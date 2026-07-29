<?php
/**
 * Template Name: Emergency Appeals
 *
 * Appeals page — urgent causes, appeal cards with progress bars, seasonal campaigns, CTA.
 */
get_header();
?>

<!-- Breadcrumbs -->
<div style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;">
	<div style="max-width:1280px;margin:0 auto;padding:12px 16px;">
		<nav style="display:flex;align-items:center;gap:8px;font-size:0.875rem;color:#64748B;">
			<a href="/" style="color:#64748B;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#EA580C'" onmouseout="this.style.color='#64748B'">Home</a>
			<span>/</span>
			<span style="color:#111827;font-weight:600;">Emergency Appeals</span>
		</nav>
	</div>
</div>

<!-- Hero -->
<section style="background:linear-gradient(135deg,#EA580C,#F97316);padding:48px 16px;text-align:center;">
	<div style="max-width:768px;margin:0 auto;">
		<h1 style="font-size:2.25rem;font-weight:800;color:#fff;line-height:1.1;margin:0 0 16px;">Emergency Appeals</h1>
		<p style="font-size:1.125rem;color:rgba(255,255,255,0.9);margin:0;">Your donations provide life-saving aid to communities in need across India.</p>
	</div>
</section>

<!-- Current Emergency Appeals -->
<div style="max-width:1280px;margin:0 auto;padding:48px 16px;">
	<h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 32px;text-align:center;">Current Emergency Appeals</h2>
	<div style="display:grid;grid-template-columns:1fr;gap:24px;">
		<style>@media (min-width:768px){.appeals-grid{grid-template-columns:repeat(3,1fr)!important;}}</style>
		<?php
		// Config-flag driven — set 'active' => false to pause an appeal without
		// deleting its data (title/image/raised/target all stay right here,
		// ready to re-enable by flipping the flag back to true). Nothing here
		// reads from a CMS/status field; this array *is* the source of truth.
		$emergency_appeals = array(
			array(
				'active' => true,
				'title'  => 'Community Kitchen Daily Meals',
				'image'  => get_template_directory_uri() . '/assets/images/food-distribution-ramadan.jpg',
				'alt'    => 'Community Kitchen',
				'urgent' => true,
				'raised' => 75000,
				'target' => 100000,
			),
			array(
				'active' => false, // paused 29 July 2026 -- set to true to bring back
				'title'  => 'Winter Relief 2026',
				'image'  => get_template_directory_uri() . '/assets/images/extra-4.jpg',
				'alt'    => 'Winter Relief',
				'urgent' => false,
				'raised' => 20000,
				'target' => 50000,
			),
			array(
				'active' => false, // paused 29 July 2026 -- set to true to bring back
				'title'  => 'Ramadan Iftar 2026',
				'image'  => get_template_directory_uri() . '/assets/images/iftaar-distribution.jpg',
				'alt'    => 'Ramadan Iftar',
				'urgent' => true,
				'raised' => 60000,
				'target' => 100000,
			),
		);
		?>
		<div class="appeals-grid" style="display:grid;grid-template-columns:1fr;gap:24px;">
			<?php foreach ( $emergency_appeals as $appeal ) :
				if ( empty( $appeal['active'] ) ) {
					continue;
				}
				$percent = round( ( $appeal['raised'] / $appeal['target'] ) * 100 );
			?>
				<div style="background:#fff;border-radius:16px;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);overflow:hidden;">
					<div style="position:relative;height:200px;overflow:hidden;">
						<img src="<?php echo esc_url( $appeal['image'] ); ?>" alt="<?php echo esc_attr( $appeal['alt'] ); ?>" width="800" height="600" loading="lazy" style="width:100%;height:100%;object-fit:cover;" onerror="this.style.display='none'">
						<?php if ( ! empty( $appeal['urgent'] ) ) : ?>
							<div style="position:absolute;top:12px;right:12px;background:#EF4444;color:#fff;border-radius:9999px;padding:4px 12px;font-size:0.75rem;font-weight:700;">Urgent</div>
						<?php endif; ?>
					</div>
					<div style="padding:20px;">
						<h3 style="font-size:1.125rem;font-weight:700;color:#111827;margin:0 0 12px;"><?php echo esc_html( $appeal['title'] ); ?></h3>
						<div style="margin-bottom:12px;">
							<div style="display:flex;justify-content:space-between;font-size:0.8125rem;color:#64748B;margin-bottom:6px;">
								<span>₹<?php echo number_format( $appeal['raised'] ); ?> raised</span>
								<span><?php echo $percent; ?>%</span>
							</div>
							<div style="height:8px;background:#F3F4F6;border-radius:9999px;overflow:hidden;">
								<div style="height:100%;width:<?php echo $percent; ?>%;background:#F97316;border-radius:9999px;"></div>
							</div>
						</div>
						<p style="font-size:0.875rem;color:#64748B;margin:0 0 16px;">₹<?php echo number_format( $appeal['raised'] ); ?> raised of ₹<?php echo number_format( $appeal['target'] ); ?></p>
						<a href="/donate" style="display:inline-flex;align-items:center;gap:6px;border-radius:9999px;background:#F97316;padding:10px 24px;font-weight:700;color:#fff;text-decoration:none;font-size:0.875rem;transition:background 0.2s;" onmouseover="this.style.background='#EA580C'" onmouseout="this.style.background='#F97316'">Donate Now</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<!-- Seasonal Campaigns -->
<section style="background:#F3F4F6;padding:48px 16px;">
	<div style="max-width:1280px;margin:0 auto;">
		<h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 32px;text-align:center;">Seasonal Campaigns</h2>
		<div style="display:grid;grid-template-columns:1fr;gap:24px;">
			<style>@media (min-width:640px){.seasonal-grid{grid-template-columns:repeat(3,1fr)!important;}}</style>
			<div class="seasonal-grid" style="display:grid;grid-template-columns:1fr;gap:24px;">
				<div style="background:#fff;border-radius:16px;padding:24px;text-align:center;box-shadow:0 1px 2px 0 rgba(0,0,0,0.05);">
					<div style="width:56px;height:56px;border-radius:9999px;background:linear-gradient(135deg,#F97316,#EA580C);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
						<svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
						</svg>
					</div>
					<h3 style="font-size:1.125rem;font-weight:700;color:#111827;margin:0 0 8px;">Eid Gift Distribution</h3>
					<p style="font-size:0.9375rem;color:#475569;margin:0 0 16px;">Spread joy this Eid with gifts for orphaned and underprivileged children.</p>
					<a href="/eid-gifts" style="display:inline-flex;align-items:center;gap:6px;font-weight:600;color:#F97316;text-decoration:none;font-size:0.875rem;">Learn More →</a>
				</div>
				<div style="background:#fff;border-radius:16px;padding:24px;text-align:center;box-shadow:0 1px 2px 0 rgba(0,0,0,0.05);">
					<div style="width:56px;height:56px;border-radius:9999px;background:linear-gradient(135deg,#F97316,#EA580C);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
						<svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zM12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
						</svg>
					</div>
					<h3 style="font-size:1.125rem;font-weight:700;color:#111827;margin:0 0 8px;">Back to School</h3>
					<p style="font-size:0.9375rem;color:#475569;margin:0 0 16px;">Help children return to school with books, uniforms, and supplies.</p>
					<a href="#" style="display:inline-flex;align-items:center;gap:6px;font-weight:600;color:#F97316;text-decoration:none;font-size:0.875rem;">Learn More →</a>
				</div>
				<div style="background:#fff;border-radius:16px;padding:24px;text-align:center;box-shadow:0 1px 2px 0 rgba(0,0,0,0.05);">
					<div style="width:56px;height:56px;border-radius:9999px;background:linear-gradient(135deg,#F97316,#EA580C);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
						<svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 2v4M6 6h12M8 10h8M7 18l1 4h8l1-4M5 10v8a2 2 0 002 2h10a2 2 0 002-2v-8M12 14v2"/>
						</svg>
					</div>
					<h3 style="font-size:1.125rem;font-weight:700;color:#111827;margin:0 0 8px;">Water for All</h3>
					<p style="font-size:0.9375rem;color:#475569;margin:0 0 16px;">Provide clean drinking water through wells and water projects.</p>
					<a href="/water" style="display:inline-flex;align-items:center;gap:6px;font-weight:600;color:#F97316;text-decoration:none;font-size:0.875rem;">Learn More →</a>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- CTA -->
<section style="padding:48px 16px;">
	<div style="max-width:1280px;margin:0 auto;">
		<div style="background:linear-gradient(135deg,#F59E0B,#F97316);border-radius:16px;padding:48px 32px;text-align:center;">
			<h2 style="font-size:1.875rem;font-weight:700;color:#fff;margin:0 0 16px;">Not Sure Where to Give?</h2>
			<p style="font-size:1.125rem;color:rgba(255,255,255,0.9);margin:0 0 32px;">Let us direct your donation where it's needed most.</p>
			<a href="/where-most-needed" style="display:inline-flex;align-items:center;gap:8px;border-radius:9999px;background:#fff;padding:16px 32px;font-weight:700;color:#EA580C;text-decoration:none;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);transition:transform 0.2s,box-shadow 0.2s;">Let us decide →</a>
		</div>
	</div>
</section>

<?php
get_footer();
