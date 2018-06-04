<?php

/**
 * Requirement : REQ-004
 * Form : TL Rebutal
 * Developer: Syedismail N
 * Created On: 29 Aug 2017
 * class to TLRebutal
 * 
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class TLRebutalController extends AppController {

    public $paginate = [
        'limit' => 10,
        'order' => [
            'Id' => 'asc'
        ]
    ];

    public function initialize() {
        parent::initialize();
        $this->loadModel('TLRebutal');
        $this->loadModel('GetJob');
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
        $ProList = $this->TLRebutal->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');

        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;
        $this->set('Projects', $ProListFinal);

//        if (isset($sessionProjects)) {
//            $ProjectId = $this->request->data['ProjectId'] = $sessionProjects;
//        }
//        if(count($ProListFinal) == 2) {
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
            $region = $this->TLRebutal->find('region', ['ProjectId' => $this->request->data['ProjectId'], 'RegionId' => $this->request->data['RegionId'], 'SetIfOneRow' => 'yes']);
            $this->set('RegionId', $region);
        } else {
            $this->set('RegionId', 0);
        }

        if (isset($this->request->data['ModuleId'])) {
            $Modules = $this->TLRebutal->find('module', ['ProjectId' => $this->request->data['ProjectId'], 'ModuleId' => $this->request->data['ModuleId']]);
            $this->set('ModuleId', $Modules);
        } else {
            $this->set('ModuleId', 0);
        }

        if (isset($this->request->data['UserGroupId'])) {
            $UserGroup = $this->TLRebutal->find('usergroupdetails', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $this->request->data['UserGroupId']]);
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
        $QcStatusId = ('4');
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
            //$QcStatusId=('2,4');
            $QcStatusId = ('4');

            $ProductionBatch = $this->TLRebutal->find('batches', ['QcStatusId' => $QcStatusId, 'ProjectId' => $ProjectId, 'RegionId' => $RegionId, 'ModuleId' => $ModuleId, 'UserGroupId' => $UserGroupId]);
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

        $staticModuleAttributes = $ModuleAttributes[$RegionId][$ProcessId]['static'];
        $productionModuleAttributes = $ModuleAttributes[$RegionId][$ProcessId]['production'];
        $AllModuleAttributes = array_merge($staticModuleAttributes, $productionModuleAttributes);

        $this->set('ProjectId', $ProjectId);
        $this->set('RegionId', $RegionId);
        $this->set('ProcessId', $ProcessId);
        $this->set('contentArr', $contentArr);
        $this->set('region', $region);
        $QcStatusId = '4';
        $session = $this->request->session();
        $user_id = $session->read('user_id');
        $ModifiedDate = date("Y-m-d H:i:s");

        $TLRebutalDetails = $this->TLRebutal->find('batchesDetails', ['BatchId' => $BatchId, 'ProjectId' => $ProjectId, 'RegionId' => $RegionId, 'ProcessId' => $ProcessId, 'QcStatusId' => $QcStatusId]);

        $SelectHygineCheckCmnts = $connection->execute("SELECT * FROM MV_QC_HygineCheckComments WHERE ProjectId=$ProjectId and RegionId=$RegionId and Qc_Batch_Id=$BatchId");
        $SelectHygineCheckComments = $SelectHygineCheckCmnts->fetchAll('assoc');
        $this->set('SelectHygineCheckComments', $SelectHygineCheckComments);

        $SelectTimeMetricCmnts = $connection->execute("SELECT * FROM ME_Production_TimeMetric WHERE ProjectId=$ProjectId and RegionId=$RegionId and Qc_Batch_Id=$BatchId");
        $SelectTimeMetricComments = $SelectTimeMetricCmnts->fetchAll('assoc');
        $this->set('SelectTimeMetricComments', $SelectTimeMetricComments);
        
        $SelectHideBatchs = $connection->execute("SELECT TOP 1* FROM MV_QC_BatchMaster WHERE ProjectId=$ProjectId and RegionId=$RegionId and Id=$BatchId and TLRebuttalSavedStatus=1");
        $SelectHideBatch = $SelectHideBatchs->fetchAll('assoc');
        $this->set('SelectHideBatch', $SelectHideBatch);
        
        $this->set('TLRebutalAttrMasId', $TLRebutalDetails['AttributeMasterId']);
        $this->set('TLRebutalHeaders', $TLRebutalDetails['Header']);
        $this->set('TLRebutalDetails', $TLRebutalDetails);
        $this->set('BatchId', $BatchId);

        if (isset($this->request->data['check_back'])) {
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->data['check_save']) {

            $Attrval = $this->request->data('Attrval');
            $ProjectId = $this->request->data('ProjectId');
            $RegionId = $this->request->data('RegionId');
            $ProcessId = $this->request->data('ProcessId');
            $BatchId = $this->request->data('BatchId');

            foreach ($Attrval as $key => $vals):
                $keysImp = explode('_', $key);
                $InputEntityId = $keysImp[0];
                $AttributeMasterId = $keysImp[1];
                $SeqNumber = $keysImp[2];
                $TLRebutalUpdate = "Update ME_ProductionData SET AttributeValue='$vals', ModifiedDate='" . date('Y-m-d H:i:s') . "' where ProjectId=$ProjectId and RegionId=$RegionId and InputEntityId=$InputEntityId and AttributeMasterId=$AttributeMasterId and SequenceNumber=$SeqNumber";
                $connection->execute($TLRebutalUpdate);
            endforeach;
            
            $HygineChkCmndUpdate = "Update MV_QC_BatchMaster SET TLRebuttalSavedStatus=1 where ProjectId=$ProjectId and RegionId=$RegionId and Id=$BatchId";
            $connection->execute($HygineChkCmndUpdate);

            $this->Flash->success(__('Updated successfully!'));

            return $this->redirect(['action' => 'checkdetails/' . $BatchId . '/' . $ProjectId . '/' . $RegionId . '/' . $ProcessId]);
        }

        if (isset($this->request->data['Accept'])) {

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
            $this->Flash->success(__('TL Rebutal Accepted!'));
            return $this->redirect(['action' => 'index']);
        }

        if (isset($this->request->data['Reject'])) {

            $queryUpdate = "update MV_QC_BatchMaster set StatusId='6', ModifiedDate='" . date('Y-m-d H:i:s') . "', ModifiedBy=$user_id where Id='" . $BatchId . "'";
            $connection->execute($queryUpdate);

            $queryUpdate = "update ME_Production_TimeMetric set QcStatusId='6', ModifiedDate='" . date('Y-m-d H:i:s') . "', ModifiedBy=$user_id where Qc_Batch_Id='" . $BatchId . "'";
            $connection->execute($queryUpdate);
            $this->Flash->error(__('TL Rebutal Rejected!'));
            return $this->redirect(['action' => 'index']);
        }
    }

    function ajaxregion() {
        echo $region = $this->TLRebutal->find('region', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

    function ajaxmodule() {
        echo $module = $this->TLRebutal->find('module', ['ProjectId' => $_POST['ProjectId'], 'ModuleId' => $_POST['ModuleId']]);
        exit;
    }

    function getusergroupdetails() {
        $session = $this->request->session();
        echo $module = $this->TLRebutal->find('usergroupdetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $_POST['userGroupId']]);
        exit;
    }
    
    function ajaxlist(){
        $batchId = $_POST['mandatory'];
        $QcStatusId = '4';
        $connection = ConnectionManager::get('default');
        
        $SelectQCBatchList = $connection->execute("select ProjectId,RegionId,ProcessId,UserGroupId from MV_QC_BatchMaster where RecordStatus=1 and StatusId IN ($QcStatusId) and Id =" . $batchId . " ")->fetchAll('assoc');
        $SelectQCBatchList = $SelectQCBatchList[0];
        echo $dataList = json_encode($SelectQCBatchList);
        exit;
    }

//
//    function getresourcedetails() {
//        $session = $this->request->session();
//        echo $module = $this->TLRebutal->find('resourcedetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserGroupId' => $_POST['userGroupId']]);
//        exit;
//    }
}
