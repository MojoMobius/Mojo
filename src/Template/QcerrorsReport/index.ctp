<?php

use Cake\Routing\Router;
?>
<div class="container-fluid">
    <div class=" jumbotron formcontent">
        <h4>QC Errors Report </h4>
        <?php echo $this->Form->create('', array('class' => 'form-horizontal', 'id' => 'projectforms')); ?>
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
        
        
        <div class="col-md-4">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Project</label>
                <div class="col-sm-6">
                    <div id="LoadProject">
                        <?php
                    echo $this->Form->input('', array('options' => $Projects, 'id' => 'ProjectId', 'name' => 'ProjectId', 'class' => 'form-control prodash-txt', 'value' => $ProjectId, 'onchange' => 'getusergroupdetails();getModule();'));
                    ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">Module</label>
                <div class="col-sm-6">
                    <div id="LoadModule">
                    <?php
                    if ($ModuleIds == '') {
                        $Modules = array(0 => '--Select--');
                        ?>
                            <?php
                            echo $this->Form->input('', array('options' => $Modules, 'id' => 'ModuleIds', 'name' => 'ModuleIds', 'class' => 'form-control prodash-txt', 'value' => $ModuleIds));
                            //echo $ModuleList;
                            ?>
                    <?php
                    } else {
                        echo $ModuleIds;
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-md-4 hide ">
            <div class="form-group">
                <label for="inputEmail3" style="margin-top: 0px;" class="col-sm-6 control-label">Region</label>
                <div class="col-sm-6" style="line-height: 0px;margin-top: -5px;">
                    <div id="LoadRegion">
                        <input type="text" name="RegionId" id ="RegionId" value="<?php echo $RegionId;?>" />
                    
                    </div>
                </div>
            </div>

        </div>
      </div>
        <div class="row"> 

        <div class="col-md-4">
            <div class="form-group">
                <label for="UserGroupId" class="col-sm-6 control-label">User Group</label>
                <div class="col-sm-6 prodash-txt">
                    <div id="LoadUserGroup">
                    <?php
                    if ($UserGroupId == '') {
                        $UserGroup = array(0 => '--Select--');
                        //echo '<div id="LoadUserGroup">';
                        echo $this->Form->input('', array('options' => $UserGroup, 'id' => 'UserGroupId', 'name' => 'UserGroupId', 'class' => 'form-control', 'value' => $UserGroupId, 'selected' => $UserGroupId, 'onchange' => 'getresourcedetails'));
                        //echo '</div>';
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
                <label for="inputPassword3" class="col-sm-6 control-label">From</label>
                <div class="col-sm-6 prodash-txt">
<?php
echo $this->Form->input('', array('id' => 'batch_from', 'name' => 'batch_from', 'class' => 'form-control', 'value' => $postbatch_from));
?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">To</label>
                <div class="col-sm-6 prodash-txt" >
<?php
echo $this->Form->input('', array('id' => 'batch_to', 'name' => 'batch_to', 'class' => 'form-control', 'value' => $postbatch_to));
?>
                </div>
            </div>
        </div>
        </div>
        
        <div class="col-md-4">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">Resource</label>
                <div class="col-sm-6 prodash-txt">
                    <div id="LoadUserDetails">
<?php
echo $this->Form->input('', array('options' => $User,'class' => 'form-control', 'selected' => $postuser_id, 'value' => $postuser_id, 'id' => 'user_id', 'name' => 'user_id', 'style' => 'height:70px; width:185px;', 'multiple' => true));
?>
                    </div>
                </div>
            </div>
        </div>
       
       

        <div class="form-group" style="text-align:center;">
            <div class="col-sm-12">
                <?php
                echo $this->Form->button('Search', array('id' => 'check_submit', 'name' => 'check_submit', 'value' => 'Search', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return Mandatory()'));

                echo $this->Form->button('Clear', array('id' => 'Clear', 'name' => 'Clear', 'value' => 'Clear', 'style' => 'margin-left:5px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return ClearFields()', 'type' => 'button'));
          
 echo $this->Form->button('Export Report', array('id' => 'downloadFile', 'name' => 'downloadFile', 'value' => 'downloadFile', 'style' => 'margin-left:5px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return formSubmitValidation()', 'type' => 'submit'));  
 
                if (count($result) > 0) {
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
                                        <th style='width:5%;'>Review Completed Date</th>
                                        <th style='width:5%;'>Review Assigned To</th>
                                        <th style='width:5%;'>Abstraction Assigned To</th>
                                        <th style='width:5%;'>Subject</th>
                                        
                                        <th style='width:5%;'>Lease ID</th>
                                        <th style='width:5%;'>Lease Status</th>
                                        <th style='width:5%;'>Languages</th>
                                        
                                        <?php 
                                          foreach($Attributetitle as $key=>$data){?>
                                               <th style='width:5%;'><?php echo $data;?></th>
                                          <?php } ?>
                                        
                                        <th style='width:5%;'>Total Error</th>
                                        <th style='width:5%;'>Total Fields</th>
                                        
                                        <th style='width:5%;'>Quality %</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                    <?php 
                        $i = 1;
                      
                        foreach($result as $key=>$data){
                    ?>
                                    <tr>
                                        <td style='width:5%;'><?php echo $i;?></td>
                                        <td style='width:5%;'><?php echo $data['End_Date']; ?></td>
                                        <td style='width:5%;'><?php echo $data['UserName']; ?></td>
                                        <td style='width:5%;'><?php echo $data['abstUserName'];?> </td>
                                         <td style='width:5%;'><?php echo $data['subject'];?></td>  
                                         
                                         <td style='width:5%;'><?php echo $data['fdrid'];?></td>
                                        <td style='width:5%;'><?php echo $data['ProjectStatus'];?></td>
                                        <td style='width:5%;'><?php echo $data['language'];?></td>
                                        
                                        <?php   foreach($data['attr'] as $key1=>$data1){?>
                                            <td style='width:5%;'><?php echo $data1['count'];?></td>
                                        <?php   }?>
                                        
                                        <td style='width:5%;'><?php echo $data['Totalerrors'];?></td>
                                        <td style='width:5%;'><?php echo $data['Totalfields'];?></td>
                                        <td style='width:5%;'><?php echo $data['quality'];?></td>
                                        
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

    
   <?php

echo $this->Form->end();
?>

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
        
        var id = $('#RegionId').val();


    });
    function viewjob(moduleid, inputentid, tablename, projectid) {
        var action = 'view'
        var url = action + '/' + moduleid + '/' + inputentid + '/' + tablename + '/' + projectid;
        var currenturl = document.URL;
        //window.location.href=currenturl+'/'+url;
        var urlopen = currenturl + '/' + url;
        window.open(urlopen, '_blank');
        //alert(url);
    }

    function getRegion(projectId) {

        var result = new Array();

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'Productionview', 'action' => 'ajaxregion')); ?>",
            data: ({projectId: projectId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadRegion').innerHTML = result;
                //$('#UserGroupId').find('option').remove();
                $('#user_id').find('option').remove();
            }
        });
    }
    function getModule()
    {
        var result = new Array();
        var ProjectId = $('#ProjectId').val();
        var RegionId = $('#RegionId').val();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'Productionview', 'action' => 'ajaxmodule')); ?>",
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
            url: "<?php echo Router::url(array('controller' => 'Productionview', 'action' => 'getusergroupdetails')); ?>",
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
            url: "<?php echo Router::url(array('controller' => 'Productionview', 'action' => 'getresourcedetails')); ?>",
            data: ({projectId: ProjectId, regionId: RegionId, userGroupId: UserGroupId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadUserDetails').innerHTML = result;
            }
        });
    }
    
function getProject(){
    
  var RegionId=$("#RegionId").val();
  var id=$("#ClientId").val();
  $("#LoadProject").html('Loading...');
            $.ajax({
            url: '<?php echo Router::url(array('controller' => 'QcerrorsReport', 'action' => 'ajaxProject')); ?>',
            
            data: {ClientId: id,RegionId: RegionId},
            type: 'POST',
            success: function (res) { 
	     $("#LoadProject").html(res);
            }
        });
}

    function getStatus()
    {
        var result = new Array();
        var ProjectId = $('#ProjectId').val();
        var ModuleId = $('#ModuleId').val();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'Productionview', 'action' => 'ajaxstatus')); ?>",
            data: ({ProjectId: ProjectId, ModuleId: ModuleId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadStatus').innerHTML = result;
            }
        });
    }

    function ClearFields()
    {
        $('#ProjectId').val('0');
        $('#ModuleId').val('0');
        $('#batch_from').val('');
        $('#batch_to').val('');
        $('#UserGroupId').val('');
        $('#ClientId').val(0);
        $('#detail').hide();
        $('#pagination').hide();
        $('#xlscnt').hide();
        $('#status').find('option').remove();
        $('#user_id').find('option').remove();
    }

    function Mandatory()
    {
        if ($('#ProjectId').val() == 0) {
            alert('Select Project Name');
            $('#ProjectId').focus();
            return false;
        }
       
        if ($('#ModuleId').val() == 0) {
            alert('Select Module');
            $('#ModuleId').focus();
            return false;
        }

        if (($('#batch_from').val() == '') && ($('#batch_to').val() == '') && ($('#user').val() == null))
        {
            alert('Select any one date!');
            return false;
        }
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
        getModule();
        getusergroupdetails(regId);
    });
</script>
    <?php
}
?>
   