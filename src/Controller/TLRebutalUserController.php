<?php

/*
 * Form : TL Rebutal
 * Developer: SyedIsmail N
 * Created On: SEP 12 2017
 *
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class TLRebutalUserController extends AppController {

    public $paginate = [
        'limit' => 10,
        'order' => [
            'Id' => 'asc'
        ]
    ];

    public function initialize() {
        parent::initialize();
        $this->loadModel('TLRebutalUser');
        $this->loadModel('projectmasters');
        $this->loadComponent('RequestHandler');
    }

    public function index() {

        $session = $this->request->session();
        $userid = $session->read('user_id');

        $MojoProjectIds = $this->projectmasters->find('Projects');
        //$this->set('Projects', $ProListFinal);
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->TLRebutalUser->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');
        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;
        //$ProListFinal = ['0' => '--Select Project--', '2278' => 'ADMV_YP'];
        $this->set('Projects', $ProListFinal);

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

        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $region = $regionMainList = $contentArr['RegionList'];
        $regionId = array_keys($region);
        $status_list = $contentArr['ProjectGroupStatus'][ProjectStatusProduction];
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

        $second_condition_status_list = $completed_status_ids = [];
        foreach ($status_list as $keystat => $stat) {
            $posCompleted = strpos(strtolower($stat), 'completed');
            if ($posCompleted === false) {
                $second_condition_status_list[$keystat] = $stat;
            } else {
                $completed_status_ids[] = $keystat;
            }
        }

        $this->set('ProdDB_PageLimit', $ProdDB_PageLimit);
        $this->set('status_list_module', $status_list_module);
        $this->set('module_ids', $module_ids);
        $this->set('region', $region);
        $this->set('regionId', $regionId[0]);
        $this->set('Status', $status_list);
        $this->set('module', $module);
        $this->set('moduleConfig', $moduleConfig);
        $this->set('ModuleStatus', $ModuleStatus);

        if (isset($this->request->data['ProjectId']) || isset($this->request->data['RegionId'])) {
            $region = $this->TLRebutalUser->find('region', ['ProjectId' => $this->request->data['ProjectId'], 'RegionId' => $this->request->data['RegionId'], 'SetIfOneRow' => 'yes']);
            $this->set('RegionId', $region);
        } else {
            $this->set('RegionId', 0);
        }

        $this->set('CallUserGroupFunctions', '');
        if (count($ProListFinal) == 2 && count($regionMainList) == 1 && !isset($this->request->data['RegionId'])) {
            $this->set('CallUserGroupFunctions', 'yes');
        }
        if (isset($this->request->data['ModuleId'])) {
            $Modules = $this->TLRebutalUser->find('module', ['ProjectId' => $this->request->data['ProjectId'], 'ModuleId' => $this->request->data['ModuleId']]);
            $this->set('ModuleIds', $Modules);
        } else {
            $this->set('ModuleIds', 0);
        }
        if (isset($this->request->data['UserGroupId'])) {
            $UserGroup = $this->TLRebutalUser->find('usergroupdetails', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $this->request->data['UserGroupId']]);
            $this->set('UserGroupId', $UserGroup);
            $UserGroupId = $this->request->data('UserGroupId');
        } else {
            $UserGroupId = '';
            $this->set('UserGroupId', '');
        }

        if (isset($this->request->data['load_data'])) {
            $this->TLRebutalUser->getLoadData();
            $this->Flash->success(__('Load has been completed!'));
            return $this->redirect(['action' => 'index']);
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
        
        //------jobs shall Move to PU--------//
        if(isset($this->request->data['Submit'])){
            $session = $this->request->session();
            $TLRebutalCommentsDetail = $this->TLRebutalUser->find('rebutalStatus', ['data' => $this->request->data(), 'UserId' => $session->read('user_id')]);
            $status='JOB Moved TO PU';
            $this->Flash->success(__($status));
        }

        if(isset($this->request->data['updateTLComments'])){
            $session = $this->request->session();
            $this->set('hideval', '1');
            $TLRebutalCommentsDetail = $this->TLRebutalUser->find('rebutal', ['data' => $this->request->data(), 'UserId' => $session->read('user_id')]);
            if($this->request->data['cmdStatus']==2)
                $status='JOB Moved TO PU';
            if($this->request->data['cmdStatus']==3)
                $status='JOB Moved TO QC';
            $this->Flash->success(__($status));
        }

        if (isset($this->request->data['check_submit'])) {
            $conditions = '';
            $ProjectId = $this->request->data('ProjectId');
            $RegionId = $this->request->data('RegionId');
            $UserGroupId = $this->request->data('UserGroupId');
            $ModuleId = $this->request->data('ModuleId');
            $batch_from = $this->request->data('batch_from');
            $batch_to = $this->request->data('batch_to');
            $selected_month_first = strtotime($batch_to);
            $month_start = date('Y-m-d', strtotime('first day of this month', $selected_month_first));
            $selected_month_last = strtotime($batch_from);
            $month_end = date('Y-m-d', strtotime('last day of this month', $selected_month_last));
            $this->set('ModuleIdVal', $ModuleId);
            $this->set('UserGroupIdVal', $UserGroupId);
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

                $conditions.="  QcStartDate >='" . date('Y-m-d', strtotime($batch_from)) . " 00:00:00' AND QcStartDate <='" . date('Y-m-d', strtotime($batch_to)) . " 23:59:59'";

                if ((count($user_id) == 1 && $user_id[0] > 0) || (count($user_id) > 1)) {
                    $conditions_timemetric.=' AND UserId IN(' . implode(",", $user_id) . ')';
                }
                $conditions.=" AND QcStatusId = 1";
                $conditions_status.=" AND QcStatusId = 1";
                
                $TLRebutalUserDetail = $this->TLRebutalUser->find('users', ['condition' => $conditions, 'conditions_timemetric' => $conditions_timemetric, 'Project_Id' => $ProjectId, 'domainId' => $domainId, 'RegionId' => $RegionId, 'Module_Id' => $ModuleId, 'batch_from' => $batch_from, 'batch_to' => $batch_to, 'conditions_status' => $conditions_status, 'UserGroupId' => $UserGroupId, 'UserId' => $user_id, 'AttributeIds' => $attributeIds]);
                $i = 0;
                $TLRebutalUser_detail = array();
                foreach ($TLRebutalUserDetail as $TLRebutalUser):
                    $TLRebutalUser_detail[$i]['Id'] = $TLRebutalUser['Id'];
                    $TLRebutalUser_detail[$i]['ProjectId'] = $TLRebutalUser['ProjectId'];
                    $TLRebutalUser_detail[$i]['RegionId'] = $TLRebutalUser['RegionId'];
                    $TLRebutalUser_detail[$i]['QCUSerID'] = $TLRebutalUser['QCUSerID'];
                    $TLRebutalUser_detail[$i]['InputEntityId'] = $TLRebutalUser['InputEntityId'];
                    $TLRebutalUser_detail[$i]['AttributeMasterId'] = $TLRebutalUser['AttributeMasterId'];
                    $TLRebutalUser_detail[$i]['ProjectAttributeMasterId'] = $TLRebutalUser['ProjectAttributeMasterId'];
                    $TLRebutalUser_detail[$i]['DomainId'] = $TLRebutalUser['DomainId'];
                    $TLRebutalUser_detail[$i]['DomainUrl'] = $TLRebutalUser['DomainUrl'];
                    $TLRebutalUser_detail[$i]['UserId'] = $TLRebutalUser['UserId'];
                    $i++;
                endforeach;

                if (empty($TLRebutalUser_detail)) {
                    $this->Flash->error(__('No Record found for this combination!'));
                }

                $this->set('TLRebutalUser_detail', $TLRebutalUser_detail);
                $this->set('contentArr', $contentArr);
            
        }  else {
            $this->set('TLRebutalUser_detail', $TLRebutalUser_detail);
        }
    }

    function ajaxregion() {
        echo $region = $this->TLRebutalUser->find('region', ['ProjectId' => $_POST['projectId']]);
        exit;
    }
    
    function ajaxmodule() {
        echo $module = $this->TLRebutalUser->find('module', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'ModuleId' => $ModuleId]);
        exit;
    }

    function ajaxstatus() {
        echo $module = $this->TLRebutalUser->find('statuslist', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

    function getusergroupdetails() {
        $session = $this->request->session();
        echo $module = $this->TLRebutalUser->find('usergroupdetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserId' => $session->read('user_id')]);
        exit;
    }

    function getresourcedetails() {
        $session = $this->request->session();
        echo $module = $this->TLRebutalUser->find('resourcedetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserGroupId' => $_POST['userGroupId']]);
        exit;
    }

    function ajaxgetcommands() {
        echo $getcomments = $this->TLRebutalUser->find('getcommands', ['ID' => $_POST['ID'], 'InputEntityId' => $_POST['InputEntityId'], 'RegionId' => $_POST['RegionId'], 'ProjectId' => $_POST['ProjectId']]);
        exit;
    }
    
    function ajaxgetnext() {
        echo $getcomments = $this->TLRebutalUser->find('getnext', ['ID' => $_POST['ID'], 'InputEntityId' => $_POST['InputEntityId'], 'RegionId' => $_POST['RegionId'], 'ProjectId' => $_POST['ProjectId']]);
        exit;
    }
    
    function ajaxmovetopu() {
        echo $movetopu = $this->TLRebutalUser->find('movetopu', ['InputEntityId' => $_POST['InputEntityId']]);
        exit;
    }
}
