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
class AbstractionReportController extends AppController {

    /**
     * to initialize the model/utilities gonna to be used this page
     */
    public $paginate = [
        'limit' => 10,
        'order' => [
            'Id' => 'asc'
        ]
    ];
     public $RegionId =1011;

    public function initialize() {
        parent::initialize();
        $this->loadModel('projectmasters');
        $this->loadModel('importinitiates');
        $this->loadModel('Puquery');
        $this->loadModel('GetJob');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
        $this->loadModel('AbstractionReport');
    }

    public function pr($array,$y='') {
        echo "<pre>";
        print_r($array);
        if(empty($y)){
            exit;
        }
    }


    public function index() {
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $RegionId = $this->RegionId;
        $moduleIdtxt = 'Abstraction';
        $this->set('RegionId', $RegionId);
//        $ProjectId = $session->read("ProjectId");
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

     
        $Cl_listarray = $connection->execute("select Id,ClientName FROM ClientMaster")->fetchAll('assoc');
        $Cl_list = array('0' => '--Select--');
        foreach ($Cl_listarray as $values):
            $Cl_list[$values['Id']] = $values['ClientName'];
        endforeach;
        $this->set('Clients', $Cl_list);
        
        $ProjectId = 3369;
        $this->request->data['ProjectId'] = 3369;

        if (isset($this->request->data['ProjectId'])) {
            $this->set('ProjectId', $this->request->data['ProjectId']);
            $ProjectId = $this->request->data['ProjectId'];
        } else {
            $this->set('ProjectId', 0);
            $ProjectId = 0;
        }

        if (isset($this->request->data['ProjectId'])) {
            $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
            $resources = $JsonArray['UserList'];
            $domainId = $JsonArray['ProjectConfig']['DomainId'];
            $AttributeMasterId = $JsonArray['ProjectConfig']['DomainId'];
            $region = $regionMainList = $JsonArray['RegionList'];
            $modules = $JsonArray['Module'];
            $ModuleId = array_search($moduleIdtxt, $modules);

            $ProjectName = $JsonArray[$ProjectId];

            $modulesConfig = $JsonArray['ModuleConfig'];
            $modulesArr = array();

            $modulesArr[$ModuleId] = $moduleIdtxt;
            ksort($modulesArr);
        }

        $this->set('resources', $resources);
        $this->set('modules', $modulesArr);

        if (isset($this->request->data['QueryDateFrom'])) {
            $QueryDateFrom = $this->request->data['QueryDateFrom'];
            $this->set('QueryDateFrom', $this->request->data['QueryDateFrom']);
        } else {
            $this->set('QueryDateFrom', '');
            $QueryDateFrom = '';
        }


        if (isset($this->request->data['QueryDateTo'])) {
            $QueryDateTo = $this->request->data['QueryDateTo'];
            $this->set('QueryDateTo', $this->request->data['QueryDateTo']);
        } else {
            $this->set('QueryDateTo', '');
            $QueryDateTo = '';
        }

        
        $ProductionFields = $JsonArray['ModuleAttributes'][$RegionId][$ModuleId]['production'];
        $AttributeGroupMaster = $JsonArray['AttributeGroupMaster'][$ModuleId];
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
                $groupwisearray[$key] = $keys_sub;
                $groupwisearray11[] = $keys_sub;
            }
           
            
                    
        $subattrList= array();
        $finalarray=array();
        $arrtlist=array();
        
        foreach ($AttributeGroupMaster as $key => $val){
            $finalarray[$key]['main']= $groupwisearray[$key];
           if(!empty($JsonArray['AttributeSubGroupMaster'][$key])){
                 foreach ($JsonArray['AttributeSubGroupMaster'][$key] as $keyatr => $valatr){
                    $finalarray[$key]['sub'][$keyatr]= $groupwisearray[$key][$keyatr];
                    unset($finalarray[$key]['main'][$keyatr]);
                }
            }
        }
      
        
         $production_attr_id = array_column($ProductionFields, 'AttributeMasterId');
        if(!empty($production_attr_id)){
            $production_attr_id_str = "[".implode("],[", $production_attr_id)."]";
        }
      
//        $this->pr($AttributeGroupMaster,1);
    
           // get fdrid
            $queryData = $connection->execute("SELECT Id FROM MC_DependencyTypeMaster where ProjectId='$ProjectId' and FieldTypeName='General' ")->fetchAll('assoc');
            $DependencyTypeMasterId = $queryData[0]['Id'];
            
//            select top 10 [5224],* from Report_ProductionEntityMaster_7_2018 where SequenceNumber =1 and DependencyTypeMasterId =167
         //     $AttributeMasterId = "[".$AttributeMasterId."] as leaseId";
              
//              $queryData = $connection->execute("select $production_attr_id_str ,ProductionEntityID ,InputEntityId from Report_ProductionEntityMaster_7_2018 where ProjectId='$ProjectId' and DependencyTypeMasterId='$DependencyTypeMasterId' and SequenceNumber=1 ")->fetchAll('assoc');
             
        

        $resqueryData = array();
        $result = array();
        if (isset($this->request->data['check_submit']) || isset($this->request->data['formSubmit'])) {

            
            
              $productionData = '';
                if (!empty($finalarray)) {
                    $productionData = $this->AbstractionReport->find('export', ['ProjectId' => $ProjectId, 'condition' => $finalarray]);
                    $this->layout = null;
                    if (headers_sent())
                        throw new Exception('Headers sent.');
                    while (ob_get_level() && ob_end_clean());
                    if (ob_get_level())
                        throw new Exception('Buffering is still active.');
                    header("Content-type: application/vnd.ms-excel");
                    header("Content-Disposition:attachment;filename=QAreviewreport.xls");
                    echo $productionData;
                    exit;
                }
            
            
            
            $ProjectId = $this->request->data['ProjectId'];
            $QueryDateFrom = $this->request->data['QueryDateFrom'];
            $QueryDateTo = $this->request->data['QueryDateTo'];

            $ClientId = 1;
            $ProjectId = 3369;
            $LeaseId = 3369;
            
            
            // get values from report table 
            
            // get fdrid
            $queryData = $connection->execute("SELECT Id FROM MC_DependencyTypeMaster where ProjectId='$ProjectId' and FieldTypeName='General' ")->fetchAll('assoc');
            $DependencyTypeMasterId = $queryData[0]['Id'];
            
//              $AttributeMasterId = "[".$AttributeMasterId."]";
//              $queryData = $connection->execute("select $AttributeMasterId as fdrid,ProductionEntityID ,InputEntityId from Report_ProductionEntityMaster_7_2018 where ProjectId='$ProjectId' and DependencyTypeMasterId='$DependencyTypeMasterId' and SequenceNumber=1 ")->fetchAll('assoc');
             
              
              // get json array 
              
              $queryData = $connection->execute("select $AttributeMasterId as fdrid,ProductionEntityID ,InputEntityId from Report_ProductionEntityMaster_7_2018 where ProjectId='$ProjectId' and DependencyTypeMasterId='$DependencyTypeMasterId' and SequenceNumber=1 ")->fetchAll('assoc');
              
            $conditions = "";

            if ($QueryDateFrom != '' && $QueryDateTo != '') {
                $conditions.="  AND QueryRaisedDate >='" . date('Y-m-d', strtotime($QueryDateFrom)) . " 00:00:00' AND QueryRaisedDate <='" . date('Y-m-d', strtotime($QueryDateTo)) . " 23:59:59'";
            }
            if ($QueryDateFrom != '' && $QueryDateTo == '') {
                $conditions.="  AND QueryRaisedDate >='" . date('Y-m-d', strtotime($QueryDateFrom)) . " 00:00:00' AND QueryRaisedDate <='" . date('Y-m-d', strtotime($QueryDateFrom)) . " 23:59:59'";
            }
            if ($QueryDateFrom == '' && $QueryDateTo != '') {
                $conditions.="  AND QueryRaisedDate ='" . date('Y-m-d', strtotime($QueryDateTo)) . " 00:00:00' AND QueryRaisedDate ='" . date('Y-m-d', strtotime($QueryDateTo)) . " 23:59:59'";
            }


            $this->set('result', $result);

            if (empty($result)) {
                $this->Flash->error(__('No Record found for this combination!'));
            }
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


 

   

    

    


function combineBySubGroup($keysss) {
        $mainarr = array();
        foreach ($keysss as $key => $value) {
            if (!empty($value))
                $mainarr[$value['SubGroupId']][] = $value;
        }
        return $mainarr;
    }

}
