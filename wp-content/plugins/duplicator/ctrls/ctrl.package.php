<?php
// Exit if accessed directly
if (! defined('DUPLICATOR_VERSION')) exit;

require_once(DUPLICATOR_PLUGIN_PATH.'/ctrls/ctrl.base.php');
require_once(DUPLICATOR_PLUGIN_PATH.'/classes/utilities/class.u.scancheck.php');
require_once(DUPLICATOR_PLUGIN_PATH.'/classes/utilities/class.u.json.php');
require_once(DUPLICATOR_PLUGIN_PATH.'/classes/package/class.pack.php');
require_once(DUPLICATOR_PLUGIN_PATH.'/classes/package/duparchive/class.pack.archive.duparchive.state.create.php');
/* @var $package DUP_Package */

/**
 *  DUPLICATOR_PACKAGE_SCAN
 *  Returns a JSON scan report object which contains data about the system
 *
 *  @return json   JSON report object
 *  @example	   to test: /wp-admin/admin-ajax.php?action=duplicator_package_scan
 */
function duplicator_package_scan()
{
    $nonce = sanitize_text_field($_REQUEST['nonce']);
	if (!wp_verify_nonce($nonce, 'duplicator_package_scan')) {
		die('An unathorized security request was made to this page. Please try again!');
	}

    DUP_Util::hasCapability('export');

    header('Content-Type: application/json;');
    @ob_flush();

    @set_time_limit(0);
    $errLevel = error_reporting();
    error_reporting(E_ERROR);
    DUP_Util::initSnapshotDirectory();

    $package = DUP_Package::getActive();
    $report  = $package->runScanner();

    $package->saveActiveItem('ScanFile', $package->ScanFile);
    $json_response = DUP_JSON::safeEncode($report);

    DUP_Package::tempFileCleanup();
    error_reporting($errLevel);
    die($json_response);
}

/**
 *  duplicator_package_build
 *  Returns the package result status
 *
 *  @return json   JSON object of package results
 */
function duplicator_package_build()
{
    DUP_Util::hasCapability('export');

    check_ajax_referer('duplicator_package_build', 'nonce');
    header('Content-Type: application/json');

    @set_time_limit(0);
    $errLevel = error_reporting();
    error_reporting(E_ERROR);
    DUP_Util::initSnapshotDirectory();

    $Package = DUP_Package::getActive();
    $Package->save('zip');

    DUP_Settings::Set('active_package_id', $Package->ID);
    DUP_Settings::Save();

    if (!is_readable(DUPLICATOR_SSDIR_PATH_TMP."/{$Package->ScanFile}")) {
        die("The scan result file was not found.  Please run the scan step before building the package.");
    }

    $Package->runZipBuild();

    //JSON:Debug Response
    //Pass = 1, Warn = 2, Fail = 3
    $json            = array();
    $json['status']  = 1;
    $json['package'] = $Package;
    $json['runtime'] = $Package->Runtime;
    $json['exeSize'] = $Package->ExeSize;
    $json['archiveSize'] = $Package->ZipSize;
    $json_response   = json_encode($json);

    //Simulate a Host Build Interrupt
	//die(0);

    error_reporting($errLevel);
    die($json_response);
}

/**
 *  Returns the package result status
 *
 *  @return json   JSON object of package results
 */
function duplicator_duparchive_package_build()
{
    DUP_LOG::Trace("call to duplicator_duparchive_package_build");

    DUP_Util::hasCapability('export');
    check_ajax_referer('duplicator_duparchive_package_build', 'nonce');
    header('Content-Type: application/json');

    @set_time_limit(0);
    $errLevel = error_reporting();
    error_reporting(E_ERROR);

    // The DupArchive build process always works on a saved package so the first time through save the active package to the package table.
    // After that, just retrieve it.
    $active_package_id = DUP_Settings::Get('active_package_id');

    if ($active_package_id == -1) {

        $package = DUP_Package::getActive();
        $package->save('daf');
        DUP_Log::TraceObject("saving active package as new id={$package->ID}", package);
        DUP_Settings::Set('active_package_id', $package->ID);
        DUP_Settings::Save();
    } else {

        DUP_Log::TraceObject("getting active package by id {$active_package_id}", package);
        $package = DUP_Package::getByID($active_package_id);
    }

    if (!is_readable(DUPLICATOR_SSDIR_PATH_TMP."/{$package->ScanFile}")) {
        die("The scan result file was not found.  Please run the scan step before building the package.");
    }

    if ($package === null) {
        die("There is no active package.");
    }

    if($package->Status == DUP_PackageStatus::ERROR) {
        $hasCompleted = true;
    } else {
        try {
            $hasCompleted = $package->runDupArchiveBuild();
        }
        catch(Exception $ex) {
            Dup_Log::Trace('#### caught exception');
            Dup_Log::Error('Caught exception', $ex->getMessage(), Dup_ErrorBehavior::LogOnly);
            Dup_Log::Trace('#### after log');
            $package->setStatus(DUP_PackageStatus::ERROR);
            $hasCompleted = true;
        }
    }

    $json = array();
    $json['failures'] = array_merge($package->BuildProgress->build_failures, $package->BuildProgress->validation_failures);
    DUP_LOG::traceObject("#### failures", $json['failures']);

    //JSON:Debug Response
    //Pass = 1, Warn = 2, 3 = Failure, 4 = Not Done
    if ($hasCompleted) {

        Dup_Log::Trace('#### completed');

        if($package->Status == DUP_PackageStatus::ERROR) {

            Dup_Log::Trace('#### error');
            $error_message = __('Error building DupArchive package') . '<br/>';

            foreach($json['failures'] as $failure) {
                $error_message .= implode(',', $failure->description);
            }

            Dup_Log::Error("Build failed so sending back error", esc_html($error_message), Dup_ErrorBehavior::LogOnly);
            Dup_Log::Trace('#### after log 2');

            $json['status'] = 3;
        } else {
            Dup_Log::Info("sending back success status");
            $json['status']  = 1;
        }

        Dup_Log::Trace('#### json package');
        $json['package']     = $package;
        $json['runtime']     = $package->Runtime;
        $json['exeSize']     = $package->ExeSize;
        $json['archiveSize'] = $package->ZipSize;
    } else {
        Dup_Log::Info("sending back continue status");
        $json['status'] = 4;
    }

    $json_response = json_encode($json);

    Dup_Log::TraceObject('json response', $json_response);
    error_reporting($errLevel);
    die($json_response);
}

/**
 *  DUPLICATOR_PACKAGE_DELETE
 *  Deletes the files and database record entries
 *
 *  @return json   A JSON message about the action.
 * 				   Use console.log to debug from client
 */
function duplicator_package_delete()
{
    DUP_Util::hasCapability('export');
    check_ajax_referer('package_list', 'nonce');

	function _unlinkFile($file) {
		if (! file_exists($file)) {
			return;
		}
		if (! @unlink($file)) {
			@chmod($file, 0644);
			@unlink($file);
		}
	}

    try {
        global $wpdb;
        $json     = array();
        $post     = stripslashes_deep($_POST);
        $tablePrefix = DUP_Util::getTablePrefix();
        $tblName  = $tablePrefix.'duplicator_packages';
        $postIDs  = isset($post['duplicator_delid']) ? sanitize_text_field($post['duplicator_delid']) : null;
        $list     = explode(",", $postIDs);
        $delCount = 0;

        if ($postIDs != null) {

            foreach ($list as $id) {

                $getResult = $wpdb->get_results($wpdb->prepare("SELECT name, hash FROM `{$tblName}` WHERE id = %d", $id), ARRAY_A);

                if ($getResult) {
                    $row       = $getResult[0];
                    $nameHash  = "{$row['name']}_{$row['hash']}";
                    $delResult = $wpdb->query($wpdb->prepare("DELETE FROM `{$tblName}` WHERE id = %d", $id));
                    if ($delResult != 0) {

						//TMP FILES
						_unlinkFile(DUP_Util::safePath(DUPLICATOR_SSDIR_PATH_TMP."/{$nameHash}_archive.daf"));
                        _unlinkFile(DUP_Util::safePath(DUPLICATOR_SSDIR_PATH_TMP."/{$nameHash}_archive.zip"));
                        _unlinkFile(DUP_Util::safePath(DUPLICATOR_SSDIR_PATH_TMP."/{$nameHash}_database.sql"));
                        _unlinkFile(DUP_Util::safePath(DUPLICATOR_SSDIR_PATH_TMP."/{$nameHash}_installer.php"));

						//WP-SNAPSHOT FILES
                        _unlinkFile(DUP_Util::safePath(DUPLICATOR_SSDIR_PATH."/{$nameHash}_archive.daf"));
                        _unlinkFile(DUP_Util::safePath(DUPLICATOR_SSDIR_PATH."/{$nameHash}_archive.zip"));
                        _unlinkFile(DUP_Util::safePath(DUPLICATOR_SSDIR_PATH."/{$nameHash}_database.sql"));
                        _unlinkFile(DUP_Util::safePath(DUPLICATOR_SSDIR_PATH."/{$nameHash}_installer.php"));
                        _unlinkFile(DUP_Util::safePath(DUPLICATOR_SSDIR_PATH."/{$nameHash}_scan.json"));
						_unlinkFile(DUP_Util::safePath(DUPLICATOR_SSDIR_PATH."/{$nameHash}.log"));

                        //Unfinished Zip files
                        $tmpZip = DUPLICATOR_SSDIR_PATH_TMP."/{$nameHash}_archive.zip.*";
                        if ($tmpZip !== false) {
                            array_map('unlink', glob($tmpZip));
                        }
                        $delCount++;
                    }
                }
            }
        }
    } catch (Exception $e) {
        $json['error'] = "{$e}";
        die(json_encode($json));
    }

    $json['ids']     = "{$postIDs}";
    $json['removed'] = $delCount;
    echo json_encode($json);
    die();
}

/**
 *  Active package info
 *  Returns a JSON scan report active package info or
 *  active_package_present == false if no active package is present.
 *
 *  @return json
 */
function duplicator_active_package_info()
{
    ob_start();
    try {
        global $wpdb;

        $error  = false;
        $result = array(
            'active_package' => array(
                'present' => false,
                'status' => 0,
                'size' => 0
            ),
            'html' => '',
            'message' => ''
        );

        $nonce = sanitize_text_field($_POST['nonce']);
        if (!wp_verify_nonce($nonce, 'duplicator_active_package_info')) {
             throw new Exception(__('An unathorized security request was made to this page. Please try again!','duplicator'));
        }

        $result['active_package']['present'] = DUP_Package::is_active_package_present();

        if ($result['active_package']['present']) {
            $id = DUP_Settings::Get('active_package_id');
            $package = DUP_Package::getByID($id);
            if (is_null($package)) {
                throw new Exception(__('Active package object error','duplicator'));
            }
            $result['active_package']['status'] = $package->Status;
            $result['active_package']['size'] = $package->getArchiveSize();
            $result['active_package']['size_format'] = DUP_Util::byteSize($package->getArchiveSize());
        }
    } catch (Exception $e) {
        $error             = true;
        $result['message'] = $e->getMessage();
    }

    $result['html'] = ob_get_clean();
    if ($error) {
        wp_send_json_error($result);
    } else {
        wp_send_json_success($result);
    }
}

/**
 * Controller for Tools
 * @package Duplicator\ctrls
 */
class DUP_CTRL_Package extends DUP_CTRL_Base
{

    /**
     *  Init this instance of the object
     */
    function __construct()
    {
        add_action('wp_ajax_DUP_CTRL_Package_addQuickFilters', array($this, 'addQuickFilters'));
        add_action('wp_ajax_DUP_CTRL_Package_getPackageFile', array($this, 'getPackageFile'));
        add_action('wp_ajax_DUP_CTRL_Package_getActivePackageStatus', array($this, 'getActivePackageStatus'));
    }

    /**
     * Removed all reserved installer files names
     *
     * @param string $_POST['dir_paths']		A semi-colon separated list of directory paths
     *
     * @return string	Returns all of the active directory filters as a ";" separated string
     */
    public function addQuickFilters($post)
    {
        $post   = $this->postParamMerge($post);
        $action = sanitize_text_field($post['action']);
        check_ajax_referer($action, 'nonce');
        $result = new DUP_CTRL_Result($this);

        try {
            //CONTROLLER LOGIC
            $package = DUP_Package::getActive();

            //DIRS
            $dir_filters = ($package->Archive->FilterOn)
                                ? $package->Archive->FilterDirs.';'.sanitize_text_field($post['dir_paths'])
                                : sanitize_text_field($post['dir_paths']);
            $dir_filters = $package->Archive->parseDirectoryFilter($dir_filters);
            $changed     = $package->Archive->saveActiveItem($package, 'FilterDirs', $dir_filters);

            //FILES
            $file_filters = ($package->Archive->FilterOn)
                                ? $package->Archive->FilterFiles.';'.sanitize_text_field($post['file_paths'])
                                : sanitize_text_field($post['file_paths']);
            $file_filters = $package->Archive->parseFileFilter($file_filters);
            $changed      = $package->Archive->saveActiveItem($package, 'FilterFiles', $file_filters);

            if (!$package->Archive->FilterOn && !empty($package->Archive->FilterExts)) {
                $changed      = $package->Archive->saveActiveItem($package, 'FilterExts', '');
            }

            $changed = $package->Archive->saveActiveItem($package, 'FilterOn', 1);

            //Result
            $package              = DUP_Package::getActive();
            $payload['dirs-in']   = esc_html(sanitize_text_field($post['dir_paths']));
            $payload['dir-out']   = esc_html($package->Archive->FilterDirs);
            $payload['files-in']  = esc_html(sanitize_text_field($post['file_paths']));
            $payload['files-out'] = esc_html($package->Archive->FilterFiles);

            //RETURN RESULT
            $test = ($changed) ? DUP_CTRL_Status::SUCCESS : DUP_CTRL_Status::FAILED;
            $result->process($payload, $test);
        } catch (Exception $exc) {
            $result->processError($exc);
        }
    }

    /**
     * Download the requested package file
     *
     * @param string $_POST['which']
     * @param string $_POST['package_id']
     *
     * @return downloadable file
     */
    function getPackageFile($post)
    {
        $params = $this->postParamMerge($post);
        $nonce = sanitize_text_field($_GET['nonce']);
        if (!wp_verify_nonce($nonce, 'DUP_CTRL_Package_getPackageFile')) {
            die('An unathorized security request was made to this page. Please try again!');
        }

        $params = $this->getParamMerge($params);
        $result = new DUP_CTRL_Result($this);

        try {
            //CONTROLLER LOGIC
            DUP_Util::hasCapability('export');

            $request   = stripslashes_deep($_REQUEST);
            $which     = (int) $request['which'];
            $packageId = (int) $request['package_id'];
            $package   = DUP_Package::getByID($packageId);
            $isBinary  = ($which != DUP_PackageFileType::Log);
            $filePath  = $package->getLocalPackageFile($which);

            //OUTPUT: Installer, Archive, SQL File
            if ($isBinary) {
                @session_write_close();
                // @ob_flush();
				//flush seems to cause issues on some PHP version where the download prompt
 				//is no longer called but the contents of the installer are dumped to the browser.
                //@flush();

                header("Pragma: public");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Cache-Control: private", false);
                header("Content-Transfer-Encoding: binary");

                if ($filePath != null) {
                    $fp = fopen($filePath, 'rb');
                    if ($fp !== false) {

                        if ($which == DUP_PackageFileType::Installer) {
                            $fileName = 'installer.php';
                        } else {
                            $fileName = basename($filePath);
                        }

						header("Content-Type: application/octet-stream");
						header("Content-Disposition: attachment; filename=\"{$fileName}\";");

                        DUP_LOG::trace("streaming $filePath");

						while(!feof($fp)) {
							$buffer = fread($fp, 2048);
							print $buffer;
						}

                        fclose($fp);
						exit;
                    } else {
                        header("Content-Type: text/plain");
                        header("Content-Disposition: attachment; filename=\"error.txt\";");
                        $message = "Couldn't open $filePath.";
                        DUP_Log::Trace($message);
                        echo esc_html($message);
                    }
                } else {
                    $message = __("Couldn't find a local copy of the file requested.", 'duplicator');

                    header("Content-Type: text/plain");
                    header("Content-Disposition: attachment; filename=\"error.txt\";");

                    // Report that we couldn't find the file
                    DUP_Log::Trace($message);
                    echo esc_html($message);
                }

                //OUTPUT: Log File
            } else {
                if ($filePath != null) {
                    header("Content-Type: text/plain");
                    $text = file_get_contents($filePath);

                    die($text);
                } else {
                    $message = __("Couldn't find a local copy of the file requested.", 'duplicator');
                    echo esc_html($message);
                }
            }
        } catch (Exception $exc) {
            $result->processError($exc);
        }
    }

    /**
     * Get active package status
     *
	 * <code>
	 * //JavaScript Ajax Request
	 * Duplicator.Package.getActivePackageStatus()
	 * </code>
     */
	public function getActivePackageStatus($post)
	{
        $post = $this->postParamMerge($post);
        $nonce = sanitize_text_field($post['nonce']);
        if (!wp_verify_nonce($nonce, 'DUP_CTRL_Package_getActivePackageStatus')) {
            die('An unathorized security request was made to this page. Please try again!');
        }
		$result = new DUP_CTRL_Result($this);

		try
		{
			//CONTROLLER LOGIC
			$post  = stripslashes_deep($_POST);
            $active_package_id = DUP_Settings::Get('active_package_id');
            $package = DUP_Package::getByID($active_package_id);
            $payload = array();

            if($package != null) {
                $test = DUP_CTRL_Status::SUCCESS;

                $payload['status']  = $package->Status;
            } else {
                $test = DUP_CTRL_Status::FAILED;
            }

			//RETURN RESULT
			return $result->process($payload, $test);
		}
		catch (Exception $exc)
		{
			$result->processError($exc);
		}
    }

}
