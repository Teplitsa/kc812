<?php
/**
 * Donation history
 **/

$campaign_slug = get_query_var('leyka_campaign_filter');
$campaign = null; var_dump($campaign_slug);

if($campaign_slug) {
	if($campaign = get_posts(array('post_type' => 'leyka_campaign', 'name' => $campaign_slug))){		
		$campaign = reset($campaign);		
	}
}

get_header();
?>
<section class="heading">
	<div class="container">
		<?php tst_section_title(); ?>
		<?php if($campaign){ ?>
		<h4><?php _e('Campaign', 'tst');?>: <a href="<?php echo get_permalink($campaign);?>"><?php echo get_the_title($campaign);?></a></h4>
		<?php } ?>
	</div>
</section>

<section class="main-content donations-history-results"><div class="container">
	<div class="donation_history">
	<?php
		if(have_posts() && class_exists('Leyka_Donation')){
			foreach($wp_query->posts as $p){
				$donation = new Leyka_Donation($p);
				$amount = number_format($donation->sum, 0, '.', ' ');
				
				echo "<div class='ldl-item'>";
				echo "<div class='amount'>{$amount} {$donation->currency_label}</div>";
				
				$meta = array();
				$name = $donation->donor_name;
				$name = (!empty($name)) ? $name : __('Anonymous', 'leyka');				
				$meta[] = '<span>'.$name.'</span>';
				
				$meta[] = '<time>'.$donation->date_funded.'</time>';
				echo "<div class='meta'>".implode(' / ', $meta)."</div>";
				echo "</div>";
			}
		}
		else {
			echo "<p>";
			_e('No donations yet', 'tst');
			echo "</p>";
		}
	?>
	</div>
</div></section>
<section class="paging"><?php tst_paging_nav($wp_query); ?></section>

<?php get_footer();
