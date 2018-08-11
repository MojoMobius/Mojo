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
    public $RegionId = 1011;

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

    public function pr($array, $y = '') {
        echo "<pre>";
        print_r($array);
        if (empty($y)) {
            exit;
        }
    }

    public function arrayfilters($array, $attid) {

        $attr = array_column($array, $attid);

        if (count($attr) > 0) {
            $ar = array();
            $i = 0;
            foreach ($attr as $key => $val) {
                if (!is_null($val)) {
                    $ar[$i] = $val;
                    $i++;
                }
            }
            if (empty($ar)) {
                $ar[] = null;
            }

//            $ar['cnt'] = count($ar);
        } else {
            $ar[] = null;
//            $ar['cnt'] = 1;
        }

        return $ar;
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
//        $moduleId = $session->read("moduleId");


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

//        $ProjectId = 3369;
//        $this->request->data['ProjectId'] = 3369;

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




        $resqueryData = array();
        $result = array();
        if (isset($this->request->data['check_submit']) || isset($this->request->data['formSubmit'])) {

            $ProjectId = $this->request->data['ProjectId'];
            $QueryDateFrom = $this->request->data['QueryDateFrom'];
            $QueryDateTo = $this->request->data['QueryDateTo'];
            $ClientId = $this->request->data['ClientId'];
            $LeaseId = $this->request->data['LeaseId'];
            
            $this->set('ClientId', $ClientId);
            $this->set('ProjectId', $ProjectId);
            $this->set('LeaseId', $LeaseId);
            
//            $this->pr($LeaseId);
            // get json array 

            $conditions = "";

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


            $queryData = $connection->execute("SELECT Id FROM MC_DependencyTypeMaster where ProjectId='$ProjectId' and FieldTypeName IN ('General' ,'After Normalized','After Normalized_Reference URL','Disposition') ")->fetchAll('assoc');
//            $DependencyTypeMasterId = $queryData[0]['Id'];
            $DependencyTypeMasterIds = '';
            if(!empty($queryData)){
                $DependencyTypeMasterIds = implode(',', array_column($queryData, 'Id'));
            }
                      
            $mncnt = count($months);
            $i = 1;
            $noresult = 0;
            foreach ($months as $monkey => $mnt_tbl) {

                $stagingTable = "Report_ProductionEntityMaster$mnt_tbl";
                $get_tableexist = $connection->execute("IF OBJECT_ID (N'$stagingTable', N'U') IS NOT NULL SELECT 1 AS res ELSE SELECT 0 AS res ")->fetchAll('assoc');

                if ($get_tableexist[0]['res'] > 0) {

                    $getqueryres = $connection->execute("select count(*) as cnt  from $stagingTable where ProjectId='$ProjectId' and DependencyTypeMasterId IN ($DependencyTypeMasterIds) ")->fetchAll('assoc');
                    if (!empty($getqueryres[0]['cnt'])) {
                        break;
                    } else {
                        if ($mncnt == $i) {
                            $noresult = 1;
                        }
                    }
                } else {
                    $noresult = 1;
                    
                    break;
                }

                $i++;
            }


            if (!empty($noresult)) {
                $this->Flash->error(__('No Record found for this combination!'));
            } else {


//                $ClientId = 1;
//                $ProjectId = 3369;
//                $LeaseId = 'US017P01';

                $ColumnNames = $connection->execute("SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS  where TABLE_NAME='$stagingTable' and ISNUMERIC(COLUMN_NAME) = 1")->fetchAll('assoc');

                $arr = array();
                foreach ($ColumnNames as $key => $val):
                    $arr[] = $val['COLUMN_NAME'];
                endforeach;
                $NumericColumnNames = implode(",", $arr);


                // split attributes
                $AttributeMast = array_chunk($arr, ceil(count($arr) / 2));
                $AttributeMasterids1 = "[" . implode('],[', $AttributeMast[0]) . "]";
                $AttributeMasterids2 = "[" . implode('],[', $AttributeMast[1]) . "]";
//          $ProductionField = $DependentMasterIds['ProductionField'];
//echo $AttributeMasterId;exit;
                $LeaseIdColumn = "[".$AttributeMasterId."]";
                
               $getInputEntityId = $connection->execute("select top 1 InputEntityId from $stagingTable where ProjectId='$ProjectId' and DependencyTypeMasterId IN ($DependencyTypeMasterIds) AND $LeaseIdColumn = '$LeaseId' ")->fetchAll('assoc');
               $InputEntityId = $getInputEntityId[0]['InputEntityId'];
//               $InputEntityId = 112152;
//                print_r($getInputEntityId);exit;
                
                $getQuery1 = $connection->execute("select SequenceNumber,ProductionEntityID ,InputEntityId ,$AttributeMasterids1 from $stagingTable where ProjectId='$ProjectId' and DependencyTypeMasterId IN ($DependencyTypeMasterIds) AND InputEntityId = '$InputEntityId' ")->fetchAll('assoc');
  
                
                $getQuery2 = $connection->execute("select SequenceNumber,ProductionEntityID ,InputEntityId ,$AttributeMasterids2 from $stagingTable where ProjectId='$ProjectId' and DependencyTypeMasterId IN ($DependencyTypeMasterIds) AND InputEntityId = '$InputEntityId'  ")->fetchAll('assoc');
                
                $getQuery = array();
                $cnt1 = count($getQuery1);
                $cnt2 = count($getQuery2);

                if ($cnt1 < $cnt2) {
                    $getQuerytemp1 = $getQuery1;
                    $getQuerytemp2 = $getQuery2;
                    $getQuery1 = $getQuerytemp2;
                    $getQuery2 = $getQuerytemp1;
                }

                if (!empty($getQuery1) && !empty($getQuery2)) {
                    foreach ($getQuery1 as $key => $val) {
                        $getQuery[$key] = isset($getQuery2[$key]) ? $getQuery2[$key] + $val : $val;
                    }
                }


                $subattrList = array();
                $finalarray = array();
                $arrtlist = array();

                foreach ($AttributeGroupMaster as $key => $val) {
                    $finalarray[$key]['main'] = $groupwisearray[$key];
                    if (!empty($JsonArray['AttributeSubGroupMaster'][$key])) {
                        foreach ($JsonArray['AttributeSubGroupMaster'][$key] as $keyatr => $valatr) {
                            $finalarray[$key]['sub'][$keyatr] = $groupwisearray[$key][$keyatr];
                            unset($finalarray[$key]['main'][$keyatr]);
                        }
                    }
                }

                foreach ($finalarray as $key => $val) {
                    foreach ($val['main'] as $key1 => $val1) {
                        foreach ($val1 as $key2 => $val2) {
                            $result = $this->arrayfilters($getQuery, intval($val2['AttributeMasterId']));
//                        $result = $this->arrayfilters($getQuery, intval(5061));
                            $finalarray[$key]['main'][$key1][$key2]['res'] = $result;
                            $finalarray[$key]['main'][$key1][$key2]['seqcnt'] = count($result);
                        }
                    }

                    foreach ($val['sub'] as $subkey1 => $subval1) {
                        foreach ($subval1 as $subkey2 => $subval2) {
                            $result = $this->arrayfilters($getQuery, intval($subval2['AttributeMasterId']));
//                        $result = $this->arrayfilters($getQuery, intval(5061));
                            $finalarray[$key]['sub'][$subkey1][$subkey2]['res'] = $result;
                            $finalarray[$key]['sub'][$subkey1][$subkey2]['seqcnt'] = count($result);
                        }
                    }
                }



//            $this->pr($finalarray);

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
            }


//             $this->pr($stagingTable);
//           
//            $this->pr($stagingTable,1);
//            $this->pr($getqueryres);
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
