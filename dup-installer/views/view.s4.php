<?php
defined("ABSPATH") or die("");
/** IDE HELPERS */
/* @var $GLOBALS['DUPX_AC'] DUPX_ArchiveConfig */

$_POST['exe_safe_mode']	= isset($_POST['exe_safe_mode']) ? DUPX_U::sanitize_text_field($_POST['exe_safe_mode']) : 0;

$url_new_rtrim  = rtrim(DUPX_U::sanitize_text_field($_POST['url_new']), "/");
$admin_base		= basename($GLOBALS['DUPX_AC']->wplogin_url);
$admin_redirect ="{$url_new_rtrim}/wp-admin/admin.php?page=duplicator-tools&tab=diagnostics";

$safe_mode		= DUPX_U::sanitize_text_field($_POST['exe_safe_mode']);
$admin_redirect = "{$admin_redirect}&package={$GLOBALS['DUPX_AC']->package_name}&installer_name={$GLOBALS['BOOTLOADER_NAME']}&safe_mode={$safe_mode}" ;
$admin_redirect = urlencode($admin_redirect);
$admin_url_qry  = (strpos($admin_base, '?') === false) ? '?' : '&';
$admin_login	= "{$url_new_rtrim}/{$admin_base}{$admin_url_qry}redirect_to={$admin_redirect}";
?>

<script>
	DUPX.getAdminLogin = function()
    {
		if ($('input#auto-delete').is(':checked')) {
			var action = encodeURIComponent('&action=installer');
			window.open('<?php echo $admin_login; ?>' + action, '_blank');
		} else {
			window.open('<?php echo $admin_login; ?>', '_blank');
		}
	};
</script>

<!-- =========================================
VIEW: STEP 4- INPUT -->
<form id='s4-input-form' method="post" class="content-form" style="line-height:20px">
	<input type="hidden" name="url_new" id="url_new" value="<?php echo DUPX_U::esc_attr($url_new_rtrim); ?>" />
	<div class="logfile-link"><a href="./<?php echo DUPX_U::esc_attr($GLOBALS["LOG_FILE_NAME"]);?>?now=<?php echo DUPX_U::esc_attr($GLOBALS['NOW_TIME']); ?>" target="dup-installer">dup-installer-log.txt</a></div>

	<div class="hdr-main">
		Step <span class="step">4</span> of 4: Test Site
	</div><br/>

	<!--  POST PARAMS -->
	<div class="dupx-debug">
		<i>Step 4 - Page Load</i>
		<input type="hidden" name="view" value="step4" />
		<input type="hidden" name="csrf_token" value="<?php echo DUPX_CSRF::generate('step4'); ?>">
		<input type="hidden" name="exe_safe_mode" id="exe-safe-mode" value="<?php echo DUPX_U::esc_attr($_POST['exe_safe_mode']); ?>" />
	</div>

	<table class="s4-final-step">
		<tr style="vertical-align: top">
			<td style="padding-top:10px">
				<button type="button" class="s4-final-btns" onclick="DUPX.getAdminLogin()"><i class="fa fa-wordpress"></i> Admin Login</button>
			</td>
			<td>
				Login to the WordPress Admin to finalize this install.<br/>
				<input type="checkbox" name="auto-delete" id="auto-delete" checked="true"/>
				<label for="auto-delete">Auto delete installer files after login <small>(recommended)</small></label>
				<br/><br/>
								
				<!-- WARN: SAFE MODE MESSAGES -->
				<div class="s4-warn" style="display:<?php echo ($safe_mode > 0 ? 'block' : 'none')?>">
					<b>Safe Mode</b><br/>
					Safe mode has <u>deactivated</u> all plugins. Please be sure to enable your plugins after logging in. <i>If you notice that problems arise when activating
					the plugins then active them one-by-one to isolate the plugin that	could be causing the issue.</i>
				</div>
			</td>
		</tr>
	</table>
	<i style="color:maroon; font-size:12px">
		<b><i class="fa fa-exclamation-triangle"></i> IMPORTANT FINAL STEPS:</b> Login into the WordPress Admin to remove all
		<a href="?view=help&archive=<?php echo DUPX_U::esc_attr($GLOBALS['FW_ENCODED_PACKAGE_PATH']); ?>&bootloader=<?php echo DUPX_U::esc_attr($GLOBALS['BOOTLOADER_NAME']); ?>&basic#help-s4" target="_blank">installation files</a>
		and keep this site secure.   This install is NOT complete until all installer files are removed.
	</i>
	<br/><br/><br/>


	<div class="s4-go-back">
		Additional Notes:
		<ul style="margin-top: 1px">
			<li>
				<a href="javascript:void(0)" onclick="$('#s4-install-report').toggle(400)">Review Migration Report</a><br/>
				&nbsp; &nbsp;
				<i id="s4-install-report-count">
					<span data-bind="with: status.step1">Install Notices:(<span data-bind="text: query_errs"></span>)</span> &nbsp;
					<span data-bind="with: status.step3">Replace Notices:(<span data-bind="text: err_all"></span>)</span> &nbsp; &nbsp;
					<span data-bind="with: status.step3" style="color:#888"><b>General Notices:</b>(<span data-bind="text: warn_all"></span>)</span>
				</i>
			</li>
			<li>
				Review this sites <a href="<?php echo DUPX_U::esc_attr($url_new_rtrim); ?>" target="_blank">front-end</a> or
				re-run the installer and <a href="<?php echo DUPX_U::esc_url("{$url_new_rtrim}/installer.php"); ?>">go back to step 1</a>.
			</li>
			<li>If the .htaccess file was reset some plugin settings might need to be re-saved.</li>
			<li>For additional help and questions visit the <a href='https://snapcreek.com/duplicator/docs/faqs-tech/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=problem_resolution&utm_content=inst4_step4_troubleshoot' target='_blank'>online FAQs</a>.</li>
		</ul>
	</div>

	<!-- ========================
	INSTALL REPORT -->
	<div id="s4-install-report" style='display:none'>
		<table class='s4-report-results' style="width:100%">
			<tr><th colspan="4">Database Report</th></tr>
			<tr style="font-weight:bold">
				<td style="width:150px"></td>
				<td>Tables</td>
				<td>Rows</td>
				<td>Cells</td>
			</tr>
			<tr data-bind="with: status.step1">
				<td>Created</td>
				<td><span data-bind="text: table_count"></span></td>
				<td><span data-bind="text: table_rows"></span></td>
				<td>n/a</td>
			</tr>
			<tr data-bind="with: status.step3">
				<td>Scanned</td>
				<td><span data-bind="text: scan_tables"></span></td>
				<td><span data-bind="text: scan_rows"></span></td>
				<td><span data-bind="text: scan_cells"></span></td>
			</tr>
			<tr data-bind="with: status.step3">
				<td>Updated</td>
				<td><span data-bind="text: updt_tables"></span></td>
				<td><span data-bind="text: updt_rows"></span></td>
				<td><span data-bind="text: updt_cells"></span></td>
			</tr>
		</table>
		<br/>

		<table class='s4-report-errs' style="width:100%; border-top:none">
			<tr><th colspan="4">Report Notices</th></tr>
			<tr>
				<td data-bind="with: status.step1">
					<a href="javascript:void(0);" onclick="$('#s4-errs-create').toggle(400)">Step 2: Install Notices (<span data-bind="text: query_errs"></span>)</a><br/>
				</td>
				<td data-bind="with: status.step3">
					<a href="javascript:void(0);" onclick="$('#s4-errs-upd').toggle(400)">Step 3: Replace Notices (<span data-bind="text: err_all"></span>)</a>
				</td>
				<td data-bind="with: status.step3">
					<a href="#s3-errs-warn-anchor" onclick="$('#s4-warnlist').toggle(400)">General Notices (<span data-bind="text: warn_all"></span>)</a>
				</td>
			</tr>
			<tr><td colspan="4"></td></tr>
		</table>


		<div id="s4-errs-create" class="s4-err-msg">
			<div class="s4-err-title">STEP 2 - INSTALL NOTICES:</div>
			<b data-bind="with: status.step1">ERRORS (<span data-bind="text: query_errs"></span>)</b><br/>
			<div class="info-error">
				Queries that error during the deploy step are logged to the <a href="./<?php echo DUPX_U::esc_attr($GLOBALS["LOG_FILE_NAME"]);?>" target="dup-installer">install-log.txt</a> file and
				and marked with an **ERROR** status.   If you experience a few errors (under 5), in many cases they can be ignored as long as your site is working correctly.
				However if you see a large amount of errors or you experience an issue with your site then the error messages in the log file will need to be investigated.
				<br/><br/>

				<b>COMMON FIXES:</b>
				<ul>
					<li>
						<b>Unknown collation:</b> See Online FAQ:
						<a href="https://snapcreek.com/duplicator/docs/faqs-tech/#faq-trouble-090-q" target="_blank">What is Compatibility mode & 'Unknown collation' errors?</a>
					</li>
					<li>
						<b>Query Limits:</b> Update MySQL server with the <a href="https://dev.mysql.com/doc/refman/5.5/en/packet-too-large.html" target="_blank">max_allowed_packet</a>
						setting for larger payloads.
					</li>
				</ul>
			</div>
		</div>


		<div id="s4-errs-upd" class="s4-err-msg">
			<div class="s4-err-title">STEP 3 - UPDATE NOTICES:</div>
			<!-- MYSQL QUERY ERRORS -->
			<b data-bind="with: status.step3">ERRORS (<span data-bind="text: errsql_sum"></span>) </b><br/>
			<div class="info-error">
				Update errors that show here are queries that could not be performed because the database server being used has issues running it.  Please validate the query, if
				it looks to be of concern please try to run the query manually.  In many cases if your site performs well without any issues you can ignore the error.
			</div>
			<div class="content">
				<div data-bind="foreach: status.step3.errsql"><div data-bind="text: $data"></div></div>
				<div data-bind="visible: status.step3.errsql.length == 0">No MySQL query errors found</div>
			</div>
			<br/>

			<!-- TABLE KEY ERRORS -->
			<b data-bind="with: status.step3">TABLE KEY NOTICES (<span data-bind="text: errkey_sum"></span>)</b><br/>
			<div class="info-notice">
				Notices should be ignored unless issues are found after you have tested an installed site. This notice indicates that a primary key is required to run the
				update engine. Below is a list of tables and the rows that were not updated.  On some databases you can remove these notices by checking the box 'Enable Full Search'
				under options in step3 of the installer.
				<br/><br/>
				<small>
					<b>Advanced Searching:</b><br/>
					Use the following query to locate the table that was not updated: <br/>
					<i>SELECT @row := @row + 1 as row, t.* FROM some_table t, (SELECT @row := 0) r</i>
				</small>
			</div>
			<div class="content">
				<div data-bind="foreach: status.step3.errkey"><div data-bind="text: $data"></div></div>
				<div data-bind="visible: status.step3.errkey.length == 0">No missing primary key errors</div>
			</div>
			<br/>

			<!-- SERIALIZE NOTICES -->
			<b data-bind="with: status.step3">SERIALIZATION NOTICES  (<span data-bind="text: errser_sum"></span>)</b><br/>
			<div class="info-notice">
				Notices should be ignored unless issues are found after you have tested an installed site.  The SQL below will show data that may have not been
				updated during the serialization process.  Best practices for serialization notices is to just re-save the plugin/post/page in question.
			</div>
			<div class="content">
				<div data-bind="foreach: status.step3.errser"><div data-bind="text: $data"></div></div>
				<div data-bind="visible: status.step3.errser.length == 0">No serialization notices found</div>
			</div>
		</div>


		<!-- WARNINGS-->
		<div id="s4-warnlist" class="s4-err-msg">
			<a href="#" id="s3-errs-warn-anchor"></a>
			<b>GENERAL NOTICES</b><br/>
			<div class="info">
				The following is a list of notices that may need to be fixed in order to finalize your setup.  These values should only be investigated if your running into
				issues with your site. For more details see the <a href="https://codex.wordpress.org/Editing_wp-config.php" target="_blank">WordPress Codex</a>.
			</div>
			<div class="content">
				<div data-bind="foreach: status.step3.warnlist">
					 <div data-bind="html: $data"></div>
				</div>
				<div data-bind="visible: status.step3.warnlist.length == 0">
					No notices found
				</div>
			</div>
		</div><br/>

	</div><br/><br/>

	<div class='s4-connect' style="display:none">
		<a href='http://snapcreek.com/support/docs/faqs/' target='_blank'>FAQs</a> |
		<a href='https://snapcreek.com' target='_blank'>Support</a>
	</div><br/>

    <?php
		$num = rand(1,2);
		switch ($num) {
			case 1:
				$key = 'free_inst_s3btn1';
				$txt = 'Want More Power?';
				break;
			case 2:
				$key = 'free_inst_s3btn2';
				$txt = 'Go Pro Today!';
				break;
			default :
				$key = 'free_inst_s3btn2';
				$txt = 'Go Pro Today!';
		}
	?>

	<div class="s4-gopro-btn">
		<a href="https://snapcreek.com/duplicator/?utm_source=duplicator_free&utm_medium=wordpress_plugin&utm_campaign=duplicator_pro&utm_content=<?php echo DUPX_U::esc_attr($key);?>" target="_blank">
			<?php echo DUPX_U::esc_html($txt);?>
		</a>
	</div>
	<br/><br/><br/>
</form>

<?php
	//Sanitize
	$json_result = true;
	$_POST['json'] = isset($_POST['json']) ? DUPX_U::esc_attr($_POST['json']) : 'json data not set';
	$json_data   = utf8_decode(urldecode($_POST['json']));
	$json_decode = json_decode($json_data);
	if ($json_decode == NULL || $json_decode == FALSE) {
		$json_data  = "{'json reset invalid form value sent.  Possible site script attempt'}";
		$json_result = false;
	}
?>

<script>
<?php if ($json_result) : ?>
	MyViewModel = function() {
		this.status = <?php echo $json_data; ?>;
		var errorCount =  this.status.step1.query_errs || 0;
		(errorCount >= 1 )
			? $('#s4-install-report-count').css('color', '#BE2323')
			: $('#s4-install-report-count').css('color', '#197713')
	};
	ko.applyBindings(new MyViewModel());
<?php else: ?>
	console.log("Cross site script attempt detected, unable to create final report!");
<?php endif; ?>
</script>



