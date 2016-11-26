<?php
/** Facebook author tag - till 4.4 **/
add_action('wp_head', 'tst_facebook_author_tag');
function tst_facebook_author_tag() {	
	
	if(!is_singular('post'))
		return;
	
	if(!tst_has_authors())
		return;
		
	$author = tst_get_post_author(get_queried_object());
	if(!$author || is_wp_error($author))
		return;
		
	$fb = get_term_meta($author->term_id, 'auctor_facebook', true);	
	
	if(!empty($fb)) {
?>
	<meta property="article:author" content="<?php echo esc_url($fb);?>" />
<?php
	}
}


/** Default author avatar **/
function tst_get_default_author_avatar(){
	
	$alt = __('Author', 'tst');
	$img = '';
	
	$def_img_id = attachment_url_to_postid(get_theme_mod('default_avatar'));
	if(!empty($def_img_id)){
		$img = 	wp_get_attachment_image($def_img_id, 'thumbnail', array('alt' => $alt));
	}
	else {		
		$img = "<img src='".get_template_directory_uri()."/assets/images/author-default.jpg' alt='{$alt}'>";
	}
		
	return $img;
}


function tst_get_post_author($cpost) {
	
	if(!tst_has_authors())
		return false;
		
	$author = get_the_terms($cpost->ID, 'auctor');
	if(!empty($author) && !is_wp_error($author))
		$author = $author[0];
	
	return $author;
}

function tst_get_author_avatar($author_term_id) {

	$avatar = get_term_meta($author_term_id, 'auctor_photo', true);

    return $avatar ? wp_get_attachment_image($avatar, 'avatar') : tst_get_default_author_avatar();
}
