    </main>

    <footer id="colophon" class="site-footer">
        <!-- Newsletter -->
        <div class="newsletter">
            <div class="container newsletter-inner">
                <div>
                    <h3>Join Our Newsletter</h3>
                    <p>Stay updated on our campaigns, impact stories, and Islamic giving opportunities.</p>
                </div>
                <!-- Plugin shortcode placeholders (uncomment when plugin is configured) -->
                <!-- Mailchimp for WP: <?php echo do_shortcode('[mc4wp_form id="NEWSLETTER_FORM_ID"]'); ?> -->
                <!-- Newsletter plugin: <?php echo do_shortcode('[newsletter_form]'); ?> -->
                <form class="newsletter-form" id="daan-newsletter-form" onsubmit="return submitNewsletter(event)">
                    <input type="email" id="newsletter-email" name="email" placeholder="Enter your email" required>
                    <button type="submit" id="newsletter-submit-btn">Subscribe</button>
                </form>
                <div id="newsletter-msg" style="margin-top:8px;font-size:0.875rem;"></div>
            </div>
        </div>

        <!-- Main footer -->
        <div class="footer-main">
            <div class="container footer-grid">
                <!-- Logo & Contact -->
                <div class="footer-brand">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo-wrap">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/daan-foundation-logo.png' ); ?>"
                             alt="Daan Foundation"
                             width="280" height="80" loading="lazy"
                             onerror="this.src='<?php echo esc_url( home_url( '/images/daan-foundation-logo.png' ) ); ?>'">
                        <div class="footer-logo-text">
                            <h3>Daan Foundation</h3>
                            <span>Serving humanity with compassion</span>
                        </div>
                    </a>
                    <div class="footer-contact">
                        <a href="tel:+918899152910">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            +91 88991 52910
                        </a>
                        <a href="mailto:daanfoundationindia@gmail.com">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            daanfoundationindia@gmail.com
                        </a>
                        <div style="display:flex;align-items:flex-start;gap:0.5rem">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1rem;height:1rem;margin-top:0.125rem;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Katkoi Street, Near DiwanKhana,<br>Plot No. 141, District Amroha,<br>Uttar Pradesh - 244221, India</span>
                        </div>
                    </div>
                </div>

                <!-- Appeals -->
                <div class="footer-col">
                    <h4>Appeals</h4>
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/community-kitchen' ) ); ?>">Community Kitchen</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/ramadan' ) ); ?>">Ramadan Iftar</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/winter' ) ); ?>">Winter Appeal</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/where-most-needed' ) ); ?>">Where Most Needed</a></li>
                    </ul>
                </div>

                <!-- Ways to Give -->
                <div class="footer-col">
                    <h4>Ways to Give</h4>
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/zakat' ) ); ?>">Zakat</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/sadaqah' ) ); ?>">Sadaqah</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/sadaqah-jariyah' ) ); ?>">Sadaqah Jariyah</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/fidya' ) ); ?>">Fidyah</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/kaffarah' ) ); ?>">Kaffarah</a></li>
                    </ul>
                </div>

                <!-- Our Work -->
                <div class="footer-col">
                    <h4>Our Work</h4>
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/impact' ) ); ?>">Our Impact</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/charity-in-action' ) ); ?>">Your Charity in Action</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/community-trust' ) ); ?>">Community Trust</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/history' ) ); ?>">History</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/annual-report' ) ); ?>">Annual Report</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/serving-with-dignity' ) ); ?>">Serving With Dignity</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/supporting-women' ) ); ?>">Supporting Women</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/donation-is-trust' ) ); ?>">Donation Is a Trust</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/empowering-livelihoods' ) ); ?>">Empowering Livelihoods</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/why-transparency' ) ); ?>">Why Transparency Matters</a></li>
                    </ul>
                </div>

                <!-- About -->
                <div class="footer-col">
                    <h4>About</h4>
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About Us</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact Us</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/bank-details' ) ); ?>">Bank Details</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bank Details -->
        <div class="footer-bank">
            <div class="container bank-inner">
                <div class="bank-info">
                    <h4>
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Bank Details
                    </h4>
                    <div class="bank-details">
                        <span><span>Bank:</span> State Bank of India</span>
                        <span><span>A/C:</span> 42818355421</span>
                        <span><span>IFSC:</span> SBIN0003448</span>
                        <span><span>Branch:</span> Amroha, UP</span>
                        <span><span>UPI:</span> Coming Soon</span>
                    </div>
                </div>
                <div class="bank-qr">
                    <p>UPI: Coming Soon</p>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="footer-bottom">
            <div class="container footer-bottom-inner">
                <div class="footer-legal">
                    <span>&copy; <?php echo date( 'Y' ); ?> Daan Foundation. Registered Charity No. 124456</span>
                    <span class="sep">&bull;</span>
                    <a href="/privacy">Privacy Policy</a>
                    <a href="/terms">Terms of Use</a>
                </div>
                <!-- Social icons removed (M1/audit) -- pointed at generic platform homepages
                     since Daan Foundation has no real social accounts set up yet. An icon
                     promising a destination it can't deliver is worse than no icon; re-add
                     once real profile URLs exist. -->
            </div>
        </div>
    </footer>
</div>

<?php wp_footer(); ?>

<script>
function submitNewsletter(event) {
    event.preventDefault();
    var email = document.getElementById('newsletter-email').value.trim();
    var msg = document.getElementById('newsletter-msg');
    var btn = document.getElementById('newsletter-submit-btn');

    if (!email || !email.includes('@')) {
        msg.innerHTML = '<span style="color:#EF4444;">Please enter a valid email address.</span>';
        return false;
    }

    btn.textContent = 'Subscribing...';
    btn.disabled = true;

    var formData = new FormData();
    formData.append('action', 'daan_newsletter_signup');
    formData.append('email', email);
    formData.append('_wpnonce', '<?php echo wp_create_nonce( 'daan_newsletter' ); ?>');

    fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
        method: 'POST',
        body: formData
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            msg.innerHTML = '<span style="color:#10B981;">Thank you for subscribing!</span>';
            document.getElementById('newsletter-email').value = '';
        } else {
            msg.innerHTML = '<span style="color:#EF4444;">' + (data.data && data.data.message ? data.data.message : 'Subscription failed. Please try again.') + '</span>';
        }
        btn.textContent = 'Subscribe';
        btn.disabled = false;
    })
    .catch(function(err) {
        msg.innerHTML = '<span style="color:#EF4444;">An error occurred. Please try again later.</span>';
        btn.textContent = 'Subscribe';
        btn.disabled = false;
    });
    return false;
}
</script>

</body>
</html>
