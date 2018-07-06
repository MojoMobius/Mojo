<!--Requirement : REQ-036
  Form : QC JOB Dump
  Developer: Durai Subbiah M
  Created On: Sep 09 2015 -->
<?php

use Cake\Routing\Router; ?>


<style>
.btn-width {
	width:80%;	
	padding:15px 10px;
	margin:10px auto;
}
</style>

<div class="container-fluid Project_landing_container">
	  <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Project Landing</h1>
          <p>Select your Project to Continue</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Project Selection</a></li>
        </ul>
      </div>
	   <?php echo $this->Form->create($OptionMaster, array('class' => 'form-horizontal', 'id' => 'projectforms'));
		     echo $this->Form->input('', array('type' => 'hidden', 'id' => 'ProjectId', 'name' => 'ProjectId')); 


	   ?>
		<div id="monitor-list">
		
			<div class="Project_list">
				  
				<?php
				foreach($Proname as $key => $value){				
				?>
					<div class="col-lg-4">	
					<button type="submit" class="widget-small blue" value="Submit" id="submit" name="submit" onclick="Formsubmit(<?php echo $Proid[$key];?>);"><i class="icon fa fa-files-o fa-3x"></i> <div class="info"><h4><?php echo $value;?></h4></div></button>


					</div>
				<?php
				}
				?>					
			</div>     
		</div>

</div>
<script>
function Formsubmit(id){
	 $('#ProjectId').val(id);
}
</script>