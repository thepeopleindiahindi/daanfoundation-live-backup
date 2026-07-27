<?php
/**
 * Template Name: FAQ
 *
 * Frequently Asked Questions — Zakat, Sadaqah, Fidya & Kaffarah.
 */
get_header();
?>

<!-- Breadcrumbs -->
<div style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;">
	<div style="max-width:1280px;margin:0 auto;padding:12px 16px;">
		<nav style="display:flex;align-items:center;gap:8px;font-size:0.875rem;color:#64748B;">
			<a href="/" style="color:#64748B;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#EA580C'" onmouseout="this.style.color='#64748B'">Home</a>
			<span>/</span>
			<span style="color:#111827;font-weight:600;">FAQ</span>
		</nav>
	</div>
</div>

<!-- Hero Banner -->
<section style="background:linear-gradient(135deg, #EA580C, #F97316);position:relative;overflow:hidden;">
	<div style="position:relative;max-width:1280px;margin:0 auto;padding:48px 16px;">
		<div style="max-width:768px;">
			<h1 style="font-size:2.25rem;font-weight:800;color:#fff;line-height:1.1;margin:0 0 16px;">Frequently Asked Questions</h1>
			<p style="font-size:1.125rem;color:rgba(255,255,255,0.9);line-height:1.625;max-width:576px;margin:0;">Answers to common questions about Zakat, Sadaqah, Fidya, and Kaffarah.</p>
		</div>
	</div>
</section>

<!-- FAQ Categories -->
<div style="max-width:896px;margin:0 auto;padding:48px 16px;">
	<style>
		.faq-item { background:#fff;border-radius:16px;box-shadow:0 1px 2px 0 rgba(0,0,0,0.05);border:1px solid #E2E8F0;margin-bottom:12px;overflow:hidden; }
		.faq-item summary { list-style:none;cursor:pointer;padding:20px 24px;font-size:1.0625rem;font-weight:700;color:#111827;display:flex;align-items:center;justify-content:space-between;gap:16px; }
		.faq-item summary::-webkit-details-marker { display:none; }
		.faq-item summary .faq-chevron { flex-shrink:0;width:20px;height:20px;color:#EA580C;transition:transform 0.2s; }
		.faq-item[open] summary .faq-chevron { transform:rotate(180deg); }
		.faq-item summary:hover { color:#EA580C; }
		.faq-answer { padding:0 24px 20px;font-size:0.9375rem;color:#475569;line-height:1.625; }
		.faq-category-title { font-size:1.5rem;font-weight:800;color:#111827;margin:40px 0 20px; }
		.faq-category-title:first-child { margin-top:0; }
	</style>

	<?php
	$faq_categories = array(
		array(
			'topic' => 'Zakat',
			'faqs'  => array(
				array( 'What is Zakat?', "Zakat is one of the five pillars of Islam. It is a mandatory charitable contribution, typically 2.5% of a Muslim's total savings and wealth above a minimum amount known as the Nisab." ),
				array( 'Who must pay Zakat?', 'Zakat is obligatory for every adult Muslim who owns wealth above the Nisab threshold for one lunar year. The wealth must be in excess of basic needs and debts.' ),
				array( 'What is the Nisab?', 'The Nisab is the minimum amount of wealth a Muslim must possess before Zakat becomes obligatory. It is calculated based on the value of gold (87.48 grams) or silver (612.36 grams).' ),
				array( 'How is Zakat calculated?', 'Zakat is calculated as 2.5% of your total zakatable assets minus any debts. Zakatable assets include cash, savings, investments, gold, silver, and business inventory.' ),
				array( 'When should I pay Zakat?', 'Zakat is due once a full lunar year has passed since your wealth exceeded the Nisab. Many Muslims choose to pay during Ramadan for increased blessings.' ),
				array( 'Who can receive Zakat?', 'There are eight categories of Zakat recipients mentioned in the Quran: the poor, the needy, Zakat administrators, those whose hearts are to be reconciled, freeing captives, those in debt, in the cause of Allah, and travelers in need.' ),
			),
		),
		array(
			'topic' => 'Sadaqah',
			'faqs'  => array(
				array( 'What is Sadaqah?', 'Sadaqah is a voluntary act of charity given out of compassion, love, or generosity. Unlike Zakat, there is no minimum amount and it can be given at any time.' ),
				array( 'What is the difference between Sadaqah and Zakat?', 'Zakat is obligatory and has specific rules about amounts and recipients. Sadaqah is voluntary, can be any amount, and can be given to anyone in need.' ),
				array( 'What is Sadaqah Jariyah?', "Sadaqah Jariyah means 'ongoing charity.' It refers to charitable acts that continue to benefit others long after the initial gift, such as building a well or school." ),
				array( 'Can I give Sadaqah to non-Muslims?', 'Yes, Sadaqah can be given to anyone in need regardless of their faith. The key is the intention to help those who are struggling.' ),
			),
		),
		array(
			'topic' => 'Fidya & Kaffarah',
			'faqs'  => array(
				array( 'What is Fidya?', 'Fidya is a donation made when someone cannot fast during Ramadan due to illness or old age and cannot make up the fasts later. It involves feeding one person for each missed fast.' ),
				array( 'What is Kaffarah?', 'Kaffarah is a penalty paid for deliberately breaking a fast without valid reason. It requires fasting for 60 consecutive days or feeding 60 poor people for each fast broken.' ),
				array( 'When should I pay Fidya vs Kaffarah?', 'Pay Fidya if you cannot fast due to long-term illness or old age. Pay Kaffarah if you deliberately broke a fast without valid excuse.' ),
				array( 'How much is Fidya?', 'Fidya is the cost of one meal per missed fast. The amount varies by region but is typically approximately ₹59 per day (cost of one meal).' ),
			),
		),
	);

	foreach ( $faq_categories as $category ) : ?>
		<h2 class="faq-category-title"><?php echo esc_html( $category['topic'] ); ?></h2>
		<?php foreach ( $category['faqs'] as $i => $faq ) : ?>
			<details class="faq-item"<?php echo ( 0 === $i ) ? ' open' : ''; ?>>
				<summary>
					<span><?php echo esc_html( $faq[0] ); ?></span>
					<svg class="faq-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
					</svg>
				</summary>
				<div class="faq-answer"><?php echo esc_html( $faq[1] ); ?></div>
			</details>
		<?php endforeach; ?>
	<?php endforeach; ?>
</div>

<!-- CTA Section -->
<div style="max-width:1280px;margin:0 auto;padding:0 16px 48px;">
	<div style="background:linear-gradient(135deg,#EA580C,#F97316);border-radius:16px;padding:48px 32px;text-align:center;">
		<h2 style="font-size:1.875rem;font-weight:700;color:#fff;margin:0 0 16px;">Still Have Questions?</h2>
		<p style="font-size:1.125rem;color:rgba(255,255,255,0.9);margin:0 0 32px;max-width:576px;margin-left:auto;margin-right:auto;">Our team is happy to help with anything not covered here.</p>
		<a href="/contact" style="display:inline-flex;align-items:center;gap:8px;border-radius:9999px;background:#fff;padding:16px 32px;font-weight:700;color:#EA580C;text-decoration:none;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);transition:transform 0.2s,box-shadow 0.2s;">Contact Us →</a>
	</div>
</div>

<?php
get_footer();
