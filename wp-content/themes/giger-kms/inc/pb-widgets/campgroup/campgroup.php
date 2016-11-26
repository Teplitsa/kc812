<?php
/*
Widget Name: [TST] Группа кампаний-карточек
Description: Вывод группы кампаний в виде карточек
*/

class TST_CampGroup_Widget extends SiteOrigin_Widget {
	
	function __construct() {
		
		parent::__construct(
			'tst-campgroup',
			'[TST] Группа кампаний-карточек',
			array(
				'description' => 'Вывод группы кампаний в виде карточек'				
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
			
			'exclude_ids' => array(
				'type' => 'text',
				'label' => 'ID записей - исключить',
				'description' => 'Список IDs, разделенных запятыми',
			),
						
			'tax_terms' => array(
				'type' => 'text',
				'label' => 'Slug терминов (через запятую)'
			),
			
			'posts_per_page' => array(
				'type' => 'text',
				'label' => 'Количество (по умолчанию - все)'
			),
			
			'format' => array(
				'type' => 'select',
				'label' => 'Формат',
				'default' => 'default',
				'options' => array(
					'project' => 'Карточка программы',
					'child'   => 'Карточка ребенка',
					'default'  => 'Карточка помощи'					
				)
			),
			/*'prog_bar' => array(
				'type' => 'checkbox',
				'label' => 'Выводить градусник',
				'default' => false
			)
			*/
		);
	}
	
	/** prepare data for template **/	
	public function get_template_variables( $instance, $args ) {
		return array(
			'exclude_ids' 	=> sanitize_text_field($instance['exclude_ids']),			
			'tax_terms'  	=> sanitize_text_field($instance['tax_terms']),
			//'nolinks'  		=> (bool)($instance['nolinks']),	
			'posts_per_page'=> (int)$instance['posts_per_page'],
			'format'    	=> $instance['format']		
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
            'post_type' => 'leyka_campaign',
            'post__not_in' => explode(',', $exclude_ids),            
            'posts_per_page' => ((int)$posts_per_page > 0) ? (int)$posts_per_page : -1
        );
		
        if($instance['tax_terms']) {
            $params['tax_query'] = array(
                array(
                    'taxonomy' => 'campaign_cat',
                    'field'    => 'slug',
                    'terms'    => explode(',', $tax_terms),
                    'operator' => 'IN',
                ),
            );
        }

        $posts = get_posts($params);
		
		$loop_css = "cards-loop sm-cols-2 md-cols-3 lg-cols-4 exlg-cols-5";
		$callback = 'tst_default_campaign_card';
		
		if($format == 'project') {
			$loop_css = "cards-loop sm-cols-2 md-cols-2 lg-cols-3";
			$callback = 'tst_project_campaign_card';
		}
		elseif($format == 'child') {
			$loop_css = "cards-loop sm-cols-2 md-cols-3 lg-cols-4";
			$callback = 'tst_child_campaign_card';	
		}

        if($posts && is_callable($callback)) {		
			echo $args['before_widget'];
			echo '<div class="so-widget-'.$this->id_base.' so-widget-'.$css_name.'">';
		?>
			<div class="frl-pb-blocks"><div class="<?php echo $loop_css;?>">
				<?php foreach ($posts as $p) {
					$class = (isset($instance['panels_info']['style']['class'])) ? $instance['panels_info']['style']['class'] : '';
					$p->widget_class = ($class) ? $class : 'default';
					
					call_user_func_array($callback, array($p));
				}?>
			</div></div>
		<?php	
			echo '</div>';
			echo $args['after_widget'];
		}
	}
	
} //class

//register
siteorigin_widget_register('tst-campgroup', __FILE__, 'TST_CampGroup_Widget');

