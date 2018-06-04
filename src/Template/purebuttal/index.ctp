<?php

use Cake\Routing\Router
?>
<div class="container-fluid mt15">
    <div class="formcontent">
        <h4>PU Rebuttal</h4>
            <?php echo $this->Form->create('',array('class'=>'form-horizontal','id'=>'projectforms')); ?>


        <div class="col-md-3">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Project </label>
                <div class="col-sm-6 prodash-txt">
                   <?php echo $this->Form->input('', array('options' => $Projects, 'id' => 'ProjectId', 'name' => 'ProjectId', 'class' => 'form-control', 'value' => $ProjectId, 'onchange' => 'getRegion(this.value);getModule(this.value);'));?>  
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="RegionId" class="col-sm-6 control-label">Region Name</label>
                <div class="col-sm-6 prodash-txt">
                    <div id="LoadRegion">
                        <?php
                        if ($RegionId == '') {
                            $Region = array(0 => '--Select--');
                            echo $this->Form->input('', array('options' => $Region, 'id' => 'RegionId', 'name' => 'RegionId', 'class' => 'form-control', 'value' => $RegionId, 'onchange' => 'getusergroupdetails(this.value)'));
                        } else {
                            echo $RegionId;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
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

        <div class="col-md-3">
            <div class="form-group">
                <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Module</label>
                <div class="col-sm-6" style="margin-top:3px;">
                    <div id="LoadModule">
                    <?php 
                    if ($ModuleIds == '') {
                    $Modules = array(0 => '--Select--'); ?>

                        <?php
                        echo $this->Form->input('', array('options' => $Modules, 'id' => 'ModuleIds', 'name' => 'ModuleIds', 'class' => 'form-control prodash-txt', 'value' => $ModuleIds, 'onchange' => 'getStatus(this.value);'));
                        //echo $ModuleList;
                            ?>

                    <?php }else{
                        echo $ModuleIds;
                    } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Date From:</label>
                <div class="col-sm-6 prodash-txt">
                    <?php 
                        echo $this->Form->input('', array('id' => 'QueryDateFrom', 'name' => 'QueryDateFrom', 'class'=>'form-control' , 'value'=>$QueryDateFrom )); 
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">To:</label>
                <div class="col-sm-6 prodash-txt">
                    <?php 
                        echo $this->Form->input('', array('id' => 'QueryDateTo', 'name' => 'QueryDateTo', 'class'=>'form-control','value'=>$QueryDateTo )); 
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">Resource</label>
                <div class="col-sm-6">
                    <div id="LoadUserDetails">
                        <?php
                            echo $this->Form->input('', array('options' => $User, 'class' => 'form-control', 'selected' => $postuser_id, 'value' => $postuser_id, 'id' => 'user_id', 'name' => 'user_id', 'style' => 'height:100px; margin-top:-15px;', 'multiple' => true));
                        ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group" style="text-align:center;" >
            <div class="col-sm-12">
                <input type="hidden" name='formSubmit'>
                <button type="submit" name = 'check_submit'class="btn btn-primary btn-sm" onclick="return formSubmitValidation();">Submit</button>
                <button type="button" name = 'clear'class="btn btn-primary btn-sm" onclick="return ClearFields();">Clear</button>
            </div>
        </div>
    </div>
</div>

<!-- ******************************************************************************************************************************************************* -->


<?php

if(!empty($rebuttalResult)){ ?>
<div id="detail" class="col-sm-12">
  
    <div style="margin:5px;" class="col-sm-12">
        <!-- Second option in collapse-->
     <div class="panel panel-default">
            <div class="panel-heading">
                <h4> Production TL Rebuttal </h4>
                
            </div>
                    
            <div id="collapse0" class="panel-collapse collapse in">
                <div class="panel-body">
                                        <!-- Second Inner Collpse Starts-->
        <?php 
            foreach($rebuttalResult as $key=>$data){
        ?>     
              <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4>
                               <div style="float: left;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key;?>" class="" aria-expanded="true"><img src="img/insert-object.png" style="margin-bottom:3px;"> 
                                    <label class="comments"><b>FDRID:</b></label>
                                    <label class="comments"><span style="text-align:left"><?php echo $key;?></span></label>
                                </a>
                                   </div>
                               <div class="clickview"><a target="_blank" href="<?php echo Router::url(array('controller'=>'purebuttallist','action'=>'index','PEid' => $data['ProductionEntityID'],'ModuleId'=>$ModuleId));?>" >Click to view</a></div>
                            </h4>
                            
                        </div>

                        <div id="collapse<?php echo $key;?>" class="panel-collapse collapse in" aria-expanded="true" style="">
                            
     <table style="width: 98%;" class="table table-striped table-center dataTable no-footer" id="example" aria-describedby="example_info">                                                                 
    <tr><th>Attribute Name</th><th>Attribute Value</th><th>QC Error</th><th>QC Comments</th><th>PU Rebuttal Comments</th><th>Action</th></tr>
             
        <?php 
            foreach($data['list'] as $key1=>$data1){
//                echo "<pre>ss";print_r($data1);exit;
        ?>
         <tr>
             <td><?php echo $data1['displayname'];?></td>
             <td><?php echo $data1['OldValue'];?></td>
             <td><?php echo $data1['ErrorCategoryName'];?> </td>
             <td><?php echo $data1['QCComments'];?></td>
             <td><?php echo $data1['UserReputedComments'];?></td>
             
             <td><div id="button_data_submit_<?php echo $data1['Id'];?>">
             <?php if(($data1['StatusId'] == 4)){ ?>
                <button name="frmsubmit" type="button" onclick="return query('<?php echo $data1['Id'];?>','4','D','<?php echo $data1['TLReputedComments'];?>','<?php echo $data1['QCComments'];?>','<?php echo $data1['UserReputedComments'];?>','<?php echo $data1['InputEntityId'];?>','<?php echo $data1['ProjectId'];?>','<?php echo $ModuleId;?>');" class="btn btn-default btn-sm added-commnt">Rebute</button>
             <?php }elseif($data1['StatusId'] == 5){?>     
             <button name="frmsubmit" type="button" onclick="return query('<?php echo $data1['Id'];?>','5','D','<?php echo $data1['TLReputedComments'];?>','<?php echo $data1['QCComments'];?>','<?php echo $data1['UserReputedComments'];?>','<?php echo $data1['InputEntityId'];?>','<?php echo $data1['ProjectId'];?>','<?php echo $ModuleId;?>');" class="btn btn-default btn-sm added-commnt">Reject</button>
             
              <?php }else{ ?>
                  <button name="frmsubmit" type="button" onclick="return query('<?php echo $data1['Id'];?>','4','E','<?php echo $data1['TLReputedComments'];?>','<?php echo $data1['QCComments'];?>','<?php echo $data1['UserReputedComments'];?>','<?php echo $data1['InputEntityId'];?>','<?php echo $data1['ProjectId'];?>','<?php echo $ModuleId;?>');" class="btn btn-default btn-sm">Rebute</button>
             <button name="frmsubmit" type="button" onclick="return query('<?php echo $data1['Id'];?>','5','E','<?php echo $data1['TLReputedComments'];?>','<?php echo $data1['QCComments'];?>','<?php echo $data1['UserReputedComments'];?>','<?php echo $data1['InputEntityId'];?>','<?php echo $data1['ProjectId'];?>','<?php echo $ModuleId;?>');" class="btn btn-default btn-sm">Reject</button>
                  
              <?php } ?>
             </div></td>
             
             
             
         </tr>
                                                            
         <?php 
            }
        ?> 
                        </table>           
                          
                        </div>
                    </div>
                                        
        <?php 
            }
        ?>     
                                        
               
                    <!-- Second Inner collapse  ends here --> 
                                    </div>
            </div>
        </div>
        <!-- Second option in collapse  ends here --> 
         
        
        
    </div>
    
    

    <!-- Code for collaps ends -->
    <input type='hidden' name='successmsg' id='successmsg' value='successmsg'>
<?php echo $this->Form->end(); ?>
</div>
<?php } ?>
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

<div id="light" class="white_content" style="position:fixed;">
        <div class="query_popuptitle"><div style='float:left;width:40%'><b><span class="rebuttal_id_txt"></span> Comments</b></div><div align='right'> <b><a onclick="document.getElementById('light').style.display = 'none';document.getElementById('fade').style.display = 'none';cleartext();"><?php echo $this->Html->image('cancel.png', array('width'=>'20px','height'=>'20px','alt' => 'Close'));?></a></b></div></div>
        <div class="query_innerbdr">
            <div class="query_outerbdr" style='height:315px;overflow:auto;'>
                <div id='QcsuccessMessage' align='center' style='display:none;color:green;'><b>Comments Successfully Posted!</b></div>
                <div id='QcDeletedMessage' align='center' style='display:none;color:green;'><b>Comments Deleted Successfully!</b></div>
                
                
                <input type='hidden' name='CommentsId' Id ='CommentsId' value=''>
                <input type='hidden' name='Status_id' Id ='Status_id' value=''>
                <input type='hidden' name='queryProjectId' Id ='queryProjectId' value=''>
                <input type='hidden' name='InputEntityId' Id ='InputEntityId' value=''>
                <input type='hidden' name='queryModuleId' Id ='queryModuleId' value=''>
                
            <?php
                echo $this->Form->input('', array( 'type'=>'hidden','id' => 'inspectionId', 'name' => 'inspectionId')); 
            ?>
               
                <label class="col-sm-4 control-label"><b>QcError Comments</b></label>
                <div class="col-sm-7">
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='qcerrortxt'></pre>
                </div>
                
                <label class="col-sm-4 control-label"><b>PUError Comments</b></label>
                <div class="col-sm-7">
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='puerrortxt'>-</pre>
                </div>
                
                <label class="col-sm-4 control-label"><b><span class="rebuttal_id_txt"></span> Comments</b></b></label>
                <div class="col-sm-7">
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='QCValueMultiTextboxtxt'></pre>
                    
                    <?php 
                echo $this->Form->textarea('', array( 'type'=>'text','id' => 'QCValueMultiTextbox', 'name' => 'QCValueMultiTextbox','style'=>'margin-bottom:8px;')); ?>
                </div>
               
                
                <div  class="col-sm-10" id='oldData' ></div>

                <div class="col-sm-11">
                    <div class="col-sm-4" style="text-align:center;margin-top: 7px;"></div>
                    <div class="col-sm-7" style="text-align:left;margin-top: 7px;margin-left: 11px;">
                <?php
                  echo $this->Form->button('Rebute', array( 'id' => 'QuerySubmit', 'name' => 'QuerySubmit', 'value' => 'QuerySubmit','class'=>'btn btn-primary btn-sm','onclick'=>"return commentsQueryInsert();",'type'=>'button')).' '; 
                 echo $this->Form->button('Close', array( 'type'=>'button','id' => 'Cancel', 'name' => 'Cancel', 'value' => 'Cancel','class'=>'btn btn-primary btn-sm','onclick'=>"document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';cleartext();")).' '; 
                   ?>   
                        </div>
                </div>
                &nbsp;
                &nbsp; 
            </div>


        </div>
    </div>


<style>
    .black_overlay{display: none;position: fixed;top: 0%;left: 0%;width: 100%;height: 100%;background:#8F8F8F;z-index:1001;-moz-opacity: 0.8;opacity:.80;filter: alpha(opacity=80);}
    .white_content{display: none;position: absolute;top: 15%;left: 25%;width: 50%;height: auto;padding: 16px;border: 5px solid #fff;z-index:1002; background:url("img/popupbg.png") repeat-x  left top #fdfdfd;}
    .query_popuptitle{background:url("img/question.gif") no-repeat left top; margin:0px 30px 10px 0px;}
    .query_popuptitle{margin:0px 30px 10px 0px;}
    .query_innerbdr {background:#c8c8c8; padding:2px; border-radius:5px; }
    .query_outerbdr{background:#fff; margin:3px; border-radius:5px; padding:6px;}
    .query_popuptitle b,.query_popuptitle1 b, .comment_popuptitle b,.allocation_popuptitle b,.rebute_popuptitle b,.reallocation_popuptitle b{padding:0px 0px 0px 30px;font-size: 12px;text-transform:uppercase;}
    .qc_popuptitle{background:url("img/comment.png") no-repeat left top;width:21px;height:21px; }
    .qcGreen_popuptitle{background:url("img/commentGreen.png") no-repeat left top;width:21px;height:21px; }
    .qcRed_popuptitle{background:url("img/commentRed.png") no-repeat left top;width:21px;height:21px; }
</style>
<div id="fade" class="black_overlay" style="display: none;"></div>


<script type="text/javascript">

 function query(CommentsId,Status_id,active,tlrebutetxt,qctxt,putxt,InputEntityId,ProjectId,ModuleId)
    {
        
        document.getElementById('light').style.display = 'block';
        document.getElementById('fade').style.display = 'block';
        $('#CommentsId').val(CommentsId);
        $('#Status_id').val(Status_id);
        $('#InputEntityId').val(InputEntityId);
        $('#queryProjectId').val(ProjectId);
        $('#queryModuleId').val(ModuleId);
       
       var comment_txt_title = "";
       
       if(Status_id == 4){
            comment_txt_title = "Rebute ";
       }else if(Status_id == 5){
            comment_txt_title = "Reject ";
       }
       
       $('.rebuttal_id_txt').text(comment_txt_title);
       $('#QuerySubmit').text(comment_txt_title);
       
        if(putxt ==''){putxt = '-';}
        if(qctxt ==''){qctxt = '-';}
        if(tlrebutetxt ==''){tlrebutetxt = '';}
        $('#QCValueMultiTextbox').val(tlrebutetxt);
        $('#qcerrortxt').text(qctxt);
        $('#puerrortxt').text(putxt);
        
        if(active == 'D'){
            $('#QuerySubmit').hide();
            $('#Cancel').hide();
            $('#QCValueMultiTextboxtxt').text(tlrebutetxt);
            $('#QCValueMultiTextboxtxt').show();
             $('#QCValueMultiTextbox').hide();
        }else{
            $('#QuerySubmit').show();
            $('#Cancel').show();
            $('#QCValueMultiTextboxtxt').hide();
            $('#QCValueMultiTextbox').show();
        }
       
       
    }
    
function commentsQueryInsert(){
        
        
        var CommentsId = $('#CommentsId').val();
        var InputEntityId = $('#InputEntityId').val();
        var ProjectId = $('#queryProjectId').val();
        var ModuleId = $('#queryModuleId').val();
        
        var QCrebuttalTextbox = $('#QCValueMultiTextbox').val();
        var Status_id = $('#Status_id').val();
        
         if ($('#QCValueMultiTextbox').val() == '') {
            alert('Enter your comments ');
            $('#QCValueMultiTextbox').focus();
            return false;
        }
        
          $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'Purebuttal','action'=>'ajaxpurebutalcommentsinsert'));?>",
            data: ({CommentsId: CommentsId,QCrebuttalTextbox:QCrebuttalTextbox,Status_id:Status_id,InputEntityId:InputEntityId,ProjectId:ProjectId,ModuleId:ModuleId }),
            dataType: 'text',
            async: false,
            success: function (result) {
                 $('#button_data_submit_'+CommentsId).html(result);
                 document.getElementById('light').style.display = 'none';
                 document.getElementById('fade').style.display = 'none';
            }

        });
    }
    
function valicateQueryInsert()
    {
        var ProjectId = "<?php echo $productionjob['ProjectId'];?>";
        var RegionId = "<?php echo $productionjob['RegionId'];?>";
     
        var SequenceNumber = $('#seq').val();
        var AttributeStatus = $("#AttributeStatus").val();


        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'Purebuttal','action'=>'purebuteajaxqueryinsert'));?>",
            data: ({ProjectId: ProjectId }),
            dataType: 'text',
            async: false,
            success: function (result) {
                
             
                
            }

        });
      
     
    }

    function getRegion(projectId) {

        var result = new Array();

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'Puquery', 'action' => 'ajaxregion')); ?>",
            data: ({projectId: projectId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadRegion').innerHTML = result;
                //$('#UserGroupId').find('option').remove();
                //$('#userid').find('option').remove();
            }
        });
    }

    function getModule() {
        var result = new Array();
        var ProjectId = $('#ProjectId').val();
        var RegionId = $('#RegionId').val();


        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'Purebuttal', 'action' => 'ajaxmodule')); ?>",
            data: ({ProjectId: ProjectId, RegionId: RegionId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadModule').innerHTML = result;
            }
        });
    }

    function getusergroupdetails(RegionId) {
        var ProjectId = $('#ProjectId').val();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'Puquery', 'action' => 'getusergroupdetails')); ?>",
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
            url: "<?php echo Router::url(array('controller' => 'Puquery', 'action' => 'getresourcedetails')); ?>",
            data: ({projectId: ProjectId, regionId: RegionId, userGroupId: UserGroupId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadUserDetails').innerHTML = result;
            }
        });
    }

    function updateQuery(att, ModuleId, ProductionEntityId) {
        if ($('#mobius_comments' + att).val() == '')
        {
            alert('Enter Comments!');
            $('#mobius_comments' + att).focus();
            return false;
        }

        mobiusComment = $("#mobius_comments" + att).val();
        status = $('#status' + att).val();
        batchfrom = $('#batch_from').val();
        batchto = $('#batch_to').val();


        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'puquery','action'=>'ajaxqueryinsert'));?>",
            data: ({mobiusComment: mobiusComment, queryID: att, status: status, ModuleId: ModuleId, ProductionEntityId: ProductionEntityId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById("projectforms").submit();
            }
        });
    }



    function formSubmitValidation() {

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
        if ($('#ModuleId').val() == 0) {
            alert('Select Module Name');
            $('#ModuleId').focus();
            return false;
        }
        if ($('#QueryDateFrom').val() == '' && $('#QueryDateTo').val() == '') {
            alert('Select From Date');
            return false;
        }
//        if ($('#QueryDateTo').val() == '') {
//            alert('Select To Date');
//            return false;
//        }
        
        if ($('#user_id').val() == '') {
            alert('Select Resource');
            return false;
        }
        
        
    }

    function ClearFields() {
        $('#ProjectId').val('0');
        $('#RegionId').val('0');
        $('#UserGroupId').val('');
        $('#ModuleId').val('0');
        $('#QueryDateFrom').val('');
        $('#QueryDateTo').val('');
        $('#user_id').find('option').remove();
    }
</script>



    <?php

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
} ?>