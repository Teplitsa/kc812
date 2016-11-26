<?php
/*
Widget Name: [TST] Блок произвольной формы
Description: Текстовый блок с фоном произвольной формы
*/

class TST_ShapeBlock_Widget extends SiteOrigin_Widget {
	
	function __construct() {
		
		parent::__construct(
			'tst-shapeblock',
			'[TST] Блок произвольной формы',
			array(
				'description' => 'Текстовый блок с фоном произвольной формы'				
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
						
			'text' => array(
				'type' => 'tinymce',
				'label' => 'Текст',
				'rows' => 6,
				'default_editor' => 'html'
			)
		);
	}
	
	/** prepare data for template **/	
	public function get_template_variables( $instance, $args ) {
		return array(
			'text'    => $instance['text']			
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
		STATIC $count = 0;
		$count++;
		
		echo $args['before_widget'];
		echo '<div class="so-widget-'.$this->id_base.' so-widget-'.$css_name.'">';
		$poly = $this->_get_polygon();
		//$poly = '<polygon points="0 0, 0.95 0.1, 1 1, 0.1 0.95" />';
	?>
	<div id="tst_block-<?php echo $count;?>" class="tst-shape-block"><div class="tst-block-content"><?php echo apply_filters('tst_entry_the_content', $text); ?></div><svg width="0" height="0"><clipPath id="clip-shape-<?php echo $count;?>" clipPathUnits="objectBoundingBox"><?php echo $poly;?></clipPath></svg></div>
	<style>
		#tst_block-<?php echo $count;?>{
			-webkit-clip-path: url("#clip-shape-<?php echo $count;?>"); 
			clip-path: url("#clip-shape-<?php echo $count;?>");
		}		
	</style>
	<?php		
		echo '</div>';
		echo $args['after_widget'];
	}
	
	protected function _get_polygon(){
		
		$polygons = array(
			'<polygon points="0 0, 0.9 0.1, 1 1, 0.12 1" />',
			'<polygon points="0.15 0, 1 0.05, 0.87 0.95, 0.07 1" />',			
			'<polygon points="0.1 0.07, 1 0, 0.85 0.9, 0 1" />',
			'<polygon points="0.09 0, 0.95 0.05, 0.9 1, 0.05 0.9" />',
		);
		
		$i = rand(0, count($polygons) - 1);
		return $polygons[$i];
	}
	
} //class

//register
siteorigin_widget_register('tst-shapeblock', __FILE__, 'TST_ShapeBlock_Widget');

