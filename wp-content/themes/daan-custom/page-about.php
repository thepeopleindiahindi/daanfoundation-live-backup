<?php
/**
 * Template Name: About Us
 *
 * About Daan Foundation page — mission, story, team, impact.
 */
get_header();
?>

<!-- Breadcrumbs -->
<div style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;">
	<div style="max-width:1280px;margin:0 auto;padding:12px 16px;">
		<nav style="display:flex;align-items:center;gap:8px;font-size:0.875rem;color:#64748B;">
			<a href="/" style="color:#64748B;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#EA580C'" onmouseout="this.style.color='#64748B'">Home</a>
			<span>/</span>
			<span style="color:#111827;font-weight:600;">About Us</span>
		</nav>
	</div>
</div>

<!-- Hero Banner -->
<section style="background:linear-gradient(135deg, #EA580C, #F97316);position:relative;overflow:hidden;">
	<div style="position:relative;max-width:1280px;margin:0 auto;padding:48px 16px;">
		<div style="max-width:768px;">
			<h1 class="page-hero-title">About Us</h1>
			<p style="font-size:1.125rem;color:rgba(255,255,255,0.9);line-height:1.625;max-width:576px;margin:0;">Daan Foundation – Serving Humanity With Compassion Since 2020</p>
		</div>
	</div>
</section>

<div style="max-width:1280px;margin:0 auto;padding:48px 16px;">
	<div style="display:flex;flex-wrap:wrap;gap:32px;">
		<!-- Main Content (2/3) -->
		<div style="flex:2;min-width:0;">

			<div style="display:flex;flex-direction:column;gap:40px;">

				<!-- 1. Hero Image -->
				<div>
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/about-hero.jpg' ); ?>" alt="Daan Foundation About" width="800" height="600" loading="lazy" style="width:100%;border-radius:16px;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);" onerror="this.style.display='none'">
				</div>

				<!-- 2. Our Story -->
				<div>
					<h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 16px;">Our Story</h2>
					<p style="font-size:1rem;color:#475569;line-height:1.625;margin:0 0 16px;text-align:justify;">Daan Foundation was founded in 2020 with a simple yet powerful belief: <strong>No person should sleep hungry.</strong> What began as a humble 15-day Ramadan Iftar effort quickly revealed the overwhelming need in our community. Seeing thousands of daily wage earners and their families struggling without food, a small group of dedicated individuals came together to do more.</p>
					<p style="font-size:1rem;color:#475569;line-height:1.625;margin:0;text-align:justify;">That short-term Iftar program evolved into a daily Community Kitchen that has never stopped serving. Today, Daan Foundation runs multiple programs addressing hunger, healthcare, education, and emergency relief — all driven by the principle that every human life matters and deserves dignity.</p>
				</div>

				<!-- 3. Important Notice -->
				<div style="background:#FFFBEB;border:1px solid #FDE68A;border-radius:16px;padding:24px;">
					<div style="display:flex;align-items:flex-start;gap:12px;">
						<svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#D97706" style="flex-shrink:0;margin-top:2px;">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
						</svg>
						<div>
							<h3 style="font-size:1.25rem;font-weight:700;color:#92400E;margin:0 0 12px;">Important Notice</h3>
							<ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:8px;">
								<li style="display:flex;align-items:flex-start;gap:8px;font-size:0.9375rem;color:#92400E;">✓ We operate exclusively in <strong>India</strong>.</li>
								<li style="display:flex;align-items:flex-start;gap:8px;font-size:0.9375rem;color:#92400E;">✓ We do <strong>not</strong> have any foreign operations or offices.</li>
								<li style="display:flex;align-items:flex-start;gap:8px;font-size:0.9375rem;color:#92400E;">✓ We do <strong>not</strong> operate any international projects.</li>
								<li style="display:flex;align-items:flex-start;gap:8px;font-size:0.9375rem;color:#92400E;">✓ We do <strong>not</strong> accept foreign donations (FCRA).</li>
								<li style="display:flex;align-items:flex-start;gap:8px;font-size:0.9375rem;color:#92400E;">✓ Our focus and operations are entirely <strong>India-focused</strong>.</li>
							</ul>
						</div>
					</div>
				</div>

				<!-- 4. Our Journey -->
				<div>
					<h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 24px;">Our Journey</h2>
					<p style="font-size:1rem;color:#475569;line-height:1.625;margin:0 0 24px;text-align:justify;">In 2020, during the COVID-19 lockdown, thousands of daily wage earners in Amroha, UP, found themselves without work, income, or food. A small group of friends and community members started distributing food packets from their own pockets. That small act of kindness grew into the Daan Foundation — a registered charitable organisation serving thousands every day.</p>
					<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:16px;">
						<?php
						$journey_items = array(
							'🍲 Daily Cooked Meal Distribution',
							'🌙 Ramadan Iftar Programs',
							'📦 Ration Kit Distribution',
							'👕 Clothing Support',
							'🏥 Medical Assistance',
							'📚 Educational Support',
						);
						foreach ( $journey_items as $item ) : ?>
							<div style="background:#F9FAFB;border-radius:12px;padding:16px;text-align:center;font-size:0.9375rem;font-weight:600;color:#334155;border:1px solid #E5E7EB;"><?php echo $item; ?></div>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- 5. Community Kitchen - Our Core Mission -->
				<div style="background:#FFF7ED;border:1px solid #FED7AA;border-radius:16px;padding:32px;">
					<h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 16px;">Community Kitchen — Our Core Mission</h2>
					<p style="font-size:1rem;color:#475569;line-height:1.625;margin:0 0 20px;text-align:justify;">The Community Kitchen is the heart of Daan Foundation. Every evening, we serve free, nutritious meals to anyone in need — no questions asked. Labourers, elderly, widows, orphans, homeless individuals, poor families, travellers, and anyone who is hungry is welcome.</p>
					<div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:20px;">
						<?php
						$beneficiaries = array( 'Labourers', 'Elderly', 'Widows', 'Orphans', 'Homeless', 'Poor families', 'Travellers', 'Anyone in need' );
						foreach ( $beneficiaries as $b ) : ?>
							<span style="background:#FED7AA;color:#9A3412;border-radius:9999px;padding:6px 14px;font-size:0.8125rem;font-weight:600;"><?php echo esc_html( $b ); ?></span>
						<?php endforeach; ?>
					</div>
					<p style="font-size:1rem;color:#475569;line-height:1.625;margin:0 0 8px;text-align:justify;">Meals include dal-roti, rice, vegetables, and seasonal items. During Ramadan, we serve special Iftar meals.</p>
					<p style="font-size:1.125rem;font-weight:700;color:#EA580C;margin:0;"><strong>500,000+ meals served since 2020 — ₹59 per meal</strong></p>
				</div>

				<!-- 6. Our Mission -->
				<div style="background:#F8FAFC;border-radius:16px;padding:32px;">
					<h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 16px;">Our Mission</h2>
					<p style="font-size:1.25rem;font-weight:600;color:#EA580C;margin:0 0 16px;">"Ensuring that no one sleeps hungry."</p>
					<p style="font-size:1rem;color:#475569;line-height:1.625;margin:0 0 16px;text-align:justify;">Our primary mission is to feed the hungry every single day. Beyond food, we are committed to:</p>
					<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:12px;">
						<?php
						$missions = array( '🍽️ Daily Meals', '🏥 Healthcare Support', '📚 Education', '👩 Women Support', '💍 Marriage Support', '🚨 Emergency Relief', '💼 Livelihood Support' );
						foreach ( $missions as $m ) : ?>
							<div style="background:#fff;border-radius:12px;padding:12px 16px;font-size:0.9375rem;font-weight:600;color:#334155;border:1px solid #E5E7EB;text-align:center;"><?php echo $m; ?></div>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- 7. Our Values -->
				<div>
					<h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 24px;">Our Values</h2>
					<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:16px;">
						<?php
						$value_icons = array(
							'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
							'M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z M12 9a3 3 0 100 6 3 3 0 000-6z',
							'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z',
							'M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z M14 2v6h6 M16 13H8 M16 17H8 M10 9H8',
							'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2 M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2 M9 14l2 2 4-4',
						);
						$values = array(
							array( 'Compassion', 'Every human life matters', '#FFF7ED', '#F97316', 0 ),
							array( 'Transparency', 'Every donation is Amanah (trust)', '#EFF6FF', '#3B82F6', 1 ),
							array( 'Dignity', 'Everyone deserves respect', '#ECFDF5', '#10B981', 2 ),
							array( 'Service', 'Selfless service to humanity', '#FEF2F2', '#EF4444', 3 ),
							array( 'Responsibility', 'Careful use of resources', '#F5F3FF', '#8B5CF6', 4 ),
						);
						foreach ( $values as $v ) : ?>
							<div style="background:#fff;border-radius:16px;padding:24px;box-shadow:0 1px 2px 0 rgba(0,0,0,0.05);border:1px solid #E5E7EB;text-align:center;">
								<div style="width:56px;height:56px;border-radius:12px;background:<?php echo $v[2]; ?>;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
									<svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="<?php echo $v[3]; ?>"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $value_icons[$v[4]]; ?>"/></svg>
								</div>
								<h3 style="font-size:1.125rem;font-weight:700;color:#111827;margin:0 0 8px;"><?php echo esc_html( $v[0] ); ?></h3>
								<p style="font-size:0.875rem;color:#475569;margin:0;"><?php echo esc_html( $v[1] ); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- 8. Our Achievements -->
				<div style="background:#ECFDF5;border:1px solid #A7F3D0;border-radius:16px;padding:32px;">
					<h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 24px;">Our Achievements</h2>
					<div style="display:flex;flex-direction:column;gap:12px;">
						<?php
						$achievements = array(
							'✅ 500,000+ meals served since 2020',
							'✅ Annual Ramadan Iftar programs serving thousands',
							'✅ Regular food and ration distribution drives',
							'✅ Ongoing support for widows and the elderly',
							'✅ Helping poor children and families',
							'✅ A completely volunteer-driven community effort',
						);
						foreach ( $achievements as $a ) : ?>
							<div style="display:flex;align-items:center;gap:12px;font-size:1rem;color:#065F46;"><?php echo $a; ?></div>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- 9. Our Leadership (Trustees) -->
				<div>
					<h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 24px;">Our Leadership (Trustees)</h2>
					<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:16px;">
						<?php
						$trustees = array(
							array( 'MR', 'Mr. Ahmad Raza Khan', 'Chairperson / Settler' ),
							array( 'AS', 'Mr. Anees Ahmad Siddiqui', 'Vice Chairman' ),
							array( 'FR', 'Mr. Farman Raza Khan', 'General Secretary' ),
							array( 'AK', 'Mr. Adnan Ahmad Khan', 'Treasurer' ),
							array( 'FS', 'Mr. Fareed Uddin Siddiqui', 'Trustee / Member' ),
						);
						foreach ( $trustees as $t ) : ?>
							<div style="background:#fff;border-radius:16px;padding:24px;text-align:center;box-shadow:0 1px 2px 0 rgba(0,0,0,0.05);border:1px solid #E5E7EB;">
								<div style="width:64px;height:64px;border-radius:9999px;background:linear-gradient(135deg,#F97316,#EA580C);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
									<span style="font-size:1.25rem;font-weight:700;color:#fff;"><?php echo esc_html( $t[0] ); ?></span>
								</div>
								<h3 style="font-size:1rem;font-weight:700;color:#111827;margin:0 0 4px;"><?php echo esc_html( $t[1] ); ?></h3>
								<p style="font-size:0.8125rem;color:#64748B;margin:0;"><?php echo esc_html( $t[2] ); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- 10. Our Volunteers -->
				<div style="background:#F8FAFC;border-radius:16px;padding:32px;">
					<h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 16px;">Our Volunteers</h2>
					<p style="font-size:1rem;color:#475569;line-height:1.625;margin:0 0 16px;text-align:justify;">Our volunteers are the backbone of Daan Foundation. They selflessly dedicate their time, energy, and resources to serve those in need. Their compassion and commitment drive everything we do.</p>
					<div style="display:flex;flex-wrap:wrap;gap:8px;">
						<?php
						$volunteers = array( 'Faizan Khan', 'Mohammad Nadeem Siddiqui', 'Mohd. Maroof', 'Kamar Aalam', 'Talib Siddiqui', 'Asma Khan', 'Rifaty Zia', 'Shagu', 'And many others' );
						foreach ( $volunteers as $vol ) : ?>
							<span style="background:#E2E8F0;color:#334155;border-radius:9999px;padding:6px 14px;font-size:0.8125rem;font-weight:600;"><?php echo esc_html( $vol ); ?></span>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- 11. Serving With Dignity -->
				<div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:16px;padding:32px;">
					<div style="display:flex;align-items:flex-start;gap:12px;">
						<svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#2563EB" style="flex-shrink:0;margin-top:2px;">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
						</svg>
						<div>
							<h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 12px;">Serving With Dignity</h2>
							<p style="font-size:1rem;color:#475569;line-height:1.625;margin:0;text-align:justify;">At Daan Foundation, we believe that every person deserves to be treated with respect and care. Whether we are serving a meal, providing medical aid, or distributing clothing, we ensure that every interaction preserves the dignity of those we serve. Our beneficiaries are not just recipients — they are our community, our neighbours, our family.</p>
						</div>
					</div>
				</div>

				<!-- 12. Looking Ahead -->
				<div style="background:#ECFDF5;border:1px solid #A7F3D0;border-radius:16px;padding:32px;">
					<h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 24px;">Looking Ahead</h2>
					<p style="font-size:1rem;color:#475569;line-height:1.625;margin:0 0 24px;text-align:justify;">While we are proud of what we have achieved, we know there is much more to do. Our goals for the future include:</p>
					<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;">
						<?php
						$goals = array(
							'🌟 Expand Community Kitchen to more areas',
							'🌍 Reach more underserved communities',
							'📦 Strengthen ration distribution programs',
							'📚 Increase education and healthcare support',
							'💼 Promote livelihood opportunities',
							'🤝 Build stronger partnerships for greater impact',
						);
						foreach ( $goals as $g ) : ?>
							<div style="background:#fff;border-radius:12px;padding:16px;font-size:0.9375rem;font-weight:600;color:#065F46;border:1px solid #A7F3D0;text-align:center;"><?php echo $g; ?></div>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- 13. CTA Section -->
				<div style="background:linear-gradient(135deg, #EA580C, #F97316);border-radius:16px;padding:48px 32px;text-align:center;">
					<h2 style="font-size:1.875rem;font-weight:700;color:#fff;margin:0 0 16px;">Together, We Can Build a Hunger-Free India</h2>
					<p style="font-size:1.125rem;color:rgba(255,255,255,0.9);margin:0 0 32px;max-width:576px;margin-left:auto;margin-right:auto;">Your support makes everything possible. Join us in our mission to ensure that no one sleeps hungry.</p>
					<a href="/donate" style="display:inline-flex;align-items:center;gap:8px;border-radius:9999px;background:#fff;padding:16px 32px;font-weight:700;color:#EA580C;text-decoration:none;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);transition:transform 0.2s,box-shadow 0.2s;">Support Our Mission →</a>
				</div>

			</div>
		</div>

		<!-- Sidebar (1/3) -->
		<div style="flex:1;min-width:280px;">
			<?php get_template_part( 'template-parts/donation-sidebar' ); ?>
		</div>
	</div>
</div>

<?php
get_footer();
