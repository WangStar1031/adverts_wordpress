<?php 
	global $redux_demo;
	$classieraSecClass = '';
	$classieraNavClass = '';
	$offcanvasDark = '';
	$classieraStickyClass = '';
	$affixClass = '';
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraStickyNav = $redux_demo['classiera_sticky_nav'];
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
	if($classieraStickyNav == 1){
		$classieraStickyClass = 'navbar-fixed-top';
		$affixClass = 'classieraNavAffix';
	}
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
		<?php if($classieraNavStyle == 4){?>
		<div class="row">
		<div class="col-lg-12">
		<?php } ?>
		<!-- mobile off canvas nav -->
		<?php if($classieraNavStyle == 3){?>
		<nav id="myNavmenu" class="navmenu navmenu-default navmenu-fixed-left offcanvas offcanvas-light <?php if(is_rtl()){echo "navmenu-fixed-right";}else{ echo "navmenu-fixed-left"; } ?> <?php echo esc_attr($offcanvasDark); ?>" role="navigation">
			<div class="navmenu-brand clearfix">
				<a href="<?php echo home_url(); ?>">
					<?php if(empty($classieraLogo)){?>
						<!-- <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>"> -->
					<?php }else{ ?>
						<img src="<?php echo esc_url($classieraLogo); ?>" alt="<?php bloginfo( 'name' ); ?>">
					<?php } ?>
				</a>
				<button type="button" class="offcanvas-button" data-toggle="offcanvas" data-target="#myNavmenu">
					<i class="fa fa-times"></i>
				</button>
			</div><!--navmenu-brand clearfix-->
			<div class="log-reg-btn text-center">
				
				<?php if(is_user_logged_in()){?>
					<a href="<?php echo esc_url($classieraProfileURL); ?>" class="offcanvas-log-reg-btn">
						<?php esc_html_e( 'My Account', 'classiera' ); ?>
					</a>
					<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>" class="offcanvas-log-reg-btn">
						<?php esc_html_e( 'Log out', 'classiera' ); ?>
					</a>
				<?php }else{ ?>
					<a href="<?php echo esc_url($classieraLoginURL); ?>" class="offcanvas-log-reg-btn">
						<?php esc_html_e( 'Login', 'classiera' ); ?>
					</a>
					<a href="<?php echo esc_url($classieraRegisterURL); ?>" class="offcanvas-log-reg-btn">
						<?php esc_html_e( 'Get Registered', 'classiera' ); ?>
					</a>
				<?php } ?>
			</div>
			<?php 
				//enque Menu Function
				classieraMobileNav();
			?>
			<?php
			if( is_user_logged_in()){
			?>
				<div class="panel panel-default">
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
			};
			?>
			<div class="submit-post">
				<a href="<?php echo esc_url($classieraSubmitPost); ?>" class="btn btn-block btn-primary btn-md active">
					<?php esc_html_e( 'Submit Ad', 'classiera' ); ?>
				</a>
			</div><!--submit-post-->

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
				<a class="navbar-brand-custom" href="<?php echo home_url(); ?>">
				<?php if(empty($classieraLogo)){?>
					<!-- Default logo -->
					<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/logo.svg" alt="<?php bloginfo( 'name' ); ?>">
				<?php }else{ ?>
					<img class="img-responsive" src="<?php echo esc_url($classieraLogo); ?>" alt="<?php bloginfo( 'name' ); ?>">
				<?php } ?>
				</a>
			</div><!--navbar-header-->
		<?php }elseif($classieraNavStyle == 2){?>
			<div class="navbar-header dropdown category-menu-dropdown">
				<button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target="#myNavmenu" data-canvas="body">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<button class="btn btn-primary round btn-md btn-style-two btn-style-two-left category-menu-btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="icon-left"><i class="fa fa-bars"></i></span>
					<?php esc_html_e( 'categories', 'classiera' ); ?>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<?php 
						$classieraCatIconCode = "";
						$args = array(
							'hierarchical' => '0',
							'hide_empty' => '0'
						);
						$categories = get_categories($args);
						foreach($categories as $cat){
							if ($cat->category_parent == 0){
								$tag = $cat->term_id;
								$catName = $cat->term_id;
								$classieraCatFields = get_option(MY_CATEGORY_FIELDS);
								if (isset($classieraCatFields[$tag])){
									$classieraCatIconCode = $classieraCatFields[$tag]['category_icon_code'];
									$classieraCatIcoIMG = $classieraCatFields[$tag]['your_image_url'];
									$classieraCatIconClr = $classieraCatFields[$tag]['category_icon_color'];
								}
								if(empty($classieraCatIconClr)){
									$iconColor = $primaryColor;
								}else{
									$iconColor = $classieraCatIconClr;
								}
								$category_icon = stripslashes($classieraCatIconCode);
								$categoryLink = get_category_link( $cat->term_id );
								?>
								<li>
									<a href="<?php echo esc_url($categoryLink); ?>">
										<?php if(!empty($category_icon) || !empty($classieraCatIcoIMG)){?>
											<?php 
											if($classieraIconsStyle == 'icon'){
												?>
												<i class="<?php echo esc_html($category_icon); ?>" style="color:<?php echo esc_html($iconColor); ?>;"></i>
												<?php
											}elseif($classieraIconsStyle == 'img'){
												?>
												<img src="<?php echo esc_url($classieraCatIcoIMG); ?>" alt="<?php echo esc_html(get_cat_name( $catName )); ?>">
												<?php
											}
											?>
										<?php } ?>
										<?php echo esc_html(get_cat_name( $catName )); ?>
									</a>
								</li>
								<?php
							} 
						}
					?>
				</ul>
			</div>
		<?php } ?>
			<div class="collapse navbar-collapse visible-lg" id="navbarCollapse">
			<?php if($classieraNavStyle == 3){ ?>	
				<div class="nav navbar-nav navbar-right nav-v3-follow flip">
					<p>
						<!-- <?php if (!empty($classieraFacebook || $classieraTwitter || $classieraGoogle || $classieraInstagram || $classieraInstagram)) { ?>
							<?php esc_html_e( 'Follow us', 'classiera' ); ?>:
						<?php } ?> -->

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
</section>
<!-- NavBar -->