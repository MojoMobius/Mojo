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
class GetjobcoreviewController extends AppController {

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
        $moduleId = 1149;
        $InputEntityId = $this->request->params['pass'][0];
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
//pr($JsonArray);
//exit;
        $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][0];
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);

        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];
        $isHistoryTrack = $JsonArray['ModuleConfig'][$moduleId]['IsHistoryTrack'];

        $this->set('StaticFields', $StaticFields);
        $this->set('DynamicFields', $DynamicFields);

        $frameType = $JsonArray['ProjectConfig']['IsBulk'];
        $limit = 1;
        $frameType = $JsonArray['ProjectConfig']['ProductionView'];

        $domainId = $JsonArray['ProjectConfig']['DomainId'];

        if ($frameType == 1) {
            if (isset($this->request->query['job']))
                $newJob = $this->request->query['job'];
            if (isset($this->request->data['NewJob']))
                $newJob = $this->request->data['NewJob'];
            $InprogressProductionjob = $connection->execute("SELECT RegionId,[1383],Id,InputEntityId,StatusId,TotalTimeTaken FROM ML_ProductionEntityMaster WHERE InputEntityId = $InputEntityId")->fetchAll('assoc');
            
                $this->set('getNewJOb', '');
                $this->set('productionjob', $InprogressProductionjob[0]);
                $productionjobNew = $InprogressProductionjob[0];
                $RegionId = $productionjobNew['RegionId'];
            $StaticFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['static'];
            $DynamicFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['dynamic'];
            $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
                //pr($productionjobNew);
            //  pr($productionjobNew);
            if (isset($productionjobNew)) {

                $DomainIdName = $productionjobNew['1383'];
                $TimeTaken = $productionjobNew['TotalTimeTaken'];

                $this->set('TimeTaken', $TimeTaken);
                // $link = $this->DomainUrl->GetDomainUrl($DomainIdName,$this->Session->read("ProjectId"),$Regionid);
                $link = $connection->execute("SELECT DomainUrl,DownloadStatus FROM ME_DomainUrl WHERE   ProjectId=" . $ProjectId . " AND RegionId=" . $productionjobNew['RegionId'] . " AND DomainId='" . $DomainIdName . "'")->fetchAll('assoc');
//                 pr($link); 

                foreach ($link as $key => $value) {
                    //pr($value);
                    $L = $value['DomainUrl'];
                    //Append file path
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
            $this->set('getNewJOb', '');

            //pr($ProductionFields);

            require_once(ROOT . DS . 'vendor' . DS . 'PHPGrid' . DS . 'jqgrid_dist.php');
            $g = new jqgrid();
            //$grid["autowidth"] = true;
            // $grid["subGrid"] = true;
            $grid["autowidth"] = false;
            $grid["shrinkToFit"] = false;
            $grid["width"] = "610";
            $grid["pgbuttons"] = false;
            $grid["pgtext"] = null;
            $grid["viewrecords"] = false;
            $grid["rownumbers"] = true;
            $grid["rowList"] = array();
            $grid["height"] = "400";
            $grid["toppager"] = false;
            //$grid["scroll"] = true; 
            $g->set_options($grid);
//            $e["on_insert"] = array("insert_data", new GetjobcoreController(), false);
//            $e["on_update"] = array("update_data", new GetjobcoreController(), false);
//            $g->set_events($e);

            $col = array();
            $col["title"] = "Id"; // caption of column
            $col["name"] = "Id"; // grid column name, must be exactly same as returned column-name from sql (tablefield or field-alias) 
            $col["width"] = "50";
            //$col["hidden"] = true;
            $cols[] = $col;
            $temp = '';
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
//            $g->select_command = "SELECT Id," . $temp . " FROM Staging_1149_Data where StatusId=" . $next_status_id;
             $g->select_command = "SELECT Id," . $temp . " FROM ML_ProductionEntityMaster where InputEntityId=".$InputEntityId;

            $g->set_actions(array(
                "inlineadd" => false,
                "rowactions" => false,
                "delete" => false,
                "autofilter" => false,
                "search" => false
                    )
            );


//            $col = array();
//            $col["title"] = "Action";
//            $col["name"] = "act";
//            $col["width"] = "100";
//            $cols[] = $col;
//            $g->set_columns($cols);

            $g->navgrid["param"]["edit"] = false;
            $g->navgrid["param"]["add"] = false;
            $g->navgrid["param"]["del"] = false;
            $g->navgrid["param"]["search"] = false;
            $g->navgrid["param"]["refresh"] = true;
            $g->table = "ML_ProductionEntityMaster";
            $out = $g->render("list1");
            $this->set('out', $out);
            $this->render('/Getjobcoreview/index_vertical');
            //       echo $out;

            /* GRID END******************************************************************************************************************************************************************* */
        } else {



            if (isset($this->request->data['clicktoviewPre'])) {
                $page = $this->request->data['page'] - 1;
                $this->redirect(array('controller' => 'Getjobcoreview', 'action' => 'index/'.$InputEntityId.'/'.$page));
            }
            if (isset($this->request->data['clicktoviewNxt'])) {
                $page = $this->request->data['page'] + 1;
                $this->redirect(array('controller' => 'Getjobcoreview', 'action' => 'index/'.$InputEntityId.'/'.$page));
            }

            


            $tempFileds = '';
            foreach ($ProductionFields as $val) {
                $tempFileds.="[" . $val['AttributeMasterId'] . "],";
            }

            // $tempFileds=rtrim($tempFileds,',');
            //echo $test="'BatchID','Id','StatusId'";
            if (isset($this->request->query['job']))
                $newJob = $this->request->query['job'];
            if (isset($this->request->data['NewJob']))
                $newJob = $this->request->data['NewJob'];


            $page = 1;
            if (isset($this->request->params['pass'][1]))
                $page = $this->request->params['pass'][1];



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
            // echo $tempFileds;
            $InprogressProductionjob = $connection->execute("SELECT $tempFileds [1383],TotalTimeTaken,Id,ProjectId,RegionId,InputEntityId,SequenceNumber,StatusId FROM ML_ProductionEntityMaster WHERE InputEntityId=" . $InputEntityId)->fetchAll('assoc');
            
                $this->set('getNewJOb', '');
                $this->set('productionjob', $InprogressProductionjob[0]);
                $productionjobNew = $InprogressProductionjob[0];
                $RegionId = $productionjobNew['RegionId'];

            $StaticFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['static'];
            $DynamicFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['dynamic'];
            $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
            
            
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
                $ProdInputEntity = $productionjobNew['InputEntityId'];
                //$SequenceNumber = $connection->execute('SELECT $tempFileds TotalTimeTaken,Id,ProjectId,RegionId,InputEntityId,SequenceNumber,StatusId FROM ML_ProductionEntityMaster WHERE InputEntityId=' . $productionjobNew['InputEntityId'] . ' ORDER BY SequenceNumber')->fetchAll('assoc');
                $SequenceNumber = $connection->execute("SELECT $tempFileds TotalTimeTaken,Id,1383,ProjectId,RegionId,InputEntityId,SequenceNumber,StatusId FROM ML_ProductionEntityMaster WHERE InputEntityId= $ProdInputEntity ORDER BY SequenceNumber")->fetchAll('assoc') ;
                //pr($SequenceNumber);
                $this->set('SequenceNumber', count($SequenceNumber));

                 //pr($productionjobNew);
                $DomainIdName = $productionjobNew[$domainId];
                $TimeTaken = $productionjobNew['TotalTimeTaken'];

                $this->set('TimeTaken', $TimeTaken);
                // $link = $this->DomainUrl->GetDomainUrl($DomainIdName,$this->Session->read("ProjectId"),$Regionid);
                
                $link = $connection->execute("SELECT DomainUrl,DownloadStatus FROM ME_DomainUrl WHERE   ProjectId=" . $ProjectId . " AND RegionId=" . $productionjobNew['RegionId'] . " AND DomainId='" . $DomainIdName . "'")->fetchAll('assoc');
                 //pr($link);

                foreach ($link as $key => $value) {
                    //pr($value);
                    $L = $value['DomainUrl'];
                    //Append file path
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

//                $QueryDetails = $connection->execute("SELECT TLComments,Query,StatusID FROM ME_UserQuery WHERE   ProductionEntityId=" . $productionjobNew['ProductionEntity'])->fetchAll('assoc');
//                //pr($QueryDetails);
//                $this->set('QueryDetails', $QueryDetails[0]);
            }
            $productionjobId = $this->request->data['ProductionId'];
            $ProductionEntity = $this->request->data['ProductionEntity'];
            $productionjobStatusId = $this->request->data['StatusId'];
            // print_r($productionjobStatusId); 
            

                $this->set('getNewJOb', '');

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
                    $ProductionFields[$key]['ControlName'] = 'Auto';
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


            $dynamicData = $SequenceNumber[0];
            //pr($dynamicData);
            $this->set('dynamicData', $dynamicData);
        }
    }

   


    

    function ajaxloadresult() {
        $session = $this->request->session();
        $ProjectId = $session->read("ProjectId");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);

        $optOption = $JsonArray['AttributeOrder'][6][$_POST['id']]['Mapping'][$_POST['toid']][$_POST['value']];
        // pr($optOption);
        $arrayVal = array();
        $i = 0;
        foreach ($optOption as $key => $val) {
            $dumy = key($val);
            $arrayVal[$i]['Value'] = $JsonArray['AttributeOrder'][6][$_POST['toid']]['Options'][$dumy];
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
//        /echo "SELECT Value  FROM ME_AutoSuggestionMaster WHERE ProjectId=".$ProjectId." AND AttributeMasterId=".$_POST['element']."";
        $link = $connection->execute("SELECT Value  FROM ME_AutoSuggestionMasterlist WHERE ProjectId=" . $ProjectId . " AND AttributeMasterId=" . $_POST['element'] . "")->fetchAll('assoc');

        $valArr = array();
        foreach ($link as $key => $value) {
            $valArr[] = $value['Value'];
        }
        echo json_encode($valArr);
        exit;
    }

    

    public function ajaxgetnextpagedata() {
        if (empty($this->request->session()->read('user_id'))) {
            echo 'expired';
            exit;
        } else {
            $connection = ConnectionManager::get('default');
            // echo 'SELECT BatchID,ProjectId,RegionId,InputEntityId,ProductionEntity,StatusId,UserId FROM Staging_1149_Data WHERE ProductionEntity='.$_POST['ProductionEntity'];
            $productionjobNew = $connection->execute('SELECT * FROM ML_ProductionEntityMaster WHERE ProductionEntity=' . $_POST['ProductionEntity'] . ' AND SequenceNumber=' . $_POST['page'])->fetchAll('assoc');
            //pr($productionjobNew);
            echo json_encode($productionjobNew[0]);
            exit;
        }
    }

    public function ajaxaddnew() {

        exit;
    }

    

    

}
