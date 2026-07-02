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
                        <span><span>UPI:</span> 8899152910@ptsbi</span>
                    </div>
                </div>
                <div class="bank-qr">
                    <p>Scan to Pay via UPI</p>
                    <img src="<?php echo esc_url( home_url( '/images/upi-qr-code.jpg' ) ); ?>"
                         alt="UPI QR Code - Daan Foundation"
                         width="200" height="200" loading="lazy"
                         onerror="this.style.display='none'">
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
                <div class="footer-social">
                    <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                        <svg fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg>
                    </a>
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                        <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 016.11 2.525c.636-.247 1.363-.416 2.427-.465C8.83 2.013 9.175 2 12.315 2z"/><path d="M12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.565a3.57 3.57 0 100 7.14 3.57 3.57 0 000-7.14zM18.405 4.715a1.08 1.08 0 110 2.16 1.08 1.08 0 010-2.16z"/></svg>
                    </a>
                    <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                        <svg fill="currentColor" viewBox="0 0 24 24"><path d="M23.5 6.19a3.02 3.02 0 00-2.12-2.14C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.38.55A3.02 3.02 0 00.5 6.19 31.6 31.6 0 000 12a31.6 31.6 0 00.5 5.81 3.02 3.02 0 002.12 2.14c1.88.55 9.38.55 9.38.55s7.5 0 9.38-.55a3.02 3.02 0 002.12-2.14A31.6 31.6 0 0024 12a31.6 31.6 0 00-.5-5.81zM9.55 15.57V8.43L15.82 12l-6.27 3.57z"/></svg>
                    </a>
                    <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                        <svg fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</div>

<?php
/**
 * Website Update Notification Modal
 *
 * Toggle: Set DAAN_SHOW_UPDATE_MODAL to false to disable the popup
 * after the website update is complete.
 */
if ( ! defined( 'DAAN_SHOW_UPDATE_MODAL' ) ) {
    define( 'DAAN_SHOW_UPDATE_MODAL', true );
}

if ( DAAN_SHOW_UPDATE_MODAL ) :
?>
<div id="daan-update-modal" class="daan-modal-overlay" role="dialog" aria-modal="true" aria-label="Website Update Notice">
    <div class="daan-modal-card">
        <button class="daan-modal-close" aria-label="Close">&times;</button>
        <div class="daan-modal-icon">&#128679;</div>
        <h2 class="daan-modal-title">Website Update in Progress</h2>
        <p class="daan-modal-text">
            We are currently updating our website. During this period, some information may be
            incomplete or inaccurate, and <strong>UPI payments may not work properly</strong>
            due to ongoing maintenance.
        </p>
        <p class="daan-modal-text">We are working to resolve these issues as quickly as possible.</p>
        <div class="daan-modal-contact">
            <p><strong>Contact Us</strong></p>
            <p>&#9993; <a href="mailto:Daanfoundationindia@gmail.com">Daanfoundationindia@gmail.com</a></p>
            <p>&#9742; <a href="tel:+918899152910">+91 88991 52910</a></p>
        </div>
        <p class="daan-modal-thanks">Thank you for your patience and support.</p>
        <button class="daan-modal-ok">OK</button>
    </div>
</div>
<?php endif; ?>

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
