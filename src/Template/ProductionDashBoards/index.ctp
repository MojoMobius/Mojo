<?php

use Cake\Routing\Router
?>
<style>
    .modal-dialog{
        width:900px !important;
    }
    @media screen and (max-height: 650px) {
    #right-pane{
        height:300px!important;
        overflow-y:auto!important;
    }
    #vertical_modal {
        height:300px!important;
    }
    }
    table td input {
    width: 40px !important;
    }
    form {
    width: 100%;
    margin: 0px;
    padding: 0px;
    }
    
</style>
<div class="panel-group" id="accordion-dv" role="tablist" aria-multiselectable="true" style="margin-top:10px;">
    <div class="container-fluid">

        <div class="panel panel-default formcontent">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h3 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-dv" href="#collapseTw" aria-expanded="false" aria-controls="collapseTwo" style="text-decoration:none;">
                        <i class="more-less glyphicon glyphicon-plus"></i>
                        Production DashBoard Job Status
                    </a> 
                </h3>
            </div>
            <div id="collapseTw" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
               <?php echo $this->Form->create('', array('class' => 'form-horizontal', 'id' => 'projectforms')); ?>

                 <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Client</label>
                        <div class="col-sm-6" style="line-height: 0px;">
                             <?php
                    if ($ClientId == '') {
                       
                         echo $this->Form->input('', array('options' => $Clients, 'id' => 'ClientId', 'name' => 'ClientId', 'class' => 'form-control', 'value' => $ClientId, 'onchange' => 'getProject(this.value)'));
                       
                    } else {
                        echo $ClientId;
                    }
                    ?>
                     
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Project</label>
                        <div class="col-sm-6" style="line-height: 0px;">
                              <div id="LoadProject">
                      
                                  <?php 
                     echo $this->Form->input('', array('options' => $Projects, 'id' => 'ProjectId', 'name' => 'ProjectId', 'class' => 'form-control', 'value' => $ProjectId,'style' => 'width:220px', 'onchange' => 'getRegion(this.value);getStatus(this.value);getCengageProject(this.value);'));                      
                      
                        ?>
                              </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Region</label>
                        <div class="col-sm-6" style="line-height: 0px;">
                            <div id="LoadRegion">
                    <?php
                    if ($RegionId == '') {
                        $Region = array(0 => '--Select--');
                        echo $this->Form->input('', array('options' => $Region, 'id' => 'RegionId', 'name' => 'RegionId', 'class' => 'form-control', 'value' => $RegionId,'style' => 'width:180px', 'onchange' => 'getusergroupdetails(this.value)'));
                    } else {
                        echo $RegionId;
                    }
                    ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">User Group</label>
                        <div class="col-sm-6" style="line-height: 0px;">
                            <div id="LoadUserGroup">
                      <?php
                    if ($UserGroupId == '') {
                        $UserGroup = array(0 => '--Select--');
                        echo $this->Form->input('', array('options' => $UserGroup, 'id' => 'UserGroupId', 'name' => 'UserGroupId', 'class' => 'form-control', 'value' => $UserGroupId, 'selected' => $UserGroupId, 'onchange' => 'getresourcedetails'));
                    } else {
                        echo $UserGroupId;
                    }
                    ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">From</label>
                        <div class="col-sm-6" style="line-height: 0px;">
                      <?php
                    echo $this->Form->input('', array('id' => 'batch_from', 'name' => 'batch_from', 'class' => 'form-control','style' => 'width:180px', 'value' => $postbatch_from));
                    ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">To</label>
                        <div class="col-sm-6" style="line-height: 0px;">
                    <?php
                    echo $this->Form->input('', array('id' => 'batch_to', 'name' => 'batch_to', 'class' => 'form-control','style' => 'width:150px', 'value' => $postbatch_to));
                    ?>
                        </div>
                    </div>
                </div>

               


                <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Resource</label>
                        <div class="col-sm-6" style="line-height: 0px;">
                            <div id="LoadUserDetails">
                    <?php
                    echo $this->Form->input('', array('options' => $User, 'class' => 'form-control', 'selected' => $postuser_id, 'value' => $postuser_id, 'id' => 'user_id', 'name' => 'user_id', 'style' => 'height:120px; width:220px;', 'multiple' => true));
                    ?>
                            </div>
                        </div>
                    </div>
                </div>


                <!--        <div class="col-md-3">
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-6 control-label">Status</label>
                        <div class="col-sm-6">
                    <?php
        //echo $this->Form->input('', array('options' => $Status, 'default' => '0', 'class' => 'form-control', 'selected' => $poststatus, 'value' => $poststatus, 'id' => 'status', 'name' => 'status', 'style' => 'height:100px', 'multiple' => true));
                    ?>
                        </div>
                    </div>
                        </div>-->

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Status</label>
                        <div class="col-sm-6" style="line-height: 0px;">
                            <div id="LoadStatus">
                        <?php echo $this->Form->input('', array('options' => $Status, 'selected' => $poststatus, 'value' => $poststatus, 'id' => 'status', 'name' => 'status', 'multiple' => true, 'class' => 'form-control', 'style' => 'height:120px; width:220px;')); ?>
                            </div>
                        </div>
                    </div>
                </div>
 <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Search</label>
                        <div class="col-sm-6" style="line-height: 0px;">
                  <?php
            echo $this->Form->input('', array('id' => 'query', 'placeholder' => 'Search', 'name' => 'query', 'class' => 'form-control', 'value' => $postquery));
            ?>
                        </div>
                    </div>
                </div>


                <div class="form-group" style="text-align:center;">
                    <div class="col-sm-12">
            <?php
            echo $this->Form->submit('Job Status', array('id' => 'check_submit', 'name' => 'check_submit', 'value' => 'Job Status', 'style' => 'margin-left:250px;width:100px;float:left;padding-bottom:2 px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return Mandatory()'));
            
//            echo $this->Form->submit('Productivity Report', array('id' => 'productivityReport_submit', 'name' => 'productivityReport_submit', 'value' => 'Job Status', 'style' => 'margin-left:10px;width:150px;float:left;padding-bottom:2 px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return Mandatory()'));
//            
//            echo $this->Form->submit('Module Summary', array('id' => 'ModuleSummary_submit', 'name' => 'ModuleSummary_submit', 'value' => 'Job Status', 'style' => 'margin-left:10px;width:120px;float:left;padding-bottom:2 px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return Mandatory()'));

            echo $this->Form->button('Load', array('id' => 'load_data', 'name' => 'load_data', 'value' => 'Load', 'style' => 'margin-left:10px;float:left;display:inline;padding-bottom:6px;', 'class' => 'btn btn-primary btn-sm', 'type' => 'submit'));
            
            if(isset($RunReportSPError)) {
                echo $this->Form->button('Report Generate', array('id' => 'reportSP_data', 'name' => 'reportSP_data', 'value' => 'Report Generate', 'style' => 'margin-left:10px;float:left;display:inline;padding-bottom:6px;background-color: #b03737 !important;', 'class' => 'btn btn-primary btn-sm', 'type' => 'submit'));
            }
            
            echo $this->Form->button('Clear', array('id' => 'Clear', 'name' => 'Clear', 'value' => 'Clear', 'style' => 'margin-left:10px;float:left;display:inline;padding-bottom:6px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return ClearFields()', 'type' => 'button'));
             
            
            
            echo $this->Form->submit('Export Job Status Results', array('id' => 'downloadFile', 'name' => 'downloadFile', 'value' => 'downloadFile', 'style' => 'margin-left:35px;float:left;display:inline;padding-bottom:6px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return Mandatory()', 'type' => 'submit'));
             
            ?>
                        <span id='xlscnt' style="float:right; margin-right:20px; margin-top:27px;display:none;">
                            <button type='submit' name='downloadFile' id='downloadFile' value='downloadFile' onclick="return Mandatory();"><img width="20" height="20" src="img/file-xls.jpg" ><img width="12" height="12" src="img/down_arrow.gif"></button>
                        </span>

                <?php 
            // echo $this->Form->button('Reload', array( 'id' => 'Reload', 'name' => 'Reload', 'value' => 'Reload','style'=>'margin-left:10px;float:left;display:inline;padding-bottom:6px;','class'=>'btn btn-warning','type'=>'submit'));

            if (count($Production_dashboard) > 0) {
                echo '<br>';
                echo '<br>';
                echo '<br>';
                ?>          
                    </div>    

                </div>

            <?php
        }
        echo $this->Form->end();
        ?>
            </div>    
        </div>
    </div>
</div>
<style>.Zebra_DatePicker_Icon{left:200px !important;}</style>
<?php
//echo $error; 
//pr($Production_dashboard);

if (count($Production_dashboard) > 0) {
?>
<div class="container-fluid">
    <div class="bs-example">
        <div id="vertical">
            <div id="top-pane">
                <div id="horizontal" style="height: 100%; width: 100%;">
                    <div id="left-pane" class="pa-lef-10">
                        <div class="pane-content" >
                            
                              <input type="button" id="prioritize" name="prioritize" value="Allocate/Prioritize" style="margin:0px 30px 30px;display:inline;" class="btn btn-primary btn-sm" onclick="priority();" data-rel="page-tag" data-target="#exampleFillPopup" data-toggle="modal">
                            <input type="hidden" name="UpdateId" id="UpdateId">
                            <button style="float:right; height:18px; visibility: hidden; margin-right:15px;" type='hidden' name='downloadFile' id='downloadFile' value='downloadFile'></button>
                            <table style='width:100%;' class="table table-striped table-center" id='example'>
                                <thead>
                                    <tr>
                                        <th colspan="7"></th>
                                            <?php
                                                foreach ($module as $key => $val) {
                                                if(($moduleConfig[$key]['IsAllowedToDisplay']==1) && ($moduleConfig[$key]['IsModuleGroup']==1)){
                                            ?>
                                                <th colspan="7" align='center'><?php echo $val; ?></th>
                                            <?php
                                                }
                                            }
                                            ?>
                                    </tr>
                                    <tr class="Heading">
                                        <th class="Cell" width="10%" hidden="">InputEntityId</th> 
                                        <th class="Cell" width="7%"></th>
                                        <th class="Cell" width="10%">Project Name</th> 
                                        <th class="Cell" width="10%">Region</th> 
                                        <th class="Cell" width="10%">Id</th>
                                        <th class="Cell" width="10%">Status</th>
                                        <th class="Cell" width="7%">Priority</th>
                                            <?php
                                            foreach ($module as $key => $val){
                                               if(($moduleConfig[$key]['IsAllowedToDisplay']==1) && ($moduleConfig[$key]['IsModuleGroup']==1)){
                                                        ?>
                                        <th class="Cell" width="10%">Start Date</th>
                                        <th class="Cell" width="10%">End Date</th>
                                        <th class="Cell" width="10%">Time Taken</th>
                                        <th class="Cell" width="10%">User Id</th>
                                        <th class="Cell" width="10%">User Group</th>
                                                        <?php
                                                }
                                            }
                                            ?>
                                        <th class="Cell" width="10%">Reallocate</th>   
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($Production_dashboard as $inputVal => $input):
                                        $IDValue = $input['Id'];
                                        $statusName = $Status[$input['StatusId']];
                                        $showDataRow = false;
                                        foreach ($module as $key=>$val){
                                            if(($moduleConfig[$key]['IsAllowedToDisplay']==1) && ($moduleConfig[$key]['IsModuleGroup']==1)){
                                                if(!empty($timeDetails[$key][$IDValue]))
                                                    $showDataRow = true;
                                            }
                                        }
                                        $posReady = strpos(strtolower($statusName), 'ready');
//                                        if($showDataRow === true || $posReady !== false) {
                                        //if(1==1) {
                                            $search_status = $Status[$input['StatusId']];
                                            //pr($status_list_module);
                                            foreach ($module_ids as $keys => $value) {
                                                $searchlist = $status_list_module[$value];
                                                $searchlist = array_map('strtolower', $searchlist);
                                                $search_status = strtolower($search_status);
                                                $moduleid_status = array_search($search_status, $searchlist);
                                                if ($moduleid_status !== FALSE) {
                                                    $module[$i] = $value;
                                                }
                                            }
                                            ?>
                                    <tr>

                                        <td hidden=""><?php echo $input['InputEntityId']; ?></td>
                                        <td><input type="checkbox" class="Pri_ids" name="priority[]" id="priority.<?php echo $input['Id']; ?>" value="<?php echo $input['Id'];?>">
                                        <input type="hidden" class="domain_ids" name="domain[<?php echo $input['Id'];?>]" id="domain.<?php echo $input['domainId']; ?>" value="<?php echo $input['domainId'];?>">
                                        
                                        <input type="hidden" class="status_ids" name="status[<?php echo $input['Id'];?>]" id="status.<?php echo $input['StatusId']; ?>" value="<?php echo $input['StatusId'];?>">
                                         <input type="hidden" class="pri_saved_ids" name="pri_saved[<?php echo $input['Id'];?>]" id="pri_saved.<?php echo $input['priority']; ?>" value="<?php echo $input['priority'];?>">
                                        </td>
                                        <td><?php echo $Projects[$input['ProjectId']]; ?></td>
                                        <td><?php echo $region[$input['RegionId']]; ?></td>
                                        <td><?php echo $input['domainId']; ?></td>
                                        <td><?php echo $Status[$input['StatusId']]; ?></td>
                                        <td><?php echo $input['priority']; ?></td>
                                        <?php
                                            foreach ($module as $key=>$val){
                                            if(($moduleConfig[$key]['IsAllowedToDisplay']==1) && ($moduleConfig[$key]['IsModuleGroup']==1)){
                                        ?>
                                            <td class="Cell" width="10%"><?php echo $timeDetails[$key][$input['Id']]['Start_Date'] ?></td>
                                            <td class="Cell" width="10%"><?php echo $timeDetails[$key][$input['Id']]['End_Date'] ?></td>
                                            <td class="Cell" width="10%"><?php echo $timeDetails[$key][$input['Id']]['TimeTaken'] ?></td>
                                            <td class="Cell" width="10%"><?php echo $User[$timeDetails[$key][$input['Id']]['UserId']]; ?></td>
                                            <td class="Cell" width="10%"><?php echo $timeDetails[$key][$input['Id']]['UserGroupId']; ?></td>
                                            <?php
                                            }
                                        }

                                            $domain = $input['domainId'];
                                            $projectId = $input['ProjectId'];
                                            $status = $input['StatusId'];
                                            $InputEntityId = $input['InputEntityId'];
                                            $AssignedTo = $input['UserId'];
                                            $options = array($i => '');
                                            $teset = '';
                                            $attributes = array('name' => 'test', 'label' => false, 'hidden' => false, 'id' => 'radioReallocate', 'class' => 'radio', 'onclick' => "reallocate('$projectId','$status',$i);");
//                                            if ($input['StatusId'] == 6 || $input['StatusId'] == 14) {
//                                                $teset = "reallocate('$projectId','$status',$i);";
//                                            }
//                                            if ($input['StatusId'] === 6 && $input['UserId'] != '') {
//                                                $teset = $this->Form->radio('', $options, $attributes);
//                                            }
//                                            $teset = "reallocate('$projectId','$status',$i);";
                                        ?>
                                        <td class="Cell lastrow" overflow="hidden" width="10%"> <?php if($input['StatusId']==$queryStatus){ ?> 
                                            <a href="#popup1"> <input type="radio" name="reallocate" onclick="reallocate('<?php echo $InputEntityId; ?>', '<?php echo $module[$i]; ?>')"></a><?php } ?> 
                                        </td>
                                    </tr>
                                    <?php
//                                        }
                                    $i++;
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
echo $this->Form->end();
?>

<div id="popup1" class="overlay" >
    <div class="popup" class="white_content">
        <div class="form-group-sm allocation_popuphgt" style="height:160px;">
            <div align="center"><span id="LoadResult"></span></div>
            <div align="center" class="allocation_popuptitle" style="margin-top:-12px;"><h4><b>Reallocation</b></h4></div><br>
            <a class="close" href="#">&times;</a>
            <!--            <label class="col-sm-4 control-label">Domain Id</label>-->
            <!--            <div class="col-md-3">
            
                            <label id='DomainId'></label>
            
                        </div></br>-->
            <!--            <label class="col-sm-4 control-label">Assigned To</label>
                        <div class="col-md-3">
                            <label id='AssignedTo'>-</label>
                        </div>-->
            <input type="hidden" name="moduleids" id="moduleids" value="">
            <input type="hidden" name="inputentityids" id="inputentityids" value="">

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="inputEmail3" style="margin-top: 15px; color:#1b1717;" class="col-sm-3 control-label"><b>Allocate To</b></label>
                    <div class="col-sm-6" style="line-height: 0px;">
                      <?php
                echo $this->Form->input('', array('options' => $User, 'default' => '0', 'class'=>'form-control','id' => 'allocateTo', 'name' => 'allocateTo'));
                ?>
                    </div>
                </div>
            </div>

            <label class="col-sm-4 control-label">&nbsp;</label>

            <div class="form-group" style="text-align:center;">
                <div class="col-sm-12">
               <?php echo $this->Form->submit('Reallocate', array('id' => 'Reallocate', 'name' => 'Reallocate', 'value' => 'Reallocate', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'reallocateClose()')); ?>
                </div>
            </div>


            <?php //echo $this->Form->end();?>
            &nbsp;


        </div>
    </div></div>

	 <!-- Popup new Modal -->
<div class="modal fade modal-fill-in" id="exampleFillPopup" aria-hidden="false" aria-labelledby="exampleFillInHandson" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                        <h4 class="modal-title" id="exampleFillInHandsonModalTitle">Priority/Job Allocation</h4>
                    </div>
                    <div class="modal-body">
                        <div  class="container-fluid" style="margin-bottom:-10px;">
                            <div id="vertical_modal">
                                <div id="top-pane">
                                    <div id="horizontal" style="height: 100%; width: 100%;">
                                        <div id="right-pane">
                                           <div class="hot">


                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer"> <input type="button" value="Submit" style="margin:0px 30px 30px;display:inline;" class="btn btn-primary btn-sm" onclick="prioritysubmit();" ></div>
                    
                </div>
            </div>
        </div>
       
        <!-- Popup new Modal -->
<div id="fade" class="black_overlay"></div>
<?php
//pr($productionjobNew);
echo $this->Form->end();
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#vertical").kendoSplitter({
            orientation: "vertical",
            panes: [
                {collapsible: false},
                {collapsible: false, size: "100px"},
                {collapsible: false, resizable: false, size: "100px"}
            ]
        });

        $("#horizontal").kendoSplitter({
            panes: [
                {collapsible: true},
                {collapsible: false},
                {collapsible: true}
            ]
        });
    });
</script>
<style>
    #vertical {
        height: 750px;
        margin: 0 auto;
    }
    #left-pane,#top-pane  { background-color: rgba(60, 70, 80, 0.05); }
    #left-pane{padding-top:12px !important};
    .pane-content {
        padding: 0 10px;
    }
    .lastrow label{position:relative !important;}
</style>
<script type="text/javascript">
    $(document).ready(function (projectId) {
        
        var sessionProject = "<?php echo $sessionProjectId; ?>";
        
        //alert(sessionProject);
//        $('#productivityReport_submit').hide();
//        $('#ModuleSummary_submit').hide();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'ProductionDashBoards', 'action' => 'ajaxcengageproject')); ?>",
            data: ({projectId: sessionProject}),
            dataType: 'text',
            async: false,
            success: function (result) {

                if(result != 0){
                    $('#productivityReport_submit').hide();
                    $('#ModuleSummary_submit').hide();
                }else{
                    $('#productivityReport_submit').show();
                    $('#ModuleSummary_submit').show();
                }
                //document.getElementById('LoadStatus').innerHTML = result;

                // document.getElementById('RegionId').value = result;
            }
        });

<?php
$js_array = json_encode($ProdDB_PageLimit);

echo "var mandatoryArr = " . $js_array . ";\n";
?>
        var pageCount = mandatoryArr;
        tables = $('#example').DataTable({
//            "pagingType": "simple_numbers",
//            "bInfo": true,
//            "bFilter": false,
//             "dom": '<"top"irflp>rt<"bottom"irflp><"clear">',
//            "pageLength": mandatoryArr,
//*******show entry data table bottom dropdown **************//
//            "sDom": 'Rlifrtlip',  ####Important###
            "sPaginationType": "full_numbers",
            "sDom": 'Rlifprtlip',
            "bStateSave": true,
            "bFilter": true,
            //"scrollY": 300,
//            "scrollX": true,
            "aoColumnDefs": [
                {"bSearchable": false, "aTargets": [6]}
            ]
        });
//{ "bSearchable":false, "aTargets": [0,6,7] }
//{ "bSortable": false, "aTargets": [0,6,7] },
        var id = $('#RegionId').val();

//        if ($('#ProjectId').val() != '') {
//            getRegion();
//            var e = document.getElementById("RegionId");
//            var strUser = e.options[e.selectedIndex].text;
//
//        }

                    
    });


    function getRegion(projectId) {

        var result = new Array();

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'ProductionDashboards', 'action' => 'ajaxregion')); ?>",
            data: ({projectId: projectId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadRegion').innerHTML = result;
                //$('#UserGroupId').find('option').remove();
                $('#user_id').find('option').remove();
                // document.getElementById('RegionId').value = result;
            }
        });
    }

    function getusergroupdetails(RegionId) {
        var ProjectId = $('#ProjectId').val();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'ProductionDashboards', 'action' => 'getusergroupdetails')); ?>",
            data: ({projectId: ProjectId, regionId: RegionId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadUserGroup').innerHTML = result;
                var optionValues = [];
                $('#UserGroupId option').each(function () {
                    optionValues.push($(this).val());
                });
                optionValues.join(',')
                $('#UserGroupId').prepend('<option selected value="' + optionValues + '">All</option>');
                getresourcedetails();

            }
        });
    }

    function getresourcedetails() {
        var ProjectId = $('#ProjectId').val();
        var RegionId = $('#RegionId').val();
        var UserGroupId = $('#UserGroupId').val();

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'ProductionDashboards', 'action' => 'getresourcedetails')); ?>",
            data: ({projectId: ProjectId, regionId: RegionId, userGroupId: UserGroupId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadUserDetails').innerHTML = result;
            }
        });
    }

    function getStatus(projectId) {
        var result = new Array();
        //        if(ProjectId=projectId){
        //         vesselName=$("#RegionId option:selected").text();
        //         
        //         alert(vesselName);
        //         
        //        }
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'ProductionDashBoards', 'action' => 'ajaxstatus')); ?>",
            data: ({projectId: projectId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadStatus').innerHTML = result;

                // document.getElementById('RegionId').value = result;
            }
        });
    }

    function getCengageProject(projectId) {
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'ProductionDashBoards', 'action' => 'ajaxcengageproject')); ?>",
            data: ({projectId: projectId}),
            dataType: 'text',
            async: false,
            success: function (result) {

                if(result != 0){
                    $('#productivityReport_submit').hide();
                    $('#ModuleSummary_submit').hide();
                }else{
                    $('#productivityReport_submit').show();
                    $('#ModuleSummary_submit').show();
                }
                //document.getElementById('LoadStatus').innerHTML = result;

                // document.getElementById('RegionId').value = result;
            }
        });
    }

    function ClearFields()
    {
        $('#ProjectId').val('0');
        $('#RegionId').val('0');
        $('#batch_from').val('');
        $('#batch_to').val('');
        $('#user_id').val('');
        $('#UserGroupId').val('');
        $('#status').val('');
        $('#query').val('');
        $('#detail').hide();
        $('#pagination').hide();
        $('#xlscnt').hide();
    }

    function reallocate(domain, status)
    {
        //alert(status);
        document.getElementById('LoadResult').innerHTML = "";
        document.getElementById('inputentityids').value = domain;
        document.getElementById('moduleids').value = status;
        var id = $('#DomainId').text(domain);
        var status = $('#AssignedTo').val(status);
        reallocate_user = new Array();
        reallocate_user = reallocate_user_list.split(',');
        reallocate_user_id = new Array();
        reallocate_user_id = user_id.split(',');
        document.getElementById('light').style.display = 'block';
        document.getElementById('fade').style.display = 'block';
        $('#DomainId').text(domain);
        $('#statusVal').text(status);
        if (AssignedTo == '')
            AssignedTo = '-';
        $('#AssignedTo').text(domain);
        $('#production_id').val(production_id);
        $('#AssignedTohidden').val(AssignedToHidden);
        $('#att').val(att);
        $('#allocateTo option[value!="0"]').remove();
        if (count > 0) {
            for (i = 0; i < count; i++)
            {
                $('#allocateTo')
                        .append($("<option></option>")
                                .attr("value", reallocate_user_id[i])
                                .text(reallocate_user[i]));
            }

        }
    }
    function reallocateClose()
    {
        //alert('test');
        if ($('#allocateTo').val() == 0)
        {
            alert('Select Allocate TO');
            $('#allocateTo').focus();
            return false;
        }
        if ($('#allocateTo').val() == $('#AssignedTohidden').val())
        {
            alert('Alerady Assigned to this user only!');
            $('#allocateTo').focus();
            return false;
        }
//        document.getElementById('light').style.display = 'none';
//        document.getElementById('fade').style.display = 'none';

        var domain = document.getElementById('inputentityids').value;
        var status = document.getElementById('moduleids').value;
        var userid = document.getElementById('allocateTo').value;

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'ProductionDashboards', 'action' => 'ajaxupdateuser')); ?>",
            data: ({InputEntityId: domain, moduleid: status, userid: userid}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadResult').innerHTML = result;
                //document.getElementById('LoadRegion').innerHTML = result;

                // document.getElementById('RegionId').value = result;

                //tables.ajax.reload();
            }
        });
    }
    function reallocateCancel()
    {
        radioId = document.getElementById('att').value;
        document.getElementById('radioReallocate' + radioId).checked = false;
        document.getElementById('light').style.display = 'none';
        document.getElementById('fade').style.display = 'none';
    }

    function Mandatory()
    {
        if ($('#query').val() == '') {
        
            if ($('#ProjectId').val() == 0) {
                alert('Select Project Name');
                $('#ProjectId').focus();
                return false;
            }
            if ($('#RegionId').val() == 0) {
                alert('Select Region Name');
                $('#RegionId').focus();
                return false;
            }

            if (($('#batch_from').val() == '') && ($('#batch_to').val() == '') && ($('#user').val() == null))
            {
                alert('Select any one date!');
                $('#batch_from').focus();
                return false;
            }
        }
        
    }

</script>
<style>
    .overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        transition: opacity 500ms;
        visibility: hidden;
        opacity: 0;
    }
    .overlay:target {
        visibility: visible;
        opacity: 1;
    }


    .popup {
        margin: 150px auto;
        padding: 20px;
        background: #fff;
        border-radius: 5px;
        width: 40%;
        position: relative;
        transition: all 5s ease-in-out;

    }

    .popup h2 {
        margin-top: 0;
        color: #333;
        font-family: Tahoma, Arial, sans-serif;
    }
    .popup .close {
        position: absolute;
        top: 20px;
        right: 30px;
        transition: all 200ms;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        color: #333;
    }
    .popup .close:hover {
        color: #fdc382;
    }
    .popup .content {
        max-height: 30%;
        overflow: auto;
    }
    .query_outerbdr {
        background: #fff none repeat scroll 0 0;
        border-radius: 5px;
        margin: 3px;
        padding: 6px;
    }

    .allocation_popuphgt {
        font-size: 12px;
        height: 157px;
        overflow: auto;
    }
    .white_content {
        background: #fdfdfd url("../img/popupbg.png") repeat-x scroll left top;
        border: 5px solid #fff;
        display: none;
        height: auto;
        left: 25%;
        padding: 16px;
        position: absolute;
        top: 25%;
        width: 50%;
        z-index: 1002;
    }

</style>
<?php
if (isset($this->request->data['check_submit']) || isset($this->request->data['downloadFile'])) {
    ?>
<script>
    $(window).bind("load", function () {
        var optionValues = [];
        $('#UserGroupId option').each(function () {
            optionValues.push($(this).val());
        });
        optionValues.join(',')
        $('#UserGroupId').prepend('<option selected value="' + optionValues + '">All</option>');
        $("#UserGroupId option[value='<?php echo $postbatch_UserGroupId; ?>']").prop('selected', true);
        //getresourcedetails();
        //$("#UserGroupId option[value='<?php echo $this->request->data['user_id']; ?>']").prop('selected', true);
    });
</script>
    <?php
}
if ($CallUserGroupFunctions == 'yes') {
    ?>
<script>
    $(window).bind("load", function () {
        var regId = $('#RegionId').val();
        getusergroupdetails(regId);
    });
</script>
    <?php
}
?>
<script>
        
function priority(){
 //var n = $("input[name^='priority']").length;
 
 var arraydata = $('.Pri_ids:checked').serialize();
 var arraydomain = $('.domain_ids').serialize();
 var arraystatus = $('.status_ids').serialize();
 var arraysaved = $('.pri_saved_ids').serialize();
 var Proid=$('#ProjectId').val();
 //console.log(arraydata);
// var arr_value = '';
//for(i=0;i<n;i++)
//{
//    
// var arr_value+='_' + arraydata[i].value;
//}
 $(".hot").html("Loading...");
            $.ajax({
            url: '<?php echo Router::url(array('controller' => 'ProductionDashBoards', 'action' => 'ajaxgetdata')); ?>',
            
            data: {ProductionEntityId: arraydata,ProjectId: Proid,domainId: arraydomain,savedId: arraysaved,statusId: arraystatus},
            type: 'POST',
            success: function (res) { 
	     $(".hot").html(res);
            }
        });
}    
function prioritysubmit(){
 //var n = $("input[name^='priority']").length;
 
 var arraydata = $('.allocateforms').serialize() ;
 
 var Proid=$('#ProjectId').val();
 //console.log(arraydata);
// var arr_value = '';
//for(i=0;i<n;i++)
//{
//    
// var arr_value+='_' + arraydata[i].value;
//}

            $.ajax({
            url: '<?php echo Router::url(array('controller' => 'ProductionDashBoards', 'action' => 'ajaxgetdatasubmit')); ?>',
            
            data: {userId: arraydata, ProjectId:Proid},
            type: 'POST',
            success: function (res) { 
	     //$(".hot").html(res);
            }
        });
        location.reload();
}    

function numericvalidation(id){
var e = document.getElementById('pri_id'+id);

if (!/^[0-9]+$/.test(e.value) && e !='') 
{ 
alert("Please enter only numbers.");
e.value = e.value.substring(0,e.value.length-1);
}
}
/*function numericvalidation123(id){
$("#pri_id"+id).keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
       // $("#errmsg"+id).html("Number Only").show().fadeOut("slow");
               return false;
    }
   });
}
*/
function getProject(id){
  $("#LoadProject").html('Loading...');
            $.ajax({
            url: '<?php echo Router::url(array('controller' => 'ProductionDashBoards', 'action' => 'ajaxProject')); ?>',
            
            data: {ClientId: id},
            type: 'POST',
            success: function (res) { 
	     $("#LoadProject").html(res);
            }
        });
}    
</script>