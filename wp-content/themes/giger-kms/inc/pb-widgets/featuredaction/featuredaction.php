<?php
/*
Widget Name: [TST] Заставка
Description: Стартовая заставка с изображением, текстом и кнопкой (опционально)
*/

class TST_FeaturedItem_Widget extends SiteOrigin_Widget {
	
	function __construct() {
		
		parent::__construct(
			'tst-featureditem',
			'[TST] Заставка',
			array(
				'description' => 'Стартовая заставка с изображением, текстом и кнопкой (опционально)'		
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
			'post_id' => array(
				'type' => 'text',
				'label' => __('ID of linked post', 'tst'),
				'description' => __('Could be post, project, event - provide fallback for empty fields', 'tst')
			),		 
					
			'image' => array(
				'type' => 'media',
				'label' => __('Image file', 'tst'),
				'library' => 'image',
				'fallback' => true,
			),		

			'title' => array(
				'type' => 'text',
				'label' => __('Title text', 'tst'),
			),
			
			'subtitle' => array(
				'type' => 'textarea',
				'label' => __('Sub title text', 'tst'),
				'rows' => 4
			),
			
			/*'extend_width' => array(
				'type' => 'checkbox',
				'default' => false,
				'label' => __('Extend Width', 'tst'),
				'description' => 'Макет шире основной колонки',
			),*/
			
			'link_section' => array(
				'type' => 'section',
				'label' => __('Link settings', 'tst'),
				'hide' => true,
				'fields' => array(					
					'link' => array(
						'type' => 'link',
						'label' => __('Button link', 'tst'),
					),
					'link_text' => array(
						'type' => 'text',
						'label' => __('Button text', 'tst'),
					),					
					'link_style' => array(
						'type' => 'select',
						'label' => __( 'Style', 'tst' ),
						'default' => 'below',
						'options' => array(
							'below' => __( 'Text below image', 'tst' ),
							'over'   => __( 'Text over image', 'tst' )										
						)
					),
				)
			)
		);
	}
	
	/** prepare data for template **/	
	public function get_template_variables( $instance, $args ) {
		return array(			
			'title'		=> $instance['title'],
			'subtitle'	=> $instance['subtitle'],			
			'image'		=> (int)$instance['image'],
			'post_id' 	=> (int)$instance['post_id'],
			'link'  	=> (isset($instance['link_section']['link'])) ? $instance['link_section']['link'] : '',
			'link_text' => (isset($instance['link_section']['link_text'])) ? $instance['link_section']['link_text'] : '',
			'link_style'=> (isset($instance['link_section']['link_style'])) ? $instance['link_section']['link_style'] : ''
			//'extend_width' => (bool)$instance['extend_width']
		);
	}
	
	public function widget( $args, $instance ) {
	
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
		
		$сpost = (!empty($post_id)) ? get_post($post_id) : '';
		
		if($сpost) {
			$title = (!$title && $сpost) ? get_the_title($сpost) : $title;
			$subtitle = (!$subtitle) ? $сpost->post_excerpt : $subtitle;
			$image = (!$image) ? get_post_thumbnail_id($сpost) : $image;
			$link = (!$link) ? get_permalink($сpost) : $link;
			$link_text = (!$link_text) ? __('More details', 'tst') : $link_text;
		}
		
        $card_callback = "tst_intro_card_markup_".$link_style;
		
		if(is_callable($card_callback)) {
			echo $args['before_widget'];
			echo '<div class="so-widget-'.$this->id_base.' so-widget-'.$css_name.'">';
			
			call_user_func_array($card_callback, array($title, $subtitle, $image, $link, $link_text));		
			
			echo '</div>';
			echo $args['after_widget'];
		}
	}
	
	
	
} //class

//register
siteorigin_widget_register('tst-featureditem', __FILE__, 'TST_FeaturedItem_Widget');

