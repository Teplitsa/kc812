<?php
/**
 * The template for displaying all single posts.
 *
 * @package bb
 */

$cpost = get_queried_object(); 
$format = tst_get_post_format($cpost);
$video = $thumbnail = '';


if($format == 'introvid'){
	$video = get_post_meta($cpost->ID, 'post_video', true);
	if(empty($video))
		$format = 'standard';
}

if($format == 'standard') {
	$thumbnail = tst_post_thumbnail_src($cpost->ID, 'medium-thumbnail');
}

get_header(); ?>
<section class="main-content single-post-section format-<?php echo $format;?>">
<div id="tst_sharing" class="regular-sharing hide-upto-medium"><?php echo tst_social_share_no_js();?></div>

<div class="container-narrow">
	<header class="entry-header-full">
		<div class="entry-meta"><?php echo tst_posted_on_single($cpost); //for event ?></div>
		<h1 class="entry-title"><?php echo get_the_title($cpost);?></h1>				
		<div class="mobile-sharing hide-on-medium"><?php echo tst_social_share_no_js();?></div>
		
		<div class="lead"><?php echo apply_filters('tst_the_content', $cpost->post_excerpt); ?></div>
	</header>		
			
		<?php if($format == 'standard' && $cpost->post_type != 'project') { ?>
			<div class="entry-preview standard">
				<div class="tpl-pictured-bg" style="background-image: url(<?php echo $thumbnail;?>);" ></div>						
			</div>
		<?php } elseif($format == 'introvid' && $cpost->post_type != 'project') { ?>
			<div class="entry-preview introvid player">
				<?php echo apply_filters('the_content', $video);?>
			</div>
		<?php } ?>				
			
		<div class="entry-content"><?php echo apply_filters('the_content', $cpost->post_content); ?></div>
		
		<footer class="entry-footer">
			<?php tst_post_nav();?>
		</footer>
	
</div>
</section>

<?php get_footer();