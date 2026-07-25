<?php
/**
 * Template Name: Contact Us
 *
 * Contact page with info, form, and FAQ CTA.
 * Plugin placeholders:
 *   - WPForms: [wpforms id="CONTACT_FORM_ID" title="false"]
 *   - Forminator: [forminator_form id="CONTACT_FORM_ID"]
 */
get_header();
?>

<!-- Breadcrumbs -->
<div style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;">
	<div style="max-width:1280px;margin:0 auto;padding:12px 16px;">
		<nav style="display:flex;align-items:center;gap:8px;font-size:0.875rem;color:#64748B;">
			<a href="/" style="color:#64748B;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#EA580C'" onmouseout="this.style.color='#64748B'">Home</a>
			<span>/</span>
			<span style="color:#111827;font-weight:600;">Contact Us</span>
		</nav>
	</div>
</div>

<!-- Hero Banner -->
<section style="background:linear-gradient(135deg, #EA580C, #F97316);position:relative;overflow:hidden;">
	<div style="position:relative;max-width:1280px;margin:0 auto;padding:48px 16px;">
		<div style="max-width:768px;">
			<h1 style="font-size:2.25rem;font-weight:800;color:#fff;line-height:1.1;margin:0 0 16px;">Get in Touch</h1>
			<p style="font-size:1.125rem;color:rgba(255,255,255,0.9);line-height:1.625;max-width:576px;margin:0;">We're here to help. Reach out to us with any questions, feedback, or inquiries.</p>
		</div>
	</div>
</section>

<!-- Contact Section -->
<div style="max-width:1280px;margin:0 auto;padding:48px 16px;">
	<div style="display:grid;grid-template-columns:1fr;gap:32px;">
		<style>
			@media (min-width: 1024px) {
				.contact-grid { grid-template-columns: 1fr 2fr !important; }
			}
		</style>
	</div>

	<div class="contact-grid" style="display:grid;grid-template-columns:1fr;gap:32px;align-items:start;">

		<!-- Left Column (1/3) - Contact Info -->
		<div>
			<h2 style="font-size:1.5rem;font-weight:700;color:#111827;margin:0 0 24px;">Contact Information</h2>

			<div style="display:flex;flex-direction:column;gap:24px;">
				<!-- Registered Office -->
				<div style="display:flex;gap:12px;">
					<div style="width:44px;height:44px;border-radius:12px;background:#FFF7ED;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
						<svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#F97316">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
						</svg>
					</div>
					<div>
						<h4 style="font-size:1rem;font-weight:700;color:#111827;margin:0 0 4px;">Registered Office</h4>
						<p style="font-size:0.9375rem;color:#475569;margin:0;text-align:left;">Katkoi Street, Near DiwanKhana, Plot No. 141, District Amroha, Uttar Pradesh - 244221, India</p>
					</div>
				</div>

				<!-- Phone -->
				<div style="display:flex;gap:12px;">
					<div style="width:44px;height:44px;border-radius:12px;background:#FFF7ED;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
						<svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#F97316">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
						</svg>
					</div>
					<div>
						<h4 style="font-size:1rem;font-weight:700;color:#111827;margin:0 0 4px;">Phone</h4>
						<a href="tel:+918899152910" style="font-size:0.9375rem;color:#F97316;text-decoration:none;font-weight:600;">+91 88991 52910</a>
					</div>
				</div>

				<!-- Email -->
				<div style="display:flex;gap:12px;">
					<div style="width:44px;height:44px;border-radius:12px;background:#FFF7ED;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
						<svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#F97316">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
						</svg>
					</div>
					<div>
						<h4 style="font-size:1rem;font-weight:700;color:#111827;margin:0 0 4px;">Email</h4>
						<a href="mailto:daanfoundationindia@gmail.com" style="font-size:0.9375rem;color:#F97316;text-decoration:none;font-weight:600;">daanfoundationindia@gmail.com</a>
					</div>
				</div>

				<!-- Office Hours -->
				<div style="display:flex;gap:12px;">
					<div style="width:44px;height:44px;border-radius:12px;background:#FFF7ED;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
						<svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#F97316">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
						</svg>
					</div>
					<div>
						<h4 style="font-size:1rem;font-weight:700;color:#111827;margin:0 0 4px;">Office Hours</h4>
						<p style="font-size:0.9375rem;color:#475569;margin:0;text-align:left;">Mon-Fri: 9am - 5pm<br>Sat-Sun: Closed</p>
					</div>
				</div>
			</div>
		</div>

		<!-- Right Column (2/3) - Contact Form -->
		<div style="background:#F3F4F6;border-radius:16px;padding:32px;">
			<h2 style="font-size:1.5rem;font-weight:700;color:#111827;margin:0 0 24px;">Send Us a Message</h2>

			<!-- Plugin shortcode placeholders (uncomment when plugin is configured) -->
			<!-- WPForms: <?php echo do_shortcode('[wpforms id="CONTACT_FORM_ID" title="false"]'); ?> -->
			<!-- Forminator: <?php echo do_shortcode('[forminator_form id="CONTACT_FORM_ID"]'); ?> -->

			<div id="contact-form-wrapper">
				<form id="daan-contact-form" method="post" onsubmit="return submitContactForm(event)">
					<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
						<div>
							<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">First Name *</label>
							<input type="text" id="contact-first" name="first_name" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;background:#fff;transition:border-color 0.2s;">
						</div>
						<div>
							<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Last Name *</label>
							<input type="text" id="contact-last" name="last_name" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;background:#fff;transition:border-color 0.2s;">
						</div>
					</div>

					<div style="margin-bottom:16px;">
						<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Email Address *</label>
						<input type="email" id="contact-email" name="email" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;background:#fff;transition:border-color 0.2s;">
					</div>

					<div style="margin-bottom:16px;">
						<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Subject *</label>
						<input type="text" id="contact-subject" name="subject" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;background:#fff;transition:border-color 0.2s;">
					</div>

					<div style="margin-bottom:24px;">
						<label style="display:block;font-size:0.875rem;font-weight:600;color:#334155;margin-bottom:6px;">Message *</label>
						<textarea id="contact-message" name="message" rows="5" style="width:100%;border-radius:12px;border:2px solid #E2E8F0;padding:12px 16px;font-size:1rem;color:#111;background:#fff;font-family:inherit;resize:vertical;transition:border-color 0.2s;"></textarea>
					</div>

					<?php wp_nonce_field( 'daan_contact', 'daan_contact_nonce' ); ?>

					<button type="submit" id="contact-submit-btn" style="width:100%;border-radius:12px;background:#F97316;color:#fff;padding:14px 0;font-size:1.125rem;font-weight:700;border:none;cursor:pointer;box-shadow:0 4px 6px -1px rgba(249,115,22,0.3);transition:background 0.2s;">Send Message</button>
				</form>
			</div>

			<!-- Success state -->
			<div id="contact-success" style="display:none;text-align:center;padding:32px 0;">
				<div style="width:64px;height:64px;border-radius:9999px;background:#ECFDF5;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
					<svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="#10B981">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
					</svg>
				</div>
				<h3 style="font-size:1.25rem;font-weight:700;color:#111827;margin:0 0 8px;">Message Sent!</h3>
				<p style="font-size:0.9375rem;color:#64748B;margin:0;">Thank you for reaching out. We'll get back to you as soon as possible.</p>
			</div>
		</div>
	</div>
</div>

<!-- FAQ CTA -->
<div style="background:#F1F5F9;padding:48px 16px;">
	<div style="max-width:640px;margin:0 auto;text-align:center;">
		<h2 style="font-size:1.5rem;font-weight:700;color:#111827;margin:0 0 12px;">Looking for Quick Answers?</h2>
		<p style="font-size:1rem;color:#475569;margin:0 0 24px;">Check out our frequently asked questions for instant answers.</p>
		<a href="/faq" style="display:inline-flex;align-items:center;gap:8px;border-radius:9999px;border:2px solid #E2E8F0;background:#fff;padding:14px 32px;font-weight:700;color:#334155;text-decoration:none;transition:border-color 0.2s,color 0.2s;"
		   onmouseover="this.style.borderColor='#F97316';this.style.color='#EA580C'" onmouseout="this.style.borderColor='#E2E8F0';this.style.color='#334155'">
			View FAQs
			<svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
			</svg>
		</a>
	</div>
</div>

<script>
function submitContactForm(event) {
	event.preventDefault();
	var first = document.getElementById('contact-first').value.trim();
	var last = document.getElementById('contact-last').value.trim();
	var email = document.getElementById('contact-email').value.trim();
	var subject = document.getElementById('contact-subject').value.trim();
	var message = document.getElementById('contact-message').value.trim();

	if (!first || !last) { alert('Please enter your full name.'); return false; }
	if (!email || !email.includes('@')) { alert('Please enter a valid email address.'); return false; }
	if (!subject) { alert('Please enter a subject.'); return false; }
	if (!message) { alert('Please enter your message.'); return false; }

	var btn = document.getElementById('contact-submit-btn');
	btn.textContent = 'Sending...';
	btn.style.opacity = '0.7';
	btn.disabled = true;

	var form = document.getElementById('daan-contact-form');
	var formData = new FormData(form);
	formData.append('action', 'daan_contact_form');

	fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
		method: 'POST',
		body: formData
	})
	.then(function(res) { return res.json(); })
	.then(function(data) {
		if (data.success) {
			document.getElementById('contact-form-wrapper').style.display = 'none';
			document.getElementById('contact-success').style.display = 'block';
		} else {
			alert(data.data && data.data.message ? data.data.message : 'There was an error. Please try again.');
			btn.textContent = 'Send Message';
			btn.style.opacity = '1';
			btn.disabled = false;
		}
	})
	.catch(function(err) {
		alert('There was an error sending your message. Please try again later.');
		btn.textContent = 'Send Message';
		btn.style.opacity = '1';
		btn.disabled = false;
	});
	return false;
}
</script>

<?php
get_footer();
