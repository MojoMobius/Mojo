<?php
use Cake\Routing\Router
?>

<div class="panel-group" id="accordion-dv" role="tablist" aria-multiselectable="true" style="margin-top:10px;">
    <div class="container-fluid">
        <div class="panel panel-default formcontent">
            <div class="panel-heading" role="tab" id="headingTwo">
            </div><div class="panel-heading" role="tab" id="headingTwo">
            </div>

            <div class="panel-heading" role="tab" id="headingTwo">
                <h3 class="panel-title" style="padding-bottom: 20px !important;">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-dv" href="#collapseTw" aria-expanded="false" aria-controls="collapseTwo" style="text-decoration:none;"> Hygiene Check </a>
                    <form action="<?php echo Router::url('/', true); ?>t-l-rebutal/" method="post" style="width: 0px !important; margin: 0 0 -15em 80em !important; padding: 0 !important;">
                        <div style="text-align:center;">
                            <input type="hidden" name="ProjectId" id="ProjectId">
                            <input type="hidden" name="RegionId" id="RegionId">
                            <input type="hidden" name="ModuleId" id="ModuleId">
                            <input type="hidden" name="UserGroupId" id="UserGroupId">
                        <?php 
                         echo $this->Form->submit('Go Back to List', array('id' => 'check_submit','class'=>'btn btn-primary btn-xs','style' => 'margin-right:100px;margin-top:-34px;margin-left:60px;' ,'name' => 'check_submit', 'value' => 'Submit', 'onclick' => 'goBack();history.back();'));
                        ?>
                        </div>
                    </form>
                </h3>
            </div>
            <div id="collapseTw" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">                
                <?php echo $this->Form->create('',array('class'=>'form-horizontal','id'=>'projectforms')); ?>
                    <?php if(!empty($TLRebutalDetails)){
                        if($SelectTimeMetricComments[0]['QcStatusId'] == '4'){ ?>
                    <button id='Reject'  name='Reject' value="Reject" class="btn btn-primary btn-xs pull-right" style="margin-right:100px;margin-top:-35px;">Reject</button>
                    <button id='Accept' name='Accept' value="Accept" class="btn btn-primary btn-xs pull-right" style="margin-right:150px;margin-top:-35px;" onclick="return CheckAccept();">Accept</button>
                <?php } 
                } ?>
                <div class="container-fluid">
                    <div class="bs-example">
                        <div id="vertical">
                            <div id="top-pane">
                                <div id="horizontal" style="height: 100%; width: 100%;">
                                    <div id="left-pane" class="pa-lef-10">
                                        <div class="pane-content" >
                                            <table style='width:100%;' class="table table-striped table-center" id='example'>
                                                <thead>
                                                    <tr class="Heading">
                                                        <?php 
                                                        foreach ($TLRebutalDetails[0] as $TLRebutalHeadersVal):
                                                            foreach ($TLRebutalHeadersVal as $keys => $Values):
                                                            ?>
                                                            <th class="Cell" width="10%"> <?php echo $contentArr['AttributeOrder'][$RegionId][$Values['ProjectAttributeMasterId']]['DisplayAttributeName']; ?> </th> 
                                                        <?php endforeach;
                                                        endforeach; ?>
                                                        <th class="Cell" width="10%"> Comments </th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        foreach ($SelectHygineCheckComments as $key => $HygineCheckCmntsValues): 
                                                            $HygineCheckCmntsVal[$HygineCheckCmntsValues['AttributeMasterId']] = $HygineCheckCmntsValues;
                                                        endforeach; 
                                                       
                                                        foreach ($SelectTimeMetricComments as $key => $TimeMetricCmntsValues): 
                                                            $TimeMetricCmntsVal[] = $TimeMetricCmntsValues;
                                                        endforeach; 
                                                    ?>
                                                    <?php 
                                                    foreach ($TLRebutalDetails[0] as $TLRebutalHeadersVal):
                                                        $i=0;
                                                        foreach ($TLRebutalHeadersVal as $keys => $Values):
                                                            if($TLRebutalDetails){ ?>
                                                                <td><input disabled type="text" name="Attrval[<?php echo $keys ?>]" id="<?php echo $keys ?>" title="<?php echo $HygineCheckCmntsVal[$keys]['Value'] ?>" value="<?php echo $HygineCheckCmntsVal[$keys]['Value'] ?>"></td>
                                                            <?php } $i++;
                                                        endforeach;
                                                    endforeach;
                                                        ?>
                                                    <?php  
                                                        array_pop($TLRebutalDetails);
                                                        array_pop($TLRebutalDetails);
                                                        $i=1; $j=0; 
                                                        foreach ($TLRebutalDetails as $key => $TLRebutalValues):
                                                            $InputEntityId = $TLRebutalValues['InputEntityId'];
                                                            echo "<tr>";
                                                            foreach ($TLRebutalValues['Data'] as $keys => $Values):
                                                                $disabled='';
                                                                foreach ($TLRebutalAttrMasId as $keys => $AttrMasVal):
                                                                    if($Values['AttributeMasterId']==$AttrMasVal){
                                                                        $disabled="disabled=disabled";
                                                                    }
                                                                endforeach;
                                                            ?>
                                                            <td><input type="text" <?php echo $disabled; ?> name="Attrval[<?php echo $InputEntityId."_".$Values['AttributeMasterId']."_".$Values['SequenceNumber'] ?>]" id="<?php echo $Values['ProjectAttributeMasterId'] ?>" value="<?php echo $Values['AttributeValue'] ?>"></td>
                                                            <?php endforeach;
                                                            if($Values['SequenceNumber'] == 1){?>
                                                               <td class="Cell" width="8%"><input disabled type="text" id="<?php echo $InputEntityId ?>" title="<?php echo $TimeMetricCmntsVal[$j]['HygieneCheckComments']; ?>" value="<?php echo $TimeMetricCmntsVal[$j]['HygieneCheckComments']; ?>" name="comments[<?php echo $InputEntityId ?>]" ></td> 
                                                            <?php $j++; } 
                                                            $i++; 
                                                            echo "</tr>";
                                                        endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="text-align:center;">
                            <div class="col-sm-12">
                                <input type="hidden" name="UpdateId" id="UpdateId">
                                <input type="hidden" name="ProjectId" id="ProjectId" value='<?php echo $ProjectId;?>'>
                                <input type="hidden" name="RegionId" id="RegionId" value='<?php echo $RegionId;?>'>
                                <input type="hidden" name="ProcessId" id="ProcessId" value='<?php echo $ProcessId;?>'>
                                <input type="hidden" name="BatchId" id="BatchId" value='<?php echo $BatchId;?>'>

                                <?php
                                    echo $this->Form->button('Save', array('id' => 'check_save', 'name' => 'check_save', 'value' => 'Save', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return CheckSave('.$BatchId.')'));
//                                    echo $this->Form->button('Back', array( 'id' => 'check_submit', 'name' => 'check_submit', 'value' => 'Submit', 'style' => 'margin-left:5px;', 'class'=>'btn btn-primary btn-sm' , 'onclick' => 'goBack();history.back();'));
//                                    echo $this->Form->button('Back', array( 'id' => 'check_back', 'name' => 'check_back', 'value' => 'Back', 'style' => 'margin-left:5px;', 'class'=>'btn btn-primary btn-sm'));
                                ?>
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
        
        var QcBatch = "<?php echo $SelectHideBatch[0]['Id'];?>";
        var BatchId = "<?php echo $BatchId; ?>";

        if(QcBatch == BatchId){
            //$("#Reject").hide();
            document.getElementById("Reject").disabled = true;
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
    
    function CheckAccept(){
        //$( "#check_save" ).trigger( "click" );
        var getConform = confirm("If you are modified Production data, Please save before Accept. Do you want still Accept?");
        if (getConform) {
        //$("#Reject").hide();
        document.getElementById("Reject").disabled = true;
        return true;
        } else {
            return false;
        }
    }
    
    function CheckSave(result){
        
        var buttonAct = $("#Reject").is(":disabled");
        if(buttonAct){
            return true;
        }else{
            var getConform = confirm("Are You Sure want to Save.? Ok Reject button is disabled");
            if (getConform) {
            //$("#Reject").hide();
            document.getElementById("Reject").disabled = true;
            return true;
            } else {
                return false;
            }
        }
    }
    
    function goBack(){
        

//        <?php
//        $js_array = json_encode($SelectQCBatch);
//
//        echo "var BatchId = " . $js_array . ";\n";
//        ?>
//        var mandatory = BatchId['0']['Id'];
        var mandatory = <?php echo $BatchId;?>;
        
            var result = new Array();
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'TLRebutal', 'action' => 'ajaxlist')); ?>",
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
