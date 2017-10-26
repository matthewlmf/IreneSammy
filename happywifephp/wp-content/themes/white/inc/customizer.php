<?php
/**
 * White Theme Customizer
 *
 * @package White
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function white_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	$wp_customize->add_section( 'title_tagline' , array(
	    'title'      => __( 'Basic Settings', 'white' ),
	    'priority'   => 30,
	) );
	
	$wp_customize->add_setting( 'white_logo' , array(
	    'default'     => '',
	    'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'white_logo',
	        array(
	            'label' => __('Upload Logo','white'),
	            'section' => 'title_tagline',
	            'settings' => 'white_logo',
	            'priority' => 5,
	        )
		)
	);
	
	// SLIDER PANEL
	$wp_customize->add_panel( 'white_slider_panel', array(
	    'priority'       => 35,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => 'Main Slider',
	) );
	
	$wp_customize->add_section(
	    'white_sec_slider_options',
	    array(
	        'title'     => __('Enable/Disable','white'),
	        'priority'  => 0,
	        'panel'     => 'white_slider_panel'
	    )
	);
	
	
	$wp_customize->add_setting(
		'white_main_slider_enable',
		array( 'sanitize_callback' => 'white_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'white_main_slider_enable', array(
		    'settings' => 'white_main_slider_enable',
		    'label'    => __( 'Enable Slider.', 'white' ),
		    'section'  => 'white_sec_slider_options',
		    'type'     => 'checkbox',
		)
	);
	
	$wp_customize->add_setting(
		'white_main_slider_count',
			array(
				'default' => '0',
				'sanitize_callback' => 'white_sanitize_positive_number'
			)
	);
	
	// Select How Many Slides the User wants, and Reload the Page.
	$wp_customize->add_control(
			'white_main_slider_count', array(
		    'settings' => 'white_main_slider_count',
		    'label'    => __( 'No. of Slides(Min:0, Max: 5)' ,'white'),
		    'section'  => 'white_sec_slider_options',
		    'type'     => 'number',
		    'description' => __('Save the Settings, and Reload this page to Configure the Slides.','white'),
		    
		)
	);
	
	if ( get_theme_mod('white_main_slider_count') > 0 ) :
		$slides = get_theme_mod('white_main_slider_count');
		
		for ( $i = 1 ; $i <= $slides ; $i++ ) :
			
			//Create the settings Once, and Loop through it.
			
			$wp_customize->add_setting(
				'white_slide_img'.$i,
				array( 'sanitize_callback' => 'esc_url_raw' )
			);
			
			$wp_customize->add_control(
			    new WP_Customize_Image_Control(
			        $wp_customize,
			        'white_slide_img'.$i,
			        array(
			            'label' => '',
			            'section' => 'white_slide_sec'.$i,
			            'settings' => 'white_slide_img'.$i,			       
			        )
				)
			);
			
			$wp_customize->add_section(
			    'white_slide_sec'.$i,
			    array(
			        'title'     => 'Slide '.$i,
			        'priority'  => $i,
			        'panel'     => 'white_slider_panel'
			    )
			);
			
			$wp_customize->add_setting(
				'white_slide_title'.$i,
				array( 'sanitize_callback' => 'sanitize_text_field' )
			);
			
			$wp_customize->add_control(
					'white_slide_title'.$i, array(
				    'settings' => 'white_slide_title'.$i,
				    'label'    => __( 'Slide Title','white' ),
				    'section'  => 'white_slide_sec'.$i,
				    'type'     => 'text',
				)
			);
			
			$wp_customize->add_setting(
				'white_slide_desc'.$i,
				array( 'sanitize_callback' => 'sanitize_text_field' )
			);
			
			$wp_customize->add_control(
					'white_slide_desc'.$i, array(
				    'settings' => 'white_slide_desc'.$i,
				    'label'    => __( 'Slide Description','white' ),
				    'section'  => 'white_slide_sec'.$i,
				    'type'     => 'text',
				)
			);
			
			
			$wp_customize->add_setting(
				'white_slide_url'.$i,
				array( 'sanitize_callback' => 'esc_url_raw' )
			);
			
			$wp_customize->add_control(
					'white_slide_url'.$i, array(
				    'settings' => 'white_slide_url'.$i,
				    'label'    => __( 'Target URL','white' ),
				    'section'  => 'white_slide_sec'.$i,
				    'type'     => 'url',
				)
			);
			
		endfor;
	
	endif;
	
	// Social Icons
	$wp_customize->add_section('white_social_section', array(
			'title' => __('Social Icons','white'),
			'priority' => 44 ,
	));
	
	$social_networks = array( //Redefinied in Sanitization Function.
					'none' => __('-','white'),
					'facebook' => __('Facebook','white'),
					'twitter' => __('Twitter','white'),
					'google-plus' => __('Google Plus','white'),
					'instagram' => __('Instagram','white'),
					'rss' => __('RSS Feeds','white'),
					'flickr' => __('Flickr','white'),
				);
				
	$social_count = count($social_networks);
				
	for ($x = 1 ; $x <= ($social_count - 1) ; $x++) :
			
		$wp_customize->add_setting(
			'white_social_'.$x, array(
				'sanitize_callback' => 'white_sanitize_social',
				'default' => 'none'
			));

		$wp_customize->add_control( 'white_social_'.$x, array(
					'settings' => 'white_social_'.$x,
					'label' => __('Icon ','white').$x,
					'section' => 'white_social_section',
					'type' => 'select',
					'choices' => $social_networks,			
		));
		
		$wp_customize->add_setting(
			'white_social_url'.$x, array(
				'sanitize_callback' => 'esc_url_raw'
			));

		$wp_customize->add_control( 'white_social_url'.$x, array(
					'settings' => 'white_social_url'.$x,
					'description' => __('Icon ','white').$x.__(' Url','white'),
					'section' => 'white_social_section',
					'type' => 'url',
					'choices' => $social_networks,			
		));
		
	endfor;
	
	class white_Custom_CSS_Control extends WP_Customize_Control {
	    public $type = 'textarea';
	 
	    public function render_content() {
	        ?>
	            <label>
	                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	                <textarea rows="8" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
	            </label>
	        <?php
	    }
	}
	
	$wp_customize-> add_section(
    'white_custom_codes',
    array(
    	'title'			=> __('Custom CSS','white'),
    	'description'	=> __('Enter your Custom CSS to Modify design.','white'),
    	'priority'		=> 41,
    	)
    );
    
	$wp_customize->add_setting(
	'white_custom_css',
	array(
		'default'		=> '',
		'capability'           => 'edit_theme_options',
		'sanitize_callback'    => 'wp_filter_nohtml_kses',
		'sanitize_js_callback' => 'wp_filter_nohtml_kses'
		)
	);
	
	$wp_customize->add_control(
	    new white_Custom_CSS_Control(
	        $wp_customize,
	        'white_custom_css',
	        array(
	            'section' => 'white_custom_codes',
	            

	        )
	    )
	);
	
	/* Sanitization Functions Common to Multiple Settings go Here, Specific Sanitization Functions are defined along with add_setting() */
	function white_sanitize_checkbox( $input ) {
	    if ( $input == 1 ) {
	        return 1;
	    } else {
	        return '';
	    }
	}
	
	function white_sanitize_positive_number( $input ) {
		if ( ($input >= 0) && is_numeric($input) )
			return $input;
		else
			return '';	
	}
	
	/* Sanitization function for Social Icons */
	function white_sanitize_social( $input ) {
		$social_networks = array(
					'none' ,
					'facebook',
					'twitter',
					'google-plus',
					'instagram',
					'rss',
					'flickr',
				);
		if ( in_array($input, $social_networks) )
			return $input;
		else
			return '';	
	}
}
add_action( 'customize_register', 'white_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function white_customize_preview_js() {
	wp_enqueue_script( 'white_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'white_customize_preview_js' );
