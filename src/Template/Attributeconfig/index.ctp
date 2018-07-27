<!--Form : Project Config
  Developer: Sivaraj K
  Created On: Sep 20 2016 -->
<?php

use Cake\Routing\Router; ?>
<style>
    .select{
        margin-top: -18px !important;
    }
</style>
<script type="text/javascript">
    function validateForm()
    {

        if ($('#ProjectId').val() == 0)
        {
            alert('Enter Project Id');
            $('#ProjectId').focus();
            return false;
        }
        if ($('#ProjectId').val() != '')
        {
             document.projectforms.submit();
        }


    }

    function checkprojectid(ProjectId) {
        //alert(ProjectId);
//        var result = new Array();
//        $.ajax({
//            type: "POST",
//            url: "<?php //echo Router::url(array('controller' => 'Projectconfig', 'action' => 'ajaxcheckproject'));  ?>",
//            data: ({ProjectId: ProjectId}),
//            dataType: 'text',
//            async: false,
//            success: function (result) {
//                if(result==''){
//                alert('Project Id not available in D2K');
//                setTimeout(function(){
//                    $('#ProjectId').focus();
//                    return false;
//                    }, 1);
//            
//                }else{
//                 return true;   
//                }
//                //document.getElementById('LoadRegion').innerHTML = result;
//            }
//        });
    }


</script>

<div class="container-fluid mt15">
    <div class="formcontent">
        <h4>Project Configuration</h4>
        <?php echo $this->Form->create($Projectconfig, array('class' => 'form-horizontal', 'id' => 'projectforms','name' => 'projectforms')); ?>
        <span id="reg">  <input type="hidden" name="RegionId" id="RegionId" value="<?php echo $RegionId;?>"></span>
        <div class="row">
         <div class="col-md-4">
            <div class="form-group">
                <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Project</label>
                <div class="col-sm-6" style="margin-top:3px;">
                  
                    <?php 
                    if ($ProjectIds == '') {
                    $Modules = array(0 => '--Select--'); ?>

                        <?php
                        echo $this->Form->input('', array('options' => $Projects, 'id' => 'ProjectId', 'name' => 'ProjectId', 'class' => 'form-control ', 'value' => $ProjectId, 'onchange' => 'getattribute(this.value);'));
                        //echo $ModuleList;
                            ?>

                    <?php }else{
                        echo $ProjectIds;
                    } ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Commencement Date AttributeId</label>
                <div class="col-sm-6" style="margin-top:3px;">
                    <div id="Attr1"><?php echo $Attr1;?> </div>
                </div>
            </div>
        </div>
         <div class="col-md-4">
            <div class="form-group">
                <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Expiration Date AttributeId</label>
                <div class="col-sm-6" style="margin-top:3px;">
                    <div id="Attr2"><?php echo $Attr2;?> </div>
                </div>
            </div>
        </div>
            </div>
        <div class="row">
         <div class="col-md-4">
            <div class="form-group">
                <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Base Rent Initial amount AttributeId</label>
                <div class="col-sm-6" style="margin-top:3px;">
                    <div id="Attr3"><?php echo $Attr3;?> </div>
                </div>
            </div>
        </div>
         <div class="col-md-4">
            <div class="form-group">
                <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Rent Inc AttributeId</label>
                <div class="col-sm-6" style="margin-top:3px;">
                    <div id="Attr4"><?php echo $Attr4;?></div>
                </div>
            </div>
        </div>
            <div class="col-md-4"></div>   
        </div>
        
                  
	
       
		
       
       
        <div class="form-group" style="text-align:center;">
            <div class="col-sm-12">
                <button type="button" class="btn btn-primary btn-sm" value="Submit" id="testbut" name="testbut" onclick="return validateForm()">Submit</button>
            </div>
        </div>

        <!--        <div class="form-group" style="text-align:center;">
                    <div class="col-sm-12">
        <?php //echo $this->Form->submit('Submit', array('id' => 'submit', 'name' => 'submit', 'value' => 'Submit', 'class' => 'btn btn-primary btn-sm pull-right', 'onclick' => 'return validateForm()')); ?>
                    </div>
                </div>-->
        <?php echo $this->Form->end(); ?>
    </div>
    <div class="bs-example mt15">
        <table class="table table-striped table-center" id="example">
            <thead>
                <tr>
                    <th>Project Name</th>                    
                    <th>Commencement Date AttrId</th>
                    <th>Expiration Date AttrId</th>
                    <th>Base Rent Initial amount AttrId</th>
                    <th>Rent Inc AttrId</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($AttrList as $inputVal => $input) {
                  
                    $EdiT = $this->Html->link('edit', ['action' => 'index', $input['Id']]);
                    ?>
                <tr>
                        <?php
                        echo '<td>' . $input['ProjectId'] . '</td>';
                        echo '<td>' . $input['Commencement_Date_Proj_AttrId'] . '</td>';
                        echo '<td>' . $input['Expiration_Date_Proj_AttriId'] . '</td>';
                        echo '<td>' . $input['Base_Rent_Initial_amount_Proj_AttriId'] . '</td>';
                        echo '<td>' . $input['Rent_Inc_Proj_AttrId'] . '</td>';
                        echo '<td>' . $EdiT . '</td>';
                        ?>    
                </tr>
                <?php }
                ?>

            </tbody>
        </table>
    </div>
    <div>&nbsp;</div>
</div>
<script>
    
    
    $(document).ready(function (projectId) {
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
       // var id = $('#RegionId').val();

//        if ($('#ProjectId').val() != '') {
//            getRegion();
//            var e = document.getElementById("RegionId");
//            var strUser = e.options[e.selectedIndex].text;
//
//        }

                    
    });
  function getattribute(ProId){
      //var RegionId=$("#RegionId").val();  
            $.ajax({
            url: '<?php echo Router::url(array('controller' => 'Attributeconfig', 'action' => 'ajaxdata')); ?>',
            
            data: {ProId: ProId},
            type: 'POST',
            success: function (res) { 
	     $("#Attr1").html(res);
             $("#Attr2").html(res);
             $("#Attr3").html(res);
             $("#Attr4").html(res);
            }
        });
         $.ajax({
            url: '<?php echo Router::url(array('controller' => 'Attributeconfig', 'action' => 'ajaxdataregion')); ?>',
            
            data: {ProId: ProId},
            type: 'POST',
            success: function (res) { 
	     $("#reg").html(res);
            }
        });
  }    
</script>
