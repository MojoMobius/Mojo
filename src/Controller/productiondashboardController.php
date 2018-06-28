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
class productiondashboardController extends AppController {

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
        $this->loadModel('projectmasters');
        $this->loadModel('importinitiates');
        $this->loadModel('Puquery');
        $this->loadModel('Purebuttal');
        $this->loadModel('Agenterror');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
    }

    public function index() {
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $ProjectId = $session->read("ProjectId");
        $moduleId = $session->read("moduleId");

        $MojoProjectIds = $this->projectmasters->find('Projects');
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $user_id, 'Project' => $MojoProjectIds]);
        $ProList = $this->Puquery->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');
        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;


        $this->set('Projects', $ProListFinal);

        if (isset($this->request->data['ProjectId'])) {
            $this->set('ProjectId', $this->request->data['ProjectId']);
            $ProjectId = $this->request->data['ProjectId'];
        } else {
            $this->set('ProjectId', 0);
            $ProjectId = 0;
        }

        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $resources = $JsonArray['UserList'];
        $domainId = $JsonArray['ProjectConfig']['DomainId'];
        $region = $regionMainList = $JsonArray['RegionList'];
        $modules = $JsonArray['Module'];

        $modulesConfig = $JsonArray['ModuleConfig'];
        $modulesArr = array();
        foreach ($modules as $key => $val) {
            if (($modulesConfig[$key]['IsAllowedToDisplay'] == 1) && ($modulesConfig[$key]['IsModuleGroup'] == 1)) {
                $modulesArr[$key] = $val;
            }
        }
        $modulesArr[0] = '--Select--';
        ksort($modulesArr);
        $this->set('resources', $resources);
        $this->set('modules', $modulesArr);

        if (count($ProListFinal) == 2) {
            $ProjectId = $this->request->data['ProjectId'] = array_keys($ProListFinal)[1];
        }



        if (isset($this->request->data['ProjectId']) || isset($this->request->data['RegionId'])) {
            $region = $this->Puquery->find('region', ['ProjectId' => $this->request->data['ProjectId'], 'RegionId' => $this->request->data['RegionId'], 'SetIfOneRow' => 'yes']);
            $this->set('RegionId', $region);
        } else {
            $this->set('RegionId', 0);
        }

        $this->set('CallUserGroupFunctions', '');
        if (count($ProListFinal) == 2 && count($regionMainList) == 1 && !isset($this->request->data['RegionId'])) {
            $this->set('CallUserGroupFunctions', 'yes');
        }

        if (isset($this->request->data['UserGroupId'])) {
            $UserGroup = $this->Puquery->find('usergroupdetails', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $this->request->data['UserGroupId']]);
            $this->set('UserGroupId', $UserGroup);
            $UserGroupId = $this->request->data('UserGroupId');
        } else {
            $UserGroupId = '';
            $this->set('UserGroupId', '');
        }

        if (isset($this->request->data['QueryDateFrom']))
            $this->set('QueryDateFrom', $this->request->data['QueryDateFrom']);
        else
            $this->set('QueryDateFrom', '');

        if (isset($this->request->data['QueryDateTo']))
            $this->set('QueryDateTo', $this->request->data['QueryDateTo']);
        else
            $this->set('QueryDateTo', '');

        if (isset($this->request->data['UserId']))
            $this->set('UserId', $this->request->data['UserId']);
        else
            $this->set('UserId', '');

        if (isset($this->request->data['user_id']))
            $this->set('postuser_id', $this->request->data['user_id']);
        else
            $this->set('postuser_id', '');

        if (isset($this->request->data['ProjectId']) || isset($this->request->data['ModuleId'])) {
            $this->set('ModuleId', $this->request->data['ModuleId']);
            $Modules = $this->Purebuttal->find('module', ['ProjectId' => $this->request->data['ProjectId'], 'RegionId' => $this->request->data['RegionId'], 'ModuleId' => $this->request->data['ModuleId']]);

//            $Modules = $this->Puquery->find('module', ['ProjectId' => $this->request->data['ProjectId'], 'ModuleId' => $this->request->data['ModuleId']]);
            $this->set('ModuleIds', $Modules);
        } else {
            $this->set('ModuleIds', 0);
        }
//print_r($Modules);exit;
        if (isset($this->request->data['UserGroupId']))
            $this->set('postbatch_UserGroupId', $this->request->data['UserGroupId']);
        else
            $this->set('postbatch_UserGroupId', '');

        if (isset($this->request->data['check_submit']) || isset($this->request->data['formSubmit'])) {

            $conditions_cengage = "";
            $ProjectId = $this->request->data('ProjectId');
            $RegionId = $this->request->data('RegionId');
            $ModuleId = $this->request->data('ModuleId');
            ////////
            $connectiond2k = ConnectionManager::get('d2k');
            $Readyforputlrebuttal = Readyforputlrebuttal;
            $session = $this->request->session();
            //$moduleId = $session->read("moduleId");

            $QcFirstStatus = $connectiond2k->execute("SELECT Status FROM D2K_ModuleStatusMaster where ModuleId=$ModuleId and ModuleStatusIdentifier='$Readyforputlrebuttal' AND RecordStatus=1")->fetchAll('assoc');

            $QcFirstStatus = array_map(current, $QcFirstStatus);
            $first_Status_name = $QcFirstStatus[0];
            $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);


            $queryData = $connection->execute("SELECT Id FROM MC_DependencyTypeMaster where ProjectId=$ProjectId and FieldTypeName='General' ")->fetchAll('assoc');

            $DependencyTypeMasterId = $queryData[0]['Id'];
            $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);

            $user_id = $this->request->data('user_id');
            $user_group_id = $this->request->data('UserGroupId');
            $QueryDateTo = $this->request->data('QueryDateTo');
            $QueryDateFrom = $this->request->data('QueryDateFrom');
            $user_id_list = $this->Puquery->find('resourceDetailsArrayOnly', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $this->request->data['UserGroupId']]);
            $this->set('User', $user_id_list);

            if (empty($user_id)) {
                $user_id = array_keys($user_id_list);
            }

            if ($QueryDateFrom != '' && $QueryDateTo != '') {
                $conditions .= "  AND prdem.ProductionStartDate >='" . date('Y-m-d', strtotime($QueryDateFrom)) . " 00:00:00' AND prdem.ProductionStartDate <='" . date('Y-m-d', strtotime($QueryDateTo)) . " 23:59:59'";
            }
            if ($QueryDateFrom != '' && $QueryDateTo == '') {
                $conditions .= "  AND prdem.ProductionStartDate >='" . date('Y-m-d', strtotime($QueryDateFrom)) . " 00:00:00' AND prdem.ProductionStartDate <='" . date('Y-m-d', strtotime($QueryDateFrom)) . " 23:59:59'";
            }
            if ($QueryDateFrom == '' && $QueryDateTo != '') {
                $conditions .= "  AND prdem.ProductionStartDate ='" . date('Y-m-d', strtotime($QueryDateTo)) . " 00:00:00' AND prdem.ProductionStartDate ='" . date('Y-m-d', strtotime($QueryDateTo)) . " 23:59:59'";
            }

//            echo "<pre>ss";print_r($user_id);exit;
            if ($user_id != '') {
                $conditions_cengage .= "  AND ptm.UserID in (" . implode(',', $user_id) . ")";
            }


            $productionmasters = array();
            $result = array();
            $ReferanceId = "DomainId";

            $queryData = $connection->execute("SELECT uniq.AttributeMasterId,prdem.id as ProductionEntityMasterId,prdem.InputEntityId FROM MV_UniqueIdFields as uniq inner join ProductionEntityMaster as prdem on uniq.ProjectId = prdem.ProjectId where prdem.ProjectId='$ProjectId' and uniq.ReferanceId = '$ReferanceId' and prdem.StatusId ='$first_Status_id' $conditions")->fetchAll('assoc');




//             echo "<pre>s";print_r($queryData);
//echo $ProjectId.'--'.$first_Status_name."--".$first_Status_id;exit;

            if (!empty($queryData)) {

                foreach ($queryData as $key => $val) {
                    $ProductionEntityID = $val['ProductionEntityMasterId'];
                    $InputEntityId = $val['InputEntityId'];
                    $AttributeMasterId = $val['AttributeMasterId'];
                    // get fdrid  

                    $getresultfdrid = $connection->execute("SELECT cpid.AttributeValue FROM MC_CengageProcessInputData as cpid inner join ME_Production_TimeMetric as ptm on ptm.ProductionEntityID=cpid.ProductionEntityID where cpid.ProductionEntityID='$ProductionEntityID' and cpid.SequenceNumber=1 and cpid.DependencyTypeMasterId='$DependencyTypeMasterId' and cpid.AttributeMasterId='$AttributeMasterId' and cpid.AttributeValue!='' $conditions_cengage group by cpid.AttributeValue")->fetchAll('assoc');

                    // check fdrid not empty
                    if (!empty($getresultfdrid)) {
                        $fdrid = $getresultfdrid[0]['AttributeValue'];
                        $queries = $connection->execute("SELECT qccmt.StatusId,qccmt.RegionId,qccmt.SequenceNumber,qccmt.ProjectAttributeMasterId,qccmt.Id,qccmt.ProjectId,qccmt.RegionId,qccmt.InputEntityId,qccmt.TLReputedComments,qccmt.UserReputedComments,qccmt.QCComments,qccmt.AttributeMasterId,qccmt.OldValue,qccat.ErrorCategoryName FROM MV_QC_Comments as qccmt inner join MV_QC_ErrorCategoryMaster as qccat on qccat.id= qccmt.ErrorCategoryMasterId where qccmt.ProjectId = '$ProjectId' and qccmt.InputEntityId ='$InputEntityId' and qccmt.StatusId IN(3,4,5,7)")->fetchAll('assoc');

                        foreach ($queries as $key => $val) {
                            $queries[$key]['displayname'] = $contentArr['AttributeOrder'][$val['RegionId']][$val['ProjectAttributeMasterId']]['DisplayAttributeName'];
                        }

                        $result[$fdrid]['list'] = $queries;
                        $result[$fdrid]['ProductionEntityID'] = $ProductionEntityID;
                    }
                }
            }
//echo "<pre>s";print_r($result);exit;
            $this->set('rebuttalResult', $result);

            if (empty($result)) {
                $this->Flash->error(__('No Record found for this combination!'));
            }
        }
    }

    public function getErrorchartreports() {

        $Chartreports = array();
        $connection = ConnectionManager::get('default');

        if (isset($this->request->data['ProjectId'])) {

//                $ProjectId = 3346;
            $ProjectId = $this->request->data('ProjectId');
            $ProjectId = 3346;
            $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);

            $batch_from = $this->request->data('batch_from');
            $batch_to = $this->request->data('batch_to');

            $batch_from = '01-2018';
            $batch_to = '06-2018';

            if (!empty($batch_from) && !empty($batch_to)) {
                $ProductionStartDate = date("Y-m-d 00:00:00", strtotime("01-" . $batch_from));
                $ProductionEndDate = date("Y-m-d 23:59:59", strtotime("30-" . $batch_to));
            } elseif (!empty($batch_from) && empty($batch_to)) {
                $ProductionStartDate = date("Y-m-d 00:00:00", strtotime("01-" . $batch_from));
                $ProductionEndDate = date("Y-m-d 23:59:59", strtotime("30-" . $batch_from));
            } elseif (empty($batch_from) && !empty($batch_to)) {
                $ProductionStartDate = date("Y-m-d 00:00:00", strtotime("01-" . $batch_to));
                $ProductionEndDate = date("Y-m-d 23:59:59", strtotime("30-" . $batch_to));
            }

//                $ProductionStartDate = date("Y-m-d 00:00:00", strtotime($batch_from));
//                $ProductionEndDate = date("Y-m-d 23:59:59", strtotime($batch_to));

            $queries = $connection->execute("SELECT qccat.ErrorCategoryName,qccmt.ProjectAttributeMasterId,count(qccmt.ProjectAttributeMasterId) as cnt,qccmt.ErrorCategoryMasterId,qccmt.RegionId FROM MV_QC_Comments as qccmt inner join MV_QC_ErrorCategoryMaster as qccat on qccat.id= qccmt.ErrorCategoryMasterId where ProjectId = '$ProjectId' and qccmt.CreatedDate between '$ProductionStartDate' and '$ProductionEndDate' GROUP BY qccat.ErrorCategoryName, qccmt.ErrorCategoryMasterId,qccmt.RegionId,qccmt.ProjectAttributeMasterId");
            $queries = $queries->fetchAll('assoc');

            $queries_total = $connection->execute("SELECT count(*) as cnt FROM MV_QC_Comments as qccmt inner join MV_QC_ErrorCategoryMaster as qccat on qccat.id= qccmt.ErrorCategoryMasterId where ProjectId = '$ProjectId' and qccmt.CreatedDate between '$ProductionStartDate' and '$ProductionEndDate'");
            $queries_total = $queries_total->fetchAll('assoc');

            $total = 0;
            if (!empty($queries_total)) {
                $total = $queries_total[0]['cnt'];
                if (!empty($queries)) {
                    $peronepercentage = round(100 / $total, 1);
                    $chartres = array();
                    foreach ($queries as $key => $val) {
                        $queries[$key]['displayname'] = $val['ErrorCategoryName'] . " " . $contentArr['AttributeOrder'][$val['RegionId']][$val['ProjectAttributeMasterId']]['DisplayAttributeName'];
                        $queries[$key]['percent'] = round($peronepercentage * $val['cnt'], 1);

                        // chart result array prepare
                        $chartres[$key]['label'] = $queries[$key]['displayname'];
                        $chartres[$key]['y'] = $queries[$key]['percent'];
                        $chartres[$key]['exploded'] = true;
                        $chartres[$key]['cnt'] = $queries[$key]['cnt'];
                    }
                }
            }

            $Chartreports = array();
            $Chartreports['total'] = $total;
            $Chartreports['peronepercentage'] = $peronepercentage;
            // $Chartreports['res'] = $queries;
            $Chartreports['chartres'] = $chartres;
        }
        $Chartreports['status'] = 1;
        echo json_encode($Chartreports);
        exit;
    }

    function ajaxgetcampaign($ProjectId) {

        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';

        //$call = 'getModule();getusergroupdetails(this.value);';

        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $Campaign = $contentArr['AttributeGroupMasterDirect'];

            return $Campaign;
        }
    }

    public function getmonthlist($date1, $date2) {
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);
        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);
        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);
        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
        if ($diff > 0) {
            for ($i = 0; $i <= $diff; $i++) {
                $months[] = date('_n_Y', strtotime("$date1 +$i month"));
            }
        } else {
            $months[] = date('_n_Y', strtotime($date1));
        }
        return $months;
    }

    public function getErrorbarchartreports() {

        $Chartreports = array();
        $connection = ConnectionManager::get('default');
        if (isset($this->request->data['ProjectId'])) {
            $first_head_result = array();
            $RegionId = 1011;
            try {

                $ProjectId = $this->request->data['ProjectId'];
                $ProjectId = 3346;
//                $campaign = $this->ajaxgetcampaign($ProjectId);

                $sladefault = QareviewSLA;
                $batch_from = "";
                $batch_to = "";
                $ProductionStartDate = "";
                $ProductionEndDate = "";

                if (!empty($this->request->data('month_from'))) {
                    $batch_from = $this->request->data('month_from');
                }

                if (!empty($this->request->data('month_to'))) {
                    $batch_to = $this->request->data('month_to');
                }

//            $batch_from = '08-05-2018';
                $QueryDateFrom = $batch_from = '01-2018';
                $QueryDateTo = $batch_to = '06-2018';

//            $QueryDateFrom = $this->request->data('batch_from');
//            $QueryDateTo = $this->request->data('batch_to');

                if (!empty($batch_from) && !empty($batch_to)) {
                    $ProductionStartDate = date("Y-m-d 00:00:00", strtotime("01-" . $batch_from));
                    $ProductionEndDate = date("Y-m-d 23:59:59", strtotime("30-" . $batch_to));
                } elseif (!empty($batch_from) && empty($batch_to)) {
                    $ProductionStartDate = date("Y-m-d 00:00:00", strtotime("01-" . $batch_from));
                    $ProductionEndDate = date("Y-m-d 23:59:59", strtotime("30-" . $batch_from));
                } elseif (empty($batch_from) && !empty($batch_to)) {
                    $ProductionStartDate = date("Y-m-d 00:00:00", strtotime("01-" . $batch_to));
                    $ProductionEndDate = date("Y-m-d 23:59:59", strtotime("30-" . $batch_to));
                }

                $QueryDateFrom = $ProductionStartDate;
                $QueryDateTo = $ProductionEndDate;
                if ($QueryDateFrom != '' && $QueryDateTo != '') {
                    $months = $this->getmonthlist($QueryDateFrom, $QueryDateTo);
                } elseif ($QueryDateFrom != '' && $QueryDateTo == '') {
                    $months = $this->getmonthlist($QueryDateFrom, $QueryDateFrom);
                } elseif ($QueryDateFrom == '' && $QueryDateTo != '') {
                    $months = $this->getmonthlist($QueryDateTo, $QueryDateTo);
                }
                
                
                
                
//                echo "<pre>s";
//                print_r($months);
//                exit;


                $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
                $ProdModuleId = '';
                foreach ($JsonArray['ModuleConfig'] as $key => $value) {
                    if ($value['IsModuleGroup'] == '1') {
                        $ProdModuleId = $key;
                    }
                }
                $AttributeGroupMaster = $JsonArray['AttributeGroupMaster'][$ProdModuleId];

                $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$ProdModuleId]['production'];
                $AttributeGroupMasterDirect = $JsonArray['AttributeGroupMasterDirect'];
                $AttributeOrder = $JsonArray['AttributeOrder'];
                $AttributeGroupMaster = $JsonArray['AttributeGroupMaster'];
                $AttributeGroupMaster = $AttributeGroupMaster[$ProdModuleId];
                $groupwisearray = array();
                $subgroupwisearray = array();
                foreach ($AttributeGroupMaster as $key => $value) {
                    $groupwisearray[$key] = $value;
                    $keys = array_map(function($v) use ($key, $emparr) {
                        if ($v['MainGroupId'] == $key) {
                            return $v;
                        }
                    }, $ProductionFields);
                    //$keys_sub = $this->combineBySubGroup($keys);
                    $groupwisearray[$key] = $keys;
                }
                foreach ($groupwisearray as $arkey => $resval) {
                    foreach ($resval as $key => $newresval) {
                        if ($newresval['AttributeMasterId'] != "")
                            $ArrAtributes_all[$arkey][] = $newresval['AttributeMasterId']; //if end
                    }
                }


                // campaign list level 1 - with subattributes

                foreach ($ArrAtributes_all as $atr_key => $atr_val) {

                    $first_head['name'] = $AttributeGroupMasterDirect[$atr_key];
                    $first_head['type'] = "column";
                    $first_head['showInLegend'] = true;
                    $first_head['yValueFormatString'] = "###0.0'%'";
                    $first_head['dataPoints'] = array();

                    // campaign list level 1 - getting subattributes
                    $ListAttributes = implode(",", $atr_val);
                    $check_Attributes = " mc.AttributeMasterId IN (" . $ListAttributes . ")";

                    $Datecheck = "Convert(date, pm.ProductionStartDate)>='" . $ProductionStartDate . "' AND Convert(date, pm.ProductionEndDate)<='" . $ProductionEndDate . "' AND";
                    $Mnth = '_6_2018';

                    $table_rep = "Report_ProductionEntityMaster$Mnth";
                   
                    $get_InputEntityIds = $connection->execute("IF OBJECT_ID (N'$table_rep', N'U') IS NOT NULL SELECT 1 AS res ELSE SELECT 0 AS res ")->fetchAll('assoc');
                    
                    foreach($months as $key=>$val){
                        
//                        IF OBJECT_ID (N'MV_QC_Commentss', N'U') IS NOT NULL SELECT 1 AS res ELSE SELECT 0 AS res;
                    
                    echo $val;exit;
                    
                    
                        }
                    
                    
                    
                    // Get month list for - Report_ProductionEntityMaster$Mnth level 2
                    // ......
                    // get input ids based on start & end date.
                    $get_InputEntityIds = $connection->execute("SELECT DISTINCT pm.InputEntityId FROM Report_ProductionEntityMaster$Mnth as pm  WHERE $Datecheck pm.ProjectId='$ProjectId' ")->fetchAll('assoc');


                    // if having inputentityids count error info level 3
                    // no ids empty result
                    if (!empty($get_InputEntityIds)) {

                        $get_InputEntityId_ids = implode(",", array_column($get_InputEntityIds, 'InputEntityId'));
                        $check_Inputentityids = " mc.InputEntityId IN ($get_InputEntityId_ids)";

                        // get count info errror
                        $Error_cnt_report = $connection->execute("SELECT count(Id) as count FROM MV_QC_Comments as mc  WHERE mc.ProjectId='$ProjectId' AND $check_Attributes AND $check_Inputentityids")->fetchAll('assoc');


//                        $first_head['dataPoints'] = array(array("y" => $Error_cnt_report[0]['count'], "label" => date('F Y', strtotime($ProductionStartDate))));
                        $first_head['dataPoints'] = array(array("y" => $atr_key, "label" => date('F Y', strtotime($ProductionStartDate))));
                    }


                    $first_head_result[] = $first_head;
                }



//             type: "column",
//                    showInLegend: true,
//                    yValueFormatString: "#,##0.## tonnes",
//                    name: "Target",
//                    dataPoints: chartres


                $dataformat = array(
                    array("y" => 3373.64, "label" => "Germany"),
                    array("y" => 2435.94, "label" => "France"),
                    array("y" => 1842.55, "label" => "China"),
                    array("y" => 1828.55, "label" => "Russia"),
                    array("y" => 1039.99, "label" => "Switzerland"),
                    array("y" => 765.215, "label" => "Japan"),
                    array("y" => 612.453, "label" => "Netherlands")
                );




                // get campaign 
//                $Chartreports['chartres'] = $dataformat;
//                $Chartreports['total'] = count($dataformat);

                $Chartreports['chartres'] = $first_head_result;
                $Chartreports['total'] = count($first_head_result);

//            echo "<pre>ss";
//            print_r($first_head_result);
//            exit;
                $Chartreports['status'] = 1;
                echo json_encode($Chartreports);
                exit;
            } catch (\Exception $e) {
                $Chartreports['status'] = 1;
                echo json_encode($Chartreports);
                exit;
            }
        }
    }

    public function getChartreports() {

        $Chartreports = array();
        $connection = ConnectionManager::get('default');
        if (isset($this->request->data['ProjectId'])) {

            try {

                $ProjectId = $this->request->data['ProjectId'];
                $ProjectId = 3346;
                $sladefault = QareviewSLA;
                $batch_from = "";
                $batch_to = "";
                $ProductionStartDate = "";
                $ProductionEndDate = "";

                if (!empty($this->request->data('month_from'))) {
                    $batch_from = $this->request->data('month_from');
                }

                if (!empty($this->request->data('month_to'))) {
                    $batch_to = $this->request->data('month_to');
                }

//            $batch_from = '08-05-2018';
                $batch_from = '01-2018';
                $batch_to = '06-2018';

                if (!empty($batch_from) && !empty($batch_to)) {
                    $ProductionStartDate = date("Y-m-d 00:00:00", strtotime("01-" . $batch_from));
                    $ProductionEndDate = date("Y-m-d 23:59:59", strtotime("30-" . $batch_to));
                } elseif (!empty($batch_from) && empty($batch_to)) {
                    $ProductionStartDate = date("Y-m-d 00:00:00", strtotime("01-" . $batch_from));
                    $ProductionEndDate = date("Y-m-d 23:59:59", strtotime("30-" . $batch_from));
                } elseif (empty($batch_from) && !empty($batch_to)) {
                    $ProductionStartDate = date("Y-m-d 00:00:00", strtotime("01-" . $batch_to));
                    $ProductionEndDate = date("Y-m-d 23:59:59", strtotime("30-" . $batch_to));
                }


                //and Date between '$ProductionStartDate' and '$ProductionEndDate'

                $getbatchavg = $connection->execute("SELECT avg(AOQ) as Accuracy,MONTH(Date) as month,YEAR(Date) as year, (SELECT TOP 1 AOQ from MV_QC_BatchIteration where ProjectId = '$ProjectId' and Iteration = 1) as Firstpass,'$sladefault' as sla from MV_QC_BatchIteration where ProjectId = '$ProjectId' and Date between '$ProductionStartDate' and '$ProductionEndDate' group by MONTH(Date),YEAR(Date) order by MONTH(Date) asc");
                $getbatchavgres = $getbatchavg->fetchAll('assoc');
//print_r("SELECT avg(AOQ) as Accuracy,MONTH(Date) as month,YEAR(Date) as year, (SELECT TOP 1 AOQ from MV_QC_BatchIteration where ProjectId = '$ProjectId' and Iteration = 1) as Firstpass,'$sladefault' as sla from MV_QC_BatchIteration where ProjectId = '$ProjectId' and Date between '$ProductionStartDate' and '$ProductionEndDate' group by MONTH(Date),YEAR(Date) order by MONTH(Date) asc");exit;
                $dataformat = array();
                $dataformataccuracy = array();
                $dataformataccuracyres = array();

                $dataformatsla = array();
                $dataformatslares = array();

                $dataformatfirstpass = array();
                $dataformatFirstpassres = array();

                $percentage = "%";
                if (!empty($getbatchavgres)) {
                    foreach ($getbatchavgres as $key => $value) {
                        //Accuracy
                        $dataformataccuracy['y'] = intval($value['Accuracy']);
                        $daytext = date('M-Y', strtotime($value['year'] . '-' . $value['month'] . '-01'));
                        $dataformataccuracy['label'] = $daytext;
                        $dataformataccuracyres[] = $dataformataccuracy;

                        // sla
                        $dataformatsla['y'] = intval($sladefault);
                        $dataformatsla['label'] = $daytext;
                        $dataformatslares[] = $dataformatsla;
                        // firstpass
                        $dataformatfirstpass['y'] = intval($value['Firstpass']);
                        $dataformatfirstpass['label'] = $daytext;
                        $dataformatfirstpassres[] = $dataformatfirstpass;

                        $getbatchavgres[$key]['monthTxt'] = $daytext;
                        $getbatchavgres[$key]['FirstpassTxt'] = intval($value['Firstpass']) . $percentage;
                        $getbatchavgres[$key]['AccuracyTxt'] = intval($value['Accuracy']) . $percentage;
                    }
                }

                $dataformat[0]["type"] = "line";
                $dataformat[0]["legendText"] = "Accuracy";
                $dataformat[0]["showInLegend"] = true;
                $dataformat[0]["dataPoints"] = $dataformataccuracyres;

                $dataformat[1]["type"] = "line";
                $dataformat[1]["showInLegend"] = true;
                $dataformat[1]["legendText"] = "First Pass";
                $dataformat[1]["dataPoints"] = $dataformatfirstpassres;

                $dataformat[2]["type"] = "line";
                $dataformat[2]["legendText"] = "SLA";
                $dataformat[2]["showInLegend"] = true;
                $dataformat[2]["dataPoints"] = $dataformatslares;

                $Chartreports['chartres'] = $dataformat;
                $Chartreports['total'] = count($getbatchavgres);
                $Chartreports['getbatchavgres'] = $getbatchavgres;
//            echo "<pre>ss";
//            print_r($getbatchavgres);
//            exit;
                $Chartreports['status'] = 1;
                echo json_encode($Chartreports);
                exit;
            } catch (\Exception $e) {
                $Chartreports['status'] = 1;
                echo json_encode($Chartreports);
                exit;
            }
        }
    }

    public function purebuteajaxqueryinsert() {
        echo $region = $this->Puquery->find('region', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

    function ajaxregion() {
        echo $region = $this->Puquery->find('region', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

    function ajaxfilelist() {
        echo $file = $this->Puquery->find('filelist');
        exit;
    }

    function ajaxstatus() {
        echo $file = $this->Puquery->find('status', ['ProjectId' => $_POST['projectId'], 'importType' => $_POST['importType']]);
        exit;
    }

    function ajaxmodule() {


        echo $module = $this->Purebuttal->find('module', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'ModuleId' => $ModuleId]);
        exit;
    }

    function getusergroupdetails() {
        $session = $this->request->session();
        echo $module = $this->Puquery->find('usergroupdetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserId' => $session->read('user_id')]);
        exit;
    }

    function getresourcedetails() {
        $session = $this->request->session();
        echo $module = $this->Puquery->find('resourcedetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserGroupId' => $_POST['userGroupId']]);
        exit;
    }

    public function delete($id = null) {
        $Puquery = $this->Puquery->get($id);
        if ($id) {
            $user_id = $this->request->session()->read('user_id');
            $Puquery = $this->Puquery->patchEntity($Puquery, ['ModifiedBy' => $user_id, 'ModifiedDate' => date("Y-m-d H:i:s"), 'RecordStatus' => 0]);
            if ($this->Puquery->save($Puquery)) {
                $this->Flash->success(__('Import Initiate deleted Successfully'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set('Puquery', $Puquery);
        $this->render('index');
    }

    public function ajaxpurebutalcommentsinsert() {
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user = $session->read("user_id");

        $CommentsId = $_POST['CommentsId'];
        $ProjectId = $_POST['ProjectId'];
        $InputEntityId = $_POST['InputEntityId'];
        $QCrebuttalTextbox = $_POST['QCrebuttalTextbox'];
        $Status_id = $_POST['Status_id'];
        $ModuleId = $_POST['ModuleId'];

        $UpdateQryStatus = "update MV_QC_Comments set  StatusId='" . $Status_id . "' ,TLReputedComments='" . trim($QCrebuttalTextbox) . "' where Id='" . $CommentsId . "' ";
        $QryStatus = $connection->execute($UpdateQryStatus);

        $queries = $connection->execute("SELECT RegionId,StatusId,SequenceNumber,Id,TLReputedComments,UserReputedComments,QCComments,AttributeMasterId,OldValue FROM MV_QC_Comments where Id = '$CommentsId'")->fetchAll('assoc');

        $RegionId = $queries[0]['RegionId'];

        // pu user rework -> status update when atleast one reject from pu-tl   
        $pucmtcntfindqueries = $connection->execute("SELECT count(Id) as pucmtcnt FROM MV_QC_Comments where StatusId = '3' and InputEntityId='$InputEntityId' and ProjectId='$ProjectId'")->fetchAll('assoc');

        if (!empty($pucmtcntfindqueries)) {

            $connectiond2k = ConnectionManager::get('d2k');
            $Readyforputlrebuttal = Readyforputlrebuttal;
            $ReadyforPURework = ReadyforPUReworkIdentifier;
            $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);

            // get production main-status id 
            $PutlFirstStatus = $connectiond2k->execute("SELECT Status FROM D2K_ModuleStatusMaster where ModuleId=$ModuleId and ModuleStatusIdentifier='$Readyforputlrebuttal' AND RecordStatus=1")->fetchAll('assoc');
            $PutlFirstStatus = array_map(current, $PutlFirstStatus);
            $Putlfirst_Status_name = $PutlFirstStatus[0];
            $Putlfirst_Status_id = array_search($Putlfirst_Status_name, $JsonArray['ProjectStatus']);

            $pucmtcnt = array_map(current, $pucmtcntfindqueries);
            $cnt = $pucmtcnt[0];
            if ($cnt == 0) { // checking no Tl - comments pending 
                $purejectcmtcntfindqueries = $connection->execute("SELECT count(Id) as pucmtcnt FROM MV_QC_Comments where StatusId = '5' and InputEntityId='$InputEntityId' and ProjectId='$ProjectId'")->fetchAll('assoc');
                $purejcmtcnt = array_map(current, $purejectcmtcntfindqueries);
                $purejcnt = $purejcmtcnt[0];

                if ($purejcnt > 0) { // check its having any rejected status
                    $getreworkFirstStatus = $connectiond2k->execute("SELECT Status FROM D2K_ModuleStatusMaster where ModuleId='$ModuleId' and ModuleStatusIdentifier='$ReadyforPURework' AND RecordStatus=1")->fetchAll('assoc');
                    $pureworkfirstStatus = array_map(current, $getreworkFirstStatus);
                    $pureworkfirst_Status_name = $pureworkfirstStatus[0];
                    $purework_Status_id = array_search($pureworkfirst_Status_name, $JsonArray['ProjectStatus']);

                    $UpdateQryStatus = "update ProductionEntityMaster set StatusId='$purework_Status_id' where ProjectId='$ProjectId'  AND InputEntityId=$InputEntityId ";
                    $QryStatus = $connection->execute($UpdateQryStatus);
                } else { // pu rebuttal comments done without any reject
                    $putlcompletedstatus_id = $JsonArray['ModuleStatus_Navigation'][$Putlfirst_Status_id][1];
                    $UpdateQryStatus = "update ProductionEntityMaster set  StatusId='$putlcompletedstatus_id' where ProjectId='$ProjectId' AND InputEntityId=$InputEntityId";
                    $QryStatus = $connection->execute($UpdateQryStatus);
                    //Staging table updation
                    $module = $JsonArray['Module'];
                    $module = array_keys($module);
                    $ProductionFields = array();
                    foreach ($module as $key => $value) {
                        $StaticFieldssarr = $JsonArray['ModuleAttributes'][$RegionId][$value]['production'];
                        if (!empty($StaticFieldssarr)) {
                            $moduleId = $value;
                        }
                    }

                    $stagingTable = 'Staging_' . $moduleId . '_Data';
                    $UpdateQryStatus = "update $stagingTable set  StatusId='$putlcompletedstatus_id' where ProjectId='$ProjectId' AND InputEntityId=$InputEntityId";
                    $QryStatus = $connection->execute($UpdateQryStatus);
                }
            }
        }

        $data1 = $queries[0];
        if ($data1['StatusId'] == 4) {
            $rebute_txt = "Rebute";
        } else if ($data1['StatusId'] == 5) {
            $rebute_txt = "Reject";
        }
        $call = "return query('" . $data1['Id'] . "','" . $data1['StatusId'] . "','D','" . $data1['TLReputedComments'] . "','" . $data1['QCComments'] . "','" . $data1['UserReputedComments'] . "')";

        echo '<button name="frmsubmit" type="button" onclick="' . $call . '" class="btn btn-default btn-sm added-commnt">' . $rebute_txt . '</button>';
        exit;
    }

    public function ajaxqueryinsert() {
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user = $session->read("user_id");
        $ProjectId = $session->read("ProjectId");
        $UpdateQryStatus = "update ME_UserQuery set  TLComments='" . trim($_POST['mobiusComment']) . "' ,StatusID='" . $_POST['status'] . "' ,ModifiedBy=$user,ModifiedDate='" . date('Y-m-d H:i:s') . "' where Id='" . $_POST['queryID'] . "' ";
        $QryStatus = $connection->execute($UpdateQryStatus);
        if ($_POST['status'] == 3) {
            $moduleTable = 'Staging_' . $_POST['ModuleId'] . '_Data';
            $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
            $first_Status_name = $JsonArray['ModuleStatusList'][$_POST['ModuleId']][0];
            $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);
            $UpdateQryStatus = "update $moduleTable set  StatusId='" . $first_Status_id . "',QueryResolved=1 ,ModifiedBy=$user,ModifiedDate='" . date('Y-m-d H:i:s') . "' where ProductionEntity='" . $_POST['ProductionEntityId'] . "' ";
            $QryStatus = $connection->execute($UpdateQryStatus);
            $UpdateQryStatus = "update ME_Production_TimeMetric set StatusId='" . $first_Status_id . "' where ProductionEntityID='" . $_POST['ProductionEntityId'] . "' AND Module_Id=" . $_POST['ModuleId'];
            $QryStatus = $connection->execute($UpdateQryStatus);
        }
        echo 'updated';
        exit;
    }

}
