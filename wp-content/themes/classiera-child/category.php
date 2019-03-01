<?php
/**
 * The template for displaying Category pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */

get_header(); 
?>

<?php get_template_part( 'templates/searchbar/searchstyle2' ); ?>
<!-- page content -->
<section class="inner-page-content border-bottom top-pad-50">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<!-- advertisement -->
				<?php get_template_part( 'templates/catinner/style4' ); ?>
				<?php //get_template_part( 'templates/classiera-loops/loop-canary' ); ?>
				<!-- advertisement -->
			</div><!--col-md-8-->
		</div><!--row-->
	</div><!--container-->
</section>	
<!-- page content -->
<?php get_footer(); ?>