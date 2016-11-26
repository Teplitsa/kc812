<?php
/**
 * Widgets
 **/

global $wp_embed;
add_filter( 'widget_text', array( $wp_embed, 'run_shortcode' ), 8 );
add_filter( 'widget_text', array( $wp_embed, 'autoembed' ), 8 );
add_filter( 'widget_text', 'do_shortcode');

add_action('widgets_init', 'tst_custom_widgets', 20);
function tst_custom_widgets(){

	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Tag_Cloud');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Search');
	unregister_widget('FrmListEntries');
	//unregister_widget('FrmShowForm');
	
	//Most of widgets do not perform well with MDL as for now
	unregister_widget('Leyka_Donations_List_Widget');
	unregister_widget('Leyka_Campaign_Card_Widget');
	unregister_widget('Leyka_Campaigns_List_Widget');
	
	//Some siteOrign stranges
	unregister_widget('SiteOrigin_Widget_Features_Widget');
	unregister_widget('SiteOrigin_Widget_PostCarousel_Widget');
	unregister_widget('SiteOrigin_Widget_Button_Widget');
	unregister_widget('SiteOrigin_Panels_Widgets_PostLoop');
	
	
	
	register_widget('TST_Social_Links');
	
}

/* Remove some unused PB widget **/
add_filter( 'siteorigin_panels_widgets', 'tst_bp_panels_widgets', 11);
function tst_bp_panels_widgets( $widgets ){
	
	if(isset($widgets['SiteOrigin_Widget_Features_Widget']))
		unset($widgets['SiteOrigin_Widget_Features_Widget']);
		
	if(isset($widgets['SiteOrigin_Widget_PostCarousel_Widget']))
		unset($widgets['SiteOrigin_Widget_PostCarousel_Widget']);
		
	if(isset($widgets['SiteOrigin_Widget_Button_Widget']))
		unset($widgets['SiteOrigin_Widget_Button_Widget']);
		
	if(isset($widgets['SiteOrigin_Panels_Widgets_PostLoop']))
		unset($widgets['SiteOrigin_Panels_Widgets_PostLoop']);
	
	//var_dump($widgets);
	
	return $widgets;
}

/* PB Custom widget folder */
function tst_pb_widgets_collection($folders){
    $folders[] = get_template_directory().'/inc/pb-widgets/';
	
    return $folders;
}
add_filter('siteorigin_widgets_widget_folders', 'tst_pb_widgets_collection');


/** Test if widget registered **/
function tst_is_widget_registered($widget_class){
	global $wp_widget_factory;
	
	if(!isset($wp_widget_factory->widgets[$widget_class]))
		return false;
	
	if(!($wp_widget_factory->widgets[$widget_class] instanceof WP_Widget))
		return false;
	
	return true;
}

/** Social Links Widget **/
class TST_Social_Links extends SiteOrigin_Widget {
		
    function __construct() {
        WP_Widget::__construct('widget_socila_links', '[TST] Социальные кнопки', array(
            'classname' => 'widget_socila_links',
            'description' => 'Меню социальных кнопок',
        ));
    }

    
    function widget($args, $instance) {
        extract($args); 
		
        echo $before_widget;
       
		echo tst_get_social_menu();
				
		echo $after_widget;
    }
	
	
	
    function form($instance) {
	?>
        <p><?php _e('Widget doesn\'t have any settings', 'tst');?></p>
    <?php
    }

    
    function update($new_instance, $old_instance) {
        $instance = $new_instance;
		
		
        return $instance;
    }
	
} // class end
