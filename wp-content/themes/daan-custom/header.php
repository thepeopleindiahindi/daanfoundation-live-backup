<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/favicon-192.png">
    <link rel="apple-touch-icon" sizes="307x307" href="/apple-touch-icon.png">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page">
    <header id="masthead" class="site-header">
        <div class="header-bar">
            <div class="header-inner">
                <!-- Logo -->
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/daan-foundation-logo.png' ); ?>"
                         alt="Daan Foundation"
                         onerror="this.src='<?php echo esc_url( home_url( '/images/daan-foundation-logo.png' ) ); ?>'">
                </a>

                <!-- Desktop Navigation -->
                <nav class="desktop-nav">
                    <?php
                    $menu_items = array(
                        'Appeals' => array(
                            'href' => home_url( '/appeals' ),
                            'featured' => array(
                                'title' => 'Community Kitchen',
                                'desc'  => 'Free food for everyone, every day',
                                'href'  => home_url( '/community-kitchen' ),
                                'style' => 'background: linear-gradient(135deg, #F59E0B, #EA580C);',
                            ),
                            'columns' => array(
                                'Emergency Appeal' => array(
                                    array( 'Community Kitchen', '/community-kitchen' ),
                                ),
                                'Seasonal Giving' => array(
                                    array( 'Ramadan Iftar', '/ramadan' ),
                                    array( 'Winter Appeal', '/winter' ),
                                ),
                            ),
                        ),
                        'Ways to Give' => array(
                            'href' => home_url( '/zakat' ),
                            'featured' => array(
                                'title' => 'Zakat Calculator',
                                'desc'  => 'Calculate your Zakat obligation',
                                'href'  => home_url( '/zakat-calculator' ),
                                'style' => 'background: linear-gradient(135deg, #F97316, #EA580C);',
                            ),
                            'columns' => array(
                                'Islamic Giving' => array(
                                    array( 'Zakat', '/zakat' ),
                                    array( 'Sadaqah', '/sadaqah' ),
                                    array( 'Sadaqah Jariyah', '/sadaqah-jariyah' ),
                                    array( 'Fidyah', '/fidya' ),
                                    array( 'Kaffarah', '/kaffarah' ),
                                ),
                                'Programs' => array(
                                    array( 'Community Kitchen', '/community-kitchen' ),
                                    array( 'Ramadan Iftar Program', '/ramadan' ),
                                    array( 'Winter Relief', '/winter' ),
                                    array( 'Eid Gifts', '/eid-gifts' ),
                                    array( 'Where Most Needed', '/where-most-needed' ),
                                    array( 'Orphan Sponsorship', '/orphan-sponsorship' ),
                                    array( 'Water for Life', '/water' ),
                                ),
                            ),
                        ),
                        'Our Work' => array(
                            'href' => home_url( '/our-work/impact' ),
                            'columns' => array(
                                'Impact for Good' => array(
                                    array( 'Our Impact', '/our-work/impact' ),
                                    array( 'Your Charity in Action', '/our-work/charity-in-action' ),
                                    array( 'Community Trust & Feedback', '/our-work/community-trust' ),
                                    array( 'The History of Daan Foundation', '/our-work/history' ),
                                    array( 'Annual Impact Report', '/our-work/annual-report' ),
                                ),
                                'Stories & Values' => array(
                                    array( 'Serving With Dignity', '/our-work/serving-with-dignity' ),
                                    array( 'Supporting Women With Dignity', '/our-work/supporting-women' ),
                                    array( 'Your Donation Is a Trust', '/our-work/donation-is-trust' ),
                                    array( 'Empowering Livelihoods', '/our-work/empowering-livelihoods' ),
                                    array( 'Why Transparency Matters', '/our-work/why-transparency' ),
                                    array( 'Where We Work', '/where-we-work' ),
                                ),
                            ),
                        ),
                        'About' => home_url( '/about' ),
                        'Contact' => home_url( '/contact' ),
                        'Bank Details' => home_url( '/bank-details' ),
                    );

                    foreach ( $menu_items as $label => $data ) : ?>
                        <div class="nav-item">
                            <?php if ( is_array( $data ) && isset( $data['columns'] ) ) : ?>
                                <a href="<?php echo esc_url( $data['href'] ); ?>" class="nav-link">
                                    <?php echo esc_html( $label ); ?>
                                    <span class="nav-arr"></span>
                                </a>
                                <div class="mega-menu">
                                    <div class="mega-menu-inner <?php echo ! isset( $data['featured'] ) ? 'no-featured' : ''; ?>">
                                        <?php if ( isset( $data['featured'] ) ) : ?>
                                            <a href="<?php echo esc_url( $data['featured']['href'] ); ?>" class="mega-menu-featured" style="<?php echo $data['featured']['style']; ?>">
                                                <span class="featured-label">Featured</span>
                                                <span class="featured-title"><?php echo esc_html( $data['featured']['title'] ); ?></span>
                                                <span class="featured-desc"><?php echo esc_html( $data['featured']['desc'] ); ?></span>
                                            </a>
                                        <?php endif; ?>
                                        <div class="mega-menu-links">
                                            <?php foreach ( $data['columns'] as $heading => $links ) : ?>
                                                <div class="mega-menu-col">
                                                    <h4><?php echo esc_html( $heading ); ?></h4>
                                                    <ul>
                                                        <?php foreach ( $links as $link ) : ?>
                                                            <li><a href="<?php echo esc_url( home_url( $link[1] ) ); ?>"><?php echo esc_html( $link[0] ); ?></a></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php else : ?>
                                <a href="<?php echo esc_url( $data ); ?>" class="nav-link"><?php echo esc_html( $label ); ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </nav>

                <!-- Right side actions -->
                <div class="header-actions">
                    <button class="search-btn" aria-label="Search">
                        <svg class="search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <a href="<?php echo esc_url( home_url( '/donate' ) ); ?>" class="donate-btn">Donate Now</a>

                    <button class="menu-toggle" id="menu-toggle" aria-label="Toggle menu">
                        <svg class="menu-icon menu-icon-open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="menu-icon menu-icon-close" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="mobile-nav" id="mobile-nav">
            <nav class="mobile-nav-inner">
                <?php foreach ( $menu_items as $label => $data ) : ?>
                    <?php if ( is_array( $data ) && isset( $data['columns'] ) ) :
                        $all_links = array();
                        foreach ( $data['columns'] as $links ) {
                            foreach ( $links as $link ) {
                                $all_links[] = $link;
                            }
                        }
                    ?>
                        <div class="mobile-nav-item">
                            <button class="mobile-nav-header" onclick="toggleMobileSubmenu(this)">
                                <?php echo esc_html( $label ); ?>
                                <svg class="mobile-nav-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="mobile-submenu">
                                <?php foreach ( $all_links as $link ) : ?>
                                    <a href="<?php echo esc_url( home_url( $link[1] ) ); ?>"><?php echo esc_html( $link[0] ); ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <a href="<?php echo esc_url( $data ); ?>" class="mobile-nav-link"><?php echo esc_html( $label ); ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </nav>
            <div class="mobile-donate-section">
                <a href="<?php echo esc_url( home_url( '/donate' ) ); ?>" class="mobile-donate-btn">Donate Now</a>
            </div>
        </div>
    </header>

    <main id="content">
