<?php 
	global $redux_demo;
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraAdsView = $redux_demo['home-ads-view'];
	$primaryColor = $redux_demo['color-primary'];
	$classieraItemClass = "item-masonry";
	if($classieraAdsView == 'list'){
		$classieraItemClass = "item-list";
	}
	$ads_type_selected = get_post_meta($post->ID, 'ads_type_selected', true);
	$largeAds='';
	if($ads_type_selected=='double_sec' || $ads_type_selected=='double_top')
	{
		$largeAds='grid-item--width2';
		$image_size='advert_double';
	}
	else
	{
		$largeAds='grid-item';
		$image_size='advert';
	}
	$category_icon_code = "";
	$category_icon_color = "";
	$catIcon = "";
	$category = get_the_category();
	$catID = $category[0]->cat_ID;
	if ($category[0]->category_parent == 0) {
		$tag = $category[0]->cat_ID;
		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
		if (isset($tag_extra_fields[$tag])) {
			$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
			$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
			$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
		}
	}elseif(isset($category[1]->category_parent) && $category[1]->category_parent == 0){
		$tag = $category[0]->category_parent;
		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
		if (isset($tag_extra_fields[$tag])) {
			$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
			$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
			$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
		}
	}else{
		$tag = $category[0]->category_parent;
		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
		if (isset($tag_extra_fields[$tag])) {
			$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
			$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
			$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
		}
	}
	if(!empty($category_icon_code)) {
		$category_icon = stripslashes($category_icon_code);
	}
	if(!empty($category_icon_color)) {
		$category_icon_color = $primaryColor;
	}
	$post_price = get_post_meta($post->ID, 'post_price', true);
	$post_phone = get_post_meta($post->ID, 'post_phone', true);
	$fifteen_min_euro = get_post_meta($post->ID, 'fifteen_min_euro', true);
	$thirty_min_euro = get_post_meta($post->ID, 'thirty_min_euro', true);
	$fourty_five_min_euro = get_post_meta($post->ID, 'fourty_five_min_euro', true);
	$one_hour_euro = get_post_meta($post->ID, 'one_hour_euro', true);
	$full_day_euro = get_post_meta($post->ID, 'full_day_euro', true);
	$business_date_euro = get_post_meta($post->ID, 'business_date_euro', true);
	$theTitle = get_the_title();
	$partner_name =  get_post_meta($post->ID, 'partner_name', true);
	$postCatgory = get_the_category( $post->ID );
	$categoryLink = get_category_link($catID);
	$classieraPostAuthor = $post->post_author;
	$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
	$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
	$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
	$classiera_ads_statustime = get_post_meta($post->ID, 'classiera_ads_statustime', true);
	$current_time = date("Y-m-d H:i:s");		
	if($current_time >= $classiera_ads_statustime){ ?>

	<div class="<?php echo $largeAds;?>">
		<div class="classiera-box-div classiera-box-div-v4">
			<figure class="clearfix">
				<div class="premium-img">
				<?php 
					$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
					if($classieraFeaturedPost == 1){
						?>
						<!-- <div class="featured-tag">
							<span class="left-corner"></span>
							<span class="right-corner"></span>
							<div class="featured">
								<p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
							</div>
						</div> -->
						<?php
					}
					?>

					<div class="premium-img-inner">
						<?php
							$discount_per = get_post_meta($post->ID,'discount_percentage',true);
							if(!empty($discount_per) && $discount_per>0)
							{
								?>
								<div class="discount_per_parent">
									<span class="discount_per">
										<?php esc_html_e('-'.$discount_per.'%','classiera');?>
									</span>
								</div>
								<?php
							}
						?>
					<!-- Get the image -->	
					<?php
						// $imageurl = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $image_size);
						// $thumb_id = get_post_thumbnail_id($post->ID);
						$posttype = get_post_meta($post->ID, "ads_type_selected");
						$post_type = $posttype[0];
						if( strpos($post_type, 'standard') === false ){
							$realUrl = get_post_meta($post->ID, "croppedImg_Path_double");
						} else {
							$realUrl = get_post_meta($post->ID, "croppedImg_Path");
						}
						if( count($realUrl) != 0){
						?>
						<img class="img-responsive" src="<?php echo esc_url($realUrl[0]); ?>" alt="<?php echo esc_html($theTitle); ?>" postID="<?=$post->ID?>" posttype="<?=$post_type?>">
						<?php
						} else{
						?>
						<img class="img-responsive" src="<?php echo get_template_directory_uri() . '/images/nothumb.png'; ?>" alt="<?php echo esc_html($theTitle); ?>" postID="<?=$post->ID?>" posttype="<?=$post_type?>">
						<?php
						}
					?>
					<!-- / Get the Image -->
						<!-- Hover content -->
						<a href="<?php the_permalink(); ?>">
							<span class="hover-posts">
								<div class="row">
									<div class="col-lg-12">
										<h4 style="color: white">
											<?php if(in_category(array('couple', 'duo'))) { ?>
												<?php echo esc_html($theTitle); ?> &amp; <?php echo esc_html($partner_name); ?>
											<?php } else { ?>
												<?php echo esc_html($theTitle); ?>
											<?php } ?>		
										</h4>
									</div>
									<div class="col-lg-12">

										<?php
										$_isNoPrice = true;
										?>
										<!-- Start 15 Minutes Price -->
										<?php if (!empty($fifteen_min_euro)) { $_isNoPrice = false; ?>
											<div class="col-lg-6">
												<span class="pull-right"><?php esc_html_e('15 Min', 'classiera'); ?></span>
											</div>
											<div class="col-lg-6">
												<span class="pull-left"><?php echo esc_html($fifteen_min_euro); ?> &euro;</span>
											</div>
										<?php } ?>
										<!-- End 15 Minutes Price -->
										
										<!-- Start 30 Minutes Price -->
										<?php if (!empty($thirty_min_euro)) { $_isNoPrice = false; ?>
											<div class="col-lg-6">
												<span class="pull-right"><?php esc_html_e('30 Min', 'classiera'); ?></span>
											</div>
											<div class="col-lg-6">
												<span class="pull-left"><?php echo esc_html($thirty_min_euro); ?> &euro;</span>
											</div>
										<?php } ?>
										<!-- End 30 Minutes Price -->

										<!-- Start 45 Minutes Price -->
										<?php if (!empty($fourty_five_min_euro)) { $_isNoPrice = false; ?>
											<div class="col-lg-6">
												<span class="pull-right"><?php esc_html_e('45 Min', 'classiera'); ?></span>
											</div>
											<div class="col-lg-6">
												<span class="pull-left"><?php echo esc_html($fourty_five_min_euro); ?> &euro;</span>
											</div>
										<?php } ?>
										<!-- End 45 Minutes price -->

										<!-- Start One Hour Price -->
										<?php if (!empty($one_hour_euro)) { $_isNoPrice = false; ?>
											<div class="col-lg-6">
												<span class="pull-right"><?php esc_html_e('1 Hour', 'classiera'); ?></span>
											</div>
											<div class="col-lg-6">
												<span class="pull-left"><?php echo esc_html($one_hour_euro); ?> &euro;</span>
											</div>
										<?php } ?>
										<!-- End One hour price -->

										<!-- Start Full Day Price -->
										<?php if (!empty($full_day_euro)) { $_isNoPrice = false; ?>
											<div class="col-lg-6">
												<span class="pull-right"><?php esc_html_e('Full Day', 'classiera'); ?></span>
											</div>
											<div class="col-lg-6">
												<span class="pull-left"><?php echo esc_html($full_day_euro); ?> &euro;</span>
											</div>
										<?php } ?>
										<!-- End Full Day Price -->
										<!-- Start Business Date -->
										<?php if (!empty($business_date_euro)) { $_isNoPrice = false; ?>
											<div class="col-lg-6">
												<span class="pull-right"><?php esc_html_e('Date', 'classiera'); ?></span>
											</div>
											<div class="col-lg-6">
												<span class="pull-left"><?php echo esc_html($business_date_euro); ?> &euro;</span>
											</div>
										<?php } ?>
										<!-- End Business Date Price -->
										<?php if( $_isNoPrice == true){?>
											<div class="col-lg-12">
												<span><?php esc_html_e('No prices provided', 'classiera'); ?></span>
											</div>
										<?php }?>
									</div>
								</div>
							</span>
						</a>
						<!-- / Hover Content -->
						<div class="category">
							<a href="<?php echo esc_url($categoryLink); ?>"><?php echo esc_html($postCatgory[0]->name); ?></a>
							<!-- <a href="tel:<?php echo esc_html($post_phone); ?>"><?php echo esc_html($post_phone); ?></a> -->
						</div><!--category-->
					</div><!--premium-img-inner-->

				</div><!--premium-img-->
			</figure>
		</div><!--row-->
	</div>
<?php } ?><!--item item-grid item-masonry-->