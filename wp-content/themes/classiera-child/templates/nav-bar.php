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