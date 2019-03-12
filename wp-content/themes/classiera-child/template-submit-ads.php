<?php
/**
 * Template name: Submit Ad
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */

if ( !is_user_logged_in() ) {
	global $redux_demo; 
	$login = $redux_demo['login'];
	wp_redirect( $login ); exit;
}
$postTitleError = '';
$post_priceError = '';
$catError = '';
$featPlanMesage = '';
$postContent = '';
$hasError ='';
$allowed ='';
$caticoncolor="";
$classieraCatIconCode ="";
$category_icon="";
$category_icon_color="";
global $redux_demo;

//   Wang
function convertString2Array($_strValue){
	$arrTemp = explode(",", $_strValue);
	$arrRetVal = [];
	foreach ($arrTemp as $value) {
		$curVal = trim($value);
		if( $curVal != ""){
			$arrRetVal[] = $curVal;
		}
	}
	return $arrRetVal;
}
$arrRealTags = convertString2Array($redux_demo["tags-collection"]);
$arrNationality = convertString2Array($redux_demo["fieldsnationality"]);
$arrGender = convertString2Array($redux_demo["fieldsgender"]);
$arrHaircolor = convertString2Array($redux_demo["fieldshaircolor"]);
$arrEyescolor = convertString2Array($redux_demo["fieldseyescolor"]);
$arrEthnicity = convertString2Array($redux_demo["fieldsethnicity"]);
$arrHeightfeet = convertString2Array($redux_demo["fieldsheightfeet"]);
$arrHeightinches = convertString2Array($redux_demo["fieldsheightinches"]);
$arrWeight = convertString2Array($redux_demo["fieldsweight"]);
$arrBreastssize = convertString2Array($redux_demo["fieldsbreastssize"]);
$arrBreastscup = convertString2Array($redux_demo["fieldsbreastscup"]);
$arrBreaststype = convertString2Array($redux_demo["fieldsbreaststype"]);
$arrWaist = convertString2Array($redux_demo["fieldswaist"]);
$arrHips = convertString2Array($redux_demo["fieldships"]);
$arrDresssize = convertString2Array($redux_demo["fieldsdresssize"]);
$arrShoesize = convertString2Array($redux_demo["fieldsshoesize"]);
$arrPubicarea = convertString2Array($redux_demo["fieldspubicarea"]);
$arrSmoker = convertString2Array($redux_demo["fieldssmoker"]);
$arrNativelanguage = convertString2Array($redux_demo["fieldsnativelanguage"]);
$arrExtralanguage1 = convertString2Array($redux_demo["fieldsextralanguage1"]);
$arrExtralanguage1level = convertString2Array($redux_demo["fieldsextralanguage1level"]);
$arrExtralanguage2 = convertString2Array($redux_demo["fieldsextralanguage2"]);
$arrExtralanguage2level = convertString2Array($redux_demo["fieldsextralanguage2level"]);
$arrAvailabletotravel = convertString2Array($redux_demo["fieldsavailabletotravel"]);
// print_r($redux_demo);
//   Xing

$featuredADS = 0;
$primaryColor = $redux_demo['color-primary'];
$googleFieldsOn = $redux_demo['google-lat-long'];
$classieraLatitude = $redux_demo['contact-latitude'];
$classieraLongitude = $redux_demo['contact-longitude'];
$classieraAddress = $redux_demo['classiera_address_field_on'];
$postCurrency = $redux_demo['classierapostcurrency'];
$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
$termsandcondition = $redux_demo['termsandcondition'];
$classieraProfileURL = $redux_demo['profile'];
$classiera_ads_typeOn = $redux_demo['classiera_ads_type'];
$ads_length = $redux_demo['ads-length'];
	
$templateGetCredits = 'template-get-credits.php';
$classieraGetCredits = getTplPageURL($templateGetCredits);

if(isset($_POST['postTitle'])){
	//print_r($_POST);
	//print_r($_POST);die;
	if(trim($_POST['postTitle']) != '' && $_POST['classiera-main-cat-field'] != ''){		
		if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
			
			if(empty($_POST['postTitle'])){
				$postTitleError =  esc_html__( 'Please enter a title.', 'classiera' );
				$hasError = true;
			}else{
				$postTitle = trim($_POST['postTitle']);
			}
			if(empty($_POST['classiera-main-cat-field'])){
				$catError = esc_html__( 'Please select a category', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['postContent'])){
				$catError = esc_html__( 'Please enter description', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['post_tags'])){
				$catError = esc_html__( 'Please enter tag', 'classiera' );
				$hasError = true;
			}
			// if(empty($_POST['post_price'])){
			// 	$catError = esc_html__( 'Please enter price', 'classiera' );
			// 	$hasError = true;
			// }
			if(empty($_POST['post_phone'])){
				$catError = esc_html__( 'Please enter phone', 'classiera' );
				$hasError = true;
			}

			if(empty($_POST['second_phone'])){
				$catError = esc_html__( 'Please enter phone', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['nationality'])){
				$catError = esc_html__( 'Select Your Nationality', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['user_age'])){
				$catError = esc_html__( 'Select Your Age', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['hair_color'])){
				$catError = esc_html__( 'Select Your Hair Color', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['eyes_color'])){
				$catError = esc_html__( 'Select Your Eyes Color', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['ethnicity'])){
				$catError = esc_html__( 'Select Your Ethnicity', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['height_feet'])){
				$catError = esc_html__( 'Select Your Height in Feet', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['height_inches'])){
				$catError = esc_html__( 'Select Your Height in Inches', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['weight'])){
				$catError = esc_html__( 'Select Your Weight', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['breast_type'])){
				$catError = esc_html__( 'Select Your Breast Type', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['breast_size_cup'])){
				$catError = esc_html__( 'Select Your Breast Size Cup', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['breast_size'])){
				$catError = esc_html__( 'Select Your Breast Size', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['waist_size'])){
				$catError = esc_html__( 'Select Your Waist Size', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['hips_size'])){
				$catError = esc_html__( 'Select Your Hips Size', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['dress_size'])){
				$catError = esc_html__( 'Select Your Dress Size', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['shoe_size'])){
				$catError = esc_html__( 'Select Your Shoe Size', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['pubic_area'])){
				$catError = esc_html__( 'Select Pubic Area', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['smoker'])){
				$catError = esc_html__( 'Are You a Smoker', 'classiera' );
				$hasError = true;
			}
			//Step 3
			if(empty($_POST['native_language'])){
				$catError = esc_html__( 'Select Native Language', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['private_numbers'])){
				$catError = esc_html__( 'Select Option for Private Numbers', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['sms_messages'])){
				$catError = esc_html__( 'Select Option for SMS Messages', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['private_messages'])){
				$catError = esc_html__( 'Select Option for Private Messages', 'classiera' );
				$hasError = true;
			}
			//Step 4
			if(empty($_POST['disabled_friendly'])){
				$catError = esc_html__( 'Select Option for Disabled Friendly', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['drinks_supplied'])){
				$catError = esc_html__( 'Select Option for Drinks Supplied', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['showers_available'])){
				$catError = esc_html__( 'Select Option for Showers Available', 'classiera' );
				$hasError = true;
			}
			if(empty($_POST['can_travel'])){
				$catError = esc_html__( 'Select Option for Available to Travel', 'classiera' );
				$hasError = true;
			}
			
			if(empty($_FILES['upload_attachment']))
			{
				$catError = esc_html__( 'Please Select Image', 'classiera' );
				$hasError = true;
			}
			//Image Count check//
			$userIMGCount = $_POST['image-count'];
			$files = $_FILES['upload_attachment'];
			$count = $files['name'];
			$filenumber = count($count);			
			if($filenumber > $userIMGCount){
				$imageError = esc_html__( 'You selected Images Count is exceeded', 'classiera' );
				$hasError = true;
			}
			//Image Count check//

			if($hasError != true && !empty($_POST['classiera_post_type']) || isset($_POST['regular-ads-enable'])) {
				$classieraPostType = $_POST['classiera_post_type'];
				//Set Post Status//
				if(is_super_admin() ){
					$postStatus = 'publish';
				}elseif(!is_super_admin()){
					if($redux_demo['post-options-on'] == 1){
						$postStatus = 'private';
					}else{
						$postStatus = 'publish';
					}
					if($classieraPostType == 'payperpost'){
						$postStatus = 'pending';
					}
				}
				//Set Post Status//
				//Check Category//
				$classieraMainCat = $_POST['classiera-main-cat-field'];
				// $classieraChildCat = $_POST['classiera-sub-cat-field'];
				// $classieraThirdCat = $_POST['classiera_third_cat'];
				// if(empty($classieraThirdCat)){
				// 	$classieraCategory = $classieraChildCat;
				// }else{
				// 	$classieraCategory = $classieraThirdCat;
				// }
				if(empty($classieraCategory)){
					$classieraCategory = $classieraMainCat;
				}
				//print_r($classieraCategory);die;
				//Check Category//
				//Setup Post Data//
				$post_information = array(
					'post_title' => esc_attr(strip_tags($_POST['postTitle'])),			
					'post_content' => strip_tags($_POST['postContent'], '<h1><h2><h3><strong><b><ul><ol><li><i><a><blockquote><center><embed><iframe><pre><table><tbody><tr><td><video><br>'),
					'post-type' => 'post',
					'post_category' => array($classieraMainCat/*, $classieraChildCat, $classieraThirdCat*/),
					'tags_input'	=> explode(',', $_POST['post_tags']),
					'tax_input' => array(
						// 'location' => $_POST['post_location']
					),
					'comment_status' => 'open',
					'ping_status' => 'open',
					'post_status' => $postStatus
				);
				//print_r($post_information);die;
				$post_id = wp_insert_post($post_information);
				
				$featuredIMG = $_POST['classiera_featured_img'];

				/*If We are using CSC Plugin*/
				
				/*Get Country Name*/
				if(isset($_POST['post_location'])){
					$postLo = $_POST['post_location'];
					$allCountry = get_posts( array( 'include' => $postLo, 'post_type' => 'countries', 'posts_per_page' => -1, 'suppress_filters' => 0, 'orderby'=>'post__in' ) );
					foreach( $allCountry as $country_post ){
						$postCounty = $country_post->post_title;
					}
				}				
				$poststate = $_POST['post_state'];
				$postCity = $_POST['post_city'];
				
				/*If We are using CSC Plugin*/
				if(isset($_POST['categorySelect'])){
					// update_post_meta($post_id, 'categorySelect', esc_attr( $_POST['categorySelect'] ) );
					wp_set_post_categories($post_id, array($_POST['categorySelect']));
				}	
				if(isset($_POST['classiera_sub_fields'])){
					$classiera_sub_fields = $_POST['classiera_sub_fields'];
					update_post_meta($post_id, 'classiera_sub_fields', $classiera_sub_fields);
				}
				if(isset($_POST['classiera_CF_Front_end'])){
					$classiera_CF_Front_end = $_POST['classiera_CF_Front_end'];
					update_post_meta($post_id, 'classiera_CF_Front_end', $classiera_CF_Front_end);
				}
				
				
				/*  update AdsType */
				update_post_meta($post_id,'ads_type_selected',$_POST['ads_type_selected']);
				/* update AdsType */

				update_post_meta($post_id, 'post_perent_cat', $classieraMainCat, $allowed);
				
				if(isset($_POST['post_phone'])){
					update_post_meta($post_id, 'post_phone', $_POST['post_phone'], $allowed);
				}
				// Second Phone Number
				if(isset($_POST['second_phone'])){
					update_post_meta($post_id, 'second_phone', $_POST['second_phone'], $allowed);
				}
				// Nationality
				if(isset($_POST['nationality'])){
					update_post_meta($post_id, 'nationality', $_POST['nationality'], $allowed);
				}
				//User Age
				if(isset($_POST['user_age'])){
					update_post_meta($post_id, 'user_age', $_POST['user_age'], $allowed);
				}

				// Tags
				if( isset($_POST['tags'])){
					update_post_meta($post_id, 'tags', $_POST['tags'], $allowed);
				}

				//Hair Color
				if(isset($_POST['hair_color'])){
					update_post_meta($post_id, 'hair_color', $_POST['hair_color'], $allowed);
				}
				//Eyes Color
				if(isset($_POST['eyes_color'])){
					update_post_meta($post_id, 'eyes_color', $_POST['eyes_color'], $allowed);
				}
				//Ethnicity
				if(isset($_POST['ethnicity'])){
					update_post_meta($post_id, 'ethnicity', $_POST['ethnicity'], $allowed);
				}
				//Height Feet
				if(isset($_POST['height_feet'])){
					update_post_meta($post_id, 'height_feet', $_POST['height_feet'], $allowed);
				}
				//Height Inches
				if(isset($_POST['height_inches'])){
					update_post_meta($post_id, 'height_inches', $_POST['height_inches'], $allowed);
				}
				//Weight
				if(isset($_POST['weight'])){
					update_post_meta($post_id, 'weight', $_POST['weight'], $allowed);
				}
				//Breast Size
				if(isset($_POST['breast_type'])){
					update_post_meta($post_id, 'breast_type', $_POST['breast_type'], $allowed);
				}
				//Breast Size Cup
				if(isset($_POST['breast_size_cup'])){
					update_post_meta($post_id, 'breast_size_cup', $_POST['breast_size_cup'], $allowed);
				}
				//Breast Size Letters
				if(isset($_POST['breast_size'])){
					update_post_meta($post_id, 'breast_size', $_POST['breast_size'], $allowed);
				}
				//Waist Size
				if(isset($_POST['waist_size'])){
					update_post_meta($post_id, 'waist_size', $_POST['waist_size'], $allowed);
				}
				//Hips Size
				if(isset($_POST['hips_size'])){
					update_post_meta($post_id, 'hips_size', $_POST['hips_size'], $allowed);
				}
				//Dress Size
				if(isset($_POST['dress_size'])){
					update_post_meta($post_id, 'dress_size', $_POST['dress_size'], $allowed);
				}
				//Shoe Size
				if(isset($_POST['shoe_size'])){
					update_post_meta($post_id, 'shoe_size', $_POST['shoe_size'], $allowed);
				}
				//Pubic Area
				if(isset($_POST['pubic_area'])){
					update_post_meta($post_id, 'pubic_area', $_POST['pubic_area'], $allowed);
				}
				//Smoker
				if(isset($_POST['smoker'])){
					update_post_meta($post_id, 'smoker', $_POST['smoker'], $allowed);
				}
				//Native Language
				if(isset($_POST['native_language'])){
					update_post_meta($post_id, 'native_language', $_POST['native_language'], $allowed);
				}
				//Language 1
				if(isset($_POST['language_1'])){
					update_post_meta($post_id, 'language_1', $_POST['language_1'], $allowed);
				}
				//Language 2
				if(isset($_POST['language_2'])){
					update_post_meta($post_id, 'language_2', $_POST['language_2'], $allowed);
				}
				//Language 1 Level
				if(isset($_POST['language_1_level'])){
					update_post_meta($post_id, 'language_1_level', $_POST['language_1_level'], $allowed);
				}
				//Language 2 Level
				if(isset($_POST['language_2_level'])){
					update_post_meta($post_id, 'language_2_level', $_POST['language_2_level'], $allowed);
				}
				//Private Numbers
				if(isset($_POST['private_numbers'])){
					update_post_meta($post_id, 'private_numbers', $_POST['private_numbers'], $allowed);
				}
				//SMS Messages
				if(isset($_POST['sms_messages'])){
					update_post_meta($post_id, 'sms_messages', $_POST['sms_messages'], $allowed);
				}
				//Private Messages
				if(isset($_POST['private_messages'])){
					update_post_meta($post_id, 'private_messages', $_POST['private_messages'], $allowed);
				}
				//Disabled Friendly
				if(isset($_POST['disabled_friendly'])){
					update_post_meta($post_id, 'disabled_friendly', $_POST['disabled_friendly'], $allowed);
				}
				//Drinks Supplied
				if(isset($_POST['drinks_supplied'])){
					update_post_meta($post_id, 'drinks_supplied', $_POST['drinks_supplied'], $allowed);
				}
				//Showers Available
				if(isset($_POST['showers_available'])){
					update_post_meta($post_id, 'showers_available', $_POST['showers_available'], $allowed);
				}
				//Available to Travel
				if(isset($_POST['can_travel'])){
					update_post_meta($post_id, 'can_travel', $_POST['can_travel'], $allowed);
				}

				//Prices
				if(isset($_POST['fifteen_min_euro'])){
					update_post_meta($post_id, 'fifteen_min_euro', $_POST['fifteen_min_euro'], $allowed);
				}
				if(isset($_POST['fifteen_min_pound'])){
					update_post_meta($post_id, 'fifteen_min_pound', $_POST['fifteen_min_pound'], $allowed);
				}
				if(isset($_POST['thirty_min_euro'])){
					update_post_meta($post_id, 'thirty_min_euro', $_POST['thirty_min_euro'], $allowed);
				}
				if(isset($_POST['thirty_min_pound'])){
					update_post_meta($post_id, 'thirty_min_pound', $_POST['thirty_min_pound'], $allowed);
				}
				if(isset($_POST['fourty_five_min_euro'])){
					update_post_meta($post_id, 'fourty_five_min_euro', $_POST['fourty_five_min_euro'], $allowed);
				}
				if(isset($_POST['fourty_five_min_pound'])){
					update_post_meta($post_id, 'fourty_five_min_pound', $_POST['fourty_five_min_pound'], $allowed);
				}
				if(isset($_POST['one_hour_euro'])){
					update_post_meta($post_id, 'one_hour_euro', $_POST['one_hour_euro'], $allowed);
				}
				if(isset($_POST['one_hour_pound'])){
					update_post_meta($post_id, 'one_hour_pound', $_POST['one_hour_pound'], $allowed);
				}
				if(isset($_POST['full_day_euro'])){
					update_post_meta($post_id, 'full_day_euro', $_POST['full_day_euro'], $allowed);
				}
				if(isset($_POST['full_day_pound'])){
					update_post_meta($post_id, 'full_day_pound', $_POST['full_day_pound'], $allowed);
				}
				if(isset($_POST['business_date_euro'])){
					update_post_meta($post_id, 'business_date_euro', $_POST['business_date_euro'], $allowed);
				}
				if(isset($_POST['business_date_pound'])){
					update_post_meta($post_id, 'business_date_pound', $_POST['business_date_pound'], $allowed);
				}
				if(isset($_POST['gender'])){
					update_post_meta($post_id, 'gender', $_POST['gender'], $allowed);
				}
				//Images Verified
				update_post_meta($post_id, 'images_verified', $_POST['images_verified'], $allowed);
				//Age Verified
				update_post_meta($post_id, 'age_verified', $_POST['age_verified'], $allowed);

				// update_post_meta($post_id, 'classiera_ads_type', $_POST['classiera_ads_type'], $allowed);
				update_post_meta($post_id, 'classiera_ads_status', $_POST['classiera_ads_status'], $allowed);
				update_post_meta($post_id, 'classiera_ads_statustime', $_POST['classiera_ads_statustime'], $allowed);

				update_post_meta($post_id, 'post_location', wp_kses($postCounty, $allowed));
				
				update_post_meta($post_id, 'post_state', wp_kses($poststate, $allowed));
				update_post_meta($post_id, 'post_city', wp_kses($postCity, $allowed));

				if(isset($_POST['video'])){
					update_post_meta($post_id, 'post_video', $_POST['video'], $allowed);
				}
				update_post_meta($post_id, 'featured_img', $featuredIMG, $allowed);
				
				update_post_meta($post_id, 'classiera_post_type', $_POST['classiera_post_type'], $allowed);
				
				if(isset($_POST['pay_per_post_product_id'])){
					update_post_meta($post_id, 'pay_per_post_product_id', $_POST['pay_per_post_product_id'], $allowed);
				}
				if(isset($_POST['days_to_expire'])){
					$date=$_POST['days_to_expire'];
					$expired_date=date('Y-m-d H:i:s', strtotime('+'.$date.' day'));
					update_post_meta($post_id, 'days_to_expire', $expired_date, $allowed);
				}
				if($classieraPostType == 'payperpost'){
					$permalink = $classieraProfileURL;
				}else{
					$permalink = get_permalink( $post_id );
				}
				
				$current_user = wp_get_current_user();
				$userID = $current_user->ID;
				$ads_cost=$_POST['ads_cost'];

				if( $ads_cost){
					update_post_meta($post_id, 'ads_cost', $ads_cost);
				}
				
				$uw_balance=$_POST['uw_balance'];
				$balance=$uw_balance-$ads_cost;
				update_user_meta($userID,'_uw_balance',$balance);
				//If Its posting featured image//
				if(trim($_POST['classiera_post_type']) != 'classiera_regular'){
					if($_POST['classiera_post_type'] == 'payperpost'){
						//Do Nothing on Pay Per Post//
					}elseif($_POST['classiera_post_type'] == 'classiera_regular_with_plan'){
						//Regular Ads Posting with Plans//
						$classieraPlanID = trim($_POST['regular_plan_id']);
						global $wpdb;
						$current_user = wp_get_current_user();
						$userID = $current_user->ID;
						$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE id = $classieraPlanID" );
						if($result){
							$tablename = $wpdb->prefix . 'classiera_plans';
							foreach ( $result as $info ){
								$newRegularUsed = $info->regular_used +1;
								$update_data = array('regular_used' => $newRegularUsed);
								$where = array('id' => $classieraPlanID);
								$update_format = array('%s');
								$wpdb->update($tablename, $update_data, $where, $update_format);
							}
						}
					}else{
						//Featured Post with Plan Ads//
						$featurePlanID = trim($_POST['classiera_post_type']);
						global $wpdb;
						$current_user = wp_get_current_user();
						$userID = $current_user->ID;
						$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE id = $featurePlanID" );
						if ($result){
							$featuredADS = 0;
							$tablename = $wpdb->prefix . 'classiera_plans';
							foreach ( $result as $info ){
								$totalAds = $info->ads;
								if (is_numeric($totalAds)){
									$totalAds = $info->ads;
									$usedAds = $info->used;
									$infoDays = $info->days;
								}								
								if($totalAds == 'unlimited'){
									$availableADS = 'unlimited';
								}else{
									$availableADS = $totalAds-$usedAds;
								}
								if($usedAds < $totalAds && $availableADS != "0" || $totalAds == 'unlimited'){
									global $wpdb;
									$newUsed = $info->used +1;
									$update_data = array('used' => $newUsed);
									$where = array('id' => $featurePlanID);
									$update_format = array('%s');
									$wpdb->update($tablename, $update_data, $where, $update_format);
									update_post_meta($post_id, 'post_price_plan_id', $featurePlanID );

									$dateActivation = date('m/d/Y H:i:s');
									update_post_meta($post_id, 'post_price_plan_activation_date', $dateActivation );		
									
									$daysToExpire = $infoDays;
									$dateExpiration_Normal = date("m/d/Y H:i:s", strtotime("+ ".$daysToExpire." days"));
									update_post_meta($post_id, 'post_price_plan_expiration_date_normal', $dateExpiration_Normal );



									$dateExpiration = strtotime(date("m/d/Y H:i:s", strtotime("+ ".$daysToExpire." days")));
									update_post_meta($post_id, 'post_price_plan_expiration_date', $dateExpiration );
									update_post_meta($post_id, 'featured_post', "1" );
								}
							}
						}
					}
				}
				//If Its posting featured image//
				if( isset($_POST['croppedImgUrlDouble'])){
					$croppedImg = $_POST['croppedImgUrlDouble'];
					if( $croppedImg != ""){
						$file_name = basename($croppedImg);
						$fileFullPath = __DIR__ . "/temp/" . $file_name;
						$arrPath = explode("/", $fileFullPath);
						$path = "";
						for( $i = 0; $i < count($arrPath) - 4; $i++){
							$path .= $arrPath[$i] . "/";
						}
						$path .= "uploads";
						if( !file_exists($path)){
							mkdir($path, 0777);
						}
						$path .= "/" . date("Y");
						if( !file_exists($path)){
							mkdir($path, 0777);
						}
						$month = date("m");
						// if( $month < 10){
						// 	$month = "0" . $month;
						// }
						$path .= "/" . $month;
						if( !file_exists($path)){
							mkdir($path, 0777);
						}

						$path_parts = pathinfo($fileFullPath);
						$type = $path_parts['extension'];
						$ret = rename($fileFullPath, $path . "/" . $post_id . "_cropped_double." . $type);
						
						$imgPath = date("Y") . "/" . date("m") . "/" . $post_id . "_cropped_double." . $type;
						$arrUrlPath = explode("/", $_SERVER['REQUEST_URI']);
						$urlPath = "";
						for( $i = 0; $i < count($arrUrlPath) - 2; $i++){
							$urlPath .= $arrUrlPath[$i] . "/";
						}
						$urlPath .= "wp-content/uploads/" . date("Y") . "/" . $month . "/" . $post_id . "_cropped_double." . $type;
						update_post_meta($post_id, 'croppedImg_Path_double', $urlPath);
					}
				}
				if( isset($_POST['croppedImgUrl'])){
					$croppedImg = $_POST['croppedImgUrl'];
					$file_name = basename($croppedImg);
					$fileFullPath = __DIR__ . "/temp/" . $file_name;
					$arrPath = explode("/", $fileFullPath);
					$path = "";
					for( $i = 0; $i < count($arrPath) - 4; $i++){
						$path .= $arrPath[$i] . "/";
					}
					$path .= "uploads";
					if( !file_exists($path)){
						mkdir($path, 0777);
					}
					$path .= "/" . date("Y");
					if( !file_exists($path)){
						mkdir($path, 0777);
					}
					$month = date("m");
					// if( $month < 10){
					// 	$month = "0" . $month;
					// }
					$path .= "/" . $month;
					if( !file_exists($path)){
						mkdir($path, 0777);
					}

					$path_parts = pathinfo($fileFullPath);
					$type = $path_parts['extension'];
					$ret = rename($fileFullPath, $path . "/" . $post_id . "_cropped." . $type);
					
					$imgPath = date("Y") . "/" . date("m") . "/" . $post_id . "_cropped." . $type;
					$arrUrlPath = explode("/", $_SERVER['REQUEST_URI']);
					$urlPath = "";
					for( $i = 0; $i < count($arrUrlPath) - 2; $i++){
						$urlPath .= $arrUrlPath[$i] . "/";
					}
					$urlPath .= "wp-content/uploads/" . date("Y") . "/" . $month . "/" . $post_id . "_cropped." . $type;
					update_post_meta($post_id, 'croppedImg_Path', $urlPath);
				}
				if ( isset($_FILES['upload_attachment']) ) {
					$count = 0;
					$files = $_FILES['upload_attachment'];
					foreach ($files['name'] as $key => $value) {
						if ($files['name'][$key]) {
							$file = array(
								'name'	 => $files['name'][$key],
								'type'	 => $files['type'][$key],
								'tmp_name' => $files['tmp_name'][$key],
								'error'	=> $files['error'][$key],
								'size'	 => $files['size'][$key]
							);
							$_FILES = array("upload_attachment" => $file);
							
							foreach ($_FILES as $file => $array){
								$featuredimg = $_POST['classiera_featured_img'];
								if($count == $featuredimg){
									$attachment_id = classiera_insert_attachment($file,$post_id);
									set_post_thumbnail( $post_id, $attachment_id );
								}else{
									$attachment_id = classiera_insert_attachment($file,$post_id);
								}
								$count++;
							}
						}
					}/*Foreach*/
				}
				wp_redirect($permalink); exit();
			}
		}
	}else{
		if(trim($_POST['postTitle']) === '') {
			$postTitleError = esc_html__( 'Please enter a title.', 'classiera' );	
			$hasError = true;
		}
		if($_POST['classiera-main-cat-field'] === '-1') {
			$catError = esc_html__( 'Please select a category.', 'classiera' );
			$hasError = true;
		} 
	}

} 
get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$featuredUsed = null;
	$featuredAds = null;
	$regularUsed = null;
	$regularAds = null;
?>
<style type="text/css">
	.emptyRequire{
		border: 1px solid red !important;
	}
</style>
<div class="closeBump"></div>
<section class="user-pages">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-4">
				<?php get_template_part( 'templates/profile/userabout' ); ?>
			</div><!--col-lg-3 col-md-4-->
			<div class="col-lg-9 col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title text-uppercase"><?php esc_html_e('Create New Advert', 'classiera') ?><!-- <span class="pull-right custom-selected-cat"></span> --></h3>
					</div>
					<div class="panel-body">
						<?php 
						global $redux_demo;
						global $wpdb;
						$current_user = wp_get_current_user();
						$userID = $current_user->ID;			
						$featured_plans = $redux_demo['featured_plans'];
						$classieraRegularAdsOn = $redux_demo['regular-ads'];
						$postLimitOn = $redux_demo['regular-ads-posting-limit'];
						$regularCount = $redux_demo['regular-ads-user-limit'];
						$cUserCheck = current_user_can( 'administrator' );
						$role = $current_user->roles;
						$currentRole = $role[0];
						$classieraAllowPosts = false;
						$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id = $userID ORDER BY id DESC" );
						foreach ($result as $info){											
							$featuredAdscheck = $info->ads;											
							if (is_numeric($featuredAdscheck)){
								$featuredAds += $info->ads;
								$featuredUsed += $info->used;
							}
							$regularAdscheck = $info->regular_ads;
							if (is_numeric($regularAdscheck)){
								$regularAds += $info->regular_ads;
								$regularUsed += $info->regular_used;
							}
						}
						if (is_numeric($featuredAds) && is_numeric($featuredUsed)){
							$featuredAvailable = $featuredAds-$featuredUsed;
						}
						if (is_numeric($regularAds) && is_numeric($regularUsed)){
							$regularAvailable = $regularAds-$regularUsed;
						}
						
						$curUserargs = array(					
							'author' => $user_ID,
							'post_status' => array('publish', 'pending', 'draft', 'private', 'trash')	
						);
						$countPosts = count(get_posts($curUserargs));
						if($currentRole == "administrator"){
							$classieraAllowPosts = true;
						}else{
							if($postLimitOn == true){
								if($regularAvailable == 0 && $featuredAvailable == 0 && $countPosts >= $regularCount){
									$classieraAllowPosts = false;
								}else{
									$classieraAllowPosts = true;
								}
							}else{
								$classieraAllowPosts = true;
							}
						}				
						if($classieraAllowPosts == false){
							?>
							<div class="alert alert-warning" role="alert">
							  <strong><?php esc_html_e('Hello.', 'classiera') ?></strong><?php esc_html_e('You Ads Posts limit are exceeded, Please Purchase a Plan for posting More Ads.', 'classiera') ?>&nbsp;&nbsp;<a class="btn btn-primary btn-sm" href="<?php echo esc_url( $featured_plans ); ?>"><?php esc_html_e('Purchase Plan', 'classiera') ?></a>
							</div>
							<?php
						}elseif($classieraAllowPosts == true){
						?>
						
						<div class="submit-post clearfix">
							<form class="form-horizontal" id="primaryPostForm" method="POST" data-toggle="validator" enctype="multipart/form-data">
								<!-- Advert types -->
							  	<div id="section_type">
									<!-- <h5 style="text-align: center;"><?php echo $redux_demo['my-ads-heading'];?></h5> -->
									<!-- <p><?php echo $redux_demo['my-ads-body-text'];?></p> -->
									<div class="row credit-packages">
										<div class="col-sm-12 col-md-4">
											<div class="thumbnail">
											  <img src="<?php echo $redux_demo['standardads-media']['url']; ?>" alt="<?php esc_html_e($redux_demo['standard-sec-title'], 'classiera'); ?>">
											  <div class="caption">
												<h3><?php esc_html_e($redux_demo['standard-sec-title'], 'classiera'); ?></h3>
												<p><?php esc_html_e($redux_demo['standard-sec-desc'], 'classiera'); ?></p>
												<p><a href="javascript:void(0)" id="standard" class="btn btn-primary btn-block post_adverts" role="button">Post Advert</a></p>
											  </div>
											</div>
										</div>
										<div class="col-sm-12 col-md-4">
											<div class="thumbnail">
											  <img src="<?php echo $redux_demo['standardads-top-media']['url']; ?>" alt="<?php esc_html_e($redux_demo['standard-sec-title'], 'classiera'); ?>">
											  <div class="caption">
												<h3><?php esc_html_e($redux_demo['standard-top-sec-title'], 'classiera'); ?></h3>
												<p><?php esc_html_e($redux_demo['standard-top-sec-desc'], 'classiera'); ?></p>
												<p><a href="javascript:void(0)" id="standard_top" class="btn btn-primary btn-block post_adverts" role="button">Post Advert</a></p>
											  </div>
											</div>
										</div>
										<div class="col-sm-12 col-md-4">
											<div class="thumbnail">
											  <img src="<?php echo $redux_demo['doubleads-media']['url']; ?>" alt="<?php esc_html_e($redux_demo['double-sec-title'], 'classiera'); ?>">
											  <div class="caption">
												<h3><?php esc_html_e($redux_demo['double-sec-title'], 'classiera'); ?></h3>
												<p><?php esc_html_e($redux_demo['double-sec-desc'], 'classiera'); ?></p>
												<p><a href="javascript:void(0)" id="double_sec" class="btn btn-primary btn-block post_adverts" role="button">Post Advert</a></p>
											  </div>
											</div>
										</div>
										<div class="col-sm-12 col-md-4">
											<div class="thumbnail">
											  <img src="<?php echo $redux_demo['doublesize-media']['url']; ?>" alt="<?php esc_html_e($redux_demo['doublesize-sec-title'], 'classiera'); ?>">
											  <div class="caption">
												<h3><?php esc_html_e($redux_demo['doublesize-sec-title'], 'classiera'); ?></h3>
												<p><?php esc_html_e($redux_demo['doublesize-sec-desc'], 'classiera'); ?></p>
												<p><a href="javascript:void(0)" id="double_top" class="btn btn-primary btn-block post_adverts" role="button">Post Advert</a></p>
											  </div>
											</div>
										</div>
									</div>
								</div>
								<!-- / Advert types -->

								<div id="smartwizard" style="display: none;" class="container-fluid">

									<ul class="nav nav-pills">
										<li><a href="#step-1"><?php esc_html_e('About Me', 'classiera'); ?></a></li>
										<li><a href="#step-2"><?php esc_html_e('Appearance', 'classiera'); ?></a></li>
										<li><a href="#step-3"><?php esc_html_e('Communication', 'classiera'); ?></a></li>
										<li><a href="#step-4"><?php esc_html_e('Facilities', 'classiera'); ?></a></li>
										<li><a href="#step-5"><?php esc_html_e('Location', 'classiera'); ?></a></li>
										<li><a href="#step-6"><?php esc_html_e('Image', 'classiera'); ?></a></li>
										<li><a href="#step-7"><?php esc_html_e('Gallery', 'classiera'); ?></a></li>
										<li><a href="#step-8"><?php esc_html_e('Prices', 'classiera'); ?></a></li>
										<li><a href="#step-9"><?php esc_html_e('Publish', 'classiera'); ?></a></li>
									</ul>
								 
									<div class="step-container clearfix">
										<?php
											// $post_id = 955;
											// $queried_post = get_post_meta($post_id);
											// print_r($queried_post);
										?>

										<!-- Begin Step-1 -->
										<div id="step-1">
											<div class="row">
												<div class="col-lg-12">
													<h3 class="text-center" style="margin-bottom: 30px;"><?php esc_html_e('About Me', 'classiera') ?></h3>
												</div>

												<div class="col-sm-12 col-lg-6">
													<div class="form-group">
														<!-- Start Gender -->
														<select name="gender">
															<option value="" selected="" disabled><?php esc_html_e('Select Your Gender', 'classiera'); ?></option>
															<?php foreach ($arrGender as $value) { ?>
																<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php } ?>
														</select>
														<!-- End Gender Field -->
														
														<!--Category-->
														<select id="categorySelect" name="categorySelect" required>
															<option value="" selected disabled><?php esc_html_e('Choose Your Category', 'classiera'); ?></option>
															<?php 
																$categories = get_terms('category', array(
																'hide_empty' => 0,
																'parent' => 0,
																'order'=> 'ASC'
																) 
															);
															foreach ($categories as $category){
																//print_r($category);
																$tag = $category->term_id;
																$classieraCatFields = get_option(MY_CATEGORY_FIELDS);
															if (isset($classieraCatFields[$tag])){
																$classieraCatIconCode = $classieraCatFields[$tag]['category_icon_code'];
																$classieraCatIcoIMG = $classieraCatFields[$tag]['your_image_url'];
																$classieraCatIconClr = $classieraCatFields[$tag]['category_icon_color'];
															}
															if (empty($classieraCatIconClr)){
																$iconColor = $primaryColor;
															} else {
																$iconColor = $classieraCatIconClr;
															}
																$category_icon = stripslashes($classieraCatIconCode);
															?>
															<option value="<?php echo esc_attr( $tag ); ?>"><?php echo esc_html(get_cat_name( $tag )); ?></option>
															<?php } ?>
														</select><!--list-unstyled-->														
														<input type="hidden" name="adstype_price" value="2" id="adstype_price">
														<input class="classiera-main-cat-field" name="classiera-main-cat-field" type="hidden" value="">
														<!--Category-->
														<!-- Nickname -->
														<div class="form-group has-error has-danger">
															<input id="title" data-minlength="1" name="postTitle" type="text" class="form-control form-control-md" placeholder="<?php esc_html_e('Your Nickname', 'classiera') ?>" required>
														</div>
														<input  value="1" type="hidden" name="classiera_ads_status">
														<input  value="1" type="hidden" name="classiera_ads_statustime">
														<!-- / Nickname -->
														<!-- Age -->
														<input id="age" name="user_age" type="text" class="form-control form-control-md" placeholder="<?php esc_html_e('Enter Your Age', 'classiera') ?>" required>
														<input type="hidden" name="age_verified" id="age_verified" value="0">
														<!-- / Age -->
													</div><!-- / Form group -->
												</div><!-- / col-sm-12 col-lg-6 -->
												

												<div class="col-sm-12 col-lg-6">
													<!--ContactPhone 1-->
													<div class="form-group">
														<input type="number" name="post_phone" class="form-control form-control-md" placeholder="<?php esc_html_e('Enter your Mobile Number', 'classiera') ?>" required>
														<input type="number" name="second_phone" class="form-control form-control-md" placeholder="<?php esc_html_e('Enter your Second Mobile Number', 'classiera') ?>"> 
														<select name="nationality" required>
															<option value="" selected disabled><?php esc_html_e('Select Your Nationality', 'classiera'); ?></option>
															<?php
																foreach ($arrNationality as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select> 
													</div>
													<!-- / ContactPhone 1-->													
													<!-- <div class="classieraExtraFields" style="display:none;"></div> -->
												</div>

												<div class="col-sm-12">
													<div class="form-group">
														<textarea name="postContent" id="description" class="form-control" data-error="<?php esc_html_e('Write description', 'classiera') ?>" required placeholder="<?php esc_html_e('About myself...', 'classiera'); ?>"></textarea>
														<!-- Keywords Field -->
														<!-- <input id="fav-tags" type="text" name="post_tags" class="form-control form-control-md" placeholder="<?php esc_html_e('enter keywords for better search..!', 'classiera') ?>"> -->
														<!-- / Keywords Field -->
													</div><!--Ad description-->
												</div>

												<div class="col-sm-12">
													<div class="form-group">
														<input type="hidden" name="tags">
														<div style="margin-bottom: 20px;">
															<?php
															foreach ($arrRealTags as $value) {
															?>
															<div class="tagBtn btn btn-primary" onclick="TagClicked(this)"><?=$value?></div>
															<?php
															}
															?>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- End Step-1 -->
										<!-- Begin Step-2 -->
										<div id="step-2">
											<div class="row">
												<div class="col-lg-12">
													<h3 class="text-center" style="margin-bottom: 30px;"><?php esc_html_e('Appearance', 'classiera'); ?></h3>
												</div>
												<div class="col-sm-12 col-lg-6">
													<div class="form-group">
														<select name="hair_color" required>
															<option value="" disabled selected><?php esc_html_e('Hair Color', 'classiera'); ?></option>
															<?php
															foreach ($arrHaircolor as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

														<select name="eyes_color" required>
															<option value="" disabled selected><?php esc_html_e('Eyes Color', 'classiera'); ?></option>
															<?php
															foreach ($arrEyescolor as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

														<select name="ethnicity" required>
															<option value="" disabled selected><?php esc_html_e('Ethnicity', 'classiera'); ?></option>
															<?php
															foreach ($arrEthnicity as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

														<span class="pre-heading"><?php esc_html_e('Height', 'classiera'); ?>:</span>
														<select name="height_inches" class="third-size pull-right" required>
															<option value="" disabled selected><?php esc_html_e('Inches', 'classiera'); ?></option>
															<?php
															foreach ($arrHeightinches as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?>"</option>
															<?php
															}
															?>
														</select>
														<select name="height_feet" class="third-size pull-right add-margin" required>
															<option value="" disabled selected><?php esc_html_e('Feet', 'classiera'); ?></option>
															<?php
															foreach ($arrHeightfeet as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>
														

														<select name="weight" required>
															<option value="" selected disabled><?php esc_html_e('Weight in Kilograms', 'classiera'); ?></option>
															<?php
															foreach ($arrWeight as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

														<span class="pre-heading"><?php esc_html_e('Breast Type', 'classiera'); ?>:</span>
														<select name="breast_type" class="fifth-size pull-right" required>
															<option value="" disabled selected><?php esc_html_e('Type', 'classiera'); ?></option>
															<?php
															foreach ($arrBreaststype as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>
														<select name="breast_size_cup" class="fifth-size pull-right add-margin" required>
															<option value="" disabled selected><?php esc_html_e('Cup', 'classiera'); ?></option>
															<?php
															foreach ($arrBreastscup as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>
														<select name="breast_size" class="fifth-size pull-right add-margin" required>
															<option value="" disabled selected><?php esc_html_e('Size', 'classiera'); ?></option>
															<?php
															foreach ($arrBreastssize as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>
														<!-- Begin Gender Field -->
														<select name="breast_size" class="fifth-size pull-right add-margin" required>
															<option value="" disabled selected><?php esc_html_e('Size', 'classiera'); ?></option>
															<?php
															foreach ($arrBreastssize as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>
														<!-- End Gender Field -->
													</div>
												</div>
												<div class="col-sm-12 col-lg-6">
													<div class="form-group">
														<select name="waist_size" required>
															<option selected disabled><?php esc_html_e('Waist Size in Inches', 'classiera'); ?></option>
															<?php
															foreach ($arrWaist as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?>"</option>
															<?php
															}
															?>
														</select>

														<select name="hips_size" required>
															<option value="" selected disabled><?php esc_html_e('Hips Size in Inches', 'classiera'); ?></option>
															<?php
															foreach ($arrHips as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?>"</option>
															<?php
															}
															?>
														</select>

														<select name="dress_size" required>
															<option value="" selected disabled><?php esc_html_e('Dress Size', 'classiera'); ?></option>
															<?php
															foreach ($arrDresssize as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

														<select name="shoe_size" required>
															<option value="" selected disabled><?php esc_html_e('Shoe Size (UK Size)', 'classiera'); ?></option>
															<?php
															foreach ($arrShoesize as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

														<select name="pubic_area" required>
															<option selected disabled><?php esc_html_e('Pubic Area', 'classiera'); ?></option>
															<?php
															foreach ($arrPubicarea as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

														<select name="smoker" required>
															<option value="" selected disabled><?php esc_html_e('Are You a Smoker?', 'classiera'); ?></option>
															<?php
															foreach ($arrSmoker as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

													</div>
												</div>
											</div>
										</div>
										<!-- End Step-2 -->
										<!-- Begin Step-3 -->
										<div id="step-3">
											<div class="row">
												<div class="col-lg-12">
												  <h3 class="text-center" style="margin-bottom: 30px;"><?php esc_html_e('Communication', 'classiera'); ?></h3>
												</div>
												<div class="col-sm-12 col-lg-6">
													<div class="form-group">
														<select name="native_language" required>
															<option value="" selected disabled><?php esc_html_e('Native Language', 'classiera'); ?></option>
															<?php
															foreach ($arrNativelanguage as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

														<select name="language_1_level" class="fit-two-fields pull-right">
															<option value="" disabled selected><?php esc_html_e('Select Level', 'classiera'); ?></option>
															<?php
															foreach ($arrExtralanguage1level as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

														<select name="language_1" class="fit-two-fields pull-right add-margin">
															<option value="" selected disabled><?php esc_html_e('Additional Language', 'classiera'); ?></option>
															<?php
															foreach ($arrExtralanguage1 as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

														<select name="language_2_level" class="fit-two-fields pull-right">
															<option value="" disabled selected><?php esc_html_e('Select Level', 'classiera'); ?></option>
															<?php
															foreach ($arrExtralanguage2level as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>

														<select name="language_2" class="fit-two-fields pull-right add-margin">
															<option selected disabled><?php esc_html_e('Additional Language', 'classiera'); ?></option>
															<?php
															foreach ($arrExtralanguage2 as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>
													</div>
												</div>
												<div class="col-sm-12 col-lg-6">
													<div class="form-group"><!-- Form Group Container -->
														<select name="private_numbers" required>
															<option value="" selected disabled><?php esc_html_e('Accept Private Numbers', 'classiera'); ?></option>
															<option value="Yes"><?php esc_html_e('Yes', 'classiera'); ?></option>
															<option value="No"><?php esc_html_e('No', 'classiera'); ?></option>
														</select>

														<select name="sms_messages" required>
															<option selected disabled><?php esc_html_e('Accept SMS Messages', 'classiera'); ?></option>
															<option value="Yes"><?php esc_html_e('Yes', 'classiera'); ?></option>
															<option value="No"><?php esc_html_e('No', 'classiera'); ?></option>
														</select>

														<select name="private_messages" required>
															<option selected disabled><?php esc_html_e('Respond to Private Messages', 'classiera'); ?></option>
															<option value="Yes"><?php esc_html_e('Yes', 'classiera'); ?></option>
															<option value="No"><?php esc_html_e('No', 'classiera'); ?></option>
														</select>
													</div><!-- / Form Group Container -->
												</div>
											</div>
										</div>
										<!-- End Step-3 -->
										<!-- Begin Step-4 -->
										<div id="step-4">
											<div class="row">
												<div class="col-lg-12">
													<h3 class="text-center" style="margin-bottom: 30px;"><?php esc_html_e('Facilities', 'classiera'); ?></h3>
												</div>
												<div class="col-sm-12 col-lg-6">
													<div class="form-group">
														<select name="disabled_friendly" required>
															<option value="" selected disabled><?php esc_html_e('Disabled Friendly', 'classiera'); ?></option>
															<option value="Yes"><?php esc_html_e('Yes', 'classiera'); ?></option>
															<option value="No"><?php esc_html_e('No', 'classiera'); ?></option>
														</select>

														<select name="drinks_supplied" required>
															<option value="" selected disabled><?php esc_html_e('Drinks Supplied', 'classiera'); ?></option>
															<option value="Yes"><?php esc_html_e('Yes', 'classiera'); ?></option>
															<option value="No"><?php esc_html_e('No', 'classiera'); ?></option>
														</select>
													</div>
												</div>

												<div class="col-sm-12 col-lg-6">
													<div class="form-group">
														<select name="showers_available" required>
															<option value="" selected disabled><?php esc_html_e('Showers Available', 'classiera'); ?></option>
															<option value="Yes"><?php esc_html_e('Yes', 'classiera'); ?></option>
															<option value="No"><?php esc_html_e('No', 'classiera'); ?></option>
														</select>

														<select name="can_travel" required>
															<option value="" selected disabled><?php esc_html_e('Available to Travel', 'classiera'); ?></option>
															<?php
															foreach ($arrAvailabletotravel as $value) {
															?>
															<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
															<?php
															}
															?>
														</select>
													</div>
												</div>
											</div>
										</div>
										<!-- End Step-4 -->
										<!-- Begin Step-5 -->
										<div id="step-5">
											<div class="row">
												<div class="col-lg-12"><!-- Heading Container -->
													<h3 class="text-center" style="margin-bottom: 30px;"><?php esc_html_e('Location', 'classiera'); ?></h3><!-- Heading -->
												</div><!--  / Heading Container -->
												<div class="col-sm-12 col-lg-6">
													<!-- post location -->
													<?php
														$classiera_ad_location_remove = $redux_demo['classiera_ad_location_remove'];
														if($classiera_ad_location_remove == 1){ ?>
														<?php 
															$args = array(
																'post_type' => 'countries',
																'posts_per_page'   => -1,
																'orderby'		  => 'title',
																'order'			=> 'ASC',
																'post_status'	  => 'publish',
																'suppress_filters' => false 
														);
														$country_posts = get_posts($args);
														if(!empty($country_posts)){
														?>
															<!--Select Country-->
															<div class="form-group">
																<select name="post_location" id="post_location" required>
																	<option value="-1" selected disabled><?php esc_html_e('Select Country', 'classiera'); ?></option>
																	<?php foreach( $country_posts as $country_post ){ ?>
																		<option value="<?php echo esc_attr( $country_post->ID ); ?>"><?php echo esc_html( $country_post->post_title ); ?></option>
																	<?php } ?>
																</select>
															<?php } ?>
															<!--Select Country--> 
															<!--Select States-->
															<?php 
															$locationsStateOn = $redux_demo['location_states_on'];
															if($locationsStateOn == 1){
															?>
																<select name="post_state" id="post_state" class="selectState" required>
																	<option value=""><?php esc_html_e('Select State', 'classiera'); ?></option>
																</select>
															<?php } ?>
															<!--Select States-->
															<!--Select City-->
															<?php 
															$locationsCityOn= $redux_demo['location_city_on'];
															if($locationsCityOn == 1){
															?>
																<select name="post_city" id="post_city" class="selectCity" required>
																	<option value=""><?php esc_html_e('Select City', 'classiera'); ?></option>
																</select>
															</div>
															<?php } ?>
															<!--Select City-->
															<!--Address-->
															<?php if($classieraAddress == 1){?>
															<div class="form-group">
															  <label class="col-sm-3 text-left flip"><?php esc_html_e('Address', 'classiera'); ?> : <span>*</span></label>
															  <div class="col-sm-9">
																  <input id="address" type="text" name="address" class="form-control form-control-md" placeholder="<?php esc_html_e('Address or City', 'classiera') ?>">
															  </div>
														  	</div>
															<?php } ?>
															<!--Address-->
												  	<?php } ?>
												</div>
											</div>
										</div>
										<!-- End Step-5 -->
										<!-- Begin Step-6 -->
										<div id="step-6">
											<div class="row">
											   	<div class="col-lg-12">
												  <h3 class="text-center" style="margin-bottom: 30px;"><?php esc_html_e('Main Advert Image', 'classiera'); ?></h3>
												</div>
												<div class="col-sm-12">
												<?php			   
												  /*Image Count Check*/
												  global $redux_demo;
												  global $wpdb;
												  $paidIMG = $redux_demo['premium-ads-limit'];
												  $regularIMG = $redux_demo['regular-ads-limit'];			   
												  $current_user = wp_get_current_user();
												  $userID = $current_user->ID;
												  $result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id = $userID ORDER BY id DESC" );
												  $totalAds = 0;
												  $usedAds = 0;
												  $availableADS = '';
												  if(!empty($result)){
													foreach ( $result as $info ){
													  $availAds = $info->ads;
													  if (is_numeric($availAds)) {
														$totalAds += $info->ads;
														$usedAds += $info->used;
													  }
													}
												  }
												  $availableADS = $totalAds-$usedAds;
												  if($availableADS == "0" || empty($result)){
													$imageLimit = $regularIMG;
												  }else{
													$imageLimit = $paidIMG;
												  }
												  if($currentRole == "administrator"){
													$imageLimit = $paidIMG;
												  }
												if($imageLimit != 0){ 
												?>
												<div class="form-main-section media-detail">
													<div class="form-group">
														<div class="col-lg-12">
															<div class="row">
																<div class="col-sm-12 col-lg-12" style="margin-bottom: 20px;">
																	<input type="hidden" name="croppedImgUrl" id="croppedImgUrl">
																	<div id="croppic" style="margin: 0 auto" originalW="255" originalH="343"></div>
																</div>
																<div class="col-sm-12 col-lg-12" style="margin-bottom: 20px;">
																	<input type="hidden" name="croppedImgUrlDouble" id="croppedImgUrlDouble">
																	<div id="croppic-double" style="margin: 0 auto" originalW="510" originalH="343"></div>
																</div>
															</div>
														</div>
													</div>
												</div>
											  	<?php } ?>
											  	<!-- add photos and media -->
												</div>
											</div>
										</div>
										<!-- End Step-6 -->
										<!-- Begin step-7 -->
										<div id="step-7">
											<div class="row">
												<div class="col-lg-12">
													<h3 class="text-center" style="margin-bottom: 30px;"><?php esc_html_e('Image Gallery', 'classiera'); ?></h3>
												</div>
												<div class="form-main-section media-detail">
													<div class="form-group">
														<div class="col-sm-12">
															<div class="classiera-dropzone-heading">
																<div class="classiera-dropzone-heading-text">
																	<p><?php esc_html_e('Select files to Upload', 'classiera') ?></p>
																	<p><?php esc_html_e('You can add multiple images. Ads With photo get 50% more Responses', 'classiera') ?></p>
																	<p class="limitIMG"><?php esc_html_e('You can upload', 'classiera') ?>&nbsp;<?php echo esc_attr( $imageLimit ); ?>&nbsp;<?php esc_html_e('Images maximum.', 'classiera') ?></p>
																</div>
															</div>
															<!-- HTML heavily inspired by http://blueimp.github.io/jQuery-File-Upload/ -->
															<div id="mydropzone" class="classiera-image-upload clearfix" data-maxfile="<?php echo esc_attr( $imageLimit ); ?>">
															<!--Imageloop-->
															<?php 
															for ($i = 0; $i < $imageLimit; $i++){
															?>
																<div class="classiera-image-box">
																	<div class="classiera-upload-box">
																		<input name="image-count" type="hidden" value="<?php echo esc_attr( $imageLimit ); ?>" />
																		<input class="classiera-input-file imgInp" id="imgInp<?php echo esc_attr( $i ); ?>" type="file" name="upload_attachment[]">
																		<label class="img-label" for="imgInp<?php echo esc_attr( $i ); ?>"><i class="fas fa-plus-square"></i></label>
																		<div class="classiera-image-preview">
																			<img class="my-image" src=""/>
																			<span class="remove-img"><i class="fas fa-times-circle"></i></span>
																		</div>
																	</div>
																</div>
															<?php } ?>
																<input type="hidden" name="classiera_featured_img" id="classiera_featured_img" value="0">
																<input type="hidden" name="images_verified" id="images_verified" value="0">
															<!--Imageloop-->
														  </div>
														  <?php 
														  $classiera_video_postads = $redux_demo['classiera_video_postads'];
														  if($classiera_video_postads == 1){
														  ?>
															<div class="iframe">
																<div class="iframe-heading">
																	<i class="fa fa-video-camera"></i>
																	<span><?php esc_html_e('Put here iframe or video url.', 'classiera') ?></span>
																</div>
																<textarea class="form-control" name="video" id="video-code" placeholder="<?php esc_html_e('Put here iframe or video url.', 'classiera') ?>"></textarea>
																<div class="help-block">
																	<p><?php esc_html_e('Add iframe or video URL (iframe 710x400) (youtube, vimeo, etc)', 'classiera') ?></p>
																</div>
															</div>
														  <?php } ?>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- End Step-7 -->
										<!-- Begin step-8 -->
										<div id="step-8">
											<div class="row">

												<div class="col-sm-12">
													<div class="form-group">
														<div class="row">
															<h3 class="text-center" style="margin-bottom: 30px;"><?php esc_html_e('Price Fields', 'classiera'); ?></h3><!-- Heading -->
															<div id="toggle">
																<input type="checkbox" name="checkbox1" id="checkbox3" class="ios-toggle" checked/>
																<label for="checkbox3" class="checkbox-label" data-off="Prices Off" data-on="Prices On"></label>
															</div>
														</div><!-- / Row -->
														<p class="price-info" style="display: none;"><?php esc_html_e('I do not wish to disclose price information!', 'classiera'); ?></p>
													</div>
												</div>

												<div class="col-sm-12 col-lg-6"><!-- Form Container -->
													<div class="form-group price-fields"><!-- Form Group Container -->
														<div class="row">
															<span class="pre-heading"><?php esc_html_e('15 Minutes', 'classiera'); ?>:</span>
															<input name="fifteen_min_pound" type="number" class="form-control quarter-size pull-right" placeholder="Price in &pound;">
															<input name="fifteen_min_euro" type="number" class="form-control quarter-size pull-right add-margin" placeholder="Price in &euro;">
														</div>
														<div class="row">
															<span class="pre-heading"><?php esc_html_e('30 Minutes', 'classiera'); ?>:</span>
															<input name="thirty_min_pound" type="number" class="form-control quarter-size pull-right" placeholder="Price in &pound;">
															<input name="thirty_min_euro" type="number" class="form-control quarter-size pull-right add-margin" placeholder="Price in &euro;">
														</div>
														<div class="row">
															<span class="pre-heading"><?php esc_html_e('45 Minutes', 'classiera'); ?>:</span>
															<input name="fourty_five_min_pound" type="number" class="form-control quarter-size pull-right" placeholder="Price in &pound;">
															<input name="fourty_five_min_euro" type="number" class="form-control quarter-size pull-right add-margin" placeholder="Price in &euro;">
														</div>
													</div><!-- / Form Group Container -->
												</div><!--  / Form Container -->

												<div class="col-sm-12 col-lg-6"><!-- Form Container -->
													<div class="form-group price-fields"><!-- Form Group Container -->
														<div class="row">
															<span class="pre-heading"><?php esc_html_e('', 'classiera'); ?><?php esc_html_e('1st Hour', 'classiera'); ?>:</span>
															<input name="one_hour_pound" type="number" class="form-control quarter-size pull-right" placeholder="Price in &pound;">
															<input name="one_hour_euro" type="number" class="form-control quarter-size pull-right add-margin" placeholder="Price in &euro;">
														</div>
														<div class="row">
															<span class="pre-heading"><?php esc_html_e('', 'classiera'); ?><?php esc_html_e('Full Day', 'classiera'); ?>:</span>
															<input name="full_day_pound" type="number" class="form-control quarter-size pull-right" placeholder="Price in &pound;">
															<input name="full_day_euro" type="number" class="form-control quarter-size pull-right add-margin" placeholder="Price in &euro;">
														</div>
														<div class="row">
															<span class="pre-heading"><?php esc_html_e('', 'classiera'); ?><?php esc_html_e('Business Date', 'classiera'); ?>:</span>
															<input name="business_date_pound" type="number" class="form-control quarter-size pull-right" placeholder="Price in &pound;">
															<input name="business_date_euro" type="number" class="form-control quarter-size pull-right add-margin" placeholder="Price in &euro;">
														</div>
													</div><!-- / Form Group Container -->
												</div>

											</div>
										</div>
										<!-- End step-8 -->
										<!-- Begin step-9 -->
										<div id="step-9">
											<div class="row">

												<div class="col-lg-12">
													<h3 class="text-center" style="margin-bottom: 30px;"><?php esc_html_e('Publish Advert', 'classiera'); ?></h3>
												</div>
												
										   		<div class="col-sm-12 col-lg-6">
													<!--Select Ads Type-->
													<?php 
													$totalAds = '';
													$usedAds = '';
													$availableADS = '';
													$planCount = 0;		   
													$regular_ads = $redux_demo['regular-ads'];
													$classieraRegularAdsDays = $redux_demo['ad_expiry'];
													$current_user = wp_get_current_user();
													$userID = $current_user->ID;
													$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id = $userID ORDER BY id DESC" );
													?>
														
															
													<select name="ads_length" id="ads_length" class="form-control form-control-md" required>
														<option value="0"><?php esc_html_e('1 Day', 'classiera') ?></option>
														<option value="1"><?php esc_html_e('3 Days', 'classiera') ?></option>
														<option value="2"><?php esc_html_e('7 Days', 'classiera') ?></option>
														<option value="3"><?php esc_html_e('30 Days', 'classiera') ?></option>
													</select>

											
													<input type="hidden" class="regular_plan_id" name="regular_plan_id" value="0">
													<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
													<input type="hidden" name="submitted" id="submitted" value="true">
											   	</div><!-- col-sm-12 -->

											   	<div class="col-sm-12 col-lg-6"><!-- Cost of Advert -->
											   		<div class="form-group">
											   			<div class="cost-container">

												   			<?php
															$uw_balance=get_user_meta(get_current_user_id(),'_uw_balance',true);
															$standard_top_sec_price=$redux_demo['standard-top-sec-price'];
															$count_stand_top=count($standard_top_sec_price);
															$cc=1;
															echo '<span class="cost-credit-title text-uppercase">Credits';
															echo '</span>';
															foreach ($standard_top_sec_price as $key => $value) {
															echo '<span id="standard_top-ads_cost-'.$key.'" class="ad_price_cost standard_top">';
															esc_html_e($value,'classiera'); echo '</span>';
															echo '<input type="hidden" id="standard_top-ads_cost_change-'.$key.'" class="ad_price_cost" value="'.$value.'">';
															}

															$double_sec_price=$redux_demo['double-sec-price'];
															$count_double_sec=count($double_sec_price);
															$cc=1;
															foreach ($double_sec_price as $key => $value) {
															echo '<span id="double_sec-ads_cost-'.$key.'" class="ad_price_cost double_sec">';
															esc_html_e($value,'classiera'); echo '</span>';
															echo '<input type="hidden" id="double_sec-ads_cost_change-'.$key.'" class="ad_price_cost" value="'.$value.'">';
															}

															$standard_sec_price=$redux_demo['standard-sec-price'];
															$count_standard_sec=count($standard_sec_price);
															$cc=1;
															foreach ($standard_sec_price as $key => $value) {
															echo '<span id="standard-ads_cost-'.$key.'" class="ad_price_cost standard">';
															esc_html_e($value,'classiera'); echo '</span>';
															echo '<input type="hidden" id="standard-ads_cost_change-'.$key.'" class="ad_price_cost" value="'.$value.'">';
															}

															$double_top_price=$redux_demo['double-top-sec-price'];
															$count_double_top=count($double_top_price);
															$cc=1;
															foreach ($double_top_price as $key => $value) {
															echo '<span id="double_top-ads_cost-'.$key.'" class="ad_price_cost double_top">';
															esc_html_e($value,'classiera'); echo '</span>';
															echo '<input type="hidden" id="double_top-ads_cost_change-'.$key.'" class="ad_price_cost" value="'.$value.'">';
															}

															?>
															<input type="hidden" id="ads_type_selected" name="ads_type_selected" value="" />
															<input type="hidden" id="ads_cost" name="ads_cost" value="" />
															<input type="hidden" name="uw_balance" id="uw_balance" value="<?php echo get_user_meta(get_current_user_id(),'_uw_balance',true);?>">
															<input type="hidden" name="classiera_post_type" value="classiera_regular">
															<input type="hidden" name="regular-ads-enable" value=no""  >
															<input type="hidden" id="days_to_expire" name="days_to_expire" value="1">
															<!--Select Ads Type-->
														</div>
											   		</div>
											   	</div><!-- Cost of advert -->

											   	<div class="col-sm-12 col-lg-6 tcs-container">
											   		<button type="button" class="btn btn-primary extra-padding post-advert-btn" id="beforeupdatecheck" disabled="false" data-toggle="modal" data-target="#myModal"><?php esc_html_e('Publish Advert', 'classiera') ?></button>
										   			<p class="tcs-info"><?php esc_html_e('By clicking "Post Advert", you agree to our', 'classiera') ?>
										   				<a href="<?php echo esc_url($termsandcondition); ?>" target="_blank"><?php esc_html_e('Terms of Use', 'classiera') ?></a>
										   				<?php esc_html_e('and acknowledge that you are the rightful owner of this item', 'classiera') ?>
										   			</p>
											   	</div>

											   	<!-- Credits modal -->
											   	<div id="myModal" class="modal fade" role="dialog">
											   		<div class="modal-dialog">
											   			<div class="modal-content">
											   				<div class="modal-header">
											   					<button type="button" class="close" data-dismiss="modal">&times;</button>
											   					<h4 class="modal-title"></h4>
											   				</div>
											   				<div class="modal-body">
											   					<p class="modal-body-info"></p>
											   				</div>
											   				<div class="modal-footer">
											   				</div>
											   			</div>
											   		</div>
											   	</div>
											   	<!-- Credits Modal -->


										   	</div><!-- Row -->
										</div>
										<!-- End step-9 -->
									</div>
								</div><!-- / Smart Wizard Content -->

								<div class="col-sm-12">
									<div class="progress" style="display: none;">
									  <div id="current-progress" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="0%">
										<span class="sr-only">0% Complete</span>
									  </div>
									</div>
								</div>
							</form>
						</div>
						<!-- / Smart Wizard Content -->

						<!--submit-post-->
						<?php } ?>
					</div>
				</div>
			</div><!--col-lg-9 col-md-8 user-content-heigh-->
		</div><!--row-->
	</div><!--container-->
</section><!--user-pages-->
<?php endwhile; ?>

<div class="loader_submit_form">
	<img src="<?php echo get_template_directory_uri().'/images/loader180.gif' ?>">
</div>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri();?>/js/smartWizard.js"></script>
<script>
	jQuery(document).ready(function($) {

		$('#smartwizard').smartWizard({
			transitionEffect: 'fade',
			toolbarButtonPosition: 'right',
			autoAdjustHeight: true,
			useURLhash: true,
			anchorSettings: {
				anchorClickable: true, // Enable/Disable anchor navigation
				enableAllAnchors: true, // Activates all anchors clickable all times
				markDoneStep: true, // add done css
				enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
			},  

			toolbarSettings: {
				toolbarPosition: 'bottom', // none, top, bottom, both
				toolbarButtonPosition: 'right', // left, right
				showNextButton: true, // show/hide a Next button
			}
		});

		$('#checkbox3').click(function() {
			if ($(this).is(':checked')) {
				$('.price-fields').show();
				$('.price-info').hide();
			} else {
				$('.price-fields').hide();
				$('.price-info').show();
			}
		});
		// setTimeout( function(){
			// var width = 255;
			// width = $("#croppic").width();
			// console.log( "width : " + width);
			// $("#croppic").height(width * 343 / 255);

			// var width_double = 510;
			// width_double = $("#croppic-double").width();
			// $("#croppic-double").height( width_double * 343 / 510);
		// }, 1000);

	});
	function customValidate(_this){
		if( _this.is("select")){
			if( $(_this).find("option:selected").length == 0)
				return false;
			if( $(_this).find("option:selected").is("[disabled]"))
				return false;
		} else if( _this.is("input")){
			if( _this.is("[type=text]") || _this.is("[type=password]") || _this.is("[type=number]")){
				if( _this.val() == "")
					return false;
			}
		} else if( _this.is("textarea")){
			if( _this.val() == "")
				return false;
		}
		return true;
	}
	$("input[required]").change(function(){
		if( $(this).val() == ""){
			$(this).addClass("emptyRequire");
		} else{
			$(this).removeClass("emptyRequire");
		}
	});
	$("textarea[required]").change(function(){
		if( $(this).val() == ""){
			$(this).addClass("emptyRequire");
		} else{
			$(this).removeClass("emptyRequire");
		}
	});
	$("select[required]").change(function(){
		if( $(this).find("option:selected").is("[disabled]")){
			$(this).addClass("emptyRequire");
		} else{
			$(this).removeClass("emptyRequire");
		}
	});
	$("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
		var elmForm = $("#step-" + (stepNumber*1+1));
		// only on forward navigation, that makes easy navigation on backwards still do the validation when going next
		if( stepNumber == 0){
			var activedTags = jQuery(".tagBtn.active");
			var arrTags = [];
			for( var i = 0; i < activedTags.length; i++){
				var curBtn = activedTags.eq(i);
				var strTag = curBtn.text();
				arrTags.push(strTag);
			}
			var strTags = arrTags.join(",");
			jQuery("input[name=tags]").val(strTags);
		}
		if( stepNumber == 5){ // step 6
			var arrCroppedImgs = elmForm.find("#croppic .croppedImg");
			if( arrCroppedImgs.length == 0){
				$("#croppic").addClass("emptyRequire");
				return false;
			}
			var imgCropped = arrCroppedImgs.eq(0);
			$("#croppedImgUrl").val(imgCropped.attr("src"));
			if( $('#ads_type_selected').val().indexOf("standard") == -1){
				var arrDoubleCroppedImgs = elmForm.find("#croppic-double .croppedImg");
				if( arrDoubleCroppedImgs.length == 0){
					$("#croppic-double").addClass("emptyRequire");
					return false;
				}
				$("#croppedImgUrlDouble").val(arrDoubleCroppedImgs.eq(0).attr("src"));
			}
		} else if( stepNumber == 6){

			var arrThumbImgInputs = $("input.classiera-input-file.imgInp");
			var isUploaded = false;
			for( var i = 0; i < arrThumbImgInputs.length; i++){
				var curInput = arrThumbImgInputs.eq(i);
				if( curInput.val() != ""){
					isUploaded = true;
				}
			}
			$("#mydropzone").addClass("emptyRequire");
			return isUploaded;
		} else{
			if(stepDirection === 'forward' && elmForm){
				var arrReqElems = elmForm.find('input,textarea,select').filter('[required]');
				var result = true;
				for( var i = 0; i < arrReqElems.length; i++){
					var curReqElem = arrReqElems.eq(i);
					if( customValidate(curReqElem) == false){
						curReqElem.addClass("emptyRequire");
						result = false;
					}
				}
				return result;
			}
			return true;
		}
	});

	function TagClicked(_this){
		jQuery(_this).toggleClass("active");
	}


</script>
<?php get_footer(); ?>