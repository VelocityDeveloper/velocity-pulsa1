<div class="header-mains bg-white rounded-top">
    <nav id="main-navi" class="navbar navbar-expand-md d-block navbar-light rounded-top p-0" aria-labelledby="main-nav-label">

        <div class="menu-header text-center d-md-none position-relative" data-bs-theme="light">

            <button class="w-75 navbar-toggler text-dark p-2 m-2 rounded-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNavOffcanvas" aria-controls="navbarNavOffcanvas" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'justg'); ?>">
                <!-- <span class="navbar-toggler-icon"></span> -->
                <small>Menu Utama</small>
            </button>

        </div>

        <div class="row m-0 p-md-4 pb-md-0 p-2">
            <div class="col-md-8 col-6 p-0">
                <?php $sitelogo = velocitytheme_option('custom_logo');
                if ($sitelogo) : ?>
                    <a href="<?php get_home_url(); ?>">
                        <img src="<?php echo wp_get_attachment_image_url($sitelogo, 'full'); ?>" alt="Site Logo" loading="lazy">
                    </a>
                <?php endif;  ?>
            </div>
            <div class="col-md-4 col-6 p-0">
                <div class="d-none d-md-block"><?php echo do_shortcode('[vd-search]'); ?></div>
                <?php $kontakimg = velocitytheme_option('banner_kontak');
                if ($kontakimg) {
                    echo '<div class="text-end"><img class="w-100" src="' . $kontakimg . '" /></div>';
                }
                ?>
            </div>
        </div>
        <h2 id="main-nav-label" class="screen-reader-text">
            <?php esc_html_e('Main Navigation', 'justg'); ?>
        </h2>

        <div class="bg-white">
            <div class="pb-0">

                <div class="offcanvas offcanvas-start" tabindex="-1" id="navbarNavOffcanvas">

                    <div class="offcanvas-header justify-content-end">
                        <button type="button" class="btn-close btn-close-dark text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div><!-- .offcancas-header -->

                    <!-- The WordPress Menu goes here -->
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'primary',
                            'container_class' => 'offcanvas-body',
                            'container_id'    => '',
                            'menu_class'      => 'navbar-nav navbar-light p-md-2 justify-content-md-end justify-content-start flex-md-wrap flex-grow-1',
                            'fallback_cb'     => '',
                            'menu_id'         => 'primary-menu',
                            'depth'           => 4,
                            'walker'          => new justg_WP_Bootstrap_Navwalker(),
                        )
                    ); ?>

                </div><!-- .offcanvas -->
            </div>

            <div class="w-100">
                <?php if (has_header_image()) {
                    echo '<a href="' . get_home_url() . '">';
                    echo '<img class="w-100" src="' . esc_url(get_header_image()) . '" />';
                    echo '</a>';
                } ?>
            </div>
        </div>

    </nav><!-- .site-navigation -->
</div>