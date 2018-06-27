<!--Requirement : REQ-036
  Form : QC JOB Dump
  Developer: Durai Subbiah M
  Created On: Sep 09 2015 -->
<?php

use Cake\Routing\Router; ?>



<script>
function ValidateForm() {
    if(($('#ProjectId').val()==0)) {
            alert('Select any one project!');
            $('#ProjectId').focus();
            return false;
    }
}
</script>
<div class="container-fluid Project_landing_container">
<!-- <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Project Landing</h1>
          <p>Select your Project to Continue</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Project Selection</a></li>
        </ul>
      </div> -->
	 <!--  <div class="Project_list">
        <div class="col-lg-4">
			<div class="widget-small blue"><i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
              <h4>Email Parsing Position</h4>
            </div>
          </div>
		</div>
		 <div class="col-lg-4">
			<div class="widget-small blue"><i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
              <h4>Email Parsing Order</h4>
            </div>
          </div>
		</div>
		<div class="col-lg-4">
			<div class="widget-small blue"><i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
              <h4>Email Parsing Order</h4>
            </div>
          </div>
		</div>
		
      </div> -->
    <div class="jumbotron formcontent proj-land">
        <h4>ProjectLanding</h4>
        <?php echo $this->Form->create($OptionMaster, array('class' => 'form-horizontal', 'id' => 'projectforms')); ?>
        <div class="col-xs-12">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Project Name</label>
                <div class="col-sm-9">
                    <?php echo $UserProject; ?>
                </div>
            </div>
        </div>
        <div class="form-group" style="text-align:center;">
            <div class="col-sm-12">
            	
                <button type="submit" class="btn btn-primary btn-sm" value="Submit" id="submit" name="submit" onclick="return ValidateForm()">Submit</button>
            </div>
        </div>
        
        </div>
</div>