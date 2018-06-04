<?php

namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Datasource\ConnectionManager;

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class QCValidationReworkTable extends Table {

    public function initialize(array $config) {
        $this->table('ProductionEntityMaster');
        $this->primaryKey('Id');
        $this->addBehavior('Timestamp');
    }

    public function findQuerypost(Query $query, array $options) {

        $connection = ConnectionManager::get('default');
        $count = $connection->execute("SELECT Id FROM ME_UserQuery WHERE ProductionEntityId='" . $options['ProductionEntity'] . "' AND RecordStatus=1")->fetchAll('assoc');
        $QueryValue = str_replace("'", "''", trim($options['query']));

        if (!empty($count)) {
            $queryUpdate = "update ME_UserQuery set Query='" . $QueryValue . "'  where ProductionEntityId='" . $options['ProductionEntity'] . "' and ModuleId=$this->ModuleId";
            $connection->execute($queryUpdate);
        } else {
            $queryInsert = "Insert into ME_UserQuery (ProjectId,UserID,ProductionEntityId,ModuleId,Query,QueryRaisedDate,StatusID,RecordStatus,CreatedDate,CreatedBy) values('" . $options['ProjectId'] . "','" . $options['user'] . "','" . $options['ProductionEntity'] . "','" . $options['moduleId'] . "','" . $QueryValue . "','" . date('Y-m-d H:i:s') . "',1,1,'" . date('Y-m-d H:i:s') . "','" . $options['user'] . "')";
            $connection->execute($queryInsert);
        }
        return $options['query'];
    }

    public function findSavedata(Query $query, array $options) {
        $user_id = $this->request->session()->read('user_id');
        $updatetempFileds = '';
        $dymamicupdatetempFileds = '';

        foreach ($ProductionFields as $val) {
            $updatetempFileds.="[" . $val['AttributeMasterId'] . "]='" . $this->request->data[$val['AttributeMasterId']] . "',";
        }
        foreach ($DynamicFields as $val) {
            $dymamicupdatetempFileds.="[" . $val['AttributeMasterId'] . "]='" . $this->request->data[$val['AttributeMasterId']] . "',";
        }
        $updatetempFileds.="TimeTaken='" . $this->request->data['TimeTaken'] . "'";
        $dymamicupdatetempFileds.="TimeTaken='" . $this->request->data['TimeTaken'] . "'";
        $productionjob = $connection->execute('UPDATE Staging_1149_Data SET ' . $updatetempFileds . 'where ProductionEntity=' . $ProductionEntity . ' AND SequenceNumber=' . $_POST['SequenceNumber']);
        $Dynamicproductionjob = $connection->execute('UPDATE Staging_1149_Data SET ' . $dymamicupdatetempFileds . 'where ProductionEntity=' . $ProductionEntity);
    }

    public function findSubcategory(Query $query, array $options) {
        $connection = ConnectionManager::get('default');
        $CategoryId = $options['CategoryId'];
        $subCategory = $connection->execute("SELECT Id,SubCategoryName FROM MV_QC_ErrorSubCategoryMaster where ErrorCatId= $CategoryId")->fetchAll('assoc');

        $template = '';
        $template.='<select name="SubCategory" id="SubCategory" style= "margin-top:17px;" class="form-control"><option value=0>--Select--</option>';
        if (!empty($subCategory)) {
            foreach ($subCategory as $key => $val):
                $template.='<option value="' . $val['Id'] . '" >';
                $template.=$val['SubCategoryName'];
                $template.='</option>';
            endforeach;
            $template.='</select>';
            return $template;
        } else {
            $template.='</select>';
            return $template;
        }
    }

//    public function findLoaddropdown(Query $query, array $options) {
//        $projectId = $options['ProjectId'];
//        $path = JSONPATH . '\\ProjectConfig_' . $projectId . '.json';
//        $content = file_get_contents($path);
//        $contentArr = json_decode($content, true);
//
//        $RegionId = $options['RegionId'];
//        $AttributeMasterId = $options['AttributeMasterId'];
//        $ProjectAttributeMasterId = $options['ProjectAttributeMasterId'];
//
//        $AttrList = $contentArr['AttributeOrder'][$RegionId][$ProjectAttributeMasterId]['Options'];
//        $template = '';
//        $template.='<select name="QCValueDropdown" id="QCValueDropdown" style= "margin-top:1px;" class="form-control"><option value=0>--Select--</option>';
//        if (!empty($AttrList)) {
//            foreach ($AttrList as $key => $val):
//                $template.='<option value="' . $key . '" >';
//                $template.=$val;
//                $template.='</option>';
//            endforeach;
//            $template.='</select>';
//            return $template;
//        } else {
//            $template.='</select>';
//            return $template;
//        }
//    }

    function ajax_GetOldDatavalue($InputEntyId, $AttributeMasterId, $ProjectAttributeMasterId, $SequenceNumber) {
        $connection = ConnectionManager::get('default');
        $cmdOldData = $connection->execute("select count(*) OldDataCount from MV_QC_Comments where AttributeMasterId = $AttributeMasterId and ProjectAttributeMasterId=$ProjectAttributeMasterId and InputEntityId=$InputEntyId and SequenceNumber = $SequenceNumber and StatusID=1")->fetchAll('assoc');
        return $cmdOldData[0];
    }

    function ajax_GetRebutalvalue($InputEntyId, $AttributeMasterId, $ProjectAttributeMasterId, $SequenceNumber) {
        $connection = ConnectionManager::get('default');
        $cmdOldData = $connection->execute("select count(*) OldDataCount from MV_QC_Comments where AttributeMasterId = $AttributeMasterId and ProjectAttributeMasterId=$ProjectAttributeMasterId and InputEntityId=$InputEntyId and SequenceNumber = $SequenceNumber and StatusID=5")->fetchAll('assoc');
        return $cmdOldData[0];
    }

    public function findGetolddata(Query $query, array $options) {
        $connection = ConnectionManager::get('default');
        $AttributeMasterId = $options[0]['AttributeMasterId'];
        $ProjectAttributeMasterId = $options[0]['ProjectAttributeMasterId'];
        $InputEntityId = $options[0]['InputEntyId'];
        $SequenceNumber = $options[0]['SequenceNumber'];
        $cmdOldData = $connection->execute("select * from MV_QC_Comments where AttributeMasterId = $AttributeMasterId and ProjectAttributeMasterId= $ProjectAttributeMasterId and InputEntityId= $InputEntityId and RecordStatus = 1 and SequenceNumber=$SequenceNumber and StatusID IN (1,4,5)")->fetchAll('assoc');
        return $cmdOldData[0];
    }

}
