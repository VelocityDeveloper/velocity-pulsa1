<?php

/**
 * Kumpulan shortcode yang digunakan di theme ini.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
//[resize-thumbnail width="300" height="150" linked="true" class="w-100"]
add_shortcode('resize-thumbnail', 'resize_thumbnail');
function resize_thumbnail($atts)
{
    ob_start();
    global $post;
    $atribut = shortcode_atts(array(
        'output'    => 'image', /// image or url
        'width'        => '300', ///width image
        'height'    => '150', ///height image
        'crop'      => 'false',
        'upscale'       => 'true',
        'linked'       => 'true', ///return link to post	
        'class'       => 'w-100', ///return class name to img	
        'attachment'     => 'true'
    ), $atts);

    $output            = $atribut['output'];
    $attach         = $atribut['attachment'];
    $width          = $atribut['width'];
    $height         = $atribut['height'];
    $crop           = $atribut['crop'];
    $upscale        = $atribut['upscale'];
    $linked            = $atribut['linked'];
    $class            = $atribut['class'] ? 'class="' . $atribut['class'] . '"' : '';
    $urlimg            = get_the_post_thumbnail_url($post->ID, 'full');

    if (empty($urlimg) && $attach == 'true') {
        $attachments = get_posts(array(
            'post_type'         => 'attachment',
            'posts_per_page'     => 1,
            'post_parent'         => $post->ID,
            'orderby'          => 'date',
            'order'            => 'DESC',
        ));
        if ($attachments) {
            $urlimg = wp_get_attachment_url($attachments[0]->ID, 'full');
        }
    }

    if ($urlimg) :
        $urlresize      = aq_resize($urlimg, $width, $height, $crop, true, $upscale);
        if ($output == 'image') :
            if ($linked == 'true') :
                echo '<a href="' . get_the_permalink($post->ID) . '" title="' . get_the_title($post->ID) . '">';
            endif;
            echo '<img src="' . $urlresize . '" width="' . $width . '" height="' . $height . '" loading="lazy" ' . $class . '>';
            if ($linked == 'true') :
                echo '</a>';
            endif;
        else :
            echo $urlresize;
        endif;
    endif;

    return ob_get_clean();
}

//[excerpt count="150"]
add_shortcode('excerpt', 'vd_getexcerpt');
function vd_getexcerpt($atts)
{
    ob_start();
    global $post;
    $atribut = shortcode_atts(array(
        'count'    => '150', /// count character
    ), $atts);

    $count        = $atribut['count'];
    $excerpt    = get_the_content();
    $excerpt     = strip_tags($excerpt);
    $excerpt     = substr($excerpt, 0, $count);
    $excerpt     = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt     = '' . $excerpt . '...';

    echo $excerpt;

    return ob_get_clean();
}

// [vd-search]
add_shortcode('vd-search', 'vd_search');
function vd_search()
{
    ob_start(); ?>
    <div class="vsearch float-end">
        <form method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>" style="max-width: 300px;">
            <label class="sr-only" for="s"><?php esc_html_e('Search', 'justg'); ?></label>
            <div class="input-group">
                <input class="field form-control rounded-0" id="s" name="s" type="text" placeholder="" value="<?php the_search_query(); ?>" required>
                <span class="input-group-append">
                    <button type="submit" class="submit btn h-100 p-1 btn-sm rounded-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </span>
            </div>
        </form>
    </div>
<?php
    return ob_get_clean();
}
