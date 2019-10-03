<?php
/**
* ReduxFramework Sample Config File
* For full documentation, please visit: http://docs.reduxframework.com/
*/

if ( ! class_exists( 'Redux' ) ) {
    return;
}


// This is your option name where all the Redux data is stored.
$opt_name = "related_posts";

// This line is only for altering the demo. Can be easily removed.
$opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

/*
*
* --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
*
*/

$sampleHTML = '';
if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
    Redux_Functions::initWpFilesystem();
    
    global $wp_filesystem;
    
    $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
}

// Background Patterns Reader
$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
$sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
$sample_patterns      = array();

if ( is_dir( $sample_patterns_path ) ) {
    
    if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
        $sample_patterns = array();
        
        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {
            
            if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                $name              = explode( '.', $sample_patterns_file );
                $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                $sample_patterns[] = array(
                    'alt' => $name,
                    'img' => $sample_patterns_url . $sample_patterns_file
                );
            }
        }
    }
}

/**
* ---> SET ARGUMENTS
* All the possible arguments for Redux.
* For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
* */

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'         => 'Related Posts Settings',
    // Name that appears at the top of your panel
    'display_version'      => VISUALMODO_RELATED_POSTS_VERSION,
    // Version that appears at the top of your panel
    'menu_type'            => 'submenu',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'       => true,
    // Show the sections below the admin menu item or not
    'menu_title'           => __( 'Settings', 'visualmodo' ),
    'page_title'           => __( 'Settings', 'visualmodo' ),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key'       => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'     => false,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar'            => false,
    // Show the panel pages on the admin bar
    'admin_bar_icon'       => 'dashicons-portfolio',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'   => 50,
    // Choose an priority for the admin bar menu
    'global_variable'      => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'             => false,
    // Show the time the page took to load, etc
    'update_notice'        => false,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'           => false,
    // Enable basic customizer support
    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
    
    // OPTIONAL -> Give you extra features
    'page_priority'        => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => 'related-posts.php',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'     => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon'            => '',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => 'related-posts-settings',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.
    
    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
    
    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.
    
    // HINTS
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
    
    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => 'https://github.com/visualmodo',
        'title' => 'Visit us on GitHub',
        'icon'  => 'el el-github'
        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/visualmodo/',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://twitter.com/visualmodo',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://pt.linkedin.com/company/visualmodo',
        'title' => 'Find us on LinkedIn',
        'icon'  => 'el el-linkedin'
    );
    
    Redux::setArgs( $opt_name, $args );
    
    /*
    * ---> END ARGUMENTS
    */
    
    
    /*
    *
    * ---> START SECTIONS
    *
    */
    
    Redux::setSection( $opt_name, array(
        'icon'      => 'el-icon-cog',
        'title'     => __('General', 'visualmodo'),
        'desc'      => __('Control and configure the general setup of your Blog.', 'visualmodo'),
        'fields'    => array(
            array(
                'id'        => 'related_posts_image',
                'type'      => 'switch',
                'title'     => __('Related Posts Image', 'visualmodo'),
                'default'   => true,
            ),
            array(
                'id'        => 'related_posts_excerpt',
                'type'      => 'switch',
                'title'     => __('Related Posts Excerpt', 'visualmodo'),
                'default'   => true,
            ),
            array(
                'id' => 'related_posts_value',
                'type' => 'slider',
                'title' => __('Number of Posts to Display', 'visualmodo'),
                'desc' => __('Min: 3, max: 12, step: 1, default value: 6', 'visualmodo'),
                "default" => 6,
                "min" => 3,
                "step" => 1,
                "max" => 12,
                'display_value' => 'text'
            ),
            array(
                'id' => 'related_posts_excerpt_value',
                'type' => 'slider',
                'title' => __('Limit Post Excerpt Length', 'visualmodo'),
                'desc' => __('Min: 10, max: 100, step: 1, default value: 60', 'visualmodo'),
                'required' => array('related_posts_excerpt','equals', true ),
                "default" => 60,
                "min" => 10,
                "step" => 1,
                "max" => 100,
                'display_value' => 'text'
            ),
            array(
                'id' => 'related_posts_image_resolution', 
                'type' => 'button_set',
                'title' => __('Related Posts Image Resolution', 'visualmodo'),
                'desc' => __('Select the best resolution for the images.', 'visualmodo'),
                'required' => array('related_posts_image','equals', true ),
                'options' => array(
                    'thumbnail' => __('Thumbnail', 'visualmodo'),
                    'medium' => __('Medium', 'visualmodo'),
                    'medium-large' => __('Medium Large', 'visualmodo'),
                    'large' => __('Large', 'visualmodo'),
                    'full' => __('Full', 'visualmodo'),
                ),
                'default' => 'thumbnail'
            ),
            array(
                'id'        => 'related_posts_heading',
                'type'      => 'text',
                'title'     => __('Related Posts Heading', 'visualmodo'),
                'desc'      => __('Default is "Recommended For You".', 'visualmodo'),
                'default' => ''
            ),
        ),
        ) );
        
        Redux::setSection( $opt_name, array(
            'title'      => __( 'Colors', 'visualmodo' ),
            'id'         => 'aaa',
            'desc'       => __( 'Control and configure the design options.', 'visualmodo' ),
            'icon'             => 'el el-tint',
            'fields'     => array(
                array(
                    'id'        => 'related_post_background_color',
                    'type'      => 'link_color',
                    'title'     => __('Background Color', 'visualmodo'),
                    'output'    => array(
                        'background-color' => '.visualmodo-related-post',
                    ),
                    'subtitle'  => __('Pick a background color for the related post body.', 'visualmodo'),
                    'active'    => false, // Disable Active Color
                    'visited'   => false,  // Enable Visited Color
                    'default'  => array(
                        'regular' => '#FFFFFF',
                        'hover'   => '#FFFFFF',
                    ),
                ),
                array(
                    'id'       => 'related_post_title',
                    'type'     => 'link_color',
                    'title'    => __( 'Title Color', 'visualmodo' ),
                    'subtitle'     => __( 'Enter the color for title states.', 'visualmodo' ),
                    'output'    => array(
                        'color' => '.visualmodo-related-post-body-title',
                    ),
                    'active'    => false, // Disable Active Color
                    'visited'   => false,  // Enable Visited Color
                    'default'  => array(
                        'regular' => '#3379fc',
                        'hover'   => '#3365c3',
                    ),
                ),
                array(
                    'id'       => 'related_post_content',
                    'type'     => 'link_color',
                    'title'    => __( 'Content Color', 'visualmodo' ),
                    'subtitle'     => __( 'Enter the color for content states.', 'visualmodo' ),
                    'output'    => array(
                        'color' => '.visualmodo-related-post-body-content',
                    ),
                    'active'    => false, // Disable Active Color
                    'visited'   => false,  // Enable Visited Color
                    'default'  => array(
                        'regular' => '#555',
                        'hover'   => '#000',
                    ),
                ),
                )
                ) );
                
                Redux::setSection( $opt_name, array(
                    'title'      => __( 'Custom Code', 'visualmodo' ),
                    'id'         => 'ccc',
                    'desc'       => __( 'Enter your custom codes.', 'visualmodo' ),
                    'icon'             => 'el el-css',
                    'fields'     => array(
                        array(
                            'id'        => 'related_posts_custom_css',
                            'type'      => 'ace_editor',
                            'title'     => __('CSS Code', 'visualmodo'),
                            'subtitle'  => __('Paste your CSS code here.', 'visualmodo'),
                            'mode'      => 'css',
                            'theme'     => 'monokai',
                        ),
                        array(
                            'id'        => 'related_posts_custom_javascript',
                            'type'      => 'ace_editor',
                            'title'     => __('JS Code', 'visualmodo'),
                            'subtitle'  => __('Paste your JS code here.', 'visualmodo'),
                            'mode'      => 'javascript',
                            'theme'     => 'chrome',
                        ),
                        )
                        ) );
                        
                        /*
                        * <--- END SECTIONS
                        */
                        
                        