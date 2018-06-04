<?php

use Cake\Routing\Router;
if($NoNewJob=='NoNewJob') {
?>
<br><br>
<div align="center" style="color:green;">
    <b>
        <?php echo 'No New Job Available Now! <br> Check Later to have new job!';?>
    </b>
    <br><br>
</div>
<?php   
} else if($this->request->query['job']=='completed' || $this->request->query['job']=='Query') {
?>
<br><br>
<div align="center" style="color:green;">
    <b>
        <?php
        if($this->request->query['job']=='completed')
         echo 'Job completed.<br>';
         else
            echo 'Query Posted Successfully.<br>';
        ?>

        <?php echo 'Click Get Job Button to get new Job';?>
    </b>
    <br><br>
    <div style="margin:0px 0px 5px 0px;">
        <button class="btn btn-default btn-sm" type="button" onclick="getJob()">Get Job</button>
    </div>
</div>
<br><br>   
<?php
}
else if($getNewJOb=='getNewJOb' ) {
    echo $this->Form->create('',array('class'=>'form-horizontal','id'=>'projectforms'));
?>
<br><br>
<div align="center" style="color:green;">
    <b>
        <?php echo 'Click Get Job Button to get new Job';?>
    </b>
    <br><br>
    <div style="margin:0px 0px 5px 0px;">
        <?php echo $this->Form->button('GetJob', array( 'id' => 'NewJob', 'name' => 'NewJob', 'value' => 'NewJob','class'=>'btn btn-default btn-sm')); ?>
    </div>
</div>
<?php echo $this->Form->end(); 
} else {
    echo $this->Form->create('',array('class'=>'form-horizontal','id'=>'projectforms','name'=>'getjob'));
?>
<input type="hidden" name="resultcnt" id="resultcnt">
<input type="hidden" name='loaded' id='loaded' >
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-top:10px;">
    <div class="container-fluid">
        <div class="panel panel-default formcontent">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h3 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="text-decoration:none;">
                        <i class="more-less glyphicon glyphicon-plus"></i>
                        QC Rework
                    </a>
                    <span class="buttongrp">    
                        <button type="button" name='Save' value="Save" class="btn btn-primary btn-xs pull-right" onclick="AjaxSave('');">Save</button>
                        <button type="submit" name='Submit' value="Submit" class="btn btn-primary btn-xs pull-right" onclick="return formSubmit();" >Submit</button>
                    </span>
                </h3>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <span  class="form-horizontal" id="">        
                    <div class="col-md-4">
                        <div class="form-group" >
                            <label for="inputEmail3" class="col-sm-6 control-label" ><b><?php echo $moduleName;?> Rework:</b></label>
                            <div class="col-sm-6 " style="padding-top: 3px;">
                                <?php foreach ($StaticFields as $key => $value) { ?>
                                <a style="color:#555b86 !important;" href="#"><u><?php echo $value['DisplayAttributeName']; ?>: <?php echo $productionjob[$value['AttributeMasterId']];?></u></a>
                                <br><input type="hidden" class="form-control" size="40"  name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" value="<?php echo $productionjob[$value['AttributeMasterId']];?>" >
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"style="margin: 0px;" >
                            <label for="inputEmail3" class="col-sm-4 control-label"><b>Timer:</b></label>
                            <div class="col-sm-8" style="padding-top: 3px;padding-left: 15px;">
                                <a href="#">
                                    <span class="badge" id='countdown'>
                                    <?php
                                       if(empty($productionjob['TimeTaken']))
                                            $hrms[0]='00:00:00';
                                        else
                                            $hrms=explode('.',$TimeTaken);
                                    ?><?php echo $hrms[0];?>
                                    </span>
                                     <?php echo $this->Form->input('', array( 'type'=>'hidden','id' => 'TimeTaken', 'name' => 'TimeTaken','value' => $hrms[0])); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-6 control-label"><b>Status:</b></label>
                            <div class="col-sm-6" style="padding-top: 3px;"> QC Rework Inprogress </div>
                        </div>
                    </div>
                </span>
                <span  class="form-horizontal" id="">        
                    <div class="col-md-4">
                        <div class="form-group" >
                            <label for="inputEmail3" class="col-sm-6 control-label" ><b>Batch Name:</b></label>
                            <div class="col-sm-6 " style="padding-top: 3px;">
						 <?php echo $QcBatchName; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-4">
                        <div class="form-group"style="margin: 0px;" >
                            <label for="inputEmail3" class="col-sm-6 control-label"><b>Researcher Name:</b></label>
                            <div class="col-sm-6" style="padding-top: 3px;">
                                <?php echo $userList[$ProdUserId]; ?>
                            </div>
                        </div>
                    </div>
                </span>	
                <div class="">
                    <div class="form-group">
                        <div class="col-sm-12"></div>
                    </div>
                </div>
                <?php if(!empty($DynamicFields)){?>
                <div id="top-pane" readonly="readonly">
                    <div class="pane-content" style="width:99.7%;" >
                        <div class="form-horizontal">
                            <div class="form-group form-group-sm form-inline" id='appendNew' style="overflow-x: scroll;overflow-y:hidden !important; white-space: nowrap;padding-bottom: 15px;margin-left:10px;">
                                <?php foreach ($DynamicFields as $key => $value) { ?>
                                <span  class="form-horizontal" id="">        
                                    <div class="col-md-4" style="padding-left:40px;">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label" style="padding-top: 12px;"><b><?php echo $value['DisplayAttributeName'];?></b></label>
                                            <div class="col-sm-6 " style="padding-top: 3px;">
                                                <?php if($value['ControlName']=='TextBox' || $value['ControlName']=='Label') { ?>
                                                <input readonly="" class="form-control" type="text"  size="40" title="<?php echo $value['AttributeMasterId'];?>" name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" onblur="<?php echo $value['FunctionName'];?>('CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>')" value="<?php echo $dynamicData[$value['AttributeMasterId']];?>">
                                                <?php } elseif($value['ControlName']=='DropDownList') { ?>
                                                <select class="form-control" disabled="" name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" value="<?php echo $dynamicData[$value['AttributeMasterId']];?>" onblur="<?php echo $value['FunctionName'];?>('<?php echo $value['AttributeMasterId'];?>', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>', '<?php echo $value['Dateformat'];?>', '<?php echo $value['AllowedDecimalPoint'];?>')" onchange="<?php echo $value['Reload'];?>" >
                                                    <option value="0">--select--</option>
                                                        <?php foreach($value['Options'] as $key_opt=>$opt) { ?>
                                                    <option value="<?php echo $key_opt;?>" <?php if($dynamicData[$value['AttributeMasterId']]==$key_opt) { echo 'Selected';} ?>><?php echo $opt;?></option>
                                                        <?php } ?>
                                                </select>
                                                <?php } elseif($value['ControlName']=='MultiTextBox') { ?>
                                                <textarea disabled="" class="form-control" title="<?php echo $value['AttributeValue'];?>"  name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" onblur="<?php echo $value['FunctionName'];?>('CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>')"><?php echo $dynamicData[$value['AttributeValue']];?></textarea>
                                                <?php } elseif($value['ControlName']=='RadioButton') {?>
                                                <input class="form-control" type="radio" <?php if($dynamicData[$value['AttributeValue']]=='Valid') { echo 'checked';}?> id="<?php echo $value['AttributeMasterId']; ?>" name="<?php echo $value['AttributeMasterId']; ?>" value="Valid"> Valid
                                                <input class="form-control" type="radio" <?php if($dynamicData[$value['AttributeValue']]=='InValid') { echo 'checked';}?> id="<?php echo $value['AttributeMasterId']; ?>_2" name="<?php echo $value['AttributeMasterId']; ?>" value="InValid" > InValid
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </span>
                                <?php } ?>
                                <div>
                                    <?php if($DOldDataresult[$value['AttributeMasterId']]['OldDataCount'] > 0) { ?>
                                    <div class='qcGreen_popuptitle' style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>
                                    <?php } else { ?>
                                    <div class='qc_popuptitle' style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- /container -->
<?php //pr($productionjob);?>
<input type="hidden" name='ProductionId' id="ProductionId" value="<?php echo $productionjob['Id'];?>">
<input type="hidden" name='ProductionEntity' id="ProductionEntity" value="<?php echo $productionjob['ProductionEntity'];?>">
<input type="hidden" name='StatusId' value="<?php echo $productionjob['StatusId'];?>">
<input type="hidden" name='RegionId' id='RegionId' value="<?php echo $productionjob['RegionId'];?>">
<input type="hidden" name="ADDNEW" id="ADDNEW" value="">

        <?php
        echo $this->Form->input('', array( 'type'=>'hidden','id' => 'addnewActivityChange', 'name' => 'addnewActivityChange','value'=>$addnewActivityChange));
        echo $this->Form->input('', array( 'type'=>'hidden','id' => 'page', 'name' => 'page','value'=>$page));
        echo $this->Form->input('', array( 'type'=>'hidden','id' => 'prevPage', 'name' => 'prevPage','value'=>$this->request->params[paging][GetJob][prevPage]));
        echo $this->Form->input('', array( 'type'=>'hidden','id' => 'nextPage', 'name' => 'nextPage','value'=>$this->request->params[paging][GetJob][nextPage]));
        ?>
<div id="example" class="container-fluid" style="margin-bottom:-10px;">
    <div id="vertical">
        <div id="top-pane" class="tap-pane">
            <div id="horizontal" style="height: 100%; width: 100%;">
                <div id="left-pane">
                    <div class="pane-content">
                        <!-- Load pdf file starts -->
                        <div style="margin-top:10px;"><iframe onload="onMyFrameLoad(this)" id="frame" sandbox="" src="<?php echo $FirstLink;?>"></iframe></div> 
                        <!-- Load pdf file ends-->
                    </div>
                </div>
                <div id="right-pane">
                    <?php
                        $previous='true';
                        if($page>1)
                            $previous='false';
                         $next='disabled="disabled"';
                        if($page<$SequenceNumber)
                            $next='';
                    ?>                          
                    <div class="col-md-12">
                        <div class="col-md-6 pull-left" style="width:56%;">
                            <?php  echo $this->Form->input('',array('options' => $Html, 'id'=>'status', 'name' => 'status', 'class'=>'form-control pull-left','style'=>'margin-left:-10px;margin-top: 5px;','onchange' =>'LoadPDF(this.value);')); ?>
                        </div>
                        <div class="pull-right" style="cursor:pointer;padding-top:5px;">
                            <button class="btn btn-primary btn-xs " name='gopdf' id='gopdf' onclick="OpenPdf();" type="button">Go</button>
                            <button class="btn btn-primary btn-xs " name='pdfPopUP' id='pdfPopUp' onclick="PdfPopup();" type="button">Undock</button>
                            <button class="btn btn-primary btn-xs" type="button" id="clicktoviewPre" name="clicktoviewPre" value='clicktoviewPre' disabled='<?php echo $previous;?>' onclick="loadNext('previous');">&lt;&lt;</button>
                            <button class="btn btn-primary btn-xs" type="button" id="clicktoviewNxt" name="clicktoviewNxt" value="Next" <?php echo $next; ?> onclick="loadNext('next');" >&gt;&gt;</button>
                            <button class="btn btn-primary btn-xs" type="button"> No of pages <span class="badge" id="SequenceNumber"><?php echo $SequenceNumber;?></span> </button> 
                        </div>
                    </div>
                    <input type="hidden" name="seq" id="seq" value='<?php echo $SequenceNumber;?>' > 
                    <div class="form-inline">
                            <?php foreach ($ProductionFields as $key => $value) {
                                $value['SequenceNumber']=1;
                            ?>
                        <div class="form-group mar" style="margin-left:20px;">
                            <p class="form-control-static col-xs-6 for-wid"><?php echo $value['DisplayAttributeName']; ?></p>
                                <?php if($value['ControlName']=='TextBox'|| $value['ControlName']=='Label') { ?>
                            <input type="text" readonly="" class="form-control" size="40"  name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" value="<?php echo $productionjob[$value['AttributeMasterId']];?>" onblur="<?php echo $value['FunctionName'];?>('<?php echo $value['AttributeMasterId'];?>', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>', '<?php echo $value['Dateformat'];?>', '<?php echo $value['AllowedDecimalPoint'];?>')" maxlength="<?php echo $value['MaxLength'];?>" minlength="<?php echo $value['MinLength'];?>">
                                <?php if($OldDataresultError[$value['AttributeMasterId']]['OldDataCount'] > 0) {?>
                            <div class='qcGreen_popuptitle'  style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>
                                <?php } else if($OldDataresultRebutal[$value['AttributeMasterId']]['OldDataCount'] > 0) {?>
                            <div class='qcRed_popuptitle'  style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>
                                <?php } else { ?>
                            <div class='qc_popuptitle' style="cursor: pointer; margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>
                                <?php } ?>
                                <?php } elseif($value['ControlName']=='DropDownList') { ?>
                            <select disabled="" class="form-control"  name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" value="<?php echo $productionjob[$value['AttributeMasterId']];?>" onblur="<?php echo $value['FunctionName'];?>('<?php echo $value['AttributeMasterId'];?>', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>', '<?php echo $value['Dateformat'];?>', '<?php echo $value['AllowedDecimalPoint'];?>')" onchange="<?php echo $value['Reload'];?>" >
                                <option value="0">--select--</option>
                                            <?php foreach($value['Options'] as $key_opt=>$opt) { ?>
                                <option value="<?php echo $key_opt;?>" <?php if($productionjob[$value['AttributeMasterId']]==$key_opt) { echo 'Selected';} ?>><?php echo $opt;?></option>
                                            <?php } ?>
                            </select>
                                <?php if($OldDataresultError[$value['AttributeMasterId']]['OldDataCount'] > 0) { ?>
                            <div class='qcGreen_popuptitle' style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>
                                <?php } else if($OldDataresultRebutal[$value['AttributeMasterId']]['OldDataCount'] > 0) { ?>
                            <div class='qcRed_popuptitle' style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>
                                <?php } else { ?>
                            <div class='qc_popuptitle' style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>
                                <?php } ?>
                                <?php } elseif($value['ControlName']=='MultiTextBox') { ?>
                            <textarea disabled="" class="form-control" title="<?php echo $value['AttributeValue'];?>"  name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" onblur="<?php echo $value['FunctionName'];?>('<?php echo $value['AttributeMasterId'];?>', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>', '<?php echo $value['Dateformat'];?>', '<?php echo $value['AllowedDecimalPoint'];?>')"><?php echo $productionjob[$value['AttributeMasterId']];?></textarea>
                                <?php if($OldDataresultError[$value['AttributeMasterId']]['OldDataCount'] > 0) { ?>
                            <div class='qcGreen_popuptitle' style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>
                                <?php } else if($OldDataresultRebutal[$value['AttributeMasterId']]['OldDataCount'] > 0) { ?>
                            <div class='qcRed_popuptitle' style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>
                                <?php } else { ?>
                            <div class='qc_popuptitle' style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>
                                <?php } ?>
                                <?php } elseif($value['ControlName']=='RadioButton') {?>
                                <?php } elseif($value['ControlName']=='Auto') { ?>
                            <input type="text" class="form-control" size="40"  name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" value="<?php echo $productionjob[$value['AttributeMasterId']];?>" onblur="<?php echo $value['FunctionName'];?>('<?php echo $value['AttributeMasterId'];?>', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>', '<?php echo $value['Dateformat'];?>', '<?php echo $value['AllowedDecimalPoint'];?>')" maxlength="<?php echo $value['MaxLength'];?>" minlength="<?php echo $value['MinLength'];?>">
                                <?php } ?>
                        </div>
                            <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="light" class="white_content" style="position:fixed;">
        <div class="query_popuptitle"><div style='float:left;width:40%'><b>QC Rework Comments</b></div><div align='right'> <b><a onclick="document.getElementById('light').style.display = 'none';document.getElementById('fade').style.display = 'none';cleartext();"><?php echo $this->Html->image('cancel.png', array('width'=>'20px','height'=>'20px','alt' => 'Close'));?></a></b></div></div>
        <div class="query_innerbdr">
            <div class="query_outerbdr" style='height:315px;overflow:auto;'>
                <div id='QcsuccessMessage' align='center' style='display:none;color:green;'><b>Comments Successfully Posted!</b></div>
                <div id='QcDeletedMessage' align='center' style='display:none;color:green;'><b>Comments Deleted Successfully!</b></div>
                <input type='hidden' name='CommentsId' Id ='CommentsId' value='0'>
                    <?php echo $this->Form->input('', array( 'type'=>'hidden','id' => 'inspectionId', 'name' => 'inspectionId')); ?>
                <label class="col-sm-4 control-label"><b>Attribute</b></label>
                <div class="col-sm-7">
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='Attribute'>-</pre>
                </div>
                <label hidden class="col-sm-4 control-label"><b>AttributeMasterId</b></label>
                <div hidden class="col-sm-7">
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='AttributeMasterId'>-</pre>
                </div>
                <label hidden class="col-sm-4 control-label"><b>ProjectAttributeMasterId</b></label>
                <div hidden class="col-sm-7">
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='ProjectAttributeMasterId'>-</pre>
                </div>
                <div id='puVEF' style='dispaly:block;'>
                    <label class="col-sm-4 control-label"><b>PU Value</b></label>
                    <div class="col-sm-7">
                        <pre class="" style='background-color:white;border:0px;padding:0px;' id='PUvalue'>-</pre>
                    </div>
                </div>
                <label class="col-sm-4 control-label"><b>Error Category&nbsp;<span style='color:red'>&nbsp;*</span></b></label>
                <div class="col-sm-7" style="width: 34.333%;">
                        <?php 
                            echo $this->Form->input('',array('options' => $CategoryName,'default' => '0','name'=>'CategoryName','id'=>'CategoryName','style'=>'margin-top:-16px;','class'=>'form-control','onchange' => 'getCategory(this.value);')); 
                        ?>
                </div>
                <label style="margin-top:16px;" class="col-sm-4 control-label"><b>Error Sub Category&nbsp;<span style='color:red'>&nbsp;*</span></b></label>
                <div class="col-sm-7" style="width: 34.333%;">
                        <?php 
                            $SubCategory = array(0 => '-- Select --');
                            echo '<div id="LoadSubCategory">';
                            echo $this->Form->input('', array('options' => $SubCategory, 'id' => 'SubCategory', 'name' => 'SubCategory','style'=>'margin-top:0px;', 'class' => 'form-control','value' => $SubCategory));
                            echo '</div>';
                        ?>
                    &nbsp;
                </div>
<!--                <label class="col-sm-4 control-label"><b>QC Value&nbsp;<span style='color:red'>&nbsp;*</span></b></label>
                <div class="col-sm-7"  id="QcCtlMultiTextbox">
                <?php 
                echo $this->Form->textarea('', array( 'type'=>'text','id' => 'QCValueMultiTextbox', 'name' => 'QCValueMultiTextbox','style'=>'margin-bottom:8px;')); ?>
                    &nbsp;
                </div>
                <div class="col-sm-7" style="width: 34.333%;" id="QcCtlDropdown">
                <?php 
                 $User=array(0 => '-- Select --');
                echo $this->Form->input('', array( 'options' => $User,'id' => 'QCValueDropdown', 'name' => 'QCValueDropdown','style'=>'margin-top:0px;')); ?>
                    &nbsp;
                </div>
                <div class="col-sm-7" id="QcCtlTextbox">
                        <?php 
                echo $this->Form->input('', array( 'type'=>'text','id' => 'QCValueTextbox', 'name' => 'QCValueTextbox','style'=>'margin-bottom:8px;')); ?>
                    &nbsp;
                </div>
                &nbsp;
                <label style="margin-top:8px;" class="col-sm-4 control-label"><b>Reference</b></label>
                <div class="col-sm-7">
                        <?php 
               
                            echo $this->Form->input('', array( 'type'=>'text','id' => 'Reference', 'name' => 'Reference','style'=>'margin-bottom:8px;margin-top:10px;')); 
                        ?>
                </div>-->

                <label class="col-sm-4 control-label"><b>QC Comments</b></label>
                <div class="col-sm-7" id="QcCmnd">
                        <?php echo $this->Form->textarea('', array( 'type'=>'text','id' => 'QCComments', 'name' => 'QCComments','style'=>'margin-bottom:8px;')); ?>
                </div>

                <div  class="col-sm-10" id='oldData' ></div>

                <div class="col-sm-12" style="text-align:center;margin-top: 7px;">
                        <?php
                            echo $this->Form->button('Mark Error', array( 'id' => 'QuerySubmit', 'name' => 'QuerySubmit', 'value' => 'QuerySubmit','class'=>'btn btn-primary btn-sm','onclick'=>"return valicateQuery('".$value['AttributeMasterId']."','".$value['ProjectAttributeMasterId']."');",'type'=>'button')).' '; 
                            echo $this->Form->button('Close', array( 'type'=>'button','id' => 'Cancel', 'name' => 'Cancel', 'value' => 'Cancel','class'=>'btn btn-primary btn-sm','onclick'=>"document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';cleartext();")).' '; 
                    echo $this->Form->button('Delete', array( 'type'=>'button','id' => 'Delete', 'name' => 'Delete', 'value' => 'Delete','class'=>'btn btn-primary btn-sm','onclick'=>"cleartext();return DeleteQuery();")); ?>   
                </div>
                &nbsp;
                &nbsp; 
            </div>


        </div>
    </div>

    <div id="fade" class="black_overlay"></div>
<?php

 echo $this->Form->end();   
}
?>
    <script>


        var myWindow = null;
        function onMyFrameLoad() {
            $('#loaded').val('loaded');
        }
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
                orientation: "horizontal",
                panes: [
                    {collapsible: true},
                    {collapsible: true},
                    {collapsible: true}
                ],
                expand: onExpandSplitter,
                resize: onResizeSplitter
            });

            function onResizeSplitter(e) {
                var leftpaneSize = $('#left-pane').data('pane').size;
                $.ajax({
                    type: "POST",
                    url: "<?php echo Router::url(array('controller' => 'QCValidationRework', 'action' => 'upddateLeftPaneSizeSession')); ?>",
                    data: ({leftpaneSize: leftpaneSize}),
                    dataType: 'text',
                    async: true,
                    success: function (result) {
                    }
                });
            }

            function onExpandSplitter() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo Router::url(array('controller' => 'QCValidationRework', 'action' => 'upddateUndockSession')); ?>",
                    data: ({undocked: 'no'}),
                    dataType: 'text',
                    async: true,
                    success: function (result) {
                    }
                });
                if (myWindow)
                    myWindow.close();
            }

            //setTimeout(window.stop,8000);
            function displayTimeout() {
                iframe1 = document.getElementById('frame');
                if ($('#loaded').val() === 'loaded') {

                } else {

                    var p = iframe1.parentNode;
                    p.removeChild(iframe1);

                    var div = document.createElement("iframe");

                    div.setAttribute("id", "frame");
                    div.setAttribute("style", 'width:100%; height:800px; overflow:hidden !important;');
                    p.appendChild(div);
                    var html = '<body>Loading takes longer than usual.<br> Please use Go button!</body>';
                    div.src = 'data:text/html;charset=utf-8,' + encodeURI(html);
                    p.appendChild(div);
                    console.log('div.contentWindow =', div.contentWindow);
                }
            }
            setTimeout(displayTimeout, 8000);
        });
    </script>
    <style>
        #vertical {
            height: 750px;
            margin: 0 auto;
        }
        #left-pane,#right-pane  { background-color: rgba(60, 70, 80, 0.05); }
        .pane-content {
            padding: 0 10px;
        }
    </style>
</div>

<script>
    var hms = '<?php echo $hrms[0];?>';   // your input string
    if (hms != '') {
        var a = hms.split(':'); // split it at the colons
        var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
    } else
    {
        var seconds = 0;
    }
    function LoadPDF(file)
    {
        document.getElementById('frame').src = file;
        $("body", myWindow.document).find('#pdfframe').attr('src', file);
    }
    function secondPassed() {
        var hour = Math.round((Math.round((seconds - 30) / 60) - 30) / 60);
        var temp = hour * 60 * 60;
        var minutes = Math.round(((seconds - temp) - 30) / 60);
        var remainingSeconds = seconds % 60;
        if (remainingSeconds < 10) {
            remainingSeconds = "0" + remainingSeconds;
        }
        if (minutes < 10) {
            minutes = "0" + minutes;
        }

        if (hour < 10) {
            hour = "0" + hour;
        }
        document.getElementById('countdown').innerHTML = hour + ":" + minutes + ":" + remainingSeconds;
        document.getElementById('TimeTaken').value = hour + ":" + minutes + ":" + remainingSeconds;
        seconds++;
    }
    var countdownTimer = setInterval('secondPassed()', 1000);

    function formSubmit() {

        var ProjectId = "<?php echo $productionjob['ProjectId'];?>";
        var RegionId = "<?php echo $productionjob['RegionId'];?>";
        var InputEntityId = "<?php echo $productionjob['InputEntityId'];?>";
        var UserId = "<?php echo $productionjob['UserId'];?>";
        var SequenceNumber = $('#page').val();

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QCValidationRework', 'action' => 'rebutalCommentsCount')); ?>",
            data: ({ProjectId: ProjectId, RegionId: RegionId, InputEntityId: InputEntityId, UserId: UserId, SequenceNumber: SequenceNumber}),
            dataType: 'text',
            async: false,
            success: function (result) {
                if (result != '') {
                    $('#resultcnt').val(result);
                } else {
                    $('#resultcnt').val('');
                }
            }
        });
        var resultcnt = $('#resultcnt').val();
        if (resultcnt != '') {
            alert("TL Rebutal Records in page " + resultcnt + ". Please Accept or Reject");
            return false;
        } else {
            return true;
        }

        <?php
            if(isset($Mandatory)) {
            $js_array = json_encode($Mandatory);
            echo "var mandatoryArr = ". $js_array . ";\n";
            }
        ?>
        var mandatary = 0;

        if (mandatary == 0) {
            AjaxSave('');
            return true;

        } else
            return false;
    }
    function getJob()
    {
        window.location.href = "QCValidationRework?job=newjob";
    }
    var windowObjectReference;
    var strWindowFeatures = "menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes";
    function OpenPdf() {
        str = $("#status option:selected").text();
        if (str.search("http://") > -1)
            file = $("#status option:selected").text();
        else if (str.search("https://") > -1)
            file = $("#status option:selected").text();
        else
            file = 'http://' + $("#status option:selected").text() + '/';
        windowObjectReference = window.open(file, "CNN_WindowName", strWindowFeatures);
    }

    function PdfPopup()
    {
        var splitterElement = $("#horizontal"), getPane = function (index) {
            index = Number(index);
            var panes = splitterElement.children(".k-pane");
            if (!isNaN(index) && index < panes.length) {
                return panes[index];
            }
        };

        var splitter = splitterElement.data("kendoSplitter");
        var pane = getPane('0');
        splitter.toggle(pane, $(pane).width() <= 0);

        var file = $("#status option:selected").text();
        myWindow = window.open("", "myWindow", "width=500, height=500");
        myWindow.document.write('<iframe id="pdfframe"  src="' + file + '" style="width:100%; height:96%; overflow:hidden !important; margin-top:15px !important;"></iframe>');

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QCValidationRework', 'action' => 'upddateUndockSession')); ?>",
            data: ({undocked: 'yes'}),
            dataType: 'text',
            async: true,
            success: function (result) {

            }
        });
    }

    function cleartext()
    {
        $("#CategoryName").val(0);
        $("#SubCategory").val(0);
        //  $('#QCValueTextbox').val('');
        //   $('#QCValueMultiTextbox').val('');
        //   $('#QCValueDropdown').val('');
        //   $('#Reference').val('');
        $('#QCComments').val('');
    }

    function LoadValue(id, value, toid) {

        var Region = $('#RegionId').val();
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidationRework','action'=>'ajaxloadresult'));?>",
            data: ({id: id, value: value, toid: toid, Region: Region}),
            dataType: 'text',
            async: false,
            success: function (result) {
                var obj = JSON.parse(result);
                // alert(JSON.stringify(obj));
                var k = 1;
                var x = document.getElementById(toid);
                document.getElementById(toid).options.length = 0;
                var option = document.createElement("option");
                option.text = '--Select--';
                option.value = 0;
                x.add(option, x[0]);
                $.each(obj, function (key, element) {
                    var option = document.createElement("option");
                    option.text = element['Value'];
                    option.value = element['id'];
                    x.add(option, x[k]);
                    k++;
                });
            }
        });
    }
    $(function () {

    <?php
        if(isset($AutoSuggesstion)){
            $AutoSuggesstion_json = json_encode($AutoSuggesstion);
            echo "var autoArr = ". $AutoSuggesstion_json . ";\n";
        }
    ?>
        if (typeof mandatoryArr != 'undefined') {
            $.each(autoArr, function (key, element) {
                //autoArr.forEach(function (element) {
                var result = new Array();
                $.ajax({
                    type: "POST",
                    url: "<?php echo Router::url(array('controller'=>'QCValidationRework','action'=>'ajaxautofill'));?>",
                    data: ({element: element}),
                    dataType: 'text',
                    async: false,
                    success: function (result) {
                        availableTags = JSON.parse(result);
                    }
                });

                $("#" + element).autocomplete({
                    source: availableTags
                });
            });
        }
    });
    function AjaxSave(addnewpagesave) {

        //alert($('#235').val());
        document.getElementById('fade').style.display = 'block';
        <?php
        if(isset($Mandatory)) {
    $js_array = json_encode($Mandatory);
    echo "var mandatoryArr = ". $js_array . ";\n";
        }
    ?>
        var mandatary = 0;

        if (mandatary == 0) {
        } else
            return false;

        var addnew = $('#ADDNEW').val();
        var productionData = new Array();
        var productionData_ely = new Array();
        var productionData_projatt = new Array();
        var dynamicData = new Array();
        var dynamicData_ely = new Array();
        var staticDatavar = new Array();
        var staticData_elyvar = new Array();
        var prodArr =<?php echo json_encode($ProductionFields );?>;
        var dynamicArr =<?php if(isset($DynamicFields)) { echo json_encode($DynamicFields );} else echo "''";?>;
        var staticArr =<?php if(isset($StaticFields)) { echo json_encode($StaticFields );} else echo "''";?>;
        var i = 0;
        var j = 0;
        var k = 0;

        $.each(prodArr, function (key, element) {
            if (element['AttributeMasterId'] != '') {
                var elt = element['AttributeMasterId'];
                var elts = element['ProjectAttributeMasterId'];
                // alert(elt);
                //alert($('#'+elt).val());
                productionData[i] = $('#' + elt).val();
                productionData_ely[j] = elt;
                productionData_projatt[k] = elts;
            }
            i++;
            j++;
            k++;
        });

        var i = 0;
        var j = 0;

        if (typeof dynamicArr != 'undefined') {
            $.each(dynamicArr, function (key, element) {
                //dynamicArr.forEach(function (element) {
                //alert(JSON.stringify(element));
                //alert(element['AttributeMasterId']);
                if (element['AttributeMasterId'] != '') {
                    var elt = element['AttributeMasterId'];
                    //alert(element.length);
                    dynamicData[i] = $('#' + elt).val();
                    dynamicData_ely[j] = elt;
                    //  alert(productionData[elt]);
                }
                i++;
                j++;
            });
        }
        s = 0;
        v = 0;


        if (typeof staticArr != 'undefined') {
            $.each(staticArr, function (key, element) {
                //dynamicArr.forEach(function (element) {
                //alert(JSON.stringify(element));
                //alert(element['AttributeMasterId']);
                if (element['AttributeMasterId'] != '') {
                    //alert('coming');
                    var elt = element['AttributeMasterId'];
                    //alert($('#' + elt).val());
                    staticDatavar[s] = $('#' + elt).val();
                    staticData_elyvar[v] = elt;
                    //  alert(productionData[elt]);
                }
                s++;
                v++;
            });
        }
//alert(staticDatavar);
        var ProductionEntity = $('#ProductionEntity').val();
        var SequenceNumber = $('#page').val();
        var TimeTaken = $('#TimeTaken').val();
        var RegionId = $('#RegionId').val();
        $('#ADDNEW').val('');
        if (addnew == '') {
            var result = new Array();
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller'=>'QCValidationRework','action'=>'ajaxsave'));?>",
                data: ({productionData_ely: productionData_ely, productionData_projatt: productionData_projatt, productionData: productionData, dynamicData: dynamicData, dynamicData_ely: dynamicData_ely, ProductionEntity: ProductionEntity, SequenceNumber: SequenceNumber, TimeTaken: TimeTaken, RegionId: RegionId}),
                dataType: 'text',
                async: false,
                success: function (result) {
                    //alert(result);
                    if (result === 'saved') {
                        // alert(addnewpagesave);
                        if (addnewpagesave == '') {
                            //    alert('Entered Data Successfully saved!');
                            document.getElementById('fade').style.display = '';
                        }
                    } else {
                        window.location = "users";
                    }
                }
            });
        }

        if (addnew == 'ADDNEW') {
            var result = new Array();
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller'=>'QCValidationRework','action'=>'ajaxnewsave'));?>",
                data: ({staticDatavar: staticDatavar, staticData_elyvar: staticData_elyvar, productionData_ely: productionData_ely, productionData_projatt: productionData_projatt, productionData: productionData, dynamicData: dynamicData, dynamicData_ely: dynamicData_ely, ProductionEntity: ProductionEntity, SequenceNumber: SequenceNumber, TimeTaken: TimeTaken, RegionId: RegionId}),
                dataType: 'text',
                async: false,
                success: function (result) {
                    if (result === 'saved') {
                        alert('Additional Page Added Successfully');
                        document.getElementById('SequenceNumber').innerHTML = $('#seq').val();
                        loadNextAddnew('next');
                    } else {
                        window.location = "users";
                    }
                }
            });
        }
    }

    function loadNextAddnew(id) {
        document.getElementById('fade').style.display = 'block';

        var page = $('#page').val();
        var seq = $('#seq').val();
        if (id === 'next') {
            // page = parseInt(page) + 1;
            if (page == seq) {
                $("#clicktoviewNxt").prop("disabled", "disabled");
            }
            if (page == 1) {
                $("#clicktoviewPre").prop("disabled", "disabled");
            }
            if (page > 1) {
                $("#clicktoviewPre").prop("disabled", "");
            }
        }
        // $('#page').val(page);
        var next_status_id = '<?php echo $next_status_id;?>';
        var ProductionEntity = $('#ProductionEntity').val();
        var productionData = new Array();
        var productionData_ely = new Array();
        var dynamicData = new Array();
        var dynamicData_ely = new Array();
        var prodArr =<?php echo json_encode($ProductionFields );?>;
        var dynamicArr =<?php if(isset($DynamicFields)) { echo json_encode($DynamicFields );} else echo "''";?>;
        var i = 0;
        j = 0;
        var InputEntyId = "<?php echo $productionjob['InputEntityId'];?>";
        var AttributeMasterId = 0;
        var ProjectAttributeMasterId = 0;
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidationRework','action'=>'ajaxgetnextpagedata'));?>",
            data: ({page: page, next_status_id: next_status_id, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, ProductionEntity: ProductionEntity, InputEntyId: InputEntyId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                if (result == 'expired') {
                    window.location = "users";
                }
                var resultData = JSON.parse(result);
                $.each(prodArr, function (key, element) {
                    // prodArr.forEach(function (element) {
                    var elt = element['AttributeMasterId'];
                    $('#' + elt).val(resultData['attrval'][elt]);

                    i++;
                    j++;
                });
                document.getElementById('fade').style.display = '';
            }
        });
    }

    function loadNext(id) {
        AjaxSave('addnew');
        $('#ADDNEW').val('');
        document.getElementById('fade').style.display = 'block';
        var page = $('#page').val();
        var seq = $('#seq').val();
        if (id === 'next') {
            page = parseInt(page) + 1;
            if (page == seq) {
                $("#clicktoviewNxt").prop("disabled", "disabled");
            }
            if (page == 1) {
                $("#clicktoviewPre").prop("disabled", "disabled");
            }
            if (page > 1) {
                $("#clicktoviewPre").prop("disabled", "");
            }
        }

        if (id === 'previous') {
            page = parseInt(page) - 1;
            if (page == seq) {
                $("#clicktoviewNxt").prop("disabled", "disabled");
            }
            if (page == 1) {
                $("#clicktoviewPre").prop("disabled", "disabled");
            }
            if (page > 1) {
                $("#clicktoviewPre").prop("disabled", "");
            }
            if (page != seq && seq > 1) {
                $("#clicktoviewNxt").prop("disabled", "");
            }
        }
        $('#page').val(page);
        var next_status_id = '<?php echo $next_status_id;?>';
        var ProductionEntity = $('#ProductionEntity').val();
        var AttributeMasterId = 0;
        var ProjectAttributeMasterId = 0;
        var productionData = new Array();
        var productionData_ely = new Array();
        var dynamicData = new Array();
        var dynamicData_ely = new Array();
        var prodArr =<?php echo json_encode($ProductionFields );?>;
        var dynamicArr =<?php if(isset($DynamicFields)) { echo json_encode($DynamicFields );} else echo "''";?>;
        var readonlyArr =<?php echo json_encode($ReadOnlyFields );?>;
        var i = 0;
        j = 0;
        var InputEntyId = "<?php echo $productionjob['InputEntityId'];?>";
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidationRework','action'=>'ajaxgetnextpagedata'));?>",
            data: ({page: page, next_status_id: next_status_id, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, ProductionEntity: ProductionEntity, InputEntyId: InputEntyId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                if (result === 'expired') {
                    window.location = "users";
                }
                var resultData = JSON.parse(result);
                $.each(prodArr, function (key, element) {
                    //prodArr.forEach(function (element) {
                    var elt = element['AttributeMasterId'];
                    $('#' + elt).val(resultData['attrval'][elt]);
                    $('#Error_' + elt).removeClass("qcGreen_popuptitle");
                    $('#Error_' + elt).removeClass("qcRed_popuptitle");
                    $('#Error_' + elt).addClass("qc_popuptitle");

                    if (resultData['attrcnt'] != '') {
                        for (var k = 0; k < (resultData['attrcnt']).length; k++) {
                            if ((resultData['attrcnt'][k]) == elt) {
                                $('#Error_' + elt).addClass("qcGreen_popuptitle");
                                $('#Error_' + elt).removeClass("qc_popuptitle");
                            } else {
                                $('#Error_' + elt).addClass("qc_popuptitle");
                            }
                        }
                    }
                    if (resultData['attrRebutal'] != '') {
                        for (var k = 0; k < (resultData['attrRebutal']).length; k++) {
                            if ((resultData['attrRebutal'][k]) == elt) {
                                $('#Error_' + elt).addClass("qcRed_popuptitle");
                                $('#Error_' + elt).removeClass("qc_popuptitle");
                            } else {
                                $('#Error_' + elt).addClass("qc_popuptitle");
                            }
                        }
                    }
                    i++;
                    j++;
                });
                document.getElementById('fade').style.display = '';
            }
        });
    }

    function addnewpage() {
        <?php
            if(isset($Mandatory)) {
            $js_array = json_encode($Mandatory);
            echo "var mandatoryArr = ". $js_array . ";\n";
            }
        ?>
        var mandatary = 0;

        if (mandatary == 0) {
        } else
            return false;

        AjaxSave('addnew');
        document.getElementById('fade').style.display = 'block';
        var page = $('#seq').val();
        var newseq = parseInt(page) + 1;
        $('#page').val(newseq);
        $('#seq').val(newseq);

        var productionData = new Array();
        var productionData_ely = new Array();
        var dynamicData = new Array();
        var dynamicData_ely = new Array();
        var prodArr =<?php echo json_encode($ProductionFields );?>;
        var dynamicArr =<?php if(isset($DynamicFields)) { echo json_encode($DynamicFields );} else echo "''";?>;
        var i = 0;
        j = 0;
        $.each(prodArr, function (key, element) {
            if (element['AttributeMasterId'] != '') {
                var elt = element['AttributeMasterId'];
                $('#' + elt).val('');
            }
            i++;
            j++;
        });
        $('#ADDNEW').val('ADDNEW');
        document.getElementById('fade').style.display = '';
    }

    function AjaxNewSave() {
        document.getElementById('fade').style.display = 'block';
        var productionData = new Array();
        var productionData_ely = new Array();
        var dynamicData = new Array();
        var dynamicData_ely = new Array();
        var prodArr =<?php echo json_encode($ProductionFields );?>;
        var dynamicArr =<?php if(isset($DynamicFields)) { echo json_encode($DynamicFields );} else echo "''";?>;
        var i = 0;
        j = 0;
        $.each(prodArr, function (key, element) {
            if (element['AttributeMasterId'] != '') {
                var elt = element['AttributeMasterId'];
                productionData[i] = $('#' + elt).val();
                productionData_ely[j] = elt;
            }
            i++;
            j++;
        });

        var i = 0;
        j = 0;
        if (typeof dynamicArr != 'undefined') {
            $.each(dynamicArr, function (key, element) {
                if (element['AttributeMasterId'] != '') {
                    var elt = element['AttributeMasterId'];
                    //alert(element.length);
                    dynamicData[i] = $('#' + elt).val();
                    dynamicData_ely[j] = elt;
                    //  alert(productionData[elt]);
                }
                i++;
                j++;
            });
        }

        var ProductionEntity = $('#ProductionEntity').val();
        var SequenceNumber = $('#page').val();
        var TimeTaken = $('#TimeTaken').val();
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidationRework','action'=>'ajaxnewsave'));?>",
            data: ({productionData_ely: productionData_ely, productionData: productionData, dynamicData: dynamicData, dynamicData_ely: dynamicData_ely, ProductionEntity: ProductionEntity, SequenceNumber: SequenceNumber, TimeTaken: TimeTaken}),
            dataType: 'text',
            async: false,
            success: function (result) {
                if (result === 'expired') {
                    window.location = "users";
                }
                // availableTags = JSON.parse(result);
                document.getElementById('fade').style.display = '';
            }
        });
    }

    function datacheck(id, value) {
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidationRework','action'=>'ajaxdatacheck'));?>",
            data: ({id: id, value: value}),
            dataType: 'text',
            async: false,
            success: function (result) {
            }
        });
    }
</script>
<style>
    .overlay {
        position: absolute;
        top: 0;
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
        height: 60%;
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
    #vertical {
        height: 750px;
        margin: 0 auto;
    }
    #left-pane,#right-pane  { background-color: rgba(60, 70, 80, 0.05); }
    .pane-content {
        padding: 0 10px;
    }
</style>
    <?php if($session->read("undocked") == 'yes') { ?>
<script>
    $(window).bind("load", function () {
        PdfPopup();
    });
</script>
    <?php } else if($session->read("leftpaneSize") > 0) { ?>
<script>
    $(window).bind("load", function () {
        var leftpaneSize = '<?php echo $session->read("leftpaneSize"); ?>';
        var splitter = $("#horizontal").data("kendoSplitter");
        splitter.size(".k-pane:first", leftpaneSize);
    });
</script>
    <?php } ?>
<script>
    $(window).unload(function () {
        myWindow.close();
    });

    function query(attname, AttributeMasterId, ProjectAttributeMasterId, PUvalue, ButtonType)
    {
        $('#CategoryName').prop('selectedIndex',0);
        $('#SubCategory').prop('selectedIndex',0);
        $('#QCComments').val('');
        document.getElementById('light').style.display = 'block';
        document.getElementById('fade').style.display = 'block';

        var InputEntyId = "<?php echo $productionjob['InputEntityId'];?>";

        if (Attribute == '')
            Attribute = '-';
        if (AttributeMasterId == '')
            AttributeMasterId = '-';
        if (ProjectAttributeMasterId == '')
            ProjectAttributeMasterId = '-';
        if (PUvalue == '')
            PUvalue = '-';
//        if (ButtonType == 'RadioButton') {
//            ButtonType = '1';
//            $('#QcCtl').hide();
//            $('#QcCtlRadio').show();
//            //$('#QcCtlCmnd').hide();
//        }
//        if (ButtonType == 'TextBox') {
//            ButtonType = '2';
//            $('#QcCtlTextbox').show();
//            $('#QcCtlDropdown').hide();
//            $('#QcCtlMultiTextbox').hide();
//            //$('#QcCtlCmnd').hide();
//        }
//        if (ButtonType == 'MultiTextBox') {
//            ButtonType = '3';
//            $('#QcCtlTextbox').hide();
//            $('#QcCtlDropdown').hide();
//            $('#QcCtlMultiTextbox').show();
//            //$('#QcCtlCmnd').show();
//        }
//        if (ButtonType == 'DropDownList') {
//            ButtonType = '1';
//            $('#QcCtlTextbox').hide();
//            $('#QcCtlDropdown').show();
//            $('#QcCtlMultiTextbox').hide();
//            //$('#QcCtlCmnd').hide();
//        }
        var SequenceNumber = $('#page').val();
        if (SequenceNumber == '') {
            SequenceNumber = '1';
        }
        var page = $('#page').val();
        var next_status_id = '<?php echo $next_status_id;?>';
        var ProductionEntity = $('#ProductionEntity').val();
        var InputEntyId = "<?php echo $productionjob['InputEntityId'];?>";

        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidationRework','action'=>'ajaxgetnextpagedata'));?>",
            data: ({page: page, next_status_id: next_status_id, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, ProductionEntity: ProductionEntity, InputEntyId: InputEntyId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                if (result === 'expired') {
                    window.location = "users";
                }
                var resultData = JSON.parse(result);
                if (resultData['tlAccept'] != '') {
                    $('#QuerySubmit').hide();
                    $('#Cancel').hide();
                    $('#Delete').hide();
                } else {
                    $('#QuerySubmit').show();
                    $('#Cancel').show();
                    $('#Delete').show();
                }
                if (resultData['attrId'] != '') {
                    $('#CommentsId').val(resultData['attrId']);
                } else {
                    $('#CommentsId').val(0);
                }
                var elt = AttributeMasterId;
                if (resultData['attrval'][elt] == '') {
                    $('#PUvalue').text('--');
                } else {
                    $('#PUvalue').text(resultData['attrval'][elt]);
                }
            }
        });

        $('#Attribute').text(attname);
        $('#AttributeMasterId').text(AttributeMasterId);
        $('#ProjectAttributeMasterId').text(ProjectAttributeMasterId);
        //  $('#ButtonType').text(ButtonType);

        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidationRework','action'=>'ajaxgetrebutaldata'));?>",
            data: ({page: page, next_status_id: next_status_id, ProductionEntity: ProductionEntity, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, InputEntyId: InputEntyId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('oldData').innerHTML = result;
            }
        });



        showOldData(PUvalue, attname, AttributeMasterId, ProjectAttributeMasterId, InputEntyId, SequenceNumber);
    }
    function showOldData(PUvalue, attname, AttributeMasterId, ProjectAttributeMasterId, InputEntyId, SequenceNumber)
    {
        var ProjectId = "<?php echo $productionjob['ProjectId'];?>";
        var RegionId = "<?php echo $productionjob['RegionId'];?>";

        var result = new Array();

//        if (ButtonType == 1) {
//            $.ajax({
//                type: "POST",
//                url: "<?php echo Router::url(array('controller' => 'QCValidationRework', 'action' => 'ajaxLoadDropdown')); ?>",
//                data: ({ProjectId: ProjectId, RegionId: RegionId, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, InputEntyId: InputEntyId, SequenceNumber: SequenceNumber}),
//                dataType: 'text',
//                async: false,
//                success: function (result) {
//                    document.getElementById('QcCtlDropdown').innerHTML = result;
//                }
//            });
//        }

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QCValidationRework', 'action' => 'ajaxgetolddata')); ?>",
            data: ({InsId: PUvalue, attName: attname, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, InputEntyId: InputEntyId, SequenceNumber: SequenceNumber}),
            dataType: 'text',
            async: false,
            success: function (result) {

                if (result != 'null') {
//                    if (ButtonType == 1) {
//                        var resultData = JSON.parse(result);
//                        var element = document.getElementById('QCValueDropdown');
//                        element.value = resultData['QCValue'];
//                    }
//                    if (ButtonType == 2) {
//                        var resultData = JSON.parse(result);
//                        document.getElementById('QCValueTextbox').value = resultData['QCValue'];
//                    }
//                    if (ButtonType == 3) {
//                        var resultData = JSON.parse(result);
//                        document.getElementById('QCValueMultiTextbox').value = resultData['QCValue'];
//                    }
                    var resultData = JSON.parse(result);
                    document.getElementById('QCComments').value = resultData['QCComments'];
                    // document.getElementById('Reference').value = resultData['Reference'];
                    var element = document.getElementById('CategoryName');
                    element.value = resultData['ErrorCategoryMasterId'];
                    $.ajax({
                        type: "POST",
                        url: "<?php echo Router::url(array('controller' => 'QCValidationRework', 'action' => 'ajaxSubCategory')); ?>",
                        data: ({CategoryId: resultData['ErrorCategoryMasterId']}),
                        dataType: 'text',
                        async: false,
                        success: function (result) {
                            document.getElementById('LoadSubCategory').innerHTML = result;
                        }
                    });
                    var element = document.getElementById('SubCategory');
                    element.value = resultData['SubErrorCategoryMasterId'];

//                    var element = document.getElementById('QCValueDropdown');
//                    element.value = resultData['QCValue'];
//
//                    var element = document.getElementById('QCValueTextbox');
//                    element.value = resultData['QCValue'];
//
//                    var element = document.getElementById('QCValueMultiTextbox');
//                    element.value = resultData['QCValue'];

                }


            }
        });
    }

    function getCategory(CategoryId) {

        var result = new Array();

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QCValidationRework', 'action' => 'ajaxSubCategory')); ?>",
            data: ({CategoryId: CategoryId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadSubCategory').innerHTML = result;
            }
        });
    }

    function DeleteQuery() {
        $('#QuerySubmit').hide();
        $('#Cancel').hide();
        $('#Delete').hide();
        var ProjectId = "<?php echo $productionjob['ProjectId'];?>";
        var RegionId = "<?php echo $productionjob['RegionId'];?>";
        var InputEntityId = "<?php echo $productionjob['InputEntityId'];?>";
        var ProductionEntityID = "<?php echo $productionjob['Id'];?>";
        var StatusId = "<?php echo $productionjob['StatusId'];?>";
        var UserId = "<?php echo $productionjob['UserId'];?>";
        var SequenceNumber = $('#page').val();
        var AttributeStatus = $("#AttributeStatus").val();
        var AttributeMasterId = $("#AttributeMasterId").html();
        var ProjectAttributeMasterId = $("#ProjectAttributeMasterId").html();
        var Attribute = $("#Attribute").html();
        var temp = $("#PUvalue").html();
        var OldValue = temp.replace(/<br>/g, "||");
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidationRework','action'=>'ajaxquerydelete'));?>",
            data: ({ProjectId: ProjectId, RegionId: RegionId, InputEntityId: InputEntityId, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, AttributeStatus: AttributeStatus, StatusId: StatusId, UserId: UserId, SequenceNumber: SequenceNumber}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('QcDeletedMessage').style.display = 'block';
                setTimeout(function () {
                    document.getElementById('QcDeletedMessage').style.display = 'none';
//                    $("#QCValueTextbox").val('');
//                    $("#QCValueMultiTextbox").val('');
//                    $("#QCValueDropdown").val('');
//                    $("#Reference").val('');
                    $("#QCComments").val('');
                    $("#CategoryName").val(0);
                    $("#SubCategory").val(0);
                    showOldData(OldValue, Attribute, AttributeMasterId, ProjectAttributeMasterId, InputEntityId, SequenceNumber)
                }, 2000);
            }
        });
        $('#QuerySubmit').show();
        $('#Cancel').show();
        $('#Delete').show();
    }
    function valicateQuery()
    {
        $('#QuerySubmit').hide();
        $('#Cancel').hide();
        $('#Delete').hide();

        var ProjectId = "<?php echo $productionjob['ProjectId'];?>";
        var RegionId = "<?php echo $productionjob['RegionId'];?>";
        var InputEntityId = "<?php echo $productionjob['InputEntityId'];?>";
        var ProductionEntityID = "<?php echo $productionjob['Id'];?>";
        var StatusId = "<?php echo $productionjob['StatusId'];?>";
        var UserId = "<?php echo $productionjob['UserId'];?>";
        var AttributeMasterId = "<?php echo $fieldValue['AttributeMasterId'];?>";
        var SequenceNumber = $('#page').val();
        var AttributeStatus = $("#AttributeStatus").val();
        var AttributeMasterId = $("#AttributeMasterId").html();
        var ProjectAttributeMasterId = $("#ProjectAttributeMasterId").html();

        var ErrCategory = $.trim($('#CategoryName').val());
        var ErrSubCategory = $.trim($('#SubCategory').val());

        var Reference = $.trim($('#Reference').val());
        // var QCValueTextbox = $.trim($('#QCValueTextbox').val());
        //  var QCValueMultiTextbox = $.trim($('#QCValueMultiTextbox').val());
        var OldValue = $.trim($('#OldValue').val());
        var CommentsId = $('#CommentsId').val();

        var Category = document.getElementById('CategoryName');
        var SubCategory = document.getElementById('SubCategory');

        var CategoryName = Category.options[Category.selectedIndex].text;
        var SubCategoryName = SubCategory.options[SubCategory.selectedIndex].text;

        var CategoryId = Category.options[Category.selectedIndex].value;
        var SubCategoryId = SubCategory.options[SubCategory.selectedIndex].value;

//        var QCValue;
//        if (QCValueTextbox != '') {
//            QCValue = $.trim($('#QCValueTextbox').val());
//        } else if (QCValueMultiTextbox != '') {
//            QCValue = $.trim($('#QCValueMultiTextbox').val());
//        } else {
//            var QCValueDropdown = document.getElementById('QCValueDropdown');
//            QCValue = QCValueDropdown.options[QCValueDropdown.selectedIndex].value;
//        }
        if (ErrCategory == 0)
        {
            $('#QuerySubmit').show();
            $('#Cancel').show();
            $('#Delete').show();
            alert("Select Error Category!");
            $("#CategoryName").focus();
            return false;
        }
        if (ErrSubCategory == 0)
        {
            $('#QuerySubmit').show();
            $('#Cancel').show();
            $('#Delete').show();
            alert("Select Error Sub Category!");
            $("#SubCategory").focus();
            return false;
        }
//        if (QCValue == '')
//        {
//            $('#QuerySubmit').show();
//            $('#Cancel').show();
//            $('#Delete').show();
//            alert("Enter QCValue!");
//            // $("#QCValue").focus();
//            return false;
//        }

        var QCComments = $.trim($("#QCComments").val());
        if (QCComments == '')
        {
            $('#QuerySubmit').show();
            $('#Cancel').show();
            $('#Delete').show();
//            alert("Enter QC Comments");
//            $("#QCComments").focus();
//            return false;
        }


        var Attribute = $("#Attribute").html();
        var temp = $("#PUvalue").html();
        var OldValue = temp.replace(/<br>/g, "||");

        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidationRework','action'=>'ajaxqueryinsert'));?>",
            data: ({ProjectId: ProjectId, RegionId: RegionId, InputEntityId: InputEntityId, CommentsId: CommentsId, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, AttributeStatus: AttributeStatus, StatusId: StatusId, UserId: UserId, Attribute: Attribute, OldValue: OldValue, QCComments: QCComments, SequenceNumber: SequenceNumber, CategoryName: CategoryName, CategoryId: CategoryId, SubCategoryName: SubCategoryName, SubCategoryId: SubCategoryId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('QcsuccessMessage').style.display = 'block';
                setTimeout(function () {
                    document.getElementById('QcsuccessMessage').style.display = 'none';
//                    $("#QCValueTextbox").val('');
//                    $("#QCValueMultiTextbox").val('');
//                    $("#QCValueDropdown").val(0);
                    $("#Reference").val('');
                    $("#QCComments").val('');
                    $("#CategoryName").val(0);
                    $("#SubCategory").val(0);
                    showOldData(OldValue, Attribute, AttributeMasterId, ProjectAttributeMasterId, InputEntityId, SequenceNumber)
                }, 2000);
            }

        });
        $('#QuerySubmit').show();
        $('#Cancel').show();
        $('#Delete').show();
    }
</script>