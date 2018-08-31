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

class QcerrorsReportController extends AppController {

    /**
     * to initialize the model/utilities gonna to be used this page
     */
    public $paginate = [
        'limit' => 10,
        'order' => [
            'Id' => 'asc'
        ]
    ];
    public $RegionId = 1011;

    public function initialize() {
        parent::initialize();
        $this->loadModel('ProductionView');
        $this->loadModel('projectmasters');
        $this->loadModel('GetJob');
        $this->loadModel('ProductionDashBoards');
        $this->loadComponent('RequestHandler');
    }

    public function index() {

        $session = $this->request->session();
        $userid = $session->read('user_id');

        $MojoProjectIds = $this->projectmasters->find('Projects');
        //$this->set('Projects', $ProListFinal);
        $connection = ConnectionManager::get('default');
        $Cl_listarray = $connection->execute("select Id,ClientName FROM ClientMaster")->fetchAll('assoc');
        $Cl_list = array('0' => '--Select--');
        foreach ($Cl_listarray as $values):
            $Cl_list[$values['Id']] = $values['ClientName'];
        endforeach;
        $this->set('Clients', $Cl_list);

        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->ProductionView->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');
        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;
        $this->set('Projects', $ProListFinal);

        if (count($ProListFinal) == 2) {
            $ProjectId = $this->request->data['ProjectId'] = array_keys($ProListFinal)[1];
        }

        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $region = $regionMainList = $contentArr['RegionList'];
        $user_list = $contentArr['UserList'];
        $status_list = $contentArr['ProjectStatus'];
        $ProdDB_PageLimit = $contentArr['ProjectConfig']['ProdDB_PageLimit'];
        $module = $contentArr['Module'];
        $ModuleStatus = $contentArr['ModuleStatus'];
        $ModuleUser = $contentArr['ModuleUser'];
        $domainId = $contentArr['ProjectConfig']['DomainId'];
        $moduleConfig = $contentArr['ModuleConfig'];
        $status_list_module = $contentArr['ModuleStatusList'];
        $module_ids = array_keys($status_list_module);
        $array_with_lcvalues = array_map('strtolower', $status_list);

        asort($status_list);
        $this->set('ProdDB_PageLimit', $ProdDB_PageLimit);
        $this->set('region', $region);
        // $this->set('User', $user_list);
        $this->set('Users', $user_lists);
        $this->set('Statusid', $status_list);
        $this->set('module', $module);
        $this->set('moduleConfig', $moduleConfig);
        $this->set('ModuleStatus', $ModuleStatus);
        $this->set('status_list_module', $status_list_module);
        $this->set('module_ids', $module_ids);
        //pr($ModuleUser[142]);
        //$Domain_id=$this->Session->read("UniqueField.DOMAIN_ID.AttributeMasterId");
        $this->set(compact('contentArr'));


        if (isset($this->request->data['ProjectId']))
            $this->set('ProjectId', $this->request->data['ProjectId']);
        else
            $this->set('ProjectId', 0);


        $this->set('RegionId', $this->RegionId);

        $this->set('CallUserGroupFunctions', '');
        if (count($ProListFinal) == 2 && count($regionMainList) == 1 && !isset($this->request->data['RegionId'])) {
            $this->set('CallUserGroupFunctions', 'yes');
        }

        $ClientId = 0;
        if (isset($this->request->data['ClientId'])) {
            $ClientId = $this->request->data['ClientId'];
            $this->set('ClientId', $ClientId);
        } else {
            $this->set('ClientId', 0);
        }


        if (isset($this->request->data['ModuleId'])) {
            $Modules = $this->ProductionView->find('module', ['ProjectId' => $this->request->data['ProjectId'], 'ModuleId' => $this->request->data['ModuleId']]);
            $this->set('ModuleIds', $Modules);
        } else {
            $this->set('ModuleIds', 0);
        }

        if (isset($this->request->data['UserGroupId'])) {
            $UserGroup = $this->ProductionView->find('usergroupdetails', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $this->request->data['UserGroupId']]);
            $this->set('UserGroupId', $UserGroup);
            $UserGroupId = $this->request->data('UserGroupId');
        } else {
            $UserGroupId = '';
            $this->set('UserGroupId', '');
        }

        if (isset($this->request->data['ModuleId'])) {
            $selstatus = $this->ProductionView->find('statuslist', ['ProjectId' => $this->request->data['ProjectId'], 'ModuleId' => $this->request->data['ModuleId'], 'status' => $this->request->data['status']]);
            //pr($selstatus);
            $this->set('selstatus', $selstatus);
        } else {
            $this->set('selstatus', '');
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
        $conditions = '';


        if (isset($this->request->data['check_submit']) || isset($this->request->data['downloadFile'])) {

            $user_id_list = $this->ProductionView->find('resourceDetailsArrayOnly', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $this->request->data['UserGroupId']]);
            $this->set('User', $user_id_list);

            $session = $this->request->session();
            $ProjectId = $this->request->data('ProjectId');

            $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $region = $contentArr['RegionList'];
            $user_list = $contentArr['UserList'];
            $user_group = $contentArr['UserGroups'];

            if (!empty($ClientId)) {
                $subject = $Cl_list[$ClientId] . " " . $contentArr[$ProjectId];
            } else {
                $subject = $contentArr[$ProjectId];
            }


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
            asort($status_list);
            $this->set('ProdDB_PageLimit', $ProdDB_PageLimit);
            $this->set('status_list_module', $status_list_module);
            $this->set('module_ids', $module_ids);
            $this->set('region', $region);
            $this->set('UserGroup', $user_group);
            $this->set('Users', $user_lists);
            $this->set('Statusid', $status_list);
            $this->set('module', $module);
            $this->set('moduleConfig', $moduleConfig);
            $this->set('ModuleStatus', $ModuleStatus);
            $RegionId = $this->request->data('RegionId');
            $batch_from = $this->request->data('batch_from');
            $batch_to = $this->request->data('batch_to');
            $selected_month_first = strtotime($batch_to);
            $month_start = date('Y-m-d', strtotime('first day of this month', $selected_month_first));
            $selected_month_last = strtotime($batch_from);
            $month_end = date('Y-m-d', strtotime('last day of this month', $selected_month_last));
            $user_id = $this->request->data('user_id');
            $status = $this->request->data('status');
            $query = $this->request->data('query');
            $ModuleId = $this->request->data('ModuleId');
            $this->set('ModuleId', $ModuleId);


            if (empty($user_id)) {
                $user_id = array_keys($user_id_list);
            }
            if (empty($user_id)) {
                $this->Flash->error(__('No UserId(s) found for this UserGroup combination!'));
                $ShowErrorOnly = TRUE;
            }

            if ($ShowErrorOnly) {
                
            } else {

                $conditions_status = '';
                $conditions_timemetric = '';

                $QueryDateFrom = $batch_from;
                $QueryDateTo = $batch_to;
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

                if ($batch_from != '' && $batch_to != '') {
                    $conditions.=" AND meptm.Start_Date >='" . date('Y-m-d', strtotime($batch_from)) . " 00:00:00' AND meptm.Start_Date <='" . date('Y-m-d', strtotime($batch_to)) . " 23:59:59'";
                }
                if ($batch_from != '' && $batch_to == '') {
                    $conditions.=" AND meptm.Start_Date >='" . date('Y-m-d', strtotime($batch_from)) . " 00:00:00' AND meptm.Start_Date <='" . date('Y-m-d', strtotime($batch_from)) . " 23:59:59'";
                }
                if ($batch_from == '' && $batch_to != '') {
                    $conditions.=" AND meptm.Start_Date >='" . date('Y-m-d', strtotime($batch_to)) . " 00:00:00' AND meptm.Start_Date <='" . date('Y-m-d', strtotime($batch_to)) . " 23:59:59'";
                }
                if ((count($user_id) == 1 && $user_id[0] > 0) || (count($user_id) > 1)) {
                    $conditions_timemetric.=' AND meptm.UserId IN(' . implode(",", $user_id) . ')';
                }

//                if ($ModuleId != '') {
//                    $conditions_timemetric.='AND Module_Id IN(' . $ModuleId . ')';
//                }
                //    echo $conditions;
//                if (!empty($status) && count($status) > 0) {
//                  
//                    $conditions.=' AND StatusId IN(' . implode(",", $status) . ')';
//                    $conditions_status.=' AND StatusId IN(' . implode(",", $status) . ')';
//                } else {
//                    $conditions.=" AND StatusId in (" . implode(',', array_keys($status_list)) . ")";
//                    $conditions_status.=" AND StatusId in (" . implode(',', array_keys($status_list)) . ")";
//                }
//                if ($query != '') {
//                    $conditions.= " AND [" . $domainId . "] LIKE '%" . $query . "%' ";
//                    $conditions_status.= " AND [" . $domainId . "] LIKE '%" . $query . "%' ";
//                }
                // query  

                $queryData = $connection->execute("SELECT Id FROM MC_DependencyTypeMaster where ProjectId='$ProjectId' and FieldTypeName='General' ")->fetchAll('assoc');
                $DependencyTypeMasterId = $queryData[0]['Id'];

                $domainAttrid = "rpem.[$domainId]";

//                Languages
//                $ModuleId = 6694018;
                $production = $contentArr['ModuleAttributes'][$this->RegionId][$ModuleId]['production'];
                $Attributetitle = $contentArr['AttributeGroupMaster'][$ModuleId];
                $this->set('Attributetitle', $Attributetitle);

                // Get language prepare 
                $getlanguAttrid = $this->searchForattrId("Languages", $production);
                $getlanguAttrids = "";
                $getlanguAttridwhere = "";
                if (!empty($getlanguAttrid)) {
                    $getlanguAttrids = "[$getlanguAttrid] as lng";
                    $getlanguAttridwhere = " and [$getlanguAttrid] is not null";
                }

                // get abstract module id 
                $abstmoduleIdtxt = "Abstraction";
                $modules = $contentArr['Module'];
                $abstructModuleId = array_search($abstmoduleIdtxt, $modules);

//                $months = array();
//                $months[0] = '_6_2018';
//                $months[1] = '_6_2018';


                $MV_QC_Comments = "MV_QC_Comments";
                $arrayResult = array();

                foreach ($months as $keymonth => $mon) {

                    $Report_ProductionEntityMaster = "Report_ProductionEntityMaster" . $mon;
                    $Report_ProductionTimeMetric = "Report_ProductionTimeMetric" . $mon;
                    $ME_Production_TimeMetric = "ME_Production_TimeMetric" . $mon;


                    // get columns & check language columns exist
                    $ColumnNames = $connection->execute("SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS  where TABLE_NAME='$Report_ProductionEntityMaster' and ISNUMERIC(COLUMN_NAME) = 1")->fetchAll('assoc');
                    $allowtoGetlanguage = 0;
                    if (in_array($getlanguAttrid, array_column($ColumnNames, "COLUMN_NAME"))) {
                        $allowtoGetlanguage = 1;
                    }

                    $sql = "select (select smeptm.UserId from $ME_Production_TimeMetric as smeptm  where  smeptm.InputEntityId =rpem.InputEntityId and smeptm.Module_Id='$abstructModuleId') as abstUserId, $domainAttrid as fdrid,rpem.StatusId,rpem.ProductionEntityID,rpem.InputEntityId,meptm.Module_Id,meptm.Start_Date , meptm.End_Date,meptm.TimeTaken,meptm.UserId,meptm.QCEndDATE  from $Report_ProductionEntityMaster as rpem inner join $ME_Production_TimeMetric as meptm on  meptm.InputEntityId =rpem.InputEntityId where rpem.ProjectId = '$ProjectId' AND rpem.DependencyTypeMasterId='$DependencyTypeMasterId' and meptm.Module_Id='$ModuleId' $conditions_timemetric $conditions";

                    $getresult = $connection->execute($sql)->fetchAll('assoc');

                    if (!empty($getresult)) {

                        foreach ($getresult as $key => $val) {

                            $InputEntityId = $val['InputEntityId'];
                            // check column exist in table
                            if (!empty($allowtoGetlanguage)) {
                                $sql = "select $getlanguAttrids from $Report_ProductionEntityMaster where ProjectId = '$ProjectId' and InputEntityId=$InputEntityId $getlanguAttridwhere  ";
                                $getresultlng = $connection->execute($sql)->fetchAll('assoc');
                                $getresult[$key]['language'] = $getresultlng[0]['lng'];
                            } else {
                                $getresult[$key]['language'] = "";
                            }
                            // get subject values 
                            $getresult[$key]['subject'] = $subject;
                            $getresult[$key]['ProjectStatus'] = $contentArr['ProjectStatus'][$val['StatusId']];
                            $getresult[$key]['quality'] = '';
                            $getresult[$key]['UserName'] = $user_list[$val['UserId']];
                            $getresult[$key]['abstUserName'] = $user_list[$val['abstUserId']];

                            // Get campain error calc -  attribute master id 
                            $arrayAttrbuteslist = array();
                            foreach ($Attributetitle as $k => $v) {
                                $arrayAttrbuteslist['title'] = $v;
                                $arrayAttrbuteslist['key'] = $k;
                                $SubattributeMasterid = $this->searchForId($k, $production);
                                $cnt = 0;
                                if (!empty($SubattributeMasterid)) {
                                    $sql = "select count(Id) as cnt from $MV_QC_Comments where InputEntityId = '$InputEntityId' and AttributeMasterId IN ($SubattributeMasterid)";
                                    $getresultcnt = $connection->execute($sql)->fetchAll('assoc');
                                    $cnt = $getresultcnt[0]['cnt'];
                                }
                                $arrayAttrbuteslist['count'] = $cnt;
                                $getresult[$key]['attr'][] = $arrayAttrbuteslist;
                            }
                            // Totalerrors
                            $getresult[$key]['Totalerrors'] = array_sum(array_column($getresult[$key]['attr'], 'count'));
                            $getresult[$key]['Totalfields'] = "";
                        }
                        $arrayResult = array_merge($arrayResult, $getresult);
                    }
                }

//                echo "<pre>s";
//                print_r($arrayResult);
//                exit;
                if (isset($this->request->data['downloadFile'])) {

                    $productionData = '';
                    $productionData = $this->QcerrorsReport->getExportData($arrayResult, $Attributetitle);
                    $this->layout = null;
                    if (headers_sent())
                        throw new Exception('Headers sent.');
                    while (ob_get_level() && ob_end_clean());
                    if (ob_get_level())
                        throw new Exception('Buffering is still active.');
                    header("Content-type: application/vnd.ms-excel");
                    header("Content-Disposition:attachment;filename=QcErrorsReport.xls");
                    echo $productionData;
                    exit;
                }


                if (empty($arrayResult)) {
                    $this->Flash->error(__('No Record found for this combination!'));
                }
                $this->set('result', $arrayResult);
            }
        }
    }

    function searchForId($id, $array) {
        $attrid = array();
        foreach ($array as $key => $val) {
            if ($val['MainGroupId'] === $id) {
                $attrid[] = $val['AttributeMasterId'];
            }
        }

        if (!empty($attrid)) {
            $attr = implode(",", $attrid);
            return $attr;
        }

        return 0;
    }

    function searchForattrId($id, $array) {
        $attrid = array();
        foreach ($array as $key => $val) {
            if (trim($val['AttributeName']) == trim($id)) {
                return $val['AttributeMasterId'];
            }
        }
        return 0;
    }

    function ajaxqueryposing() {
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $ProjectId = $session->read("ProjectId");
        $moduleId = $session->read("moduleId");
        echo $_POST['query'];
        $file = $this->ProductionView->find('querypost', ['ProductionEntity' => $_POST['InputEntyId'], 'query' => $_POST['query'], 'ProjectId' => $ProjectId, 'moduleId' => $moduleId, 'user' => $user_id]);
        exit;
    }

    function ajaxloadresult() {
        $session = $this->request->session();
        $ProjectId = $session->read("ProjectId");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $Region = $_POST['Region'];
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

    function ajaxregion() {
        echo $region = $this->ProductionView->find('region', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

    function ajaxmodule() {
        echo $module = $this->ProductionView->find('module', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'ModuleId' => $ModuleId]);
        exit;
    }

    function getusergroupdetails() {
        $session = $this->request->session();
        echo $module = $this->ProductionView->find('usergroupdetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserId' => $session->read('user_id')]);
        exit;
    }

    function getresourcedetails() {
        $session = $this->request->session();
        echo $module = $this->ProductionView->find('resourcedetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserGroupId' => $_POST['userGroupId']]);
        exit;
    }

    function ajaxstatus() {
        echo $module = $this->ProductionView->find('statuslist', ['ProjectId' => $_POST['ProjectId'], 'ModuleId' => $_POST['ModuleId']]);
        exit;
    }

    function ajaxgetdatahand() {
        $session = $this->request->session();
        $moduleIdHandson = $session->read("moduleIdHandson");
        $InputEntityIdHandson = $session->read("InputEntityIdHandson");
        $tableHandson = $session->read("tableHandson");
        $ProjectIdHandson = $session->read("ProjectIdHandson");
        $ProjectId = $ProjectIdHandson;
        $moduleId = $moduleIdHandson;
        $InputEntityId = $InputEntityIdHandson;
        $tablenamemonth = "Report_ProductionEntityMaster_$tableHandson";
        $tabledomainurlmonth = "ME_DomainUrl_$tableHandson";

        $connection = ConnectionManager::get('default');
        $user_id = $session->read("user_id");
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        //$moduleId = $session->read("moduleId");
        $stagingTable = 'Staging_' . $moduleId . '_Data';
        $first_Status_name = $JsonArray['ModuleStatusList'][$moduleId][0];
        $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);

        $next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][0];
        $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];
        $link = $connection->execute("SELECT * FROM $tablenamemonth WHERE InputEntityId=" . $InputEntityId)->fetchAll('assoc');
        $RegionId = $link[0]['RegionId'];

        $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['production'];
        $ReadOnlyFields = $JsonArray['ModuleAttributes'][$RegionId][$moduleId]['readonly'];
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

    public function ajaxProject() {
        $session = $this->request->session();
        $sessionProjectId = $session->read("ProjectId");
        $userid = $session->read('user_id');
        set_time_limit(0);
        $MojoProjectIds = $this->projectmasters->find('Projects');
        //$this->set('Projects', $ProListFinal);

        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->QcerrorsReport->find('ajaxProjectNameList', ['proId' => $is_project_mapped_to_user, 'ClientId' => $_POST['ClientId'], 'RegionId' => $_POST['RegionId']]);
        echo $ProList;
        exit;
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

}
