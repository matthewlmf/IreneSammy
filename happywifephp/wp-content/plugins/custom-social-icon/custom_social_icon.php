<?php
/*
Plugin Name: Custom Social Icon
Plugin URI: vrajeshdave.wordpress.com
Description: Your Link Your Icon/Images,by using this plugin ,you can create list of social links associate wtih custom image..by using shortcode [CSI]
Version: 1.0
Author: Vrajesh Dave
Author URI: vrajeshdave.wordpress.com
License: GPLv2 or later
*/
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

if ( ! class_exists( 'CSI' ) ) {
	class CSI
	{		
		protected $tag = 'CSI';	
		protected $name = 'CSI_name';
		protected $version = '1.0';
		public function __construct()
		{
			add_shortcode( $this->tag, array( &$this, 'shortcode' ) );			
			add_action('admin_init', array(&$this, 'CSI_admin_init_settings'));
			add_action('admin_menu', array(&$this, 'CSI_add_menu'));		
			
		}	
		function CSI_activate(){}
		function CSI_deactivate(){}
		protected function _enqueue()
		{
			
			$CSI_path = plugin_dir_url( __FILE__ );
			$CSI_path_css = plugin_dir_url( __FILE__ ).'css/';
			$CSI_path_js = plugin_dir_url( __FILE__ ).'js/';
			if ( !wp_style_is($this->tag, 'enqueued' ) ) {
				wp_enqueue_style(
					$this->tag,
					$CSI_path_css . 'csi_css.css',
					array(),
					$this->version
				);												
			}
			
			if ( !wp_script_is($this->tag, 'enqueued' ) ) {
				if (!wp_script_is( 'jquery')) {				
					wp_enqueue_script( 'jquery' );
				}									
				wp_register_script(
					'jquery-' . $this->tag.'localize',
					$CSI_path_js . 'csi_js.js',
					array( 'jquery'),
					'1.0' 
				);				
			}
			
		}
		
		
		public function shortcode( $atts, $content = null )
		{
			
					
			$this->_enqueue();				
			$CSI_html = $this->_get_CSI_html();					
			return $CSI_html;
		}
		protected function _get_CSI_html(){
				$CSI_html='';
				$get_CSI_links =get_option('_csi_link'); 	
				if(!empty($get_CSI_links)){
					
					$CSI_html.='<div class="CSI_content">';
					foreach($get_CSI_links as $single_CSI_link){	
						
						$get_path_id =  "$single_CSI_link[path]";									
						$CSI_path =  wp_get_attachment_url($get_path_id );
						$CSI_link="$single_CSI_link[link]";	
						$CSI_html.="<a class='CSI_front_link' href='".$CSI_link."' target='blank'><img class='CSI_front_img' src='".$CSI_path."'></a>";
					}
					$CSI_html.='</div>';
				}
				return $CSI_html;
		}
		
		public function CSI_admin_init_settings()
		{			
			wp_enqueue_media();
			wp_enqueue_script(
					'jquery-' . $this->tag.'adminjs',
					plugin_dir_url( __FILE__ ).'js/admin_settings.js',
					array( 'jquery'),
					'1.0' 
			);		
			wp_enqueue_style(
					'admin_'.$this->tag,
					 plugin_dir_url( __FILE__ ).'css/csi_admin_css.css',
					array(),
					$this->version
				);		
			$CSI_admin_array=array('CSI_image_url'=>plugins_url( 'images/', __FILE__)) ;
			wp_localize_script( 'jquery-' . $this->tag.'adminjs', 'CSI_obj_name', $CSI_admin_array );	
			
			
			
			
			
			

			/*add_settings_section("CSI_section", "All Settings", null, "theme-options");

			add_settings_field("twitter_url", "Twitter Profile Url", "display_twitter_element", "theme-options", "CSI_section");
			add_settings_field("facebook_url", "Facebook Profile Url", "display_facebook_element", "theme-options", "CSI_section");

			register_setting("section", "twitter_url");
			register_setting("section", "facebook_url");
			*/
			
			
			
			
			
			
			
			
			register_setting('CSI_template-group', '_csi_link');
			register_setting('CSI_template-group', '_csi_file');
		} 
		

		public function CSI_add_menu()
		{
			add_options_page('Custom Social Icons', 'Custom Social Icons', 'manage_options', 'CSI_template', array(&$this, 'CSI_settings_page'));
		} 
		
		public function CSI_settings_page()
		{
			if(!current_user_can('manage_options'))
			{
				wp_die(__('You do not have sufficient permissions to access this page.'));
			}			
			include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
		} 
		
	}
 }
if(class_exists('CSI'))
{	
	$CSI_obj = new CSI();
	register_activation_hook(__FILE__, array(&$CSI_obj, 'CSI_activate'));
	register_deactivation_hook(__FILE__, array(&$CSI_obj, 'CSI_deactivate'));		
		
	if(isset($CSI_obj))
	{		
		function plugin_CSI_settings_link($links)
		{ 
			$settings_link = '<a href="options-general.php?page=CSI_template">Settings</a>'; 
			array_unshift($links, $settings_link); 
			return $links; 
		}
		$plugin = plugin_basename(__FILE__); 
		add_filter("plugin_action_links_$plugin", 'plugin_CSI_settings_link');
	}
}
?>
