<!DOCTYPE html>
<!--
Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
-->
<html>
<head>
	<meta charset="utf-8">
	<title>CKEditor Sample</title>
	<script src="../ckeditor.js"></script>
	<script src="js/sample.js"></script>
	<link rel="stylesheet" href="css/samples.css">
	<!--<link rel="stylesheet" href="toolbarconfigurator/lib/codemirror/neo.css">
	-->
</head>
<body id="main">

<?php 

		//$path = JSONPATH . '\\ProjectConfig_' . $input['ProjectId'] . '.json';
		$path = 'filenews.htm';
		
		
                                        $content = file_get_contents($path);
									//	echo "<pre>"; var_dump($content);exit;
										
?>


<main>
	
	<div class="adjoined-bottom">
		<div class="grid-container">
			<div class="grid-width-100">
				<div id="editor">
				
				<?php echo $content;?>
				
					<h1>Hello world!</h1>
					<p>I'm an instance of new </p>
				</div>
			</div>
		</div>
	</div>

</main>

<script>
	initSample();
</script>

</body>
</html>