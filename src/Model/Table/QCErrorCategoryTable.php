<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Query;
use Cake\Datasource\ConnectionManager;

class QCErrorCategoryTable extends Table {

    public function initialize(array $config) {
        $this->table('MV_QC_ErrorCategoryMaster');
        $this->primaryKey('Id');
        $this->addBehavior('Timestamp');
    }

    public function findGetcategory(Query $query, array $options) {
        $Id = $options[0];
        $connection = ConnectionManager::get('default');
        $CategoryList = $connection->execute("select * from MV_QC_ErrorCategoryMaster where Id = $Id ");
        $CategoryList = $CategoryList->fetchAll('assoc');
        $i = 0;
        foreach ($CategoryList as $pass) {
            $attr[$i]['Id'] = $pass['Id'];
            $attr[$i]['ErrorCategoryName'] = $pass['ErrorCategoryName'];
            $i++;
        }
        return $attr;
    }

    public function findGetsubcategory(Query $query, array $options) {
        $Id = $options[0];
        $connection = ConnectionManager::get('default');
        $CategoryList = $connection->execute("select * from MV_QC_ErrorSubCategoryMaster where MV_QC_ErrorSubCategoryMaster.ErrorCatId = $Id and MV_QC_ErrorSubCategoryMaster.RecordStatus = 1");
        $CategoryList = $CategoryList->fetchAll('assoc');
        $i = 0;
        foreach ($CategoryList as $pass) {
            $attr[$i]['ErrorCatId'] = $pass['ErrorCatId'];
            $attr[$i]['SubCategoryName'] = $pass['SubCategoryName'];
            $i++;
        }
        return $attr;
    }

    public function subcategorylist() {
        $connection = ConnectionManager::get('default');
        $CategoryList = $connection->execute("select MV_QC_ErrorSubCategoryMaster.ErrorCatId, MV_QC_ErrorSubCategoryMaster.RecordStatus,STUFF((SELECT  ', ' + SubCategoryName FROM MV_QC_ErrorSubCategoryMaster p1 WHERE MV_QC_ErrorSubCategoryMaster.ErrorCatId = p1.ErrorCatId and p1.RecordStatus = 1 FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)')      ,1,1,'') as SubCategoryName from MV_QC_ErrorSubCategoryMaster where MV_QC_ErrorSubCategoryMaster.RecordStatus = 1 group by MV_QC_ErrorSubCategoryMaster.ErrorCatId, MV_QC_ErrorSubCategoryMaster.RecordStatus");
        $CategoryList = $CategoryList->fetchAll('assoc');
        return $CategoryList;
    }

}
