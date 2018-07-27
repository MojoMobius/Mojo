<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use App\Model\Entity\User;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Entity;

class AttributeconfigTable extends Table {

//    public function initialize(array $config)
//    {
//        $this->table('ME_ClientOutputTemplateMapping');
//        $this->table('ME_ProductionTemplateMaster');
////        $this->table('RegionAttributeMapping');
////        $this->table('ProjectAttributeMaster');
//        $this->primaryKey('Id');
//    }
    public function initialize(array $config) {
        $this->table('ProjectMaster');
        $this->primaryKey('Id');
    }

    public static function defaultConnectionName() {
        return 'd2k';
    }

     public function findinsertdata(Query $query, array $options) {
         
        $connection = ConnectionManager::get('default');
         $ProjectId=$options['ProjectId'];
         $RegionId=$options['RegionId'];
         $UserId=$options['UserId'];
         $Attarr=$options['attribute'];
         $Attprojarr=$options['projattribute'];
         $CreatedDate=date('Y-m-d H:i:s');
         
         $seldata = $connection->execute("SELECT Id FROM RentCalc_Config WHERE ProjectId='".$ProjectId."'")->fetchAll('assoc'); 
        if(!empty($seldata)){
          
             $productionjob = $connection->execute("UPDATE RentCalc_Config set Commencement_Date_AttrId='$Attarr[0]',Expiration_Date_AttriId='$Attarr[1]',Base_Rent_Initial_amount_AttriId='$Attarr[2]',Rent_Inc_AttrId='$Attarr[3]',Commencement_Date_Proj_AttrId='$Attprojarr[0]',Expiration_Date_Proj_AttriId='$Attprojarr[1]',Base_Rent_Initial_amount_Proj_AttriId='$Attprojarr[2]',Rent_Inc_Proj_AttrId='$Attprojarr[3]',ModifiedDate='$CreatedDate',ModifiedBy='$UserId' WHERE ProjectId='".$ProjectId."'");
        }
        else{
        
         $productionjob = $connection->execute("INSERT INTO RentCalc_Config(ProjectId,Regionid,Commencement_Date_AttrId,Expiration_Date_AttriId,Base_Rent_Initial_amount_AttriId,Rent_Inc_AttrId,Commencement_Date_Proj_AttrId,Expiration_Date_Proj_AttriId,Base_Rent_Initial_amount_Proj_AttriId,Rent_Inc_Proj_AttrId,RecordStatus,CreatedDate,CreatedBy)values ($ProjectId,$RegionId,$Attarr[0],$Attarr[1],$Attarr[2],$Attarr[3],$Attprojarr[0],$Attprojarr[1],$Attprojarr[2],$Attprojarr[3],'1','$CreatedDate','$UserId')");
        }
        
     
     }
     public function findproname(Query $query, array $options){
          $ProList=$options['Prolist'];
          $ProjectId=$options['ProjectId'];
         
          $ProListFinal='<select name="ProjectId" id="ProjectId" class="form-control " onchange="getattribute(this.value);"><option value="0">--Select Project--</option>';
          
        foreach ($ProList as $values):
            $selected="";
        if($ProjectId == $values['ProjectId']){
            $selected="selected";
        }
            $ProListFinal.='<option value='.$values['ProjectId'].' '.$selected.'>'.$values['ProjectName'].'</option>';
        endforeach;
         $ProListFinal.='</select>';
         
         return $ProListFinal;
     }

    public function findProjectcheck(Query $query, array $options) {
        //$connection = ConnectionManager::get('d2k');
        //$Field = $connection->execute("select ProjectMaster.ProjectName,ME_DropdownMaster.ProjectId,ME_DropdownMaster.ProjectAttributeMasterId,ME_DropdownMaster.AttributeMasterId,STUFF((SELECT  ',' + DropDownValue FROM ME_DropdownMaster p1 WHERE ME_DropdownMaster.AttributeMasterId = p1.AttributeMasterId ORDER BY p1.OrderId FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)')      ,1,1,'') as DropDownValue from ProjectMaster,ME_DropdownMaster where ProjectMaster.ProjectId = ME_DropdownMaster.ProjectId group by ME_DropdownMaster.ProjectId,ME_DropdownMaster.AttributeMasterId,ME_DropdownMaster.ProjectAttributeMasterId,ProjectMaster.ProjectName");
        //$Field = $Field->fetchAll('assoc');
        $query = $this->find()
                ->select(['Projectconfig.Id'])
                ->where(['Projectconfig.Id' => $options['ProjectId']])
        //->order(['ProjectAttributeMaster.DisplayOrder'])
        ;
        //return $Field;
        $query->first();
        foreach ($query as $pass) {
            $ProjectId = $pass['Id'];
        }
        return $ProjectId;
    }
    public function findGetMojoProjectNameList(Query $query, array $options) {
        $proId = $options['proId'];
       // print_r($proId);exit;

        $test = implode(',', $options['proId']);
        $connection = ConnectionManager::get('default');
        $Field = $connection->execute('select ProjectName,ProjectId from ProjectMaster where ProjectId in (' . $test . ') AND RecordStatus = 1');
        $Field = $Field->fetchAll('assoc');
        return $Field;
    }

//    public function attributelist()
//    {
//        $connection = ConnectionManager::get('default');
//        $AttributeList = $connection->execute("select ProjectMaster.ProjectName,ME_DropdownMaster.ProjectId,ME_DropdownMaster.ProjectAttributeMasterId,ME_DropdownMaster.AttributeMasterId,STUFF((SELECT  ',' + DropDownValue FROM ME_DropdownMaster p1 WHERE ME_DropdownMaster.AttributeMasterId = p1.AttributeMasterId ORDER BY p1.OrderId FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)')      ,1,1,'') as DropDownValue from ProjectMaster,ME_DropdownMaster where ProjectMaster.ProjectId = ME_DropdownMaster.ProjectId group by ME_DropdownMaster.ProjectId,ME_DropdownMaster.AttributeMasterId,ME_DropdownMaster.ProjectAttributeMasterId,ProjectMaster.ProjectName");
//        $AttributeList = $AttributeList->fetchAll('assoc');
//        return $AttributeList;
//    }
}
