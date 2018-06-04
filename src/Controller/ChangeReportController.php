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
use Cake\Network\Exception\NotFoundException;
class ChangeReportController extends AppController {

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
        $this->loadModel('ChangeReport');
        $this->loadModel('projectmasters');
        $this->loadComponent('RequestHandler');
    }

    public function index() {

        $session = $this->request->session();
        $ProjectId = $session->read('ProjectId');
        $userid = $session->read('user_id');
        
        $MojoProjectIds = $this->projectmasters->find('Projects');
        //$this->set('Projects', $ProListFinal);
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->ChangeReport->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');
        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;
        $this->set('Projects', $ProListFinal);


        $session = $this->request->session();
        $project_id = $session->read('ProjectId');


        $path = JSONPATH . '\\ProjectConfig_' . $project_id . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $user_list = $contentArr['UserList'];
        $status_list = $contentArr['ProjectStatus'];
        
        $module=$contentArr['Module'];
        asort($status_list);

        $this->set('User', array());
        //$this->set('User', $user_list);
        $this->set('Users', $user_lists);
        $this->set('Status', $status_list);
        $this->set('module', $module);
        
        if (isset($this->request->data['ProjectId']))
            $this->set('ProjectId', $this->request->data['ProjectId']);
        else
            $this->set('ProjectId', 0);
      
        if (isset($this->request->data['RegionId'])){
            $region = $this->ChangeReport->find('region', ['ProjectId' => $this->request->data['ProjectId'],'RegionId' => $this->request->data['RegionId']]);
            $this->set('RegionId', $region);
        }
        else{
            $this->set('RegionId', 0);
        }
        
        if (isset($this->request->data['UserGroupId'])) {
            $UserGroup = $this->ChangeReport->find('usergroupdetails', ['ProjectId' => $_POST['ProjectId'],'RegionId' => $_POST['RegionId'],'UserId' => $session->read('user_id'), 'UserGroupId' => $this->request->data['UserGroupId']]);
            $this->set('UserGroupId', $UserGroup);
            $UserGroupId = $this->request->data('UserGroupId');
        } else {
            $UserGroupId = '';
            $this->set('UserGroupId','');
        }
        
        if (isset($this->request->data['status'][0]))
            $this->set('poststatus', $this->request->data['status'][0]);
        else
            $this->set('poststatus', 0);

        if (isset($this->request->data['batch_to']))
            $this->set('postbatch_to', $this->request->data['batch_to']);
        else
            $this->set('postbatch_to', '');

        if (isset($this->request->data['batch_from']))
            $this->set('postbatch_from', $this->request->data['batch_from']);
        else
            $this->set('postbatch_from', '');

        if (isset($this->request->data['user_id'][0]))
            $this->set('postuser_id', $this->request->data['user_id'][0]);
        else
            $this->set('postuser_id', 0);
        
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
        if (isset($this->request->data['Allocate'])) {
            $Update = $this->ProductionDashboards->UpdateUserId($this->request->data, $this->Session->read("user_id"));
            $this->Session->setFlash('Reallocation Successfully Done!', 'flash_good');
        }
        
        if (isset($this->request->data['check_submit'])) {
            
            $user_id_list = $this->ChangeReport->find('resourceDetailsArrayOnly', ['ProjectId' => $_POST['ProjectId'],'RegionId' => $_POST['RegionId'],'UserId' => $session->read('user_id'), 'UserGroupId' => $this->request->data['UserGroupId']]);
            $this->set('User', $user_id_list);
            $ProjectId = $this->request->data('ProjectId');
            $RegionId = $this->request->data('RegionId');
            $batch_from = $this->request->data('batch_from');
            $batch_to = $this->request->data('batch_to');
            $UserId = $this->request->data('user_id');
            $UserGroupId = $this->request->data('UserGroupId');
            $status = $this->LastStatus($ProjectId);
            $query = $this->request->data('query');
            
            
            $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $modules = $contentArr['Module'];
            $modulesConfig = $contentArr['ModuleConfig'];
            $user_list = $contentArr['UserList'];
            $modulesArr = array();
            foreach ($modules as $key => $val) {
                if ($modulesConfig[$key]['IsUrlMonitoring'] == 1) {
                    $modulesArr[$key] = $val;
                }
            }
            $ModuleId = key($modulesArr);
            
            if(empty($UserId)) {
                $UserId = array_keys($user_id_list);
            }
            
            $conditions.=" PTM.ProjectId ='$ProjectId'";
            if ($batch_from != '' && $batch_to != '') {
                $conditions.="  AND ProductionStartDate >='". date('Y-m-d', strtotime($batch_from)) . " 00:00:00' AND ProductionEndDate <='". date('Y-m-d', strtotime($batch_to)) . " 23:59:59'";
            }
            if ($batch_from != '' && $batch_to == '') {
                $conditions.="  AND  ProductionStartDate  >='". date('Y-m-d', strtotime($batch_from)) . " 00:00:00' AND ProductionStartDate <='". date('Y-m-d', strtotime($batch_from)) . " 23:59:59'";
            }
            if ($batch_from == '' && $batch_to != '') {
                $conditions.="  AND  ProductionEndDate >='". date('Y-m-d', strtotime($batch_to)) . " 00:00:00' AND ProductionEndDate <='". date('Y-m-d', strtotime($batch_to)) . " 23:59:59'";
            }
            if (!empty($status) && count($status) > 0) {
                $conditions.=' AND StatusId IN('.$status. ')';
            }
            if ((count($UserId) == 1 && $UserId[0] > 0) || (count($UserId) > 1)) {
                $conditions.=' AND UserId IN(' . implode(",", $UserId) . ')';
            }
            $conditions.=' AND IsChanged=1 ';
        $session = $this->request->session();
        $project_id = $ProjectId;
       
        
        $outputMapping=$this->ChangeReport->find('getmapping',['Project_Id' => $ProjectId, 'Region_Id' => $RegionId,'attOrder'=>$attOrder]);
        //pr($outputMapping);
        $header_fields=$outputMapping[0];
        
        $select_fields=$outputMapping[1]['Fields'];
        $Head=array('[Start_Date],[End_Date],[TimeTaken]');
        $select_fields=  array_merge($select_fields,$Head);
        
        //pr($select_fields); die;
        $userOrderId = $outputMapping[1]['UserId']['Order'];
        $ExportProductions = $this->ChangeReport->find('users', ['condition' => $conditions, 'Project_Id' => $ProjectId, 'Region_Id' => $RegionId, 'Module_Id' => $ModuleId, 'batch_from' => $batch_from, 'batch_to' => $batch_to, 'conditions_status' => $conditions_status,'select_fields'=>$select_fields, 'UserGroupId' => $UserGroupId, 'UserId' => $user_id]);
        
        $ExportProduction = $ExportProductions[0];
        $ExportUserGroupName = $ExportProductions[1];
        $ExportProduction = $ExportProduction->fetchAll('assoc'); 
        //$ExportUserGroupName = $ExportUserGroupName->fetchAll('assoc'); 
        //pr($user_list); die;

        $data='';
        $HeaderFields=implode('*',$header_fields);
        if(!empty($ExportProduction))     
        {
         $data=$HeaderFields;
         $data.= PHP_EOL;
            foreach($ExportProduction as $val)
                {
                    $i=1;
                    foreach($val as $val2)
                    {
                        //echo $i."------".$userOrderId."-------------<br>";
                        if(isset($userOrderId) && $i==$userOrderId)
                        {
                            foreach ($modules as $key => $vals) {
                                if ($modulesConfig[$key]['IsUrlMonitoring'] == 1) {
                                    $data.= $user_list[$val['UserId']]."*";
                                    $data.= $ExportUserGroupName[$val['UserId']] . "*";
                                }
                            }
                        }
                        else if(isset($QcuserOrderId) && $i==$QcuserOrderId)
                        {
                            $data.= $user_list[$val2] . "*";
                        }
                        else
                        {
                            if($val2!=''){
                                $data.= $this->textarea_slash($val2) . "*";
                            }else{
                                $data.= $val2 . "*";
                            }
                        }
                    $i++;    
                    }
                    $data.= PHP_EOL;
                }
                $data = rtrim($data,'*');
                $data.= PHP_EOL;
//                pr($data);
//                exit;
                if (headers_sent()) {echo 'header sent';}
		while (ob_get_level() && ob_end_clean());
                if (ob_get_level()) {echo 'Buffering is still active.';};
		/* header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=Export_Output.xls"); */
		//echo chr(255) . chr(254) . mb_convert_encoding($data, 'UTF-16LE', 'UTF-8');
		header("Content-type: text/plain;charset=utf-8");
		header("Content-Disposition:attachment;filename=Change_Report.txt");
		echo iconv("UTF-8", "UTF-8",$data);
		/* echo iconv("UTF-8", "ISO-8859-1//TRANSLIT",$data); */
		 exit;
    }else{
        $this->Flash->error(__('No Record found for this combination'));
     
    
        }
        
       }
    }
    function ajaxregion() {
        echo $region = $this->ChangeReport->find('region', ['ProjectId' => $_POST['projectId']]);
        exit;
    }
    public function textarea_slash($content)
    {
        $content = trim($content);
        $content = str_replace('&amp;','&',$content);
        $content = preg_replace('/\n/',' ',$content);
        $content = ereg_replace(' +',' ',$content);
        $content = preg_replace("/\n/", "  ", trim($content));
        $content = preg_replace("/\t/", "  ", trim($content));
        $content = preg_replace("/\r/", "  ", trim($content));
        $content = preg_replace("/\"/", "'", trim($content));
        $content = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $content);
        return $content;
    }
    
    public function LastStatus($projectid) {
        //Get last module of this project
        $LastModuleId = $this->LastModule($projectid);
        // Get last status of this module
        $FinalStatus = $this->FinalStatus($LastModuleId,$projectid);

        return $FinalStatus;
    }
    
    public function LastModule($projectid) {
        $exec_read = sqlsrv_query($this->connection, "SELECT TOP 1 ModuleId FROM ME_Module_Level_Config WHERE Project=$projectid ORDER BY LevelId DESC");
        if ($exec_read) {
            while ($row = sqlsrv_fetch_array($exec_read, SQLSRV_FETCH_ASSOC)) {
                $Id = $row['ModuleId'];
            }
        }
        return $Id;
    }
    public function FinalStatus($module,$project_Id) {
    //$path='E:\xampp\htdocs\mojo_V2\JsonReferance\ProjectConfig_'.$project_Id.'.json';
    $path = JSONPATH . '\\ProjectConfig_' . $project_Id . '.json';
        $content=  file_get_contents($path);
        $JsonArray=  json_decode($content,true);
        $first_Status_name = $JsonArray['ModuleStatusList'][$module][count($JsonArray['ModuleStatusList'][$module])-1];
        $status=array_search($first_Status_name,$JsonArray['ProjectStatus']);
        return $status;
    }
    
    function getusergroupdetails() {
        $session = $this->request->session();
        echo $module = $this->UrlStatusReport->find('usergroupdetails', ['ProjectId' => $_POST['projectId'],'RegionId' => $_POST['regionId'],'UserId' => $session->read('user_id')]);
        exit;
    }
    
    function getresourcedetails() {
        $session = $this->request->session();
        echo $module = $this->UrlStatusReport->find('resourcedetails', ['ProjectId' => $_POST['projectId'],'RegionId' => $_POST['regionId'],'UserGroupId' => $_POST['userGroupId']]);
        exit;
    }

}
