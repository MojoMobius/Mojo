<?php

use Cake\Routing\Router
?>
<style>
    .mandatory{
        color:red;
    }
    .Flash-suc-Message{
        font-size: 18px;
		padding-left:10%;		
        color:green;
    }
	.Flash-error-Message{
        font-size: 18px;
		padding-left:10%;		
        color:red;
    }
    .Flash-Message{
        font-size: 18px;
        color:red;
    }
.form-inline .form-group {
     margin-bottom: 2px!important; 
}
table td input{
	width:30px!important;
}
</style>
 <?php echo $this->Form->create('',array('class'=>'form-horizontal','id'=>'projectforms')); ?>

<div class="container-fluid mt15">
    <div class="formcontent">
        <h4>Delivery Page</h4>
           
<?php //$SessionRegionId='1011'; ?>
        
                     <input type="hidden" name="RegionId" id="RegionId" value="<?php echo  $SessionRegionId;?>">
        <div class="row">
		  <div class="col-md-5">
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
                     <input type="hidden" name="RegionId" id="RegionId" value="<?php echo  $SessionRegionId;?>">
                     
                        </div>
                    </div>
                </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Project<span class="mandatory"> *</span> </label>
				 
                <div id="LoadProject" class="col-sm-6 " style="line-height: 0px;">
                   <?php echo $this->Form->input('', array('options' => $Projects, 'id' => 'ProjectId', 'name' => 'ProjectId', 'class' => 'form-control', 'value' => $ProjectId, 'onchange' => 'getusergroupdetails('.$SessionRegionId.');getModule(this.value);'));?>  
                </div>
            </div>
        </div>
        </div>
        <div class="row">



        <div class="col-md-5">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">From<span class="mandatory"> *</span>:</label>
                <div class="col-sm-6 prodash-txt">
                    <?php 
                        echo $this->Form->input('', array('id' => 'QueryDateFrom', 'name' => 'QueryDateFrom', 'class'=>'form-control' , 'value'=>$QueryDateFrom )); 
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">To:</label>
                <div class="col-sm-6 prodash-txt">
                    <?php 
                        echo $this->Form->input('', array('id' => 'QueryDateTo', 'name' => 'QueryDateTo', 'class'=>'form-control','value'=>$QueryDateTo )); 
                    ?>
                </div>
            </div>
        </div>

        
        </div>
		

        <div class="form-group" style="text-align:center;" >
            <div class="col-sm-12">
                <!--<input type="hidden" name='formSubmit'>
                <button type="submit" name = 'check_submit'class="btn btn-primary btn-sm" onclick="return formSubmitValidation();">Submit</button>
                <button type="button" name = 'clear'class="btn btn-primary btn-sm" onclick="return ClearFields();">Clear</button>
				-->
				 <?php
            echo $this->Form->submit('Delivery Page Report', array('id' => 'check_submit', 'name' => 'check_submit', 'value' => 'Job Status', 'style' => 'margin-left:350px;width:170px;float:left;padding-bottom:2 px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return Mandatory()'));
            
                        
            echo $this->Form->button('Clear', array('id' => 'Clear', 'name' => 'Clear', 'value' => 'Clear', 'style' => 'margin-left:10px;float:left;display:inline;padding-bottom:6px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return ClearFields()', 'type' => 'button'));
             
            
             
            ?>
                       

            </div>
        </div>
    </div>
</div>

<!-- ******************************************************************************************************************************************************* -->

    <div style="padding-bottom:50px;">
      <input type="submit" id="submit" name="submit" value="Submit Status" style="margin-left:40px;width:140px;float:left;padding-bottom:2 px;" class="btn btn-primary btn-sm">
	</div>

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
                                        <th style='width:10%;'>S.No</th>
                                        <th style='width:10%;'>Action</th>
                                        <th style='width:20%;'>Project</th>
                                        <th style='width:20%;'>FDR ID</th>
                                        <th style='width:20%;'>Start Date</th>
                                        <th style='width:20%;'>Total Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                    <?php 
                        $i = 1;
if (count($result) > 0) {

                        foreach($result as $key1=>$data1){
                    ?>
                                    <tr>
                                        <td ><?php echo $i;?></td>
                                        <td ><input type="checkbox" name="chk_status[]" id="chk_status<?php echo $data1['Id'];?>"value="<?php echo $data1['Id'];?>"></td>
                                        <td ><?php echo $project_name;?></td>
                                        <td ><?php echo $data1['fdrid'];?> </td>
                                        <td ><?php echo $data1['ProductionStartDate'];?></td>
                                        <td ><?php echo $data1['TotalTimeTaken'];?></td>
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

<style type='text/css'>
    .comments{top:0 !important;left:0 !important;position:relative !important;color:black !important;}
    .frmgrp_align{margin-left: 15px !important;margin-right: 0px !important;}


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

<script type="text/javascript">

    function ClearFields() {
        $('#ProjectId').val('0');
        $('#ClientId').val('0');
        $('#QueryDateFrom').val('');
        $('#QueryDateTo').val('');
    }
	function getProject(id){
    
  var RegionId=$("#RegionId").val();
  $("#LoadProject").html('Loading...');
            $.ajax({
            url: '<?php echo Router::url(array('controller' => 'DeliveryPage', 'action' => 'ajaxProject')); ?>',
            
            data: {ClientId: id,RegionId: RegionId},
            type: 'POST',
            success: function (res) { 
	     $("#LoadProject").html(res);
            }
        });
}    

function Mandatory()
    {

            if ($('#ClientId').val() == 0) {
                alert('Select Client Name');
                $('#ClientId').focus();
                return false;
            }
			else if ($('#ProjectId').val() == 0) {
                alert('Select Project Name');
                $('#ProjectId').focus();
                return false;
            }            

            
			else{
				return true;
			}

    }

</script> 
