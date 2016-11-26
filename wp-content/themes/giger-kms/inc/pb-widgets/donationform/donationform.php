<?php
/*
Widget Name: [TST] Платежная форма
Description: Вывод платежной формы
*/

class TST_PaymentForm_Widget extends SiteOrigin_Widget {
	
	function __construct() {
		
		parent::__construct(
			'tst-paymentform',
			'[TST] Платежная форма',
			array(
				'description' => 'Вывод платежной формы'				
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
				'label' => 'ID кампании',
				'description' => 'Для текущей кампании - оставить пустым'
			)			
		);
	}
	
	/** prepare data for template **/	
	public function get_template_variables( $instance, $args ) {
		return array(
			'post_id' 	=> (int)($instance['post_id'])			
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
		
			echo $args['before_widget'];
			echo '<div class="so-widget-'.$this->id_base.' so-widget-'.$css_name.'">';
		?>
			<div class="campaign-form">
			<?php tst_donation_form($post_id);?>
			</div>
		<?php	
			echo '</div>';
			echo $args['after_widget'];
	}
	
} //class

//register
siteorigin_widget_register('tst-paymentform', __FILE__, 'TST_PaymentForm_Widget');

