<?php
use Cake\Routing\Router
?>

<div class="panel-group" id="accordion-dv" role="tablist" aria-multiselectable="true" style="margin-top:10px;">
    <div class="container-fluid">
        <div class="panel panel-default formcontent">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h3 class="panel-title" style="padding-bottom: 20px !important;">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-dv" href="#collapseTw" aria-expanded="false" aria-controls="collapseTwo" style="text-decoration:none;"> Hygiene Check </a>
                    
                         <form action="<?php echo Router::url('/', true); ?>hygiene-check/" method="post" style="width: 0px !important; margin: 0 0 -15em 80em !important; padding: 0 !important;">
                <div style="text-align:center;">
                    <input type="hidden" name="ProjectId" id="ProjectId">
                    <input type="hidden" name="RegionId" id="RegionId">
                    <input type="hidden" name="ModuleId" id="ModuleId">
                    <input type="hidden" name="UserGroupId" id="UserGroupId">
                 <?php 
                 echo $this->Form->submit('Go Back to List', array('id' => 'check_submit','class'=>'btn btn-primary btn-xs','style' => 'margin-right:100px;margin-top:-40px;margin-left:15px;' ,'name' => 'check_submit', 'value' => 'Submit', 'onclick' => 'goBack();history.back();'));
                ?>
                </div>
                </form>
                        <?php // $go_back = htmlspecialchars($_SERVER['HTTP_REFERER']); ?>
<!--                    <a href=<?php echo $go_back; ?>><button style='float:right;' class='badge badge-pill badge-dark'> Go Back</button></a>-->
                </h3>
            </div>
            <div id="collapseTw" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                <?php echo $this->Form->create('',array('class'=>'form-horizontal','id'=>'projectforms')); ?>
                <?php if(!empty($Production_batchDetails)){ ?>
                    <?php if($SelectTimeMetricComments[0]['QcStatusId'] != '4'){ ?>
                    <button name='Reject' value="Reject" class="btn btn-primary btn-xs pull-right" style="margin-right:160px;margin-top:-38px;">Reject</button>
                    <button name='Accept' value="Accept" class="btn btn-primary btn-xs pull-right" style="margin-right:215px;margin-top:-38px;">Accept</button>
                    <?php } ?>
                <?php } ?>
                <div class="container-fluid">
                    <div class="bs-example">
                        <div id="vertical">
                            <div id="top-pane">
                                <div id="horizontal" style="height: 100%; width: 100%;">
                                    <div id="left-pane" class="pa-lef-10">
                                        <div class="pane-content" >
                                            <input type="hidden" name="UpdateId" id="UpdateId">
                                            <table style='width:100%;' class="table table-striped table-center" id='example'>
                                                <thead>
                                                    <tr class="Heading">
                                                        <?php foreach ($HygieneCheckHeader as $HygieneCheckValues): ?>
                                                        <th class="Cell" width="10%"> <?php echo $contentArr['AttributeOrder'][$RegionId][$HygieneCheckValues]['DisplayAttributeName']; ?> </th> 
<!--                                                        <th class="Cell" width="10%"> <?php echo $HygieneCheckValues; ?> </th> -->
                                                        <?php endforeach; ?>
                                                        <th class="Cell" width="10%"> Comments </th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <?php 
                                                        foreach ($SelectHygineCheckComments as $key => $HygineCheckCmntsValues): 
                                                            $HygineCheckCmntsVal[$HygineCheckCmntsValues['AttributeMasterId']] = $HygineCheckCmntsValues;
                                                        endforeach; 
                                                        
                                                        foreach ($SelectTimeMetricComments as $key => $TimeMetricCmntsValues): 
                                                            $TimeMetricCmntsVal[] = $TimeMetricCmntsValues;
                                                        endforeach; 
                                                        ?>
                                                        
                                                        <?php $i=0; foreach ($HygieneCheckHeader as $key => $HygieneCheckValues): ?>
                                                        <?php if($Production_batchDetails){  ?>
                                                        <td><input type="text" name="Attrval[<?php echo $key ?>]" id="<?php echo $key ?>" value="<?php echo $HygineCheckCmntsVal[$key]['Value'] ?>" title="<?php echo $HygineCheckCmntsVal[$key]['Value']; ?>"></td>
                                                        <?php }?>
                                                        <?php $i++; endforeach; ?>
                                                    </tr>
                                                    <?php $i=0; foreach ($Production_batchDetails as $inputVal => $Productioninput):?>
                                                        <tr>
                                                        <?php foreach ($Productioninput as $key => $input): 
                                                            if($key!='InputEntityId' && $key!='SequenceNumber'){ ?>        
                                                            <td class="Cell" width="8%"> <?php echo $Productioninput[$key]; ?> </td>
                                                        <?php } endforeach; if($Productioninput['SequenceNumber'] == 1){?>
                                                            <td class="Cell" width="8%"><input type="text" id="<?php echo $Productioninput['InputEntityId'] ?>" value="<?php echo $TimeMetricCmntsVal[$i]['HygieneCheckComments']; ?>" title="<?php echo $TimeMetricCmntsVal[$i]['HygieneCheckComments']; ?>" name="comments[<?php echo $Productioninput['InputEntityId'] ?>]" ></td>
                                                        </tr>
                                                        <?php $i++; } endforeach; ?>
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
            </div>
        </div>
    </div>
</div>
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
    
     function goBack(){
        <?php
$js_array = json_encode($SelectQCBatch);

echo "var BatchId = " . $js_array . ";\n";
?>
   var mandatory = BatchId['0']['Id'];
         var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'HygieneCheck', 'action' => 'ajaxlist')); ?>",
            data: ({mandatory: mandatory}),
            dataType: 'text',
            async: false,
            success: function (result) {
                var resultData = JSON.parse(result);
                 $('#ProjectId').val(resultData['ProjectId']);
                 $('#RegionId').val(resultData['RegionId']);
                 $('#ModuleId').val(resultData['ProcessId']);
                 $('#UserGroupId').val(resultData['UserGroupId']);
            }
        });
           }
</script>
