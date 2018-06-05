<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\DateTime;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Utility\Hash;

class QCBatchMasterController extends AppController {

    /**
     * to initialize the model/utilities gonna to be used this page
     */
    public $paginate = [
        'limit' => 10,
        'order' => [
            'Id' => 'asc'
        ]
    ];

    public function initialize() {
        parent::initialize();
        $this->loadModel('QCBatchMaster');
        $this->loadModel('projectmasters');
        $this->loadModel('GetJob');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
    }

    public function index() {

        $ReadyForQCBatch = 1;
        $MojoProjectIds = $this->projectmasters->find('Projects');

        $session = $this->request->session();
        $userid = $session->read('user_id');
        $moduleId = $session->read("moduleId");
       
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->QCBatchMaster->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');
        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;
        $this->set('Projects', $ProListFinal);

        if (isset($this->request->data['check_submit'])) {

            $session = $this->request->session();
            $user_id = $session->read('user_id');

            $ModifiedDate = date("Y-m-d H:i:s");

            $ProjectId = $this->request->data('ProjectId');
            $RegionId = $this->request->data('RegionId');
            $ModuleId = $this->request->data('ModuleId');
            $UserGroupId = $this->request->data['UserGroupId'];

            $connection = ConnectionManager::get('default');
            $queries = $connection->execute("select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
                    . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (" . $UserGroupId . ") AND UGMapping.RecordStatus = 1 AND UGMapping.UserRoleId IN ("
                    . " SELECT Split.a.value('.', 'VARCHAR(100)') AS String  
                   FROM (SELECT CAST('<M>' + REPLACE([RoleId], ',', '</M><M>') + '</M>' AS XML) AS String  
                        FROM ME_ProjectRoleMapping where ProjectId = " . $ProjectId . " AND ModuleId = 1 AND RecordStatus = 1) AS A CROSS APPLY String.nodes ('/M') AS Split(a)"
                    . ") GROUP BY UGMapping.UserId");

            $queries = $queries->fetchAll('assoc');
            $Queriesresult = array_map('current', $queries);
            $UserList = implode(",", $Queriesresult);

            $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            

            $region = $contentArr['RegionList'];
            $hygineCheck = $contentArr['ProjectConfig']['HygineCheck'];
            $moduleHygenicCheck = $contentArr['ModuleConfig'][$ModuleId]['IsHygineCheck'];

            $batch = $ProListFinal[$ProjectId] . '_' . $region[$RegionId];
            $batchName = str_replace(' ', '', $batch);

            $batch_from = $this->request->data('batch_from');
            $batch_to = $this->request->data('batch_to');

            $from_time = $this->request->data('FromTime');
            $to_time = $this->request->data('ToTime');

            $ProductionStartDate = $batch_from;
            $ProductionStartDate = date("Y-m-d", strtotime($ProductionStartDate));
            $ProductionStartTime = $from_time;

            $ProductionEndDate = $batch_to;
            $ProductionEndDate = date("Y-m-d", strtotime($ProductionEndDate));
            $ProductionEndTime = $to_time;

            if ($ProductionStartTime == '') {
                $ProductionStartTime = '00:00:00';
            }
            $DupCheckTimeStart = new \DateTime($ProductionStartDate . ' ' . $ProductionStartTime);
            $DupCheckTimeStart->modify("+1 second");
            $DupCheckTimeStart = $DupCheckTimeStart->format('Y-m-d H:i:s');

            $conditions = '';

            if ($ProductionEndTime != '') {

                $NewEndTime = new \DateTime($ProductionEndDate . ' ' . $ProductionEndTime);
                $NewEndTime->modify("-1 second");
                $NewEndTime = $NewEndTime->format('Y-m-d H:i:s');

                $DupCheckTimeEnd = new \DateTime($ProductionEndDate . ' ' . $ProductionEndTime);
                $DupCheckTimeEnd->modify("-1 second");
                $DupCheckTimeEnd = $DupCheckTimeEnd->format('Y-m-d H:i:s');
                $conditions.="  Start_Date >='" . $ProductionStartDate . " $ProductionStartTime' AND Start_Date <='" . $NewEndTime . "'";
            }

            if ($ProductionEndTime == '') {
                $currentDate = date("Y-m-d");
                $currentTime = date("H:i:s");
                $ProductionEndTime = '23:59:59';
                if ($ProductionEndDate >= $currentDate) {
                    $ProductionEndTime = $currentTime;
                }
                $DupCheckTimeEnd = new \DateTime($ProductionEndDate . ' ' . $ProductionEndTime);
                $DupCheckTimeEnd = $DupCheckTimeEnd->format('Y-m-d H:i:s');
                $conditions.="  Start_Date >='" . $ProductionStartDate . " $ProductionStartTime' AND Start_Date <='" . $ProductionEndDate . " $ProductionEndTime'";
            }

            if (empty($ProjectId)) {
                $ProjectId = $session->read('ProjectId');
            }

            //$selectRecords = $connection->execute("select * from ME_Production_TimeMetric where $conditions and ProjectId=$ProjectId and RegionId = $RegionId and Module_Id= $ModuleId and UserId IN (" . $UserList . ")")->fetchAll('assoc');

                $CompletedRecords = $connection->execute("select distinct (InputEntityId) from ME_Production_TimeMetric where $conditions and ProjectId=$ProjectId and RegionId = $RegionId and Module_Id= $ModuleId and UserId IN (" . $UserList . ") and QcStatusId = $ReadyForQCBatch and QC_Module_Id=$moduleId")->fetchAll('assoc');


            $totalSelectedRecords = count($selectRecords);
            $totalCompletedRecords = count($CompletedRecords);

            /*$selectBatch = $connection->execute("SELECT * FROM MV_QC_BatchMaster WHERE ((ProductionStartDate <= '$DupCheckTimeStart' and '$DupCheckTimeStart' <= ProductionEndDate) or
                (ProductionStartDate  <= '$DupCheckTimeEnd' and '$DupCheckTimeEnd' <= ProductionEndDate) or
                ('$DupCheckTimeStart'  <= ProductionStartDate and ProductionStartDate <= '$DupCheckTimeEnd')) and ProjectId=$ProjectId and RegionId = $RegionId and ProcessId= $ModuleId")->fetchAll('assoc');
*/
           // if (empty($selectBatch)) {
                if (!empty($totalCompletedRecords)) {
                    //if ($totalSelectedRecords == $totalCompletedRecords) {
                        $BatchStatusId = 3;
                        if (($hygineCheck == 1) && ($moduleHygenicCheck == 1)) {
                            $BatchStatusId = 2;
                        }
                        $InsertQCBatch = $connection->execute("Insert into MV_QC_BatchMaster (BatchName,ProjectId,Regionid,ProcessId,QC_Module_Id,UserGroupId,EntityCount,ProductionStartDate,ProductionStartTime,ProductionEndDate,ProductionEndTime,RecordStatus,CreatedDate,CreatedBy,StatusId) "
                                . "values ('" . $batchName . "_QCBatch_" . date('Y-m-d_H-i-s') . "',$ProjectId,$RegionId,$ModuleId,$moduleId,$UserGroupId,$totalCompletedRecords,'$ProductionStartDate $ProductionStartTime','$ProductionStartTime','$ProductionEndDate $ProductionEndTime','$ProductionEndTime',1,GETDATE(),$user_id,$BatchStatusId)");

                        $batchId = $connection->execute("SELECT Id FROM MV_QC_BatchMaster WHERE ProjectId=$ProjectId and RegionId = $RegionId and ProcessId= $ModuleId and QC_Module_Id= $moduleId ORDER BY Id DESC")->fetchAll('assoc');
                        $QcBatchId = $batchId[0]['Id'];
                        $updateTimeMetric = $connection->execute("UPDATE ME_Production_TimeMetric SET QcStatusId=$BatchStatusId,Qc_Batch_Id=$QcBatchId,ModifiedDate='$ModifiedDate',ModifiedBy=$user_id WHERE $conditions and ProjectId=$ProjectId and RegionId = $RegionId and Module_Id= $ModuleId and QC_Module_Id= $moduleId and UserId IN (" . $UserList . ") and QcStatusId = $ReadyForQCBatch");

                        $selectInputId = $connection->execute("SELECT InputEntityId FROM ME_Production_TimeMetric where Qc_Batch_Id=$QcBatchId")->fetchAll('assoc');
                        $InputEntityId = array_map(current, $selectInputId);

                        $getStatus = $connection->execute("SELECT StatusId FROM ProductionEntityMaster where InputEntityId=$InputEntityId[0]")->fetchAll('assoc');
                        $getFirstStatus = array_map(current, $getStatus);
                        $getFirstStatus = $getFirstStatus[0];


                        $getSecondStatus_name = $contentArr['ModuleStatus_Navigation'][$getFirstStatus][0];
                        $getSecondStatus_id = $contentArr['ModuleStatus_Navigation'][$getFirstStatus][1];

                        if ($BatchStatusId == 3) {
                            $getSecondStatus_name = $contentArr['ModuleStatus_Navigation'][$getSecondStatus_id][0];
                            $getSecondStatus_id = $contentArr['ModuleStatus_Navigation'][$getSecondStatus_id][1];
                        }

                        foreach ($InputEntityId as $key => $val) {
                            $updateProdEntityMaster = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=$getSecondStatus_id,ModifiedDate='$ModifiedDate',ModifiedBy=$user_id WHERE InputEntityId= $val");
                        }
                        $this->Flash->success(__('Batch has been Created!'));
                    //}
                } else {
                    $this->Flash->error(__('No Records for Selected Date'));
                }
            /*} else {
                $this->Flash->error(__('Batch already created in selected Date'));
            } */
        }

        $UserProject = array_keys($ProListFinal);
        $ids = join("','", $UserProject);
        $connection = ConnectionManager::get('default');
        $SelectQCBatch = $connection->execute("select * from MV_QC_BatchMaster where RecordStatus=1 and ProjectId IN ('$ids') and QC_Module_Id= $moduleId ORDER BY ProductionStartDate DESC,ProductionStartTime DESC")->fetchAll('assoc');
        $this->set('SelectQCBatch', $SelectQCBatch);
    }

    function ajaxregion() {
        echo $region = $this->QCBatchMaster->find('region', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

    function ajaxmodule() {
        echo $module = $this->QCBatchMaster->find('module', ['ProjectId' => $_POST['ProjectId']]);
        exit;
    }

    function getusergroupdetails() {
        $session = $this->request->session();
        echo $module = $this->QCBatchMaster->find('usergroupdetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserId' => $session->read('user_id')]);
        exit;
    }
    function getavailabledate() {
        $session = $this->request->session();
        $moduleId = $session->read("moduleId");
        echo $Module = $this->QCBatchMaster->find('availabledate', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'ModuleId' => $_POST['ModuleId'], 'UserGroupId' => $_POST['UserGroupId'], 'QcModuleId' => $_POST['moduleId']]);
        exit;
    }
    function getProductionData() {
        $session = $this->request->session();
        $moduleId = $session->read("moduleId");
         echo $Module = $this->QCBatchMaster->find('availableproduction', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'ModuleId' => $_POST['ModuleId'], 'UserGroupId' => $_POST['UserGroupId'], 'batch_from' => $_POST['batch_from'], 'batch_to' => $_POST['batch_to'], 'FromTime' => $_POST['FromTime'], 'ToTime' => $_POST['ToTime'], 'QcModuleId' => $_POST['moduleId']]);
        exit;
    }
    function ajaxcount() {
        
        $session = $this->request->session();
        $moduleId = $session->read("moduleId");

        $ProjectId = $_POST['ProjectId'];
        $RegionId = $_POST['RegionId'];
        $ModuleId = $_POST['ModuleId'];
        $UserGroupId = $_POST['UserGroupId'];

        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $region = $contentArr['RegionList'];
        $hygineCheck = $contentArr['ProjectConfig']['HygineCheck'];
        $moduleHygenicCheck = $contentArr['ModuleConfig'][$ModuleId]['IsHygineCheck'];

        $connection = ConnectionManager::get('default');
        $queries = $connection->execute("select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (" . $UserGroupId . ") AND UGMapping.RecordStatus = 1 AND UGMapping.UserRoleId IN ("
                . " SELECT Split.a.value('.', 'VARCHAR(100)') AS String  
                   FROM (SELECT CAST('<M>' + REPLACE([RoleId], ',', '</M><M>') + '</M>' AS XML) AS String  
                        FROM ME_ProjectRoleMapping where ProjectId = " . $ProjectId . " AND ModuleId = 1 AND RecordStatus = 1) AS A CROSS APPLY String.nodes ('/M') AS Split(a)"
                . ") GROUP BY UGMapping.UserId");

        $queries = $queries->fetchAll('assoc');
        $Queriesresult = array_map('current', $queries);
        $UserList = implode(",", $Queriesresult);

        $batch_from = $_POST['batch_from'];
        $batch_to = $_POST['batch_to'];

        $from_time = $_POST['FromTime'];
        $to_time = $_POST['ToTime'];

        $ProductionStartDate = $batch_from;
        $ProductionStartDate = date("Y-m-d", strtotime($ProductionStartDate));
        $ProductionStartTime = $from_time;

        $ProductionEndDate = $batch_to;
        $ProductionEndDate = date("Y-m-d", strtotime($ProductionEndDate));
        $ProductionEndTime = $to_time;

        if ($ProductionStartTime == '') {
            $ProductionStartTime = '00:00:00';
        }
        $DupCheckTimeStart = new \DateTime($ProductionStartDate . ' ' . $ProductionStartTime);
        $DupCheckTimeStart->modify("+1 second");
        $DupCheckTimeStart = $DupCheckTimeStart->format('Y-m-d H:i:s');

        $conditions = '';

        if ($ProductionEndTime != '') {

            $NewEndTime = new \DateTime($ProductionEndDate . ' ' . $ProductionEndTime);
            $NewEndTime->modify("-1 second");
            $NewEndTime = $NewEndTime->format('Y-m-d H:i:s');

            $DupCheckTimeEnd = new \DateTime($ProductionEndDate . ' ' . $ProductionEndTime);
            $DupCheckTimeEnd->modify("-1 second");
            $DupCheckTimeEnd = $DupCheckTimeEnd->format('Y-m-d H:i:s');
            $conditions.="  Start_Date >='" . $ProductionStartDate . " $ProductionStartTime' AND Start_Date <='" . $NewEndTime . "'";
        }

        if ($ProductionEndTime == '') {
            $currentDate = date("Y-m-d");
            $currentTime = date("H:i:s");
            $ProductionEndTime = '23:59:59';
            if ($ProductionEndDate >= $currentDate) {
                $ProductionEndTime = $currentTime;
            }
            $DupCheckTimeEnd = new \DateTime($ProductionEndDate . ' ' . $ProductionEndTime);
            $DupCheckTimeEnd = $DupCheckTimeEnd->format('Y-m-d H:i:s');
            $conditions.="  Start_Date >='" . $ProductionStartDate . " $ProductionStartTime' AND Start_Date <='" . $ProductionEndDate . " $ProductionEndTime'";
        }

        $selectRecords = $connection->execute("select * from ME_Production_TimeMetric where $conditions and ProjectId=$ProjectId and RegionId = $RegionId and Module_Id= $ModuleId and UserId IN (" . $UserList . ")")->fetchAll('assoc');
       
                $CompletedRecords = $connection->execute("select distinct (InputEntityId) from ME_Production_TimeMetric where $conditions and ProjectId=$ProjectId and RegionId = $RegionId and Module_Id= $ModuleId and UserId IN (" . $UserList . ") and QcStatusId = 1 and QC_Module_Id=$moduleId")->fetchAll('assoc');
        
        $totalSelectedRecords = count($selectRecords);
        $totalCompletedRecords = count($CompletedRecords);
        $text = "Batch Not Created Some Incomplete Records in Selected date";

//        $selectBatch = $connection->execute("SELECT * FROM MV_QC_BatchMaster WHERE ((ProductionStartDate <= '$DupCheckTimeStart' and '$DupCheckTimeStart' <= ProductionEndDate) or
//                (ProductionStartDate  <= '$DupCheckTimeEnd' and '$DupCheckTimeEnd' <= ProductionEndDate) or
//                ('$DupCheckTimeStart'  <= ProductionStartDate and ProductionStartDate <= '$DupCheckTimeEnd')) and ProjectId=$ProjectId and RegionId = $RegionId and ProcessId= $ModuleId")->fetchAll('assoc');

       // if (empty($selectBatch)) {
            if (!empty($totalCompletedRecords)) {
                //if ($totalSelectedRecords == $totalCompletedRecords) {
                   // if (($hygineCheck == 1) && ($moduleHygenicCheck == 1)) {
                        echo $totalCompletedRecords;
                   // }
//                } else {
//                    echo 'Incomplete';
//                }
            }
            else {
                echo 'No Record Found';
            }
        //}

        exit;
    }

}
