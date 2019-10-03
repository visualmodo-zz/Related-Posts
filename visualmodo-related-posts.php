<?php
/*
Plugin Name: Visualmodo Related Posts
Plugin URI: https://visualmodo.com/related-posts
Description: Visualmodo Related Posts for WordPress will help increase your visitors’ time on website and decrease your bounce rate.
Version: 1.0.1
Author: Visualmodo
Author URI: https://visualmodo.com
License: GPLv3 or later
Text Domain: visualmodo
Domain Path: /languages
*/

// don't load directly
if (!defined('ABSPATH')) die('-1');

if ( ! defined( 'VISUALMODO_RELATED_POSTS_VERSION' ) ) define( 'VISUALMODO_RELATED_POSTS_VERSION', '1.0.1' );

// Related Posts Base
$dir = dirname( __FILE__ );
$inc = dirname(__FILE__) . "/includes";

require_once( $inc . "/options/init.php");
wp_enqueue_style('visualmodo_related_posts_backend_style', plugins_url('assets/styles/backend.css', __FILE__) );
wp_enqueue_style('visualmodo_related_posts_frontend_style', plugins_url('assets/styles/related-posts.css', __FILE__) );

/*-----------------------------------------------------------------------------------*/
/*  *.  Redux Framework Improvements
/*-----------------------------------------------------------------------------------*/

/** remove redux menu under the tools **/
add_action( 'admin_menu', 'visualmodo_related_post_remove_redux_menu',12 );
function visualmodo_related_post_remove_redux_menu() {
    remove_submenu_page('tools.php','redux-about');
}


/*-----------------------------------------------------------------------------------*/
/*  *.  Related Posts Dashboard
/*-----------------------------------------------------------------------------------*/

add_action( 'admin_menu', 'visualmodo_related_post_admin_menu' );

function visualmodo_related_post_admin_menu() {
    add_menu_page( 'Related Posts', 'Related Posts', 'manage_options', 'related-posts.php', 'visualmodo_related_post_home', plugin_dir_url(__FILE__) . "/assets/img/related-posts.svg", 99  );
}

function visualmodo_related_post_home(){ ?>
    <div class="wrap visualmodo-related-posts-page-welcome about-wrap">
    <h1><?php echo sprintf( __( 'Visualmodo Related Posts', 'visualmodo' ), isset( $matches[0] ) ? $matches[0] : VISUALMODO_RELATED_POSTS_VERSION ) ?></h1>
    
    <div class="about-text">
    <?php _e( 'Visualmodo Related Posts for WordPress will help increase your visitors’ time on website and decrease your bounce rate.', 'visualmodo' ) ?>
    </div>
    <div class="wp-badge visualmodo-related-posts-page-logo">
    <?php echo sprintf( __( 'Version %s', 'visualmodo' ), VISUALMODO_RELATED_POSTS_VERSION ) ?>
    </div>
    <p class="visualmodo-related-posts-page-actions">
    <a href="<?php echo esc_attr( admin_url( 'admin.php?page=related-posts-settings' ) ) ?>"
    class="button button-primary visualmodo-related-posts-button-settings"><?php _e( 'Settings', 'visualmodo' ) ?></a>
    <a href="https://twitter.com/share" class="twitter-share-button"
    data-via="visualmodo"
    data-text="Visualmodo Related Posts for WordPress will help increase your visitors’ time on website and decrease your bounce rate."
    data-url="http://visualmodo.com" data-size="large">Tweet</a>
    <script>! function ( d, s, id ) {
        var js, fjs = d.getElementsByTagName( s )[ 0 ], p = /^http:/.test( d.location ) ? 'http' : 'https';
        if ( ! d.getElementById( id ) ) {
            js = d.createElement( s );
            js.id = id;
            js.src = p + '://platform.twitter.com/widgets.js';
            fjs.parentNode.insertBefore( js, fjs );
        }
    }( document, 'script', 'twitter-wjs' );</script>
    </p>
    </div>
    <?php
}

/*-----------------------------------------------------------------------------------*/
/*  *.  Single Related Posts
/*-----------------------------------------------------------------------------------*/

function related_posts_after_post_content($content){
    
    if ( !is_admin() && is_singular( 'post' ) ) {
        
        global $post;
        $options = get_option('related_posts');
        $related_posts_custom_css = $options['related_posts_custom_css'] ?: '';
        $related_post_background_color = $options['related_post_background_color'] ?: '#FFFFFF';
        $related_post_title = $options['related_post_title'] ?: '#3365c3';
        $related_post_content = $options['related_post_content'] ?: '#000';
        $related_posts_heading = $options['related_posts_heading'] ?: 'Recommended For You';
        $related_posts_image = $options['related_posts_image'] ?: '';
        $related_posts_excerpt = $options['related_posts_excerpt'] ?: '';
        $related_posts_image_resolution = $options['related_posts_image_resolution'] ?: 'thumbnail';
        $related_posts_value = $options['related_posts_value'] ?: '6';
        
        // Custom CSS
        if(!empty($related_posts_custom_css)) { 
            $content .= '<style type="text/css">'. $related_posts_custom_css .'</style>'; 
        }
        
        $content .= '<style type="text/css">
            .visualmodo-related-post {background-color:'. $related_post_background_color['regular'] .'; }
            .visualmodo-related-post:hover {background-color:'. $related_post_background_color['hover'] .'; }
            .visualmodo-related-post:hover .visualmodo-related-post-body-title {color:'. $related_post_title['hover'] .'; }
            .visualmodo-related-post:hover .visualmodo-related-post-body-content {color:'. $related_post_content['hover'] .'; } 
        </style>';
        
        $content .= '<div class="visualmodo-related-posts">';
        
        $content .= '<h3 class="visualmodo-related-posts-title">'.$related_posts_heading.'</h3>';
        
        function get_excerpt(){
            $options = get_option('related_posts');
            $related_posts_excerpt_value = $options['related_posts_excerpt_value'] ?: '60';
            $excerpt = get_the_content();
            $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
            $excerpt = strip_shortcodes($excerpt);
            $excerpt = strip_tags($excerpt);
            $excerpt = substr($excerpt, 0, $related_posts_excerpt_value);
            return $excerpt;
        }
        
        $related = get_posts( 
            array( 
                'category__in' => wp_get_post_categories(get_the_ID()), 
                'numberposts' => $related_posts_value, 
                'post__not_in' => array(get_the_ID()) 
                ) 
            );
            
            if( $related )
            
            $content .= '<div class="visualmodo-related-posts-grid">';
            
            foreach( $related as $post ) {
                
                setup_postdata($post);
                
                if ($related_posts_image == true && has_post_thumbnail()) { 
                    $img = get_the_post_thumbnail( get_the_ID(), $related_posts_image_resolution, array( 'class' => 'visualmodo-related-post-body-image' ) ); 
                }
                
                $content .= '<div class="visualmodo-related-post">';
                $content .= '<a rel="bookmark" href="'.get_the_permalink().'">';
                
                $content .= $img;
                
                $content .= '<div class="visualmodo-related-post-body">';
                $content .= '<h6 class="visualmodo-related-post-body-title">'. get_the_title() .'</h6>';
                if ($related_posts_excerpt == true) { 
                    $content .= '<p class="visualmodo-related-post-body-content">'. get_excerpt() .'</p>'; 
                }
                $content .= '</div>';
                
                $content .= '</a>';
                $content .= '</div>';
            }
            
            $content .= '</div>';
            
            wp_reset_postdata();
            
            return $content;
            
        } else {
            
            return $content;
            
        }
    }
    
    add_filter( "the_content", "related_posts_after_post_content" ); 
    
    ?>