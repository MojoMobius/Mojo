<?php

use Cake\Routing\Router
?>
<style>
    .mandatory{
        color:red;
    }
    .Flash-suc-Message{
        font-size: 18px;
        color:green;
    }
    .Flash-Message{
        font-size: 18px;
        color:red;
    }
.form-inline .form-group {
     margin-bottom: 2px!important; 
}
</style>

<div class="container-fluid mt15">
    <div class="formcontent">
        <h4>PU Queries</h4>
            <?php echo $this->Form->create('',array('class'=>'form-horizontal','id'=>'projectforms')); ?>
<?php //$SessionRegionId='1011'; ?>
        
                     <input type="hidden" name="RegionId" id="RegionId" value="<?php echo  $SessionRegionId;?>">
        <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Project<span class="mandatory"> *</span> </label>
                <div class="col-sm-6 prodash-txt">
                   <?php echo $this->Form->input('', array('options' => $Projects, 'id' => 'ProjectId', 'name' => 'ProjectId', 'class' => 'form-control', 'value' => $ProjectId, 'onchange' => 'getusergroupdetails('.$SessionRegionId.');getModule(this.value);'));?>  
                </div>
            </div>
        </div>
            <div class="col-md-4">
            <div class="form-group">
                <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Module<span class="mandatory"> *</span></label>
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
        
<!--
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
-->

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
                <label for="inputEmail3" class="col-sm-6 control-label">Query Date From<span class="mandatory"> *</span>:</label>
                <div class="col-sm-6 prodash-txt">
                    <?php 
                        echo $this->Form->input('', array('id' => 'QueryDateFrom', 'name' => 'QueryDateFrom', 'class'=>'form-control' , 'value'=>$QueryDateFrom )); 
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">To:</label>
                <div class="col-sm-6 prodash-txt">
                    <?php 
                        echo $this->Form->input('', array('id' => 'QueryDateTo', 'name' => 'QueryDateTo', 'class'=>'form-control','value'=>$QueryDateTo )); 
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
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
        </div>


        <div class="form-group" style="text-align:center;" >
            <div class="col-sm-12">
                <input type="hidden" name='formSubmit'>
                <button type="submit" name = 'check_submit'class="btn btn-primary btn-sm" onclick="return formSubmitValidation();">Submit</button>
                <button type="button" name = 'clear'class="btn btn-primary btn-sm" onclick="return ClearFields();">Clear</button>
            </div>
        </div>
		<?php echo $this->Form->end(); ?>
    </div>
</div>

<!-- ******************************************************************************************************************************************************* -->

<?php
//pr($queryResult);
if(!empty($queryResult)){ ?>
<div id="detail" class="col-sm-12">
   
    <?php echo $this->Form->create('',array('name' => 'inputSearch2', 'id' => 'inputSearch2', 'class' => 'form-horizontal','enctype' => 'multipart/form-data', 'type'=> 'post','style'=>'margin:0px !important;width:100%')); ?>

    <!-- Code for collaps starts -->
    <div style="margin:5px;" class="col-sm-12">
        <!-- Second option in collapse-->
        <?php $i=0;
            foreach($queryResult as $key=>$data){
              
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>"><img src="img/insert-object.png" style="margin-bottom:3px;"> <?php echo $resources[$key];?></a> </h4>
            </div>
            <div id="collapse<?php echo $i;?>" class="panel-collapse collapse in">
                <div class="panel-body"> 
                    <?php $j=0;
                        foreach($data as $key2=>$data2){
                    ?>
                    <!-- Second Inner Collpse Starts-->
                    <div class="panel panel-default">
                        <div class="panel-heading row">
        <div class="col-md-9">
            <span id="message<?php echo $data2[0]['ProductionEntityId'];?>" class="Flash-Message"></span>
           
                            <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse99<?php echo $i;?><?php echo $j;?>"><img src="img/insert-object.png" style="margin-bottom:3px;"> 
                                    <label class="comments"><b>Domain Id:</b></label>
                                    <label class="comments"><span style="text-align:left"><?php echo $key2;?></span></label>
                                </a>
                            </h4>
        </div>
                   <div class="col-md-3">
                       <a target="_blank" href="<?php echo Router::url(array('controller'=>'Puquerylist','action'=>'index','PEid' => $data2[0]['ProductionEntityId'],'ModuleId'=>$data2[0]['ModuleId']));?>" >Click to view</a>
                           
                             <button name ='frmsubmit' type="button" onclick="updateQuerydqc('<?php echo $data2[0]['StatusId'];?>','<?php echo $data2[0]['ProductionEntityId'];?>', '<?php echo $data2[0]['ModuleId']?>');" class="btn btn-default btn-sm">dqc Completed</button>
                             <button name ='frmsubmit' type="button" onclick="return updateQuerysub('<?php echo $data2[0]['StatusId'];?>','<?php echo $data2[0]['ProductionEntityId'];?>', '<?php echo $data2[0]['ModuleId']?>');" class="btn btn-default btn-sm">Submit</button>
        </div>
                        </div>

                        <div id="collapse99<?php echo $i;?><?php echo $j;?>" class="panel-collapse collapse in">
                            <div class="panel-body">
                            <?php $k=0;
                                foreach($data2 as $key3=>$data3){
                                    if(!empty($data3['Client_Response_Date']) && $data3['Client_Response_Date']!='NULL')                                    {
                                       $Cl_date=date("d-m-Y", strtotime($data3['Client_Response_Date']) ); 
                                       
                                    }
                                    else{
                                       $Cl_date=date("d-m-Y");  
                                    }
                                    
                                echo $this->Form->input('', array( 'type'=>'hidden','id' => 'QueryID', 'name' => 'Query[]','value'=>$data3['Id'])); 
                            ?>
                                <fieldset>
                                    <legend class="puq">
                                        <label class="comments"><b>Query Date:</b></label>
                                        &nbsp;&nbsp;&nbsp;
                                        <label class="comments"><span><?php echo $data3['QueryRaisedDate'];?></span></label> <span id="suc-message<?php echo $data3['Id'];?>" class="Flash-suc-Message"></span>
                                         <span id="error-message<?php echo $data3['Id'];?>" class="Flash-Message"></span>
                                        &nbsp;&nbsp;&nbsp;

                                    </legend>
                                    <div class="form-comment"> 
                                        <div class="form-group form-group-sm form-inline">
                                            
                                            <div class="row">
                                            <div class="form-group frmgrp_align col-md-3">
                                                <label class="comments"><span>User Raised Query</span></label>
                                                <div><textarea readonly="" rows="2" class="form-controls puq-cmt" title="<?php echo $data3['Query'];?>"><?php echo $data3['Query'];?></textarea></div>
                                            </div>

                                            <div class="form-group frmgrp_align  col-md-3">
                                                <label class="comments"><span>Mobius Comments</span><span class="mandatory">*</span></label>
                                                <div><textarea name='mobius_comments<?php echo $data3['Id']?>' rows="2" id='mobius_comments<?php echo $data3['Id']?>' class="form-controls puq-cmt" title="<?php echo $data3['TLComments'];?>"><?php echo $data3['TLComments'];?></textarea></div>
                                            </div>

                                            <div class="form-group frmgrp_align  col-md-3">
                                                <label class="comments">Status</label>
                                                <div><select class="form-control" name='status<?php echo $data3['Id']?>' id='status<?php echo $data3['Id']?>'>
                                                    <option <?php if($data3['QueryStatus'] != 3){ echo "selected"; } ?> value="2">Hold</option>
                                                    <option <?php if($data3['QueryStatus'] == 3){ echo "selected"; } ?> value="3" >Query Completed</option>
                                                    </select>
                                                </div>
                                            </div>
                                                <div class="form-group frmgrp_align  col-md-2">
                                                <label class="comments">Client Response</label>
                                                <div><textarea name='cl_resp<?php echo $data3['Id']?>' rows="2" id='cl_resp<?php echo $data3['Id']?>' class="form-controls puq-cmt" title="<?php echo $data3['Client_Response'];?>"><?php echo $data3['Client_Response'];?></textarea>
                                                </div>
                                                
                                            </div>
                                        </div>
                                            <div class="row">
                                            
                                            
                                            <div class="form-group frmgrp_align  col-md-3">
                                                <label class="comments">Client Response Date</label>
                                              <?php 
                                            echo $this->Form->input('', array('id' => 'respDate'.$data3['Id'].'', 'name' => 'respDate'.$data3['Id'].'', 'class'=>'form-control' , 'value'=>$Cl_date )); 
                                        ?>
                                            </div>
						<div class="form-group frmgrp_align  col-md-3">
                                                <label class="comments">File</label>
                                                <div><input type="file" name="upfile<?php echo $data3['Id']?>" id="upfile<?php echo $data3['Id']?>"  style="border:none;">
												<input type="hidden" name="domainId" id="domainId" value="<?php echo $key2;?>">
												<input type="hidden" name="InputEntityId" id="InputEntityId" value="<?php echo $data3['InputEntityId'];?>">
												</div>
                                                <?php echo $data3['UploadFile'];?>
												<br>(Allowed Formats: doc and pdf)
                                            </div>
                                                 <div class="form-group frmgrp_align  col-md-5">
                                                <button name ='frmsubmit' type="button" onclick="return updateQuery('<?php echo $data3['Id'];?>', '<?php echo $data3['ModuleId']?>', '<?php echo $data3['ProductionEntityId']?>');" class="btn btn-default btn-sm">Save</button>
                                               
											   
												
                                            </div>
                                        </div>
                                           

                                        </div>
                                    </div>
                                </fieldset>
                            <?php
                                $k++;
                                  }
                            ?>
                            </div>
                        </div>
                    </div>
                    <!-- Second Inner collapse  ends here --> 
                    <?php
                        $j++;
                        }
                    ?>
                </div>
            </div>
        </div>
        <!-- Second option in collapse  ends here --> 
        <?php 
            $i++;
        }?> 
    </div>

    <!-- Code for collaps ends -->
    <input type='hidden' name='successmsg' id='successmsg' value='successmsg'>
<?php echo $this->Form->end(); ?>
</div>
<?php } ?>
<style type='text/css'>
    .comments{top:0 !important;left:0 !important;position:relative !important;color:black !important;}
    .frmgrp_align{margin-left: 15px !important;margin-right: 0px !important;}


</style>

<script type="text/javascript">

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
            url: "<?php echo Router::url(array('controller' => 'Puquery', 'action' => 'ajaxmodule')); ?>",
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
    if($('#ProjectId').val() <= 0){
        alert("Please Choose Project");
        exit;
    }
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
    function updateQuerydqc(stsId,ProductionEntityId,ModuleId) {
            			
          var ProjectId = $("#ProjectId").val(); 
            var result = new Array();
             $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Puquery', 'action' => 'ajaxqueryinsertdqc')); ?>",
                  data: ({statusId: stsId,ProductionEntityId: ProductionEntityId, ModuleId: ModuleId, ProjectId: ProjectId}),
                success: function (res) { 
			if(res == '0'){
                           //$("#message"+ProductionEntityId).show(); 
                            $("#message"+ProductionEntityId).show().html("Status Not Completed"); 
                                    setTimeout(function(){
                                       $("#message"+ProductionEntityId).hide(); 
                                     }, 2000);
                                }
                                else{
                                    location.reload();
                                }
                           
                          //$(".hot_query").html(res);
                 }
                
            });
           
			//location.reload();
        }
         function updateQuerysub(stsId, ProductionEntityId, ModuleId) {
	 var ProjectId = $("#ProjectId").val(); 
            var result = new Array();
             $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Puquery', 'action' => 'ajaxquerysubmit')); ?>",
                  data: ({statusId: stsId,ProductionEntityId: ProductionEntityId, ModuleId: ModuleId, ProjectId: ProjectId}),
                success: function (res) { 
			if(res == '0'){
                           //$("#message"+ProductionEntityId).show(); 
                            $("#message"+ProductionEntityId).show().html("Status Not Completed"); 
                                    setTimeout(function(){
                                       $("#message"+ProductionEntityId).hide(); 
                                     }, 2000);
                                }
                                else{
                                    location.reload();
                                }
                           
                          //$(".hot_query").html(res);
                 }
                
            });
           
		
  
    }
	   function updateQuery(att, ModuleId, ProductionEntityId) {
		///
    var file_data = $('#upfile'+att).prop('files')[0];   
     var form_data = new FormData();                  
    form_data.append('file', file_data);
                                 
   
		///
		
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
        cl_resp = $('#cl_resp' + att).val();
        respDate = $('#respDate'+ att).val();
		ProjectId = $('#ProjectId').val();
		RegionId = $('#RegionId').val();
		DomainId = $('#domainId').val();
		InputEntityId = $('#InputEntityId').val();



        var result = new Array();
		form_data.append('mobiusComment', mobiusComment);
		form_data.append('queryID', att);
		form_data.append('status', status);
		form_data.append('cl_resp', cl_resp);
		form_data.append('cl_resp_date', respDate);
		form_data.append('ModuleId', ModuleId);
		form_data.append('ProductionEntityId', ProductionEntityId);
		form_data.append('ProjectId', ProjectId);
		form_data.append('RegionId', RegionId);
		form_data.append('DomainId', DomainId);
		form_data.append('InputEntityId', InputEntityId);
		 $.ajax({
        url: "<?php echo Router::url(array('controller'=>'puquery','action'=>'ajaxqueryinsert'));?>",
		dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,           
        data: form_data,                         
        type: 'post',
        success: function(res){
                        if(res == '0'){
                                       //$("#message"+ProductionEntityId).show(); 
                            $("#error-message"+att).show().html("Invalid uploaded file format !"); 
                                    setTimeout(function(){
                                       $("#error-message"+att).hide(); 
                                     }, 2000);
                                }
                                else{
                                     $("#suc-message"+att).show().html("Successfully Saved"); 
                                    setTimeout(function(){
                                       $("#suc-message"+att).hide(); 
                                     }, 2000);
                                }
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
            alert('Select Query Raised Date');
            return false;
        }
        if ($('#user_id').val() == '') {
            alert('Select Resource');
            return false;
        }
    }

    function ClearFields() {
        $('#ProjectId').val('0');
        //$('#RegionId').val('0');
        //$('#UserGroupId').val('');
        $('#ModuleId').val('0');
        $('#QueryDateFrom').val('');
        $('#QueryDateTo').val('');
        //$('#user_id').find('option').remove();
    }
</script>

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
<?php
            foreach($queryResult as $key=>$data){              
                    foreach($data as $key2=>$data2){
                       foreach($data2 as $key3=>$data3){
                          
 ?>
<script>
  $('#respDate<?php echo $data3['Id'];?>').Zebra_DatePicker({
          format: 'd-m-Y',
          direction: true,
          });
     
</script>
        <?php 
              }     
            }  
          }
        ?>
