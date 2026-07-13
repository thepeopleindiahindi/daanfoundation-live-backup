<?php
/**
 * Template Name: Water for Life
 *
 * Water for Life page — split hero, stats, water project cards, CTA.
 */
get_header();
?>

<!-- Breadcrumbs -->
<div style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;">
	<div style="max-width:1280px;margin:0 auto;padding:12px 16px;">
		<nav style="display:flex;align-items:center;gap:8px;font-size:0.875rem;color:#64748B;">
			<a href="/" style="color:#64748B;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#EA580C'" onmouseout="this.style.color='#64748B'">Home</a>
			<span>/</span>
			<span style="color:#111827;font-weight:600;">Water for Life</span>
		</nav>
	</div>
</div>

<!-- Split Hero -->
<section style="background:#fff;">
	<div style="max-width:1280px;margin:0 auto;padding:48px 16px;">
		<div style="display:grid;grid-template-columns:1fr;gap:32px;align-items:center;">
			<style>@media (min-width:1024px){.water-hero-grid{grid-template-columns:1fr 1fr!important;}}</style>
			<div class="water-hero-grid" style="display:grid;grid-template-columns:1fr;gap:32px;align-items:center;">
				<div>
					<h1 style="font-size:2.25rem;font-weight:800;color:#111827;line-height:1.1;margin:0 0 16px;">Water for Life</h1>
					<blockquote style="font-size:1.125rem;font-weight:600;color:#F97316;font-style:italic;margin:0 0 16px;padding:0 0 0 16px;border-left:4px solid #F97316;">"The best charity is giving water to drink." <cite style="display:block;font-size:0.875rem;font-weight:400;color:#64748B;margin-top:4px;font-style:normal;">— Prophet Muhammad (PBUH)</cite></blockquote>
					<p style="font-size:1rem;color:#475569;line-height:1.625;margin:0 0 24px;">Millions of people around the world lack access to clean, safe drinking water. Your donation can build a well, provide water filtration, and save lives. Water is a Sadaqah Jariyah — an ongoing charity that benefits communities for generations.</p>
					<a href="/donate" style="display:inline-flex;align-items:center;gap:8px;border-radius:9999px;background:#F97316;padding:16px 32px;font-weight:700;color:#fff;text-decoration:none;box-shadow:0 20px 25px -5px rgba(249,115,22,0.3);transition:background 0.2s,transform 0.2s;"
					   onmouseover="this.style.background='#EA580C';this.style.transform='scale(1.02)'" onmouseout="this.style.background='#F97316';this.style.transform='scale(1)'">
					   Build a Well <span style="font-size:1.25rem;">→</span>
					</a>
				</div>
				<div>
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/impact-2.jpg' ); ?>" alt="Clean Water" width="800" height="600" loading="lazy" style="width:100%;border-radius:16px;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);" onerror="this.style.display='none'">
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Stats Section -->
<section style="background:#F3F4F6;padding:48px 16px;">
	<div style="max-width:1280px;margin:0 auto;">
		<div style="display:grid;grid-template-columns:1fr;gap:24px;text-align:center;">
			<style>@media (min-width:640px){.water-stats-grid{grid-template-columns:repeat(3,1fr)!important;}}</style>
			<div class="water-stats-grid" style="display:grid;grid-template-columns:1fr;gap:24px;">
				<div style="background:#fff;border-radius:16px;padding:32px 16px;box-shadow:0 1px 2px 0 rgba(0,0,0,0.05);">
					<div style="font-size:2.5rem;font-weight:800;color:#EA580C;margin:0 0 8px;">785M</div>
					<div style="font-size:0.9375rem;color:#475569;font-weight:600;">people lack clean water</div>
				</div>
				<div style="background:#fff;border-radius:16px;padding:32px 16px;box-shadow:0 1px 2px 0 rgba(0,0,0,0.05);">
					<div style="font-size:2.5rem;font-weight:800;color:#EA580C;margin:0 0 8px;">2B</div>
					<div style="font-size:0.9375rem;color:#475569;font-weight:600;">use contaminated water</div>
				</div>
				<div style="background:#fff;border-radius:16px;padding:32px 16px;box-shadow:0 1px 2px 0 rgba(0,0,0,0.05);">
					<div style="font-size:2.5rem;font-weight:800;color:#EA580C;margin:0 0 8px;">1,000</div>
					<div style="font-size:0.9375rem;color:#475569;font-weight:600;">children die daily from water diseases</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Water Projects Section -->
<section style="padding:48px 16px;">
	<div style="max-width:1280px;margin:0 auto;">
		<h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 32px;text-align:center;">Water Projects</h2>
		<div style="display:grid;grid-template-columns:1fr;gap:24px;">
			<style>@media (min-width:640px){.water-projects-grid{grid-template-columns:repeat(3,1fr)!important;}}</style>
			<div class="water-projects-grid" style="display:grid;grid-template-columns:1fr;gap:24px;">
				<!-- Hand Pump Well -->
				<div style="background:#fff;border-radius:16px;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);padding:24px;text-align:center;">
					<div style="width:64px;height:64px;border-radius:9999px;background:linear-gradient(135deg,#F97316,#EA580C);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
						<svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 2v4M6 6h12M8 10h8M7 18l1 4h8l1-4M5 10v8a2 2 0 002 2h10a2 2 0 002-2v-8M12 14v2"/>
						</svg>
					</div>
					<h3 style="font-size:1.25rem;font-weight:700;color:#111827;margin:0 0 8px;">Hand Pump Well</h3>
					<div style="display:inline-block;background:#FFF7ED;color:#EA580C;border-radius:9999px;padding:4px 12px;font-size:0.875rem;font-weight:700;margin-bottom:12px;">₹300</div>
					<p style="font-size:0.9375rem;color:#475569;margin:0;">Provides clean water to a family, reducing waterborne diseases and improving health.</p>
				</div>
				<!-- Solar Well -->
				<div style="background:#fff;border-radius:16px;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);padding:24px;text-align:center;">
					<div style="width:64px;height:64px;border-radius:9999px;background:linear-gradient(135deg,#F97316,#EA580C);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
						<svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
							<circle cx="12" cy="12" r="4"/>
							<path stroke-linecap="round" d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
						</svg>
					</div>
					<h3 style="font-size:1.25rem;font-weight:700;color:#111827;margin:0 0 8px;">Solar Well</h3>
					<div style="display:inline-block;background:#FFF7ED;color:#EA580C;border-radius:9999px;padding:4px 12px;font-size:0.875rem;font-weight:700;margin-bottom:12px;">₹3,000</div>
					<p style="font-size:0.9375rem;color:#475569;margin:0;">Solar-powered well providing sustainable clean water for an entire community.</p>
				</div>
				<!-- Water Tanker Distribution -->
				<div style="background:#fff;border-radius:16px;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);padding:24px;text-align:center;">
					<div style="width:64px;height:64px;border-radius:9999px;background:linear-gradient(135deg,#F97316,#EA580C);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
						<svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
							<rect x="3" y="7" width="14" height="10" rx="2"/>
							<path stroke-linecap="round" d="M17 9h2a2 2 0 012 2v4a2 2 0 01-2 2h-1M5 19a2 2 0 100-4 2 2 0 000 4zM16 19a2 2 0 100-4 2 2 0 000 4z"/>
						</svg>
					</div>
					<h3 style="font-size:1.25rem;font-weight:700;color:#111827;margin:0 0 8px;">Water Tanker Distribution</h3>
					<div style="display:inline-block;background:#FFF7ED;color:#EA580C;border-radius:9999px;padding:4px 12px;font-size:0.875rem;font-weight:700;margin-bottom:12px;">₹100</div>
					<p style="font-size:0.9375rem;color:#475569;margin:0;">Emergency water supply tanker distribution for drought-affected and crisis-hit areas.</p>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- CTA Section -->
<section style="padding:48px 16px;">
	<div style="max-width:1280px;margin:0 auto;">
		<div style="background:linear-gradient(135deg,#2563EB,#4338CA);border-radius:16px;padding:48px 32px;text-align:center;">
			<h2 style="font-size:1.875rem;font-weight:700;color:#fff;margin:0 0 16px;">Give the Gift of Clean Water — Sadaqah Jariyah</h2>
			<p style="font-size:1.125rem;color:rgba(255,255,255,0.9);margin:0 0 32px;max-width:576px;margin-left:auto;margin-right:auto;">Your donation provides clean, safe drinking water to families in need. A Sadaqah Jariyah that keeps giving.</p>
			<a href="/donate" style="display:inline-flex;align-items:center;gap:8px;border-radius:9999px;background:#fff;padding:16px 32px;font-weight:700;color:#2563EB;text-decoration:none;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);transition:transform 0.2s,box-shadow 0.2s;">Donate Now →</a>
		</div>
	</div>
</section>

<?php
get_footer();
