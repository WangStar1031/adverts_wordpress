<?php
	/* @var $Package DUP_Package */

    $packages = DUP_Package::get_all();
	$totalElements	= count($packages);
	$statusCount	= 0; // total packages completed
    $active_package_present = DUP_Package::is_active_package_present();

    $package_debug	= DUP_Settings::Get('package_debug');
    $ajax_nonce		= wp_create_nonce('package_list');
	$ui_create_frmt = is_numeric(DUP_Settings::Get('package_ui_created')) ? DUP_Settings::Get('package_ui_created') : 1;
	$package_running = false;
?>

<style>
	div#dup-list-alert-nodata {padding:70px 20px;text-align:center; font-size:20px; line-height:26px}
	div.dup-notice-msg {border:1px solid silver; padding: 10px; border-radius: 5px; width: 550px; 
		margin:40px auto 0px auto; font-size:12px; text-align: left; word-break:normal;
		background: #fefcea; 
		background: -moz-linear-gradient(top,  #fefcea 0%, #efe5a2 100%);
		background: -ms-linear-gradient(top,  #fefcea 0%,#efe5a2 100%);
		background: linear-gradient(to bottom,  #fefcea 0%,#efe5a2 100%);
	}
	input#dup-bulk-action-all {margin:0px;padding:0px 0px 0px 5px;}
	button.dup-button-selected {border:1px solid #000 !important; background-color:#dfdfdf !important;}
	div.dup-quick-start {font-style:italic; font-size: 13px; line-height: 18px; margin-top: 15px}

    .add-new-h2.disabled { 
        cursor: not-allowed;
        border-color: #ccc !important;
        background: #f7f7f7 !important;
        color: #ccc !important;
    }
	
	/* Table package details */
	table.dup-pack-table {word-break:break-all;}
	table.dup-pack-table th {white-space:nowrap !important;}
	table.dup-pack-table td.pack-name {text-overflow:ellipsis; white-space:nowrap}
    table.dup-pack-table td.pack-size {min-width: 65px; }

	table.dup-pack-table input[name="delete_confirm"] {margin-left:15px}
	table.dup-pack-table td.fail {border-left: 4px solid #d54e21;}
	table.dup-pack-table td.pass {border-left: 4px solid #2ea2cc;}

    .dup-pack-info {height: 45px;}
    .dup-pack-info td {vertical-align: middle; }
	tr.dup-pack-info td {white-space:nowrap; padding:2px 30px 2px 7px;}
	tr.dup-pack-info td.get-btns {text-align:right; padding:3px 5px 6px 0px !important;}
	tr.dup-pack-info td.get-btns button {box-shadow:none}
	textarea.dup-pack-debug {width:98%; height:300px; font-size:11px; display:none}
	td.error-msg a {color:maroon}
	td.error-msg a i {color:maroon}
	td.error-msg span {display:inline-block; padding:7px 18px 0px 0px; color:maroon}
	div#dup-help-dlg i {display: inline-block; width: 15px; padding:2px;line-height:28px; font-size:14px;}
	tr.dup-pack-info sup  {font-style:italic;font-size:10px; cursor: pointer; vertical-align: baseline; position: relative; top: -0.8em;}
	tr#pack-processing {display: none}
    
    /* Building package */
 
    .dup-pack-info .building-info {display: none;}
    .dup-pack-info.is-running .building-info {display: inline;}
    .dup-pack-info.is-running .get-btns button {display: none;}

</style>

<form id="form-duplicator" method="post">

<!-- ====================
TOOL-BAR -->
<table id="dup-toolbar">
	<tr valign="top">
		<td style="white-space: nowrap">
			<select id="dup-pack-bulk-actions">
				<option value="-1" selected="selected"><?php esc_html_e("Bulk Actions", 'duplicator') ?></option>
				<option value="delete" title="<?php esc_attr_e("Delete selected package(s)", 'duplicator') ?>"><?php esc_html_e("Delete", 'duplicator') ?></option>
			</select>
			<input type="button" id="dup-pack-bulk-apply" class="button action" value="<?php esc_html_e("Apply", 'duplicator') ?>" onclick="Duplicator.Pack.ConfirmDelete()">
			<span class="btn-separator"></span>
			<a href="javascript:void(0)" class="button"  title="<?php esc_attr_e("Get Help", 'duplicator') ?>" onclick="Duplicator.Pack.showHelp()">
				<i class="fa fa-question-circle grey-icon"></i>
			</a>
			<a href="admin.php?page=duplicator-settings&tab=package" class="button grey-icon" title="<?php esc_attr_e("Settings", 'duplicator') ?>"><i class="fa fa-gear"></i></a>
		</td>
		<td>						
			<span><i class="fa fa-archive"></i> <?php esc_html_e("Packages", 'duplicator'); ?></span>
			<?php
			$package_url = admin_url('admin.php?page=duplicator&tab=new1');
			$package_nonce_url = wp_nonce_url($package_url, 'new1-package');
			?>
			<a id="dup-create-new" 
               onClick="return Duplicator.Pack.CreateNew(this);"
               href="<?php echo $package_nonce_url;?>"
               class="add-new-h2 <?php echo ($active_package_present ? 'disabled' : ''); ?>"
               >
                <?php esc_html_e("Create New", 'duplicator'); ?>
            </a>
		</td>
	</tr>
</table>

<?php if($totalElements == 0 )  : ?>
	<!-- ====================
	NO-DATA MESSAGES-->
	<table class="widefat dup-pack-table">
		<thead><tr><th>&nbsp;</th></tr></thead>
		<tbody>
			<tr>
				<td>
				<div id='dup-list-alert-nodata'>
					<i class="fa fa-archive"></i> 
					<?php esc_html_e("No Packages Found.", 'duplicator'); ?><br/>
					<?php esc_html_e("Click the 'Create New' button to build a package.", 'duplicator'); ?><br/>
					<div class="dup-quick-start">
						<?php esc_html_e("New to Duplicator?", 'duplicator'); ?><br/>
						<a href="https://snapcreek.com/duplicator/docs/quick-start/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_content=packages_empty&utm_campaign=quick_start" target="_blank">
							<?php esc_html_e("Check out the 'Quick Start' guide!", 'duplicator'); ?>
						</a>
					</div>
					<div style="height:75px">&nbsp;</div>
				</div>
				</td>
			</tr>
		</tbody>
		<tfoot><tr><th>&nbsp;</th></tr></tfoot>
	</table>
<?php else : ?>	
	<!-- ====================
	LIST ALL PACKAGES -->
	<table class="widefat dup-pack-table">
		<thead>
			<tr>
				<th><input type="checkbox" id="dup-bulk-action-all"  title="<?php esc_attr_e("Select all packages", 'duplicator') ?>" style="margin-left:15px" onclick="Duplicator.Pack.SetDeleteAll()" /></th>
				<th><?php esc_html_e("Created", 'duplicator') ?></th>
				<th><?php esc_html_e("Size", 'duplicator') ?></th>
				<th style="width:90%;"><?php esc_html_e("Name", 'duplicator') ?></th>
				<th style="text-align:center;" colspan="2">
					<?php esc_html_e("Package",  'duplicator')?>
				</th>
			</tr>
		</thead>
		<tr id="pack-processing">
			<td colspan="6">
				<div id='dup-list-alert-nodata'>
					<i class="fa fa-archive"></i>
					<?php esc_html_e("No Packages Found.", 'duplicator'); ?><br/>
					<?php esc_html_e("Click the 'Create New' button to build a package.", 'duplicator'); ?><br/>
					<div class="dup-quick-start">
						<?php esc_html_e("New to Duplicator?", 'duplicator'); ?><br/>
						<a href="https://snapcreek.com/duplicator/docs/quick-start/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_content=packages_empty&utm_campaign=quick_start" target="_blank">
							<?php esc_html_e("Check out the 'Quick Start' guide!", 'duplicator'); ?>
						</a>
					</div>
					<div style="height:75px">&nbsp;</div>
				</div>
			</td>
		</tr>
		<?php
		$rowCount = 0;
		//$totalSize = 0;
		$txt_dbonly    = __('Database Only', 'duplicator');
		$txt_mode_zip  = __('Archive created as zip file', 'duplicator');
		$txt_mode_daf  = __('Archive created as daf file', 'duplicator');
		//$rows = $qryResult;


		foreach ($packages as $Package) {
            $is_running_package = $Package->isRunning();

            // Never display incomplete packages and purge those that are no longer active
            if(!$is_running_package && $Package->Status >= 0 && $Package->Status < 100) {
                $Package->delete();
                
                if ($rowCount <= 1 && $totalElements == 1) {
                    $package_running = true;
                }

                continue;
            }
            
            
			$pack_dbonly = false;

			if (is_object($Package)) {
				 $pack_name			= $Package->Name;
				 $pack_archive_size = $Package->getArchiveSize();
                 $pack_perc         = $Package->Status;
				 $pack_storeurl		= $Package->StoreURL;
				 $pack_namehash	    = $Package->NameHash;
				 $pack_dbonly       = $Package->Archive->ExportOnlyDB;
				 $pack_build_mode   = ($Package->Archive->Format === 'ZIP') ? true : false;
			} else {
				 $pack_archive_size = 0;
                 $pack_perc         = 0;
				 $pack_storeurl		= 'unknown';
				 $pack_name			= 'unknown';
				 $pack_namehash	    = 'unknown';
				 $pack_build_mode   = false;
			}
			
			//Links
			$uniqueid  			=  $Package->Name.'_'.$Package->Hash;
	
            
      		$packagepath 		= $pack_storeurl . $Package->Archive->File;
   
			$installerpath		= $pack_storeurl . "{$uniqueid}_installer.php";
			$installfilelink	= "{$installerpath}?get=1&file={$uniqueid}_installer.php";
			$css_alt		    = ($rowCount % 2 != 0) ? '' : 'alternate';
			?>

			<!-- COMPLETE -->

			<?php

            if ($Package->Status >= 100 || $is_running_package) :
                $statusCount ++;
                ?>
				<tr class="dup-pack-info <?php echo esc_attr($css_alt); ?> <?php echo $is_running_package ? 'is-running' : ''; ?>">
					<td class="pass"><input name="delete_confirm" type="checkbox" id="<?php echo absint($Package->ID); ?>" /></td>
					<td>
						<?php 
							echo DUP_Package::getCreatedDateFormat( $Package->Created , $ui_create_frmt);
							echo ($pack_build_mode) ? " <sup title='{$txt_mode_zip}'>zip</sup>" : " <sup title='{$txt_mode_daf}'>daf</sup>";
						?>
					</td>
					<td class="pack-size"><?php echo DUP_Util::byteSize($pack_archive_size); ?></td>
					<td class='pack-name'>
						<?php	echo ($pack_dbonly) ? "{$pack_name} <sup title='".esc_attr($txt_dbonly)."'>DB</sup>" : esc_html($pack_name); ?>
                        <span class="building-info" ><i class="fa fa-gear fa-spin"></i> <b>Building Package</b> <span class="perc"><?php echo $pack_perc; ?></span>%</span>
					</td>
					<td class="get-btns">
						<button id="<?php echo esc_attr("{$uniqueid}_installer.php"); ?>" class="button no-select" onclick="Duplicator.Pack.DownloadPackageFile(0, <?php echo absint($Package->ID); ?>); return false;">
							<i class="fa fa-bolt"></i> <?php esc_html_e("Installer", 'duplicator') ?>
						</button> 
                        <button id="<?php echo esc_attr("{$uniqueid}_archive.zip"); ?>" class="button no-select" onclick="Duplicator.Pack.DownloadFile('<?php echo esc_js($Package->Archive->File); ?>', '<?php echo esc_js($packagepath); ?>'); return false;">
							<i class="fa fa-file-archive-o"></i> <?php esc_html_e("Archive", 'duplicator') ?>
						</button>
						<button type="button" class="button no-select" title="<?php esc_attr_e("Package Details", 'duplicator') ?>" onclick="Duplicator.Pack.OpenPackageDetails(<?php echo "{$Package->ID}"; ?>);">
							<i class="fa fa-archive" ></i> 
						</button>
					</td>
				</tr>
				
			<!-- NOT COMPLETE -->				
			<?php else : ?>	
			
				<?php
					/*$size = 0;
					$tmpSearch = glob(DUPLICATOR_SSDIR_PATH_TMP . "/{$pack_namehash}_*");
					if (is_array($tmpSearch)) {
						$result = array_map('filesize', $tmpSearch);
						$size = array_sum($result);
					}
					$pack_archive_size = $size;*/
					$error_url = "?page=duplicator&action=detail&tab=detail&id={$Package->ID}";
				?>
				<tr class="dup-pack-info  <?php echo esc_attr($css_alt); ?>">
					<td class="fail"><input name="delete_confirm" type="checkbox" id="<?php echo absint($Package->ID); ?>" /></td>
					<td><?php echo DUP_Package::getCreatedDateFormat($Package->Created, $ui_create_frmt);?></td>
					<td class="pack-size"><?php echo DUP_Util::byteSize($pack_archive_size); ?></td>
					<td class='pack-name'><?php echo esc_html($pack_name); ?></td>               
					<td class="get-btns error-msg" colspan="2">		
						<span>
							<i class="fa fa-exclamation-triangle"></i>
							<a href="<?php echo esc_url($error_url); ?>"><?php esc_html_e("Error Processing", 'duplicator') ?></a>
						</span>			
						<a class="button no-select" title="<?php esc_attr_e("Package Details", 'duplicator') ?>" href="<?php echo esc_url($error_url); ?>">
							<i class="fa fa-archive"></i> 
						</a>						
					</td>
				</tr>
			<?php endif; ?>
			<?php
			//$totalSize = $totalSize + $pack_archive_size;
			$rowCount++;
		}
	?>
	<tfoot>
		<tr>
			<th colspan="11" style="text-align:right; font-size:12px;">
				<?php //esc_html_e("Total Size", 'duplicator');	echo ': ';  esc_html_e(DUP_Util::byteSize($totalSize)); ?>
				<span style="font-style:italic; cursor:help" title="<?php esc_attr_e("Current Server Time", 'duplicator') ?>">
				<?php
					$dup_serv_time = @date("H:i");
					esc_html_e("Time", 'duplicator');	echo ": {$dup_serv_time}";
				?>
				</span>
			</th>
		</tr>
	</tfoot>
	</table>

	<div style="float:right; padding:10px 5px">
		<?php echo $totalElements; echo '&nbsp;'; esc_html_e("Items", 'duplicator');  ?>
	</div>
	
<?php endif; ?>	
</form>

<!-- ==========================================
THICK-BOX DIALOGS: -->
<?php
$alert1          = new DUP_UI_Dialog();
$alert1->title   = __('Bulk Action Required', 'duplicator');
$alert1->message = '<i class="fa fa-exclamation-triangle"></i>&nbsp;';
$alert1->message .= __('No selections made! Please select an action from the "Bulk Actions" drop down menu.', 'duplicator');
$alert1->initAlert();

$alert2          = new DUP_UI_Dialog();
$alert2->title   = __('Selection Required', 'duplicator', 'duplicator');
$alert2->message = '<i class="fa fa-exclamation-triangle"></i>&nbsp;';
$alert2->message .= __('No selections made! Please select at least one package to delete.', 'duplicator');
$alert2->initAlert();

$confirm1               = new DUP_UI_Dialog();
$confirm1->title        = __('Delete Packages?', 'duplicator');
$confirm1->message      = __('Are you sure, you want to delete the selected package(s)?', 'duplicator');
$confirm1->progressText = __('Removing Packages, Please Wait...', 'duplicator');
$confirm1->jscallback   = 'Duplicator.Pack.Delete()';
$confirm1->initConfirm();

$alert3          = new DUP_UI_Dialog();
$alert3->height  = 355;
$alert3->width   = 350;
$alert3->title   = __('Duplicator Help', 'duplicator');
$alert3->message = "<div id='dup-help-dlg'></div>";
$alert3->initAlert();

$alertPackRunning          = new DUP_UI_Dialog();
$alertPackRunning->title   = __('Alert!', 'duplicator');
$alertPackRunning->message = __('A package is being processed. Retry later.', 'duplicator');
$alertPackRunning->initAlert();
?>

<!-- =======================
DIALOG: HELP DIALOG -->
<div id="dup-help-dlg-info" style="display:none">
	<b><?php esc_html_e("Common Questions:", 'duplicator') ?></b><hr size='1'/>
	<i class="fa fa-file-text-o"></i> <a href="https://snapcreek.com/duplicator/docs/quick-start?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_content=help_btn_pack_help&utm_campaign=duplicator_free#quick-010-q" target="_blank"><?php esc_html_e("How do I create a package", 'duplicator') ?></a> <br/>
    <i class="fa fa-file-text-o"></i> <a href="https://snapcreek.com/duplicator/docs/quick-start/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_content=help_btn_install_help&utm_campaign=duplicator_free#quick-040-q" target="_blank"><?php esc_html_e('How do I install a package?', 'duplicator'); ?></a>	 <br/>
	<i class="fa fa-file-code-o"></i> <a href="https://snapcreek.com/duplicator/docs/faqs-tech?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_content=help_btn_faq&utm_campaign=duplicator_free" target="_blank"><?php esc_html_e("Frequently Asked Questions!", 'duplicator') ?></a>
	<br/><br/>

	<b><?php esc_html_e("Other Resources:", 'duplicator') ?></b><hr size='1'/>
	<i class="fa fa-question-circle"></i> <a href="https://snapcreek.com/ticket?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_content=help_btn_ticket&utm_campaign=duplicator_free" target="_blank"><?php esc_html_e("Need help with the plugin?", 'duplicator') ?></a> <br/>
	<i class="fa fa-lightbulb-o"></i> <a href="https://snapcreek.com/support?idea=1&utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_content=help_btn_idea&utm_campaign=duplicator_free" target="_blank"><?php esc_html_e("Have an idea for the plugin?", 'duplicator') ?></a> <br/>
	<?php if($statusCount >= 3)  :	?>
		<i class="fa fa-star-o"></i> <a href="https://wordpress.org/support/plugin/duplicator/reviews/?filter=5" target="vote-wp"><?php esc_html_e("Help review the plugin!", 'duplicator') ?></a>
	<?php endif; ?>
</div>

<script>
jQuery(document).ready(function($) 
{
    /** Create new package check */
    Duplicator.Pack.CreateNew = function(e){
        var cButton = $(e);
        if (cButton.hasClass('disabled')) {
            <?php $alertPackRunning->showAlert(); ?>
        } else {
            Duplicator.Pack.GetActivePackageInfo(function (info) {
                if (info.present) {
                    cButton.addClass('disabled');
                    // reloag current page to update packages list
                    location.reload(true);
                } else {
                    // no active package. Load step1 page.
                    window.location = cButton.attr('href');
                }
            });
        }
        return false;
    };

	/*	Creats a comma seperate list of all selected package ids  */
	Duplicator.Pack.GetDeleteList = function () 
	{
		var arr = new Array;
		var count = 0;
		$("input[name=delete_confirm]").each(function () {
			if (this.checked) {
				arr[count++] = this.id;
			}
		});
		var list = arr.join(',');
		return list;
	}
	
	/*	Provides the correct confirmation items when deleting packages */
	Duplicator.Pack.ConfirmDelete = function () 
	{
		if ($("#dup-pack-bulk-actions").val() != "delete") {
			<?php $alert1->showAlert(); ?>
			return;
		}
		
		var list = Duplicator.Pack.GetDeleteList();
		if (list.length == 0) {
			<?php $alert2->showAlert(); ?>
			return;
		}
		<?php $confirm1->showConfirm(); ?>
	}
	
	
	/*	Removes all selected package sets 
	 *	@param event	To prevent bubbling */
	Duplicator.Pack.Delete = function (event) 
	{
		var list = Duplicator.Pack.GetDeleteList();

		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {action : 'duplicator_package_delete', duplicator_delid : list, nonce: '<?php echo esc_js($ajax_nonce); ?>' },
			complete: function(data) { 
				Duplicator.ReloadWindow(data); 
			}
		});

	};

    Duplicator.Pack.ActivePackageInfo = function (info) {
        $('.dup-pack-info.is-running .pack-size').text(info.size_format);

        if (info.present) {
            $('.dup-pack-info.is-running .building-info .perc').text(info.status);

            setTimeout(function(){
                Duplicator.Pack.GetActivePackageInfo(Duplicator.Pack.ActivePackageInfo);
            }, 1000);
            
        } else {
            $('.dup-pack-info.is-running').removeClass('is-running');
            $('#dup-create-new.disabled').removeClass('disabled');
        }
    }

    /*	Get active package info
	 *
     *	  */
	Duplicator.Pack.GetActivePackageInfo = function (callbackOnSuccess)
	{
		$.ajax({
            type: "POST",
            cache: false,
            url: ajaxurl,
            dataType: "json",
            timeout: 10000000,
			data: {
                action : 'duplicator_active_package_info',
                nonce: '<?php echo esc_js(wp_create_nonce('duplicator_active_package_info')); ?>'
            },
			complete: function () {},
            success: function (result) {
                console.log(result);
                if (result.success) {
                    if ($.isFunction(callbackOnSuccess)) {
                        callbackOnSuccess(result.data.active_package);
                    }
                } else {
                    // @todo manage error
                }
			},
            error: function (result) {
                var result = result || new Object();
                // @todo manage error
            }
		});
	};
	
	/* Toogles the Bulk Action Check boxes */
	Duplicator.Pack.SetDeleteAll = function() 
	{
		var state = $('input#dup-bulk-action-all').is(':checked') ? 1 : 0;
		$("input[name=delete_confirm]").each(function() {
			 this.checked = (state) ? true : false;
		});
	}
	
	/*	Opens detail screen */
	Duplicator.Pack.OpenPackageDetails = function (package_id) 
	{
		window.location.href = '?page=duplicator&action=detail&tab=detail&id=' + package_id;
	}

	/*	Toggles the feedback form */
	Duplicator.Pack.showHelp = function ()
	{
		$('#dup-help-dlg').html($('#dup-help-dlg-info').html());
		<?php $alert3->showAlert(); ?>
	}

<?php if ($package_running) : ?>
    	$('#pack-processing').show();
<?php endif;

if ($active_package_present) :?>
    Duplicator.Pack.GetActivePackageInfo(Duplicator.Pack.ActivePackageInfo);
<?php endif; ?>
	
});
</script>