<!--InvalidUrl popup start here -->
<?php // echo $this->Form->create(array('name' => 'updateInvalidUrlPopup', 'id' => 'updateInvalidUrlPopup', 'class' => 'form-group', 'inputDefaults' => array( 'div' => false),'type'=> 'post')); ?>
<div id="InvalidUrl" class="white_content" width='70%' align="center" >
    <div class="rebute_popuptitle"><b style="padding-left:20px;float:left;width:40%;">Invalid Url</b><div align='right'> <b><a onclick="InvalidUrlPopupClose();"><?php echo $this->Html->image('cancel.png', array('width'=>'20px','height'=>'20px','alt' => 'Close'));?></a></b></div></div>
    <div class="query_innerbdr">
    <div class="query_outerbdr">
    <div class="form-group form-group-sm rebute_popuphgt" style="height:200px;">
        <table width='100%' id="rebuteTable" border='1'>
            <tr class='Heading'>
                <td class="Cell">S.No</td>
                <td class="Cell">HTML</td>
                <td class="Cell">Url</td>
                <td class="Cell">Remarks</td>
                <td class="Cell">Reason</td>
            </tr>
            <tr class="Row">
                <td class="Cell"><?php echo $i;?><input type="hidden" name="ProjectId" id="ProjectId" value="<?php echo $Result['UrlMonitoring']['ProjectId'];?>">
                    <input type="hidden" name="InputEntityId" id="InputEntityId" value="<?php echo $Result['UrlMonitoring']['InputEntityId'];?>">
                    <input type="hidden" name="RegionId" id="RegionId" value="<?php echo $Result['UrlMonitoring']['RegionId'];?>">
                    <input type="hidden" name="UsrID" id="UsrID" value="<?php echo $Result['UrlMonitoring']['Id'];?>">
                    <input type="hidden" name="DomainId" id="DomainId" value="<?php echo $DomainId;?>">
                    <input type="hidden" name="InvalidUrlId" id="InvalidUrlId">
                </td>
                <td class="Cell"><label id="InputIdVal" name="InputIdVal"></label></td>
                <td class="Cell"><label id="InvalidUrlVal" name="InvalidUrlVal"></label></td>
                <td class="Cell">
                    <select class="form-control" style="width:150px;" title="Select Valid or Invalid" name="InvalidDropDown" id="InvalidDropDown" onchange='return InvalidUrlChk("17");'>
                        <?php
                        foreach($UrlRemarks as $key=>$value){
                            echo "<option value='$key'>$value</option>";
                        }
                        ?>
<!--                        <option value="Others" >Others</option>-->
                        
                    </select>
                </td>
                <td class="Cell"><textarea disabled='disabled' name='InvalidUrlComments' id='InvalidUrlComments'></textarea></td>
            </tr>
        </table>           
        <label class="col-sm-4 control-label">&nbsp;</label>
            <div class="col-sm-10" align="center">
                <button class="btn btn-default btn-sm" type="submit" value="updateInvalidUrlPopupsubmit" name='updateInvalidUrlPopupsubmit'  id='updateInvalidUrlPopupsubmit' onclick = "return updateInvalidUrl('17');">Submit</button>
                  &nbsp;
            </div>
    </div>
        &nbsp;
    </div>
  </div>
</div>
<div id="fade3" class="black_overlay"></div>
<?php //echo $this->Form->end(); ?>
<!-- comment popup ends here -->

<script>
    
function InvalidUrlPopupClose()
{
document.getElementById('InvalidUrl').style.display='none';
document.getElementById('fade3').style.display='none'
}
    
</script>
    