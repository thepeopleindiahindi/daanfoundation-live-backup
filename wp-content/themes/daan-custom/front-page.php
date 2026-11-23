<?php
/**
 * Front page template — full homepage matching React design
 * Template Name: Homepage
 */

get_header();
?>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- HERO SECTION — responsive image (mobile crop vs desktop banner) -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="hero hero-iftar" aria-labelledby="hero-iftar-title">
    <?php
    // Owner, 2026-11-23: new hero photo; text in HTML (not in the image). Price from the "Iftar kit price" setting.
    $daan_iftar_price = function_exists( 'daan_menu_price' ) ? daan_menu_price( 'daan_iftar_kit_price', 91 ) : '₹91';
    ?>
    <picture class="hero-iftar-media">
        <img class="hero-iftar-img" src="/images/hero-r27-1536.webp" srcset="/images/hero-r27-480.webp 480w, /images/hero-r27-768.webp 768w, /images/hero-r27-1024.webp 1024w, /images/hero-r27-1536.webp 1536w" sizes="(min-width: 1024px) 62vw, 100vw" width="1536" height="1024" fetchpriority="high" alt="Ramadan 2027: Bringing Smiles Through Free Iftar. A boy holding an iftar kit and a food container from Daan Foundation's Community Kitchen">
    </picture>
    <div class="hero-iftar-shade" aria-hidden="true"></div>
    <div class="hero-iftar-text">
        <div class="hero-iftar-inner">
            <h1 id="hero-iftar-title">Feed a fasting person this Ramadan</h1>
            <p class="hero-iftar-sub">200–300 people get iftar every day in Ramadan · Since 2020</p>
            <div class="hero-iftar-btns">
                <a class="hero-iftar-btn" href="<?php echo esc_url( home_url( '/product/ramadan-iftar/' ) ); ?>">Donate Iftar Kit (<?php echo esc_html( $daan_iftar_price ); ?>)</a>
                <a class="hero-iftar-btn-ghost" href="<?php echo esc_url( home_url( '/donate/' ) ); ?>">Other ways to give</a>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- DONATION WIDGET + QUICK ACTIONS — side-by-side on desktop (>=1024px) -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<div class="donate-quickactions-row">
<section class="section hero-donate-section">
    <div class="container" style="display:flex;justify-content:center;">
        <div class="donation-widget" data-daan-donate>
            <h2>Make a Donation</h2>
            <p class="widget-sub">Every contribution makes a difference</p>

            <div data-daan-free>
            <div class="amount-grid">
                <?php foreach ( array( 500, 1000, 2500, 5000 ) as $amount ) : ?>
                    <button type="button" data-amount="<?php echo $amount; ?>" class="amount-btn <?php echo $amount === 1000 ? 'active' : ''; ?>"
                            onclick="selectAmount(this, <?php echo $amount; ?>)">
                        ₹<?php echo $amount; ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="custom-amount-wrap">
                <span class="currency">₹</span>
                <input type="number" class="custom-amount" aria-label="Other amount" placeholder="Other amount"
                       oninput="clearAmounts(this)">
            </div>
            </div>

            <div class="cause-select">
                <label for="donate-cause">Select a Cause</label>
                <select id="donate-cause">
                    <?php echo daan_widget_cause_options(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </select>
            </div>

            <button type="button" class="donate-now-btn" onclick="daanWidgetGo(this)">Donate Now</button>

            <div class="trust-indicators">
                <span class="trust-item">
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                    Secure
                </span>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- QUICK ACTIONS — Maximise Your Reward -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="section quick-actions-section">
    <div class="container">
        <div class="section-header">
            <h2>Maximise Your Reward</h2>
            <p>Choose how you'd like to make a difference today</p>
        </div>

        <div class="quick-actions-grid">
            <?php
            $qa_icons = array(
                'M3 2v7c0 1.1.9 2 2 2h4a2 2 0 002-2V2 M7 2v20 M14 2v20h4a2 2 0 002-2V2',
                'M12 2v2 M6.5 12l5.5-5.5 5.5 5.5 M3 21h18 M3 21l4-8 M21 21l-4-8',
                'M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z',
                'M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z M3 6h18 M16 10a4 4 0 01-8 0',
                'M4 2h16a2 2 0 012 2v16a2 2 0 01-2 2H4a2 2 0 01-2-2V4a2 2 0 012-2z M8 6h8 M8 10h8 M8 14h5 M16 14h1 M8 18h8 M16 18h1',
                'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
            );
            $qa_items = array(
                array( 'Community Kitchen', 'Feed the hungry — ₹60 provides one meal', '/community-kitchen/', 'linear-gradient(135deg, #F59E0B, #EA580C)', 0 ),
                array( 'Fidyah & Kaffarah', 'Fidyah & Kaffarah: not accepted · read the rules', '/fidya/', 'linear-gradient(135deg, #8B5CF6, #7C3AED)', 1 ),
                array( 'Ramadan Iftar Appeal', 'Iftar meals for those fasting in need', '/ramadan/', 'linear-gradient(135deg, #F43F5E, #E11D48)', 2 ),
                array( 'Donate Ration Kit', 'A complete ration kit for a family in need — ' . ( function_exists( 'daan_kit_price' ) ? '₹' . number_format_i18n( daan_kit_price() ) : '₹1,536' ) . ' per kit', '/product/ration-kit-donation/', 'linear-gradient(135deg, #06B6D4, #0D9488)', 3 ),
                array( 'Zakat', 'Calculate and pay your Zakat accurately', '/zakat/', 'linear-gradient(135deg, #F97316, #EA580C)', 4 ),
                array( 'Sadaqah', 'Earn ongoing rewards with voluntary charity', '/sadaqah/', 'linear-gradient(135deg, #3B82F6, #4F46E5)', 5 ),
            );
            foreach ( $qa_items as $qa ) : ?>
                <a href="<?php echo esc_url( home_url( $qa[2] ) ); ?>" class="qa-card">
                    <div class="qa-icon" style="background: <?php echo $qa[3]; ?>">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $qa_icons[$qa[4]]; ?>" />
                        </svg>
                    </div>
                    <h3><?php echo esc_html( $qa[0] ); ?></h3>
                    <p><?php echo esc_html( $qa[1] ); ?></p>
                    <div class="qa-arrow">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
</div><!-- /.donate-quickactions-row -->

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- CURRENT CAMPAIGNS -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="section section-alt">
    <div class="container">
        <div class="header-with-link">
            <div>
                <h2 class="h2" style="margin-bottom:0.5rem">Current Campaigns</h2>
                <p class="text-slate-600">Support our ongoing humanitarian initiatives</p>
            </div>
            <a href="<?php echo esc_url( home_url( '/appeals/' ) ); ?>" class="view-all">
                View All Campaigns
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>

        <div class="campaign-grid daan-campaigns">
            <?php
            // Owner, 2026-11-23 (D-037): only true facts; no raised/goal amounts or progress bars. Rates from the settings.
            $fk_paused = function_exists( 'daan_fk_hold_on' ) && daan_fk_hold_on();
            $campaigns = array(
                array( 'Community Kitchen', '100–120 people every day · ' . daan_menu_price( 'daan_meal_price', 60 ) . ' a meal', '/images/food-distribution-ramadan.jpg', '/community-kitchen/', '/product/community-kitchen/', 'Donate' ),
                array( 'Ramadan Iftar', '200–300 people every day in Ramadan · ' . daan_menu_price( 'daan_iftar_kit_price', 91 ) . ' a kit', '/images/iftaar-distribution.jpg', '/ramadan/', '/product/ramadan-iftar/', 'Donate' ),
                array( 'Ration Kit', daan_menu_price( 'daan_kit_price', 1536 ) . ' per kit, as Zakat or Sadaqah', '/images/ration-kit-front.jpg', '/ration-kit-distribution-india/', '/product/ration-kit-donation/', 'Donate' ),
                array( 'Zakat', 'Given only to eligible Muslim families, as their own', '/images/aid-distribution-elderly.jpg', '/zakat/', '/product/zakat/', 'Donate' ),
                array( 'Winter Appeal', 'Warm blankets and clothing for families in the cold', '/images/community-queue.jpg', '/winter-appeal/', '/donate/?cause=Winter%20Appeal', 'Donate' ),
                array( 'Fidyah & Kaffarah', 'Fidyah & Kaffarah: not accepted. Read our update and the rules.', '/images/extra-2.jpg', '/fidya/', '/fidya/', $fk_paused ? 'Read the rules' : 'Learn more' ),
            );
            foreach ( $campaigns as $c ) : ?>
                <div class="campaign-card">
                    <a href="<?php echo esc_url( home_url( $c[3] ) ); ?>" class="campaign-image-wrap" tabindex="-1" aria-hidden="true">
                        <img src="<?php echo esc_url( $c[2] ); ?>" alt="" loading="lazy">
                    </a>
                    <div class="campaign-body">
                        <h3><a href="<?php echo esc_url( home_url( $c[3] ) ); ?>"><?php echo esc_html( $c[0] ); ?></a></h3>
                        <p><?php echo esc_html( $c[1] ); ?></p>
                        <a href="<?php echo esc_url( home_url( $c[4] ) ); ?>" class="campaign-donate-btn"><?php echo esc_html( $c[5] ); ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="view-all-mobile">
            <a href="<?php echo esc_url( home_url( '/appeals/' ) ); ?>">
                View All Campaigns
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- IMPACT STATS -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="section section-dark">
    <div class="container">
        <div class="section-header">
            <h2 style="color:#fff">Our Impact</h2>
            <p style="color:#94A3B8">Together, we are making a meaningful difference in the lives of those who need it most.</p>
        </div>

        <div class="impact-grid">
            <?php
            $stat_icons = array(
                'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z',
                'M21 8l-9-5-9 5v8l9 5 9-5V8z M3 8l9 5 9-5 M12 13v8',
                'M12 2v4 M12 6l-3 3 M12 6l3 3 M4.93 4.93l1.41 1.41 M2 12h4 M18 12h4 M4.93 19.07l1.41-1.41 M17.66 17.66l1.41 1.41 M12 20v2',
                'M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2 M9 3a4 4 0 100 8 4 4 0 000-8z M23 21v-2a4 4 0 00-3-3.87 M16 3.13a4 4 0 010 7.75',
            );
            $stats = array(
                array( '100–120', 'People Fed Every Day', 'Community Kitchen in Amroha · Since 2020', '/images/food-distribution-ramadan.jpg', 0 ),
                array( '200–300', 'Iftar Every Day in Ramadan', 'People served iftar daily during Ramadan', '/images/iftaar-distribution.jpg', 1 ),
                array( '6+', 'Years of Experience', 'Serving communities with compassion since 2020', '/images/community-queue.jpg', 2 ),
                array( '12–15', 'Years of Team Experience', 'Founded in 2020 by a team experienced in community service', '/images/aid-distribution-elderly.jpg', 3 ),
            );
            foreach ( $stats as $s ) : ?>
                <div class="impact-card">
                    <div class="impact-card-bg">
                        <img src="<?php echo esc_url( $s[3] ); ?>" alt="<?php echo esc_attr( $s[1] ); ?>" loading="lazy">
                        <div class="overlay"></div>
                    </div>
                    <div class="impact-card-content">
                        <div class="impact-card-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $stat_icons[$s[4]]; ?>" />
                            </svg>
                        </div>
                        <div class="impact-card-number"><?php echo $s[0]; ?></div>
                        <div class="impact-card-label"><?php echo esc_html( $s[1] ); ?></div>
                        <p class="impact-card-desc"><?php echo esc_html( $s[2] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- EMERGENCY APPEAL — draft placement/content, to be finalised -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="section" style="padding-top:2rem;padding-bottom:2rem;">
    <div class="container">
        <div style="position:relative;border-radius:16px;overflow:hidden;box-shadow:0 1px 2px 0 rgba(0,0,0,0.05);min-height:320px;display:flex;align-items:flex-end;">
            <img src="<?php echo esc_url( home_url( '/images/aid-distribution-elderly.jpg' ) ); ?>" alt="Emergency Appeal — urgent relief distribution" loading="lazy" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
            <div class="gradient-overlay-dark" style="position:absolute;inset:0;"></div>
            <div style="position:relative;padding:2rem;max-width:32rem;">
                <span style="display:inline-block;background:#C2410C;color:#fff;border-radius:9999px;padding:4px 14px;font-size:0.75rem;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;margin-bottom:0.75rem;">Urgent</span>
                <h2 style="color:#fff;font-size:1.75rem;font-weight:800;margin:0 0 0.5rem;">Emergency Appeal</h2>
                <p style="color:rgba(255,255,255,0.9);margin:0 0 1.25rem;font-size:1rem;line-height:1.6;">Support our urgent relief efforts — help us respond quickly when it matters most.</p>
                <a href="<?php echo esc_url( home_url( '/appeals/' ) ); ?>"
                   style="display:inline-flex;align-items:center;gap:0.5rem;border-radius:9999px;background:#fff;padding:0.875rem 1.75rem;font-weight:700;color:#C2410C;text-decoration:none;box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);transition:box-shadow 0.2s;"
                   onmouseover="this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.1)'"
                   onmouseout="this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.1)'">
                    View Emergency Appeals
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- MISSION SECTION -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="section section-alt">
    <div class="container mission-grid">
        <div class="mission-image">
            <img src="/images/about-hero.jpg" alt="Our mission" width="800" height="600" loading="lazy">
            <div class="mission-badge">
                <div class="big">6+</div>
                <div class="small">Years of Service</div>
            </div>
        </div>
        <div class="mission-text">
            <h2>Serving Humanity With Compassion Since 2020</h2>
            <p>
                Daan Foundation is an India-based charitable organisation committed to helping
                poor, needy and vulnerable people through food support, community welfare and
                social assistance programmes. Our Community Kitchen in Amroha feeds 100–120 people
                every day, and during Ramadan we serve iftar to 200–300 people every day.
            </p>
            <div class="mission-stats">
                <div>
                    <div class="mission-stat-num">100–120</div>
                    <div class="mission-stat-label">People Fed Every Day · Since 2020</div>
                </div>
                <div>
                    <div class="mission-stat-num">200–300</div>
                    <div class="mission-stat-label">Iftar Every Day in Ramadan</div>
                </div>
            </div>
            <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"
               style="display:inline-flex;align-items:center;gap:0.5rem;font-weight:600;color:#C2410C;transition:gap 0.2s"
               onmouseover="this.style.gap='0.75rem'" onmouseout="this.style.gap='0.5rem'">
                Learn About Our Story
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- ZAKAT CALCULATOR — compact trigger; full calculator lives at /zakat-calculator -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="section section-warm">
    <div class="container" style="display:flex;justify-content:center;">
        <a href="<?php echo esc_url( home_url( '/zakat-calculator/' ) ); ?>" class="zakat-compact-card">
            <span class="zakat-compact-icon">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#F97316">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </span>
            <span class="zakat-compact-label">Zakat Calculator</span>
        </a>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- IMPACT STORIES -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="section section-alt">
    <div class="container">
        <div class="header-with-link">
            <div>
                <h2 class="h2" style="margin-bottom:0.5rem">How Your Donations Are Changing Lives</h2>
                <p class="text-slate-600">Real stories from the communities we serve</p>
            </div>
            <a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" class="view-all">
                View all stories
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>

        <div class="stories-grid">
            <?php
            $story_posts = get_posts( array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'posts_per_page' => 3,
                'category_name'  => 'blog',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ) );
            $story_ids              = wp_list_pluck( $story_posts, 'ID' );
            $story_fallback_images  = array(
                '/images/impact-story-1.jpg',
                '/images/impact-story-2.jpg',
                '/images/impact-story-3.jpg',
            );
            foreach ( $story_posts as $i => $story_post ) :
                $post_id   = $story_post->ID;
                $categories = get_the_category( $post_id );
                $cat_label  = $categories ? $categories[0]->name : 'Update';
                $thumb      = has_post_thumbnail( $post_id )
                    ? get_the_post_thumbnail_url( $post_id, 'medium_large' )
                    : $story_fallback_images[ $i % count( $story_fallback_images ) ];
                ?>
                <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="story-card">
                    <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy">
                    <div class="story-overlay"></div>

                    <div class="story-content">
                        <span class="story-category"><?php echo esc_html( $cat_label ); ?></span>
                        <h3><?php echo esc_html( wp_trim_words( get_the_title( $post_id ), 10, '…' ) ); ?></h3>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- LATEST NEWS -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="section section-alt">
    <div class="container">
        <div class="header-with-link">
            <div>
                <h2 class="h2" style="margin-bottom:0.5rem">Latest News</h2>
                <p class="text-slate-600">Updates from our work across India</p>
            </div>
            <a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" class="view-all">
                View All News
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>

        <div class="stories-grid">
            <?php
            $news_posts = get_posts( array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'posts_per_page' => 3,
                'category_name'  => 'blog',
                'orderby'        => 'date',
                'order'          => 'DESC',
                'post__not_in'   => $story_ids,
            ) );
            $news_fallback_images = array(
                '/images/news-1.jpg',
                '/images/news-2.jpg',
                '/images/news-3.jpg',
            );
            foreach ( $news_posts as $i => $news_post ) :
                $post_id = $news_post->ID;
                $thumb   = has_post_thumbnail( $post_id )
                    ? get_the_post_thumbnail_url( $post_id, 'medium_large' )
                    : $news_fallback_images[ $i % count( $news_fallback_images ) ];
                ?>
                <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="story-card">
                    <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy">
                    <div class="story-overlay"></div>
                    <div class="story-content">
                        <h3><?php echo esc_html( wp_trim_words( get_the_title( $post_id ), 10, '…' ) ); ?></h3>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- PHOTO GALLERY — Our Work in Action -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Our Work in Action</h2>
            <p>See the impact of your donations across India</p>
        </div>

        <div class="gallery-grid-1">
            <div class="gallery-featured">
                <img src="/images/hero-2.jpg" alt="Aid distribution" width="800" height="600" loading="lazy">
            </div>
            <div class="gallery-thumb">
                <img src="/images/campaign-1.jpg" alt="Campaign" width="800" height="600" loading="lazy">
            </div>
            <div class="gallery-thumb">
                <img src="/images/campaign-2.jpg" alt="Campaign" width="800" height="600" loading="lazy">
            </div>
            <div class="gallery-thumb">
                <img src="/images/campaign-3.jpg" alt="Campaign" width="800" height="600" loading="lazy">
            </div>
            <div class="gallery-thumb">
                <img src="/images/impact-1.jpg" alt="Impact" width="800" height="600" loading="lazy">
            </div>
        </div>

        <div class="gallery-grid-2">
            <img src="/images/news-1.jpg" alt="News" width="800" height="600" loading="lazy">
            <img src="/images/news-2.jpg" alt="News" width="800" height="600" loading="lazy">
            <img src="/images/news-3.jpg" alt="News" width="800" height="600" loading="lazy">
            <img src="/images/extra-6.jpg" alt="Community support" width="800" height="360" loading="lazy">
            <img src="/images/ration-kit-front.jpg" alt="Ration Kit" width="800" height="360" loading="lazy">
            <img src="/images/extra-7.jpg" alt="Charity work" width="800" height="360" loading="lazy">
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- FINAL CTA -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="section">
    <div class="container">
        <div class="cta-section" style="background-image:url('/images/hero-1.jpg');background-size:cover;background-position:center">
            <div class="cta-overlay"></div>
            <div class="cta-content">
                <h2>Make a Difference Today</h2>
                <p>Your donation can provide food, warmth, and hope to those in need across India. Every contribution matters.</p>
                <a href="<?php echo esc_url( home_url( '/donate/' ) ); ?>"
                   style="display:inline-flex;align-items:center;gap:0.5rem;border-radius:9999px;background:#fff;padding:1rem 2rem;font-weight:700;color:#C2410C;box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);transition:box-shadow 0.2s"
                   onmouseover="this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.1)'"
                   onmouseout="this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.1)'">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                    Donate Now
                </a>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
