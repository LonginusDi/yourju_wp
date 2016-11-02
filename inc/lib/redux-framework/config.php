<?php

if ( ! class_exists( 'Redux' ) ) {
	return;
}

$options_pages = array();
$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
$options_pages[''] = 'Select a page:';
foreach ($options_pages_obj as $_page) {
	$options_pages[$_page->ID] = $_page->post_title;
}

$opt_name = "citytours";
$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
	'opt_name'             => $opt_name,
	'disable_tracking' => true,
	'display_name'         => $theme->get( 'Name' ),
	'display_version'      => $theme->get( 'Version' ),
	'menu_type'            => 'submenu',
	'allow_sub_menu'       => false,
	'menu_title'           => __( 'Theme Options', 'citytours' ),
	'page_title'           => __( 'CityTours Theme Options', 'citytours' ),
	'google_api_key'       => '',
	'google_update_weekly' => false,
	'async_typography'     => true,
	//'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
	'admin_bar'            => true,
	'admin_bar_icon'       => 'dashicons-portfolio',
	'admin_bar_priority'   => 50,
	'global_variable'      => 'ct_options',
	'dev_mode'             => false,
	'update_notice'        => false,
	'customizer'           => true,
	//'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
	//'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
	'page_priority'        => null,
	'page_parent'          => 'themes.php',
	'page_permissions'     => 'manage_options',
	'menu_icon'            => '',
	'last_tab'             => '',
	'page_icon'            => 'icon-themes',
	'page_slug'            => 'CityTours',
	'save_defaults'        => true,
	'default_show'         => false,
	'default_mark'         => '',
	'show_import_export'   => true,
	'transient_time'       => 60 * MINUTE_IN_SECONDS,
	'output'               => true,
	'output_tag'           => true,
	// 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
	'database'             => '',
	'system_info'          => false,
	//'compiler'             => true,
	'hints'                => array(
		'icon'          => 'el el-question-sign',
		'icon_position' => 'right',
		'icon_color'    => 'lightgray',
		'icon_size'     => 'normal',
		'tip_style'     => array(
			'color'   => 'red',
			'shadow'  => true,
			'rounded' => false,
			'style'   => '',
		),
		'tip_position'  => array(
			'my' => 'top left',
			'at' => 'bottom right',
		),
		'tip_effect'    => array(
			'show' => array(
				'effect'   => 'slide',
				'duration' => '500',
				'event'    => 'mouseover',
			),
			'hide' => array(
				'effect'   => 'slide',
				'duration' => '500',
				'event'    => 'click mouseleave',
			),
		),
	)
);

$args['share_icons'][] = array(
	'url'   => 'http://twitter.com/soaptheme',
	'title' => 'Follow us on Twitter',
	'icon'  => 'el el-twitter'
);

$args['intro_text'] = '';
$args['footer_text'] = '&copy; 2015 CityTours';

Redux::setArgs( $opt_name, $args );

$tabs = array(
	array(
		'id'      => 'redux-help-tab-1',
		'title'   => __( 'Theme Information', 'citytours' ),
		'content' => __( '<p>If you have any question please check documentation <a href="http://soaptheme.net/document/citytours-wp/">Documentation</a>. And that are beyond the scope of documentation, please feel free to contact us.</p>', 'citytours' )
	),
);
Redux::setHelpTab( $opt_name, $tabs );

// Set the help sidebar
$content = __( '<p></p>', 'citytours' );
Redux::setHelpSidebar( $opt_name, $content );

Redux::setSection( $opt_name, array(
	'title' => __( 'Basic Settings', 'citytours' ),
	'id'    => 'basic-settings',
	'icon'  => 'el el-home',
	'fields'     => array(
		array(
			'id'       => 'copyright',
			'type'     => 'text',
			'title'    => __( 'Copyright Text', 'citytours' ),
			'subtitle' => __( 'Set copyright text in footer', 'citytours' ),
			'default'  => 'Citytours 2015',
		),
		array(
			'id'       => 'email',
			'type'     => 'text',
			'title'    => __('E-Mail Address', 'citytours'),
			'subtitle' => __( 'Set email address', 'citytours' ),
			'default'  => '',
			'validate' => 'email'
		),
		array(
			'id'       => 'phone_no',
			'type'     => 'text',
			'title'    => __('Phone Number', 'citytours'),
			'subtitle' => __( 'Set phone number', 'citytours' ),
			'desc' => __('Leave blank to hide phone number field', 'citytours'),
			'default'  => '',
		),
		array(
			'id'       => 'modal_login',
			'type'     => 'switch',
			'title'    => __('Modal Login/Sign Up', 'citytours'),
			'subtitle' => __('Enable modal login and modal signup.', 'citytours'),
			'default'  => true,
		),/*
		array(
			'id'       => 'sticky_menu',
			'type'     => 'switch',
			'title'    => __( 'Sticky Menu', 'citytours' ),
			'subtitle' => __( 'Enable Sticky Menu', 'citytours' ),
			'default'  => true,
		),*/
		array(
			'id'       => 'preload',
			'type'     => 'switch',
			'title'    => __( 'Page Preloader', 'citytours' ),
			'subtitle' => __( 'Enable Page Preloader', 'citytours' ),
			'default'  => true,
		),
	)
) );

Redux::setSection( $opt_name, array(
	'title' => __( 'Styling Options', 'citytours' ),
	'id'    => 'styling-settings',
	'icon'  => 'el el-brush'
) );


Redux::setSection( $opt_name, array(
	'title'      => __( 'Logo & Favicon', 'citytours' ),
	'id'         => 'logo-settings',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'favicon',
			'type'     => 'media',
			'url'      => true,
			'title'    => __( 'Favicon', 'citytours' ),
			'desc'     => '',
			'subtitle' => __( 'Set a 16x16 ico image for your favicon', 'citytours' ),
			'default'  => array( 'url' => CT_IMAGE_URL . "/favicon.ico" ),
		),
		array(
			'id'       => 'logo',
			'type'     => 'media',
			'url'      => true,
			'title'    => __( 'Logo Image', 'citytours' ),
			'desc'     => '',
			'subtitle' => __( 'Set an image file for your logo', 'citytours' ),
			'default'  => array( 'url' => CT_IMAGE_URL . "/logo.png" ),
		),
		array(
			'id'       => 'logo_sticky',
			'type'     => 'media',
			'url'      => true,
			'title'    => __( 'Logo Image In Sticky Menu Bar', 'citytours' ),
			'desc'     => '',
			'subtitle' => __( 'Set an image file for your sticky logo', 'citytours' ),
			'default'  => array( 'url' => CT_IMAGE_URL . "/logo_sticky.png" ),
		),
		array(
			'id'             => 'logo_height_header',
			'type'           => 'dimensions',
			'units'          => 'px',    // You can specify a unit value. Possible: px, em, %
			'units_extended' => 'false',  // Allow users to select any type of unit
			'title'          => __( 'Header Logo Height', 'citytours' ),
			'subtitle'  => __( 'Set height of logo in header', 'citytours' ),
			'desc'           => __( 'Leave blank to use default value that supported by each header style', 'citytours' ),
			'width'         => false,
			'default'        => array()
		),
	)
) );

Redux::setSection( $opt_name, array(
	'title'      => __( 'Header Style & Skin', 'citytours' ),
	'id'         => 'hf-settings',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'header_style',
			'type'     => 'image_select',
			'title'    => __('Header Style', 'citytours'), 
			'subtitle' => __('Select header style', 'citytours'),
			'options'  => array(
				'transparent'      => array(
					'alt'   => 'transparent', 
					'img'   => CT_IMAGE_URL . '/admin/header/transparent.jpg'
				),
				'plain'      => array(
					'alt'   => 'plain', 
					'img'   => CT_IMAGE_URL . '/admin/header/plain.jpg'
				),
			),
			'default' => 'transparent'
		),
		array(
			'id'       => 'skin',
			'type'     => 'image_select',
			'title'    => __('Site Skin', 'citytours'), 
			'subtitle' => __('Select a Site Skin', 'citytours'),
			'options'  => array(
				'red'      => array(
					'alt'   => 'red',
					'title' => 'red',
					'img'   => CT_IMAGE_URL . '/admin/skin/red.jpg'
				),
				'aqua'      => array(
					'alt'   => 'aqua',
					'title' => 'aqua',
					'img'   => CT_IMAGE_URL . '/admin/skin/aqua.jpg'
				),
				'green'      => array(
					'alt'   => 'green',
					'title' => 'green',
					'img'   => CT_IMAGE_URL . '/admin/skin/green.jpg'
				),
				'orange'      => array(
					'alt'   => 'orange',
					'title' => 'orange',
					'img'   => CT_IMAGE_URL . '/admin/skin/orange.jpg'
				),
			),
			'default' => 'red'
		),
		array(
			'id'       => 'header_img',
			'type'     => 'media',
			'url'      => true,
			'title'    => __( 'Default Header Image', 'citytours' ),
			'desc'     => '',
			'subtitle' => __( 'Set a default image file for your header.', 'citytours' ),
			'desc'           => __( 'You can override this setting by using Header Image Settings metabox in post edit panel.', 'citytours' ),
			'default'  => array( 'url' => CT_IMAGE_URL . "/header-img.jpg" ),
		),
		array(
			'id'             => 'header_img_height',
			'type'           => 'dimensions',
			'units'          => 'px',    // You can specify a unit value. Possible: px, em, %
			'units_extended' => 'false',  // Allow users to select any type of unit
			'title'          => __( 'Default Header Image Height', 'citytours' ),
			'subtitle'  => __( 'Set default height of header image', 'citytours' ),
			'desc'           => __( 'You can override this setting by using Header Image Settings metabox in post edit panel.', 'citytours' ),
			'width'         => false,
			'default'        => array( 'height' => '500')
		),
	)
) );

Redux::setSection( $opt_name, array(
	'title'      => __( 'Layouts', 'citytours' ),
	'id'         => 'layouts',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'def_post_layout',
			'type'     => 'image_select',
			'title'    => __('Default Single Post Layout', 'citytours'), 
			'subtitle' => __('Select Default Single Post Layout', 'citytours'),
			'options'  => array(
				'left'      => array(
					'alt'   => 'left-sidbar', 
					'img'   => ReduxFramework::$_url.'assets/img/2cl.png'
				),
				'right'      => array(
					'alt'   => 'right-sidbar', 
					'img'   => ReduxFramework::$_url.'assets/img/2cr.png'
				),
				'no'      => array(
					'alt'   => 'no-sidbar', 
					'img'   => ReduxFramework::$_url.'assets/img/1col.png'
				),
			),
			'default' => 'left'
		),
		array(
			'id'       => 'def_page_layout',
			'type'     => 'image_select',
			'title'    => __('Default Single Page Layout', 'citytours'), 
			'subtitle' => __('Select Default Single Page Layout', 'citytours'),
			'options'  => array(
				'left'      => array(
					'alt'   => 'left-sidbar', 
					'img'   => ReduxFramework::$_url.'assets/img/2cl.png'
				),
				'right'      => array(
					'alt'   => 'right-sidbar', 
					'img'   => ReduxFramework::$_url.'assets/img/2cr.png'
				),
				'no'      => array(
					'alt'   => 'no-sidbar', 
					'img'   => ReduxFramework::$_url.'assets/img/1col.png'
				),
			),
			'default' => 'left'
		),
	)
) );
Redux::setSection( $opt_name, array(
	'title'      => __( 'Social Links', 'citytours' ),
	'id'         => 'social-settings',
	'subsection' => true,
	'fields'     => array(
		array(
			'title' => __('Facebook', 'citytours'),
			'desc' => __( 'Insert your custom link to show the Facebook icon. Leave blank to hide icon.', 'citytours' ),
			'id' => 'facebook',
			'type' => 'text'),
		array(
			'title' => __('Twitter', 'citytours'),
			'desc' => __( 'Insert your custom link to show the Twitter icon. Leave blank to hide icon.', 'citytours' ),
			'id' => 'twitter',
			'type' => 'text'),
		array(
			'title' => __('Google+', 'citytours'),
			'desc' => __( 'Insert your custom link to show the Google+ icon. Leave blank to hide icon.', 'citytours' ),
			'id' => 'google',
			'type' => 'text'),
		array(
			'title' => __('Instagram', 'citytours'),
			'desc' => __( 'Insert your custom link to show the Instagram icon. Leave blank to hide icon.', 'citytours' ),
			'id' => 'instagram',
			'type' => 'text'),
		array(
			'title' => __('Pinterest', 'citytours'),
			'desc' => __( 'Insert your custom link to show the Pinterest icon. Leave blank to hide icon.', 'citytours' ),
			'id' => 'pinterest',
			'type' => 'text'),
		array(
			'title' => __('Vimeo', 'citytours'),
			'desc' => __( 'Insert your custom link to show the Vimeo icon. Leave blank to hide icon.', 'citytours' ),
			'id' => 'vimeo',
			'type' => 'text'),
		array(
			'title' => __('YouTube', 'citytours'),
			'desc' => __( 'Insert your custom link to show the YouTube icon. Leave blank to hide icon.', 'citytours' ),
			'id' => 'youtube-play',
			'type' => 'text'),
		array(
			'title' => __('LinkedIn', 'citytours'),
			'desc' => __( 'Insert your custom link to show the LinkedIn icon. Leave blank to hide icon.', 'citytours' ),
			'id' => 'linkedin',
			'type' => 'text'),
	)
) );

Redux::setSection( $opt_name, array(
	'title'      => __( 'Custom JS & CSS', 'citytours' ),
	'id'         => 'custom-code',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'custom_css',
			'type'     => 'ace_editor',
			'title'    => __( 'Custom CSS Code', 'citytours' ),
			'subtitle' => __( 'Paste your CSS code here.', 'citytours' ),
			'mode'     => 'css',
			'theme'    => 'chrome',
			'default'  => ""
		),
		array(
			'id'       => 'custom_js',
			'type'     => 'ace_editor',
			'title'    => __( 'Custom Javascript Code', 'citytours' ),
			'subtitle' => __( 'Paste your Javascript code here.', 'citytours' ),
			'mode'     => 'javascript',
			'theme'    => 'chrome',
			'default'  => ""
		),
	)
) );

Redux::setSection( $opt_name, array(
	'title'      => __( 'Page/Post Settings', 'citytours' ),
	'id'         => 'main-page-settings',
	'fields'     => array(
		array(
			'id'       => 'login_page',
			'type'     => 'select',
			'title'    => __('Login Page', 'citytours'),
			'subtitle' => __('You can leave this field blank if you don\'t need Custom Login Page', 'citytours'),
			'desc'     => __('If you set wrong page you should be unable to login. In that case you can login with /wp-login.php?no_redirect=1', 'citytours'),
			'options'  => $options_pages,
			'default'  => ''
		),
		array(
			'id'       => 'redirect_page',
			'type'     => 'select',
			'title'    => __('Page to Redirect to on login', 'citytours'),
			'subtitle' => __('Select a Page to Redirect to on login.', 'citytours'),
			'options'  => $options_pages,
			'default'  => ''
		),
		array(
			'id'       => '404_page',
			'type'     => 'select',
			'title'    => __('404 Page', 'citytours'),
			'subtitle' => __('You can leave this field blank if you don\'t need Custom 404 Page', 'citytours'),
			'options'  => $options_pages,
			'default'  => ''
		),
	)
));

Redux::setSection( $opt_name, array(
	'title'      => __( 'Blog Settings', 'citytours' ),
	'id'         => 'blog-settings',
	'fields'     => array(
		array(
			'id'       => 'blog_header_img',
			'type'     => 'media',
			'url'      => true,
			'title'    => __( 'Blog Header Image', 'citytours' ),
			'desc'     => '',
			'subtitle' => __( 'Set a image file for your blog page header.', 'citytours' ),
			'default'  => array( 'url' => CT_IMAGE_URL . "/header-img.jpg" ),
		),
		array(
			'id'             => 'blog_header_img_height',
			'type'           => 'dimensions',
			'units'          => 'px',    // You can specify a unit value. Possible: px, em, %
			'units_extended' => 'false',  // Allow users to select any type of unit
			'title'          => __( 'Blog Header Image Height', 'citytours' ),
			'subtitle'  => __( 'Set height of blog page header image', 'citytours' ),
			'width'         => false,
			'default'        => array( 'height' => '500')
		),
		array(
			'id' => 'blog_header_content',
			'title' => __('Blog Page Header Content', 'citytours'),
			'subtitle' => __( 'Set blog page header content.', 'citytours' ),
			'type' => 'editor'
		),
		array(
			'id'       => 'blog_page_layout',
			'type'     => 'image_select',
			'title'    => __('Blog Page Layout', 'citytours'), 
			'subtitle' => __('Select Blog Page Layout', 'citytours'),
			'options'  => array(
				'left'      => array(
					'alt'   => 'left-sidbar', 
					'img'   => ReduxFramework::$_url.'assets/img/2cl.png'
				),
				'right'      => array(
					'alt'   => 'right-sidbar', 
					'img'   => ReduxFramework::$_url.'assets/img/2cr.png'
				),
				'no'      => array(
					'alt'   => 'no-sidbar', 
					'img'   => ReduxFramework::$_url.'assets/img/1col.png'
				),
			),
			'default' => 'left'
		),
	)
) );

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'ct-booking/ct-booking.php' ) ) :

Redux::setSection( $opt_name, array(
	'title' => __( 'Booking Settings', 'citytours' ),
	'id'    => 'booking-settings',
	'fields'     => array(
		array(
			'id'       => 'date_format',
			'type'     => 'select',
			'title'    => __('Date Format', 'citytours'),
			'subtitle' => __('Please select a date format for datepicker.', 'citytours'),
			'options'  => array(
							'mm/dd/yyyy' => 'mm/dd/yyyy',
							'dd/mm/yyyy' => 'dd/mm/yyyy',
							'yyyy-mm-dd' => 'yyyy-mm-dd',
						  ),
			'default'  => 'mm/dd/yyyy'
		),
		array(
			'id'       => 'wishlist',
			'type'     => 'select',
			'title'    => __('Wishlist Page', 'citytours'),
			'subtitle' => __('Please create a blank page and set it.', 'citytours'),
			'desc'     => '',
			'options'  => $options_pages,
			'default'  => ''
		),
	)
) );

$desc = __('All price fields in admin panel will be considered in this currency', 'citytours');
require_once CT_INC_DIR . '/functions/currency.php';
Redux::setSection( $opt_name, array(
	'title'      => __( 'Currency Settings', 'citytours' ),
	'id'         => 'currency-settings',
	'icon'  => 'el el-usd',
	'fields'     => array(
		array(
			'id'       => 'def_currency',
			'type'     => 'select',
			'title'    => __( 'Default Currency', 'citytours' ),
			'subtitle' => __( 'Select default currency', 'citytours' ),
			'desc'     => apply_filters( 'ct_options_def_currency_desc', $desc ),
			//Must provide key => value pairs for select options
			'options'  => ct_get_all_available_currencies(),
			'default'  => 'usd'
		),
		array(
			'id'       => 'site_currencies',
			'type'     => 'checkbox',
			'title'    => __('Available Currencies', 'citytours'),
			'subtitle' => __('You can select currencies that this site support. You can manage currency list <a href="admin.php?page=currencies">here</a>', 'citytours'),
			'desc'     => '',
			'options'  => ct_get_all_available_currencies(),
			'default'  => ct_get_default_available_currencies()
		),
		array(
			'id'       => 'cs_pos',
			'type'     => 'button_set',
			'title'    => __( 'Currency Symbol Position', 'citytours' ),
			'subtitle' => __( "Select a Curency Symbol Position for Frontend", 'citytours' ),
			'desc'     => '',
			'options'  => array(
				'left' => __( 'Left ($99.99)', 'citytours' ),
				'right' => __( 'Right (99.99$)', 'citytours' ),
				'left_space' => __( 'Left with space ($ 99.99)', 'citytours' ),
				'right_space' => __( 'Right with space (99.99 $)', 'citytours' )
			),
			'default'  => 'before'
		),
		array(
			'id'       => 'decimal_prec',
			'type'     => 'select',
			'title'    => __( 'Decimal Precision', 'citytours' ),
			'subtitle' => __( 'Please choose desimal precision', 'citytours' ),
			'desc'     => '',
			'options'  => array(
							'0' => '0',
							'1' => '1',
							'2' => '2',
							'3' => '3',
							),
			'default'  => '2'
		),
		array(
			'id'       => 'thousands_sep',
			'type'     => 'text',
			'title'    => __( 'Thousand Separate', 'citytours' ),
			'subtitle' => __( 'This sets the thousand separator of displayed prices.', 'citytours' ),
			'default'  => ',',
		),
		array(
			'id'       => 'decimal_sep',
			'type'     => 'text',
			'title'    => __( 'Decimal Separate', 'citytours' ),
			'subtitle' => __( 'This sets the decimal separator of displayed prices.', 'citytours' ),
			'default'  => '.',
		),
	)
) );

Redux::setSection( $opt_name, array(
	'title' => __( 'Hotel', 'citytours' ),
	'id'    => 'hotel-settings',
) );

Redux::setSection( $opt_name, array(
	'title'      => __( 'Hotel Main Settings', 'citytours' ),
	'id'         => 'hotel-main-settings',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'disable_hotel',
			'type'     => 'button_set',
			'title'    => __('Enable/Disable hotel feature.', 'citytours'),
			'default'  => 0,
			'options'  => array(
				'0' => __( 'Enable', 'citytours' ),
				'1' => __( 'Disable', 'citytours' )
			),
		),
		array(
			'id'       => 'hotel_cart_page',
			'type'     => 'select',
			'required' => array( 'disable_hotel', '=', '0' ),
			'title'    => __('Hotel Cart Page', 'citytours'),
			'subtitle' => __('This sets the base page of your hotel booking. Please add [hotel_cart] shortcode in the page content.', 'citytours'),
			'options'  => $options_pages,
		),
		array(
			'id'       => 'hotel_checkout_page',
			'type'     => 'select',
			'required' => array( 'disable_hotel', '=', '0' ),
			'title'    => __('Hotel Checkout Page', 'citytours'),
			'subtitle' => __('This sets the hotel Checkout Page. Please add [hotel_checkout] shortcode in the page content.', 'citytours'),
			'options'  => $options_pages,
		),
		array(
			'id'       => 'hotel_thankyou_page',
			'type'     => 'select',
			'required' => array( 'disable_hotel', '=', '0' ),
			'title'    => __('Hotel Booking Confirmation Page', 'citytours'),
			'subtitle' => __('This sets the hotel booking confirmation Page. Please add [hotel_booking_confirmation] shortcode in the page content.', 'citytours'),
			'options'  => $options_pages,
		),
		array(
			'id'       => 'hotel_thankyou_text_1',
			'type'     => 'text',
			'required' => array( 'disable_hotel', '=', '0' ),
			'title'    => __('Hotel Booking Confirmation Text 1', 'citytours'),
			'subtitle' => __('This sets confirmation text1.', 'citytours'),
			'default'  => 'Lorem ipsum dolor sit amet, nostrud nominati vis ex, essent conceptam eam ad. Cu etiam comprehensam nec. Cibo delicata mei an, eum porro legere no. Te usu decore omnium, quem brute vis at, ius esse officiis legendos cu. Dicunt voluptatum at cum. Vel et facete equidem deterruisset, mei graeco cetero labores et. Accusamus inciderint eu mea.',
		),
		array(
			'id'       => 'hotel_thankyou_text_2',
			'type'     => 'text',
			'required' => array( 'disable_hotel', '=', '0' ),
			'title'    => __('Hotel Booking Confirmation Text 2', 'citytours'),
			'subtitle' => __('This sets confirmation text2.', 'citytours'),
			'default'  => 'Nihil inimicus ex nam, in ipsum dignissim duo. Tale principes interpretaris vim ei, has posidonium definitiones ut. Duis harum fuisset ut his, duo an dolor epicuri appareat.',
		),
		array(
			'id'       => 'hotel_invoice_page',
			'type'     => 'select',
			'required' => array( 'disable_hotel', '=', '0' ),
			'title'    => __('Invoice Page', 'citytours'),
			'subtitle' => __('You can create a blank page for invoice page. After that please set the page here.', 'citytours'),
			'options'  => $options_pages,
		),
		array(
			'id'       => 'hotel_terms_page',
			'type'     => 'select',
			'required' => array( 'disable_hotel', '=', '0' ),
			'title'    => __('Terms & Conditions Page', 'citytours'),
			'subtitle' => __('Booking Terms and Conditions Page.', 'citytours'),
			'options'  => $options_pages,
		),
		array(
			'id'       => 'hotel_review',
			'type'     => 'switch',
			'required' => array( 'disable_hotel', '=', '0' ),
			'title'    => __('Hotel Review On/Off', 'citytours'),
			'default'  => true,
		),
		array(
			'id'       => 'hotel_review_fields',
			'type'     => 'text',
			'required' => array( 'disable_hotel', '=', '0' ),
			'title'    => __('Hotel Review Fields', 'citytours'),
			'subtitle'    => __('Set review fields separated by comma.', 'citytours'),
			'default'  => 'Position,Comfort,Price,Quality',
		),

	),
) );

Redux::setSection( $opt_name, array(
	'title'      => __( 'Hotel List Page Settings', 'citytours' ),
	'id'         => 'hotel-list-settings',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'hotel_header_img',
			'type'     => 'media',
			'url'      => true,
			'title'    => __( 'Header Image', 'citytours' ),
			'desc'     => '',
			'subtitle' => __( 'Set a image file for your hotel list page header.', 'citytours' ),
			'default'  => array( 'url' => CT_IMAGE_URL . "/header-img.jpg" ),
		),
		array(
			'id'             => 'hotel_header_img_height',
			'type'           => 'dimensions',
			'units'          => 'px',    // You can specify a unit value. Possible: px, em, %
			'units_extended' => 'false',  // Allow users to select any type of unit
			'title'          => __( 'Header Image Height', 'citytours' ),
			'subtitle'  => __( 'Set height of hotel list page header image', 'citytours' ),
			'width'         => false,
			'default'        => array( 'height' => '500')
		),
		array(
			'id' => 'hotel_header_content',
			'title' => __( 'Page Header Content', 'citytours' ),
			'subtitle' => __( 'Set hotel list page header content.', 'citytours' ),
			'type' => 'editor'
		),
		array(
			'title' => __('Enable Star Rating Filter', 'citytours'),
			'subtitle' => __('Add star rating filter to hotel list page.', 'citytours'),
			'id' => 'hotel_star_filter',
			'default' => true,
			'type' => 'switch'),
		array(
			'title' => __('Enable Price Filter', 'citytours'),
			'subtitle' => __('Add price filter to hotel list page.', 'citytours'),
			'id' => 'hotel_price_filter',
			'default' => true,
			'type' => 'switch'),
		array(
			'id'       => 'hotel_price_filter_steps',
			'required' => array( 'hotel_price_filter', '=', true ),
			'type'     => 'text',
			'title'    => __( 'Price Filter Steps', 'citytours' ),
			'subtitle' => __( 'This field is for price filter steps. For example you can set 50,80,100 to make 4 steps - 0~50, 50~80, 80~100, 100+.', 'citytours' ),
			'default'  => '50,80,100',
		),
		array(
			'title' => __('Enable Review Rating Filter', 'citytours'),
			'subtitle' => __('Add review rating filter to hotel list page.', 'citytours'),
			'id' => 'hotel_rating_filter',
			'default' => true,
			'type' => 'switch'),
		array(
			'title' => __('Enable Facility Filter', 'citytours'),
			'subtitle' => __('Add facility filter to hotel list page.', 'citytours'),
			'id' => 'hotel_facility_filter',
			'default' => true,
			'type' => 'switch'),
		array(
			'title' => __('Enable District Filter', 'citytours'),
			'subtitle' => __('Add district filter to hotel list page.', 'citytours'),
			'id' => 'hotel_district_filter',
			'default' => true,
			'type' => 'switch'),
		array(
			'id'       => 'hotel_posts',
			'type'     => 'text',
			'title'    => __( 'Hotels per page', 'citytours' ),
			'subtitle' => __( 'Select a number of hotels to show on Hotel List Page', 'citytours' ),
			'default'  => '12',
		),
	),
) );

// add-on compatibility
$hotel_add_on_settings = apply_filters( 'ct_options_hotel_addon_settings', array() );
if ( ! empty( $hotel_add_on_settings ) ) {
	Redux::setSection( $opt_name, array(
		'title'      => __( 'Hotel Add-On Settings', 'citytours' ),
		'id'         => 'hotel-add-settings',
		'subsection' => true,
		'fields'     => array( $hotel_add_on_settings )
	) );
}

Redux::setSection( $opt_name, array(
	'title'      => __( 'Hotel Email Settings', 'citytours' ),
	'id'         => 'hotel-email-settings',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'hotel_confirm_email_start',
			'type'     => 'section',
			'title'    => __( 'Customer Email Setting', 'citytours' ),
			// 'subtitle' => __( '', 'citytours' ),
			'indent'   => true,
		),
		/*array(
			'title' => __('Enable Icalendar', 'citytours'),
			'subtitle' => __('Send icalendar with booking confirmation email.', 'citytours'),
			'id' => 'hotel_confirm_email_ical',
			'default' => true,
			'type' => 'switch'),*/
		array(
			'title' => __('Booking Confirmation Email Subject', 'citytours'),
			'subtitle' => __( 'Hotel booking confirmation email subject.', 'citytours' ),
			'id' => 'hotel_confirm_email_subject',
			'default' => 'Your booking at [hotel_name]',
			'type' => 'text'),
		array(
			'title' => __('Booking Confirmation Email Description', 'citytours'),
			'subtitle' => __( 'Hotel booking confirmation email description.', 'citytours' ),
			'id' => 'hotel_confirm_email_description',
			'default' => file_get_contents( dirname( __FILE__ ) . '/templates/hotel_confirm_email_description.htm' ),
			'type' => 'editor'),
		array(
			'id'     => 'hotel_confirm_email_end',
			'type'   => 'section',
			'indent' => false,
		),
		array(
			'id'       => 'hotel_admin_email_start',
			'type'     => 'section',
			'title'    => __( 'Admin Notification Setting', 'citytours' ),
			// 'subtitle' => __( '', 'citytours' ),
			'indent'   => true,
		),
		array(
			'title' => __('Administrator Notification', 'citytours'),
			'subtitle' => __('enable individual booked email notification to site administrator.', 'citytours'),
			'id' => 'hotel_booked_notify_admin',
			'default' => 'true',
			'type' => 'switch'),
		array(
			'title' => __('Administrator Booking Notification Email Subject', 'citytours'),
			'subtitle' => __( 'Administrator Notification Email Subject for Hotel Booking.', 'citytours' ),
			'id' => 'hotel_admin_email_subject',
			'default' => 'Received a booking at [hotel_name]',
			'required' => array( 'hotel_booked_notify_admin', '=', '1' ),
			'type' => 'text'),
		array(
			'title' => __('Administrator Booking Notification Email Description', 'citytours'),
			'subtitle' => __( 'Administrator Notification Email Description for Hotel Booking.', 'citytours' ),
			'id' => 'hotel_admin_email_description',
			'default' => file_get_contents( dirname( __FILE__ ) . '/templates/hotel_admin_email_description.htm' ),
			'required' => array( 'hotel_booked_notify_admin', '=', '1' ),
			'type' => 'editor'),
		array(
			'id'     => 'hotel_admin_email_end',
			'type'   => 'section',
			'indent' => false,
		),
	),
) );


Redux::setSection( $opt_name, array(
	'title' => __( 'Tour', 'citytours' ),
	'id'    => 'tour-settings',
) );

Redux::setSection( $opt_name, array(
	'title'      => __( 'Tour Main Settings', 'citytours' ),
	'id'         => 'tour-main-settings',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'disable_tour',
			'type'     => 'button_set',
			'title'    => __('Enable/Disable tour feature.', 'citytours'),
			'default'  => 0,
			'options'  => array(
				'0' => __( 'Enable', 'citytours' ),
				'1' => __( 'Disable', 'citytours' )
			),
		),
		array(
			'id'       => 'tour_cart_page',
			'type'     => 'select',
			'required' => array( 'disable_tour', '=', '0' ),
			'title'    => __('Tour Cart Page', 'citytours'),
			'subtitle' => __('This sets the base page of your tour booking. Please add [tour_cart] shortcode in the page content.', 'citytours'),
			'options'  => $options_pages,
		),
		array(
			'id'       => 'tour_checkout_page',
			'type'     => 'select',
			'required' => array( 'disable_tour', '=', '0' ),
			'title'    => __('Tour Checkout Page', 'citytours'),
			'subtitle' => __('This sets the tour Checkout Page. Please add [tour_checkout] shortcode in the page content.', 'citytours'),
			'options'  => $options_pages,
		),
		array(
			'id'       => 'tour_thankyou_page',
			'type'     => 'select',
			'required' => array( 'disable_tour', '=', '0' ),
			'title'    => __('Tour Booking Confirmation Page', 'citytours'),
			'subtitle' => __('This sets the tour booking confirmation Page. Please add [tour_booking_confirmation] shortcode in the page content.', 'citytours'),
			'options'  => $options_pages,
		),

		array(
			'id'       => 'tour_thankyou_text_1',
			'type'     => 'text',
			'required' => array( 'disable_tour', '=', '0' ),
			'title'    => __('Tour Booking Confirmation Text 1', 'citytours'),
			'subtitle' => __('This sets confirmation text1.', 'citytours'),
			'default'  => 'Lorem ipsum dolor sit amet, nostrud nominati vis ex, essent conceptam eam ad. Cu etiam comprehensam nec. Cibo delicata mei an, eum porro legere no. Te usu decore omnium, quem brute vis at, ius esse officiis legendos cu. Dicunt voluptatum at cum. Vel et facete equidem deterruisset, mei graeco cetero labores et. Accusamus inciderint eu mea.',
		),
		array(
			'id'       => 'tour_thankyou_text_2',
			'type'     => 'text',
			'required' => array( 'disable_tour', '=', '0' ),
			'title'    => __('Tour Booking Confirmation Text 2', 'citytours'),
			'subtitle' => __('This sets confirmation text2.', 'citytours'),
			'default'  => 'Nihil inimicus ex nam, in ipsum dignissim duo. Tale principes interpretaris vim ei, has posidonium definitiones ut. Duis harum fuisset ut his, duo an dolor epicuri appareat.',
		),
		array(
			'id'       => 'tour_invoice_page',
			'type'     => 'select',
			'required' => array( 'disable_tour', '=', '0' ),
			'title'    => __('Invoice Page', 'citytours'),
			'subtitle' => __('You can create a blank page for invoice page. After that please set the page here.', 'citytours'),
			'options'  => $options_pages,
		),
		array(
			'id'       => 'tour_terms_page',
			'type'     => 'select',
			'required' => array( 'disable_tour', '=', '0' ),
			'title'    => __('Terms & Conditions Page', 'citytours'),
			'subtitle' => __('Booking Terms and Conditions Page.', 'citytours'),
			'options'  => $options_pages,
		),
		array(
			'id'       => 'tour_review',
			'type'     => 'switch',
			'required' => array( 'disable_tour', '=', '0' ),
			'title'    => __('Tour Review On/Off', 'citytours'),
			'default'  => true,
		),
		array(
			'id'       => 'tour_review_fields',
			'type'     => 'text',
			'required' => array( 'disable_tour', '=', '0' ),
			'title'    => __('Tour Review Fields', 'citytours'),
			'subtitle'    => __('Set review fields separated by comma.', 'citytours'),
			'default'  => 'Position,Tourist guide,Price,Quality',
		),
		),
) );

Redux::setSection( $opt_name, array(
	'title'      => __( 'Tour List Page Settings', 'citytours' ),
	'id'         => 'tour-list-settings',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'tour_header_img',
			'type'     => 'media',
			'url'      => true,
			'title'    => __( 'Header Image', 'citytours' ),
			'desc'     => '',
			'subtitle' => __( 'Set a image file for your tour list page header.', 'citytours' ),
			'default'  => array( 'url' => CT_IMAGE_URL . "/header-img.jpg" ),
		),
		array(
			'id'             => 'tour_header_img_height',
			'type'           => 'dimensions',
			'units'          => 'px',    // You can specify a unit value. Possible: px, em, %
			'units_extended' => 'false',  // Allow users to select any type of unit
			'title'          => __( 'Header Image Height', 'citytours' ),
			'subtitle'  => __( 'Set height of tour list page header image', 'citytours' ),
			'width'         => false,
			'default'        => array( 'height' => '500')
		),
		array(
			'id' => 'tour_header_content',
			'title' => __( 'Page Header Content', 'citytours' ),
			'subtitle' => __( 'Set tour list page header content.', 'citytours' ),
			'type' => 'editor'
		),
		array(
			'title' => __('Enable Price Filter', 'citytours'),
			'subtitle' => __('Add price filter to tour list page.', 'citytours'),
			'id' => 'tour_price_filter',
			'default' => true,
			'type' => 'switch'),
		array(
			'id'       => 'tour_price_filter_steps',
			'required' => array( 'tour_price_filter', '=', true ),
			'type'     => 'text',
			'title'    => __( 'Price Filter Steps', 'citytours' ),
			'subtitle' => __( 'This field is for price filter steps. For example you can set 50,80,100 to make 4 steps - 0~50, 50~80, 80~100, 100+.', 'citytours' ),
			'default'  => '50,80,100',
		),
		array(
			'title' => __('Enable Rating Filter', 'citytours'),
			'subtitle' => __('Add rating filter to tour list page.', 'citytours'),
			'id' => 'tour_rating_filter',
			'default' => true,
			'type' => 'switch'),
		array(
			'title' => __('Enable Facility Filter', 'citytours'),
			'subtitle' => __('Add facility filter to tour list page.', 'citytours'),
			'id' => 'tour_facility_filter',
			'default' => true,
			'type' => 'switch'),
		array(
			'id'       => 'tour_posts',
			'type'     => 'text',
			'title'    => __( 'Tours per page', 'citytours' ),
			'subtitle' => __( 'Select a number of tours to show on Tour List Page', 'citytours' ),
			'default'  => '12',
		),
	),
) );

Redux::setSection( $opt_name, array(
	'title'      => __( 'Tour Email Settings', 'citytours' ),
	'id'         => 'tour-email-settings',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'tour_confirm_email_start',
			'type'     => 'section',
			'title'    => __( 'Customer Email Setting', 'citytours' ),
			// 'subtitle' => __( '', 'citytours' ),
			'indent'   => true,
		),
		array(
			'title' => __('Booking Confirmation Email Subject', 'citytours'),
			'subtitle' => __( 'Tour booking confirmation email subject.', 'citytours' ),
			'id' => 'tour_confirm_email_subject',
			'default' => 'Your booking at [tour_name]',
			'type' => 'text'),
		array(
			'title' => __('Booking Confirmation Email Description', 'citytours'),
			'subtitle' => __( 'Tour booking confirmation email description.', 'citytours' ),
			'id' => 'tour_confirm_email_description',
			'default' => file_get_contents( dirname( __FILE__ ) . '/templates/tour_confirm_email_description.htm' ),
			'type' => 'editor'),
		array(
			'id'     => 'tour_confirm_email_end',
			'type'   => 'section',
			'indent' => false,
		),
		array(
			'id'       => 'tour_admin_email_start',
			'type'     => 'section',
			'title'    => __( 'Admin Notification Setting', 'citytours' ),
			// 'subtitle' => __( '', 'citytours' ),
			'indent'   => true,
		),
		array(
			'title' => __('Administrator Notification', 'citytours'),
			'subtitle' => __('enable individual booked email notification to site administrator.', 'citytours'),
			'id' => 'tour_booked_notify_admin',
			'default' => 'true',
			'type' => 'switch'),
		array(
			'title' => __('Administrator Booking Notification Email Subject', 'citytours'),
			'subtitle' => __( 'Administrator Notification Email Subject for Tour Booking.', 'citytours' ),
			'id' => 'tour_admin_email_subject',
			'default' => 'Received a booking at [tour_name]',
			'required' => array( 'tour_booked_notify_admin', '=', '1' ),
			'type' => 'text'),
		array(
			'title' => __('Administrator Booking Notification Email Description', 'citytours'),
			'subtitle' => __( 'Administrator Notification Email Description for Tour Booking.', 'citytours' ),
			'id' => 'tour_admin_email_description',
			'default' => file_get_contents( dirname( __FILE__ ) . '/templates/tour_admin_email_description.htm' ),
			'required' => array( 'tour_booked_notify_admin', '=', '1' ),
			'type' => 'editor'),
		array(
			'id'     => 'tour_admin_email_end',
			'type'   => 'section',
			'indent' => false,
		),
	),
) );

// add-on compatibility
$tour_add_on_settings = apply_filters( 'ct_options_tour_addon_settings', array() );
if ( ! empty( $tour_add_on_settings ) ) {
	Redux::setSection( $opt_name, array(
		'title'      => __( 'Tour Add-On Settings', 'citytours' ),
		'id'         => 'tour-add-settings',
		'subsection' => true,
		'fields'     => array( $tour_add_on_settings )
	) );
}

Redux::setSection( $opt_name, array(
	'title' => __( 'Payment', 'citytours' ),
	'id'    => 'payment-settings',
) );
Redux::setSection( $opt_name, array(
	'title' => __( 'Paypal', 'citytours' ),
	'id'    => 'paypal-settings',
	'subsection' => true,
	'fields'     => array(
		array(
			'title' => __('PayPal Integration', 'citytours'),
			'subtitle' => __('Enable payment through PayPal in booking step.', 'citytours'),
			'id' => 'pay_paypal',
			'default' => false,
			'type' => 'switch'),

		array(
			'title' => __('Sandbox Mode', 'citytours'),
			'subtitle' => __('Enable PayPal sandbox for testing.', 'citytours'),
			'id' => 'paypal_sandbox',
			'default' => false,
			'required' => array( 'pay_paypal', '=', '1' ),
			'type' => 'switch'),

		array(
			'title' => __('PayPal API Username', 'citytours'),
			'subtitle' => __('Your PayPal Account API Username.', 'citytours'),
			'id' => 'paypal_api_username',
			'default' => '',
			'required' => array( 'pay_paypal', '=', '1' ),
			'type' => 'text'),

		array(
			'title' => __('PayPal API Password', 'citytours'),
			'subtitle' => __('Your PayPal Account API Password.', 'citytours'),
			'id' => 'paypal_api_password',
			'default' => '',
			'required' => array( 'pay_paypal', '=', '1' ),
			'type' => 'text'),

		array(
			'title' => __('PayPal API Signature', 'citytours'),
			'subtitle' => __('Your PayPal Account API Signature.', 'citytours'),
			'id' => 'paypal_api_signature',
			'default' => '',
			'required' => array( 'pay_paypal', '=', '1' ),
			'type' => 'text'),
	)
) );

endif;

// add-on compatibility
$payment_add_on_settings = apply_filters( 'ct_options_payment_addon_settings', array() );
if ( ! empty( $payment_add_on_settings ) ) {
	Redux::setSection( $opt_name, array(
		'title'      => __( 'Payment Add-On Settings', 'citytours' ),
		'id'         => 'payment-add-settings',
		'subsection' => true,
		'fields'     => $payment_add_on_settings
	) );
}

if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
	$section = array(
		'icon'   => 'el el-list-alt',
		'title'  => __( 'Documentation', 'citytours' ),
		'fields' => array(
			array(
				'id'       => '17',
				'type'     => 'raw',
				'markdown' => true,
				'content'  => file_get_contents( dirname( __FILE__ ) . '/../README.md' )
			),
		),
	);
	Redux::setSection( $opt_name, $section );
}