<!--<link rel="stylesheet" type="text/css" href="css/wda_style.css">
<link rel="stylesheet" type="text/css" href="font-awesome-4.2.0/css/font-awesome.css">-->
<div class="wrap" style="min-height:512px;">
	<section class="wda-container">
<?php 
	// Declaration
	global $wpdb;
	global $wdaDbObj;
	global $URL;
	global $QueryStringStart;
	
?>
		<div class="row">
			<div class="col-12">
				<label for="txtTablePrefix">Table Prefix : </label>
				<input type="text" id="txtTablePrefix" readonly  value="<?php echo $wpdb->prefix; ?>">
				<?php //echo '<pre>POST : '; print_r($_POST); echo '</pre>'; ?>
				<?php //echo '<pre>GET : '; print_r($_GET); echo '</pre>'; ?>
			</div>
		</div>
<?php

	if(isset($_GET['action'])):
	echo '<div class="row"><div class="col-12 notice">';// Notic Start
		// DROP table Process start here
		if(isset($_GET['action']) && $_GET['action']=='drop' && isset($_GET['tbl'])):
			$qryDropTable = "DROP TABLE ".$_GET['tbl'].';';
			$affectedRow=$wdaDbObj->ExecuteNoneQuery($qryDropTable);
			if(gettype($affectedRow)=="string"){
				echo $affectedRow;
			}else{
				echo 'Table '.$_GET['tbl'].' has Droped<br>';
				//echo $affectedRow.' Row Affected<br>';
			}
		endif; // DROP Table Process complated
		
		// TRUNCATE table Process start here
		if(isset($_GET['action']) && $_GET['action']=='trunc' && isset($_GET['tbl'])):
			$qryDropTable = "TRUNCATE TABLE ".$_GET['tbl'].';';
			//echo $qryDropTable."<br>";
			$affectedRow=$wdaDbObj->ExecuteNoneQuery($qryDropTable);
			if(gettype($affectedRow)=="string"){
				echo $affectedRow;
			}else{
				echo 'Table '.$_GET['tbl'].' has Truncated<br>';
				//echo $affectedRow.' Row Affected<br>';
			}
		endif; // TRUNCATE Table Process complated
	echo '<a id="notice-close" href="javascript:" class="wda-close"><span class="fa fa-close"></span></a></div></div>'; // Notic End
	endif;
	
	if(isset( $_REQUEST['wda_query_form_nonce']) &&  wp_verify_nonce($_REQUEST['wda_query_form_nonce'],'wda_query_form')): // check Wp_validation
	echo '<div class="row"><div class="col-12 notice">';// Notic Start
		 
		// Execute When Custome Query is fired
		if(isset($_POST['wda_btnSubmit']) && $_POST['wda_btnSubmit']=='Submit' && $_POST['wda_txtQuery']!=''):
			$flagCustom=true;
			$qryCustom=$_POST['wda_txtQuery'];
			// maintain Query
			$qryCustom=str_replace('\\','',trim($qryCustom));
			// find action
			// 1 for SELECT or Displayable statments 
			// 0 for Manag statment [insert, update ,delete] that doesn't display data
			$displayActionList = array('select','show');
			$action = explode(' ',$qryCustom);
			$action = $action[0];
			$isDisplayTable = in_array(strtolower($action),$displayActionList)?1:0;
			//$isDisplayTable = strtolower((substr($qryCustom,0,4)))=='show'?1:0;
			
			// Execute base on Statment
			//echo "Displat Table : ".$isDisplayTable."<br>";
			if($isDisplayTable===1){
				$rsCustome=$wdaDbObj->ExecuteQuery($qryCustom);
				if( gettype($rsCustome)!='resource'){ echo $rsCustome; }
			}elseif($isDisplayTable===0){
				$affectedRow=$wdaDbObj->ExecuteNoneQuery($qryCustom);
				if(gettype($affectedRow)=="string"){
					echo $affectedRow;
				}else{
					echo $affectedRow.' Row Affected<br>';
				}
			}else{
				echo "Somthing Goes Wrong<br>";	
			}
			//echo $qryCustom."<br>";
		endif;// Custome Query Execution Function Ends Here
	echo '<a id="notice-close" href="javascript:" class="wda-close"><span class="fa fa-close"></span></a></div></div>'; // Notic End
	endif; // end of wp_validaiton
?>
		
		<div class="row">
			<div class="col-8">
				<form name="wda_custome_query" method="post" action="<?php echo $URL;?>">
					<?php	wp_nonce_field('wda_query_form','wda_query_form_nonce',true,true);	?>
					<div class="row">
						<div class="col-12"><h4>Custome Query</h4></div>
					</div>
					<div class="row">
						<div class="col-12">
							<textarea id="wda_txtQuery" name="wda_txtQuery" required class="query-box" dropzone="copy" placeholder="Enter Query" title="Enter Query"><?php echo isset($_POST['wda_txtQuery'])?str_replace('\\','',$_POST['wda_txtQuery']):''; ?></textarea>
						</div>
					</div>
					<div class="row clear" style="padding-top:10px;">
						<div class="col-10">
							<div class="row" style="padding:5px 0;font-weight:900;font-size:.8em;">
								<div class="col-3"><label class="ex-label primary" ></label> : Primary Key</div>
								<div class="col-3"><label class="ex-label no-null" ></label> : Not Null</div>
								<div class="col-3"><label class="ex-label auto-increment" ></label> : Auto Increment</div>
								<div class="col-3"><label ><input id="cbxWhereClause" type="checkbox" class="ex-label" > : Where Clause</label></div>
							</div>
							<div class="row display-none" style="padding:5px 0;font-weight:900;font-size:.8em;" id="clauseRow">
								<!--<div class="col-3 pull-right"><label ><input id="cbxConditionClause" type="checkbox" class="ex-label" value="and" > : OR</label></div>-->
								<div class="col-3 pull-right">
									<label ><input id="rdiConditionClause" name="rdiConditionClause" type="radio" class="ex-label" value="or" checked > : OR&nbsp;</label>
									<label ><input id="rdiConditionClause" name="rdiConditionClause" type="radio" class="ex-label" value="and" > : AND&nbsp;</label>
								</div>
								<div class="col-9 " style="text-transform:uppercase">
									<label title="Equele To">				<input id="rdiRelation" name="rdiRelation" type="radio" class="ex-label" value="=" checked > : &nbsp;= &nbsp;</label>
									<label title="Not Equele To">				<input id="rdiRelation" name="rdiRelation" type="radio" class="ex-label" value="<>" > :  &nbsp;<> &nbsp;</label>
									<label title="Less Then">				<input id="rdiRelation" name="rdiRelation" type="radio" class="ex-label" value="<" > :  &nbsp;< &nbsp;</label>
									<label title="Grater Then">				<input id="rdiRelation" name="rdiRelation" type="radio" class="ex-label" value=">" > :  &nbsp;>&nbsp;</label>
									<label title="Less Then Or Equele To">		<input id="rdiRelation" name="rdiRelation" type="radio" class="ex-label" value="<=" > : &nbsp;<=&nbsp;</label>
									<label title="Grater Then or Equele To">	<input id="rdiRelation" name="rdiRelation" type="radio" class="ex-label" value=">=" > : &nbsp;>=&nbsp;</label>
									<label title="Like">		<input id="rdiRelation" name="rdiRelation" type="radio" class="ex-label" value="LIKE" > : &nbsp;Like&nbsp;</label>
									<label title="Not Like">	<input id="rdiRelation" name="rdiRelation" type="radio" class="ex-label" value="NOT LIKE" > : &nbsp;not like&nbsp;</label>
								</div>
							</div>
							<div id="table-column-container" class="row">
								<!--<div class="col-3" data-table="wp_test"><label id="dragable" class="lbl-table-col" data-table="wp_test" data-column="Name" draggable="true">Dreagale</label></div>-->
								<!-- Label of Table's Columns Will be Placed Here -->
							</div>
						</div>
						<div class="col-2 text-right action-block">
							<input type="submit" id="wda_btnSubmit" name="wda_btnSubmit" class="btn btn-block" value="Submit">
							<label class="btn btn-block"><input type="radio" id="rdiQueryAction" name="rdiQueryAction" value="select" checked>SELECT</label>
							<label class="btn btn-block"><input type="radio" id="rdiQueryAction" name="rdiQueryAction" value="insert">INSERT</label>
							<label class="btn btn-block"><input type="radio" id="rdiQueryAction" name="rdiQueryAction" value="update">UPDATE</label>
							<label class="btn btn-block"><input type="radio" id="rdiQueryAction" name="rdiQueryAction" value="delete">DELETE</label>
						</div>
					</div>
				</form>	
			</div>
			<div class="col-4">
				<div class="row"><div class="col-12"><h4>Tables</h4></div></div>
				<div class="row">
					<table cellspacing="0" bordercolor="#222"  border="1" class="table-list">
						<tr>
							<th >Table name</th>
							<th >Action</th>
						</tr>
						<?php
							$tableList=wda_showTable();
							//$wdaDbObj->DisplayTable($tableList);
							if($tableList){
								while($row=mysql_fetch_array($tableList)){
									echo '<tr>';
										echo '<td><label><input type="checkbox" name="controlTable" id="controlTable" data-table="'.$row[0].'" value="'.$row[0].'">'.$row[0].'</label></td>';
										echo '<td>
												<a class="table-action" href="javascript:" tabindex="-1" data-action="browse" data-table="'.$row[0].'" title="Display Data"><span class="fa fa-file-text"></span></a>
												<a class="table-action" href="javascript:" tabindex="-1" data-action="structure" data-table="'.$row[0].'" title="Display Structure"><span class="fa fa-file-text-o"></span></a>
												
												<a class="" href="'.$URL.$QueryStringStart.'action=trunc&tbl='.$row[0].'" tabindex="-1" data-action="trunc" data-table="'.$row[0].'" title="Truncate Table"><span class="fa fa-trash-o"></span></a>
												<a class="" href="'.$URL.$QueryStringStart.'action=drop&tbl='.$row[0].'" tabindex="-1" data-action="drop" data-table="'.$row[0].'" title="Drop Table"><span class="fa fa-trash"></span></a>
												
											</td>';
									echo '</tr>';	
								}	
							}
							// 'table-action' class is used for Ajax-pop 
							//echo '<a class="table-action" href="'.$URL.$QueryStringStart.'action=alter&tbl='.$row[0].'" tabindex="-1" data-action="alter" data-table="'.$row[0].'" title="Alter Table"><span class="fa fa-edit"></span></a>';
						?>
					</table>
				</div>
			</div>
		</div>
		<!-- Display Table -->
		<?php
			echo '<div id="popup" class="row table-container display-none">
					<div class="col-12" style="text-align:right;min-height:40px;">
						<a id="popup-close" href="javascript:" class="wda-close"><span class="fa fa-close"></span></a>
					</div>
					<div id="popup-contant" class="col-12 " >';
					if(isset( $_REQUEST['wda_query_form_nonce']) &&  wp_verify_nonce($_REQUEST['wda_query_form_nonce'],'wda_query_form')): // check Wp_validation
					//echo '<pre>'; print_r($_POST); echo '</pre>';
						if(isset($_GET['action']) && $_GET['action']=='show' && isset($_GET['tbl'])): // Display Table
							$TableName=$_GET['tbl'];
							$qryGetTableDetail="SELECT * FROM ".$TableName.";";
							$rsGetTableDetail = $wdaDbObj->ExecuteQuery($qryGetTableDetail);
							$wdaDbObj->DisplayTable($rsGetTableDetail);
							echo '<script type="text/javascript">jQuery(document).ready(function(e){jQuery("#popup").slideDown("fast");});</script>';
						elseif(isset($_GET['action']) && $_GET['action']=='struct' && isset($_GET['tbl'])): // work only if GET Method is Come
							$TableName=$_GET['tbl'];
							$wdaDbObj->DisplayTable(wda_showTableStructure($TableName));
							echo '<script type="text/javascript">jQuery(document).ready(function(e){jQuery("#popup").slideDown("fast");});</script>';
						elseif(isset($flagCustom) && $isDisplayTable===1):
							$wdaDbObj->DisplayTable($rsCustome);
							echo '<script type="text/javascript">jQuery(document).ready(function(e){jQuery("#popup").slideDown("fast");});</script>';
						endif;// Display Table Over
					endif; // end of wp_validation
			echo '</div></div>';
		?>
		<br clear="all"/>
	</section>
</div>