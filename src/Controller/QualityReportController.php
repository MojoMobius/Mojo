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
class QualityReportController extends AppController {

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
        $this->loadModel('GetJob');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
        $this->loadModel('ProjectleaseReport');
       $this->loadModel('QualityReport');
    }

    public function index() {
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $RegionId = 1011;
        $moduleIdtxt = 'DQC';
        $this->set('RegionId', $RegionId);
//        $ProjectId = $session->read("ProjectId");
        $moduleId = $session->read("moduleId");


        $Cl_listarray = $connection->execute("select Id,ClientName FROM ClientMaster")->fetchAll('assoc');
		
		$i=0;
		$strClient='';
		 foreach ($Cl_listarray as $values):
		 if($i > 0){			
		 $strClient.=',';	 
		 }
		  $i++;
		 $strClient.=$values['Id'];
		 endforeach;
		  
		$Cl_list = array('0' => '--Select--');
		if(count($Cl_listarray) > 1 ){
		$Cl_list[$strClient] ='All';
		}
        foreach ($Cl_listarray as $values):
            $Cl_list[$values['Id']] = $values['ClientName'];
        endforeach;
        $this->set('Clients', $Cl_list);

        $MojoProjectIds = $this->projectmasters->find('Projects');
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $user_id, 'Project' => $MojoProjectIds]);
        $ProList = $this->Puquery->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
		$i=0;
		$strPro="";
		 foreach ($ProList as $values):
            if($i > 0){				
				$strPro.=',';
			}
			$i++;
			$strPro.=$values['ProjectId'].",";
        endforeach;
		
		
        $ProListFinal = array('0' => '--Select Project--');
		$ProListFinal[] = 'All';
        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;


        $this->set('Projects', $ProListFinal);

//        $this->request->data['ProjectId'] = 3346;
//        $ProjectId = 3346;
//        $this->pr($Cl_list);

        if (isset($this->request->data['ClientId'])) {
            $ClientId = $this->request->data['ClientId'];
            $this->set('ClientId', $ClientId);
        } else {
            $this->set('ClientId', 0);
            $ClientId = 0;
        }

        if (isset($this->request->data['ProjectId'])) {
            $this->set('ProjectId', $this->request->data['ProjectId']);
            $ProjectId = $this->request->data['ProjectId'];
        } else {
            $this->set('ProjectId', 0);
            $ProjectId = 0;
        }
        $JsonArray = array();
//        if (isset($this->request->data['ProjectId'])) {
//            $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
//            $resources = $JsonArray['UserList'];
//            $domainId = $JsonArray['ProjectConfig']['DomainId'];
//            $AttributeMasterId = $JsonArray['ProjectConfig']['DomainId'];
//            $region = $regionMainList = $JsonArray['RegionList'];
//            $modules = $JsonArray['Module'];
//            $this->set('modulesarray', $modules);
////            $ModuleId = array_search($moduleIdtxt, $modules);
//
//            $ProjectName = $JsonArray[$ProjectId];
//
//            $modulesConfig = $JsonArray['ModuleConfig'];
//            $modulesArr = array();
//
//            $modulesArr[$ModuleId] = $moduleIdtxt;
//            ksort($modulesArr);
//        }

        $this->set('resources', $resources);
        $this->set('modules', $modulesArr);
        $this->set('contentArr', $JsonArray);


        if (isset($this->request->data['user_id']))
            $this->set('UserId', $this->request->data['user_id']);
        else
            $this->set('UserId', '');

//        print_r($this->request->data['user_id']) ;exit;

        if (isset($this->request->data['user_id']))
            $this->set('postuser_id', $this->request->data['user_id']);
        else
            $this->set('postuser_id', '');


//            $this->set('User', array());

        if (isset($this->request->data['ProjectId']) || isset($this->request->data['ModuleId'])) {
            $Modules = $this->ProjectleaseReport->find('module', ['ProjectId' => $this->request->data['ProjectId'], 'ModuleId' => $ModuleId]);

            $this->set('ModuleIds', $Modules);
        } else {
            $this->set('ModuleIds', 0);
        }
//        QueryRaisedDate
        if (isset($this->request->data['UserGroupId']))
            $this->set('postbatch_UserGroupId', $this->request->data['UserGroupId']);
        else
            $this->set('postbatch_UserGroupId', '');

        $resqueryData = array();
        $result = array();
		if (isset($this->request->data['QueryDateTo']))
            $this->set('QueryDateTo', $this->request->data['QueryDateTo']);
			else
				$this->set('QueryDateTo', '');

			if (isset($this->request->data['QueryDateFrom']))
				$this->set('QueryDateFrom', $this->request->data['QueryDateFrom']);
			else            
				$this->set('QueryDateFrom', date("d-m-Y"));
			
			
        if (isset($this->request->data['check_submit']) || isset($this->request->data['formSubmit'])) {

            $ProjectId = $this->request->data['ProjectId'];            
               
            $RegionId = $this->request->data['regionId'];
//            $ModuleId = $this->request->data['ModuleId'];
            $UserGroupId = $this->request->data['UserGroupId'];

            $QueryDateFrom = $this->request->data['QueryDateFrom'];
            $QueryDateTo = $this->request->data['QueryDateTo'];
			
			
			

            $user_id = $this->request->data['user_id'];

            if (isset($this->request->data['user_id']))
                $this->set('postuser_id', $this->request->data['user_id']);
            else
                $this->set('postuser_id', '');


            $user_id_list = $this->QualityReport->find('resourceDetailsArrayOnly', ['ProjectId' => $ProjectId, 'RegionId' => $RegionId, 'UserId' => $session->read('user_id'), 'UserGroupId' => $UserGroupId]);
            $this->set('User', $user_id_list);

            
            if (empty($user_id)) {
                $user_id = array_keys($user_id_list);
            }

            $conditions = "";
            $results = array();
            $prod_conditions = '';

//            if (!empty($ProjectId)) {
//                $prod_conditions = " AND ptm.ProjectId= '$ProjectId'";
//            }
			//////////rahamath start////////////////
			 if ($QueryDateFrom != '' && $QueryDateTo != '') {
                    $months = $this->getmonthlist($QueryDateFrom, $QueryDateTo);
                } elseif ($QueryDateFrom != '' && $QueryDateTo == '') {
                    $months = $this->getmonthlist($QueryDateFrom, $QueryDateFrom);
                } elseif ($QueryDateFrom == '' && $QueryDateTo != '') {
                    $months = $this->getmonthlist($QueryDateTo, $QueryDateTo);
                } else {
					
					$QueryDateFrom= date("Y-m-01", strtotime(date('Y').'-'.date('m', strtotime('-3 month')).'-01'));
					$QueryDateTo = date("Y-m-d");
                    $months = $this->getmonthlist($QueryDateFrom, $QueryDateTo);
                }
				
 //             $ProjectId = array('0'=>'3346');
                $arrayResult = array();
//                $months[] = "_6_2018";
				/*$AttributeMasterId='';
				$StrProject='';
				$i=0;
			foreach ($ProjectId as $val) {
				$JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $val]);
				
                $AttributeMasterId .= "[".$JsonArray['ProjectConfig']['DomainId']."]  ";
				if($i > 0){
					$StrProject .= ",";
				}
                $StrProject .= $val;
			}*/
		$Cl_listarray = $connection->execute("SELECT Id,ClientName FROM ClientMaster WHERE Id='".$ClientId."'")->fetchAll('assoc');
         
			$SDate="";
			$EDate="";
			$UserId="";
			if(!empty($this->request->data['user_id'])){
				$UserId=implode(",",$this->request->data['user_id']);
				$Listuser="and cm.UserId IN ($UserId)";
			}
			
			if($QueryDateFrom !=""){
			$SDate= "AND rpm.ProductionStartDate >='" . date('Y-m-d', strtotime($QueryDateFrom)) . " 00:00:00'";
			}
			if($QueryDateTo !=""){
			$EDate= "AND rpm.ProductionStartDate <='" . date('Y-m-d', strtotime($QueryDateTo)) . " 23:59:59'";
			}
			
            $Record_data=array();
			 $CommentHead=array();
                foreach ($months as $key => $dt) {				
                  foreach ($ProjectId as $valpro) {
					  
					$prodEntitymastertab = "Report_ProductionEntityMaster" . $dt;
                    $prodtimeMatricstab = "ME_Production_TimeMetric" . $dt;
					$JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $valpro]);
					$totalAttributes = 	$JsonArray['ProjectConfig']['TotalAttributes'];
						
					 $DomainId = "[".$JsonArray['ProjectConfig']['DomainId']."]";
					 $DomId = $JsonArray['ProjectConfig']['DomainId'];
					 $ProName=$JsonArray[$valpro];
					foreach($JsonArray['ModuleConfig'] as $key=> $mval){
							if($mval['IsModuleGroup'] == 2){								
								$sqlcomment = "select ModuleName from ME_Module_Level_Config
					where Project ='".$valpro."' and ModuleId='".$key."'";
                    $listmodule = $connection->execute($sqlcomment)->fetchAll('assoc');
					$CommentHead[$key]=$listmodule[0]['ModuleName'];
							}
						}
					$CommentName=array_unique($CommentHead);	
					$ColumnNames = $connection->execute("SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME='$prodEntitymastertab' and ISNUMERIC(COLUMN_NAME) = 1")->fetchAll('assoc');
					$ColArr=array_column($ColumnNames, 'COLUMN_NAME');					
					if(in_array($DomId,$ColArr)){
						$DomainColumn="rpm.".$DomainId." as FDR,";
						$DomainWhere = "and rpm.".$DomainId." IS NOT NULL";
					}
					else{
						$DomainColumn='';
						
						$DomainWhere='';
					}
					
					 $sql = "select DISTINCT rpm.InputEntityId,rpm.Id,$DomainColumn cm.ModuleId,cm.Id as commentId,cm.QCComments,rpm.ProductionStartDate from $prodEntitymastertab as rpm
					LEFT JOIN MV_QC_Comments as cm ON cm.InputEntityId = rpm.InputEntityId
					where rpm.ProjectId ='".$valpro."' $DomainWhere $SDate $EDate $Listuser";
                    $listArr = $connection->execute($sql)->fetchAll('assoc');
					
					foreach($listArr as $value){		
						
						$Record_data['CommentHead']=$CommentName;						
						$Record_data['Client']=$Cl_listarray[0]['ClientName'];					
						$Record_data['leaseId']=$value['FDR'];		
						$Record_data['project_name']=$ProName;
						$Record_data['date']=$value['ProductionStartDate'];
						$Record_data['totalAttributes']=$totalAttributes;
						$Record_data['comments'][$value['ModuleId']][$value['InputEntityId']][]=$value['QCComments'];
						$Record_datas[$value['InputEntityId']]=$Record_data;
						
				
					}					
				 }
				}
				
			/////////////rahamath end/////////////////////////
           
// $this->pr($results);
//pr($Record_datas);exit;
            $this->set('result', $Record_datas);

            if (isset($this->request->data['downloadFile'])) {

                $productionData = '';
                if (!empty($results)) {
                    $productionData = $this->QualityReport->find('export', ['ProjectId' => $ProjectId, 'result' => $results]);
                    $this->layout = null;
                    if (headers_sent())
                        throw new Exception('Headers sent.');
                    while (ob_get_level() && ob_end_clean());
                    if (ob_get_level())
                        throw new Exception('Buffering is still active.');
                    header("Content-type: application/vnd.ms-excel");
                    header("Content-Disposition:attachment;filename=QualityReport.xls");
                    echo $productionData;
                    exit;
                }
            }

            if (empty($Record_data)) {
                $this->Flash->error(__('No Record found for this combination!'));
            }
        }
    }

    public function search($array, $key, $value) {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, $this->search($subarray, $key, $value));
            }
        }

        return $results;
    }

    public function pr($array, $n = '') {
        echo "<pre>";
        print_r($array);
        if (empty($n)) {
            exit;
        }
    }

    public function getvalues($array, $key, $d = '', $dt = '', $s = '') {
        $arr = array();
        if (!empty($array)) {
            $arr = array_column($array, $key);
            $msg = '';
            if (!empty($arr)) {
                $i = 1;
                foreach ($arr as $k => $v) {
                    if (!empty($v)) {
                        if (!empty($d)) {
                            $v = date('d-m-Y', strtotime($v));
                        }
                        if (!empty($dt)) {
                            $v = date('d-m-Y', strtotime($v));
                        }
                        if (!empty($s)) {
                            $v = $i . ". " . $v;
                            $i++;
                        }

                        $msg .=$v . ", ";
                    }
                }
            }

            $msg = rtrim($msg, ', ');

            return $msg;
        }

        return $arr;
    }

    function ajaxgetgroupurl($ProjectId, $RegionId, $moduleId, $ProdEntityId, $InputEntityId) {
        $connection = ConnectionManager::get('default');
//        $ProjectId = $_POST['ProjectId'];
//        $RegionId = $_POST['RegionId'];
//        $InputEntityId = $_POST['InputEntityId'];
//        $ProdEntityId = $_POST['ProdEntityId'];
//        $ProdEntityId = 108904;
//        $InputEntityId = 110190;
//        $AttrGroup = $_POST['AttrGroup'];
//        $AttrSubGroup = $_POST['AttrSubGroup'];
//        $AttrId = $_POST['AttrId'];
//        $Seq = $_POST['seq'];
//        $ProjAttrId = $_POST['ProjAttrId'];
        $session = $this->request->session();

        $stagingTable = 'Staging_' . $moduleId . '_Data';

//        if ($AttrId != '') {
//            $RefURL = AfterRefURL;
//            $RefUrlID = $connection->execute("Select Id from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=" . $ProjectId)->fetchAll('assoc');
//            
//            $multipleValStaging = $connection->execute("Select [" . $AttrId . "] as AttributeValue from $stagingTable where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntity = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . "  and SequenceNumber = " . $Seq . " and [" . $AttrId . "] <> '' GROUP by [" . $AttrId . "]")->fetchAll('assoc');
//        }
        $RefURL = AfterRefURL;
        $RefUrlID = $connection->execute("Select Id from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=" . $ProjectId)->fetchAll('assoc');

        $ColumnNames = $connection->execute("SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS  where TABLE_NAME='$stagingTable' and ISNUMERIC(COLUMN_NAME) = 1")->fetchAll('assoc');

        $arr = array();
        foreach ($ColumnNames as $key => $val):
            $arr[] = '[' . $val['COLUMN_NAME'] . ']';
        endforeach;
        $NumericColumnNames = implode(",", $arr);

        $multipleAttr = $connection->execute("Select $NumericColumnNames from $stagingTable where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntity = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . "")->fetchAll('assoc');



        foreach ($multipleAttr as $keys => $values) {
            foreach ($values as $key => $val) {
                if (!empty($val)) {
                    $newArr[$val][] = $key;
                }
            }
        }

        $i = 0;

        foreach ($newArr as $val => $key) {
            $multipleAttrVal[$i]['AttributeValue'] = $val;
            $multipleAttrVal[$i]['attrcnt'] = count(array_unique($key));
            $i++;
        }

        $arrayres = array_column($multipleValStaging, 'AttributeValue');

        $finalarr = array_map(function ($mulattval) use($arrayres) {
            if (!in_array($mulattval['AttributeValue'], $arrayres))
                return $mulattval;
        }, $multipleAttrVal);
        $finalarr1 = array_filter($finalarr);

        $result = array();
        $res = array();
        if (!empty($finalarr1)) {
            $result = array_column($finalarr1, 'AttributeValue');
        }
        if (!empty($result)) {
            $res['pdfname'] = implode(',', $result);
            $res['noofdocuments'] = count($result);
        }
        return $res;
//        $this->pr($array_data);
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

        echo $module = $this->ProjectleaseReport->find('module', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'ModuleId' => $ModuleId]);
        exit;
    }

    function getusergroupdetails() {
        $session = $this->request->session();

        echo $module = $this->QualityReport->find('usergroupdetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserId' => $session->read('user_id')]);
        exit;
    }

    function getresourcedetails() {
        $session = $this->request->session();
        echo $module = $this->QualityReport->find('resourcedetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserGroupId' => $_POST['userGroupId']]);
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

    public function ajaxProject() {
        $session = $this->request->session();
        $sessionProjectId = $session->read("ProjectId");
        $userid = $session->read('user_id');
        set_time_limit(0);
        $MojoProjectIds = $this->projectmasters->find('Projects');
        //$this->set('Projects', $ProListFinal);
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->QualityReport->find('ajaxProjectNameList', ['proId' => $is_project_mapped_to_user, 'ClientId' => $_POST['ClientId'], 'RegionId' => $_POST['RegionId']]);
        echo $ProList;
        exit;
    }
	    
    
}
