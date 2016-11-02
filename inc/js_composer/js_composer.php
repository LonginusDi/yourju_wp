<?php

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }
$extra_class = array(
	'type' => 'textfield',
	'heading' => esc_html__( 'Extra class name', 'citytours' ),
	'param_name' => 'class',
	'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'citytours' )
);
$content_area = array(
	"type" => "textarea_html",
	"heading" => esc_html__( "Content", 'citytours' ),
	"param_name" => "content",
	"description" => esc_html__( "Enter your content.", 'citytours' ),
	"admin_label" => true,
);
$hotel_districts = get_terms( 'district', array( 'hide_empty' => false ) );
$districts = array( esc_html__( "All", "ct" ) => "" );
if ( ! is_wp_error( $hotel_districts ) ) :
foreach ( $hotel_districts as $term ) {
	$districts[$term->name] = $term->term_id;
}
endif;

$tour_type_terms = get_terms( 'tour_type', array( 'hide_empty' => false ) );
$tour_types = array( esc_html__( "All", "ct" ) => "" );
if ( ! is_wp_error( $tour_type_terms ) ) :
foreach ( $tour_type_terms as $term ) {
	$tour_types[$term->name] = $term->term_id;
}
endif;


// ! Removing unwanted shortcodes
vc_remove_element("vc_widget_sidebar");
vc_remove_element("vc_wp_search");
vc_remove_element("vc_wp_meta");
vc_remove_element("vc_wp_recentcomments");
vc_remove_element("vc_wp_calendar");
vc_remove_element("vc_wp_pages");
vc_remove_element("vc_wp_tagcloud");
vc_remove_element("vc_wp_custommenu");
vc_remove_element("vc_wp_text");
vc_remove_element("vc_wp_posts");
vc_remove_element("vc_wp_links");
vc_remove_element("vc_wp_categories");
vc_remove_element("vc_wp_archives");
vc_remove_element("vc_wp_rss");
vc_remove_element("vc_gallery");
vc_remove_element("vc_teaser_grid");
// vc_remove_element("vc_btn");
vc_remove_element("vc_cta_button");
vc_remove_element("vc_posts_grid");
vc_remove_element("vc_images_carousel");
vc_remove_element("vc_posts_slider");
vc_remove_element("vc_carousel");
vc_remove_element("vc_message");
vc_remove_element("vc_progress_bar");
vc_remove_element("vc_tour");

vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => esc_html__("Is Container", 'citytours'),
	"param_name" => "is_container",
	"value" => array( esc_html__( 'yes', 'citytours' ) => 'yes' ),
	"description" => "This option will add container class to this row. Please check bootstrap container class for more detail.",
	"def" => ""
));

/* Blockquote Shortcode */
vc_map( array(
	"name" => esc_html__("Container", 'citytours'),
	"base" => "container",
	"icon" => "container",
	"class" => "",
	"category" => esc_html__('by SoapTheme', 'citytours'),
	"params" => array(
		$content_area,
		$extra_class
	),
	'js_view' => 'VcColumnView'
) );

/* Button */
vc_map( array(
	"name" => esc_html__("Button", 'citytours'),
	"base" => "button",
	"icon" => "button",
	"category" => esc_html__('by SoapTheme', 'citytours'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => esc_html__("Link", 'citytours'),
			"admin_label" => true,
			"param_name" => "link",
			"value" => "#"
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Button Size", 'citytours'),
			"admin_label" => true,
			"param_name" => "size",
			"value" => array(
				__( "Default", "ct" )=> "",
				__( "Medium", "ct" )=> "medium",
				__( "Full", "ct" )=> "full",
			),
			"std" => '',
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", 'citytours'),
			"admin_label" => true,
			"param_name" => "style",
			"value" => array(
				__( "Default", "ct" ) => "",
				__( "Outline", "ct" ) => "outline",
				__( "White", "ct" ) => "white",
				__( "Green", "ct" ) => "green",
			),
			"std" => '',
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Target", 'citytours'),
			"param_name" => "target",
			"value" => array(
				"_self" => "_self",
				"_blank" => "_blank",
				"_top" => "_top",
				"_parent" => "_parent"
			),
			"std" => '',
			"description" => ""
		),
		$content_area,
		$extra_class
	)
) );

/* Blockquote Shortcode */
vc_map( array(
	"name" => esc_html__("Blockquote", 'citytours'),
	"base" => "blockquote",
	"icon" => "blockquote",
	"class" => "",
	"category" => esc_html__('by SoapTheme', 'citytours'),
	"params" => array(
		$content_area,
		$extra_class
	)
) );

/* Banner Shortcode */
vc_map( array(
	"name" => esc_html__("Banner", 'citytours'),
	"base" => "banner",
	"icon" => "banner",
	"class" => "",
	"category" => esc_html__('by SoapTheme', 'citytours'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", 'citytours'),
			"admin_label" => true,
			"param_name" => "style",
			"value" => array(
				__( "Default", "ct" ) => "",
				__( "Colored", "ct" ) => "colored",
			),
			"std" => '',
			"description" => ""
		),
		$content_area,
		$extra_class
	)
) );

/* CheckList Shortcode */
vc_map( array(
	"name" => esc_html__("Checklist", 'citytours'),
	"base" => "checklist",
	"icon" => "checklist",
	"class" => "",
	"category" => esc_html__('by SoapTheme', 'citytours'),
	"params" => array(
		$content_area,
		$extra_class
	)
) );

/* Icon Box Shortcode */
vc_map( array(
	"name" => esc_html__("Icon Box", 'citytours'),
	"base" => "icon_box",
	"icon" => "icon_box",
	"class" => "",
	"category" => esc_html__('by SoapTheme', 'citytours'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", 'citytours'),
			"admin_label" => true,
			"param_name" => "style",
			"value" => array(
				__( "Default", "ct" ) => "",
				__( "Style2", "ct" ) => "style2",
				__( "Style3", "ct" ) => "style3",
			),
			"std" => '',
			"description" => ""
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Icon Class', 'citytours' ),
			'param_name' => 'icon_class',
			'admin_label' => true
		),
		$content_area,
		$extra_class
	)
) );

/* Icon List Shortcode */
vc_map( array(
	"name" => esc_html__("Icon List", 'citytours'),
	"base" => "icon_list",
	"icon" => "icon_list",
	"class" => "",
	"category" => esc_html__('by SoapTheme', 'citytours'),
	"params" => array(
		$content_area,
		$extra_class
	)
) );

/* Tooltip Shortcode */
vc_map( array(
	"name" => esc_html__("Tooltip", 'citytours'),
	"base" => "tooltip",
	"icon" => "tooltip",
	"class" => "",
	"category" => esc_html__('by SoapTheme', 'citytours'),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'citytours' ),
			'param_name' => 'title',
			'admin_label' => true
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", 'citytours'),
			"admin_label" => true,
			"param_name" => "style",
			"value" => array(
				__( "Simple", "ct" ) => "",
				__( "Advanced", "ct" ) => "advanced",
			),
			"std" => '',
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Tooltip Position", 'citytours'),
			"admin_label" => true,
			"param_name" => "position",
			"value" => array(
				__( "Top", "ct" ) => "top",
				__( "Bottom", "ct" ) => "bottom",
				__( "Left", "ct" ) => "left",
				__( "Right", "ct" ) => "right",
			),
			"std" => 'top',
			"description" => "",
			"dependency" => array(
				"element" => "style",
				"value" => array("")
			),
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Tooltip Effect", 'citytours'),
			"admin_label" => true,
			"param_name" => "effect",
			"value" => array(
				__( "fadeInDown", "ct" ) => "1",
				__( "flipInX", "ct" ) => "2",
				__( "twistUp", "ct" ) => "3",
				__( "zoomIn", "ct" ) => "4",
			),
			"std" => 'top',
			"description" => "",
			"dependency" => array(
				"element" => "style",
				"value" => array("advanced")
			),
		),
		$content_area,
		$extra_class
	)
) );

/* PriceTable Shortcode */
vc_map( array(
	"name" => esc_html__("Pricing Table", 'citytours'),
	"base" => "pricing_table",
	"icon" => "pricing_table",
	"class" => "",
	"category" => esc_html__('by SoapTheme', 'citytours'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", 'citytours'),
			"admin_label" => true,
			"param_name" => "style",
			"value" => array(
				__( "Default", "ct" ) => "",
				__( "Style2", "ct" ) => "style2",
			),
			"std" => '',
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Is Featured", 'citytours'),
			"param_name" => "is_featured",
			"value" => array(
				__( "No", "ct" ) => "",
				__( "Yes", "ct" ) => "true",
			),
			"std" => '',
			"description" => ""
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'citytours' ),
			'param_name' => 'title',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Price', 'citytours' ),
			'param_name' => 'price',
			"admin_label" => true,
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Button Title', 'citytours' ),
			'param_name' => 'btn_title',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Button Link', 'citytours' ),
			'param_name' => 'btn_url',
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Button Target", 'citytours'),
			"param_name" => "btn_target",
			"value" => array(
				"_self" => "_self",
				"_blank" => "_blank",
				"_top" => "_top",
				"_parent" => "_parent"
			),
			"std" => '_self',
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Button Color", 'citytours'),
			"param_name" => "btn_color",
			"value" => array(
				__( "Default", "ct" ) => "",
				__( "Outline", "ct" ) => "outline",
				__( "White", "ct" ) => "white",
				__( "Green", "ct" ) => "green",
			),
			"std" => '',
			"description" => ""
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Button Class', 'citytours' ),
			'param_name' => 'btn_class',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Ribbon Image Url', 'citytours' ),
			'param_name' => 'ribbon_img_url',
		),
		$content_area,
		$extra_class
	)
) );

/* Review Shortcode */
vc_map( array(
	"name" => esc_html__("Review", 'citytours'),
	"base" => "review",
	"icon" => "review",
	"class" => "",
	"category" => esc_html__('by SoapTheme', 'citytours'),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Reviewer Name', 'citytours' ),
			'param_name' => 'name',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Rating', 'citytours' ),
			'param_name' => 'rating',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Reviewer Image Url', 'citytours' ),
			'param_name' => 'img_url',
		),
		$content_area,
		$extra_class
	)
) );

/* Parallax Block */
vc_map( array(
	"name" => esc_html__("Parallax Block", 'citytours'),
	"base" => "parallax_block",
	"icon" => "parallax_block",
	"class" => "",
	"is_container" => true,
	"category" => esc_html__('by SoapTheme', 'citytours'),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Background Image Url', 'citytours' ),
			'param_name' => 'bg_image'
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Parallax Block Height', 'citytours' ),
			'param_name' => 'height',
			'value' => 470
		),
		$extra_class
	),
	'js_view' => 'VcColumnView'
) );

/* hotels Shortcode */
vc_map( array(
	"name" => esc_html__("Hotels", 'citytours'),
	"base" => "hotels",
	"icon" => "hotels",
	"class" => "",
	"category" => esc_html__('by SoapTheme', 'citytours'),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'citytours' ),
			'param_name' => 'title',
			'admin_label' => true
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Type", 'citytours'),
			"param_name" => "type",
			"value" => array(
				__( "Latest Hotels", 'citytours' ) => "latest",
				__( "Popular Hotels", 'citytours' ) => "popular",
				__( "Featured Hotels", 'citytours' ) => "featured",
				// esc_html__( "Hot Hotels", 'citytours' ) => "hot",
				__( "Selected Hotels", 'citytours' ) => "selected",
			),
			"std" => '',
			"description" => "",
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Count', 'citytours' ),
			'param_name' => 'count',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Per Row', 'citytours' ),
			'param_name' => 'count_per_row',
			"value" => array(
				__( "2", 'citytours' ) => 2,
				__( "3", 'citytours' ) => 3,
				__( "4", 'citytours' ) => 4,
			),
			"std" => '3',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Districts', 'citytours' ),
			'param_name' => 'district',
			"dependency" => array(
				"element" => "type",
				"value" => $districts
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Post Ids', 'citytours' ),
			'param_name' => 'post_ids',
			"dependency" => array(
				"element" => "type",
				"value" => array("")
			),
		),
		$extra_class
	)
) );

/* tours Shortcode */
vc_map( array(
	"name" => esc_html__("Tours", 'citytours'),
	"base" => "tours",
	"icon" => "tours",
	"class" => "",
	"category" => esc_html__('by SoapTheme', 'citytours'),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'citytours' ),
			'param_name' => 'title',
			'admin_label' => true
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Type", 'citytours'),
			"param_name" => "type",
			"value" => array(
				__( "Latest Hotels", 'citytours' ) => "latest",
				__( "Popular Hotels", 'citytours' ) => "popular",
				__( "Featured Hotels", 'citytours' ) => "featured",
				// esc_html__( "Hot Hotels", 'citytours' ) => "hot",
				__( "Selected Hotels", 'citytours' ) => "selected",
			),
			"std" => '',
			"description" => "",
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Count', 'citytours' ),
			'param_name' => 'count',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Per Row', 'citytours' ),
			'param_name' => 'count_per_row',
			"value" => array(
				__( "2", 'citytours' ) => 2,
				__( "3", 'citytours' ) => 3,
				__( "4", 'citytours' ) => 4,
			),
			"std" => '3',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Tour Type', 'citytours' ),
			'param_name' => 'tour_type',
			"dependency" => array(
				"element" => "type",
				"value" => $tour_types
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Post Ids', 'citytours' ),
			'param_name' => 'post_ids',
			"dependency" => array(
				"element" => "type",
				"value" => array("")
			),
		),
		$extra_class
	)
) );

/* Timeline container Block */
vc_map( array(
	"name" => esc_html__("Timeline Container", 'citytours'),
	"base" => "timeline_container",
	"icon" => "timeline_container",
	"class" => "",
	"as_parent" => array( 'only' => 'timeline' ),
	"is_container" => true,
	"category" => esc_html__('by SoapTheme', 'citytours'),
	"params" => array(
		$extra_class
	),
	'js_view' => 'VcColumnView',
	'default_content' => '[timeline][/timeline]'
) );

/* Tiemline Shortcode */
vc_map( array(
	"name" => esc_html__("Timeline", 'citytours'),
	"base" => "timeline",
	"icon" => "timeline",
	"allowed_container_element" => 'timeline_container',
	"class" => "",
	"category" => esc_html__('by SoapTheme', 'citytours'),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Time', 'citytours' ),
			'param_name' => 'time',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Duration', 'citytours' ),
			'param_name' => 'duration',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Icon Class', 'citytours' ),
			'param_name' => 'icon_class',
		),
		$content_area,
		$extra_class
	)
) );

/* Accordion Shortcode */
vc_add_param("vc_accordion", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => esc_html__("Toggle Type", 'citytours'),
	"admin_label" => true,
	"param_name" => "toggle_type",
	"value" => array(
		"Accordion" => "accordion",
		"Toggle" => "toggle"
	),
	"std" => "accordion",
	"description" => ""
));

vc_remove_param('vc_accordion', 'interval');
vc_remove_param('vc_accordion', 'collapsible');
vc_remove_param('vc_accordion', 'disable_keyboard');

vc_map_update("vc_accordion", array(
	'is_container' => false,
	'as_parent' => array( 'only' => 'vc_accordion_tab' ),
));

/* Tabs */
vc_remove_param("vc_tabs", "interval");

vc_add_param("vc_tabs", array(
	'type' => 'textfield',
	'heading' => esc_html__( 'Active Tab Index', 'citytours' ),
	'param_name' => 'active_tab_index',
	'value' => '1'
));

if ( class_exists( 'WPBakeryShortCode' ) ) {
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_Container extends WPBakeryShortCodesContainer {}
		class WPBakeryShortCode_Parallax_Block extends WPBakeryShortCodesContainer {}
		class WPBakeryShortCode_Timeline_Container extends WPBakeryShortCodesContainer {}
	}
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Timeline extends WPBakeryShortCode {}
	}
}


// Replace rows and columns classes
function ct_vc_shortcode_css_class( $class_string, $tag, $atts ) {
	if ($tag =='vc_row' || $tag =='vc_row_inner') {
		$class_string = str_replace('vc_row-fluid', 'row', $class_string);
		if ( !empty( $atts['add_clearfix'] ) ) {
			$class_string .= ' add-clearfix';
		}
	}
	if ($tag =='vc_column' || $tag =='vc_column_inner') {
		if ( !(function_exists('vc_is_inline') && vc_is_inline()) ) {
			$class_string = preg_replace('/vc_col-(\w{2})-(\d{1,2})/', 'col-$1-$2', $class_string);
			$class_string = preg_replace('/vc_hidden-(\w{2})/', 'hidden-$1', $class_string);
		}
	}

	return $class_string;
}
add_filter('vc_shortcodes_css_class', 'ct_vc_shortcode_css_class', 10, 3);