<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package bb
 */

$cc_link = '<a href="http://creativecommons.org/licenses/by-sa/3.0/" target="_blank">Creative Commons СС-BY-SA 3.0</a>';
$tst = __("Teplitsa of social technologies", 'tst');
$banner = get_template_directory_uri().'/assets/images/te-st-logo-10x50';
$footer_text = get_theme_mod('footer_text');
?>
</div><!--  #site_content -->


<footer class="site-footer"><div class="container">		
	
	<div class="frame">
		<div class="bit md-8 lg-7 bit-no-margin vk hide-upto-small">
			<div class="widget-area vk"><?php dynamic_sidebar( 'footer_1-sidebar' );?></div>
		</div>
		<div class="bit md-4 lg-5 bit-no-margin">
			<div class="widget-area text"><?php dynamic_sidebar('footer_2-sidebar' );?></div>
		</div>		
	</div>
	
	<div class="hr"></div>
	<div class="sf-cols">
		
		<div class="sf-cols-8">		
				
			<div class="copy">
				<?php echo apply_filters('tst_the_content', $footer_text); ?>	
				<p><?php printf(__('All materials of the site are avaliabe under license %s', 'tst'), $cc_link);?></p>
			</div>
			
		</div>
		
		<div class="sf-cols-4">
			<div class="te-st-bn">
				<p class="support">Сайт сделан <br>при поддержке</p>
				<a title="<?php echo $tst;?>" href="http://te-st.ru/" class="tst-banner">					
					<svg class="tst-icon"><use xlink:href="#icon-te-st" /></svg>
				</a>
			</div>			
		</div>
	</div>
	
</div></footer>

<?php wp_footer(); ?>
<?php
	$code = get_theme_mod('jivo_code');
	echo $code;
?>
</body>
</html>
