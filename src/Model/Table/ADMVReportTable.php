<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Query;
use Cake\Datasource\ConnectionManager;

class ADMVReportTable extends Table {

    public function initialize(array $config) {
        $this->table('MV_UserGroupMapping');
        $this->primaryKey('Id');
    }



}
