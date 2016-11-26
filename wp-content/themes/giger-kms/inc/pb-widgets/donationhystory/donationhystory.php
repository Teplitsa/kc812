<?php
/*
Widget Name: [TST] История пожертвований
Description: Несколько последних пожертвований и ссылка на полную историю
*/

class TST_DonationHystory_Widget extends SiteOrigin_Widget {
	
	function __construct() {
		
		parent::__construct(
			'tst-donationhystory',
			'[TST] История пожертвований',
			array(
				'description' => 'Несколько последних пожертвований и ссылка на полную историю'				
			),
			array(
				
			),
			false,
			plugin_dir_path(__FILE__)
		);
			
	}
	
	/* abstract method - we not going to use them */
	function get_template_name($instance) {
		return '';
	}
	
	function get_style_name($instance) {
		return '';
	}
	
	/** admin form **/
	function initialize_form(){

		return array(
			'title' => array(
				'type' => 'text',
				'label' => __('Title', 'tst')
			),
			'post_id' => array(
				'type' => 'text',
				'label' => 'ID кампании',
				'description' => 'Для текущей кампании - оставить пустым'
			),
			'posts_per_page' => array(
				'type' => 'text',
				'label' => 'Количество (по умолчанию - 5)'
			)			
		);
	}
	
	/** prepare data for template **/	
	public function get_template_variables( $instance, $args ) {
		return array(
			'title'		=> $instance['title'],
			'post_id' 	=> (int)($instance['post_id']),
			'posts_per_page' => (int)($instance['posts_per_page'])
		);
	}
	
		public function widget( $args, $instance ) {
		
		if(!function_exists('leyka_get_donors_list'))
			return;
		
		if( empty( $this->form_options ) ) {
			$this->form_options = $this->initialize_form();
		}

		$instance = $this->modify_instance($instance);

		// Filter the instance
		$instance = apply_filters( 'siteorigin_widgets_instance', $instance, $this );
		$instance = apply_filters( 'siteorigin_widgets_instance_' . $this->id_base, $instance, $this );

		$args = wp_parse_args( $args, array(
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '',
			'after_title' => '',
		) );

		// Add any missing default values to the instance
		$instance = $this->add_defaults( $this->form_options, $instance );
		$template_vars = $this->get_template_variables($instance, $args);
		extract( $template_vars );
		
		$css_name = $this->generate_and_enqueue_instance_styles( $instance );
		
			echo $args['before_widget'];
			echo '<div class="so-widget-'.$this->id_base.' so-widget-'.$css_name.'">';
			
			if(!empty($title)){
				echo $args['before_title'];
				echo apply_filters('tst_the_title', $title);
				echo $args['after_title'];
			}
			
			$post_id = ($post_id) ? $post_id : get_queried_object_id();
			$posts_per_page = (!$posts_per_page) ? 5 : $posts_per_page;
			
			echo leyka_get_donors_list($post_id, array('num' => $posts_per_page, 'show_purpose' => 0));
		?>
			<div class="all-link"><a href="<?php echo get_permalink($post_id);?>donations"><?php _e('Full list', 'tst');?>&nbsp;&rarr;</a></div>			
		<?php	
			echo '</div>';
			echo $args['after_widget'];
	}
	
} //class

//register
siteorigin_widget_register('tst-donationhystory', __FILE__, 'TST_DonationHystory_Widget');

