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
<section class="hero">
    <picture class="hero-picture">
        <source media="(max-width: 767px)" srcset="<?php echo esc_url( '/images/hero-mobile.jpg' ); ?>">
        <img class="hero-img" src="<?php echo esc_url( '/images/hero-new-banner.webp' ); ?>" alt="No one should sleep hungry — Daan Foundation">
    </picture>

    <div class="hero-overlay-bottom"></div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- DONATION WIDGET — below the hero image, no overlap -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="section hero-donate-section">
    <div class="container" style="display:flex;justify-content:center;">
        <div class="donation-widget">
            <h3>Make a Donation</h3>
            <p class="widget-sub">Every contribution makes a difference</p>

            <div class="amount-grid">
                <?php foreach ( array( 500, 1000, 2500, 5000 ) as $amount ) : ?>
                    <button class="amount-btn <?php echo $amount === 1000 ? 'active' : ''; ?>"
                            onclick="selectAmount(this, <?php echo $amount; ?>)">
                        ₹<?php echo $amount; ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="custom-amount-wrap">
                <span class="currency">₹</span>
                <input type="number" class="custom-amount" placeholder="Other amount"
                       oninput="clearAmounts(this)">
            </div>

            <div class="cause-select">
                <label for="donate-cause">Select a Cause</label>
                <select id="donate-cause">
                    <option>Where Most Needed</option>
                    <option>Community Kitchen</option>
                    <option>Ramadan Iftar</option>
                    <option>Zakat</option>
                    <option>Sadaqah</option>
                </select>
            </div>

            <button class="donate-now-btn" onclick="handleDonate()">Donate Now</button>

            <div class="trust-indicators">
                <span class="trust-item">
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                    Secure
                </span>
                <span>&bull;</span>
                <span>Registered Charity</span>
                <span>&bull;</span>
                <span>100% Transparent</span>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- QUICK ACTIONS — Maximise Your Reward -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="section">
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
                array( 'Community Kitchen', 'Feed the hungry — ₹59 provides one meal', '/community-kitchen', 'linear-gradient(135deg, #F59E0B, #EA580C)', 0 ),
                array( 'Fidyah & Kaffarah', 'Fulfil your Islamic obligation by feeding the needy', '/fidya', 'linear-gradient(135deg, #8B5CF6, #7C3AED)', 1 ),
                array( 'Ramadan Iftar Appeal', 'Iftar meals for those fasting in need', '/ramadan', 'linear-gradient(135deg, #F43F5E, #E11D48)', 2 ),
                array( 'Ration Kit Distribution', 'Essential food rations for poor families', '/where-most-needed', 'linear-gradient(135deg, #06B6D4, #0D9488)', 3 ),
                array( 'Zakat', 'Calculate and pay your Zakat accurately', '/zakat', 'linear-gradient(135deg, #F97316, #EA580C)', 4 ),
                array( 'Sadaqah', 'Earn ongoing rewards with voluntary charity', '/sadaqah', 'linear-gradient(135deg, #3B82F6, #4F46E5)', 5 ),
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
            <a href="<?php echo esc_url( home_url( '/appeals' ) ); ?>" class="view-all">
                View All Campaigns
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>

        <div class="campaign-grid">
            <?php
            $campaigns = array(
                array( 'Community Kitchen', 'Free daily meals for people in need — serving with dignity since 2020', '/images/food-distribution-ramadan.jpg', 250000, 500000, '/community-kitchen' ),
                array( 'Ration Kits Distribution', 'Essential food ration kits for poor families and vulnerable communities', '/images/ration-kit-front.jpg', 120000, 250000, '/where-most-needed' ),
                array( 'Education Support', 'Helping poor children continue education and supporting families with school needs', '/images/aid-distribution-elderly.jpg', 85000, 200000, '/our-work/impact' ),
                array( 'Fidyah & Kaffarah', 'Feed the needy through Fidyah and Kaffarah — fulfil your Islamic obligation', '/images/iftaar-distribution.jpg', 180000, 300000, '/fidya' ),
            );
            foreach ( $campaigns as $c ) :
                $progress = round( ( $c[3] / $c[4] ) * 100 );
            ?>
                <a href="<?php echo esc_url( home_url( $c[5] ) ); ?>" class="campaign-card">
                    <div class="campaign-image-wrap">
                        <img src="<?php echo esc_url( $c[2] ); ?>" alt="<?php echo esc_attr( $c[0] ); ?>" loading="lazy">
                        <div class="campaign-overlay"></div>
                        <div class="campaign-progress">
                            <div class="campaign-progress-text">
                                <span class="raised">₹<?php echo number_format( $c[3] ); ?></span>
                                <span class="percent"><?php echo $progress; ?>%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width:<?php echo $progress; ?>%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="campaign-body">
                        <h3><?php echo esc_html( $c[0] ); ?></h3>
                        <p><?php echo esc_html( $c[1] ); ?></p>
                        <span class="campaign-link">
                            Donate now
                            <svg class="arrow" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="view-all-mobile">
            <a href="<?php echo esc_url( home_url( '/appeals' ) ); ?>">
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
                'M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z',
                'M12 2v4 M12 6l-3 3 M12 6l3 3 M4.93 4.93l1.41 1.41 M2 12h4 M18 12h4 M4.93 19.07l1.41-1.41 M17.66 17.66l1.41 1.41 M12 20v2',
                'M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2 M9 3a4 4 0 100 8 4 4 0 000-8z M23 21v-2a4 4 0 00-3-3.87 M16 3.13a4 4 0 010 7.75',
            );
            $stats = array(
                array( '500K+', 'Food Packets Distributed', 'Meals and food packets served since 2020', '/images/food-distribution-ramadan.jpg', 0 ),
                array( '100K+', 'Iftar Kits Distributed', 'Food and Iftar kits provided during Ramadan', '/images/iftaar-distribution.jpg', 1 ),
                array( '6+', 'Years of Experience', 'Serving communities with compassion since 2020', '/images/community-queue.jpg', 2 ),
                array( '600K+', 'Beneficiaries Reached', 'Total lives touched across India', '/images/aid-distribution-elderly.jpg', 3 ),
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
                <span style="display:inline-block;background:var(--primary);color:#fff;border-radius:9999px;padding:4px 14px;font-size:0.75rem;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;margin-bottom:0.75rem;">Urgent</span>
                <h2 style="color:#fff;font-size:1.75rem;font-weight:800;margin:0 0 0.5rem;">Emergency Appeal</h2>
                <p style="color:rgba(255,255,255,0.9);margin:0 0 1.25rem;font-size:1rem;line-height:1.6;">Support our urgent relief efforts — help us respond quickly when it matters most.</p>
                <a href="<?php echo esc_url( home_url( '/appeals' ) ); ?>"
                   style="display:inline-flex;align-items:center;gap:0.5rem;border-radius:9999px;background:#fff;padding:0.875rem 1.75rem;font-weight:700;color:var(--primary);text-decoration:none;box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);transition:box-shadow 0.2s;"
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
<!-- OUR PROGRAMS -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Our Programs</h2>
            <p>Supporting communities through sustainable development</p>
        </div>

        <div class="program-grid">
            <!-- Program 1 — Community Kitchen -->
            <a href="<?php echo esc_url( home_url( '/community-kitchen' ) ); ?>" class="program-card">
                <img src="/images/food-distribution-ramadan.jpg" alt="Community Kitchen" width="800" height="600" loading="lazy">
                <div class="program-overlay"></div>
                <div class="program-content">
                    <span class="program-badge" style="background:#F97316">₹59/meal</span>
                    <h3>Community Kitchen</h3>
                    <p>Free daily meals served with dignity</p>
                </div>
            </a>

            <!-- Program 2 — Ration Kit Distribution -->
            <a href="<?php echo esc_url( home_url( '/where-most-needed' ) ); ?>" class="program-card">
                <img src="/images/extra-5.jpg" alt="Ration Kit Distribution" width="800" height="360" loading="lazy">
                <div class="program-overlay"></div>
                <div class="program-content">
                    <span class="program-badge" style="background:#F59E0B">Essential Aid</span>
                    <h3>Ration Kit Distribution</h3>
                    <p>Essential food rations for poor families</p>
                </div>
            </a>

            <!-- Program 3 — Fidyah & Kaffarah -->
            <a href="<?php echo esc_url( home_url( '/fidya' ) ); ?>" class="program-card md-span-2">
                <img src="/images/iftaar-distribution.jpg" alt="Fidyah & Kaffarah" width="800" height="600" loading="lazy">
                <div class="program-overlay"></div>
                <div class="program-content">
                    <span class="program-badge" style="background:#8B5CF6">Islamic Giving</span>
                    <h3>Fidyah & Kaffarah</h3>
                    <p>Fulfil your obligation by feeding the needy</p>
                </div>
            </a>
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
                social assistance programmes. By strengthening our community kitchen and outreach
                programs, we aim to serve 25,000 beneficiaries annually.
            </p>
            <div class="mission-stats">
                <div>
                    <div class="mission-stat-num">500K+</div>
                    <div class="mission-stat-label">Meals Distributed</div>
                </div>
                <div>
                    <div class="mission-stat-num">600K+</div>
                    <div class="mission-stat-label">Beneficiaries Reached</div>
                </div>
            </div>
            <a href="<?php echo esc_url( home_url( '/about' ) ); ?>"
               style="display:inline-flex;align-items:center;gap:0.5rem;font-weight:600;color:var(--primary);transition:gap 0.2s"
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
<!-- ISLAMIC GIVING — Maximise Your Reward -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Maximise Your Reward</h2>
            <p>Choose a cause and earn blessings through your generosity</p>
        </div>

        <div class="islamic-grid">
            <?php
            $islamic_icons = array(
                'M3 2v7c0 1.1.9 2 2 2h4a2 2 0 002-2V2 M7 2v20 M14 2v20h4a2 2 0 002-2V2',
                'M12 2v2 M6.5 12l5.5-5.5 5.5 5.5 M3 21h18 M3 21l4-8 M21 21l-4-8',
                'M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z',
                'M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z M3 6h18 M16 10a4 4 0 01-8 0',
                'M4 2h16a2 2 0 012 2v16a2 2 0 01-2 2H4a2 2 0 01-2-2V4a2 2 0 012-2z M8 6h8 M8 10h8 M8 14h5 M16 14h1 M8 18h8 M16 18h1',
                'M16 7a4 4 0 11-8 0 4 4 0 018 0z M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
            );
            $islamic = array(
                array( 'Community Kitchen', 'Support our daily free meal program for the needy.', '/community-kitchen', '#FED7AA', '#F97316', 0 ),
                array( 'Fidyah & Kaffarah', 'Fulfil your Islamic obligation by feeding the needy.', '/fidya', '#FECDD3', '#E11D48', 1 ),
                array( 'Ramadan Iftar Appeal', 'Provide iftar meals to fasting families during Ramadan.', '/ramadan', '#DDD6FE', '#7C3AED', 2 ),
                array( 'Ration Kit Distribution', 'Essential food rations for struggling families.', '/where-most-needed', '#FDE68A', '#D97706', 3 ),
                array( 'Zakat', 'Fulfil your 2.5% obligation and purify your wealth.', '/zakat', '#A7F3D0', '#059669', 4 ),
                array( 'Sadaqah', 'Give voluntary charity and earn continuous rewards.', '/sadaqah', '#CFFAFE', '#0891B2', 5 ),
            );
            foreach ( $islamic as $i ) : ?>
                <a href="<?php echo esc_url( home_url( $i[2] ) ); ?>" class="islamic-card">
                    <div class="islamic-card-icon" style="background:<?php echo $i[3]; ?>">
                        <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="<?php echo $i[4]; ?>">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $islamic_icons[$i[5]]; ?>" />
                        </svg>
                    </div>
                    <h3><?php echo esc_html( $i[0] ); ?></h3>
                    <p><?php echo esc_html( $i[1] ); ?></p>
                    <span class="learn-more">
                        Learn More
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- ZAKAT CALCULATOR -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="section section-warm">
    <div class="container zakat-grid">
        <div class="zakat-text">
            <h2>Calculate Your Zakat</h2>
            <p>Use our simple Zakat calculator to determine your obligation. We'll help ensure your Zakat reaches those who need it most.</p>
            <ul class="zakat-features">
                <li><span class="zakat-dot"></span> Easy-to-use calculator</li>
                <li><span class="zakat-dot"></span> Updated Nisab values</li>
                <li><span class="zakat-dot"></span> 100% Zakat policy</li>
            </ul>
            <a href="<?php echo esc_url( home_url( '/zakat-calculator' ) ); ?>"
               style="display:inline-flex;align-items:center;gap:0.5rem;margin-top:1.5rem;font-weight:600;color:var(--primary);transition:gap 0.2s"
               onmouseover="this.style.gap='0.75rem'" onmouseout="this.style.gap='0.5rem'">
                Calculate Now
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
        <div>
            <div style="background:#fff;border-radius:16px;padding:2rem;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);text-align:center">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#F97316" style="margin-bottom:1rem">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                <p style="color:#64748B;margin:0 0 1rem;font-size:0.9375rem;">Use our simple Zakat calculator to determine your obligation instantly.</p>
                <a href="<?php echo esc_url( home_url( '/zakat-calculator' ) ); ?>"
                   style="display:inline-flex;align-items:center;gap:0.5rem;font-weight:700;color:#EA580C;text-decoration:none;transition:gap 0.2s"
                   onmouseover="this.style.gap='0.75rem'" onmouseout="this.style.gap='0.5rem'">
                    Open Calculator
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
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
            <a href="<?php echo esc_url( home_url( '/news' ) ); ?>" class="view-all">
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
                    <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $post_id ) ); ?>" loading="lazy">
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
            <a href="<?php echo esc_url( home_url( '/news' ) ); ?>" class="view-all">
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
                    <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $post_id ) ); ?>" loading="lazy">
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
                <a href="<?php echo esc_url( home_url( '/donate' ) ); ?>"
                   style="display:inline-flex;align-items:center;gap:0.5rem;border-radius:9999px;background:#fff;padding:1rem 2rem;font-weight:700;color:var(--primary);box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);transition:box-shadow 0.2s"
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
