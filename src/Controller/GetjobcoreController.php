<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Hash;
use Cake\View\Helper\BreadcrumbsHelper;
use DateTime;
use DatePeriod;
use DateInterval;

/**
 * Bookmarks Controller
 *ajx
 * @property \App\Model\Table\ImportInitiates $ImportInitiates
 */
class GetjobcoreController extends AppController {

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
       // $this->loadHelper('Breadcrumb', ['className' => 'Breadcrumb.Breadcrumb']);
    }
    
    
  function searchForId($id, $array) {
   foreach ($array as $key => $val) {
    
       if ($val['AttributeMasterId'] == $id) {
           return $val['ProjectAttributeMasterId'];
       }
   }
   return null;
}





    public function index() {
      // $this->request->query['menu'];
      //exit; 
       
    
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        
        $ProjectId = $session->read("ProjectId");
        $moduleId = $session->read("moduleId");
        //echo $this->request->here; exit;
        $stagingTable = 'Staging_' . $moduleId . '_Data';
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $ctrl = $this->request->controller; //exit;
        //echo $action = $this->request->action; exit;
        $avail_menus = $this->SearchValue($Menu,  strtolower($ctrl_act));
        $isHistoryTrack = $JsonArray['ModuleConfig'][$moduleId]['IsHistoryTrack'];
		$LevelModule = $JsonArray['ModuleConfig'][$moduleId]['Level'];

//		$this->set('levelModule', $LevelModule);

			//		$LevelModule = 1;
		$this->set('levelModule', $LevelModule);		
		$this->set('ModuleId', $moduleId);

        $FromStatus = $JsonArray['ModuleConfig'][$moduleId]['FromStatus'];
	//	exit;
        if ($FromStatus == '') {
            $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][0];
            $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);
            $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
            $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];
        } else {
            $first_Status_id = $FromStatus;
            $FromStatusArr = explode(',', $FromStatus);
            //pr($FromStatusArr);
            foreach ($FromStatusArr as $val) {

                $next_status_idArr[] = $JsonArray['ModuleStatus_Navigation'][$val][1];
            }
            $next_status_id = implode(',', $next_status_idArr);
        }
        
//////rent calculation////
         $RentAttribute = $connection->execute('SELECT * FROM RentCalc_Config  WHERE ProjectId=' . $ProjectId . '')->fetchAll('assoc');
         $Commencement=$RentAttribute[0]['Commencement_Date_AttrId'];
         $Expiration=$RentAttribute[0]['Expiration_Date_AttriId'];
         $BaseRent=$RentAttribute[0]['Base_Rent_Initial_amount_AttriId'];
         $RentInc=$RentAttribute[0]['Rent_Inc_AttrId'];
         $this->set('Commencement',$Commencement);
         $this->set('Expiration', $Expiration);
         $this->set('BaseRent', $BaseRent);
         $this->set('RentInc', $RentInc);

//////rent calculation end////         
      $prod = $JsonArray['ModuleAttributes'][1011][$moduleId]['production'];
     $Commencementkey = $this->searchForId($Commencement,$prod);
     $Expirationkey = $this->searchForId($Expiration,$prod);
    $this->set('CommencementProjAttrmasterid',$Commencementkey);
    $this->set('ExpirationProjAttrmasterid', $Expirationkey);
              
        $this->set('ModuleAttributes', $JsonArray['ModuleAttributes'][12][$moduleId]['production']);
        
        $moduleName = $JsonArray['Module'][$moduleId];
        $this->set('moduleName', $moduleName);
        $frameType = $JsonArray['ProjectConfig']['IsBulk'];
        $limit = 1;
        $frameType = $JsonArray['ProjectConfig']['ProductionView'];
        $domainId = $JsonArray['ProjectConfig']['DomainId'];
        $domainUrl = $JsonArray['ProjectConfig']['DomainUrl'];
        $joballocation_type = $JsonArray['ProjectConfig']['joballocation_type'];
        $userCheck = '';
        if ($joballocation_type == 1) {
            $userCheck = ' AND UserId=' . $user_id;
        }
        
	//	exit;
        if ($frameType == 1) {
            if (isset($this->request->query['job']))
                $newJob = $this->request->query['job'];
            if (isset($this->request->data['NewJob']))
                $newJob = $this->request->data['NewJob'];
            $InprogressProductionjob = $connection->execute('SELECT special FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE UserId=' . $user_id . ' AND StatusId in (' . $next_status_id . ') AND SequenceNumber=1 AND ProjectId=' . $ProjectId)->fetchAll('assoc');
            exit;
            if (empty($InprogressProductionjob)) {
                $productionjob = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WHERE StatusId=' . $first_Status_id . ' AND SequenceNumber=1 AND ProjectId=' . $ProjectId)->fetchAll('assoc');
                //$productionjob = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE StatusId=' . $first_Status_id . ' AND SequenceNumber=1 AND ProjectId=' . $ProjectId)->fetchAll('assoc');
                //               echo "SELECT UserGroupId FROM MV_UserGroupMapping where Projectid=$ProjectId and RegionId=6 and UserId=95534";
                if (empty($productionjob)) {
                    $this->set('NoNewJob', 'NoNewJob');
                } else {
                    foreach ($productionjob as $val) {
                        if ($val['StatusId'] == $first_Status_id && ($newJob == 'NewJob' || $newJob == 'newjob')) {
//                            $updateUserGroupId = $connection->execute("SELECT UserGroupId FROM MV_UserGroupMapping where Projectid=$ProjectId and RegionId=".$val['RegionId']." and UserId=$user_id and RecordStatus=1");
//                            foreach ($updateUserGroupId as $UserVal) {
//                               $userGpId = $UserVal['UserGroupId']; 
//                            }
//                            $productionCompletejob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $next_status_id . ",UserId=" . $user_id . ",UserGroupId=" . $userGpId .",ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $val['ProductionEntity']);
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
        }
        elseif ($frameType == 2) {

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
        } 
        else {


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
           // echo "SELECT Status FROM D2K_ModuleStatusMaster where ModuleId=$moduleId and ModuleStatusIdentifier='$statusIdentifier' AND RecordStatus=1";
            //echo 'coming';exit;
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
			//echo 'SELECT  top 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE StatusId IN (' . $next_status_id . ') AND ProjectId=' . $ProjectId . ' AND UserId= ' . $user_id . ' Order by ProductionEntity,StatusId Desc';
            $InprogressProductionjob = $connection->execute('SELECT  top 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE StatusId IN (' . $next_status_id . ') AND ProjectId=' . $ProjectId . ' AND UserId= ' . $user_id . ' Order by ProductionEntity,StatusId Desc')->fetchAll('assoc');
            //pr($InprogressProductionjob); exit;
            //$InprogressProductionjob=simplexml_load_string('<xml>'.$InprogressProductionjob[0]['special'].'</xml>');
            //echo '<pre>';
            //var_dump( (array) $InprogressProductionjob );
             pr($InprogressProductionjob);
            exit;

            if (empty($InprogressProductionjob)) {
                $productionjob = $connection->execute('SELECT TOP 1 * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE StatusId IN (' . $first_Status_id . ') ' . $userCheck . ' AND ProjectId=' . $ProjectId . ' Order by Priority desc,ProductionEntity,StatusId Desc')->fetchAll('assoc');
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
                        $inprogressjob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId =" . $NextStatusId . ",UserId=" . $user_id . ",ActStartDate='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntity=" . $productionjob[0]['ProductionEntity']);
                        if (empty($ProductionEntityStatus)) {
                            $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $NextStatusId . ",ProductionStartDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $productionjob[0]['ProductionEntity']);
                        } else {
                            $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $NextStatusId . " WHERE ID=" . $productionjob[0]['ProductionEntity']);
                        }
//      $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $NextStatusId . ",ProductionStartDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $productionjob[0]['ProductionEntity']);
                        $productiontimemetricMain = $connection->execute("UPDATE ME_Production_TimeMetric SET StatusId=" . $NextStatusId . ",UserId=" . $user_id . ",Start_Date='" . date('Y-m-d H:i:s') . "' WHERE ProductionEntityID=" . $productionjob[0]['ProductionEntity'] . " AND Module_Id=" . $moduleId);
                        $productionjob[0]['StatusId'] = $NextStatusId;
                        $productionjob[0]['StatusId'] = 'Production In Progress';
                    }
           
                    $InprogressProductionjob = $connection->execute('SELECT * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE StatusId IN (' . $NextStatusId . ') AND ProjectId=' . $ProjectId . ' AND UserId= ' . $user_id . 'Order by ProductionEntity,StatusId Desc')->fetchAll('assoc');
                    $productionjobNew = $InprogressProductionjob;
                    $this->set('productionjob', $InprogressProductionjob[0]);
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
			
            $Category=$productionjobNew[0]['Category'];
            $connection = ConnectionManager::get('default');
            $RegionId = $productionjobNew[0]['RegionId'];
            if($Category==''){
               $Category= 'production';
            }
            $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId][$Category];
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
            //if()
            $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
            
            $ReadOnlyFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['readonly'];
            //pr($productionjobNew);
            
            if ($productionjobNew) {
                //exit;

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

                foreach ($productionjobNew as $key => $value) {
                   // pr($value);exit;

                    if ($value['special'] != '') {
                        $special = '<xml>' . $value['special'] . '</xml>';
                        $specialArr = simplexml_load_string($special);
                        $specialArr = json_decode(json_encode($specialArr), 1);
                        //  pr($productionjobNew);
                        //exit;
                        //$specialArr=$this->xml2array($specialArr);

                        foreach ($specialArr as $key2Temp => $value2) {
                            $key2 = str_replace('_x003', '', $key2Temp);
                            $key2 = str_replace('_', '', $key2);
                            if (is_array($value2) && count($value2) == 0)
                                $value2 = '';
                            $finalprodValue[$key2][$value['SequenceNumber']][$value['DependencyTypeMasterId']] = $value2;
                        }
                        if ($value['SequenceNumber'] > $maxSeq[$value['DependencyTypeMasterId']] && $tempDep == $value['DependencyTypeMasterId']) {
                            $maxSeq[$value['DependencyTypeMasterId']] = $value['SequenceNumber'];
                            $tempDep = $value['DependencyTypeMasterId'];
                        } else {
                            if (!isset($maxSeq[$value['DependencyTypeMasterId']]))
                                $maxSeq[$value['DependencyTypeMasterId']] = 1;
                            $tempDep = $value['DependencyTypeMasterId'];
                        }
                    }
                    //pr($finalprodValue); exit;
                    //foreach ($value as $key2 => $value2) {
                    // pr($value2);
                    //exit;
//                        if(is_numeric($key2)) {
//                            if($value2!='' && $value2!=NULL)
//                        $finalprodValue[$key2][$value['SequenceNumber']][$value['DependencyTypeMasterId']] = $value2;
//                            
//                            if($value['SequenceNumber']>$maxSeq[$value['DependencyTypeMasterId']] && $tempDep==$value['DependencyTypeMasterId']) {
//                                $maxSeq[$value['DependencyTypeMasterId']]=$value['SequenceNumber'];
//                                $tempDep=$value['DependencyTypeMasterId'];
//                            }
//                            else {
//                                if(!isset($maxSeq[$value['DependencyTypeMasterId']]))
//                                $maxSeq[$value['DependencyTypeMasterId']]=1;
//                                $tempDep=$value['DependencyTypeMasterId'];
//                            }
//                        }
                    //}
                }
//                echo '<pre>';
//                print_r($StaticFields);
//                exit;
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
                //$DependancyId = $DependentMasterIds['InputValue']['Id'];
                $DependancyId = $DependentMasterIds['InputValue'];
                $getDomainUrlVal = $finalprodValue[$domainUrl][1][$DependancyId];
                //   print_r($getDomainUrlVal);
                //   exit;
                // $SelDomainUrl = $getDomainUrlVal[0]['AttributeValue'];
//$getDomainUrlVal='www.techradar.com/news/why-self-driving-vehicles-could-be-the-biggest-winner-in-a-5g-world';
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
				if($moduleId==145){
					 $SelDomainUrl = 'http://mojolease.botminds.ai/login';
				}
                //echo $SelDomainUrl; exit;
                $oldone = 1;
                foreach ($groupwisearray as $key => $subGrp) {
                    foreach ($subGrp as $key2 => $subGrpAtt) {
                        $oldone = 1;
                        foreach ($subGrpAtt as $key3 => $subGrpAtt3) {
                            $arryKeys = array_keys($finalprodValue[$subGrpAtt3['AttributeMasterId']]);

                            if (max($arryKeys) > $oldone && $finalGrpprodValue[$key2]['MaxSeq'] < max($arryKeys))
                                $finalGrpprodValue[$key2]['MaxSeq'] = max($arryKeys);



                            $oldone = max($arryKeys);
                        }
                    }
                }
               // pr($finalprodValue);exit;
                $ProjectId = $productionjobNew[0]['ProjectId'];
                $ProjectName = $JsonArray[$ProjectId];

                $this->set('ProjectName', $ProjectName);
                $this->set('JsonArray', $JsonArray);
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
       
            if (isset($this->request->data['Submit'])) {

                $queryStatus = $connection->execute("SELECT count(1) as cnt FROM ME_UserQuery WITH (NOLOCK) WHERE  StatusID=1 AND ProjectId=" . $ProjectId . " AND  ProductionEntityId='" . $productionjobNew[0]['ProductionEntity'] . "'")->fetchAll('assoc');

                $cnt_InputEntity_RejectError = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=3 AND ProjectId=" . $ProjectId . " AND InputEntityId='" . $InputEntityId . "' AND ModuleId='" . $QcCommentsModuleId . "'")->fetchAll('assoc');

                $cnt_InputEntity_TLAcceptError = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=4 AND ProjectId=" . $ProjectId . " AND InputEntityId='" . $InputEntityId . "' AND ModuleId='" . $QcCommentsModuleId . "'")->fetchAll('assoc');

                $cnt_InputEntity_AcceptError = $connection->execute("SELECT count(1) as cnt FROM MV_QC_Comments WITH (NOLOCK) WHERE  StatusID=2 AND ProjectId=" . $ProjectId . " AND InputEntityId='" . $InputEntityId . "' AND ModuleId='" . $QcCommentsModuleId . "'")->fetchAll('assoc');

                if ($queryStatus[0]['cnt'] > 0) {
//                    $completion_status = $queryStatusId;
                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$CompletionStatusId][2][1];
                    $submitType = 'query';
                } else if ($cnt_InputEntity_RejectError[0]['cnt'] != 0) {
                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$CompletionStatusId][2][1];
                    $submitType = 'Rework Reject';
                } else if ($cnt_InputEntity_TLAcceptError[0]['cnt'] != 0) {
                    $CompletionStatus = $JsonArray['ModuleStatus_Navigation'][$CompletionStatusId][2][1];
                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$CompletionStatus][1];
                    $submitType = 'Rework Reject by TL';
                } else if ($cnt_InputEntity_AcceptError[0]['cnt'] != 0) {
                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$CompletionStatusId][1];
                    $submitType = 'Rework Accept';
					if(!empty($QcbatchId))
                    $QCBatchMaster = $connection->execute("UPDATE MV_QC_BatchMaster SET QCCompletedCount=" . $QcCompletedCount . " WHERE Id=" . $QcbatchId);
                } else {
                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$CompletionStatusId][1];
                    $submitType = 'completed';
                }

                //$Dynamicproductionjob = $connection->execute("UPDATE  $stagingTable  SET TimeTaken='" . $this->request->data['TimeTaken'] . "' where ProductionEntity= ".$ProductionEntity);
                $productionCompletejob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $completion_status . ",ActEnddate='" . date('Y-m-d H:i:s') . "',TimeTaken='" . $this->request->data['TimeTaken'] . "' WHERE ProductionEntity=" . $ProductionEntity);
                if (empty($ProductionEntityStatusCompleted)) {
                    $productionjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $completion_status . ",ProductionEndDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $ProductionEntity);
                } else {
                    $productionjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $completion_status . " WHERE ID=" . $ProductionEntity);
                }
                //  $productionjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $completion_status . ",ProductionEndDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $ProductionEntity);
                $productiontimemetricMain = $connection->execute("UPDATE ME_Production_TimeMetric SET StatusId=" . $completion_status . ",End_Date='" . date('Y-m-d H:i:s') . "',TimeTaken='" . $this->request->data['TimeTaken'] . "' WHERE ProductionEntityID=" . $ProductionEntity . " AND Module_Id=" . $moduleId);


                if ($this->request->data['Submit'] == 'saveandcontinue')
                    $submitArray = array('job' => 'newjob'); //, 'continue' => 'yes'
                else if ($this->request->data['Submit'] == 'saveandexit') {
                    $this->redirect(array('controller' => 'users', 'action' => 'logout'));
                } else
                    $submitArray = array('job' => $submitType);

                $this->redirect(array('controller' => 'Getjobcore', 'action' => '', '?' => $submitArray));
                return $this->redirect(['action' => 'index']);
            }

            if (empty($InprogressProductionjob) && $this->request->data['NewJob'] != 'NewJob' && !isset($this->request->data['Submit']) && $this->request->query['job'] != 'newjob') {
                $this->set('getNewJOb', 'getNewJOb');
            } else {
                $this->set('getNewJOb', '');
            }
            $validate = array();
        //pr($JsonArray['ValidationRules']); exit;
            foreach ($ProductionFields as $key => $val) {
                $validationRules = $JsonArray['ValidationRules'][$val['ProjectAttributeMasterId']];
                $validate[$val['ProjectAttributeMasterId']]['MinLength'] = $validationRules['MinLength'];
//pr()
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
                    CASE($IsAlphabet == 1 && $IsNumeric == 1 && $IsEmail == 1):
                        $FunctionName = 'EmailOnly';
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
                    CASE($IsAlphabet == 1 && $IsNumeric == 1 && $IsUrl == 1):
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
                    $Mandatory[$manKey]['ProjectAttributeMasterId'] = $val['ProjectAttributeMasterId'];
                    $Mandatory[$manKey]['AttributeMasterId'] = $val['AttributeMasterId'];
                    $Mandatory[$manKey]['DisplayAttributeName'] = $val['DisplayAttributeName'];
                    $manKey++;
                }
                if ($IsAutoSuggesstion == 1) {
                    $AutoSuggesstion[] = $val['AttributeMasterId'];
                }

                if ($val['ControlName'] == 'DropDownList' && $IsAutoSuggesstion == 1) {
                    $validate[$val['ProjectAttributeMasterId']]['ControlName'] = 'Auto';
                    if ($IsAllowNewValues != 0) {

                        $validate[$val['ProjectAttributeMasterId']]['IsAllowNewValues'] = 'datacheck(this.id,this.value)';
                    }
                    $validate[$val['ProjectAttributeMasterId']]['IsAllowNewValues'] = $IsAllowNewValues;
                }
                $validate[$val['ProjectAttributeMasterId']]['ControlName'] = $val['ControlName'];
                $validate[$val['ProjectAttributeMasterId']]['DisplayAttributeName'] = $val['DisplayAttributeName'];
                $validate[$val['ProjectAttributeMasterId']]['IsMandatory'] = $validationRules['IsMandatory'];
                $validate[$val['ProjectAttributeMasterId']]['MinLength'] = $validationRules['MinLength'];
                $validate[$val['ProjectAttributeMasterId']]['MaxLength'] = $validationRules['MaxLength'];
                $validate[$val['ProjectAttributeMasterId']]['FunctionName'] = $FunctionName;
                //if ($IsMandatory == 1) {
                $validate[$val['ProjectAttributeMasterId']]['Mandatory'] = $Mandatory;
//                }else{
//                 $validate[$val['ProjectAttributeMasterId']]['Mandatory'] = '';   
//                }
                //$validate[$val['ProjectAttributeMasterId']]['AllowedCharacter'] = $AllowedCharacter;
                $validate[$val['ProjectAttributeMasterId']]['AllowedCharacter'] = htmlspecialchars($AllowedCharacter);
                $validate[$val['ProjectAttributeMasterId']]['NotAllowedCharacter'] = htmlspecialchars($NotAllowedCharacter);

                
                 $validate[$val['ProjectAttributeMasterId']]['Dateformat'] = $Dateformat;
                 $validate[$val['ProjectAttributeMasterId']]['Dateformat'] = $Dateformat;
                 $validate[$val['ProjectAttributeMasterId']]['Dateformat'] = $Dateformat;
                   
                $validate[$val['ProjectAttributeMasterId']]['IsDatepicker'] = $validationRules['IsDatepicker'];
                $validate[$val['ProjectAttributeMasterId']]['IsDatecalculator'] = $validationRules['IsDatecalculator'];
                $validate[$val['ProjectAttributeMasterId']]['IsRentcalculator'] = $validationRules['IsRentcalculator'];

                $validate[$val['ProjectAttributeMasterId']]['Options'] = htmlspecialchars($JsonArray['AttributeOrder'][$productionjobNew[0]['RegionId']][$val['ProjectAttributeMasterId']]['Options']);
                $validate[$val['ProjectAttributeMasterId']]['Mapping'] = $JsonArray['AttributeOrder'][$productionjobNew[0]['RegionId']][$val['ProjectAttributeMasterId']]['Mapping'];

                if ($validate[$val['ProjectAttributeMasterId']]['Mapping']) {
                    $to_be_filled = array_keys($validate[$val['ProjectAttributeMasterId']]['Mapping']);
                    $against = $to_be_filled[0];
                    $against_org = $JsonArray['AttributeOrder'][$productionjobNew[0]['RegionId']][$against]['AttributeId'];
                    // $validate[$val['ProjectAttributeMasterId']]['Reload'] = 'LoadValue(' . $val['ProjectAttributeMasterId'] . ',this.value,' . $against . ','.$against_org.'';
                    $validate[$val['ProjectAttributeMasterId']]['Reload'] = $against . ',' . $against_org;
                }

                $QcErrorComments[$ProductionFields[$key]['AttributeMasterId']]['seq'] = $this->Getjobcore->ajax_GetQcComments_seq($productionjobNew[0]['InputEntityId'], $ProductionFields[$key]['AttributeMasterId'], $ProductionFields[$key]['ProjectAttributeMasterId'], 1, $QcCommentsModuleId);
            }
           // pr($Mandatory); exit;
            $this->set('QcErrorComments', $QcErrorComments);
            $this->set('validate', $validate);
            $this->set('ProductionFields', $ProductionFields);
            $this->set('DynamicFields', $DynamicFields);
            $this->set('Mandatory', $Mandatory);
            $this->set('AutoSuggesstion', $AutoSuggesstion);
            $this->set('ReadOnlyFields', $ReadOnlyFields);
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

    function is_numeric_array($array)
    {
    foreach ($array as $a => $b) {
    if (is_int($b)) {
    return 1;
    }else{
        return 2;
    }
    }
    }



    function ajaxgeapivalidation($listdata, $listdata_back, $project_scope_id,$validation_apiurl) {
        try {
            $connection = ConnectionManager::get('default');

//            $listdata = $_POST['listdata'];
//            $listdata_back = $_POST['listdata'];
//            $listdata_back = $listdata_back;
//            $listdata = $this->ajaxgeapivalidationremovekey($project_scope_id, $listdata);
//echo $validation_apiurl;
            
//           echo $listdata_json = json_encode($listdata); exit;
           $listdata_json = json_encode($listdata); 
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $validation_apiurl);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);

            //attach encoded JSON string to the POST fields
            curl_setopt($ch, CURLOPT_POSTFIELDS, array("mojo_json"=>$listdata_json));

            // receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);

            curl_close($ch);
            $result = json_decode($server_output, true);
              
                            
            if (!empty($result) && (!empty($result['FDRID']) || !empty($result['LeaseID']))  ) {
                $res_array = $result["Validation Output"];

                if (!empty($res_array)) {
                            
                    foreach ($res_array as $key => $val) {
                        foreach ($val as $key1 => $val1) {
//                            echo "<pre>s";print_r($key1);
//                            echo "<pre>s";print_r($val);
//                            echo "<pre>s";print_r($listdata_back);
//                            
//                            exit;
                         
//         $arrkey[] = "Location_Type";
        
         $arrkey = array_keys($val1);
         $arraytype = $this->is_numeric_array($arrkey);
         if($arraytype == 1){
             
                $res_array[$key][$key1]['ext'] = implode(",", array_keys($val1));
                                $res_array[$key][$key1]['key'] = $listdata_back[$key][$key1]["key"];
                                $array_pagination_cls = explode("_", $res_array[$key][$key1]["key"]);
                                unset($array_pagination_cls[1]);
                                $res_array[$key][$key1]['pagination_key'] = implode("_", $array_pagination_cls);
                                foreach ($val1 as $key3 => $val3) {
                                    $txt = implode("<br>", $val3['error']);
                                    $res_array[$key][$key1][$key3]['error_txt'] = $txt;
                                }
             
             
         }else{
             
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
                }

                $result["Validation Output"] = $res_array;
                $result["status"] = 1;
            } else {
                $result["status"] = 0;
            }
        } catch (\Exception $e) {
            $result["status"] = 0;
        }

        return $result;
    }

    function getattrsubgroupmasterid($json, $mastid, $subid) {
        return $json[$mastid][$subid];
    }

    function getattrvalue($ProjectId, $AttributeMasterId, $ProductionField, $InputEntityId, $moduleId, $RegionId) {
//        $AttributeMasterId = 3264;
        $staging = "Staging_" . $moduleId . "_Data";

        $connection = ConnectionManager::get('default');
        $selector = "[" . $AttributeMasterId . "]";

        $getQuery = $connection->execute("select distinct SequenceNumber, $selector from $staging where DependencyTypeMasterId='$ProductionField'  AND ProjectId='$ProjectId' AND RegionId='$RegionId' AND InputEntityId='$InputEntityId' order by SequenceNumber")->fetchAll('assoc');

        if (!empty($getQuery)) {
            $arr = array();
            foreach ($getQuery as $key => $val) {
                $arr[$val['SequenceNumber']] = $val[$AttributeMasterId];
            }
            $arr['cnt'] = count($getQuery);
        } else {
            $arr[1] = null;
            $arr['cnt'] = 1;
        }

        return $arr;
    }

    public function arrayfilters($array, $attid) {

        $attr = array_column($array, $attid);
       
        if (count($attr) > 0) {
            $ar = array();
            $i = 0;
            foreach ($attr as $key => $val) {
                if (!is_null($val)) {
                    $i++;
                    $ar[$i] = $val;
                }
            }
            if(empty($ar)){
                $ar[1] = "";
            }
            
            $ar['cnt'] = count($ar);
        } else {
            $ar[1] = "";
            $ar['cnt'] = 1;
        }
        
        return $ar;
    }

    public function ajaxapidatapreparation() {
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $connection = ConnectionManager::get('default');
        $ProjectId = $_POST['ProjectId'];
        $RegionId = $_POST['RegionId'];
        $StatusId = $_POST['StatusId'];
        $TimeTaken = $_POST['TimeTaken'];
        $InputEntityId = $_POST['InputEntityId'];
        $ProductionEntityID = $_POST['ProductionEntityID'];
        $project_scope_id = $_POST['project_scope_id'];
        $moduleId = $session->read("moduleId");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $AttributeGroupMaster = $JsonArray['AttributeGroupMaster'][$moduleId];
        $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
        $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][0];
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];

        $staging = "Staging_" . $moduleId . "_Data";

        $DependentMasterIdsQuery = $connection->execute("SELECT Id,Type,DisplayInProdScreen,FieldTypeName FROM MC_DependencyTypeMaster where ProjectId='$ProjectId'")->fetchAll('assoc');
        $DependentMasterIds = $staticDepenIds = array();
        foreach ($DependentMasterIdsQuery as $vals) {
            if ($vals['DisplayInProdScreen'] == 1)
                $DependentMasterIds[$vals['Type']] = $vals['Id'];

            if ($vals['Type'] == "InputValue")
                $staticDepenIds[] = $vals['Id'];

            if ($vals['FieldTypeName'] == "General")
                $staticDepenIds[] = $vals['Id'];
        }

        $attr_array = $_POST['attr_array'];
   
        if (!empty($attr_array)) {
            $list_data[$ProjectId] = array();
            $list_data_main = $listdata = array();

            $AttributeMasterlists = array_column($ProductionFields, 'AttributeMasterId');
            $AttributeMast = array_chunk($AttributeMasterlists, ceil(count($AttributeMasterlists) / 2));
            $AttributeMasterids1 = "[" . implode('],[', $AttributeMast[0]) . "]";
            $AttributeMasterids2 = "[" . implode('],[', $AttributeMast[1]) . "]";
            $ProductionField = $DependentMasterIds['ProductionField'];

            $getQuery1 = $connection->execute("select distinct SequenceNumber, $AttributeMasterids1 from $staging where DependencyTypeMasterId='$ProductionField'  AND ProjectId='$ProjectId' AND RegionId='$RegionId' AND InputEntityId='$InputEntityId' order by SequenceNumber")->fetchAll('assoc');

            $getQuery2 = $connection->execute("select distinct SequenceNumber, $AttributeMasterids2 from $staging where DependencyTypeMasterId='$ProductionField'  AND ProjectId='$ProjectId' AND RegionId='$RegionId' AND InputEntityId='$InputEntityId' order by SequenceNumber")->fetchAll('assoc');

            $getQuery = array();
            $cnt1 = count($getQuery1);
            $cnt2 = count($getQuery2);

            if ($cnt1 < $cnt2) {
                $getQuerytemp1 = $getQuery1;
                $getQuerytemp2 = $getQuery2;
                $getQuery1 = $getQuerytemp2;
                $getQuery2 = $getQuerytemp1;
            }

            if (!empty($getQuery1) && !empty($getQuery2)) {
                foreach ($getQuery1 as $key => $val) {
                    $getQuery[$key] = isset($getQuery2[$key]) ? $getQuery2[$key] + $val : $val;
                }
            }
//            echo "<pre>s";
//            print_r($attr_array);exit;
            
            foreach ($attr_array as $key => $val) {
                // header1 - name 
                foreach ($val['sub'] as $subkey => $subvalue) {
                    // header2 sub-key get name
                    $subtitle = $this->getattrsubgroupmasterid($JsonArray['AttributeSubGroupMaster'], $val['id'], $subkey);
                    foreach ($subvalue as $sskey => $ssvalue) {
                        $ssattrname = $ssvalue['AttributeName']; // get header name 3

                      $array = $this->arrayfilters($getQuery, intval($ssvalue['AttributeMasterId']));
                    
                      $array_cnt = $array;
                       unset($array['cnt']);
                       
                       if (!empty($subtitle)) {
                            $list_data_main[$val['name']][$subtitle][$ssattrname] = $array_cnt;
                            $listdata[$val['name']][$subtitle][$ssattrname] = $array;

                            $list_data_main[$val['name']][$subtitle][$ssattrname]['key'] = "ProductionFields_" . $ssvalue['AttributeMasterId'] . "_" . $DependentMasterIds['ProductionField'];
                        } else {
                            $list_data_main[$val['name']][$ssattrname] = $array_cnt;
                            $listdata[$val['name']][$ssattrname] = $array;

                            $list_data_main[$val['name']][$ssattrname]['key'] = "ProductionFields_" . $ssvalue['AttributeMasterId'] . "_" . $DependentMasterIds['ProductionField'];
                        }
                    }
                }
            }
        }

        $list[$project_scope_id] = $listdata;
        $lists['array'] = $list;

        
        $getApiurl = $connection->execute("SELECT FilePath FROM ME_FileStoragePath where ProjectId='$ProjectId' and ProcessName = 'validation'")->fetchAll('assoc');
        $validation_apiurl = $getApiurl[0]['FilePath'];
       
     
        $result = $this->ajaxgeapivalidation($lists, $list_data_main, $project_scope_id,$validation_apiurl);
        echo json_encode($result);
        exit;
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

        $session = $this->request->session();
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';

        $RefURL = AfterRefURL;
        $RefUrlID = $connection->execute("Select Id from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=" . $ProjectId)->fetchAll('assoc');
        //  $multipleAttrVal = $connection->execute("Select Id,AttributeValue,count (AttributeValue) as attrcnt from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and AttributeMasterId = " . $AttrId . " and ProjectAttributeMasterId = " . $ProjAttrId . " and AttributeMainGroupId = " . $MainGrpId . " and AttributeSubGroupId = " . $SubGrpId . " and SequenceNumber = " . $Seq . " and RecordDeleted <> 1 and AttributeValue <> '' GROUP by AttributeValue,Id Order by attrcnt desc")->fetchAll('assoc');

        $multipleAttrVal = $connection->execute("Select Id,[" . $AttrId . "] as AttributeValue,count (" . $AttrId . ") as attrcnt from $stagingTable where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntity = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and SequenceNumber = " . $Seq . " and [" . $AttrId . "] <> '' GROUP by [" . $AttrId . "],Id Order by attrcnt desc")->fetchAll('assoc');
        $getData['attrval'] = $multipleAttrVal;
        $getData['attrinitiallink'] = $multipleAttrVal[0]['AttributeValue'];

//        $sameUrl = $getData['attrinitiallink'];
//        if ($sameUrl != '') {
//            $sameIdlink = $connection->execute("Select AttributeMainGroupId, count(Id) as cnt from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and AttributeValue = '$sameUrl' and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and RecordDeleted <> 1 group by AttributeMainGroupId")->fetchAll('assoc');
//        }
//        $getData['attrcnt'] = $sameIdlink;

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

        $session = $this->request->session();
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';

        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $AttributeGroupMaster = $JsonArray['AttributeGroupMasterDirect'];
        $GroupVal = array();
        foreach ($AttributeGroupMaster as $key => $val) {

            $RefURL = AfterRefURL;
            $RefUrlID = $connection->execute("Select Id from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=" . $ProjectId)->fetchAll('assoc');
            $multipleAttrVal = $connection->execute("Select AttributeValue, count (AttributeValue) as attrcnt,HtmlFileName from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and AttributeMainGroupId = " . $key . " and RecordDeleted <> 1 and AttributeValue <> '' and HtmlFileName <> '' GROUP by HtmlFileName,AttributeValue Order by attrcnt desc")->fetchAll('assoc');
            $GroupVal = array_merge($GroupVal, $multipleAttrVal);
        }
        $getData['attrval'] = $GroupVal;
        $getData['attrinitiallink'] = $GroupVal[0]['AttributeValue'];
        $getData['attrinitialhtml'] = $GroupVal[0]['HtmlFileName'];

        $sameUrl = $getData['attrinitiallink'];
        $groupwisearray = array();
        if ($sameUrl != '') {

            $ColumnNames = $connection->execute("SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS  where TABLE_NAME='$stagingTable' and ISNUMERIC(COLUMN_NAME) = 1")->fetchAll('assoc');

            $arr = array();
            foreach ($ColumnNames as $key => $val):
                $arr[] = '[' . $val['COLUMN_NAME'] . ']';
            endforeach;
            $NumericColumnNames = implode(",", $arr);

            $sameIdlinkVal = $connection->execute("SELECT * FROM (SELECT $NumericColumnNames from $stagingTable where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntity = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . ") src UNPIVOT ([Column Value] for [Column Name] IN ($NumericColumnNames)) unpvt WHERE  [Column Value] LIKE '$sameUrl' ")->fetchAll('assoc');

            //   $sameIdlink = $connection->execute("Select AttributeMainGroupId, count(Id) as cnt from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and AttributeValue = '$sameUrl' and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and RecordDeleted <> 1 group by AttributeMainGroupId")->fetchAll('assoc');
            //   $sameIdlinkVal=$connection->execute("SET NOCOUNT ON; exec spSearchStringInTable @SearchString = N'$sameUrl',@table_schema = 'dbo', @table_name = $stagingTable,@ProjectId = $ProjectId,@InputEntityId = $InputEntityId,@RegionId = $RegionId,@ProductionEntity = $ProdEntityId,@DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . "")->fetchAll('assoc');
            $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
            $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
            $AttributeGroupMaster = $JsonArray['AttributeGroupMaster'];
            $AttributeGroupMaster = $AttributeGroupMaster[$moduleId];

            foreach ($sameIdlinkVal as $keys => $values) {
                $arrVal = $values['Column Name'];
                $keys = array_map(function($v) use ($arrVal, $emparr) {
                    if ($v['AttributeMasterId'] == $arrVal) {
                        return $v['MainGroupId'];
                    }
                }, $ProductionFields);
                $groupwisearray[$arrVal] = $keys;
            }
        }

        foreach ($groupwisearray as $keys => $values) {
            foreach ($values as $key => $val) {
                if (!empty($val)) {
                    $newArr[$val][] = $key;
                }
            }
        }
        $i = 0;
        foreach ($newArr as $val => $key) {
            $sameIdlink[$i]['AttributeMainGroupId'] = $val;
            $sameIdlink[$i]['cnt'] = count($key);
            $i++;
        }

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

        $session = $this->request->session();
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';

        $Id = $_POST['Id'];

        $DeleteUrl = $connection->execute("Update $stagingTable set [" . $AttrId . "] = '' where Id = " . $Id . " and ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntity = " . $ProdEntityId . "  and SequenceNumber = " . $Seq);
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
        $session = $this->request->session();
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';

        if ($AttrId != '') {
            $RefURL = AfterRefURL;
            $RefUrlID = $connection->execute("Select Id from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=" . $ProjectId)->fetchAll('assoc');
            //$multipleVal = $connection->execute("Select AttributeValue from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and AttributeMasterId = " . $AttrId . " and ProjectAttributeMasterId = " . $ProjAttrId . " and AttributeMainGroupId = " . $AttrGroup . " and AttributeSubGroupId = " . $AttrSubGroup . " and SequenceNumber = " . $Seq . " and RecordDeleted <> 1 and AttributeValue <> '' GROUP by AttributeValue")->fetchAll('assoc');
            $multipleValStaging = $connection->execute("Select [" . $AttrId . "] as AttributeValue from $stagingTable where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntity = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . "  and SequenceNumber = " . $Seq . " and [" . $AttrId . "] <> '' GROUP by [" . $AttrId . "]")->fetchAll('assoc');
        }
        $RefURL = AfterRefURL;
        $RefUrlID = $connection->execute("Select Id from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=" . $ProjectId)->fetchAll('assoc');
        // $multipleAttrVal = $connection->execute("Select AttributeValue, count (AttributeValue) as attrcnt  from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and RecordDeleted <> 1 and AttributeValue <> '' GROUP by AttributeValue Order by attrcnt desc")->fetchAll('assoc');
        $ColumnNames = $connection->execute("SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS  where TABLE_NAME='$stagingTable' and ISNUMERIC(COLUMN_NAME) = 1")->fetchAll('assoc');

        $arr = array();
        foreach ($ColumnNames as $key => $val):
            $arr[] = '[' . $val['COLUMN_NAME'] . ']';
        endforeach;
        $NumericColumnNames = implode(",", $arr);
//echo "Select $NumericColumnNames from $stagingTable where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntity = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . "";
        $multipleAttr = $connection->execute("Select $NumericColumnNames from $stagingTable where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntity = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . "")->fetchAll('assoc');

        foreach ($multipleAttr as $keys => $values) {
            foreach ($values as $key => $val) {
                if (!empty($val)) {
                    $newArr[$val][] = $key;
                }
            }
        }
        $i = 0;
        foreach ($newArr as $val => $key) {
            $multipleAttrVal[$i]['AttributeValue'] = $val;
            $multipleAttrVal[$i]['attrcnt'] = count(array_unique($key));
            $i++;
        }

        $arrayres = array_column($multipleValStaging, 'AttributeValue');

        $finalarr = array_map(function ($mulattval) use($arrayres) {
            if (!in_array($mulattval['AttributeValue'], $arrayres))
                return $mulattval;
        }, $multipleAttrVal);
        $finalarr1 = array_filter($finalarr);

        //pr($finalarr1);

        $finarr = array();
        foreach ($finalarr1 as $vas) {
            $finarr[] = $vas;
        }


        $getData['attrval'] = $finarr;
        $getData['attrinitiallink'] = $multipleAttrVal[0]['AttributeValue'];

//        $sameUrl = $getData['attrinitiallink'];
//        //if ($sameUrl != '') {
//            $sameIdlink = $connection->execute("Select AttributeMainGroupId, count(Id) as cnt from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and AttributeValue = '$sameUrl' and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and RecordDeleted <> 1 group by AttributeMainGroupId")->fetchAll('assoc');
//        //}
//        $getData['attrcnt'] = $sameIdlink;

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

        $session = $this->request->session();
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';

        $RefURL = AfterRefURL;
        $RefUrlID = $connection->execute("Select Id,FieldTypeName from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=" . $ProjectId)->fetchAll('assoc');
        $batchValues = $connection->execute("Select Top 1 BatchID,BatchCreated,ActStartDate from $stagingTable where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntity = " . $ProdEntityId)->fetchAll('assoc');
        $BatchId = $batchValues[0]['BatchID'];
        $BatchCreated = $batchValues[0]['BatchCreated'];
        $ActStartDate = $batchValues[0]['ActStartDate'];
        $multipleAttrVal = $connection->execute("Insert into $stagingTable (BatchID,BatchCreated,ProjectId,RegionId,InputEntityId,ProductionEntity,[" . $AttrId . "],SequenceNumber,StatusId,ActStartDate,DependencyTypeMasterId,RecordStatus,UserId,CreatedDate)"
                . "values('" . $BatchId . "','" . $BatchCreated . "','" . $ProjectId . "','" . $RegionId . "','" . $InputEntityId . "','" . $ProdEntityId . "','" . $UrlText . "','" . $Seq . "',4,'" . $ActStartDate . "','" . $RefUrlID[0]['Id'] . "','" . 1 . "','" . $user_id . "','" . $createddate . "')");
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

        $session = $this->request->session();
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';

        $RefURL = AfterRefURL;
        $RefUrlID = $connection->execute("Select Id,FieldTypeName from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=" . $ProjectId)->fetchAll('assoc');
        if ($UrlText != '') {
            $sameIdlink = $connection->execute("Select HtmlFileName from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and AttributeValue = '$UrlText' and AttributeMasterId = " . $AttrId . " and ProjectAttributeMasterId = " . $ProjAttrId . " and SequenceNumber = " . $Seq . "  and HtmlFileName <> '' and RecordDeleted <> 1")->fetchAll('assoc');
            $getData['htmlfile'] = $sameIdlink[0]['HtmlFileName'];

            $groupwisearray = array();
            $ColumnNames = $connection->execute("SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS  where TABLE_NAME='$stagingTable' and ISNUMERIC(COLUMN_NAME) = 1")->fetchAll('assoc');

            $arr = array();
            foreach ($ColumnNames as $key => $val):
                $arr[] = '[' . $val['COLUMN_NAME'] . ']';
            endforeach;
            $NumericColumnNames = implode(",", $arr);

            $sameIdlinkVal = $connection->execute("SELECT * FROM (SELECT $NumericColumnNames from $stagingTable where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntity = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . ") src UNPIVOT ([Column Value] for [Column Name] IN ($NumericColumnNames)) unpvt WHERE  [Column Value] LIKE '$UrlText' ")->fetchAll('assoc');

// $sameIdlinkVal=$connection->execute("SET NOCOUNT ON; exec spSearchStringInTable @SearchString = N'$UrlText', @table_schema = 'dbo', @table_name = $stagingTable")->fetchAll('assoc');

            $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
            $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
            $AttributeGroupMaster = $JsonArray['AttributeGroupMaster'];
            $AttributeGroupMaster = $AttributeGroupMaster[$moduleId];

            foreach ($sameIdlinkVal as $keys => $values) {
                $arrVal = $values['Column Name'];
                $keys = array_map(function($v) use ($arrVal, $emparr) {
                    if ($v['AttributeMasterId'] == $arrVal) {
                        return $v['MainGroupId'];
                    }
                }, $ProductionFields);
                $groupwisearray[$arrVal] = $keys;
            }
            foreach ($groupwisearray as $keys => $values) {
                foreach ($values as $key => $val) {
                    if (!empty($val)) {
                        $newArr[$val][] = $key;
                    }
                }
            }
            $i = 0;
            foreach ($newArr as $val => $key) {
                $sameIdlink[$i]['AttributeMainGroupId'] = $val;
                $sameIdlink[$i]['cnt'] = count($key);
                $i++;
            }
            //    $attrCount = $connection->execute("Select AttributeMainGroupId, count(Id) as cnt from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and AttributeValue = '$UrlText' and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and RecordDeleted <> 1 group by AttributeMainGroupId")->fetchAll('assoc');
            $getData['attrCount'] = $sameIdlink;

            //  $sameIdlinkVal=$connection->execute("SET NOCOUNT ON; exec spSearchStringInTable @SearchString = N'$UrlText', @table_schema = 'dbo', @table_name = $stagingTable")->fetchAll('assoc');
            foreach ($sameIdlinkVal as $keys => $values) {
                $arrId[] = $values['Column Name'];
            }
            $arrUnique = array_unique($arrId);
            foreach ($arrUnique as $key => $val) {
                $finalarray[$key]['AttributeMasterId'] = $val;
            }

            $getData['attrid'] = $finalarray;

            // $attrids = $connection->execute("Select AttributeMasterId from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and AttributeValue = '$UrlText' and RecordDeleted <> 1 and AttributeValue <> ''")->fetchAll('assoc');
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

        $session = $this->request->session();
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';

        $RefURL = AfterRefURL;
        $RefUrlID = $connection->execute("Select Id,FieldTypeName from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=" . $ProjectId)->fetchAll('assoc');
        if ($UrlText != '') {
            $htmlfile = $connection->execute("Select HtmlFileName from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and AttributeValue = '$UrlText' and HtmlFileName <> '' and RecordDeleted <> 1")->fetchAll('assoc');
            $getData['htmlfile'] = $htmlfile[0]['HtmlFileName'];

            $groupwisearray = array();
            //    $sameIdlinkVal=$connection->execute("SET NOCOUNT ON; exec spSearchStringInTable @SearchString = N'$UrlText', @table_schema = 'dbo', @table_name = $stagingTable")->fetchAll('assoc');
            $ColumnNames = $connection->execute("SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS  where TABLE_NAME='$stagingTable' and ISNUMERIC(COLUMN_NAME) = 1")->fetchAll('assoc');

            $arr = array();
            foreach ($ColumnNames as $key => $val):
                $arr[] = '[' . $val['COLUMN_NAME'] . ']';
            endforeach;
            $NumericColumnNames = implode(",", $arr);

            $sameIdlinkVal = $connection->execute("SELECT * FROM (SELECT $NumericColumnNames from $stagingTable where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntity = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . ") src UNPIVOT ([Column Value] for [Column Name] IN ($NumericColumnNames)) unpvt WHERE  [Column Value] LIKE '$UrlText' ")->fetchAll('assoc');

            $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
            $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
            $AttributeGroupMaster = $JsonArray['AttributeGroupMaster'];
            $AttributeGroupMaster = $AttributeGroupMaster[$moduleId];

            foreach ($sameIdlinkVal as $keys => $values) {
                $arrVal = $values['Column Name'];
                $keys = array_map(function($v) use ($arrVal, $emparr) {
                    if ($v['AttributeMasterId'] == $arrVal) {
                        return $v['MainGroupId'];
                    }
                }, $ProductionFields);
                $groupwisearray[$arrVal] = $keys;
            }


            foreach ($groupwisearray as $keys => $values) {
                foreach ($values as $key => $val) {
                    if (!empty($val)) {
                        $newArr[$val][] = $key;
                    }
                }
            }
            $i = 0;
            foreach ($newArr as $val => $key) {
                $sameIdlink[$i]['AttributeMainGroupId'] = $val;
                $sameIdlink[$i]['cnt'] = count($key);
                $i++;
            }
            //   $attrCount = $connection->execute("Select AttributeMainGroupId, count(Id) as cnt from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and AttributeValue = '$UrlText' and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and RecordDeleted <> 1 group by AttributeMainGroupId")->fetchAll('assoc');
            $getData['attrCount'] = $sameIdlink;

            //     $sameIdlinkVal=$connection->execute("SET NOCOUNT ON; exec spSearchStringInTable @SearchString = N'$UrlText', @table_schema = 'dbo', @table_name = $stagingTable")->fetchAll('assoc');
            foreach ($sameIdlinkVal as $keys => $values) {
                $arrId[] = $values['Column Name'];
            }
            $arrUnique = array_unique($arrId);
            foreach ($arrUnique as $key => $val) {
                $finalarray[$key]['AttributeMasterId'] = $val;
            }
            $getData['attrid'] = $finalarray;
            //   $attrids = $connection->execute("Select AttributeMasterId from MC_CengageProcessInputData where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntityID = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . " and AttributeValue = '$UrlText' and RecordDeleted <> 1 and AttributeValue <> ''")->fetchAll('assoc');
        }
        if (!empty($getData)) {
            echo json_encode($getData);
        }
        exit;
    }

    function ajaxqueryposing() {
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        //$role_id = $session->read("RoleId");
        $ProjectId = $session->read("ProjectId");
        $moduleId = $session->read("moduleId");
        $RegionId = $_POST['RegionId'];
        echo $_POST['query'];
        $file = $this->Getjobcore->find('querypost', ['ProductionEntity' => $_POST['InputEntyId'],'category' => $_POST['category'], 'query' => $_POST['query'], 'ProjectId' => $ProjectId, 'RegionId' => $RegionId, 'moduleId' => $moduleId, 'user' => $user_id]);
        exit;
    }
    function ajaxquerypostingmulti() {
			
	parse_str($_POST['multiquery'], $Query);
       if(empty($Query)){
        echo "fail";
        exit;  
       }
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        //$role_id = $session->read("RoleId");
        $ProjectId = $session->read("ProjectId");
        $moduleId = $session->read("moduleId");
        $RegionId = $_POST['RegionId'];	
		 $file = $this->Getjobcore->find('querypostAll', ['ProductionEntity' => $_POST['InputEntyId'], 'comments' => $Query, 'ProjectId' => $ProjectId, 'RegionId' => $RegionId, 'moduleId' => $moduleId, 'user' => $user_id]);   
        echo "success";
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
            $arrayVal[$i]['Value'] = $JsonArray['AttributeOrder'][$Region][$_POST['toid']]['OptionsWithKey'][$dumy];
            $arrayVal[$i]['id'] = $dumy;
            $i++;
        }

        $getdata['arrvalue'] = $arrayVal;
        $getdata['count'] = count($arrayVal);

        echo json_encode($getdata);
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
        $StatusId = $_POST['StatusId'];
        $TimeTaken = $_POST['TimeTaken'];
        $InputEntityId = $_POST['InputEntityId'];
        $ProductionEntityID = $_POST['ProductionEntityID'];
        $moduleId = $session->read("moduleId");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
        $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][0];
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];

        $batchValues = $connection->execute("Select Top 1 BatchID,BatchCreated,ActStartDate from Staging_" . $moduleId . "_Data where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntity = " . $ProductionEntityID)->fetchAll('assoc');
        $BatchId = $batchValues[0]['BatchID'];
        $BatchCreated = $batchValues[0]['BatchCreated'];
        $ActStartDate = $batchValues[0]['ActStartDate'];

        if (empty($this->request->session()->read('user_id'))) {
            echo 'expired';
            exit;
        } else {
            parse_str($_POST['Updatedata'], $postValue);
            $updateReady = array();
            foreach ($postValue as $key => $AttributeValue) {
                $ProdFields = explode('_', $key);
                $updateReady[$ProdFields[3]][$ProdFields[2]][$ProdFields[1]] = $AttributeValue;
            }
            $postValue = array_filter($postValue);

            foreach ($updateReady as $seqKey => $seqVal) {
                foreach ($seqVal as $depKey => $depVal) {
                    $updateFields = '';
                    foreach ($depVal as $attKey => $attVal) {
                        if ($attKey != '') {
                            if (is_array($attVal))
                                $attVal = implode(',', $attVal);
                            $attVal=  str_replace("'", "''", $attVal);
                            $updateFields.="[" . $attKey . "]=N'" . $attVal . "',";
                        }
                    }


                    $updateTable = $connection->execute("UPDATE Staging_" . $moduleId . "_Data SET $updateFields UserId='" . $user_id . "',TimeTaken='" . $TimeTaken . "' where  DependencyTypeMasterId='" . $depKey . "' AND SequenceNumber='" . $seqKey . "' AND ProjectId='" . $ProjectId . "' AND RegionId='" . $RegionId . "' AND InputEntityId='" . $InputEntityId . "'");
                }
            }



            parse_str($_POST['Inputdata'], $insert);

            if (isset($insert)) {
                $i = 0;
                $depArr = array();
                $insertReady = array();
                foreach ($insert as $key2 => $val2) {
                    $ProdFields = explode('_', $key2);
                    $insertReady[$ProdFields[3]][$ProdFields[2]][$ProdFields[1]] = $val2;
                }

                foreach ($insertReady as $seqKey => $seqVal) {
                    foreach ($seqVal as $depKey => $depVal) {
                        $insertcolumn = '';
                        $insertFields = '';
                        foreach ($depVal as $attKey => $attVal) {
                            if ($attKey != '') {
                                if (is_array($attVal))
                                    $attVal = implode(',', $attVal);
                                $attVal=  str_replace("'", "''", $attVal);
                                $insertcolumn.="[" . $attKey . "],";
                                $insertFields.="N'" . $attVal . "',";
                            }
                        }
                        
                        // echo "INSERT INTO Staging_".$moduleId."_Data ($insertcolumn UserId,DependencyTypeMasterId,SequenceNumber,ProjectId,RegionId,InputEntityId,StatusId,ProductionEntity) values($insertFields $user_id,$depKey,$seqKey,$ProjectId,$RegionId,$InputEntityId,$next_status_id,$ProductionEntityID)";
                        $updateTable = $connection->execute("INSERT INTO Staging_" . $moduleId . "_Data ($insertcolumn UserId,DependencyTypeMasterId,SequenceNumber,ProjectId,RegionId,InputEntityId,StatusId,ProductionEntity,ActStartDate,BatchID,BatchCreated,TimeTaken) values($insertFields $user_id,$depKey,$seqKey,$ProjectId,$RegionId,$InputEntityId,$StatusId,$ProductionEntityID,'$ActStartDate','$BatchId','$BatchCreated','$TimeTaken')");
                    }
                }
            }
            $updateTable = $connection->execute("UPDATE Staging_" . $moduleId . "_Data SET  UserId='" . $user_id . "',TimeTaken='" . $TimeTaken . "' where  ProjectId='" . $ProjectId . "' AND RegionId='" . $RegionId . "' AND InputEntityId='" . $InputEntityId . "'");
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
            $productionjobNew = $connection->execute('SELECT * FROM ' . $stagingTable . ' WITH (NOLOCK) WHERE ProductionEntityID=' . $_POST['ProductionEntity'] . ' AND SequenceNumber=' . $_POST['page'])->fetchAll('assoc');
            echo json_encode($productionjobNew[0]);
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

    function ajaxgetdatahandrework() {

        $ProductionEntityId = $_POST['ProductionEntityId'];
        $AttributeMasterId = $_POST['AttributeMasterId'];
        $moduleId = $_POST['ModuleId'];
        $qcModuleId = $_POST['QcCommentsModuleId'];
        $Title = $_POST['title'];
        $session = $this->request->session();
        $ProjectId = $session->read("ProjectId");
        $connection = ConnectionManager::get('default');
        $user_id = $session->read("user_id");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);

        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);

        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];
        $PivotId = '';
        $finalval = array();

        $link2 = $connection->execute("SELECT FieldTypeName,Id FROM MC_DependencyTypeMaster WHERE FieldTypeName IN ('After Normalized') AND ProjectId=" . $ProjectId)->fetchAll('assoc');

        $linkdata = $connection->execute("SELECT RegionId FROM ProductionEntityMaster where ProjectId=" . $ProjectId . " AND Id='" . $ProductionEntityId . "'")->fetchAll('assoc');
//         $RegionId = $link[0]['RegionId'];


        foreach ($link2 as $keytype => $valuetype) {
            //echo $keytype.'<br>';
            $PivotId.= '[' . $valuetype["Id"] . '],';
            $FieldTyper = $valuetype['FieldTypeName'];
            $FieldTypeId = $valuetype['Id'];
            $FieldTypeName = preg_replace('/\s+/', '', $FieldTyper);
            $finalval[$FieldTypeId] = $FieldTypeName;
        }
        $PivotId = rtrim($PivotId, ',');

        $link = $connection->execute("select * from (select Attributevalue,InputEntityId, SequenceNumber, ProjectAttributeMasterId,AttributeMasterId,DependencyTypeMasterId from MC_CengageProcessInputData WHERE AttributeMasterId=" . $AttributeMasterId . " AND ProductionEntityID=" . $ProductionEntityId . " AND ProjectId=" . $ProjectId . " ) a pivot ( max(Attributevalue) for DependencyTypeMasterId in ($PivotId)) piv;")->fetchAll('assoc');
        $RegionId = $linkdata[0]['RegionId'];
        $valArr = array();
        $i = 0;
        $qchead = '';
        $qvalue = '';

        foreach ($link as $key => $value) {

            //$valArr['handson'][$i]['DataId'] = $value['SequenceNumber'];
            foreach ($finalval as $key4 => $value4) {
//		if($i == 0){
////		if($value4=="AfterNormalized"){ $head="After Normalized";} elseif($value4=="AfterDisposition"){ $head="After Disposition"; } else{ $head=$value4; }
////		$qchead.='<td>'.$head.'</td>';
//		}
                $valArr['handson'][$i][$value4] = $value[$key4];

                $InputEntyId = $value['InputEntityId'];
                $ProjectAttributeMasterId = $value['ProjectAttributeMasterId'];
                $AttributeMasterId = $value['AttributeMasterId'];
                $SequenceNumber = $value['SequenceNumber'];

                $qcerror['handson'][$i][$value4]['status'] = $this->getdataqccommentpurebuttal($InputEntyId, $AttributeMasterId, $ProjectAttributeMasterId, $SequenceNumber, $qcModuleId);
                $qcerror['handson'][$i][$value4]['seq'] = $value['SequenceNumber'];
            }


            //$valArr['handson'][$i]['Id'] = $i;
            $i++;
        }

        $qc_datarow = '';
        $headi = 0;
        foreach ($valArr['handson'] as $key => $value) {
            $qc_datarow.='<tr>';
            foreach ($value as $arkey => $arvalue) {

//		     $qc_datarow.='<td>'.$arvalue.'</td>';
//		     $qc_datarow.='<td>'.$arvalue.'</td>';
                $text_cls = "";
                $text_onclk = "";
                $seq = "";

                if (!empty($qcerror['handson'][$key][$arkey]['status'])) {
                    $text_cls = "pu_cmts_seq";
                }
                $seq = $qcerror['handson'][$key][$arkey]['seq'];
                $text_onclk = "onclick=loadMultiFieldqcerror($AttributeMasterId,$seq)";
                $qc_datarow.='<td ' . $text_onclk . ' class ="' . $text_cls . '" >' . $arvalue . '</td>';
            }
            $qc_datarow.='</tr>';
        }
        $qc_data = '<div  style="padding: 10px;background: #fff;font-size: 17px;font-weight: 500;">' . $Title . '</div>';
        $qc_data.='<table style="display:inline-table">';
//		  $qc_data.='<tr>'.$qc_datarow.'</tr>';
        $qc_data.=$qc_datarow;
        $qc_data.='</table>';
        echo $qc_data;
        // echo json_encode($valArr);
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

    function ajaxgetdatahand() {
        $ProductionEntityId = $_POST['ProductionEntityId'];
        $AttributeMasterId = $_POST['AttributeMasterId'];
        $session = $this->request->session();
        $ProjectId = $session->read("ProjectId");
        $connection = ConnectionManager::get('default');
        $user_id = $session->read("user_id");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';
        $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][0];
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);

        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];
        $PivotId = '';
        $finalval = array();
        $link2 = $connection->execute("SELECT FieldTypeName,Id FROM MC_DependencyTypeMaster WHERE Type IN ('ProductionField') AND ProjectId=" . $ProjectId)->fetchAll('assoc');
        foreach ($link2 as $keytype => $valuetype) {
            //echo $keytype.'<br>';
            $PivotId.= '[' . $valuetype["Id"] . '],';
            $FieldTyper = $valuetype['FieldTypeName'];
            $FieldTypeId = $valuetype['Id'];
            $FieldTypeName = preg_replace('/\s+/', '', $FieldTyper);
            $finalval[$FieldTypeId] = $FieldTypeName;
            $depene = $valuetype["Id"];
        }
        $PivotId = rtrim($PivotId, ',');

        //$link = $connection->execute("SELECT * FROM MC_CengageProcessInputData WHERE AttributeMasterId=" . $AttributeMasterId . " AND ProductionEntityID=" . $ProductionEntityId . "AND DependencyTypeMasterId IN (1008,1012,1011) AND ProjectId=" . $ProjectId)->fetchAll('assoc');
        //$link = $connection->execute("select * from (select Attributevalue, SequenceNumber, DependencyTypeMasterId from MC_CengageProcessInputData WHERE AttributeMasterId=" . $AttributeMasterId . " AND ProductionEntityID=" . $ProductionEntityId . " AND ProjectId=" . $ProjectId . " ) a pivot ( max(Attributevalue) for DependencyTypeMasterId in ($PivotId)) piv;")->fetchAll('assoc');

        $link = $connection->execute("select MAX([$AttributeMasterId]) as data from $stagingTable where ProductionEntity=" . $ProductionEntityId . " AND ProjectId=" . $ProjectId . " AND DependencyTypeMasterId =$depene Group by SequenceNumber")->fetchAll('assoc');
        //$link = $connection->execute("SELECT * FROM MC_CengageProcessInputData WHERE AttributeMasterId=2993 AND ProductionEntityID=43108 AND DependencyTypeMasterId IN (1008,1012,1011) AND ProjectId=2308")->fetchAll('assoc');
        $RegionId = $link[0]['RegionId'];
        //pr($link);
        $valArr = array();
        $i = 0;
        foreach ($link as $key => $value) {
            //  pr($value);
            $valArr['handson'][$i]['data'] = $value['data'];
            $valArr['handson'][$i]['Id'] = $i;
            $i++;
        }
        echo json_encode($valArr);
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

    function ajaxgetdatahandalldatarework() {

        $ProductionEntityId = $_POST['ProductionEntityId'];
        $AttributeMasterId = $_POST['AttributeMasterId'];
        $moduleId = $_POST['ModuleId'];
        $Title = $_POST['title'];
        $handskey = $_POST['handskey'];
        $qcModuleId = $_POST['QcCommentsModuleId'];
        $session = $this->request->session();
//        $moduleId = $session->read("moduleId");

        $handskeysub = $_POST['handskeysub'];
        $ProjectId = $session->read("ProjectId");
        $connection = ConnectionManager::get('default');
        $user_id = $session->read("user_id");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
//        $moduleId = $session->read("moduleId");
//        $stagingTable = 'Staging_' . $moduleId . '_Data';
        $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][3];
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);

        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];


        $link = $connection->execute("SELECT RegionId FROM ProductionEntityMaster where ProjectId=" . $ProjectId . " AND Id='" . $ProductionEntityId . "'")->fetchAll('assoc');

        $RegionId = $link[0]['RegionId'];
        $finalval = array();
        $PivotId = '';

        $link2 = $connection->execute("SELECT FieldTypeName,Id FROM MC_DependencyTypeMaster WHERE FieldTypeName IN ('After Normalized') AND ProjectId=" . $ProjectId)->fetchAll('assoc');

        foreach ($link2 as $keytype => $valuetype) {
            $PivotId.= '[' . $valuetype["Id"] . '],';
            $FieldTyper = $valuetype['FieldTypeName'];
            $FieldTypeId = $valuetype['Id'];
            $FieldTypeName = preg_replace('/\s+/', '', $FieldTyper);
            $finalval[$FieldTypeId] = $FieldTypeName;
        }
        $PivotId = rtrim($PivotId, ',');

        //$ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
        $firstModuleId = $JsonArray['ModuleAttributes'][$RegionId];
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
        $i = 0;
        $att = 1;
        $tblhead = "";
        $tblheadtwo = "";

        foreach ($groupwisearray[$handskey] as $keyn => $valuen) {
            $nm_menu = count($valuen);
            foreach ($valuen as $keyprodFields => $valprodFields) {
                $tblhead.="<td align='center'>" . $valprodFields['AttributeName'] . "</td>";
//		$tblheadtwo.="<td style='min-width:150px;'>After Normalized</td>";
                $link44 = $connection->execute("select * from (select Attributevalue,InputEntityId, SequenceNumber, ProjectAttributeMasterId,AttributeMasterId,DependencyTypeMasterId from MC_CengageProcessInputData WHERE AttributeMasterId=" . $valprodFields['AttributeMasterId'] . " AND ProductionEntityID=" . $ProductionEntityId . " AND ProjectId=" . $ProjectId . " ) a pivot ( max(Attributevalue) for DependencyTypeMasterId in ($PivotId)) piv;")->fetchAll('assoc');

                foreach ($link44 as $key => $value) {

                    $Arratt = array();
                    //$valArr['handson'][$i]['DataId'] = $valprodFields['SubGroupId'];


                    if ($value['SequenceNumber'] != $att)
                        $att = 1;
                    else
                        $att = $att + 1;
                    $valArr['handson'][$value['SequenceNumber']][$valprodFields['AttributeName']] = $valprodFields['AttributeName'];

                    foreach ($finalval as $key4 => $value4) {

                        $Arratt[] = $value[$key4];
                    }

                    $valArr['handson'][$value['SequenceNumber']][$valprodFields['AttributeName']] = $Arratt;

                    $InputEntyId = $value['InputEntityId'];
                    $ProjectAttributeMasterId = $value['ProjectAttributeMasterId'];
                    $AttributeMasterId = $value['AttributeMasterId'];
                    $SequenceNumber = $value['SequenceNumber'];

                    $qcerror['handson'][$value['SequenceNumber']][$valprodFields['AttributeName']]['status'] = $this->getdataqccommentpurebuttal($InputEntyId, $AttributeMasterId, $ProjectAttributeMasterId, $SequenceNumber, $qcModuleId);
                    $qcerror['handson'][$value['SequenceNumber']][$valprodFields['AttributeName']]['seq'] = $value['SequenceNumber'];


                    $old = $value['SequenceNumber'];
                    //$valArr['handson']['Id'] = $i;
                    $i++;
                }
            }
        }

        $qc_datarow = '';
        $headi = 0;
        foreach ($valArr['handson'] as $key => $value) {

            $qc_datarow.='<tr>';     
            $ac_menu = count($value);
            $ex_menu = $nm_menu - count($value);
            foreach ($value as $arkey => $arvalue) {
                $text_cls = "";
                $seq = "";
                if (!empty($qcerror['handson'][$key][$arkey]['status'])) {
                    $text_cls = "pu_cmts_seq";
                }
                $seq = $qcerror['handson'][$key][$arkey]['seq'];
                $text_onclk = "onclick=Pucmterrorclk($handskeysub,$seq)";

                $qc_datarow.='<td ' . $text_onclk . ' class ="' . $text_cls . '" cellspacing="10">' . $arvalue[0] . '</td>';
            }
            for ($i = 0; $i < $ex_menu; $i++) {
                $qc_datarow.='<td ></td>';
            }
            $qc_datarow.='</tr>';
        }
        $qc_data = '<div style="padding: 10px;background: #fff;font-size: 17px;font-weight: 500;">' . $Title . '</div>';
        $qc_data.='<table style="display:inline-table"><tr style="white-space: nowrap;">' . $tblhead . '</tr>';
//		 $qc_data.='<tr >'.$tblheadtwo.'</tr>';		
        $qc_data.=$qc_datarow;
        $qc_data.='</table>';
        echo $qc_data;
        //echo "hello";
        //echo json_encode($valArr);

        exit;
    }

    function ajaxgetdatahandalldataold() {
        $ProductionEntityId = $_POST['ProductionEntityId'];
        $AttributeMasterId = $_POST['AttributeMasterId'];
        $handskey = $_POST['handskey'];
        $handskeysub = $_POST['handskeysub'];
        $session = $this->request->session();
        $ProjectId = $session->read("ProjectId");
        $connection = ConnectionManager::get('default');
        $user_id = $session->read("user_id");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';
        $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][0];
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);

        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];
        $link = $connection->execute("SELECT * FROM " . $stagingTable . " where UserId=" . $user_id . " AND StatusId=" . $next_status_id . " AND ProjectId=" . $ProjectId . "")->fetchAll("assoc");
        $RegionId = $link[0]['RegionId'];
        $finalval = array();
        $PivotId = '';
        $link2 = $connection->execute("SELECT FieldTypeName,Id FROM MC_DependencyTypeMaster WHERE Type IN ('ProductionField') AND ProjectId=" . $ProjectId)->fetchAll('assoc');
        foreach ($link2 as $keytype => $valuetype) {
            //echo $keytype.'<br>';
            $PivotId.= '[' . $valuetype["Id"] . '],';
            $FieldTyper = $valuetype['FieldTypeName'];
            $FieldTypeId = $valuetype['Id'];
            $FieldTypeName = preg_replace('/\s+/', '', $FieldTyper);
            $finalval[$FieldTypeId] = $FieldTypeName;
            $depen = $valuetype["Id"];
        }
        $PivotId = rtrim($PivotId, ',');
        $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
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
        $i = 0;
        $att = 1;
        foreach ($groupwisearray[$handskey] as $keyn => $valuen) {
            foreach ($valuen as $keyprodFields => $valprodFields) {
                //$link44 = $connection->execute("select * from (select Attributevalue, SequenceNumber, DependencyTypeMasterId from MC_CengageProcessInputData WHERE AttributeMasterId=" . $valprodFields['AttributeMasterId'] . " AND ProductionEntityID=" . $ProductionEntityId . " AND ProjectId=" . $ProjectId . " ) a pivot ( max(Attributevalue) for DependencyTypeMasterId in ($PivotId)) piv;")->fetchAll('assoc');
                //echo "select Max([".$valprodFields['AttributeMasterId']."]) as ".$valprodFields['AttributeName'].",SequenceNumber  from  $stagingTable WHERE  ProductionEntity=" . $ProductionEntityId . " AND ProjectId=" . $ProjectId . " AND DependencyTypeMasterId =".$depen." GROUP BY SequenceNumber";
                $link44 = $connection->execute("select Max([" . $valprodFields['AttributeMasterId'] . "]) as " . $valprodFields['AttributeName'] . ",SequenceNumber  from  $stagingTable WHERE  ProductionEntity=" . $ProductionEntityId . " AND ProjectId=" . $ProjectId . " AND DependencyTypeMasterId =" . $depen . " GROUP BY SequenceNumber")->fetchAll('assoc');
                foreach ($link44 as $key => $value) {
                    //$valArr['handson'][$i]['DataId'] = $valprodFields['SubGroupId'];
                    if ($value['SequenceNumber'] != $att)
                        $att = 1;
                    else
                        $att = $att + 1;
                    $valArr['handson'][$value['SequenceNumber']][$valprodFields['AttributeName']] = $valprodFields['AttributeName'];
                    foreach ($finalval as $key4 => $value4) {
                        //pr($value4);
                        $valArr['handson'][$value['SequenceNumber']][$valprodFields['AttributeName']] = $value[$valprodFields['AttributeName']];
                    }
                    $old = $value['SequenceNumber'];
                    //$valArr['handson']['Id'] = $i;
                    $i++;
                }
            }
        }
        echo json_encode($valArr);
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
        //$role_id = $session->read("RoleId");
        $moduleId = $session->read("moduleId");
        $ProjectId = $_POST['ProjectId'];
        $RegionId = $_POST['RegionId'];
        $AttributeId = $_POST['attributeId'];


        $file = $this->Getjobcore->find('helptooltip', ['ProjectId' => $ProjectId, 'RegionId' => $RegionId, 'AttributeId' => $AttributeId]);
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

    function xml2array($xmlObject, $out = array()) {
        foreach ((array) $xmlObject as $index => $node)
            $out[$index] = ( is_object($node) ) ? $this->xml2array($node) : $node;

        return $out;
    }

    function ajaxinsertpurebuttal() {
        $connection = ConnectionManager::get('default');

        $PuComments = str_replace("'", "''", $_POST['PuComments']);

        $createddate = date("Y-m-d H:i:s");
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $ProjectId = $_POST['ProjectId'];
        $session = $this->request->session();
        $user_id = $session->read('user_id');
        $commentsId = $_POST['CommentsId'];
        $ModifiedDate = date("Y-m-d H:i:s");

        $connection->execute("UPDATE MV_QC_Comments SET UserReputedComments = '" . trim($PuComments) . "' where ProjectId = '" . $_POST['ProjectId'] . "' and RegionId='" . $_POST['RegionId'] . "' and InputEntityId='" . $_POST['InputEntityId'] . "' and AttributeMasterId='" . $_POST['AttributeMasterId'] . "' and ProjectAttributeMasterId='" . $_POST['ProjectAttributeMasterId'] . "' and ModuleId='" . $_POST['QcCommentsModuleId'] . "' and SequenceNumber='" . $_POST['SequenceNumber'] . "'");
        exit;
    }

    function ajaxupdateacceptstatus() {
        $connection = ConnectionManager::get('default');

        $createddate = date("Y-m-d H:i:s");
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $ProjectId = $_POST['ProjectId'];
        $session = $this->request->session();
        $user_id = $session->read('user_id');
        $commentsId = $_POST['CommentsId'];
        $ModifiedDate = date("Y-m-d H:i:s");

        $connection->execute("UPDATE MV_QC_Comments SET StatusId = 2,UserReputedComments='' where ProjectId = '" . $_POST['ProjectId'] . "' and RegionId='" . $_POST['RegionId'] . "' and InputEntityId='" . $_POST['InputEntityId'] . "' and AttributeMasterId='" . $_POST['AttributeMasterId'] . "' and ProjectAttributeMasterId='" . $_POST['ProjectAttributeMasterId'] . "' and ModuleId='" . $_POST['QcCommentsModuleId'] . "' and SequenceNumber='" . $_POST['SequenceNumber'] . "'");
        exit;
    }

    function ajaxupdaterejectstatus() {
        $connection = ConnectionManager::get('default');

        $createddate = date("Y-m-d H:i:s");
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $ProjectId = $_POST['ProjectId'];
        $session = $this->request->session();
        $user_id = $session->read('user_id');
        $commentsId = $_POST['CommentsId'];
        $ModifiedDate = date("Y-m-d H:i:s");

        $connection->execute("UPDATE MV_QC_Comments SET StatusId = 3 where ProjectId = '" . $_POST['ProjectId'] . "' and RegionId='" . $_POST['RegionId'] . "' and InputEntityId='" . $_POST['InputEntityId'] . "' and AttributeMasterId='" . $_POST['AttributeMasterId'] . "' and ProjectAttributeMasterId='" . $_POST['ProjectAttributeMasterId'] . "' and ModuleId='" . $_POST['QcCommentsModuleId'] . "' and SequenceNumber='" . $_POST['SequenceNumber'] . "'");
        exit;
    }

    function ajaxcheckreworkincomplete() {
        $connection = ConnectionManager::get('default');

        $createddate = date("Y-m-d H:i:s");
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $ProjectId = $_POST['ProjectId'];
        $session = $this->request->session();
        $user_id = $session->read('user_id');
        $commentsId = $_POST['CommentsId'];
        $ModifiedDate = date("Y-m-d H:i:s");

        $reworkCount = $connection->execute("Select count(Id) as cnt from MV_QC_Comments where ProjectId = '" . $_POST['ProjectId'] . "' and RegionId='" . $_POST['RegionId'] . "' and ModuleId='" . $_POST['QcCommentsModuleId'] . "' and InputEntityId='" . $_POST['InputEntityId'] . "' and RecordStatus=1 and StatusID IN (1,5,9)")->fetchAll('assoc');
        echo $reworkCount[0]['cnt'];
        exit;
    }

    function ajaxgetrebutteddata() {

        $connection = ConnectionManager::get('default');

        $createddate = date("Y-m-d H:i:s");
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $ProjectId = $_POST['ProjectId'];
        $session = $this->request->session();
        $user_id = $session->read('user_id');
        $commentsId = $_POST['CommentsId'];
        $ModifiedDate = date("Y-m-d H:i:s");

        $reworkCount = $connection->execute("Select UserReputedComments,TLReputedComments from MV_QC_Comments where ProjectId = '" . $_POST['ProjectId'] . "' and RegionId='" . $_POST['RegionId'] . "' and SequenceNumber='" . $_POST['SequenceNumber'] . "' and AttributeMasterId='" . $_POST['AttributeMasterId'] . "' and ModuleId='" . $_POST['QcCommentsModuleId'] . "' and InputEntityId='" . $_POST['InputEntityId'] . "' and RecordStatus=1")->fetchAll('assoc');

        $getdata['UserReputedComments'] = $reworkCount[0]['UserReputedComments'];
        $getdata['TLReputedComments'] = $reworkCount[0]['TLReputedComments'];

        echo json_encode($getdata);
        exit;
    }
	function querysubmit(){
	 $connection = ConnectionManager::get('default');

	  parse_str($_POST['Query'], $Query);
	  parse_str($_POST['QueryId'], $QueryId);
	  parse_str($_POST['QueryName'], $QueryName);
	  $ProductionEntity=$_POST['ProductionEntity'];
	 
	 
	$Htmlview="<table class='table table-center qryvalidation'>
	  <tr>
	  <th  width='20%'>Attribute Name</th>
	  <th  width='20%'>Query</th>
	  <th  width='20%'>TL Comments</th>
	  <th  width='20%'>Client Response</th>
	  <th  width='20%'>Client Response Date</th>
	  </tr>";
	  foreach ($Query as $key =>$value){
		  
		  if($value=="Yes"){
			  $ID=explode("_",$key);
			  $newkey=$ID[1];
			  $comments ="";
			  $tlcomments = "";
			  $cl_resp = "";
			  $cl_date = "";
			  
			   $result = $connection->execute("Select Client_Response,Client_Response_Date,Query,TLComments from ME_UserQuery where AttributeMasterId = '" . $newkey . "' AND ProductionEntityId=$ProductionEntity")->fetchAll('assoc');
			   
			   
		  if(!empty($result)){
			  $comments = $result[0]['Query'];
			  $tlcomments = $result[0]['TLComments'];
			  $cl_resp = $result[0]['Client_Response'];
                          if(!empty($result[0]['Client_Response_Date']) && $result[0]['Client_Response_Date'] !='NULL'){
			  $cl_date = date("d-m-Y",strtotime($result[0]['Client_Response_Date']));
                          }
                          else{
                          $cl_date = "";    
                          }
		  }

        
			  
			  $Htmlview.='<tr>
			  <td>'.$QueryName['querynameall'][$newkey].'</td>
			  <td><textarea name="query['.$newkey.']" id="qry['.$newkey.']" rows="4" cols="30" placeholder="" class="submit_query">'.$comments.'</textarea>
                             <input type="hidden" name="totqry" id="totqry" value='.$newkey.'> 

</td>
			  <td>'.$tlcomments.'</td>
			  <td>'.$cl_resp.'</td>
			  <td>'.$cl_date.'</td>
			  </tr>';
	  
		  }
		  
		  
		  
	  }
	   $Htmlview.="</table>";
	   echo  $Htmlview;
	   exit;
		
		
	}
	function ajaxGetAPIToken(){
		$session = $this->request->session();
		$ProjectId = $session->read("ProjectId");
		
		 $jobId = $_POST['domainId'];
		
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
		$projectConfigs=$JsonArray['ProjectConfig'];
		/* $fields = array(
            'username' => "khaleelurrehmanm@mobiusservices.com",
            'password' => "Lease@123",
            'grant_type' => "password"
        );
		 $fields_string = http_build_query($fields);
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.botminds.ai/token");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: application/x-www-form-urlencoded'                                            
                                            ));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		//pr($server_output);
        $server_output = curl_exec($ch);
		curl_close($ch);
		$server_output=json_decode($server_output);
		$token= 'Bearer '.$server_output->access_token;
		$projectId=$projectConfigs['ApiProjectId'];
		$templateId=$projectConfigs['ApiTemplateId'];
		  $documnetName=$JsonArray[$ProjectId].'_'.$jobId.'_Lease.pdf'; //exit;
		//$projectId='95d832f0deb14e85a3f8dcac10414e75';
		  $filesize=filesize('C:\inetpub\wwwroot\mojov2\webroot\htmlfiles\\'.$documnetName); //exit;
		//$filesize=553383;
		$namehash=md5($documnetName.$filesize);
		$resourceurl='https://browser.botminds.ai/getPdfContent?file='.$projectId.'-'.$namehash;
		 $docid=md5($resourceurl);
		 //echo "https://api.botminds.ai/api/document/exportkeywords/".$projectId."/".$docid."/".$templateId;
		//exit;
		$ch = curl_init();
		$curlConfig = array(
        CURLOPT_URL            => "https://api.botminds.ai/api/document/exportkeywords/".$projectId."/".$docid."/".$templateId,
	
        CURLOPT_HTTPHEADER=>array(
                                            'Content-Type: application/json',
											'SubscriptionId:8e00b698c5464c5ea252d30e5056cea6',
											"Authorization:$token"
                                            )
);
curl_setopt_array($ch, $curlConfig);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$result = curl_exec($ch);


$result2=json_decode($result);
//pr($result2);
  $tsv=str_replace(' ','%20',$result2->Result);

//echo $tsv = "https://finonsstorage.blob.core.windows.net/exportkeywords/SH_SH%20US017P01%20-%20Lease_1532748815.tsv?sv=2017-07-29&sr=b&sig=SaglL1yWHJYVgD7NnmfjttHc%2B7y%2BHYtOTjNPhwzECL8%3D&se=2018-07-28T03%3A38%3A35Z&sp=r";
$filepath = "C:\inetpub\wwwroot\mojov2\webroot\\$documnetName.tsv";
//exit;
//echo $tsv;
//echo $filepath;

if(!copy($tsv, $filepath)) {
echo 'error in copy';
exit;
 }
 */
  $filepath = 'C:\xampp\htdocs\mojo\webroot\test.tsv';
 $load_keys=false;
 $array = array();
 
//    if (!file_exists($filepath)){ return $array; }
//    $content = file($filepath);
//   // echo '<pre>';
// 
//    for ($x=0; $x < count($content); $x++){
//        if (trim($content[$x]) != ''){
//            $line = explode("\t", trim($content[$x]));
//            if ($load_keys){
//                $key = array_shift($line);
//                $array[$key] = $line;
//            }
//            else { $array[] = $line; }
//        }
//    }
    
    $fp = fopen('C:\xampp\htdocs\mojo\webroot\test.tsv','r');
$result = array();

while (($line = fgetcsv($fp, 0, "\t")) !== FALSE) if ($line) { 
    //echo $line;
    if($line[0]!='')
        $array[] = $line; 
    
}
fclose($fp);


//pr($result);
  //pr($array);
  $ProductionFields = $JsonArray['ModuleAttributes']['1011'][145]['production'];
  $GroupAttribute=$JsonArray['AttributeGroupMasterDirect'];
  $SubGroupAttribute=$JsonArray['AttributeSubGroupMaster'];
  
        $connection = ConnectionManager::get('default');
        $ProdFieldID = $connection->execute("Select Id from MC_DependencyTypeMaster where Type in ('ProductionField','Disposition') AND ProjectId=" . $ProjectId)->fetchAll('assoc');
       
  foreach ($GroupAttribute as $key => $value) {
                $groupwisearray[$key] = $value;
                $keys = array_map(function($v) use ($key, $emparr) {
                    if ($v['MainGroupId'] == $key) {
                        return $v;
                    }
                }, $ProductionFields);
                $keys_sub = $this->combineBySubGroup($keys);
			   if(!empty($keys_sub))
                $groupwisearray[$key] = $keys_sub;
            }
			$groupwisearray= array_filter(array_map('array_filter', $groupwisearray));
                       
            $option_list = array(0=>'Base Rent',1=>'Tags',2=>'Units',3=>'Operations',4=>'Lessee',5=>'Lessor',6=>'Renewal',7=>'Expiration',8=>'Rent Change - Index',9=>'Lessee Notice Copy',10=>'Lessor Notice Copy',11=>'Payment Contact',12=>'Sublessee',13=>'Sublessee Notice Copy',14=>'Sublessor',15=>'Sublessor Notice Copy',16=>'CAM/OpEx/ServChrg',17=>'Free Rent / Abatement',18=>'RE Tax',19=>'Insurance',20=>'Parking',21=>'VAT',22=>'Sales Tax',23=>'Utilities',24=>'Storage',25=>'Tenant Improvements',26=>'Security Deposit',27=>'Peppercorn',28=>'Other',29=>'Alterations',30=>'Assignment/Sublet',31=>'Audit Rights',32=>'Holdover',33=>'Insurance - Building',34=>'Late Charges',35=>'Parking',36=>'Permitted Use',37=>'Relocation',38=>'Signage',39=>'Surrender/Reinstatement',40=>'UK L&T Act',41=>'Safety Equipment',42=>'Tenant Improvements/Allowance',43=>'Right of 1st Offer/Refusal',44=>'Redecoration (UK)',45=>'RE Taxes/Rates/Appeals',46=>'Other Charges & Fees',47=>'Opex/Service Charges',48=>'Maintenance & Repairs',49=>'Estoppel',50=>'Landlord',51=>'Notice - Landlord',52=>'Notice - Tenant',53=>'Payee',54=>'Tenant',55=>'Auto Renew/Expiry Notice',56=>'Cancel/Break - LL',57=>'Rolling Cancel/Break - LL',58=>'Cancel/Break - Mutual',59=>'Rent Change - Index',60=>'Rent Review - Market',61=>'Rolling Cancel/Break - Mutual',62=>'Expiration Notice',63=>'Cancel/Break - TT',64=>'Rolling Cancel/Break - TT',65=>'Contraction',66=>'Expansion',67=>'Purchase/Buy',68=>'Must Expand',69=>'Must Reduce');
            $option_list_key = array(1=>'Expiration');
            $option_list_option = array(54=>'Renewal',55=>'Auto Renew/Expiry Notice',56=>'Cancel/Break - LL',57=>'Rolling Cancel/Break - LL',58=>'Cancel/Break - Mutual',59=>'Rent Change - Index',60=>'Rent Review - Market',61=>'Rolling Cancel/Break - Mutual',62=>'Expiration Notice',63=>'Cancel/Break - TT',64=>'Rolling Cancel/Break - TT',65=>'Contraction',66=>'Expansion',67=>'Purchase/Buy',68=>'Must Expand',69=>'Must Reduce',70=>'other');

 $groupId='';$groupidorg='';$subgrup=0;$start_array = 1;$rentSearchprevoud='';$type_name = ''; $type_keys='';$final_type='';$temp = '';$tempsubgrup='';

     foreach($array as $attributeArr){  
         //echo $attributeArr[0];
         //echo '<br>';
	   if(count($attributeArr)==1){
               //if($tempGrpId!=$groupidorg)
                        //$lastSequenc=1;
            $tempGrpSearch = '';
             $rentSearch  = in_array($attributeArr[0], $option_list);
            if($rentSearch){
               
				if($groupidorg!=''){
                                    $groupidorg=$groupId;
                                    $subgrup = array_keys($SubGroupAttribute[$groupidorg]);
                                    //pr($subgrup);
                                   // echo $attributeArr[0];
                                    if(in_array($attributeArr[0], $option_list_key))
                                    {
                                         if($tempsubgrup!=$subgrup)
                                        $start_array=-1;
					 $subgrup = $subgrup[0];
                                         $tempsubgrup=$subgrup;
                                    }
                                    else if(in_array($attributeArr[0], $option_list_option)){
                                        if($tempsubgrup!=$subgrup)
                                        $start_array=-1;
                                         $subgrup = $subgrup[1];
                                         $tempsubgrup=$subgrup;
                                    }
                                    else {
                                        
					 $subgrup = $subgrup[0];
                                    }
					
					//echo $subgrup;
				}
				 $tempGrpSearch = 'options';
                                // echo $tempGrpId."!=".$groupidorg;
                                 if($tempGrpId!=$groupidorg){
                                       $start_array=-1;
                                 // $lastSequenc=1;
                                 }
                                 $tempGrpId  = $groupidorg;
			}
            else{
				$groupId=array_search($attributeArr[0],$GroupAttribute);
				if($groupId!=''){
					$groupidorg=$groupId;
					$subgrup=0;
					$tempGrpSearch='';
				}
				if(!empty($SubGroupAttribute[$groupidorg])){
					$subgrup_search=array_search($attributeArr[0],$SubGroupAttribute[$groupidorg]);
					if(!empty($subgrup_search)){
						$subgrup=$subgrup_search;
					}
				}
			}
		}
        else {
			
             if($tempGrpSearch == ''){
                     if($tempGrpId!=$groupidorg)
                        $lastSequenc=1;
				$keys = array_keys(array_column($groupwisearray[$groupidorg][$subgrup], 'DisplayAttributeName','AttributeMasterId'), $attributeArr[0]);
                if($keys[0] != ''){
					$update['singleAttr']['ProductionFields_'.$keys[0].'_'.$ProdFieldID[0]['Id'].'_1']=trim($attributeArr[1],'"');
                    $update['singleAttr']['ProductionFields_'.$keys[0].'_'.$ProdFieldID[1]['Id'].'_1']='A';
                    }
               }
         }  
         if($tempGrpSearch != ''){
            $t=1;
            //echo count($attributeArr);
            $rentSearch  = in_array($attributeArr[0], $option_list);
            if($rentSearch){
                if(count($attributeArr)==1) {
                $type_name = $attributeArr[0];
                $work_type = $SubGroupAttribute[$groupidorg][$subgrup];
                if($work_type == 'Rent'){
                   $final_type = 'Expense Type';
                }
                else if($work_type == 'Key Dates'){
                    $final_type = 'Key Dates Type';
                }
                else if($work_type == 'Options'){
                    $final_type = 'Option Type';
                }
				else if($work_type == 'Contacts'){
                    $final_type = 'Contacts';
                }
                else if($work_type == 'Lease Clauses'){
                    $final_type = 'Clauses Type';
                }
                else {
                    $final_type = 'Option Type';
                }
                
                $keys = array_keys(array_column($groupwisearray[$groupidorg][$subgrup], 'DisplayAttributeName','AttributeMasterId'), $final_type); 
                
             //echo '<br>' ;                                  ;
             //echo $attributeArr[0];
             //echo '-';
             //echo $start_array   ;
             //echo '<br>' ;
           if($start_array!=-1)
           {
               //echo 'coming';
               $start_array=$lastSequenc+1;
                $count=count($attributeArr)+$start_array;
                
           }
           else {
               $start_array=1;
           $seq=1;$lastSequenc=1;
           $count=count($attributeArr);
               $type_keys = $keys;
           }
                }
            }
            
            else{
                
		  $keyss = $type_keys;
                  $keys = array_keys(array_column($groupwisearray[$groupidorg][$subgrup], 'DisplayAttributeName','AttributeMasterId'), $attributeArr[0]);
                  $count=count($attributeArr);
                  if($start_array!=1) 
                      $count=(count($attributeArr)-1)+$start_array;
            }
          //  echo '<br>'.$start_array.'-'.$count.'<br>';
            for($c= $start_array; $c < $count; $c++)
            {
                $temp = $keyss[0];
				if(($keys[0] != '') && ($rentSearch == '')){
                 $update['addAttrGroup']['ProductionFields_'.$keyss[0].'_'.$ProdFieldID[0]['Id'].'_'.$c]=$type_name;
					$update['addAttrGroup']['ProductionFields_'.$keys[0].'_'.$ProdFieldID[0]['Id'].'_'.$c]=trim($attributeArr[$t],'"');
                                        $update['funcValGroup'][$c]['ProductionFields_'.$keys[0].'_'.$ProdFieldID[0]['Id'].'_'.$c] = $subgrup.'_'.$groupidorg.'_'.trim($attributeArr[$t],'"');
					$update['addAttrGroup']['ProductionFields_'.$keys[0].'_'.$ProdFieldID[1]['Id'].'_'.$c]='A';
				}
				  
				$t++;
			if($c>$seq) {
				$seq = $c;
                                
                               $lastSequenc=$c;
            }
                       
            }
        }   //echo 'coming'; exit;
        if($tempGrpSearch == ''){
			if(count($attributeArr) > 2){
				$groupAddition = $connection->execute("Select Is_Distinct from MC_Subgroup_Config where Primary_Group_Id = $groupidorg AND Subgroup_Id = $subgrup AND RecordStatus = 1 AND ProjectId=" . $ProjectId)->fetchAll('assoc');
				if($groupAddition[0]['Is_Distinct'] != 1){
					for($c= 2; $c < count($attributeArr); $c++){
						$keys = array_keys(array_column($groupwisearray[$groupidorg][$subgrup], 'DisplayAttributeName','AttributeMasterId'), $attributeArr[0]);
						$Projectkeys = array_keys(array_column($groupwisearray[$groupidorg][$subgrup], 'DisplayAttributeName','ProjectAttributeMasterId'), $attributeArr[0]);
						$DisplayName = array_keys(array_column($groupwisearray[$groupidorg][$subgrup], 'DisplayAttributeName','DisplayAttributeName'), $attributeArr[0]);
						if($keys[0] != ''){
							$update['addAttrSingle']['ProductionFields_'.$keys[0].'_'.$ProdFieldID[0]['Id'].'_'.$c]=trim($attributeArr[$c],'"');
							$update['funcValSingle']['ProductionFields_'.$keys[0].'_'.$ProdFieldID[0]['Id'].'_'.$c] = $keys[0].'_'.$Projectkeys[0].'_'.$groupidorg.'_'.$subgrup.'_'.$DisplayName[0].'_'.$attributeArr[$c];
							$update['addAttrSingle']['ProductionFields_'.$keys[0].'_'.$ProdFieldID[1]['Id'].'_'.$c]='A';
                        } 
					}
				}
				else{
					for($c= 2; $c < count($attributeArr); $c++){
						$keys = array_keys(array_column($groupwisearray[$groupidorg][$subgrup], 'DisplayAttributeName','AttributeMasterId'), $attributeArr[0]);
						if($keys[0] != ''){
							$update['addAttrGroup']['ProductionFields_'.$keys[0].'_'.$ProdFieldID[0]['Id'].'_'.$c]=trim($attributeArr[$c],'"');
                                                    
                                                        $update['funcValGroup'][$c]['ProductionFields_'.$keys[0].'_'.$ProdFieldID[0]['Id'].'_'.$c] = $subgrup.'_'.$groupidorg.'_'.trim($attributeArr[$c],'"');
                            $update['addAttrGroup']['ProductionFields_'.$keys[0].'_'.$ProdFieldID[1]['Id'].'_'.$c]='A';
                        } 
					}
      
				}
			}
		}
    }
         
   if($update == ''){
      $update = 'No Data';
   }
   //pr($update);
   echo json_encode($update);
 
curl_close($ch); 
		exit;
	}    
 function datecalculator() {
     $connection = ConnectionManager::get('default');
     $session = $this->request->session();
     $ProjectId = $session->read("ProjectId");
     $moduleId = $session->read("moduleId");
     $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
     $prod = $JsonArray['ModuleAttributes'][1011][$moduleId]['production'];
     $this->set('JsonArray', $JsonArray);
     $this->set('prod', $prod);
//      
//     $Commencementkey = $this->searchForId($Commencement,$prod);
//     $Expirationkey = $this->searchForId($Expiration,$prod);
//    $this->set('CommencementProjAttrmasterid',$Commencementkey);
//    $this->set('ExpirationProjAttrmasterid', $Expirationkey);
//     print_r($ProjectId);exit;
                 
	}
        
     
       
function dateformatselectors($datfrmt,$date){
 // convert seconds into a specific format
 $newEndDate = '';
 if($datfrmt =='MM-dd-yy'){
      $newEndDate='m-d-Y';
 }
 else if($datfrmt =='y-M-d'){
      $newEndDate='Y-m-d';
 }
 else if($datfrmt =='M/d/y'){
        $newEndDate='m/d/Y';
 }
 else if($datfrmt =='M/d/y H:m'){
      $newEndDate='m/d/Y';
 }
 else{
      $newEndDate='d-m-Y';
 }

 $date = date($newEndDate, strtotime($date));
 
return $date;

}

 function datecalculatrformat() {
     
      $connection = ConnectionManager::get('default');
     $session = $this->request->session();
     $ProjectId = $session->read("ProjectId");
     $moduleId = $session->read("moduleId");
     $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
     $prod = $JsonArray['ModuleAttributes'][1011][$moduleId]['production'];
     
     $dateval = $this->request->data['datevals'];
     $attributeid = $this->request->data['attributeid'];
    
     $productionattributeid = $this->searchForId($attributeid,$prod);
     $dateformat=$JsonArray['ValidationRules'][$productionattributeid]['Dateformat'];
     $date = $this->dateformatselectors($dateformat,$dateval);
     echo $date;
     exit;
     
 }
        
 function ajaxRentcal(){

        $session = $this->request->session();
        $ProjectId = $session->read("ProjectId");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
      
       $C_dateformat= $JsonArray['ValidationRules'][$_POST['CommencementId']]['Dateformat'];
       $E_dateformat= $JsonArray['ValidationRules'][$_POST['ExpirationId']]['Dateformat'];
       
        ////format///
  if($C_dateformat =='MM-dd-yy'){
       $F_date=explode("-",$_POST['Commencement']);
       $_POST['Commencement']=$F_date[1]."-".$F_date[0]."-".$F_date[2];
  }
  elseif($C_dateformat =='y-M-d'){
      
       $F_date=explode("-",$_POST['Commencement']);
       $_POST['Commencement']=$F_date[2]."-".$F_date[1]."-".$F_date[0];
      
  }
  elseif($C_dateformat =='M/d/y'){      
       $F_date=explode("/",$_POST['Commencement']);
       $_POST['Commencement']=$F_date[1]."-".$F_date[0]."-".$F_date[2];
      
  } 
  elseif($C_dateformat =='M/d/y H:m'){
      
       $F_date=explode("/",$_POST['Commencement']);
       $_POST['Commencement']=$F_date[1]."-".$F_date[0]."-".$F_date[2];
      
  } 
  else{
       $newStartDate=$dt->format("d-m-Y");
       
  }
  //expiredate
  if($E_dateformat =='MM-dd-yy'){
       $F_date=explode("-",$_POST['Expiration']);
       $_POST['Expiration']=$F_date[1]."-".$F_date[0]."-".$F_date[2];
  }
  elseif($E_dateformat =='y-M-d'){
      
     
       $F_date=explode("-",$_POST['Expiration']);
       $_POST['Expiration']=$F_date[2]."-".$F_date[1]."-".$F_date[0];
      
  }
  elseif($E_dateformat =='M/d/y'){
      
      
       $F_date=explode("/",$_POST['Expiration']);
       $_POST['Expiration']=$F_date[1]."-".$F_date[0]."-".$F_date[2];
      
  }  
  elseif($E_dateformat =='M/d/y H:m'){
      
       $F_date=explode("/",$_POST['Expiration']);
       $_POST['Expiration']=$F_date[1]."-".$F_date[0]."-".$F_date[2];
      
  }  
  else{
      $newEndDate=date("d-m-Y", strtotime($Mindate));
  }
    ////format end////
       
       
//echo $_POST['Rentval']."hello";
     
       
    ////format///
 $startFormat ='d-m-Y';   
 $endFormat ='d-m-Y';    
       
 if($C_dateformat =='MM-dd-yy'){
      $F_date=explode("-",$_POST['Commencement']);
      $_POST['Commencement']=$F_date[1]."-".$F_date[0]."-".$F_date[2];
      $startFormat ='m-d-Y';
 }
 elseif($C_dateformat =='y-M-d'){
      $F_date=explode("-",$_POST['Commencement']);
      $_POST['Commencement']=$F_date[2]."-".$F_date[1]."-".$F_date[0];
      $startFormat ='Y-m-d';
 }
 elseif($C_dateformat =='M/d/y'){
     
      $F_date=explode("/",$_POST['Commencement']);
      $_POST['Commencement']=$F_date[1]."-".$F_date[0]."-".$F_date[2];
      $startFormat ='m/d/Y';
 } 
 elseif($C_dateformat =='M/d/y H:m'){
      $F_date=explode("/",$_POST['Commencement']);
      $_POST['Commencement']=$F_date[1]."-".$F_date[0]."-".$F_date[2];
      $startFormat ='m/d/Y';
 }
 //expiredate
 if($E_dateformat =='MM-dd-yy'){
      $F_date=explode("-",$_POST['Expiration']);
      $_POST['Expiration']=$F_date[1]."-".$F_date[0]."-".$F_date[2];
       $endFormat ='m-d-Y';
 }
 elseif($E_dateformat =='y-M-d'){
      $F_date=explode("-",$_POST['Expiration']);
      $_POST['Expiration']=$F_date[2]."-".$F_date[1]."-".$F_date[0];
      $endFormat ='Y-m-d';
 }
 elseif($E_dateformat =='M/d/y'){
      $F_date=explode("/",$_POST['Expiration']);
      $_POST['Expiration']=$F_date[1]."-".$F_date[0]."-".$F_date[2];
      $endFormat ='m/d/Y';
 }  
 elseif($E_dateformat =='M/d/y H:m'){
      $F_date=explode("/",$_POST['Expiration']);
      $_POST['Expiration']=$F_date[1]."-".$F_date[0]."-".$F_date[2];
      $endFormat ='m/d/Y';
     
 }
   ////format end////
 
    /* echo $_POST['ProjectId']."-".$_POST['Commencement']."-".$_POST['Expiration']."-".$_POST['BaseRent']."-".$_POST['RentInc']."-"."-".$_POST['Frequency'];
     exit;*/
 $date_set="yes";    
 
 ///////check date////////

 
 
  $CSdate=date("Y-m-d", strtotime($_POST['Commencement']));
  $CEdate=date("Y-m-d", strtotime($_POST['Expiration']));
  
  $CFdate = date('Y-m-d', strtotime($CSdate . $_POST['Frequency']));  
  $mindateArr=array($CEdate,$CFdate);
  $CheckMindate=date("Y-m-d", strtotime(min($mindateArr)));
  
if($CheckMindate == $CEdate && $CEdate !=$CFdate){
    $date_set="no";  
}
  
 ////// check date end//////
 
$percentage = $_POST['RentInc'];
$total = $_POST['BaseRent'];
$PercentageAmount = ($percentage / 100) * $total;
$Fromdate=date('Y-m-d',strtotime($_POST['Commencement']));

$Todate=date('Y-m-d',strtotime($_POST['Expiration']));

$Fromday=date('d',strtotime($_POST['Commencement']));
$Today=date('d',strtotime($_POST['Expiration']));

$start    = new \DateTime($Fromdate);
$start->modify(''.$Fromday.' day of this month');
$end      = new \DateTime($Todate);
$end->modify(''.$Today.' day of next month');
//$interval = \DateInterval::createFromDateString($_POST['Frequency']);
$interval = \DateInterval::createFromDateString($_POST['Frequency']);
$period   = new \DatePeriod($start, $interval, $end);
//print_r($period);exit;
//foreach ($period as $dt) {
// echo $dt->format("Y-m-d") . "<br>\n";
//}


 $Htmlview="<table class='table table-center'>
	  <tr>
	  <th  width='20%'>% Change</th>
	  <th  width='20%'>Amount ($)</th>
	  <th  width='20%'>Expense Start</th>
	  <th  width='20%'>Expense End</th>
	  </tr>";
foreach ($period as $dt) {

    
  $StartDate=$dt->format("d-m-Y");
  $Edate=date("d-m-Y", strtotime($_POST['Frequency'], strtotime($StartDate)));
  $Endcheck_date = date('Y-m-d', strtotime($Edate . ' -1 day'));  
  
  
  $CheckEdate=date("Y-m-d", strtotime($_POST['Expiration']));
  $mindateArr=array($CheckEdate,$Endcheck_date);
  $Mindate=date("d-m-Y", strtotime(min($mindateArr)));

$total =$total + ($percentage / 100) * $total;
$n = $total;
$whole = floor($n);      // 1
$fraction = $n - $whole; // .25
if($fraction > 0){
$total =number_format((float)$total, 2, '.', '');
}
    
  ////format///
  if($C_dateformat =='MM-dd-yy'){
       $newStartDate=$dt->format("m-d-Y");
  }
  elseif($C_dateformat =='y-M-d'){
      
       $newStartDate=$dt->format("Y-m-d");
      
  }
  elseif($C_dateformat =='M/d/y'){
      
       $newStartDate=$dt->format("m/d/Y");
      
  }
  elseif($C_dateformat =='M/d/y H:m'){
      
       $newStartDate=$dt->format("m/d/Y");
      
  } 
  else{
       $newStartDate=$dt->format("d-m-Y");
  }
  //expiredate
  if($E_dateformat =='MM-dd-yy'){
       $newEndDate=date("m-d-Y", strtotime($Mindate));
  }
  elseif($E_dateformat =='y-M-d'){
      
       $newEndDate=date("Y-m-d", strtotime($Mindate));
      
  }
  elseif($E_dateformat =='M/d/y'){
     
      
       $newEndDate=date("m/d/Y", strtotime($Mindate));
      
  }  
  elseif($E_dateformat =='M/d/y H:m'){
      
       $newEndDate=date("m/d/Y", strtotime($Mindate));
      
  }  
  else{
      $newEndDate=date("d-m-Y", strtotime($Mindate));
  }
    ////format end////
  //  echo $dt->format("Y-m-d") . "<br>\n";
    
    $Htmlview.='<tr>
			  <td>'.$percentage.'<input type="hidden" name="percent[]" id="percent[]" value="'.$percentage.'" class="percent-class"></td>
			  <td>'.$total.'<input type="hidden" name="totalamt[]" id="totalamt[]" value="'.$total.'" class="totalamt-class"></td>
			  <td>'.$newStartDate.'<input type="hidden" name="startdate[]" id="startdate[]" value="'.$newStartDate.'" class="startdate-class"></td>
			  <td>'.$newEndDate.'<input type="hidden" name="enddate[]" id="enddate[]" value="'.$newEndDate.'" class="enddate-class"></td>
			  </tr>';
}

  $Htmlview.='</table">';
  $Htmlview.='<input type="hidden" name="startFormat" id="startFormat" value="'.$startFormat.'"">'
          . '<input type="hidden" name="endFormat" id="endFormat" value="'.$endFormat.'" ">';

 
     if($date_set=="yes"){
     echo $Htmlview;
     exit;
     }
     else{
     echo "0";
     exit;
    }
 }  
 
function ajaxSearch(){  
$OSF_CO_NAME = $_POST['OSF_CO_NAME'];
$FORMER_CO_NAME = $_POST['FORMER_CO_NAME'];

  $connection = ConnectionManager::get('default');
 // echo "Select Brands from Brands where CO_ENT_NBR = '" . $CO_ENT_NBR . "'";
 $test='';
if($OSF_CO_NAME!='' && $FORMER_CO_NAME==''){
	$test.="  OSF_CO_NAME like '".$OSF_CO_NAME."%'";
}

if($FORMER_CO_NAME!='' && $OSF_CO_NAME=='' ){
	$test.="  FORMER_CO_NAME like '".$FORMER_CO_NAME."%'";
}
if($FORMER_CO_NAME!='' && $OSF_CO_NAME!='' ){
	$test.="  FORMER_CO_NAME like '".$FORMER_CO_NAME."%' AND OSF_CO_NAME like '".$OSF_CO_NAME."%'";
}

 $result = $connection->execute("Select top 100 * from OSF 
 LEFT JOIN Bio_Former_Employment ON Bio_Former_Employment.EXEC_LINK_ID=OSF.CO_ENT_NBR
 LEFT JOIN CA1 ON CA1.CO_ENT_NBR =OSF.CO_ENT_NBR
 LEFT JOIN Bio_Current_Employment ON Bio_Current_Employment.CO_ROOT_ID =OSF.CO_ENT_NBR
 LEFT JOIN Bio_Certifications ON Bio_Certifications.EXEC_LINK_ID =OSF.CO_ENT_NBR
 LEFT JOIN Bio_Awards ON Bio_Awards.EXEC_LINK_ID =OSF.CO_ENT_NBR
 LEFT JOIN Bio_Associations ON Bio_Associations.EXEC_LINK_ID =OSF.CO_ENT_NBR
  
 where $test " )->fetchAll('assoc');
			   
 $Htmlview="<table class='table table-center'>
	  <tr>
	  <th  width='20%'>Company Name</th>
	  <th  width='20%'>Company Enterprise Number</th>
	  </tr>";
	 // pr($result);
foreach ($result as $set) {

 	$populate="'".$set['COMP_ENT_NBR']."','".$set['COMP_CO_ID']."','".$set['COMP_CO_NAME']."','".$set['Address1']."','".$set['City']."','".$set['State']."','".$set['Zip']."','".$set['Email']."','".$set['URL']."','".$set['Phone']."','".$set['Fax']."','".$set['Toll_Free']."','".$set['Address1']."','".$set['Address2']."','".$set['Address3']."','".$set['Postal_Code1']."','".$set['City']."','".$set['Province']."','".$set['Postal_Code2']."','".$set['Country']."','".$set['Postal_Code3']."','".$set['Email']."','".$set['URL']."','".$set['Phone']."','".$set['Fax']."','".$set['Toll_Free']."','".$set['Mailing_Address1']."','".$set['Mailing_City']."','".$set['Mailing_State']."','".$set['Mailing_Zip']."','".$set['Email']."','".$set['URL']."','".$set['Phone']."','".$set['Fax']."','".$set['Toll_Free']."','".$set['Mailing_Address1']."','".$set['Mailing_Address2']."','".$set['Mailing_Address3']."','".$set['Mailing_PostalCode1']."','".$set['Mailing_City']."','".$set['Mailing_Province']."','".$set['Mailing_Postal_Code2']."','".$set['Mailing_Country']."','".$set['Mailing_Postal_Code3']."','".$set['Email']."','".$set['URL']."','".$set['Phone']."','".$set['Fax']."','".$set['Toll_Free']."','".$set['Nbr_Employees']."','".$set['Revenue_Type']."','".$set['Sales']."','".$set['Upper_Sales_Range']."','".$set['Net_Income']."','".$set['Assets']."','".$set['Liabilities']."','".$set['Net_Worth']."','".$set['Fiscal_Yr_End_Date']."','".$set['FYE_MMDD']."','".$set['Nbr_Employee_Benefits']."','".$set['Pension_Type1']."','".$set['Pension_Assets']."','".$set['Pension_Ending_Date']."','".$set['Ticker']."','".$set['Stock_Exchange1']."','".$set['Cusip_Nbr']."','".$set['OSF_CO_NAME']."','".$set['OSF_ADDRESS1']."','".$set['OSF_CITY']."','".$set['OSF_COUNTRY']."','".$set['OSF_CO_NAME']."','".$set['OSF_ADDRESS1']."','".$set['OSF_CITY']."','".$set['OSF_COUNTRY']."','".$set['OSF_CO_NAME']."','".$set['OSF_ADDRESS1']."','".$set['OSF_CITY']."','".$set['OSF_COUNTRY']."','".$set['OSF_CO_NAME']."','".$set['OSF_ADDRESS1']."','".$set['OSF_CITY']."','".$set['OSF_COUNTRY']."','".$set['FIRST_NAME']."','".$set['MIDDLE_NAME']."','".$set['LAST_NAME']."','".$set['SUFFIX']."','".$set['Personnel_ID']."','".$set['Exec_Title']."','".$set['RESP_CODES']."','".$set['Board_Ind']."','".$set['Chairman_Ind']."','".$set['COMPENSATIONS']."','".$set['COMMITTEES']."','".$set['BD_START_DATE']."','".$set['BD_END_DATE']."','".$set['EXEC_TITLE_START_DATE']."','".$set['EXEC_TITLE_END_DATE']."','".$set['School']."','".$set['Degree']."','".$set['Area']."','".$set['Year']."','".$set['CERT_NAME']."','".$set['Year']."','".$set['AWARD_NAME']."','".$set['YEAR']."','".$set['ASSOC_COUNCIL_NAME']."','".$set['COMMITTEE']."','".$set['ROLE']."','".$set['START_DATE']."','".$set['END_DATE']."','".$set['GENDER']."','".$set['FORMER_CO_ENT_NBR']."','".$set['FORMER_CO_NAME']."','".$set['FORMER_EXEC_TITLE']."','".$set['DATE_OF_BIRTH']."','".$set['START_DATE']."','".$set['End_DATE']."','".$set['COMPENSATIONS']."','".$set['COMMITTEES']."','".$set['EXEC_LINK_ID']."','".$set['PERSONNEL_ID']."'";
//$populate="'".$set['CO_NAME']."','".$set['TRADE_NAME']."'";
    $Htmlview.='<tr onclick="populate('.$populate.')" style="cursor: pointer;">
			  <td>'.$set['FORMER_CO_NAME'].'</td>
			  <td>'.$set['CO_ENT_NBR'].'</td>
			  
			  </tr>';
}
 $Htmlview.='</table">';
     
    echo $Htmlview;
     exit;
 }
 
 function ajaxgetdatahandalldata() {
     if($_POST['singleAttr']=="no"){
     $Attr =explode("-",$_POST['AttributeMasterId']);
     $setArr= array_filter($Attr);
     }
     else{
      $setArr = array(0 => $_POST['AttributeMasterId']);
     }
     //print_r($setArr);exit;
	 
     $i=0;
     $ListAttrId='';
     $qc_datarownew='';
     $tblheadnew='';
    echo $totattr= count($setArr);
    $OrderAttribute='[' . $setArr[0] . ']';
     foreach ($setArr as $val){       
         if($i > 0){
         $ListAttrId.=",";
         }
          $ListAttrId.= '[' . $val . ']';
          $i++;
     }

     
     $session = $this->request->session();
     $moduleId = $session->read("moduleId");
     $Attributes =implode(",",$setArr);
     $InputEntity=$_POST['InputEntityId'];
     $stagingtable = 'Staging_'.$moduleId.'_Data';
      
        $ProductionEntityId = $_POST['ProductionEntityId'];
        $AttributeMasterId = $_POST['AttributeMasterId'];
       //  $moduleId = $_POST['ModuleId'];
        $Title = $_POST['title'];
        $Prvseq = $_POST['prvseq'];


        
        $handskeysub = $_POST['handskeysub'];
        $ProjectId = $session->read("ProjectId");
        $connection = ConnectionManager::get('default');
        $user_id = $session->read("user_id");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $link = $connection->execute("SELECT RegionId FROM ProductionEntityMaster where ProjectId=" . $ProjectId . " AND Id='".$ProductionEntityId."'")->fetchAll('assoc');
          
        $RegionId = $link[0]['RegionId'];       

	 $link2 = $connection->execute("SELECT FieldTypeName,Id FROM MC_DependencyTypeMaster WHERE FieldTypeName IN ('After Normalized') AND ProjectId=".$ProjectId)->fetchAll('assoc');
     
        foreach ($link2 as $keytype => $valuetype) {
            $NormalizedId=$valuetype["Id"];
        }
       
   
        //$ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
		/*$firstModuleId = $JsonArray['ModuleAttributes'][$RegionId];
                foreach ($firstModuleId as $keys => $valuesval) {
                        $fineval[] = $keys;
                }
		$modulIdSS = $fineval[0];
                
                 */
   

        $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
        foreach($ProductionFields as $key=>$val){
            if(in_array($val['AttributeMasterId'] , $setArr)){
                $tblheadnew.="<td align='center'>".$val['DisplayAttributeName']."</td>";
                $handskeysub =$val['SubGroupId'];
                $handskeymain =$val['MainGroupId'];
            }
        }
       //echo "SELECT DISTINCT sequenceNumber,$ListAttrId FROM $stagingtable WITH (NOLOCK) WHERE  ProjectId='".$ProjectId."' AND InputEntityId='".$InputEntity."' AND DependencyTypeMasterId=$NormalizedId AND UserId= $user_id  Order by $OrderAttribute asc";
        $link4 = $connection->execute("SELECT DISTINCT sequenceNumber,$ListAttrId FROM $stagingtable WITH (NOLOCK) WHERE  ProjectId='".$ProjectId."' AND InputEntityId='".$InputEntity."' AND DependencyTypeMasterId=$NormalizedId AND UserId= $user_id  Order by $OrderAttribute asc")->fetchAll('assoc');
               //$seq=0;
               $Rowdata=array();
		foreach ($link4 as $key => $value) {
                   // pr($value);
                   // $seq++;
                    $seq=$value['sequenceNumber'];
                     $qc_datarownew.='<tr>';
                   for($i=0;$i<$totattr;$i++){
                      
                        if($_POST['singleAttr']=="no"){
                        $text_onclk ='onclick=Pucmterrorclk('.$handskeysub.','.$seq.')';
                        }
                        else{
                      $text_onclk = "onclick=loadMultiFieldqcerror($AttributeMasterId,$seq,$Prvseq)";
                        }
                     $text_cls = "pu_cmts_seq";
                    // echo $setArr[0];
                     if(!is_null($value[$setArr[0]]))
		     $qc_datarownew.='<td '.$text_onclk.' class ="'.$text_cls.'" cellspacing="10">'.$value[$setArr[$i]].'</td>';
		  
                   }
                   
                     $qc_datarownew.='</tr>';
                    
                
                }
                
        
        
		 $qc_data='<div style="padding: 10px;background: #fff;font-size: 17px;font-weight: 500;">'.$Title.'</div>';
		 $qc_data.='<table style="display:inline-table"><tr style="white-space: nowrap;">'.$tblheadnew.'</tr>';		 
//		 $qc_data.='<tr >'.$tblheadtwo.'</tr>';		
		 $qc_data.=$qc_datarownew;
		 $qc_data.='</table>';
		echo $qc_data;
		//echo "hello";
        //echo json_encode($valArr);
	   
	   exit;
        
    }
     
 function GetFetchDate(){
        $date=$_POST['inputdate'];
        if($_POST['year'] != 0){
            $date= date('d-m-Y', strtotime($date. $_POST['year'] .'year'));
        }
        if($_POST['month'] != 0){
            $date= date('d-m-Y', strtotime($date. $_POST['month'] .'month'));
        }
         if($_POST['days'] != 0){
            $date= date('d-m-Y', strtotime($date. $_POST['days'] .'days'));
        }
        
        echo '<input type="text" value="'.$date.'" readonly id="newDate">';
        exit;
    }
    function ajaxcheckquery(){
        $session = $this->request->session();
        $moduleId = $session->read("moduleId");
        $proejctId=$_POST['ProjectId'];
        $ProductionEntityId=$_POST['ProductionEntityID'];
        $AttributeMasterID=$_POST['AttributeMasterId'];
        $user_id = $session->read("user_id");
        $connection = ConnectionManager::get('default');
       
        $qryCnt = $connection->execute("SELECT DISTINCT ProductionEntityId FROM ME_UserQuery WITH (NOLOCK) "
                      . "WHERE  ProjectId='".$proejctId."' "
                      . "AND ProductionEntityId='".$ProductionEntityId."' "
                      . "AND AttributeMasterID=$AttributeMasterID "
                      . "AND UserID= $user_id AND StatusId=1
                          AND ModuleId=$moduleId")->fetchAll('assoc');
       // pr($qryCnt);
        if($qryCnt){
            echo 1;
        }
        else
            echo 0;
         exit;
    }
 
}
