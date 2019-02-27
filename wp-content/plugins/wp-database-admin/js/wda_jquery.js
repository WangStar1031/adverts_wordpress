// JavaScript Document
jQuery(function(){
	if(jQuery('.notice').text()==''){
		jQuery('.notice').addClass('display-none');
	}	
});

jQuery(document).ready(function(e) {
	
	/**
	 *	Declaration
	 */
	var isMultiSelect = true;
	var action = 'select';
	var objDroppable = jQuery('#wda_txtQuery');
	var queryBox = jQuery('#wda_txtQuery');
	var where =  document.getElementById('cbxWhereClause'); //jQuery('#cbxWhereClause');
	
	/**
	 *	Helper Functions 
	 */
	
	//draggable
	function makeLabelDraggable(){
		jQuery('[draggable="true"]').draggable({
			appendTo:'body',
			revert:'invalid',
			helper:'clone',
			stop : function(){
				//alert('stop Draggable');
				//if(action != 'select'){ jQuery(this).remove();}
			}
				
		});
	}
	makeLabelDraggable();
	
	// Table List Check button Set According to Action[SELECT,INSERT,UPDATE,DELETE]
	function setCheckedAllTable(){
		if((! isMultiSelect)  && action != 'select'){
			removeAllColumns();
			jQuery('input[id=controlTable]').each(function(index, element) {
				this.checked=false;
			});
		}
	}
	
	// REMOVE The Column From Column Container
	function removeColumns(tableName){
		jQuery('#table-column-container').children('div').each(function(index, element) {
			if(jQuery(this).attr('data-table')==tableName){
				jQuery(this).remove();
			}
		});
	}
	
	// REMOVE All Column From Colummn Container
	function removeAllColumns(){
		jQuery('#table-column-container').children('div').each(function(index, element) {
			jQuery(this).remove();
		});
	}
	
	// Setup Clause Row
	function setClauseRow(){
		if(where.checked){
			jQuery('#clauseRow').slideDown('fast');	
			
		}else{
			jQuery('#clauseRow').slideUp('fast');	
		}
	}
	
	// Get Selected Table List @return Array [javascript]
	function getTableList(){
		var tableList = [];
		jQuery('[id=controlTable]').each(function(index, element) {
			if(this.checked){
				tableList.push(jQuery(this).attr('data-table'));
			}
		});
		//alert(tableList);
		return tableList;
	}
	
	// Function That Create SQL Query [ init ]
	// [Only when it click on Radio button and Checkbox]
	function initGanarateSqlQuery(){
		//jQuery(where).removeAttr('disabled');
		var sql;
		var Tables = getTableList();
		switch (action){
			case 'select':
					sql = 'SELECT * \nFROM '+Tables;
				break;
			case 'insert':
					//jQuery(where).removeAttr('checked');
					//jQuery(where).attr('disabled','disabled');
					sql = 'INSERT INTO '+Tables+' ()\nVALUES ();';
				break;
			case 'update':
					sql = 'UPDATE '+Tables+' SET';
				break;
			case 'delete':
					sql = 'DELETE FROM '+Tables;
				break;
			default:
					sql = '';
				break;
		}
		setClauseRow();
		return sql;
	}
	
	// SETUP SQL Query in to QueryBox
	// [Only when it click on Radio button and Checkbox]
	function initSetupSql(){
		jQuery(queryBox).val(initGanarateSqlQuery());
	}
	
	// Function That Create SQL Query [ Drag ]
	// [Only when User Drag label in]
	function dragGanarateSqlQuery( dragObj ){
		//jQuery(where).removeAttr('disabled');
		var sql = jQuery(queryBox).val();
		var Tables = getTableList();
		var column = jQuery(dragObj).attr('data-table')+'.'+jQuery(dragObj).attr('data-column');
		var datatype = jQuery(dragObj).attr('data-type');
		var relation;
		 jQuery('[id=rdiRelation]').each(function(index, element) {
				if(this.checked==true){
					relation = ' '+jQuery(this).val()+' ';
				}
		});
		//alert(relation);
		if(action!='select' || where.checked==true){
			
			var int_datatype = ['tinyint','smallint','mediumint','int','bigint','decimal','float','bit'];
			
			var column = jQuery(dragObj).attr('data-column');
			var promptText = 'Enter Value For \nTable : '+Tables+'\nColumn : '+column+'\nData-type : '+datatype;
			var value = prompt(promptText);
			var isInt = datatype.match(/int/);
			var isDecimal = datatype.match(/decimal/);
			var isFloat = datatype.match(/float/);
			var isBool = datatype.match(/bit/);
			if(value==null || value==''){
				return false;
			}else{
				if( isInt==null && isDecimal==null && isFloat==null  && isBool==null){
					// value is string or that kind 
					// so.. we have to set single quotes
					value = '\''+value+'\'';	
					
				}else{
					// value is Interger , bit or that kind
					// so not need to set single quotes	
				}
			}
			
			// validate the value
			/*if(value==null || value==''){
				return false;	
			}else if(isNaN(value)){
				value = '\''+value+'\'';	
			}*/
			
		}
		switch (action){
			case 'select':
					//alert('old : \n'+sql);
					
					if(where.checked==true){
						//alert(sql.indexOf('WHERE'));
						if(sql.indexOf('WHERE')==-1){
							sql+='\nWHERE '+Tables+'.'+column+relation+value;	
						}else{
							
							sql+=' '+ jQuery('#rdiConditionClause').val().toUpperCase()+' '+Tables+'.'+column+relation+value;
						}
						//alert(sql);
					}else{
						var firstLine = sql.substring(0,sql.indexOf('\n'));
						var  newFirstLine = (firstLine=='SELECT * ')?firstLine.replace('*',column):firstLine+','+column;
						//alert(newFirstLine);
						sql = sql.replace(firstLine,newFirstLine);
					}
				break;
			case 'insert':
					// disable cbxWhere
					jQuery(where).removeAttr('checked');
					jQuery(where).attr('disabled','disabled');
					// First Line
					var firstLine = sql.substring(0,sql.indexOf('\n'));
					firstLine = (firstLine=='INSERT INTO '+Tables+' ()')?'INSERT INTO '+Tables+'('+column+')':firstLine.replace(')',','+column+')');
					
					// Second Line
					var secondLine = sql.substring(sql.indexOf('\n'));
					secondLine = (secondLine=='\nVALUES ();')?'\nVALUES ('+value+')':secondLine.replace(')',','+value+')');
					
					//alert(firstLine);
					//alert(secondLine);
					sql = firstLine+secondLine;
				break;
			case 'update':
					//sql = 'UPDATE '+Tables+' SET';
					
					if(where.checked==true){
						if(sql.indexOf('WHERE')==-1){
							sql+='\nWHERE '+column+relation+value;
						}else{
							sql+=' '+jQuery('#rdiConditionClause').val().toUpperCase()+' '+column+relation+value;
						}
					}else{
						
						if(sql.indexOf('WHERE')==-1){
							sql = (sql=='UPDATE '+Tables+' SET')?sql += '\n'+ column +' = '+ value:sql+',\n'+ column +' = '+ value;	
						}else{
							var firstLine = sql.substring(0,sql.lastIndexOf('\n'));
							var lastLine = sql.substring(sql.lastIndexOf('\n'));
							firstLine = firstLine.replace(firstLine,firstLine+',\n'+ column +' = '+ value)
							sql = firstLine+lastLine;
						}
					}
				break;
			case 'delete':
					sql = (sql=='DELETE FROM '+Tables)?sql+'\nWHERE '+column+relation+value:sql+' '+jQuery('#rdiConditionClause').val().toUpperCase()+relation+column +relation+ value;
				break;
			default:
					sql = '';
				break;
		}
		setClauseRow();
		return sql;
	}
	
	// SETUP SQL Query in to QueryBox
	// [Only when it click on Radio button and Checkbox]
	function dragSetupSql( dragObj ){
		var sql = dragGanarateSqlQuery( dragObj );
		if( sql == false){
			return false;	
		}else{
			jQuery(queryBox).val( sql );
		}
	}
	
	
	/**
	 *	Events of Controls
	 */
	
	// Notice Close
	jQuery('#notice-close').click(function(e) {
		jQuery(this).parent('div').slideUp('fast');
	});
	
	//droppable
	jQuery(objDroppable).droppable({
		activeClass: "query-box-default",
		hoverClass: "query-box-hover",
		accept: ".lbl-table-col",
		drop:function( event , ui ){
			var dragObject = jQuery(ui.draggable);
			
			//Send Dragable Object To SQL ganarater [drag]
			var flag = dragSetupSql(jQuery(dragObject));
			
			// Remove Label if Action is Insert update or delete
			if(flag != false ){
				if((action != 'select' && action != 'delete') && where.checked == false){
					jQuery(dragObject).parent('div[class^=col-4]').remove(); jQuery(dragObject).remove();
				}
			}
		}	
	});
	// cbxWhereClause Click Event
	jQuery('#cbxWhereClause').click(function(e) {
		
		setClauseRow();
		//alert(this.checked);
	});
	
	// drop table comfirem
	jQuery('[data-action^=drop]').click(function(e) {
		return confirm('Are you sure you want to DROP TABLE '+jQuery(this).attr('data-table')+' ?');
	});
	
	// drop table comfirem
	jQuery('[data-action^=trunc]').click(function(e) {
		return confirm('Are you sure you want to TRUNCATE TABLE '+jQuery(this).attr('data-table')+' ?');
	});
	
	// Check The Action And Set isMultiSelect
	jQuery('[id=rdiQueryAction]').click(function(e) {
		where.checked = false;
		where.disabled= false;
		//document.getElementById('vd').disabled
		switch (jQuery(this).val()){
			case 'select':
				isMultiSelect = true;
				break;
			case 'insert':
				where.checked = false;
				where.disabled= true;
				isMultiSelect = false;
				break;
			case 'update':
				isMultiSelect = false;
				break;
			case 'delete':
				where.checked = true;
				where.disabled= true;
				isMultiSelect = false;
				break;
			default:
				isMultiSelect = true;
				break;
		}
		action = jQuery(this).val();
		setCheckedAllTable();
		initSetupSql()
		//alert('Multi Select ? '+isMultiSelect );
	});
	
	// Table list check box click Event
	jQuery('[id=controlTable]').click(function(e) {
		
		// check Which Action Will be Occure Action
		setCheckedAllTable();
		
		if(action != 'select'){
			removeAllColumns();
			this.checked = true;
		}
		initSetupSql();
		var columnContainer = jQuery('#table-column-container');
		if(this.checked){
			//alert(jQuery(this).attr('data-table'));
			jQuery.ajax({
				type:'POST',
				url:ajaxurl,
				data:{
					action:'wdaGetTableColums',
					table:jQuery(this).attr('data-table')
				},
				success: function(data, textStatus, XMLHttpRequest){
					jQuery(columnContainer).append(data);
					// Make new Label Draggable
					makeLabelDraggable();
				},
				error:function(MLHttpRequest, textStatus, errorThrown){
					//alert('Error : '+errorThrown);
				}
			});
		}else{
			removeColumns(jQuery(this).attr('data-table'));
		}
	});
	
	
	// Table Action Button click
	jQuery('[class=table-action]').click(function(e) {
		jQuery.ajax({
			type:'POST',
			url:ajaxurl,
			data:{
				action:'wdaSetTableActionResponse',
				table:jQuery(this).attr('data-table'),
				request:jQuery(this).attr('data-action')
			},
			success: function(data, textStatus, XMLHttpRequest){
				jQuery('#popup-contant').html(data);
				jQuery('#popup').slideDown('fast');
				//jQuery('#popup').removeClass('display-none');
			},
			error: function(MLHttpRequest, textStatus, errorThrown){
				//alert('Error : '+errorThrown);	
			}
		});
		//alert(jQuery(this).attr('data-table'));
	});
	// popup close 
	jQuery('#popup-close').click(function(e) {
		jQuery('#popup').slideUp('fast');
	});

});
