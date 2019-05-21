<?php 
	global $redux_demo;
	$classieraDisplayName = '';
	$templateProfile = '';
	$templateAllAds = '';
	$templateEditPost = '';
	$templateSubmitAd = '';
	$templateFollow = '';
	//Get Credits
	$templateGetCredits ='';
	//Confirm Images
	$templateConfirmImages ='';
	$templatePlans = '';
	$templateFavourite = '';
	$current_user = wp_get_current_user();
	$user_ID = $current_user->ID;
	$classieraAuthorEmail = $current_user->user_email;
	$classieraDisplayName = $current_user->display_name;
	if(empty($classieraDisplayName)){
		$classieraDisplayName = $current_user->user_nicename;
	}
	if(empty($classieraDisplayName)){
		$classieraDisplayName = $current_user->user_login;
	}
	$classieraAuthorIMG = get_user_meta($user_ID, "classify_author_avatar_url", true);
	$classieraAuthorIMG = classiera_get_profile_img($classieraAuthorIMG);
	if(empty($classieraAuthorIMG)){
		$classieraAuthorIMG = classiera_get_avatar_url ($classieraAuthorEmail, $size = '150' );
	}	
	$classieraOnlineCheck = classiera_user_last_online($user_ID);
	$UserRegistered = $current_user->user_registered;
	$dateFormat = get_option( 'date_format' );
	$classieraRegDate = date_i18n($dateFormat,  strtotime($UserRegistered));
	$classieraProfile = $redux_demo['profile'];
	//Get Credits variable
	$classieraGetCredits = $redux_demo['get_credits'];
	//Confirm Images Variable
	$classieraConfirmImages = $redux_demo['confirm_images'];
	$classieraProfile = $redux_demo['profile'];
	$classieraAllAds = $redux_demo['all-ads'];
	$classieraEditProfile = $redux_demo['edit'];
	$classieraPostAds = $redux_demo['new_post'];
	$classieraInbox = $redux_demo['classiera_inbox_page_url'];
	$classieraFollowerPage = $redux_demo['classiera_user_follow'];
	$classieraUserPlansPage = $redux_demo['classiera_single_user_plans'];
	$classieraUserFavourite = $redux_demo['all-favourite'];
	$classiera_bid_system = $redux_demo['classiera_bid_system'];
	if (function_exists('icl_object_id')){ 		
		$templateProfile = 'template-profile.php';
		$templateAllAds = 'template-user-all-ads.php';
		$templateEditProfile = 'template-edit-profile.php';
		$templateSubmitAd = 'template-submit-ads.php';
		$templateFollow = 'template-follow.php';
		// Get credits page template 
		$templateGetCredits = 'template-get-credits.php';
		// Confirm Images Template
		$templateConfirmImages = 'template-confirm-images.php';
		$templatePlans = 'template-user-plans.php';
		$templateFavourite = 'template-favorite.php';
		$templateMessage = 'template-message.php';
		
		$classieraProfile = classiera_get_template_url($templateProfile);
		//Get credits
		$classieraGetCredits = classiera_get_template_url($templateGetCredits);
		//Confirm Images
		$classieraConfirmImages = classiera_get_template_url($templateConfirmImages);
		$classieraAllAds = classiera_get_template_url($templateAllAds);
		$classieraEditProfile = classiera_get_template_url($templateEditProfile);
		$classieraPostAds = classiera_get_template_url($templateSubmitAd);
		$classieraFollowerPage = classiera_get_template_url($templateFollow);
		$classieraUserPlansPage = classiera_get_template_url($templatePlans);
		$classieraUserFavourite = classiera_get_template_url($templateFavourite);
		$classieraInbox = classiera_get_template_url($templateMessage);
	}
	$userAvatarUrl = get_avatar_url($user_ID);
	//////////
	function isConfirmedPost1($_postId){
		$isConfirmed = get_post_meta( $_postId, "images_verified", true);
		if( $isConfirmed == '1') return true;
		return false;
		// $dir = __DIR__ . "/../../ConfirmImages/";
		// if( !file_exists($dir)){
		// 	mkdir($dir, 777);
		// }
		// $files = glob($dir . $_postId . ".*");
		// if( $files) return true;
		// return false;
	}

	$args = array(
		'post_type' => 'POST',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'author' => $user_ID
	);

	$wp_query1 = new WP_Query($args);
	$is_Exist = false;
	while ( $wp_query1->have_posts() ) : $wp_query1->the_post();
		$post_id = get_the_ID(); 
		if( isConfirmedPost1($post_id))
			continue;
		$is_Exist = true;
	endwhile;
	//////////
?>
<aside id="sideBarAffix" class="affix-top">
	<?php if(!in_array( 'user', (array) $current_user->roles )): ?>
	<div class="panel panel-default hidden-xs" data-intro="<?php esc_html_e('This is Your Wallet! Whenever you purchase or spend credits, your ballance will always be visible here.', 'classiera'); ?>" data-step="1">
	  <div class="panel-heading text-center">
	    <h3 class="panel-title"><?php esc_html_e('My Ballance', 'classiera'); ?></h3>
	  </div>
	  <div class="panel-body">
	    <div class="wallet-info">
	    	<div class="media">
	    		<div class="media-body">
	    			<!-- Display User Wallet Ballance -->
	    			<div class="wallet-container">
	    				<h4><?php echo do_shortcode("[uw_balance]"); ?></h4>
	    			</div>
	    			<!--/Display User Wallet Ballance -->
	    		</div><!--media-body-->
	    	</div><!--media-->
	    </div><!--author-info-->
	  </div>
	</div>
	<?php endif;?>

	<div class="author-info hidden-xs" data-intro="<?php esc_html_e('This is your Avatar, as well as your account registration date.', 'classiera'); ?>" data-step="2">
		<div class="panel panel-default">
		  <div class="panel-heading text-center">
		    <h3 class="panel-title">
		    	<?php echo esc_attr( $classieraDisplayName ); ?>					
		    	<?php echo classiera_author_verified($user_ID); ?>
		    </h3>
		  </div>
		  <div class="panel-body">
		    <div class="media">
		    	<div class="media-center">
		    		<img class="media-object" src="<?php echo esc_url( $userAvatarUrl ); ?>" alt="<?php echo esc_attr( $classieraDisplayName ); ?>">
		    	</div><!--media-left-->
		    	<div class="media-body author-details">
		    		<p><?php esc_html_e('Member Since', 'classiera') ?></p>
		    		<p><?php echo esc_html( $classieraRegDate ); ?></p>
		    		<?php if($classieraOnlineCheck == false){?>
		    		<span class="offline"><i class="fa fa-circle"></i><?php esc_html_e('Offline', 'classiera') ?></span>
		    		<?php }else{ ?>
		    		<span><i class="fa fa-circle"></i><?php esc_html_e('Online', 'classiera') ?></span>
		    		<?php } ?>
		    	</div><!--media-body-->
		    </div><!--media-->
		  </div>
		</div>
		
	</div><!--author-info-->
	<?php
	$useragent=$_SERVER['HTTP_USER_AGENT'];
	$isMobile = false;
	if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
		$isMobile = true;
	}

	if( !$isMobile){
	?>
	<div class="panel panel-default" data-intro="These are your menu options!" data-step="3">
	  <div class="panel-heading text-center">
	    <h3 class="panel-title"><?php esc_html_e("Menu Options", 'classiera') ?></h3>
	  </div>

	  <div class="panel-body account-options">

	    <ul class="list-group"><!-- user-page-list list-unstyled -->

	    	<li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-profile.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraProfile ); ?>">
	    			<span>
	    				<!-- <i class="fa fa-user"></i> -->
	    				<?php esc_html_e("About Me", 'classiera') ?>
	    			</span>
	    		</a>
	    	</li><!--About-->

	    	<?php if(!in_array( 'user', (array) $current_user->roles )): ?>
	    	<li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-user-all-ads.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraAllAds ); ?>">
	    			<span>
	    				<!-- <i class="fa fa-suitcase"></i> -->
	    				<?php esc_html_e("My Ads", 'classiera') ?>
	    			</span>
	    			<span class="in-count pull-right flip badge"><?php echo count_user_posts($user_ID);?></span>
	    		</a>
	    	</li><!--My Ads-->
	    	<?php endif;?>

	    	<!-- <li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-favorite.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraUserFavourite ); ?>">
	    			<span>
	    				<?php esc_html_e("Watch later Ads", 'classiera') ?>
	    			</span>
	    			<span class="in-count pull-right flip badge">
	    				<?php 
	    					global $current_user;
	    					wp_get_current_user();
	    					$user_id = $current_user->ID;
	    					$myarray = classiera_authors_all_favorite($user_id);
	    					if(!empty($myarray)){
	    						$args = array(
	    						   'post_type' => 'post',
	    						   'post__in'      => $myarray
	    						);
	    					$wp_query = new WP_Query( $args );
	    					$current = -1;
	    					$current2 = 0;
	    					while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; $current2++; 													
	    					endwhile;						
	    					echo esc_attr( $current2 );
	    					wp_reset_query();
	    					}else{
	    						echo "0";
	    					}
	    				?>
	    			</span>
	    		</a>
	    	</li> -->

	    	<?php if($classiera_bid_system == true){ ?>
	    	<li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-message.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraInbox ); ?>">
	    			<span>
	    				<!-- <i class="fa fa-envelope"></i> -->
	    				<?php esc_html_e("Message", 'classiera') ?>
	    			</span>
	    			<span class="in-count pull-right flip badge"><?php echo count_user_message($user_ID);?></span>
	    		</a>
	    	</li><!--Message-->
	    	<?php } ?>

	    	<?php if($classieraUserPlansPage){?>
	    		<?php if(!in_array( 'user', (array) $current_user->roles )): ?>
	    	<li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-user-plans.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraUserPlansPage ); ?>">
	    			<span>
	    				<!-- <i class="fas fa-dollar-sign"></i> -->
	    				<?php esc_html_e("Packages", 'classiera') ?>
	    			</span>
	    		</a>
	    	</li><!--Packages-->
	    		<?php endif; ?>
	    	<?php } ?>

	    	<!-- <?php if(!in_array( 'user', (array) $current_user->roles )): ?>
	    	<li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-follow.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraFollowerPage ); ?>">
	    			<span>
	    				<?php esc_html_e("Follower", 'classiera') ?>
	    			</span>
	    		</a>
	    	</li>
	    	<?php endif;?> -->

	    	<?php if(!in_array( 'user', (array) $current_user->roles )): ?>
	    	<li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-get-credits.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraGetCredits ); ?>">
	    			<span>
	    				<!-- <i class="fa fa-credit-card"></i> -->
	    				<?php esc_html_e("Get Credits", 'classiera') ?>
	    			</span>
	    		</a>
	    	</li><!-- Get Credits -->
	    	<?php endif;?>

	    	<?php if(!in_array( 'user', (array) $current_user->roles ) && $is_Exist): ?>
	    	<li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-confirm-images.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraConfirmImages ); ?>">
	    			<span>
	    				<!-- <i class="fa fa-credit-card"></i> -->
	    				<?php esc_html_e("Confirm Images", 'classiera') ?>
	    			</span>
	    		</a>
	    	</li><!-- Confirm Images -->
	    	<?php endif;?>

	    	<li class="list-group-item userabout-list-group-item no-padding <?php if(is_page_template( 'template-edit-profile.php' )){echo "active";}?>">
	    		<a href="<?php echo esc_url( $classieraEditProfile ); ?>">
	    			<span>
	    				<!-- <i class="fa fa-cog"></i> -->
	    				<?php esc_html_e("Profile Settings", 'classiera') ?>
	    			</span>
	    		</a>
	    	</li><!--Profile Setting-->
	    	<li class="list-group-item userabout-list-group-item no-padding" >
	    		<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>">
	    			<span>
	    				<!-- <i class="fas fa-sign-out-alt"></i> -->
	    				<?php esc_html_e("Logout", 'classiera') ?>
	    			</span>
	    		</a>
	    	</li><!--Logout-->
	    </ul><!--user-page-list-->
	    <?php if(!in_array( 'user', (array) $current_user->roles )): ?>
	    <div class=""><!-- user-submit-ad -->
	    	<a href="<?php echo esc_url( $classieraPostAds ); ?>" class="btn btn-primary btn-block extra-padding">
	    		<!-- <i class="icon-left fa fa-plus-circle"></i> -->
	    		<?php esc_html_e("Create New Advert", 'classiera') ?>
	    	</a>
	    </div><!--user-submit-ad-->
	    <?php endif; ?>
	  </div>
	</div>
	<?php
	}
	?>
</aside><!--sideBarAffix-->