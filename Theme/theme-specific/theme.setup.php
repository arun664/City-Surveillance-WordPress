<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0.22
 */

if (!defined("PROLINGUA_THEME_FREE")) define("PROLINGUA_THEME_FREE", false);
if (!defined("PROLINGUA_THEME_FREE_WP")) define("PROLINGUA_THEME_FREE_WP", false);

// Theme storage
$PROLINGUA_STORAGE = array(
	// Theme required plugin's slugs
	'required_plugins' => array_merge(

		// List of plugins for both - FREE and PREMIUM versions
		//-----------------------------------------------------
		array(
			// Required plugins
			// DON'T COMMENT OR REMOVE NEXT LINES!
			'trx_addons'					=> esc_html__('ThemeREX Addons', 'prolingua'),

			// Recommended (supported) plugins fot both (lite and full) versions
			// If plugin not need - comment (or remove) it
			'contact-form-7'				=> esc_html__('Contact Form 7', 'prolingua'),
			'mailchimp-for-wp'				=> esc_html__('MailChimp for WP', 'prolingua'),
		),

		// List of plugins for PREMIUM version only
		//-----------------------------------------------------
		PROLINGUA_THEME_FREE 
			? array(
					// Recommended (supported) plugins for the FREE (lite) version
					// ...
					) 
			: array(
					// Recommended (supported) plugins for the PRO (full) version
					// If plugin not need - comment (or remove) it
					'js_composer'				=> esc_html__('Visual Composer', 'prolingua'),
                    'vc-extensions-bundle'		=> esc_html__('Visual Composer extensions bundle', 'prolingua'),
					'essential-grid'			=> esc_html__('Essential Grid', 'prolingua'),
					'revslider'					=> esc_html__('Revolution Slider', 'prolingua'),
				)
	),
	
	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url' => 'http://prolingua.themerex.net',
	'theme_doc_url'  => 'http://prolingua.themerex.net/doc',
    'theme_video_url' => 'https://www.youtube.com/channel/UCnFisBimrK2aIE-hnY70kCA',	// ThemeREX

	'theme_support_url'  => 'https://themerex.ticksy.com',
	'theme_download_url' => 'https://themeforest.net/user/themerex/portfolio'
);

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( !function_exists('prolingua_customizer_theme_setup1') ) {
	add_action( 'after_setup_theme', 'prolingua_customizer_theme_setup1', 1 );
	function prolingua_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		prolingua_storage_set('settings', array(
			
			'duplicate_options'		=> 'child',		// none  - use separate options for template and child-theme
													// child - duplicate theme options from the main theme to the child-theme only
													// both  - sinchronize changes in the theme options between main and child themes
			
			'custmize_refresh'		=> 'auto',		// Refresh method for preview area in the Appearance - Customize:
													// auto - refresh preview area on change each field with Theme Options
													// manual - refresh only obn press button 'Refresh' at the top of Customize frame
		
			'max_load_fonts'		=> 5,			// Max fonts number to load from Google fonts or from uploaded fonts
		
			'comment_maxlength'		=> 1000,		// Max length of the message from contact form

			'comment_after_name'	=> true,		// Place 'comment' field before the 'name' and 'email'
			
			'socials_type'			=> 'icons',		// Type of socials:
													// icons - use font icons to present social networks
													// images - use images from theme's folder trx_addons/css/icons.png
			
			'icons_type'			=> 'icons',		// Type of other icons:
													// icons - use font icons to present icons
													// images - use images from theme's folder trx_addons/css/icons.png
			
			'icons_selector'		=> 'internal',	// Icons selector in the shortcodes:
													// vc (default) - standard VC icons selector (very slow and don't support images)
													// internal - internal popup with plugin's or theme's icons list (fast)
			'check_min_version'		=> true,		// Check if exists a .min version of .css and .js and return path to it
													// instead the path to the original file
													// (if debug_mode is off and modification time of the original file < time of the .min file)
			'autoselect_menu'		=> false,		// Show any menu if no menu selected in the location 'main_menu'
													// (for example, the theme is just activated)
			'disable_jquery_ui'		=> false,		// Prevent loading custom jQuery UI libraries in the third-party plugins
		
			'use_mediaelements'		=> true,		// Load script "Media Elements" to play video and audio
			
			'tgmpa_upload'			=> false		// Allow upload not pre-packaged plugins via TGMPA
		));


		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------
		
		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// For example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		prolingua_storage_set('load_fonts', array(
			// Google font
			array(
				'name'	 => 'Muli',
				'family' => 'sans-serif',
				'styles' => '200,200i,300,300i,400,400i,600'	// Parameter 'style' used only for the Google fonts
				),
            array(
                'name'	 => 'Ubuntu',
                'family' => 'sans-serif',
                'styles' => '300'	// Parameter 'style' used only for the Google fonts
              ),

			// Font-face packed with theme
			array(
				'name'   => 'Montserrat',
				'family' => 'sans-serif'
				)
		));

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		prolingua_storage_set('load_fonts_subset', 'latin,latin-ext');
		
		// Settings of the main tags
		prolingua_storage_set('theme_fonts', array(
			'p' => array(
				'title'				=> esc_html__('Main text', 'prolingua'),
				'description'		=> esc_html__('Font settings of the main text of the site', 'prolingua'),
				'font-family'		=> '"Muli",sans-serif',
				'font-size' 		=> '1rem',
				'font-weight'		=> '200',
				'font-style'		=> 'normal',
				'line-height'		=> '1.681em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '',
				'margin-top'		=> '0em',
				'margin-bottom'		=> '1.07em'
				),
			'h1' => array(
				'title'				=> esc_html__('Heading 1', 'prolingua'),
				'font-family'		=> '"Muli",sans-serif',
				'font-size' 		=> '3.611em', //3.611em
				'font-weight'		=> '200',
				'font-style'		=> 'normal',
				'line-height'		=> '1.24em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '1.2px',
				'margin-top'		=> '1.129em',
				'margin-bottom'		=> '0.839em'
				),
			'h2' => array(
				'title'				=> esc_html__('Heading 2', 'prolingua'),
				'font-family'		=> '"Muli",sans-serif',
				'font-size' 		=> '2.778em',
				'font-weight'		=> '200',
				'font-style'		=> 'normal',
				'line-height'		=> '1.234em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '1.1px',
				'margin-top'		=> '1.5822em',
				'margin-bottom'		=> '0.7799em'
				),
			'h3' => array(
				'title'				=> esc_html__('Heading 3', 'prolingua'),
				'font-family'		=> '"Muli",sans-serif',
				'font-size' 		=> '2.333em',
				'font-weight'		=> '200',
				'font-style'		=> 'normal',
				'line-height'		=> '1.1815em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0.8px',
				'margin-top'		=> '1.4495em',
				'margin-bottom'		=> '0.9799em'
				),
			'h4' => array(
				'title'				=> esc_html__('Heading 4', 'prolingua'),
				'font-family'		=> '"Muli",sans-serif',
				'font-size' 		=> '1.889em',
				'font-weight'		=> '200',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2043em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0.7px',
				'margin-top'		=> '1.2865em',
				'margin-bottom'		=> '0.9455em'
				),
			'h5' => array(
				'title'				=> esc_html__('Heading 5', 'prolingua'),
				'font-family'		=> '"Muli",sans-serif',
				'font-size' 		=> '1.500em',
				'font-weight'		=> '200',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2399em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0.55px',
				'margin-top'		=> '1.639em',
				'margin-bottom'		=> '1.226em'
				),
			'h6' => array(
				'title'				=> esc_html__('Heading 6', 'prolingua'),
				'font-family'		=> '"Muli",sans-serif',
				'font-size' 		=> '1.056em',
				'font-weight'		=> '300',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2706em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0.35px',
				'margin-top'		=> '2.4176em',
				'margin-bottom'		=> '1.393em'
				),
			'logo' => array(
				'title'				=> esc_html__('Logo text', 'prolingua'),
				'description'		=> esc_html__('Font settings of the text case of the logo', 'prolingua'),
				'font-family'		=> '"Ubuntu",sans-serif',
				'font-size' 		=> '1.944em',
				'font-weight'		=> '300',
				'font-style'		=> 'normal',
				'line-height'		=> '1.15em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'normal',
				'letter-spacing'	=> '1px'
				),
			'button' => array(
				'title'				=> esc_html__('Buttons', 'prolingua'),
				'font-family'		=> '"Muli",sans-serif',
				'font-size' 		=> '11px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.3em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '2.2px'
				),
			'input' => array(
				'title'				=> esc_html__('Input fields', 'prolingua'),
				'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'prolingua'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '1em',
				'font-weight'		=> '200',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				),
			'info' => array(
				'title'				=> esc_html__('Post meta', 'prolingua'),
				'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'prolingua'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '20px',
				'font-weight'		=> '200',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '0.4em',
				'margin-bottom'		=> ''
				),
			'menu' => array(
				'title'				=> esc_html__('Main menu', 'prolingua'),
				'description'		=> esc_html__('Font settings of the main menu items', 'prolingua'),
				'font-family'		=> '"Muli",sans-serif',
				'font-size' 		=> '18px',
				'font-weight'		=> '300',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				),
			'submenu' => array(
				'title'				=> esc_html__('Dropdown menu', 'prolingua'),
				'description'		=> esc_html__('Font settings of the dropdown menu items', 'prolingua'),
				'font-family'		=> '"Muli",sans-serif',
				'font-size' 		=> '18px',
				'font-weight'		=> '300',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		prolingua_storage_set('scheme_color_groups', array(
			'main'	=> array(
							'title'			=> esc_html__('Main', 'prolingua'),
							'description'	=> esc_html__('Colors of the main content area', 'prolingua')
							),
			'alter'	=> array(
							'title'			=> esc_html__('Alter', 'prolingua'),
							'description'	=> esc_html__('Colors of the alternative blocks (sidebars, etc.)', 'prolingua')
							),
			'extra'	=> array(
							'title'			=> esc_html__('Extra', 'prolingua'),
							'description'	=> esc_html__('Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'prolingua')
							),
			'inverse' => array(
							'title'			=> esc_html__('Inverse', 'prolingua'),
							'description'	=> esc_html__('Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'prolingua')
							),
			'input'	=> array(
							'title'			=> esc_html__('Input', 'prolingua'),
							'description'	=> esc_html__('Colors of the form fields (text field, textarea, select, etc.)', 'prolingua')
							),
			)
		);
		prolingua_storage_set('scheme_color_names', array(
			'bg_color'	=> array(
							'title'			=> esc_html__('Background color', 'prolingua'),
							'description'	=> esc_html__('Background color of this block in the normal state', 'prolingua')
							),
			'bg_hover'	=> array(
							'title'			=> esc_html__('Background hover', 'prolingua'),
							'description'	=> esc_html__('Background color of this block in the hovered state', 'prolingua')
							),
			'bd_color'	=> array(
							'title'			=> esc_html__('Border color', 'prolingua'),
							'description'	=> esc_html__('Border color of this block in the normal state', 'prolingua')
							),
			'bd_hover'	=>  array(
							'title'			=> esc_html__('Border hover', 'prolingua'),
							'description'	=> esc_html__('Border color of this block in the hovered state', 'prolingua')
							),
			'text'		=> array(
							'title'			=> esc_html__('Text', 'prolingua'),
							'description'	=> esc_html__('Color of the plain text inside this block', 'prolingua')
							),
			'text_dark'	=> array(
							'title'			=> esc_html__('Text dark', 'prolingua'),
							'description'	=> esc_html__('Color of the dark text (bold, header, etc.) inside this block', 'prolingua')
							),
			'text_light'=> array(
							'title'			=> esc_html__('Text light', 'prolingua'),
							'description'	=> esc_html__('Color of the light text (post meta, etc.) inside this block', 'prolingua')
							),
			'text_link'	=> array(
							'title'			=> esc_html__('Link', 'prolingua'),
							'description'	=> esc_html__('Color of the links inside this block', 'prolingua')
							),
			'text_hover'=> array(
							'title'			=> esc_html__('Link hover', 'prolingua'),
							'description'	=> esc_html__('Color of the hovered state of links inside this block', 'prolingua')
							),
			'text_link2'=> array(
							'title'			=> esc_html__('Link 2', 'prolingua'),
							'description'	=> esc_html__('Color of the accented texts (areas) inside this block', 'prolingua')
							),
			'text_hover2'=> array(
							'title'			=> esc_html__('Link 2 hover', 'prolingua'),
							'description'	=> esc_html__('Color of the hovered state of accented texts (areas) inside this block', 'prolingua')
							),
			'text_link3'=> array(
							'title'			=> esc_html__('Link 3', 'prolingua'),
							'description'	=> esc_html__('Color of the other accented texts (buttons) inside this block', 'prolingua')
							),
			'text_hover3'=> array(
							'title'			=> esc_html__('Link 3 hover', 'prolingua'),
							'description'	=> esc_html__('Color of the hovered state of other accented texts (buttons) inside this block', 'prolingua')
							)
			)
		);
		prolingua_storage_set('schemes', array(
		
			// Color scheme: 'default'
			'default' => array(
				'title'	 => esc_html__('Default', 'prolingua'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#ffffff', //ok
					'bd_color'			=> '#eaecf0', //ok
		
					// Text and links colors
					'text'				=> '#44474a', //ok
					'text_light'		=> '#a6a6a6', //ok
					'text_dark'			=> '#0c1220', //ok
					'text_link'			=> '#3e3ed3', //ok
					'text_hover'		=> '#0c1220', //ok
					'text_link2'		=> '#f9ad3d', //ok fec557
					'text_hover2'		=> '#0c1220', //ok 0c1a3b
					'text_link3'		=> '#04ded0', //ok 29f0e9
					'text_hover3'		=> '#f3f5f9', //ok
		
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#f3f5f9', //ok
					'alter_bg_hover'	=> '#e4e7ed', //ok
					'alter_bd_color'	=> '#d5d9e2', //ok
					'alter_bd_hover'	=> '#dadada',
					'alter_text'		=> '#333333', //ok
					'alter_light'		=> '#b7b7b7', //ok
					'alter_dark'		=> '#1d1d1d', //ok
					'alter_link'		=> '#3e3ed3', //ok
					'alter_hover'		=> '#0c1220', //ok
					'alter_link2'		=> '#0c1220', //ok header search
					'alter_hover2'		=> '#3e3ed3', //ok header search
					'alter_link3'		=> '#04ded0', //ok services 29f0e9
					'alter_hover3'		=> '#ddb837',
		
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#0c1220', //ok
					'extra_bg_hover'	=> '#0c1220', //ok button dark
					'extra_bd_color'	=> '#343434', //ok
					'extra_bd_hover'	=> '#3d3d3d',
					'extra_text'		=> '#898989', //ok
					'extra_light'		=> '#68738b', //ok
					'extra_dark'		=> '#ffffff', //ok
					'extra_link'		=> '#f9ad3d', //ok fec557
					'extra_hover'		=> '#f3f5f9',
					'extra_link2'		=> '#04ded0', // skills 29f0e9
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#b6bac5', // outer socials
					'extra_hover3'		=> '#eec432',
		
					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#e5e9ed', //ok
					'input_bg_hover'	=> '#d2d8df', //ok
					'input_bd_color'	=> 'transparent', //- transparent
					'input_bd_hover'	=> 'transparent', //- transparent
					'input_text'		=> '#44474a', //ok
					'input_light'		=> '#44474a', //ok
					'input_dark'		=> '#0c1220', //ok
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#ffffff', //ok
					'inverse_bd_hover'	=> '#5aa4a9', //-
					'inverse_text'		=> '#ffffff', //ok
					'inverse_light'		=> '#a6a6a6', //ok
					'inverse_dark'		=> '#b1b1c1', //ok
					'inverse_link'		=> '#ffffff', //ok
					'inverse_hover'		=> '#ffffff'  //ok
				)
			),
		
			// Color scheme: 'dark'
			'dark' => array(
				'title'  => esc_html__('Dark', 'prolingua'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#0c1a3b', //ok
					'bd_color'			=> '#333f5b', //ok
		
					// Text and links colors
					'text'				=> '#a2afcb', //ok
					'text_light'		=> '#68738b', //ok
					'text_dark'			=> '#ffffff', //ok
					'text_link'			=> '#04ded0', //ok 29f0e9
					'text_hover'		=> '#ffffff', //ok
					'text_link2'		=> '#f9ad3d', //ok fec557
					'text_hover2'		=> '#0c1220', //ok
					'text_link3'		=> '#f9ad3d', //ok fec557
					'text_hover3'		=> '#0c1220', //ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#0c1220', //ok
					'alter_bg_hover'	=> '#101728', //ok
					'alter_bd_color'	=> '#252a37', //ok
					'alter_bd_hover'	=> '#4a4a4a', //-
					'alter_text'		=> '#989da9', //ok
					'alter_light'		=> '#797c82', //ok
					'alter_dark'		=> '#ffffff', //ok
					'alter_link'		=> '#f9ad3d', //ok fec557
					'alter_hover'		=> '#ffffff', //ok
					'alter_link2'		=> '#04ded0', // ok header search 29f0e9
					'alter_hover2'		=> '#f3f5f7', //ok header search
					'alter_link3'		=> '#3e3ed3',//ok services
					'alter_hover3'		=> '#ddb837',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#ffffff', //ok
					'extra_bg_hover'	=> '#f3f5f7', //ok
					'extra_bd_color'	=> '#e5e5e5', //ok
					'extra_bd_hover'	=> '#4a4a4a', //-
					'extra_text'		=> '#333333', //ok
					'extra_light'		=> '#b7b7b7', //ok
					'extra_dark'		=> '#2e2d32', //ok
					'extra_link'		=> '#3e3ed3', //ok
					'extra_hover'		=> '#f3f5f9',
					'extra_link2'		=> '#04ded0', //ok skills rework 29f0e9
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#b6bac5', //ok outer socials
					'extra_hover3'		=> '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'	=> 'transparent', //- transparent
					'input_bg_hover'	=> 'transparent', //- transparent
					'input_bd_color'	=> '#3d4862', //ok
					'input_bd_hover'	=> '#ffffff', //ok
					'input_text'		=> '#a2afcb', //ok
					'input_light'		=> '#a2afcb', //ok
					'input_dark'		=> '#ffffff', //ok
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#e36650',
					'inverse_bd_hover'	=> '#cb5b47',
					'inverse_text'		=> '#ffffff', //ok
					'inverse_light'		=> '#a6a6a6', //ok
					'inverse_dark'		=> '#1d1d1d', //ok
					'inverse_link'		=> '#ffffff', //ok
					'inverse_hover'		=> '#1d1d1d'  //ok
				)
			),

            // Color scheme: 'Alter Dark'
            'darksome' => array(
                'title'  => esc_html__('Alter Dark', 'prolingua'),
                'colors' => array(

                    // Whole block border and background
                    'bg_color'			=> '#0f2149', //ok
                    'bd_color'			=> '#34425f', //ok

                    // Text and links colors
                    'text'				=> '#a2afcb', //ok
                    'text_light'		=> '#68738b', //ok
                    'text_dark'			=> '#ffffff', //ok
                    'text_link'			=> '#04ded0', //ok 29f0e9
                    'text_hover'		=> '#ffffff', //ok
                    'text_link2'		=> '#f9ad3d', //ok fec557
                    'text_hover2'		=> '#0c1220', //ok
                    'text_link3'		=> '#3e3ed3', //ok
                    'text_hover3'		=> '#0c1220', //ok

                    // Alternative blocks (sidebar, tabs, alternative blocks, etc.)
                    'alter_bg_color'	=> '#0f2149', //ok
                    'alter_bg_hover'	=> '#101728',
                    'alter_bd_color'	=> '#34425f', //ok
                    'alter_bd_hover'	=> '#4a4a4a',
                    'alter_text'		=> '#a2afcb', //ok footer text
                    'alter_light'		=> '#68738b', //ok footer light
                    'alter_dark'		=> '#ffffff', //ok footer copy
                    'alter_link'		=> '#04ded0', //ok footer link 29f0e9
                    'alter_hover'		=> '#f3f5f7', //ok button hover
                    'alter_link2'		=> '#04ded0', //ok header search 29f0e9
                    'alter_hover2'		=> '#f3f5f7', //ok header search
                    'alter_link3'		=> '#3e3ed3', //ok services
                    'alter_hover3'		=> '#ddb837',

                    // Extra blocks (submenu, tabs, color blocks, etc.)
                    'extra_bg_color'	=> '#ffffff',
                    'extra_bg_hover'	=> '#f3f5f7',
                    'extra_bd_color'	=> '#e5e5e5',
                    'extra_bd_hover'	=> '#4a4a4a',
                    'extra_text'		=> '#333333',
                    'extra_light'		=> '#b7b7b7',
                    'extra_dark'		=> '#2e2d32',
                    'extra_link'		=> '#3e3ed3', //ok
                    'extra_hover'		=> '#f3f5f9',
                    'extra_link2'		=> '#04ded0', //ok 29f0e9
                    'extra_hover2'		=> '#8be77c',
                    'extra_link3'		=> '#b6bac5', //outer socials
                    'extra_hover3'		=> '#eec432',

                    // Input fields (form's fields and textarea)
                    'input_bg_color'	=> 'transparent', //ok
                    'input_bg_hover'	=> 'transparent', //ok
                    'input_bd_color'	=> '#3c4761',     //ok
                    'input_bd_hover'	=> '#ffffff',     //ok
                    'input_text'		=> '#697590',     //ok
                    'input_light'		=> '#697590',     //ok
                    'input_dark'		=> '#ffffff',

                    // Inverse blocks (text and links on the 'text_link' background)
                    'inverse_bd_color'	=> '#e36650',
                    'inverse_bd_hover'	=> '#cb5b47',
                    'inverse_text'		=> '#ffffff', //ok
                    'inverse_light'		=> '#a6a6a6',
                    'inverse_dark'		=> '#1d1d1d',
                    'inverse_link'		=> '#ffffff', //ok
                    'inverse_hover'		=> '#1d1d1d'
                )
            )
		
		));
		
		// Simple schemes substitution
		prolingua_storage_set('schemes_simple', array(
			// Main color	// Slave elements and it's darkness koef.
			'text_link'		=> array('alter_hover' => 1,	'extra_link' => 1, 'inverse_bd_color' => 0.85, 'inverse_bd_hover' => 0.7),
			'text_hover'	=> array('alter_link' => 1,		'extra_hover' => 1),
			'text_link2'	=> array('alter_hover2' => 1,	'extra_link2' => 1),
			'text_hover2'	=> array('alter_link2' => 1,	'extra_hover2' => 1),
			'text_link3'	=> array('alter_hover3' => 1,	'extra_link3' => 1),
			'text_hover3'	=> array('alter_link3' => 1,	'extra_hover3' => 1)
		));
	}
}

			
// Additional (calculated) theme-specific colors
// Attention! Don't forget setup custom colors also in the theme.customizer.color-scheme.js
if (!function_exists('prolingua_customizer_add_theme_colors')) {
	function prolingua_customizer_add_theme_colors($colors) {
		if (substr($colors['text'], 0, 1) == '#') {
			$colors['bg_color_0']  = prolingua_hex2rgba( $colors['bg_color'], 0 );
			$colors['bg_color_01']  = prolingua_hex2rgba( $colors['bg_color'], 0.1 );
			$colors['bg_color_02']  = prolingua_hex2rgba( $colors['bg_color'], 0.2 );
			$colors['bg_color_07']  = prolingua_hex2rgba( $colors['bg_color'], 0.7 );
			$colors['bg_color_08']  = prolingua_hex2rgba( $colors['bg_color'], 0.8 );
			$colors['bg_color_09']  = prolingua_hex2rgba( $colors['bg_color'], 0.9 );
			$colors['alter_bg_color_07']  = prolingua_hex2rgba( $colors['alter_bg_color'], 0.7 );
			$colors['extra_bg_color_01']  = prolingua_hex2rgba( $colors['extra_bg_color'], 0.1 );
			$colors['extra_bg_color_05']  = prolingua_hex2rgba( $colors['extra_bg_color'], 0.5 );
			$colors['extra_bg_color_07']  = prolingua_hex2rgba( $colors['extra_bg_color'], 0.7 );
            $colors['extra_bg_color_09']  = prolingua_hex2rgba( $colors['extra_bg_color'], 0.9 );
			$colors['alter_bg_color_04']  = prolingua_hex2rgba( $colors['alter_bg_color'], 0.4 );
			$colors['alter_bg_color_02']  = prolingua_hex2rgba( $colors['alter_bg_color'], 0.2 );
			$colors['alter_bd_color_02']  = prolingua_hex2rgba( $colors['alter_bd_color'], 0.2 );
			$colors['alter_bd_color_025']  = prolingua_hex2rgba( $colors['alter_bd_color'], 0.25 );
			$colors['text_dark_07']  = prolingua_hex2rgba( $colors['text_dark'], 0.7 );
			$colors['extra_dark_05']  = prolingua_hex2rgba( $colors['extra_dark'], 0.5 );
			$colors['extra_text_02']  = prolingua_hex2rgba( $colors['extra_text'], 0.2 );
			$colors['extra_light_015']  = prolingua_hex2rgba( $colors['extra_light'], 0.15 );
			$colors['text_link_02']  = prolingua_hex2rgba( $colors['text_link'], 0.2 );
			$colors['text_link_07']  = prolingua_hex2rgba( $colors['text_link'], 0.7 );
			$colors['extra_link_026']  = prolingua_hex2rgba( $colors['extra_link'], 0.26 );
			$colors['inverse_link_02']  = prolingua_hex2rgba( $colors['inverse_link'], 0.2 );
			$colors['text_link_blend'] = prolingua_hsb2hex(prolingua_hex2hsb( $colors['text_link'], 2, -5, 5 ));
			$colors['alter_link_blend'] = prolingua_hsb2hex(prolingua_hex2hsb( $colors['alter_link'], 2, -5, 5 ));
		} else {
			$colors['bg_color_0'] = '{{ data.bg_color_0 }}';
			$colors['bg_color_01'] = '{{ data.bg_color_01 }}';
			$colors['bg_color_02'] = '{{ data.bg_color_02 }}';
			$colors['bg_color_07'] = '{{ data.bg_color_07 }}';
			$colors['bg_color_08'] = '{{ data.bg_color_08 }}';
			$colors['bg_color_09'] = '{{ data.bg_color_09 }}';
			$colors['alter_bg_color_07'] = '{{ data.alter_bg_color_07 }}';
			$colors['extra_bg_color_01'] = '{{ data.extra_bg_color_01 }}';
			$colors['extra_bg_color_05'] = '{{ data.extra_bg_color_05 }}';
			$colors['extra_bg_color_07'] = '{{ data.extra_bg_color_07 }}';
			$colors['extra_bg_color_09'] = '{{ data.extra_bg_color_09 }}';
			$colors['alter_bg_color_04'] = '{{ data.alter_bg_color_04 }}';
			$colors['alter_bg_color_02'] = '{{ data.alter_bg_color_02 }}';
			$colors['alter_bd_color_02'] = '{{ data.alter_bd_color_02 }}';
			$colors['extra_bg_color_07'] = '{{ data.extra_bg_color_07 }}';
			$colors['alter_bd_color_025'] = '{{ data.alter_bd_color_025 }}';
			$colors['text_dark_07'] = '{{ data.text_dark_07 }}';
			$colors['extra_dark_05'] = '{{ data.extra_dark_05 }}';
			$colors['extra_text_02'] = '{{ data.extra_text_02 }}';
			$colors['extra_light_015'] = '{{ data.extra_light_015 }}';
			$colors['text_link_02'] = '{{ data.text_link_02 }}';
			$colors['text_link_07'] = '{{ data.text_link_07 }}';
			$colors['extra_link_026'] = '{{ data.extra_link_026 }}';
			$colors['inverse_link_02'] = '{{ data.inverse_link_02 }}';
			$colors['text_link_blend'] = '{{ data.text_link_blend }}';
			$colors['alter_link_blend'] = '{{ data.alter_link_blend }}';
		}
		return $colors;
	}
}


			
// Additional theme-specific fonts rules
// Attention! Don't forget setup fonts rules also in the theme.customizer.color-scheme.js
if (!function_exists('prolingua_customizer_add_theme_fonts')) {
	function prolingua_customizer_add_theme_fonts($fonts) {
		$rez = array();	
		foreach ($fonts as $tag => $font) {
			if (substr($font['font-family'], 0, 2) != '{{') {
				$rez[$tag.'_font-family'] 		= !empty($font['font-family']) && !prolingua_is_inherit($font['font-family'])
														? 'font-family:' . trim($font['font-family']) . ';' 
														: '';
				$rez[$tag.'_font-size'] 		= !empty($font['font-size']) && !prolingua_is_inherit($font['font-size'])
														? 'font-size:' . prolingua_prepare_css_value($font['font-size']) . ";"
														: '';
				$rez[$tag.'_line-height'] 		= !empty($font['line-height']) && !prolingua_is_inherit($font['line-height'])
														? 'line-height:' . trim($font['line-height']) . ";"
														: '';
				$rez[$tag.'_font-weight'] 		= !empty($font['font-weight']) && !prolingua_is_inherit($font['font-weight'])
														? 'font-weight:' . trim($font['font-weight']) . ";"
														: '';
				$rez[$tag.'_font-style'] 		= !empty($font['font-style']) && !prolingua_is_inherit($font['font-style'])
														? 'font-style:' . trim($font['font-style']) . ";"
														: '';
				$rez[$tag.'_text-decoration'] 	= !empty($font['text-decoration']) && !prolingua_is_inherit($font['text-decoration'])
														? 'text-decoration:' . trim($font['text-decoration']) . ";"
														: '';
				$rez[$tag.'_text-transform'] 	= !empty($font['text-transform']) && !prolingua_is_inherit($font['text-transform'])
														? 'text-transform:' . trim($font['text-transform']) . ";"
														: '';
				$rez[$tag.'_letter-spacing'] 	= !empty($font['letter-spacing']) && !prolingua_is_inherit($font['letter-spacing'])
														? 'letter-spacing:' . trim($font['letter-spacing']) . ";"
														: '';
				$rez[$tag.'_margin-top'] 		= !empty($font['margin-top']) && !prolingua_is_inherit($font['margin-top'])
														? 'margin-top:' . prolingua_prepare_css_value($font['margin-top']) . ";"
														: '';
				$rez[$tag.'_margin-bottom'] 	= !empty($font['margin-bottom']) && !prolingua_is_inherit($font['margin-bottom'])
														? 'margin-bottom:' . prolingua_prepare_css_value($font['margin-bottom']) . ";"
														: '';
			} else {
				$rez[$tag.'_font-family']		= '{{ data["'.$tag.'_font-family"] }}';
				$rez[$tag.'_font-size']			= '{{ data["'.$tag.'_font-size"] }}';
				$rez[$tag.'_line-height']		= '{{ data["'.$tag.'_line-height"] }}';
				$rez[$tag.'_font-weight']		= '{{ data["'.$tag.'_font-weight"] }}';
				$rez[$tag.'_font-style']		= '{{ data["'.$tag.'_font-style"] }}';
				$rez[$tag.'_text-decoration']	= '{{ data["'.$tag.'_text-decoration"] }}';
				$rez[$tag.'_text-transform']	= '{{ data["'.$tag.'_text-transform"] }}';
				$rez[$tag.'_letter-spacing']	= '{{ data["'.$tag.'_letter-spacing"] }}';
				$rez[$tag.'_margin-top']		= '{{ data["'.$tag.'_margin-top"] }}';
				$rez[$tag.'_margin-bottom']		= '{{ data["'.$tag.'_margin-bottom"] }}';
			}
		}
		return $rez;
	}
}




//-------------------------------------------------------
//-- Thumb sizes
//-------------------------------------------------------

if ( !function_exists('prolingua_customizer_theme_setup') ) {
	add_action( 'after_setup_theme', 'prolingua_customizer_theme_setup' );
	function prolingua_customizer_theme_setup() {

		// Enable support for Post Thumbnails
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size(370, 0, false);
		
		// Add thumb sizes
		// ATTENTION! If you change list below - check filter's names in the 'trx_addons_filter_get_thumb_size' hook
		$thumb_sizes = apply_filters('prolingua_filter_add_thumb_sizes', array(
			'prolingua-thumb-huge'		=> array(1170, 658, true),
			'prolingua-thumb-big' 		=> array( 842, 472, true),
			'prolingua-thumb-med' 		=> array( 370, 208, true),
			'prolingua-thumb-tiny' 		=> array(  90,  90, true),
			'prolingua-thumb-masonry-big' => array( 760,   0, false),		// Only downscale, not crop
			'prolingua-thumb-masonry'		=> array( 370,   0, false),		// Only downscale, not crop
			)
		);
		$mult = prolingua_get_theme_option('retina_ready', 1);
		if ($mult > 1) $GLOBALS['content_width'] = apply_filters( 'prolingua_filter_content_width', 1170*$mult);
		foreach ($thumb_sizes as $k=>$v) {
			// Add Original dimensions
			add_image_size( $k, $v[0], $v[1], $v[2]);
			// Add Retina dimensions
			if ($mult > 1) add_image_size( $k.'-@retina', $v[0]*$mult, $v[1]*$mult, $v[2]);
		}

	}
}

if ( !function_exists('prolingua_customizer_image_sizes') ) {
	add_filter( 'image_size_names_choose', 'prolingua_customizer_image_sizes' );
	function prolingua_customizer_image_sizes( $sizes ) {
		$thumb_sizes = apply_filters('prolingua_filter_add_thumb_sizes', array(
			'prolingua-thumb-huge'		=> esc_html__( 'Huge image', 'prolingua' ),
			'prolingua-thumb-big'			=> esc_html__( 'Large image', 'prolingua' ),
			'prolingua-thumb-med'			=> esc_html__( 'Medium image', 'prolingua' ),
			'prolingua-thumb-tiny'		=> esc_html__( 'Small square avatar', 'prolingua' ),
			'prolingua-thumb-masonry-big'	=> esc_html__( 'Masonry Large (scaled)', 'prolingua' ),
			'prolingua-thumb-masonry'		=> esc_html__( 'Masonry (scaled)', 'prolingua' ),
            'prolingua-thumb-extra'		=> esc_html__( 'Extra image', 'prolingua' ),
			)
		);
		$mult = prolingua_get_theme_option('retina_ready', 1);
		foreach($thumb_sizes as $k=>$v) {
			$sizes[$k] = $v;
			if ($mult > 1) $sizes[$k.'-@retina'] = $v.' '.esc_html__('@2x', 'prolingua' );
		}
		return $sizes;
	}
}

// Remove some thumb-sizes from the ThemeREX Addons list
if ( !function_exists( 'prolingua_customizer_trx_addons_add_thumb_sizes' ) ) {
	add_filter( 'trx_addons_filter_add_thumb_sizes', 'prolingua_customizer_trx_addons_add_thumb_sizes');
	function prolingua_customizer_trx_addons_add_thumb_sizes($list=array()) {
		if (is_array($list)) {
			foreach ($list as $k=>$v) {
				if (in_array($k, array(
								'trx_addons-thumb-huge',
								'trx_addons-thumb-big',
								'trx_addons-thumb-medium',
								'trx_addons-thumb-tiny',
								'trx_addons-thumb-masonry-big',
								'trx_addons-thumb-masonry',
                                'trx_addons-thumb-extra',
								)
							)
						) unset($list[$k]);
			}
		}
		return $list;
	}
}

// and replace removed styles with theme-specific thumb size
if ( !function_exists( 'prolingua_customizer_trx_addons_get_thumb_size' ) ) {
	add_filter( 'trx_addons_filter_get_thumb_size', 'prolingua_customizer_trx_addons_get_thumb_size');
	function prolingua_customizer_trx_addons_get_thumb_size($thumb_size='') {
		return str_replace(array(
							'trx_addons-thumb-huge',
							'trx_addons-thumb-huge-@retina',
							'trx_addons-thumb-big',
							'trx_addons-thumb-big-@retina',
							'trx_addons-thumb-medium',
							'trx_addons-thumb-medium-@retina',
							'trx_addons-thumb-tiny',
							'trx_addons-thumb-tiny-@retina',
							'trx_addons-thumb-masonry-big',
							'trx_addons-thumb-masonry-big-@retina',
							'trx_addons-thumb-masonry',
							'trx_addons-thumb-masonry-@retina',
                            'trx_addons-thumb-extra',
                            'trx_addons-thumb-extra-@retina',
							),
							array(
							'prolingua-thumb-huge',
							'prolingua-thumb-huge-@retina',
							'prolingua-thumb-big',
							'prolingua-thumb-big-@retina',
							'prolingua-thumb-med',
							'prolingua-thumb-med-@retina',
							'prolingua-thumb-tiny',
							'prolingua-thumb-tiny-@retina',
							'prolingua-thumb-masonry-big',
							'prolingua-thumb-masonry-big-@retina',
							'prolingua-thumb-masonry',
							'prolingua-thumb-masonry-@retina',
                            'prolingua-thumb-extra',
							'prolingua-thumb-extra-@retina',
							),
							$thumb_size);
	}
}




//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( !function_exists( 'prolingua_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'prolingua_importer_set_options', 9 );
	function prolingua_importer_set_options($options=array()) {
		if (is_array($options)) {
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url(prolingua_get_protocol() . '://demofiles.themerex.net/prolingua/');
			// Required plugins
			$options['required_plugins'] = array_keys(prolingua_storage_get('required_plugins'));
			// Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 3;
			// Default demo
			$options['files']['default']['title'] = esc_html__('ProLingua Demo', 'prolingua');
			$options['files']['default']['domain_dev'] = '';		// Developers domain
			$options['files']['default']['domain_demo']= esc_url(prolingua_get_protocol().'://prolingua.themerex.net');		// Demo-site domain
			// If theme need more demo - just copy 'default' and change required parameter
			// Banners
			$options['banners'] = array(
									array(
										'image' => prolingua_get_file_url('theme-specific/theme.about/images/frontpage.png'),
										'title' => esc_html__('Front page Builder', 'prolingua'),
										'content' => wp_kses_post(__('Create your Frontpage right in WordPress Customizer! To do this, you will not need either the Visual Composer or any other Builder. Just turn on/off sections, and fill them with content and decorate to your liking', 'prolingua')),
										'link_url' => esc_url('//www.youtube.com/watch?v=VT0AUbMl_KA'),
										'link_caption' => esc_html__('More about Frontpage Builder', 'prolingua'),
										'duration' => 20
										),
									array(
										'image' => prolingua_get_file_url('theme-specific/theme.about/images/layouts.png'),
										'title' => esc_html__('Custom layouts', 'prolingua'),
										'content' => wp_kses_post(__('Forget about problems with customization of header or footer! You can edit any layout without any changes in CSS or HTML directly in Visual Builder. Moreover - you can easily create your own headers and footers and use them along with built-in', 'prolingua')),
										'link_url' => esc_url('//www.youtube.com/watch?v=pYhdFVLd7y4'),
										'link_caption' => esc_html__('More about Custom Layouts', 'prolingua'),
										'duration' => 20
										),
									array(
										'image' => prolingua_get_file_url('theme-specific/theme.about/images/documentation.png'),
										'title' => esc_html__('Read full documentation', 'prolingua'),
										'content' => wp_kses_post(__('Need more details? Please check our full online documentation for detailed information on how to use ProLingua', 'prolingua')),
										'link_url' => esc_url(prolingua_storage_get('theme_doc_url')),
										'link_caption' => esc_html__('Online documentation', 'prolingua'),
										'duration' => 15
										),
									array(
										'image' => prolingua_get_file_url('theme-specific/theme.about/images/video-tutorials.png'),
										'title' => esc_html__('Video tutorials', 'prolingua'),
										'content' => wp_kses_post(__('No time for reading documentation? Check out our video tutorials and learn how to customize ProLingua in detail.', 'prolingua')),
										'link_url' => esc_url(prolingua_storage_get('theme_video_url')),
										'link_caption' => esc_html__('Video tutorials', 'prolingua'),
										'duration' => 15
										),
									array(
										'image' => prolingua_get_file_url('theme-specific/theme.about/images/studio.png'),
										'title' => esc_html__('Mockingbird Website Custom studio', 'prolingua'),
										'content' => wp_kses_post(__('We can make a website based on this theme for a very fair price.
We can implement any extra functional: translate your website, WPML implementation and many other customization according to your request.', 'prolingua')),
										'link_url' => esc_url('//mockingbird.ticksy.com/'),
										'link_caption' => esc_html__('Contact us', 'prolingua'),
										'duration' => 25
										)
									);
		}
		return $options;
	}
}




// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if (!function_exists('prolingua_create_theme_options')) {

	function prolingua_create_theme_options() {

		// Message about options override. 
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = __('<b>Attention!</b> Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages', 'prolingua');

		prolingua_storage_set('options', array(
		
			// 'Logo & Site Identity'
			'title_tagline' => array(
				"title" => esc_html__('Logo & Site Identity', 'prolingua'),
				"desc" => '',
				"priority" => 10,
				"type" => "section"
				),
			'logo_info' => array(
				"title" => esc_html__('Logo in the header', 'prolingua'),
				"desc" => '',
				"priority" => 20,
				"type" => "info",
				),
			'logo_text' => array(
				"title" => esc_html__('Use Site Name as Logo', 'prolingua'),
				"desc" => wp_kses_data( __('Use the site title and tagline as a text logo if no image is selected', 'prolingua') ),
				"class" => "prolingua_column-1_2 prolingua_new_row",
				"priority" => 30,
				"std" => 1,
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_retina_enabled' => array(
				"title" => esc_html__('Allow retina display logo', 'prolingua'),
				"desc" => wp_kses_data( __('Show fields to select logo images for Retina display', 'prolingua') ),
				"class" => "prolingua_column-1_2",
				"priority" => 40,
				"refresh" => false,
				"std" => 0,
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_max_height' => array(
				"title" => esc_html__('Logo max. height', 'prolingua'),
				"desc" => wp_kses_data( __("Max. height of the logo image (in pixels). Maximum size of logo depends on the actual size of the picture", 'prolingua') ),
				"std" => 80,
				"min" => 20,
				"max" => 160,
				"step" => 1,
				"refresh" => false,
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "slider"
				),
			// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
			'logo_retina' => array(
				"title" => esc_html__('Logo for Retina', 'prolingua'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'prolingua') ),
				"class" => "prolingua_column-1_2",
				"priority" => 70,
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile_header' => array(
				"title" => esc_html__('Logo for the mobile header', 'prolingua'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'prolingua') ),
				"class" => "prolingua_column-1_2 prolingua_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_header_retina' => array(
				"title" => esc_html__('Logo for the mobile header for Retina', 'prolingua'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'prolingua') ),
				"class" => "prolingua_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile' => array(
				"title" => esc_html__('Logo mobile', 'prolingua'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile menu', 'prolingua') ),
				"class" => "prolingua_column-1_2 prolingua_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_retina' => array(
				"title" => esc_html__('Logo mobile for Retina', 'prolingua'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'prolingua') ),
				"class" => "prolingua_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "image"
				),
			'logo_side' => array(
				"title" => esc_html__('Logo side', 'prolingua'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu', 'prolingua') ),
				"class" => "prolingua_column-1_2 prolingua_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_side_retina' => array(
				"title" => esc_html__('Logo side for Retina', 'prolingua'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'prolingua') ),
				"class" => "prolingua_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "image"
				),
			
		
		
			// 'General settings'
			'general' => array(
				"title" => esc_html__('General Settings', 'prolingua'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 20,
				"type" => "section",
				),

			'general_layout_info' => array(
				"title" => esc_html__('Layout', 'prolingua'),
				"desc" => '',
				"type" => "info",
				),
			'body_style' => array(
				"title" => esc_html__('Body style', 'prolingua'),
				"desc" => wp_kses_data( __('Select width of the body content', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'prolingua')
				),
				"refresh" => false,
				"std" => 'wide',
				"options" => prolingua_get_list_body_styles(),
				"type" => "select"
				),
			'boxed_bg_image' => array(
				"title" => esc_html__('Boxed bg image', 'prolingua'),
				"desc" => wp_kses_data( __('Select or upload image, used as background in the boxed body', 'prolingua') ),
				"dependency" => array(
					'body_style' => array('boxed')
				),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'prolingua')
				),
				"std" => '',
				"hidden" => true,
				"type" => "image"
				),
			'remove_margins' => array(
				"title" => esc_html__('Remove margins', 'prolingua'),
				"desc" => wp_kses_data( __('Remove margins above and below the content area', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'prolingua')
				),
				"refresh" => false,
				"std" => 0,
				"type" => "checkbox"
				),

			'general_sidebar_info' => array(
				"title" => esc_html__('Sidebar', 'prolingua'),
				"desc" => '',
				"type" => "info",
				),
			'sidebar_position' => array(
				"title" => esc_html__('Sidebar position', 'prolingua'),
				"desc" => wp_kses_data( __('Select position to show sidebar', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'prolingua')
				),
				"std" => 'right',
				"options" => array(),
				"type" => "switch"
				),
			'sidebar_widgets' => array(
				"title" => esc_html__('Sidebar widgets', 'prolingua'),
				"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'prolingua')
				),
				"dependency" => array(
					'sidebar_position' => array('left', 'right')
				),
				"std" => 'sidebar_widgets',
				"options" => array(),
				"type" => "select"
				),
			'expand_content' => array(
				"title" => esc_html__('Expand content', 'prolingua'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'prolingua') ),
                "override" => array(
                    'mode' => 'page',
                    'section' => esc_html__('Content', 'prolingua')
                ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),
			'general_widgets_info' => array(
				"title" => esc_html__('Additional widgets', 'prolingua'),
				"desc" => '',
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "info",
				),
			'widgets_above_page' => array(
				"title" => esc_html__('Widgets at the top of the page', 'prolingua'),
				"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'prolingua')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
				),
			'widgets_above_content' => array(
				"title" => esc_html__('Widgets above the content', 'prolingua'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'prolingua')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_content' => array(
				"title" => esc_html__('Widgets below the content', 'prolingua'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'prolingua')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_page' => array(
				"title" => esc_html__('Widgets at the bottom of the page', 'prolingua'),
				"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'prolingua')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
				),

			'general_effects_info' => array(
				"title" => esc_html__('Design & Effects', 'prolingua'),
				"desc" => '',
				"type" => "info",
				),
			'border_radius' => array(
				"title" => esc_html__('Border radius', 'prolingua'),
				"desc" => wp_kses_data( __('Specify the border radius of the form fields and buttons in pixels or other valid CSS units', 'prolingua') ),
				"std" => 0,
				"type" => "text"
				),

			'general_misc_info' => array(
				"title" => esc_html__('Miscellaneous', 'prolingua'),
				"desc" => '',
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "info",
				),
			'seo_snippets' => array(
				"title" => esc_html__('SEO snippets', 'prolingua'),
				"desc" => wp_kses_data( __('Add structured data markup to the single posts and pages', 'prolingua') ),
				"std" => 0,
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
				),
            'privacy_text' => array(
                "title" => esc_html__("Text with Privacy Policy link", 'prolingua'),
                "desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'prolingua') ),
                "std"   => wp_kses_post( __( 'I agree that my submitted data is being collected and stored.', 'prolingua') ),
                "type"  => "text"
            ),
		
		
			// 'Header'
			'header' => array(
				"title" => esc_html__('Header', 'prolingua'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 30,
				"type" => "section"
				),

			'header_style_info' => array(
				"title" => esc_html__('Header style', 'prolingua'),
				"desc" => '',
				"type" => "info"
				),
			'header_type' => array(
				"title" => esc_html__('Header style', 'prolingua'),
				"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'prolingua')
				),
				"std" => 'default',
				"options" => prolingua_get_list_header_footer_types(),
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "switch"
				),
			'header_style' => array(
				"title" => esc_html__('Select custom layout', 'prolingua'),
				"desc" => wp_kses_data( __('Select custom header from Layouts Builder', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'prolingua')
				),
				"dependency" => array(
					'header_type' => array('custom')
				),
				"std" => PROLINGUA_THEME_FREE ? 'header-custom-sow-header-default' : 'header-custom-header-default',
				"options" => array(),
				"type" => "select"
				),
			'header_position' => array(
				"title" => esc_html__('Header position', 'prolingua'),
				"desc" => wp_kses_data( __('Select position to display the site header', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'prolingua')
				),
				"std" => 'default',
				"options" => array(),
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "switch"
				),
			'header_fullheight' => array(
				"title" => esc_html__('Header fullheight', 'prolingua'),
				"desc" => wp_kses_data( __("Enlarge header area to fill whole screen. Used only if header have a background image", 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'prolingua')
				),
				"std" => 0,
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_zoom' => array(
				"title" => esc_html__('Header zoom', 'prolingua'),
				"desc" => wp_kses_data( __("Zoom the header title. 1 - original size", 'prolingua') ),
				"std" => 1,
				"min" => 0.3,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "slider"
				),
			'header_wide' => array(
				"title" => esc_html__('Header fullwide', 'prolingua'),
				"desc" => wp_kses_data( __('Do you want to stretch the header widgets area to the entire window width?', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'prolingua')
				),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 1,
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_widgets_info' => array(
				"title" => esc_html__('Header widgets', 'prolingua'),
				"desc" => wp_kses_data( __('Here you can place a widget slider, advertising banners, etc.', 'prolingua') ),
				"type" => "info"
				),
			'header_widgets' => array(
				"title" => esc_html__('Header widgets', 'prolingua'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on each page', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'prolingua'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on this page', 'prolingua') ),
				),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'header_columns' => array(
				"title" => esc_html__('Header columns', 'prolingua'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'prolingua')
				),
				"dependency" => array(
					'header_type' => array('default'),
					'header_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => prolingua_get_list_range(0,6),
				"type" => "select"
				),

			'menu_info' => array(
				"title" => esc_html__('Main menu', 'prolingua'),
				"desc" => wp_kses_data( __('Select main menu style, position, color scheme and other parameters', 'prolingua') ),
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "info"
				),
			'menu_style' => array(
				"title" => esc_html__('Menu position', 'prolingua'),
				"desc" => wp_kses_data( __('Select position of the main menu', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'prolingua')
				),
				"std" => 'top',
				"options" => array(
					'top'	=> esc_html__('Top',	'prolingua'),
				),
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "switch"
				),
			'menu_side_stretch' => array(
				"title" => esc_html__('Stretch sidemenu', 'prolingua'),
				"desc" => wp_kses_data( __('Stretch sidemenu to window height (if menu items number >= 5)', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'prolingua')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 0,
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_side_icons' => array(
				"title" => esc_html__('Iconed sidemenu', 'prolingua'),
				"desc" => wp_kses_data( __('Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'prolingua')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_mobile_fullscreen' => array(
				"title" => esc_html__('Mobile menu fullscreen', 'prolingua'),
				"desc" => wp_kses_data( __('Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'prolingua') ),
				"std" => 1,
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_image_info' => array(
				"title" => esc_html__('Header image', 'prolingua'),
				"desc" => '',
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "info"
				),
			'header_image_override' => array(
				"title" => esc_html__('Header image override', 'prolingua'),
				"desc" => wp_kses_data( __("Allow override the header image with the page's/post's/product's/etc. featured image", 'prolingua') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'prolingua')
				),
				"std" => 0,
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_mobile_info' => array(
				"title" => esc_html__('Mobile header', 'prolingua'),
				"desc" => wp_kses_data( __("Configure the mobile version of the header", 'prolingua') ),
				"priority" => 500,
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "info"
				),
			'header_mobile_enabled' => array(
				"title" => esc_html__('Enable the mobile header', 'prolingua'),
				"desc" => wp_kses_data( __("Use the mobile version of the header (if checked) or relayout the current header on mobile devices", 'prolingua') ),
				"std" => 0,
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_additional_info' => array(
				"title" => esc_html__('Additional info', 'prolingua'),
				"desc" => wp_kses_data( __('Additional info to show at the top of the mobile header', 'prolingua') ),
				"std" => '',
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"refresh" => false,
				"teeny" => false,
				"rows" => 20,
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "text_editor"
				),
			'header_mobile_hide_info' => array(
				"title" => esc_html__('Hide additional info', 'prolingua'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_logo' => array(
				"title" => esc_html__('Hide logo', 'prolingua'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_login' => array(
				"title" => esc_html__('Hide login/logout', 'prolingua'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_search' => array(
				"title" => esc_html__('Hide search', 'prolingua'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_cart' => array(
				"title" => esc_html__('Hide cart', 'prolingua'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
				),

            // Section 'Theme Specific'
            'custom_sections_section' => array(
                "title" => esc_html__('Custom Section', 'prolingua'),
                "desc" => wp_kses_data( __("Theme specific settings", 'prolingua') ),
                "type" => "section"
            ),
            'custom_sections_info' => array(
                "title" => esc_html__('Custom sections', 'prolingua'),
                "desc" => wp_kses_data( __("Custom left and right sections", 'prolingua') ),
                "type" => "info"
            ),
            'custom_sections_socials' => array(
                "title" => esc_html__('Show right section with socials', 'prolingua'),
                "desc" => wp_kses_data( __("Uncheck this field to hide right section (Socials working with plugin ThemeRex Addons)", 'prolingua') ),
                "override" => array(
                    'mode' => 'page',
                    'section' => esc_html__('Content', 'prolingua')
                ),
                "std" => "0",
                "type" => "checkbox"
            ),
            'custom_sections_links' => array(
                "title" => esc_html__('Show left section with links', 'prolingua'),
                "desc" => wp_kses_data( __("Uncheck this field to hide left section", 'prolingua') ),
                "override" => array(
                    'mode' => 'page',
                    'section' => esc_html__('Content', 'prolingua')
                ),
                "std" => "0",
                "type" => "checkbox"
            ),
            'custom_sections_link' => array(
                "title" => esc_html__("Link 1", 'prolingua'),
                "desc" => wp_kses_data( __("Custom Text Link", 'prolingua') ),
                "std" => '',
                "type" => "text"
            ),
            'custom_sections_url' => array(
                "title" => esc_html__("URL", 'prolingua'),
                "desc" => wp_kses_data( __("URL for first link", 'prolingua') ),
                "std" => '',
                "type" => "text"
            ),
            'custom_sections_link2' => array(
                "title" => esc_html__("Link 2", 'prolingua'),
                "desc" => wp_kses_data( __("Custom Text Link 2", 'prolingua') ),
                "std" => '',
                "type" => "text"
            ),
            'custom_sections_url2' => array(
                "title" => esc_html__("URL", 'prolingua'),
                "desc" => wp_kses_data( __("URL for second link", 'prolingua') ),
                "std" => '',
                "type" => "text"
            ),

            'custom_sections_boxed_hide' => array(
                "title" => esc_html__('Hide sections on boxed version', 'prolingua'),
                "desc" => wp_kses_data( __("Uncheck this field to show sections on boxed version", 'prolingua') ),
                "std" => "0",
                "type" => "checkbox"
            ),


			// 'Footer'
			'footer' => array(
				"title" => esc_html__('Footer', 'prolingua'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 50,
				"type" => "section"
				),
			'footer_type' => array(
				"title" => esc_html__('Footer style', 'prolingua'),
				"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'prolingua')
				),
				"std" => 'default',
				"options" => prolingua_get_list_header_footer_types(),
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "switch"
				),
			'footer_style' => array(
				"title" => esc_html__('Select custom layout', 'prolingua'),
				"desc" => wp_kses_data( __('Select custom footer from Layouts Builder', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'prolingua')
				),
				"dependency" => array(
					'footer_type' => array('custom')
				),
				"std" => 'footer-default',
				"options" => array(),
				"type" => "select"
				),
			'footer_widgets' => array(
				"title" => esc_html__('Footer widgets', 'prolingua'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'prolingua')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 'footer_widgets',
				"options" => array(),
				"type" => "select"
				),
			'footer_columns' => array(
				"title" => esc_html__('Footer columns', 'prolingua'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'prolingua')
				),
				"dependency" => array(
					'footer_type' => array('default'),
					'footer_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => prolingua_get_list_range(0,6),
				"type" => "select"
				),
			'footer_wide' => array(
				"title" => esc_html__('Footer fullwide', 'prolingua'),
				"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'prolingua') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'prolingua')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_in_footer' => array(
				"title" => esc_html__('Show logo', 'prolingua'),
				"desc" => wp_kses_data( __('Show logo in the footer', 'prolingua') ),
				'refresh' => false,
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_footer' => array(
				"title" => esc_html__('Logo for footer', 'prolingua'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the footer', 'prolingua') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1)
				),
				"std" => '',
				"type" => "image"
				),
			'logo_footer_retina' => array(
				"title" => esc_html__('Logo for footer (Retina)', 'prolingua'),
				"desc" => wp_kses_data( __('Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'prolingua') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1),
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "image"
				),
			'socials_in_footer' => array(
				"title" => esc_html__('Show social icons', 'prolingua'),
				"desc" => wp_kses_data( __('Show social icons in the footer (under logo or footer widgets)', 'prolingua') ),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'copyright' => array(
				"title" => esc_html__('Copyright', 'prolingua'),
				"desc" => wp_kses_data( __('Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'prolingua') ),
				"std" => esc_html__('Copyright &copy; {Y} by ThemeREX. All rights reserved.', 'prolingua'),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"refresh" => false,
				"type" => "textarea"
				),
			
		
		
			// 'Blog'
			'blog' => array(
				"title" => esc_html__('Blog', 'prolingua'),
				"desc" => wp_kses_data( __('Options of the the blog archive', 'prolingua') ),
				"priority" => 70,
				"type" => "panel",
				),
		
				// Blog - Posts page
				'blog_general' => array(
					"title" => esc_html__('Posts page', 'prolingua'),
					"desc" => wp_kses_data( __('Style and components of the blog archive', 'prolingua') ),
					"type" => "section",
					),
				'blog_general_info' => array(
					"title" => esc_html__('General settings', 'prolingua'),
					"desc" => '',
					"type" => "info",
					),
				'blog_style' => array(
					"title" => esc_html__('Blog style', 'prolingua'),
					"desc" => '',
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'prolingua')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"std" => 'excerpt',
					"options" => array(),
					"type" => "select"
					),
				'first_post_large' => array(
					"title" => esc_html__('First post large', 'prolingua'),
					"desc" => wp_kses_data( __('Make your first post stand out by making it bigger', 'prolingua') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'prolingua')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array('classic', 'masonry')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				"blog_content" => array( 
					"title" => esc_html__('Posts content', 'prolingua'),
					"desc" => wp_kses_data( __("Display either post excerpts or the full post content", 'prolingua') ),
					"std" => "excerpt",
					"dependency" => array(
						'blog_style' => array('excerpt')
					),
					"options" => array(
						'excerpt'	=> esc_html__('Excerpt',	'prolingua'),
						'fullpost'	=> esc_html__('Full post',	'prolingua')
					),
					"type" => "switch"
					),
				'excerpt_length' => array(
					"title" => esc_html__('Excerpt length', 'prolingua'),
					"desc" => wp_kses_data( __("Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged", 'prolingua') ),
					"dependency" => array(
						'blog_style' => array('excerpt'),
						'blog_content' => array('excerpt')
					),
					"std" => 60,
					"type" => "text"
					),
				'blog_columns' => array(
					"title" => esc_html__('Blog columns', 'prolingua'),
					"desc" => wp_kses_data( __('How many columns should be used in the blog archive (from 2 to 4)?', 'prolingua') ),
					"std" => 2,
					"options" => prolingua_get_list_range(2,4),
					"type" => "hidden"
					),
				'post_type' => array(
					"title" => esc_html__('Post type', 'prolingua'),
					"desc" => wp_kses_data( __('Select post type to show in the blog archive', 'prolingua') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'prolingua')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"linked" => 'parent_cat',
					"refresh" => false,
					"hidden" => true,
					"std" => 'post',
					"options" => array(),
					"type" => "select"
					),
				'parent_cat' => array(
					"title" => esc_html__('Category to show', 'prolingua'),
					"desc" => wp_kses_data( __('Select category to show in the blog archive', 'prolingua') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'prolingua')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"refresh" => false,
					"hidden" => true,
					"std" => '0',
					"options" => array(),
					"type" => "select"
					),
				'posts_per_page' => array(
					"title" => esc_html__('Posts per page', 'prolingua'),
					"desc" => wp_kses_data( __('How many posts will be displayed on this page', 'prolingua') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'prolingua')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"hidden" => true,
					"std" => '',
					"type" => "text"
					),
				"blog_pagination" => array( 
					"title" => esc_html__('Pagination style', 'prolingua'),
					"desc" => wp_kses_data( __('Show Older/Newest posts or Page numbers below the posts list', 'prolingua') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'prolingua')
					),
					"std" => "pages",
					"options" => array(
						'pages'	=> esc_html__("Page numbers", 'prolingua'),
						'links'	=> esc_html__("Older/Newest", 'prolingua'),
						'more'	=> esc_html__("Load more", 'prolingua'),
						'infinite' => esc_html__("Infinite scroll", 'prolingua')
					),
					"type" => "select"
					),
				'show_filters' => array(
					"title" => esc_html__('Show filters', 'prolingua'),
					"desc" => wp_kses_data( __('Show categories as tabs to filter posts', 'prolingua') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'prolingua')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array('portfolio', 'gallery')
					),
					"hidden" => true,
					"std" => 0,
					"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
					),
	
				'blog_sidebar_info' => array(
					"title" => esc_html__('Sidebar', 'prolingua'),
					"desc" => '',
					"type" => "info",
					),
				'sidebar_position_blog' => array(
					"title" => esc_html__('Sidebar position', 'prolingua'),
					"desc" => wp_kses_data( __('Select position to show sidebar', 'prolingua') ),
					"std" => 'right',
					"options" => array(),
					"type" => "switch"
					),
				'sidebar_widgets_blog' => array(
					"title" => esc_html__('Sidebar widgets', 'prolingua'),
					"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'prolingua') ),
					"dependency" => array(
						'sidebar_position_blog' => array('left', 'right')
					),
					"std" => 'sidebar_widgets',
					"options" => array(),
					"type" => "select"
					),
				'expand_content_blog' => array(
					"title" => esc_html__('Expand content', 'prolingua'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'prolingua') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
	
	
				'blog_widgets_info' => array(
					"title" => esc_html__('Additional widgets', 'prolingua'),
					"desc" => '',
					"type" => PROLINGUA_THEME_FREE ? "hidden" : "info",
					),
				'widgets_above_page_blog' => array(
					"title" => esc_html__('Widgets at the top of the page', 'prolingua'),
					"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'prolingua') ),
					"std" => 'hide',
					"options" => array(),
					"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
					),
				'widgets_above_content_blog' => array(
					"title" => esc_html__('Widgets above the content', 'prolingua'),
					"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'prolingua') ),
					"std" => 'hide',
					"options" => array(),
					"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_content_blog' => array(
					"title" => esc_html__('Widgets below the content', 'prolingua'),
					"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'prolingua') ),
					"std" => 'hide',
					"options" => array(),
					"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_page_blog' => array(
					"title" => esc_html__('Widgets at the bottom of the page', 'prolingua'),
					"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'prolingua') ),
					"std" => 'hide',
					"options" => array(),
					"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
					),

				'blog_advanced_info' => array(
					"title" => esc_html__('Advanced settings', 'prolingua'),
					"desc" => '',
					"type" => "info",
					),
				'no_image' => array(
					"title" => esc_html__('Image placeholder', 'prolingua'),
					"desc" => wp_kses_data( __('Select or upload an image used as placeholder for posts without a featured image', 'prolingua') ),
					"std" => '',
					"type" => "image"
					),
				'time_diff_before' => array(
					"title" => esc_html__('Easy Readable Date Format', 'prolingua'),
					"desc" => wp_kses_data( __("For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'prolingua') ),
					"std" => 5,
					"type" => "text"
					),
				'sticky_style' => array(
					"title" => esc_html__('Sticky posts style', 'prolingua'),
					"desc" => wp_kses_data( __('Select style of the sticky posts output', 'prolingua') ),
					"std" => 'inherit',
					"options" => array(
						'inherit' => esc_html__('Decorated posts', 'prolingua'),
						'columns' => esc_html__('Mini-cards',	'prolingua')
					),
					"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
					),
				"blog_animation" => array( 
					"title" => esc_html__('Animation for the posts', 'prolingua'),
					"desc" => wp_kses_data( __('Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'prolingua') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'prolingua')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"std" => "none",
					"options" => array(),
					"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
					),
				'meta_parts' => array(
					"title" => esc_html__('Post meta', 'prolingua'),
					"desc" => wp_kses_data( __("If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page.", 'prolingua') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'prolingua') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'prolingua')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=0|date=0|counters=1|author=0|share=0|edit=1',
					"options" => array(
						'categories' => esc_html__('Categories', 'prolingua'),
						'date'		 => esc_html__('Post date', 'prolingua'),
						'author'	 => esc_html__('Post author', 'prolingua'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'prolingua'),
						'share'		 => esc_html__('Share links', 'prolingua'),
						'edit'		 => esc_html__('Edit link', 'prolingua')
					),
					"type" => PROLINGUA_THEME_FREE ? "hidden" : "checklist"
				),
				'counters' => array(
					"title" => esc_html__('Views, Likes and Comments', 'prolingua'),
					"desc" => wp_kses_data( __("Likes and Views are available only if ThemeREX Addons is active", 'prolingua') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'prolingua')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=0|likes=1|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'prolingua'),
						'likes' => esc_html__('Likes', 'prolingua'),
						'comments' => esc_html__('Comments', 'prolingua')
					),
					"type" => PROLINGUA_THEME_FREE ? "hidden" : "checklist"
				),

				
				// Blog - Single posts
				'blog_single' => array(
					"title" => esc_html__('Single posts', 'prolingua'),
					"desc" => wp_kses_data( __('Settings of the single post', 'prolingua') ),
					"type" => "section",
					),
                'header_type_post' => array(
                    "title" => esc_html__('Header style', 'prolingua'),
                    "desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'prolingua') ),
                    "override" => array(
                        'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
                        'section' => esc_html__('Header', 'prolingua')
                    ),
                    "std" => 'default',
                    "options" => prolingua_get_list_header_footer_types(),
                    "type" => PROLINGUA_THEME_FREE ? "hidden" : "switch"
                ),
                'header_style_post' => array(
                    "title" => esc_html__('Select custom layout', 'prolingua'),
                    "desc" => wp_kses_data( __('Select custom header from Layouts Builder', 'prolingua') ),
                    "dependency" => array(
                        'header_type_post' => array('custom')
                    ),
                    "std" => 'header-default',
                    "options" => array(),
                    "type" => "select"
                ),

                'expand_content_post' => array(
                    "title" => esc_html__('Expand content', 'prolingua'),
                    "desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'prolingua') ),
                    "refresh" => false,
                    "std" => 0,
                    "type" => "checkbox"
                ),
				'hide_featured_on_single' => array(
					"title" => esc_html__('Hide featured image on the single post', 'prolingua'),
					"desc" => wp_kses_data( __("Hide featured image on the single post's pages", 'prolingua') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'prolingua')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'hide_sidebar_on_single' => array(
					"title" => esc_html__('Hide sidebar on the single post', 'prolingua'),
					"desc" => wp_kses_data( __("Hide sidebar on the single post's pages", 'prolingua') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'show_post_meta' => array(
					"title" => esc_html__('Show post meta', 'prolingua'),
					"desc" => wp_kses_data( __("Display block with post's meta: date, categories, counters, etc.", 'prolingua') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'meta_parts_post' => array(
					"title" => esc_html__('Post meta', 'prolingua'),
					"desc" => wp_kses_data( __("Meta parts for single posts.", 'prolingua') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=0|date=1|counters=1|author=1|share=0|edit=1',
					"options" => array(
						'categories' => esc_html__('Categories', 'prolingua'),
						'date'		 => esc_html__('Post date', 'prolingua'),
						'author'	 => esc_html__('Post author', 'prolingua'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'prolingua'),
						'share'		 => esc_html__('Share links', 'prolingua'),
						'edit'		 => esc_html__('Edit link', 'prolingua')
					),
					"type" => PROLINGUA_THEME_FREE ? "hidden" : "checklist"
				),
				'counters_post' => array(
					"title" => esc_html__('Views, Likes and Comments', 'prolingua'),
					"desc" => wp_kses_data( __("Likes and Views are available only if ThemeREX Addons is active", 'prolingua') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=0|likes=1|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'prolingua'),
						'likes' => esc_html__('Likes', 'prolingua'),
						'comments' => esc_html__('Comments', 'prolingua')
					),
					"type" => PROLINGUA_THEME_FREE ? "hidden" : "checklist"
				),
				'show_share_links' => array(
					"title" => esc_html__('Show share links', 'prolingua'),
					"desc" => wp_kses_data( __("Display share links on the single post", 'prolingua') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'show_author_info' => array(
					"title" => esc_html__('Show author info', 'prolingua'),
					"desc" => wp_kses_data( __("Display block with information about post's author", 'prolingua') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'blog_single_related_info' => array(
					"title" => esc_html__('Related posts', 'prolingua'),
					"desc" => '',
					"type" => "info",
					),
				'show_related_posts' => array(
					"title" => esc_html__('Show related posts', 'prolingua'),
					"desc" => wp_kses_data( __("Show section 'Related posts' on the single post's pages", 'prolingua') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'prolingua')
					),
					"std" => 1,
					"type" => "checkbox"
					),
				'related_posts' => array(
					"title" => esc_html__('Related posts', 'prolingua'),
					"desc" => wp_kses_data( __('How many related posts should be displayed in the single post? If 0 - no related posts shown.', 'prolingua') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => prolingua_get_list_range(1,9),
					"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
					),
				'related_columns' => array(
					"title" => esc_html__('Related columns', 'prolingua'),
					"desc" => wp_kses_data( __('How many columns should be used to output related posts in the single page (from 2 to 4)?', 'prolingua') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => prolingua_get_list_range(1,4),
					"type" => PROLINGUA_THEME_FREE ? "hidden" : "switch"
					),
			'blog_end' => array(
				"type" => "panel_end",
				),
			
		
		
			// 'Colors'
			'panel_colors' => array(
				"title" => esc_html__('Colors', 'prolingua'),
				"desc" => '',
				"priority" => 300,
				"type" => "section"
				),

			'color_schemes_info' => array(
				"title" => esc_html__('Color schemes', 'prolingua'),
				"desc" => wp_kses_data( __('Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'prolingua') ),
				"type" => "info",
				),
			'color_scheme' => array(
				"title" => esc_html__('Site Color Scheme', 'prolingua'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'prolingua')
				),
				"std" => 'default',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'header_scheme' => array(
				"title" => esc_html__('Header Color Scheme', 'prolingua'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'prolingua')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'menu_scheme' => array(
				"title" => esc_html__('Sidemenu Color Scheme', 'prolingua'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'prolingua')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "switch"
				),
			'sidebar_scheme' => array(
				"title" => esc_html__('Sidebar Color Scheme', 'prolingua'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'prolingua')
				),
				"std" => 'dark',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'footer_scheme' => array(
				"title" => esc_html__('Footer Color Scheme', 'prolingua'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'prolingua')
				),
				"std" => 'dark',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),

			'color_scheme_editor_info' => array(
				"title" => esc_html__('Color scheme editor', 'prolingua'),
				"desc" => wp_kses_data(__('Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'prolingua') ),
				"type" => "info",
				),
			'scheme_storage' => array(
				"title" => esc_html__('Color scheme editor', 'prolingua'),
				"desc" => '',
				"std" => '$prolingua_get_scheme_storage',
				"refresh" => false,
				"colorpicker" => "tiny",
				"type" => "scheme_editor"
				),


			// 'Hidden'
			'media_title' => array(
				"title" => esc_html__('Media title', 'prolingua'),
				"desc" => wp_kses_data( __('Used as title for the audio and video item in this post', 'prolingua') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'prolingua')
				),
				"hidden" => true,
				"std" => '',
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "text"
				),
			'media_author' => array(
				"title" => esc_html__('Media author', 'prolingua'),
				"desc" => wp_kses_data( __('Used as author name for the audio and video item in this post', 'prolingua') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'prolingua')
				),
				"hidden" => true,
				"std" => '',
				"type" => PROLINGUA_THEME_FREE ? "hidden" : "text"
				),


			// Internal options.
			// Attention! Don't change any options in the section below!
			// Use huge priority to call render this elements after all options!
			'reset_options' => array(
				"title" => '',
				"desc" => '',
				"std" => '0',
				"priority" => 10000,
				"type" => "hidden",
				),

			'last_option' => array(		// Need to manually call action to include Tiny MCE scripts
				"title" => '',
				"desc" => '',
				"std" => 1,
				"type" => "hidden",
				),

		));


		// Prepare panel 'Fonts'
		$fonts = array(
		
			// 'Fonts'
			'fonts' => array(
				"title" => esc_html__('Typography', 'prolingua'),
				"desc" => '',
				"priority" => 200,
				"type" => "panel"
				),

			// Fonts - Load_fonts
			'load_fonts' => array(
				"title" => esc_html__('Load fonts', 'prolingua'),
				"desc" => wp_kses_data( __('Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'prolingua') )
						. '<br>'
						. wp_kses_data( __('<b>Attention!</b> Press "Refresh" button to reload preview area after the all fonts are changed', 'prolingua') ),
				"type" => "section"
				),
			'load_fonts_subset' => array(
				"title" => esc_html__('Google fonts subsets', 'prolingua'),
				"desc" => wp_kses_data( __('Specify comma separated list of the subsets which will be load from Google fonts', 'prolingua') )
						. '<br>'
						. wp_kses_data( __('Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'prolingua') ),
				"class" => "prolingua_column-1_3 prolingua_new_row",
				"refresh" => false,
				"std" => '$prolingua_get_load_fonts_subset',
				"type" => "text"
				)
		);

		for ($i=1; $i<=prolingua_get_theme_setting('max_load_fonts'); $i++) {
			if (prolingua_get_value_gp('page') != 'theme_options') {
				$fonts["load_fonts-{$i}-info"] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					"title" => esc_html(sprintf(__('Font %s', 'prolingua'), $i)),
					"desc" => '',
					"type" => "info",
					);
			}
			$fonts["load_fonts-{$i}-name"] = array(
				"title" => esc_html__('Font name', 'prolingua'),
				"desc" => '',
				"class" => "prolingua_column-1_3 prolingua_new_row",
				"refresh" => false,
				"std" => '$prolingua_get_load_fonts_option',
				"type" => "text"
				);
			$fonts["load_fonts-{$i}-family"] = array(
				"title" => esc_html__('Font family', 'prolingua'),
				"desc" => $i==1 
							? wp_kses_data( __('Select font family to use it if font above is not available', 'prolingua') )
							: '',
				"class" => "prolingua_column-1_3",
				"refresh" => false,
				"std" => '$prolingua_get_load_fonts_option',
				"options" => array(
					'inherit' => esc_html__("Inherit", 'prolingua'),
					'serif' => esc_html__('serif', 'prolingua'),
					'sans-serif' => esc_html__('sans-serif', 'prolingua'),
					'monospace' => esc_html__('monospace', 'prolingua'),
					'cursive' => esc_html__('cursive', 'prolingua'),
					'fantasy' => esc_html__('fantasy', 'prolingua')
				),
				"type" => "select"
				);
			$fonts["load_fonts-{$i}-styles"] = array(
				"title" => esc_html__('Font styles', 'prolingua'),
				"desc" => $i==1 
							? wp_kses_data( __('Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'prolingua') )
								. '<br>'
								. wp_kses_data( __('<b>Attention!</b> Each weight and style increase download size! Specify only used weights and styles.', 'prolingua') )
							: '',
				"class" => "prolingua_column-1_3",
				"refresh" => false,
				"std" => '$prolingua_get_load_fonts_option',
				"type" => "text"
				);
		}
		$fonts['load_fonts_end'] = array(
			"type" => "section_end"
			);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = prolingua_get_theme_fonts();
		foreach ($theme_fonts as $tag=>$v) {
			$fonts["{$tag}_section"] = array(
				"title" => !empty($v['title']) 
								? $v['title'] 
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html(sprintf(__('%s settings', 'prolingua'), $tag)),
				"desc" => !empty($v['description']) 
								? $v['description'] 
								// Translators: Add tag's name to make description
								: wp_kses_post( sprintf(__('Font settings of the "%s" tag.', 'prolingua'), $tag) ),
				"type" => "section",
				);
	
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$options = '';
				$type = 'text';
				$title = ucfirst(str_replace('-', ' ', $css_prop));
				if ($css_prop == 'font-family') {
					$type = 'select';
					$options = array();
				} else if ($css_prop == 'font-weight') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'prolingua'),
						'100' => esc_html__('100 (Light)', 'prolingua'), 
						'200' => esc_html__('200 (Light)', 'prolingua'), 
						'300' => esc_html__('300 (Thin)',  'prolingua'),
						'400' => esc_html__('400 (Normal)', 'prolingua'),
						'500' => esc_html__('500 (Semibold)', 'prolingua'),
						'600' => esc_html__('600 (Semibold)', 'prolingua'),
						'700' => esc_html__('700 (Bold)', 'prolingua'),
						'800' => esc_html__('800 (Black)', 'prolingua'),
						'900' => esc_html__('900 (Black)', 'prolingua')
					);
				} else if ($css_prop == 'font-style') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'prolingua'),
						'normal' => esc_html__('Normal', 'prolingua'), 
						'italic' => esc_html__('Italic', 'prolingua')
					);
				} else if ($css_prop == 'text-decoration') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'prolingua'),
						'none' => esc_html__('None', 'prolingua'), 
						'underline' => esc_html__('Underline', 'prolingua'),
						'overline' => esc_html__('Overline', 'prolingua'),
						'line-through' => esc_html__('Line-through', 'prolingua')
					);
				} else if ($css_prop == 'text-transform') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'prolingua'),
						'none' => esc_html__('None', 'prolingua'), 
						'uppercase' => esc_html__('Uppercase', 'prolingua'),
						'lowercase' => esc_html__('Lowercase', 'prolingua'),
						'capitalize' => esc_html__('Capitalize', 'prolingua')
					);
				}
				$fonts["{$tag}_{$css_prop}"] = array(
					"title" => $title,
					"desc" => '',
					"class" => "prolingua_column-1_5",
					"refresh" => false,
					"std" => '$prolingua_get_theme_fonts_option',
					"options" => $options,
					"type" => $type
				);
			}
			
			$fonts["{$tag}_section_end"] = array(
				"type" => "section_end"
				);
		}

		$fonts['fonts_end'] = array(
			"type" => "panel_end"
			);

		// Add fonts parameters to Theme Options
		prolingua_storage_set_array_before('options', 'panel_colors', $fonts);

		// Add Header Video if WP version < 4.7
		if (!function_exists('get_header_video_url')) {
			prolingua_storage_set_array_after('options', 'header_image_override', 'header_video', array(
				"title" => esc_html__('Header video', 'prolingua'),
				"desc" => wp_kses_data( __("Select video to use it as background for the header", 'prolingua') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'prolingua')
				),
				"std" => '',
				"type" => "video"
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is 'Theme Options'
		if (!function_exists('the_custom_logo') || (isset($_REQUEST['page']) && $_REQUEST['page']=='theme_options')) {
			prolingua_storage_set_array_before('options', 'logo_retina', function_exists('the_custom_logo') ? 'custom_logo' : 'logo', array(
				"title" => esc_html__('Logo', 'prolingua'),
				"desc" => wp_kses_data( __('Select or upload the site logo', 'prolingua') ),
				"class" => "prolingua_column-1_2 prolingua_new_row",
				"priority" => 60,
				"std" => '',
				"type" => "image"
				)
			);
		}
	}
}


// Returns a list of options that can be overridden for CPT
if (!function_exists('prolingua_options_get_list_cpt_options')) {
	function prolingua_options_get_list_cpt_options($cpt, $title='') {
		if (empty($title)) $title = ucfirst($cpt);
		return array(
					"header_info_{$cpt}" => array(
						"title" => esc_html__('Header', 'prolingua'),
						"desc" => '',
						"type" => "info",
						),
					"header_type_{$cpt}" => array(
						"title" => esc_html__('Header style', 'prolingua'),
						"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'prolingua') ),
						"std" => 'inherit',
						"options" => prolingua_get_list_header_footer_types(true),
						"type" => PROLINGUA_THEME_FREE ? "hidden" : "switch"
						),
					"header_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'prolingua'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select custom layout to display the site header on the %s pages', 'prolingua'), $title) ),
						"dependency" => array(
							"header_type_{$cpt}" => array('custom')
						),
						"std" => 'inherit',
						"options" => array(),
						"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
						),
					"header_position_{$cpt}" => array(
						"title" => esc_html__('Header position', 'prolingua'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to display the site header on the %s pages', 'prolingua'), $title) ),
						"std" => 'inherit',
						"options" => array(),
						"type" => PROLINGUA_THEME_FREE ? "hidden" : "switch"
						),
					"header_image_override_{$cpt}" => array(
						"title" => esc_html__('Header image override', 'prolingua'),
						"desc" => wp_kses_data( __("Allow override the header image with the post's featured image", 'prolingua') ),
						"std" => 0,
						"type" => PROLINGUA_THEME_FREE ? "hidden" : "checkbox"
						),
					"header_widgets_{$cpt}" => array(
						"title" => esc_html__('Header widgets', 'prolingua'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select set of widgets to show in the header on the %s pages', 'prolingua'), $title) ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
						
					"sidebar_info_{$cpt}" => array(
						"title" => esc_html__('Sidebar', 'prolingua'),
						"desc" => '',
						"type" => "info",
						),
					"sidebar_position_{$cpt}" => array(
						"title" => esc_html__('Sidebar position', 'prolingua'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to show sidebar on the %s pages', 'prolingua'), $title) ),
						"refresh" => false,
						"std" => 'left',
						"options" => array(),
						"type" => "switch"
						),
					"sidebar_widgets_{$cpt}" => array(
						"title" => esc_html__('Sidebar widgets', 'prolingua'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select sidebar to show on the %s pages', 'prolingua'), $title) ),
						"dependency" => array(
							"sidebar_position_{$cpt}" => array('left', 'right')
						),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"hide_sidebar_on_single_{$cpt}" => array(
						"title" => esc_html__('Hide sidebar on the single pages', 'prolingua'),
						"desc" => wp_kses_data( __("Hide sidebar on the single page", 'prolingua') ),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"footer_info_{$cpt}" => array(
						"title" => esc_html__('Footer', 'prolingua'),
						"desc" => '',
						"type" => "info",
						),
					"footer_type_{$cpt}" => array(
						"title" => esc_html__('Footer style', 'prolingua'),
						"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'prolingua') ),
						"std" => 'inherit',
						"options" => prolingua_get_list_header_footer_types(true),
						"type" => PROLINGUA_THEME_FREE ? "hidden" : "switch"
						),
					"footer_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'prolingua'),
						"desc" => wp_kses_data( __('Select custom layout to display the site footer', 'prolingua') ),
						"std" => 'inherit',
						"dependency" => array(
							"footer_type_{$cpt}" => array('custom')
						),
						"options" => array(),
						"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
						),
					"footer_widgets_{$cpt}" => array(
						"title" => esc_html__('Footer widgets', 'prolingua'),
						"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'prolingua') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 'footer_widgets',
						"options" => array(),
						"type" => "select"
						),
					"footer_columns_{$cpt}" => array(
						"title" => esc_html__('Footer columns', 'prolingua'),
						"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'prolingua') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default'),
							"footer_widgets_{$cpt}" => array('^hide')
						),
						"std" => 0,
						"options" => prolingua_get_list_range(0,6),
						"type" => "select"
						),
					"footer_wide_{$cpt}" => array(
						"title" => esc_html__('Footer fullwide', 'prolingua'),
						"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'prolingua') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"widgets_info_{$cpt}" => array(
						"title" => esc_html__('Additional panels', 'prolingua'),
						"desc" => '',
						"type" => PROLINGUA_THEME_FREE ? "hidden" : "info",
						),
					"widgets_above_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the top of the page', 'prolingua'),
						"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'prolingua') ),
						"std" => 'hide',
						"options" => array(),
						"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
						),
					"widgets_above_content_{$cpt}" => array(
						"title" => esc_html__('Widgets above the content', 'prolingua'),
						"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'prolingua') ),
						"std" => 'hide',
						"options" => array(),
						"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_content_{$cpt}" => array(
						"title" => esc_html__('Widgets below the content', 'prolingua'),
						"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'prolingua') ),
						"std" => 'hide',
						"options" => array(),
						"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the bottom of the page', 'prolingua'),
						"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'prolingua') ),
						"std" => 'hide',
						"options" => array(),
						"type" => PROLINGUA_THEME_FREE ? "hidden" : "select"
						)
					);
	}
}


// Return lists with choises when its need in the admin mode
if (!function_exists('prolingua_options_get_list_choises')) {
	add_filter('prolingua_filter_options_get_list_choises', 'prolingua_options_get_list_choises', 10, 2);
	function prolingua_options_get_list_choises($list, $id) {
		if (is_array($list) && count($list)==0) {
			if (strpos($id, 'header_style')===0)
				$list = prolingua_get_list_header_styles(strpos($id, 'header_style_')===0);
			else if (strpos($id, 'header_position')===0)
				$list = prolingua_get_list_header_positions(strpos($id, 'header_position_')===0);
			else if (strpos($id, 'header_widgets')===0)
				$list = prolingua_get_list_sidebars(strpos($id, 'header_widgets_')===0, true);
			else if (substr($id, -7) == '_scheme')
				$list = prolingua_get_list_schemes($id!='color_scheme');
			else if (strpos($id, 'sidebar_widgets')===0)
				$list = prolingua_get_list_sidebars(strpos($id, 'sidebar_widgets_')===0, true);
			else if (strpos($id, 'sidebar_position')===0)
				$list = prolingua_get_list_sidebars_positions(strpos($id, 'sidebar_position_')===0);
			else if (strpos($id, 'widgets_above_page')===0)
				$list = prolingua_get_list_sidebars(strpos($id, 'widgets_above_page_')===0, true);
			else if (strpos($id, 'widgets_above_content')===0)
				$list = prolingua_get_list_sidebars(strpos($id, 'widgets_above_content_')===0, true);
			else if (strpos($id, 'widgets_below_page')===0)
				$list = prolingua_get_list_sidebars(strpos($id, 'widgets_below_page_')===0, true);
			else if (strpos($id, 'widgets_below_content')===0)
				$list = prolingua_get_list_sidebars(strpos($id, 'widgets_below_content_')===0, true);
			else if (strpos($id, 'footer_style')===0)
				$list = prolingua_get_list_footer_styles(strpos($id, 'footer_style_')===0);
			else if (strpos($id, 'footer_widgets')===0)
				$list = prolingua_get_list_sidebars(strpos($id, 'footer_widgets_')===0, true);
			else if (strpos($id, 'blog_style')===0)
				$list = prolingua_get_list_blog_styles(strpos($id, 'blog_style_')===0);
			else if (strpos($id, 'post_type')===0)
				$list = prolingua_get_list_posts_types();
			else if (strpos($id, 'parent_cat')===0)
				$list = prolingua_array_merge(array(0 => esc_html__('- Select category -', 'prolingua')), prolingua_get_list_categories());
			else if (strpos($id, 'blog_animation')===0)
				$list = prolingua_get_list_animations_in();
			else if ($id == 'color_scheme_editor')
				$list = prolingua_get_list_schemes();
			else if (strpos($id, '_font-family') > 0)
				$list = prolingua_get_list_load_fonts(true);
		}
		return $list;
	}
}
?>