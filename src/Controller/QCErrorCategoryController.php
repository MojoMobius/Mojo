<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class QCErrorCategoryController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function index() {
        if (isset($this->request->data['check_submit'])) {
            $QCErrorCategorytable = TableRegistry::get('Qcerrorcategory');
            $Id = $this->request->data['ID'];
            $CategoryName = $this->request->data('CategoryName');
            $RecordStatus = '1';
            $session = $this->request->session();
            $CreatedBy = $session->read('user_id');
            $CreatedDate = date('Y-m-d H:i:s');
            $user_id = $this->request->session()->read('user_id');
            $connection = ConnectionManager::get('default');
            $queries = $connection->execute("SELECT ErrorCategoryName FROM MV_QC_ErrorCategoryMaster where RecordStatus = 1")->fetchAll('assoc');
            $Queriesresult = array_map('current', $queries);
            $result = array_intersect($CategoryName, $Queriesresult);
            $DispArray = json_encode($result);
            $str = str_replace(array('[', ']'), " ", $DispArray);
            $string = str_replace('"', '', $str);
            $string = "<strong>" . $string . "</strong>";

            if (empty($result)) {
                for ($i = 0; $i < count($CategoryName); $i++) {

                    $QCErrorCategory = $QCErrorCategorytable->newEntity();
                    $QCErrorCategory->CreatedDate = date("Y-m-d H:i:s");
                    $QCErrorCategory->RecordStatus = '1';
                    $QCErrorCategory->CreatedBy = $user_id;
                    $QCErrorCategory->ProjectId = $ProjectId;
                    $QCErrorCategory->ErrorCategoryName = $CategoryName[$i];

                    $QCErrorCategorytable->save($QCErrorCategory);
                }
                $this->Flash->success(__('Category Name has been saved.'));
            } else {
                $this->Flash->error(__($string . 'Category Name already exists.'));
            }

            return $this->redirect(['action' => 'index']);
        }

        $connection = ConnectionManager::get('default');
        $QCErrorCategory = $connection->execute("select Id, ErrorCategoryName from MV_QC_ErrorCategoryMaster where RecordStatus = 1")->fetchAll('assoc');
        $i = 0;
        $QC_Category = array();
        foreach ($QCErrorCategory as $user):
            $QC_Category[$i]['Id'] = $user['Id'];
            $QC_Category[$i]['ErrorCategoryName'] = $user['ErrorCategoryName'];
            $i++;
        endforeach;

        $this->set(compact('QC_Category'));

        $SubCategory = $this->QCErrorCategory->subcategorylist();
        $QC_Error_Category = array();
        foreach ($SubCategory as $user):
            $QC_Error_Category[$user['ErrorCatId']] = $user['SubCategoryName'];
        endforeach;

        $this->set(compact('QC_Error_Category'));
    }

    public function delete($id = null) {
        $CategoryName = $this->QCErrorCategory->get($id);
        if ($id) {
            $user_id = $this->request->session()->read('user_id');

            $connection = ConnectionManager::get('default');
            $SubCategoryName = $connection->execute("UPDATE MV_QC_ErrorSubCategoryMaster SET ModifiedBy = $user_id, RecordStatus = 0 where ErrorCatId='" . $id . "' ");

            $CategoryName = $this->QCErrorCategory->patchEntity($CategoryName, ['ModifiedBy' => $user_id, 'ModifiedDate' => date("Y-m-d H:i:s"), 'RecordStatus' => 0]);
            if ($this->QCErrorCategory->save($CategoryName)) {
                $this->Flash->success(__('Category Name deleted Successfully'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set('CategoryName', $CategoryName);
        $this->render('index');
    }

    public function edit($id = null) {
        $QCErrorCategory = $this->QCErrorCategory->get($id);

        $Id = $this->request->params['pass'][0];
        $category_name = $this->QCErrorCategory->find('getcategory', [$Id]);

        $category_name_cnt = count($category_name);
        $this->set(compact('category_name_cnt'));
        $this->set(compact('category_name'));

        $sub_category_name = $this->QCErrorCategory->find('getsubcategory', [$Id]);
        $sub_category_name_cnt = count($sub_category_name);
        $this->set(compact('sub_category_name_cnt'));
        $this->set(compact('sub_category_name'));

        if ($this->request->is(['post', 'put'])) {

            $CategoryName = $this->request->data('CategoryName');
            $SubCategoryName = $this->request->data('SubCategoryName');
            $user_id = $this->request->session()->read('user_id');
            $createddate = date("Y-m-d H:i:s");

            $connection = ConnectionManager::get('default');
            $queries = $connection->execute("SELECT ErrorCategoryName FROM MV_QC_ErrorCategoryMaster where RecordStatus = 1 and Id != $id")->fetchAll('assoc');
            $Queriesresult = array_map('current', $queries);
            //$catCompare = explode(" ", $CategoryName);
            $result = array_intersect($catCompare, $Queriesresult);

            $DispArray = json_encode($result);
            $str = str_replace(array('[', ']'), " ", $DispArray);
            $string = str_replace('"', '', $str);
            $string = "<strong>" . $string . "</strong>";

            if (empty($result)) {
                $QCErrorCategory = $this->QCErrorCategory->patchEntity($QCErrorCategory, ['ErrorCategoryName' => $CategoryName, 'ModifiedBy' => $user_id, 'ModifiedDate' => date("Y-m-d H:i:s")]);
                $this->QCErrorCategory->save($QCErrorCategory);
                $this->Flash->success(__('Category Name has been Updated.'));

                $connection = ConnectionManager::get('default');
                $existingValues = $connection->execute("DELETE FROM MV_QC_ErrorSubCategoryMaster WHERE ErrorCatId='" . $id . "' ");

                for ($i = 0; $i < count($SubCategoryName); $i++) {
                    $connection = ConnectionManager::get('default');
                    $InsertSubCategory = $connection->execute("Insert INTO MV_QC_ErrorSubCategoryMaster (ErrorCatId,SubCategoryName,RecordStatus,CreatedBy)values ($id,'$SubCategoryName[$i]',1,$user_id )");
                }
            } else {
                $this->Flash->error(__($string . 'Category Name already exists.'));
            }

            return $this->redirect(['action' => 'index']);
        }
    }

}
