<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * Bookmarks Controller
 *
 * @property \App\Model\Table\ImportInitiates $ImportInitiates
 */
class QCValidationReworkController extends AppController {

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
        $this->loadModel('QCValidationRework');
        $this->loadModel('projectmasters');
        $this->loadModel('GetJob');
        // $this->loadHelper('Html');
        $this->loadComponent('RequestHandler');
    }

    public function index() {
        $connection = ConnectionManager::get('d2k');
        $statusIdentifier = ReadyforQCReworkIdentifier;
        $session = $this->request->session();
        $moduleId = $session->read("moduleId");
        $QcFirstStatus = $connection->execute("SELECT Status FROM D2K_ModuleStatusMaster where ModuleId=$moduleId and ModuleStatusIdentifier='$statusIdentifier' AND RecordStatus=1")->fetchAll('assoc');
        $QcFirstStatus = array_map(current, $QcFirstStatus);
        $first_Status_name = $QcFirstStatus[0];
        $connection = ConnectionManager::get('default');
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $ProjectId = $session->read("ProjectId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);
        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];
        $isHistoryTrack = $JsonArray['ModuleConfig'][$moduleId]['IsHistoryTrack'];
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
        $userList = $JsonArray['UserList'];
        $this->set('userList', $userList);
        // $frameType = 2;
        if ($frameType == 1) {
            if (isset($this->request->query['job']))
                $newJob = $this->request->query['job'];
            if (isset($this->request->data['NewJob']))
                $newJob = $this->request->data['NewJob'];
            $AttributeOrder = $JsonArray['AttributeOrder'];
            $this->set('AttributeOrder', $AttributeOrder);

            $InprogressProductionjob = $connection->execute('SELECT * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE UserId=' . $user_id . ' AND StatusId=' . $next_status_id . ' AND SequenceNumber=1 AND ProjectId=' . $ProjectId)->fetchAll('assoc');
            if (empty($InprogressProductionjob)) {
                $InprogressRebutaljob = $connection->execute('SELECT TOP 1 *  FROM MV_QC_TimeMetric where QcStatusId = 2 AND QCUSerID=' . $user_id . ' AND ProjectId=' . $ProjectId)->fetchAll('assoc');
                if (empty($InprogressRebutaljob)) {
                    $Rebutaljob = $connection->execute('SELECT TOP 1 * FROM MV_QC_TimeMetric where QcStatusId = 3 AND QCUSerID=' . $user_id . ' AND ProjectId=' . $ProjectId)->fetchAll('assoc');
                    if (empty($Rebutaljob)) {
                        $productionjob = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WHERE StatusId=' . $first_Status_id . ' AND SequenceNumber=1 AND ProjectId=' . $ProjectId)->fetchAll('assoc');
                        if (empty($productionjob)) {
                            $this->set('NoNewJob', 'NoNewJob');
                        } else {
                            foreach ($productionjob as $val) {
                                if ($val['StatusId'] == $first_Status_id && ($newJob == 'NewJob' || $newJob == 'newjob')) {
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
                                $productionjobNew = $productionjob[0];
                                $this->set('productionjob', $productionjob[0]);
                                $inputEntity = $productionjob[0]['InputEntityId'];
                                $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity)->fetchAll('assoc');
                                $QcBatchId = $BatchId[0]['Qc_Batch_Id'];
                                $ProdUserId = $BatchId[0]['UserId'];
                                $BatchName = $connection->execute('SELECT BatchName FROM MV_QC_BatchMaster WITH (NOLOCK) WHERE Id=' . $QcBatchId)->fetchAll('assoc');
                                $QcBatchName = $BatchName[0]['BatchName'];
                                $this->set('QcBatchName', $QcBatchName);
                                $this->set('ProdUserId', $ProdUserId);
                            }
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
                        $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity)->fetchAll('assoc');
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
                    $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity)->fetchAll('assoc');
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
                $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity)->fetchAll('assoc');
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
                if (count($DynamicFields) > 1) {
                    foreach ($DynamicFields as $val) {
                        $dymamicupdatetempFileds.="[" . $val['AttributeMasterId'] . "]='" . $this->request->data[$val['AttributeMasterId']] . "',";
                    }
                    $dymamicupdatetempFileds.="TimeTaken='" . $this->request->data['TimeTaken'] . "'";
                    $Dynamicproductionjob = $connection->execute('UPDATE ' . $stagingTable . ' SET ' . $dymamicupdatetempFileds . 'where ProductionEntity=' . $ProductionEntity);
                }
                $cnt_InputEntity = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE ProjectId=" . $ProjectId . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

                $cnt_InputEntity_QcError = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID IN (1,4) AND ProjectId=" . $ProjectId . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

                $cnt_InputEntity_QcError_Deleted = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=0 AND RecordStatus =1 AND ProjectId=" . $ProjectId . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

                if ($cnt_InputEntity[0]['cnt'] != 0) {

                    if ($cnt_InputEntity_QcError[0]['cnt'] != 0) {
                        $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][1];
                        $QcStatusId = 1;
                        $submitType = 'completed';
                    } else if ($cnt_InputEntity_QcError_Deleted[0]['cnt'] != 0) {
                        $status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][1];
                        $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][1];
                        $QcStatusId = 5;
                        $submitType = 'completed';
                    }
                } else {
                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][1];
                    $QcStatusId = 0;
                    $submitType = 'completed';
                }
                if ($completion_status != '') {
                    $QcIterationUpdate = $connection->execute("UPDATE MV_QC_Iteration SET QcEndDate='" . date('Y-m-d H:i:s') . "',TimeTaken='" . $this->request->data['TimeTaken'] . "',ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id WHERE InputEntityId=" . $InputEntityId);
                    $productionCompletejob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $completion_status . ",ActEnddate='" . date('Y-m-d H:i:s') . "' ,TimeTaken='" . $this->request->data['TimeTaken'] . "' WHERE ProductionEntity=" . $ProductionEntity);
                    $productionjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $completion_status . ",ProductionEndDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $ProductionEntity);
                    $productiontimemetricMain = $connection->execute("UPDATE MV_QC_TimeMetric SET StatusId=" . $completion_status . ",QcStatusId=" . $QcStatusId . ",QCEndDate='" . date('Y-m-d H:i:s') . "',QCTimeTaken='" . $this->request->data['TimeTaken'] . "' WHERE ProductionEntityID=" . $ProductionEntity . " AND Module_Id=" . $moduleId);

                    $this->redirect(array('controller' => 'QCValidationRework', 'action' => '', '?' => array('job' => $submitType)));
                    return $this->redirect(['action' => 'index']);
                    return $this->redirect(['action' => 'index']);
                }
            }

            if (empty($InprogressProductionjob) && $this->request->data['NewJob'] != 'NewJob' && !isset($this->request->data['Submit']) && $this->request->query['job'] != 'newjob') {
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
            $this->render('/QCValidationRework/index_vertical');
            /* GRID END******************************************************************************************************************************************************************* */
        } else {

            if (isset($this->request->data['clicktoviewPre'])) {
                $page = $this->request->data['page'] - 1;
                $this->redirect(array('controller' => 'QCValidationRework', 'action' => 'index/' . $page));
            }
            if (isset($this->request->data['clicktoviewNxt'])) {
                $page = $this->request->data['page'] + 1;
                $this->redirect(array('controller' => 'QCValidationRework', 'action' => 'index/' . $page));
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
                $this->redirect(array('controller' => 'QCValidationRework', 'action' => 'index/'));
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
                $InprogressRebutaljob = $connection->execute('SELECT TOP 1 *  FROM MV_QC_TimeMetric where QcStatusId = 3 AND QCUSerID=' . $user_id . ' AND ProjectId=' . $ProjectId)->fetchAll('assoc');

                if (empty($InprogressRebutaljob)) {
                    $Rebutaljob = $connection->execute('SELECT TOP 1 * FROM MV_QC_TimeMetric where QcStatusId = 3 AND QCUSerID=' . $user_id . ' AND ProjectId=' . $ProjectId)->fetchAll('assoc');

                    if (empty($Rebutaljob)) {
                        $productionjob = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE StatusId=' . $first_Status_id . ' AND SequenceNumber=' . $page . ' AND ProjectId=' . $ProjectId)->fetchAll('assoc');

                        if (empty($productionjob)) {
                            $this->set('NoNewJob', 'NoNewJob');
                        } else {
                            if ($productionjob[0]['StatusId'] == $first_Status_id && ($newJob == 'NewJob' || $newJob == 'newjob')) {
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
                            $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity)->fetchAll('assoc');
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
                        $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity)->fetchAll('assoc');
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
                    $productionjobNew = $productionjob[0];
                    $inputEntity = $productionjob[0]['InputEntityId'];
                    $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity)->fetchAll('assoc');
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
                $BatchId = $connection->execute('SELECT Qc_Batch_Id, UserId FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE InputEntityId=' . $inputEntity)->fetchAll('assoc');
                $QcBatchId = $BatchId[0]['Qc_Batch_Id'];
                $ProdUserId = $BatchId[0]['UserId'];
                $BatchName = $connection->execute('SELECT BatchName FROM MV_QC_BatchMaster WITH (NOLOCK) WHERE Id=' . $QcBatchId)->fetchAll('assoc');
                $QcBatchName = $BatchName[0]['BatchName'];
                $this->set('QcBatchName', $QcBatchName);
                $this->set('ProdUserId', $ProdUserId);
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

                $cnt_InputEntity_QcError = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID = 1 AND ProjectId=" . $ProjectId . " AND UserId=" . $user_id . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

                $cnt_InputEntity_TLAcceptError = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID IN (4,5) AND ProjectId=" . $ProjectId . " AND UserId=" . $user_id . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

                $cnt_InputEntity_QcError_Deleted = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=0 AND RecordStatus =1 AND ProjectId=" . $ProjectId . " AND UserId=" . $user_id . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

                if ($cnt_InputEntity[0]['cnt'] != 0) {
                    if ($cnt_InputEntity_QcError[0]['cnt'] != 0) {
                        $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][2][1];
                        $QcStatusId = 5;
                        $submitType = 'completed';
                    } else if ($cnt_InputEntity_QcError_Deleted[0]['cnt'] != 0) {
                        if ($cnt_InputEntity_TLAcceptError[0]['cnt'] != 0) {
                            $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][2][1];
                            $QcStatusId = 5;
                        } else {
                            $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][1];
                        }
                        $QcStatusId = 1;
                        $submitType = 'completed';
                    } else {
                        $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][1];
                        $QcStatusId = 1;
                        $submitType = 'completed';
                    }
                } else {
                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][1];
                    $QcStatusId = 0;
                    $submitType = 'completed';
                }
//                echo "completion_status";
//                pr($completion_status);
//                exit;
                if ($completion_status != '') {
                    $QcIterationUpdate = $connection->execute("UPDATE MV_QC_Iteration SET QcEndDate='" . date('Y-m-d H:i:s') . "',TimeTaken='" . $this->request->data['TimeTaken'] . "',ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id WHERE InputEntityId=" . $InputEntityId);
                    $productionCompletejob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $completion_status . ",ActEnddate='" . date('Y-m-d H:i:s') . "',ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id,TimeTaken='" . $this->request->data['TimeTaken'] . "' WHERE ProductionEntity=" . $ProductionEntity);
                    $productionjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $completion_status . ",ProductionEndDate='" . date('Y-m-d H:i:s') . "',ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id WHERE ID=" . $ProductionEntity);
                    $productiontimemetricMain = $connection->execute("UPDATE MV_QC_TimeMetric SET StatusId=" . $completion_status . ",QcStatusId=" . $QcStatusId . ",QCEndDate='" . date('Y-m-d H:i:s') . "',QCTimeTaken='" . $this->request->data['TimeTaken'] . "',ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy=$user_id WHERE ProductionEntityID=" . $ProductionEntity . " AND Module_Id=" . $moduleId);
                    $this->redirect(array('controller' => 'QCValidationRework', 'action' => '', '?' => array('job' => $submitType)));
                    return $this->redirect(['action' => 'index']);
                    //$Dynamicproductionjob = $connection->execute("UPDATE  $stagingTable  SET TimeTaken='" . $this->request->data['TimeTaken'] . "' where ProductionEntity= ".$ProductionEntity);
                }
            }

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
            $x_Array = array();
            $i = 0;
            $j = 0;
            foreach ($DynamicFields as $key => $value) {
                if ($key == 0)
                    $d = $key;
                else
                    $d = $key - 1;
                if (empty($InprogressProductionjob)) {
                    $DOldDataresult[$DynamicFields[$key]['AttributeMasterId']] = $this->QCValidationRework->ajax_GetOldDatavalue($productionjob[0][0]['InputEntityId'], $DynamicFields[$key]['AttributeMasterId'], $DynamicFields[$key]['ProjectAttributeMasterId'], 1);
                } else {
                    $DOldDataresult[$DynamicFields[$key]['AttributeMasterId']] = $this->QCValidationRework->ajax_GetOldDatavalue($InprogressProductionjob[0][0]['InputEntityId'], $DynamicFields[$key]['AttributeMasterId'], $DynamicFields[$key]['ProjectAttributeMasterId'], 1);
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
                    $OldDataresultError[$ProductionFields[$key]['AttributeMasterId']] = $this->QCValidationRework->ajax_GetOldDatavalue($productionjob[0]['InputEntityId'], $ProductionFields[$key]['AttributeMasterId'], $ProductionFields[$key]['ProjectAttributeMasterId'], 1);
                    $OldDataresultRebutal[$ProductionFields[$key]['AttributeMasterId']] = $this->QCValidationRework->ajax_GetRebutalvalue($productionjob[0]['InputEntityId'], $ProductionFields[$key]['AttributeMasterId'], $ProductionFields[$key]['ProjectAttributeMasterId'], 1);
                } else {
                    //   print_r($InprogressProductionjob);
                    $OldDataresultError[$ProductionFields[$key]['AttributeMasterId']] = $this->QCValidationRework->ajax_GetOldDatavalue($InprogressProductionjob[0]['InputEntityId'], $ProductionFields[$key]['AttributeMasterId'], $ProductionFields[$key]['ProjectAttributeMasterId'], 1);
                    $OldDataresultRebutal[$ProductionFields[$key]['AttributeMasterId']] = $this->QCValidationRework->ajax_GetRebutalvalue($InprogressProductionjob[0]['InputEntityId'], $ProductionFields[$key]['AttributeMasterId'], $ProductionFields[$key]['ProjectAttributeMasterId'], 1);
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
    }

    function ajaxqueryposing() {
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $ProjectId = $session->read("ProjectId");
        $moduleId = $session->read("moduleId");
        echo $_POST['query'];
        $file = $this->QCValidationRework->find('querypost', ['ProductionEntity' => $_POST['InputEntyId'], 'query' => $_POST['query'], 'ProjectId' => $ProjectId, 'moduleId' => $moduleId, 'user' => $user_id]);
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
            $updatetempFileds = '';
            $dymamicupdatetempFileds = '';
            $productionData = $_POST['productionData'];
            $ProductionFields = $_POST['productionData_ely'];
            $dynamicData = $_POST['dynamicData'];
            $dynamicData_ely = $_POST['dynamicData_ely'];
            foreach ($ProductionFields as $key => $val) {
                $productionData[$key] = str_replace("'", "''", $productionData[$key]);
                $productionData[$key] = str_replace("\n", " ", $productionData[$key]);
                $updatetempFileds.="[" . $val . "]=N'" . $productionData[$key] . "',";
                $IsAutoSuggesstion = $JsonArray['ValidationRules'][$ProjectAttr[$key]]['IsAutoSuggesstion'];
                $IsAllowNewValues = $JsonArray['ValidationRules'][$ProjectAttr[$key]]['IsAllowNewValues'];
                if ($IsAutoSuggesstion == '1' && $IsAllowNewValues == '1') {
                    $Value = $productionData[$key];
                    $attrmasterid = $val;
                    $Projattrmasterid = $ProjectAttr[$key];
                    $createddate = date("Y-m-d H:i:s");
                    $link = $connection->execute("SELECT count(1) as count  FROM ME_AutoSuggestionMasterlist WITH (NOLOCK) WHERE ProjectId=" . $ProjectId . " AND RegionId=" . $RegionId . " AND AttributeMasterId=" . $attrmasterid . " AND ProjectAttributeMasterId=" . $Projattrmasterid . " AND RecordStatus=1 AND Value = '" . $Value . "'")->fetchAll('assoc');
                    $valcount = $link[0]['count'];
                    if ($valcount == 0) {
                        $updateautosuggestion = $connection->execute("INSERT into ME_AutoSuggestionMasterlist (ProjectId,RegionId,AttributeMasterId,ProjectAttributeMasterId,Value,OrderId,RecordStatus,CreatedDate,CreatedBy)values ('" . $ProjectId . "','" . $RegionId . "','" . $attrmasterid . "','" . $Projattrmasterid . "','" . $Value . "','1','1','" . $createddate . "','" . $user_id . "')");
                    }
                }
            }
            foreach ($dynamicData_ely as $key => $val) {
                $dynamicData[$key] = str_replace("'", "''", $dynamicData[$key]);
                $dynamicData[$key] = str_replace("\n", " ", $dynamicData[$key]);
                $dymamicupdatetempFileds.="[" . $val . "]=N'" . $dynamicData[$key] . "',";
            }

            $updatetempFileds.="TimeTaken='" . $_POST['TimeTaken'] . "'";
            $dymamicupdatetempFileds.="TimeTaken='" . $_POST['TimeTaken'] . "'";
            $productionjob = $connection->execute('UPDATE ' . $stagingTable . ' SET ' . $updatetempFileds . 'where ProductionEntity=' . $_POST['ProductionEntity'] . ' AND SequenceNumber=' . $_POST['SequenceNumber']);
            $Dynamicproductionjob = $connection->execute('UPDATE ' . $stagingTable . ' SET ' . $dymamicupdatetempFileds . 'where ProductionEntity=' . $_POST['ProductionEntity']);
            echo 'saved';
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
            $productionjobNew = $connection->execute('SELECT * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE ProductionEntity=' . $_POST['ProductionEntity'] . ' AND SequenceNumber=' . $_POST['page'])->fetchAll('assoc');

            //echo 'select AttributeMasterId from MV_QC_Comments where InputEntityId=' . $_POST['InputEntyId'] . ' and StatusID IN (1,4,5) AND SequenceNumber=' . $_POST['page'];
            $cmdOldData = $connection->execute('select AttributeMasterId from MV_QC_Comments where InputEntityId=' . $_POST['InputEntyId'] . ' AND AttributeMasterId=' . $_POST['AttributeMasterId'] . ' AND ProjectAttributeMasterId=' . $_POST['ProjectAttributeMasterId'] . ' and StatusID IN (1,4,5) AND SequenceNumber=' . $_POST['page'])->fetchAll('assoc');
            $oldDataAttr = array_map(current, $cmdOldData);

            $OldDataId = $connection->execute('select Id from MV_QC_Comments where InputEntityId=' . $_POST['InputEntyId'] . 'AND AttributeMasterId=' . $_POST['AttributeMasterId'] . ' AND ProjectAttributeMasterId=' . $_POST['ProjectAttributeMasterId'] . ' AND SequenceNumber=' . $_POST['page'])->fetchAll('assoc');
            $oldDataAttrId = array_map(current, $OldDataId);

            $TLAcceptError = $connection->execute('select Id from MV_QC_Comments where InputEntityId=' . $_POST['InputEntyId'] . 'AND AttributeMasterId=' . $_POST['AttributeMasterId'] . ' AND ProjectAttributeMasterId=' . $_POST['ProjectAttributeMasterId'] . ' And StatusID=2 AND SequenceNumber=' . $_POST['page'])->fetchAll('assoc');
            $TLAccept = array_map(current, $TLAcceptError);

            $cmdOldDataRebutal = $connection->execute('select AttributeMasterId from MV_QC_Comments where InputEntityId=' . $_POST['InputEntyId'] . ' and AttributeMasterId=' . $_POST['AttributeMasterId'] . ' AND ProjectAttributeMasterId=' . $_POST['ProjectAttributeMasterId'] . ' and StatusID=5 AND SequenceNumber=' . $_POST['page'])->fetchAll('assoc');
            $oldDataAttrRebutal = array_map(current, $cmdOldDataRebutal);

            $getOldData['attrval'] = $productionjobNew[0];
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

            $productionjobNew = $connection->execute('SELECT BatchCreated,BatchID,ProjectId,RegionId,InputEntityId,ProductionEntity,StatusId,UserId,ActStartDate FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE ProductionEntity=' . $ProductionEntity)->fetchAll('assoc');
            //pr($productionjobNew[0]); exit;
            $refData = $productionjobNew[0];

            $seq = count($productionjobNew) + 1;
            $productionjob = $connection->execute("INSERT INTO  " . $stagingTable . "( BatchCreated,BatchID,ProjectId,RegionId,InputEntityId,ProductionEntity,SequenceNumber,StatusId,UserId,ActStartDate," . $updatetempFileds . " )values ( '" . $refData['BatchCreated'] . "'," . $refData['BatchID'] . "," . $refData['ProjectId'] . "," . $refData['RegionId'] . "," . $refData['InputEntityId'] . "," . $refData['ProductionEntity'] . "," . $seq . "," . $refData['StatusId'] . "," . $user_id . ",'" . $refData['ActStartDate'] . "'," . $valuetoInsert . ")");

            $dymamicupdatetempFileds = '';
            foreach ($dynamicData_ely as $key => $val) {
                $dymamicupdatetempFileds.="[" . $val . "]='" . str_replace("'", "''", $dynamicData[$key]) . "',";
            }

            $dymamicupdatetempFileds.="TimeTaken='" . $_POST['TimeTaken'] . "'";

            $Dynamicproductionjob = $connection->execute('UPDATE ' . $stagingTable . ' SET ' . $dymamicupdatetempFileds . 'where ProductionEntity=' . $refData['ProductionEntity']);
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
        $connection = ConnectionManager::get('d2k');
        $statusIdentifier = ReadyforQCReworkIdentifier;

        $QcFirstStatus = $connection->execute("SELECT Status FROM D2K_ModuleStatusMaster where ModuleId=$moduleId and ModuleStatusIdentifier='$statusIdentifier' AND RecordStatus=1")->fetchAll('assoc');
        $QcFirstStatus = array_map(current, $QcFirstStatus);
        $first_Status_name = $QcFirstStatus[0];
//   $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][0];
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
        $session = $this->request->session();
        $ProjectId = $session->read("ProjectId");
        $user_id = $session->read("user_id");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';

        $connection = ConnectionManager::get('d2k');
        $statusIdentifier = ReadyforQCReworkIdentifier;

        $QcFirstStatus = $connection->execute("SELECT Status FROM D2K_ModuleStatusMaster where ModuleId=$moduleId and ModuleStatusIdentifier='$statusIdentifier' AND RecordStatus=1")->fetchAll('assoc');
        $QcFirstStatus = array_map(current, $QcFirstStatus);
        $first_Status_name = $QcFirstStatus[0];
        //   $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][0];
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);
        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];
//echo "SELECT * FROM  . $stagingTable  WHERE UserId= $user_id AND StatusId=$next_status_id";
        $connection = ConnectionManager::get('default');
        $link = $connection->execute("SELECT * FROM " . $stagingTable . " WHERE UserId=" . $user_id . " AND StatusId=" . $next_status_id . "AND ProjectId=" . $ProjectId)->fetchAll('assoc');
        $RegionId = $link[0]['RegionId'];
        $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
        $ReadOnlyFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['readonly'];
        //pr($ReadOnlyFields);
        $valArr = array();
        $i = 0;
        foreach ($link as $key => $value) {
            foreach ($ProductionFields as $key2 => $val2) {
                $valArr['handson'][$i]['[' . $val2["AttributeMasterId"] . ']'] = $value[$val2["AttributeMasterId"]];
            }
            foreach ($ReadOnlyFields as $key2 => $val2) {
                $valArr['handson'][$i]['[' . $val2["AttributeMasterId"] . ']'] = $value[$val2["AttributeMasterId"]];
            }
            $valArr['handson'][$i]['DataId'] = $value['Id'];
            $valArr['handson'][$i]['TimeTaken'] = $value['TimeTaken'];
            $valArr['handson'][$i]['Id'] = $i;
            $i++;
        }
        echo json_encode($valArr);
        exit;
    }

    function ajaxsavedatahand() {
        $session = $this->request->session();
        $ProjectId = $session->read("ProjectId");
        $user_id = $session->read("user_id");
        $moduleId = $session->read("moduleId");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $connection = ConnectionManager::get('d2k');
        $statusIdentifier = ReadyforQCReworkIdentifier;

        $QcFirstStatus = $connection->execute("SELECT Status FROM D2K_ModuleStatusMaster where ModuleId=$moduleId and ModuleStatusIdentifier='$statusIdentifier' AND RecordStatus=1")->fetchAll('assoc');
        $QcFirstStatus = array_map(current, $QcFirstStatus);
        $first_Status_name = $QcFirstStatus[0];
        //$first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][0];
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);
        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];
        $stagingTable = 'Staging_' . $moduleId . '_Data';
        $connection = ConnectionManager::get('default');
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
        echo $subCategory = $this->QCValidationRework->find('subcategory', ['CategoryId' => $_POST['CategoryId']]);
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
            $connection->execute("UPDATE MV_QC_Comments SET ProjectId = $ProjectId, RegionId='" . $_POST['RegionId'] . "',InputEntityId='" . $_POST['InputEntityId'] . "',AttributeMasterId='" . $_POST['AttributeMasterId'] . "',ProjectAttributeMasterId='" . $_POST['ProjectAttributeMasterId'] . "',OldValue='" . trim($OldValue) . "',"
                    . "QCComments='" . trim($QCComments) . "', TLReputedComments='', UserReputedComments='',ErrorCategoryMasterId='" . $_POST['CategoryId'] . "' ,SubErrorCategoryMasterId='" . $_POST['SubCategoryId'] . "' ,SequenceNumber='" . $_POST['SequenceNumber'] . "' ,UserId='" . $user_id . "' ,StatusId=1 ,RecordStatus=1 ,ModifiedDate='" . $ModifiedDate . "' ,ModifiedBy=$user_id where Id = '" . $_POST['CommentsId'] . "'");
        } else {
            $connection->execute("INSERT into MV_QC_Comments (ProjectId,RegionId,InputEntityId,AttributeMasterId,ProjectAttributeMasterId,OldValue,QCComments,ErrorCategoryMasterId,SubErrorCategoryMasterId,SequenceNumber,UserId,StatusId,RecordStatus,CreatedDate,CreatedBy)"
                    . "values($ProjectId,'" . $_POST['RegionId'] . "','" . $_POST['InputEntityId'] . "','" . $_POST['AttributeMasterId'] . "','" . $_POST['ProjectAttributeMasterId'] . "','" . trim($OldValue) . "','" . trim($QCComments) . "','" . $_POST['CategoryId'] . "','" . $_POST['SubCategoryId'] . "','" . $_POST['SequenceNumber'] . "','" . $user_id . "',1,1,'" . $createddate . "','" . $user_id . "')");
        }
        die;
    }

    function ajaxgetolddata() {
        $result = $this->QCValidationRework->find('getolddata', [$_POST]);
        echo $old_data = json_encode($result);
        exit;
    }

    function ajaxgetrebutaldata() {
        $session = $this->request->session();
        $user_id = $session->read('user_id');
        $connection = ConnectionManager::get('default');
        $result = $connection->execute("Select TLReputedComments FROM MV_QC_Comments where StatusId = 3 and InputEntityId = " . $_POST['InputEntyId'] . " and AttributeMasterId=" . $_POST['AttributeMasterId'] . " and ProjectAttributeMasterId=" . $_POST['ProjectAttributeMasterId'] . " and SequenceNumber=" . $_POST['page'] . " and UserId=" . $user_id . "")->fetchAll('assoc');
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
        $TLresult = $connection->execute("Select * FROM MV_QC_Comments where StatusId IN (3,4,5) and InputEntityId = " . $_POST['InputEntityId'] . " and AttributeMasterId=" . $_POST['AttributeMasterId'] . " and ProjectAttributeMasterId=" . $_POST['ProjectAttributeMasterId'] . " and SequenceNumber=" . $_POST['SequenceNumber'] . "")->fetchAll('assoc');
        $Errorresult = $connection->execute("Select * FROM MV_QC_Comments where StatusId = 1 and InputEntityId = " . $_POST['InputEntityId'] . " and AttributeMasterId=" . $_POST['AttributeMasterId'] . " and ProjectAttributeMasterId=" . $_POST['ProjectAttributeMasterId'] . " and SequenceNumber=" . $_POST['SequenceNumber'] . "")->fetchAll('assoc');

        if (!empty($TLresult)) {
            $updateStatus = $connection->execute("Update MV_QC_Comments set StatusId = 0,ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy='" . $_POST['UserId'] . "' where InputEntityId = " . $_POST['InputEntityId'] . " and AttributeMasterId=" . $_POST['AttributeMasterId'] . " and ProjectAttributeMasterId=" . $_POST['ProjectAttributeMasterId'] . " and SequenceNumber=" . $_POST['SequenceNumber'] . "");
        } else if (!empty($Errorresult)) {
            $updateStatus = $connection->execute("Update MV_QC_Comments set StatusId = 0, RecordStatus=0,ModifiedDate='" . date('Y-m-d H:i:s') . "',ModifiedBy='" . $_POST['UserId'] . "' where InputEntityId = " . $_POST['InputEntityId'] . " and AttributeMasterId=" . $_POST['AttributeMasterId'] . " and ProjectAttributeMasterId=" . $_POST['ProjectAttributeMasterId'] . " and SequenceNumber=" . $_POST['SequenceNumber'] . "");
        }
        exit;
    }

//    function ajaxLoadDropdown() {
//        echo $subCategory = $this->QCValidationRework->find('loaddropdown', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'AttributeMasterId' => $_POST['AttributeMasterId'], 'ProjectAttributeMasterId' => $_POST['ProjectAttributeMasterId'], 'SequenceNumber' => $_POST['SequenceNumber']]);
//        exit;
//    }

    function rebutalCommentsCount() {
        $ProjectId = $_POST['ProjectId'];
        $RegionId = $_POST['RegionId'];
        $InputEntityId = $_POST['InputEntityId'];
        $UserId = $_POST['UserId'];
        $SequenceNumber = $_POST['SequenceNumber'];
        $connection = ConnectionManager::get('default');
        $cnt_InputEntity_Rebutal = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE StatusID=5 AND RegionId=" . $RegionId . " AND UserId=" . $UserId . " AND ProjectId=" . $ProjectId . " AND SequenceNumber=" . $SequenceNumber . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');

        $pageSequence = $connection->execute("SELECT DISTINCT SequenceNumber FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=5 AND ProjectId=" . $ProjectId . " AND UserId=" . $UserId . " AND  InputEntityId='" . $InputEntityId . "'")->fetchAll('assoc');
        $seqe = array_map(current, $pageSequence);
        $commaList = implode(',', $seqe);

        if ($cnt_InputEntity_Rebutal[0]['cnt'] != 0) {
            echo $commaList;
        }
        exit;
    }

}
