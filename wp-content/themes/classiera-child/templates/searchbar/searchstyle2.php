<?php 
	global $redux_demo;
	$classieraLocationName = 'post_location';
	$classieraLocationSearch = $redux_demo['classiera_search_location_on_off'];
	$classieraLocationType = $redux_demo['classiera_search_location_type'];
	$locShownBy = $redux_demo['location-shown-by'];
	if($locShownBy == 'post_location'){
		$classieraLocationName = 'post_location';
	}elseif($locShownBy == 'post_state'){
		$classieraLocationName = 'post_state';
	}elseif($locShownBy == 'post_city'){
		$classieraLocationName = 'post_city';
	}
?>
<section class="search-section search-section-v2">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<form data-toggle="validator" role="form" class="search-form search-form-v2 form-inline" action="<?php echo home_url(); ?>" method="get">
					<!--Select Category-->
					<div class="form-group clearfix">
						<div class="input-group side-by-side-input inner-addon right-addon pull-left flip">
							<div class="input-group-addon input-group-addon-width-sm"><i class="fa fa-bars"></i></div>
							<i class="form-icon form-icon-size-small fa fa-sort"></i>
							<select class="form-control form-control-sm" data-placeholder="<?php esc_html_e('Select Category..', 'classiera'); ?>" name="category_name" id="ajaxSelectCat">
								<option value="-1" selected disabled><?php esc_html_e('All Categories', 'classiera'); ?></option>
								<?php 
								$args = array(
									'hierarchical' => '0',
									'hide_empty' => '0'
								);
								$categories = get_categories($args);
								foreach ($categories as $cat) {
									if($cat->category_parent == 0){
										$catID = $cat->cat_ID;
										?>
									<option value="<?php echo esc_attr($cat->slug); ?>">
										<?php echo esc_html($cat->cat_name); ?>
									</option>	
										<?php
										$args2 = array(
											'hide_empty' => '0',
											'parent' => $catID
										);
										$categories = get_categories($args2);
										foreach($categories as $cat){
											?>
										<option value="<?php echo esc_attr($cat->slug); ?>">- <?php echo esc_html($cat->cat_name); ?></option>	
											<?php
										}
									}
								}
								?>
							</select>
						</div>
						<!--Searchkeyword-->
						<div class="side-by-side-input pull-left flip classieraAjaxInput">
							<input type="text" name="s" class="form-control form-control-sm" id="classieraSearchAJax" placeholder="<?php esc_html_e( 'Enter keyword...', 'classiera' ); ?>" data-error="<?php esc_html_e( 'Please Type some words..!', 'classiera' ); ?>">
							<div class="help-block with-errors"></div>
							<span class="classieraSearchLoader"><img src="<?php echo get_template_directory_uri().'/images/loader.gif' ?>" alt="classiera loader"></span>
							<div class="classieraAjaxResult"></div>
						</div>
						<!--Searchkeyword-->
					</div>					
					<!--Select Category-->
					<!--Locations-->
					<?php if($classieraLocationSearch == 1){?>
					<div class="form-group">
                        <div class="input-group inner-addon right-addon">
                            <div class="input-group-addon input-group-addon-width-sm"><i class="fas fa-map-marker-alt"></i></div>
							<?php if($classieraLocationType == 'input'):?>
								<input type="text" id="getCity" name="<?php echo esc_attr($classieraLocationName); ?>" class="form-control form-control-sm" placeholder="<?php esc_html_e('type your location', 'classiera'); ?>">
								<a id="getLocation" href="#" class="form-icon form-icon-size-small" title="<?php esc_html_e('Click here to get your own location', 'classiera'); ?>">
									<i class="fa fa-crosshairs"></i>
								</a>
							<?php elseif($classieraLocationType == 'dropdown'):?>
								<!--Locations dropdown-->
								<?php get_template_part( 'templates/classiera-locations-dropdown' );?>
								<!--Locations dropdown-->
							<?php endif; ?>
                        </div>
                    </div>
					<?php } ?>
					<!--Locations-->
					<div class="form-group">
                        <button class="radius" type="submit" name="search" value="Search"><?php esc_html_e( 'Search', 'classiera' ); ?><i class="fa fa-search icon-with-btn-right pull-right flip"></i></button>
                    </div>
                    <div class="form-group">
                        <!-- <button class="radius" name="search" value="Search"></button> -->
                        <button class="radius" style="outline: none" name="filter-modal" type="button" data-toggle="modal" data-target="#filter-modal"><?php esc_html_e( 'Filter', 'classiera' ); ?><i class="fa fa-filter icon-with-btn-right pull-right flip"></i></button>
                    </div>
				</form>
			</div><!--col-md-12-->
		</div><!--row-->
	</div><!--container-->
</section><!--search-section-->

<!-- Modal -->
<div class="modal fade" id="filter-modal" tabindex="-1" role="dialog" aria-labelledby="FilterModal">
  <div class="modal-dialog filter-modal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" style="outline: none;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
        <h4 class="modal-title text-uppercase" id="FilterModal"><?php esc_html_e('Advanced Filter', 'classiera'); ?></h4>
      </div>
      <div class="modal-body">
        
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		  <div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="headingOne">
		      <h4 class="panel-title">
		        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
		          Collapsible Group Item #1 
		        </a>
		      </h4>
		    </div>
		    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
		      <div class="panel-body">

				<div class="input-group">
					<span><?php esc_html_e('Select Category', 'classiera'); ?></span>
					<select class="form-control" name="filter-category" id="filter-category">
						<option value="" selected disabled><?php esc_html_e('Choose Category', 'classiera'); ?></option>
						<option value="Escort"><?php esc_html_e('Escort', 'classiera'); ?></option>
					</select>
				</div>

				<div class="input-group">
					<span><?php esc_html_e('Select Age Range', 'classiera'); ?></span>
					Filter by price interval: <b>€ 10</b> <input id="age-range" type="text" class="span2" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[250,450]"/> <b>€ 1000</b>
				</div>

		      </div>
		    </div>
		  </div>
		  <div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="headingTwo">
		      <h4 class="panel-title">
		        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
		          Collapsible Group Item #2
		        </a>
		      </h4>
		    </div>
		    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
		      <div class="panel-body">
		        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
		      </div>
		    </div>
		  </div>
		  <div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="headingThree">
		      <h4 class="panel-title">
		        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
		          Collapsible Group Item #3
		        </a>
		      </h4>
		    </div>
		    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
		      <div class="panel-body">
		        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
		      </div>
		    </div>
		  </div>
		</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary filter-button"><?php esc_html_e('Filter', 'classiera'); ?></button>
        <button type="button" class="btn btn-primary filter-button" data-dismiss="modal"><?php esc_html_e('Cancel', 'classiera'); ?></button>
      </div>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){
		var mySlider = $("#age-range").slider();
	});
</script>