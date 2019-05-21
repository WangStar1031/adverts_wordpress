			<?php 
	$useragent=$_SERVER['HTTP_USER_AGENT'];
	$isMobile = false;
	if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
		$isMobile = true;
	}
	global $redux_demo;
	$classieraSecClass = '';
	$classieraNavClass = '';
	$offcanvasDark = '';
	$affixClass = '';
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraLogo = $redux_demo['logo']['url'];
	$classieraProfileURL = $redux_demo['profile'];
	$classieraLoginURL = $redux_demo['login'];
	$classieraRegisterURL = $redux_demo['register'];
	$classieraSubmitPost = $redux_demo['new_post'];	

	$current_user = wp_get_current_user();
	$user_ID = $current_user->ID;
	$classiera_bid_system = $redux_demo['classiera_bid_system'];
	$templateProfile = 'template-profile.php';
	$templateAllAds = 'template-user-all-ads.php';
	$templatePlans = 'template-user-plans.php';
	$templateFavourite = 'template-favorite.php';
	$templateMessage = 'template-message.php';
	$templateGetCredits = 'template-get-credits.php';
	$templateConfirmImages = 'template-confirm-images.php';
	$templateEditProfile = 'template-edit-profile.php';

	$classieraProfile = classiera_get_template_url($templateProfile);
	$classieraAllAds = classiera_get_template_url($templateAllAds);
	$classieraUserPlansPage = classiera_get_template_url($templatePlans);
	$classieraUserFavourite = classiera_get_template_url($templateFavourite);
	$classieraInbox = classiera_get_template_url($templateMessage);
	$classieraGetCredits = classiera_get_template_url($templateGetCredits);
	$classieraConfirmImages = classiera_get_template_url($templateConfirmImages);
	$classieraEditProfile = classiera_get_template_url($templateEditProfile);

	function isConfirmedPost_1($_postId){
		$isConfirmed = get_post_meta( $_postId, "images_verified", true);
		if( $isConfirmed == '1') return true;
		return false;
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
		if( isConfirmedPost_1($post_id))
			continue;
		$is_Exist = true;
	endwhile;

	//WPML Settings//
	if(function_exists('icl_object_id')){ 		
		$templateProfile = 'template-profile.php';
		$templateLogin = 'template-login.php';
		$templateRegister = 'template-register.php';
		$templateSubmitAd = 'template-submit-ads.php';		
		$classieraProfileURL = classiera_get_template_url($templateProfile);
		$classieraLoginURL = classiera_get_template_url($templateLogin);
		$classieraRegisterURL = classiera_get_template_url($templateRegister);
		$classieraSubmitPost = classiera_get_template_url($templateSubmitAd);
	}
	//WPML Settings//
	//Socail Links
	$primaryColor = $redux_demo['color-primary'];
	$classieraNavStyle = $redux_demo['nav-style'];
	if($classieraNavStyle == 3){
		$container = '';
		$classieraSecClass = 'classiera-navbar-v3';
		$classieraNavClass = 'classiera-custom-navbar-v1';
		$container = 'container-fluid';
	}
?>
<!-- NavBar -->
<section class="classiera-navbar  <?php echo esc_attr($affixClass);?> <?php echo esc_attr($classieraSecClass); ?>">
	<div class="<?php echo esc_attr($container); ?>">
		<!-- mobile off canvas nav -->
		<?php if($classieraNavStyle == 3){ ?>
		<nav id="myNavmenu" class="navmenu navmenu-default navmenu-fixed-left offcanvas navmenu-fixed-left <?php echo esc_attr($offcanvasDark); ?>" role="navigation">
			<div class="col-xs-12">
				<button type="button" class="offcanvas-button" data-toggle="offcanvas" data-target="#myNavmenu">
					<i class="fa fa-times"></i>
				</button>
				<div class="navmenu-brand clearfix">
					<a href="<?php echo home_url(); ?>">
						<?php if(empty($classieraLogo)){?>
							<!-- <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>"> -->
						<?php }else{ ?>
							<img src="<?php echo esc_url($classieraLogo); ?>" alt="<?php bloginfo( 'name' ); ?>">
						<?php } ?>
					</a>
				</div><!--navmenu-brand clearfix-->
				<ul class="nav navmenu-nav">
					<a class="navbar-brand-custom" href="<?php echo home_url(); ?>">
						<!-- Default logo -->
						<img class="img-responsive mobile-logo" src="<?php echo get_template_directory_uri(); ?>/images/logo.svg" alt="<?php bloginfo( 'name' ); ?>">
					</a>
					<?php if(is_user_logged_in()){?>
						<li>
							<a href="<?php echo esc_url($classieraProfileURL); ?>"><?php esc_html_e( 'My Account', 'classiera' ); ?></a>
						</li>

						<li>
							<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>"><?php esc_html_e( 'Log out', 'classiera' ); ?></a>	
						</li>
					<?php }else{ ?>
						<li>
							<a href="<?php echo esc_url($classieraLoginURL); ?>"><?php esc_html_e( 'Login', 'classiera' ); ?></a>
						</li>
						<li>
							<a href="<?php echo esc_url($classieraRegisterURL); ?>"><?php esc_html_e( 'Get Registered', 'classiera' ); ?></a>
						</li>
					<?php } ?>
				</ul>
				<?php 
					//enque Menu Function
					classieraMobileNav();
				?>

				<?php if( is_user_logged_in() && $isMobile) { ?>

					    <ul class="nav navmenu-nav">
							<!-- About Me -->
					    	<li>
					    		<a href="<?php echo esc_url( $classieraProfile ); ?>">
					    			<span>
					    				<!-- <i class="fa fa-user"></i> -->
					    				<?php esc_html_e("My Profile", 'classiera') ?>
					    			</span>
					    		</a>
					    	</li>
					    	<!-- End About me -->

							<!-- All Adverts -->
					    	<?php if(!in_array( 'user', (array) $current_user->roles )): ?>
						    	<li>
						    		<a href="<?php echo esc_url( $classieraAllAds ); ?>">
						    			<span>
						    				<!-- <i class="fa fa-suitcase"></i> -->
						    				<?php esc_html_e("My Ads", 'classiera') ?>
						    			</span>
						    			<span class="in-count pull-right flip badge"><?php echo count_user_posts($user_ID);?></span>
						    		</a>
						    	</li>
					    	<?php endif;?>
					    	<!-- End All Adverts -->
							
							<!-- Messages -->
					    	<!-- <?php if($classiera_bid_system == true){ ?>
						    	<li class="<?php if(is_page_template( 'template-message.php' )){echo "active";}?>">
						    		<a href="<?php echo esc_url( $classieraInbox ); ?>">
						    			<span>
						    				<?php esc_html_e("Message", 'classiera') ?>
						    			</span>
						    			<span class="in-count pull-right flip badge"><?php echo count_user_message($user_ID);?></span>
						    		</a>
						    	</li>
					    	<?php } ?> -->
					    	<!--End Messages -->

							<!-- Packages -->
					    	<?php if($classieraUserPlansPage){?>
					    		<?php if(!in_array( 'user', (array) $current_user->roles )): ?>
							    	<li>
							    		<a href="<?php echo esc_url( $classieraUserPlansPage ); ?>">
							    			<span>
							    				<!-- <i class="fas fa-dollar-sign"></i> -->
							    				<?php esc_html_e("Packages", 'classiera') ?>
							    			</span>
							    		</a>
							    	</li><!--Packages-->
					    		<?php endif; ?>
					    	<?php } ?>
					    	<!-- End Packages -->

							<!-- Get Credits -->
					    	<?php if(!in_array( 'user', (array) $current_user->roles )): ?>
						    	<li>
						    		<a href="<?php echo esc_url( $classieraGetCredits ); ?>">
						    			<span>
						    				<!-- <i class="fa fa-credit-card"></i> -->
						    				<?php esc_html_e("Get Credits", 'classiera') ?>
						    			</span>
						    		</a>
						    	</li><!-- Get Credits -->
					    	<?php endif;?>
					    	<!-- End Get Credits -->

							<!-- Confirm Images -->
					    	<?php if(!in_array( 'user', (array) $current_user->roles ) && $is_Exist): ?>
						    	<li>
						    		<a href="<?php echo esc_url( $classieraConfirmImages ); ?>">
						    			<span>
						    				<!-- <i class="fa fa-credit-card"></i> -->
						    				<?php esc_html_e("Confirm Images", 'classiera') ?>
						    			</span>
						    		</a>
						    	</li><!-- Confirm Images -->
					    	<?php endif;?>
					    	<!-- End Confirm Images -->

							<!-- Profile Settings -->
					    	<li>
					    		<a href="<?php echo esc_url( $classieraEditProfile ); ?>">
					    			<span>
					    				<?php esc_html_e("Profile Settings", 'classiera') ?>
					    			</span>
					    		</a>
					    	</li>
					    	<!-- End Profile Settings -->
							
							<!-- Logout -->
					    	<!-- <li>
					    		<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>">
					    			<span>
					    				<i class="fas fa-sign-out-alt"></i>
					    				<?php esc_html_e("Logout", 'classiera') ?>
					    			</span>
					    		</a>
					    	</li> -->
					    	<!-- End Logout -->

					    </ul><!--user-page-list-->

					    <?php if(!in_array( 'user', (array) $current_user->roles )): ?>
					    <div class="">
					    	<a href="<?php echo esc_url( $classieraPostAds ); ?>" class="btn btn-primary btn-block extra-padding active">
					    		<?php esc_html_e("Create New Advert", 'classiera') ?>
					    	</a>
					    </div>
					    <?php endif; ?>

				<?php } ?>
				<!-- <div class="submit-post">
					<a href="<?php echo esc_url($classieraSubmitPost); ?>" class="btn btn-block btn-primary btn-md active">
						<?php esc_html_e( 'Submit Ad', 'classiera' ); ?>
					</a>
				</div> -->
			</div>
		</nav>
		<?php } ?>
		<!-- mobile off canvas nav -->

		<!--Primary Nav-->
		<nav class="navbar navbar-default <?php echo esc_attr($classieraNavClass); ?>">
			<?php if($classieraNavStyle == 3){?>
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target="#myNavmenu" data-canvas="body">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<span class="hidden-lg pull-right"><?php echo do_shortcode('[wp_locale_switch]'); ?></span>
					<a class="navbar-brand-custom" href="<?php echo home_url(); ?>">
						<?php if(empty($classieraLogo)){?>
							<!-- Default logo -->
							<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/logo.svg" alt="<?php bloginfo( 'name' ); ?>">
						<?php }else{ ?>
							<img class="img-responsive" src="<?php echo esc_url($classieraLogo); ?>" alt="<?php bloginfo( 'name' ); ?>">
						<?php } ?>
					</a>
				</div><!--navbar-header-->
			<?php } ?>

			<div class="collapse navbar-collapse visible-lg" id="navbarCollapse">
			<?php if($classieraNavStyle == 3){ ?>	
				<div class="nav navbar-nav navbar-right nav-v3-follow flip">
					<p>
						
						<?php esc_html_e( 'Follow us', 'classiera' ); ?>:
						

						<?php if(!empty($classieraFacebook)){?>
						<a href="<?php echo esc_url($classieraFacebook); ?>" target="_blank">
							<i class="fab fa-facebook-f"></i>
						</a>
						<?php } ?>
						<?php if(!empty($classieraTwitter)){?>
                        <a href="<?php echo esc_url($classieraTwitter); ?>" target="_blank">
							<i class="fab fa-twitter"></i>
						</a>
						<?php } ?>
						<?php if(!empty($classieraGoogle)){?>
                        <a href="<?php echo esc_url($classieraGoogle); ?>" target="_blank">
							<i class="fab fa-google-plus-g"></i>
						</a>
						<?php } ?>
						<?php if(!empty($classieraInstagram)){?>
                        <a href="<?php echo esc_url($classieraInstagram); ?>" target="_blank">
							<i class="fab fa-instagram"></i>
						</a>
						<?php } ?>
						<?php if(!empty($classieraPinterest)){?>
                        <a href="<?php echo esc_url($classieraPinterest); ?>" target="_blank">
							<i class="fab fa-pinterest-p"></i>
						</a>
						<?php } ?>
					</p>
				</div>
				<div class="nav navbar-nav navbar-right betube-search flip">
					<a href="<?php echo esc_url($classieraSubmitPost); ?>" class="btn btn-primary radius btn-md btn-style-three active"><?php esc_html_e( 'Submit Ad', 'classiera' ); ?></a>
				</div>
			<?php } 

				classieraPrimaryNav();

			?>
				
			</div><!--collapse navbar-collapse visible-lg-->
		</nav>
		<!--Primary Nav-->
	</div>

</section>
<!-- NavBar -->