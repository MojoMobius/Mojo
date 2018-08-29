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
class DeliveryPageController extends AppController {

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
        $this->loadModel('deliveryPage');
        $this->loadModel('GetJob');
        $this->loadModel('ProductionDashBoards');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
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
        $ProList = $this->deliveryPage->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
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
            $Clients = $this->deliveryPage->find('client', ['ClientId' => $this->request->data['ClientId']]);
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

   
    
        
       

//pr($completed_status_idsss); exit;
       

        if (isset($this->request->data['QueryDateTo']))
            $this->set('QueryDateTo', $this->request->data['QueryDateTo']);
        else
            $this->set('QueryDateTo', '');

        if (isset($this->request->data['QueryDateFrom']))
            $this->set('QueryDateFrom', $this->request->data['QueryDateFrom']);
        else
            $this->set('QueryDateFrom', date('d-m-Y'));
 if (isset($this->request->data['submit'])){
	 $StsArr=$this->request->data['chk_status'];
	// print_r($StsArr);exit;
	 foreach($StsArr as $row){
		 echo $row;
		    //$queryUpdate = "update ProductionEntityMaster set StatusId='" . $userid . "' where Id='" . $row . "'";
            //$connection->execute($queryUpdate);
	 }
	 exit;
 }
       
			
        if (isset($this->request->data['check_submit']) || isset($this->request->data['downloadFile'])) {

            $ProjectId = $this->request->data('ProjectId');
            $conditions = '';
            $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
            $resources = $JsonArray['UserList'];
            $domainId = $JsonArray['ProjectConfig']['DomainId'];
			$Pro_name=$JsonArray[$ProjectId];
            $AttributeMasterId = $JsonArray['ProjectConfig']['DomainId'];
			$queryData = $connection->execute("SELECT Id FROM MC_DependencyTypeMaster where ProjectId='$ProjectId' and FieldTypeName='General' ")->fetchAll('assoc');
            $DependencyTypeMasterId = $queryData[0]['Id'];

            $QueryDateFrom = $batch_from = $this->request->data('QueryDateFrom');
            $QueryDateTo = $batch_to = $this->request->data('QueryDateTo');
            $RegionId = $this->request->data('RegionId');
            $ClientId = $this->request->data('ClientId');
            $arrayResult = array();
			///query start/////////
			
			$Query = $connection->execute("SELECT pem.Id,pem.TotalTimeTaken,cpid.AttributeValue as fdrid,pem.ProductionStartDate,pem.ProjectId FROM ProductionEntityMaster as pem
			LEFT JOIN ProjectMaster as pm ON pm.ProjectId=pem.ProjectId
			LEFT JOIN MC_CengageProcessInputData as cpid ON cpid.ProductionEntityID=pem.ID
			WHERE pem.ProjectId='".$ProjectId."' AND pm.client_id='".$ClientId."' AND cpid.DependencyTypeMasterId='$DependencyTypeMasterId' and cpid.SequenceNumber=1 and cpid.AttributeMasterId='$AttributeMasterId'")->fetchAll('assoc');
            
			///query end/////////   
				$arrayResult=$Query;
                
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

                

                $this->set('result', $arrayResult);
                $this->set('project_name', $Pro_name);
           
        } 
    }

    public function indexold() {
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $ProjectId = $session->read("ProjectId");
        $moduleId = $session->read("moduleId");

        $MojoProjectIds = $this->projectmasters->find('Projects');
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $user_id, 'Project' => $MojoProjectIds]);
        $ProList = $this->deliveryPage->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');
        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;
        //$ProListFinal = ['0' => '--Select Project--', '2294' => 'Mojo URL Monitoring'];
        $this->set('Projects', $ProListFinal);
		
		$connection = ConnectionManager::get('default');
        $Cl_listarray = $connection->execute("select Id,ClientName FROM ClientMaster")->fetchAll('assoc');
		 
        $Cl_list = array('0' => '--Select--');
        foreach ($Cl_listarray as $values):
            $Cl_list[$values['Id']] = $values['ClientName'];
        endforeach;
        //$ProListFinal = ['0' => '--Select Project--', '2278' => 'ADMV_YP'];
        $this->set('Clients', $Cl_list);
		if ($this->request->data['ClientId'] > 0) {
                 $Clients = $this->deliveryPage->find('client', ['ClientId' => $this->request->data['ClientId']]);
                 $this->set('ClientId', $Clients);
                } else {
                   
                    $this->set('ClientId', '');
        }
		
		
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $resources = $JsonArray['UserList'];
        $domainId = $JsonArray['ProjectConfig']['DomainId'];
        $region = $regionMainList = $JsonArray['RegionList'];       
        foreach($region as $key => $val){
            $RegionId=$key;
        }
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
        $this->set('SessionRegionId', $RegionId);
        $this->set('resources', $resources);
        $this->set('modules', $modulesArr);

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

        if (isset($this->request->data['ProjectId']) || isset($this->request->data['RegionId'])) {
            $region = $this->deliveryPage->find('region', ['ProjectId' => $this->request->data['ProjectId'], 'RegionId' => $this->request->data['RegionId'], 'SetIfOneRow' => 'yes']);
            $this->set('RegionId', $region);
        } else {
            $this->set('RegionId', 0);
        }

        $this->set('CallUserGroupFunctions', '');
        if (count($ProListFinal) == 2 && count($regionMainList) == 1 && !isset($this->request->data['RegionId'])) {
            $this->set('CallUserGroupFunctions', 'yes');
        }

        if (isset($this->request->data['UserGroupId'])) {
            $UserGroup = $this->deliveryPage->find('usergroupdetails', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $this->request->data['UserGroupId']]);
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
            $Modules = $this->deliveryPage->find('module', ['ProjectId' => $this->request->data['ProjectId'], 'ModuleId' => $this->request->data['ModuleId']]);
            $this->set('ModuleIds', $Modules);
        } else {
            $this->set('ModuleIds', 0);
        }

        if (isset($this->request->data['UserGroupId']))
            $this->set('postbatch_UserGroupId', $this->request->data['UserGroupId']);
        else
            $this->set('postbatch_UserGroupId', '');

        if (isset($this->request->data['check_submit']) || isset($this->request->data['formSubmit'])) {

            $user_id = $this->request->data('user_id');
            $user_group_id = $this->request->data('UserGroupId');
            $QueryDateTo = $this->request->data('QueryDateTo');
            $QueryDateFrom = $this->request->data('QueryDateFrom');
            $ModuleId = $this->request->data('ModuleId');
            $user_id_list = $this->deliveryPage->find('resourceDetailsArrayOnly', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $this->request->data['UserGroupId']]);
            $this->set('User', $user_id_list);
			
			$moduleIdLevel=$connection->execute("SELECT ModuleId FROM ME_Module_Level_Config where Project=$ProjectId and Modulegroup=1")->fetchAll('assoc');    
		    $moduleIdLevel=$moduleIdLevel[0]['ModuleId'];
		
			if($ModuleId == $moduleIdLevel){
			$DQCStatus = 1;
			}
			else{
			$DQCStatus = 0;
			}
			
			$this->set('DQCStatus', $DQCStatus);
			
            if (empty($user_id)) {
                $user_id = array_keys($user_id_list);
            }

            if ($QueryDateFrom != '' && $QueryDateTo != '') {
                $conditions.="  AND QueryRaisedDate >='" . date('Y-m-d', strtotime($QueryDateFrom)) . " 00:00:00' AND QueryRaisedDate <='" . date('Y-m-d', strtotime($QueryDateTo)) . " 23:59:59'";
            }
            if ($QueryDateFrom != '' && $QueryDateTo == '') {
                $conditions.="  AND QueryRaisedDate >='" . date('Y-m-d', strtotime($QueryDateFrom)) . " 00:00:00' AND QueryRaisedDate <='" . date('Y-m-d', strtotime($QueryDateFrom)) . " 23:59:59'";
            }
            if ($QueryDateFrom == '' && $QueryDateTo != '') {
                $conditions.="  AND QueryRaisedDate ='" . date('Y-m-d', strtotime($QueryDateTo)) . " 00:00:00' AND QueryRaisedDate ='" . date('Y-m-d', strtotime($QueryDateTo)) . " 23:59:59'";
            }
            if ($user_id != '') {
                $conditions.="  AND ME_UserQuery.UserID in (" . implode(',', $user_id) . ")";
            }
//            if ($user_group_id != '') {
//                $conditions.="  AND UserGroupId in (" . $user_group_id . ")";
//            }
            if ($ModuleId != 0) {
                $conditions.="  AND ME_UserQuery.ModuleId = " . $ModuleId . "";
            }
            $moduleTable = 'Staging_' . $ModuleId . '_Data';          
        
        $StatusFind = $JsonArray['ProjectStatus']; 
       
        $connectiond2k = ConnectionManager::get('d2k');
        $QcFirstStatusRW = $connectiond2k->execute("SELECT Status FROM D2K_ModuleStatusMaster where ModuleId=$ModuleId AND ModuleStatusIdentifier LIKE '%Query%' AND RecordStatus=1")->fetchAll('assoc');  
        //echo"<pre>";print_r($QcFirstStatusRW);exit;
        $ArrQuery=array(); 
        $newkey=array();
         foreach($QcFirstStatusRW as $key => $value){
           foreach($value as $key2 => $value2){
             $ArrQuery[]=$value2;
           }
         }
          foreach($StatusFind as $key => $value){
              if(in_array($value, $ArrQuery)){
                  $newkey[]=$key;
              }       
          }
          $StsId = implode(",",$newkey);
        
            
            $queryData = $connection->execute("SELECT distinct Tdata.AttributeValue as domainID,Tdata.InputEntityId, ME_UserQuery.ProductionEntityId,ME_UserQuery.ModuleId,ME_UserQuery.Id ,ME_UserQuery.StatusID as QueryStatus ,TLComments,QueryRaisedDate, ME_UserQuery.UserID,ME_UserQuery.Query,ME_UserQuery.UploadFile,ME_UserQuery.Client_Response,ME_UserQuery.Client_Response_Date,ME_UserQuery.UploadFile,pem.StatusId as stsId FROM ME_UserQuery INNER JOIN MC_CengageProcessInputData as Tdata ON Tdata.ProductionEntityID=ME_UserQuery.ProductionEntityId INNER JOIN ProductionEntityMaster as pem ON pem.Id=ME_UserQuery.ProductionEntityId"
                            . " WHERE Tdata.AttributeMasterId=" . $domainId . " AND ME_UserQuery.ProjectId=" . $ProjectId . " AND ME_UserQuery.StatusID in (1,2,3,4) AND pem.StatusId in ($StsId)" . $conditions)->fetchAll('assoc');
            $i = 0;
            foreach ($queryData as $val) {
                $queryResult[$val['UserID']][$val['domainID']][]=array('Query'=>$val['Query'],'QueryRaisedDate'=>$val['QueryRaisedDate'],'Id'=>$val['Id'],'TLComments'=>$val['TLComments'],'ModuleId'=>$val['ModuleId'],'ProductionEntityId'=>$val['ProductionEntityId'],'InputEntityId'=>$val['InputEntityId'],'Client_Response'=>$val['Client_Response'],'Client_Response_Date'=>$val['Client_Response_Date'],'UploadFile'=>$val['UploadFile'],'StatusId'=>$val['stsId'],'QueryStatus'=>$val['QueryStatus']);
              /*  $queryResult[$val['UserID']][$val['domainID']][$i]['Query'] = $val['Query'];
                $queryResult[$val['UserID']][$val['domainID']][$i]['QueryRaisedDate'] = $val['QueryRaisedDate'];
                $queryResult[$val['UserID']][$val['domainID']][$i]['Id'] = $val['Id'];
                $queryResult[$val['UserID']][$val['domainID']][$i]['TLComments'] = $val['TLComments'];
                $queryResult[$val['UserID']][$val['domainID']][$i]['ModuleId'] = $val['ModuleId'];
                $queryResult[$val['UserID']][$val['domainID']][$i]['ProductionEntityId'] = $val['ProductionEntityId'];
                $queryResult[$val['UserID']][$val['domainID']][$i]['InputEntityId'] = $val['InputEntityId'];
                $queryResult[$val['UserID']][$val['domainID']][$i]['Client_Response'] = $val['Client_Response'];
                $queryResult[$val['UserID']][$val['domainID']][$i]['Client_Response_Date'] = $val['Client_Response_Date'];
                $queryResult[$val['UserID']][$val['domainID']][$i]['StatusId'] = $val['stsId'];*/
            }


            $this->set('queryResult', $queryResult);

            if (empty($queryResult)) {
                $this->Flash->error(__('No Record found for this combination!'));
            }
        }
    }

    function ajaxregion() {
        echo $region = $this->deliveryPage->find('region', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

    function ajaxfilelist() {
        echo $file = $this->deliveryPage->find('filelist');
        exit;
    }

    function ajaxstatus() {
        echo $file = $this->deliveryPage->find('status', ['ProjectId' => $_POST['projectId'], 'importType' => $_POST['importType']]);
        exit;
    }

    function ajaxmodule() {
        echo $module = $this->deliveryPage->find('module', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'ModuleId' => $ModuleId]);
        exit;
    }

    function getusergroupdetails() {
        $session = $this->request->session();
        echo $module = $this->deliveryPage->find('usergroupdetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserId' => $session->read('user_id')]);
        exit;
    }

    function getresourcedetails() {
       // echo $_POST['projectId']."-".$_POST['regionId']."-".$_POST['userGroupId'];exit;
        $session = $this->request->session();
        echo $module = $this->deliveryPage->find('resourcedetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserGroupId' => $_POST['userGroupId']]);
        exit;
    }

    public function delete($id = null) {
        $Puquery = $this->deliveryPage->get($id);
        if ($id) {
            $user_id = $this->request->session()->read('user_id');
            $Puquery = $this->deliveryPage->patchEntity($Puquery, ['ModifiedBy' => $user_id, 'ModifiedDate' => date("Y-m-d H:i:s"), 'RecordStatus' => 0]);
            if ($this->deliveryPage->save($Puquery)) {
                $this->Flash->success(__('Import Initiate deleted Successfully'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set('Puquery', $Puquery);
        $this->render('index');
    }
    public function ajaxquerysubmit() {  
         $connection = ConnectionManager::get('default');
		  $session = $this->request->session();   
		  $user = $session->read("user_id");
         $selData = $connection->execute("SELECT * FROM ME_UserQuery WHERE StatusID !=3 AND ProductionEntityId='".$_POST['ProductionEntityId']."'")->fetchAll('assoc');
         if(count($selData) > 0){
             echo '0';
         }
         else{
         $ProjectId = $this->request->data('ProjectId');
        
        
            $moduleTable = 'Staging_' . $_POST['ModuleId'] . '_Data';
            $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
			$SelectQryStatus = $connection->execute("Select StatusId from $moduleTable where ProductionEntity='" . $_POST['ProductionEntityId'] . "' ")->fetchAll('assoc');
            $QryStatus = $SelectQryStatus[0]['StatusId'];
			$first_Status_name = $JsonArray['ModuleStatus_Navigation'][$QryStatus][0];
			$first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);
			//echo "Select StatusId from $moduleTable where ProductionEntity='" . $_POST['ProductionEntityId'] . "' "; exit;
            
            $Status_Id = $JsonArray['ModuleStatus_Navigation'][$QryStatus][1];
            //print_r($QryStatus);
           // exit;
             $UpdateQryStatus = "update $moduleTable set  StatusId='" . $first_Status_id . "',QueryResolved=1 ,ModifiedBy=$user,ModifiedDate='" . date('Y-m-d H:i:s') . "' where ProductionEntity='" . $_POST['ProductionEntityId'] . "' ";
            $QryStatus = $connection->execute($UpdateQryStatus);
             //$UpdateQryStatus = "update ME_Production_TimeMetric set StatusId='" . $first_Status_id . "' where ProductionEntityID='" . $_POST['ProductionEntityId'] . "' AND Module_Id=" . $_POST['ModuleId'];
			//echo "UPDATE ProductionEntityMaster SET StatusId=" . $first_Status_id . " WHERE ID=" . $_POST['ProductionEntityId'];
			$productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $first_Status_id . " WHERE ID=" . $_POST['ProductionEntityId']);
             
        echo '1';
         }
        exit;
    }
    
    public function ajaxqueryinsert() { 
        
     $domainDate=date("Y-m-d", strtotime($_POST['cl_resp_date']) );
    $ModuleId=$_POST['ModuleId'];
         $connection = ConnectionManager::get('default');
         $session = $this->request->session();        
         $file = $this->request->data('file');
         $ProjectId = $this->request->data('ProjectId');
         $InputEntityId = $this->request->data('InputEntityId');
         $RegionId = $this->request->data('RegionId');
         $DomainId = $this->request->data('DomainId');
         $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
         $content = file_get_contents($path);
         $contentArr = json_decode($content, true);
         $att_masterId =$contentArr['ProjectConfig']['DomainUrl'];
            foreach($contentArr['AttributeOrder'][$RegionId] as $key => $value){
                if($value['AttributeId'] == $att_masterId){
                           $Projectatt_masterId =$key;
                }
            }
           
         ///get data//////
             $selDependencyData = $connection->execute("SELECT TOP 1 Id FROM MC_DependencyTypeMaster where ProjectId=$ProjectId and FieldTypeName='After Normalized_Reference URL' order by Id desc")->fetchAll('assoc');
           
            
           $selData = $connection->execute("SELECT TOP 1 Id,SequenceNumber,AttributeMainGroupId,AttributeSubGroupId FROM MC_CengageProcessInputData where ProjectId=$ProjectId and RegionId=$RegionId and ProductionEntityID='".$_POST['ProductionEntityId']."'  and InputEntityId=$InputEntityId and AttributeMasterId=$att_masterId and DependencyTypeMasterId='".$selDependencyData[0]['Id']."' order by Id desc")->fetchAll('assoc');
           if($selData[0]['SequenceNumber'] > 0){
               $SeqNumber=$selData[0]['SequenceNumber'] + 1;
           }
           else{
               $SeqNumber=0;
           }
         
         ///get data end//////
        
        ///file upload//////////////////////
         $apendfilename="_".$DomainId."_".$ProjectId;
        $uploadFolder = "htmlfiles";
        $allowed = array('doc','docx','pdf');
        $filename = $file['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $file_info = pathinfo($filename, PATHINFO_FILENAME);
              /* if (!file_exists($uploadFolder)) {
                    mkdir($uploadFolder, 0777, true);
                }
                */
       
             if (in_array($ext, $allowed)) {
                 
                 $uploadFName=$file_info."_".$DomainId."_".$ProjectId.".".$ext;
                 $uploadFName = str_replace("'", "''", $uploadFName);
						 $uploadFName = str_replace(" ", "_", $uploadFName);
                if(!move_uploaded_file($_FILES['file']['tmp_name'], ''.$uploadFolder.'/' .$uploadFName))                        {
                    //$this->Flash->error('Invalid File .');
                     echo "0";
		     exit;
                }
                else{
                  ///insert///

                    $uploadFNameStaging[$att_masterId] = $uploadFName;
	 $uploadFNameStaging =json_encode($uploadFNameStaging);
	
                 $InsertQryStatus = "Insert into MC_CengageProcessInputData (ProjectId, RegionId, InputEntityId, ProductionEntityID, AttributeMasterId, ProjectAttributeMasterId, AttributeValue, DependencyTypeMasterId, SequenceNumber, AttributeMainGroupId, AttributeSubGroupId, RecordStatus, CreatedDate, RecordDeleted,HtmlFileName) VALUES ('".$ProjectId."', '".$RegionId."','".$InputEntityId."','".$_POST['ProductionEntityId']."','".$att_masterId."','".$Projectatt_masterId."','".$uploadFName."','".$selDependencyData[0]['Id']."','".$SeqNumber."','".$selData[0]['AttributeMainGroupId']."','".$selData[0]['AttributeSubGroupId']."','1','".date('Y-m-d H:i:s')."','0','" . $uploadFName . "')";
				$QryInStatus = $connection->execute($InsertQryStatus);
	
	
				$multipleAttrVal = $connection->execute("Insert into Staging_".$ModuleId."_Data (BatchID,BatchCreated,ProjectId,RegionId,InputEntityId,ProductionEntity,[" . $att_masterId . "],SequenceNumber,StatusId,DependencyTypeMasterId,RecordStatus,HtmlFileName)"
                . "values('" . $BatchId . "','" . $BatchCreated . "','" . $ProjectId . "','".$RegionId."','" . $InputEntityId . "','" . $_POST['ProductionEntityId'] . "','" . $uploadFName . "','" . $SeqNumber . "',4,'" . $selDependencyData[0]['Id'] . "','" . 1 . "','" . $uploadFNameStaging . "')");
       
                  ///insert end///  
                }
             }
             else{
                 if($ext !=""){
                  //$this->Flash->error('Invalid uploaded file format !');
                     echo "0";
					 exit;
		     
                 }
                 else{
                     // echo "0";
		    // exit;
                  //  $this->Flash->error('Upload File Not Choosen!');
                 }
             }
        
        ///file upload end//////////////////////
        $user = $session->read("user_id");
        $ProjectId = $session->read("ProjectId");
     
        $UpdateQryStatus = "update ME_UserQuery set Client_Response='" . trim($_POST['cl_resp']) . "' ,Client_Response_Date='" . $domainDate . "' ,UploadFile='".$uploadFName."' ,TLComments='" . trim($_POST['mobiusComment']) . "' ,StatusID='" . $_POST['status'] . "' ,ModifiedBy=$user,ModifiedDate='" . date('Y-m-d H:i:s') . "' where Id='" . $_POST['queryID'] . "' ";
        $QryStatus = $connection->execute($UpdateQryStatus);
         /*if ($_POST['status'] == 3) {
           $moduleTable = 'Staging_' . $_POST['ModuleId'] . '_Data';
            $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
            $first_Status_name = $JsonArray['ModuleStatusList'][$_POST['ModuleId']][0];
            $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);
            $SelectQryStatus = $connection->execute("Select StatusId from $moduleTable where ProductionEntity='" . $_POST['ProductionEntityId'] . "' ")->fetchAll('assoc');
            $QryStatus = $SelectQryStatus[0]['StatusId'];
            $Status_Id = $JsonArray['ModuleStatus_Navigation'][$QryStatus][1];
            //print_r($QryStatus);
           // exit;
            $UpdateQryStatus = "update $moduleTable set  StatusId='" . $Status_Id . "',QueryResolved=1 ,ModifiedBy=$user,ModifiedDate='" . date('Y-m-d H:i:s') . "' where ProductionEntity='" . $_POST['ProductionEntityId'] . "' ";
            $QryStatus = $connection->execute($UpdateQryStatus);
            $UpdateQryStatus = "update ME_Production_TimeMetric set StatusId='" . $first_Status_id . "' where ProductionEntityID='" . $_POST['ProductionEntityId'] . "' AND Module_Id=" . $_POST['ModuleId'];
            $QryStatus = $connection->execute($UpdateQryStatus);
                  
        }  */
        echo "1";
        exit;
    }
     public function ajaxqueryinsertdqc() {  
        
        //echo $stagingTable;exit;
         $connection = ConnectionManager::get('default');
         $selData = $connection->execute("SELECT * FROM ME_UserQuery WHERE StatusID !=3 AND ProductionEntityId='".$_POST['ProductionEntityId']."'")->fetchAll('assoc');
         if(count($selData) > 0){
             echo '0';
         }
         else{
             
        $moduleId =$_POST['ModuleId']; 
        $ProjectId =$_POST['ProjectId'];
		 $UserId =$_POST['UserId'];
        //$user_id = $session->read("user_id");
        $stagingTable = 'Staging_' . $moduleId . '_Data';
         $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
         
         $content = file_get_contents($path);
         $JsonArray = json_decode($content, true);
        //$JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);      
        $first_Status_id = $_POST['statusId'];
            //$next_status_name = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];
            $next_status_id = $JsonArray['ModuleStatus_Navigation'][$first_Status_id][1];
			$inprogress=$JsonArray['ModuleStatus_Navigation'][$next_status_id][1];
			$completed=$JsonArray['ModuleStatus_Navigation'][$inprogress][1];
                  
             
              $inprogressjob = $connection->execute("UPDATE " . $stagingTable . " SET StatusId=" . $completed . ", UserId=".$UserId." WHERE ProductionEntity=" . $_POST['ProductionEntityId']);
              $productionEntityjob = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=" . $completed . " WHERE ID=" . $_POST['ProductionEntityId']);
             
             
             echo '1';
         }
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
        $ProList = $this->deliveryPage->find('ajaxProjectNameList', ['proId' => $is_project_mapped_to_user,'ClientId' => $_POST['ClientId'],'RegionId' => $_POST['RegionId']]);
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
