<?php
/*
Widget Name: [TST] Последние записи
Description: Вывод последних записей из блога
*/

class TST_RecentPosts_Widget extends SiteOrigin_Widget {
	
	function __construct() {
		
		parent::__construct(
			'tst-recentposts',
			'[TST] Последние записи',
			array(
				'description' => 'Вывод последних записей из блога'				
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
				'label' => __('Title', 'tst'),
			),
			'posts_per_page' => array(
				'type' => 'number',
				'label' => 'Количество',
				'default' => 1
			),
			'title_url' => array(
				'type' => 'link',
				'label' => __('All posts link', 'tst'),
			),
		);
	}
	
	/** prepare data for template **/	
	public function get_template_variables( $instance, $args ) {
		return array(
			'posts_per_page'	=> (int)($instance['posts_per_page']),
			'title_url'			=> esc_url($instance['title_url']),
			'title'				=> $instance['title']
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
		
		$posts_per_page = ($posts_per_page < 1) ? 1 : $posts_per_page;		
		$posts = get_posts(array('posts_per_page' => $posts_per_page));
        
        if($posts) {		
			echo $args['before_widget'];
			echo '<div class="so-widget-'.$this->id_base.' so-widget-'.$css_name.'">';
			
			if(!empty($title)){
				$title = apply_filters('widget_title', $title);
				$title = (!empty($title_url)) ? "<a href='{$title_url}' title='Все записи'>{$title}</a>" : $title;
				echo $args['before_title'] . $title . $args['after_title'];
			}
		?>
			<div class="recent-posts">
			<?php
				foreach($posts as $p) {
					tst_post_card($p);
				}
			?>
			</div>
		<?php	
			echo '</div>';
			echo $args['after_widget'];
		}
	}
	
} //class

//register
siteorigin_widget_register('tst-recentposts', __FILE__, 'TST_RecentPosts_Widget');

