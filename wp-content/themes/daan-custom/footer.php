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
                    <input type="email" id="newsletter-email" name="email" aria-label="Your email address" placeholder="Enter your email" required>
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
                        <img src="<?php echo esc_url( home_url( '/images/daan-foundation-logo-192.png' ) ); ?>"
                             alt=""
                             width="192" height="192" loading="lazy"
                             onerror="this.src='<?php echo esc_url( home_url( '/images/daan-foundation-logo-192.png' ) ); ?>'">
                        <div class="footer-logo-text">
                            <h3>Daan Foundation</h3>
                            <span>Serving humanity with compassion</span>
                        </div>
                    </a>
                    <div class="footer-contact">
                        <a href="tel:+919528206525">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            +91 95282 06525
                        </a>
                        <a href="<?php echo esc_url( daan_whatsapp_url() ); ?>" target="_blank" rel="noopener">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            WhatsApp: +91 95282 06525
                        </a>
                        <a href="mailto:daanfoundationindia@gmail.com">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            daanfoundationindia@gmail.com
                        </a>
                        <div style="display:flex;align-items:flex-start;gap:0.5rem">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1rem;height:1rem;margin-top:0.125rem;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Katkoi Plot No. 145, Amroha District, Uttar Pradesh, India 244221</span>
                        </div>
                    </div>
                </div>

                <!-- Appeals -->
                <div class="footer-col">
                    <h4>Appeals</h4>
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/community-kitchen/' ) ); ?>">Community Kitchen</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/ramadan/' ) ); ?>">Ramadan Iftar</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/winter-appeal/' ) ); ?>">Winter Appeal</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/where-most-needed/' ) ); ?>">Where Most Needed</a></li>
                    </ul>
                </div>

                <!-- Ways to Give -->
                <div class="footer-col">
                    <h4>Ways to Give</h4>
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/zakat/' ) ); ?>">Zakat</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/sadaqah/' ) ); ?>">Sadaqah</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/sadaqah-jariyah/' ) ); ?>">Sadaqah Jariyah</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/fidya/' ) ); ?>">Fidyah</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/kaffarah/' ) ); ?>">Kaffarah</a></li>
                    </ul>
                </div>

                <!-- Our Work -->
                <div class="footer-col">
                    <h4>Our Work</h4>
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/impact/' ) ); ?>">Our Impact</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/charity-in-action/' ) ); ?>">Your Charity in Action</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/community-trust/' ) ); ?>">Community Trust</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/history/' ) ); ?>">History</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/annual-report/' ) ); ?>">Annual Report</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/serving-with-dignity/' ) ); ?>">Serving With Dignity</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/supporting-women/' ) ); ?>">Supporting Women</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/donation-is-trust/' ) ); ?>">Donation Is a Trust</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/empowering-livelihoods/' ) ); ?>">Empowering Livelihoods</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/our-work/why-transparency/' ) ); ?>">Why Transparency Matters</a></li>
                    </ul>
                </div>

                <!-- About -->
                <div class="footer-col">
                    <h4>About</h4>
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About Us</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Us</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/donate/' ) ); ?>">Donate by UPI</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Pay with UPI (UPI only since 2026-10-27) -->
        <div class="footer-bank">
            <div class="container">
                <div class="upi-card">
                    <h4 class="upi-card-title">Pay with UPI</h4>
                    <img class="upi-card-qr" src="https://daanfoundation.in/wp-content/uploads/2026/08/QR-Code-SBI-Payment-Daan-Foundation.jpeg" alt="UPI QR code - Daan Foundation" loading="lazy" decoding="async">
                    <p class="upi-card-text">Scan the QR code with any UPI app to donate.</p>
                    <p class="upi-card-id"><span class="upi-card-label">UPI ID:</span> <span class="upi-card-value" id="footer-upi-id">sbibhim.instant90923460741799790@sbipay</span> <button type="button" class="upi-copy-btn" data-copy="sbibhim.instant90923460741799790@sbipay" aria-label="Copy UPI ID">Copy</button></p>
                    <p class="upi-card-contact">Contact: <a href="tel:+919528206525">+91 95282 06525</a></p>
                </div>
            </div>
        </div>
        <script>
        (function(){document.querySelectorAll('.upi-copy-btn').forEach(function(b){
        b.addEventListener('click',function(){var t=b.getAttribute('data-copy'),done=function(){b.textContent='Copied';setTimeout(function(){b.textContent='Copy';},2000);};
        if(navigator.clipboard&&window.isSecureContext){navigator.clipboard.writeText(t).then(done,function(){});}else{var x=document.createElement('textarea');x.value=t;x.setAttribute('readonly','');x.style.position='absolute';x.style.left='-9999px';document.body.appendChild(x);x.select();try{document.execCommand('copy');done();}catch(e){}document.body.removeChild(x);}});});})();
        </script>

        <!-- Bottom bar -->
        <div class="footer-bottom">
            <div class="container footer-bottom-inner">
                <div class="footer-legal">
                    <span>&copy; <?php echo date( 'Y' ); ?> Daan Foundation (Registered Trust) | Reg. No. 149/11-20/302 (Tehsil Amroha) | PAN: AAETD5465E</span>
                    <span class="sep">&bull;</span>
                    <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a>
                    <a href="<?php echo esc_url( home_url( '/terms-conditions/' ) ); ?>">Terms of Use</a>
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
