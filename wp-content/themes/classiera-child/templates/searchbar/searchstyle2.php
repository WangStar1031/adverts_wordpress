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
	global $wpdb;
	$post = $wpdb->prefix . 'posts';
	$sql = 'select ID from ' . $post . ' where post_status="publish" and post_type="post"';
	$queryRes = $wpdb->get_results($sql);
	$arrIds = [];
	foreach ($queryRes as $value) {
		$arrIds[] = $value->ID;
	}
	$strInIDs = "";
	if( count($arrIds) != 0){
		$strInIDs = " and post_id in (" . implode(",", $arrIds) . ")";
	}

	$postmeta=$wpdb->prefix.'postmeta';
	$sql='select MIN(meta_value) as min, MAX(meta_value) as max from ' . $postmeta . ' where meta_key="user_age"' . $strInIDs;
	$queryRes=$wpdb->get_results($sql);
	$ageMin = 18;
	$ageMax = 99;
	if( $queryRes != false){
		$ageMin = $ageMin > $queryRes[0]->min ? $ageMin : $queryRes[0]->min;
		$ageMax = $queryRes[0]->max;
	}
	$ageAvg1 = $ageMin;
	$ageAvg2 = $ageMax;

	$sql='select distinct meta_value as val from ' . $postmeta . ' where meta_key="native_language"' . $strInIDs;
	$queryRes=$wpdb->get_results($sql);
	$arrLangs = [];
	foreach ($queryRes as $value) {
		$arrLangs[] = $value->val;
	}

	$sql='select distinct meta_value as val from ' . $postmeta . ' where meta_key="hair_color"' . $strInIDs;
	$queryRes=$wpdb->get_results($sql);
	$arrHairCols = [];
	foreach ($queryRes as $value) {
		$arrHairCols[] = $value->val;
	}

	$sql='select distinct meta_value as val from ' . $postmeta . ' where meta_key="eyes_color"' . $strInIDs;
	$queryRes=$wpdb->get_results($sql);
	$arrEyeCols = [];
	foreach ($queryRes as $value) {
		$arrEyeCols[] = $value->val;
	}

	$sql='select distinct meta_value as val from ' . $postmeta . ' where meta_key="ethnicity"' . $strInIDs . ' order by meta_value';
	$queryRes=$wpdb->get_results($sql);
	$arrEthnicity = [];
	foreach ($queryRes as $value) {
		$arrEthnicity[] = $value->val;
	}

	$sql='select MIN(meta_value) as min, MAX(meta_value) as max from ' . $postmeta . ' where meta_key="weight"' . $strInIDs;
	$queryRes=$wpdb->get_results($sql);
	$weightMin = 40;
	$weightMax = 99;
	if( $queryRes != false){
		$weightMin = $queryRes[0]->min;
		$weightMax = $queryRes[0]->max;
		// $weightAvg1 = intval(($weightMin * 2 + $weightMax) / 3);
		// $weightAvg2 = intval(($weightMin + $weightMax * 2) / 3);
	}
	$weightAvg1 = $weightMin;
	$weightAvg2 = $weightMax;
	
	$sql='select MIN(meta_value) as min, MAX(meta_value) as max from ' . $postmeta . ' where meta_key="waist_size"' . $strInIDs;
	$queryRes=$wpdb->get_results($sql);
	$waistMin = 40;
	$waistMax = 99;
	if( $queryRes != false){
		$waistMin = $queryRes[0]->min;
		$waistMax = $queryRes[0]->max;
		// $waistAvg1 = intval(($waistMin * 2 + $waistMax) / 3);
		// $waistAvg2 = intval(($waistMin + $waistMax * 2) / 3);
	}
	$waistAvg1 = $waistMin;
	$waistAvg2 = $waistMax;

	$sql='select MIN(meta_value) as min, MAX(meta_value) as max from ' . $postmeta . ' where meta_key="hips_size"' . $strInIDs;
	$queryRes=$wpdb->get_results($sql);
	$hipsMin = 40;
	$hipsMax = 99;
	if( $queryRes != false){
		$hipsMin = $queryRes[0]->min;
		$hipsMax = $queryRes[0]->max;
		// $hipsAvg1 = intval(($hipsMin * 2 + $hipsMax) / 3);
		// $hipsAvg2 = intval(($hipsMin + $hipsMax * 2) / 3);
	}
	$hipsAvg1 = $hipsMin;
	$hipsAvg2 = $hipsMax;
	
	$sql='select distinct meta_value as val from ' . $postmeta . ' where meta_key="dress_size"' . $strInIDs .' order by meta_value';
	$queryRes=$wpdb->get_results($sql);
	$arrDressSize = [];
	foreach ($queryRes as $value) {
		$arrDressSize[] = $value->val;
	}
	
	$sql='select distinct meta_value as val from ' . $postmeta . ' where meta_key="shoe_size"' . $strInIDs . ' order by meta_value';
	$queryRes=$wpdb->get_results($sql);
	$arrShoeSize = [];
	foreach ($queryRes as $value) {
		$arrShoeSize[] = $value->val;
	}

	$sql='select distinct meta_value as val from ' . $postmeta . ' where meta_key="pubic_area"' . $strInIDs . ' order by meta_value';
	$queryRes=$wpdb->get_results($sql);
	$arrPubicArea = [];
	foreach ($queryRes as $value) {
		$arrPubicArea[] = $value->val;
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
						<div id="collapseOne" class="panel-collapse collapse in clearfix" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body col-lg-12 col-md-12 col-xs-12">
								<!-- Age -->
								<div class="row">
									<div class="col-md-4 col-lg-4">
										<?php esc_html_e('Select Age Range', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<table class="col-md-12 col-lg-12">
											<tr>
												<td><?=$ageMin?></td>
												<td class="rangeTd">
													<input id="age-range" type="text" class="span2 form-control" value="" data-slider-min="<?=$ageMin?>" data-slider-max="<?=$ageMax?>" data-slider-step="1" data-slider-value="[<?=$ageAvg1?>,<?=$ageAvg2?>]"/>
												</td>
												<td><?=$ageMax?></td>
											</tr>
										</table>
									</div>
								</div>
								<!-- Category -->
								<div class="row">
									<div class="col-md-4 col-lg-4">
										<?php esc_html_e('Select Category', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<select class="form-control" name="filter-category" id="filter-category">
											<option value="" selected disabled><?php esc_html_e('Choose Category', 'classiera'); ?></option>
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
												<option value="<?php echo esc_attr($catID); ?>">
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
													<option value="<?php echo esc_attr($cat->cat_ID); ?>">- <?php echo esc_html($cat->cat_name); ?></option>	
														<?php
													}
												}
											}
											?>
										</select>
									</div>
								</div>

								<!-- Native Language -->
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<?php esc_html_e('Native Language', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<select class="form-control" name="filter-category" id="nat_lang">
											<option value="" selected disabled><?php esc_html_e('Choose Native Language', 'classiera'); ?></option>
											<?php
											foreach ($arrLangs as $value) {
											?>
											<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<!-- Hair color -->
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<?php esc_html_e('Hair color', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<select class="form-control" name="filter-category" id="hair_color">
											<option value="" selected disabled><?php esc_html_e('Hair color', 'classiera'); ?></option>
											<?php
											foreach ($arrHairCols as $value) {
											?>
											<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<!-- Eyes color -->
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<?php esc_html_e('Eyes color', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<select class="form-control" name="filter-category" id="eyes_color">
											<option value="" selected disabled><?php esc_html_e('Eyes color', 'classiera'); ?></option>
											<?php
											foreach ($arrEyeCols as $value) {
											?>
											<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<!-- Ethnicity -->
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<?php esc_html_e('Ethnicity', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<select class="form-control" name="filter-category" id="ethnicity">
											<option value="" selected disabled><?php esc_html_e('Ethnicity', 'classiera'); ?></option>
											<?php
											foreach ($arrEthnicity as $value) {
											?>
											<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<!-- Weight -->
								<div class="row">
									<div class="col-md-4 col-lg-4">
										<?php esc_html_e('Select Weight Range', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<table class="col-md-12 col-lg-12">
											<tr>
												<td><?=$weightMin?></td>
												<td class="rangeTd">
													<input id="weight-range" type="text" class="span2 form-control" value="" data-slider-min="<?=$weightMin?>" data-slider-max="<?=$weightMax?>" data-slider-step="1" data-slider-value="[<?=$weightAvg1?>,<?=$weightAvg2?>]"/>
												</td>
												<td><?=$weightMax?></td>
											</tr>
										</table>
									</div>
								</div>

								<!-- Waist Size -->
								<div class="row">
									<div class="col-md-4 col-lg-4">
										<?php esc_html_e('Select Waist Size Range', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<table class="col-md-12 col-lg-12">
											<tr>
												<td><?=$waistMin?></td>
												<td class="rangeTd">
													<input id="waist-range" type="text" class="span2 form-control" value="" data-slider-min="<?=$waistMin?>" data-slider-max="<?=$waistMax?>" data-slider-step="1" data-slider-value="[<?=$waistAvg1?>,<?=$waistAvg2?>]"/>
												</td>
												<td><?=$waistMax?></td>
											</tr>
										</table>
									</div>
								</div>

								<!-- Hips Size -->
								<div class="row">
									<div class="col-md-4 col-lg-4">
										<?php esc_html_e('Select Hips Size Range', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<table class="col-md-12 col-lg-12">
											<tr>
												<td><?=$hipsMin?></td>
												<td class="rangeTd">
													<input id="hips-range" type="text" class="span2 form-control" value="" data-slider-min="<?=$hipsMin?>" data-slider-max="<?=$hipsMax?>" data-slider-step="1" data-slider-value="[<?=$hipsAvg1?>,<?=$hipsAvg2?>]"/>
												</td>
												<td><?=$hipsMax?></td>
											</tr>
										</table>
									</div>
								</div>

								<!-- Dress Size -->
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<?php esc_html_e('Dress Size', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<select class="form-control" name="filter-category" id="dress_size">
											<option value="" selected disabled><?php esc_html_e('Dress Size', 'classiera'); ?></option>
											<?php
											foreach ($arrDressSize as $value) {
											?>
											<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>

								<!-- Shoe Size -->
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<?php esc_html_e('Shoe Size', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<select class="form-control" name="filter-category" id="shoe_size">
											<option value="" selected disabled><?php esc_html_e('Shoe Size', 'classiera'); ?></option>
											<?php
											foreach ($arrShoeSize as $value) {
											?>
											<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>

								<!-- Pubic Area -->
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<?php esc_html_e('Pubic Area', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<select class="form-control" name="filter-category" id="pubic_area">
											<option value="" selected disabled><?php esc_html_e('Pubic Area', 'classiera'); ?></option>
											<?php
											foreach ($arrPubicArea as $value) {
											?>
											<option value="<?=$value?>"><?php esc_html_e($value, 'classiera'); ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>

								<!-- Smoker -->
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<?php esc_html_e('Smoker', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<select class="form-control" name="filter-category" id="smoker">
											<option value="" selected disabled><?php esc_html_e('Are you Smoker?', 'classiera'); ?></option>
											<option value="Yes"><?php esc_html_e('Yes', 'classiera'); ?></option>
											<option value="No"><?php esc_html_e('No', 'classiera'); ?></option>
										</select>
									</div>
								</div>

								<!-- Disabled Friendly -->
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<?php esc_html_e('Disabled Friendly', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<select class="form-control" name="filter-category" id="disabled-friendly">
											<option value="" selected disabled><?php esc_html_e('Disabled Friendly', 'classiera'); ?></option>
											<option value="Yes"><?php esc_html_e('Yes', 'classiera'); ?></option>
											<option value="No"><?php esc_html_e('No', 'classiera'); ?></option>
										</select>
									</div>
								</div>

								<!-- Drinks Supplied -->
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<?php esc_html_e('Drinks Supplied', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<select class="form-control" name="filter-category" id="drink-supplied">
											<option value="" selected disabled><?php esc_html_e('Drinks Supplied', 'classiera'); ?></option>
											<option value="Yes"><?php esc_html_e('Yes', 'classiera'); ?></option>
											<option value="No"><?php esc_html_e('No', 'classiera'); ?></option>
										</select>
									</div>
								</div>

								<!-- Showers Aavailable -->
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<?php esc_html_e('Showers Aavailable', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<select class="form-control" name="filter-category" id="showers-available">
											<option value="" selected disabled><?php esc_html_e('Showers Aavailable', 'classiera'); ?></option>
											<option value="Yes"><?php esc_html_e('Yes', 'classiera'); ?></option>
											<option value="No"><?php esc_html_e('No', 'classiera'); ?></option>
										</select>
									</div>
								</div>

								<!-- Available to Travel -->
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<?php esc_html_e('Available to Travel', 'classiera'); ?>
									</div>
									<div class="col-md-8 col-lg-8">
										<select class="form-control" name="filter-category" id="availabl-travel">
											<option value="" selected disabled><?php esc_html_e('Available to Travel', 'classiera'); ?></option>
											<option value="Yes"><?php esc_html_e('Yes', 'classiera'); ?></option>
											<option value="No"><?php esc_html_e('No', 'classiera'); ?></option>
										</select>
									</div>
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
				<button type="button" class="btn btn-primary filter-button" onclick="submitFilter()"><?php esc_html_e('Filter', 'classiera'); ?></button>
				<button type="button" class="btn btn-primary filter-button" data-dismiss="modal"><?php esc_html_e('Cancel', 'classiera'); ?></button>
			</div>
		</div>
	</div>
</div>
<form method="get" id="filterForm" action="<?php echo home_url(); ?>">
	<input type="hidden" name="age">
	<input type="hidden" name="category">
	<input type="hidden" name="nat_lang">
	<input type="hidden" name="hair">
	<input type="hidden" name="eyes">
	<input type="hidden" name="ethnicity">
	<input type="hidden" name="weight">
	<input type="hidden" name="waist">
	<input type="hidden" name="hips">
	<input type="hidden" name="dress">
	<input type="hidden" name="shoe">
	<input type="hidden" name="pubic">
	<input type="hidden" name="smoker">
	<input type="hidden" name="friendly">
	<input type="hidden" name="drink">
	<input type="hidden" name="showers">
	<input type="hidden" name="travel">
</form>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/bootstrap-slider.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/bootstrap-slider.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/css/bootstrap-slider.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/css/bootstrap-slider.min.css">
<style type="text/css">
	.rangeTd{
		text-align: center;
	}
</style>
<script>
	$(document).ready(function(){
		var sldAge = new Slider('#age-range', {});
		var sldWeight = new Slider('#weight-range', {});
		var sldWeight = new Slider('#waist-range', {});
		var sldWeight = new Slider('#hips-range', {});
	});
	function submitFilter(){
		$("#filterForm input[name=age]").val($("#age-range").val());
		$("#filterForm input[name=category]").val($("#filter-category").val());
		$("#filterForm input[name=nat_lang]").val($("#nat_lang").val());
		$("#filterForm input[name=hair]").val($("#hair_color").val());
		$("#filterForm input[name=eyes]").val($("#eyes_color").val());
		$("#filterForm input[name=ethnicity]").val($("#ethnicity").val());
		$("#filterForm input[name=weight]").val($("#weight-range").val());
		$("#filterForm input[name=waist]").val($("#waist-range").val());
		$("#filterForm input[name=hips]").val($("#hips-range").val());
		$("#filterForm input[name=dress]").val($("#dress_size").val());
		$("#filterForm input[name=shoe]").val($("#shoe_size").val());
		$("#filterForm input[name=pubic]").val($("#pubic_area").val());
		$("#filterForm input[name=smoker]").val($("#smoker").val());
		$("#filterForm input[name=friendly]").val($("#disabled-friendly").val());
		$("#filterForm input[name=drink]").val($("#drink-supplied").val());
		$("#filterForm input[name=showers]").val($("#showers-available").val());
		$("#filterForm input[name=travel]").val($("#availabl-travel").val());

		$("#filterForm").submit();
	}
</script>