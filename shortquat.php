<?php 
/*
plugin Name:ShortCode

*/




add_action( 'init', 'shortcode_theme_custom_post' );
function shortcode_theme_custom_post() {
    register_post_type( 'Testimonial',
        array(
            'labels' => array(
                'name' => __( 'Testimonial' ),
                'singular_name' => __( 'Testimonial' )
            ),
            'supports' => array('title', 'editor', 'custom-fields', 'thumbnail', 'page-attributes'),
            'public' => false,
            'show_ui' => true
        )
    );
}





function post_list_shortcode($atts){
    extract( shortcode_atts( array(
        'count' => '-1',
        'type' => 'post',
        'color' => '#00d86c',
        'icon' => '',
    ), $atts) );
     
    $q = new WP_Query(
        array(
		'posts_per_page' => $count,
		'post_type' => $type
		)
        );      
         
    $list = '<ul>';
    while($q->have_posts()) : $q->the_post();
        $idd = get_the_ID();
        $custom_field = get_post_meta($idd, 'custom_field', true);
        $post_content = get_the_content();
        $list .= '<li><a style="color:'.$color.'" href="'.get_permalink().'">';
	   
	   if(!empty($icon)){
		   $list.='<i class="'.$icon.'"></i>';
		   
	   }
	   
	   
	   $list .=''.get_the_title().'</a></li>';        
	   
	   
	   
    endwhile;
    $list.= '</ul>';
    wp_reset_query();
    return $list;
}
add_shortcode('post_list', 'post_list_shortcode');  


function shortcode_test(){
	vc_map( array(
	 "name" => __( "Post list", "my-text-domain"),
	 "base" => "post_list",
	 "category" => __("Stock","my-text-domain"),
	 "params" => array(
		array(
		"type" => "textfield",
		"heading" => __("post type","my-text-domain"),
		"param_name" => "type",
		"value" => __("post","my-text-domain"),
		"description" => __("Post type","my-text-domain"),
		),
		
		array(
		"type" => "textfield",
		"heading" => __("post count","my-text-domain"),
		"param_name" => "count",
		"value" => __("-1","my-text-domain"),
		"description" => __("Type how many item youwant to show . Number only . Tupe -1 for unlimited","my-text-domain"),
		),
		
		array(
		"type" => "colorpicker",
		"heading" => __("Link color","my-text-domain"),
		"param_name" => "color",
		"value" => __("#00d86c","my-text-domain"),
		"description" => __("Color picker","my-text-domain"),
		),
		
		array(
		"type" => "iconpicker",
		"heading" => __("Icon","my-text-domain"),
		"param_name" => "icon",
		"description" => __("icon picker","my-text-domain"),
		)
		
		
		)
	 
	));
	
}
add_action('vc_before_init','shortcode_test');











