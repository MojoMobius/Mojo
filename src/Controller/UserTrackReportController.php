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

class UserTrackReportController extends AppController {

    public $paginate = [
        'limit' => 10,
        'order' => [
            'Id' => 'asc'
        ]
    ];

    public function initialize() {
        parent::initialize();
        $this->loadModel('UserTrackReport');
        $this->loadModel('projectmasters');
        $this->loadComponent('RequestHandler');
    }

    public function index() {
        $session = $this->request->session();
        $sessionProjectId = $session->read("ProjectId");
        $userid = $session->read('user_id');
        set_time_limit(0);
        $MojoProjectIds = $this->projectmasters->find('Projects');
        
         $productionHours = ProductionHours;
        
        //$this->set('Projects', $ProListFinal);
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->UserTrackReport->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
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
                 $Clients = $this->UserTrackReport->find('client', ['ClientId' => $this->request->data['ClientId']]);
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

        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);        
        $region = $regionMainList = $contentArr['RegionList'];
       foreach($region as $key => $value){
           $sessionRegion = $key;
       }
       // echo $sessionRegion;exit;
//        $status_list = $contentArr['ProjectGroupStatus'][ProjectStatusProduction];
        //  $status_list = $contentArr['ProjectGroupStatus']['Production'];
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
        $UserList = $contentArr['UserList'];
        asort($status_list);
        $search_text='Query';
       // pr($status_list);
        foreach($status_list as $index => $string) {
       // echo $string;
        if (strpos($string, $search_text) !== FALSE){
             $queryStatus= $index;
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
        $this->set('UserList', $UserList);
//pr($completed_status_idsss); exit;
        if (isset($this->request->data['ProjectId']) || isset($this->request->data['RegionId'])) {
            $region = $this->UserTrackReport->find('region', ['ProjectId' => $this->request->data['ProjectId'], 'RegionId' => $this->request->data['RegionId'], 'SetIfOneRow' => 'yes']);
            $this->set('RegionId', $region);
        } else {
            $this->set('RegionId', 0);
        }

        $this->set('CallUserGroupFunctions', '');
        if (count($ProListFinal) == 2 && count($regionMainList) == 1 && !isset($this->request->data['RegionId'])) {
            $this->set('CallUserGroupFunctions', 'yes');
        }

        if (isset($this->request->data['UserGroupId'])) {
            $UserGroup = $this->UserTrackReport->find('usergroupdetails', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $this->request->data['UserGroupId']]);
            $this->set('UserGroupId', $UserGroup);
            $UserGroupId = $this->request->data('UserGroupId');
        } else {
            $UserGroupId = '';
            $this->set('UserGroupId', '');
        }
		
//       if(isset($this->request->data['reportSP_data']))
//        {
//            $this->UserTrackReport->SpRunFuncRPEMMonthWise();
//            $this->Flash->success(__('Report generate has been completed!'));
//            return $this->redirect(['action' => 'index']);
//        }


        if (isset($this->request->data['load_data'])) {
            $this->UserTrackReport->getLoadData();
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


		
        if (isset($this->request->data['check_submit']) || isset($this->request->data['downloadFile'])) {

            $CheckSPDone = $this->UserTrackReport->find('CheckSPDone', ['ProjectId' => $_POST['ProjectId']]);

            $conditions = '';
		
            if ($this->request->data['UserGroupId'] > 0) {
				
                $user_id_list = $this->UserTrackReport->find('resourceDetailsArrayOnly', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'],'UserGroupId' =>$this->request->data['UserGroupId'], 'UserId' => $session->read('user_id')]);
				
              
                $this->set('User', $user_id_list);
            }

            $batch_from = $this->request->data('batch_from');
            $batch_to = $this->request->data('batch_to');
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
//                foreach($AttributeOrder as $keys=>$values) {
//                    $attributeIds[] = $values['AttributeId'];
//                }

                $conditions_status = '';
                $conditions_timemetric = '';


                if ($batch_from != '' && $batch_to == '') {
                    $batch_to = $batch_from;
                }
                if ($batch_from == '' && $batch_to != '') {
                    $batch_from = $batch_to;
                }


                $conditions.="  StartTime >='" . date('Y-m-d', strtotime($batch_from)) . " 00:00:00' AND StartTime <='" . date('Y-m-d', strtotime($batch_to)) . " 23:59:59'";
                //$conditionsIs.="  ActStartDate >='" . date('Y-m-d', strtotime($batch_from)) . " 00:00:00' AND ActStartDate <='" . date('Y-m-d', strtotime($batch_to)) . " 23:59:59'";

                if ((count($user_id) == 1 && $user_id[0] > 0) || (count($user_id) > 1)) {
                    $conditions_timemetric.=' AND UserId IN(' . implode(",", $user_id) . ')';
                    //$conditions_status.=' AND b.[' . $ModuleId . '] IN(' . implode(",", $user_id) . ')';
                }

               

                if ($query != '') {
                    $conditions.= " AND DomainId LIKE '%" . $query . "%' ";
                    $conditions_status.= " AND DomainId LIKE '%" . $query . "%' ";
                }
				
                $ProductionDashboard = $this->UserTrackReport->find('users', ['condition' => $conditions, 'Module' => $ModuleStatus, 'conditionsIs' => $conditionsIs,'conditions_timemetric' => $conditions_timemetric, 'Project_Id' => $ProjectId, 'domainId' => $domainId, 'RegionId' => $RegionId, 'Module_Id' => $ModuleId, 'batch_from' => $batch_from, 'batch_to' => $batch_to, 'conditions_status' => $conditions_status, 'UserGroupId' => $UserGroupId, 'UserId' => $user_id, 'AttributeIds' => $attributeIds, 'CheckSPDone' => $CheckSPDone]);
              //  pr($ProductionDashboard);exit;
                if ($ProductionDashboard == 'RunReportSPError') {
                    $this->Flash->error(__("Please click 'Report Generate' button to generate results and search again."));
                    $this->set('RunReportSPError', 'RunReportSPError');
                } else {
                    $ProductionDashboardarr = $ProductionDashboard;
                 //   pr($ProductionDashboardarr); die;
                    $i = 0;
                    $Production_dashboard = array();
                    foreach ($ProductionDashboardarr as $Production):
                        $Production_dashboard[$i]['ClientName'] = $Production['ClientName'];
                        $Production_dashboard[$i]['InputEntityId'] = $Production['InputEntityId'];
                        $Production_dashboard[$i]['ProjectId'] = $Production['ProjectId'];
                        $Production_dashboard[$i]['DomainId'] = $Production['DomainId'];
                        $Production_dashboard[$i]['ModuleId'] = $Production['ModuleId'];
                        $Production_dashboard[$i]['Date'] = $Production['CreatedDate'];
                        $Production_dashboard[$i]['UserId'] = $Production['UserId'];

                        $datetime1   = $productionHours;
                        $exd1 = explode(":", $datetime1);
                        $PrSecs = $exd1[0] * 3600 + $exd1[1] * 60 + $exd1[2];
                     
                        $datetime2   = $Production['time'];
                        $ex = explode(".", $datetime2);
                        $res = $ex[0];
                        $ex = explode(":", $res);
                        $Imsecs = $ex[0] * 3600 + $ex[1] * 60 + $ex[2];

                        $interval = $PrSecs - $Imsecs;
                        $timediff =  gmdate("H:i:s", $interval);
                        
                        $Production_dashboard[$i]['Productiontime'] = $res;
                        $Production_dashboard[$i]['NonProductiontime'] = $timediff;
                      //  $ph = "convert(varchar(5),DateDiff(s, $productionHours, $Production_dashboard[$i]['time'])/3600)+':'+convert(varchar(5),DateDiff(s, $productionHours, $Production_dashboard[$i]['time'])%3600/60)+':'+convert(varchar(5),(DateDiff(s, $productionHours, $Production_dashboard[$i]['time'])%60))";
                      

//                        foreach ($module as $key => $val) {
//                            $Production_dashboard[$i][$key]['UserId'] = $Production[$key];
//                        }
//                        if ($Production['ProductionStartDate'] != '') {
//                            $Production_dashboard[$i]['ProductionStartDate'] = date("d-m-Y H:i:s", strtotime($Production['ProductionStartDate']));
//                        } else {
//                            $Production_dashboard[$i]['ProductionStartDate'] = '';
//                        }
//                        if ($Production['ProductionEndDate'] != '') {
//                            $Production_dashboard[$i]['ProductionEndDate'] = date("d-m-Y H:i:s", strtotime($Production['ProductionEndDate']));
//                        } else {
//                            $Production_dashboard[$i]['ProductionEndDate'] = '';
//                        }
//
//                        if ($Production['CreatedDate'] != '') {
//                            $Production_dashboard[$i]['CreatedDate'] = date("d-m-Y H:i:s", strtotime($Production['CreatedDate']));
//                        } else {
//                            $Production_dashboard[$i]['CreatedDate'] = '';
//                        }
//
//                        $Production_dashboard[$i]['month'] = date("n", strtotime($Production['ProductionStartDate']));
//                        $Production_dashboard[$i]['year'] = date("Y", strtotime($Production['ProductionStartDate']));
//
//                        if ($Production['TotalTimeTaken'] != '')
//                            $Production_dashboard[$i]['TotalTimeTaken'] = date(" H:i:s", strtotime($Production['TotalTimeTaken']));
//                        else
//                            $Production_dashboard[$i]['TotalTimeTaken'] = '';
//
//                        $Production_dashboard[$i]['UserGroupId'] = $Production['UserGroupId'];

                        $i++;
                    endforeach;


                    if (isset($this->request->data['downloadFile'])) {
                        $productionData = '';
                        $productionData = $this->UserTrackReport->find('export', ['ProjectId' => $ProjectId, 'condition' => $Production_dashboard, 'time' => $timeDetails]);
                        $this->layout = null;
                        if (headers_sent())
                            throw new Exception('Headers sent.');
                        while (ob_get_level() && ob_end_clean());
                        if (ob_get_level())
                            throw new Exception('Buffering is still active.');
                        header("Content-type: application/vnd.ms-excel");
                        header("Content-Disposition:attachment;filename=ProductionDashboards.xls");
                        echo $productionData;
                        exit;
                    }

                    if (empty($Production_dashboard)) {
                        $this->Flash->error(__('No Record found for this combination!'));
                    }
                  
                    $this->set('Production_dashboard', $Production_dashboard);
                    $this->set('timeDetails', $timeDetails);
                }
            }
        }  else {
            $this->set('Production_dashboard', $Production_dashboard);
            $this->set('timeDetails', $timeDetails);
        }
    }

    function ajaxregion() {
        echo $region = $this->UserTrackReport->find('region', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

    function ajaxstatus() {
        echo $module = $this->UserTrackReport->find('statuslist', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

  /*  function ajaxcengageproject() {
        echo $CengageCnt = $this->UserTrackReport->find('cengageproject', ['ProjectId' => $_POST['projectId']]);
        exit;
    }
*/
    function getusergroupdetails() {
      
        $session = $this->request->session();
        echo $module = $this->UserTrackReport->find('usergroupdetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserId' => $session->read('user_id')]);
        exit;
    }

    function getresourcedetails() {		
     
        $session = $this->request->session();
        echo $module = $this->UserTrackReport->find('resourcedetails', ['ProjectId' => $_POST['projectId'],'UserGroupId' => $_POST['userGroupId'], 'RegionId' => $_POST['regionId']]);
        exit;
    }

    function ajaxupdateuser() {
        echo $updateuser = $this->UserTrackReport->find('reallocateuser', ['InputEntityId' => $_POST['InputEntityId'], 'moduleid' => $_POST['moduleid'], 'userid' => $_POST['userid']]);
        exit;
    }
    
     function ajaxdirectabstraction() {
		 
      $connection = ConnectionManager::get('default');
	  $id=$_POST['ProductionEntityId'];
	  $ProjectId=$_POST['ProjectId'];
	  //echo $ProjectId;exit;
	   $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
           $content = file_get_contents($path);
           $contentArr = json_decode($content, true);
           $abstractionModuleid = array_search('Abstraction',$contentArr['Module']);
           
           parse_str($_POST['Inputentityids'], $searchInputentity);
            parse_str($_POST['ids'], $searcharray);
           parse_str($_POST['domainId'], $domainarray);
           
         $tbl_view.="<table class='table table-striped table-center'><tr><th>Id</th><th>Status</th>";
         $tbl_view.='</tr>';
                        
          foreach($searcharray['priority'] as $key=>$val){
                 
              $inputentityId = $searchInputentity['InputEntityId'][$val];
             	
               $queryUpdate = $connection->execute("select isbotminds from ProductionEntityMaster where InputEntityId='$inputentityId'")->fetchAll('assoc');
                $isbotminds=$queryUpdate[0]['isbotminds'];
                
                $isbotminds_yes = $isbotminds == 1?'selected':'';
                $isbotminds_no = $isbotminds == 0?'selected':'';
                
                
                $templateUser="<select  name='status[$inputentityId]' class='form-control statusids' >"
                        . "<option value=0> --Select --</option>"  
                        . "<option value=1 $isbotminds_yes>Yes</option>"
                        ."<option value=0 $isbotminds_no>No</option>";
                       
                 $templateUser.='</select>';
                 
              $tbl_view.='<tr><td>'.$domainarray['domain'][$val].'</td>'
                      . '<td>'.$templateUser
                      . '</td></tr>';
              
          }
            $tbl_view.="</table>";
          
//           print_r($domainarray);exit;
//           print_r($abstractionModuleid);exit;
       
	   echo $tbl_view;
        exit;
    }
    
     function ajaxdirectabstractionsubmit() {
         
         $connection = ConnectionManager::get('default');
		parse_str($_POST['statusids'], $searcharray);
		  $ProjectId=$_POST['ProjectId'];
                
           $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
           $content = file_get_contents($path);
           $contentArr = json_decode($content, true);
           $abstractionModuleid = array_search('Abstraction',$contentArr['Module']);
           
                foreach($searcharray['status'] as $key => $val){
                  $queryUpdate = "Update ProductionEntityMaster set isbotminds='$val' where InputEntityId='$key'";	
         $connection->execute($queryUpdate);
        
                     $queryUpdate = "Update Staging_".$abstractionModuleid."_Data set isbotminds='$val' where InputEntityId='$key'";	
                 
         $connection->execute($queryUpdate);
                    
                }
                
            $array = array("status"=>1);
            echo json_encode($array);
                exit;
     }
    
	 function ajaxgetdata() {
		 
      $connection = ConnectionManager::get('default');
	  $id=$_POST['ProductionEntityId'];
	  $ProjectId=$_POST['ProjectId'];
	  //echo $ProjectId;exit;
	   $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
			//pr($contentArr);exit;
			$Module=array();
			$Module_key=array();
			foreach($contentArr['ModuleConfig'] as $key => $value){
				if($value['IsModuleGroup'] > 0){
					$Module[]=$contentArr['Module'][$key];
					$Module_key[]=$key;
                                        $Curlevel[$key]=$value['Level'];
                                        
				}
			}
				
	  parse_str($_POST['ProductionEntityId'], $searcharray);
	  
	  parse_str($_POST['domainId'], $domainarray);
	  parse_str($_POST['savedId'], $saved_priority);
	  parse_str($_POST['statusId'], $statusarray);
	
	///html file start////////////
	   $tbl_view='<form method="post" accept-charset="utf-8" class="form-horizontal allocateforms" id="projectforms">';
        
		///title start///		
			$tbl_view.="<table class='table table-striped table-center'  style='width:985px !important'><tr><th>Id</th><th>Priority</th>";
			foreach($Module as $value):
			$tbl_view.='<th>'.$value.'</th>';
			endforeach;
			
			$tbl_view.='</tr>';
		////title end///
	  
	   if(!empty($searcharray['priority'])){
		   $i=0;
		   
		   foreach($searcharray['priority'] as $row):	
		    $j=0;		   
		    $i++;
                    
				$tbl_view.='<tr><td>'.$domainarray['domain'][$row].'</td><td><input type="text" name="pri_id['.$row.']" id="pri_id'.$row.'" value="'.$saved_priority['pri_saved'][$row].'" class="form-control " onkeyup="numericvalidation('.$row.');"></td>';
				////dynamic td///////
				foreach($Module_key as $val):
				$j++;
				///selected user start////////////
				 $SavedUser = $connection->execute("select Estimated_Time,UserId from ME_Production_TimeMetric  where  ProductionEntityID ='" . $row . "' and  Module_Id='" . $val . "' and ProjectId='" . $ProjectId . "'")->fetchAll('assoc');
                             
                                
				 $DbUser=$SavedUser[0]['UserId'];
                                 
				 $Estimated_Time=$SavedUser[0]['Estimated_Time'];	 
				///selected user end//////////////
                                ///status check//////////////
                                 $readonly="";
                               
                                 
                                 $EntityResult = $connection->execute("select StatusId from ProductionEntityMaster  where  Id ='" . $row . "'")->fetchAll('assoc');
                                 $Status_id=$EntityResult[0]['StatusId'];
                                
                                 foreach($contentArr['ModuleStatus'] as $key => $value){
                                      foreach($value as $inkey => $invalue){
                                        if($invalue ==  $contentArr['ProjectStatus'][$Status_id]){
                                           $Levelmodule=$Curlevel[$key];     

                                        }
                                      }
			         }
                                 
                                 if(!empty($StatusQuery)){
				 
                                /* $CheckSts=explode(",",$Sts);
                                 if(!in_array($statusarray['status'][$row], $CheckSts)){*/
                                   //$statusarray['status'][$row]=2;
                                 
                                 if($Levelmodule > $Curlevel[$val]){
                                  $readonly="disabled";
                                  }
								  
                                 }
                                 ///status check end//////////////
                                 
				$templateUser="<table><tbody><tr><td style='padding-left:2%;'>User </td><td style='padding-left:5%;'>EST</td></tr>";
                                $templateUser.="<tr><td><select ".$readonly."  name='UserId[".$j."][]' id='UserId-".$val."-".$row."' class='form-control  user-".$val."-".$row."' ><option value=0>--Select--</option>"; 
					
				
					foreach($contentArr['ModuleUser'][$val] as $key => $values):					
					 $selected_mode="";
					 if($DbUser == $values['Id']){
					    $selected_mode="selected";	 					 }					 
							$templateUser.='<option value="'.$values['Id'].'" '.$selected_mode.'>';
							$templateUser.=$values['Username'];
							$templateUser.='</option>';
					endforeach;
					
					
					 $templateUser.='</select>';
                                         
					 $templateUser.='</td><td> ';
					 $templateUser.='&nbsp;&nbsp;<input type="text" name="estimatedtime['.$j.'][]" id="estimatedtime" value="'.$Estimated_Time.'" > </td></tr></table>';
                                         
				$tbl_view.='<input type="hidden" name="entity['.$j.'][]" id="entity" value="'.$row.'" class="form-control ">';
				
				$tbl_view.='<input type="hidden" name="module['.$j.'][]" id="module" value="'.$val.'" class="form-control ">';
				$tbl_view.='<td>'.$templateUser.'</td>';
				endforeach;
				///dynamic td end////
                             
				
		   endforeach;
	   }	   
	   
	   $tbl_view.="</table>";
	   $tbl_view.='<input type="hidden" name="no_of_column" id="no_of_column" value="'.count($Module).'">';
	   $tbl_view.='<input type="hidden" name="ProjectId" id="ProjectId" value="'.$ProjectId.'">';
	   $tbl_view .='</form>'; 
	   
	///html file end////////////
       
	   echo $tbl_view;
        exit;
    }
	function ajaxgetdatasubmit(){
		$connection = ConnectionManager::get('default');
		parse_str($_POST['userId'], $searcharray);
		
		foreach($searcharray['pri_id'] as $key => $val):
		  $queryUpdate = "update ProductionEntityMaster set priority='" . $val . "' where Id='" . $key . "'";	
         $connection->execute($queryUpdate);
		endforeach;
		
		for($i=1; $i <= $searcharray['no_of_column']; $i++){
		
		foreach($searcharray['UserId'][$i] as $key =>$val):
		 $queryUpdatetimemetric = "update ME_Production_TimeMetric set UserId='" . $val . "' where  ProductionEntityID ='" . $searcharray['entity'][$i][$key] . "' and  Module_Id='" . $searcharray['module'][$i][$key] . "' and ProjectId='" . $searcharray['ProjectId'] . "'";	
         $connection->execute($queryUpdatetimemetric);
		
		endforeach;
		
                foreach($searcharray['estimatedtime'][$i] as $key =>$val):
		 $queryUpdatetimemetric = "update ME_Production_TimeMetric set Estimated_Time='" . $val . "' where  ProductionEntityID ='" . $searcharray['entity'][$i][$key] . "' and  Module_Id='" . $searcharray['module'][$i][$key] . "' and ProjectId='" . $searcharray['ProjectId'] . "'";	
         $connection->execute($queryUpdatetimemetric);
		
		endforeach;
                
		}//end for
		
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
        $ProList = $this->UserTrackReport->find('ajaxProjectNameList', ['proId' => $is_project_mapped_to_user,'ClientId' => $_POST['ClientId'],'RegionId' => $_POST['RegionId']]);
       echo $ProList;
       exit;
        
   }

}
