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
use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\DateTime;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Utility\Hash;

class AgenterrorController extends AppController {

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
        $this->loadModel('QCBatchMaster');
        $this->loadModel('Agenterror');
        $this->loadModel('GetJob');
        $this->loadModel('projectmasters');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
    }
    public function index() {   
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $MojoProjectIds = $this->projectmasters->find('Projects');
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $userid = $session->read('user_id');
        $moduleId = $session->read("moduleId");
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->QCBatchMaster->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');
        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;
              
        
        
        
        
        $this->set('Projects', $ProListFinal);
        
         /*   $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            pr($contentArr['AttributeGroupMasterDirect']);exit;
          
          */
        
		//$Filter="WHERE  ProjectId IN ('$ids') AND CreatedDate >= '".date("Y-m-d")."'";
/////index value form///
       if(!empty($this->request->data('batch_from'))){
            $fdate = $this->request->data('batch_from');
         } 
        else { 
            $fdate= "";//date("d-m-Y");
        }
        
        if(!empty($this->request->data('batch_to'))){
            $tdate = $this->request->data('batch_to');
         } 
        else { 
            $tdate= "";
        }
        $this->set('fromdate', $fdate);
        $this->set('todate', $tdate);    
    
        
        
////index value form end/////  
        
if (isset($this->request->data['check_submit'])) {
$session = $this->request->session();
$user_id = $session->read("user_id");
$moduleId = $session->read("moduleId");

$ProjectId = $this->request->data('ProjectId');
$CampaignId = $this->request->data('CampaignId');
$connection = ConnectionManager::get('default');

$stagingTable = 'Staging_' . $moduleId . '_Data';
$link = $connection->execute("SELECT * FROM " . $stagingTable . " where UserId=" . $user_id . "  AND ProjectId=" . $ProjectId . "")->fetchAll("assoc");
$RegionId = $link[0]['RegionId'];

/*
$path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
$content = file_get_contents($path);
$contentArr = json_decode($content, true);
$AttributeGroupMaster = $contentArr['AttributeGroupMasterDirect'];
*/


 foreach ($ProList as $values):
     if($values['ProjectId']==$ProjectId){
            $ProName = $values['ProjectName'];
     }
endforeach;
//seperate count///

/*

$Arrfdate=explode("-",$fdate);
$Arrtdate=explode("-",$tdate);
$fdateformat = $Arrfdate[2]."-".$Arrfdate[1]."-".$Arrfdate[0];
$tdateformat = $Arrtdate[2]."-".$Arrtdate[1]."-".$Arrtdate[0];

$ts1 = strtotime($fdate);
$ts2 = strtotime($tdate);
$year1 = date('Y', $ts1);
$year2 = date('Y', $ts2);
$month1 = date('m', $ts1);
$month2 = date('m', $ts2);
 $countmonth = (($year2 - $year1) * 12) + ($month2 - $month1);
if($month1 == $month2 && $year1 == $year2){
    $countmonth = 1;
}
*/
////
$QueryDateFrom=$this->request->data('batch_from');
$QueryDateTo=$this->request->data('batch_to');

///
if ($QueryDateFrom != '' && $QueryDateTo != '') { 
$months = $this->getmonthlist($QueryDateFrom, $QueryDateTo); 
} 
elseif ($QueryDateFrom != '' && $QueryDateTo == '') {  
$months = $this->getmonthlist($QueryDateFrom, $QueryDateFrom);
}
elseif ($QueryDateFrom == '' && $QueryDateTo != '') { 
$months = $this->getmonthlist($QueryDateTo, $QueryDateTo); 
}

            
       if(!empty($this->request->data('batch_from')) && empty($this->request->data('batch_to'))){
           $Datecheck ="Convert(date, pm.ProductionStartDate)='".$fdateformat."' AND ";         
       } 
       elseif($this->request->data('batch_from') == $this->request->data('batch_to')){
           $Datecheck ="Convert(date, pm.ProductionStartDate)='".$fdateformat."' AND ";
       }else{
            $Datecheck ="Convert(date, pm.ProductionStartDate)>='".$fdateformat."' AND Convert(date, pm.ProductionStartDate)<='".$tdateformat."' AND";
       }
       
         
//seperate count end	

$Setmonth=$Arrfdate[1];
$Setyear=$Arrfdate[2];
$Arrcompleted=array();
$Arrtarget=array();
$Arrmonthtitle=array();
//$ProjectId=3351;

        $V_project=array();
        $V_empid=array();
        $V_empname=array();
        $V_campaign=array();
        $V_errors=array();
        $V_count=array();
        $V_percentage=array();
        $ListError=array();
        $V_attrname=array();
        $ArrInputEntity=array();
        $ArrAtributes_all=array();
        $V_camp=array();
        
          $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        //echo "<pre>";print_r($JsonArray);exit;        
       
        foreach($JsonArray['ModuleConfig'] as $key => $value){
           
            if($value['IsModuleGroup'] == '1'){
                 $ProdModuleId= $key;
            }
        }
        
    ///////////campaign////////
            //$RegionId = $productionjobNew[0]['RegionId'];
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
                //$keys_sub = $this->combineBySubGroup($keys);
               
                $groupwisearray[$key] = $keys;
                
            }
            
         
           foreach($groupwisearray as $arkey => $resval){
              foreach($resval as $key => $newresval){      
               if($newresval['AttributeMasterId']!="")
                  $ArrAtributes_all[$arkey][]= $newresval['AttributeMasterId']; //if end
                }
              
            }
                  /*  if(!empty($CampaignId)){  
                     if($arkey == $CampaignId){
                     foreach($resval as $key => $newresval){      
                      if($newresval['AttributeMasterId']!="")
                         $ArrAtributes[]= $newresval['AttributeMasterId']; //if end
                     }
                    }
                   }//if end
                   */
            
             $checkAttributes="";
             if(!empty($CampaignId)){                  
                     $ListAttributes=implode(",",$ArrAtributes_all[$CampaignId]);
                     $checkAttributes="AND  mc.AttributeMasterId IN (".$ListAttributes.")";
             }
          
          ///////////campaign end////////////     
  
			 //for($i=0;$i<$countmonth;$i++){
                          //   $j=$i+1;
                          foreach($months as $CountMonth){
                             				
				 /////Query start/////
				 //targete
                                 $Arrdatetitle=explode("_",$CountMonth);
				 $strdate =$Arrdatetitle[2]."-".$Arrdatetitle[1]."-01";
				 $Arrmonthtitle[]=date('F Y', strtotime($strdate));
                                 $Mnth =$CountMonth;
                                  $Prod_Module = 'tm.*';
      
        //$ProdModuleId=6694018;                     
                              
//echo "SELECT DISTINCT pm.InputEntityId,$Prod_Module ,ec.ErrorCategoryName,mc.ProjectAttributeMasterId,mc.ErrorCategoryMasterId FROM Report_ProductionEntityMaster".$Mnth." as pm LEFT JOIN Report_ProductionTimeMetric".$Mnth." as tm ON pm.InputEntityId =tm.InputEntityId LEFT JOIN MV_QC_Comments as mc ON pm.InputEntityId =mc.InputEntityId LEFT JOIN MV_QC_ErrorCategoryMaster as ec ON ec.ID = mc.ErrorCategoryMasterId WHERE ".$Datecheck."  pm.ProjectId='".$ProjectId."' ".$checkAttributes." ";exit;
                             
			$cnt_report = $connection->execute("SELECT DISTINCT pm.InputEntityId,$Prod_Module ,ec.ErrorCategoryName,mc.ProjectAttributeMasterId,mc.AttributeMasterId,mc.ErrorCategoryMasterId FROM Report_ProductionEntityMaster".$Mnth." as pm LEFT JOIN Report_ProductionTimeMetric".$Mnth." as tm ON pm.InputEntityId =tm.InputEntityId LEFT JOIN MV_QC_Comments as mc ON pm.InputEntityId =mc.InputEntityId LEFT JOIN MV_QC_ErrorCategoryMaster as ec ON ec.ID = mc.ErrorCategoryMasterId WHERE ".$Datecheck."  pm.ProjectId='".$ProjectId."' ".$checkAttributes." ")->fetchAll('assoc');
                       
                 /*  foreach($cnt_report as $val){
                    $ArrInputEntity[]=$val['InputEntityId'];
                   }
                  * 
                  */    
                        
                   foreach($cnt_report as $val){                             
                   $ListError[]=$val['ErrorCategoryName'];
              
              
               
                  ///campaign name///
                         foreach($ArrAtributes_all as $key => $value){
                              if (in_array($value, $ArrAtributes_all[$key])){
                                 $aoqAttributes =implode(",",$ArrAtributes_all[$key]);
                                 $Camp_name =$AttributeGroupMasterDirect[$key];
                              }  
                             
                             /*foreach($value as $newkey => $newvalue){
                                    if($newvalue == $val['AttributeMasterId']){
                                     $aoqAttributes =implode(",",$ArrAtributes_all[$key]);
                                     $Camp_name =$AttributeGroupMasterDirect[$key];
                                    }

                                }*/
                          }

                  /////end///////
            
                
            if(!empty($Camp_name)){
                
                
               if (!in_array($Camp_name, $V_camp)){
                   $V_camp[]=$Camp_name;
              ////Aoq calculate/////////////////
              //$UniqueEntity=array_unique($ArrInputEntity);
              //$Entityimplode=implode(",",$UniqueEntity);
              //echo $Entityimplode;exit;     
               $Selectaoqweight= $connection->execute("select InputEntityId from MV_QC_Comments where ProjectId='".$ProjectId."' AND ErrorCategoryMasterId ='".$val['ErrorCategoryMasterId']."' AND AttributeMasterId IN(".$aoqAttributes.")  GROUP BY AttributeMasterId")->fetchAll('assoc');     
            $Arraoq=array();   
               foreach($Selectaoqweight as $res){
                   /////////////AOQ start/////////////////
                    
        $DependentMasterIdsQuery = $connection->execute("SELECT Id FROM MC_DependencyTypeMaster where ProjectId='". $ProjectId ."' AND FieldTypeName='After Normalized'")->fetchAll('assoc');
        $DependId=$DependentMasterIdsQuery[0]['Id'];
     

       /* $Selectaoqtime= $connection->execute("select DISTINCT InputEntityId from ME_Production_TimeMetric where Qc_Batch_Id='".$input['Id']."'")->fetchAll('assoc');       
       // echo $Selectaoqtime[0]['InputEntityId'];exit;
      */
       /////Attributes Missed 
       $Selectaoqqc= $connection->execute("select COUNT(Id) as cnt from MV_QC_Comments where ErrorCategoryMasterId='".$ErrorcatId."' AND InputEntityId='".$res['InputEntityId']."'")->fetchAll('assoc');
       $totAttrMissed=$Selectaoqqc[0]['cnt'];
      
       /////Attributes Filled
       $Selectaoqinput= $connection->execute("select COUNT(Id) as cnt from MC_CengageProcessInputData where DependencyTypeMasterId='".$DependId."' AND InputEntityId='".$res['InputEntityId']."' GROUP BY SequenceNumber,AttributeMasterId,DependencyTypeMasterId")->fetchAll('assoc');
       $AttrFilled = array();
       foreach ($Selectaoqinput as $Inattr):
       $AttrFilled[] = $Inattr['cnt'];
       endforeach;
       $totAttrFilled=array_sum($AttrFilled);
       
       
       ///error weightage//////////
       $Selectaoqweight= $connection->execute("select SUM(wm.Weightage) as weightage from MV_QC_Comments as cm LEFT JOIN MC_WeightageMaster as wm ON cm.ErrorCategoryMasterId=wm.ErrorCategory  where InputEntityId='".$res['InputEntityId']."' GROUP BY cm.InputEntityId")->fetchAll('assoc');
       $totweight=$Selectaoqweight[0]['weightage'];
       
       ///////end/////////////////
       $totAttributes =$totAttrFilled + $totAttrMissed;
        $AOQ_Calc=100 - ($totweight/$totAttributes); 
       
        $Arraoq[]=$AOQ_Calc;
        /////////////AOQ end/////////////////  
        } 
       $newaoq= array_sum($Arraoq)/count($Arraoq) ;
       $aoq_Calc = bcdiv($newaoq, 1, 2);  // 2.56
       if(floor($aoq_Calc) == $aoq_Calc) {           
        $aoq_Calc =round($aoq_Calc);       
       }
             ////Aoq calculate end/////////////////
                   
                
            
             
                     $CurAoq=array_sum($Arraoq);                   
                      unset($Arraoq);     
                            $Empname=$JsonArray['UserList'][$val[$ProdModuleId]] ;
                            $Attr_name=$AttributeOrder[$RegionId][$val['ProjectAttributeMasterId']]['DisplayAttributeName'];       
                           
                            
                            
                                           $V_errors[]=$val['ErrorCategoryName'];
                                           $V_project[]=$ProName;
                                           $V_empid[]=$val[$ProdModuleId];
                                           $V_empname[]=$Empname;
                                           $V_campaign[]=$Camp_name;
                                           $V_percentage[]=$aoq_Calc;
                                           $V_attrname[]=$Attr_name;
                                    }
                                }
                                    
                                    
                                    
                                }
				
				 /////Query end/////
				 
				 $Setmonth= $Setmonth + 1;
			 }
                         
                               
        $this->set('listerror', $ListError);
        $this->set('v_error', $V_errors); 
        $this->set('v_project', $V_project);
        $this->set('v_empid', $V_empid);
        $this->set('v_empname', $V_empname);
        $this->set('v_campaign', $V_campaign);
        $this->set('v_percentage', $V_percentage);
        $this->set('v_attrname', $V_attrname);
			 
       
	 } 
	
	
	
	
    }
//    function combineBySubGroup($keysss) {
//       
//        $mainarr = array();
//        foreach ($keysss as $key => $value) {
//            if (!empty($value))
//                $mainarr[$value['SubGroupId']][] = $value;
//        }
//        return $mainarr;
//    }
    function ajaxcampaign() {
        echo $Campaign = $this->Agenterror->find('Campaign', ['ProjectId' => $_POST['projectId']]);
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
          } 
        else 
           { 
            $months[] = date('_n_Y', strtotime($date1));
           }       
            return $months;  
    }
       

}
