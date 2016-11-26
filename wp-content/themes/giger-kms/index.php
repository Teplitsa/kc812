<?php
/**
 * The main template file.
 */
 
$posts = $wp_query->posts;
$paged = (get_query_var('paged', 0)) ? get_query_var('paged', 0) : 1;

get_header();
?>
<section class="heading">
	<div class="container">
		<?php tst_section_title(); ?>
		<div class="blog-menu"><?php wp_nav_menu(array('theme_location'=> 'primary', 'container' => false, 'fallback_cb' => false));?></div>
	</div>
</section>

<section class="main-content"><div class="container-narrow">

	<?php
		if(!empty($posts)){
			foreach($posts as $p){
				tst_post_card($p);
			}
		}
		else {
			echo '<p>Ничего не найдено</p>';
		}
	?>
	<div class="paging"><?php tst_paging_nav($wp_query); ?></div>
	
</div></section>

<?php get_footer();