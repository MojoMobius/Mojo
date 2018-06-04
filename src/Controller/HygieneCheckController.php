<?php

/*
 * Requirement : REQ-004
 * Form : Hygiene Check
 * Developer: Syedismail N
 * Created On: 21 Aug 2017
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class HygieneCheckController extends AppController {

    public $paginate = [
        'limit' => 10,
        'order' => [
            'Id' => 'asc'
        ]
    ];

    public function initialize() {
        parent::initialize();
        $this->loadModel('HygieneCheck');
        $this->loadModel('projectmasters');
        $this->loadComponent('RequestHandler');
    }

    public function index() {
        $session = $this->request->session();
        $userid = $session->read('user_id');
        $sessionProjects = $session->read('ProjectId');

        $MojoProjectIds = $this->projectmasters->find('Projects');
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->HygieneCheck->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');

        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;
        $this->set('Projects', $ProListFinal);

//        if (isset($sessionProjects)) {
//            $ProjectId = $this->request->data['ProjectId'] = $sessionProjects;
//        }
//        if (count($ProListFinal) == 2) {
//            $ProjectId = $this->request->data['ProjectId'] = array_keys($ProListFinal)[1];
//        }

        if (isset($this->request->data['ProjectId'])) {
            $this->set('ProjectId', $this->request->data['ProjectId']);
            $ProjectId = $this->request->data['ProjectId'];
        } else {
            $this->set('ProjectId', 0);
            $ProjectId = 0;
        }

        if (isset($this->request->data['ProjectId']) || isset($this->request->data['RegionId'])) {
            $region = $this->HygieneCheck->find('region', ['ProjectId' => $this->request->data['ProjectId'], 'RegionId' => $this->request->data['RegionId'], 'SetIfOneRow' => 'yes']);
            $this->set('RegionId', $region);
        } else {
            $this->set('RegionId', 0);
        }

        if (isset($this->request->data['ModuleId'])) {
            $Modules = $this->HygieneCheck->find('module', ['ProjectId' => $this->request->data['ProjectId'], 'ModuleId' => $this->request->data['ModuleId']]);
            $this->set('ModuleId', $Modules);
        } else {
            $this->set('ModuleId', 0);
        }

        if (isset($this->request->data['UserGroupId'])) {
            $UserGroup = $this->HygieneCheck->find('usergroupdetails', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $this->request->data['UserGroupId']]);
            $this->set('UserGroupId', $UserGroup);
            $UserGroupId = $this->request->data('UserGroupId');
        } else {
            $UserGroupId = '';
            $this->set('UserGroupId', '');
        }

        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $region = $regionMainList = $contentArr['RegionList'];
        $status_list = $contentArr['ProjectStatus'];
        $status_list_module = $contentArr['ModuleStatusList'];
        $module_ids = array_keys($status_list_module);
        $array_with_lcvalues = array_map('strtolower', $status_list);
        $ProdDB_PageLimit = $contentArr['ProjectConfig']['ProdDB_PageLimit'];
        $module = $contentArr['Module'];
        $ModuleStatus = $contentArr['ModuleStatus'];
        $ModuleUser = $contentArr['ModuleUser'];
        $domainId = $contentArr['ProjectConfig']['DomainId'];
        $moduleConfig = $contentArr['ModuleConfig'];
        $QcStatusId = ('2,4,6');
        asort($status_list);


        $this->set('module_ids', $module_ids);
        $this->set('contentArr', $contentArr);
        $this->set('region', $region);
        $this->set('Status', $status_list);
        $this->set('module', $module);
        $this->set('moduleConfig', $moduleConfig);
        $this->set('ModuleStatus', $ModuleStatus);

        if ($this->request->data['check_submit']) {

            $ProjectId = $this->request->data('ProjectId');
            $RegionId = $this->request->data('RegionId');
            $ModuleId = $this->request->data('ModuleId');
            $UserGroupId = $this->request->data('UserGroupId');
            $QcStatusId = ('2,4,6');

            $ProductionBatch = $this->HygieneCheck->find('batches', ['QcStatusId' => $QcStatusId, 'ProjectId' => $ProjectId, 'RegionId' => $RegionId, 'ModuleId' => $ModuleId, 'UserGroupId' => $UserGroupId]);

            if (!empty($ProductionBatch[0])) {
                $ProductionBatcharr = $ProductionBatch[0];
                $i = 0;
                $Production_batch = array();
                foreach ($ProductionBatcharr as $Production):
                    $Production_batch[$i]['Id'] = $Production['Id'];
                    $Production_batch[$i]['ProjectId'] = $Production['ProjectId'];
                    $Production_batch[$i]['RegionId'] = $Production['RegionId'];
                    $Production_batch[$i]['ProcessId'] = $Production['ProcessId'];
                    $Production_batch[$i]['BatchName'] = $Production['BatchName'];
                    $Production_batch[$i]['EntityCount'] = $Production['EntityCount'];
                    $Production_batch[$i]['StatusId'] = $Production['StatusId'];
                    $Production_batch[$i]['ProductionStartDate'] = $Production['ProductionStartDate'];
                    $Production_batch[$i]['ProductionEndDate'] = $Production['ProductionEndDate'];
                    $Production_batch[$i]['CreatedDate'] = $Production['CreatedDate'];
                    $i++;
                endforeach;
                $this->set('Production_batch', $Production_batch);
            }else {
                $this->Flash->error(__('No Record found for this combination!'));
            }
        }
    }

    public function checkdetails($BatchId, $ProjectId, $RegionId, $ProcessId) {

        $connection = ConnectionManager::get('default');
        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $region = $regionMainList = $contentArr['RegionList'];
        $ModuleList = $contentArr['ModuleStatus'];
        $this->set('contentArr', $contentArr);
        $this->set('RegionId', $RegionId);
        $this->set('region', $region);
        $QcStatusId = '2,4,6';
        $session = $this->request->session();
        $user_id = $session->read('user_id');
        $ModifiedDate = date("Y-m-d H:i:s");

        $SelectQCBatch = $connection->execute("select * from MV_QC_BatchMaster where RecordStatus=1 and Id IN ('$BatchId') AND StatusId IN ($QcStatusId)")->fetchAll('assoc');
        $this->set('SelectQCBatch', $SelectQCBatch);
     
        $ProductionBatchDetails = $this->HygieneCheck->find('batchesDetails', ['BatchId' => $BatchId, 'ProjectId' => $ProjectId, 'RegionId' => $RegionId, 'ProcessId' => $ProcessId, 'QcStatusId' => $QcStatusId]);
        if (!empty($ProductionBatchDetails)) {
            
            $this->set('HygieneCheckHeader', $ProductionBatchDetails[1]);
//            $this->set('HygieneCheckHeader', $ProductionBatchDetails[0]);
            $ProdBatchDetails = "";
            $HyginicKeyArr = $ProductionBatchDetails[1];
            $ProductionBatchDetailsarr = $ProductionBatchDetails[2];

            $i = 0;
            $Production_batchDetails = array();
            foreach ($ProductionBatchDetailsarr as $keys => $Production):
                $Production_batchDetails[$i] = $Production;
                $i++;
            endforeach;
            $this->set('Production_batchDetails', $Production_batchDetails);
        }else {
            $this->Flash->error(__('No Record found for this combination!'));
        }

        $SelectHygineCheckCmnts = $connection->execute("SELECT * FROM MV_QC_HygineCheckComments WHERE ProjectId=$ProjectId and RegionId=$RegionId and Qc_Batch_Id=$BatchId");
        $SelectHygineCheckComments = $SelectHygineCheckCmnts->fetchAll('assoc');
        $this->set('SelectHygineCheckComments', $SelectHygineCheckComments);

        $SelectTimeMetricCmnts = $connection->execute("SELECT * FROM ME_Production_TimeMetric WHERE ProjectId=$ProjectId and RegionId=$RegionId and Qc_Batch_Id=$BatchId");
        $SelectTimeMetricComments = $SelectTimeMetricCmnts->fetchAll('assoc');
        $this->set('SelectTimeMetricComments', $SelectTimeMetricComments);

        if (isset($this->request->data['Accept'])) {

            if ($this->request->data['Attrval']) {
                $AttributevalArray = $this->request->data['Attrval'];
                foreach ($AttributevalArray as $keys => $values):
                    if (!empty($values)) {
                        $queryInsert = "Insert into MV_QC_HygineCheckComments (ProjectId,RegionId,Qc_Batch_Id,AttributeMasterId,value,RecordStatus,CreatedDate,CreatedBy)"
                                . " values('" . $ProjectId . "','" . $RegionId . "','" . $BatchId . "','" . $keys . "','" . $values . "',1,'" . date('Y-m-d H:i:s') . "',1)";
                        $connection->execute($queryInsert);
                    }
                endforeach;
                $queryUpdate = "update MV_QC_BatchMaster set StatusId='3', ModifiedDate='" . date('Y-m-d H:i:s') . "', ModifiedBy=$user_id where Id='" . $BatchId . "'";
                $connection->execute($queryUpdate);
                $queryUpdate = "update ME_Production_TimeMetric set QcStatusId='3', ModifiedDate='" . date('Y-m-d H:i:s') . "', ModifiedBy=$user_id where Qc_Batch_Id='" . $BatchId . "'";
                $connection->execute($queryUpdate);

                $selectInputId = $connection->execute("SELECT InputEntityId FROM ME_Production_TimeMetric where Qc_Batch_Id=$BatchId")->fetchAll('assoc');
                $InputEntityId = array_map(current, $selectInputId);

                $getStatus = $connection->execute("SELECT StatusId FROM ProductionEntityMaster where InputEntityId=$InputEntityId[0]")->fetchAll('assoc');
                $getFirstStatus = array_map(current, $getStatus);
                $getFirstStatus = $getFirstStatus[0];

                $getSecondStatus_name = $contentArr['ModuleStatus_Navigation'][$getFirstStatus][0];
                $getSecondStatus_id = $contentArr['ModuleStatus_Navigation'][$getFirstStatus][1];

                foreach ($InputEntityId as $key => $val) {
                    $updateProdEntityMaster = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=$getSecondStatus_id,ModifiedDate='$ModifiedDate',ModifiedBy=$user_id WHERE InputEntityId= $val");
                }
            }

            if ($this->request->data('comments')) {
                $commentsArray = $this->request->data['comments'];
                echo "<br><br>";
                foreach ($commentsArray as $keys => $values):
                    if (!empty($values)) {
                        $queryUpdate = "update ME_Production_TimeMetric set HygieneCheckComments='" . $values . "' where InputEntityId='" . $keys . "'";
                        $connection->execute($queryUpdate);
                    }
                endforeach;
            }
            $this->Flash->success(__('Hygenic Check Accepted!'));
            return $this->redirect(['action' => 'index']);
        }

        if (isset($this->request->data['Reject'])) {

            if ($this->request->data['Attrval']) {
                $AttributevalArray = $this->request->data['Attrval'];
                foreach ($AttributevalArray as $keys => $values):
                    if (!empty($values)) {
                        $queryInsert = "Insert into MV_QC_HygineCheckComments (ProjectId,RegionId,Qc_Batch_Id,AttributeMasterId,value,RecordStatus,CreatedDate,CreatedBy)"
                                . " values('" . $ProjectId . "','" . $RegionId . "','" . $BatchId . "','" . $keys . "','" . $values . "',1,'" . date('Y-m-d H:i:s') . "',1)";
                        $connection->execute($queryInsert);
                    }
                endforeach;

                $queryUpdate = "update MV_QC_BatchMaster set StatusId='4', ModifiedDate='" . date('Y-m-d H:i:s') . "', ModifiedBy=$user_id where Id='" . $BatchId . "'";
                $connection->execute($queryUpdate);

                $queryUpdate = "update ME_Production_TimeMetric set QcStatusId='4', ModifiedDate='" . date('Y-m-d H:i:s') . "', ModifiedBy=$user_id where Qc_Batch_Id='" . $BatchId . "'";
                $connection->execute($queryUpdate);
            }
            if ($this->request->data('comments')) {
                $commentsArray = $this->request->data['comments'];
                foreach ($commentsArray as $keys => $values):
                    if (!empty($values)) {
                        $queryUpdate = "update ME_Production_TimeMetric set HygieneCheckComments='" . $values . "' where InputEntityId='" . $keys . "'";
                        $connection->execute($queryUpdate);
                    }
                endforeach;
            }
            $this->Flash->error(__('Hygenic Check Rejected!'));
            return $this->redirect(['action' => 'index']);
        }
    }

    function ajaxregion() {
        echo $region = $this->HygieneCheck->find('region', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

    function ajaxmodule() {
        echo $module = $this->HygieneCheck->find('module', ['ProjectId' => $_POST['ProjectId'], 'ModuleId' => $_POST['ModuleId']]);
        exit;
    }

    function getusergroupdetails() {
        $session = $this->request->session();
        echo $module = $this->HygieneCheck->find('usergroupdetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $_POST['userGroupId']]);
        exit;
    }

    function getresourcedetails() {
        $session = $this->request->session();
        echo $module = $this->HygieneCheck->find('resourcedetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserGroupId' => $_POST['userGroupId']]);
        exit;
    }
    
     function ajaxlist(){
        $batchId = $_POST['mandatory'];
        $QcStatusId = '2,4,6';
        $connection = ConnectionManager::get('default');
        
        $SelectQCBatchList = $connection->execute("select ProjectId,RegionId,ProcessId,UserGroupId from MV_QC_BatchMaster where RecordStatus=1 and StatusId IN ($QcStatusId) and Id =" . $batchId . " ")->fetchAll('assoc');
        $SelectQCBatchList = $SelectQCBatchList[0];
        echo $dataList = json_encode($SelectQCBatchList);
        exit;
    }
}
