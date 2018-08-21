<?php

/**
 * Form : ProductionFieldsMapping
 * Developer: Mobius
 * Created On: Oct 17 2016
 * class to get Input status of a file
 */

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

require_once(ROOT . '\vendor' . DS . 'PHPExcel' . DS . 'IOFactory.php');
require_once(ROOT . '\vendor' . DS . 'PHPExcel.php');

use PHPExcel_IOFactory;

class InputinitiateController extends AppController {

    /**
     * to initialize the model/utilities gonna to be used this page
     */
    public function initialize() {
        parent::initialize();
        $this->loadModel('Produserqltysummary');
        $this->loadComponent('RequestHandler');
    }

    public function index() {

        $phpExcelAutoload = new \PHPExcel_Autoloader();
        $phpExcel = new \PHPExcel_IOFactory();
        $session = $this->request->session();
        $user_id = $session->read('user_id');
        $uploadFolder = "InputFiles";
        $connection = ConnectionManager::get('default');
        if ($this->request->is('post')) {

            $ProjectId = $this->request->data['ProjectId'];
            $StatusId = $this->request->data['StatusId'];
            $RegionId = 1011;
            $CreatedDate = date('Y-m-d H:i:s');
            $CreatedBy = $user_id;

            $file = $this->request->data('file');
            if ($file['name'] != '') {


//                Check the input file 
                $allowed = array('xls', 'xlsx');
                $filename = $file['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    $this->Flash->error('Invalid Input File .');
                    return $this->redirect(['action' => 'index']);
                }

                if (!file_exists($uploadFolder)) {
                    mkdir($uploadFolder, 0777, true);
                }
                $apendfilename = date("YmdHis") . "_";
                if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadFolder . '/' . $_FILES['file']['name'])) {
                    die('Error uploading file - check destination is writeable.');
                }
                $myfile = $file['tmp_name'];
                //$inputFileName = $myfile;
                $inputFileName = $_FILES['file']['name'];


                $insert = "INSERT INTO ME_InputInitiation (ProjectId,Region,FileName,InputToStatus,RecordStatus,CreatedBy,CreatedDate)values('$ProjectId','$RegionId','$inputFileName','$StatusId','1','$CreatedBy','$CreatedDate')";
                $insertQry = $connection->execute($insert);
            } else {
                $this->Flash->success(__('Invalid Input File .'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->success(__('File has been Uploaded Successfully.'));
            return $this->redirect(['action' => 'index']);
        }

        $ProjectMaster = TableRegistry::get('Projectmaster');
        $ProList = $ProjectMaster->find();
//        $OptionMasterMapping = $this->OptionMasterMapping->newEntity();
        $Projects = array();
        $ProListopt = '';
        $call = 'getStatus(this.value);';
        $ProListopt = '<select name="ProjectId" id="ProjectId" class="form-control" onchange="' . $call . '"><option value=0>--Select--</option>';
        foreach ($ProList as $query):
            $Projects[$query->ProjectId] = $query->ProjectName;
            $ProListopt.='<option value="' . $query->ProjectId . '">';
            $ProListopt.=$query->ProjectName;
            $ProListopt.='</option>';
        endforeach;
        $assigned_details_cnt = 1;
        $ProListopt.='</select>';

        $this->set(compact('ProListopt'));
        $this->set(compact('ProList'));

        // get list
        $select = "Select Top 100 ProjectId,Region,FileName,InputToStatus,CreatedDate,ResponseData from ME_InputInitiation  order by CreatedDate desc";

        $list = $connection->execute($select)->fetchAll('assoc');

        $this->set('list', $list);
        $this->set('Projects', $Projects);
        $this->set('basefilepath', 'inputfiles');
        $ProdDB_PageLimit = 20;

        $this->set('ProdDB_PageLimit', $ProdDB_PageLimit);
    }

    function ajaxStatus() {

        echo $region = $this->Inputinitiate->find('status', ['ProjectId' => $_POST['ProjectId']]);
        exit;
    }

}
