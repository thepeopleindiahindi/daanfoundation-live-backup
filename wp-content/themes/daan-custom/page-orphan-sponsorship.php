<?php
/**
 * Template Name: Sponsor an Orphan
 *
 * Sponsor an Orphan page — full-bleed hero, sponsorship cards, impact stats, CTA.
 */
get_header();
?>

<!-- Breadcrumbs -->
<div style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;">
	<div style="max-width:1280px;margin:0 auto;padding:12px 16px;">
		<nav style="display:flex;align-items:center;gap:8px;font-size:0.875rem;color:#64748B;">
			<a href="/" style="color:#64748B;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#EA580C'" onmouseout="this.style.color='#64748B'">Home</a>
			<span>/</span>
			<span style="color:#111827;font-weight:600;">Sponsor an Orphan</span>
		</nav>
	</div>
</div>

<!-- Full-bleed Hero -->
<section style="position:relative;overflow:hidden;min-height:500px;background:url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/community-queue.jpg' ); ?>') center/cover no-repeat;">
	<div style="position:absolute;inset:0;background:linear-gradient(to right,rgba(15,23,42,0.8),rgba(15,23,42,0.6),rgba(15,23,42,0.4));"></div>
	<div style="position:relative;z-index:10;max-width:1280px;margin:0 auto;padding:80px 16px;">
		<div style="max-width:640px;">
			<h1 style="font-size:2.25rem;font-weight:800;color:#fff;line-height:1.1;margin:0 0 16px;">Sponsor an Orphan</h1>
			<p style="font-size:1.25rem;color:rgba(255,255,255,0.9);margin:0 0 16px;">Change a child's life with your monthly support</p>
			<blockquote style="font-size:1rem;font-weight:500;color:rgba(255,255,255,0.8);font-style:italic;margin:0 0 24px;padding:0 0 0 16px;border-left:4px solid #F97316;">"The one who cares for an orphan and I will be together in Paradise like this," and he held his index and middle fingers together. <cite style="display:block;font-size:0.8125rem;font-weight:400;color:rgba(255,255,255,0.6);margin-top:4px;font-style:normal;">— Prophet Muhammad (PBUH)</cite></blockquote>
			<a href="/donate" style="display:inline-flex;align-items:center;gap:8px;border-radius:9999px;background:#fff;padding:16px 32px;font-weight:700;color:#EA580C;text-decoration:none;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);transition:transform 0.2s,box-shadow 0.2s;">Start Sponsoring — ₹1,000/month →</a>
		</div>
	</div>
</section>

<!-- What Your Sponsorship Provides -->
<section style="padding:48px 16px;">
	<div style="max-width:1280px;margin:0 auto;">
		<h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 32px;text-align:center;">What Your Sponsorship Provides</h2>
		<div style="display:grid;grid-template-columns:1fr;gap:24px;">
			<style>@media (min-width:640px){.sponsor-grid{grid-template-columns:repeat(2,1fr)!important;}}@media (min-width:1024px){.sponsor-grid{grid-template-columns:repeat(4,1fr)!important;}}</style>
			<div class="sponsor-grid" style="display:grid;grid-template-columns:1fr;gap:24px;">
				<div style="background:#F3F4F6;border-radius:16px;padding:24px;text-align:center;">
					<div style="width:56px;height:56px;border-radius:9999px;background:linear-gradient(135deg,#F97316,#EA580C);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
						<svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zM12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5"/>
						</svg>
					</div>
					<h3 style="font-size:1.125rem;font-weight:700;color:#111827;margin:0 0 8px;">Education</h3>
					<p style="font-size:0.9375rem;color:#475569;margin:0;">School fees, books, uniforms, and educational supplies for a brighter future.</p>
				</div>
				<div style="background:#F3F4F6;border-radius:16px;padding:24px;text-align:center;">
					<div style="width:56px;height:56px;border-radius:9999px;background:linear-gradient(135deg,#F97316,#EA580C);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
						<svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16 M4 12h16"/>
						</svg>
					</div>
					<h3 style="font-size:1.125rem;font-weight:700;color:#111827;margin:0 0 8px;">Healthcare</h3>
					<p style="font-size:0.9375rem;color:#475569;margin:0;">Regular medical checkups, medicines, and healthcare support when needed.</p>
				</div>
				<div style="background:#F3F4F6;border-radius:16px;padding:24px;text-align:center;">
					<div style="width:56px;height:56px;border-radius:9999px;background:linear-gradient(135deg,#F97316,#EA580C);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
						<svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
						</svg>
					</div>
					<h3 style="font-size:1.125rem;font-weight:700;color:#111827;margin:0 0 8px;">Nutrition</h3>
					<p style="font-size:0.9375rem;color:#475569;margin:0;">Daily nutritious meals, clean water, and healthy food to support growth.</p>
				</div>
				<div style="background:#F3F4F6;border-radius:16px;padding:24px;text-align:center;">
					<div style="width:56px;height:56px;border-radius:9999px;background:linear-gradient(135deg,#F97316,#EA580C);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
						<svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
						</svg>
					</div>
					<h3 style="font-size:1.125rem;font-weight:700;color:#111827;margin:0 0 8px;">Support</h3>
					<p style="font-size:0.9375rem;color:#475569;margin:0;">Emotional care, mentorship, and a loving community environment for every child.</p>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Impact Stats -->
<section style="background:#EA580C;padding:48px 16px;">
	<div style="max-width:1280px;margin:0 auto;">
		<div style="display:grid;grid-template-columns:1fr;gap:24px;text-align:center;">
			<style>@media (min-width:640px){.orphan-stats-grid{grid-template-columns:repeat(3,1fr)!important;}}</style>
			<div class="orphan-stats-grid" style="display:grid;grid-template-columns:1fr;gap:24px;">
				<div>
					<div style="font-size:2.5rem;font-weight:800;color:#fff;margin:0 0 8px;">5,000+</div>
					<div style="font-size:1rem;color:rgba(255,255,255,0.85);font-weight:600;">orphans supported</div>
				</div>
				<div>
					<div style="font-size:2.5rem;font-weight:800;color:#fff;margin:0 0 8px;">15</div>
					<div style="font-size:1rem;color:rgba(255,255,255,0.85);font-weight:600;">countries</div>
				</div>
				<div>
					<div style="font-size:2.5rem;font-weight:800;color:#fff;margin:0 0 8px;">98%</div>
					<div style="font-size:1rem;color:rgba(255,255,255,0.85);font-weight:600;">school attendance</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- CTA Section -->
<section style="padding:48px 16px;">
	<div style="max-width:1280px;margin:0 auto;">
		<div style="background:linear-gradient(135deg,#F59E0B,#F97316);border-radius:16px;padding:48px 32px;text-align:center;">
			<blockquote style="font-size:1.125rem;font-weight:500;color:#fff;font-style:italic;margin:0 0 16px;">"The one who cares for an orphan and I will be together in Paradise like this (closing his index and middle fingers)."</blockquote>
			<p style="font-size:1rem;color:rgba(255,255,255,0.9);margin:0 0 32px;">— Prophet Muhammad (PBUH)</p>
			<a href="/donate" style="display:inline-flex;align-items:center;gap:8px;border-radius:9999px;background:#fff;padding:16px 32px;font-weight:700;color:#EA580C;text-decoration:none;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);transition:transform 0.2s,box-shadow 0.2s;">Sponsor Now →</a>
		</div>
	</div>
</section>

<?php
get_footer();
