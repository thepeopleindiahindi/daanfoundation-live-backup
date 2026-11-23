<?php
/**
 * Page Content & Sidebar Layout Helpers
 *
 * Provides centralized page data for all sidebar-layout pages
 * and helper functions to render the sidebar-page wrapper.
 *
 * @package DaanCustom
 */

/**
 * Return structured data for a given page slug.
 *
 * @param string $slug Page identifier.
 * @return array|null  Page data array or null if not found.
 */
function daan_get_page_data( $slug ) {
	// Fitrana / Fidyah rate: one setting in plugin daan-order-tools (docs/fiqh/decisions.md D-006).
	$fitra = '₹' . number_format( function_exists( 'daan_fitrana_rate' ) ? daan_fitrana_rate() : 90 );
	// Community Kitchen facts (owner, 2026-11-23, D-037): 100–120 people a day, Amroha, since 2020; meal price from the setting.
	$meal    = '₹' . number_format( function_exists( 'daan_meal_price' ) ? daan_meal_price() : 60 );
	$ck_long = 'Every day, our Community Kitchen in Amroha serves a hot, freshly cooked meal to 100–120 people in need, and on special days and occasions, many more. We have kept this kitchen running, day after day, since 2020. Just ' . $meal . ' feeds one person a full meal.';
	// Other Fitrana rates, kit price and kit links: the same settings (docs/fiqh/decisions.md D-021, D-029).
	$rate_barley      = '₹' . number_format( function_exists( 'daan_rate' ) ? daan_rate( 'barley' ) : 175 );
	$rate_dates       = '₹' . number_format( function_exists( 'daan_rate' ) ? daan_rate( 'dates' ) : 525 );
	$rate_raisins     = '₹' . number_format( function_exists( 'daan_rate' ) ? daan_rate( 'raisins' ) : 3500 );
	$kit_price        = '₹' . number_format( function_exists( 'daan_kit_price' ) ? daan_kit_price() : 1536 );
	$kit_fitrana_url  = function_exists( 'daan_kit_url' ) ? daan_kit_url( 'fitrana' ) : '/donate/';

	// Core texts, the same wording on every page (docs/fiqh/decisions.md D-007 to D-010).
	$zakat_use   = 'Your Zakat is given only to eligible Muslim recipients, and always in a way that makes them its owner. In our Community Kitchen, meals are not served at a shared table: each person receives a full plate of food, or has their own container filled, and takes it as their own. Zakat is never used for staff salaries, gas, packing, rent, transport or any other running cost.';
	$zakat_who   = 'Zakat can be given only to a Muslim who is genuinely in need, meaning someone who does not own wealth equal to the Nisab beyond their basic needs, and who is not from the family of the Prophet ﷺ (Sayyid / Banu Hashim). Being a widow, an orphan or elderly does not by itself make a person eligible; they must also be in need.';
	$all_welcome = 'Our kitchen serves everyone in need, of every faith, community and background, and turns no one away. Meals for those who are not eligible for Zakat are funded from Sadaqah and general donations, never from Zakat. Zakat is kept in a separate account.';
	// Iftar kit price and items: settings in plugin daan-order-tools (D-012). ₹91 iftar is never the ₹90 Fitrana rate.
	$iftar_price = '₹' . number_format( function_exists( 'daan_iftar_kit_price' ) ? daan_iftar_kit_price() : 91 );
	$iftar_items = function_exists( 'daan_iftar_kit_items_text' ) ? daan_iftar_kit_items_text() : 'A full plate of veg biryani, 2 dates, 1 banana or seasonal fruit, 1 egg and 1 soft drink (sometimes 2 eggs instead of the drink).';
	$kit_iftar_url = function_exists( 'daan_kit_url' ) ? daan_kit_url( 'iftar' ) : '/product/ramadan-iftar/';
	$iftar_kit   = 'Each Iftar kit is ' . $iftar_price . '. ' . $iftar_items . ' Iftar kits are handed out at our Community Kitchen after Asr, each given to the person as their own, and people may take them home. We do not provide Sehri. An Iftar kit is not Fidyah or Fitrana.';
	$iftar_zakat = 'Zakat may be given for Iftar kits, because each kit becomes the recipient\'s property. However, we request that you give for Iftar as Sadaqah rather than Zakat. Our Iftar programme is generally funded by Sadaqah, so that it can reach as many fasting people as possible.';
	$scholar     = 'This page gives general information based on Hanafi fiqh, with reference to rulings of Darul Uloom Deoband. It is not a fatwa. For your own situation, please consult a qualified mufti.';

	$pages = array(
		'community-kitchen' => array(
			'title'             => 'Community Kitchen',
			'subtitle'          => 'Serving Free Meals With Dignity & Compassion',
			'hero_description'  => 'Since 2020, Daan Foundation has been operating its Community Kitchen continuously with one simple mission: to ensure that no needy person sleeps hungry.',
			'gradient'          => 'from-orange-600 to-amber-600',
			'image'             => '/images/food-distribution-ramadan.jpg',
			'button_text'       => 'Support the Kitchen',
			'button_url'        => '#donate',
			'default_cause'     => 'community-kitchen',
			'sections'      => array(
				array(
					'type'    => 'text',
					'heading' => 'A Daily Mission Against Hunger',
					'paragraphs' => array(
						'Daan Foundation\'s Community Kitchen in Amroha is a daily mission to fight hunger. Every single evening, our dedicated team prepares and distributes freshly cooked meals, ensuring that no one in our community goes to bed hungry. What began as a small iftar distribution effort during Ramadan 2020 has blossomed into a full-scale, year-round feeding programme that touches countless lives.',
						$ck_long . ' Each meal is prepared with care and delivered with dignity. Our kitchen operates on the simple yet profound belief that access to food is a fundamental human right, and we are committed to upholding that right for every person who comes to us.',
						'We serve all community members without any discrimination of caste, creed, religion, or background. Every person who walks through our doors is welcomed with respect and offered a warm, nutritious meal. Our commitment to inclusive service has made the Community Kitchen a trusted and beloved institution in the communities we serve.'
					)
				),
				array(
					'type'    => 'grid',
					'heading' => '100–120 People Fed Every Day',
					'items'   => array(
						array( 'icon' => 'rice', 'title' => '100–120 Daily', 'desc' => '100–120 people fed every day · Since 2020' ),
						array( 'icon' => 'rupee', 'title' => $meal . '/Meal', 'desc' => 'Cost to provide one nutritious meal' ),
						array( 'icon' => 'calendar', 'title' => 'Daily', 'desc' => 'Evening meal service, 365 days a year' ),
						array( 'icon' => 'users', 'title' => 'All Communities', 'desc' => 'Served without any discrimination' ),
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Hunger Is a Daily Struggle',
					'paragraphs' => array(
						'For millions of people across India, hunger is not a temporary inconvenience but a daily struggle that affects every aspect of life. The inability to afford even one square meal forces families to make impossible choices between food, medicine, and education for their children. This harsh reality is what drives our Community Kitchen to operate with unwavering dedication every single day.',
						'We have seen firsthand how a single nutritious meal can transform a person\'s entire day, giving them the strength to work, children the energy to study, and families the hope to keep going. By providing free meals, we are not just filling empty stomachs — we are restoring dignity, enabling productivity, and creating a foundation upon which people can begin to rebuild their lives.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Food Served With Respect',
					'paragraphs' => array(
						'At Daan Foundation, we believe that how food is served is just as important as the food itself. Every meal is presented with care and respect, served on clean utensils in a dignified manner that honours the person receiving it. We never forget that the individuals we serve are our brothers and sisters, and they deserve nothing less than the utmost respect and compassion.',
						'Our volunteers are trained to serve with a smile, to make eye contact, and to treat every recipient with the warmth and dignity they deserve. This approach has created an atmosphere of trust and mutual respect that sets our Community Kitchen apart from traditional food distribution programmes.',
						'We do not seat people at a shared table. Each person receives a full plate, or has their own container filled, and takes the food as their own.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'How Your Zakat and Sadaqah Are Used Here',
					'paragraphs' => array(
						$zakat_use,
						$all_welcome,
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'Fresh Meals Prepared Daily',
					'items'   => array(
						array( 'icon' => 'rice', 'title' => 'Rice', 'desc' => 'Steamed basmati rice, a staple of every meal' ),
						array( 'icon' => 'dal', 'title' => 'Dal', 'desc' => 'Protein-rich lentil preparation' ),
						array( 'icon' => 'vegetables', 'title' => 'Vegetables', 'desc' => 'Seasonal mixed vegetable curry' ),
						array( 'icon' => 'roti', 'title' => 'Roti', 'desc' => 'Fresh whole wheat flatbreads' ),
						array( 'icon' => 'khichdi', 'title' => 'Khichdi', 'desc' => 'Easy-to-digest rice and lentil porridge' ),
						array( 'icon' => 'seasonal', 'title' => 'Seasonal', 'desc' => 'Special dishes prepared during festivals and occasions' ),
					)
				),
				array(
					'type'    => 'testimonials',
					'heading' => 'Stories of Hope',
					'items'   => array(
						array(
							'quote' => 'Before Daan Foundation\'s Community Kitchen, I often went to bed hungry after a day of hard labour that earned me barely enough for one meal. Now I come here every evening, eat a proper meal, and save whatever little I earn for my children\'s education. This kitchen has given me a new lease on life.',
							'name'  => 'Rafiq',
							'role'  => 'Daily Wage Labourer'
						),
						array(
							'quote' => 'I live alone and have no family to cook for me. The Community Kitchen is my lifeline. The volunteers are so kind and the food is always delicious and clean. I feel like I have a family here. May Allah bless everyone who contributes to this noble cause.',
							'name'  => 'Shanti Devi',
							'role'  => 'Beneficiary'
						),
						array(
							'quote' => 'I bring my children here every evening after work. Knowing that they will get a nutritious meal gives me peace of mind. The kitchen has become a part of our daily routine and my kids look forward to it. This is truly a blessing for our community.',
							'name'  => 'Salman Khan',
							'role'  => 'Community Member'
						),
						array(
							'quote' => 'Volunteering at the Community Kitchen has been the most fulfilling experience of my life. Seeing the smiles on people\'s faces when they receive a hot meal fills my heart with joy. I encourage everyone to spend even one evening here to understand the real impact of this work.',
							'name'  => 'Faizan Khan',
							'role'  => 'Volunteer'
						),
						array(
							'quote' => 'After my husband passed away, I struggled to feed my three children on my own. The Community Kitchen has been a godsend — my children eat well, and I can focus on finding work without worrying about their next meal. I am forever grateful to Daan Foundation.',
							'name'  => 'Chhoti Aapa',
							'role'  => 'Beneficiary'
						),
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'More Than Just Food',
					'paragraphs' => array(
						'The Community Kitchen is more than a meal service — it is a community hub where people from all walks of life come together in the spirit of sharing and compassion. Our guests often arrive early to help with preparation, share stories, and build friendships with fellow community members and volunteers alike. This sense of belonging and mutual care is as nourishing as the food we serve.',
						'We have seen children do better in school because they no longer study on an empty stomach. We have seen elderly beneficiaries regain their health and vitality. We have seen families stay intact because one less financial burden has been lifted. Every meal we serve creates ripples of positive change that extend far beyond the dinner plate.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'A Vision for the Future',
					'paragraphs' => array(
						'Our aim is to keep our Community Kitchen in Amroha running every single day, and to feed many more people on special days and occasions, when the need is greatest.',
						'With your support, we can scale our operations, improve our infrastructure, and reach even more vulnerable communities. Every contribution, no matter how small, brings us one step closer to a hunger-free India where no one is left behind.'
					)
				),
				array(
					'type'    => 'notice',
					'heading' => 'Serving Humanity Since 2020',
					'content' => 'Daan Foundation\'s Community Kitchen in Amroha has been serving free meals with dignity and compassion since our founding in Ramadan 2020: 100–120 people fed every day, and many more on special days and occasions.',
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Join This Mission of Humanity',
					'description' => 'Your contribution of just ₹60 can provide a nutritious meal to someone in need. Together, we can ensure that no one goes to bed hungry.',
					'button_text' => 'Support the Kitchen',
					'button_url'  => '/donate/?cause=community-kitchen',
				),
			),
		),

		'zakat' => array(
			'title'         => 'Give Your Zakat',
			'subtitle'      => 'Fulfil your sacred obligation. Your Zakat purifies your wealth and transforms lives.',
			'gradient'      => 'from-orange-600 to-orange-700',
			'image'         => '/images/community-queue.jpg',
			'default_cause' => 'zakat',
			'sections'      => array(
				array(
					'type'    => 'text',
					'heading' => 'What is Zakat?',
					'paragraphs' => array(
						'Zakat is one of the five pillars of Islam. It is an obligatory act of worship for every sane, adult Muslim who owns wealth equal to or above the Nisab, beyond their basic needs and debts, for one full lunar year. The amount due is 2.5% (one-fortieth) of that wealth. It is not merely a charitable recommendation but a divine commandment that purifies one\'s wealth and blesses what remains.',
						'The Qur\'an names eight categories of Zakat recipients (Qur\'an 9:60): the poor, the needy, those employed to collect it, those whose hearts are to be reconciled, freeing captives, those in debt, in the cause of Allah, and the stranded traveller. As a charitable trust, Daan Foundation distributes Zakat to the poor and the needy.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Zakat in the Light of the Qur\'an',
					'paragraphs' => array(
						'Allah says in the Qur\'an: "And those in whose wealth there is a known right, for the one who asks and the one who is deprived." (Qur\'an 70:24-25). This verse reminds us that wealth is a trust from Allah, and embedded within it is a right that belongs to those who are in need.',
						'Allah mentions Zakat together with Salah in many verses of the Qur\'an, showing that caring for those in need is part of worship itself.'
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'How Daan Foundation Uses Zakat',
					'items'   => array(
						array( 'icon' => 'utensils', 'title' => 'Community Kitchen', 'desc' => 'A full plate of food handed to each eligible person as their own' ),
						array( 'icon' => 'package', 'title' => 'Ration Kits', 'desc' => 'Food supplies given to eligible families as their own' ),
						array( 'icon' => 'shirt', 'title' => 'Clothing Support', 'desc' => 'Clothing given to eligible recipients' ),
						array( 'icon' => 'heart-pulse', 'title' => 'Medical Assistance', 'desc' => 'Medical help given to, or on behalf of, eligible recipients' ),
						array( 'icon' => 'book', 'title' => 'Educational Support', 'desc' => 'School supplies and fees for eligible children' ),
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Community Kitchen & Food Support',
					'paragraphs' => array(
						$zakat_use,
						$all_welcome,
						'Each meal costs ' . $meal . ', so your Zakat can feed many eligible people. Our Community Kitchen in Amroha feeds 100–120 people every day, and many more on special days and occasions.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Nisab — The Threshold for Zakat',
					'paragraphs' => array(
						'Zakat becomes due when your wealth reaches the Nisab and a full lunar year passes over it. The Nisab is 87.48 grams of gold or 612.36 grams of silver.',
						'If you own only gold, with no cash, silver or trade goods at all, the gold Nisab applies. If you own any cash, silver or trade goods, even alongside gold, your combined wealth is measured against the value of 612.36 grams of silver at today\'s price. Please check the current silver rate in your city, or use our Zakat Calculator.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'What is Fitrana (Zakat al-Fitr)?',
					'paragraphs' => array(
						'Sadaqat al-Fitr (Fitrana) is a separate obligation, due on Eid al-Fitr at the end of Ramadan, so that people in need can also celebrate Eid with dignity. Through Daan Foundation, Fitrana is ' . $fitra . ' per person (wheat, the minimum), and we accept it only as complete ration kits.',
						'Visit our Zakat al-Fitr page to learn who must pay it and to contribute.'
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'Supporting Humanity Beyond Food',
					'items'   => array(
						array( 'icon' => 'graduation-cap', 'title' => 'Education', 'desc' => 'Sponsoring education for underprivileged children' ),
						array( 'icon' => 'stethoscope', 'title' => 'Medical', 'desc' => 'Healthcare access for those who cannot afford it' ),
						array( 'icon' => 'tshirt', 'title' => 'Clothing', 'desc' => 'Providing warm clothes and basic apparel' ),
						array( 'icon' => 'ring', 'title' => 'Marriage', 'desc' => 'Supporting marriage expenses for orphaned girls' ),
						array( 'icon' => 'briefcase', 'title' => 'Livelihood', 'desc' => 'Skills training and livelihood support' ),
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Transparency & Responsibility',
					'paragraphs' => array(
						'We take our responsibility in handling Zakat funds with the utmost seriousness. Zakat is kept in a separate account and is tracked from the donor to the recipient. ' . $zakat_who,
						'Our financial records are maintained with complete transparency, and we provide detailed reports to donors upon request. We believe that trust is the foundation of Islamic charity, and we work tirelessly to honour the trust you place in us.'
					)
				),
				array(
					'type'    => 'notice',
					'heading' => 'Working Only Within India',
					'content' => 'Daan Foundation operates exclusively within India, serving communities across the country. Your Zakat stays within India, helping your fellow citizens in need.',
				),
				array(
					'type'    => 'faq',
					'heading' => 'Frequently Asked Questions',
					'items'   => array(
						array( 'q' => 'What is Zakat?', 'a' => 'Zakat is one of the five pillars of Islam. It is a mandatory charitable contribution of 2.5% of a Muslim\'s zakatable wealth above a minimum amount known as the Nisab.' ),
						array( 'q' => 'Who must pay Zakat?', 'a' => 'Zakat is obligatory for every sane, adult Muslim who owns wealth equal to or above the Nisab, beyond basic needs and debts, for one full lunar year.' ),
						array( 'q' => 'What is the Nisab?', 'a' => 'The Nisab is 87.48 grams of gold or 612.36 grams of silver. If you own any cash, silver or trade goods, your combined wealth is measured against the value of 612.36 grams of silver.' ),
						array( 'q' => 'How is Zakat calculated?', 'a' => 'Zakat is calculated as 2.5% of your total zakatable assets minus any debts. Zakatable assets include cash, savings, investments, gold, silver, and business inventory.' ),
						array( 'q' => 'When should I pay Zakat?', 'a' => 'Zakat is due once a full lunar year has passed since your wealth reached the Nisab. Many Muslims choose to pay during Ramadan.' ),
						array( 'q' => 'Who can receive Zakat?', 'a' => $zakat_who ),
						array( 'q' => 'Does any of my Zakat go to running costs?', 'a' => 'No. Zakat is never used for salaries, gas, packing, rent, transport or other running costs. These are met from general donations.' ),
						array( 'q' => 'Can I give Zakat for Iftar?', 'a' => $iftar_zakat ),
					),
				),
				array(
					'type'    => 'notice',
					'heading' => 'Please Note',
					'content' => $scholar,
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Ready to Pay Your Zakat?',
					'description' => 'Fulfil your sacred obligation today and transform lives across India. Your Zakat is a powerful act of worship that brings barakah to your wealth and hope to those in need.',
					'button_text' => 'Pay Your Zakat',
					'button_url'  => '/donate/?cause=zakat',
				),
			),
		),

		'sadaqah' => array(
			'title'         => 'Give Sadaqah',
			'subtitle'      => 'Voluntary charity given sincerely for the sake of Allah. Every contribution, no matter how small, makes a difference.',
			'gradient'      => 'from-rose-500 to-pink-600',
			'image'         => '/images/aid-distribution-elderly.jpg',
			'default_cause' => 'sadaqah',
			'sections'      => array(
				array(
					'type'    => 'text',
					'heading' => 'What is Sadaqah?',
					'paragraphs' => array(
						'Sadaqah is a voluntary act of charity given purely for the sake of Allah, without any obligation or fixed amount. Unlike Zakat, which is an obligatory pillar of Islam with specific rules and calculations, Sadaqah can be given at any time, in any amount, and in any form — including kind words, a smile, or any act of goodness. The Prophet Muhammad (peace be upon him) said, "Every act of goodness is Sadaqah." (Sahih Muslim 1005)',
						'The beauty of Sadaqah lies in its flexibility and accessibility. Anyone, regardless of their financial circumstances, can give Sadaqah. A kind word to someone who is distressed, helping a neighbour with their chores, or simply smiling at a stranger — all of these are forms of Sadaqah that are beloved to Allah.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'The Meaning of Sadaqah',
					'paragraphs' => array(
						'The word Sadaqah is derived from the Arabic root Sidq, which means truthfulness and sincerity. This etymological connection reminds us that true charity emanates from a genuine and sincere heart, reflecting the truth of one\'s faith through action. When we give Sadaqah, we are not merely transferring wealth — we are expressing the depth of our faith and our connection to humanity.',
						'Allah says in the Qur\'an: "Who is it that would loan Allah a goodly loan so He may multiply it for him many times over?" (Qur\'an 2:245). This beautiful verse describes charity as a loan to Allah Himself, promising abundant returns in this life and the next. The Prophet Muhammad (peace be upon him) said: "…charity extinguishes sins just as water extinguishes fire." (Jami\' at-Tirmidhi 2616, graded Hasan)'
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'How Daan Foundation Uses Sadaqah',
					'items'   => array(
						array( 'icon' => 'utensils', 'title' => 'Community Kitchen', 'desc' => 'Daily meals for the hungry and underprivileged' ),
						array( 'icon' => 'moon', 'title' => 'Ramadan Iftar', 'desc' => 'Iftar meals during the blessed month of Ramadan' ),
						array( 'icon' => 'package', 'title' => 'Ration Kits', 'desc' => 'Essential food supplies for families facing food insecurity' ),
						array( 'icon' => 'heart-pulse', 'title' => 'Medical Aid', 'desc' => 'Healthcare and medical expense support' ),
						array( 'icon' => 'book', 'title' => 'Education', 'desc' => 'School supplies and educational sponsorship' ),
						array( 'icon' => 'shirt', 'title' => 'Clothing', 'desc' => 'New clothes for children and families in need' ),
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Community Kitchen',
					'paragraphs' => array(
						'Your Sadaqah directly supports our Community Kitchen programme, which feeds 100–120 people in need every day in Amroha, and many more on special days and occasions. Every contribution helps us prepare and distribute nutritious meals to those who cannot afford them, serving all community members without any discrimination.',
						'Whether you give ₹60 for one meal or ₹6,000 for a hundred meals, every rupee of your Sadaqah creates an immediate and tangible impact in someone\'s life. You can also consider Sadaqah Jariyah (ongoing charity), which we use only for the lasting assets of our kitchen, such as utensils, stoves and storage.'
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'More Than Food Support',
					'items'   => array(
						array( 'icon' => 'graduation-cap', 'title' => 'Education', 'desc' => 'Giving the gift of knowledge and opportunity' ),
						array( 'icon' => 'stethoscope', 'title' => 'Medical', 'desc' => 'Healthcare that heals bodies and gives hope' ),
						array( 'icon' => 'tshirt', 'title' => 'Clothing', 'desc' => 'Warmth and dignity through proper clothing' ),
						array( 'icon' => 'ring', 'title' => 'Marriage', 'desc' => 'Helping orphans start their married life with dignity' ),
						array( 'icon' => 'briefcase', 'title' => 'Livelihood', 'desc' => 'Empowering people to earn their own livelihood' ),
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Why Sadaqah Matters',
					'paragraphs' => array(
						'Sadaqah has the power to transform both the giver and the receiver. For the giver, it purifies the heart, increases gratitude, and brings immense spiritual rewards. For the receiver, it provides relief from hardship, restores dignity, and offers hope for a better tomorrow.',
						'By giving Sadaqah through Daan Foundation, you ensure that your charity reaches those who need it most, creating a lasting impact that goes far beyond the immediate act of giving.'
					)
				),
				array(
					'type'    => 'notice',
					'heading' => 'Every Act of Kindness Counts',
					'content' => 'Even a smile is Sadaqah. Every contribution, big or small, creates ripples of positive change in someone\'s life.',
				),
				array(
					'type'    => 'faq',
					'heading' => 'Frequently Asked Questions',
					'items'   => array(
						array( 'q' => 'What is the difference between Sadaqah and Zakat?', 'a' => 'Zakat is an obligatory annual charity calculated at 2.5% of wealth, while Sadaqah is voluntary charity that can be given at any time in any amount.' ),
						array( 'q' => 'What is Sadaqah Jariyah?', 'a' => 'Sadaqah Jariyah is charity whose benefit continues over time, such as a well, a mosque or lasting facilities that keep serving people, so its reward continues even after death. At Daan Foundation, your Sadaqah Jariyah supports the lasting needs of our Community Kitchen, such as utensils, stoves and storage. When these needs are met, it supports the kitchen\'s work of feeding people.' ),
						array( 'q' => 'Can Sadaqah be given to non-Muslims?', 'a' => 'Yes. Voluntary Sadaqah can help anyone in need. Zakat and Fitrana, however, can be given only to eligible Muslims.' ),
					),
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Every Act of Kindness Counts',
					'description' => 'Give Sadaqah today and be the reason someone smiles. Your voluntary charity can provide meals, education, medical aid, and hope to those who need it most.',
					'button_text' => 'Give Sadaqah Now',
					'button_url'  => '/donate/?cause=sadaqah',
				),
			),
		),

		'fidya' => array(
			'title'         => 'Fidya',
			'subtitle'      => 'A charitable compensation for those unable to fast during Ramadan due to valid long-term reasons.',
			'gradient'      => 'from-emerald-600 to-teal-700',
			'image'         => '/images/extra-2.jpg',
			'default_cause' => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'shortcode',
					'heading' => '',
					'code'    => '[daan_fk_update]',
				),
				array(
					'type'    => 'text',
					'heading' => 'What is Fidya?',
					'paragraphs' => array(
						'Fidya is a charitable compensation for Muslims who are unable to fast during Ramadan due to a lasting reason such as old age or a chronic illness with no hope of recovery. If recovery is possible later, the missed fasts should be made up instead.',
						'One fast\'s Fidyah equals Sadaqat al-Fitr (about 1.75 kg of wheat or its value), currently ' . $fitra . '. It is given to people in need as ration or cash that they own. An Iftar kit is not Fidyah. Daan Foundation is no longer accepting Fidyah donations. For guidance on paying your fidya, please ask a qualified mufti.'
					)
				),
				array(
					'type'    => 'quote',
					'quote'   => '"For days few in number. However, should any one of you be sick or on a journey, then (he should fast) a number of other days (equal to the missed ones); and those who have the strength, (still, they do not opt for fasting,) on them there is a fidyah (compensation), that is, the feeding of a poor person. Then whoever does good voluntarily, that is better for him. However, that you fast is better for you, if you only knew."',
					'source'  => '— Qur\'an 2:184 (translation: Mufti Muhammad Taqi Usmani)'
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Donate Iftar This Ramadan',
					'description' => 'Iftar donation is general charity (Sadaqah), not Fidyah or Kaffarah.',
					'button_text' => 'Donate Iftar',
					'button_url'  => '/ramadan/',
				),
				array(
					'type'    => 'shortcode',
					'heading' => '',
					'code'    => '[daan_more_box]',
				),
			),
		),

		'kaffarah' => array(
			'title'         => 'Kaffarah',
			'subtitle'      => 'Feeding those in need through Daan Foundation — fulfil your Kaffarah with compassion.',
			'gradient'      => 'from-red-600 to-rose-700',
			'image'         => '/images/food-distribution-ramadan.jpg',
			'default_cause' => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'shortcode',
					'heading' => '',
					'code'    => '[daan_fk_update]',
				),
				array(
					'type'    => 'text',
					'heading' => 'What is Kaffarah?',
					'paragraphs' => array(
						'Kaffarah (expiation) is due when a Ramadan fast is intentionally broken without a valid reason, or when a sworn oath (Qasam) is broken.',
						'For a broken oath, the kaffarah is feeding ten needy people two full meals each at two separate times of the day (such as morning and evening) (Qur\'an 5:89). One meal is not enough. For a broken fast, and for any other details, please ask a qualified mufti.'
					)
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Donate Iftar This Ramadan',
					'description' => 'Iftar donation is general charity (Sadaqah), not Fidyah or Kaffarah.',
					'button_text' => 'Donate Iftar',
					'button_url'  => '/ramadan/',
				),
				array(
					'type'    => 'shortcode',
					'heading' => '',
					'code'    => '[daan_more_box]',
				),
			),
		),

		// Moved from the 2024 Elementor page 5856 to the theme design (D-036, 2026-11-23); text unchanged.
		'bank-interest' => array(
			'title'         => 'Donate Bank Interest as Ration Kits',
			'subtitle'      => 'Donate Your Bank Interest with Daan Foundation',
			'gradient'      => 'from-cyan-600 to-teal-700',
			'image'         => '/images/ration-kit-front.jpg',
			'default_cause' => 'ration kit interest money',
			'sections'      => array(
				array(
					'type'       => 'text',
					'heading'    => 'Bank Interest',
					'paragraphs' => array(
						'Interest (riba) earned in a bank account is not permissible to keep or use. Scholars advise giving it away to people in need without any intention of reward (Darul Ifta, Darul Uloom Deoband).',
						'Interest money must be given away, without any intention of reward, to people in need. Daan Foundation uses it only for ration kits, which each family receives and owns. Your entire interest amount goes into the kit items; the cost of transport and our website is paid by Daan Foundation from its general funds. It is not counted as Zakat and is never used for staff, buildings or running costs.',
					),
				),
				array(
					'type'    => 'shortcode',
					'heading' => '',
					'code'    => '<p><strong>Each kit: [daan_kit_price]. What is in one kit:</strong></p>[daan_kit_items]',
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Give Ration Kits',
					'description' => 'Interest money goes only into ration kits that families receive and own.',
					'button_text' => 'Give Ration Kits (₹' . number_format_i18n( function_exists( 'daan_kit_price' ) ? daan_kit_price() : 1536 ) . ' each)',
					'button_url'  => '/product/ration-kit-interest-money/',
				),
				array(
					'type'    => 'faq',
					'heading' => 'Frequently Asked Questions',
					'items'   => array(
						array( 'q' => 'Sood ka paisa kisko dena chahiye? (Who should receive interest money?)', 'a' => 'To people in need, without any intention of reward (Darul Ifta, Darul Uloom Deoband). Daan Foundation uses it only for ration kits that each family receives and owns.' ),
						array( 'q' => 'Can I give interest money to charity?', 'a' => 'Interest money must be given away to people in need, without any intention of reward. Through Daan Foundation it goes only into ration kits.' ),
						array( 'q' => 'Is interest money counted as Zakat?', 'a' => 'No. Interest money is not counted as Zakat.' ),
						array( 'q' => 'Who pays for transport and delivery?', 'a' => 'Your entire interest amount goes into the kit items; the cost of transport and our website is paid by Daan Foundation from its general funds.' ),
					),
				),
				array(
					'type'    => 'shortcode',
					'heading' => '',
					'code'    => '<p>More about ration kits: <a href="/ration-kit-distribution-india/">Ration Kit Donation for Poor Families</a>. During Ramadan: <a href="/ramadan/">Donate Iftar</a>.</p>',
				),
			),
		),

		'ramadan' => array(
			'title'         => 'Donate Iftar This Ramadan',
			'subtitle'      => 'Give Iftar kits to fasting people in need in Amroha, Uttar Pradesh. Each kit is given as the person\'s own, after Asr at our Community Kitchen.',
			'gradient'      => 'from-violet-600 to-purple-700',
			'image'         => '/images/iftaar-distribution.jpg',
			'default_cause' => 'ramadan-iftar',
			'sections'      => array(
				array(
					'type'    => 'shortcode',
					'heading' => 'Donate Iftar Kits',
					'code'    => '[daan_iftar_buy]',
				),
				array(
					'type'    => 'text',
					'heading' => 'Fitrana and Ration Kits This Ramadan',
					'paragraphs' => array(
						'Alongside Iftar, you can give your Fitrana as complete ration kits (Zakat al-Fitr page), or give ration kits for poor families (Ration Kit Donation page). Iftar, Fitrana and ration kits are separate donations.',
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'A Journey Built on Compassion & Trust',
					'paragraphs' => array(
						'Daan Foundation was born during the blessed month of Ramadan in 2020, emerging from a simple yet powerful humanitarian vision: to provide Iftar meals to those in need. What began as a modest 15-day plan to distribute meals during the holy month has grown into a year-round mission serving families across Amroha. The founders, driven by the spirit of Ramadan, started with a small group of volunteers and limited resources, but their unwavering commitment and the community\'s overwhelming response turned this temporary initiative into a permanent institution of service.',
						'Today, Daan Foundation stands as a testament to what can be achieved when faith meets action. From that first Ramadan, serving a handful of people each evening, we have expanded to provide not just iftar meals but comprehensive support including a daily Community Kitchen, winter aid, medical assistance, educational sponsorship, and much more. The seed planted in Ramadan 2020 has grown into a tree of compassion that shelters many families.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Early Days',
					'paragraphs' => array(
						'In the early days, the founders worked without an office, operating from their homes and personal vehicles. They would prepare food in their own kitchens, pack it, and drive to distribution points to serve those in need. There was no infrastructure, no funding, and no certainty — only faith and the burning desire to help others during the blessed month.',
						'Despite these humble beginnings, the quality and consistency of the service quickly earned the trust of the community. People began donating food, money, and their time. Local businesses offered support. Within weeks, what had started as a small iftar distribution had become a community-wide movement. The founders realised that this was not just a Ramadan project but a calling to serve humanity throughout the year.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Ramadan — A Month of Compassion',
					'paragraphs' => array(
						'Ramadan is the holiest month in the Islamic calendar, a time of fasting, prayer, reflection, and heightened charity. During this month, Muslims fast from dawn to sunset, experiencing hunger and thirst to develop empathy for the less fortunate. It is a month of mercy in which the Prophet ﷺ was at his most generous (Sahih al-Bukhari 6), and the act of feeding a fasting person carries immense spiritual merit.',
						'The Prophet Muhammad (peace be upon him) said: "Whoever gives food to a fasting person to break his fast will have the same reward as him, without the fasting person\'s reward being reduced in the slightest." (Jami\' at-Tirmidhi 807, graded Sahih) This beautiful teaching inspires our donors to contribute generously during Ramadan, ensuring that those who are fasting can break their fast with a nutritious meal provided with love and respect.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Iftar Distribution Since 2020',
					'paragraphs' => array(
						'Since 2020, Daan Foundation has distributed iftar every evening during Ramadan. During Ramadan, we serve iftar to 200–300 people every day. Our iftar distribution serves daily wage labourers, homeless individuals, orphans, widows, elderly persons, disabled persons, low-income families, students, rickshaw pullers, and construction workers.',
						'Our volunteers ensure that every person receives their kit with a smile and a greeting of "Ramadan Mubarak," making the distribution a truly compassionate experience.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'What Is in an Iftar Kit',
					'paragraphs' => array(
						$iftar_kit,
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Can I Give Zakat for Iftar?',
					'paragraphs' => array(
						$iftar_zakat,
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Community Kitchen',
					'paragraphs' => array(
						'Building on the iftar distribution, we established our year-round Community Kitchen that continues the spirit of Ramadan every single day. The kitchen serves free, nutritious meals to anyone in need, 365 days a year, with the same love and dedication that characterised our first Ramadan distribution. Today it feeds 100–120 people every day, and many more on special days and occasions.',
						'The Community Kitchen embodies the Ramadan spirit of generosity throughout the year, ensuring that the hunger-alleviating work that began in the holy month never stops. Each meal costs just ₹60, making every contribution a meaningful investment in human dignity.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Food Without Discrimination',
					'paragraphs' => array(
						'At Daan Foundation, we serve all community members without any discrimination of caste, creed, religion, gender, or background. Our iftar distributions and Community Kitchen are open to everyone who is in need. We believe that hunger knows no religion, and neither should compassion. Meals for those who are not eligible for Zakat are funded from Sadaqah and general donations, never from Zakat.',
						'Our volunteers come from various backgrounds and faiths, united by the common goal of serving humanity. This spirit of unity and inclusivity is the true essence of Ramadan and the core value of Daan Foundation.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'The Spirit of Charity in Ramadan',
					'paragraphs' => array(
						'The Prophet Muhammad (peace be upon him) was the most generous of people, and his generosity increased during Ramadan when Angel Jibreel would review the Qur\'an with him each night. The Prophet was "more generous than the blowing wind" during this blessed month (Sahih al-Bukhari 6; Sahih Muslim 2308). This tradition of heightened generosity during Ramadan is one that Daan Foundation strives to embody and facilitate for our donors.',
						'By donating through Daan Foundation during Ramadan, you are continuing a blessed tradition that dates back to the Prophet himself. Your contributions ensure that the blessings of Ramadan reach those who need them most, creating a chain of generosity that uplifts entire communities.'
					)
				),
				array(
					'type'    => 'faq',
					'heading' => 'Iftar Donation: Frequently Asked Questions',
					'items'   => array(
						array( 'q' => 'How much does one Iftar kit cost?', 'a' => 'One Iftar kit is ' . $iftar_price . '. You can give as many kits as you like.' ),
						array( 'q' => 'What is in the Iftar kit?', 'a' => $iftar_items ),
						array( 'q' => 'Where and when are Iftar kits given?', 'a' => 'At our Community Kitchen in Amroha, Uttar Pradesh, after Asr during Ramadan. Each kit is given to the person as their own, and people may take it home. We do not provide Sehri.' ),
						array( 'q' => 'Can I give Zakat for Iftar?', 'a' => $iftar_zakat ),
						array( 'q' => 'Is an Iftar kit Fidyah or Fitrana?', 'a' => 'No. An Iftar kit is not Fidyah or Fitrana. Fitrana is given separately as complete ration kits on our Zakat al-Fitr page.' ),
						// Hinglish questions (D-038).
						array( 'q' => 'Roza iftar karane ka sawab kya hai?', 'a' => 'The Prophet Muhammad (peace be upon him) said: "Whoever gives food to a fasting person to break his fast will have the same reward as him, without the fasting person\'s reward being reduced in the slightest." (Jami\' at-Tirmidhi 807, graded Sahih)' ),
						array( 'q' => 'Iftar kit kitne ka hai?', 'a' => 'One Iftar kit is ' . $iftar_price . '. Choose any number of kits; the total is worked out for you.' ),
						array( 'q' => 'Iftar kit me kya milta hai?', 'a' => $iftar_items ),
						array( 'q' => 'Kya iftar ke liye zakat de sakte hain?', 'a' => $iftar_zakat ),
						array( 'q' => 'Iftar kahan aur kab diya jata hai?', 'a' => 'At our Community Kitchen in Amroha, Uttar Pradesh, after Asr during Ramadan. During Ramadan, we serve iftar to 200–300 people every day.' ),
						array( 'q' => 'Kya aap sehri bhi dete hain?', 'a' => 'No. We provide iftar only.' ),
					),
				),
				array(
					'type'    => 'shortcode',
					'heading' => 'Read more',
					'code'    => '<ul><li><a href="/whats-inside-iftar-kit/">What\'s inside an Iftar kit</a></li><li><a href="/roza-iftar-karane-ka-sawab/">Roza iftar karane ka sawab (Tirmidhi 807)</a></li><li><a href="/where-does-your-iftar-donation-go/">Where does your iftar donation go?</a></li><li><a href="/donate-iftar-safely-upi/">How to donate iftar safely by UPI</a></li><li><a href="/inside-amroha-community-kitchen/">Inside our Amroha Community Kitchen</a></li><li><a href="/ration-kit-distribution-india/">Ration kits for families (all year)</a></li></ul>',
				),
				array(
					'type'    => 'notice',
					'heading' => 'Serving Since 2020',
					'content' => 'Daan Foundation was born in Ramadan 2020 with a simple iftar distribution. Today, our Community Kitchen in Amroha feeds 100–120 people every day, and during Ramadan we serve iftar to 200–300 people every day.',
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Continue the Legacy of Ramadan',
					'description' => 'Support our Ramadan iftar distribution and Community Kitchen. Your contribution continues the blessed tradition of feeding those in need.',
					'button_text' => 'Donate for Ramadan',
					'button_url'  => $kit_iftar_url,
				),
			),
		),

		'winter-appeal' => array(
			'title'         => 'Winter Appeal',
			'subtitle'      => 'Warmth for Every Needy — Protecting Lives During Harsh Winters in India',
			'gradient'      => 'from-blue-800 to-indigo-900',
			'image'         => '',
			'default_cause' => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'text',
					'heading' => 'Protecting Lives During Harsh Winters',
					'paragraphs' => array(
						'Winter in India can be brutally harsh, especially for those who lack adequate shelter and warm clothing. Every year, thousands of people, particularly in northern India, face the winter months with nothing more than thin clothes and open skies. For homeless individuals, daily wage labourers, and families living in makeshift homes, winter is not just uncomfortable — it is life-threatening.',
						'Daan Foundation\'s Winter Appeal aims to protect the most vulnerable members of our society from the cold. We distribute warm clothing, blankets, shoes, and socks to those who cannot afford them, ensuring that they can face the winter months with dignity and safety. Your support can mean the difference between survival and suffering for someone in need.'
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'Our Winter Support Initiative',
					'items'   => array(
						array( 'icon' => 'users', 'title' => 'Poor Families', 'desc' => 'Families who cannot afford winter essentials' ),
						array( 'icon' => 'briefcase', 'title' => 'Daily Wage Labourers', 'desc' => 'Workers whose income stops in extreme cold' ),
						array( 'icon' => 'heart', 'title' => 'Elderly', 'desc' => 'Senior citizens who are most vulnerable to cold' ),
						array( 'icon' => 'home', 'title' => 'Homeless', 'desc' => 'Individuals living on the streets with no shelter' ),
						array( 'icon' => 'child', 'title' => 'Children', 'desc' => 'Young children who need protection from winter illnesses' ),
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'What We Provide',
					'items'   => array(
						array( 'icon' => 'tshirt', 'title' => 'Warm Clothes', 'desc' => 'Sweaters, jackets, and woollen garments' ),
						array( 'icon' => 'bed', 'title' => 'Blankets', 'desc' => 'Warm blankets for sleeping through cold nights' ),
						array( 'icon' => 'shoe', 'title' => 'Shoes', 'desc' => 'Sturdy footwear to protect from cold and dampness' ),
						array( 'icon' => 'socks', 'title' => 'Socks', 'desc' => 'Warm woollen socks for essential warmth' ),
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'New & Old — Both Matter',
					'paragraphs' => array(
						'We accept both new and gently used winter clothing donations. Your pre-loved winter jackets, sweaters, and blankets can provide life-saving warmth to someone who has nothing. We carefully sort, clean, and pack all donations before distribution, ensuring that every item reaches its recipient in good condition.',
						'For those who prefer to contribute financially, your donation helps us purchase new winter essentials in bulk at wholesale prices, maximising the impact of every rupee. A contribution of just ₹500 can provide a warm blanket, while ₹1,000 can provide a complete winter kit including clothes, blanket, and socks.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Why This Matters',
					'paragraphs' => array(
						'Winter-related health complications are a leading cause of preventable suffering among India\'s homeless and impoverished populations. Hypothermia, pneumonia, and other cold-related illnesses claim thousands of lives each year. A simple blanket or a warm jacket can prevent these tragedies and save lives.',
						'Beyond the physical protection, your winter donation sends a powerful message of care and solidarity. It tells the recipient that they are not forgotten, that someone cares about their wellbeing, and that they matter. This psychological warmth is just as important as the physical warmth we provide.'
					)
				),
				array(
					'type'    => 'notice',
					'heading' => 'Warmth for Every Needy',
					'content' => 'Help us protect the most vulnerable from the harsh winter. Your donation of warm clothes, blankets, or funds can save lives.',
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Share the Warmth This Winter',
					'description' => 'Your contribution can provide a warm blanket, jacket, or complete winter kit to someone who desperately needs it. Donate today and save a life this winter.',
					'button_text' => 'Donate for Winter',
					'button_url'  => '/donate/?cause=winter-appeal',
				),
			),
		),

		'where-most-needed' => array(
			'title'         => 'Where Help Is Needed Most',
			'subtitle'      => 'Your donation reaches the most urgent humanitarian needs across India.',
			'gradient'      => 'from-slate-700 to-slate-900',
			'image'         => '/images/extra-3.jpg',
			'default_cause' => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'text',
					'heading' => 'Responding Where Help Is Needed Most',
					'paragraphs' => array(
						'In a country as vast and diverse as India, needs are constantly shifting and evolving. From sudden humanitarian crises to chronic poverty that persists generation after generation, there are always communities and individuals who need urgent support. Daan Foundation\'s "Where Help Is Needed Most" fund allows us to respond flexibly and rapidly to the most pressing needs, ensuring that your donation creates the maximum possible impact.',
						'Rather than being restricted to a single programme, this fund gives us the agility to direct resources where they are needed most at any given time. Whether it is a medical emergency, a natural disaster, a community facing severe food shortage, or a family on the brink of collapse, your donation helps us be there when it matters most.'
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'Where Your Donation Goes',
					'items'   => array(
						array( 'icon' => 'utensils', 'title' => 'Hunger', 'desc' => 'Providing meals to those who cannot afford food' ),
						array( 'icon' => 'wallet', 'title' => 'Financial Crisis', 'desc' => 'Emergency financial support for families in crisis' ),
						array( 'icon' => 'heart-pulse', 'title' => 'Medical Emergencies', 'desc' => 'Urgent medical care for those without resources' ),
						array( 'icon' => 'package', 'title' => 'Lack of Food', 'desc' => 'Ration kits and essential food supplies' ),
						array( 'icon' => 'shield', 'title' => 'Difficulties', 'desc' => 'Support for those facing overwhelming challenges' ),
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Community Kitchen',
					'paragraphs' => array(
						'A significant portion of this fund supports our Community Kitchen, which feeds 100–120 people in need every day in Amroha, and many more on special days and occasions. Your donation helps us maintain this vital service daily, ensuring that no one in our community goes hungry. Each meal costs just ₹60, and every contribution translates directly into nourishment for someone in need.',
						'The Community Kitchen serves all community members without discrimination, welcoming everyone with dignity and respect. Whether it is a daily wage labourer who earned nothing today, a widow struggling to feed her children, or an elderly person living alone, our kitchen is a reliable source of warmth and nourishment.'
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'Supporting Communities Beyond Food',
					'items'   => array(
						array( 'icon' => 'package', 'title' => 'Ration', 'desc' => 'Essential food supplies for entire families' ),
						array( 'icon' => 'tshirt', 'title' => 'Clothing', 'desc' => 'New and gently used clothing for all ages' ),
						array( 'icon' => 'stethoscope', 'title' => 'Medical', 'desc' => 'Healthcare and emergency medical assistance' ),
						array( 'icon' => 'book', 'title' => 'Education', 'desc' => 'School supplies and educational sponsorship' ),
						array( 'icon' => 'ring', 'title' => 'Marriage', 'desc' => 'Support for orphaned girls\' marriage expenses' ),
						array( 'icon' => 'briefcase', 'title' => 'Livelihood', 'desc' => 'Skills training and economic empowerment' ),
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'A Mission Built on Compassion',
					'paragraphs' => array(
						'Daan Foundation was founded on the principle of compassionate service to humanity, regardless of background or belief. Our "Where Help Is Needed Most" fund embodies this principle by allowing us to respond to needs as they arise, without being constrained by programme boundaries. This flexibility has enabled us to help countless individuals and families in their moments of greatest need.',
						'From providing emergency medical assistance to a child with a critical illness, to supporting a family that lost everything in a fire, to ensuring a elderly person has warm meals in winter — your donation to this fund makes all of this possible. You are not just donating to a programme; you are becoming a partner in our mission to serve humanity wherever and whenever help is needed.'
					)
				),
				array(
					'type'    => 'notice',
					'heading' => 'Help Where It Matters Most',
					'content' => 'Your donation to this fund ensures that we can respond to the most urgent needs, wherever they arise, with speed and compassion.',
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Donate Where Help Is Needed Most',
					'description' => 'Your contribution will be directed to the most pressing humanitarian needs, ensuring maximum impact for every rupee you give.',
					'button_text' => 'Donate Now',
					'button_url'  => '/donate/?cause=where-needed',
				),
			),
		),

		'sadaqah-jariyah' => array(
			'title'         => 'Sadaqah Jariyah',
			'subtitle'      => 'Ongoing charity that continues benefiting people, even after the donor has passed away.',
			'gradient'      => 'from-cyan-600 to-teal-700',
			'image'         => '/images/extra-1.jpg',
			'default_cause' => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'text',
					'heading' => 'What is Sadaqah Jariyah?',
					'paragraphs' => array(
						'Sadaqah Jariyah means "ongoing charity": charity whose benefit continues over time, so that its reward continues for the giver even after death. The Prophet Muhammad (peace be upon him) said, "When a person dies, his deeds come to an end except for three: ongoing charity (Sadaqah Jariyah), beneficial knowledge, or a righteous child who prays for him." (Sahih Muslim 1631)',
						'Common examples are a well, a mosque, or lasting facilities that keep serving people for years.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Why It Is Important',
					'paragraphs' => array(
						'Sadaqah Jariyah is among the most rewarding forms of charity because its benefit lasts. For those who wish to leave a lasting legacy of goodness, it is a way to keep benefiting people even after one is no longer able to perform good deeds oneself.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Sadaqah Jariyah at Daan Foundation',
					'paragraphs' => array(
						'Your Sadaqah Jariyah supports the lasting needs of our Community Kitchen, such as utensils, stoves and storage. When these needs are met, it supports the kitchen\'s work of feeding people.',
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'What Your Sadaqah Jariyah Provides',
					'items'   => array(
						array( 'icon' => 'utensils', 'title' => 'Utensils', 'desc' => 'Cooking vessels and serving utensils used every day' ),
						array( 'icon' => 'seasonal', 'title' => 'Stoves', 'desc' => 'Cooking stoves and kitchen equipment' ),
						array( 'icon' => 'package', 'title' => 'Storage', 'desc' => 'Storage for grain, rations and supplies' ),
					)
				),
				array(
					'type'    => 'notice',
					'heading' => 'A Lasting Benefit',
					'content' => 'Your Sadaqah Jariyah supports the lasting needs of our Community Kitchen, such as utensils, stoves and storage. When these needs are met, it supports the kitchen\'s work of feeding people.',
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Give Sadaqah Jariyah Today',
					'description' => 'Support the lasting needs of our Community Kitchen, such as utensils, stoves and storage.',
					'button_text' => 'Give Ongoing Charity',
					'button_url'  => '/donate/?cause=sadaqah-jariyah',
				),
			),
		),

		'eid-gifts' => array(
			'title'         => 'Spread Joy This Eid',
			'subtitle'      => 'Supporting Children with Love & Dignity — Daan Foundation\'s Eid Gift Initiative',
			'gradient'      => 'from-amber-500 to-orange-600',
			'image'         => '/images/extra-5.jpg',
			'default_cause' => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'text',
					'heading' => 'Bringing Smiles This Eid',
					'paragraphs' => array(
						'Eid is a time of celebration, joy, and togetherness for Muslims around the world. It is a day when families come together, children dress in new clothes, and everyone shares in the happiness of the occasion. Central to Eid celebration is the tradition of Eidi — gifts given to children as a token of love and blessing. However, for many children from disadvantaged backgrounds, Eid can be a reminder of what they do not have rather than a day of joy.',
						'Daan Foundation\'s Eid Gift Initiative aims to ensure that every child, regardless of their family\'s financial circumstances, can experience the joy of Eid. We distribute new clothes, toys, school bags, and sweets to children from orphanages, low-income families, and vulnerable communities, bringing smiles to their faces and dignity to their celebration.'
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'Our Eid Gifts Programme',
					'items'   => array(
						array( 'icon' => 'heart', 'title' => 'Orphan Children', 'desc' => 'Children who have lost one or both parents' ),
						array( 'icon' => 'woman', 'title' => 'Widows\' Children', 'desc' => 'Children being raised by single mothers' ),
						array( 'icon' => 'users', 'title' => 'Low-Income Families', 'desc' => 'Children from families struggling to make ends meet' ),
						array( 'icon' => 'shield', 'title' => 'Vulnerable Children', 'desc' => 'Children facing abuse, neglect, or extreme poverty' ),
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'What We Provide',
					'items'   => array(
						array( 'icon' => 'tshirt', 'title' => 'New Clothes', 'desc' => 'Brand new Eid outfits for children of all ages' ),
						array( 'icon' => 'backpack', 'title' => 'School Bags', 'desc' => 'Durable school bags filled with supplies' ),
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'Why Eid Gifts Matter',
					'items'   => array(
						array( 'icon' => 'smile', 'title' => 'Joy & Happiness', 'desc' => 'Every child deserves to feel the joy of Eid' ),
						array( 'icon' => 'heart', 'title' => 'Dignity & Self-Worth', 'desc' => 'New clothes give children confidence and dignity' ),
						array( 'icon' => 'users', 'title' => 'Community Belonging', 'desc' => 'Gifts help children feel included in celebrations' ),
						array( 'icon' => 'star', 'title' => 'Lasting Memories', 'desc' => 'Eid gifts create cherished childhood memories' ),
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Our Responsibility',
					'paragraphs' => array(
						'We take great care in selecting and distributing Eid gifts. Each gift is age-appropriate, culturally sensitive, and of good quality. We work with local communities and community leaders to identify the children who need support the most, ensuring that our gifts reach those who would otherwise go without any celebration.',
						'Our volunteers personally distribute the gifts, spending time with the children and making them feel special and loved. The smiles we receive in return are the greatest reward, reminding us why this work is so important. Last year, we brought joy to children in Amroha, and with your support, we can reach even more this Eid.'
					)
				),
				array(
					'type'    => 'notice',
					'heading' => 'Spread Joy This Eid',
					'content' => 'Your donation can bring a smile to a child\'s face this Eid. Help us ensure that every child experiences the joy and dignity of Eid celebration.',
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Give the Gift of Eid Joy',
					'description' => 'Donate today to provide Eid gifts to children in need. Your contribution gives a child the joy, dignity, and happiness they deserve.',
					'button_text' => 'Donate for Eid Gifts',
					'button_url'  => '/donate/?cause=eid-gifts',
				),
			),
		),

		'zakat-al-fitr' => array(
			'title'         => 'Fitrana (Zakat al-Fitr) 2027',
			'subtitle'      => 'The charity of Eid al-Fitr, so that everyone can celebrate Eid with dignity.',
			'gradient'      => 'from-indigo-600 to-purple-700',
			'image'         => '/images/iftaar-distribution.jpg',
			'default_cause' => 'fitrana-kit',
			'sections'      => array(
				array(
					'type'    => 'text',
					'heading' => 'What is Zakat al-Fitr?',
					'paragraphs' => array(
						'Sadaqat al-Fitr (Fitrana) is wajib on every Muslim who, on the morning of Eid al-Fitr, owns wealth equal to the Nisab beyond their basic needs. Unlike Zakat, a full year does not need to pass on this wealth. It is paid for yourself and for your minor children. It purifies the fast and helps people in need celebrate Eid with dignity.',
						'Fitrana can be given from four items (Sahih al-Bukhari 1506, 1508): wheat or wheat flour, half a sa\' (about 1.75 kg) per person; or barley, dates or raisins, one sa\' (about 3.5 kg) per person, according to your means.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Fitrana Amount',
					'paragraphs' => array(
						'Fitrana: ' . $fitra . ' per person (wheat, the minimum). You may give more according to your means: barley ' . $rate_barley . ', dates ' . $rate_dates . ' or raisins ' . $rate_raisins . ' per person (this year\'s estimate).',
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'How We Accept Fitrana',
					'paragraphs' => array(
						'Daan Foundation is unable to track individual Fitrana payments. Therefore we accept Fitrana only as complete ration kits of ' . $kit_price . ' each. One kit can cover the Fitrana of several members of one family. Any amount above your family\'s actual Fitrana is counted as voluntary Sadaqah.',
						'Please pay at least 3 days before Eid. Payments received later will still be accepted, and we will try our best to deliver them, but we cannot take responsibility for delivery before the Eid prayer.',
						'If these conditions are acceptable to you, please give your Fitrana through us; otherwise, please give it directly to a deserving person.'
					)
				),
				array(
					'type'    => 'shortcode',
					'heading' => 'What Is in the Fitrana Ration Kit',
					'code'    => '<p>When you give [daan_kit_price] (or the amount we set each year), we deliver this complete ration kit, with the items and quantities listed below, to a family in need. The amount includes the cost of transport and our website. Your Fitrana is counted only from the food items in the kit, not from these costs.</p>[daan_kit_items]',
				),
				array(
					'type'    => 'shortcode',
					'heading' => '',
					'code'    => '[daan_fitrana_calculator]',
				),
				array(
					'type'    => 'comparison',
					'heading' => 'Who Should Pay vs Zakat vs Fitrana',
					'col1'    => array(
						'heading' => 'Who Should Pay',
						'items'   => array(
							'Every Muslim who owns wealth equal to the Nisab beyond basic needs on Eid morning',
							'Paid for yourself and your minor children; for your wife or adult children it is not wajib on you, but you may pay with their permission',
							'Please pay at least 3 days before Eid',
							$fitra . ' per person (wheat, the minimum)',
						)
					),
					'col2'    => array(
						'heading' => 'Zakat vs Fitrana',
						'items'   => array(
							'Zakat is 2.5% of annual wealth; Fitrana is a fixed amount per person',
							'Zakat needs a full year on wealth above the Nisab; Fitrana needs only ownership of the Nisab on Eid morning',
							'Zakat can be given at any time once due; Fitrana is due on Eid al-Fitr',
							'Zakat purifies wealth; Fitrana purifies the fast and feeds the needy',
						)
					),
				),
				array(
					'type'    => 'faq',
					'heading' => 'Fitrana: Frequently Asked Questions',
					'items'   => array(
						array( 'q' => 'Fitrana kitna hai 2027 me? (How much is Fitrana in 2027?)', 'a' => 'Fitrana is ' . $fitra . ' per person (wheat, the minimum). You may give more according to your means: barley ' . $rate_barley . ', dates ' . $rate_dates . ' or raisins ' . $rate_raisins . ' per person (this year\'s estimate).' ),
						array( 'q' => 'Fitra kitna dena hai? (How much Fitra should I give?)', 'a' => 'One Fitrana for yourself and one for each of your minor children, at the rate of the item you choose (wheat ' . $fitra . ' per person is the minimum). For your wife or adult children it is not wajib on you, but you may pay with their permission.' ),
						array( 'q' => 'Fitra kis par wajib hai? (Who must pay Fitrana?)', 'a' => 'Every Muslim who, on the morning of Eid al-Fitr, owns wealth equal to the Nisab beyond their basic needs. A full year does not need to pass on this wealth.' ),
						array( 'q' => 'Fitrana kab tak dena chahiye? (By when should I pay?)', 'a' => 'Please pay at least 3 days before Eid. Payments received later will still be accepted, and we will try our best to deliver them, but we cannot take responsibility for delivery before the Eid prayer.' ),
						array( 'q' => 'Can I pay Fitrana online in India?', 'a' => 'Yes. We accept Fitrana only as complete ration kits of ' . $kit_price . ' each. One kit can cover the Fitrana of several members of one family.' ),
						array( 'q' => 'What if my family\'s Fitrana is less than one kit?', 'a' => 'Any amount above your family\'s actual Fitrana is counted as voluntary Sadaqah.' ),
					),
				),
				array(
					'type'    => 'notice',
					'heading' => 'Please Note',
					'content' => $scholar,
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Give Your Fitrana',
					'description' => 'Each Fitrana Ration Kit is ' . $kit_price . ' and can cover the Fitrana of several members of one family.',
					'button_text' => 'Give Fitrana Ration Kits',
					'button_url'  => $kit_fitrana_url,
				),
			),
		),

		'impact' => array(
			'title'             => 'Our Impact',
			'subtitle'          => 'A 6-Year Journey of Compassion, Growth & Service',
			'hero_description'  => 'From a small Ramadan Iftar initiative to a trusted humanitarian mission serving communities across India.',
			'gradient'          => 'from-orange-600 to-orange-700',
			'image'             => '/images/impact-1.jpg',
			'button_text'       => 'Donate Now',
			'button_url'        => '/donate/',
			'default_cause'     => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'grid',
					'heading' => 'Our Impact in Numbers',
					'items'   => array(
						array( 'title' => '100–120', 'desc' => 'People Fed Every Day · Since 2020' ),
						array( 'title' => '200–300', 'desc' => 'People Served Iftar Every Day in Ramadan' ),
						array( 'title' => '6+', 'desc' => 'Years of Service' ),
						array( 'title' => '12–15', 'desc' => 'Years of Team Experience in Community Service' ),
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Essential Food Support',
					'paragraphs' => array(
						'Many families struggle every day to arrange even basic meals. Financial difficulties, unemployment, illness, and emergencies often leave vulnerable people uncertain about how they will feed their families.',
						'Daan Foundation works to ensure that needy individuals and families receive essential support with dignity and compassion.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Daily Food Distribution',
					'paragraphs' => array(
						'Since 2020, the foundation has continued distributing cooked meals and food support to people in need. What initially began as a temporary 15-day Ramadan effort gradually became a continuous humanitarian mission.',
						'During emergencies and difficult situations, food assistance acts as an immediate relief for vulnerable communities, especially daily wage workers, elderly individuals, patients, and struggling families.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Ramadan & Iftar Support',
					'paragraphs' => array(
						'Every Ramadan, Daan Foundation organizes Iftar arrangements for fasting individuals and distributes food support to families who face difficulties arranging meals during the holy month.',
						'The foundation also provides ration kits containing essential food items to help families prepare for Ramadan with greater ease and dignity.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Qurbani & Community Welfare',
					'paragraphs' => array(
						'Through initiatives such as Qurbani Easy, the organization helps facilitate Qurbani contributions and utilizes the meat distribution process to support vulnerable communities.',
						'Qurbani meat and cooked meals are distributed among needy families so they can celebrate Eid with comfort and happiness.'
					)
				),
				array(
					'type'    => 'checklist',
					'heading' => 'Supporting Families Beyond Food',
					'items'   => array(
						'Distribution of ration kits',
						'Providing old clothes and essential items',
						'Assisting financially struggling families during marriages',
						'Helping patients receive medical treatment and healthcare support',
						'Supporting educational needs of underprivileged children',
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Working Towards Long-Term Change',
					'paragraphs' => array(
						'The foundation believes that humanitarian work is not only about responding during emergencies but also about standing beside communities consistently.',
						'By continuing food support, welfare activities, and charitable initiatives, Daan Foundation aims to create positive and lasting impact among vulnerable sections of society.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Islamic Social Finance & Community Support',
					'paragraphs' => array(
						'Daan Foundation continues its charitable activities through the support of donors, volunteers, and well-wishers who believe in helping humanity through compassion and collective responsibility.',
						'Every contribution — whether food, clothing, ration support, medical assistance, or charity donations — helps bring relief and hope to families in need.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Daan Foundation\'s Journey of Humanity (2020–2026)',
					'paragraphs' => array(
						'Daan Foundation began with a small humanitarian effort in 2020, when a few volunteers decided to distribute food during Ramadan for only 15 days — from the 15th Roza until the 30th Roza before Eid.',
						'What started as a temporary Ramadan initiative gradually transformed into a continuous humanitarian mission. During the pandemic and lockdown period, many families faced unemployment, hunger, and financial hardship — and the work continued even after Ramadan ended.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => '2020 — The Beginning of a Mission',
					'paragraphs' => array(
						'In 2020, Daan Foundation started its first food distribution effort during Ramadan. The original plan was to provide cooked meals only from the 15th Roza until the 30th Roza — a total of 15 days.',
						'Despite limited resources, volunteers worked continuously to prepare and distribute meals to people affected by poverty and lockdown conditions. That small initiative became the starting point of a much larger humanitarian journey.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => '2021 — Expanding Food & Iftar Support',
					'paragraphs' => array(
						'As awareness about the foundation\'s work increased, more people came forward to support the mission. During Ramadan 2021, Daan Foundation expanded its Iftar arrangements and started reaching larger numbers of fasting individuals and struggling families.',
						'The organization also began distributing ration kits containing essential food supplies to households facing financial difficulties, and the Community Kitchen initiative became more organized.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => '2022 — Building a Stronger Community Kitchen',
					'paragraphs' => array(
						'By 2022, the Community Kitchen had become one of the foundation\'s most important humanitarian initiatives. Meals were being prepared and distributed every day to laborers, elderly individuals, patients, travelers, and poor families.',
						'The organization also expanded its welfare activities by distributing clothes to needy families, helping financially struggling families during marriages, and supporting patients with medical treatment assistance. The work was no longer limited to Ramadan — it had become a year-round mission of service.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => '2023 — Reaching More People in Need',
					'paragraphs' => array(
						'In 2023, Daan Foundation continued to grow with the support of donors and volunteers. Food distribution activities expanded further, and more ration kits were delivered to families facing hardship. The foundation also strengthened its emergency support efforts — every year, the number of people benefiting from its support continued increasing.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => '2024 — Strengthening Humanitarian Efforts',
					'paragraphs' => array(
						'By 2024, Daan Foundation had become a trusted community-driven charitable initiative for many vulnerable families. Its daily food distribution and Ramadan Iftar programs expanded significantly, while welfare support activities continued helping people in need with dignity and compassion.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => '2025 — Iftar Every Day in Ramadan',
					'paragraphs' => array(
						'During Ramadan, we serve iftar to 200–300 people every day. In Ramadan 2025, this support reached fasting people through cooked meals, food distribution and ration assistance.',
						'The Community Kitchen continued to feed 100–120 people every day through the support of Zakat, Sadaqah, charity donations and community contributions.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => '2026 — Continuing the Journey of Humanity',
					'paragraphs' => array(
						'By 2026, Daan Foundation\'s Community Kitchen in Amroha was feeding 100–120 people every day, and many more on special days and occasions. From a small 15-day Ramadan effort to a growing charitable foundation, the journey reflects the power of sincere intentions, community support, and consistent humanitarian work.'
					)
				),
				array(
					'type'    => 'checklist',
					'heading' => 'Today, the Foundation Continues Serving Through',
					'items'   => array(
						'Daily food distribution',
						'Community Kitchen services',
						'Ramadan Iftar arrangements',
						'Ration kit distribution',
						'Clothing support for needy families',
						'Medical assistance for patients',
						'Welfare and emergency support programs',
					)
				),
				array(
					'type'    => 'text',
					'paragraphs' => array(
						'Every meal distributed, every ration kit delivered, and every family supported represents the generosity of donors, volunteers, and supporters who believe in helping humanity. Daan Foundation continues its journey with the same spirit with which it began in 2020: serving people with dignity, compassion, responsibility, and hope.'
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'Our Programs',
					'items'   => array(
						array( 'title' => 'Community Kitchen', 'desc' => 'Daily free meal distribution serving freshly cooked food every evening.' ),
						array( 'title' => 'Ration Kit Distribution', 'desc' => 'Essential food supplies for struggling families year-round.' ),
						array( 'title' => 'Fidyah & Kaffarah', 'desc' => 'Fulfil your Islamic obligation by feeding the needy.' ),
					)
				),
				array(
					'type'    => 'notice',
					'heading' => 'Working Only Within India',
					'content' => 'Daan Foundation operates only within India and focuses entirely on charitable and humanitarian activities within Indian geography.',
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Every Meal Is More Than Food',
					'description' => 'It is dignity, hope, and humanity. Together, we can build a future where no one sleeps hungry.',
					'button_text' => 'Donate Now',
					'button_url'  => '/donate/',
				),
			),
		),

		'charity-in-action' => array(
			'title'             => 'Your Charity in Action',
			'subtitle'          => 'Every Donation Becomes a Meal, a Kit, a Moment of Relief',
			'hero_description'  => 'See how your Zakat, Sadaqah, and charity are transformed into real, everyday support for families across India.',
			'gradient'          => 'from-amber-600 to-amber-700',
			'image'             => '/images/food-distribution-ramadan.jpg',
			'button_text'       => 'Donate Now',
			'button_url'        => '/donate/',
			'default_cause'     => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'text',
					'paragraphs' => array(
						'Daan Foundation has been working continuously since 2020 to support vulnerable families through food assistance, Ramadan support, community welfare, and humanitarian services. What began as a small Ramadan initiative has grown into a regular community effort powered by the generosity of people who donate their Zakat, Sadaqah, charity, and other forms of support to help those in need.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Supporting Families Through Ramadan',
					'paragraphs' => array(
						'Every Ramadan, Daan Foundation arranges Iftar meals and food support for fasting individuals and struggling families. Through the support of donors, the foundation provides essential food items and cooked meals to help people break their fast with dignity.',
						'The organization also distributes ration kits containing important household food supplies to families facing financial hardship during the holy month.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Community Kitchen Initiative',
					'paragraphs' => array(
						'One of the foundation\'s important ongoing humanitarian efforts is its Community Kitchen, which has continued operating regularly since 2020.',
						'Through this initiative, cooked meals are prepared and distributed daily to needy individuals, laborers, poor families, patients, travelers, and other vulnerable members of society. Every day, 100–120 people benefit from this food support program. This community kitchen operates through the generosity of people who contribute through:'
					)
				),
				array(
					'type'    => 'checklist',
					'items'   => array(
						'Zakat',
						'Sadaqah',
						'Charity donations',
						'Food donations',
						'Community support initiatives',
					)
				),
				array(
					'type'    => 'text',
					'paragraphs' => array(
						'The support of donors helps ensure that food continues reaching those who may otherwise struggle to arrange regular meals.'
					)
				),
				array(
					'type'    => 'checklist',
					'heading' => 'Charity That Creates Real Impact',
					'items'   => array(
						'Daily food distribution',
						'Iftar arrangements during Ramadan',
						'Ration kit distribution',
						'Community kitchen operations',
						'Clothing support for needy families',
						'Medical assistance for patients',
						'Welfare support for vulnerable individuals',
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Continuing the Mission',
					'paragraphs' => array(
						'Since its beginning in 2020, Daan Foundation has remained committed to serving humanity with compassion, dignity, and responsibility.',
						'Every donation, every meal, and every act of support helps bring relief, hope, and comfort to families facing hardship. The foundation continues its mission through the collective efforts of volunteers, supporters, and donors who believe in helping humanity through charity and kindness.'
					)
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Put Your Charity Into Action',
					'description' => 'Every donation you make is used to serve those who need it most. Join us in making a real difference.',
					'button_text' => 'Donate Now',
					'button_url'  => '/donate/',
				),
			),
		),

		'community-trust' => array(
			'title'             => 'Community Trust & Feedback',
			'subtitle'          => 'The True Strength of Our Work Is Reflected in the Trust of Those We Serve',
			'hero_description'  => 'Real voices from the communities, volunteers, and families Daan Foundation has worked alongside since 2020.',
			'gradient'          => 'from-orange-500 to-red-600',
			'image'             => '/images/extra-5.jpg',
			'button_text'       => 'Donate Now',
			'button_url'        => '/donate/',
			'default_cause'     => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'text',
					'paragraphs' => array(
						'Daan Foundation, Amroha, Uttar Pradesh, India believes that the true strength of humanitarian work is reflected in the trust, prayers, and feedback of the people it serves.',
						'Since 2020, the foundation has worked closely with communities through food distribution, Community Kitchen services, Ramadan Iftar arrangements, ration support, clothing distribution, medical assistance, and welfare initiatives. Because the organization works directly among people and communities, many individuals, volunteers, and local residents have shared positive feedback about the support they received during difficult times.',
						'For Daan Foundation, this feedback is more than appreciation — it is a responsibility that motivates the organization to continue serving humanity with honesty, compassion, and dignity.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Our Commitment to Communities',
					'paragraphs' => array(
						'Daan Foundation may not operate like large international humanitarian organizations, but it remains deeply committed to helping vulnerable people through transparent and community-focused charitable work. The foundation believes in:'
					)
				),
				array(
					'type'    => 'checklist',
					'items'   => array(
						'Respecting the dignity of every individual',
						'Listening to community needs',
						'Providing support without discrimination',
						'Maintaining honesty and accountability',
						'Continuously improving humanitarian efforts',
					)
				),
				array(
					'type'    => 'text',
					'paragraphs' => array(
						'Every activity carried out by the organization is guided by compassion, responsibility, and sincere intention to help people facing hardship.'
					)
				),
				array(
					'type'    => 'testimonials',
					'heading' => 'Community Voices & Volunteer Feedback',
					'items'   => array(
						array( 'quote' => 'During difficult financial days, Daan Foundation regularly provided cooked meals and ration support to our family. Their volunteers treated everyone respectfully and helped us during a very difficult time.', 'name' => 'Ramzan Begam' ),
						array( 'quote' => 'I have personally seen how the Community Kitchen distributes food daily to laborers, poor families, and travelers. Many people benefit from this initiative every single day.', 'name' => 'Chhoti Aapa' ),
						array( 'quote' => 'During Ramadan, Daan Foundation arranged Iftar meals and ration kits for many struggling families like ours. Their support reduced our worries and helped us complete Ramadan peacefully.', 'name' => 'Raja Bhai' ),
						array( 'quote' => 'From food distribution to helping needy families, every volunteer works with sincerity and teamwork. Seeing smiles on people\'s faces motivates us to continue serving humanity.', 'name' => 'Faizan Khan', 'role' => 'Volunteer' ),
						array( 'quote' => 'What makes Daan Foundation different is the respectful way they help people. Whether someone needs food, clothes, or medical support, the organization tries its best to assist them.', 'name' => 'Mohammad Nadeem' ),
						array( 'quote' => 'I have seen Daan Foundation grow from a small Ramadan food effort into a larger humanitarian mission. Every year, more families are benefiting from its charitable work.', 'name' => 'Nadeem Siddiqui' ),
						array( 'quote' => 'Many people in the community trust Daan Foundation because the organization works directly among the people and regularly helps families facing hardship.', 'name' => 'Maruf' ),
						array( 'quote' => 'The foundation not only distributes food but also supports women, children, and poor families through ration kits, clothes distribution, and emergency assistance.', 'name' => 'Shagufta' ),
						array( 'quote' => 'Since 2020, the organization has continuously helped needy people through food distribution and welfare work. Their consistency is what makes their work valuable.', 'name' => 'Abdul Haq' ),
						array( 'quote' => 'The volunteers and supporters of Daan Foundation work with compassion and dedication. Their mission is helping humanity, and people can clearly see that in their work.', 'name' => 'Sher Baniya' ),
						array( 'quote' => 'It is inspiring to see young volunteers coming together to help poor families, organize Iftar arrangements, and support people in need through charitable activities.', 'name' => 'Fatima' ),
						array( 'quote' => 'The foundation\'s work continues because of the support of donors, volunteers, and local people who believe in helping humanity through charity and kindness.', 'name' => 'Farman Raja' ),
						array( 'quote' => 'Whether during Ramadan or emergencies, Daan Foundation tries to respond quickly and support struggling families through food assistance and welfare support.', 'name' => 'Adnan Ahmed Khan' ),
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Building Trust Through Service',
					'paragraphs' => array(
						'Daan Foundation understands that trust is built through actions, consistency, and transparency. Since 2020, the organization has continued serving communities through:'
					)
				),
				array(
					'type'    => 'checklist',
					'items'   => array(
						'Daily food distribution',
						'Community Kitchen services',
						'Ramadan Iftar support',
						'Ration kit distribution',
						'Clothing assistance',
						'Medical support initiatives',
						'Welfare and emergency relief activities',
					)
				),
				array(
					'type'    => 'text',
					'paragraphs' => array(
						'The prayers, feedback, and support of the community continue motivating the foundation to expand its humanitarian efforts responsibly.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Looking Towards the Future',
					'paragraphs' => array(
						'Daan Foundation remains committed to improving its charitable work and continuing to support vulnerable communities with dignity and compassion. As the organization grows, more community stories, reviews, and volunteer experiences will continue becoming part of this journey — reflecting the impact that collective kindness and charity can create in people\'s lives.'
					)
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Be Part of This Trust',
					'description' => 'Every contribution helps Daan Foundation continue serving communities with honesty and compassion.',
					'button_text' => 'Donate Now',
					'button_url'  => '/donate/',
				),
			),
		),

		'history' => array(
			'title'             => 'The History of Daan Foundation',
			'subtitle'          => 'From a 15-Day Ramadan Effort to a Lasting Humanitarian Mission',
			'hero_description'  => 'The story of how Daan Foundation grew from a small volunteer-led food drive into a continuous mission of service.',
			'gradient'          => 'from-amber-700 to-orange-800',
			'image'             => '/images/about-hero.jpg',
			'button_text'       => 'Donate Now',
			'button_url'        => '/donate/',
			'default_cause'     => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'text',
					'paragraphs' => array(
						'Daan Foundation was not established through corporate planning or large institutional support. It began with a simple humanitarian effort during Ramadan in 2020.',
						'At that time, a small group of volunteers started a food distribution project with a very limited plan. The intention was only to distribute meals from the 15th Roza until the 30th Roza — a total of just 15 days — ending on Eid. It was meant to be a temporary Ramadan initiative to help people facing hardship.',
						'However, as the work continued, the volunteers witnessed the growing needs of poor and vulnerable families. Hunger, unemployment, illness, and financial struggles became increasingly visible, especially during the pandemic period. Because of this, the work did not stop after Eid.',
						'What started as a 15-day Ramadan food project in 2020 gradually transformed into a continuous humanitarian mission.',
						'Since then, Daan Foundation has continued serving communities by regularly distributing food and supporting needy individuals with dignity and compassion.',
						'Over the years, the organization expanded its activities according to community needs. Some of the important humanitarian works carried out by the foundation include:'
					)
				),
				array(
					'type'    => 'checklist',
					'items'   => array(
						'Daily and emergency food distribution',
						'Arrangements of Iftar for fasting individuals during Ramadan',
						'Distribution of ration kits to needy families',
						'Providing old clothes and essential items to poor people',
						'Helping financially struggling families during marriages',
						'Assisting patients in receiving medical treatment',
						'Supporting underprivileged children in education',
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Growth During Difficult Times',
					'paragraphs' => array(
						'The COVID-19 pandemic became an important phase in the foundation\'s journey. During lockdowns, many families lost their sources of income, increasing the need for food and relief work.'
					)
				),
				array(
					'type'    => 'quote',
					'quote'   => 'Necessity is the mother of invention.',
				),
				array(
					'type'    => 'text',
					'paragraphs' => array(
						'Daan Foundation adapted its charitable efforts to meet these challenges. Alongside food distribution, the organization also introduced the Qurbani Easy platform to help Muslims fulfill their Qurbani obligations conveniently during lockdowns and restrictions.',
						'The initiative received positive support, and Qurbani meat was also utilized to prepare and distribute cooked meals among vulnerable communities. Meat from Mannat (vowed) Qurbani is given only to the poor and needy.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'A Mission Built on Service',
					'paragraphs' => array(
						'Daan Foundation\'s journey is unique because it did not begin as a large planned organization. It grew naturally through direct community service and the sincere efforts of volunteers who simply wanted to help people in need.',
						'Today, the foundation continues its mission with the same spirit with which it began in 2020 — serving humanity through food support, charity, healthcare assistance, education support, and welfare initiatives for vulnerable communities.'
					)
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Be Part of the Next Chapter',
					'description' => 'From a 15-day Ramadan effort to a lasting mission — your support keeps this story going.',
					'button_text' => 'Donate Now',
					'button_url'  => '/donate/',
				),
			),
		),

		'annual-report' => array(
			'title'             => 'Annual Impact Report (2023–2026)',
			'subtitle'          => 'A Transparent Look at Our Journey and Impact',
			'hero_description'  => 'Founded in 2020 and officially registered in 2023 — from a small iftar initiative to a daily Community Kitchen in Amroha.',
			'gradient'          => 'from-orange-600 to-amber-600',
			'image'             => '/images/impact-2.jpg',
			'button_text'       => 'Donate Now',
			'button_url'        => '/donate/',
			'default_cause'     => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'text',
					'heading' => 'Foundation Overview',
					'paragraphs' => array(
						'Daan Foundation was founded in 2020 and officially registered in 2023. From humble beginnings as a small iftar initiative, we have grown into an organisation that feeds 100–120 people every day at our Community Kitchen in Amroha and, during Ramadan, serves iftar to 200–300 people every day.'
					)
				),
				array(
					'type'    => 'grid',
					'items'   => array(
						array( 'title' => '100–120', 'desc' => 'People Fed Every Day · Since 2020' ),
						array( 'title' => '200–300', 'desc' => 'Iftar Every Day in Ramadan' ),
						array( 'title' => '365', 'desc' => 'Days of Daily Meals' ),
					)
				),
				array(
					'type'    => 'checklist',
					'heading' => 'Core Mission',
					'items'   => array(
						'Daily meals through Community Kitchen — no individual remains hungry',
						'Serve all without discrimination, regardless of background',
						'Expand food access during Ramadan with large-scale iftar programmes',
						'Support vulnerable families with ration kits throughout the year',
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Community Kitchen',
					'paragraphs' => array(
						'The Community Kitchen is at the heart of everything we do. Every evening, freshly cooked meals are prepared and distributed to labourers, families, elderly individuals, and anyone in need.',
						'Approximate cost per meal: ' . $meal . '. Operating daily since 2020, the Community Kitchen feeds 100–120 people every day — one plate at a time.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Ramadan Programme',
					'paragraphs' => array(
						'What began as a small iftar for a few families has grown into a large-scale Ramadan programme. During Ramadan, we serve iftar to 200–300 people every day and distribute ration kits to struggling families throughout the holy month. Our volunteer-driven team works tirelessly to ensure every family is served.'
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'Looking Ahead',
					'items'   => array(
						array( 'title' => 'Expand Community Kitchens', 'desc' => 'Open additional community kitchen locations to serve more areas.' ),
						array( 'title' => 'Increase Daily Capacity', 'desc' => 'Grow the number of meals prepared and distributed every evening.' ),
						array( 'title' => 'Strengthen Ramadan Outreach', 'desc' => 'Expand our Ramadan iftar and ration distribution programmes.' ),
						array( 'title' => 'Support More Families', 'desc' => 'Reach more vulnerable families with food, livelihood, and welfare support.' ),
					)
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Help Us Grow Our Impact',
					'description' => 'Your donation fuels our mission to serve more meals, reach more families, and build a hunger-free future.',
					'button_text' => 'Donate Now',
					'button_url'  => '/donate/',
				),
			),
		),

		'serving-with-dignity' => array(
			'title'             => 'Serving Every Needy Person With Dignity',
			'subtitle'          => 'Kindness, Respect, and Humanity for Every Person We Serve',
			'hero_description'  => 'Every person deserves dignity and compassionate support, regardless of financial condition, age, health, or circumstance.',
			'gradient'          => 'from-red-600 to-orange-700',
			'image'             => '/images/aid-distribution-elderly.jpg',
			'button_text'       => 'Donate Now',
			'button_url'        => '/donate/',
			'default_cause'     => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'text',
					'paragraphs' => array(
						'Daan Foundation believes that every person deserves dignity, compassion, and respectful humanitarian support, regardless of financial condition, age, health, or personal circumstances.',
						'Since 2020, the foundation has worked among local communities in India through food distribution, Community Kitchen services, Ramadan Iftar arrangements, ration support, clothing assistance, medical help, and welfare initiatives for vulnerable families.'
					)
				),
				array(
					'type'    => 'quote',
					'quote'   => 'The organization\'s mission is simple: to help people facing hardship with kindness, respect, and humanity.',
				),
				array(
					'type'    => 'text',
					'heading' => 'Supporting Vulnerable Communities',
					'paragraphs' => array(
						'Many people facing poverty or emergencies also struggle with additional challenges such as old age, illness, disability, unemployment, or lack of family support.',
						'These difficulties often make it harder for them to arrange food, healthcare, or other basic necessities. Daan Foundation believes humanitarian support should reach every vulnerable person with dignity and compassion.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Community-Based Humanitarian Work',
					'paragraphs' => array(
						'As a community-focused charitable organization working within India, Daan Foundation understands that every family\'s needs are different. Because of this, the foundation tries to ensure that its support remains respectful, compassionate, accessible, and community-centered.',
						'Whether through cooked meal distribution, ration kits, or welfare support, volunteers work directly among communities to identify and assist people in need.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Listening to People & Understanding Their Needs',
					'paragraphs' => array(
						'Daan Foundation believes real humanitarian work begins with listening to people. The organization regularly interacts with poor families, laborers, elderly individuals, women, patients, and local community members.',
						'This direct connection helps the foundation understand local needs more effectively and improve its charitable activities responsibly.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Supporting People With Respect',
					'paragraphs' => array(
						'The foundation believes charity should always protect the dignity of the people receiving support. During food distribution, Ramadan Iftar programs, Community Kitchen services, and welfare activities, volunteers try their best to maintain kindness, respectful behavior, and compassion toward every individual.',
						'Special attention is often given to elderly people, widows, patients, poor families, and individuals facing serious financial hardship.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Building Stronger Communities Together',
					'paragraphs' => array(
						'Daan Foundation believes meaningful humanitarian work becomes possible when communities come together through charity, volunteer efforts, compassion, and collective responsibility.',
						'Every meal distributed and every family supported reflects the generosity of donors, volunteers, and supporters who believe in helping humanity sincerely.'
					)
				),
				array(
					'type'    => 'notice',
					'heading' => 'Our Mission in India',
					'content' => 'Daan Foundation operates only within India and focuses entirely on charitable and humanitarian activities for local communities. The organization does not operate internationally and does not conduct activities outside India.',
				),
				array(
					'type'    => 'text',
					'heading' => 'Continuing the Journey of Humanity',
					'paragraphs' => array(
						'Since its beginning in 2020, Daan Foundation has continued growing through the support of local communities, volunteers, and donors. The foundation remains committed to ensuring that no vulnerable person feels ignored and that humanitarian support reaches people with dignity, care, and compassion.'
					)
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Help Us Serve With Dignity',
					'description' => 'Your support helps ensure every person we reach is treated with kindness, respect, and humanity.',
					'button_text' => 'Donate Now',
					'button_url'  => '/donate/',
				),
			),
		),

		'supporting-women' => array(
			'title'             => 'Supporting Women With Dignity & Care',
			'subtitle'          => 'No Woman Should Sleep Hungry',
			'hero_description'  => 'Every woman deserves dignity, care, respect, and access to basic necessities such as food, healthcare, and community support.',
			'gradient'          => 'from-orange-700 to-amber-800',
			'image'             => '/images/extra-6.jpg',
			'button_text'       => 'Donate Now',
			'button_url'        => '/donate/',
			'default_cause'     => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'text',
					'paragraphs' => array(
						'Daan Foundation believes that every woman deserves dignity, care, respect, and access to basic necessities such as food, healthcare, and community support.',
						'Across many communities, women — especially housewives, widows, elderly women, and pregnant mothers — often silently carry the burden of financial hardship, household responsibilities, and family care. During difficult times, many women prioritize feeding their children and families before themselves.'
					)
				),
				array(
					'type'    => 'quote',
					'quote'   => 'Daan Foundation believes that no woman should sleep hungry.',
				),
				array(
					'type'    => 'text',
					'heading' => 'Our Commitment to Women & Families',
					'paragraphs' => array(
						'Since 2020, Daan Foundation has worked continuously through food distribution, Community Kitchen services, Ramadan Iftar arrangements, ration kit distribution, and welfare support for vulnerable families in India. The organization remains committed to supporting women facing hardship by ensuring that, wherever possible, families receive food support, struggling mothers receive assistance, and vulnerable women are treated with dignity and respect.',
						'The foundation especially understands the importance of helping housewives from financially struggling households, widows, elderly women, pregnant women, and mothers caring for children during difficult situations.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Food Is a Basic Human Need',
					'paragraphs' => array(
						'Daan Foundation believes that one of the most important responsibilities of humanitarian work is ensuring people have access to food.',
						'For women managing homes under financial pressure, arranging daily meals can become emotionally and physically exhausting. Pregnant women and mothers require proper nutrition and care not only for themselves, but also for the health and wellbeing of their children.',
						'Through its Community Kitchen and food support initiatives, Daan Foundation tries to ensure that vulnerable women and families receive cooked meals, ration kits, and emergency support whenever possible.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Working Towards Women\'s Support & Empowerment',
					'paragraphs' => array(
						'Daan Foundation understands that helping women is not limited only to food support. Real community welfare also means listening to women\'s needs, respecting their dignity, supporting struggling families, and encouraging community compassion toward vulnerable women.',
						'The organization remains willing and committed to supporting women through humanitarian and welfare initiatives within its capacity and available resources.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Compassion During Difficult Times',
					'paragraphs' => array(
						'Many women facing poverty or emergencies continue caring for their families while silently struggling themselves.',
						'Daan Foundation believes humanitarian support should reach such women with kindness and respect — without discrimination and without making them feel ignored, whether through cooked meal distribution, Ramadan Iftar support, ration assistance, clothing support, or medical help.',
						'The organization tries its best to stand beside vulnerable families and women during difficult moments.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Building a More Compassionate Community',
					'paragraphs' => array(
						'Daan Foundation believes stronger communities are built when people come together to support vulnerable families with compassion and responsibility. The foundation continues working through the support of donors, volunteers, local communities, and people who believe in helping humanity sincerely.',
						'Every meal distributed and every family supported represents a shared effort to reduce hardship and bring dignity, comfort, and hope to people in need.'
					)
				),
				array(
					'type'    => 'notice',
					'heading' => 'Our Ongoing Mission',
					'content' => 'Daan Foundation operates only within India and remains committed to community-based humanitarian and charitable work. Its mission remains simple: to serve humanity with compassion, dignity, and responsibility.',
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Help Support Women in Need',
					'description' => 'Your donation helps ensure vulnerable women and mothers receive food, care, and dignity.',
					'button_text' => 'Donate Now',
					'button_url'  => '/donate/',
				),
			),
		),

		'donation-is-trust' => array(
			'title'             => 'Your Donation Is a Trust',
			'subtitle'          => 'An Amanah — Used Honestly, Carefully, Responsibly',
			'hero_description'  => 'Every donation given by supporters is a trust that must be used responsibly to help people in need.',
			'gradient'          => 'from-amber-600 to-orange-800',
			'image'             => '/images/ration-kit-front.jpg',
			'button_text'       => 'Donate Now',
			'button_url'        => '/donate/',
			'default_cause'     => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'text',
					'paragraphs' => array(
						'Daan Foundation believes that every donation given by supporters is a trust — an amanah — that must be used responsibly, honestly, and carefully to help people in need.',
						'Since 2020, the foundation has continued serving vulnerable communities within India through food distribution, Community Kitchen services, Ramadan Iftar arrangements, ration support, clothing assistance, medical help, educational support, and welfare initiatives.',
						'The foundation operates only within India and focuses entirely on helping local communities and families facing hardship.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Our Main Mission: Feeding the Hungry',
					'paragraphs' => array(
						'Through its Community Kitchen and food support initiatives, the organization regularly distributes cooked meals and food assistance to laborers, poor families, elderly individuals, patients, travelers, and people struggling during difficult situations.',
						'What started in 2020 as a small 15-day Ramadan food initiative gradually became a continuous humanitarian effort serving communities throughout the year.'
					)
				),
				array(
					'type'    => 'quote',
					'quote'   => 'To help ensure that no needy person sleeps hungry.',
				),
				array(
					'type'    => 'text',
					'heading' => 'Beyond Food: Supporting Humanity',
					'paragraphs' => array(
						'Although food support remains the foundation\'s central mission, Daan Foundation also works for other humanitarian causes within its capacity and available resources. These efforts include:'
					)
				),
				array(
					'type'    => 'checklist',
					'items'   => array(
						'Distributing clothes to needy individuals',
						'Helping patients receive medical support',
						'Supporting education for poor children',
						'Assisting financially struggling families during marriages, especially helping poor girls and their families',
						'Supporting small livelihood efforts to help people move toward self-reliance',
					)
				),
				array(
					'type'    => 'text',
					'paragraphs' => array(
						'The organization believes humanitarian work is not only about temporary relief but also about helping people regain stability and dignity in their lives.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Transparency & Responsibility',
					'paragraphs' => array(
						'Daan Foundation understands that donors place trust in the organization when they contribute through Zakat, Sadaqah, charity donations, food support, or community welfare contributions.',
						'Like every organization involved in regular charitable work, certain operational and management expenses are necessary to continue activities effectively and consistently — including transportation, food preparation, packaging, volunteer coordination, communication, community outreach, and basic operational support.',
						'The organization believes honesty and transparency are more important than unrealistic promises.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Why Trust Matters',
					'paragraphs' => array(
						'Daan Foundation believes trust is built through consistent humanitarian work, responsible use of donations, direct community engagement, and sincere service to humanity.',
						'Since 2020, families across Amroha have benefited from the foundation\'s charitable efforts through daily meal distribution, Ramadan Iftar programs, ration kit support, clothing distribution, medical assistance, and welfare activities.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Supporting Small Livelihood Efforts',
					'paragraphs' => array(
						'Alongside relief work, Daan Foundation also believes in helping people become more self-dependent wherever possible, encouraging livelihood opportunities and helping people move toward financial stability and self-reliance.',
						'The foundation believes even small opportunities can help restore confidence, dignity, and hope.'
					)
				),
				array(
					'type'    => 'notice',
					'heading' => 'Working Only Within India',
					'content' => 'Daan Foundation works only within India and focuses entirely on humanitarian and charitable activities for communities in need inside the country. The organization does not operate internationally and is not authorized to receive donations or conduct activities outside India.',
				),
				array(
					'type'        => 'cta',
					'heading'     => 'A Mission Built on Compassion',
					'description' => 'Every meal distributed and every family helped represents the trust of people who believe in helping humanity sincerely.',
					'button_text' => 'Donate Now',
					'button_url'  => '/donate/',
				),
			),
		),

		'empowering-livelihoods' => array(
			'title'             => 'Empowering Lives Through Sustainable Livelihoods',
			'subtitle'          => 'True Charity Goes Beyond Immediate Relief',
			'hero_description'  => 'It helps people stand on their own feet — small, meaningful support tailored to real needs.',
			'gradient'          => 'from-orange-800 to-red-700',
			'image'             => '/images/extra-3.jpg',
			'button_text'       => 'Donate Now',
			'button_url'        => '/donate/',
			'default_cause'     => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'text',
					'heading' => 'Our Approach',
					'paragraphs' => array(
						'We believe in empowering individuals to become self-reliant. Our approach is simple yet effective: identify willing individuals who want to improve their livelihoods, understand their existing skills and opportunities, provide small, meaningful support tailored to their needs, and help them become self-reliant and independent.'
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'Types of Livelihood Support',
					'items'   => array(
						array( 'title' => 'Small Business Support', 'desc' => 'Helping individuals set up grocery stores, street vending, and other small businesses.' ),
						array( 'title' => 'Food Cart Setup', 'desc' => 'Providing ice cream and food cart setups for street vendors to earn a steady income.' ),
						array( 'title' => 'Sewing Machines for Women', 'desc' => 'Equipping women with sewing machines for home-based tailoring work.' ),
						array( 'title' => 'Skill-Based Support', 'desc' => 'Identifying existing skills and providing targeted support to enhance them.' ),
					)
				),
				array(
					'type'    => 'testimonials',
					'heading' => 'Stories of Empowerment',
					'items'   => array(
						array( 'quote' => 'With support from Daan Foundation, Rafiq started a street cart business. Today, he earns a steady income and supports his family independently.', 'name' => 'Rafiq' ),
						array( 'quote' => 'Shabana received a sewing machine and started stitching clothes from home. She now earns enough to support her children\'s education.', 'name' => 'Shabana' ),
						array( 'quote' => 'Imran received help to improve his general store. With better stock and setup, his business grew and his family\'s livelihood improved significantly.', 'name' => 'Imran' ),
					)
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Help Someone Stand on Their Own Feet',
					'description' => 'Your donation can provide the tools and support someone needs to build a sustainable livelihood.',
					'button_text' => 'Donate Now',
					'button_url'  => '/donate/',
				),
			),
		),

		'why-transparency' => array(
			'title'             => 'Why Daan Foundation Does Not Follow a "100% Donation Policy"',
			'subtitle'          => 'Honest About How Your Donation Is Used',
			'hero_description'  => 'Transparency and effective service matter more to us than unrealistic promises.',
			'gradient'          => 'from-amber-700 to-orange-700',
			'image'             => '/images/extra-2.jpg',
			'button_text'       => 'Donate Now',
			'button_url'        => '/donate/',
			'default_cause'     => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'text',
					'paragraphs' => array(
						'Daan Foundation believes that transparency, honesty, and effective service are essential parts of charitable work. Many people ask an important question when donating:'
					)
				),
				array(
					'type'    => 'quote',
					'quote'   => 'Does 100% of my donation directly reach the needy?',
				),
				array(
					'type'    => 'text',
					'paragraphs' => array(
						'While the intention behind this question is understandable and sincere, the reality of humanitarian work is more practical and complex. Like many responsible charities around the world, Daan Foundation believes that a strict "100% donation policy" is neither fully practical nor sustainable for long-term humanitarian service. Instead, we focus on an even more important question:'
					)
				),
				array(
					'type'    => 'quote',
					'quote'   => 'How effectively and transparently is my donation being used to help people?',
				),
				array(
					'type'    => 'text',
					'heading' => 'Why Humanitarian Work Has Operational Costs',
					'paragraphs' => array(
						'Providing food, ration kits, medical help, clothing, educational support, and community welfare services requires more than donations alone. Every charitable activity involves real operational and administrative expenses. For example:'
					)
				),
				array(
					'type'    => 'checklist',
					'items'   => array(
						'Transportation for delivering food and ration kits',
						'Packaging and storage expenses',
						'Fuel and travel costs',
						'Digital payment systems and website maintenance',
						'Communication and coordination expenses',
						'Volunteer support and field operations',
						'Documentation, accountability, and transparency systems',
						'Emergency response arrangements during crises',
					)
				),
				array(
					'type'    => 'text',
					'paragraphs' => array(
						'Without these systems, humanitarian work cannot function effectively or consistently.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Serving Communities Responsibly',
					'paragraphs' => array(
						'Since 2020, Daan Foundation has continuously distributed food and supported vulnerable families through various welfare initiatives. Maintaining regular charitable work over several years requires planning, coordination, and sustainable systems.',
						'Our goal is not only to distribute assistance, but also to maintain trust, accountability, and long-term continuity in serving communities.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Zakat Is the Exception',
					'paragraphs' => array(
						'One exception is Zakat. Islamic rulings do not allow Zakat to be spent on salaries, gas, packing, rent, transport or other running costs, so every rupee of Zakat goes to eligible recipients, who receive it as their own. Zakat is kept in a separate account. Our running costs are met only from general donations and Sadaqah.',
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Transparency Matters More Than Slogans',
					'paragraphs' => array(
						'Sometimes organizations promote "100% donation" claims without clearly explaining how operational costs are actually managed. Daan Foundation believes donors deserve complete honesty regarding how charitable activities are carried out.',
						'We believe transparency builds stronger trust than unrealistic promises.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Administrative Support Helps Increase Impact',
					'paragraphs' => array(
						'Operational and administrative systems are not separate from humanitarian work — they help make humanitarian work possible, enabling the organization to reach more families, respond during emergencies, and maintain consistent food distribution.',
						'Without proper infrastructure and coordination, even the best intentions may fail to create lasting impact.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'A Trust Built on Service',
					'paragraphs' => array(
						'The foundation continues its work through the trust of donors, volunteers, and supporters who believe in helping humanity sincerely and responsibly.',
						'Every contribution — whether Zakat, Sadaqah, food support, ration assistance, clothing, or medical help — plays a role in bringing relief and hope to vulnerable families.'
					)
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Give With Confidence',
					'description' => 'Daan Foundation remains committed to serving humanity with compassion, honesty, and responsibility.',
					'button_text' => 'Donate Now',
					'button_url'  => '/donate/',
				),
			),
		),

		'our-work' => array(
			'title'             => 'Our Work',
			'subtitle'          => 'How Your Donations Become Real, Everyday Support',
			'hero_description'  => 'Explore how Daan Foundation puts your donations to work — our impact, history, transparency, and the people and causes behind every rupee given.',
			'gradient'          => 'from-orange-600 to-orange-700',
			'image'             => '/images/hero-2.jpg',
			'button_text'       => 'Donate Now',
			'button_url'        => '/donate/',
			'default_cause'     => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'text',
					'heading' => 'Committed to Transparency and Real Impact',
					'paragraphs' => array(
						'Since 2020, Daan Foundation has grown from a small Ramadan Iftar effort in Amroha, Uttar Pradesh into a continuous humanitarian mission serving communities across India — through Zakat, Sadaqah, community kitchens, and emergency relief.',
						'This page brings together our impact, our history, how we handle every donation, and the people whose lives your generosity supports directly.',
					)
				),
				array(
					'type'    => 'linkgrid',
					'heading' => 'Explore Our Work',
					'items'   => array(
						array( 'title' => 'Our Impact', 'desc' => 'A 6-Year Journey of Compassion, Growth & Service', 'url' => '/our-work/impact/' ),
						array( 'title' => 'Your Charity in Action', 'desc' => 'Every Donation Becomes a Meal, a Kit, a Moment of Relief', 'url' => '/our-work/charity-in-action/' ),
						array( 'title' => 'Community Trust & Feedback', 'desc' => 'The True Strength of Our Work Is Reflected in the Trust of Those We Serve', 'url' => '/our-work/community-trust/' ),
						array( 'title' => 'The History of Daan Foundation', 'desc' => 'From a 15-Day Ramadan Effort to a Lasting Humanitarian Mission', 'url' => '/our-work/history/' ),
						array( 'title' => 'Annual Impact Report', 'desc' => 'A Transparent Look at Our Journey and Impact', 'url' => '/our-work/annual-report/' ),
						array( 'title' => 'Serving With Dignity', 'desc' => 'Kindness, Respect, and Humanity for Every Person We Serve', 'url' => '/our-work/serving-with-dignity/' ),
						array( 'title' => 'Supporting Women With Dignity', 'desc' => 'No Woman Should Sleep Hungry', 'url' => '/our-work/supporting-women/' ),
						array( 'title' => 'Your Donation Is a Trust', 'desc' => 'An Amanah — Used Honestly, Carefully, Responsibly', 'url' => '/our-work/donation-is-trust/' ),
						array( 'title' => 'Empowering Livelihoods', 'desc' => 'True Charity Goes Beyond Immediate Relief', 'url' => '/our-work/empowering-livelihoods/' ),
						array( 'title' => 'Why Transparency Matters', 'desc' => 'Honest About How Your Donation Is Used', 'url' => '/our-work/why-transparency/' ),
					)
				),
			),
		),
	);

	// Filter out faq placeholders — they have 'faq' type but no 'items' for demo
	// Return the page data or null if not found.
	if ( ! isset( $pages[ $slug ] ) ) {
		return null;
	}

	return $pages[ $slug ];
}

/**
 * Open the sidebar page layout wrapper.
 *
 * @param string $default_cause Default cause for donation sidebar.
 */
function daan_sidebar_page_start( $default_cause = 'where-needed' ) {
	// The page's own cause is pre-selected in the sidebar (Community Kitchen page → meals, Fitrana page → kit, ...).
	$GLOBALS['daan_sidebar_cause'] = function_exists( 'daan_cause_from_link' ) ? daan_cause_from_link( $default_cause ) : '';
	?>
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-12">
		<div class="lg:grid lg:grid-cols-3 lg:gap-10">
			<div class="lg:col-span-2 space-y-10">
	<?php
}

/**
 * Close the sidebar page layout wrapper and render the donation sidebar.
 */
function daan_sidebar_page_end() {
	?>
			</div>
			<aside class="lg:col-span-1 mt-8 lg:mt-0">
				<div class="lg:sticky lg:top-24">
					<?php get_template_part( 'template-parts/donation-sidebar' ); ?>
				</div>
			</aside>
		</div>
	</div>
	<?php
}
