<?php 
    use Cake\Routing\Router;
    
    $inpuId = urldecode($_GET['inputid']);
    $inpuIdarr = explode("_", $inpuId);
    $attributeid = $inpuIdarr[1];
?>

<br>
<p ALIGN=CENTER><b>Date Calculator</b></p>
<table align='center'>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>Start Date</td>
	<td><input type="text" value="" id="startDate" class="getdate"></td>
</tr>
<tr>
	<td>Years</td>
	<td><input type="text" value="0" id="years" class="getdate "></td>
</tr>
<tr>
	<td>Months</td>
	<td><input type="text" value="0" id="months" class="getdate "></td>
</tr>
<tr>
	<td>Days</td>
	<td><input type="text" value="0" id="days" class="getdate "></td>
</tr>
<tr>
	<td>New Date</td>
	<td><span id="Fetch-date"><input type="text" value="" readonly id="newDate"></span></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td><input type="button" value="Update" id="update" onclick="update_parent();"></td>
	<td><input type="button" value="Close" id="winclose" onclick="window.close();"></td>
</tr>
</table>

	<script type="text/javascript">
		$(document).ready(function () {
			inpuId = '<?php echo urldecode($_GET['inputid']); ?>'; 
			var arr1 = inpuId.split('"');
			inpuId = arr1[1];
			
				
			$('#startDate').Zebra_DatePicker({
				format: 'd-m-Y',
				onSelect: function (dateText, inst) {
					//humanise();
				var inputdate=$('#startDate').val();
				var year=$('#years').val();
				var month=$('#months').val();
				var days=$('#days').val();
					$.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'GetFetchDate')); ?>",
                 data: ({inputdate: inputdate,year: year,month: month,days: days}),
                success: function (res) { 
							$("#Fetch-date").html(res);
					}
                
            });
					
				}
			});
			
			$(".getdate").keyup(function(){
				//humanise();
				var inputdate=$('#startDate').val();
				var year=$('#years').val();
				var month=$('#months').val();
				var days=$('#days').val();
					$.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'GetFetchDate')); ?>",
                 data: ({inputdate: inputdate,year: year,month: month,days: days}),
                success: function (res) { 
							$("#Fetch-date").html(res);
					}
                
                });
			});
			
			$(".onlyno").keydown(function (e) {
				//alert(e.keyCode);
				// Allow: backspace, delete, tab, escape, enter and .
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 173]) !== -1 ||
					 // Allow: Ctrl+A, Command+A
					(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
					 // Allow: home, end, left, right, down, up
					(e.keyCode >= 35 && e.keyCode <= 40)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
			});
			
		});
		
		function update_parent() {
			//alert('child');
			var vals = $("#newDate").val();
                        
                        if(vals == ''){
                            alert("Please Choose the Date");
                            $("#newDate").focus();
                            return false;
                        }
                        
			var attributeid = '<?php echo $attributeid;?>';
                        
                        $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'datecalculatrformat')); ?>",
                 data: ({datevals: vals,attributeid: attributeid}),
                success: function (res) {
               window.opener.setValue(inpuId, res);
                window.close();
                return false;
//            
		}
                
                });
                        
                        
           
		}

		function humanise() {
			var startDate = $("#startDate").val();
			var years = $("#years").val();
			var months = $("#months").val();
			var days = $("#days").val();
			
			if(startDate=="") {
				alert('Please select Start Date first');
				$("#startDate").focus();
				return false;
			}
			
			if(years=="")
				years = 0;
			if(months=="")
				months = 0;
			if(days=="")
				days = 0;
			
			var arr = startDate.split("-");
			startDatenew = arr[2]+'-'+arr[1]+'-'+arr[0];
			var lastDate = new Date(startDatenew);
			
			lastDate.setYear(lastDate.getFullYear() + parseInt(years));
			lastDate.setMonth(lastDate.getMonth() + parseInt(months)+1);
			lastDate.setDate(lastDate.getDate() + parseInt(days));  
			var displayDate = lastDate.getDate()+'-'+lastDate.getMonth()+'-'+lastDate.getFullYear();
			//alert(lastDate);
			$("#newDate").val(displayDate);
			
			var sDate = $("#newDate").val();
		    var sarr = sDate.split("-");
			if(sarr[1]==0){
				sarr[1] = 12;				
				sarr[2] = sarr[2] - 1;
			var Datenew = sarr[0]+'-'+sarr[1]+'-'+sarr[2];
			
			$("#newDate").val(Datenew);
			}
		}
	</script>

        