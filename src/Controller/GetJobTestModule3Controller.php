<?php

/**
 * Requirement : REQ-003
 * Form : Input Initation
 * Developer: Jaishalini R
 * Created On: 21 Sep 2016
 * class to Initiate Import
 * 
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * Bookmarks Controller
 *
 * @property \App\Model\Table\ImportInitiates $ImportInitiates
 */
class GetJobTestModule3Controller extends AppController {

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
        $this->loadModel('GetJob');
        // $this->loadHelper('Html');
        $this->loadComponent('RequestHandler');
    }

    public function index() {
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $ProjectId = $session->read("ProjectId");
        $moduleId = 1154;
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][0];
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);
        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];
        $isHistoryTrack = $JsonArray['ModuleConfig'][$moduleId]['IsHistoryTrack'];
        
        

        $frameType = $JsonArray['ProjectConfig']['IsBulk'];
        $limit = 1;
        $frameType = $JsonArray['ProjectConfig']['ProductionView'];

        $domainId = $JsonArray['ProjectConfig']['DomainId'];

        if ($frameType == 1) {
            if (isset($this->request->query['job']))
                $newJob = $this->request->query['job'];
            if (isset($this->request->data['NewJob']))
                $newJob = $this->request->data['NewJob'];
            $InprogressProductionjob = $connection->execute('SELECT * FROM Staging_1154_Data WITH (NOLOCK) WHERE UserId=' . $user_id . ' AND StatusId=' . $next_status_id . ' AND SequenceNumber=1 AND ProjectId=' . $ProjectId)->fetchAll('assoc');
            if (empty($InprogressProductionjob)) {
                $productionjob = $connection->execute('SELECT TOP 1 * FROM Staging_1154_Data WITH (NOLOCK) WHERE StatusId=' . $first_Status_id . ' AND SequenceNumber=1 AND ProjectId=' . $ProjectId)->fetchAll('assoc');
                if (empty($productionjob)) {
                    $this->set('NoNewJob', 'NoNewJob');
                } else {
                    foreach ($productionjob as $val) {
                        if ($val['StatusId'] == $first_Status_id && ($newJob == 'NewJob' || $newJob == 'newjob')) {
                            if ($this->GetJobTestModule3->updateAll(['StatusId' => $next_status_id, 'UserId' => $user_id, 'ActStartDate' => date('Y-m-d H:i:s')], ['ProductionEntity' => $val['ProductionEntity']])) {
                                $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $next_status_id . ",ProductionStartDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $val['ProductionEntity']);
                                $productionjob[0]['StatusId'] = $next_status_id;
                                $productionjob[0]['StatusId'] = 'Production In Progress';
                            }
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
            
            $DynamicFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['dynamic'];
            $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
            $ReadOnlyFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['readonly'];
            $this->set('StaticFields', $StaticFields);
            $this->set('DynamicFields', $DynamicFields);
            if (isset($productionjobNew)) {
                $DomainIdName = $productionjobNew[$domainId];
                $TimeTaken = $productionjobNew['TimeTaken'];
                $this->set('TimeTaken', $TimeTaken);
                $link = $connection->execute("SELECT DomainUrl,DownloadStatus FROM ME_DomainUrl WITH (NOLOCK) WHERE   ProjectId=" . $ProjectId . " AND RegionId=" . $productionjobNew['RegionId'] . " AND DomainId='" . $DomainIdName . "'")->fetchAll('assoc');
                foreach ($link as $key => $value) {
                    $L = $value['DomainUrl'];
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
                    $Dynamicproductionjob = $connection->execute('UPDATE Staging_1154_Data SET ' . $dymamicupdatetempFileds . 'where ProductionEntity=' . $ProductionEntity);
                }

                $queryStatus = $connection->execute("SELECT count(1) as cnt FROM ME_UserQuery WITH (NOLOCK) WHERE ProjectId=" . $ProjectId . " AND  ProductionEntityId='" . $productionjobNew['ProductionEntity'] . "'")->fetchAll('assoc');

                if ($queryStatus[0]['cnt'] > 0) {
                    $completion_status = 18;
                    $submitType = 'query';
                } else {
                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][1];
                    $submitType = 'completed';
                }

                if ($this->GetJobTestModule3->updateAll(['StatusId' => $completion_status, 'ActEnddate' => date('Y-m-d H:i:s')], ['ProductionEntity' => $ProductionEntity])) {
                    //$productionjob = $connection->execute('INSERT INTO  ME_Production_TimeMetric( ProjectId,ProductionEntityID,InputEntityId,Module_Id,Start_Date,End_Date,TimeTaken,UserId,' . $updatetempFileds . ' )values ( ' . $productionjobNew['BatchID'] . ',' . $productionjobNew['ProjectId'] . ',' . $productionjobNew['RegionId'] . ',' . $productionjobNew['InputEntityId'] . ',' . $productionjobNew['ProductionEntity'] . ',' . $SequenceNumber . ',' . $productionjobNew['StatusId'] . ',' . $productionjobNew['StatusId'] . ',' . $valuetoInsert . ')');
                    $productionjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $completion_status . ",ProductionEndDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $ProductionEntity);
                    $this->redirect(array('controller' => 'GetJobTestModule3', 'action' => '', '?' => array('job' => $submitType)));
                    return $this->redirect(['action' => 'index']);
                }
                return $this->redirect(['action' => 'index']);
            }

            if (empty($InprogressProductionjob) && $this->request->data['NewJob'] != 'NewJob' && !isset($this->request->data['Submit']) && $this->request->query['job'] != 'newjob') {
                $this->set('getNewJOb', 'getNewJOb');
            } else {
                $this->set('getNewJOb', '');
            }
            require_once(ROOT . DS . 'vendor' . DS . 'PHPGrid' . DS . 'jqgrid_dist.php');
            $g = new jqgrid();
            //$grid["autowidth"] = true;
            // $grid["subGrid"] = true;
            $grid["autowidth"] = false;
            $grid["shrinkToFit"] = false;
            //$grid["width"] = "650";
            $grid["pgbuttons"] = false;
            $grid["pgtext"] = null;
            $grid["viewrecords"] = false;
            $grid["rownumbers"] = true;
            $grid["rowList"] = array();
            $grid["height"] = "400";
            $grid["toppager"] = false;
            $grid["autoresize"] = true;
            //$grid["auto_width"] = false;
            //$grid["shrink_to_fit"] = true;
            $grid["width"] = 1200;

            //$grid["scroll"] = true; 
            $g->set_options($grid);
            $e["on_insert"] = array("insert_data", new GetJobTestModule3Controller(), false);
            $e["on_update"] = array("update_data", new GetJobTestModule3Controller(), false);
            $g->set_events($e);

            $col = array();
            $col["title"] = "Id"; // caption of column
            $col["name"] = "Id"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias) 
            $col["width"] = "50";
            //$col["hidden"] = true;
            $cols[] = $col;
            $temp = '';
            // pr($ReadOnlyFields);
            foreach ($ReadOnlyFields as $key => $val) {
                if ($val['AttributeName'] != '') {
                    $temp.='[' . $val['AttributeMasterId'] . '] as "' . $val['AttributeName'] . '",';
                    $col = array();
                    $col["title"] = $val['DisplayAttributeName']; // caption of column
                    $col["name"] = $val['AttributeName']; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias) 
                    $col["width"] = "100";
                    $col["editable"] = false;
                    $col["search"] = false;
                    $cols[] = $col;
                }
            }
            foreach ($ProductionFields as $key => $val) {
                if ($val['AttributeName'] != '') {
                    $temp.='[' . $val['AttributeMasterId'] . '] as "' . $val['AttributeName'] . '",';

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

                    if ($IsAutoSuggesstion == 1) {
                        $AutoSuggesstion[] = $val['AttributeMasterId'];
                    }





                    $col = array();
                    $col["title"] = $val['DisplayAttributeName']; // caption of column
                    $col["name"] = $val['AttributeName']; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias) 
                    $col["width"] = "100";
                    $col["editable"] = true;
                    if ($IsMandatory == 1) {
                        $col["editrules"] = array("required" => true);
                    }
                    if ($FunctionName != '') {
                        $col["editoptions"] = array("onblur" => $FunctionName . "(this.id,this.value)");
                    }
                    if ($val['ControlName'] == 'DropDownList' && $IsAutoSuggesstion != 1) {
                        $col["edittype"] = "select";
                        $opt = array();
                        $opt = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$val['ProjectAttributeMasterId']]['Options'];

                        $Mapping = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$val['ProjectAttributeMasterId']]['Mapping'];
                        //pr($Mapping);
                        $jsfun = '';
                        if (count($Mapping) > 0) {
                            $id = $val['AttributeName'];
                            $to_be_filled = array_keys($Mapping);
                            $against = $to_be_filled[0];
                            $map_Id = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$against]['AttributeName'];
                            $jsfun = "LoadValue(" . $val['ProjectAttributeMasterId'] . ",this.value," . $against . ",this.id,'" . $map_Id . "');";
                        }

                        $col["formatter"] = "select";
                        $opt['0'] = '--Select--';
                        if (empty($opt))
                            $opt['0'] = '--Select--';

                        $col["editoptions"] = array("value" => $opt, "onchange" => $jsfun);
                    }
                    if ($val['ControlName'] == 'DropDownList' && $IsAutoSuggesstion == 1) {
                        //  $col["edittype"] = "select";  
                        $opt = array();
                        $opt = $JsonArray['AttributeOrder'][$productionjobNew['RegionId']][$val['ProjectAttributeMasterId']]['Options'];
                        array_push($opt, '--Select--');
                        $col["formatter"] = "autocomplete";
                        sort($opt);
                        if (empty($opt))
                            $opt['0'] = '--Select--';

                        $col["formatoptions"] = array("value" => $opt);
                        /*  $col["formatoptions"] = array( "sql"=>"SELECT *, DropDownValue as v FROM ME_DropdownMaster where ProjectAttributeMasterId=".$val['ProjectAttributeMasterId']." ORDER BY DropDownValue",
                          "search_on"=>"concat(DropDownValue,'-',client_id)",
                          "force_select"=>true); */
                        //$col['editoptions']["style"] = "width:200px";
                        //$col['editoptions']["size"] = "4";
                        //$col['editoptions']["multiple"] = true;
                    }
                    $col["search"] = false;
                    $cols[] = $col;
                }
            }
            $temp = rtrim($temp, ',');
            $g->select_command = "SELECT Id," . $temp . " FROM Staging_1154_Data WITH (NOLOCK) where StatusId=" . $next_status_id;

            $g->set_actions(array(
                "inlineadd" => true,
                "rowactions" => true,
                "delete" => true,
                "autofilter" => false,
                "search" => false
                    )
            );


            $col = array();
            $col["title"] = "Action";
            $col["name"] = "act";
            $col["width"] = "100";
            $cols[] = $col;
            $g->set_columns($cols);

            $g->navgrid["param"]["edit"] = false;
            $g->navgrid["param"]["add"] = false;
            //$g->navgrid["param"]["del"] = false;
            $g->navgrid["param"]["search"] = false;
            $g->navgrid["param"]["refresh"] = true;
            $g->table = "Staging_1154_Data";
            $out = $g->render("list1");
            $this->set('out', $out);
            $this->render('/GetJobTestModule3/index_vertical');
            //       echo $out;

            /* GRID END******************************************************************************************************************************************************************* */
        } else {

            if (isset($this->request->data['clicktoviewPre'])) {
                $page = $this->request->data['page'] - 1;
                $this->redirect(array('controller' => 'GetJobTestModule3', 'action' => 'index/' . $page));
            }
            if (isset($this->request->data['clicktoviewNxt'])) {
                $page = $this->request->data['page'] + 1;
                $this->redirect(array('controller' => 'GetJobTestModule3', 'action' => 'index/' . $page));
            }

            if (isset($this->request->data['DeleteVessel'])) {
                $sequence = 1;
                if (isset($this->request->data['page']))
                    $sequence = $this->request->data['page'];
                $ProjectId = $this->request->data['ProjectId'];
                $ProductionEntity = $this->request->data['ProductionEntity'];
                $ProductionId = $this->request->data['ProductionId'];
                if ($sequence == 1) {
                    $SequenceNumber = $connection->execute('SELECT ' . $tempFileds . 'TimeTaken,Id,BatchID,BatchCreated,ProjectId,RegionId,InputEntityId,ProductionEntity,SequenceNumber,StatusId,UserId FROM Staging_1154_Data WITH (NOLOCK) WHERE ProductionEntity=' . $ProductionEntity)->fetchAll('assoc');
                    $sequencemax = count($SequenceNumber);
                    if ($sequencemax == 1)
                        return 'Minimum one record required';
                }
                $delete = $connection->execute("DELETE FROM Staging_1154_Data WHERE   ProductionEntity='" . $ProductionEntity . "' and SequenceNumber='" . $sequence . "'");
                $SequenceNumber = $connection->execute("SELECT Id,SequenceNumber FROM Staging_1154_Data  WITH (NOLOCK) WHERE  ProductionEntity='" . $ProductionEntity . "' AND SequenceNumber>$sequence order by SequenceNumber desc")->fetchAll('assoc');

                //  pr($SequenceNumber); exit;
                foreach ($SequenceNumber as $key => $val) {
                    //pr($val);
                    $newsequence = $val['SequenceNumber'] - 1;
                    $id = $val['Id'];
                    // echo "update  Staging_1154_Data set SequenceNumber = $newsequence WHERE Id=".$val['Id']."  and SequenceNumber='".$val['SequenceNumber']."'"; exit;
                    $update = $connection->execute("update  Staging_1154_Data set SequenceNumber = $newsequence WHERE Id=" . $val['Id'] . "  and SequenceNumber='" . $val['SequenceNumber'] . "'");
                    //$update = $this->query("update ME_ProductionData set SequenceNumber = $newsequence WHERE Id=".$ProductionId."  and SequenceNumber='".$val['SequenceNumber']."'");  
                }

                if ($delete == 'no')
                    $this->Flash->success(__('Minimum One record required'));
                else
                    $this->Flash->success(__('Deleted Successfully'));

                $this->redirect(array('controller' => 'GetJobTestModule3', 'action' => 'index/'));
            }


            
            // $tempFileds=rtrim($tempFileds,',');
            //echo $test="'BatchID','Id','StatusId'";
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
            $InprogressProductionjob = $connection->execute('SELECT TOP 1 * FROM Staging_1154_Data WITH (NOLOCK) WHERE StatusId=' . $next_status_id . ' AND SequenceNumber=' . $page . ' AND ProjectId=' . $ProjectId . ' AND UserId= ' . $user_id)->fetchAll('assoc');
            if (empty($InprogressProductionjob)) {
                $productionjob = $connection->execute('SELECT TOP 1 * FROM Staging_1154_Data WITH (NOLOCK) WHERE StatusId=' . $first_Status_id . ' AND SequenceNumber=' . $page . ' AND ProjectId=' . $ProjectId)->fetchAll('assoc');
                if (empty($productionjob)) {
                    $this->set('NoNewJob', 'NoNewJob');
                } else {
                    //echo $newJob;
                    //pr($productionjob);
                    // echo $productionjob[0]['StatusId'].' =='. $first_Status_id;
                    if ($productionjob[0]['StatusId'] == $first_Status_id && ($newJob == 'NewJob' || $newJob == 'newjob')) {
                        if ($this->GetJobTestModule3->updateAll(['StatusId' => $next_status_id, 'UserId' => $user_id, 'ActStartDate' => date('Y-m-d H:i:s')], ['ProductionEntity' => $productionjob[0]['ProductionEntity']])) {
                            $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $next_status_id . ",ProductionStartDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $productionjob[0]['ProductionEntity']);
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
           // pr($productionjobNew);
            $RegionId = $productionjobNew['RegionId'];
            $StaticFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['static'];
          //  pr($StaticFields);
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
            //pr($productionjobNew);
            if (isset($productionjobNew)) {
                $SequenceNumber = $connection->execute('SELECT ' . $tempFileds . 'TimeTaken,Id,BatchID,BatchCreated,ProjectId,RegionId,InputEntityId,ProductionEntity,SequenceNumber,StatusId,UserId FROM Staging_1154_Data WITH (NOLOCK)  WHERE ProductionEntity=' . $productionjobNew['ProductionEntity'] . ' ORDER BY SequenceNumber')->fetchAll('assoc');
                $this->set('SequenceNumber', count($SequenceNumber));

                $DomainIdName = $productionjobNew[$domainId];
                $TimeTaken = $productionjobNew['TimeTaken'];

                $this->set('TimeTaken', $TimeTaken);
                $link = $connection->execute("SELECT DomainUrl,DownloadStatus FROM ME_DomainUrl WITH (NOLOCK) WHERE   ProjectId=" . $ProjectId . " AND RegionId=" . $productionjobNew['RegionId'] . " AND DomainId='" . $DomainIdName . "'")->fetchAll('assoc');
                //   pr($link); 

                foreach ($link as $key => $value) {
                    //pr($value);
                    $L = $value['DomainUrl'];
                    
                    $pos = strpos($L, 'http');
                    if(empty($pos)){
                        $L="http://".$L;
                    }
                    
                    //Append file path
                    if ($value['DownloadStatus'] == 1)
                        $FilePath = FILE_PATH . $value[0]['InputId'] . '.html';
                    else
                        $FilePath = $L;
                    $LinkArray[$FilePath] = $L;
                    
                    
                }
               // pr($LinkArray);
                
                reset($LinkArray);
                $FirstLink = key($LinkArray);
                $this->set('Html', $LinkArray);
                $this->set('FirstLink', $FirstLink);

                $QueryDetails = array();

                $QueryDetails = $connection->execute("SELECT TLComments,Query,StatusID FROM ME_UserQuery WITH (NOLOCK) WHERE   ProductionEntityId=" . $productionjobNew['ProductionEntity'])->fetchAll('assoc');
                //pr($QueryDetails);
                $this->set('QueryDetails', $QueryDetails[0]);
            }
            $productionjobId = $this->request->data['ProductionId'];
            $ProductionEntity = $this->request->data['ProductionEntity'];
            $productionjobStatusId = $this->request->data['StatusId'];
            // print_r($productionjobStatusId); 
            if (isset($this->request->data['Submit'])) {
                // echo "SELECT count(1) FROM ME_UserQuery WHERE ProjectId=".$ProjectId." AND RegionId=".$productionjobNew['RegionId']." AND InputEntityId='".$productionjobNew['ProductionEntity']."'";
                $queryStatus = $connection->execute("SELECT count(1) as cnt FROM ME_UserQuery WITH (NOLOCK) WHERE ProjectId=" . $ProjectId . " AND  ProductionEntityId='" . $productionjobNew['ProductionEntity'] . "'")->fetchAll('assoc');
                ;
                // pr($queryStatus);
                //exit;
                if ($queryStatus[0]['cnt'] > 0) {
                    $completion_status = 18;
                    $submitType = 'query';
                } else {
                    $completion_status = $JsonArray['ModuleStatus_Navigation'][$next_status_id][1];
                    $submitType = 'completed';
                }

                if ($this->GetJobTestModule3->updateAll(['StatusId' => $completion_status, 'ActEnddate' => date('Y-m-d H:i:s')], ['ProductionEntity' => $ProductionEntity])) {
                    //$productionjob = $connection->execute('INSERT INTO  ME_Production_TimeMetric( ProjectId,ProductionEntityID,InputEntityId,Module_Id,Start_Date,End_Date,TimeTaken,UserId,' . $updatetempFileds . ' )values ( ' . $productionjobNew['BatchID'] . ',' . $productionjobNew['ProjectId'] . ',' . $productionjobNew['RegionId'] . ',' . $productionjobNew['InputEntityId'] . ',' . $productionjobNew['ProductionEntity'] . ',' . $SequenceNumber . ',' . $productionjobNew['StatusId'] . ',' . $productionjobNew['StatusId'] . ',' . $valuetoInsert . ')');
                    $productionjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $completion_status . ",ProductionEndDate='" . date('Y-m-d H:i:s') . "' WHERE ID=" . $ProductionEntity);
                    $this->redirect(array('controller' => 'GetJobTestModule3', 'action' => '', '?' => array('job' => $submitType)));
//                            if ($submitType == 'completed')
//                                $this->Flash->success(__('Job Completed Successfully'));
//                            else if ($submitType == 'completed')
//                                $this->Flash->success(__('Query posted Successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                //$this->Flash->success(__('Entererd Data saved Successfully'));
                return $this->redirect(['action' => 'index']);
            }

            if (empty($InprogressProductionjob) && $this->request->data['NewJob'] != 'NewJob' && !isset($this->request->data['Submit']) && $this->request->query['job'] != 'newjob') {
                $this->set('getNewJOb', 'getNewJOb');
            } else {
                $this->set('getNewJOb', '');
            }

            //pr($DynamicFields);
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
                // if($val['AttributeName']=='Input_Categories_Primary')
                // echo $IsAlphabet .'&&'. $IsNumeric .'&&'. $IsSpecialCharacter .'&&'. $IsEmail;


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

            $manKey=0;
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
                    $ProductionFields[$key]['Reload'] = 'LoadValue(' . $val['ProjectAttributeMasterId'] . ',this.value,' . $against . ');';
                }
            }
            //pr($ProductionFields);
            $this->set('ProductionFields', $ProductionFields);
            $this->set('DynamicFields', $DynamicFields);
            $this->set('Mandatory', $Mandatory);
            $this->set('AutoSuggesstion', $AutoSuggesstion);

            $this->set('ReadOnlyFields', $ReadOnlyFields);
            $dynamicData = $SequenceNumber[0];
            //pr($dynamicData);
            $this->set('dynamicData', $dynamicData);
        }
    }

    public function update_data($data) {
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $ProjectId = $session->read("ProjectId");
        $moduleId = 1154;
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $ProductionFields = $JsonArray['ModuleAttributes'][6][$moduleId]['production'];
        $temp = '';
        // pr($data);
        foreach ($ProductionFields as $key => $val) {
            if ($data['params'][$val['AttributeName']] != '')
                $temp.="[" . $val['AttributeMasterId'] . "] = '" . $data['params'][$val['AttributeName']] . "',";
        }
        $temp = trim($temp, ',');
        require_once(ROOT . DS . 'vendor' . DS . 'PHPGrid' . DS . 'jqgrid_dist.php');
        $g = new jqgrid();
        $selected_ids = $data["rid"];
        $str = $data["params"]["data"];
        $g->execute_query("UPDATE Staging_1154_Data SET " . $temp . " ,RecordStatus=1 WHERE Id = " . $data['Id'] . "");
    }

    public function insert_data($data) {
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $ProjectId = $session->read("ProjectId");
        $moduleId = 1154;

        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $ProductionFields = $JsonArray['ModuleAttributes'][6][$moduleId]['production'];

        $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][0];
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);

        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];


        $tempFields = '';
        $tempData = '';
        $InprogressProductionjob = $connection->execute('SELECT TOP 1 BatchID,BatchCreated,ProjectId,RegionId,InputEntityId,ProductionEntity,SequenceNumber,StatusId,UserId,ActStartDate FROM Staging_1154_Data WITH (NOLOCK) WHERE UserId=' . $user_id . ' AND StatusId=' . $next_status_id . ' ORDER BY SequenceNumber DESC')->fetchAll('assoc');
        foreach ($ProductionFields as $key => $val) {
            if ($data['params'][$val['AttributeName']] != '') {
                $tempFields.="[" . $val['AttributeMasterId'] . "],";
                $tempData.= "'" . $data['params'][$val['AttributeName']] . "',";
            }
        }
        $temp = trim($temp, ',');
        require_once(ROOT . DS . 'vendor' . DS . 'PHPGrid' . DS . 'jqgrid_dist.php');
        $g = new jqgrid();
        $selected_ids = $data["rid"];
        $str = $data["params"]["data"];
        $g->execute_query("INSERT into Staging_1154_Data (" . $tempFields . "BatchID,BatchCreated,ProjectId,RegionId,InputEntityId,ProductionEntity,SequenceNumber,StatusId,UserId,ActStartDate) values($tempData'" . $InprogressProductionjob[0]['BatchID'] . "','" . $InprogressProductionjob[0]['BatchCreated'] . "','" . $InprogressProductionjob[0]['ProjectId'] . "','" . $InprogressProductionjob[0]['RegionId'] . "','" . $InprogressProductionjob[0]['InputEntityId'] . "','" . $InprogressProductionjob[0]['ProductionEntity'] . "','" . ($InprogressProductionjob[0]['SequenceNumber'] + 1) . "','" . $InprogressProductionjob[0]['StatusId'] . "','" . $InprogressProductionjob[0]['UserId'] . "','" . $InprogressProductionjob[0]['ActStartDate'] . "')");
        $id = $res = array("id" => $id, "success" => true);
        echo json_encode($res);
        exit;
    }

    function ajaxqueryposing() {
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $ProjectId = $session->read("ProjectId");
        $moduleId = $session->read("moduleId");
        echo $_POST['query'];
        $file = $this->GetJobTestModule3->find('querypost', ['ProductionEntity' => $_POST['InputEntyId'], 'query' => $_POST['query'], 'ProjectId' => $ProjectId, 'moduleId' => $moduleId, 'user' => $user_id]);
        exit;
    }

    function ajaxloadresult() {
        $session = $this->request->session();
        $ProjectId = $session->read("ProjectId");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $Region=$_POST['Region'];
        $optOption = $JsonArray['AttributeOrder'][$Region][$_POST['id']]['Mapping'][$_POST['toid']][$_POST['value']];
        // pr($optOption);
        $arrayVal = array();
        $i = 0;
        foreach ($optOption as $key => $val) {
            $dumy = key($val);
            $arrayVal[$i]['Value'] = $JsonArray['AttributeOrder'][$Region][$_POST['toid']]['Options'][$dumy];
            $arrayVal[$i]['id'] = $dumy;
            $i++;
        }
        //pr($arrayVal);
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
                $updatetempFileds.="[" . $val . "]='" . $productionData[$key] . "',";
                $IsAutoSuggesstion = $JsonArray['ValidationRules'][$ProjectAttr[$key]]['IsAutoSuggesstion'];
                $IsAllowNewValues = $JsonArray['ValidationRules'][$ProjectAttr[$key]]['IsAllowNewValues'];
                if ($IsAutoSuggesstion == '1' && $IsAllowNewValues == '1') {
                    $Value = $productionData[$key];
                    $attrmasterid = $val;
                    $Projattrmasterid = $ProjectAttr[$key];
                    $createddate = date("Y-m-d H:i:s");
                    //echo '<br>'.$val.'<br>'.$productionData[$key].'<br>'.$ProjectAttr[$key].'value saved<br>';
                    $link = $connection->execute("SELECT count(1) as count  FROM ME_AutoSuggestionMasterlist WITH (NOLOCK) WHERE ProjectId=" . $ProjectId . " AND RegionId=" . $RegionId . " AND AttributeMasterId=" . $attrmasterid . " AND ProjectAttributeMasterId=" . $Projattrmasterid . " AND RecordStatus=1 AND Value = '" . $Value . "'")->fetchAll('assoc');
                    $valcount = $link[0]['count'];
                    if ($valcount == 0) {
                        $updateautosuggestion = $connection->execute("INSERT into ME_AutoSuggestionMasterlist (ProjectId,RegionId,AttributeMasterId,ProjectAttributeMasterId,Value,OrderId,RecordStatus,CreatedDate,CreatedBy)values ('" . $ProjectId . "','" . $RegionId . "','" . $attrmasterid . "','" . $Projattrmasterid . "','" . $Value . "','1','1','" . $createddate . "','" . $user_id . "')");
                    }
                }
            }
            //  pr($DynamicFields);
            foreach ($dynamicData_ely as $key => $val) {
                $dymamicupdatetempFileds.="[" . $val . "]='" . $dynamicData[$key] . "',";
            }

            $updatetempFileds.="TimeTaken='" . $_POST['TimeTaken'] . "'";
            $dymamicupdatetempFileds.="TimeTaken='" . $_POST['TimeTaken'] . "'";


            $productionjob = $connection->execute('UPDATE Staging_1154_Data SET ' . $updatetempFileds . 'where ProductionEntity=' . $_POST['ProductionEntity'] . ' AND SequenceNumber=' . $_POST['SequenceNumber']);
            $Dynamicproductionjob = $connection->execute('UPDATE Staging_1154_Data SET ' . $dymamicupdatetempFileds . 'where ProductionEntity=' . $_POST['ProductionEntity']);
            echo 'saved';
            exit;
        }
    }

    public function ajaxgetnextpagedata() {
        if (empty($this->request->session()->read('user_id'))) {
            echo 'expired';
            exit;
        } else {
            $connection = ConnectionManager::get('default');
            // echo 'SELECT BatchID,ProjectId,RegionId,InputEntityId,ProductionEntity,StatusId,UserId FROM Staging_1154_Data WHERE ProductionEntity='.$_POST['ProductionEntity'];
            $productionjobNew = $connection->execute('SELECT * FROM Staging_1154_Data WITH (NOLOCK) WHERE ProductionEntity=' . $_POST['ProductionEntity'] . ' AND SequenceNumber=' . $_POST['page'])->fetchAll('assoc');
            //pr($productionjobNew);
            echo json_encode($productionjobNew[0]);
            exit;
        }
    }

    public function ajaxaddnew() {

        exit;
    }

    public function ajaxnewsave() {
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
            foreach ($ProductionFields as $key => $val) {
                $updatetempFileds.="[" . $val . "],";
                $valuetoInsert.="'" . $productionData[$key] . "',";
                $IsAutoSuggesstion = $JsonArray['ValidationRules'][$ProjectAttr[$key]]['IsAutoSuggesstion'];
                $IsAllowNewValues = $JsonArray['ValidationRules'][$ProjectAttr[$key]]['IsAllowNewValues'];
                if ($IsAutoSuggesstion == '1' && $IsAllowNewValues == '1') {
                    $Value = $productionData[$key];
                    $attrmasterid = $val;
                    $Projattrmasterid = $ProjectAttr[$key];
                    $createddate = date("Y-m-d H:i:s");
                    //echo '<br>'.$val.'<br>'.$productionData[$key].'<br>'.$ProjectAttr[$key].'value saved<br>';
                    $link = $connection->execute("SELECT count(1) as count  FROM ME_AutoSuggestionMasterlist WITH (NOLOCK)WHERE ProjectId=" . $ProjectId . " AND RegionId=" . $RegionId . " AND AttributeMasterId=" . $attrmasterid . " AND ProjectAttributeMasterId=" . $Projattrmasterid . " AND RecordStatus=1 AND Value = '" . $Value . "'")->fetchAll('assoc');
                    $valcount = $link[0]['count'];
                    if ($valcount == 0) {
                        $updateautosuggestion = $connection->execute("INSERT into ME_AutoSuggestionMasterlist (ProjectId,RegionId,AttributeMasterId,ProjectAttributeMasterId,Value,OrderId,RecordStatus,CreatedDate,CreatedBy)values ('" . $ProjectId . "','" . $RegionId . "','" . $attrmasterid . "','" . $Projattrmasterid . "','" . $Value . "','1','1','" . $createddate . "','" . $user_id . "')");
                    }
                }
            }
            foreach ($dynamicData_ely as $key => $val) {
                $updatetempFileds.="[" . $val . "],";
                $valuetoInsert.="'" . $dynamicData[$key] . "',";
            }
            $updatetempFileds.='TimeTaken';
            $valuetoInsert.= "'" . $_POST['TimeTaken'] . "'";



            $productionjobNew = $connection->execute('SELECT BatchCreated,BatchID,ProjectId,RegionId,InputEntityId,ProductionEntity,StatusId,UserId,ActStartDate FROM Staging_1154_Data WITH (NOLOCK) WHERE ProductionEntity=' . $ProductionEntity)->fetchAll('assoc');
            //pr($productionjobNew[0]); exit;
            $refData = $productionjobNew[0];

            $seq = count($productionjobNew) + 1;

            // echo 'INSERT INTO  Staging_1154_Data( BatchID,ProjectId,RegionId,InputEntityId,ProductionEntity,SequenceNumber,StatusId,UserId,' . $updatetempFileds . ' )values ( ' . $refData['BatchID'] . ',' . $refData['ProjectId'] . ',' . $refData['RegionId'] . ',' . $refData['InputEntityId'] . ',' . $refData['ProductionEntity'] . ',' . $_POST['SequenceNumber'] . ',' . $refData['StatusId'] . ',' . $user_id . ',' . $valuetoInsert . ')';
            //exit;
            $productionjob = $connection->execute("INSERT INTO  Staging_1154_Data( BatchCreated,BatchID,ProjectId,RegionId,InputEntityId,ProductionEntity,SequenceNumber,StatusId,UserId,ActStartDate," . $updatetempFileds . " )values ( '" . $refData['BatchCreated'] . "'," . $refData['BatchID'] . "," . $refData['ProjectId'] . "," . $refData['RegionId'] . "," . $refData['InputEntityId'] . "," . $refData['ProductionEntity'] . "," . $seq . "," . $refData['StatusId'] . "," . $user_id . ",'" . $refData['ActStartDate'] . "'," . $valuetoInsert . ")");

            $dymamicupdatetempFileds = '';
            foreach ($dynamicData_ely as $key => $val) {
                $dymamicupdatetempFileds.="[" . $val . "]='" . $dynamicData[$key] . "',";
            }

            $dymamicupdatetempFileds.="TimeTaken='" . $_POST['TimeTaken'] . "'";

            $Dynamicproductionjob = $connection->execute('UPDATE Staging_1154_Data SET ' . $dymamicupdatetempFileds . 'where ProductionEntity=' . $refData['ProductionEntity']);
            echo 'saved';
            exit;
        }
    }

    function ajaxdelete() {
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
                $SequenceNumber = $connection->execute('SELECT Id FROM Staging_1154_Data WITH (NOLOCK) WHERE ProductionEntity=' . $ProductionEntity)->fetchAll('assoc');
                $sequencemax = count($SequenceNumber);
                if ($sequencemax == 1)
                    $delete = 'No';
            }
            if ($delete != 'No') {
                // echo "DELETE FROM Staging_1154_Data WHERE   ProductionEntity='" . $ProductionEntity . "' and SequenceNumber='" . $sequence . "'";
                $delete = $connection->execute("DELETE FROM Staging_1154_Data WITH (NOLOCK) WHERE   ProductionEntity='" . $ProductionEntity . "' and SequenceNumber='" . $sequence . "'");
                $SequenceNumber = $connection->execute("SELECT Id,SequenceNumber FROM Staging_1154_Data with (NOLOCK)  WHERE  ProductionEntity='" . $ProductionEntity . "' AND SequenceNumber>$sequence order by SequenceNumber desc")->fetchAll('assoc');
                foreach ($SequenceNumber as $key => $val) {
                    $newsequence = $val['SequenceNumber'] - 1;
                    $id = $val['Id'];
                    $update = $connection->execute("update  Staging_1154_Data set SequenceNumber = $newsequence WHERE Id=" . $val['Id'] . "  and SequenceNumber='" . $val['SequenceNumber'] . "'");
                }
            }
            if ($delete == 'No')
                echo 'one';
            else
                echo 'deleted';
            exit;
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

}
