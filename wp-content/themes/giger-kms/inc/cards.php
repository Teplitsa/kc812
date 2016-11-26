<?php

/** == Posts elements == **/
function tst_post_card(WP_Post $cpost){
	
	$pl = get_permalink($cpost);
	$ex = apply_filters('tst_the_title', tst_get_post_excerpt($cpost, 40, true));
	$src = tst_post_thumbnail_src($cpost, 'post-thumbnail');
?>
<article class="tpl-post card">
	<a href="<?php echo $pl; ?>" class="thumbnail-link">
		<div class="entry-preview"><div class="tpl-pictured-bg" style="background-image: url(<?php echo $src;?>);" ></div></div>
	</a>	
	<div class="entry-data">		
		<h4 class="entry-title"><a href="<?php echo $pl; ?>"><?php echo get_the_title($cpost);?></a></h4>
		<div class="entry-meta"><?php echo tst_posted_on($cpost);?></div>
		<div class="entry-summary"><?php echo $ex;?></div>
		<div class="read-more"><a href="<?php echo $pl; ?>" class="ghost-button">Читать дальше</a></div>
	</div>	
</article>
<?php
}

function tst_intro_card_markup_below($title, $subtitle, $img_id, $link = '', $button_text = '') {
	
	$button_text = (!empty($button_text)) ? $button_text : __('More', 'tst');
	$has_sharing = (!empty($link)) ? false : true;
?>
	<section class="intro-head-image">
		<div class="tpl-pictured-bg" style="background-image: url(<?php echo wp_get_attachment_url( $img_id );?>)"></div>
	</section>
	<section class="intro-head-content<?php if(!empty($link)) { echo '  has-button'; }?>"><div class="ihc-content">
		<h1 class="ihc-title"><?php if(!empty($link)) { ?><a href="<?php echo esc_url($link);?>"><?php } ?>
			<?php echo apply_filters('tst_the_title', $title);?>
			<?php if(!empty($link)) { ?></a><?php } ?>
		</h1>
		<?php if($subtitle){ ?>
			<div class="frame">
				<div class="bit <?php if(!empty($link)){ echo 'md-8 exlg-9'; }?> ihc-desc"><?php echo apply_filters('tst_the_content', $subtitle); ?></div>
				<?php if(!empty($link)) { ?>
				<div class="bit md-4 exlg-3"><a href="<?php echo esc_url($link);?>"><?php echo $button_text;?></a></div>
				<?php } ?>
			</div>
		<?php } ?>	
	</div></section>
	<?php if($has_sharing) { ?>	
		<div class="mobile-sharing hide-on-medium"><?php echo tst_social_share_no_js();?></div>
	<?php }?>
<?php
}

function tst_intro_card_markup_over($title, $subtitle, $img_id, $link = '', $button_text = '', $style = 'below') {
	
	$button_text = (!empty($button_text)) ? $button_text : __('More', 'tst');
	$has_sharing = (!empty($link)) ? false : true;
	
?>
	<section class="intro-head-image text-over-image">
		<div class="tpl-pictured-bg" style="background-image: url(<?php echo wp_get_attachment_url( $img_id );?>)"></div>
	</section>
	<section class="intro-head-content text-over-image<?php if(!empty($link)) { echo '  has-button'; }?>"><div class="ihc-content">
	<?php if(!empty($link)) { ?><a href="<?php echo esc_url($link);?>"><?php } ?>
	
		<h1 class="ihc-title"><span><?php echo apply_filters('tst_the_title', $title);?></span></h1>
		<?php if($subtitle){ ?>
			<div class="ihc-desc"><?php echo apply_filters('tst_the_content', $subtitle); ?></div>
		<?php } ?>
		<?php if(!empty($link)) { ?>
			<div class="cta"><?php echo $button_text;?></div>
		<?php } ?>		
		
	<?php if(!empty($link)) { ?></a><?php } ?>
	</div></section>
	<?php if($has_sharing) { ?>	
		<div class="mobile-sharing hide-on-medium"><?php echo tst_social_share_no_js();?></div>
	<?php }

}


function tst_related_post_card(WP_Post $cpost) {

	$pl = get_permalink($cpost);
	$ex = apply_filters('tst_the_title', tst_get_post_excerpt($cpost, 40, true));
?>
<article class="tpl-related-post card"><a href="<?php echo $pl; ?>" class="entry-link">	
	<div class="entry-preview"><?php echo tst_post_thumbnail($cpost->ID, 'post-thumbnail');?></div>
	<div class="entry-data">
		<?php if('project' != $cpost->post_type) { ?>
		<div class="entry-meta"><?php echo strip_tags(tst_posted_on($cpost), '<span>');?></div>
		<?php } ?>
		<h4 class="entry-title"><?php echo get_the_title($cpost);?></h4>
		<div class="entry-summary"><?php echo $ex;?></div>		
	</div>
</a></article>	
<?php
}

function tst_event_card(WP_Post $cpost){
		
	//162	
	$event = new TST_Event($cpost);
	
	$pl = get_permalink($event->post_object);	
	
?>
<article class="tpl-event card" <?php echo $event->get_event_schema_prop();?>">
	<a href="<?php echo $pl; ?>" class="thumbnail-link" <?php echo $event->get_event_url_prop();?>>
	<div class="entry-preview"><?php echo tst_post_thumbnail($cpost->ID, 'post-thumbnail');?></div>
	<div class="entry-data">
		<div class="entry-meta"><?php echo $event->posted_on_card();?></div>
		<h4 class="entry-title" <?php echo $event->get_event_name_prop();?>><?php echo get_the_title($cpost);?></h4>
		<div class="entry-summary">
			<p><?php echo apply_filters('tst_the_title', $event->get_participants_mark());?></p>
			<p><?php echo apply_filters('tst_the_title', $event->get_full_address_mark());?></p>
			<?php echo $event->get_event_offer_field();?>
		</div>
	</div>
	</a>
</article>
<?php
}


/* People and orgs */
function tst_person_card(WP_Post $cpost, $linked = true){
	$pl = get_permalink($cpost);	
?>
<article class="tpl-person card <?php if($linked) { echo 'linked'; }?>">
<?php if($linked) {?> <a href="<?php echo $pl; ?>" class="entry-link"><?php } ?>
	
	<div class="entry-preview"><?php echo tst_post_thumbnail($cpost->ID, 'square');?></div>
	<div class="entry-data">
		<h4 class="entry-title"><?php echo get_the_title($cpost);?></h4>
		<div class="entry-meta"><?php echo apply_filters('tst_the_title', $cpost->post_excerpt);?></div>
	</div>
	
<?php if($linked) {?></a><?php } ?>
</article>
<?php
}

function tst_person_card_group(WP_Post $cpost){
	
	$linked = ($cpost->widget_class == 'linked-card') ? true : false;
	
	tst_person_card($cpost, $linked);	
}

function tst_person_card_single(WP_Post $cpost){
	
	$linked = ($cpost->widget_class == 'linked-card') ? true : false;
	
	tst_person_card($cpost, $linked);	
}


function tst_org_card(WP_Post $cpost){
	
	$pl = esc_url($cpost->post_excerpt);
?>
<article class="tpl-org logo">
	<a href="<?php echo $pl;?>" class="logo-link logo-frame" target="_blank" title="<?php echo esc_attr($cpost->post_title);?>">
		<span><?php echo get_the_post_thumbnail($cpost->ID, 'full'); ?></span>
	</a>
</article>
<?php
}

function tst_org_card_group(WP_Post $cpost){

?>
<div class="bit bit-no-margin sm-6 md-3 lg-col-5"><?php tst_org_card($cpost); ?></div>
<?php
}

function tst_org_card_single(WP_Post $cpost){
		
	tst_org_card($cpost);	
}


/** search **/
function tst_search_card(WP_Post $cpost) {
	
	$pl = get_permalink($cpost);
	$ex = apply_filters('tst_the_title', tst_get_post_excerpt($cpost, 40, true));
	
	
?>
<article class="tpl-search"><a href="<?php echo $pl; ?>" class="entry-link">
	<div class="entry-meta"><?php echo strip_tags(tst_posted_on($cpost), '<span>');?></div>
	<h4 class="entry-title"><?php echo get_the_title($cpost);?></h4>
	<div class="entry-summary"><?php echo $ex;?></div>
</a></article>
<?php
}





/** == Helpers == **/

/** Excerpt **/
function tst_get_post_excerpt($cpost, $l = 30, $force_l = false){
	
	if(is_int($cpost))
		$cpost = get_post($cpost);
	
	$e = (!empty($cpost->post_excerpt)) ? $cpost->post_excerpt : wp_trim_words(strip_shortcodes($cpost->post_content), $l);
	if($force_l)
		$e = wp_trim_words($e, $l);	
	
	return $e;
}


/** Deafult thumbnail for posts **/
function tst_get_default_post_thumbnail($type = 'default_thumbnail', $size){
		
	$default_thumb_id = attachment_url_to_postid(get_theme_mod($type));
	$img = '';
	if($default_thumb_id){
		$img = wp_get_attachment_image($default_thumb_id, $size);	
	}
	
	return $img;
}

function tst_post_thumbnail($post_id, $size = 'post-thumbnail'){
	
	$thumb = get_the_post_thumbnail($post_id, $size);
	
	if(!$thumb){
		$thumb = tst_get_default_post_thumbnail('default_thumbnail', $size);
	}
			
	return $thumb;
}

function tst_post_thumbnail_src($post_id, $size = 'post-thumbnail'){
	
	$src = get_the_post_thumbnail_url($post_id, $size);
	if(!$src){
		$default_thumb_id = attachment_url_to_postid(get_theme_mod('default_thumbnail'));
		if($default_thumb_id){
			$src = wp_get_attachment_image_src($default_thumb_id, $size);
			$src = ($src) ? $src[0] : '';
		}
	}
	
	return $src;
}

/** Cards for campaigns **/
function tst_leyka_campaign_card($cpost) {

	$callback = 'tst_default_campaign_card';
	
	if(has_term('programms', 'campaign_cat', $cpost)){
		$callback = 'tst_project_campaign_card';
	}
	elseif(has_term('children', 'campaign_cat', $cpost)){
		$callback = 'tst_child_campaign_card';
	}
	else {
		//test for child term
	}
	
	if(is_callable($callback)){
		call_user_func_array($callback, array($cpost));
	}
}


function tst_project_campaign_card($cpost) {
	
	$pl = get_permalink($cpost);
?>
<article class="tpl-programm card"><a href="<?php echo $pl; ?>" class="entry-link">	
	<div class="entry-preview"><?php echo tst_post_thumbnail($cpost->ID, 'square');?></div>
	<h4 class="entry-title"><span><?php echo get_the_title($cpost);?></span></h4>
</a></article>
<?php
}

function tst_child_campaign_card($cpost) {
	
	$pl = get_permalink($cpost);
	$src = tst_post_thumbnail_src($cpost, 'post-thumbnail');
?>
<article class="tpl-child card"><div class="child-card-content">
	<a href="<?php echo $pl; ?>" class="thumbnail-link">
		<div class="entry-preview"><div class="tpl-pictured-bg" style="background-image: url(<?php echo $src;?>);" ></div></div>
		<div class="entry-data">		
			<h4 class="entry-title"><?php echo get_the_title($cpost);?></h4>
			<?php tst_child_meta($cpost); ?>		
		</div>
	</a>
	<?php if(function_exists('leyka_get_scale') && !has_term('rosemary', 'campaign_cat', $cpost)) {?>
		<?php echo leyka_get_scale($cpost, array('show_button' => 1));?>
	<?php }?>
</div></article>
<?php
}

function tst_child_meta($cpost){
	
	$age  = get_post_meta($cpost->ID, 'campaign_child_age', true);
	$city = get_post_meta($cpost->ID, 'campaign_child_city', true);
	$diag = get_post_meta($cpost->ID, 'campaign_child_diagnosis', true);
	$summary = '';
	
	if(empty($age) && empty($city) && empty($diag)){
		$summary = apply_filters('tst_the_title', tst_get_post_excerpt($cpost, 40, true));
	}
?>
	<div class="child-meta">	
	<?php if(!empty($age)) { ?>	
		<p><span class="label"><?php _e('Age', 'tst');?>:</span> <?php echo apply_filters('tst_the_title', $age);?></p>
	<?php } ?>
	<?php if(!empty($city)) { ?>	
		<p><span class="label"><?php _e('City', 'tst');?>:</span> <?php echo apply_filters('tst_the_title', $city);?></p>
	<?php } ?>
	<?php if(!empty($diag)) { ?>	
		<p><span class="label"><?php _e('Diagnosis', 'tst');?>:</span> <?php echo apply_filters('tst_the_title', $diag);?></p>
	<?php } ?>
	<?php if(!empty($summary)) { ?>	
		<p><?php echo $summary;?></p>
	<?php } ?>
	</div>
<?php
}

function tst_default_campaign_card($cpost) {

	$pl = get_permalink($cpost);
	$ex = apply_filters('tst_the_title', tst_get_post_excerpt($cpost, 25, true));
	
?>
<article class="tpl-campaign default card">
	<a href="<?php echo $pl; ?>" class="thumbnail-link">
	<div class="entry-preview"><?php echo tst_post_thumbnail($cpost->ID, 'post-thumbnail');?></div>
	<div class="entry-data">		
		<h4 class="entry-title"><?php echo get_the_title($cpost);?></h4>
		<div class="entry-summary"><?php echo $ex;?></div>
		<div class="entry-help"><span><?php _e('Donate', 'tst');?></span></div>
	</div>
	</a>
</article>
<?php
}
