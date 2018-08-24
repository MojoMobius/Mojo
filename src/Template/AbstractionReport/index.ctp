<?php

use Cake\Routing\Router
?>
<div class="container-fluid mt15">
    <div class="formcontent">
        <h4>Abstraction Report</h4>
            <?php echo $this->Form->create('',array('class'=>'form-horizontal','id'=>'projectforms')); ?>
        <div class="row">

            <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Client<span class="mandatory"> *</span></label>
                        <div class="col-sm-6" style="line-height: 0px;">
                             <?php
                       
                         echo $this->Form->input('', array('options' => $Clients, 'id' => 'ClientId', 'name' => 'ClientId', 'class' => 'form-control', 'value' => $ClientId));

                    ?>
                     <input type="hidden" name="RegionId" id="RegionId" value="<?php echo  $SessionRegionId;?>">
                     
                        </div>
                    </div>
                </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-6 control-label">Project <span class="mandatory"> *</span></label>
                    <div class="col-sm-6 prodash-txt">
                   <?php echo $this->Form->input('', array('options' => $Projects, 'id' => 'ProjectId', 'name' => 'ProjectId', 'class' => 'form-control', 'value' => $ProjectId));?>  
                        
                        <input type="hidden" name="regionId" id="RegionId" value="<?php echo $RegionId;?>" />
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="UserGroupId" class="col-sm-6 control-label">Lease Id<span class="mandatory"> *</span></label>
                    <div class="col-sm-6 ">
                       <div id="LoadUserGroup">
                            <input type="text" name="LeaseId" id="LeaseId" value="<?php echo $LeaseId;?>">
                       </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-6 control-label">Query Date From :</label>
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


        </div>

        <div class="form-group" style="text-align:center;" >
            <div class="col-sm-12">
                <input type="hidden" name='formSubmit'>
                <button type="submit" name = 'check_submit'class="btn btn-primary btn-sm" onclick="return formSubmitValidation();">Export Report</button>
                <button type="button" name = 'clear'class="btn btn-primary btn-sm" onclick="return ClearFields();">Clear</button>
                    <?php
// echo $this->Form->button('Export Report', array('id' => 'downloadFile', 'name' => 'downloadFile', 'value' => 'downloadFile', 'style' => 'margin-left:5px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return formSubmitValidation()', 'type' => 'submit'));   ?>
            </div>
        </div>
		<?php echo $this->Form->end(); ?>
    </div>
</div>


<style type='text/css'>
    .mandatory {
    color: red;
}
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
if (count($result) > 0) {
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
                                        <th style='width:10%;'>Project</th>
                                        <th style='width:5%;'>Lease ID</th>
                                        <th style='width:5%;'>No. of Documents</th>
                                        <th style='width:25%;'>PDF Name</th>

                                        <th style='width:5%;'>Status</th>
                                        <th style='width:15%;'>On-Hold Comments</th>
                                        <th style='width:10%;'>On-hold reported date</th>
                                        <th style='width:10%;'>Client Responses</th>
                                        <th style='width:10%;'>Client resolution date</th>
                                    </tr>
                                </thead>
                                <tbody>
                    <?php 
                        $i = 1;
                        foreach($result as $key1=>$data1){
                    ?>
                                    <tr>
                                        <td style='width:5%;'><?php echo $i;?></td>
                                        <td style='width:10%;'><?php echo $data1['ProjectName'];?></td>
                                        <td style='width:5%;'><?php echo $data1['leaseid'];?></td>
                                        <td style='width:5%;'><?php echo $data1['noofdocuments'];?> </td>
                                        <td style='width:25%;'><?php echo $data1['pdfname'];?></td>

                                        <td style='width:5%;'><?php echo $data1['status'];?></td>
                                        <td style='width:15%;'><?php echo $data1['holdcomments'];?></td>
                                        <td style='width:10%;'><?php echo $data1['holdreportdate'];?></td>
                                        <td style='width:10%;'><?php echo $data1['Client_Response'];?></td>
                                        <td style='width:10%;'><?php echo $data1['Client_Response_Date'];?></td>
                                    </tr>

                            <?php 
                            $i++;
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
}
echo $this->Form->end();
?>


<script type="text/javascript">


    function formSubmitValidation() {


        if ($('#ClientId').val() == 0) {
            alert('Select Client Id');
            $('#ClientId').focus();
            return false;
        }
     
        if ($('#ProjectId').val() == 0) {
            alert('Select Project Name');
            $('#ProjectId').focus();
            return false;
        }
        
        if ($('#LeaseId').val() == 0) {
            alert('Please Enter LeaseId ');
            $('#LeaseId').focus();
            return false;
        }
        
//        if ($('#QueryDateFrom').val() == '' && $('#QueryDateTo').val() == '') {
//            alert('Select From Date');
//            return false;
//        }

    }

    function ClearFields() {
        $('#ProjectId').val('0');
        $('#LeaseId').val('');
        $('#ClientId').val('0');   
        $('#QueryDateFrom').val('');   
        $('#QueryDateTo').val('');   

    }
</script>

