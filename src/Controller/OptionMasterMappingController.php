<?php

/**
 * Form : ProductionFieldsMapping
 * Developer: Mobius
 * Created On: Oct 17 2016
 * class to get Input status of a file
 */

namespace App\Controller;

use Cake\ORM\TableRegistry;

class OptionMasterMappingController extends AppController {

    /**
     * to initialize the model/utilities gonna to be used this page
     */
    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function index() {

//        if($this->request->data['submit']=='Submit') {
//           // pr($this->request->data);exit;
//            $this->ProductionFieldsMapping->InsertAttributeMapping($this->request->data);
//            $this->Session->setFlash('Entered Data Successfully Saved!','flash_good');
//        }
        $session = $this->request->session();
        $user_id = $session->read('user_id');
        if ($this->request->is('post')) {
            $OptionMasterMaptable = TableRegistry::get('MeDropdownMapping');
            $ProjectId = $this->request->data('ProjectId');
            $RegionId = $this->request->data('RegionId');
            $ModuleId = $this->request->data('ModuleId');
            $PrimaryAttributeId = $this->request->data('PrimaryAttributeId');
            $SecondaryAttributeId = $this->request->data('SecondaryAttributeId');
            $count = $this->request->data('count');
            $PrimaryAttributeId = explode('_', $PrimaryAttributeId);
            $ParentPaAtId = $PrimaryAttributeId[0];
            $ParentAtId = $PrimaryAttributeId[1];
            $SecondaryAttributeId = explode('_', $SecondaryAttributeId);
            $SecondaryPaAtId = $SecondaryAttributeId[0];
            $SecondaryAtId = $SecondaryAttributeId[1];
            $existing = array(
                'ProjectId' => $ProjectId,
                'RegionId' => $RegionId,
                'ModuleId' => $ModuleId,
                'Parent_ProjectAttributeMasterId' => $ParentPaAtId,
                'Parent_AttributeMasterId' => $ParentAtId,
                'Child_ProjectAttributeMasterId' => $SecondaryPaAtId,
                'Child_AttributeMasterId' => $SecondaryAtId
            );
            $OptionMasterMaptable->deleteAll($existing);
            for ($i = 0; $i < $count; $i++) {
                $parentid = $this->request->data('parentid_' . $i);
                $childid = $this->request->data('childid_' . $i);
                $countchildid = count($childid);
                for ($j = 0; $j < $countchildid; $j++) {
                    $OptionMasterMap = $OptionMasterMaptable->newEntity();
                    $OptionMasterMap->CreatedDate = date("Y-m-d H:i:s");
                    $OptionMasterMap->RecordStatus = '1';
                    $OptionMasterMap->CreatedBy = $user_id;
                    $OptionMasterMap->ProjectId = $ProjectId;
                    $OptionMasterMap->RegionId = $RegionId;
                    $OptionMasterMap->ModuleId = $ModuleId;
                    $OptionMasterMap->Parent_AttributeMasterId = $ParentAtId;
                    $OptionMasterMap->Parent_ProjectAttributeMasterId = $ParentPaAtId;
                    $OptionMasterMap->Child_AttributeMasterId = $SecondaryAtId;
                    $OptionMasterMap->Child_ProjectAttributeMasterId = $SecondaryPaAtId;
                    $OptionMasterMap->Parent_Dp_MasterId = $parentid;
                    $OptionMasterMap->Child_Dp_MasterId = $childid[$j];
                    //$OptionMasterMap = $OptionMasterMaptable->patchEntity($OptionMasterMap, $data);
                    $OptionMasterMaptable->save($OptionMasterMap);
                }
            }
            $this->Flash->success(__('List Values Mapping has been saved.'));
            return $this->redirect(['action' => 'index']);
        }

        $ProjectMaster = TableRegistry::get('Projectmaster');
        $ProList = $ProjectMaster->find();
        $OptionMasterMapping = $this->OptionMasterMapping->newEntity();
        $ProListopt = '';
        $call = 'getRegion(this.value);';
        $ProListopt = '<select name="ProjectId" id="ProjectId" class="form-control" onchange="' . $call . '"><option value=0>--Select--</option>';
        foreach ($ProList as $query):
            $ProListopt.='<option value="' . $query->ProjectId . '">';
            $ProListopt.=$query->ProjectName;
            $ProListopt.='</option>';
        endforeach;
        $assigned_details_cnt = 1;
        $ProListopt.='</select>';


        $this->set(compact('ProListopt'));
        $this->set(compact('ProList'));
    }

    function ajaxregion() {
        echo $region = $this->Optionmastermapping->find('region', ['ProjectId' => $_POST['ProjectId']]);
        exit;
    }

    function ajaxmodule() {
        echo $module = $this->Optionmastermapping->find('module', ['ProjectId' => $_POST['ProjectId']]);
        exit;
    }

    function ajaxloadattribute() {
        echo $optionattribute = $this->Optionmastermapping->find('optionattribute', ['PrimaryId' => $_POST['PrimaryId'], 'SecondaryId' => $_POST['SecondaryId'], 'ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'ModuleId' => $_POST['ModuleId']]);
        exit;
    }

    function ajaxattributeids() {
        $this->loadModel('OptionMastersMapping');
        echo $attributeids = $this->OptionMastersMapping->find('attributeids', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId']]);
        exit;
    }

}
