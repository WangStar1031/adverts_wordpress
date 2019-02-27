<?php
/*
 * 	show the list of table in Database
 *	return Resource on Success
 * 	return 0 on fail
 */

function wda_showTable(){
	global $wdaDbObj;
	$qry="SHOW TABLES";
	
	$result = $wdaDbObj->ExecuteQuery($qry);
	if($result){
		return $result;	
	}
	return 0;
}

/*
 * 	show the Columns in Table
 *	@param $TableName
 *	return Resource on Success
 * 	return 0 on fail
 */
 
function wda_showTableStructure($TableName){
	global $wdaDbObj;
	$qry="SHOW COLUMNS FROM  ".$TableName.";";
	$result = $wdaDbObj->ExecuteQuery($qry);
	if($result){
		return $result;	
	}
	return 0;
	
}
 
/**
 * 	Parse the SQL Query
 *	@param $query
 *	return array
 *		[1] $query [SQL statment]
 *		[2] $action [1=SELECT , 0=INSERT,UPDATE]
 * 	remove the all extra content that may be harm to execution in Database
 *	NOTE : Currenlty not used yet, BUT Fully Functional [just not implemented or use any where]
 */
function parseSqlStatment($qry){
	$sqlCheck=array('select');
	$sql['query']=str_replace('\\','',trim($qry));
	$sql['action'] =in_array(strtolower(substr($qry,0,6)),$sqlCheck)?1:0;
	
	return $sql;
}

/*
 * 	Truncate Query String From Urls
 *	@param Get Variable
 *	@param Url
 *	return '' on fail
 */
/*function wda_TruncQueryString($queryString,$url){
	return  preg_replace_callback('/([?&])'.$queryString.'=[^&]+(&|$)/', function($matches) {
		return $matches[2] ? $matches[1] : '';
	}, $url);	
}*/


/*function wda_QueryParse($query){
	
}
*/
/*
 * 	Truncate Query String From Urls
 *	return HTML for Columns
 *	return FALSE on fail
 */
function wda_ajax_getTableColums(){
	$table = $_POST['table'];
	$rsTableColumn = wda_showTableStructure($table);
	if($rsTableColumn){
		while($row=mysql_fetch_assoc($rsTableColumn)){
			$content = $row['Field'];
			$content .= $row['Extra']=='auto_increment'?'<label class="ex-label auto-increment pull-right" title="Auto Increment"></label>':'';
			echo '<div class="col-4" data-table="'.$table.'"><label class="lbl-table-col" title="'.$table.'.'.$row['Field'].'" data-table="'.$table.'" data-column="'.$row['Field'].'" data-type="'.$row['Type'].'" data-null="'.$row['Null'].'" data-key="'.$row['Key'].'" data-extra="'.$row['Extra'].'" draggable="true">'
				.$content.
				'</label></div>';
		}
		
	}else{
		return false;	
	}
	
	die();
}
add_action( 'wp_ajax_nopriv_wdaGetTableColums', 'wda_ajax_getTableColums' );
add_action( 'wp_ajax_wdaGetTableColums', 'wda_ajax_getTableColums' );


/**
 *	Ajax Function Handle The display Data 
 *	Like Select statement or Table Detail
 */
function wda_ajax_setTableActionResponse(){
	global $wdaDbObj;
	//echo '<div class="row"><div class="col-12" style="text-align:right;min-height:40px;"><a id="popup-close" href="javascript:" class="wda-close" >&times;</a><div class="clear"></div></div></div>';
	if($_POST['request']=='browse'){
		$qryGetTableDetail="SELECT * FROM ".$_POST['table'].";";
		$rsGetTableDetail = $wdaDbObj->ExecuteQuery($qryGetTableDetail);
		$wdaDbObj->DisplayTable($rsGetTableDetail);
	}elseif($_POST['request']=='structure'){
		$wdaDbObj->DisplayTable(wda_showTableStructure($_POST['table']));
	}
	die();
} 
add_action('wp_ajax_nopriv_wdaSetTableActionResponse','wda_ajax_setTableActionResponse');
add_action('wp_ajax_wdaSetTableActionResponse','wda_ajax_setTableActionResponse');
?>