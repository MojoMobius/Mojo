<?php

use Cake\Routing\Router
?>
<style>
    .mandatory{
        color:red;
    }
</style>
<div class="container-fluid mt15">
    <div class="formcontent">
        <h4>Quality Report</h4>
            <?php echo $this->Form->create('',array('class'=>'form-horizontal','id'=>'projectforms')); ?>
        <div class="row">

             <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Client<span class="mandatory"> *</span></label>
                        <div class="col-sm-6" style="line-height: 0px;">
                             <?php
                       
                         echo $this->Form->input('', array('options' => $Clients, 'id' => 'ClientId', 'name' => 'ClientId', 'class' => 'form-control', 'value' => $ClientId, 'onchange' => 'getProject()'));
                       
                    ?>
                    
                     
                        </div>
                    </div>
                </div>
            <input type="hidden" name="regionId" id="RegionId" value="<?php echo $RegionId;?>" />
             <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Project<span class="mandatory"> *</span></label>
                        <div class="col-sm-6" style="line-height: 0px;">
                              <div id="LoadProject">
                                  <?php 
                     echo $this->Form->input('', array('options' => $Projects, 'id' => 'ProjectId', 'name' => 'ProjectId', 'class' => 'form-control', 'value' => $ProjectId,'style' => 'width:220px;height:100px','multiple'=>'true', 'onchange' => 'getusergroupdetails();'));  
                      
                        ?>
                         
                              </div>
                        </div>
                    </div>
                </div>
            
            
<!--getModule(this.value);-->
            <div class="col-md-4 hide">
                <div class="form-group">
                    <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Module</label>
                    <div class="col-sm-6" style="margin-top:3px;">
                        <div id="LoadModule">
                    <?php 
                    
                    if ($ModuleIds == '') {
                      
                    $Modules = array(0 => '--Select--'); ?>

                        <?php
                        echo $this->Form->input('', array('options' => $Modules, 'id' => 'ModuleIds', 'name' => 'ModuleIds', 'class' => 'form-control prodash-txt', 'value' => $ModuleIds, 'onchange' => 'getusergroupdetails();getresourcedetails();'));
                        //echo $ModuleList;
                            ?>

                    <?php }else{
                        echo $ModuleIds;
                    } ?>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="form-group">
                    <label for="UserGroupId" class="col-sm-6 control-label">User Group</label>
                    <div class="col-sm-6 prodash-txt">
                    <?php
                        if ($UserGroupId == '') {
                            $UserGroup = array(0 => '--Select--');
                            echo '<div id="LoadUserGroup">';
                            echo $this->Form->input('', array('options' => $UserGroup, 'id' => 'UserGroupId', 'name' => 'UserGroupId', 'class' => 'form-control', 'value' => $UserGroupId, 'selected' => $UserGroupId, 'onchange' => 'getresourcedetails'));
                            echo '</div>';
                        } else {
                            echo $UserGroupId;
                        }
                    ?>
                    </div>
                </div>
            </div>

       


        </div>
        <div class="row">
            
             <div class="col-md-4">
                <div class="form-group">
                   <label for="inputPassword3" class="col-sm-6 control-label">From <span class="mandatory"> *</span></label>
                    <div class="col-sm-6 ">
                         <?php 
                        echo $this->Form->input('', array('id' => 'QueryDateFrom', 'name' => 'QueryDateFrom', 'class'=>'form-control' , 'value'=>$QueryDateFrom )); 
                    ?>
                    
                    </div>
                </div>
            </div>
			<div class="col-md-4">
                <div class="form-group">
                   <label for="inputPassword3" class="col-sm-6 control-label">To</label>
                    <div class="col-sm-6 ">
                         <?php 
                        echo $this->Form->input('', array('id' => 'QueryDateTo', 'name' => 'QueryDateTo', 'class'=>'form-control','value'=>$QueryDateTo )); 
                    ?>
                    
                    </div>
                </div>
            </div>
			<div class="col-md-4">
                <div class="form-group">
                   <label for="inputPassword3" class="col-sm-6 control-label">Resource</label>
                    <div class="col-sm-6 ">
                        <div id="LoadUserDetails">
                        <?php
//                        echo "<pre>s";print_r($postuser_id);exit;
                        
                            echo $this->Form->input('', array('options' => $User, 'class' => 'form-control', 'selected' => $postuser_id, 'value' => $postuser_id, 'id' => 'user_id', 'name' => 'user_id', 'style' => 'height:100px;margin-top: -15px;', 'multiple' => true));
                        ?>
                        </div>
                    
                    </div>
                </div>
            </div>
            
           
        </div>

        <div class="form-group" style="text-align:center;" >
            <div class="col-sm-12">
                <input type="hidden" name='formSubmit'>
                <button type="submit" name = 'check_submit'class="btn btn-primary btn-sm" onclick="return formSubmitValidation();">Submit</button>
                <button type="button" name = 'clear'class="btn btn-primary btn-sm" onclick="return ClearFields();">Clear</button>
                    <?php
 echo $this->Form->button('Export Report', array('id' => 'downloadFile', 'name' => 'downloadFile', 'value' => 'downloadFile', 'style' => 'margin-left:5px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return formSubmitValidation()', 'type' => 'submit'));   ?>
            </div>
        </div>
		<?php echo $this->Form->end(); ?>
    </div>
</div>


<style type='text/css'>
    .comments{top:0 !important;left:0 !important;position:relative !important;color:black !important;}
    .frmgrp_align{margin-left: 15px !important;margin-right: 0px !important;}

    .panel-default>.panel-heading {
        color: #333;
        border-color: #ddd;
        height: 47px;
    }
    .clickview{
        font-weight: bold;
        color: red;
        float: right;
        font-size: 12px;
        cursor: pointer;
    }
    .added-commnt{
        border-color:#ccc;
        background-color:#ccc;
    }
    .pu_cmts_seq{
        color:red;
    }
</style>


<script type="text/javascript">

    $(document).ready(function () {
<?php
//$js_array = json_encode($ProdDB_PageLimit);
//echo "var mandatoryArr = " . $js_array . ";\n";
//echo "var mandatoryArr = "10 ";";
?>
        //var projectId = 3346;
//        var pageCount = 10;

        //$.fn.dataTable.moment('DD-MM-YYYY HH:mm:ss');
        //$.fn.dataTable.moment( 'dddd, DD/MM/YYYY' );
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
            // "scrollX": true,
            "aoColumnDefs": [
                {"bSearchable": false,
                    //"aTargets": [5]
                }
            ]
        });
    });

</script>

<?php
foreach($result as $key=>$val){
	$Headkey=$key;
}
?>

<div class="container-fluid">
    <div class="bs-example">
      
        <div id="vertical">
            <div id="top-pane">
                <div id="horizontal" style="height: 100%; width: 100%;">
                    <div id="left-pane" class="pa-lef-10">
                        <div class="pane-content" >
                            <input type="hidden" name="UpdateId" id="UpdateId">
                            <button style="float:right; height:18px; visibility: hidden; margin-right:15px;" type='hidden' name='downloadFile' id='downloadFile' value='downloadFile'></button>

                            <table style='width:100%;' class="table table-striped table-center" id='example'>
                                <thead>
                                    <tr class="Heading">
                                        <th style='width:5%;'>S.No</th>
                                        <th style='width:10%;'>Client</th>
                                        <th style='width:10%;'>Project Name</th>
                                        <th style='width:5%;'>Date</th>
                                        <th style='width:10%;'>LeaseId</th>
										<?php foreach( $result[$Headkey]['CommentHead'] as $head){ 
										?>										
                                        <th style='width:10%;'><?php echo $head." Comments";?></th>
                                        <th style='width:10%;'><?php echo $head." Percentage";?></th>
										<?php
										}
										?>
                                        <th style='width:10%;'>Overall Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                    <?php 
                        $i = 1;
						
if (count($result) > 0) {
                        foreach($result as $key1=>$val){
														
							
                    ?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $val['Client']; ?></td>
                                        <td><?php echo $val['project_name']; ?></td>
                                        <td><?php echo $val['date'];?> </td>
                                        <td><?php echo $val['leaseId'];?></td>
										<?php 
										$total_percent=array();
										foreach($result[$Headkey]['CommentHead'] as $keyhead => $head){
										$total_percent[]= count($val['comments'][$keyhead][$key1]);
										$cnt= count($val['comments'][$keyhead][$key1]);
										?>										
											 <td>
											 <?php foreach($val['comments'][$keyhead][$key1] as $valcomments){
												 ?><p> <?php echo $valcomments;?> </p>
											 <?php } ?>
											 </td>
                                         <td>
										 <?php 
										 $com_percentage= 1 - ( $cnt / $val['totalAttributes']) ;
										 echo  number_format((float)$com_percentage, 2, '.', '');
										 ?></td>
										<?php
										}
										?>
                                       <td><?php 
									   $totalcnt=array_sum($total_percent);
									   
									    $tot_perc= 1 -( $totalcnt / $val['totalAttributes']) ;
										 echo number_format((float)$tot_perc, 2, '.', ''); ?></td>
                                    </tr>

                            <?php 
                            $i++;
                               }
                        }
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
echo $this->Form->end();
?>


<script type="text/javascript">


    function getModule() {
//        var result = new Array();
        var ProjectId = $('#ProjectId').val();
        var RegionId = $('#RegionId').val();


        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QualityReport', 'action' => 'ajaxmodule')); ?>",
            data: ({ProjectId: ProjectId, RegionId: RegionId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadModule').innerHTML = result;
            }
        });
    }

    function getusergroupdetails() {
        var ProjectId = $('#ProjectId').val();
        var RegionId = $('#RegionId').val();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QualityReport', 'action' => 'getusergroupdetails')); ?>",
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

function getStatus(){
    return true;
}

    function getresourcedetails() {
        var ProjectId = $('#ProjectId').val();
        var RegionId = $('#RegionId').val();
        var UserGroupId = $('#UserGroupId').val();

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QualityReport', 'action' => 'getresourcedetails')); ?>",
            data: ({projectId: ProjectId, regionId: RegionId, userGroupId: UserGroupId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadUserDetails').innerHTML = result;
            }
        });
    }


    function formSubmitValidation() {

        if ($('#ClientId').val() == 0) {
            alert('Please Select Client ');
            $('#ClientId').focus();
            return false;
        }
		if ($('#projectId').val() == 0 || $('#projectId').val() == '') {
            alert('Please Select Project ');
            $('#projectId').focus();
            return false;
        }
		if ($('#QueryDateFrom').val() == '') {
            alert('Please Select Date ');
            $('#QueryDateFrom').focus();
            return false;
        }

       
    }

    function ClearFields() {
        $('#ProjectId').val('0');
        $('#UserGroupId').val('');
        $('#QueryDateFrom').val('');
        $('#QueryDateTo').val('');
        //$('#ModuleId').val('0');
        $('#ClientId').val('0');
        $('#user_id').find('option').remove();
    }
    
function getProject(){
    
  var RegionId=$("#RegionId").val();
  var id=$("#ClientId").val();
  $("#LoadProject").html('Loading...');
            $.ajax({
            url: '<?php echo Router::url(array('controller' => 'QualityReport', 'action' => 'ajaxProject')); ?>',
            
            data: {ClientId: id,RegionId: RegionId},
            type: 'POST',
            success: function (res) { 
	     $("#LoadProject").html(res);
            }
        });
}    

</script>



<?php

if ( (isset($this->request->data['check_submit']) || isset($this->request->data['downloadFile'])) && !empty($postbatch_UserGroupId) ) {
    ?>
<script>
    $(window).bind("load", function () {
        getusergroupdetails();
        
        var optionValues = [];
        $('#UserGroupId option').each(function () {
            optionValues.push($(this).val());
        });
        optionValues.join(',')
       // $('#UserGroupId').prepend('<option selected value="' + optionValues + '">All</option>');
        $("#UserGroupId option[value='<?php echo $postbatch_UserGroupId; ?>']").prop('selected', true);
        
        //$("#user_id option[value='<?php //echo $UserId; ?>']").prop('selected', true);
    });
</script>
    <?php
}

if ($CallUserGroupFunctions == 'yes') {
    ?>
<script>
    $(window).bind("load", function () {
        var regId = $('#RegionId').val();
      //  getusergroupdetails(regId);
    });
</script>
    <?php
}
?>