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

class ChartReportsController extends AppController {

    public $paginate = [
        'limit' => 10,
        'order' => [
            'Id' => 'asc'
        ]
    ];
    public $regionid = 1011;
    
    public function initialize() {
        parent::initialize();
        $this->loadModel('QCBatchMaster');
        $this->loadModel('projectmasters');
        $this->loadComponent('RequestHandler');
    }

    public function index() {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $MojoProjectIds = $this->projectmasters->find('Projects');
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $userid = $session->read('user_id');
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->QCBatchMaster->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');
        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;
        $this->set('Projects', $ProListFinal);
        

    }

   public function getChartreports() {
       
        $Chartreports = array();
        $connection = ConnectionManager::get('default');
        if (isset($this->request->data['ProjectId'])) {
             
//                $ProjectId = 3346;
                $ProjectId = $this->request->data('ProjectId');
                $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
                $content = file_get_contents($path);
                $contentArr = json_decode($content, true);
        
                $batch_from = $this->request->data('batch_from');
                $batch_to = $this->request->data('batch_to');
                
                $ProductionStartDate = date("Y-m-d 00:00:00", strtotime($batch_from));
                $ProductionEndDate = date("Y-m-d 23:59:59", strtotime($batch_to));
              
                $queries = $connection->execute("SELECT qccat.ErrorCategoryName,qccmt.ProjectAttributeMasterId,count(qccmt.ProjectAttributeMasterId) as cnt,qccmt.ErrorCategoryMasterId,qccmt.RegionId FROM MV_QC_Comments as qccmt inner join MV_QC_ErrorCategoryMaster as qccat on qccat.id= qccmt.ErrorCategoryMasterId where ProjectId = '$ProjectId' and qccmt.CreatedDate between '$ProductionStartDate' and '$ProductionEndDate' GROUP BY qccat.ErrorCategoryName, qccmt.ErrorCategoryMasterId,qccmt.RegionId,qccmt.ProjectAttributeMasterId");
                $queries = $queries->fetchAll('assoc');
            
             $queries_total = $connection->execute("SELECT count(*) as cnt FROM MV_QC_Comments as qccmt inner join MV_QC_ErrorCategoryMaster as qccat on qccat.id= qccmt.ErrorCategoryMasterId where ProjectId = '$ProjectId' and qccmt.CreatedDate between '$ProductionStartDate' and '$ProductionEndDate'");
            $queries_total = $queries_total->fetchAll('assoc');
            
            $total = 0;
            if(!empty($queries_total)){
                $total = $queries_total[0]['cnt'];
                if(!empty($queries)){
                    $peronepercentage = round(100/$total,1);
                    $chartres = array();
                    foreach($queries as $key=>$val){
                        $queries[$key]['displayname'] = $val['ErrorCategoryName']." ".$contentArr['AttributeOrder'][$val['RegionId']][$val['ProjectAttributeMasterId']]['DisplayAttributeName'];
                        $queries[$key]['percent'] = round($peronepercentage*$val['cnt'],1);
                       
                        // chart result array prepare
                        $chartres[$key]['label'] = $queries[$key]['displayname'];
                        $chartres[$key]['y'] = $queries[$key]['percent'];
                        $chartres[$key]['exploded'] = true;
                        $chartres[$key]['cnt'] = $queries[$key]['cnt'];
                        }
                }
            }
             
            $Chartreports = array();
            $Chartreports['total'] = $total;
            $Chartreports['peronepercentage'] = $peronepercentage;
           // $Chartreports['res'] = $queries;
            $Chartreports['chartres'] = $chartres;
            
          
         }
        $Chartreports['status'] = 1;  
       echo json_encode($Chartreports);
       exit;
         
   }
   

}
