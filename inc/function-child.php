<?php

/**
 * Fuction yang digunakan di theme ini.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('after_setup_theme', 'velocitychild_theme_setup', 9);

function velocitychild_theme_setup()
{

    // Load justg_child_enqueue_parent_style after theme setup
    add_action('wp_enqueue_scripts', 'justg_child_enqueue_parent_style', 20);

    if (class_exists('Kirki')) :

        Kirki::add_panel('panel_velocity', [
            'priority'    => 10,
            'title'       => esc_html__('Velocity Theme', 'justg'),
            'description' => esc_html__('', 'justg'),
        ]);

        // section title_tagline
        Kirki::add_section('title_tagline', [
            'panel'    => 'panel_velocity',
            'title'    => __('Site Identity', 'justg'),
            'priority' => 10,
        ]);
        // new \Kirki\Field\Image(
        //     [
        //         'settings'    => 'banner_uheader',
        //         'label'       => esc_html__('Banner Header', 'justg'),
        //         'description' => esc_html__('Banner Utama', 'justg'),
        //         'section'     => 'title_tagline',
        //         'default'     => '',
        //     ]
        // );
        new \Kirki\Field\Image(
            [
                'settings'    => 'banner_kontak',
                'label'       => esc_html__('Banner Kontak Header', 'justg'),
                'description' => esc_html__('Banner Secondary', 'justg'),
                'section'     => 'title_tagline',
                'default'     => '',
            ]
        );

        ///Section Color
        Kirki::add_section('section_colorvelocity', [
            'panel'    => 'panel_velocity',
            'title'    => __('Color & Background', 'justg'),
            'priority' => 10,
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'color',
            'settings'    => 'color_theme',
            'label'       => __('Theme Color', 'kirki'),
            'description' => esc_html__('', 'kirki'),
            'section'     => 'section_colorvelocity',
            'default'     => '#324f7b',
            'transport'   => 'auto',
            'output'      => [
                [
                    'element'   => ':root',
                    'property'  => '--color-theme',
                ],
                [
                    'element'   => ':root',
                    'property'  => '--bs-primary',
                ],
                [
                    'element'   => '.border-color-theme',
                    'property'  => '--bs-border-color',
                ],
                [
                    'element'   => '.bg-theme',
                    'property'  => 'background-color',
                    'suffix'    => ' !important',
                ],
            ],
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'background',
            'settings'    => 'background_themewebsite',
            'label'       => __('Website Background', 'kirki'),
            'description' => esc_html__('', 'kirki'),
            'section'     => 'section_colorvelocity',
            'default'     => [
                'background-color'      => 'rgba(255,255,255)',
                'background-image'      => '',
                'background-repeat'     => 'repeat',
                'background-position'   => 'center center',
                'background-size'       => 'cover',
                'background-attachment' => 'scroll',
            ],
            'transport'   => 'auto',
            'output'      => [
                [
                    'element'   => ':root[data-bs-theme=light] body',
                ],
                [
                    'element'   => 'body',
                ],
            ],
        ]);

        // remove panel in customizer 
        Kirki::remove_panel('global_panel');
        Kirki::remove_panel('panel_header');
        Kirki::remove_panel('panel_footer');
        Kirki::remove_panel('panel_antispam');
    // Kirki::remove_control('custom_logo');

    endif;

    //remove action from Parent Theme
    remove_action('justg_header', 'justg_header_menu');
    remove_action('justg_do_footer', 'justg_the_footer_open');
    remove_action('justg_do_footer', 'justg_the_footer_content');
    remove_action('justg_do_footer', 'justg_the_footer_close');
    remove_theme_support('widgets-block-editor');
}


///remove breadcrumbs
add_action('wp_head', function () {
    if (!is_single()) {
        remove_action('justg_before_title', 'justg_breadcrumb');
    }
});

if (!function_exists('justg_header_open')) {
    function justg_header_open()
    {
        echo '<header id="wrapper-header">';
        echo '<div id="wrapper-navbar" class="container px-2 px-md-0" itemscope itemtype="http://schema.org/WebSite">';
    }
}
if (!function_exists('justg_header_close')) {
    function justg_header_close()
    {
        echo '</div>';
        echo '</header>';
    }
}


///add action builder part
add_action('justg_header', 'justg_header_berita');
function justg_header_berita()
{
    require_once(get_stylesheet_directory() . '/inc/part-header.php');
}
add_action('justg_do_footer', 'justg_footer_berita');
function justg_footer_berita()
{
    require_once(get_stylesheet_directory() . '/inc/part-footer.php');
}
add_action('justg_before_wrapper_content', 'justg_before_wrapper_content');
function justg_before_wrapper_content()
{
    echo '<div class="px-2">';
    echo '<div class="card rounded-0 border-light border-top-0 border-bottom-0 px-0 px-md-2 container">';
}
add_action('justg_after_wrapper_content', 'justg_after_wrapper_content');
function justg_after_wrapper_content()
{
    echo '</div>';
    echo '</div>';
}


// excerpt more
if (!function_exists('velocity_custom_excerpt_more')) {
    function velocity_custom_excerpt_more($more)
    {
        return '...';
    }
}
add_filter('excerpt_more', 'velocity_custom_excerpt_more');

// excerpt length
function velocity_excerpt_length($length)
{
    return 20;
}
add_filter('excerpt_length', 'velocity_excerpt_length');


//register widget
add_action('widgets_init', 'justg_widgets_init', 20);
if (!function_exists('justg_widgets_init')) {
    function justg_widgets_init()
    {
        $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building-fill me-2 mr-2" viewBox="0 0 16 16">
		<path d="M3 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h3v-3.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V16h3a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H3Zm1 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5ZM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM7.5 5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM4.5 8h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5Z"/>
	  </svg>';
        register_sidebar(
            array(
                'name'          => __('Main Sidebar', 'justg'),
                'id'            => 'main-sidebar',
                'description'   => __('Main sidebar widget area', 'justg'),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div></aside>',
                'before_title'  => '<h3 class="widget-title fw-bold"><span>',
                'after_title'   => '</span></h3><div class="my-2">',
                'show_in_rest'   => false,
            )
        );
        register_sidebar(
            array(
                'name'          => __('Secondary Sidebar', 'justg'),
                'id'            => 'secondary-sidebar',
                'description'   => __('Secondary sidebar widget area', 'justg'),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div></aside>',
                'before_title'  => '<h3 class="widget-title fw-bold"><span>',
                'after_title'   => '</span></h3><div class="my-2">',
                'show_in_rest'   => false,
            )
        );
    }
}
if (!function_exists('justg_right_sidebar_check')) {
    function justg_right_sidebar_check()
    {
        if (is_singular('fl-builder-template')) {
            return;
        }
        if (!is_active_sidebar('main-sidebar')) {
            return;
        }
        echo '<div class="left-sidebar widget-area p-md-0 col-sm-12 col-md-3 order-3 order-md-1" id="left-sidebar" role="complementary">';
        do_action('justg_before_main_sidebar');
        dynamic_sidebar('main-sidebar');
        do_action('justg_after_main_sidebar');
        echo '</div>';
    }
}
if (!function_exists('justg_left_sidebar_check')) {
    function justg_left_sidebar_check()
    {
        if (is_singular('fl-builder-template')) {
            return;
        }
        if (!is_active_sidebar('secondary-sidebar')) {
            return;
        }
        echo '<div class="right-sidebar widget-area ps-md-0 col-sm-12 col-md-3 order-4" id="right-sidebar" role="complementary">';
        do_action('justg_before_secondary_sidebar');
        dynamic_sidebar('secondary-sidebar');
        do_action('justg_after_secondary_sidebar');
        echo '</div>';
    }
}
