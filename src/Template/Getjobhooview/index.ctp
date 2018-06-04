<?php use Cake\Routing\Router;
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
}
else if($this->request->query['job']=='completed' || $this->request->query['job']=='Query')
{
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
        <?php
     echo $this->Form->end();   
}
else
{
    echo $this->Form->create('',array('class'=>'form-horizontal','id'=>'projectforms','name'=>'getjob'));
?>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-top:10px;">
       <div class="container-fluid">

        <div class="panel panel-default formcontent">
			<div class="panel-heading" role="tab" id="headingTwo">
                <h3 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="text-decoration:none;">
						<i class="more-less glyphicon glyphicon-plus"></i>
						Production
					</a> <span class="buttongrp">    
                         <?php $Back = $this->Html->link('Back', ['controller'=>'productionview','action' => 'index']); ?>
                         <span  class="btn btn-primary btn-xs pull-right" style="margin-top:-4px;"><?php echo $Back ?></span>
                        
                       </span>
				</h3>
			</div>
			<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				<div class="">
					 
               <div class="col-md-2">
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-6
                        control-label"><b>HOO process</b></label>
                     <div class="col-sm-6">
                        &nbsp;
                     </div>
                  </div>
               </div>
                 
               <div class="col-md-2">
                  <div class="form-group"> <?php foreach ($StaticFields as $key => $value) { ?>
             
            <a style="color:#555b86 !important;"
               href="#"><u><?php echo $value['DisplayAttributeName']; ?>:<?php echo $productionjob[$value['AttributeMasterId']];?></u></a>
             
              <?php } ?></div>
                  
                </div>
               
               <div class="col-md-2">
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-6
                        control-label">Time Taken</label>
                     <div class="col-sm-6" style="margin-top:5px">
                                 <a href="#">
<!--                                     <span class="badge" id='countdown'>-->
                                         <?php $hrms=explode('.',$TimeTaken);
                                         echo $hrms[0];?>
<!--                                     </span>-->
                                     <?php echo $this->Form->input('', array( 'type'=>'hidden','id' => 'TimeTaken', 'name' => 'TimeTaken','value' => $hrms[0])); ?>
                                 </a><br>
                     </div> 
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-3
                        control-label">Status</label>
                     <div class="col-sm-8">
                        <label for="inputEmail3" class="col-sm-9
                           control-label">HOO Production Completed</label>
                     </div>
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-2
                        control-label">&nbsp;</label>
                  
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-sm-12">
                  </div>
               </div>
           
				</div>
                <?php if(!empty($DynamicFields)){?>
                <div id="top-pane" readonly="readonly">
                    <div class="pane-content" style="width:99.7%;" >
                        <div class="form-horizontal">
                            <div class="form-group form-group-sm form-inline" id='appendNew' style="overflow-x: scroll;overflow-y:hidden !important; white-space: nowrap;padding-bottom: 15px;">
                                <?php foreach ($DynamicFields as $key => $value) { ?>
                                <div class="col-md-2">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-6
                                   control-label"><b><?php echo $value['DisplayAttributeName'];?></b></label>
                                   <input type="hidden" name="CommonAM[<?php echo $value['ProjectAttributeMasterId'];?>]" id="CommonAM[<?php echo $value['ProjectAttributeMasterId'];?>]" value="<?php echo $dynamicData[$value['AttributeMasterId']];?>">

			</div>
                    </div>
                                <div class="col-md-2">
                        <div class="form-group">
                            
                            <div class="col-sm-6">
<!--                                <input id="1390" class="form-control" size="40" name="1390" value="" onblur="('1390', this.value, '', '', '', '')" maxlength="" minlength="" type="text">-->
                                 <?php if($value['ControlName']=='TextBox' || $value['ControlName']=='Label') { ?>
                                <input readonly="readonly" class="form-control" type="text"  size="40" title="<?php echo $value['AttributeMasterId'];?>" name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]" onblur="<?php echo $value['FunctionName'];?>('CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>')" value="<?php echo $dynamicData[$value['AttributeMasterId']];?>">
                                                                <?php } elseif($value['ControlName']=='DropDownList') { ?>
                                <select disabled="disabled"class="form-control" name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]">
                                            <option value="yes" <?php if($value['AttributeValue']=='yes') { echo 'Selected';} ?>>Yes</option>
                                            <option value="no" <?php if($value['AttributeValue']=='no') { echo 'Selected';} ?>>No</option>
                                        </select>
                                                                <?php } elseif($value['ControlName']=='MultiTextBox') { ?>
                                <textarea disabled="disabled" title="<?php echo $value['AttributeValue'];?>"  name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]" onblur="<?php echo $value['FunctionName'];?>('CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>')"><?php echo $dynamicData[$value['AttributeValue']];?></textarea>
                                                                <?php } elseif($value['ControlName']=='RadioButton') {?>
                                <input readonly="readonly "class="form-control" type="radio" <?php if($value['AttributeValue']=='Valid') { echo 'checked';}?> id="CommonPAM_<?php echo $value['ProjectAttributeMasterId'];?>_1" name="<?php echo $value['AttributeMasterId']; ?>" value="Valid"> Valid
                                <input readonly="readonly" class="form-control" type="radio" <?php if($value['AttributeValue']=='InValid') { echo 'checked';}?> id="CommonPAM_<?php echo $value['ProjectAttributeMasterId'];?>_2" name="<?php echo $value['AttributeMasterId']; ?>" value="InValid" > InValid
                                                    <?php } 
                                                    
                                         ?>
                            </div>
                        </div>
                    </div>
                                <?php } ?>

<!--                                <table class="pane-cont-table" width='90%' style="margin-left:10px">
                                    <tr>
                                                        <?php //pr($Dynamic);
                                                        foreach ($DynamicFields as $key => $value) { ?>
                                        <td><?php echo $value['DisplayAttributeName'];?></td>
                                    <input type="hidden" name="CommonAM[<?php echo $value['ProjectAttributeMasterId'];?>]" id="CommonAM[<?php echo $value['ProjectAttributeMasterId'];?>]" value="<?php echo $dynamicData[$value['AttributeMasterId']];?>">
                                                        <?php //} ?>

                                                        
                                    <td align="center">
                                                                <?php if($value['ControlName']=='TextBox' || $value['ControlName']=='Label') { ?>
                                        <input type="text"  size="40" title="<?php echo $value['AttributeMasterId'];?>" name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]" onblur="<?php echo $value['FunctionName'];?>('CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>')" value="<?php echo $dynamicData[$value['AttributeMasterId']];?>">
                                                                <?php } elseif($value['ControlName']=='DropDownList') { ?>
                                        <select class="form-control" name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]">
                                            <option value="yes" <?php if($value['AttributeValue']=='yes') { echo 'Selected';} ?>>Yes</option>
                                            <option value="no" <?php if($value['AttributeValue']=='no') { echo 'Selected';} ?>>No</option>
                                        </select>
                                                                <?php } elseif($value['ControlName']=='MultiTextBox') { ?>
                                        <textarea title="<?php echo $value['AttributeValue'];?>"  name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]" onblur="<?php echo $value['FunctionName'];?>('CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>')"><?php echo $dynamicData[$value['AttributeValue']];?></textarea>
                                                                <?php } elseif($value['ControlName']=='RadioButton') {?>
                                        <input type="radio" <?php if($value['AttributeValue']=='Valid') { echo 'checked';}?> id="CommonPAM_<?php echo $value['ProjectAttributeMasterId'];?>_1" name="<?php echo $value['AttributeMasterId']; ?>" value="Valid"> Valid
                                        <input type="radio" <?php if($value['AttributeValue']=='InValid') { echo 'checked';}?> id="CommonPAM_<?php echo $value['ProjectAttributeMasterId'];?>_2" name="<?php echo $value['AttributeMasterId']; ?>" value="InValid" > InValid


                                                                <?php
                                                               }?>
                                    </td>
                                                        <?php } ?>
                                    </tr>
                                </table>-->
            </div>
                        </div>
                    </div>
                </div>
                            <?php } ?>
            </div>
		</div>    </div></div>





<!--
<div class="container-fluid">
 <div class="jumbotron formcontent">
    <h4>Production</h4>
    
       <div class="col-md-2">
          <div class="form-group">
             <label for="inputEmail3" class="col-sm-6
                control-label"><b>Core process</b></label>
             <div class="col-sm-6">
                &nbsp;
             </div>
          </div>
       </div>
       <div class="col-md-3">
          <div class="form-group">
             <label for="inputEmail3" class="col-sm-6
                control-label">Timer</label>
             <div class="col-sm-6" style="margin-top:5px">
                         <a href="#">
                             <span class="badge" id='countdown'>
                                         <?php
                                            //if(empty($productionjob['TimeTaken']))
                                             //       $hrms[0]='00:00:00';
                                            //    else
                                             //       $hrms=explode('.',$TimeTaken);
                                            ?><?php //echo $hrms[0];?>
                             </span>
                                     <?php //echo $this->Form->input('', array( 'type'=>'hidden','id' => 'TimeTaken', 'name' => 'TimeTaken','value' => $hrms[0])); ?>
                         </a><br>
             </div>
          </div>
       </div>
       <div class="col-md-4">
          <div class="form-group">
             <label for="inputEmail3" class="col-sm-3
                control-label">Status</label>
             <div class="col-sm-8">
                <label for="inputEmail3" class="col-sm-9
                   control-label">Production in Progress</label>
             </div>
          </div>
       </div>
       <div class="col-md-3">
          <div class="form-group">
             <label for="inputEmail3" class="col-sm-2
                control-label">&nbsp;</label>
             <div class="col-sm-10">
                 <a  class="btn btn-primary
                   btn-sm pull-right" href="#popup1">Query</a>
                
             </div>
          </div>
       </div>
       <div class="form-group">
          <div class="col-sm-12">
          </div>
       </div>
    
 </div>
</div>
<div class="container-fluid">
 <div class="well">
     
              <?php //foreach ($StaticFields as $key => $value) { ?>
     
    <a style="color:#555b86 !important;"
       href="#"><u><?php //echo $value['DisplayAttributeName']; ?>:<?php echo $productionjob[$value['AttributeMasterId']];?></u></a>
     
              <?php //} ?>
    <div class="pull-right">
         <?php //pr($productionjob);?>
                <input type="hidden" name='ProductionId' value="<?php echo $productionjob['Id'];?>">
                <input type="hidden" name='ProductionEntity' value="<?php echo $productionjob['ProductionEntity'];?>">
                <input type="hidden" name='StatusId' value="<?php echo $productionjob['StatusId'];?>">
                <input type="hidden" name="ADDNEW" id="ADDNEW" value="<?php echo $ADDNEW;?>">
                <?php
                echo $this->Form->input('', array( 'type'=>'hidden','id' => 'addnewActivityChange', 'name' => 'addnewActivityChange','value'=>$addnewActivityChange));
                echo $this->Form->input('', array( 'type'=>'hidden','id' => 'page', 'name' => 'page','value'=>$page));
                echo $this->Form->input('', array( 'type'=>'hidden','id' => 'prevPage', 'name' => 'prevPage','value'=>$this->request->params[paging][GetJob][prevPage]));
                echo $this->Form->input('', array( 'type'=>'hidden','id' => 'nextPage', 'name' => 'nextPage','value'=>$this->request->params[paging][GetJob][nextPage]));
                ?>
      <!-- /container -->
	  <div id="example" class="container-fluid" style="margin-bottom:10px;">
         <div id="vertical">
            <div id="top-pane">
               <div id="horizontal" style="height: 100%; width: 100%;">
                  <div id="left-pane">
                     <div class="pane-content">
                          
                         
                         
                         
						<div style="margin:10px 0px 5px 0px;">
                            <div class="col-md-8">
                                                            <?php  echo $this->Form->input('',array('options' => $Html, 'id'=>'status', 'name' => 'status', 'class'=>'form-control','onchange' =>'LoadPDF(this.value);')); ?>
								 
							  </div>
							<div class="pull-right" style="margin-bottom:10px">
                                <button class="btn btn-primary btn-xs " name='gopdf' id='gopdf' onclick="OpenPdf();">Go</button>
                                <button class="btn btn-primary btn-xs " name='pdfPopUP' id='pdfPopUp' onclick="PdfPopup();">Unlock</button>
							</div>
						</div>
						  <!-- Load pdf file starts -->
                                                  <div style="margin-top:10px;"><iframe id="frame" src="<?php //echo $FirstLink;?>" style="width:100%; height:430px; overflow:hidden !important;"></iframe>
						 </div> 
						  <!-- Load pdf file ends-->
						</div>
                   </div>
                    
                  <div id="right-pane">
                                                                <?php
                         //echo 'jai'.$page.'-'.$SequenceNumber;
                                   // if($SequenceNumber>1 && $ADDNEW!='Addnew' ) { 
                                        //echo '&nbsp;';
                                       // echo '</br>';
                                        //echo $page.'-'.$SequenceNumber;
                                                    $previous='true';
                                                    if($page>1)
                                                        $previous='false';
                                                     $next='disabled="disabled"';
                                                    if($page<$SequenceNumber)
                                                        $next='';
                                                   // echo $next;
                                               // echo '&nbsp;';
                                                //echo $this->Form->button('Prev', array('type'=>'button','id' => 'clicktoviewPre', 'name' => 'clicktoviewPre', 'value' => 'clicktoviewPre', 'disabled'=>$previous , 'class'=>'btn btn-default btn-sm','onclick'=>"loadNext('previous');"));
                                               // echo '&nbsp;&nbsp;';
                                               // echo $this->Form->button('Next', array('type'=>'button','id' => 'clicktoviewNxt', 'name' => 'clicktoviewNxt', 'value' => 'Next', 'disabled'=>$next,'class'=>'btn btn-default btn-sm','onclick'=>"loadNext('next');" )); 
                                            // echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                           //  echo '<b>      Total No Of Pages : '.$SequenceNumber.'</b>';
                                          // echo $this->Form->button('Delete', array('id' => 'DeleteVessel', 'style'=>'float:right;margin-right:10px;','name' => 'DeleteVessel', 'value' => 'DeleteVessel', 'disabled'=>"false",'class'=>'btn btn-default btn-sm', 'type'=>'submit' )); 
                          ?>
                        <div class="col-md-12">
                            <div class="pull-right" style="cursor:pointer;padding-top:5px;">
                                <button class="btn btn-primary btn-xs" type="button" id="clicktoviewPre" name="clicktoviewPre" value='clicktoviewPre' disabled='<?php echo $previous;?>' onclick="loadNext('previous');">&lt;&lt;</button>
                                <button class="btn btn-primary btn-xs" type="button" id="clicktoviewNxt" name="clicktoviewNxt" value="Next" <?php echo $next; ?> onclick="loadNext('next');" >&gt;&gt;</button>
<!--                                <button class="btn btn-primary btn-xs" type="button" onclick="DeletePage();">X</button>-->
                                <button class="btn btn-primary btn-xs" type=""> No of pages <span class="badge" id="SequenceNumber"><?php echo $SequenceNumber;?></span> </button> 
                            </div>
                        </div>
                            <?php 
                                //    }
                                ?>
                                                    
                                     
                    <input type="hidden" name="seq" id="seq" value='<?php echo $SequenceNumber;?>' > 


                    <div class="form-inline">
                            <?php 
                            foreach ($ReadOnlyFields as $key => $value) {
                                $value['SequenceNumber']=1;
                                ?>
                                    <div class="form-group mar" style="margin-left:10px;">
                                        <p class="form-control-static col-xs-6 for-wid"><?php echo $value['DisplayAttributeName']; ?></p>
                                                    <input type="text" class="form-control" size="40" disabled=""  value="<?php echo $productionjob[$value['AttributeMasterId']];?>"  >
                                                
                                    
                                                </div>
				<?php } ?>
                        
                            <?php 
                           // pr($ProductionFields);
                            foreach ($ProductionFields as $key => $value) {
                                $value['SequenceNumber']=1;
                                ?>

                        <div class="form-group mar" style="margin-left:10px;">
                            <p class="form-control-static col-xs-6 for-wid"><?php echo $value['DisplayAttributeName']; ?></p>
                                                    <?php if($value['ControlName']=='TextBox' || $value['ControlName']=='Label') { ?>
                                                    <input readonly="readonly" type="text" class="form-control" size="40"  name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" value="<?php echo $productionjob[$value['AttributeMasterId']];?>" onblur="<?php echo $value['FunctionName'];?>('<?php echo $value['AttributeMasterId'];?>',this.value,'<?php echo $value['AllowedCharacter'];?>','<?php echo $value['NotAllowedCharacter'];?>','<?php echo $value['Dateformat'];?>','<?php echo $value['AllowedDecimalPoint'];?>')" maxlength="<?php echo $value['MaxLength'];?>" minlength="<?php echo $value['MinLength'];?>">
                                                    <?php } elseif($value['ControlName']=='DropDownList') { ?>
                                                    <select disabled="disabled" name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" value="<?php echo $productionjob[$value['AttributeMasterId']];?>" onblur="<?php echo $value['FunctionName'];?>('<?php echo $value['AttributeMasterId'];?>',this.value,'<?php echo $value['AllowedCharacter'];?>','<?php echo $value['NotAllowedCharacter'];?>','<?php echo $value['Dateformat'];?>','<?php echo $value['AllowedDecimalPoint'];?>')" onchange="<?php echo $value['Reload'];?>" >
                                                        <option value="0">--select--</option>
                                                    <?php foreach($value['Options'] as $key_opt=>$opt) { ?>
                                <option value="<?php echo $key_opt;?>" <?php if($productionjob[$value['AttributeMasterId']]==$key_opt) { echo 'Selected';} ?>><?php echo $opt;?></option>
                                                    <?php } ?>
                                                    </select>
                                                    <?php } elseif($value['ControlName']=='MultiTextBox') { ?>
                                                    <?php } elseif($value['ControlName']=='RadioButton') {?>
                                                    <?php } elseif($value['ControlName']=='Auto') { ?>
                                                    <input readonly="readonly" type="text" class="form-control" size="40"  name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" value="<?php echo $productionjob[$value['AttributeMasterId']];?>" onblur="<?php echo $value['FunctionName'];?>('<?php echo $value['AttributeMasterId'];?>', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>', '<?php echo $value['Dateformat'];?>', '<?php echo $value['AllowedDecimalPoint'];?>')" maxlength="<?php echo $value['MaxLength'];?>" minlength="<?php echo $value['MinLength'];?>">
                                                    <?php } ?>
                        </div>




				<?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
                                                     <?php 
if($QueryDetails['StatusID']==1) {
                                                    ?>
    <div id="popup1" class="overlay">
        <div class="popup">
            <div id='successMessage' align='center' style='display:none;color:green'><b>Query Successfully Posted!</b></div>
            <h2>Query</h2>
            <a class="close" href="#">&times;</a>
            <div class="content">
                <table style="width:100%">
                    <tr><td style="width:50%">Query</td><td><textarea name="query" id="query" rows="5" cols="35"><?php echo $QueryDetails['Query'];?></textarea></td></tr>
                    <tr>
                        <td></td>
                        <td><input type="hidden" name="ProductionEntity" id="ProductionEntity" value="<?php echo $productionjob['ProductionEntity'];?>"> 
                                <?php echo $this->Form->button('Submit', array( 'id' => 'Query', 'name' => 'Query', 'value' => 'Query','class'=>'btn btn-warning','onclick'=>"return valicateQuery();",'type'=>'button')).' '; 
                           //echo $this->Form->button('Cancel', array( 'type'=>'button','id' => 'Cancel', 'name' => 'Cancel', 'value' => 'Cancel','class'=>'btn btn-warning','onclick'=>"queryPopupClose();")); ?>  
                        </td>
                    </tr>
                </table>
						</div>
					</div>
				    </div>
<?php
    } else if($QueryDetails['StatusID']==3) {
?>
    <div id="popup1" class="overlay">
        <div class="popup" style="width:50%;">
            <div id='successMessage' align='center' style='display:none;color:green'><b>Query Successfully Posted!</b></div>
            <h2>TL Comments</h2>
            <a class="close" href="#">&times;</a>
            <div class="content">
                <table style="width:100%">
                    <tr>
                        <td >User Query</td>
                        <td>TL Comments</td></tr>
                    <tr>
                    <tr>
                        <td><textarea name="query" id="query" rows="5" cols="35"><?php echo $QueryDetails['Query']; ?></textarea></td>
                        <td><textarea name="query" id="query" rows="5" cols="35"><?php echo $QueryDetails['TLComments']; ?></textarea></td></tr>
                </table>
			</div>
                  </div>
               </div>
<?php
    } else {
?>
    <div id="popup1" class="overlay">
        <div class="popup">
            <div id='successMessage' align='center' style='display:none;color:green'><b>Query Successfully Posted!</b></div>
            <h2>Query</h2>
            <a class="close" href="#">&times;</a>
            <div class="content">
                <table style="width:100%">
                    <tr><td style="width:50%">Query</td><td><textarea name="query" id="query" rows="5" cols="35"></textarea></td></tr>
                    <tr>
                        <td></td>
                        <td> <input type="hidden" name="ProductionEntity" id="ProductionEntity" value="<?php echo $productionjob['ProductionEntity'];?>"> 
                                <?php echo $this->Form->button('Submit', array( 'id' => 'Query', 'name' => 'Query', 'value' => 'Query','class'=>'btn btn-warning','onclick'=>"return valicateQuery();",'type'=>'button')).' '; 
                           //echo $this->Form->button('Cancel', array( 'type'=>'button','id' => 'Cancel', 'name' => 'Cancel', 'value' => 'Cancel','class'=>'btn btn-warning','onclick'=>"queryPopupClose();")); ?>  
                        </td>
                    </tr>
                </table>
            </div>
         </div>
    </div>
<?php
    }
?>
              


    <!--    <div id="popup1" class="overlay" >
	<div class="popup">
            <div id='successMessage' align='center' style='display:none;color:green'><b>Query Successfully Posted!</b></div>
		<h2>Query</h2>
		<a class="close" href="#">&times;</a>
		<div class="content">
			<table style="width:100%">
			<tr><td style="width:50%">Query</td><td><textarea name="query" id="query" rows="5" cols="35"></textarea></td></tr>
                        <tr>
                            <td></td>
                            <td> <input type="hidden" name="ProductionEntity" id="ProductionEntity" value="<?php echo $productionjob['ProductionEntity'];?>"> 
                                <?php //echo $this->Form->button('Submit', array( 'id' => 'Query', 'name' => 'Query', 'value' => 'Query','class'=>'btn btn-warning','onclick'=>"return valicateQuery();",'type'=>'button')).' '; 
                           //echo $this->Form->button('Cancel', array( 'type'=>'button','id' => 'Cancel', 'name' => 'Cancel', 'value' => 'Cancel','class'=>'btn btn-warning','onclick'=>"queryPopupClose();")); ?>  
                            </td>
                        </tr>
			</table>
		</div>
	</div>
        </div>-->
    <div id="fade" class="black_overlay"></div>
<?php

 echo $this->Form->end();   
}
?>
         <script>
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
}
else
{
    var seconds = 0;
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
    
    <?php

$js_array = json_encode($Mandatory);
echo "var mandatoryArr = ". $js_array . ";\n";
?>
        var mandatary = '';
        mandatoryArr.forEach(function (element) {
            //  alert($('#' + element).val());
            if ($('#' + element).val() == '') {
        alert('Enter Value');
                $('#' + element).focus();
                var mandatary = '1';

        return false;
                exit;

    }
});
        //alert(mandatary);
        if (mandatary == '')
            return true;
        else
            return false;
}
function getJob()
{
   window.location.href = "Getjobhooview?job=newjob"; 
}
var windowObjectReference;
var strWindowFeatures = "menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes";
function OpenPdf() {
        str = $("#status").text();
        if (str.search("http://") > -1)
            file = $("#status").text();
        else if (str.search("https://") > -1)
            file = $("#status").text();
    else
            file = 'http://' + $("#status").text() + '/';
    windowObjectReference = window.open(file, "CNN_WindowName", strWindowFeatures);
}
    var myWindow = null;
function PdfPopup()
{
        var file = '<?php echo FILE_PATH;?>' + $("#status").text();
        myWindow = window.open("", "myWindow", "width=500, height=500");
        myWindow.document.write('<iframe id="pdfframe"  src="' + file + '" style="width:100%; height:100%; overflow:hidden !important;"></iframe>');
   var splitter = splitterElement.data("kendoSplitter");
   splitter[leftPane.width() > 0 ? "collapse" : "expand"](leftPane);
}
function valicateQuery()
{
        if ($("#query").val() == '')
    {
        alert('Enter Query');
        $("#query").focus();
        return false;
    }
        query = $("#query").val();
        InputEntyId = $("#ProductionEntity").val();
   
    var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'Getjobhooview','action'=>'ajaxqueryposing'));?>",
            data: ({query: query, InputEntyId: InputEntyId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('successMessage').style.display = 'block';
                setTimeout(function () {
                    document.getElementById('successMessage').style.display = 'none';
                    $("#query").val(result);
                }, 2000);
            }
        });
}
    function LoadValue(id, value, toid) {
var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'Getjobhooview','action'=>'ajaxloadresult'));?>",
            data: ({id: id, value: value, toid: toid}),
            dataType: 'text',
            async: false,
            success: function (result) {
                var obj = JSON.parse(result);
                  // alert(JSON.stringify(obj));
                var k = 1;
                //toid = 225;
                var x = document.getElementById('test' + toid);
                document.getElementById('test' + toid).options.length = 0;
                    var option = document.createElement("option");
                    option.text = '--Select--';
                    option.value = 0;
                     x.add(option, x[0]);  
                     
                obj.forEach(function (element) {
                    //alert(element['Value'])
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
$AutoSuggesstion_json = json_encode($AutoSuggesstion);
echo "var autoArr = ". $AutoSuggesstion_json . ";\n";
?>
    
        autoArr.forEach(function (element) {
    var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'Getjobhooview','action'=>'ajaxautofill'));?>",
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
    });
    
    
    function loadNextAddnew(id) {
    document.getElementById('fade').style.display='block';
    
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
        var dynamicArr =<?php echo json_encode($DynamicFields );?>;
        var i = 0;
        j = 0;



        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'Getjobhooview','action'=>'ajaxgetnextpagedata'));?>",
            data: ({page: page, next_status_id: next_status_id, ProductionEntity: ProductionEntity}),
            dataType: 'text',
            async: false,
            success: function (result) {
                if(result=='expired') {
                        window.location="users";
                    }
                var resultData = JSON.parse(result);
                prodArr.forEach(function (element) {
                    var elt = element['AttributeMasterId'];
                    $('#' + elt).val(resultData[elt]);

                    i++;
                    j++;
                });
                document.getElementById('fade').style.display='';
            }
        });

    }
    
    function loadNext(id) {
    document.getElementById('fade').style.display='block';
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
//alert(page);
//alert(seq);
            if (page == seq) {
               // alert('enter');
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



        var productionData = new Array();
        var productionData_ely = new Array();
        var dynamicData = new Array();
        var dynamicData_ely = new Array();
        var prodArr =<?php echo json_encode($ProductionFields );?>;
        var dynamicArr =<?php echo json_encode($DynamicFields );?>;
        var i = 0;
        j = 0;



        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'Getjobhooview','action'=>'ajaxgetnextpagedata'));?>",
            data: ({page: page, next_status_id: next_status_id, ProductionEntity: ProductionEntity}),
            dataType: 'text',
            async: false,
            success: function (result) {
                if(result==='expired') {
                        window.location="users";
                    }
                var resultData = JSON.parse(result);
                prodArr.forEach(function (element) {
                    var elt = element['AttributeMasterId'];
                    $('#' + elt).val(resultData[elt]);

                    i++;
                    j++;
                });
                document.getElementById('fade').style.display='';
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
              </style>