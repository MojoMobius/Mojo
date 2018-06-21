<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Hash;

/**
 * Bookmarks Controller
 *
 * @property \App\Model\Table\ImportInitiates $ImportInitiates
 */
class QCValidationController extends AppController {

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
        $this->loadModel('QCValidation');
        $this->loadModel('projectmasters');
        $this->loadModel('GetJob');
        // $this->loadHelper('Html');
        $this->loadComponent('RequestHandler');
    }

    public function index() {


        $connectiond2k = ConnectionManager::get('d2k');
        $statusIdentifier = ReadyForQCIdentifier;
        $statusreworkIdentifier = "ReadyforQCRework";
        $session = $this->request->session();
        $moduleId = $session->read("moduleId");
       
        /////////////QC ///////////////////////////////////////
        
        $QcFirstStatus = $connectiond2k->execute("SELECT Status FROM D2K_ModuleStatusMaster where ModuleId=$moduleId and ModuleStatusIdentifier='$statusIdentifier' AND RecordStatus=1")->fetchAll('assoc');
        
        $QcFirstStatus = array_map(current, $QcFirstStatus);
        $first_Status_name = $QcFirstStatus[0];
        
        $connection = ConnectionManager::get('default');
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $ProjectId = $session->read("ProjectId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        //echo "<pre>";print_r($JsonArray);exit;
        
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);
        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];
        $isHistoryTrack = $JsonArray['ModuleConfig'][$moduleId]['IsHistoryTrack'];
        
        
        /////////////QC end ///////////////////////////////////////
        
        /////////////QC Rework ///////////////////////////////////////
       
        $QcFirstStatusRW = $connectiond2k->execute("SELECT Status FROM D2K_ModuleStatusMaster where ModuleId=$moduleId and ModuleStatusIdentifier='$statusreworkIdentifier' AND RecordStatus=1")->fetchAll('assoc');
        
        $QcFirstStatusRW = array_map(current, $QcFirstStatusRW);
         $first_Status_name_rw = $QcFirstStatusRW[0];///Ready for QC Rework
        
         $first_Status_id_rw = array_search($first_Status_name_rw, $JsonArray['ProjectStatus']);
         $next_status_name_rw = $JsonArray['ModuleStatus_Navigation'][$first_Status_id_rw][0];
       
        $next_status_id_rw = $JsonArray['ModuleStatus_Navigation'][$first_Status_id_rw][1];
        
        
        
        /////////////QC Rework end ///////////////////////////////////////
        
       
//        $queryStatus = $JsonArray['ModuleStatusList'][$moduleId];
//        // pr($queryStatus);
//        $pos = array_search('Query', $queryStatus);
//        $searchword = 'Query';
//        $matches = array_filter($queryStatus, function($var) use ($searchword) {
//            return preg_match("/\b$searchword\b/i", $var);
//        });
//        $matchKey = key($matches);
//        $queryStatusId = array_search(strtolower($matches[$matchKey]), array_map(strtolower, $JsonArray['ProjectStatus']));
        $ErrorCategory = $connection->execute("SELECT Id, ErrorCategoryName FROM MV_QC_ErrorCategoryMaster where RecordStatus=1")->fetchAll('assoc');

        $CategoryName = array();
        foreach ($ErrorCategory as $key => $value) {
            $CategoryName[0] = '-- Select --';
            $CategoryName[$value['Id']] = $value['ErrorCategoryName'];
        }

        $this->set('CategoryName', $CategoryName);

        $moduleName = $JsonArray['Module'][$moduleId];
        $this->set('moduleName', $moduleName);
        $page = 1;
        $frameType = $JsonArray['ProjectConfig']['IsBulk'];
        $limit = 1;
        $frameType = $JsonArray['ProjectConfig']['ProductionView'];
        $domainId = $JsonArray['ProjectConfig']['DomainId'];
        $domainUrl = $JsonArray['ProjectConfig']['DomainUrl'];
        $userList = $JsonArray['UserList'];
        $this->set('userList', $userList);
        $this->set('QCModuleId', $moduleId);
       // $frameType = 3;

        if ($frameType == 1) {

            if (isset($this->request->query['job']))
                $newJob = $this->request->query['job'];
            if (isset($this->request->data['NewJob']))
                $newJob = $this->request->data['NewJob'];

            $AttributeOrder = $JsonArray['AttributeOrder'];
            $this->set('AttributeOrder', $AttributeOrder);
            $this->set('next_status_id', $next_status_id);
            $InprogressProductionjob = $connection->execute('SELECT * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE UserId=' . $user_id . ' AND StatusId=' . $next_status_id . ' AND SequenceNumber=1 AND ProjectId=' . $ProjectId)->fetchAll('assoc');

            if (empty($InprogressProductionjob)) {
                $InprogressRebutaljob = $connection->execute('SELECT TOP 1 *  FROM MV_QC_TimeMetric where QcStatusId = 4 AND QCUSerID=' . $user_id . ' AND ProjectId=' . $ProjectId)->fetchAll('assoc');

                if (empty($InprogressRebutaljob)) {
                    $Rebutaljob = $connection->execute('SELECT TOP 1 * FROM MV_QC_TimeMetric where QcStatusId = 3 AND QCUSerID=' . $user_id . ' AND ProjectId=' . $ProjectId)->fetchAll('assoc');

                    if (empty($Rebutaljob)) {
                        $productionjob = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WHERE StatusId=' . $first_Status_id . ' AND SequenceNumber=1 AND ProjectId=' . $ProjectId)->fetchAll('assoc');
                        if (empty($productionjob)) {
                            $this->set('NoNewJob', 'NoNewJob');
                        } else {
                            foreach ($productionjob as $val) {
                                if ($val['StatusId'] == $first_Status_id && ($newJob == 'NewJob' || $newJob == 'newjob')) {
//                        $updateUserGroupId = $connection->execute("SELECT UserGroupId FROM MV_UserGroupMapping where Projectid=$ProjectId and RegionId=".$productionjob[0]['RegionId']." and UserId=$user_id and RecordStatus=1");
//                            foreach ($updateUserGroupId as $UserVal) {
//                               $userGpId = $UserVal['UserGroupId']; 
//                            }
//                        $inprogressjob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $next_status_id . ",UserId=" . $user_id . ",UserGroupId=" . $userGpId .",ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $productionjob[0]['ProductionEntity']);
                                    $ProjectId = $productionjob[0]['ProjectId'];
                                    $RegionId = $productionjob[0]['RegionId'];
                                    $InputEntityId = $productionjob[0]['InputEntityId'];

                                    $QcIterationInsert = $connection->execute("INSERT INTO MV_QC_Iteration (ProjectId,RegionId,InputEntityId,QCUserId,QcStartDate,RecordStatus,CreatedDate,CreatedBy) values($ProjectId,$RegionId,$InputEntityId,$user_id,'" . date('Y-m-d H:i:s') . "',1,'" . date('Y-m-d H:i:s') . "',$user_id)");
                                    $productionCompletejob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $next_status_id . ",UserId=" . $user_id . ",ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $val['ProductionEntity']);
                                    $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $next_status_id . ",ProductionStartDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $val['ProductionEntity']);
                                    $productiontimemetricMain = $connection->execute("UPDATE MV_QC_TimeMetric SET StatusId=" . $next_status_id . ",QCUSerID=" . $user_id . ",QCStartDate='" . date('Y-m-d H:i:s') . "',ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id WHERE ProductionEntityID=" . $val['ProductionEntity'] . " AND Module_Id=" . $moduleId);
                                    $productionjob[0]['StatusId'] = $next_status_id;
                                    $productionjob[0]['StatusId'] = 'QC In Progress';
                                }
                            }
                            $productionjobNew = $productionjob[0];
                            $this->set('productionjob', $productionjob[0]);
                            $inputEntity = $productionjob[0]['InputEntityId'];
                            $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity . ' AND Qc_Batch_Id IS NOT NULL')->fetchAll('assoc');
                            $QcBatchId = $BatchId[0]['Qc_Batch_Id'];
                            $ProdUserId = $BatchId[0]['UserId'];
                            $BatchName = $connection->execute('SELECT BatchName FROM MV_QC_BatchMaster WITH (NOLOCK) WHERE Id=' . $QcBatchId)->fetchAll('assoc');
                            $QcBatchName = $BatchName[0]['BatchName'];
                            $this->set('QcBatchName', $QcBatchName);
                            $this->set('ProdUserId', $ProdUserId);
                        }
                    } else {

                        $Error_status = $Rebutaljob[0]['StatusId'];
                        $InputEntityId = $Rebutaljob[0]['InputEntityId'];

                        $productionjob = $connection->execute('SELECT * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE InputEntityId=' . $InputEntityId . ' AND SequenceNumber=' . $page . ' AND ProjectId=' . $ProjectId . ' AND UserId= ' . $user_id)->fetchAll('assoc');
                        if ($productionjob[0]['StatusId'] == $Error_status && ($newJob == 'NewJob' || $newJob == 'newjob')) {
                            $ProjectId = $productionjob[0]['ProjectId'];
                            $RegionId = $productionjob[0]['RegionId'];
                            $InputEntityId = $productionjob[0]['InputEntityId'];

                            $QcIterationInsert = $connection->execute("INSERT INTO MV_QC_Iteration (ProjectId,RegionId,InputEntityId,QCUserId,QcStartDate,RecordStatus,CreatedDate,CreatedBy) values($ProjectId,$RegionId,$InputEntityId,$user_id,'" . date('Y-m-d H:i:s') . "',1,'" . date('Y-m-d H:i:s') . "',$user_id)");
                            $inprogressjob = $connection->execute("UPDATE " . $stagingTable . " SET UserId=" . $user_id . ",ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id,ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $productionjob[0]['ProductionEntity']);
                            $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id,ProductionStartDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $productionjob[0]['ProductionEntity']);
                            $productiontimemetricMain = $connection->execute("UPDATE MV_QC_TimeMetric SET QcStatusId = 4,QCUSerID=" . $user_id . ",ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id,QCStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntityID=" . $productionjob[0]['ProductionEntity'] . " AND Module_Id=" . $moduleId);
                            $productionjob[0]['StatusId'] = $Error_status;
                            $productionjob[0]['StatusId'] = 'QC Error In Progress';
                        }
                        $productionjobNew = $productionjob[0];
                        $this->set('productionjob', $productionjob[0]);
                        $inputEntity = $productionjob[0]['InputEntityId'];
                        $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity . ' AND Qc_Batch_Id IS NOT NULL')->fetchAll('assoc');
                        $QcBatchId = $BatchId[0]['Qc_Batch_Id'];
                        $ProdUserId = $BatchId[0]['UserId'];
                        $BatchName = $connection->execute('SELECT BatchName FROM MV_QC_BatchMaster WITH (NOLOCK) WHERE Id=' . $QcBatchId)->fetchAll('assoc');
                        $QcBatchName = $BatchName[0]['BatchName'];
                        $this->set('QcBatchName', $QcBatchName);
                        $this->set('ProdUserId', $ProdUserId);
                    }
                } else {

                    $InputEntityId = $InprogressRebutaljob[0]['InputEntityId'];
                    $productionjob = $connection->execute('SELECT * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE InputEntityId=' . $InputEntityId . ' AND SequenceNumber=1 AND ProjectId=' . $ProjectId . ' AND UserId= ' . $user_id)->fetchAll('assoc');
                    $this->set('getNewJOb', '');
                    $this->set('productionjob', $productionjob[0]);
                    $productionjobNew = $productionjob[0];
                    $inputEntity = $productionjob[0]['InputEntityId'];
                    $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity . ' AND Qc_Batch_Id IS NOT NULL')->fetchAll('assoc');
                    $QcBatchId = $BatchId[0]['Qc_Batch_Id'];
                    $ProdUserId = $BatchId[0]['UserId'];
                    $BatchName = $connection->execute('SELECT BatchName FROM MV_QC_BatchMaster WITH (NOLOCK) WHERE Id=' . $QcBatchId)->fetchAll('assoc');
                    $QcBatchName = $BatchName[0]['BatchName'];
                    $this->set('QcBatchName', $QcBatchName);
                    $this->set('ProdUserId', $ProdUserId);
                }
            } else {

                $this->set('getNewJOb', '');
                $this->set('productionjob', $InprogressProductionjob[0]);
                $productionjobNew = $InprogressProductionjob[0];
                $inputEntity = $InprogressProductionjob[0]['InputEntityId'];
                $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity . ' AND Qc_Batch_Id IS NOT NULL')->fetchAll('assoc');
                $QcBatchId = $BatchId[0]['Qc_Batch_Id'];
                $ProdUserId = $BatchId[0]['UserId'];
                $BatchName = $connection->execute('SELECT BatchName FROM MV_QC_BatchMaster WITH (NOLOCK) WHERE Id=' . $QcBatchId)->fetchAll('assoc');
                $QcBatchName = $BatchName[0]['BatchName'];
                $this->set('QcBatchName', $QcBatchName);
                $this->set('ProdUserId', $ProdUserId);
            }


            $RegionId = $productionjobNew['RegionId'];
            $StaticFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['static'];
            if ($RegionId == '')
                $RegionId = 6;
            $DynamicFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['dynamic'];
            $ProductionFieldsold = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
            $key = 0;
            foreach ($ProductionFieldsold as $val) {
                $ProductionFields[$key] = $val;
                $key++;
            }
            $ReadOnlyFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['readonly'];
            $this->set('ProductionFields', $ProductionFields);
            $this->set('StaticFields', $StaticFields);
            $this->set('DynamicFields', $DynamicFields);
            $this->set('ReadOnlyFields', $ReadOnlyFields);
            if (isset($productionjobNew)) {
                $DomainIdName = $productionjobNew[$domainId];
                $TimeTaken = $productionjobNew['TimeTaken'];
                $this->set('TimeTaken', $TimeTaken);
                //echo "SELECT DomainUrl,DownloadStatus FROM ME_DomainUrl WITH (NOLOCK) WHERE   ProjectId=" . $ProjectId . " AND RegionId=" . $productionjobNew['RegionId'] . " AND DomainId='" . $DomainIdName . "'";
                $link = $connection->execute("SELECT DomainUrl,DownloadStatus FROM ME_DomainUrl WITH (NOLOCK) WHERE   ProjectId=" . $ProjectId . " AND RegionId=" . $productionjobNew['RegionId'] . " AND DomainId='" . $DomainIdName . "'")->fetchAll('assoc');
                foreach ($link as $key => $value) {
                    $L = $value['DomainUrl'];
                    $pos = strpos($L, 'http');
                    if ($pos === false) {
                        $L = "http://" . $L;
                    }
                    if ($value['DownloadStatus'] == 1)
                        $FilePath = FILE_PATH . $value[0]['InputId'] . '.html';
                    else
                        $FilePath = $L;
                    $LinkArray[$FilePath] = $L;
                }
                reset($LinkArray);

                //pr($LinkArray);

                $FirstLink = key($LinkArray);
                $this->set('Html', $LinkArray);
                $this->set('FirstLink', $FirstLink);

                $QueryDetails = array();

                $QueryDetails = $connection->execute("SELECT TLComments,Query,StatusID FROM ME_UserQuery WITH (NOLOCK) WHERE   ProductionEntityId=" . $productionjobNew['ProductionEntity'])->fetchAll('assoc');
                $this->set('QueryDetails', $QueryDetails[0]);
            }

            $InputEntityId = $InprogressProductionjob[0]['InputEntityId'];
            if (empty($InprogressProductionjob)) {
                $InputEntityId = $productionjob[0]['InputEntityId'];
            }

            $productionjobId = $this->request->data['ProductionId'];
            $ProductionEntity = $this->request->data['ProductionEntity'];
            $productionjobStatusId = $this->request->data['StatusId'];
            // pr($this->request->data);

            if (isset($this->request->data['Submit'])) {

                if (count($DynamicFields) > 1) {
                    foreach ($DynamicFields as $val) {
                        $dymamicupdatetempFileds.="[" . $val['AttributeMasterId'] . "]='" . $this->request->data[$val['AttributeMasterId']] . "',";
                    }
                    $dymamicupdatetempFileds.="TimeTaken='" . $this->request->data['TimeTaken'] . "'";
                    $Dynamicproductionjob = $connection->execute('UPDATE ' . $stagingTable . ' SET ' . $dymamicupdatetempFileds . 'where ProductionEntity=' . $ProductionEntity);
                }
                $cnt_InputEntity = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE ProjectId=" . $ProjectId . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

                $cnt_InputEntity_QcError = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=1 AND ProjectId=" . $ProjectId . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

                $cnt_InputEntity_TLAcceptError = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=2 AND ProjectId=" . $ProjectId . " AND UserId=" . $user_id . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

                $cnt_InputEntity_QcError_Deleted = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=0 AND RecordStatus =1 AND ProjectId=" . $ProjectId . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

                if ($cnt_InputEntity[0]['cnt'] != 0) {

                    if ($cnt_InputEntity_QcError[0]['cnt'] != 0) {
                        $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][2][1];
                        $QcStatusId = 1;
                        $submitType = 'completed';
                    } else if ($cnt_InputEntity_QcError_Deleted[0]['cnt'] != 0) {
                        if ($cnt_InputEntity_TLAcceptError[0]['cnt'] != 0) {
                            $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][2][1];
                            $QcStatusId = 5;
                        } else {
                            $status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][2][1];
                            $completion_status = $JsonArray['ModuleStatus_Navigation'][$status][2][1];
                            $QcStatusId = 7;
                            $submitType = 'completed';
                        }
                    }
                } else {
                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][1];
                    $QcStatusId = 0;
                    $submitType = 'completed';
                    ///qc complete////
                    $QCcompletequery = $connection->execute("SELECT Qc_Batch_Id FROM ME_Production_TimeMetric where InputEntityId='".$InputEntityId."'")->fetchAll('assoc');
                    $QCBatchId=$QCcompletequery[0]['Qc_Batch_Id'];         
                    $connection->execute("UPDATE MV_QC_BatchMaster SET QCCompletedCount = QCCompletedCount + 1 where Id='".$QCBatchId."'");
                    /////end///////// 
                    
                    
                }
				
                if ($completion_status != '') {
                    $QcIterationUpdate = $connection->execute("UPDATE MV_QC_Iteration SET QcEndDate='" . date('Y-m-d H:i:s') . "',TimeTaken='" . $this->request->data['TimeTaken'] . "',ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id WHERE CreatedDate IN (select MAX (createddate)from MV_QC_Iteration) and InputEntityId=" . $InputEntityId);
                    $productionCompletejob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $completion_status . ",ActEnddate='" . date('Y-m-d H:i:s') . "' ,TimeTaken='" . $this->request->data['TimeTaken'] . "' WHERE ProductionEntity=" . $ProductionEntity);
                    $productionjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $completion_status . ",ProductionEndDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $ProductionEntity);
                    $productiontimemetricMain = $connection->execute("UPDATE MV_QC_TimeMetric SET StatusId=" . $completion_status . ",QcStatusId=" . $QcStatusId . ",QCEndDate='" . date('Y-m-d H:i:s') . "',QCTimeTaken='" . $this->request->data['TimeTaken'] . "' WHERE ProductionEntityID=" . $ProductionEntity . " AND Module_Id=" . $moduleId);

                    $this->redirect(array('controller' => 'QCValidation', 'action' => '', '?' => array('job' => $submitType)));
                    return $this->redirect(['action' => 'index']);
                    return $this->redirect(['action' => 'index']);
                }
            }

            if (empty($InprogressProductionjob) && empty($InprogressRebutaljob) && $this->request->data['NewJob'] != 'NewJob' && !isset($this->request->data['Submit']) && $this->request->query['job'] != 'newjob') {
                $this->set('getNewJOb', 'getNewJOb');
            } else {
                $this->set('getNewJOb', '');
            }
            $vals = array();
            $valKey = array();
            foreach ($ReadOnlyFields as $key => $val) {
                $vals[] = $val['AttributeName'];
                $valKey[] = $val['AttributeMasterId'];
            }
            foreach ($ProductionFields as $key => $val) {
                $vals[] = $val['AttributeName'];
                $valKey[] = $val['AttributeMasterId'];
                $validationRules = $JsonArray['ValidationRules'][$val['ProjectAttributeMasterId']];
                $IsAlphabet = $validationRules['IsAlphabet'];
                $IsNumeric = $validationRules['IsNumeric'];
                $IsEmail = $validationRules['IsEmail'];
                $IsUrl = $validationRules['IsUrl'];
                $IsSpecialCharacter = $validationRules['IsSpecialCharacter'];
                $AllowedCharacter = addslashes($validationRules['AllowedCharacter']);
                $NotAllowedCharacter = addslashes($validationRules['NotAllowedCharacter']);
                $Format = $validationRules['Format'];
                $IsUrl = $validationRules['IsUrl'];
                $IsMandatory = $validationRules['IsMandatory'];
                $IsDate = $validationRules['IsDate'];
                $IsDecimal = $validationRules['IsDecimal'];

                $IsAutoSuggesstion = $validationRules['IsAutoSuggesstion'];
                $IsAllowNewValues = $validationRules['IsAllowNewValues'];

                $Dateformat = $validationRules['Dateformat'];
                SWITCH (TRUE) {
                    CASE($IsUrl == 1):
                        $FunctionName = 'urlValidator';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 0 && $IsSpecialCharacter == 0):
                        $FunctionName = 'AlphabetOnlyValidator';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 1 && $IsSpecialCharacter == 0):
                        $FunctionName = 'AlphaNumericOnly';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 1 && $IsSpecialCharacter == 1):
                        $FunctionName = 'AlphaNumericSpecial';
                        $param = 'Yes';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 0 && $IsSpecialCharacter == 1):
                        $FunctionName = 'AlphabetSpecialonly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 1 && $IsSpecialCharacter == 1):
                        $FunctionName = 'NumericSpecialOnly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 0 && $IsSpecialCharacter == 0 && $IsEmail == 1 ):
                        $FunctionName = 'emailValidator';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 1 && $IsSpecialCharacter == 0 && $IsEmail == 0 ):
                        $FunctionName = 'NumbersOnly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 0 && $IsSpecialCharacter == 0 && $IsEmail == 0 && $IsUrl == 1):
                        $FunctionName = 'UrlOnly';
                        BREAK;
                    CASE($IsDate == 1):
                        $FunctionName = 'isDate';
                        BREAK;
                    CASE($IsDecimal == 1):
                        $FunctionName = 'checkDecimal';
                        BREAK;
                    DEFAULT:
                        $FunctionName = '';
                        BREAK;
                }
                if ($IsMandatory == 1) {
                    $Mandatory[$manKey]['AttributeMasterId'] = $val['AttributeMasterId'];
                    $Mandatory[$manKey]['DisplayAttributeName'] = $val['DisplayAttributeName'];
                    $manKey++;
                }
                if ($IsAutoSuggesstion == 1) {
                    $AutoSuggesstion[] = $val['AttributeMasterId'];
                }

                if ($val['ControlName'] == 'DropDownList' && $IsAutoSuggesstion == 1) {
                    $ProductionFields[$key]['ControlName'] = 'Auto';
                    if ($IsAllowNewValues != 0) {

                        $ProductionFields[$key]['IsAllowNewValues'] = 'datacheck(this.id,this.value)';
                    }
                    $ProductionFields[$key]['IsAllowNewValues'] = $IsAllowNewValues;
                }
                $ProductionFields[$key]['MinLength'] = $validationRules['MinLength'];
                $ProductionFields[$key]['MaxLength'] = $validationRules['MaxLength'];
                $ProductionFields[$key]['FunctionName'] = $FunctionName;
                $ProductionFields[$key]['Mandatory'] = $Mandatory;
                $ProductionFields[$key]['AllowedCharacter'] = $AllowedCharacter;
                $ProductionFields[$key]['NotAllowedCharacter'] = $NotAllowedCharacter;
                $ProductionFields[$key]['Format'] = $Format;
                $ProductionFields[$key]['Dateformat'] = $Dateformat;
                $ProductionFields[$key]['AllowedDecimalPoint'] = $validationRules['AllowedDecimalPoint'];
                $ProductionFields[$key]['Options'] = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$val['ProjectAttributeMasterId']]['Options'];
                $ProductionFields[$key]['Mapping'] = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$val['ProjectAttributeMasterId']]['Mapping'];
                if ($ProductionFields[$key]['Mapping']) {
                    $to_be_filled = array_keys($ProductionFields[$key]['Mapping']);
                    $against = $to_be_filled[0];
                    $against_org = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$against]['AttributeId'];
                    $ProductionFields[$key]['Reload'] = 'LoadValue(' . $val['ProjectAttributeMasterId'] . ',this.value,' . $against_org . ');';
                }
                $ops = 0;
                foreach ($ProductionFields[$key]['Options'] as $valops) {
                    $ProductionFields[$key]['Optionsbut'][$ops] = $valops;
                    $ops++;
                }
                $ProductionFields[$key]['Optionsbut1'] = 'NO';
                if (isset($ProductionFields[$key]['Optionsbut']))
                    $ProductionFields[$key]['Optionsbut1'] = json_encode($ProductionFields[$key]['Optionsbut']);
            }

            $this->set('ProductionFields', $ProductionFields);
            $this->set('handsonHeaders', $vals);
            $this->set('valKey', $valKey);
            $this->set('session', $session);
            $this->render('/QCValidation/index_vertical');
            /* GRID END******************************************************************************************************************************************************************* */
        }  
        elseif ($frameType == 2) 
            {

            if (isset($this->request->data['clicktoviewPre'])) {
                $page = $this->request->data['page'] - 1;
                $this->redirect(array('controller' => 'QCValidation', 'action' => 'index/' . $page));
            }
            if (isset($this->request->data['clicktoviewNxt'])) {
                $page = $this->request->data['page'] + 1;
                $this->redirect(array('controller' => 'QCValidation', 'action' => 'index/' . $page));
            }
            //  exit;
            if (isset($this->request->data['DeleteVessel'])) {
                $sequence = 1;
                if (isset($this->request->data['page']))
                    $sequence = $this->request->data['page'];
                $ProjectId = $this->request->data['ProjectId'];
                $ProductionEntity = $this->request->data['ProductionEntity'];
                $ProductionId = $this->request->data['ProductionId'];
                if ($sequence == 1) {
                    $SequenceNumber = $connection->execute('SELECT ' . $tempFileds . 'TimeTaken,Id,BatchID,BatchCreated,ProjectId,RegionId,InputEntityId,ProductionEntity,SequenceNumber,StatusId,UserId FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE ProductionEntity=' . $ProductionEntity)->fetchAll('assoc');
                    $sequencemax = count($SequenceNumber);
                    if ($sequencemax == 1)
                        return 'Minimum one record required';
                }
                $delete = $connection->execute("DELETE FROM " . $stagingTable . " WHERE   ProductionEntity='" . $ProductionEntity . "' and SequenceNumber='" . $sequence . "'");
                $SequenceNumber = $connection->execute("SELECT Id,SequenceNumber FROM " . $stagingTable . "  WITH (NOLOCK) WHERE  ProductionEntity='" . $ProductionEntity . "' AND SequenceNumber>$sequence order by SequenceNumber desc")->fetchAll('assoc');
                foreach ($SequenceNumber as $key => $val) {
                    $newsequence = $val['SequenceNumber'] - 1;
                    $id = $val['Id'];
                    $update = $connection->execute("update  " . $stagingTable . " set SequenceNumber = $newsequence WHERE Id=" . $val['Id'] . "  and SequenceNumber='" . $val['SequenceNumber'] . "'");
                }

                if ($delete == 'no')
                    $this->Flash->success(__('Minimum One record required'));
                else
                    $this->Flash->success(__('Deleted Successfully'));
                $this->redirect(array('controller' => 'QCValidation', 'action' => 'index/'));
            }

            if (isset($this->request->query['job']))
                $newJob = $this->request->query['job'];
            if (isset($this->request->data['NewJob']))
                $newJob = $this->request->data['NewJob'];
            $page = 1;
            if (isset($this->request->params['pass'][0]))
                $page = $this->request->params['pass'][0];
            $staticSequence = $page;
            if (isset($this->request->data['AddNew'])) {
                $staticSequence = $SequenceNumber + 1;
                $tempFileds = '';
            }

            $this->set('staticSequence', $staticSequence);
            $this->set('page', $page);

            $addnew = '';
            if (isset($this->request->data['AddNew']))
                $addnew = 'Addnew';
            $this->set('ADDNEW', $addnew);
            $this->set('next_status_id', $next_status_id);

            $InprogressProductionjob = $connection->execute('SELECT * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE StatusId=' . $next_status_id . ' AND SequenceNumber=' . $page . ' AND ProjectId=' . $ProjectId . ' AND UserId= ' . $user_id)->fetchAll('assoc');

            if (empty($InprogressProductionjob)) {
                $InprogressRebutaljob = $connection->execute('SELECT TOP 1 *  FROM MV_QC_TimeMetric where QcStatusId = 4 AND QCUSerID=' . $user_id . ' AND ProjectId=' . $ProjectId)->fetchAll('assoc');

                if (empty($InprogressRebutaljob)) {
                    $Rebutaljob = $connection->execute('SELECT TOP 1 * FROM MV_QC_TimeMetric where QcStatusId = 3 AND QCUSerID=' . $user_id . ' AND ProjectId=' . $ProjectId)->fetchAll('assoc');

                    if (empty($Rebutaljob)) {
                        $productionjob = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE StatusId=' . $first_Status_id . ' AND SequenceNumber=' . $page . ' AND ProjectId=' . $ProjectId)->fetchAll('assoc');
                        if (empty($productionjob)) {
                            $this->set('NoNewJob', 'NoNewJob');
                        } else {
                            if ($productionjob[0]['StatusId'] == $first_Status_id && ($newJob == 'NewJob' || $newJob == 'newjob')) {
//                        $updateUserGroupId = $connection->execute("SELECT UserGroupId FROM MV_UserGroupMapping where Projectid=$ProjectId and RegionId=".$productionjob[0]['RegionId']." and UserId=$user_id and RecordStatus=1");
//                            foreach ($updateUserGroupId as $UserVal) {
//                               $userGpId = $UserVal['UserGroupId']; 
//                            }
//                        $inprogressjob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $next_status_id . ",UserId=" . $user_id . ",UserGroupId=" . $userGpId .",ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $productionjob[0]['ProductionEntity']);
                                $ProjectId = $productionjob[0]['ProjectId'];
                                $RegionId = $productionjob[0]['RegionId'];
                                $InputEntityId = $productionjob[0]['InputEntityId'];

                                $QcIterationInsert = $connection->execute("INSERT INTO MV_QC_Iteration (ProjectId,RegionId,InputEntityId,QCUserId,QcStartDate,RecordStatus,CreatedDate,CreatedBy) values($ProjectId,$RegionId,$InputEntityId,$user_id,'" . date('Y-m-d H:i:s') . "',1,'" . date('Y-m-d H:i:s') . "',$user_id)");
                                $inprogressjob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $next_status_id . ",UserId=" . $user_id . ",ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id,ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $productionjob[0]['ProductionEntity']);
                                $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $next_status_id . ",ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id,ProductionStartDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $productionjob[0]['ProductionEntity']);
                                $productiontimemetricMain = $connection->execute("UPDATE MV_QC_TimeMetric SET StatusId=" . $next_status_id . ",ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id,QCUSerID=" . $user_id . ",QCStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntityID=" . $productionjob[0]['ProductionEntity'] . " AND Module_Id=" . $moduleId);
                                $productionjob[0]['StatusId'] = $next_status_id;
                                $productionjob[0]['StatusId'] = 'QC In Progress';
                            }
                            $productionjobNew = $productionjob[0];
                            $this->set('productionjob', $productionjob[0]);
                            $inputEntity = $productionjob[0]['InputEntityId'];
                            $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity . ' AND Qc_Batch_Id IS NOT NULL')->fetchAll('assoc');
                            $QcBatchId = $BatchId[0]['Qc_Batch_Id'];
                            $ProdUserId = $BatchId[0]['UserId'];
                            $BatchName = $connection->execute('SELECT BatchName FROM MV_QC_BatchMaster WITH (NOLOCK) WHERE Id=' . $QcBatchId)->fetchAll('assoc');
                            $QcBatchName = $BatchName[0]['BatchName'];
                            $this->set('QcBatchName', $QcBatchName);
                            $this->set('ProdUserId', $ProdUserId);
                        }
                    } else {

                        $Error_status = $Rebutaljob[0]['StatusId'];
                        $InputEntityId = $Rebutaljob[0]['InputEntityId'];

                        $productionjob = $connection->execute('SELECT * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE InputEntityId=' . $InputEntityId . ' AND SequenceNumber=' . $page . ' AND ProjectId=' . $ProjectId . ' AND UserId= ' . $user_id)->fetchAll('assoc');
                        if ($productionjob[0]['StatusId'] == $Error_status && ($newJob == 'NewJob' || $newJob == 'newjob')) {
                            $ProjectId = $productionjob[0]['ProjectId'];
                            $RegionId = $productionjob[0]['RegionId'];
                            $InputEntityId = $productionjob[0]['InputEntityId'];

                            $QcIterationInsert = $connection->execute("INSERT INTO MV_QC_Iteration (ProjectId,RegionId,InputEntityId,QCUserId,QcStartDate,RecordStatus,CreatedDate,CreatedBy) values($ProjectId,$RegionId,$InputEntityId,$user_id,'" . date('Y-m-d H:i:s') . "',1,'" . date('Y-m-d H:i:s') . "',$user_id)");
                            $inprogressjob = $connection->execute("UPDATE " . $stagingTable . " SET UserId=" . $user_id . ",ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id,ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $productionjob[0]['ProductionEntity']);
                            $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id,ProductionStartDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $productionjob[0]['ProductionEntity']);
                            $productiontimemetricMain = $connection->execute("UPDATE MV_QC_TimeMetric SET QcStatusId = 4,QCUSerID=" . $user_id . ",ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id,QCStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntityID=" . $productionjob[0]['ProductionEntity'] . " AND Module_Id=" . $moduleId);
                            $productionjob[0]['StatusId'] = $Error_status;
                            $productionjob[0]['StatusId'] = 'QC Error In Progress';
                        }
                        $productionjobNew = $productionjob[0];
                        $this->set('productionjob', $productionjob[0]);
                        $inputEntity = $productionjob[0]['InputEntityId'];
                        $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity . ' AND Qc_Batch_Id IS NOT NULL')->fetchAll('assoc');
                        $QcBatchId = $BatchId[0]['Qc_Batch_Id'];
                        $ProdUserId = $BatchId[0]['UserId'];
                        $BatchName = $connection->execute('SELECT BatchName FROM MV_QC_BatchMaster WITH (NOLOCK) WHERE Id=' . $QcBatchId)->fetchAll('assoc');
                        $QcBatchName = $BatchName[0]['BatchName'];
                        $this->set('QcBatchName', $QcBatchName);
                        $this->set('ProdUserId', $ProdUserId);
                    }
                } else {

                    $InputEntityId = $InprogressRebutaljob[0]['InputEntityId'];
                    $productionjob = $connection->execute('SELECT * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE InputEntityId=' . $InputEntityId . ' AND SequenceNumber=' . $page . ' AND ProjectId=' . $ProjectId . ' AND UserId= ' . $user_id)->fetchAll('assoc');
                    $this->set('getNewJOb', '');
                    $this->set('productionjob', $productionjob[0]);
                    $inputEntity = $productionjob[0]['InputEntityId'];
                    $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity . ' AND Qc_Batch_Id IS NOT NULL')->fetchAll('assoc');
                    $QcBatchId = $BatchId[0]['Qc_Batch_Id'];
                    $ProdUserId = $BatchId[0]['UserId'];
                    $BatchName = $connection->execute('SELECT BatchName FROM MV_QC_BatchMaster WITH (NOLOCK) WHERE Id=' . $QcBatchId)->fetchAll('assoc');
                    $QcBatchName = $BatchName[0]['BatchName'];
                    $this->set('QcBatchName', $QcBatchName);
                    $this->set('ProdUserId', $ProdUserId);
                    $productionjobNew = $productionjob[0];
                }
            } else {

                $this->set('getNewJOb', '');
                $this->set('productionjob', $InprogressProductionjob[0]);
                $inputEntity = $InprogressProductionjob[0]['InputEntityId'];
                $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity . ' AND Qc_Batch_Id IS NOT NULL')->fetchAll('assoc');
                $QcBatchId = $BatchId[0]['Qc_Batch_Id'];
                $ProdUserId = $BatchId[0]['UserId'];
                $BatchName = $connection->execute('SELECT BatchName FROM MV_QC_BatchMaster WITH (NOLOCK) WHERE Id=' . $QcBatchId)->fetchAll('assoc');
                $QcBatchName = $BatchName[0]['BatchName'];
                $this->set('QcBatchName', $QcBatchName);
                $this->set('ProdUserId', $ProdUserId);
                $productionjobNew = $InprogressProductionjob[0];
            }

            $RegionId = $productionjobNew['RegionId'];
            $StaticFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['static'];
            $DynamicFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['dynamic'];
            $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
            $ReadOnlyFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['readonly'];
            $this->set('StaticFields', $StaticFields);
            $this->set('DynamicFields', $DynamicFields);

            $tempFileds = '';
            foreach ($ProductionFields as $val) {
                $tempFileds.="[" . $val['AttributeMasterId'] . "],";
            }
            foreach ($DynamicFields as $val) {
                $tempFileds.="[" . $val['AttributeMasterId'] . "],";
            }
            foreach ($StaticFields as $val) {
                $tempFileds.="[" . $val['AttributeMasterId'] . "],";
            }

            if (isset($productionjobNew)) {
                $SequenceNumber = $connection->execute('SELECT ' . $tempFileds . 'TimeTaken,Id,BatchID,BatchCreated,ProjectId,RegionId,InputEntityId,ProductionEntity,SequenceNumber,StatusId,UserId FROM ' . $stagingTable . ' WITH (NOLOCK)  WHERE ProductionEntity=' . $productionjobNew['ProductionEntity'] . ' ORDER BY SequenceNumber')->fetchAll('assoc');
                $this->set('SequenceNumber', count($SequenceNumber));

                $DomainIdName = $productionjobNew[$domainId];
                $TimeTaken = $productionjobNew['TimeTaken'];

                $this->set('TimeTaken', $TimeTaken);
                $link = $connection->execute("SELECT DomainUrl,DownloadStatus FROM ME_DomainUrl WITH (NOLOCK) WHERE   ProjectId=" . $ProjectId . " AND RegionId=" . $productionjobNew['RegionId'] . " AND DomainId='" . $DomainIdName . "'")->fetchAll('assoc');
                foreach ($link as $key => $value) {
                    $L = $value['DomainUrl'];

                    $pos = strpos($L, 'http');
                    if ($pos === false) {
                        $L = "http://" . $L;
                    }

                    if ($value['DownloadStatus'] == 1)
                        $FilePath = FILE_PATH . $value[0]['InputId'] . '.html';
                    else
                        $FilePath = $L;
                    $LinkArray[$FilePath] = $L;
                }
                reset($LinkArray);
                $FirstLink = key($LinkArray);
                $this->set('Html', $LinkArray);
                $this->set('FirstLink', $FirstLink);

                $QueryDetails = array();

                $QueryDetails = $connection->execute("SELECT TLComments,Query,StatusID FROM ME_UserQuery WITH (NOLOCK) WHERE   ProductionEntityId=" . $productionjobNew['ProductionEntity'])->fetchAll('assoc');
                $this->set('QueryDetails', $QueryDetails[0]);
            }

            $InputEntityId = $InprogressProductionjob[0]['InputEntityId'];
            if (empty($InprogressProductionjob)) {
                $InputEntityId = $productionjob[0]['InputEntityId'];
            }

            $productionjobId = $this->request->data['ProductionId'];
            $ProductionEntity = $this->request->data['ProductionEntity'];
            $productionjobStatusId = $this->request->data['StatusId'];

            if (isset($this->request->data['Submit'])) {

                $cnt_InputEntity = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE ProjectId=" . $ProjectId . " AND UserId=" . $user_id . "  AND InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

                $cnt_InputEntity_QcError = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=1 AND ProjectId=" . $ProjectId . " AND UserId=" . $user_id . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

                $cnt_InputEntity_TLAcceptError = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=2 AND ProjectId=" . $ProjectId . " AND UserId=" . $user_id . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

                $cnt_InputEntity_QcError_Deleted = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=0 AND RecordStatus =1 AND ProjectId=" . $ProjectId . " AND UserId=" . $user_id . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

                if ($cnt_InputEntity[0]['cnt'] != 0) {

                    if ($cnt_InputEntity_QcError[0]['cnt'] != 0) {
                        $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][2][1];
                        $QcStatusId = 1;
                        $submitType = 'completed';
                    } else if ($cnt_InputEntity_QcError_Deleted[0]['cnt'] != 0) {
                        if ($cnt_InputEntity_TLAcceptError[0]['cnt'] != 0) {
                            $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][2][1];
                            $QcStatusId = 5;
                        } else {
                            $status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][2][1];
                            $completion_status = $JsonArray['ModuleStatus_Navigation'][$status][2][1];
                            $QcStatusId = 7;
                            $submitType = 'completed';
                        }
                    }
                } else {
                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][1];
                    $QcStatusId = 0;
                    $submitType = 'completed';
                }
                if ($completion_status != '') {
                    $QcIterationUpdate = $connection->execute("UPDATE MV_QC_Iteration SET QcEndDate='" . date('Y-m-d H:i:s') . "',TimeTaken='" . $this->request->data['TimeTaken'] . "',ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id WHERE CreatedDate IN (select MAX (createddate)from MV_QC_Iteration) and InputEntityId=" . $InputEntityId);
                    $productionCompletejob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $completion_status . ",ActEnddate='" . date('Y-m-d H:i:s') . "',ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id,TimeTaken='" . $this->request->data['TimeTaken'] . "' WHERE ProductionEntity=" . $ProductionEntity);
                    $productionjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $completion_status . ",ProductionEndDate='" . date('Y-m-d H:i:s') . "',ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id WHERE ID=" . $ProductionEntity);
                    $productiontimemetricMain = $connection->execute("UPDATE MV_QC_TimeMetric SET StatusId=" . $completion_status . ",QcStatusId=" . $QcStatusId . ",QCEndDate='" . date('Y-m-d H:i:s') . "',QCTimeTaken='" . $this->request->data['TimeTaken'] . "',ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id WHERE ProductionEntityID=" . $ProductionEntity . " AND Module_Id=" . $moduleId);
                    $this->redirect(array('controller' => 'QCValidation', 'action' => '', '?' => array('job' => $submitType)));
                    return $this->redirect(['action' => 'index']);
                    //$Dynamicproductionjob = $connection->execute("UPDATE  $stagingTable  SET TimeTaken='" . $this->request->data['TimeTaken'] . "' where ProductionEntity= ".$ProductionEntity);
                }
            }

            if (empty($InprogressProductionjob) && empty($InprogressRebutaljob) && $this->request->data['NewJob'] != 'NewJob' && !isset($this->request->data['Submit']) && $this->request->query['job'] != 'newjob') {
                $this->set('getNewJOb', 'getNewJOb');
            } else {
                $this->set('getNewJOb', '');
            }

            foreach ($DynamicFields as $key => $val) {
                $validationRules = $JsonArray['ValidationRules'][$val['ProjectAttributeMasterId']];
                $IsAlphabet = $validationRules['IsAlphabet'];
                $IsNumeric = $validationRules['IsNumeric'];
                $IsEmail = $validationRules['IsEmail'];
                $IsUrl = $validationRules['IsUrl'];
                $IsSpecialCharacter = $validationRules['IsSpecialCharacter'];
                $AllowedCharacter = addslashes($validationRules['AllowedCharacter']);
                $NotAllowedCharacter = addslashes($validationRules['NotAllowedCharacter']);
                $Format = $validationRules['Format'];
                $IsUrl = $validationRules['IsUrl'];
                $IsMandatory = $validationRules['IsMandatory'];
                $IsDate = $validationRules['IsDate'];
                $IsDecimal = $validationRules['IsDecimal'];

                $IsAutoSuggesstion = $validationRules['IsAutoSuggesstion'];
                $IsAllowNewValues = $validationRules['IsAllowNewValues'];

                $Dateformat = $validationRules['Dateformat'];
                SWITCH (TRUE) {
                    CASE($IsUrl == 1):
                        $FunctionName = 'UrlOnly';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 0 && $IsSpecialCharacter == 0):
                        $FunctionName = 'AlphabetOnly';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 1 && $IsSpecialCharacter == 0):
                        $FunctionName = 'AlphaNumericOnly';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 1 && $IsSpecialCharacter == 1):
                        $FunctionName = 'AlphaNumericSpecial';
                        $param = 'Yes';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 0 && $IsSpecialCharacter == 1):
                        $FunctionName = 'AlphabetSpecialonly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 1 && $IsSpecialCharacter == 1):
                        $FunctionName = 'NumericSpecialOnly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 0 && $IsSpecialCharacter == 0 && $IsEmail == 1 ):
                        $FunctionName = 'EmailOnly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 1 && $IsSpecialCharacter == 0 && $IsEmail == 0 ):
                        $FunctionName = 'NumbersOnly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 0 && $IsSpecialCharacter == 0 && $IsEmail == 0 && $IsUrl == 1):
                        $FunctionName = 'UrlOnly';
                        BREAK;
                    CASE($IsDate == 1):
                        $FunctionName = 'isDate';
                        BREAK;
                    CASE($IsDecimal == 1):
                        $FunctionName = 'checkDecimal';
                        BREAK;
                    DEFAULT:
                        $FunctionName = '';
                        BREAK;
                }
                if ($IsMandatory == 1) {
                    $Mandatory[] = $val['AttributeMasterId'];
                }
                if ($IsAutoSuggesstion == 1) {
                    $AutoSuggesstion[] = $val['AttributeMasterId'];
                }

                if ($val['ControlName'] == 'DropDownList' && $IsAutoSuggesstion == 1) {
                    $DynamicFields[$key]['ControlName'] = 'Auto';
                    if ($IsAllowNewValues != 0) {

                        $DynamicFields[$key]['IsAllowNewValues'] = 'datacheck(this.id,this.value)';
                    }
                    $DynamicFields[$key]['IsAllowNewValues'] = $IsAllowNewValues;
                }
                $DynamicFields[$key]['MinLength'] = $validationRules['MinLength'];
                $DynamicFields[$key]['MaxLength'] = $validationRules['MaxLength'];
                $DynamicFields[$key]['FunctionName'] = $FunctionName;
                $DynamicFields[$key]['Mandatory'] = $Mandatory;
                $DynamicFields[$key]['AllowedCharacter'] = $AllowedCharacter;
                $DynamicFields[$key]['NotAllowedCharacter'] = $NotAllowedCharacter;
                $DynamicFields[$key]['Format'] = $Format;
                $DynamicFields[$key]['Dateformat'] = $Dateformat;
                $DynamicFields[$key]['AllowedDecimalPoint'] = $validationRules['AllowedDecimalPoint'];
                $DynamicFields[$key]['Options'] = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$val['ProjectAttributeMasterId']]['Options'];
                $DynamicFields[$key]['Mapping'] = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$val['ProjectAttributeMasterId']]['Mapping'];
                if ($DynamicFields[$key]['Mapping']) {
                    $to_be_filled = array_keys($DynamicFields[$key]['Mapping']);
                    $against = $to_be_filled[0];
                    $DynamicFields[$key]['Reload'] = 'LoadValue(' . $val['ProjectAttributeMasterId'] . ',this.value,' . $against . ');';
                }
            }
            $x_Array = array();
            $i = 0;
            $j = 0;
            foreach ($DynamicFields as $key => $value) {
                if ($key == 0)
                    $d = $key;
                else
                    $d = $key - 1;
                if (empty($InprogressProductionjob)) {
                    $DOldDataresult[$DynamicFields[$key]['AttributeMasterId']] = $this->QCValidation->ajax_GetOldDatavalue($productionjob[0][0]['InputEntityId'], $DynamicFields[$key]['AttributeMasterId'], $DynamicFields[$key]['ProjectAttributeMasterId'], 1);
                } else {
                    $DOldDataresult[$DynamicFields[$key]['AttributeMasterId']] = $this->QCValidation->ajax_GetOldDatavalue($InprogressProductionjob[0][0]['InputEntityId'], $DynamicFields[$key]['AttributeMasterId'], $DynamicFields[$key]['ProjectAttributeMasterId'], 1);
                }
                $j++;
            }
            //pr($DOldDataresult);
            $this->set('DOldDataresult', $DOldDataresult);

            $manKey = 0;
            foreach ($ProductionFields as $key => $val) {
                $validationRules = $JsonArray['ValidationRules'][$val['ProjectAttributeMasterId']];
                $IsAlphabet = $validationRules['IsAlphabet'];
                $IsNumeric = $validationRules['IsNumeric'];
                $IsEmail = $validationRules['IsEmail'];
                $IsUrl = $validationRules['IsUrl'];
                $IsSpecialCharacter = $validationRules['IsSpecialCharacter'];
                $AllowedCharacter = addslashes($validationRules['AllowedCharacter']);
                $NotAllowedCharacter = addslashes($validationRules['NotAllowedCharacter']);
                $Format = $validationRules['Format'];
                $IsUrl = $validationRules['IsUrl'];
                $IsMandatory = $validationRules['IsMandatory'];
                $IsDate = $validationRules['IsDate'];
                $IsDecimal = $validationRules['IsDecimal'];

                $IsAutoSuggesstion = $validationRules['IsAutoSuggesstion'];
                $IsAllowNewValues = $validationRules['IsAllowNewValues'];

                $Dateformat = $validationRules['Dateformat'];
                SWITCH (TRUE) {
                    CASE($IsUrl == 1):
                        $FunctionName = 'UrlOnly';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 0 && $IsSpecialCharacter == 0):
                        $FunctionName = 'AlphabetOnly';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 1 && $IsSpecialCharacter == 0):
                        $FunctionName = 'AlphaNumericOnly';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 1 && $IsSpecialCharacter == 1):
                        $FunctionName = 'AlphaNumericSpecial';
                        $param = 'Yes';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 0 && $IsSpecialCharacter == 1):
                        $FunctionName = 'AlphabetSpecialonly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 1 && $IsSpecialCharacter == 1):
                        $FunctionName = 'NumericSpecialOnly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 0 && $IsSpecialCharacter == 0 && $IsEmail == 1 ):
                        $FunctionName = 'EmailOnly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 1 && $IsSpecialCharacter == 0 && $IsEmail == 0 ):
                        $FunctionName = 'NumbersOnly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 0 && $IsSpecialCharacter == 0 && $IsEmail == 0 && $IsUrl == 1):
                        $FunctionName = 'UrlOnly';
                        BREAK;
                    CASE($IsDate == 1):
                        $FunctionName = 'isDate';
                        BREAK;
                    CASE($IsDecimal == 1):
                        $FunctionName = 'checkDecimal';
                        BREAK;
                    DEFAULT:
                        $FunctionName = '';
                        BREAK;
                }
                if ($IsMandatory == 1) {
                    $Mandatory[$manKey]['AttributeMasterId'] = $val['AttributeMasterId'];
                    $Mandatory[$manKey]['DisplayAttributeName'] = $val['DisplayAttributeName'];
                    $manKey++;
                }
                if ($IsAutoSuggesstion == 1) {
                    $AutoSuggesstion[] = $val['AttributeMasterId'];
                }

                if ($val['ControlName'] == 'DropDownList' && $IsAutoSuggesstion == 1) {
                    $ProductionFields[$key]['ControlName'] = 'Auto';
                    if ($IsAllowNewValues != 0) {

                        $ProductionFields[$key]['IsAllowNewValues'] = 'datacheck(this.id,this.value)';
                    }
                    $ProductionFields[$key]['IsAllowNewValues'] = $IsAllowNewValues;
                }
                $ProductionFields[$key]['MinLength'] = $validationRules['MinLength'];
                $ProductionFields[$key]['MaxLength'] = $validationRules['MaxLength'];
                $ProductionFields[$key]['FunctionName'] = $FunctionName;
                $ProductionFields[$key]['Mandatory'] = $Mandatory;
                $ProductionFields[$key]['AllowedCharacter'] = $AllowedCharacter;
                $ProductionFields[$key]['NotAllowedCharacter'] = $NotAllowedCharacter;
                $ProductionFields[$key]['Format'] = $Format;
                $ProductionFields[$key]['Dateformat'] = $Dateformat;
                $ProductionFields[$key]['AllowedDecimalPoint'] = $validationRules['AllowedDecimalPoint'];
                $ProductionFields[$key]['Options'] = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$val['ProjectAttributeMasterId']]['Options'];
                $ProductionFields[$key]['Mapping'] = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$val['ProjectAttributeMasterId']]['Mapping'];
                if ($ProductionFields[$key]['Mapping']) {
                    $to_be_filled = array_keys($ProductionFields[$key]['Mapping']);
                    $against = $to_be_filled[0];
                    $against_org = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$against]['AttributeId'];
                    $ProductionFields[$key]['Reload'] = 'LoadValue(' . $val['ProjectAttributeMasterId'] . ',this.value,' . $against_org . ');';
                }
            }

            $f_Array = array();
            //Create array by sequence number
            $i = 0;
            $j = 0;
            $qcComments = array();

            foreach ($ProductionFields as $key => $value) {
                if ($key == 0)
                    $p = $key;
                else
                    $p = $key - 1;
                if ($value['SequenceNumber'] == $P_array[$p]['SequenceNumber']) {
                    $f_Array[$i][$j] = $P_array[$key];
                } else {
                    $i++;
                    $f_Array[$i][$j] = $P_array[$key];
                }
//             echo '<pre>';
//             print_r($ProductionFields[$key]['AttributeMasterId']);
                if (empty($InprogressProductionjob)) {
                    //     print_r($productionjob);
                    $OldDataresultError[$ProductionFields[$key]['AttributeMasterId']] = $this->QCValidation->ajax_GetOldDatavalue($productionjob[0]['InputEntityId'], $ProductionFields[$key]['AttributeMasterId'], $ProductionFields[$key]['ProjectAttributeMasterId'], 1);
                    $OldDataresultRebutal[$ProductionFields[$key]['AttributeMasterId']] = $this->QCValidation->ajax_GetRebutalvalue($productionjob[0]['InputEntityId'], $ProductionFields[$key]['AttributeMasterId'], $ProductionFields[$key]['ProjectAttributeMasterId'], 1);
                } else {
                    //   print_r($InprogressProductionjob);
                    $OldDataresultError[$ProductionFields[$key]['AttributeMasterId']] = $this->QCValidation->ajax_GetOldDatavalue($InprogressProductionjob[0]['InputEntityId'], $ProductionFields[$key]['AttributeMasterId'], $ProductionFields[$key]['ProjectAttributeMasterId'], 1);
                    $OldDataresultRebutal[$ProductionFields[$key]['AttributeMasterId']] = $this->QCValidation->ajax_GetRebutalvalue($InprogressProductionjob[0]['InputEntityId'], $ProductionFields[$key]['AttributeMasterId'], $ProductionFields[$key]['ProjectAttributeMasterId'], 1);
                }
                $j++;
            }
            $this->set('OldDataresultError', $OldDataresultError);
            $this->set('OldDataresultRebutal', $OldDataresultRebutal);
            $Html = $Html_nameS;

            $this->set('ProductionFields', $ProductionFields);
            $this->set('DynamicFields', $DynamicFields);
            $this->set('Mandatory', $Mandatory);
            $this->set('AutoSuggesstion', $AutoSuggesstion);
            $this->set('ReadOnlyFields', $ReadOnlyFields);
            $this->set('session', $session);
            $dynamicData = $SequenceNumber[0];
            $this->set('dynamicData', $dynamicData);
        } 
		else {
           
//pr($this->request);
            $distinct = $this->GetJob->find('getDistinct', ['ProjectId' => $ProjectId]);
            $this->set('distinct', $distinct);

            // pr($distinct);
            //----------------------------------$frameType == 3------------------------------//
            $this->viewBuilder()->layout('boostrap-default');



            if (isset($this->request->query['job']))
                $newJob = $this->request->query['job'];
            if (isset($this->request->data['NewJob']))
                $newJob = $this->request->data['NewJob'];
            $page = 1;
            if (isset($this->request->params['pass'][0]))
                $page = $this->request->params['pass'][0];

            $staticSequence = $page;
            if (isset($this->request->data['AddNew'])) {
                $staticSequence = $SequenceNumber + 1;
                $tempFileds = '';
            }

            $this->set('staticSequence', $staticSequence);
            $this->set('page', $page);
            $addnew = '';
            if (isset($this->request->data['AddNew']))
                $addnew = 'Addnew';
            $this->set('ADDNEW', $addnew);
            $this->set('next_status_id', $next_status_id);
            $next_status_id_org=$next_status_id;
           $InprogressProductionjob = $connection->execute('SELECT * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE UserId=' . $user_id . ' AND StatusId IN (' . $next_status_id_rw . ','.$next_status_id.') AND SequenceNumber=1 AND ProjectId=' . $ProjectId)->fetchAll('assoc');
           //pr($InprogressProductionjob);exit;
            if (empty($InprogressProductionjob)) {
                 
                  $Reworkjob = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WHERE StatusId=' . $first_Status_id_rw . ' AND SequenceNumber=1 AND ProjectId=' . $ProjectId)->fetchAll('assoc');
                     if (empty($Reworkjob)) {
						
                      $CheckStatus="Inprogress";

                        $productionjob = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WHERE StatusId=' . $first_Status_id . ' AND SequenceNumber=1 AND ProjectId=' . $ProjectId)->fetchAll('assoc');
                        if (empty($productionjob)) {
                            $this->set('NoNewJob', 'NoNewJob');
                        } else {
                            
                            foreach ($productionjob as $val) {
                                if ($val['StatusId'] == $first_Status_id && ($newJob == 'NewJob' || $newJob == 'newjob')) {
//                        $updateUserGroupId = $connection->execute("SELECT UserGroupId FROM MV_UserGroupMapping where Projectid=$ProjectId and RegionId=".$productionjob[0]['RegionId']." and UserId=$user_id and RecordStatus=1");
//                            foreach ($updateUserGroupId as $UserVal) {
//                               $userGpId = $UserVal['UserGroupId']; 
//                            }
//                        $inprogressjob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $next_status_id . ",UserId=" . $user_id . ",UserGroupId=" . $userGpId .",ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $productionjob[0]['ProductionEntity']);
                                    $ProjectId = $productionjob[0]['ProjectId'];
                                    $RegionId = $productionjob[0]['RegionId'];
                                    $InputEntityId = $productionjob[0]['InputEntityId'];

                                    $QcIterationInsert = $connection->execute("INSERT INTO MV_QC_Iteration (ProjectId,RegionId,InputEntityId,QCUserId,QcStartDate,RecordStatus,CreatedDate,CreatedBy) values($ProjectId,$RegionId,$InputEntityId,$user_id,'" . date('Y-m-d H:i:s') . "',1,'" . date('Y-m-d H:i:s') . "',$user_id)");
                                    $productionCompletejob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $next_status_id . ",UserId=" . $user_id . ",ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $val['ProductionEntity']);
                                    $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $next_status_id . ",ProductionStartDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $val['ProductionEntity']);
                                    $productiontimemetricMain = $connection->execute("UPDATE MV_QC_TimeMetric SET StatusId=" . $next_status_id . ",QCUSerID=" . $user_id . ",QCStartDate='" . date('Y-m-d H:i:s') . "',ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id WHERE ProductionEntityID=" . $val['ProductionEntity'] . " AND Module_Id=" . $moduleId);
                                    $productionjob[0]['StatusId'] = $next_status_id;
									
                                    $productionjob[0]['StatusId'] = 'QC In Progress';
                                }
                            }
                            $productionjobNew = $productionjob[0];
                            $this->set('productionjob', $productionjob[0]);
                            $inputEntity = $productionjob[0]['InputEntityId'];
//                            $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity)->fetchAll('assoc');
                            $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity . ' AND Qc_Batch_Id IS NOT NULL')->fetchAll('assoc');
                            $QcBatchId = $BatchId[0]['Qc_Batch_Id'];
                            $ProdUserId = $BatchId[0]['UserId'];
                            $BatchName = $connection->execute('SELECT BatchName FROM MV_QC_BatchMaster WITH (NOLOCK) WHERE Id=' . $QcBatchId)->fetchAll('assoc');
                            $QcBatchName = $BatchName[0]['BatchName'];
                            $this->set('QcBatchName', $QcBatchName);
                            $this->set('ProdUserId', $ProdUserId);
                        }
                    } else {
						 $CheckStatus="Rework";

                       foreach ($Reworkjob as $val) {
                                if ($val['StatusId'] == $first_Status_id_rw && ($newJob == 'NewJob' || $newJob == 'newjob')) {
//                        $updateUserGroupId = $connection->execute("SELECT UserGroupId FROM MV_UserGroupMapping where Projectid=$ProjectId and RegionId=".$productionjob[0]['RegionId']." and UserId=$user_id and RecordStatus=1");
//                            foreach ($updateUserGroupId as $UserVal) {
//                               $userGpId = $UserVal['UserGroupId']; 
//                            }
//                        $inprogressjob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $next_status_id . ",UserId=" . $user_id . ",UserGroupId=" . $userGpId .",ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $productionjob[0]['ProductionEntity']);
                                    $ProjectId = $Reworkjob[0]['ProjectId'];
                                    $RegionId = $Reworkjob[0]['RegionId'];
                                    $InputEntityId = $Reworkjob[0]['InputEntityId'];

                            $QcIterationInsert = $connection->execute("INSERT INTO MV_QC_Iteration (ProjectId,RegionId,InputEntityId,QCUserId,QcStartDate,RecordStatus,CreatedDate,CreatedBy) values($ProjectId,$RegionId,$InputEntityId,$user_id,'" . date('Y-m-d H:i:s') . "',1,'" . date('Y-m-d H:i:s') . "',$user_id)");
                                    $productionCompletejob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $next_status_id_rw . ",UserId=" . $user_id . ",ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $val['ProductionEntity']);
                                    $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $next_status_id_rw . ",ProductionStartDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $val['ProductionEntity']);
                                    $productiontimemetricMain = $connection->execute("UPDATE MV_QC_TimeMetric SET StatusId=" . $next_status_id_rw . ",QCUSerID=" . $user_id . ",QCStartDate='" . date('Y-m-d H:i:s') . "',ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id WHERE ProductionEntityID=" . $val['ProductionEntity'] . " AND Module_Id=" . $moduleId);
                                    $Reworkjob[0]['StatusId'] = $next_status_id_rw;
                                    $Reworkjob[0]['StatusId'] = 'QC Rework In Progress';
                        }
                            }
                            $productionjobNew = $Reworkjob[0];
                            $this->set('productionjob', $Reworkjob[0]);
                            $inputEntity = $Reworkjob[0]['InputEntityId'];
//                            $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity)->fetchAll('assoc');
                        $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity . ' AND Qc_Batch_Id IS NOT NULL')->fetchAll('assoc');
                        $QcBatchId = $BatchId[0]['Qc_Batch_Id'];
                        $ProdUserId = $BatchId[0]['UserId'];
                        $BatchName = $connection->execute('SELECT BatchName FROM MV_QC_BatchMaster WITH (NOLOCK) WHERE Id=' . $QcBatchId)->fetchAll('assoc');
                        $QcBatchName = $BatchName[0]['BatchName'];
                        $this->set('QcBatchName', $QcBatchName);
                        $this->set('ProdUserId', $ProdUserId);
                    }
                } else {
                    //echo $next_status_id."-first,".$next_status_id_rw."-rework".$InprogressProductionjob[0]['StatusId'];exit;

                   
                    

                    $InputEntityId = $InprogressProductionjob[0]['InputEntityId'];
                    $productionjob = $connection->execute('SELECT * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE InputEntityId=' . $InputEntityId . ' AND SequenceNumber=1 AND ProjectId=' . $ProjectId . ' AND UserId= ' . $user_id)->fetchAll('assoc');
                    $this->set('getNewJOb', '');
                    $this->set('productionjob', $productionjob[0]);
                    $productionjobNew = $productionjob[0];
                    $inputEntity = $productionjob[0]['InputEntityId'];
                    $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity . ' AND Qc_Batch_Id IS NOT NULL')->fetchAll('assoc');
                    $QcBatchId = $BatchId[0]['Qc_Batch_Id'];
                    $ProdUserId = $BatchId[0]['UserId'];
                    $BatchName = $connection->execute('SELECT BatchName FROM MV_QC_BatchMaster WITH (NOLOCK) WHERE Id=' . $QcBatchId)->fetchAll('assoc');
                    $QcBatchName = $BatchName[0]['BatchName'];
                    $this->set('QcBatchName', $QcBatchName);
                    $this->set('ProdUserId', $ProdUserId);
                }
				
				 if($InprogressProductionjob[0]['StatusId']==$next_status_id_rw || $CheckStatus =="Rework" ){
                      $this->set('QCStatus_find', 'rework');
                      $this->set('QCrework_next_id', $next_status_id_rw);
                      $next_status_id= $next_status_id_rw;
                }else{
                      $this->set('QCStatus_find', 'inprogress');
                }

//            $InprogressProductionjob = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE StatusId=' . 4 . ' AND SequenceNumber=' . $page . ' AND ProjectId=' . $ProjectId . ' AND UserId= ' . $user_id)->fetchAll('assoc');
//            if (empty($InprogressProductionjob)) {
//                
//            $productionjob = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE StatusId=' . $first_Status_id . ' AND SequenceNumber=' . $page . ' AND ProjectId=' . $ProjectId)->fetchAll('assoc');
//                if (empty($productionjob)) {
//                    $this->set('NoNewJob', 'NoNewJob');
//                } else {
//                    if ($productionjob[0]['StatusId'] == $first_Status_id && ($newJob == 'NewJob' || $newJob == 'newjob')) {
////                        $updateUserGroupId = $connection->execute("SELECT UserGroupId FROM MV_UserGroupMapping where Projectid=$ProjectId and RegionId=".$productionjob[0]['RegionId']." and UserId=$user_id and RecordStatus=1");
////                            foreach ($updateUserGroupId as $UserVal) {
////                               $userGpId = $UserVal['UserGroupId']; 
////                            }
////                        $inprogressjob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $next_status_id . ",UserId=" . $user_id . ",UserGroupId=" . $userGpId .",ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $productionjob[0]['ProductionEntity']);
//                        $inprogressjob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $next_status_id . ",UserId=" . $user_id . ",ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $productionjob[0]['ProductionEntity']);
//                        $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $next_status_id . ",ProductionStartDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $productionjob[0]['ProductionEntity']);
//                        $productiontimemetricMain = $connection->execute("UPDATE ME_Production_TimeMetric SET StatusId=" . $next_status_id . ",UserId=" . $user_id . ",Start_Date='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntityID=" . $productionjob[0]['ProductionEntity'] . " AND Module_Id=" . $moduleId);
//                        $productionjob[0]['StatusId'] = $next_status_id;
//                        $productionjob[0]['StatusId'] = 'Production In Progress';
//                    }
//                    $productionjobNew = $productionjob[0];
//                    $this->set('productionjob', $productionjob[0]);
//                }
//            } else {
//                $this->set('getNewJOb', '');
//                $this->set('productionjob', $InprogressProductionjob[0]);
//                $productionjobNew = $InprogressProductionjob[0];
//            }
            $RegionId = $productionjobNew['RegionId'];
            $module = $JsonArray['Module'];
            $module = array_keys($module);
        
           $ProductionFields = array();
           $StaticFields = array();
           foreach ($module as $key => $value) {
   $StaticFieldsarr = $JsonArray['ModuleAttributes'][$RegionId][$value]['static'];   
   $ProductionFieldsarr = $JsonArray['ModuleAttributes'][$RegionId][$value]['production'];  
   if(!empty($ProductionFieldsarr))
    $ProductionFields = array_merge($ProductionFields,$ProductionFieldsarr);
    if(!empty($StaticFieldsarr))
    $StaticFields = array_merge($StaticFields,$StaticFieldsarr);
 }
            $AttributeGroupMaster = $JsonArray['AttributeGroupMasterDirect'];
         //   $AttributeGroupMaster = $AttributeGroupMaster[$moduleId];

            $groupwisearray = array();
            $subgroupwisearray = array();
            foreach ($AttributeGroupMaster as $key => $value) {
                $groupwisearray[$key] = $value;
                $keys = array_map(function($v) use ($key, $emparr) {
                    if ($v['MainGroupId'] == $key) {
                        return $v;
                    }
                }, $ProductionFields);
                $keys_sub = $this->combineBySubGroup($keys);
                $groupwisearray[$key] = $keys_sub;
            }
            $n = 0;
            $firstValue = array();
            foreach ($AttributeGroupMaster as $key => $value) {
                foreach ($groupwisearray[$key] as $keysub => $valuesSub) {
                    $firstValue[$n] = $valuesSub[0];
                    $n++;
                }
            }
            $FirstAttribute = $firstValue[0];

            $this->set('AttributeGroupMaster', $AttributeGroupMaster);
            $this->set('AttributesListGroupWise', $groupwisearray);
            $this->set('AttributeSubGroupMasterJSON', $JsonArray['AttributeSubGroupMaster']);

            $this->set('FirstAttrId', $FirstAttribute['AttributeMasterId']);
            $this->set('FirstProjAttrId', $FirstAttribute['ProjectAttributeMasterId']);
            $this->set('FirstGroupId', $FirstAttribute['MainGroupId']);
            $this->set('FirstSubGroupId', $FirstAttribute['SubGroupId']);
			$this->set('ModuleAttributes', $ProductionFieldsarr);

                         $RegionId = $productionjobNew['RegionId'];
            $module = $JsonArray['Module'];
            $module = array_keys($module);
        
           $StaticFields = array();
           foreach ($module as $key => $value) {
          
   $StaticFieldssarr = $JsonArray['ModuleAttributes'][$RegionId][$value]['static'];  
   if(!empty($StaticFieldssarr))
    $StaticFields = array_merge($StaticFields,$StaticFieldssarr);
 }
 
          //  $StaticFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['static'];
            $DynamicFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['dynamic'];
       //     $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
            $ReadOnlyFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['readonly'];

            $this->set('StaticFields', $StaticFields);
            $this->set('DynamicFields', $DynamicFields);

            $tempFileds = '';
            foreach ($ProductionFields as $val) {
                $tempFileds.="[" . $val['AttributeMasterId'] . "],";
            }
            foreach ($DynamicFields as $val) {
                $tempFileds.="[" . $val['AttributeMasterId'] . "],";
            }
            foreach ($StaticFields as $val) {
                $tempFileds.="[" . $val['AttributeMasterId'] . "],";
            }

            $tempFileds = '';
            foreach ($groupwisearray as $value) {
                foreach ($value as $valu) {
                    foreach ($valu as $val) {
                        $tempFileds.="[" . $val['AttributeMasterId'] . "],";
                    }
                }
            }

            if (isset($productionjobNew)) {
                $DependentMasterIdsQuery = $connection->execute('SELECT Id,Type FROM MC_DependencyTypeMaster where ProjectId=' . $ProjectId . ' AND DisplayInProdScreen=1')->fetchAll('assoc');
                $DependentMasterIds = array();
                foreach ($DependentMasterIdsQuery as $vals) {
                    $DependentMasterIds[$vals['Type']] = $vals['Id'];
                }

                $InputEntityId = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE StatusId=' . $next_status_id . ' AND SequenceNumber=' . $page . ' AND ProjectId=' . $ProjectId . ' AND UserId= ' . $user_id)->fetchAll('assoc');
                $DependencyTypeMaster = $connection->execute("SELECT Id,Type,FieldTypeName FROM MC_DependencyTypeMaster WHERE ProjectId=" . $ProjectId . " AND (DisplayInProdScreen=1 or FieldTypeName='General') AND RecordStatus=1")->fetchAll('assoc');
				foreach ($DependencyTypeMaster as $vals) {
					if($vals['DisplayInProdScreen']==1)
						$DependentMasterIds[$vals['Type']] = $vals['Id'];
					
					if($vals['Type']=="InputValue")
						$staticDepenIds[] = $vals['Id'];
					
					if($vals['FieldTypeName']=="General")
						$staticDepenIds[] = $vals['Id'];
                }
				
                if (!empty($InputEntityId)) {
                    $CengageProcessInputData = $connection->execute('SELECT * FROM MC_CengageProcessInputData where ProjectId=' . $ProjectId . ' AND InputEntityId=' . $InputEntityId[0]['InputEntityId'] . ' AND DependencyTypeMasterId IN (' . implode(',', $DependentMasterIds) . ')')->fetchAll('assoc');
                        $staticFields = array();
                    foreach ($StaticFields as $key => $value) {
                        $getDomainIdVal = $connection->execute('SELECT AttributeValue FROM MC_CengageProcessInputData where ProjectId=' . $ProjectId . ' AND InputEntityId=' . $InputEntityId[0]['InputEntityId'] . ' AND AttributeMasterId IN (' . $value['AttributeMasterId'] . ') AND DependencyTypeMasterId in ('.implode(',',$staticDepenIds).')')->fetchAll('assoc');
						
                        $staticFields = array_merge($staticFields,$getDomainIdVal);
						
                        }
//                    if ($domainUrl) {
//                        $getDomainUrlVal = $connection->execute('SELECT * FROM MC_CengageProcessInputData where ProjectId=' . $ProjectId . ' AND InputEntityId=' . $InputEntityId[0]['InputEntityId'] . ' AND AttributeMasterId IN (' . $domainUrl . ') AND ID=355729')->fetchAll('assoc');
//                    }
                }
 
                $DependencyTypeMaster = $connection->execute("SELECT Id,Type,FieldTypeName FROM MC_DependencyTypeMaster WHERE ProjectId=" . $ProjectId . " AND DisplayInProdScreen=1 AND Type='InputValue' AND RecordStatus=1")->fetchAll('assoc');
                $DependancyId = $DependencyTypeMaster[0]['Id'];
                if (!empty($InputEntityId)) {
//                    echo 'SELECT * FROM MC_CengageProcessInputData where ProjectId=' . $ProjectId . ' AND InputEntityId=' . $InputEntityId[0]['InputEntityId'] . ' AND AttributeMasterId IN (' . $domainUrl . ') AND DependencyTypeMasterId = '.$DependancyId.' AND AttributeSubGroupId=0';
                    $getDomainUrlVal = $connection->execute('SELECT * FROM MC_CengageProcessInputData where ProjectId=' . $ProjectId . ' AND InputEntityId=' . $InputEntityId[0]['InputEntityId'] . ' AND AttributeMasterId IN (' . $domainUrl . ') AND DependencyTypeMasterId = '.$DependancyId.' AND SequenceNumber=1')->fetchAll('assoc');
                    }
                
                $SelDomainUrl = $getDomainUrlVal[0]['AttributeValue'];

                $html = strpos($SelDomainUrl, '.html');
                if (empty($html)){
                    $pos = strpos($SelDomainUrl, 'http');
                    if ($pos === false) {
                        $SelDomainUrl = "http://" . $SelDomainUrl;
                }
                }else{
                    $SelDomainUrl = "";
                }

                $finalprodValue = array();
                foreach ($CengageProcessInputData as $key => $value) {
                    ////qc comment status find/////////////////////
                   // pr($value);
                     $QcCommentVal = $connection->execute('SELECT * FROM MV_QC_Comments where ProjectId=' . $ProjectId . ' AND InputEntityId=' . $InputEntityId[0]['InputEntityId'] . ' AND AttributeMasterId='.$value['AttributeMasterId'].' AND SequenceNumber='.$value['SequenceNumber'].' and ModuleId='.$moduleId )->fetchAll('assoc');
                    if(!empty($QcCommentVal)){
                       $qc_status= $QcCommentVal[0]['StatusId'];
                    }
                    else{
                        $qc_status='';
                    }
                     $finalprodValue[$value['AttributeMasterId']][$value['SequenceNumber']]['qccomment_status'] = $qc_status;
                     $finalprodValue[$value['AttributeMasterId']][$value['SequenceNumber']]['qccomment_id'] = $QcCommentVal[0]['Id'];
                     $finalprodValue[$value['AttributeMasterId']][$value['SequenceNumber']]['qccomment_errorcat'] = $QcCommentVal[0]['ErrorCategoryMasterId'];
                     $finalprodValue[$value['AttributeMasterId']][$value['SequenceNumber']]['qccomment_errorsub'] = $QcCommentVal[0]['SubErrorCategoryMasterId'];
                
                    ////qc comment status find end/////////////////////
                    
                    
                    $finalprodValue[$value['AttributeMasterId']][$value['SequenceNumber']][$value['DependencyTypeMasterId']] = [$value['AttributeValue']];
                }
                foreach ($groupwisearray as $key => $subGrp) {
                    foreach ($subGrp as $key2 => $subGrpAtt) {
                        foreach ($subGrpAtt as $key3 => $subGrpAtt3) {
                            $arryKeys = array_keys($finalprodValue[$subGrpAtt3['AttributeMasterId']]);
                            if (max($arryKeys) > $oldone)
                                $finalGrpprodValue[$key2]['MaxSeq'] = max($arryKeys);
                             $oldone = max($arryKeys);
                        }
                    }
                }
//                foreach ($getDomainIdVal as $key => $value) {
//                    $FDRID = $value['AttributeValue'];
//                }
           
                $this->set('DependentMasterIds', $DependentMasterIds);
                $this->set('processinputdata', $finalprodValue);
                $this->set('GrpSercntArr', $finalGrpprodValue);
               // $this->set('FDRID', $FDRID);
                $this->set('staticFields', $staticFields);
                $this->set('getDomainUrl', $SelDomainUrl);

                //$DomainIdName = $productionjobNew[$domainId];
                $TimeTaken = $productionjobNew['TimeTaken'];
                $InputEntityId = $productionjobNew['InputEntityId'];
                $this->set('TimeTaken', $TimeTaken);
                $this->set('InputEntityId', $InputEntityId);

                $QueryDetails = array();
                $QueryDetails = $connection->execute("SELECT TLComments,Query,StatusID FROM ME_QcUserQuery WITH (NOLOCK) WHERE   ProductionEntityId=" . $productionjobNew['ProductionEntity'])->fetchAll('assoc');
                $this->set('QueryDetails', $QueryDetails[0]);

                $HelpContantDetails = array();
                $HelpContantDetails = $connection->execute("SELECT Id,AttributeMasterId FROM MC_CengageHelp WHERE ProjectId = " . $ProjectId . " AND RegionId = " . $RegionId . " AND RecordStatus=1")->fetchAll('assoc');

                foreach ($HelpContantDetails as $HelpContantId):
                    $HelpContId[] = $HelpContantId['AttributeMasterId'];
                endforeach;
                $this->set('HelpContantDetails', $HelpContId);
            }
            
           $InputEntityId = $InprogressProductionjob[0]['InputEntityId'];
            if (empty($InprogressProductionjob)) {
                $InputEntityId = $productionjob[0]['InputEntityId'];
            }
            
            $productionjobId = $this->request->data['ProductionId'];
            $ProductionEntity = $this->request->data['ProductionEntityID'];
            $productionjobStatusId = $this->request->data['StatusId'];
         // pr($this->request->data); exit;
            if (isset($this->request->data['Submit'])) {
                 //exit;
            //////rework check/////////////////////////////
            /*if($this->request->data['getreworkjob'] =="rework"){
                
                $cnt_InputEntity = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE ProjectId=" . $ProjectId . " AND  InputEntityId='" . $InputEntityId . "' AND StatusId=6")->fetchAll('assoc');
               if($cnt_InputEntity[0]['cnt'] > 0){

               }
               else{

               }
            }*/
            //////rework check end/////////////////////////////
                
               
                if (count($DynamicFields) > 1) {
                    foreach ($DynamicFields as $val) {
                        $dymamicupdatetempFileds.="[" . $val['AttributeMasterId'] . "]='" . $this->request->data[$val['AttributeMasterId']] . "',";
                    }
                    $dymamicupdatetempFileds.="TimeTaken='" . $this->request->data['TimeTaken'] . "'";
                    $Dynamicproductionjob = $connection->execute('UPDATE ' . $stagingTable . ' SET ' . $dymamicupdatetempFileds . 'where ProductionEntity=' . $ProductionEntity);
                }
                $cnt_InputEntity = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE ProjectId=" . $ProjectId . " AND  InputEntityId='" . $InputEntityId . "' AND ModuleId=$moduleId")->fetchAll('assoc');
				//echo "SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID in (1,9) AND ProjectId=" . $ProjectId . " AND  InputEntityId='" . $InputEntityId . "'";
				
                $cnt_InputEntity_QcError = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID in (1,9) AND ProjectId=" . $ProjectId . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');
//pr($cnt_InputEntity_QcError);
                $cnt_InputEntity_TLAcceptError = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=8 AND ProjectId=" . $ProjectId . " AND UserId=" . $user_id . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');
                
                $cnt_InputEntity_TLRejectError = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=9 AND ProjectId=" . $ProjectId . " AND UserId=" . $user_id . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

                
                $cnt_InputEntity_QcError_Deleted = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=0 AND RecordStatus =1 AND ProjectId=" . $ProjectId . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

               // $cnt_InputEntity_TL_rebutall = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=7 AND RecordStatus =1 AND ProjectId=" . $ProjectId . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

                if ($cnt_InputEntity[0]['cnt'] != 0) {

                    if ($cnt_InputEntity_QcError[0]['cnt'] != 0) {
                        $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id_org][1];
                        $QcStatusId = 1;
                        $submitType = 'completed';
						
                    } 
					else if ($cnt_InputEntity_TLAcceptError[0]['cnt'] != 0) {
                            $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id_org][2][1]; //QC completed - QC Accept all
                            $QcStatusId = 8;
                        }
					else if ($cnt_InputEntity_QcError_Deleted[0]['cnt'] != 0) {
							$completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id_org][2][1];
                            $QcStatusId = 7;
                            $submitType = 'completed';
                        
                    }
                } else {
                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id_org][2][1];
                    $QcStatusId = 0;
                    $submitType = 'completed';
					///qc complete////
                    $QCcompletequery = $connection->execute("SELECT Qc_Batch_Id FROM ME_Production_TimeMetric where InputEntityId='".$InputEntityId."'")->fetchAll('assoc');
                    $QCBatchId=$QCcompletequery[0]['Qc_Batch_Id'];         
                    $connection->execute("UPDATE MV_QC_BatchMaster SET QCCompletedCount = QCCompletedCount + 1 where Id='".$QCBatchId."'");
                    /////end///////// 
                }
				//echo $completion_status;
				//exit;
                
                
                if ($completion_status != '') {
                   // $QcIterationUpdate = $connection->execute("UPDATE MV_QC_Iteration SET QcEndDate='" . date('Y-m-d H:i:s') . "',TimeTaken='" . $this->request->data['TimeTaken'] . "',ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id WHERE CreatedDate IN (select MAX (createddate)from MV_QC_Iteration) and InputEntityId=" . $InputEntityId);
                    $productionCompletejob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $completion_status . ",ActEnddate='" . date('Y-m-d H:i:s') . "' ,TimeTaken='" . $this->request->data['TimeTaken'] . "' WHERE ProductionEntity=" . $ProductionEntity);
                    $productionjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $completion_status . ",ProductionEndDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $ProductionEntity);
                    $productiontimemetricMain = $connection->execute("UPDATE MV_QC_TimeMetric SET StatusId=" . $completion_status . ",QcStatusId=" . $QcStatusId . ",QCEndDate='" . date('Y-m-d H:i:s') . "',QCTimeTaken='" . $this->request->data['TimeTaken'] . "' WHERE ProductionEntityID=" . $ProductionEntity . " AND Module_Id=" . $moduleId);
                    if(count($cnt_InputEntity_TLRejectError[0]['cnt'])>0){
                        
                    $moduleId=$connection->execute("SELECT ModuleId FROM ME_Module_Level_Config where Project=3346 and Modulegroup=1")->fetchAll('assoc');    
					//pr($moduleId);
                    $table='Staging_'.$moduleId[0]['ModuleId'].'_Data';
                    $productionjob = $connection->execute("UPDATE $table SET StatusId=" . $completion_status . " WHERE ProductionEntity=" . $ProductionEntity);    
                    }
                    $this->redirect(array('controller' => 'QCValidation', 'action' => '', '?' => array('job' => $submitType)));
                    return $this->redirect(['action' => 'index']);
                    return $this->redirect(['action' => 'index']);
                }
            }
//            $productionjobId = $this->request->data['ProductionId'];
//            $ProductionEntity = $this->request->data['ProductionEntityID'];
//            $productionjobStatusId = $this->request->data['StatusId'];
//
//            if (isset($this->request->data['Submit'])) {
//                $queryStatus = $connection->execute("SELECT count(1) as cnt FROM ME_UserQuery WITH (NOLOCK) WHERE  StatusID=1 AND ProjectId=" . $ProjectId . " AND  ProductionEntityId='" . $productionjobNew['ProductionEntity'] . "'")->fetchAll('assoc');
//
//                if ($queryStatus[0]['cnt'] > 0) {
////                    $completion_status = $queryStatusId;
//                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][2][1];
//                    $submitType = 'query';
//                } else {
//                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][1];
//                    $submitType = 'completed';
//                }
//
//                //$Dynamicproductionjob = $connection->execute("UPDATE  $stagingTable  SET TimeTaken='" . $this->request->data['TimeTaken'] . "' where ProductionEntity= ".$ProductionEntity);
//                $productionCompletejob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $completion_status . ",ActEnddate='" . date('Y-m-d H:i:s') . "',TimeTaken='" . $this->request->data['TimeTaken'] . "' WHERE ProductionEntity=" . $ProductionEntity);
//                $productionjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $completion_status . ",ProductionEndDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $ProductionEntity);
//                $productiontimemetricMain = $connection->execute("UPDATE ME_Production_TimeMetric SET StatusId=" . $completion_status . ",End_Date='" . date('Y-m-d H:i:s') . "',TimeTaken='" . $this->request->data['TimeTaken'] . "' WHERE ProductionEntityID=" . $ProductionEntity . " AND Module_Id=" . $moduleId);
//                $this->redirect(array('controller' => 'Getjobcore', 'action' => '', '?' => array('job' => $submitType)));
//                return $this->redirect(['action' => 'index']);
//            }

            if (empty($InprogressProductionjob) && $this->request->data['NewJob'] != 'NewJob' && !isset($this->request->data['Submit']) && $this->request->query['job'] != 'newjob') {
                $this->set('getNewJOb', 'getNewJOb');
            } else {
                $this->set('getNewJOb', '');
            }

            foreach ($DynamicFields as $key => $val) {
                $validationRules = $JsonArray['ValidationRules'][$val['ProjectAttributeMasterId']];
                $IsAlphabet = $validationRules['IsAlphabet'];
                $IsNumeric = $validationRules['IsNumeric'];
                $IsEmail = $validationRules['IsEmail'];
                $IsUrl = $validationRules['IsUrl'];
                $IsSpecialCharacter = $validationRules['IsSpecialCharacter'];
                $AllowedCharacter = addslashes($validationRules['AllowedCharacter']);
                $NotAllowedCharacter = addslashes($validationRules['NotAllowedCharacter']);
                $Format = $validationRules['Format'];
                $IsUrl = $validationRules['IsUrl'];
                $IsMandatory = $validationRules['IsMandatory'];
                $IsDate = $validationRules['IsDate'];
                $IsDecimal = $validationRules['IsDecimal'];

                $IsAutoSuggesstion = $validationRules['IsAutoSuggesstion'];
                $IsAllowNewValues = $validationRules['IsAllowNewValues'];

                $Dateformat = $validationRules['Dateformat'];
                SWITCH (TRUE) {
                    CASE($IsUrl == 1):
                        $FunctionName = 'UrlOnly';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 0 && $IsSpecialCharacter == 0):
                        $FunctionName = 'AlphabetOnly';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 1 && $IsSpecialCharacter == 0):
                        $FunctionName = 'AlphaNumericOnly';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 1 && $IsSpecialCharacter == 1):
                        $FunctionName = 'AlphaNumericSpecial';
                        $param = 'Yes';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 0 && $IsSpecialCharacter == 1):
                        $FunctionName = 'AlphabetSpecialonly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 1 && $IsSpecialCharacter == 1):
                        $FunctionName = 'NumericSpecialOnly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 0 && $IsSpecialCharacter == 0 && $IsEmail == 1 ):
                        $FunctionName = 'EmailOnly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 1 && $IsSpecialCharacter == 0 && $IsEmail == 0 ):
                        $FunctionName = 'NumbersOnly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 0 && $IsSpecialCharacter == 0 && $IsEmail == 0 && $IsUrl == 1):
                        $FunctionName = 'UrlOnly';
                        BREAK;
                    CASE($IsDate == 1):
                        $FunctionName = 'isDate';
                        BREAK;
                    CASE($IsDecimal == 1):
                        $FunctionName = 'checkDecimal';
                        BREAK;
                    DEFAULT:
                        $FunctionName = '';
                        BREAK;
                }
                if ($IsMandatory == 1) {
                    $Mandatory[] = $val['AttributeMasterId'];
                }
                if ($IsAutoSuggesstion == 1) {
                    $AutoSuggesstion[] = $val['AttributeMasterId'];
                }

                if ($val['ControlName'] == 'DropDownList' && $IsAutoSuggesstion == 1) {
                    $DynamicFields[$key]['ControlName'] = 'Auto';
                    if ($IsAllowNewValues != 0) {

                        $DynamicFields[$key]['IsAllowNewValues'] = 'datacheck(this.id,this.value)';
                    }
                    $DynamicFields[$key]['IsAllowNewValues'] = $IsAllowNewValues;
                }
                $DynamicFields[$key]['MinLength'] = $validationRules['MinLength'];
                $DynamicFields[$key]['MaxLength'] = $validationRules['MaxLength'];
                $DynamicFields[$key]['FunctionName'] = $FunctionName;
                $DynamicFields[$key]['Mandatory'] = $Mandatory;
                $DynamicFields[$key]['AllowedCharacter'] = $AllowedCharacter;
                $DynamicFields[$key]['NotAllowedCharacter'] = $NotAllowedCharacter;
                $DynamicFields[$key]['Format'] = $Format;
                $DynamicFields[$key]['Dateformat'] = $Dateformat;
                $DynamicFields[$key]['AllowedDecimalPoint'] = $validationRules['AllowedDecimalPoint'];
                $DynamicFields[$key]['Options'] = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$val['ProjectAttributeMasterId']]['Options'];
                $DynamicFields[$key]['Mapping'] = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$val['ProjectAttributeMasterId']]['Mapping'];
                if ($DynamicFields[$key]['Mapping']) {
                    $to_be_filled = array_keys($DynamicFields[$key]['Mapping']);
                    $against = $to_be_filled[0];
                    $DynamicFields[$key]['Reload'] = 'LoadValue(' . $val['ProjectAttributeMasterId'] . ',this.value,' . $against . ');';
                }
            }
            $manKey = 0;
            $j = 0;
            foreach ($ProductionFields as $key => $val) {
                $validationRules = $JsonArray['ValidationRules'][$val['ProjectAttributeMasterId']];
                $IsAlphabet = $validationRules['IsAlphabet'];
                $IsNumeric = $validationRules['IsNumeric'];
                $IsEmail = $validationRules['IsEmail'];
                $IsUrl = $validationRules['IsUrl'];
                $IsSpecialCharacter = $validationRules['IsSpecialCharacter'];
                $AllowedCharacter = addslashes($validationRules['AllowedCharacter']);
                $NotAllowedCharacter = addslashes($validationRules['NotAllowedCharacter']);
                $Format = $validationRules['Format'];
                $IsUrl = $validationRules['IsUrl'];
                $IsMandatory = $validationRules['IsMandatory'];
                $IsDate = $validationRules['IsDate'];
                $IsDecimal = $validationRules['IsDecimal'];

                $IsAutoSuggesstion = $validationRules['IsAutoSuggesstion'];
                $IsAllowNewValues = $validationRules['IsAllowNewValues'];

                $Dateformat = $validationRules['Dateformat'];
                SWITCH (TRUE) {
                    CASE($IsUrl == 1):
                        $FunctionName = 'UrlOnly';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 0 && $IsSpecialCharacter == 0):
                        $FunctionName = 'AlphabetOnly';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 1 && $IsSpecialCharacter == 0):
                        $FunctionName = 'AlphaNumericOnly';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 1 && $IsSpecialCharacter == 1):
                        $FunctionName = 'AlphaNumericSpecial';
                        $param = 'Yes';
                        BREAK;
                    CASE($IsAlphabet == 1 && $IsNumeric == 0 && $IsSpecialCharacter == 1):
                        $FunctionName = 'AlphabetSpecialonly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 1 && $IsSpecialCharacter == 1):
                        $FunctionName = 'NumericSpecialOnly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 0 && $IsSpecialCharacter == 0 && $IsEmail == 1 ):
                        $FunctionName = 'EmailOnly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 1 && $IsSpecialCharacter == 0 && $IsEmail == 0 ):
                        $FunctionName = 'NumbersOnly';
                        BREAK;
                    CASE($IsAlphabet == 0 && $IsNumeric == 0 && $IsSpecialCharacter == 0 && $IsEmail == 0 && $IsUrl == 1):
                        $FunctionName = 'UrlOnly';
                        BREAK;
                    CASE($IsDate == 1):
                        $FunctionName = 'isDate';
                        BREAK;
                    CASE($IsDecimal == 1):
                        $FunctionName = 'checkDecimal';
                        BREAK;
                    DEFAULT:
                        $FunctionName = '';
                        BREAK;
                }
                if ($IsMandatory == 1) {
                    $Mandatory[$manKey]['AttributeMasterId'] = $val['AttributeMasterId'];
                    $Mandatory[$manKey]['DisplayAttributeName'] = $val['DisplayAttributeName'];
                    $manKey++;
                }
                if ($IsAutoSuggesstion == 1) {
                    $AutoSuggesstion[] = $val['AttributeMasterId'];
                }

                if ($val['ControlName'] == 'DropDownList' && $IsAutoSuggesstion == 1) {
                    $ProductionFields[$key]['ControlName'] = 'Auto';
                    if ($IsAllowNewValues != 0) {

                        $ProductionFields[$key]['IsAllowNewValues'] = 'datacheck(this.id,this.value)';
                    }
                    $ProductionFields[$key]['IsAllowNewValues'] = $IsAllowNewValues;
                }
                $ProductionFields[$key]['MinLength'] = $validationRules['MinLength'];
                $ProductionFields[$key]['MaxLength'] = $validationRules['MaxLength'];
                $ProductionFields[$key]['FunctionName'] = $FunctionName;
                $ProductionFields[$key]['Mandatory'] = $Mandatory;
                $ProductionFields[$key]['AllowedCharacter'] = $AllowedCharacter;
                $ProductionFields[$key]['NotAllowedCharacter'] = $NotAllowedCharacter;
                $ProductionFields[$key]['Format'] = $Format;
                $ProductionFields[$key]['Dateformat'] = $Dateformat;
                $ProductionFields[$key]['AllowedDecimalPoint'] = $validationRules['AllowedDecimalPoint'];
                $ProductionFields[$key]['Options'] = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$val['ProjectAttributeMasterId']]['Options'];
                $ProductionFields[$key]['Mapping'] = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$val['ProjectAttributeMasterId']]['Mapping'];
                if ($ProductionFields[$key]['Mapping']) {
                    $to_be_filled = array_keys($ProductionFields[$key]['Mapping']);
                    $against = $to_be_filled[0];
                    $against_org = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$against]['AttributeId'];
                    $ProductionFields[$key]['Reload'] = 'LoadValue(' . $val['ProjectAttributeMasterId'] . ',this.value,' . $against_org . ');';
                }
          
                    $OldDataresultError[$ProductionFields[$key]['AttributeMasterId']]['seq'] = $this->QCValidation->ajax_GetOldDatavalue_seq($productionjobNew['InputEntityId'], $ProductionFields[$key]['AttributeMasterId'], $ProductionFields[$key]['ProjectAttributeMasterId'], 1,$moduleId);
             $OldDataresultRebutal[$ProductionFields[$key]['AttributeMasterId']]['seq'] = $this->QCValidation->ajax_GetRebutalvalue($productionjobNew['InputEntityId'], $ProductionFields[$key]['AttributeMasterId'], $ProductionFields[$key]['ProjectAttributeMasterId'], 1,$moduleId);
			 
			  $QcErrorComments[$ProductionFields[$key]['AttributeMasterId']]['seq'] = $this->QCValidation->ajax_GetQcComments_seq($productionjobNew['InputEntityId'], $ProductionFields[$key]['AttributeMasterId'], $ProductionFields[$key]['ProjectAttributeMasterId'], 1,$moduleId);
//             if (empty($InprogressProductionjob)) {
//                    //     print_r($productionjob);
//					if($productionjob[0]['InputEntityId']){
//                    $OldDataresultError[$ProductionFields[$key]['AttributeMasterId']] = $this->QCValidation->ajax_GetOldDatavalue($productionjob[0]['InputEntityId'], $ProductionFields[$key]['AttributeMasterId'], $ProductionFields[$key]['ProjectAttributeMasterId'], 1);
//                    $OldDataresultRebutal[$ProductionFields[$key]['AttributeMasterId']] = $this->QCValidation->ajax_GetRebutalvalue($productionjob[0]['InputEntityId'], $ProductionFields[$key]['AttributeMasterId'], $ProductionFields[$key]['ProjectAttributeMasterId'], 1);
//					}
//                } else {
//                    //   print_r($InprogressProductionjob);
//                    $OldDataresultError[$ProductionFields[$key]['AttributeMasterId']] = $this->QCValidation->ajax_GetOldDatavalue($InprogressProductionjob[0]['InputEntityId'], $ProductionFields[$key]['AttributeMasterId'], $ProductionFields[$key]['ProjectAttributeMasterId'], 1);
//                    $OldDataresultRebutal[$ProductionFields[$key]['AttributeMasterId']] = $this->QCValidation->ajax_GetRebutalvalue($InprogressProductionjob[0]['InputEntityId'], $ProductionFields[$key]['AttributeMasterId'], $ProductionFields[$key]['ProjectAttributeMasterId'], 1);
//                }
                $j++;
            }
			//pr($OldDataresultError);
            $this->set('QcErrorComments', $QcErrorComments);
            $this->set('OldDataresultError', $OldDataresultError);
            $this->set('OldDataresultRebutal', $OldDataresultRebutal);
         
            $this->set('ProductionFields', $ProductionFields);
            $this->set('DynamicFields', $DynamicFields);
            $this->set('Mandatory', $Mandatory);
            $this->set('AutoSuggesstion', $AutoSuggesstion);
            $this->set('ReadOnlyFields', $ReadOnlyFields);
            $this->set('session', $session);
            $dynamicData = $SequenceNumber[0];
            $this->set('dynamicData', $dynamicData);
        }
    }
function ajaxgetafterreferenceurl() {
        $connection = ConnectionManager::get('default');
        $AttrId = $_POST['Attr'];
        $ProjAttrId = $_POST['ProjAttr'];
        $MainGrpId = $_POST['MainGrp'];
        $SubGrpId = $_POST['SubGrp'];
        $Seq = $_POST['seq'];

        $ProjectId = $_POST['ProjectId'];
        $RegionId = $_POST['RegionId'];
        $InputEntityId = $_POST['InputEntityId'];
        $ProdEntityId = $_POST['ProdEntityId'];

        $RefURL = AfterRefURL;
        $RefUrlID = $connection->execute("Select Id from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=".$ProjectId)->fetchAll('assoc');
        $multipleAttrVal = $connection->execute("Select Id,AttributeValue,count (AttributeValue) as attrcnt from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and AttributeMasterId = " . $AttrId . " and ProjectAttributeMasterId = " . $ProjAttrId . " and AttributeMainGroupId = " . $MainGrpId . " and AttributeSubGroupId = " . $SubGrpId . " and SequenceNumber = " . $Seq . " and RecordDeleted <> 1 and AttributeValue <> '' GROUP by AttributeValue,Id Order by attrcnt desc")->fetchAll('assoc');

        $getData['attrval'] = $multipleAttrVal;
        $getData['attrinitiallink'] = $multipleAttrVal[0]['AttributeValue'];
       
        $sameUrl = $getData['attrinitiallink'];
        if ($sameUrl != '') {
            $sameIdlink = $connection->execute("Select AttributeMainGroupId, count(Id) as cnt from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and AttributeValue = '$sameUrl' and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and RecordDeleted <> 1 group by AttributeMainGroupId")->fetchAll('assoc');
        }
        $getData['attrcnt'] = $sameIdlink;

        echo json_encode($getData);
        exit;
    }

    function ajaxLoadfirstattribute() {
        $connection = ConnectionManager::get('default');
        $groupId = $_POST['groupId'];

        $ProjectId = $_POST['ProjectId'];
        $RegionId = $_POST['RegionId'];
        $InputEntityId = $_POST['InputEntityId'];
        $ProdEntityId = $_POST['ProdEntityId'];
        $Seq = $_POST['seq'];

        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $AttributeGroupMaster = $JsonArray['AttributeGroupMasterDirect'];
        $GroupVal = array();
        foreach($AttributeGroupMaster as $key => $val){

        $RefURL = AfterRefURL;
        $RefUrlID = $connection->execute("Select Id from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=".$ProjectId)->fetchAll('assoc');
        $multipleAttrVal = $connection->execute("Select AttributeValue, count (AttributeValue) as attrcnt,HtmlFileName from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and AttributeMainGroupId = " . $key . " and RecordDeleted <> 1 and AttributeValue <> '' GROUP by HtmlFileName,AttributeValue Order by attrcnt desc")->fetchAll('assoc');

        $GroupVal = array_merge($GroupVal,$multipleAttrVal);
        
         }   
       $getData['attrval'] = $GroupVal;
       $getData['attrinitiallink'] = $GroupVal[0]['AttributeValue'];
       $getData['attrinitialhtml'] = $GroupVal[0]['HtmlFileName'];
           
            
        $sameUrl = $getData['attrinitiallink'];
        //if ($sameUrl != '') {
            $sameIdlink = $connection->execute("Select AttributeMainGroupId, count(Id) as cnt from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and AttributeValue = '$sameUrl' and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and RecordDeleted <> 1 group by AttributeMainGroupId")->fetchAll('assoc');
            //echo "Select AttributeMainGroupId, count(Id) as cnt from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and AttributeValue = '$sameUrl' and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and SequenceNumber = " . $Seq . " and RecordDeleted <> 1 group by AttributeMainGroupId";
        //}
        $getData['attrcnt'] = $sameIdlink;

        if (!empty($GroupVal)) {
        echo json_encode($getData);
        }
        exit;
    }

    function ajaxdeletereferenceurl() {
        $connection = ConnectionManager::get('default');
        $AttrId = $_POST['Attr'];
        $ProjAttrId = $_POST['ProjAttr'];
        $MainGrpId = $_POST['MainGrp'];
        $SubGrpId = $_POST['SubGrp'];
        $Seq = $_POST['Seq'];

        $ProjectId = $_POST['ProjectId'];
        $RegionId = $_POST['RegionId'];
        $InputEntityId = $_POST['InputEntityId'];
        $ProdEntityId = $_POST['ProdEntityId'];

        $Id = $_POST['Id'];
        $DeleteUrl = $connection->execute("Update MC_CengageProcessInputData set RecordDeleted = 1 where Id = " . $Id . " and ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and AttributeMasterId = " . $AttrId . " and ProjectAttributeMasterId = " . $ProjAttrId . " and AttributeMainGroupId = " . $MainGrpId . " and SequenceNumber = " . $Seq . " and AttributeSubGroupId = " . $SubGrpId);
        echo "Deleted";
        exit;
    }

    function ajaxgetgroupurl() {
        $connection = ConnectionManager::get('default');


        $ProjectId = $_POST['ProjectId'];
        $RegionId = $_POST['RegionId'];
        $InputEntityId = $_POST['InputEntityId'];
        $ProdEntityId = $_POST['ProdEntityId'];
        
         $AttrGroup = $_POST['AttrGroup'];
        $AttrSubGroup = $_POST['AttrSubGroup'];
        $AttrId = $_POST['AttrId'];
        $Seq = $_POST['seq'];
        $ProjAttrId = $_POST['ProjAttrId'];
       if($AttrId != ''){
        $RefURL = AfterRefURL;
        $RefUrlID = $connection->execute("Select Id from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=".$ProjectId)->fetchAll('assoc');
        $multipleVal = $connection->execute("Select AttributeValue from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and AttributeMasterId = " . $AttrId . " and ProjectAttributeMasterId = " . $ProjAttrId . " and AttributeMainGroupId = " . $AttrGroup . " and AttributeSubGroupId = " . $AttrSubGroup . " and SequenceNumber = " . $Seq . " and RecordDeleted <> 1 and AttributeValue <> '' GROUP by AttributeValue")->fetchAll('assoc');
    }
        $RefURL = AfterRefURL;
        $RefUrlID = $connection->execute("Select Id from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=".$ProjectId)->fetchAll('assoc');
        $multipleAttrVal = $connection->execute("Select AttributeValue, count (AttributeValue) as attrcnt  from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and RecordDeleted <> 1 and AttributeValue <> '' GROUP by AttributeValue Order by attrcnt desc")->fetchAll('assoc');
       
		//pr($multipleVal);
		//pr($multipleAttrVal);
		
		$arrayres = array_column($multipleVal, 'AttributeValue');
		//pr($multipleAttrVal);
		
		$finalarr = array_map(function ($mulattval) use($arrayres) { 
							if(!in_array($mulattval['AttributeValue'],$arrayres))
								return $mulattval; 
					}, $multipleAttrVal);
		$finalarr1 = array_filter($finalarr);
		
		//pr($finalarr1);
		
		$finarr = array();
		foreach($finalarr1 as $vas) {
			$finarr[] = $vas;
		}
		
		
        $getData['attrval'] = $finarr;
        $getData['attrinitiallink'] = $multipleAttrVal[0]['AttributeValue'];
        
        $sameUrl = $getData['attrinitiallink'];
        //if ($sameUrl != '') {
            $sameIdlink = $connection->execute("Select AttributeMainGroupId, count(Id) as cnt from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and AttributeValue = '$sameUrl' and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and RecordDeleted <> 1 group by AttributeMainGroupId")->fetchAll('assoc');
        //}
        $getData['attrcnt'] = $sameIdlink;

        if (!empty($multipleAttrVal)) {
            echo json_encode($getData);
        }
        exit;
    }

    function ajaxinsertreferenceurl() {
        $connection = ConnectionManager::get('default');
        $UrlText = $_POST['NewUrl'];
        $ProjectId = $_POST['ProjectId'];
        $RegionId = $_POST['RegionId'];
        $InputEntityId = $_POST['InputEntityId'];
        $ProdEntityId = $_POST['ProdEntityId'];
        $AttrGroup = $_POST['AttrGroup'];
        $AttrSubGroup = $_POST['AttrSubGroup'];
        $AttrId = $_POST['AttrId'];
        $Seq = $_POST['Seq'];
        $ProjAttrId = $_POST['ProjAttrId'];
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $moduleId = $session->read("moduleId");
        $createddate = date("Y-m-d H:i:s");
        $RefURL = AfterRefURL;
        $RefUrlID = $connection->execute("Select Id,FieldTypeName from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=".$ProjectId)->fetchAll('assoc');
        $multipleAttrVal = $connection->execute("Insert into MC_CengageProcessInputData (ProjectId,RegionId,InputEntityId,ProductionEntityID,AttributeMasterId,ProjectAttributeMasterId,AttributeValue,DependencyTypeMasterId,DependencyTypeName,SequenceNumber,ModuleId,AttributeMainGroupId,AttributeSubGroupId,RecordStatus,UserId,CreatedDate,RecordDeleted)"
                . "values('" . $ProjectId . "','" . $RegionId . "','" . $InputEntityId . "','" . $ProdEntityId . "','" . $AttrId . "','" . $ProjAttrId . "','" . $UrlText . "','" . $RefUrlID[0]['Id'] . "','" . $RefUrlID[0]['FieldTypeName'] . "','" . $Seq . "','" . $moduleId . "','" . $AttrGroup . "','" . $AttrSubGroup . "','" . 1 . "','" . $user_id . "','" . $createddate . "','" . 0 . "')");
        echo "Inserted";
        exit;
    }

    function ajaxloadmultipleurl() {
        $connection = ConnectionManager::get('default');
        $UrlText = $_POST['NewUrl'];
        $ProjectId = $_POST['ProjectId'];
        $RegionId = $_POST['RegionId'];
        $InputEntityId = $_POST['InputEntityId'];
        $ProdEntityId = $_POST['ProdEntityId'];
        $AttrGroup = $_POST['AttrGroup'];
        $AttrSubGroup = $_POST['AttrSubGroup'];
        $AttrId = $_POST['AttrId'];
        $ProjAttrId = $_POST['ProjAttrId'];
        $Seq = $_POST['seq'];

        $RefURL = AfterRefURL;
        $RefUrlID = $connection->execute("Select Id,FieldTypeName from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=".$ProjectId)->fetchAll('assoc');
        if ($UrlText != '') {
            $sameIdlink = $connection->execute("Select HtmlFileName from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and AttributeValue = '$UrlText' and AttributeMasterId = " . $AttrId . " and ProjectAttributeMasterId = " . $ProjAttrId . " and AttributeMainGroupId = " . $AttrGroup . " and SequenceNumber = " . $Seq . " and AttributeSubGroupId = " . $AttrSubGroup . " and HtmlFileName <> '' and RecordDeleted <> 1")->fetchAll('assoc');
            $getData['htmlfile'] = $sameIdlink[0]['HtmlFileName'];    
            $attrCount = $connection->execute("Select AttributeMainGroupId, count(Id) as cnt from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and AttributeValue = '$UrlText' and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and RecordDeleted <> 1 group by AttributeMainGroupId")->fetchAll('assoc');
       
        $getData['attrCount'] = $attrCount; 
        $attrids = $connection->execute("Select AttributeMasterId from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and AttributeValue = '$text' and RecordDeleted <> 1 and AttributeValue <> ''")->fetchAll('assoc');
        $getData['attrid'] = $attrids;
        }

        if (!empty($getData)) {

            echo json_encode($getData);
        }
        exit;
    }

    function ajaxloadgroupurl() {
        $connection = ConnectionManager::get('default');
        $UrlText = $_POST['NewUrl'];
        $ProjectId = $_POST['ProjectId'];
        $RegionId = $_POST['RegionId'];
        $InputEntityId = $_POST['InputEntityId'];
        $ProdEntityId = $_POST['ProdEntityId'];
        $AttrGroup = $_POST['AttrGroup'];
        $AttrSubGroup = $_POST['AttrSubGroup'];
        $AttrId = $_POST['AttrId'];
        $ProjAttrId = $_POST['ProjAttrId'];

        $RefURL = AfterRefURL;
        $RefUrlID = $connection->execute("Select Id,FieldTypeName from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=".$ProjectId)->fetchAll('assoc');
        if ($UrlText != '') {
            $htmlfile = $connection->execute("Select HtmlFileName from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and AttributeValue = '$UrlText' and HtmlFileName <> '' and RecordDeleted <> 1")->fetchAll('assoc');
        $getData['htmlfile'] = $htmlfile[0]['HtmlFileName'];    
            $attrCount = $connection->execute("Select AttributeMainGroupId, count(Id) as cnt from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and AttributeValue = '$UrlText' and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and RecordDeleted <> 1 group by AttributeMainGroupId")->fetchAll('assoc');
            
        $getData['attrCount'] = $attrCount; 
        $attrids = $connection->execute("Select AttributeMasterId from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and AttributeValue = '$UrlText' and RecordDeleted <> 1 and AttributeValue <> ''")->fetchAll('assoc');
        $getData['attrid'] = $attrids;
            
        }
        if (!empty($getData)) {

            echo json_encode($getData);
        }
        exit;
    }

    function ajaxqueryposing() {
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $ProjectId = $session->read("ProjectId");
        $moduleId = $session->read("moduleId");
        $RegionId = $_POST['RegionId'];
        echo $_POST['query'];
        $file = $this->QCValidation->find('querypost', ['ProductionEntity' => $_POST['InputEntyId'], 'query' => $_POST['query'], 'ProjectId' => $ProjectId, 'RegionId' => $RegionId, 'moduleId' => $moduleId, 'user' => $user_id]);
        exit;
    }

    function ajaxloadresult() {
        $session = $this->request->session();
        $ProjectId = $session->read("ProjectId");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $Region = $_POST['Region'];
        $optOption = $JsonArray['AttributeOrder'][$Region][$_POST['id']]['Mapping'][$_POST['toid']][$_POST['value']];
        $arrayVal = array();
        $i = 0;
        foreach ($optOption as $key => $val) {
            $dumy = key($val);
            $arrayVal[$i]['Value'] = $JsonArray['AttributeOrder'][$Region][$_POST['toid']]['Options'][$dumy];
            $arrayVal[$i]['id'] = $dumy;
            $i++;
        }
        echo json_encode($arrayVal);
        exit;
    }

    function ajaxautofill() {
        $session = $this->request->session();
        $ProjectId = $session->read("ProjectId");
        $connection = ConnectionManager::get('default');
        $link = $connection->execute("SELECT Value  FROM ME_AutoSuggestionMasterlist WITH (NOLOCK) WHERE ProjectId=" . $ProjectId . " AND AttributeMasterId=" . $_POST['element'] . "")->fetchAll('assoc');

        $valArr = array();
        foreach ($link as $key => $value) {
            $valArr[] = $value['Value'];
        }
        echo json_encode($valArr);
        exit;
    }

    public function ajaxsave() {


        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $connection = ConnectionManager::get('default');
        $ProjectId = $_POST['ProjectId'];
        $RegionId = $_POST['RegionId'];
        $InputEntityId = $_POST['InputEntityId'];
        $ProductionEntityID = $_POST['ProductionEntityID'];

        $moduleId = $session->read("moduleId");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];




        if (empty($this->request->session()->read('user_id'))) {
            echo 'expired';
            exit;
        } else {
            parse_str($_POST['Updatedata'], $postValue);

            //$updateTimeTaken.="TimeTaken='" . $postValue['TimeTaken'] . "'";
            foreach ($postValue as $key => $val) {
                $ProdFields = explode('_', $key);
                if (isset($ProdFields['3'])) {
                    //pr($ProdFields);
                    $AttributeValue = $postValue[$ProdFields[0] . '_' . $ProdFields[1] . '_' . $ProdFields[2] . '_' . $ProdFields[3]];
                    $productionjob = $connection->execute("UPDATE MC_CengageProcessInputData SET AttributeValue='" . $AttributeValue . "', UserId='" . $user_id . "' where AttributeMasterId='" . $ProdFields[1] . "' AND DependencyTypeMasterId='" . $ProdFields[2] . "' AND SequenceNumber='" . $ProdFields[3] . "' AND ProjectId='" . $ProjectId . "' AND RegionId='" . $RegionId . "' AND InputEntityId='" . $InputEntityId . "'");

                    //echo "UPDATE MC_CengageProcessInputData SET AttributeValue='" . $AttributeValue . "', UserId='" . $user_id . "' where AttributeMasterId='" . $ProdFields[1] . "' AND DependencyTypeMasterId='" . $ProdFields[2] . "' AND SequenceNumber='" . $ProdFields[3] . "' AND ProjectId='" . $ProjectId . "' AND RegionId='" . $RegionId . "' AND InputEntityId='" . $InputEntityId . "'<br><br>";
                    }
                }

            parse_str($_POST['Inputdata'], $insert);
            if (isset($insert)) {
                $i = 0;
                $depArr = array();
                foreach ($insert as $key2 => $val2) {
                    $ProdFields = explode('_', $key2);
                    if (isset($ProdFields['3'])) {

                        $projAttArr = $this->searchArray('AttributeMasterId', $ProdFields[1], $ProductionFields);
                        $projectAttributeId = $ProductionFields[$projAttArr]['ProjectAttributeMasterId'];
                        $MainGroupId = $ProductionFields[$projAttArr]['MainGroupId'];
                        $SubGroupId = $ProductionFields[$projAttArr]['SubGroupId'];
                        if (isset($MainGroupId) && isset($SubGroupId) && isset($projectAttributeId)) {
                            $depArr[$MainGroupId][$SubGroupId][$projectAttributeId][$ProdFields[3]]['AttributeMasterId'] = $ProdFields[1];
                            $AttributeValue = $postValue[$ProdFields[0] . '_' . $ProdFields[1] . '_' . $ProdFields[2] . '_' . $ProdFields[3]];
                            $productionjob = $connection->execute("INSERT INTO MC_CengageProcessInputData ([ProjectId],[RegionId],[InputEntityId],[ProductionEntityID],[AttributeMasterId],[ProjectAttributeMasterId],[AttributeValue],[DependencyTypeMasterId],[SequenceNumber],[ModuleId],[AttributeMainGroupId],[AttributeSubGroupId],[RecordStatus],[UserId],[CreatedDate])
                                                            values ($ProjectId,$RegionId,$InputEntityId,$ProductionEntityID,$ProdFields[1],$projectAttributeId,'$val2',$ProdFields[2],$ProdFields[3],$moduleId,$MainGroupId,$SubGroupId,1,$user_id,'" . date('Y-m-d H:i:s') . "')
                                                          ");
            }
            }
                    $i++;
                }
                $DependencyTypeMaster = $connection->execute("SELECT Id FROM MC_DependencyTypeMaster WHERE ProjectId=" . $ProjectId . "AND RegionId=" . $RegionId . " AND Type not in ('ProductionField','Disposition','Comments') AND FieldTypeName !='General' AND RecordStatus=1")->fetchAll('assoc');
                foreach ($depArr as $Mainkey3 => $Mainval3) {
                    foreach ($Mainval3 as $subKey => $subVal) {
                        foreach ($subVal as $projKey => $projVal) {
                            foreach ($projVal as $seqKey => $seqVal) {
                                foreach ($DependencyTypeMaster as $key4 => $val4) {
                                    $productionjob = $connection->execute("INSERT INTO MC_CengageProcessInputData ([ProjectId],[RegionId],[InputEntityId],[ProductionEntityID],[AttributeMasterId],[ProjectAttributeMasterId],[AttributeValue],[DependencyTypeMasterId],[SequenceNumber],[ModuleId],[AttributeMainGroupId],[AttributeSubGroupId],[RecordStatus],[UserId],[CreatedDate])
                                                            values ($ProjectId,$RegionId,$InputEntityId,$ProductionEntityID," . $seqVal['AttributeMasterId'] . ",$projKey,''," . $val4['Id'] . ",$seqKey,$moduleId,$Mainkey3,$subKey,1,$user_id,'" . date('Y-m-d H:i:s') . "')
                                                          ");

                                    //echo "INSERT INTO MC_CengageProcessInputData ([ProjectId],[RegionId],[InputEntityId],[ProductionEntityID],[AttributeMasterId],[ProjectAttributeMasterId],[AttributeValue],[DependencyTypeMasterId],[SequenceNumber],[ModuleId],[AttributeMainGroupId],[AttributeSubGroupId],[RecordStatus],[UserId],[CreatedDate])
                                    //                       values ($ProjectId,$RegionId,$InputEntityId,$ProductionEntityID,".$seqVal['AttributeMasterId'].",$projKey,'',".$val4['Id'].",$seqKey,$moduleId,$Mainkey3,$subKey,1,$user_id,'".date('Y-m-d H:i:s')."')
                                    //                       ";
                                }
                            }
                        }
                    }
                }
            }
            echo (json_encode("saved"));
            exit;
        }
    }

    public function ajaxgetnextpagedata() {
        $session = $this->request->session();
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';
        if (empty($this->request->session()->read('user_id'))) {
            echo 'expired';
            exit;
        } else {
            $connection = ConnectionManager::get('default');
           // $productionjobNew = $connection->execute('SELECT * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE ProductionEntity=' . $_POST['ProductionEntity'] . ' AND SequenceNumber=' . $_POST['page'])->fetchAll('assoc');

            $cmdOldData = $connection->execute('select AttributeMasterId from MV_QC_Comments where InputEntityId=' . $_POST['InputEntyId'] . ' and StatusID IN (1,2) AND AttributeMasterId=' . $_POST['AttributeMasterId'] . ' AND ProjectAttributeMasterId=' . $_POST['ProjectAttributeMasterId'] . ' AND ModuleId = '.$moduleId.' And SequenceNumber=' . $_POST['page'])->fetchAll('assoc');
            $oldDataAttr = array_map(current, $cmdOldData);

            $OldDataId = $connection->execute('select Id from MV_QC_Comments where InputEntityId=' . $_POST['InputEntyId'] . 'AND AttributeMasterId=' . $_POST['AttributeMasterId'] . ' AND ProjectAttributeMasterId=' . $_POST['ProjectAttributeMasterId'] . ' AND ModuleId = '.$moduleId.' AND SequenceNumber=' . $_POST['page'])->fetchAll('assoc');
            $oldDataAttrId = array_map(current, $OldDataId);

            $TLAcceptError = $connection->execute('select Id from MV_QC_Comments where InputEntityId=' . $_POST['InputEntyId'] . 'AND AttributeMasterId=' . $_POST['AttributeMasterId'] . ' AND ProjectAttributeMasterId=' . $_POST['ProjectAttributeMasterId'] . ' AND ModuleId = '.$moduleId.'  And StatusID=2 AND SequenceNumber=' . $_POST['page'])->fetchAll('assoc');
            $TLAccept = array_map(current, $TLAcceptError);

            $cmdOldDataRebutal = $connection->execute('select AttributeMasterId from MV_QC_Comments where InputEntityId=' . $_POST['InputEntyId'] . ' and StatusID=3 AND AttributeMasterId=' . $_POST['AttributeMasterId'] . ' AND ProjectAttributeMasterId=' . $_POST['ProjectAttributeMasterId'] . ' AND ModuleId = '.$moduleId.' And SequenceNumber=' . $_POST['page'])->fetchAll('assoc');
            $oldDataAttrRebutal = array_map(current, $cmdOldDataRebutal);

         //   $getOldData['attrval'] = $productionjobNew[0];
            $getOldData['attrcnt'] = $oldDataAttr;
            $getOldData['attrId'] = $oldDataAttrId;
            $getOldData['tlAccept'] = $TLAccept;
            $getOldData['attrRebutal'] = $oldDataAttrRebutal;

            echo json_encode($getOldData);
            exit;
        }
    }

    public function ajaxnewsave() {
        $session = $this->request->session();
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';
        if (empty($this->request->session()->read('user_id'))) {
            echo 'expired';
            exit;
        } else {
            $session = $this->request->session();
            $user_id = $session->read("user_id");
            $ProjectId = $session->read("ProjectId");
            $connection = ConnectionManager::get('default');
            $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
            $RegionId = $_POST['RegionId'];
            $ProjectAttr = $_POST['productionData_projatt'];
            $productionData = $_POST['productionData'];
            $ProductionFields = $_POST['productionData_ely'];
            $ProductionEntity = $_POST['ProductionEntity'];

            $dynamicData = $_POST['dynamicData'];
            $dynamicData_ely = $_POST['dynamicData_ely'];

            $staticData = $_POST['staticDatavar'];
            $staticData_ely = $_POST['staticData_elyvar'];


            foreach ($ProductionFields as $key => $val) {
                $productionData[$key] = str_replace("'", "''", $productionData[$key]);
                $productionData[$key] = str_replace("\n", " ", $productionData[$key]);
                $updatetempFileds.="[" . $val . "],";
                $valuetoInsert.="N'" . $productionData[$key] . "',";
                $IsAutoSuggesstion = $JsonArray['ValidationRules'][$ProjectAttr[$key]]['IsAutoSuggesstion'];
                $IsAllowNewValues = $JsonArray['ValidationRules'][$ProjectAttr[$key]]['IsAllowNewValues'];
                if ($IsAutoSuggesstion == '1' && $IsAllowNewValues == '1') {
                    $Value = $productionData[$key];
                    $attrmasterid = $val;
                    $Projattrmasterid = $ProjectAttr[$key];
                    $createddate = date("Y-m-d H:i:s");
                    $link = $connection->execute("SELECT count(1) as count  FROM ME_AutoSuggestionMasterlist WITH (NOLOCK)WHERE ProjectId=" . $ProjectId . " AND RegionId=" . $RegionId . " AND AttributeMasterId=" . $attrmasterid . " AND ProjectAttributeMasterId=" . $Projattrmasterid . " AND RecordStatus=1 AND Value = '" . $Value . "'")->fetchAll('assoc');
                    $valcount = $link[0]['count'];
                    if ($valcount == 0) {
                        $updateautosuggestion = $connection->execute("INSERT into ME_AutoSuggestionMasterlist (ProjectId,RegionId,AttributeMasterId,ProjectAttributeMasterId,Value,OrderId,RecordStatus,CreatedDate,CreatedBy)values ('" . $ProjectId . "','" . $RegionId . "','" . $attrmasterid . "','" . $Projattrmasterid . "','" . $Value . "','1','1','" . $createddate . "','" . $user_id . "')");
                    }
                }
            }
            foreach ($dynamicData_ely as $key => $val) {
                $updatetempFileds.="[" . $val . "],";
                $valuetoInsert.="N'" . str_replace("'", "''", $dynamicData[$key]) . "',";
            }

            foreach ($staticData_ely as $key => $val) {
                $updatetempFileds.="[" . $val . "],";
                $valuetoInsert.="'" . str_replace("'", "''", $staticData[$key]) . "',";
            }

            $updatetempFileds.='TimeTaken';
            $valuetoInsert.= "'" . $_POST['TimeTaken'] . "'";

            $productionjobNew = $connection->execute('SELECT BatchCreated,BatchID,ProjectId,RegionId,InputEntityId,ProductionEntity,StatusId,UserId,ActStartDate FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE ProductionEntityID=' . $ProductionEntity)->fetchAll('assoc');
            //pr($productionjobNew[0]); exit;
            $refData = $productionjobNew[0];

            $seq = count($productionjobNew) + 1;
            $productionjob = $connection->execute("INSERT INTO  " . $stagingTable . "( BatchCreated,BatchID,ProjectId,RegionId,InputEntityId,ProductionEntity,SequenceNumber,StatusId,UserId,ActStartDate," . $updatetempFileds . " )values ( '" . $refData['BatchCreated'] . "'," . $refData['BatchID'] . "," . $refData['ProjectId'] . "," . $refData['RegionId'] . "," . $refData['InputEntityId'] . "," . $refData['ProductionEntity'] . "," . $seq . "," . $refData['StatusId'] . "," . $user_id . ",'" . $refData['ActStartDate'] . "'," . $valuetoInsert . ")");

            $dymamicupdatetempFileds = '';
            foreach ($dynamicData_ely as $key => $val) {
                $dymamicupdatetempFileds.="[" . $val . "]='" . str_replace("'", "''", $dynamicData[$key]) . "',";
            }

            $dymamicupdatetempFileds.="TimeTaken='" . $_POST['TimeTaken'] . "'";

            $Dynamicproductionjob = $connection->execute('UPDATE ' . $stagingTable . ' SET ' . $dymamicupdatetempFileds . 'where ProductionEntityID=' . $refData['ProductionEntity']);
            echo 'saved';
            exit;
        }
    }

    function ajaxdelete() {
        $session = $this->request->session();
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';

        if (empty($this->request->session()->read('user_id'))) {
            echo 'expired';
            exit;
        } else {
            $connection = ConnectionManager::get('default');
            $delete = 'Yes';
            $sequence = $_POST['page'];
            $user_id = $this->request->session()->read('user_id');
            $ProjectId = $this->request->session()->read('ProjectId');
            $ProductionEntity = $_POST['ProductionEntity'];
            $ProductionId = $_POST['ProductionId'];

            if ($sequence == 1) {
                $SequenceNumber = $connection->execute('SELECT Id FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE ProductionEntity=' . $ProductionEntity)->fetchAll('assoc');
                $sequencemax = count($SequenceNumber);
                if ($sequencemax == 1)
                    $delete = 'No';
            }
            if ($delete != 'No') {
                $delete = $connection->execute("DELETE FROM " . $stagingTable . " WHERE   ProductionEntity='" . $ProductionEntity . "' and SequenceNumber='" . $sequence . "'");
                $SequenceNumber = $connection->execute("SELECT Id,SequenceNumber FROM " . $stagingTable . " with (NOLOCK)  WHERE  ProductionEntity='" . $ProductionEntity . "' AND SequenceNumber>$sequence order by SequenceNumber desc")->fetchAll('assoc');
                foreach ($SequenceNumber as $key => $val) {
                    $newsequence = $val['SequenceNumber'] - 1;
                    $id = $val['Id'];
                    $update = $connection->execute("update  " . $stagingTable . " set SequenceNumber = $newsequence WHERE Id=" . $val['Id'] . "  and SequenceNumber='" . $val['SequenceNumber'] . "'");
                }
            }
            if ($delete == 'No')
                echo 'one';
            else
                echo 'deleted';
            exit;
        }
    }

    function ajaxremoverow() {
        $session = $this->request->session();
        $moduleId = $session->read("moduleId");
        $ProjectId = $session->read("ProjectId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';
        $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][0];
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);

        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];
        $connection = ConnectionManager::get('default');
        $primary_Id = $_POST['data'][$_POST['changes']][0];
        $sequence = $_POST['changes'] + 1;
        $user_id = $session->read("user_id");
        //  $rowId  = $change[0] + 1;
        if ($_POST['changes'] != 0) {

            //echo "SELECT ProductionEntity,Id,SequenceNumber FROM " . $stagingTable . " with (NOLOCK)  WHERE  Id='" . $primary_Id . "'";
            if ($primary_Id != '') {
                $prodEntity = $connection->execute("SELECT ProductionEntity,Id,SequenceNumber FROM " . $stagingTable . " with (NOLOCK)  WHERE  Id='" . $primary_Id . "'")->fetchAll('assoc');
                //pr($prodEntity);
                $ProductionEntity = $prodEntity[0]['ProductionEntity'];
            } else {
                //echo 'SELECT TOP 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE UserId=' . $user_id . ' AND StatusId=' . $next_status_id . ' and SequenceNumber='.$sequence.' ORDER BY SequenceNumber DESC';
                $seq_check = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE UserId=' . $user_id . ' AND StatusId=' . $next_status_id . ' and SequenceNumber=' . $sequence . ' ORDER BY SequenceNumber DESC')->fetchAll('assoc');
                // pr($seq_check);
                $ProductionEntity = $seq_check[0]['ProductionEntity'];
                $primary_Id = $seq_check[0]['Id'];
            }
            if ($ProductionEntity != '') {
                //echo "DELETE FROM " . $stagingTable . " WHERE   Id='" . $primary_Id . "'";
                $delete = $connection->execute("DELETE FROM " . $stagingTable . " WHERE   Id='" . $primary_Id . "'");
            }
            //echo "SELECT Id,SequenceNumber FROM " . $stagingTable . " with (NOLOCK)  WHERE  ProductionEntity='" . $ProductionEntity . "' AND SequenceNumber>$sequence order by SequenceNumber desc"; 
            $SequenceNumber = $connection->execute("SELECT Id,SequenceNumber FROM " . $stagingTable . " with (NOLOCK)  WHERE  ProductionEntity='" . $ProductionEntity . "' AND SequenceNumber>$sequence order by SequenceNumber desc")->fetchAll('assoc');
            foreach ($SequenceNumber as $key => $val) {
                $newsequence = $val['SequenceNumber'] - 1;
                $id = $val['Id'];
                //echo "update  " . $stagingTable . " set SequenceNumber = $newsequence WHERE Id=" . $val['Id'] . "  and SequenceNumber='" . $val['SequenceNumber'] . "'";
                $update = $connection->execute("update  " . $stagingTable . " set SequenceNumber = $newsequence WHERE Id=" . $val['Id'] . "  and SequenceNumber='" . $val['SequenceNumber'] . "'");
            }
        }
    }

    function ajax_datacheck() {
        $ProjectId = $this->request->session()->read('ProjectId');
        $this->layout = 'ajax';
        error_reporting(E_PARSE);
        $connection = ConnectionManager::get('default');
        $users = $connection->execute("SELECT Value FROM ME_AutoSuggestionMasterlist WITH (NOLOCK) WHERE  AttributeMasterId='" . $_POST['AttributeMasterId'] . "' and ProjectId='" . $ProjectId . "' and Value='" . $_POST['value'] . "'");
        //$users = $this->GetJob->query("select ".$_POST['colum']." from Zip_Dump where ".$_POST['colum']." = '".$_POST['val']."'");
        if (empty($users)) {
            echo 0;
        } else
            echo 1;
        exit;
    }

    function ajaxgetdatahand() {
        $ProductionEntityId = $_POST['ProductionEntityId'];
        $AttributeMasterId = $_POST['AttributeMasterId'];
        $Title = $_POST['title'];
        $session = $this->request->session();
        $ProjectId = $session->read("ProjectId");
        $connection = ConnectionManager::get('default');
        $user_id = $session->read("user_id");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';
        $connectiond2k = ConnectionManager::get('d2k');
        $statusIdentifier = ReadyForQCIdentifier;

        $QcFirstStatus = $connectiond2k->execute("SELECT Status FROM D2K_ModuleStatusMaster where ModuleId=$moduleId and ModuleStatusIdentifier='$statusIdentifier' AND RecordStatus=1")->fetchAll('assoc');
        $QcFirstStatus = array_map(current, $QcFirstStatus);
        $first_Status_name = $QcFirstStatus[0];


        //   $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][0];
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);

        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];
        $PivotId = '';
        $finalval = array();
	
        $link2 = $connection->execute("SELECT FieldTypeName,Id FROM MC_DependencyTypeMaster WHERE FieldTypeName IN ('After Normalized','Before','After Disposition') AND ProjectId=".$ProjectId)->fetchAll('assoc');
	
	
        foreach ($link2 as $keytype => $valuetype) {
            //echo $keytype.'<br>';
            $PivotId.= '[' . $valuetype["Id"] . '],';
            $FieldTyper = $valuetype['FieldTypeName'];
            $FieldTypeId = $valuetype['Id'];
            $FieldTypeName = preg_replace('/\s+/', '', $FieldTyper);
            $finalval[$FieldTypeId] = $FieldTypeName;
        }
        $PivotId = rtrim($PivotId, ',');

        //$link = $connection->execute("SELECT * FROM MC_CengageProcessInputData WHERE AttributeMasterId=" . $AttributeMasterId . " AND ProductionEntityID=" . $ProductionEntityId . "AND DependencyTypeMasterId IN (1008,1012,1011) AND ProjectId=" . $ProjectId)->fetchAll('assoc');
        $link = $connection->execute("select * from (select Attributevalue, SequenceNumber, DependencyTypeMasterId from MC_CengageProcessInputData WHERE AttributeMasterId=" . $AttributeMasterId . " AND ProductionEntityID=" . $ProductionEntityId . " AND ProjectId=" . $ProjectId . " ) a pivot ( max(Attributevalue) for DependencyTypeMasterId in ($PivotId)) piv;")->fetchAll('assoc');
        //$link = $connection->execute("SELECT * FROM MC_CengageProcessInputData WHERE AttributeMasterId=2993 AND ProductionEntityID=43108 AND DependencyTypeMasterId IN (1008,1012,1011) AND ProjectId=2308")->fetchAll('assoc');
        $RegionId = $link[0]['RegionId'];

        $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
        $ReadOnlyFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['readonly'];
        //pr($ReadOnlyFields);
        $valArr = array();
        $i = 0;
	$qchead='';
	$qvalue='';
        foreach ($link as $key => $value) {

            //$valArr['handson'][$i]['DataId'] = $value['SequenceNumber'];
            foreach ($finalval as $key4 => $value4) {
		if($i == 0){
		if($value4=="AfterNormalized"){ $head="After Normalized";} elseif($value4=="AfterDisposition"){ $head="After Disposition"; } else{ $head=$value4; }
		$qchead.='<td>'.$head.'</td>';
		}
                $valArr['handson'][$i][$value4] = $value[$key4];
            }
	   
            //$valArr['handson'][$i]['Id'] = $i;
            $i++;
        }
	         $qc_datarow='';
		 $headi=0;
		foreach($valArr['handson'] as $key=>$value){
		     $qc_datarow.='<tr>';
		   foreach($value as $arkey=>$arvalue){	
		  
		     $qc_datarow.='<td>'.$arvalue.'</td>';
		   }		   
		   $qc_datarow.='</tr>';
		    
		    
		}
	
	
	
	         $qc_data='<div  style="padding: 10px;background: #fff;font-size: 17px;font-weight: 500;">'.$Title.'</div>';
		 $qc_data.='<table><tr>'.$qchead.'</tr>';
		  $qc_data.='<tr>'.$qc_datarow.'</tr>';
		// $qc_data.=$qc_datarow;
		 $qc_data.='</table>';
		echo $qc_data;
       // echo json_encode($valArr);
        exit;
    }

    function ajaxsavedatahand() {
        $session = $this->request->session();
        $ProjectId = $session->read("ProjectId");
        $connection = ConnectionManager::get('default');
        $user_id = $session->read("user_id");
        $moduleId = $session->read("moduleId");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][0];
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);

        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];

        $stagingTable = 'Staging_' . $moduleId . '_Data';

        $link = $connection->execute("SELECT * FROM " . $stagingTable . " where UserId=" . $user_id . " AND StatusId=" . $next_status_id . " AND ProjectId=" . $ProjectId . "")->fetchAll("assoc");
        $RegionId = $link[0]['RegionId'];
        $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
        $ReadOnlyFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['readonly'];
        $colMap[0] = 'DataId';
        $i = 1;
        foreach ($ReadOnlyFields as $val) {
            $colMap[$i] = '[' . $val["AttributeMasterId"] . ']';
            $i++;
        }
        foreach ($ProductionFields as $val) {
            $colMap[$i] = '[' . $val["AttributeMasterId"] . ']';
            $i++;
        }



        $primary_Id = $_POST['data'][$_POST['changes'][0][0]][0];
        if (isset($_POST['changes']) && $_POST['changes']) {
            $i = 0;
            foreach ($_POST['changes'] as $change) {

                $rowId = $change[0] + 1;
                $colId = $change[1];
                $newVal = $change[3];
                $primary_Id = $_POST['data'][$change[0]][0];
                if (!empty($primary_Id)) {
                    //echo "UPDATE " . $stagingTable . " SET " . $colMap[$colId] . " = N'" . $newVal . "' WHERE id = " . $primary_Id;
                    $connection->execute("UPDATE " . $stagingTable . " SET " . $colMap[$colId] . " = N'" . $newVal . "' WHERE id = " . $primary_Id);
                    $out = array(
                        'result' => 'ok'
                    );
                    echo json_encode($out);
                } else {
                    $tempFields = '';
                    $tempData = '';
                    $InprogressProductionjob = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE UserId=' . $user_id . ' AND StatusId=' . $next_status_id . " AND ProjectId=" . $ProjectId . ' ORDER BY SequenceNumber DESC')->fetchAll('assoc');
                    $RegionId = $InprogressProductionjob[0]['RegionId'];
                    $primary_Id = $InprogressProductionjob[0]['Id'];
                    $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
                    $StaticFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['static'];

                    $sequenceNo = $InprogressProductionjob[0]['SequenceNumber'];
                    foreach ($StaticFields as $key => $val) {
                        if ($val['AttributeMasterId'] != '') {
                            $tempFields.="[" . $val['AttributeMasterId'] . "],";
                            $tempData.= "'" . $InprogressProductionjob[0][$val['AttributeMasterId']] . "',";
                        }
                    }
                    if ($sequenceNo == $rowId) {
                        $connection->execute("UPDATE " . $stagingTable . " SET " . $colMap[$colId] . " = N'" . $newVal . "' WHERE id = " . $primary_Id);
                    } else {
                        $seq_check = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE UserId=' . $user_id . ' AND StatusId=' . $next_status_id . " AND ProjectId=" . $ProjectId . ' and SequenceNumber=' . $rowId . ' ORDER BY SequenceNumber DESC')->fetchAll('assoc');
                        if ($seq_check) {
                            $RegionId = $seq_check[0]['RegionId'];
                            $primary_Id = $seq_check[0]['Id'];
                            $connection->execute("UPDATE " . $stagingTable . " SET " . $colMap[$colId] . " = N'" . $newVal . "' WHERE id = " . $primary_Id);
                        } else {
                            $connection->execute("INSERT INTO " . $stagingTable . "(BatchID,BatchCreated,ProjectId,RegionId,InputEntityId,ProductionEntity,SequenceNumber,StatusId,UserId,ActStartDate,TimeTaken,RecordStatus,CreatedBy,CreatedDate," . $tempFields . "$colMap[$colId]) "
                                    . " values(" . $InprogressProductionjob[0]['BatchID'] . ",'" . $InprogressProductionjob[0]['BatchCreated'] . "'," . $InprogressProductionjob[0]['ProjectId'] . "," . $InprogressProductionjob[0]['RegionId'] . "," . $InprogressProductionjob[0]['InputEntityId'] . "," . $InprogressProductionjob[0]['ProductionEntity'] . "," . ($InprogressProductionjob[0]['SequenceNumber'] + 1) . "," . $InprogressProductionjob[0]['StatusId'] . "," . $InprogressProductionjob[0]['UserId'] . ",'" . $InprogressProductionjob[0]['ActStartDate'] . "','" . $InprogressProductionjob[0]['TimeTaken'] . "',1,1,'" . date('Y-m-d H:i:s') . "'," . $tempData . "N'" . $newVal . "')");
                        }
                    }
                    $out = array(
                        'result' => 'newinsert'
                    );
                    echo json_encode($out);
                }
                $i++;
            }
        }
    }

    function ajaxgetdatahandalldata() {
        $ProductionEntityId = $_POST['ProductionEntityId'];
        $AttributeMasterId = $_POST['AttributeMasterId'];
        $Title = $_POST['title'];
        $handskey = $_POST['handskey'];
        $handskeysub = $_POST['handskeysub'];
        $session = $this->request->session();
        $ProjectId = $session->read("ProjectId");
		$RegionId = $session->read("ProjectId");
        $connection = ConnectionManager::get('default');
        $user_id = $session->read("user_id");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';
        $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][3];
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);

        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];

        $link = $connection->execute("SELECT * FROM " . $stagingTable . " where UserId=" . $user_id . " AND StatusId=" . $next_status_id . " AND ProjectId=" . $ProjectId . "")->fetchAll("assoc");
        $RegionId = $link[0]['RegionId'];
        $finalval = array();
        $PivotId = '';
	//echo "SELECT FieldTypeName,Id FROM MC_DependencyTypeMaster WHERE FieldTypeName IN ('After Normalized','Before','After Disposition') AND ProjectId=".$ProjectId;exit;
      //  $link2 = $connection->execute("SELECT FieldTypeName,Id FROM MC_DependencyTypeMaster WHERE Type IN ('ProductionField') AND ProjectId=".$ProjectId)->fetchAll('assoc');
	 $link2 = $connection->execute("SELECT FieldTypeName,Id FROM MC_DependencyTypeMaster WHERE FieldTypeName IN ('After Normalized','Before','After Disposition') AND ProjectId=".$ProjectId)->fetchAll('assoc');
       
        foreach ($link2 as $keytype => $valuetype) {
            //echo $keytype.'<br>';
            $PivotId.= '[' . $valuetype["Id"] . '],';
	    //$PivotId.= '' . $valuetype["Id"] . ',';
            $FieldTyper = $valuetype['FieldTypeName'];
            $FieldTypeId = $valuetype['Id'];
            $FieldTypeName = preg_replace('/\s+/', '', $FieldTyper);
            $finalval[$FieldTypeId] = $FieldTypeName;
        }
        $PivotId = rtrim($PivotId, ',');
        //$ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
		$firstModuleId = $JsonArray['ModuleAttributes'][$RegionId];
//				pr($firstModuleId);
				
				foreach ($firstModuleId as $keys => $valuesval) {
					$fineval[] = $keys;
				}
				$modulIdSS = $fineval[0];

        $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$modulIdSS]['production'];
        $AttributeGroupMaster = $JsonArray['AttributeGroupMaster'];
        $AttributeGroupMaster = $AttributeGroupMaster[$moduleId][$handskey];
        $groupwisearray = array();
        $subgroupwisearray = array();
        $groupwisearray[$handskey] = $AttributeGroupMaster;
        $keys = array_map(function($v) use ($handskey, $handskeysub) {
            if (($v['MainGroupId'] == $handskey) && ($v['SubGroupId'] == $handskeysub)) {
                return $v;
            }
        }, $ProductionFields);
        $keys_sub = $this->combineBySubGroup($keys);
        $groupwisearray[$handskey] = $keys_sub;
        $valArr = array();
        $i = 0;$att=1;
	$tblhead="";
	$tblheadtwo="";
        foreach ($groupwisearray[$handskey] as $keyn => $valuen) {
	    $nm_menu=count($valuen);
            foreach ($valuen as $keyprodFields => $valprodFields) {
		$tblhead.="<td colspan='3' align='center'>".$valprodFields['AttributeName']."</td>";
		$tblheadtwo.="<td style='min-width:120px;'>Before</td><td style='min-width:150px;'>After Normalized</td><td style='min-width:150px;'>After Disposition</td>";
                $link44 = $connection->execute("select * from (select Attributevalue, SequenceNumber, DependencyTypeMasterId from MC_CengageProcessInputData WHERE AttributeMasterId=" . $valprodFields['AttributeMasterId'] . " AND ProductionEntityID=" . $ProductionEntityId . " AND ProjectId=" . $ProjectId . " ) a pivot ( max(Attributevalue) for DependencyTypeMasterId in ($PivotId)) piv;")->fetchAll('assoc');
		 //$link44 = $connection->execute("select Attributevalue, SequenceNumber, DependencyTypeMasterId from MC_CengageProcessInputData WHERE AttributeMasterId=" . $valprodFields['AttributeMasterId'] . " AND ProductionEntityID=" . $ProductionEntityId . " AND ProjectId=" . $ProjectId . " AND DependencyTypeMasterId in ($PivotId)")->fetchAll('assoc');
		
		 //$link44 = $connection->execute("select * from (select Attributevalue, SequenceNumber, DependencyTypeMasterId from MC_CengageProcessInputData WHERE AttributeMasterId=" . $valprodFields['AttributeMasterId'] . " AND ProductionEntityID=" . $ProductionEntityId . " AND ProjectId=" . $ProjectId . " ) a pivot ( max(Attributevalue) for DependencyTypeMasterId in ($PivotId)) piv;")->fetchAll('assoc');
            
                foreach ($link44 as $key => $value) {
		   
		    	$Arratt=array();
                    //$valArr['handson'][$i]['DataId'] = $valprodFields['SubGroupId'];
                    if($value['SequenceNumber']!=$att)
                        $att=1;
                    else
                        $att=$att+1;
                    $valArr['handson'][$value['SequenceNumber']][$valprodFields['AttributeName']] = $valprodFields['AttributeName'];
		    
                    foreach ($finalval as $key4 => $value4) {
			
                        $Arratt[] = $value[$key4];
                    }
		   
		    $valArr['handson'][$value['SequenceNumber']][$valprodFields['AttributeName']] =$Arratt;
		   
                    $old=$value['SequenceNumber'];
                    //$valArr['handson']['Id'] = $i;
                    $i++;
                }
            }
        }
	
	//echo "<pre>";pr($valArr['handson']);exit;
		 $qc_datarow='';
		 $headi=0;
		foreach($valArr['handson'] as $key=>$value){
		    $ac_menu= count($value);
		    $ex_menu=$nm_menu - count($value);
		   foreach($value as $arkey=>$arvalue){	
		  
		     $qc_datarow.='<td cellspacing="10">'.$arvalue[0].'</td>';
		     $qc_datarow.='<td cellspacing="10">'.$arvalue[1].'</td>';
		     $qc_datarow.='<td cellspacing="10">'.$arvalue[2].'</td>';
		   }
		   for($i=0;$i<$ex_menu;$i++){
		     $qc_datarow.='<td ></td>';
		     $qc_datarow.='<td></td>';
		     $qc_datarow.='<td></td>';
		   }
		   $qc_datarow.='</tr>';
		    
		    
		}
		 $qc_data='<div style="padding: 10px;background: #fff;font-size: 17px;font-weight: 500;">'.$Title.'</div>';
		 $qc_data.='<table style="display:inline-table"><tr style="white-space: nowrap;">'.$tblhead.'</tr>';		 
		 $qc_data.='<tr >'.$tblheadtwo.'</tr>';		
		 $qc_data.=$qc_datarow;
		 $qc_data.='</table>';
		echo $qc_data;
		//echo "hello";
        //echo json_encode($valArr);
	   
        exit;
        
    }

    function ajaxconvert() {
        $ProductionFields = $_POST['production'];
        $changedArr = $_POST['changed'];
        $keyval = $_POST['keyval'];
        $changed = $changedArr[3];
        $Mapping = $ProductionFields[$keyval]['Mapping'];
        if (!empty($Mapping)) {
            $toMpping = key($Mapping);
            $mappingArray = $Mapping[$toMpping][$changed];
            $mappingArray_val = array();
            foreach ($mappingArray as $key => $val) {
                $mappingArray_val[] = key($val);
            }
            $tocolumn = array_search($toMpping, array_column($ProductionFields, 'ProjectAttributeMasterId'));
            $returnArr[0] = $mappingArray_val;
            $returnArr[1] = $tocolumn;
            echo $js_array = json_encode($returnArr);
        }
        exit;
    }

    function ajaxsavehandson() {
        $session = $this->request->session();
        $ProductionEntityId = $_POST['ProductionEntityId'];
        $changedArr = $_POST['changed'];
        $keyval = $_POST['keyval'];
        $changed = $changedArr[3];

        $ProjectId = $session->read("ProjectId");
        $RegionId = $session->read("RegionId");
        $connection = ConnectionManager::get('default');
        $user_id = $session->read("user_id");
        $moduleId = $session->read("moduleId");



//        $link = $connection->execute("SELECT * FROM " . $stagingTable . " where UserId=" . $user_id . " AND StatusId=" . $next_status_id . " AND ProjectId=" . $ProjectId . "")->fetchAll("assoc");
//        $RegionId = $link[0]['RegionId'];
//        $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
//        $ReadOnlyFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['readonly'];
//        $colMap[0] = 'DataId';
//        $i = 1;
//        foreach ($ReadOnlyFields as $val) {
//            $colMap[$i] = '[' . $val["AttributeMasterId"] . ']';
//            $i++;
//        }
//        foreach ($ProductionFields as $val) {
//            $colMap[$i] = '[' . $val["AttributeMasterId"] . ']';
//            $i++;
//        }



        $primary_Id = $_POST['data'][$_POST['changed'][0][0]][0];
        if (isset($_POST['changed']) && $_POST['changed']) {
            $i = 0;
            //$change = $_POST['changed'];
            foreach ($_POST['changed'] as $change) {
                $newVal = $change[3];
                $primary_Id = $_POST['data'][$change[0]][0];
                if (!empty($primary_Id)) {
                    //echo "UPDATE MC_CengageProcessInputData SET AttributeValue = N'" . $newVal . "' WHERE Id = " . $primary_Id;
                    $connection->execute("UPDATE MC_CengageProcessInputData SET AttributeValue = N'" . $newVal . "' WHERE Id = " . $primary_Id);
                    $out = array(
                        'result' => 'ok'
                    );
                    echo json_encode($out);
                } else {
                    echo "INSERT INTO MC_CengageProcessInputData (ProjectId,RegionId,InputEntityId,ProductionEntityID,AttributeMasterId,ProjectAttributeMasterId,AttributeValue,CreatedDate) "
                    . " values(" . $ProjectId . ",'" . $RegionId . "','44871'," . $ProductionEntityId . ",'2993','8098'," . $newVal . ",'" . date('Y-m-d H:i:s') . "')";
//                    $connection->execute("INSERT INTO MC_CengageProcessInputData (ProjectId,RegionId,InputEntityId,ProductionEntityID,AttributeMasterId,ProjectAttributeMasterId,AttributeValue,CreatedDate) "
//                                    . " values(" . $ProjectId . ",'" . $RegionId . "','44871'," . $ProductionEntityId . ",'2993','8098'," . $newVal . ",'" . date('Y-m-d H:i:s') . "')");
//                    $tempFields = '';
//                    $tempData = '';
//                    $InprogressProductionjob = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE UserId=' . $user_id . ' AND StatusId=' . $next_status_id . " AND ProjectId=" . $ProjectId . ' ORDER BY SequenceNumber DESC')->fetchAll('assoc');
//                    $RegionId = $InprogressProductionjob[0]['RegionId'];
//                    $primary_Id = $InprogressProductionjob[0]['Id'];
//                    $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
//                    $StaticFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['static'];
//
//                    $sequenceNo = $InprogressProductionjob[0]['SequenceNumber'];
//                    foreach ($StaticFields as $key => $val) {
//                        if ($val['AttributeMasterId'] != '') {
//                            $tempFields.="[" . $val['AttributeMasterId'] . "],";
//                            $tempData.= "'" . $InprogressProductionjob[0][$val['AttributeMasterId']] . "',";
//                        }
//                    }
//                    if ($sequenceNo == $rowId) {
//                        $connection->execute("UPDATE " . $stagingTable . " SET " . $colMap[$colId] . " = N'" . $newVal . "' WHERE id = " . $primary_Id);
//                    } else {
//                        $seq_check = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE UserId=' . $user_id . ' AND StatusId=' . $next_status_id . " AND ProjectId=" . $ProjectId . ' and SequenceNumber=' . $rowId . ' ORDER BY SequenceNumber DESC')->fetchAll('assoc');
//                        if ($seq_check) {
//                            $RegionId = $seq_check[0]['RegionId'];
//                            $primary_Id = $seq_check[0]['Id'];
//                            $connection->execute("UPDATE " . $stagingTable . " SET " . $colMap[$colId] . " = N'" . $newVal . "' WHERE id = " . $primary_Id);
//                        } else {
//                            $connection->execute("INSERT INTO " . $stagingTable . "(BatchID,BatchCreated,ProjectId,RegionId,InputEntityId,ProductionEntity,SequenceNumber,StatusId,UserId,ActStartDate,TimeTaken,RecordStatus,CreatedBy,CreatedDate," . $tempFields . "$colMap[$colId]) "
//                                    . " values(" . $InprogressProductionjob[0]['BatchID'] . ",'" . $InprogressProductionjob[0]['BatchCreated'] . "'," . $InprogressProductionjob[0]['ProjectId'] . "," . $InprogressProductionjob[0]['RegionId'] . "," . $InprogressProductionjob[0]['InputEntityId'] . "," . $InprogressProductionjob[0]['ProductionEntity'] . "," . ($InprogressProductionjob[0]['SequenceNumber'] + 1) . "," . $InprogressProductionjob[0]['StatusId'] . "," . $InprogressProductionjob[0]['UserId'] . ",'" . $InprogressProductionjob[0]['ActStartDate'] . "','" . $InprogressProductionjob[0]['TimeTaken'] . "',1,1,'" . date('Y-m-d H:i:s') . "'," . $tempData . "N'" . $newVal . "')");
//                        }
//                    }
                    $out = array(
                        'result' => 'newinsert'
                    );
                    echo json_encode($out);
                }
                $i++;
            }
        }
    }

    function upddateUndockSession() {
        $session = $this->request->session();
        $undocked = $_POST['undocked'];
        $user_id = $session->read("user_id");

        $session->write("leftpaneSize", '0');
        $session->write("undocked", $undocked);

        $this->layout = 'ajax';
        $this->render(false);
    }

    function upddateLeftPaneSizeSession() {
        $session = $this->request->session();
        $leftpaneSize = $_POST['leftpaneSize'];

        $session->write("leftpaneSize", $leftpaneSize);
        $session->write("undocked", 'no');

        $this->layout = 'ajax';
        $this->render(false);
    }

    function ajaxSubCategory() {
        echo $subCategory = $this->QCValidation->find('subcategory', ['CategoryId' => $_POST['CategoryId']]);
        exit;
    }

    function ajaxqueryinsert() {

        $connection = ConnectionManager::get('default');

        if ($_POST['OldValue'] == '--') {
            $OldValue = '';
        } else {
            $OldValue = str_replace("'", "''", $_POST['OldValue']);
        }
        $QCComments = str_replace("'", "''", $_POST['QCComments']);
        //  $QCValue = str_replace("'", "''", $_POST['QCValue']);
        // $Reference = str_replace("'", "''", $_POST['Reference']);
        $createddate = date("Y-m-d H:i:s");
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $ProjectId = $_POST['ProjectId'];
        $session = $this->request->session();
        $user_id = $session->read('user_id');
        $commentsId = $_POST['CommentsId'];
        $ModifiedDate = date("Y-m-d H:i:s");
        if ($commentsId != 0) {
            $connection->execute("UPDATE MV_QC_Comments SET ProjectId = $ProjectId,ModuleId='".$_POST['QCModuleId']."', RegionId='" . $_POST['RegionId'] . "',InputEntityId='" . $_POST['InputEntityId'] . "',AttributeMasterId='" . $_POST['AttributeMasterId'] . "',ProjectAttributeMasterId='" . $_POST['ProjectAttributeMasterId'] . "',OldValue='" . trim($OldValue) . "',"
                    . "QCComments='" . trim($QCComments) . "',ErrorCategoryMasterId='" . $_POST['CategoryId'] . "' ,SubErrorCategoryMasterId='" . $_POST['SubCategoryId'] . "' ,SequenceNumber='" . $_POST['SequenceNumber'] . "' ,UserId='" . $user_id . "' ,StatusId=1 ,RecordStatus=1 ,ModifiedDate='" . $ModifiedDate . "' ,ModifiedBy=$user_id where Id = '" . $_POST['CommentsId'] . "'");
        } else {
            $connection->execute("INSERT into MV_QC_Comments (ProjectId,RegionId,ModuleId,InputEntityId,AttributeMasterId,ProjectAttributeMasterId,OldValue,QCComments,ErrorCategoryMasterId,SubErrorCategoryMasterId,SequenceNumber,UserId,StatusId,RecordStatus,CreatedDate,CreatedBy)"
                    . "values($ProjectId,'" . $_POST['RegionId'] . "','".$_POST['QCModuleId']."','" . $_POST['InputEntityId'] . "','" . $_POST['AttributeMasterId'] . "','" . $_POST['ProjectAttributeMasterId'] . "','" . trim($OldValue) . "','" . trim($QCComments) . "','" . $_POST['CategoryId'] . "','" . $_POST['SubCategoryId'] . "','" . $_POST['SequenceNumber'] . "','" . $user_id . "',1,1,'" . $createddate . "','" . $user_id . "')");
        }
        die;
    }

    function ajaxgetolddata() {
 $session = $this->request->session();
        $moduleId = $session->read("moduleId");
        $_POST['moduleId']=$moduleId;
        $result = $this->QCValidation->find('getolddata', [$_POST]);
        echo $old_data = json_encode($result);
        exit;
    }

    function ajaxgetrebutaldata() {
        $session = $this->request->session();
        $user_id = $session->read('user_id');
        
        $moduleId = $session->read("moduleId");
        $connection = ConnectionManager::get('default');

        $result = $connection->execute("Select TLReputedComments FROM MV_QC_Comments where StatusId = 3 and InputEntityId = " . $_POST['InputEntyId'] . " and AttributeMasterId=" . $_POST['AttributeMasterId'] . " and ProjectAttributeMasterId=" . $_POST['ProjectAttributeMasterId'] . " and ModuleId=$moduleId$moduleId and SequenceNumber=" . $_POST['page'] . " and UserId=" . $user_id . "")->fetchAll('assoc');
        $Comments = $result[0]['TLReputedComments'];
        $TlComments = '';
        if (!empty($Comments)) {
            $TlComments .= '<label class="col-sm-5 control-label"><b>TL Rebutal Comments</b></label>';
            $TlComments .= '<textarea style="margin-left: 5px;" disabled="" id="TLComments" name="TLComments">' . $Comments . '</textarea>';
        }
        echo $TlComments;
        exit;
    }

    function ajaxquerydelete() {

        $connection = ConnectionManager::get('default');
        $TLresult = $connection->execute("Select * FROM MV_QC_Comments where StatusId = 3 and InputEntityId = " . $_POST['InputEntityId'] . " and AttributeMasterId=" . $_POST['AttributeMasterId'] . " and ProjectAttributeMasterId=" . $_POST['ProjectAttributeMasterId'] . " and SequenceNumber=" . $_POST['SequenceNumber'] . " and UserId=" . $_POST['UserId'] . "")->fetchAll('assoc');
        $Errorresult = $connection->execute("Select * FROM MV_QC_Comments where StatusId = 1 and InputEntityId = " . $_POST['InputEntityId'] . " and AttributeMasterId=" . $_POST['AttributeMasterId'] . " and ProjectAttributeMasterId=" . $_POST['ProjectAttributeMasterId'] . " and SequenceNumber=" . $_POST['SequenceNumber'] . " and UserId=" . $_POST['UserId'] . "")->fetchAll('assoc');

        if (!empty($TLresult)) {
            $updateStatus = $connection->execute("Update MV_QC_Comments set StatusId = 0,ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=" . $_POST['UserId'] . " where InputEntityId = " . $_POST['InputEntityId'] . " and AttributeMasterId=" . $_POST['AttributeMasterId'] . " and ProjectAttributeMasterId=" . $_POST['ProjectAttributeMasterId'] . " and SequenceNumber=" . $_POST['SequenceNumber'] . " and UserId=" . $_POST['UserId'] . "");
        } else if (!empty($Errorresult)) {
            $updateStatus = $connection->execute("Update MV_QC_Comments set StatusId = 0, RecordStatus=0,ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=" . $_POST['UserId'] . " where InputEntityId = " . $_POST['InputEntityId'] . " and AttributeMasterId=" . $_POST['AttributeMasterId'] . " and ProjectAttributeMasterId=" . $_POST['ProjectAttributeMasterId'] . " and SequenceNumber=" . $_POST['SequenceNumber'] . " and UserId=" . $_POST['UserId'] . "");
        }
        exit;
    }

//    function ajaxLoadDropdown() {
//        echo $subCategory = $this->QCValidation->find('loaddropdown', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'AttributeMasterId' => $_POST['AttributeMasterId'], 'ProjectAttributeMasterId' => $_POST['ProjectAttributeMasterId'], 'SequenceNumber' => $_POST['SequenceNumber']]);
//        exit;
//    }

    function rebutalCommentsCount() {
        $ProjectId = $_POST['ProjectId'];
        $RegionId = $_POST['RegionId'];
        $InputEntityId = $_POST['InputEntityId'];
        $UserId = $_POST['UserId'];
        $SequenceNumber = $_POST['SequenceNumber'];
        $connection = ConnectionManager::get('default');

        $cnt_InputEntity_Rebutal = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE StatusID=3 AND RegionId=" . $RegionId . " AND UserId=" . $UserId . " AND ProjectId=" . $ProjectId . " AND SequenceNumber=" . $SequenceNumber . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

        $pageSequence = $connection->execute("SELECT DISTINCT SequenceNumber FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=3 AND ProjectId=" . $ProjectId . " AND UserId=" . $UserId . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');
        $seqe = array_map(current, $pageSequence);
        $commaList = implode(',', $seqe);
        if ($cnt_InputEntity_Rebutal[0]['cnt'] != 0) {
            echo $commaList;
        }
        exit;
    }
 function combineBySubGroup($keysss) {
        $mainarr = array();
        foreach ($keysss as $key => $value) {
            if (!empty($value))
                $mainarr[$value['SubGroupId']][] = $value;
        }
        return $mainarr;
    }
    
        function ajaxhelptooltip() {
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $moduleId = $session->read("moduleId");
        $ProjectId = $_POST['ProjectId'];
        $RegionId = $_POST['RegionId'];
        $AttributeId = $_POST['attributeId'];


        $file = $this->QCValidation->find('helptooltip', ['ProjectId' => $ProjectId, 'RegionId' => $RegionId, 'AttributeId' => $AttributeId]);
        echo $file;
        exit;
    }

    function searchArray($key, $st, $array) {
        foreach ($array as $k => $v) {
            if (strtolower($v[$key]) === strtolower($st)) {

                return $k;
}
        }
        return null;
    }
 
    
   function ajaxupdateacceptstatus(){
        $connection = ConnectionManager::get('default');
        $Id = $_POST['Id'];
        $updateStatus = $connection->execute("Update MV_QC_Comments set StatusId = 8 WHERE Id='".$Id."'");
        
}
   
    function ajaxupdaterejectstatus(){
        $connection = ConnectionManager::get('default');
        $Id = $_POST['Id'];
        $Comments = $_POST['comment'];
		echo "Update MV_QC_Comments set StatusId = 9,QCComments='".$Comments."' WHERE Id='".$Id."'";
        $updateStatus = $connection->execute("Update MV_QC_Comments set StatusId = 9,QCComments='".$Comments."' WHERE Id='".$Id."'");
        
   } 
   function Checkcomment(){
	   echo "hello";
   }
   
   function ajaxformsubmit(){
       
      
        $connectiond2k = ConnectionManager::get('d2k');
        $statusIdentifier = ReadyforPUReworkIdentifier;
        $session = $this->request->session();
        $moduleId = $session->read("moduleId");        
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $ProjectId = $session->read("ProjectId");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        //echo "<pre>";print_r($JsonArray);exit;        
       
        foreach($JsonArray['ModuleConfig'] as $key => $value){
            if($value['IsModuleGroup'] == '1'){
                $ProdModuleId= $key;
            }
        }
        
        /////////////d2k ///////////////////////////////////////
       //echo "SELECT Status FROM D2K_ModuleStatusMaster where ModuleId=$moduleId and ModuleStatusIdentifier='$statusIdentifier' and RecordStatus=1";exit;
        $QcFirstStatus = $connectiond2k->execute("SELECT Status FROM D2K_ModuleStatusMaster where ModuleId=$ProdModuleId and ModuleStatusIdentifier='$statusIdentifier' and RecordStatus=1")->fetchAll('assoc');
       
        $QcFirstStatus = array_map(current, $QcFirstStatus);
        $first_Status_name = $QcFirstStatus[0];        
        $stagingTable = 'Staging_' . $moduleId . '_Data';
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);
        
        
        /////////////d2k end ///////////////////////////////////////
       
        $connection = ConnectionManager::get('default');
        $rework = $_POST['rework'];
        $ProjectId = $_POST['projectId'];
        $InputEntityId = $_POST['entityId'];
        $nextId = $_POST['nextId'];
        if($rework =="rework"){
		if($InputEntityId){
		//echo "SELECT count(1) as cnt FROM MV_QC_Comments  WHERE ProjectId=" . $ProjectId . " AND  InputEntityId='" . $InputEntityId . "' AND StatusId=6";
		
            $cnt_InputEntity = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments  WHERE ProjectId=" . $ProjectId . " AND  InputEntityId='" . $InputEntityId . "' AND StatusId=6")->fetchAll('assoc');
            $cnt_InputEntityReject = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WHERE ProjectId=" . $ProjectId . " AND  InputEntityId='" . $InputEntityId . "' AND StatusId=9")->fetchAll('assoc');
            
             if($cnt_InputEntity[0]['cnt'] > 0){                   
                $SubmitInfo=0;
             }
             elseif($cnt_InputEntityReject[0]['cnt'] > 0){
                 
                $UpdateStatus= $JsonArray['ModuleStatus_Navigation'][$nextId][1];
                
                //$Updataquery = $connection->execute("UPDATE ".$stagingTable." SET StatusId=" . $UpdateStatus . "WHERE ProjectId=" . $ProjectId . " AND InputEntityId=" . $InputEntityId);
                $SubmitInfo=1;
             }             
             else{
                // $Updataquery = $connection->execute("UPDATE ".$stagingTable." SET StatusId=" . $first_Status_id . "WHERE ProjectId=" . $ProjectId . " AND InputEntityId=" . $InputEntityId);
                 $SubmitInfo=1;
             }
			 }
        }
        else{
                $SubmitInfo=1;
        }
        
        echo $SubmitInfo;
        exit;
   }
  
 function ajaxgetrebutteddata(){
     
      $connection = ConnectionManager::get('default');
      
        $ModifiedDate = date("Y-m-d H:i:s");
       $id = $_POST['id'];
	   
       $reworkCount =  $connection->execute("Select QCComments from MV_QC_Comments where   Id='".$id."'  and RecordStatus=1")->fetchAll('assoc');
      
       $getdata['QCComments'] = $reworkCount[0]['QCComments'];
        
     
        echo json_encode($getdata);
        exit; 
 }
}
