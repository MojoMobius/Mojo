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

class ChartsQcbatchController extends AppController {

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

            try {

                $ProjectId = $this->request->data['ProjectId'];
//            $ProjectId = 3346;
                $sladefault = QareviewSLA;
                $batch_from = "";
                $batch_to = "";
                $ProductionStartDate = "";
                $ProductionEndDate = "";

                if (!empty($this->request->data('month_from'))) {
                    $batch_from = $this->request->data('month_from');
                }

                if (!empty($this->request->data('month_to'))) {
                    $batch_to = $this->request->data('month_to');
                }

//            $batch_from = '08-05-2018';

                if (!empty($batch_from) && !empty($batch_to)) {
                    $ProductionStartDate = date("Y-m-d 00:00:00", strtotime("01-" . $batch_from));
                    $ProductionEndDate = date("Y-m-d 23:59:59", strtotime("30-" . $batch_to));
                } elseif (!empty($batch_from) && empty($batch_to)) {
                    $ProductionStartDate = date("Y-m-d 00:00:00", strtotime("01-" . $batch_from));
                    $ProductionEndDate = date("Y-m-d 23:59:59", strtotime("30-" . $batch_from));
                } elseif (empty($batch_from) && !empty($batch_to)) {
                    $ProductionStartDate = date("Y-m-d 00:00:00", strtotime("01-" . $batch_to));
                    $ProductionEndDate = date("Y-m-d 23:59:59", strtotime("30-" . $batch_to));
                }


                //and Date between '$ProductionStartDate' and '$ProductionEndDate'

                $getbatchavg = $connection->execute("SELECT avg(AOQ) as Accuracy,MONTH(Date) as month,YEAR(Date) as year, (SELECT TOP 1 AOQ from MV_QC_BatchIteration where ProjectId = '$ProjectId' and Iteration = 1) as Firstpass,'$sladefault' as sla from MV_QC_BatchIteration where ProjectId = '$ProjectId' and Date between '$ProductionStartDate' and '$ProductionEndDate' group by MONTH(Date),YEAR(Date) order by MONTH(Date) asc");
                $getbatchavgres = $getbatchavg->fetchAll('assoc');
//print_r("SELECT avg(AOQ) as Accuracy,MONTH(Date) as month,YEAR(Date) as year, (SELECT TOP 1 AOQ from MV_QC_BatchIteration where ProjectId = '$ProjectId' and Iteration = 1) as Firstpass,'$sladefault' as sla from MV_QC_BatchIteration where ProjectId = '$ProjectId' and Date between '$ProductionStartDate' and '$ProductionEndDate' group by MONTH(Date),YEAR(Date) order by MONTH(Date) asc");exit;
                $dataformat = array();
                $dataformataccuracy = array();
                $dataformataccuracyres = array();

                $dataformatsla = array();
                $dataformatslares = array();

                $dataformatfirstpass = array();
                $dataformatFirstpassres = array();

                $percentage = "%";
                if (!empty($getbatchavgres)) {
                    foreach ($getbatchavgres as $key => $value) {
                        //Accuracy
                        $dataformataccuracy['y'] = intval($value['Accuracy']);
                        $daytext = date('M-Y', strtotime($value['year'] . '-' . $value['month'] . '-01'));
                        $dataformataccuracy['label'] = $daytext;
                        $dataformataccuracyres[] = $dataformataccuracy;

                        // sla
                        $dataformatsla['y'] = intval($sladefault);
                        $dataformatsla['label'] = $daytext;
                        $dataformatslares[] = $dataformatsla;
                        // firstpass
                        $dataformatfirstpass['y'] = intval($value['Firstpass']);
                        $dataformatfirstpass['label'] = $daytext;
                        $dataformatfirstpassres[] = $dataformatfirstpass;

                        $getbatchavgres[$key]['monthTxt'] = $daytext;
                        $getbatchavgres[$key]['FirstpassTxt'] = intval($value['Firstpass']) . $percentage;
                        $getbatchavgres[$key]['AccuracyTxt'] = intval($value['Accuracy']) . $percentage;
                    }
                }

                $dataformat[0]["type"] = "line";
                $dataformat[0]["legendText"] = "Accuracy";
                $dataformat[0]["showInLegend"] = true;
                $dataformat[0]["dataPoints"] = $dataformataccuracyres;

                $dataformat[1]["type"] = "line";
                $dataformat[1]["showInLegend"] = true;
                $dataformat[1]["legendText"] = "First Pass";
                $dataformat[1]["dataPoints"] = $dataformatfirstpassres;

                $dataformat[2]["type"] = "line";
                $dataformat[2]["legendText"] = "SLA";
                $dataformat[2]["showInLegend"] = true;
                $dataformat[2]["dataPoints"] = $dataformatslares;

                $Chartreports['chartres'] = $dataformat;
                $Chartreports['total'] = count($getbatchavgres);
                $Chartreports['getbatchavgres'] = $getbatchavgres;
//            echo "<pre>ss";
//            print_r($getbatchavgres);
//            exit;
                $Chartreports['status'] = 1;
                echo json_encode($Chartreports);
                exit;
            } catch (\Exception $e) {
                $Chartreports['status'] = 1;
                echo json_encode($Chartreports);
                exit;
            }
        }
    }

}
