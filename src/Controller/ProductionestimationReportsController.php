<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class ProductionestimationReportsController extends AppController {

    public $paginate = [
        'limit' => 10,
        'order' => [
            'Id' => 'asc'
        ]
    ];

    public function initialize() {
        parent::initialize();
        $this->loadModel('ProductionDashBoards');
        $this->loadModel('ProductionestimationReports');
        $this->loadModel('projectmasters');
        $this->loadComponent('RequestHandler');
    }

    public function index() {
        $session = $this->request->session();
        $sessionProjectId = $session->read("ProjectId");
        $userid = $session->read('user_id');
        set_time_limit(0);
        $MojoProjectIds = $this->projectmasters->find('Projects');
        //$this->set('Projects', $ProListFinal);
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->ProductionDashBoards->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');

        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];

        endforeach;
        //$ProListFinal = ['0' => '--Select Project--', '2278' => 'ADMV_YP'];

        $this->set('Projects', $ProListFinal);
        $this->set('sessionProjectId', $sessionProjectId);

        $connection = ConnectionManager::get('default');
        $Cl_listarray = $connection->execute("select Id,ClientName FROM ClientMaster")->fetchAll('assoc');

        $Cl_list = array('0' => '--Select--');
        foreach ($Cl_listarray as $values):
            $Cl_list[$values['Id']] = $values['ClientName'];
        endforeach;
        //$ProListFinal = ['0' => '--Select Project--', '2278' => 'ADMV_YP'];
        $this->set('Clients', $Cl_list);

        if ($this->request->data['ClientId'] > 0) {
            $Clients = $this->ProductionDashBoards->find('client', ['ClientId' => $this->request->data['ClientId']]);
            $this->set('ClientId', $Clients);
        } else {

            $this->set('ClientId', '');
        }


        if (count($ProListFinal) == 2) {
            $ProjectId = $this->request->data['ProjectId'] = array_keys($ProListFinal)[1];
        }

        if (isset($this->request->data['ProjectId'])) {
            $this->set('ProjectId', $this->request->data['ProjectId']);
            $ProjectId = $this->request->data['ProjectId'];
        } else {
            $this->set('ProjectId', 0);
            $ProjectId = 0;
        }

        $path = JSONPATH . '\\ProjectConfig_' . $sessionProjectId . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $region = $regionMainList = $contentArr['RegionList'];
        foreach ($region as $key => $value) {
            $sessionRegion = $key;
        }

        $status_list = $contentArr['ProjectStatus'];
        // pr($status_list);
        $status_list_module = $contentArr['ModuleStatusList'];
        $module_ids = array_keys($status_list_module);
        $array_with_lcvalues = array_map('strtolower', $status_list);
        $ProdDB_PageLimit = $contentArr['ProjectConfig']['ProdDB_PageLimit'];
        $module = $contentArr['Module'];
        $ModuleStatus = $contentArr['ModuleStatus'];
        $ModuleUser = $contentArr['ModuleUser'];
        $domainId = $contentArr['ProjectConfig']['DomainId'];
        $moduleConfig = $contentArr['ModuleConfig'];
        asort($status_list);
        $search_text = 'Query';
        // pr($status_list);
        foreach ($status_list as $index => $string) {
            // echo $string;
            if (strpos($string, $search_text) !== FALSE) {
                $queryStatus = $index;
                break;
            }
        }

        //pr($queryStatus);  
        // exit;
        //pr($status_list); 
        $second_condition_status_list = $completed_status_ids = [];
        foreach ($status_list as $keystat => $stat) {
            $posCompleted = strpos(strtolower($stat), 'completed');
            if ($posCompleted === false) {
                $second_condition_status_list[$keystat] = $stat;
            } else {
                $completed_status_ids[] = $keystat;
            }
        }
        //pr($second_condition_status_list); 
        //pr($completed_status_ids);
        //die;

        $second_condition_status_listss = $completed_status_idsss = [];
        foreach ($status_list as $keystatss => $statss) {
            $posCompletedss = strpos(strtolower($statss), 'ready for production');
            if ($posCompletedss === false) {
                $second_condition_status_listss[$keystatss] = $statss;
            } else {
                $completed_status_idsss[$keystatss] = $keystatss;
            }
        }

        $readyforprod = implode(',', $completed_status_idsss);

        $this->set('ProdDB_PageLimit', $ProdDB_PageLimit);
        $this->set('status_list_module', $status_list_module);
        $this->set('module_ids', $module_ids);
        $this->set('SessionRegionId', $sessionRegion);
        $this->set('Status', $status_list);
        $this->set('module', $module);
        $this->set('moduleConfig', $moduleConfig);
        $this->set('ModuleStatus', $ModuleStatus);
        $this->set('queryStatus', $queryStatus);
//pr($completed_status_idsss); exit;
        if (isset($this->request->data['ProjectId']) || isset($this->request->data['RegionId'])) {
            $region = $this->ProductionDashBoards->find('region', ['ProjectId' => $this->request->data['ProjectId'], 'RegionId' => $this->request->data['RegionId'], 'SetIfOneRow' => 'yes']);
            $this->set('RegionId', $region);
        } else {
            $this->set('RegionId', 0);
        }


        $this->set('CallUserGroupFunctions', '');
        if (count($ProListFinal) == 2 && count($regionMainList) == 1 && !isset($this->request->data['RegionId'])) {
            $this->set('CallUserGroupFunctions', 'yes');
        }

        if (isset($this->request->data['UserGroupId'])) {
            $UserGroup = $this->ProductionDashBoards->find('usergroupdetails', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $this->request->data['UserGroupId']]);
            $this->set('UserGroupId', $UserGroup);
            $UserGroupId = $this->request->data('UserGroupId');
        } else {
            $UserGroupId = '';
            $this->set('UserGroupId', '');
        }

        if (isset($this->request->data['status']))
            $this->set('poststatus', $this->request->data['status']);
        else
            $this->set('poststatus', '');

        if (isset($this->request->data['batch_to']))
            $this->set('postbatch_to', $this->request->data['batch_to']);
        else
            $this->set('postbatch_to', '');

        if (isset($this->request->data['batch_from']))
            $this->set('postbatch_from', $this->request->data['batch_from']);
        else
            $this->set('postbatch_from', date('d-m-Y'));

        if (isset($this->request->data['user_id']))
            $this->set('postuser_id', $this->request->data['user_id']);
        else
            $this->set('postuser_id', '');
        if (isset($this->request->data['query']))
            $this->set('postquery', $this->request->data['query']);
        else
            $this->set('postquery', '');
        if (isset($this->request->data['deliveryDate']))
            $this->set('postbatch_deliveryDate', $this->request->data['deliveryDate']);
        else
            $this->set('postbatch_deliveryDate', '');

        if (isset($this->request->data['UserGroupId']))
            $this->set('postbatch_UserGroupId', $this->request->data['UserGroupId']);
        else
            $this->set('postbatch_UserGroupId', '');


        if (isset($this->request->data['check_submit']) || isset($this->request->data['downloadFile'])) {

            $conditions = '';

            if ($this->request->data['UserGroupId'] > 0) {

                $user_id_list = $this->ProductionDashBoards->find('resourceDetailsArrayOnly', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'UserGroupId' => $this->request->data['UserGroupId'], 'UserId' => $session->read('user_id')]);

                $this->set('User', $user_id_list);
            }

            $QueryDateFrom = $batch_from = $this->request->data('batch_from');
            $QueryDateTo = $batch_to = $this->request->data('batch_to');
            $user_id = $this->request->data('user_id');
            $status = $this->request->data('status');
            $query = $this->request->data('query');
            $RegionId = $this->request->data('RegionId');
            $UserGroupId = $this->request->data('UserGroupId');
            $selected_month_first = strtotime($batch_to);
            $month_start = date('Y-m-d', strtotime('first day of this month', $selected_month_first));
            $selected_month_last = strtotime($batch_from);
            $month_end = date('Y-m-d', strtotime('last day of this month', $selected_month_last));

            if (empty($user_id)) {
                $user_id = array_keys($user_id_list);
            }

            if (empty($user_id)) {
                $this->Flash->error(__('No UserId(s) found for this UserGroup combination!'));
                $ShowErrorOnly = TRUE;
            }

            if ($ShowErrorOnly) {
                
            } else {

                $AttributeOrder = $contentArr['AttributeOrder'][$_POST['RegionId']];
                $attributeIds = [];

                $conditions_status = '';
                $conditions_timemetric = '';

                if ($batch_from != '' && $batch_to == '') {
                    $batch_to = $batch_from;
                }
                if ($batch_from == '' && $batch_to != '') {
                    $batch_from = $batch_to;
                }

                if ($QueryDateFrom != '' && $QueryDateTo != '') {
                    $months = $this->getmonthlist($QueryDateFrom, $QueryDateTo);
                } elseif ($QueryDateFrom != '' && $QueryDateTo == '') {
                    $months = $this->getmonthlist($QueryDateFrom, $QueryDateFrom);
                } elseif ($QueryDateFrom == '' && $QueryDateTo != '') {
                    $months = $this->getmonthlist($QueryDateTo, $QueryDateTo);
                } else {
                    $QueryDateFrom = date("Y-m-d");
                    $QueryDateTo = date("Y-m-d");
                    $months = $this->getmonthlist($QueryDateTo, $QueryDateTo);
                }
//                $ProjectId = 3346;
                $arrayResult = array();
//                $months[] = "_6_2018";

                foreach ($months as $key => $dt) {

//            $prodtimematricstab = "Report_ProductionTimeMetric_6_2018";

                    $prodEntitymastertab = "Report_ProductionEntityMaster" . $dt;
                    echo $prodtimeMatricstab = "ME_Production_TimeMetric" . $dt;

                    $get_tableexist_TimeMatrix = $connection->execute("IF OBJECT_ID (N'$prodtimeMatricstab', N'U') IS NOT NULL SELECT 1 AS res ELSE SELECT 0 AS res ")->fetchAll('assoc');

                    $get_tableexist_Entitymaster = $connection->execute("IF OBJECT_ID (N'$prodEntitymastertab', N'U') IS NOT NULL SELECT 1 AS res ELSE SELECT 0 AS res ")->fetchAll('assoc');


                    // check table exists 
                    if ($get_tableexist_TimeMatrix[0]['res'] > 0 && $get_tableexist_Entitymaster[0]['res'] > 0) {

                        // Get availabel columns
                        $result = $connection->execute("SELECT top 1 * FROM $prodtimeMatricstab WHERE ProjectId = '$ProjectId'")->fetchAll('assoc');
                        $modulekeys = array_keys($module);
                        $TableColumnkeys = array_keys($result[0]);
                        $AvlTablecolumns = array();
                        foreach ($modulekeys as $key => $val) {
                            if (in_array($val, $TableColumnkeys)) {
                                $AvlTablecolumns[] = $val;
                            }
                        }

                        $conditions.=" AND Module_Id IN (" . implode(',', array_keys($module)) . ")";

                        $prodEntityconditions.=" AND ProductionStartDate >='" . date('Y-m-d', strtotime($batch_from)) . " 00:00:00' AND ProductionStartDate <='" . date('Y-m-d', strtotime($batch_to)) . " 23:59:59'";

                        $domainattrid = "[" . $domainId . "]";
                        $queryData = $connection->execute("SELECT Id FROM MC_DependencyTypeMaster where ProjectId='$ProjectId' and FieldTypeName='General' ")->fetchAll('assoc');
                        $DependencyTypeMasterId = $queryData[0]['Id'];

                        $Production_dashboard = $connection->execute("SELECT distinct rpem.InputEntityId, $domainattrid as fdrid ,rpem.InputEntityId as Id,rpem.StatusId,rpem.ProductionStartDate,rpem.ProductionEndDate,rpem.ProjectId FROM $prodtimeMatricstab as rpetm inner join $prodEntitymastertab as rpem ON rpetm.InputEntityId =rpem.InputEntityId WHERE rpem.ProjectId = '$ProjectId' $prodEntityconditions  AND rpem.DependencyTypeMasterId='$DependencyTypeMasterId'")->fetchAll('assoc');

                        foreach ($Production_dashboard as $key => $val) {

                            $InputEntityId = $val['InputEntityId'];
                            $conditionsInputEntity .= "AND InputEntityId ='$InputEntityId'";
                            $Production_dashboard_module = $connection->execute("SELECT ProductionEntityID,Module_Id,UserId,Start_Date,End_Date,TimeTaken,Estimated_Time FROM $prodtimeMatricstab as rpetm WHERE rpetm.ProjectId = '$ProjectId' $conditions $conditionsInputEntity")->fetchAll('assoc');

                            $Production_dashboard_modules = array();
                            foreach ($Production_dashboard_module as $k => $v) {
                                $Production_dashboard_modules[$v['Module_Id']] = $v;
                                $timetak = explode(".", $v['TimeTaken']);
                                $Production_dashboard_modules[$v['Module_Id']]['TimeTaken'] = $timetak[0];
                            }
                            $Production_dashboard[$key]['module'] = $Production_dashboard_modules;
                        }
                        $arrayResult = array_merge($arrayResult, $Production_dashboard);
                    } else {
                        continue;
                    }
                }
                
                if (empty($arrayResult)) {
                    $this->Flash->error(__('No Record found for this combination!'));
//                    return $this->redirect(['action' => 'index']);
                }
                
                if (isset($this->request->data['downloadFile']) && !empty($arrayResult)) {
                    $productionData = '';
                    $productionData = $this->ProductionestimationReports->find('export', ['ProjectId' => $ProjectId, 'condition' => $arrayResult]);
                    $this->layout = null;
                    if (headers_sent())
                        throw new Exception('Headers sent.');
                    while (ob_get_level() && ob_end_clean());
                    if (ob_get_level())
                        throw new Exception('Buffering is still active.');
                    header("Content-type: application/vnd.ms-excel");
                    header("Content-Disposition:attachment;filename=ProductionEstimationtimetakenReports.xls");
                    echo $productionData;
                    exit;
                }

                

                $this->set('Production_dashboard', $arrayResult);
//                $this->set('timeDetails', $timeDetails);
            }
        } else {
            $this->set('Production_dashboard', $arrayResult);
//            $this->set('timeDetails', $timeDetails);
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

    function ajaxstatus() {
        echo $module = $this->ProductionDashBoards->find('statuslist', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

    function getusergroupdetails() {

        $session = $this->request->session();
        echo $module = $this->ProductionDashBoards->find('usergroupdetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserId' => $session->read('user_id')]);
        exit;
    }

    function getresourcedetails() {

        $session = $this->request->session();
        echo $module = $this->ProductionestimationReports->find('resourcedetails', ['ProjectId' => $_POST['projectId'], 'UserGroupId' => $_POST['userGroupId'], 'RegionId' => $_POST['regionId']]);
        exit;
    }

    public function ajaxProject() {
        $session = $this->request->session();
        $sessionProjectId = $session->read("ProjectId");
        $userid = $session->read('user_id');
        set_time_limit(0);
        $MojoProjectIds = $this->projectmasters->find('Projects');
        //$this->set('Projects', $ProListFinal);
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->ProductionDashBoards->find('ajaxProjectNameList', ['proId' => $is_project_mapped_to_user, 'ClientId' => $_POST['ClientId'], 'RegionId' => $_POST['RegionId']]);
        echo $ProList;
        exit;
    }

}
