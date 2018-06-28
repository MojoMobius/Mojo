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

        $configquery = $connection->execute("SELECT * FROM DashboardModuleconfig where Userid='" . $user . "'")->fetchAll('assoc');

        $this->set('setting_overall', $configquery[0]['Overall']);
        $this->set('setting_error', $configquery[0]['Errordistribution']);
        $this->set('setting_issue', $configquery[0]['Issues']);
        $this->set('setting_rft', $configquery[0]['Rightfirst']);

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

    public function getErrorchartreports($batch_from, $batch_to, $ProjectId, $RegionId) {

        $Chartreports = array();
        $connection = ConnectionManager::get('default');

        if (isset($ProjectId)) {

            $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);

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
        return $Chartreports;
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

    public function getdashboardchartreports() {
        $RegionId = 1011;
        $ProjectId = $this->request->data['ProjectId'];
        $ProjectId = 3346;
        if (!empty($this->request->data('month_from'))) {
            $batch_from = $this->request->data('month_from');
        }

        if (!empty($this->request->data('month_to'))) {
            $batch_to = $this->request->data('month_to');
        }
        $batch_from = '03-2018';
        $batch_to = '06-2018';

        $userconfiglist = array();
        $linechart = 0;
        $piechart = 1;
        $barchart = 0;
        $campaigntab = 1;


        // Line chart 
        if (!empty($linechart)) {
            $result['linechart'] = $this->getChartreports($batch_from, $batch_to, $ProjectId, $RegionId);
        } else {
            $result['linechart'] = array("status" => 0);
        }

        // Pie-chart 
        if (!empty($piechart)) {
            $result['piechart'] = $this->getErrorchartreports($batch_from, $batch_to, $ProjectId, $RegionId);
        } else {
            $result['piechart'] = array("status" => 0);
        }

        // barchart
        if (!empty($barchart)) {
            $result['barchart'] = $this->getErrorbarchartreports($batch_from, $batch_to, $ProjectId, $RegionId);
        } else {
            $result['barchart'] = array("status" => 0);
        }

        // campaign table 
        if (!empty($campaigntab)) {
            $result['campaigntab'] = $this->getCampaignerrreports($batch_from, $batch_to, $ProjectId, $RegionId);
        } else {
            $result['campaigntab'] = array("status" => 0);
        }

        echo json_encode($result);
        exit;
    }

    public function pr($arr, $sk = 1) {

        echo "<pre>";
        print_r($arr);
        if (!empty($sk)) {
            exit;
        }
    }

    public function getCampaignerrreports($batch_from, $batch_to, $ProjectId, $RegionId) {

        $connection = ConnectionManager::get('default');
        if (!empty($ProjectId)) {

            $ProductionStartDate = "";
            $ProductionEndDate = "";
//                $QueryDateFrom = $batch_from = '03-2018';
//                $QueryDateTo = $batch_to = '06-2018';

            $QueryDateFrom = $batch_from;
            $QueryDateTo = $batch_to;

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


            $contentArr = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);

            $month = '6';
            $year = '2018';

            $dt = $month . '_' . $year;
            $conditions = "month(ProductionStartDate) ='$month' AND year(ProductionStartDate) ='$year'";

            $moduleId = $connection->execute("select ModuleId from ME_Module_Level_Config where modulegroup =1 and Project = $ProjectId")->fetchAll('assoc');

            $moduleId = $moduleId[0]['ModuleId'];
            $Regionid = $contentArr['RegionList'];
            $Regionid = array_keys($Regionid);
            $Regionid = $Regionid[0];
            $ProductionFields = $contentArr['ModuleAttributes'][$Regionid][$moduleId]['production'];
            $AttributeGroupMaster = $contentArr['AttributeGroupMasterDirect'];
            $groupwisearray = array();
            $subgroupwisearray = array();
            foreach ($AttributeGroupMaster as $key => $value) {
                //    $groupwisearray[] = $value;
                $keys = array_map(function($v) use ($key, $emparr) {
                    if ($v['MainGroupId'] == $key) {
                        return $v;
                    }
                }, $ProductionFields);

                $keys_sub = $this->combineBySubGroup($keys);
                $groupwisearray[] = $keys_sub;
            }
            $n = 0;
            $firstValue = array();
            foreach ($AttributeGroupMaster as $key => $value) {
                foreach ($groupwisearray[$key] as $keysub => $valuesSub) {
                    $firstValue[$n] = $valuesSub[0];
                    $n++;
                }
            }

            $subattrList = array();
            $finalarray = array();
            $arrtlist = array();
            foreach ($AttributeGroupMaster as $key => $val) {
                $subattrList[] = $contentArr['AttributeSubGroupMaster'][$key];
            }

            $i = 0;
            foreach ($subattrList as $key => $val) {
                foreach ($val as $keys => $vals) {
                    $finalarray[$keys] = $groupwisearray[$i][$keys];
                }
                $i++;
            }


            foreach ($finalarray as $key => $val) {
                foreach ($val as $keys => $value) {
                    $arrtlist[$key][] = $value['AttributeMasterId'];
                }
            }

            $select_fields_sel = [];
            $select_fields_exists = [];
            $select_fields_exists_group = [];
            $result = array();

            foreach ($arrtlist as $key => $value) {
                foreach ($value as $val) {
                    $select_fields_sel = "'$val'";

                    // get monthly reports 

                    $queriesFieldFind = $connection->execute("select name as select_fields_name FROM sys.columns WHERE name in (N$select_fields_sel) AND object_id = OBJECT_ID(N'Report_ProductionEntityMaster_" . $dt . "')");
                    $queriesFieldFind = $queriesFieldFind->fetchAll('assoc');

//$this->pr($queriesFieldFind);

                    $reportListfinal = array();
                    foreach ($queriesFieldFind as $select_fields_ex) {

                        $vals_exist = '[' . $select_fields_ex['select_fields_name'] . ']';
                        $select_fields_exists_group = '[' . $select_fields_ex['select_fields_name'] . ']';
                        $select_fields_exists = "REPLACE(REPLACE(" . $vals_exist . ",CHAR(13),' '),CHAR(10),' ') as " . $vals_exist . "";

                        $display_fields[] = $select_fields_ex['select_fields_name'];
//                        $reportList = $connection->execute("Select count(" . $select_fields_exists_group . ") as cnt,$select_fields_exists_group as $select_fields_exists_group from Report_ProductionEntityMaster_" . $dt . " where $conditions and ProjectId ='" . $ProjectId . "'  and DependencyTypeMasterId=20  group by " . $select_fields_exists_group . "");
                        $reportList = $connection->execute("Select count($select_fields_exists_group) as cnt,$select_fields_exists_group as $select_fields_exists_group from Report_ProductionEntityMaster_$dt where $conditions and ProjectId ='$ProjectId'  group by  $select_fields_exists_group ");
                        $reportList = $reportList->fetchAll('assoc');


                        foreach ($reportList as $keys => $vals) {
                            foreach ($ProductionFields as $item) {
                                $SubGroupName = $contentArr['AttributeSubGroupMaster'][$item['MainGroupId']][$key];

                                if (($vals[$select_fields_ex['select_fields_name']] == '') || ($vals[$select_fields_ex['select_fields_name']] == null)) {
//                                    $this->pr($item,0);
//                                    $this->pr($select_fields_ex['select_fields_name']);

                                    if ($item['AttributeMasterId'] == $select_fields_ex['select_fields_name'])
                                        $result[$SubGroupName][$item['DisplayAttributeName']]['X'] = $vals['cnt'];
                                }
                                if ($vals[$select_fields_ex['select_fields_name']] == 'A') {
                                    if ($item['AttributeMasterId'] == $select_fields_ex['select_fields_name'])
                                        $result[$SubGroupName][$item['DisplayAttributeName']]['A'] = $vals['cnt'];
                                }
                                if ($vals[$select_fields_ex['select_fields_name']] == 'D') {
                                    if ($item['AttributeMasterId'] == $select_fields_ex['select_fields_name'])
                                        $result[$SubGroupName][$item['DisplayAttributeName']]['D'] = $vals['cnt'];
                                }
                                if ($vals[$select_fields_ex['select_fields_name']] == 'M') {
                                    if ($item['AttributeMasterId'] == $select_fields_ex['select_fields_name'])
                                        $result[$SubGroupName][$item['DisplayAttributeName']]['M'] = $vals['cnt'];
                                }
                                if ($vals[$select_fields_ex['select_fields_name']] == 'V') {
                                    if ($item['AttributeMasterId'] == $select_fields_ex['select_fields_name'])
                                        $result[$SubGroupName][$item['DisplayAttributeName']]['V'] = $vals['cnt'];
                                }
                            }
                        }
                    }
                }
            }


            $table = "<table class='table table-striped table-center'>";
            $table .="<thead><tr>
                <th>Sub Group Name</th>
                <th>Field Name</th>
                <th>X</th>
                <th>A</th>
                <th>D</th>
                <th>M</th>
                <th>V</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>";
            foreach ($result as $query => $value) {
                $i = 0;
                foreach ($value as $vals => $val) {
                    $table .= '<tr>';
                    if ($i == 0)
                        $table .= '<td rowspan=' . count($value) . '>' . $query . '</td>';
                    $Total = $val['X'] + $val['A'] + $val['D'] + $val['M'] + $val['V'];
                    $table .= '<td>' . $vals . '</td>';
                    $table .= '<td>' . $val['X'] . '</td>';
                    $table .= '<td>' . $val['A'] . '</td>';
                    $table .= '<td>' . $val['D'] . '</td>';
                    $table .= '<td>' . $val['M'] . '</td>';
                    $table .= '<td>' . $val['V'] . '</td>';
                    $table .= '<td>' . $Total . '</td>';
                    $table .= '</tr>';
                    $i++;
                }
            }
            $table .= "</tbody>
    </table>";


            $results['table'] = $table;
            $results['total'] = count($result);
            $results['status'] = 1;

            return $results;
//            echo "<pre>";
//            print_r($table);
//            exit;
        }
    }

    public function getErrorbarchartreports($batch_from, $batch_to, $ProjectId, $RegionId) {

        $Chartreports = array();
        $connection = ConnectionManager::get('default');
        if (isset($ProjectId)) {
            $first_head_result = array();
            try {

                $ProductionStartDate = "";
                $ProductionEndDate = "";

//                $QueryDateFrom = $batch_from = '03-2018';
//                $QueryDateTo = $batch_to = '06-2018';

                $QueryDateFrom = $batch_from;
                $QueryDateTo = $batch_to;

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

                    // campaign list level 1 - getting subattributes
                    $ListAttributes = implode(",", $atr_val);
                    $check_Attributes = " mc.AttributeMasterId IN (" . $ListAttributes . ")";

                    $Datecheck = "Convert(date, pm.ProductionStartDate)>='" . $ProductionStartDate . "' AND Convert(date, pm.ProductionEndDate)<='" . $ProductionEndDate . "' AND";

                    // Get month list for - Report_ProductionEntityMaster$Mnth level 2
                    // ......
                    $first_head['name'] = $AttributeGroupMasterDirect[$atr_key];
                    $first_head['type'] = "column";
                    $first_head['showInLegend'] = true;
                    $first_head['yValueFormatString'] = "###0.0'%'";
                    $first_head['dataPoints'] = array();

                    foreach ($months as $key => $val) {

                        $date_strings = str_replace("_", "-", $val);
                        $xAxisname = date("F Y", strtotime("01" . $date_strings));

                        $table_rep = "Report_ProductionEntityMaster$val";
                        $get_tableexist = $connection->execute("IF OBJECT_ID (N'$table_rep', N'U') IS NOT NULL SELECT 1 AS res ELSE SELECT 0 AS res ")->fetchAll('assoc');

                        if ($get_tableexist[0]['res'] > 0) {

                            // get input ids based on start & end date.
                            $get_InputEntityIds = $connection->execute("SELECT DISTINCT pm.InputEntityId FROM $table_rep as pm  WHERE $Datecheck pm.ProjectId='$ProjectId' ")->fetchAll('assoc');

                            // if having inputentityids count error info level 3
                            // no ids empty result
                            if (!empty($get_InputEntityIds)) {

                                $InputEntityIds = array_column($get_InputEntityIds, 'InputEntityId');
                                $get_InputEntityId_ids = implode(",", $InputEntityIds);
                                $check_Inputentityids = " mc.InputEntityId IN ($get_InputEntityId_ids)";

                                // get count info errror
                                $Error_cnt_report = $connection->execute("SELECT count(Id) as count FROM MV_QC_Comments as mc  WHERE mc.ProjectId='$ProjectId' AND $check_Attributes AND $check_Inputentityids")->fetchAll('assoc');

//                        $first_head['dataPoints'] = array(array("y" => $Error_cnt_report[0]['count'], "label" => date('F Y', strtotime($ProductionStartDate))));
                                $first_head['dataPoints'][] = array("y" => $atr_key, "label" => $xAxisname);
                            } else {
                                $first_head['dataPoints'][] = array("y" => $atr_key, "label" => $xAxisname);
                            }
                        } else {
                            $first_head['dataPoints'][] = array("y" => $atr_key, "label" => $xAxisname);
                        }
                    }
                    $first_head_result[] = $first_head;
                }

//                       echo "<pre>s";print_r($first_head_result);

                $Chartreports['chartres'] = $first_head_result;
                $Chartreports['total'] = count($first_head_result);
                $Chartreports['status'] = 1;
                return $Chartreports;
            } catch (\Exception $e) {
                $Chartreports['status'] = 1;
                $Chartreports['total'] = 0;
                return $Chartreports;
            }
        }
    }

    public function getChartreports($batch_from, $batch_to, $ProjectId, $RegionId) {

        $Chartreports = array();
        $connection = ConnectionManager::get('default');
        if (isset($ProjectId)) {

            try {

                $sladefault = QareviewSLA;
                $ProductionStartDate = "";
                $ProductionEndDate = "";

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
//                        $dataformatfirstpass['y'] = intval($value['Firstpass']);
//                        $dataformatfirstpass['label'] = $daytext;
//                        $dataformatfirstpassres[] = $dataformatfirstpass;

                        $getbatchavgres[$key]['monthTxt'] = $daytext;
                        $getbatchavgres[$key]['FirstpassTxt'] = intval($value['Firstpass']) . $percentage;
                        $getbatchavgres[$key]['AccuracyTxt'] = intval($value['Accuracy']) . $percentage;
                    }
                }

                $dataformat[0]["type"] = "line";
                $dataformat[0]["legendText"] = "Accuracy";
                $dataformat[0]["showInLegend"] = true;
                $dataformat[0]["dataPoints"] = $dataformataccuracyres;

//                $dataformat[2]["type"] = "line";
//                $dataformat[2]["showInLegend"] = true;
//                $dataformat[2]["legendText"] = "First Pass";
//                $dataformat[2]["dataPoints"] = $dataformatfirstpassres;

                $dataformat[1]["type"] = "line";
                $dataformat[1]["legendText"] = "SLA";
                $dataformat[1]["showInLegend"] = true;
                $dataformat[1]["dataPoints"] = $dataformatslares;

                $Chartreports['chartres'] = $dataformat;
                $Chartreports['total'] = count($getbatchavgres);

                $Chartreports['status'] = 1;
                return $Chartreports;
            } catch (\Exception $e) {
                $Chartreports['status'] = 1;
                $Chartreports['total'] = 0;
                return $Chartreports;
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

    public function ajaxsetting() {
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user = $session->read("user_id");
        $ProjectId = $session->read("ProjectId");
        $configquery = $connection->execute("SELECT * FROM DashboardModuleconfig where Userid='" . $user . "'")->fetchAll('assoc');
        //echo count($configquery);exit;
        if (count($configquery) > 0) {
            $UpdateQryStatus = "update DashboardModuleconfig set  Overall='" . $_POST['overall'] . "' ,Errordistribution='" . $_POST['error_dist'] . "' ,Issues='" . $_POST['issue'] . "',Rightfirst='" . $_POST['rft'] . "' where Userid='" . $user . "' ";
            $QryStatus = $connection->execute($UpdateQryStatus);
        } else {
            $InsertQryStatus = "INSERT INTO DashboardModuleconfig (Overall, Errordistribution, Issues, Rightfirst,Userid ) VALUES ('" . $_POST['overall'] . "','" . $_POST['error_dist'] . "','" . $_POST['issue'] . "','" . $_POST['rft'] . "','" . $user . "')";
            $QryStatus = $connection->execute($InsertQryStatus);
            //pr($QryStatus);exit;
        }

        echo "success";
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

}
