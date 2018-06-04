<?php
/*
 * Form : TL Rebutal
 * Developer: SyedIsmail N
 * Created On: SEP 12 2017
 */
use Cake\Routing\Router
?>
<div class="panel-group" id="accordion-dv" role="tablist" aria-multiselectable="true" style="margin-top:10px;">
    <div class="container-fluid">
        <div class="panel panel-default formcontent">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h3 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-dv" href="#collapseTw" aria-expanded="false" aria-controls="collapseTwo" style="text-decoration:none;">
                        <i class="more-less glyphicon glyphicon-plus"></i> TL Rebutal
                    </a>
                </h3>
            </div>
            <div id="collapseTw" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
               <?php echo $this->Form->create('', array('name' => 'projectforms', 'id' => 'projectforms', 'class' => 'form-horizontal', 'inputDefaults' => array( 'div' => false),'type'=> 'post')); ?>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Project</label>
                        <div class="col-sm-6" style="line-height: 0px;">
                            <?php echo $this->Form->input('', array('options' => $Projects, 'id' => 'ProjectId', 'name' => 'ProjectId', 'class' => 'form-control', 'value' => $ProjectId,'style' => 'width:220px', 'onchange' => 'getRegion(this.value);getModule(this.value);')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">Region</label>
                        <div class="col-sm-6" style="line-height: 0px;">
                            <div id="LoadRegion">
                                <?php if ($RegionId == '') {
                                    $Region = array(0 => '--Select--');
                                    echo $this->Form->input('', array('options' => $Region, 'id' => 'RegionId', 'name' => 'RegionId', 'class' => 'form-control', 'value' => $RegionId,'style' => 'width:220px', 'onchange' => 'getusergroupdetails(this.value)'));
                                } else {
                                    echo $RegionId;
                                } ?>
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
                        <label for="inputPassword3" class="col-sm-6 control-label">Module</label>
                        <div class="col-sm-6">
                            <div id="LoadModule">
                                <?php if ($ModuleIds == '') {
                                        $Modules = array(0 => '--Select--');
                                ?>
                                <?php
                                    echo $this->Form->input('', array('options' => $Modules, 'id' => 'ModuleIds', 'name' => 'ModuleIds', 'class' => 'form-control prodash-txt', 'value' => $ModuleIds));
                                } else {
                                    echo $ModuleIds;
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">From</label>
                        <div class="col-sm-6" style="line-height: 0px;">
                            <?php echo $this->Form->input('', array('id' => 'batch_from', 'name' => 'batch_from', 'class' => 'form-control','style' => 'width:220px', 'value' => $postbatch_from)); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputEmail3" style="margin-top: 5px;" class="col-sm-6 control-label">To</label>
                        <div class="col-sm-6" style="line-height: 0px;">
                            <?php echo $this->Form->input('', array('id' => 'batch_to', 'name' => 'batch_to', 'class' => 'form-control','style' => 'width:220px', 'value' => $postbatch_to)); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="text-align:center;">
                    <div class="col-sm-12">
                    <input type="hidden" name="hideval" id="hideval" value="<?php if($hideval!=''){ echo $hideval;} ?>">
                    <?php
                        echo $this->Form->submit(' Search ', array('id' => 'check_submit', 'name' => 'check_submit', 'value' => 'Job Status', 'style' => 'margin-left:550px;width:100px;float:left;padding-bottom:2 px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return Mandatory()'));
                        echo $this->Form->button(' Clear ', array('id' => 'Clear', 'name' => 'Clear', 'value' => 'Clear', 'style' => 'margin-left:10px;float:left;display:inline;padding-bottom:6px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return ClearFields()', 'type' => 'button'));
                    ?>
                    <span id='xlscnt' style="float:right; margin-right:20px; margin-top:27px;display:none;">
                        <button type='submit' name='downloadFile' id='downloadFile' value='downloadFile' onclick="return Mandatory();"><img width="20" height="20" src="img/file-xls.jpg" ><img width="12" height="12" src="img/down_arrow.gif"></button>
                    </span>
                    <?php 
                        if (count($TLRebutalUser_detail) > 0) {
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

<?php echo $this->Form->create('', array('name' => 'updateProcution', 'id' => 'updateProcution', 'class' => 'form-group', 'inputDefaults' => array( 'div' => false),'type'=> 'post')); ?>
<div id="rebute" class="white_content" style="width:60%">
  <div class="rebute_popuptitle"><b style="padding-left:20px;float:left;width:40%;">Rebute</b><div align='right'> <b><a onclick="document.getElementById('rebute').style.display='none';document.getElementById('fade').style.display='none'"><?php echo $this->Html->image('cancel.png', array('width'=>'20px','height'=>'20px','alt' => 'Close'));?></a></b></div></div>
  <div class="query_innerbdr_disble">
    <div class="query_outerbdr">
        <div class="form-group form-group-sm rebute_popuphgt" style="height:200px;">
            <div class="col-sm-8">
               <label hidden style="color:#ff7f06" id="filename"></label>
           </div>
                <table width='100%' id="rebuteTable">
                    <tr class='Heading'>
                        <td>S.No</td>
                        <td>Attribute</td>
<!--                        <td>QC Value</td>-->
                        <td>PU Value</td>
                        <td>Error Category</td>
                        <td>Sub Error Category</td>
                        <td>Page No</td>
<!--                        <td>Reference</td>-->
                        <td>QC Comments</td>
                        <td>Rebute</td>
                        <td>TL Rebutal Comments</td>
                    </tr>
                </table>           
            <label class="col-sm-8 control-label" style='color:#ff7f06;'>&nbsp;**click checkbox to enable Rebutal textbox, Unchecked jobs shall Move to PU</label>
                <input type="hidden" value="2" name="cmdStatus" id="cmdStatus">
                <input type="hidden" value="" name="InputEntityId" id="InputEntityId">
                <input type="hidden" value="" name="productionID" id="productionID">
                <input type="hidden" value="" name="ActStartDate" id="ActStartDate">
                <input type="hidden" value="" name="totalerrorscount" id="totalerrorscount">
                <input type="hidden" name="ProjectId" id="ProjectId" value="<?php echo $ProjectId; ?>">
                <input type="hidden" name="RegionId" id="RegionId" value="<?php echo $regionId; ?>">
                <input type="hidden" name="UserGroupId" id="UserGroupId" value="<?php echo $UserGroupIdVal; ?>">
                <input type="hidden" name="ModuleId" id="ModuleId" value="<?php echo $ModuleIdVal; ?>">
                <input type="hidden" name="batch_from" id="batch_from" value="<?php echo $postbatch_from; ?>">
                <input type="hidden" name="batch_to" id="batch_to" value="<?php echo $postbatch_to; ?>">
                <label class="col-sm-4 control-label">&nbsp;</label>
            <div id="Masbutton" class="col-sm-10" align="center">
                <button class="btn btn-default btn-sm" type="submit" value="updateTLComments" name='updateTLComments'  id='updateTLComments' onclick = "return updateTLCommentsfn();">Submit</button>
                &nbsp;
            </div>
        </div>
        &nbsp;
    </div>
  </div>
</div>
<div id="fade" class="black_overlay"></div>
<?php echo $this->Form->end(); ?>

<?php  if (count($TLRebutalUser_detail) > 0) { ?>
<?php // echo $this->Form->create('', array('name' => 'sampleRebutal', 'id' => 'sampleRebutal', 'class' => 'form-group', 'inputDefaults' => array( 'div' => false,'label'=>false),'type'=> 'post')); ?>
<div class="container-fluid">
    <div class="bs-example">
        <div id="vertical" style="margin-top:-210px;">
            <div id="top-pane" >
                <div id="horizontal" style="height: 100%; width: 100%;">
                    <div id="left-pane" class="pa-lef-10">
                        <div class="pane-content" >
                            <input type="hidden" name="UpdateId" id="UpdateId">
                            <button style="float:right; height:18px; visibility: hidden; margin-right:15px;" type='hidden' name='downloadFile' id='downloadFile' value='downloadFile'></button>
                            <table style='width:100%;' class="table table-striped table-center" id='example'>
                                <thead>
                                    <tr><th colspan="6"></th></tr>
                                    <tr class="Heading">
                                        <th class="Cell" width="10%">Domain Id</th> 
                                        <th class="Cell" width="10%">Region</th> 
                                        <th class="Cell" width="10%">Qc User</th>
                                        <th class="Cell" width="10%">Production User</th>
                                        <th class="Cell" width="10%">Rebute</th>
                                        <th class="Cell" width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; foreach ($TLRebutalUser_detail as $inputVal => $input): ?>
                                    <tr>
                                        <td class="Cell" width="10%"><a href="<?php echo $input['DomainUrl'] ?>" target="_blank"><?php echo $input['DomainId'] ?></a></td>
                                        <td class="Cell" width="10%"><?php echo $contentArr['RegionList'][$input['RegionId']] ?></td>
                                        <td class="Cell" width="10%"><?php echo $contentArr['UserList'][$input['QCUSerID']] ?></td>
                                        <td class="Cell" width="10%"><?php echo $contentArr['UserList'][$input['UserId']] ?></td>
                                        <td class="Cell" width="10%"><?php echo $this->Form->button('Rebute', array('hiddenField' => false,'id'=>'rebute','class'=>'btn btn-default btn-sm','type'=>'button','name'=>'Rebute','value'=>'Rebute','onclick'=>"rebute('".$input['InputEntityId']."','".$input['Id']."','".$input['RegionId']."','".$input['ProjectId']."');"))?></td>
                                        <td class="Cell" width="10%"><?php echo $this->Form->checkbox('', array('hiddenField' => false,'id'=>'rework'.$input['InputEntityId'],'name'=>'rework[]','value'=>$input['InputEntityId']))?></td>
                                    </tr>
                                    <?php $i++; endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
            <?php
                echo $this->Form->button('Move to PU', array( 'id' => 'Submit', 'name' => 'Submit', 'value' => 'Submit','class'=>'btn btn-default btn-sm','onclick'=>"ValidateForm('save');")); 
            ?>
    </div>
</div>
<div id="fade" class="black_overlay"></div>
<?php
}
echo $this->Form->end();
?>

<script type="text/javascript">
    $(document).ready(function () {
        
        var proj = $('#hideval').val();
        if(proj == '1'){
           $("#check_submit").click();
        }
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
        var Regid = $('#RegionId').val();
        <?php
            $js_array = json_encode($ProdDB_PageLimit);
            echo "var mandatoryArr = " . $js_array . ";\n";
        ?>
        var pageCount = mandatoryArr;
        tables = $('#example').DataTable({
            "sPaginationType": "full_numbers",
            "sDom": 'Rlifprtlip',
            "bStateSave": true,
            "bFilter": true,
            "aoColumnDefs": [
                {"bSearchable": false, "aTargets": [6]}
            ]
        });
    });

    function getRegion(projectId) {
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'TLRebutalUser', 'action' => 'ajaxregion')); ?>",
            data: ({projectId: projectId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadRegion').innerHTML = result;
                $('#user_id').find('option').remove();
            }
        });
    }
    
    function getModule() {
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

    function getusergroupdetails(RegionId) {
        var ProjectId = $('#ProjectId').val();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'TLRebutalUser', 'action' => 'getusergroupdetails')); ?>",
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
            url: "<?php echo Router::url(array('controller' => 'TLRebutalUser', 'action' => 'getresourcedetails')); ?>",
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
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'TLRebutalUser', 'action' => 'ajaxstatus')); ?>",
            data: ({projectId: projectId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadStatus').innerHTML = result;
            }
        });
    }

    function ClearFields() {
        $('#ProjectId').val('0');
        $('#RegionId').val('0');
        $('#UserGroupId').val('0');
        $('#ModuleId').val('0');
        $('#batch_from').val('');
        $('#batch_to').val('');
        $('#example').hide();
    }

    function Mandatory() {
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
        if ($('#UserGroupId').val() == 0) {
            alert('Select User Group');
            $('#UserGroupId').focus();
            return false;
        }
        if ($('#ModuleId').val() == 0) {
            alert('Select Module Name');
            $('#ModuleId').focus();
            return false;
        }
        if (($('#batch_from').val() == '') && ($('#batch_to').val() == '')) {
            alert('Select any one date!');
            $('#batch_from').focus();
            return false;
        }
    }
    
    function rebute(InputEntityId,ID,RegionId,ProjectId) {
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'TLRebutalUser', 'action' => 'ajaxgetcommands')); ?>",
            data: ({ID:ID, InputEntityId:InputEntityId, RegionId:RegionId, ProjectId:ProjectId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                $('#rebuteTable tr').slice(1).remove();
                $("#InputEntityId").val(InputEntityId)
                $("#productionID").val(ID)
                document.getElementById('rebute').style.display='block';
                document.getElementById('fade').style.display='block';
                
                var getContact = eval('(' + result + ')');
                var totalerrorscount = getContact.length;
                $('#totalerrorscount').val(totalerrorscount);
                j=1;
                for(i=0;i<getContact.length;i++){

                    var newRow = $("<tr class='Row'>");
                    var cols = "";
                    cols += '<td class="Cell">'+j+'</td>';
                    cols += '<td class="Cell">'+getContact[i].ProjectAttributeMasterId+'</td>';
//                    cols += '<td class="Cell">'+getContact[i].QCValue+'</td>';
                    cols += '<td class="Cell">'+getContact[i].OldValue+'</td>';
                    cols += '<td class="Cell">'+getContact[i].ErrorCategoryName+'</td>';
                    cols += '<td class="Cell">'+getContact[i].SubCategoryName+'</td>';
                    cols += '<td class="Cell">'+getContact[i].SequenceNumber+'</td>';
//                    cols += '<td class="Cell">'+getContact[i].Reference+'</td>';
                    cols += '<td class="Cell">'+getContact[i].QCComments+'</td>';
    //                    cols += '<td class="Cell">'+getContact[i].TLReputedComments+'</td>';

                    if(getContact[i].TLReputedComments==null)
                        getContact[i].TLReputedComments='';
                    cols += '<td class="Cell"><input class="messageCheckbox" type="checkbox" name="rebute[]" id="rebute'+getContact[i].cmdId+'" value="'+getContact[i].cmdId+'" onclick="updteStatuschk('+getContact.length+','+getContact[i].cmdId+')"></td>';
                    cols += '<td class="Cell"><textarea disabled="disabled" name="tlcmd_'+getContact[i].cmdId+'" id="tlcmd_'+getContact[i].cmdId+'">'+getContact[i].TLReputedComments+'</textarea></td>';
                
                    newRow.append(cols);
                    $("#rebuteTable").append(newRow);  
                    j++;
                }
            }
        });
    }
    
    function updteStatuschk(cnt,chkval) {
        if (($("#rebute"+chkval+":checked").val())!=undefined) {
            $('#cmdStatus').val('3');
            $("#tlcmd_"+chkval).removeAttr("disabled","disabled");
        }
        if (($("#rebute"+chkval+":checked").val())==undefined) {
            $("#tlcmd_"+chkval).val('');
            $('#cmdStatus').val('2');
            $("#tlcmd_"+chkval).attr("disabled","disabled");
        }
         
//        var checkboxChecked = $('input[name="rebute[]"]:checked').length;
//        if(checkboxChecked == cnt) {
//            $('#cmdStatus').val('2');   
//        } else {
//            $('#cmdStatus').val('3');   
//        }
    }
    
    function updateTLCommentsfn() {
        var temp='';
        $.each($("input[name='rebute[]']:checked"), function() {    
               if($("#tlcmd").val()=='') {
                   alert('Enter Commands');
                   $("#tlcmd").focus();
                   temp='yes';
                   return false;
               }
        });

        if(temp=='') {
            var r = confirm("Are you sure want to submit?");
            if (r == true) {
                return true;      
            } else {
                return false;
            } 
        } else {
            return false;   
        }
    }
    
    function ValidateForm()
    {
        var checkboxChecked = $('input[name="rework[]"]:checked').length;
        if(checkboxChecked ==0) {
           alert('Select Any one Job to move to PU');
           return false;
        }else{
            var result = new Array();
            $('input:checkbox[name="rework[]"]:checked').each(function () {
                //alert("Id: " + $(this).attr("id") + " Value: " + $(this).val());
                var InputEntityId = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo Router::url(array('controller' => 'TLRebutalUser', 'action' => 'ajaxmovetopu')); ?>",
                    data: ({InputEntityId: InputEntityId}),
                    dataType: 'text',
                    async: false,
                    success: function (result) {
                         
                    }
                });
            });
            location.reload();
        }
    }

</script>
<style>
    .overlay {
        position: absolute;
        top: -200;
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
    .Heading {
	display: table-row;
	font-weight: bold;
	text-align: left;
	background: rgb(255,255,255); /* Old browsers */
	background: -moz-linear-gradient(top, rgb(255,255,255) 0%, rgb(229,229,229) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgb(255,255,255)), color-stop(100%, rgb(229,229,229))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgb(255,255,255) 0%, rgb(229,229,229) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgb(255,255,255) 0%, rgb(229,229,229) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgb(255,255,255) 0%, rgb(229,229,229) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgb(255,255,255) 0%, rgb(229,229,229) 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e5e5e5', GradientType=0 ); /* IE6-9 */
	color: #5C5C5C;
    }
    .Row {
        display: table-row;
    }
    .Row1 {
        display: table-row;
        background-color: #f7f7f7;
    }
    .Cell {
        display: table-cell;
        border: 1px solid #e4e1e1;
        padding: 5px;
        font-size: 12px;
        color:#000;
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
        });
    </script>
    <?php } if ($CallUserGroupFunctions == 'yes') { ?>
        <script>
            $(window).bind("load", function () {
                var regId = $('#RegionId').val();
                getusergroupdetails(regId);
            });
        </script>
    <?php } ?>