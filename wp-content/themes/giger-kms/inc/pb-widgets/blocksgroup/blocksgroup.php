<?php
/*
Widget Name: [TST] Группа блоков-карточек
Description: Вывод группы элементов в виде карточек
*/

class TST_BlocksGroup_Widget extends SiteOrigin_Widget {
	
	function __construct() {
		
		parent::__construct(
			'tst-blocksgroup',
			'[TST] Группа блоков-карточек',
			array(
				'description' => 'Вывод группы блоков-карточек (напр., люди или организации)'				
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
			'post_type' => array(
				'type' => 'select',
				'label' => 'Тип контента',
				'default' => 'person',
				'options' => array(
					'person'  => 'Люди',
					'org'     => 'Организации',
					'project' => 'Проекты',
				)
			),
			
			'exclude_ids' => array(
				'type' => 'text',
				'label' => 'ID записей - исключить',
				'description' => 'Список IDs, разделенных запятыми',
			),
						
			'taxonomy' => array(
				'type' => 'text',
				'label' => 'Таксономия'				
			),
			
			'tax_terms' => array(
				'type' => 'text',
				'label' => 'Slug терминов (через запятую)'
			),
			
			'posts_per_page' => array(
				'type' => 'text',
				'label' => 'Количество (по умолчанию - все)'
			),
			'nolinks' => array(
				'type' => 'checkbox',
				'label' => 'Карточки не-кликабельные',
				'default' => false
			)			
		);
	}
	
	/** prepare data for template **/	
	public function get_template_variables( $instance, $args ) {
		return array(
			'exclude_ids' 	=> sanitize_text_field($instance['exclude_ids']),
			'post_type'   	=> sanitize_text_field($instance['post_type']),
			'taxonomy'    	=> sanitize_text_field($instance['taxonomy']),
			'tax_terms'  	=> sanitize_text_field($instance['tax_terms']),
			'nolinks'  		=> (bool)($instance['nolinks']),	
			'posts_per_page'=> (int)$instance['posts_per_page']
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
		
		$params = array(
            'post_type' => $instance['post_type'],
            'post__not_in' => $instance['exclude_ids'] ? explode(',', $instance['exclude_ids']) : array(),            
            'posts_per_page' => ($instance['posts_per_page'] && (int)$instance['posts_per_page'] > 0) ? (int)$instance['posts_per_page'] : -1
        );
		
        if($instance['taxonomy'] && $instance['tax_terms']) {
            $params['tax_query'] = array(
                array(
                    'taxonomy' => $instance['taxonomy'],
                    'field'    => 'slug',
                    'terms'    => explode(',', $instance['tax_terms']),
                    'operator' => 'IN',
                ),
            );
        }

        $posts = get_posts($params);
		
		$loop_css = "cards-loop sm-cols-2 md-cols-3 lg-cols-4 exlg-cols-5";
		
		if($instance['post_type'] == 'project'){
			$loop_css = "cards-loop sm-cols-2 md-cols-2 lg-cols-3";
		}
		
		if($instance['post_type'] == 'org'){
			$loop_css = "frame logo-gallery";
		}

        if($posts && is_callable('tst_'.$instance['post_type'].'_card_group')) {		
			echo $args['before_widget'];
			echo '<div class="so-widget-'.$this->id_base.' so-widget-'.$css_name.'">';
		?>
			<div class="frl-pb-blocks"><div class="<?php echo $loop_css;?>">
				<?php foreach ($posts as $p) {
					$class = (isset($instance['panels_info']['style']['class'])) ? $instance['panels_info']['style']['class'] : '';
					$p->widget_class = ($class) ? $class : 'default';
					$linked = (!$nolinks) ? false : true;
					call_user_func_array('tst_'.$instance['post_type'].'_card_group', array($p, $linked));
				}?>
			</div></div>
		<?php	
			echo '</div>';
			echo $args['after_widget'];
		}
	}
	
} //class

//register
siteorigin_widget_register('tst-blocksgroup', __FILE__, 'TST_BlocksGroup_Widget');

