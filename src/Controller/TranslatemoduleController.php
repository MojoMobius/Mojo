<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Hash;

//require_once __DIR__ . '/vendor/autoload.php';
//require_once(ROOT . DS . 'vendor' . DS . 'mpdf' . DS . 'library_vendor' . DS . 'autoload.php');

/**
 * Bookmarks Controller
 *
 * @property \App\Model\Table\ImportInitiates $ImportInitiates
 */
class TranslatemoduleController extends AppController {

    /**
     * to initialize the model/utilities gonna to be used this page
     */
    public $paginate = [
        'limit' => 10,
        'order' => [
            'Id' => 'asc'
        ]
    ];
    public $validation_apiurl = "http://52.66.118.29:8080/mojo_validation/validation/mojo_input/";

    public function initialize() {
        parent::initialize();
        $this->loadModel('GetJob');
        $this->loadModel('Getjobcore');
        // $this->loadHelper('Html');
        $this->loadComponent('RequestHandler');
    }

    public function index() {

        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $ProjectId = $session->read("ProjectId");
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][0];
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);
        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];
        $isHistoryTrack = $JsonArray['ModuleConfig'][$moduleId]['IsHistoryTrack'];
        $this->set('ModuleAttributes', $JsonArray['ModuleAttributes'][12][$moduleId]['production']);
        $moduleName = $JsonArray['Module'][$moduleId];
        $this->set('moduleName', $moduleName);
        $frameType = $JsonArray['ProjectConfig']['IsBulk'];
        $limit = 1;
        $frameType = $JsonArray['ProjectConfig']['ProductionView'];
        $domainId = $JsonArray['ProjectConfig']['DomainId'];
        $domainUrl = $JsonArray['ProjectConfig']['DomainUrl'];


        if (isset($this->request->data['translate']) || isset($this->request->data['viewpdf'])) {

            $mpdf = new \Mpdf\Mpdf();
            $strContent = $this->request->data['translatehtml'];
            $pdffilename = $this->request->data['pdffilename'];
            $pdffilename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $pdffilename);
            $pdffilename = $pdffilename . '.pdf';

            $mpdf->WriteHTML($strContent);
            $uploadFolder = "InputFiles";

            if (!file_exists($uploadFolder)) {
                mkdir($uploadFolder, 0777, true);
            }
            $mpdf->Output($uploadFolder . DS . $pdffilename);
            if (isset($this->request->data['viewpdf'])) {
                $link = DS . $uploadFolder . DS . $pdffilename;
                return $this->redirect($link);
            }

            $this->Flash->success('The File has been saved.');
            return $this->redirect(['action' => 'index']);
        }


        if ($frameType == 1) {
            if (isset($this->request->query['job']))
                $newJob = $this->request->query['job'];
            if (isset($this->request->data['NewJob']))
                $newJob = $this->request->data['NewJob'];
            $InprogressProductionjob = $connection->execute('SELECT special FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE UserId=' . $user_id . ' AND StatusId=' . $next_status_id . ' AND SequenceNumber=1 AND ProjectId=' . $ProjectId)->fetchAll('assoc');
            exit;
            if (empty($InprogressProductionjob)) {
                $productionjob = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WHERE StatusId=' . $first_Status_id . ' AND SequenceNumber=1 AND ProjectId=' . $ProjectId)->fetchAll('assoc');

                if (empty($productionjob)) {
                    $this->set('NoNewJob', 'NoNewJob');
                } else {
                    foreach ($productionjob as $val) {
                        if ($val['StatusId'] == $first_Status_id && ($newJob == 'NewJob' || $newJob == 'newjob')) {

                            $productionCompletejob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $next_status_id . ",UserId=" . $user_id . ",ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $val['ProductionEntity']);
                            $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $next_status_id . ",ProductionStartDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $val['ProductionEntity']);
                            $productiontimemetricMain = $connection->execute("UPDATE ME_Production_TimeMetric SET StatusId=" . $next_status_id . ",UserId=" . $user_id . ",Start_Date='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntityID=" . $val['ProductionEntity'] . " AND Module_Id=" . $moduleId);
                            $productionjob[0]['StatusId'] = $next_status_id;
                            $productionjob[0]['StatusId'] = 'Production In Progress';
                        }
                    }
                    $productionjobNew = $productionjob[0];
                    $this->set('productionjob', $productionjob[0]);
                }
            } else {
                $this->set('getNewJOb', '');
                $this->set('productionjob', $InprogressProductionjob[0]);
                $productionjobNew = $InprogressProductionjob[0];
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
                $queryStatus = $connection->execute("SELECT count(1) as cnt FROM ME_UserQuery WITH (NOLOCK) WHERE StatusID=1 AND ProjectId=" . $ProjectId . " AND  ProductionEntityId='" . $productionjobNew['ProductionEntity'] . "'")->fetchAll('assoc');
                if ($queryStatus[0]['cnt'] > 0) {
                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][2][1];
//                    $completion_status = $queryStatusId;
                    $submitType = 'query';
                } else {
                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][1];
                    $submitType = 'completed';
                }
                $productionCompletejob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $completion_status . ",ActEnddate='" . date('Y-m-d H:i:s') . "' ,TimeTaken='" . $this->request->data['TimeTaken'] . "' WHERE ProductionEntity=" . $ProductionEntity);
                $productionjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $completion_status . ",ProductionEndDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $ProductionEntity);
                $productiontimemetricMain = $connection->execute("UPDATE ME_Production_TimeMetric SET StatusId=" . $completion_status . ",End_Date='" . date('Y-m-d H:i:s') . "',TimeTaken='" . $this->request->data['TimeTaken'] . "' WHERE ProductionEntityID=" . $ProductionEntity . " AND Module_Id=" . $moduleId);

                $this->redirect(array('controller' => 'Getjobcore', 'action' => '', '?' => array('job' => $submitType)));
                return $this->redirect(['action' => 'index']);
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
                    CASE($IsAlphabet == 0 && $IsNumeric == 0 && $IsSpecialCharacter == 1):
                        $FunctionName = 'SpecialOnly';
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
            $this->render('/Getjobcore/index_vertical');
            /* GRID END******************************************************************************************************************************************************************* */
        } elseif ($frameType == 2) {

            if (isset($this->request->data['clicktoviewPre'])) {
                $page = $this->request->data['page'] - 1;
                $this->redirect(array('controller' => 'Getjobcore', 'action' => 'index/' . $page));
            }
            if (isset($this->request->data['clicktoviewNxt'])) {
                $page = $this->request->data['page'] + 1;
                $this->redirect(array('controller' => 'Getjobcore', 'action' => 'index/' . $page));
            }

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
                $this->redirect(array('controller' => 'Getjobcore', 'action' => 'index/'));
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
            $InprogressProductionjob = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE StatusId=' . $next_status_id . ' AND SequenceNumber=' . $page . ' AND ProjectId=' . $ProjectId . ' AND UserId= ' . $user_id)->fetchAll('assoc');
            if (empty($InprogressProductionjob)) {
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
                        $inprogressjob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $next_status_id . ",UserId=" . $user_id . ",ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $productionjob[0]['ProductionEntity']);
                        $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $next_status_id . ",ProductionStartDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $productionjob[0]['ProductionEntity']);
                        $productiontimemetricMain = $connection->execute("UPDATE ME_Production_TimeMetric SET StatusId=" . $next_status_id . ",UserId=" . $user_id . ",Start_Date='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntityID=" . $productionjob[0]['ProductionEntity'] . " AND Module_Id=" . $moduleId);
                        $productionjob[0]['StatusId'] = $next_status_id;
                        $productionjob[0]['StatusId'] = 'Production In Progress';
                    }
                    $productionjobNew = $productionjob[0];
                    $this->set('productionjob', $productionjob[0]);
                }
            } else {
                $this->set('getNewJOb', '');
                $this->set('productionjob', $InprogressProductionjob[0]);
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
            // pr($this->request->data);
//            exit;
            $productionjobId = $this->request->data['ProductionId'];
            $ProductionEntity = $this->request->data['ProductionEntity'];
            $productionjobStatusId = $this->request->data['StatusId'];
            if (isset($this->request->data['Submit'])) {
                $queryStatus = $connection->execute("SELECT count(1) as cnt FROM ME_UserQuery WITH (NOLOCK) WHERE  StatusID=1 AND ProjectId=" . $ProjectId . " AND  ProductionEntityId='" . $productionjobNew['ProductionEntity'] . "'")->fetchAll('assoc');
                ;
                if ($queryStatus[0]['cnt'] > 0) {
//                    $completion_status = $queryStatusId;
                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][2][1];
                    $submitType = 'query';
                } else {
                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][1];
                    $submitType = 'completed';
                }

                //$Dynamicproductionjob = $connection->execute("UPDATE  $stagingTable  SET TimeTaken='" . $this->request->data['TimeTaken'] . "' where ProductionEntity= ".$ProductionEntity);
                $productionCompletejob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $completion_status . ",ActEnddate='" . date('Y-m-d H:i:s') . "',TimeTaken='" . $this->request->data['TimeTaken'] . "' WHERE ProductionEntity=" . $ProductionEntity);
                $productionjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $completion_status . ",ProductionEndDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $ProductionEntity);
                $productiontimemetricMain = $connection->execute("UPDATE ME_Production_TimeMetric SET StatusId=" . $completion_status . ",End_Date='" . date('Y-m-d H:i:s') . "',TimeTaken='" . $this->request->data['TimeTaken'] . "' WHERE ProductionEntityID=" . $ProductionEntity . " AND Module_Id=" . $moduleId);
                $this->redirect(array('controller' => 'Getjobcore', 'action' => '', '?' => array('job' => $submitType)));
                return $this->redirect(['action' => 'index']);
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
                    CASE($IsAlphabet == 0 && $IsNumeric == 0 && $IsSpecialCharacter == 1):
                        $FunctionName = 'SpecialOnly';
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
                    CASE($IsAlphabet == 0 && $IsNumeric == 0 && $IsSpecialCharacter == 1):
                        $FunctionName = 'SpecialOnly';
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
            $this->set('ProductionFields', $ProductionFields);
            $this->set('DynamicFields', $DynamicFields);
            $this->set('Mandatory', $Mandatory);
            $this->set('AutoSuggesstion', $AutoSuggesstion);
            $this->set('ReadOnlyFields', $ReadOnlyFields);
            $this->set('session', $session);
            $dynamicData = $SequenceNumber[0];
            $this->set('dynamicData', $dynamicData);
        } else {

            //----------------------------------$frameType == 3------------------------------//
            $distinct = $this->GetJob->find('getDistinct', ['ProjectId' => $ProjectId]);
            $this->set('distinct', $distinct);
            $this->viewBuilder()->layout('boostrap-default');
            if (isset($this->request->data['clicktoviewPre'])) {
                $page = $this->request->data['page'] - 1;
                $this->redirect(array('controller' => 'Getjobcore', 'action' => 'index/' . $page));
            }
            if (isset($this->request->data['clicktoviewNxt'])) {
                $page = $this->request->data['page'] + 1;
                $this->redirect(array('controller' => 'Getjobcore', 'action' => 'index/' . $page));
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

            $connection = ConnectionManager::get('d2k');
            $statusIdentifier = ReadyforPUReworkIdentifier;
            $session = $this->request->session();
            $moduleId = $session->read("moduleId");

            $PuReworkFirstStatus = $connection->execute("SELECT Status FROM D2K_ModuleStatusMaster where ModuleId=$moduleId and ModuleStatusIdentifier='$statusIdentifier' AND RecordStatus=1")->fetchAll('assoc');
            $PuFirst_Status_id = array();
            $PuNext_Status_ids = array();
            if (!empty($PuReworkFirstStatus)) {
                $PuReworkFirstStatus = array_map(current, $PuReworkFirstStatus);
                foreach ($PuReworkFirstStatus as $val) {
                    if (array_search($val, $JsonArray['ProjectStatus']))
                        $PuFirst_Status_id[] = array_search($val, $JsonArray['ProjectStatus']);
                }
                $PuFirst_Status_ids = implode(',', $PuFirst_Status_id);

                foreach ($PuFirst_Status_id as $val) {
                    if ($JsonArray['ModuleStatus_Navigation'][$val][1])
                        $PuNextStatusId[] = $JsonArray['ModuleStatus_Navigation'][$val][1];
                }
                $PuNext_Status_ids = implode(',', $PuNextStatusId);
            }

            if (!empty($PuFirst_Status_ids)) {
                $first_Status_id = $first_Status_id . ',' . $PuFirst_Status_ids;
            } else {
                $first_Status_id = $first_Status_id;
            }

            if (!empty($PuNext_Status_ids)) {
                $next_status_id = $next_status_id . ',' . $PuNext_Status_ids;
            } else {
                $next_status_id = $next_status_id;
            }

            $connection = ConnectionManager::get('default');
            $InprogressProductionjob = $connection->execute('SELECT  top 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE StatusId IN (' . $next_status_id . ') AND ProjectId=' . $ProjectId . ' AND UserId= ' . $user_id . ' Order by ProductionEntity,StatusId Desc')->fetchAll('assoc');
            //pr($InprogressProductionjob);

            if (empty($InprogressProductionjob)) {
                $productionjob = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE StatusId IN (' . $first_Status_id . ') AND ProjectId=' . $ProjectId . ' Order by ProductionEntity,StatusId Desc')->fetchAll('assoc');
                $FirstStatusId[] = $productionjob[0]['StatusId'];
                $FirstStatus = $productionjob[0]['StatusId'];
                $NextStatusId = $JsonArray['ModuleStatus_Navigation'][$FirstStatus][1];

                $ProductionEntityStatus = array_intersect($FirstStatusId, $PuFirst_Status_id);

                $moduleStatus = $FirstStatus;
                $moduleStatusName = $JsonArray['ProjectStatus'][$moduleStatus];

                if (empty($productionjob)) {
                    $this->set('NoNewJob', 'NoNewJob');
                } else {
                    if ($productionjob[0]['StatusId'] == $FirstStatus && ($newJob == 'NewJob' || $newJob == 'newjob')) {
                        $inprogressjob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $NextStatusId . ",UserId=" . $user_id . ",ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $productionjob[0]['ProductionEntity']);
                        if (empty($ProductionEntityStatus)) {
                            $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $NextStatusId . ",ProductionStartDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $productionjob[0]['ProductionEntity']);
                        } else {
                            $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $NextStatusId . " WHERE ID=" . $productionjob[0]['ProductionEntity']);
                        }

                        $productiontimemetricMain = $connection->execute("UPDATE ME_Production_TimeMetric SET StatusId=" . $NextStatusId . ",UserId=" . $user_id . ",Start_Date='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntityID=" . $productionjob[0]['ProductionEntity'] . " AND Module_Id=" . $moduleId);
                        $productionjob[0]['StatusId'] = $NextStatusId;
                        $productionjob[0]['StatusId'] = 'Production In Progress';
                    }
                    $InprogressProductionjob = $connection->execute('SELECT * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE StatusId IN (' . $NextStatusId . ') AND ProjectId=' . $ProjectId . ' AND UserId= ' . $user_id . 'Order by ProductionEntity,StatusId Desc')->fetchAll('assoc');
                    $productionjobNew = $InprogressProductionjob;
                    $this->set('productionjob', $productionjob[0]);
                }
            } else {

                $InprogressProductionjob = $connection->execute('SELECT * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE StatusId IN (' . $next_status_id . ')  AND ProjectId=' . $ProjectId . ' AND UserId= ' . $user_id . 'Order by ProductionEntity,StatusId Desc')->fetchAll('assoc');
                $this->set('getNewJOb', '');
                $this->set('productionjob', $InprogressProductionjob[0]);
                $productionjobNew = $InprogressProductionjob;
                $moduleStatus = $productionjobNew[0]['StatusId'];
                $moduleStatusName = $JsonArray['ProjectStatus'][$moduleStatus];
                $connection = ConnectionManager::get('d2k');
                $module = $connection->execute("SELECT ProjectEntityStatusMaster.Status FROM D2K_ModuleStatusMaster inner join d2k_projectmodulestatusmapping on D2K_ModuleStatusMaster.Id = D2K_ProjectModuleStatusMapping.ModuleStatusId inner join projectentitystatusmaster on projectentitystatusmaster.id = D2K_ProjectModuleStatusMapping.ProjectStatusId where D2K_ModuleStatusMaster.status = '" . $moduleStatusName . "'")->fetchAll('assoc');
                $moduleStatusName = $module[0]['Status'];
            }

            if ($moduleStatusName != '') {
                $connection = ConnectionManager::get('d2k');
                $QcCommentsModuleId = $connection->execute("SELECT ModuleId from D2K_ModuleStatusMaster where Status = '" . $moduleStatusName . "' Order by ModuleId desc")->fetchAll('assoc');
                $QcCommentsModuleId = $QcCommentsModuleId[0]['ModuleId'];
                $this->set('QcCommentsModuleId', $QcCommentsModuleId);
            }

            $connection = ConnectionManager::get('default');
            $RegionId = $productionjobNew[0]['RegionId'];
            $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
            $AttributeGroupMaster = $JsonArray['AttributeGroupMaster'];
            $AttributeGroupMaster = $AttributeGroupMaster[$moduleId];
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
            $this->set('ModuleAttributes', $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production']);
            $StaticFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['static'];
            $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
//            $ReadOnlyFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['readonly'];
            //pr($productionjobNew);
            //exit;
            if ($productionjobNew) {

                $DependentMasterIdsQuery = $connection->execute('SELECT Id,Type,DisplayInProdScreen,FieldTypeName FROM MC_DependencyTypeMaster where ProjectId=' . $ProjectId . '')->fetchAll('assoc');
                $DependentMasterIds = $staticDepenIds = array();
                foreach ($DependentMasterIdsQuery as $vals) {
                    if ($vals['DisplayInProdScreen'] == 1)
                        $DependentMasterIds[$vals['Type']] = $vals['Id'];

                    if ($vals['Type'] == "InputValue")
                        $staticDepenIds[] = $vals['Id'];

                    if ($vals['FieldTypeName'] == "General")
                        $staticDepenIds[] = $vals['Id'];
                }
                $InputEntityId = $productionjobNew[0]['InputEntityId'];
                $maxSeq = array();
                $tempDep = '';
                $finalprodValue = array();

                //pr($finalprodValue);
                $staticFields = array();
                $static = 0;
                foreach ($StaticFields as $key => $value) {
                    foreach ($staticDepenIds as $depkey => $depval) {
                        if ($finalprodValue[$value['AttributeMasterId']][1][$depval] != '') {
                            $staticFields[$static] = $finalprodValue[$value['AttributeMasterId']][1][$depval];
                            $static++;
                        }
                    }
                }

                $DependancyId = $DependentMasterIds['InputValue'];
                $getDomainUrlVal = $finalprodValue[$domainUrl][1][$DependancyId];


                $html = strpos($getDomainUrlVal, '.html');
                if (empty($html)) {
                    $pos = strpos($getDomainUrlVal, 'http');
                    if ($pos === false) {
                        $SelDomainUrl = "http://" . $getDomainUrlVal;
                    } else {
                        $SelDomainUrl = $getDomainUrlVal;
                    }
                } else {
                    // echo 'coming';
                    $SelDomainUrl = "";
                }

//                pr($finalprodValue);
//               exit;
                $this->set('DependentMasterIds', $DependentMasterIds);
                $this->set('processinputdata', $finalprodValue);
                $this->set('GrpSercntArr', $finalGrpprodValue);
                $this->set('staticFields', $staticFields);
                $this->set('getDomainUrl', $SelDomainUrl);
                $this->set('maxSeq', $maxSeq);
                $TimeTaken = $productionjobNew[0]['TimeTaken'];
                $this->set('TimeTaken', $TimeTaken);
                $QueryDetails = array();
                $QueryDetails = $connection->execute("SELECT TLComments,Query,StatusID FROM ME_UserQuery WITH (NOLOCK) WHERE   ProductionEntityId=" . $productionjobNew[0]['ProductionEntity'])->fetchAll('assoc');
                $this->set('QueryDetails', $QueryDetails[0]);
                $HelpContantDetails = array();
                $HelpContantDetails = $connection->execute("SELECT Id,AttributeMasterId FROM MC_CengageHelp WHERE ProjectId = " . $ProjectId . " AND RegionId = " . $RegionId . " AND RecordStatus=1")->fetchAll('assoc');
                foreach ($HelpContantDetails as $HelpContantId):
                    $HelpContId[] = $HelpContantId['AttributeMasterId'];
                endforeach;
                $this->set('HelpContantDetails', $HelpContId);
            }

            $productionjobId = $this->request->data['ProductionId'];
            $ProductionEntity = $this->request->data['ProductionEntityID'];
            $productionjobStatusId = $this->request->data['StatusId'];
            $CompletionStatusId = $productionjobNew[0]['StatusId'];

            $CompletionStatusEntity[] = $productionjobNew[0]['StatusId'];

            $ProductionEntityStatusCompleted = array_intersect($CompletionStatusEntity, $PuNextStatusId);

            $QcbatchId = $connection->execute("SELECT Qc_Batch_Id FROM ME_Production_TimeMetric WITH (NOLOCK) WHERE  InputEntityId='" . $InputEntityId . "' and Qc_Batch_Id!=''")->fetchAll('assoc');
            $QcbatchId = $QcbatchId[0]['Qc_Batch_Id'];

            if (!empty($QcbatchId)) {
                $QcCompletedCount = $connection->execute("SELECT QCCompletedCount FROM MV_QC_BatchMaster WITH (NOLOCK) WHERE  Id='" . $QcbatchId . "'")->fetchAll('assoc');
                $QcCompletedCount = $QcCompletedCount[0]['QCCompletedCount'];
                $QcCompletedCount = $QcCompletedCount + 1;
            }

            if (empty($InprogressProductionjob) && $this->request->data['NewJob'] != 'NewJob' && !isset($this->request->data['Submit']) && $this->request->query['job'] != 'newjob') {
                $this->set('getNewJOb', 'getNewJOb');
            } else {
                $this->set('getNewJOb', '');
            }
            $validate = array();

            $this->set('QcErrorComments', $QcErrorComments);
            $this->set('validate', $validate);
            $this->set('ProductionFields', $ProductionFields);



            $this->set('session', $session);
            $dynamicData = $SequenceNumber[0];
            $this->set('dynamicData', $dynamicData);

            foreach ($PuNextStatusId as $val) {
                if (($BatchRejectionStatus == 2) && ($productionjobNew[0]['StatusId'] == $val)) {
                    $this->render('/Getjobcore/index');
                } else if ($productionjobNew[0]['StatusId'] == $val) {
                    $this->render('/Getjobcore/index_rework');
                }
            }
        }
    }

    function ajaxgeapivalidationremovekey($project_scope_id, $listdata) {

        if (!empty($listdata)) {
            foreach ($listdata as $key => $val) {
                foreach ($val as $key1 => $val1) {
                    foreach ($val1 as $key2 => $val2) {
                        unset($listdata[$key][$key1][$key2]['key']);
                    }
                }
            }
        }
        $list[$project_scope_id] = $listdata;
        $lists['array'] = $list;
        return $lists;
    }

    function ajaxgeapivalidation() {
        $connection = ConnectionManager::get('default');
        $listdata = $_POST['listdata'];
        $listdata_back = $_POST['listdata'];
        $project_scope_id = $_POST['project_scope_id'];
        $listdata = $this->ajaxgeapivalidationremovekey($project_scope_id, $listdata);
        $listdata_json = json_encode($listdata);
//      echo "<pre>";
//      print_r($listdata_json);exit;

        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL,"http://localhost/project/api.php");
        curl_setopt($ch, CURLOPT_URL, $this->validation_apiurl);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);

        //attach encoded JSON string to the POST fields
//        curl_setopt($ch, CURLOPT_POSTFIELDS,"postvar1=value1&postvar2=value2&postvar3=value3");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "mojo_json=$listdata_json");

        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);

        curl_close($ch);
        $result = json_decode($server_output, true);
        $res_array = $result["Validation Output"];
        if (!empty($res_array)) {
            foreach ($res_array as $key => $val) {
                foreach ($val as $key1 => $val1) {
                    foreach ($val1 as $key2 => $val2) {

                        $res_array[$key][$key1][$key2]['ext'] = implode(",", array_keys($val2));
                        $res_array[$key][$key1][$key2]['key'] = $listdata_back[$key][$key1][$key2]["key"];

                        $array_pagination_cls = explode("_", $res_array[$key][$key1][$key2]["key"]);
                        unset($array_pagination_cls[1]);
                        $res_array[$key][$key1][$key2]['pagination_key'] = implode("_", $array_pagination_cls);

                        foreach ($val2 as $key3 => $val3) {
                            $txt = implode("<br>", $val3['error']);
                            $res_array[$key][$key1][$key2][$key3]['error_txt'] = $txt;
                        }
                    }
                }
            }
        }

        $result["Validation Output"] = $res_array;
        echo json_encode($result);
        exit;
    }

    public function getdataqccommentpurebuttal($InputEntyId, $AttributeMasterId, $ProjectAttributeMasterId, $SequenceNumber) {


        $connection = ConnectionManager::get('default');

        $cmdOldData = $connection->execute("select mvc.QCComments from MV_QC_Comments as mvc inner join MV_QC_ErrorCategoryMaster as mve on mvc.ErrorCategoryMasterId = mve.Id where mvc.AttributeMasterId = $AttributeMasterId and mvc.ProjectAttributeMasterId=$ProjectAttributeMasterId and mvc.InputEntityId=$InputEntyId and SequenceNumber =$SequenceNumber and mvc.StatusID IN (1) order by mvc.SequenceNumber")->fetchAll('assoc');
        $status = 0;
        if (!empty($cmdOldData)) {
            $status = 1;
        }
        return $status;
    }

    function combineBySubGroup($keysss) {
        $mainarr = array();
        foreach ($keysss as $key => $value) {
            if (!empty($value))
                $mainarr[$value['SubGroupId']][] = $value;
        }
        return $mainarr;
    }

    function xml2array($xmlObject, $out = array()) {
        foreach ((array) $xmlObject as $index => $node)
            $out[$index] = ( is_object($node) ) ? $this->xml2array($node) : $node;

        return $out;
    }

}
