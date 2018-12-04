<!--Form : Dropdown Mapping
  Developer: Jaishalini R
  Created On: NOV 20 2018 -->
<?php
use Cake\Routing\Router; 
?>

<script type="text/javascript">
  
    function validateForm()
    {
        if ($('#ProjectId').val() == 0)
        {
            $('#lease_deatils').hide();
            alert('Select Project Name');
            $('#ProjectId').focus();
            return false;
        }
        
         var ProjectId=$('#ProjectId').val();
        var result = new Array();
         $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'CheckMojo', 'action' => 'ajaxCheckMojoconfig')); ?>",
                 data: ({ProjectId: ProjectId}),
                success: function (res) {
                    $('#lease_deatils').show();
                $('#lease_deatils').html(res);    
                }
                
            });
    }

    
</script>

<div class="container-fluid">
    <div class="jumbotron formcontent">
        <h4>Check Mojo Configuration</h4>
        <?php echo $this->Form->create($OptionMaster, array('class' => 'form-horizontal', 'id' => 'projectforms','enctype' => 'multipart/form-data')); ?>
        <div class="col-md-4">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Project</label>
                <div class="col-sm-6">
                    <?php echo $ProListopt; ?>
                </div>
            </div>
        </div>

        <div id="submitbtwn" class="form-group" style="text-align:center;">
            <div class="col-sm-12">

                <button type="button" class="btn btn-primary btn-sm" value="Submit" id="submit" name="submit" onclick="return validateForm()">Submit</button>
            </div>
        </div>

        <?php echo $this->Form->end(); ?>
    </div>
    <div id="lease_deatils">
        
        
    </div>
</div>

<?php
echo $this->Form->end();
?>


