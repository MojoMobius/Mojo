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
class GetInvalidViewController extends AppController {

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
        $this->loadModel('GetJob');
        // $this->loadHelper('Html');
        $this->loadComponent('RequestHandler');
    }

    //---------------GetInvalid--------------------
    function ajaxGetInvalid(){
        $this->layout = 'ajax';
        error_reporting(E_PARSE);
        $connection = ConnectionManager::get('default');
        $val = $this->GetInvalidView->find('GetInvalidView',$_POST);
        echo $val;
        exit;
    }
    
    function ajaxGetInvalidDomainUrl(){
        $this->layout = 'ajax';
        error_reporting(E_PARSE);
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $ProjectId = $session->read("ProjectId");
        $val = $this->GetInvalidView->find('GetInvalidDomainUrl',['DomainId' => $_POST['DomainId'], 'DomainUrl' => $_POST['DomainUrl'], 'ProjectId' => $ProjectId, 'RegionId' => $_POST['RegionId'], 'DomainUrlMonthYear' => $_POST['DomainUrlMonthYear'], 'user' => $user_id]);
        //echo $val[0]['DomainUrl'];
        echo wordwrap($val[0]['DomainUrl'],15,"<br>\n");
        exit;
    }
    
    function ajaxGetInvalidDomainUrlId(){
        $this->layout = 'ajax';
        error_reporting(E_PARSE);
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $ProjectId = $session->read("ProjectId");
        $val = $this->GetInvalidView->find('GetInvalidDomainUrl',['DomainId' => $_POST['DomainId'], 'DomainUrl' => $_POST['DomainUrl'], 'ProjectId' => $ProjectId, 'RegionId' => $_POST['RegionId'], 'DomainUrlMonthYear' => $_POST['DomainUrlMonthYear'], 'user' => $user_id]);
        echo $val[0]['DomainId'];
        exit;
    }
    
    function ajaxGetInvalidInputId(){
        $this->layout = 'ajax';
        error_reporting(E_PARSE);
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $ProjectId = $session->read("ProjectId");
        $val = $this->GetInvalidView->find('GetInvalidDomainUrl',['DomainId' => $_POST['DomainId'], 'DomainUrl' => $_POST['DomainUrl'], 'ProjectId' => $ProjectId, 'RegionId' => $_POST['RegionId'], 'DomainUrlMonthYear' => $_POST['DomainUrlMonthYear'], 'user' => $user_id]);
        echo $val[0]['InputId'];
        exit;
    }
    
    function ajaxGetInvalidDomainUrlRemarks(){
        $this->layout = 'ajax';
        error_reporting(E_PARSE);
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $ProjectId = $session->read("ProjectId");
        $val = $this->GetInvalidView->find('GetInvalidDomainUrlRemarks',['DomainId' => $_POST['DomainId'], 'DomainUrl' => $_POST['DomainUrl'], 'ProjectId' => $ProjectId, 'RegionId' => $_POST['RegionId'], 'DomainUrlMonthYear' => $_POST['DomainUrlMonthYear'], 'user' => $user_id]);
        //pr($val[0]['Remarks']);
        
        echo $val[0]['Remarks'];
        exit;
    }
    
    function ajaxGetInvalidDomainUrlReason(){
        $this->layout = 'ajax';
        error_reporting(E_PARSE);
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $ProjectId = $session->read("ProjectId");
        $val = $this->GetInvalidView->find('GetInvalidDomainUrlRemarks',['DomainId' => $_POST['DomainId'], 'DomainUrlMonthYear' => $_POST['DomainUrlMonthYear'], 'DomainUrl' => $_POST['DomainUrl'], 'ProjectId' => $ProjectId, 'RegionId' => $_POST['RegionId'], 'DomainUrlMonthYear' => $_POST['DomainUrlMonthYear'], 'user' => $user_id]);
        //pr($val[0]['Reason']);
        
        echo $val[0]['Reason'];
        exit;
    }
    
    function ajaxvalidInvalid(){
        $this->layout = 'ajax';
        error_reporting(E_PARSE);
        $connection = ConnectionManager::get('default');
        $val = $this->GetInvalidView->find('UpdateInvalidDomainUrl',$_POST);
        pr($val);
        exit;
    }
    //----------------GetInvalid-------------------

}
