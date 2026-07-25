<?php
/**
 * Template Name: Where We Work
 *
 * Where We Work page — hero, global stats, regions grid, featured project, CTA.
 */
get_header();
?>

<!-- Breadcrumbs -->
<div style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;">
	<div style="max-width:1280px;margin:0 auto;padding:12px 16px;">
		<nav style="display:flex;align-items:center;gap:8px;font-size:0.875rem;color:#64748B;">
			<a href="/" style="color:#64748B;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#EA580C'" onmouseout="this.style.color='#64748B'">Home</a>
			<span>/</span>
			<span style="color:#111827;font-weight:600;">Where We Work</span>
		</nav>
	</div>
</div>

<!-- Hero -->
<section style="background:linear-gradient(135deg,#1E293B,#334155);padding:64px 16px;text-align:center;">
	<div style="max-width:768px;margin:0 auto;">
		<div style="width:64px;height:64px;border-radius:16px;background:rgba(249,115,22,0.2);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
			<svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="#FB923C" stroke-width="2">
				<circle cx="12" cy="12" r="10"/>
				<ellipse cx="12" cy="12" rx="4" ry="10"/>
				<path stroke-linecap="round" d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/>
			</svg>
		</div>
		<h1 style="font-size:2.25rem;font-weight:800;color:#fff;line-height:1.1;margin:0 0 16px;">Where We Work</h1>
		<p style="font-size:1.125rem;color:rgba(255,255,255,0.9);margin:0;">Serving vulnerable communities across India with compassion and dignity</p>
	</div>
</section>

<!-- Global Stats -->
<section style="background:#EA580C;padding:48px 16px;">
	<div style="max-width:1280px;margin:0 auto;">
		<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;text-align:center;">
			<style>@media (min-width:640px){.ww-stats-grid{grid-template-columns:repeat(4,1fr)!important;}}</style>
			<div class="ww-stats-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
				<div>
					<div style="font-size:2.5rem;font-weight:800;color:#fff;margin:0 0 4px;">6+</div>
					<div style="font-size:0.9375rem;color:rgba(255,255,255,0.85);">States Covered</div>
				</div>
				<div>
					<div style="font-size:2.5rem;font-weight:800;color:#fff;margin:0 0 4px;">600K+</div>
					<div style="font-size:0.9375rem;color:rgba(255,255,255,0.85);">Beneficiaries Reached</div>
				</div>
				<div>
					<div style="font-size:2.5rem;font-weight:800;color:#fff;margin:0 0 4px;">6+</div>
					<div style="font-size:0.9375rem;color:rgba(255,255,255,0.85);">Years of Service</div>
				</div>
				<div>
					<div style="font-size:2.5rem;font-weight:800;color:#fff;margin:0 0 4px;">500K+</div>
					<div style="font-size:0.9375rem;color:rgba(255,255,255,0.85);">Meals Distributed</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Regions Grid -->
<section style="padding:48px 16px;">
	<div style="max-width:1280px;margin:0 auto;">
		<h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 32px;text-align:center;">Our Regions</h2>
		<div style="display:grid;grid-template-columns:1fr;gap:24px;">
			<style>@media (min-width:640px){.regions-grid{grid-template-columns:repeat(2,1fr)!important;}}</style>
			<div class="regions-grid" style="display:grid;grid-template-columns:1fr;gap:24px;">
				<!-- Uttar Pradesh (Headquarters) -->
				<div style="background:#F8FAFC;border-radius:16px;padding:24px;">
					<h3 style="font-size:1.25rem;font-weight:700;color:#111827;margin:0 0 12px;">Uttar Pradesh — Headquarters</h3>
					<div style="display:flex;flex-wrap:wrap;gap:8px;">
						<?php
						$up = array( 'Amroha', 'Moradabad', 'Sambhal', 'Rampur' );
						foreach ( $up as $c ) : ?>
							<span style="background:#FFF7ED;color:#9A3412;border-radius:9999px;padding:4px 12px;font-size:0.8125rem;font-weight:600;"><?php echo esc_html( $c ); ?></span>
						<?php endforeach; ?>
					</div>
				</div>
				<!-- South India -->
				<div style="background:#F8FAFC;border-radius:16px;padding:24px;">
					<h3 style="font-size:1.25rem;font-weight:700;color:#111827;margin:0 0 12px;">South India</h3>
					<div style="display:flex;flex-wrap:wrap;gap:8px;">
						<?php
						$south = array( 'Tamil Nadu', 'Karnataka', 'Kerala', 'Andhra Pradesh', 'Telangana' );
						foreach ( $south as $c ) : ?>
							<span style="background:#DBEAFE;color:#1E40AF;border-radius:9999px;padding:4px 12px;font-size:0.8125rem;font-weight:600;"><?php echo esc_html( $c ); ?></span>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Featured Project -->
<section style="background:#F3F4F6;padding:48px 16px;">
	<div style="max-width:1280px;margin:0 auto;">
		<h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 32px;text-align:center;">Featured Project</h2>
		<div style="display:grid;grid-template-columns:1fr;gap:32px;align-items:center;">
			<style>@media (min-width:1024px){.featured-grid{grid-template-columns:1fr 1fr!important;}}</style>
			<div class="featured-grid" style="display:grid;grid-template-columns:1fr;gap:32px;align-items:center;">
				<div>
					<img src="<?php echo esc_url( home_url( '/images/iftaar-distribution.jpg' ) ); ?>" alt="Ramadan Iftar Distribution" width="800" height="600" loading="lazy" style="width:100%;border-radius:16px;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);" onerror="this.style.display='none'">
				</div>
				<div>
					<span style="display:inline-block;background:#FFF7ED;color:#9A3412;border-radius:9999px;padding:4px 12px;font-size:0.8125rem;font-weight:600;margin-bottom:12px;">Uttar Pradesh</span>
					<h3 style="font-size:1.5rem;font-weight:700;color:#111827;margin:0 0 12px;">Ramadan Iftar Distribution — Our Community Kitchen's Roots</h3>
					<p style="font-size:1rem;color:#475569;line-height:1.625;margin:0 0 24px;">What began as a 15-day Ramadan Iftar pilot in Amroha in 2020 has grown into Daan Foundation's flagship Community Kitchen, providing daily Iftar meals and ration support to families across Uttar Pradesh — powered by Zakat and Sadaqah from generous donors.</p>
					<a href="/ramadan" style="display:inline-flex;align-items:center;gap:8px;font-weight:600;color:#F97316;text-decoration:none;transition:gap 0.2s;" onmouseover="this.style.gap='12px'" onmouseout="this.style.gap='8px'">Learn More →</a>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- CTA -->
<section style="padding:48px 16px;">
	<div style="max-width:1280px;margin:0 auto;text-align:center;">
		<a href="/donate" style="display:inline-flex;align-items:center;gap:8px;border-radius:9999px;background:#F97316;padding:16px 32px;font-weight:700;color:#fff;text-decoration:none;box-shadow:0 20px 25px -5px rgba(249,115,22,0.3);transition:background 0.2s;"
		   onmouseover="this.style.background='#EA580C'" onmouseout="this.style.background='#F97316'">Support Our Mission →</a>
	</div>
</section>

<?php
get_footer();
