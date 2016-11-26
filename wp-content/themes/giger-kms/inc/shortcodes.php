<?php
/**
 * Shortcodes
 **/

 /** phone icon **/
add_shortcode('phone_icon', 'tst_phone_icon_screen');
function tst_phone_icon_screen($atts) {
	
	return "<i class='link-icon'>".tst_svg_icon('icon-phone', false)."</i>";
}
 
add_shortcode('mobile_icon', 'tst_mobile_icon_screen');
function tst_mobile_icon_screen($atts) {
	
	$icons = array('icon-whatsapp', 'icon-telegram', 'icon-viber');
	$out = '';
	
	foreach($icons as $id) {
		$out .= "<i class='ml-icon'>".tst_svg_icon($id, false)."</i>";
	}
	
	return "<span class='ml-links'>{$out}</span>";
}

/** map **/
add_shortcode('map_block', 'tst_map_block_screen');
function tst_map_block_screen($atts) {
	
	extract(shortcode_atts(array(				
		'url'  => ''
	), $atts));
	
	$url = esc_url($url);
	
	$out = "<div class='map-block'>";
	$out .= "<div class='map-frame'><div class='map-mobile map-pic'>".tst_svg_icon('pic-mapmobile', false)."</div><div class='map-full map-pic'><a href='{$url}' target='_blank'>".tst_svg_icon('pic-map', false)."</a></div></div>";	
	$out .= "<a href='{$url}' target='_blank'>Посмотреть на Google карте</a></div>";
	
	return $out;
}


/** gallery **/
remove_shortcode('gallery');
add_shortcode('gallery', 'tst_gallery_screen');
function tst_gallery_screen($atts){
	
	$out = gallery_shortcode($atts);
	$polygons = array(
		'<polygon points="0.07 0.06, 0.91 0, 1 0.88, 0.06 1" />',
		'<polygon points="0 0.09, 0.94 0, 1 0.89, 0.12 1" />',		
		'<polygon points="0 0, 0.88 0, 1 0.92, 0.06 1" />',
		'<polygon points="0.06 0.03, 0.95 0, 1 0.85, 0.05 0.99" />',
		'<polygon points="0 0, 0.85 0, 1 0.95, 0.09 0.98" />',
	);
	
	$clips = '';
	foreach($polygons as $i => $poly) {
		$count = $i+1;
	
$clips .= '<svg width="0" height="0" xmlns="http://www.w3.org/2000/svg"><clipPath id="polshape-'.$count.'" clipPathUnits="objectBoundingBox">'.$poly.'</clipPath></svg><style>.gallery .gallery-item:nth-of-type(5n+'.$count.')  a {  }</style>';
	
	}
	
	$clips = "<div class='gallery-clips'>{$clips}</div>";
	return $out.$clips;
}



/** sitemap **/
add_shortcode('tst_sitemap', 'tst_sitemap_screen');
function tst_sitemap_screen($atts){
	
	$out =  wp_nav_menu(array('theme_location' => 'sitemap', 'container' => false, 'menu_class' => 'sitemap', 'echo'=> false));
	
	return $out;
}


/** Youtube video caption **/
add_shortcode('yt_caption', 'tst_yt_caption_screen');
function tst_yt_caption_screen($atts, $content = null){	
	
	return '<div class="yt-caption">'.apply_filters('tst_the_content', $content).'</div>';
}


/** Buttons **/
add_shortcode('tst_btn', 'tst_btn_screen');
function tst_btn_screen($atts){
	
	extract(shortcode_atts(array(				
		'url'  => '',
		'txt'  => ''
	), $atts));
	
	if(empty($url))
		return '';
	
	$url = esc_url($url);
	$txt = apply_filters('tst_the_title', $txt);
	
	ob_start();
?>
<span class="tst-btn"><a href="<?php echo $url;?>" class="tst-button"><?php echo $txt;?></a></span>
<?php
	$out = ob_get_contents();
	ob_end_clean();
	
	return $out;
}



/** Toggle **/
if(!shortcode_exists( 'su_spoiler' ))
	add_shortcode('su_spoiler', 'tst_su_spoiler_screen');

function tst_su_spoiler_screen($atts, $content = null){
	
	extract(shortcode_atts(array(
        'title' => 'Подробнее',
        'open'  => 'no',
		'class' => ''
    ), $atts));
	
	if(empty($content))
		return '';
	
	$title = apply_filters('tst_the_title', $title);
	$class = (!empty($class)) ? ' '.esc_attr($class) : '';
	if($open == 'yes')
		$class .= ' toggled';
	
	ob_start();
?>
<div class="su-spoiler<?php echo $class;?>">
	<div class="su-spoiler-title"><span class="su-spoiler-icon"></span><?php echo $title;?></div>
	<div class="su-spoiler-content"><?php echo apply_filters('tst_the_content', $content);?></div>
</div>
<?php
	$out = ob_get_contents();
	ob_end_clean();
	
	return $out;
}

/** Quote **/
add_shortcode('tst_quote', 'tst_quote_screen');
function tst_quote_screen($atts, $content = null) {
	
	extract(shortcode_atts(array(
        'name' => '',        
		'class' => ''
    ), $atts));
	
	if(empty($content))
		return '';
	
	$name = apply_filters('tst_the_title', $name);
	$class = (!empty($class)) ? ' '.esc_attr($class) : '';
	ob_start();
?>
<div class="tst-quote <?php echo $class;?>">	
	<div class="tst-quote-content"><?php echo apply_filters('tst_the_content', $content);?></div>
	<?php if(!empty($name)) { ?>
		<div class="tst-quote-cite"><?php echo $name;?></div>
	<?php } ?>
</div>
<?php
	$out = ob_get_contents();
	ob_end_clean();
	
	return $out;
}
