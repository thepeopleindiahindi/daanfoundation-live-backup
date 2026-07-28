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
						'Daan Foundation\'s Community Kitchen is a daily mission to fight hunger across India, serving free, nutritious meals to thousands of individuals and families. Every single evening, our dedicated team prepares and distributes freshly cooked meals, ensuring that no one in our community goes to bed hungry. What began as a small iftar distribution effort during Ramadan 2020 has blossomed into a full-scale, year-round feeding programme that touches countless lives.',
						'Since our inception, we have served over 500,000 meals, each one prepared with care and delivered with dignity. Our kitchen operates on the simple yet profound belief that access to food is a fundamental human right, and we are committed to upholding that right for every person who comes to us. The cost of providing each meal is just ₹59, a small price for the immense impact it carries.',
						'We serve all community members without any discrimination of caste, creed, religion, or background. Every person who walks through our doors is welcomed with respect and offered a warm, nutritious meal. Our commitment to inclusive service has made the Community Kitchen a trusted and beloved institution in the communities we serve.'
					)
				),
				array(
					'type'    => 'grid',
					'heading' => '500,000+ Meals Served',
					'items'   => array(
						array( 'icon' => 'rice', 'title' => '500,000+ Meals', 'desc' => 'Served since 2020 with love and care' ),
						array( 'icon' => 'rupee', 'title' => '₹59/Meal', 'desc' => 'Cost to provide one nutritious meal' ),
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
						'Our volunteers are trained to serve with a smile, to make eye contact, and to treat every recipient with the warmth and dignity they deserve. This approach has created an atmosphere of trust and mutual respect that sets our Community Kitchen apart from traditional food distribution programmes.'
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
						'Our vision is to expand the Community Kitchen model to cities across India, establishing a network of kitchens that serve fresh, nutritious meals to all who need them. We are actively working on partnerships with local governments, businesses, and community organisations to make this vision a reality. The goal is to reach a million meals annually within the next three years.',
						'With your support, we can scale our operations, improve our infrastructure, and reach even more vulnerable communities. Every contribution, no matter how small, brings us one step closer to a hunger-free India where no one is left behind.'
					)
				),
				array(
					'type'    => 'notice',
					'heading' => 'Serving Humanity Since 2020',
					'content' => 'Daan Foundation\'s Community Kitchen has been serving free meals with dignity and compassion since our founding in Ramadan 2020. Over 500,000 meals served and counting.',
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Join This Mission of Humanity',
					'description' => 'Your contribution of just ₹59 can provide a nutritious meal to someone in need. Together, we can ensure that no one goes to bed hungry.',
					'button_text' => 'Support the Kitchen',
					'button_url'  => '/donate?cause=community-kitchen',
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
						'Zakat is one of the Five Pillars of Islam, an obligatory act of worship that requires Muslims who possess wealth above a certain threshold (known as Nisab) to give 2.5% of their accumulated wealth annually to those in need. It is not merely a charitable recommendation but a divine commandment that purifies one\'s wealth and blesses what remains. Zakat serves as a powerful mechanism for wealth redistribution, ensuring that the more fortunate members of society support the less fortunate.',
						'The Qur\'an explicitly mentions eight categories of Zakat recipients: the poor, the needy, Zakat administrators, those whose hearts are to be reconciled, those in bondage, those in debt, in the cause of Allah, and the wayfarer. By fulfilling this obligation, Muslims not only comply with a fundamental tenet of their faith but also contribute to building a more equitable and compassionate society.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Zakat in the Light of the Qur\'an',
					'paragraphs' => array(
						'Allah says in the Qur\'an: "And those in whose wealth there is a known right, for the one who asks and the one who is deprived." (Qur\'an 70:24-25). This powerful verse reminds us that wealth is a trust from Allah, and embedded within it is a right that belongs to those who are in need.',
						'The institution of Zakat is mentioned alongside prayer (Salah) in over 80 verses of the Qur\'an, highlighting its fundamental importance in Islamic practice. It is a comprehensive system of social welfare that, when properly implemented, has the power to eliminate poverty from society.'
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'How Daan Foundation Uses Zakat',
					'items'   => array(
						array( 'icon' => 'utensils', 'title' => 'Community Kitchen', 'desc' => 'Daily free meals for the hungry and underprivileged' ),
						array( 'icon' => 'moon', 'title' => 'Ramadan Iftar', 'desc' => 'Iftar meals for fasting individuals during Ramadan' ),
						array( 'icon' => 'package', 'title' => 'Ration Kits', 'desc' => 'Essential food supplies for families in need' ),
						array( 'icon' => 'shirt', 'title' => 'Clothing Support', 'desc' => 'New and gently used clothing for those in need' ),
						array( 'icon' => 'heart-pulse', 'title' => 'Medical Assistance', 'desc' => 'Healthcare support and emergency medical aid' ),
						array( 'icon' => 'book', 'title' => 'Educational Support', 'desc' => 'School supplies and educational sponsorship for children' ),
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Community Kitchen & Food Support',
					'paragraphs' => array(
						'Your Zakat funds directly support our flagship Community Kitchen programme, which serves free meals to thousands of individuals every single day. We serve widows, orphans, daily wage labourers, homeless individuals, elderly persons, disabled persons, low-income families, and students who cannot afford proper meals. Each meal costs just ₹59, meaning your Zakat can provide hundreds of meals to those who need them most.',
						'Since our founding, we have distributed over 500,000 meals through our Community Kitchen. Your Zakat ensures that this vital work continues and expands to reach even more vulnerable communities across India.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Nisab — The Threshold for Zakat',
					'paragraphs' => array(
						'Zakat becomes obligatory when a Muslim\'s wealth exceeds the Nisab threshold and a full lunar year has passed. The Nisab is calculated based on the value of 87.48 grams of gold or 612.36 grams of silver. As of the current rates, the silver Nisab is approximately ₹45,000, making it more accessible for many Muslims to participate in this blessed obligation.',
						'The gold Nisab is approximately ₹6,50,000 based on prevailing gold prices. Many scholars recommend using the silver Nisab as the benchmark, as it allows more people to fulfil this obligation and maximises the benefit to those in need. For Fitrana (Zakat al-Fitr), which is a separate obligation, the amount is approximately ₹60 per person, given before Eid prayer.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'What is Fitrana (Zakat al-Fitr)?',
					'paragraphs' => array(
						'Fitrana, also called Zakat al-Fitr, is a charitable donation given before Eid prayer at the end of Ramadan. It is meant to help poor and needy people so they can also celebrate Eid with dignity and happiness.',
						'Through Ramadan food distribution and ration support activities, Daan Foundation tries to help vulnerable families during the holy month. Visit our dedicated Zakat al-Fitr page to learn more and contribute.'
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
						'We take our responsibility in handling Zakat funds with the utmost seriousness. Every rupee of your Zakat is meticulously tracked and allocated to programmes that directly benefit eligible recipients. We follow religious guidelines meticulously, ensuring that Zakat funds are distributed only to those who qualify under the eight categories defined in the Qur\'an.',
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
						array( 'q' => 'What is Zakat?', 'a' => 'Zakat is one of the five pillars of Islam. It is a mandatory charitable contribution, typically 2.5% of a Muslim\'s total savings and wealth above a minimum amount known as the Nisab.' ),
						array( 'q' => 'Who must pay Zakat?', 'a' => 'Zakat is obligatory for every adult Muslim who owns wealth above the Nisab threshold for one lunar year. The wealth must be in excess of basic needs and debts.' ),
						array( 'q' => 'What is the Nisab?', 'a' => 'The Nisab is the minimum amount of wealth a Muslim must possess before Zakat becomes obligatory. It is calculated based on the value of gold (87.48 grams) or silver (612.36 grams).' ),
						array( 'q' => 'How is Zakat calculated?', 'a' => 'Zakat is calculated as 2.5% of your total zakatable assets minus any debts. Zakatable assets include cash, savings, investments, gold, silver, and business inventory.' ),
						array( 'q' => 'When should I pay Zakat?', 'a' => 'Zakat is due once a full lunar year has passed since your wealth exceeded the Nisab. Many Muslims choose to pay during Ramadan for increased blessings.' ),
						array( 'q' => 'Who can receive Zakat?', 'a' => 'There are eight categories of Zakat recipients mentioned in the Qur\'an: the poor, the needy, Zakat administrators, those whose hearts are to be reconciled, freeing captives, those in debt, in the cause of Allah, and travellers in need.' ),
					),
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Ready to Pay Your Zakat?',
					'description' => 'Fulfil your sacred obligation today and transform lives across India. Your Zakat is a powerful act of worship that brings barakah to your wealth and hope to those in need.',
					'button_text' => 'Pay Your Zakat',
					'button_url'  => '/donate?cause=zakat',
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
						'Sadaqah is a voluntary act of charity given purely for the sake of Allah, without any obligation or fixed amount. Unlike Zakat, which is an obligatory pillar of Islam with specific rules and calculations, Sadaqah can be given at any time, in any amount, and in any form — including kind words, a smile, or any act of goodness. The Prophet Muhammad (peace be upon him) said, "Every act of goodness is Sadaqah."',
						'The beauty of Sadaqah lies in its flexibility and accessibility. Anyone, regardless of their financial circumstances, can give Sadaqah. A kind word to someone who is distressed, helping a neighbour with their chores, or simply smiling at a stranger — all of these are forms of Sadaqah that are beloved to Allah.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'The Meaning of Sadaqah',
					'paragraphs' => array(
						'The word Sadaqah is derived from the Arabic root Sidq, which means truthfulness and sincerity. This etymological connection reminds us that true charity emanates from a genuine and sincere heart, reflecting the truth of one\'s faith through action. When we give Sadaqah, we are not merely transferring wealth — we are expressing the depth of our faith and our connection to humanity.',
						'Allah says in the Qur\'an: "Who is it that would loan Allah a goodly loan so He may multiply it for him many times over?" (Qur\'an 2:245). This beautiful verse describes charity as a loan to Allah Himself, promising abundant returns in this life and the next. The Prophet Muhammad (peace be upon him) said, "Sadaqah extinguishes sin as water extinguishes fire," and "The believer\'s shade on the Day of Resurrection will be his Sadaqah."'
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
						'Your Sadaqah directly supports our Community Kitchen programme, which serves over 500,000 free meals to individuals and families in need. Every contribution helps us prepare and distribute nutritious meals to those who cannot afford them, serving all community members without any discrimination.',
						'Whether you give ₹59 for one meal or ₹5,900 for a hundred meals, every rupee of your Sadaqah creates an immediate and tangible impact in someone\'s life. You can also consider Sadaqah Jariyah (ongoing charity) — a continuous act of charity that continues to benefit people and earn you rewards long after you have given it.'
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
						'Sadaqah has the power to transform both the giver and the receiver. For the giver, it purifies the heart, increases gratitude, and brings immense spiritual rewards. For the receiver, it provides relief from hardship, restores dignity, and offers hope for a better tomorrow. The Prophet Muhammad (peace be upon him) said, "Give Sadaqah without delay, for it stands in the way of calamity."',
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
						array( 'q' => 'What is Sadaqah Jariyah?', 'a' => 'Sadaqah Jariyah is ongoing charity that continues to benefit people and earn rewards for the giver even after death, such as building a well or supporting a community kitchen.' ),
					),
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Every Act of Kindness Counts',
					'description' => 'Give Sadaqah today and be the reason someone smiles. Your voluntary charity can provide meals, education, medical aid, and hope to those who need it most.',
					'button_text' => 'Give Sadaqah Now',
					'button_url'  => '/donate?cause=sadaqah',
				),
			),
		),

		'fidya' => array(
			'title'         => 'Fidya',
			'subtitle'      => 'A charitable compensation for those unable to fast during Ramadan due to valid long-term reasons.',
			'gradient'      => 'from-emerald-600 to-teal-700',
			'image'         => '/images/extra-2.jpg',
			'default_cause' => 'fidya-kaffarah',
			'sections'      => array(
				array(
					'type'    => 'text',
					'heading' => 'What is Fidya?',
					'paragraphs' => array(
						'Fidya is a charitable compensation prescribed for Muslims who are unable to fast during Ramadan due to a valid, long-term reason such as old age or chronic illness. Instead of fasting, the individual must feed one needy person for each day of Ramadan that is missed. This provision reflects the mercy and practicality of Islamic teachings, ensuring that those who genuinely cannot fast can still fulfil their spiritual obligations.',
						'For each missed fast, the fidya amount is equivalent to the cost of feeding one person two meals or providing one meal (sadaqat-ul-fitr). The compensation must be given to those in need, ensuring that the intention of the fast — developing empathy for the hungry and less fortunate — is still fulfilled through the act of feeding others.'
					)
				),
				array(
					'type'    => 'quote',
					'quote'   => '"Fasting is for a fixed number of days. But if any of you is ill or on a journey, the same number of days from other days. And as for those who can fast with difficulty (e.g., old and sick), they have a choice either to fast or to feed a poor person for every day of fasting missed."',
					'source'  => '— Qur\'an 2:184'
				),
				array(
					'type'    => 'checklist',
					'heading' => 'How Daan Foundation Uses Fidya',
					'items'   => array(
						'Providing nutritious meals to the hungry through our Community Kitchen',
						'Distributing ration kits to low-income families and vulnerable individuals',
						'Supporting iftar distributions for the poor during Ramadan',
						'Providing food support to orphans, widows, and elderly persons',
						'Ensuring your Fidya reaches those most in need with complete transparency',
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Community Kitchen',
					'paragraphs' => array(
						'Your Fidya contributions support our Community Kitchen, which provides free, nutritious meals to thousands of individuals every day. Each meal costs just ₹59, and your Fidya can provide multiple meals to those who need them most. We serve all community members regardless of background, ensuring that your compensation reaches the deserving with dignity and respect.',
						'Since 2020, we have served over 500,000 meals through our Community Kitchen programme. By giving your Fidya through Daan Foundation, you are directly contributing to this vital work and ensuring that your spiritual obligation is fulfilled in the most impactful way possible.'
					)
				),
				array(
					'type'    => 'comparison',
					'heading' => 'Who Should Pay Fidya vs Kaffarah',
					'col1'    => array(
						'heading' => 'Fidya',
						'items'   => array(
							'For those permanently unable to fast due to old age or chronic illness',
							'Feed one needy person per missed fast day',
							'Approximately ₹60 per day for 30 days',
							'Based on the cost of a full meal (two meals or one fitrana)',
						)
					),
					'col2'    => array(
						'heading' => 'Kaffarah',
						'items'   => array(
							'For intentionally breaking a fast without valid reason',
							'Fast 60 consecutive days OR feed 60 needy people',
							'Approximately ₹3,540 or fast 60 days',
							'More severe due to the intentional nature of the violation',
						)
					),
				),
				array(
					'type'    => 'notice',
					'heading' => 'Fulfil Your Obligation With Confidence',
					'content' => 'Daan Foundation handles your Fidya with the utmost care and religious compliance, ensuring it reaches those who genuinely need it.',
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Fulfil Your Fidya Today',
					'description' => 'Give your Fidya through Daan Foundation and ensure that your compensation reaches those who need it most. Every contribution goes directly to feeding the hungry.',
					'button_text' => 'Pay Fidya Now',
					'button_url'  => '/donate?cause=fidya-kaffarah',
				),
			),
		),

		'kaffarah' => array(
			'title'         => 'Kaffarah',
			'subtitle'      => 'Feeding those in need through Daan Foundation — fulfil your Kaffarah with compassion.',
			'gradient'      => 'from-red-600 to-rose-700',
			'image'         => '/images/food-distribution-ramadan.jpg',
			'default_cause' => 'fidya-kaffarah',
			'sections'      => array(
				array(
					'type'    => 'text',
					'heading' => 'What is Kaffarah?',
					'paragraphs' => array(
						'Kaffarah (expiation) is a religious obligation for a Muslim who intentionally breaks a fast during Ramadan without a valid Islamic reason. The prescribed expiation is to either fast for 60 consecutive days or, if one is unable to do so, to feed 60 needy people two meals each, providing them with a full day\'s sustenance. This requirement underscores the sanctity of the Ramadan fast and the importance of fulfilling one\'s spiritual commitments.',
						'Kaffarah also applies to other situations such as breaking an oath, where the expiation involves feeding ten needy people, clothing them, or freeing a slave. If none of these are possible, a fast of three days is observed. The severity of Kaffarah reflects the gravity of the violation while still providing a path to redemption and spiritual renewal.'
					)
				),
				array(
					'type'    => 'checklist',
					'heading' => 'How Daan Foundation Uses Kaffarah',
					'items'   => array(
						'Feeding 60 needy people two nutritious meals each through our Community Kitchen',
						'Distributing ration kits containing staple food items to low-income families',
						'Supporting our daily meal programme for the homeless and vulnerable',
						'Providing iftar meals to the poor during Ramadan',
						'Ensuring complete transparency in the distribution of your Kaffarah',
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Community Kitchen',
					'paragraphs' => array(
						'Your Kaffarah directly supports our Community Kitchen, which serves free, nutritious meals to thousands of individuals daily. Each meal costs just ₹59, and feeding 60 people for your Kaffarah amounts to ₹3,540, ensuring 60 individuals receive a full day\'s nourishment. This is a powerful way to transform a spiritual obligation into a tangible act of compassion that directly benefits your community.',
						'Since 2020, we have served over 500,000 meals through our Community Kitchen. By entrusting your Kaffarah to Daan Foundation, you can be confident that your expiation is being fulfilled correctly and that your contribution is making a real difference in the lives of those who need it most.'
					)
				),
				array(
					'type'    => 'comparison',
					'heading' => 'Kaffarah for Broken Fast vs Broken Oath',
					'col1'    => array(
						'heading' => 'Kaffarah for Broken Fast',
						'items'   => array(
							'Applicable when a Ramadan fast is intentionally broken without valid reason',
							'Fast 60 consecutive days without interruption',
							'Or feed 60 needy people (₹3,540 at ₹59/meal × 2 meals × 60 people)',
							'Cannot be waived; must be fulfilled to make up for the broken fast',
						)
					),
					'col2'    => array(
						'heading' => 'Kaffarah for Broken Oath',
						'items'   => array(
							'Applicable when a sworn oath is broken',
							'Feed ten needy people one full meal each',
							'Or clothe ten needy people, or free a slave',
							'If unable, fast for three consecutive days',
						)
					),
				),
				array(
					'type'    => 'notice',
					'heading' => 'Fulfil Your Kaffarah With Confidence',
					'content' => 'Daan Foundation ensures your Kaffarah is distributed according to Islamic guidelines, feeding those in need with dignity and respect.',
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Fulfil Your Kaffarah Today',
					'description' => 'Complete your expiation with confidence through Daan Foundation. Your Kaffarah will provide nutritious meals to those who need them most.',
					'button_text' => 'Pay Kaffarah Now',
					'button_url'  => '/donate?cause=fidya-kaffarah',
				),
			),
		),

		'ramadan' => array(
			'title'         => 'Ramadan With Daan Foundation',
			'subtitle'      => 'Daan Foundation was born during the blessed month of Ramadan in 2020 through a simple humanitarian effort: providing Iftar meals to people in need.',
			'gradient'      => 'from-violet-600 to-purple-700',
			'image'         => '/images/iftaar-distribution.jpg',
			'default_cause' => 'ramadan-iftar',
			'sections'      => array(
				array(
					'type'    => 'text',
					'heading' => 'A Journey Built on Compassion & Trust',
					'paragraphs' => array(
						'Daan Foundation was born during the blessed month of Ramadan in 2020, emerging from a simple yet powerful humanitarian vision: to provide Iftar meals to those in need. What began as a modest 15-day plan to distribute meals during the holy month has grown into a year-round mission serving thousands of people across India. The founders, driven by the spirit of Ramadan, started with a small group of volunteers and limited resources, but their unwavering commitment and the community\'s overwhelming response turned this temporary initiative into a permanent institution of service.',
						'Today, Daan Foundation stands as a testament to what can be achieved when faith meets action. From that first Ramadan, serving a handful of people each evening, we have expanded to provide not just iftar meals but comprehensive support including a daily Community Kitchen, winter aid, medical assistance, educational sponsorship, and much more. The seed planted in Ramadan 2020 has grown into a tree of compassion that shelters thousands.'
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
						'Ramadan is the holiest month in the Islamic calendar, a time of fasting, prayer, reflection, and heightened charity. During this month, Muslims fast from dawn to sunset, experiencing hunger and thirst to develop empathy for the less fortunate. It is a month when rewards for good deeds are multiplied, and the act of feeding a fasting person carries immense spiritual merit.',
						'The Prophet Muhammad (peace be upon him) said, "Whoever feeds a fasting person will have a reward like that of the fasting person, without any reduction in his reward." This beautiful teaching inspires thousands of our donors to contribute generously during Ramadan, ensuring that those who are fasting can break their fast with a nutritious meal provided with love and respect.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Iftar Distribution Since 2020',
					'paragraphs' => array(
						'Since 2020, Daan Foundation has been distributing iftar meals to thousands of people every evening during Ramadan. Our iftar distribution serves daily wage labourers, homeless individuals, orphans, widows, elderly persons, disabled persons, low-income families, students, rickshaw pullers, and construction workers. What began with distributing 1,000 meals in our first year has grown to serving thousands daily by 2025.',
						'Each iftar meal consists of nutritious and fulfilling food, including fruits, dates, snacks, and a main meal, all packed hygienically and distributed with warmth and dignity. Our volunteers ensure that every person receives their meal with a smile and a greeting of "Ramadan Mubarak," making the distribution a truly compassionate experience.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Community Kitchen',
					'paragraphs' => array(
						'Building on the iftar distribution, we established our year-round Community Kitchen that continues the spirit of Ramadan every single day. The kitchen serves free, nutritious meals to anyone in need, 365 days a year, with the same love and dedication that characterised our first Ramadan distribution. Over 500,000 meals have been served since our founding.',
						'The Community Kitchen embodies the Ramadan spirit of generosity throughout the year, ensuring that the hunger-alleviating work that began in the holy month never stops. Each meal costs just ₹59, making every contribution a meaningful investment in human dignity.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Food Without Discrimination',
					'paragraphs' => array(
						'At Daan Foundation, we serve all community members without any discrimination of caste, creed, religion, gender, or background. Our iftar distributions and Community Kitchen are open to everyone who is in need. We believe that hunger knows no religion, and neither should compassion. This commitment to inclusive service has made us a trusted organisation in the diverse communities we serve.',
						'Our volunteers come from various backgrounds and faiths, united by the common goal of serving humanity. This spirit of unity and inclusivity is the true essence of Ramadan and the core value of Daan Foundation.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'The Spirit of Charity in Ramadan',
					'paragraphs' => array(
						'The Prophet Muhammad (peace be upon him) was the most generous of people, and his generosity increased during Ramadan when Angel Jibreel would review the Qur\'an with him each night. The Prophet was "more generous than the blowing wind" during this blessed month. This tradition of heightened generosity during Ramadan is one that Daan Foundation strives to embody and facilitate for our donors.',
						'By donating through Daan Foundation during Ramadan, you are continuing a blessed tradition that dates back to the Prophet himself. Your contributions ensure that the blessings of Ramadan reach those who need them most, creating a chain of generosity that uplifts entire communities.'
					)
				),
				array(
					'type'    => 'notice',
					'heading' => 'Serving Since 2020',
					'content' => 'Daan Foundation was born in Ramadan 2020 with a simple iftar distribution. Today, we serve thousands year-round through multiple programmes.',
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Continue the Legacy of Ramadan',
					'description' => 'Support our Ramadan iftar distribution and Community Kitchen. Your contribution continues the blessed tradition of feeding those in need.',
					'button_text' => 'Donate for Ramadan',
					'button_url'  => '/donate?cause=ramadan-iftar',
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
					'button_url'  => '/donate?cause=winter-appeal',
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
						'A significant portion of this fund supports our Community Kitchen, which serves over 500,000 free meals to individuals and families in need. Your donation helps us maintain this vital service daily, ensuring that no one in our community goes hungry. Each meal costs just ₹59, and every contribution translates directly into nourishment for someone in need.',
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
					'button_url'  => '/donate?cause=where-needed',
				),
			),
		),

		'sadaqah-jariyah' => array(
			'title'         => 'Sadaqah Jariyah',
			'subtitle'      => 'Ongoing charity that continues benefiting people, even after the donor has passed away.',
			'gradient'      => 'from-cyan-600 to-teal-700',
			'image'         => '/images/extra-1.jpg',
			'default_cause' => 'community-kitchen',
			'sections'      => array(
				array(
					'type'    => 'text',
					'heading' => 'What is Sadaqah Jariyah?',
					'paragraphs' => array(
						'Sadaqah Jariyah means "ongoing charity" — a virtuous act that continues to benefit others and earn rewards for the giver long after the act itself has been performed. The Prophet Muhammad (peace be upon him) said, "When a person dies, his deeds come to an end except for three: ongoing charity (Sadaqah Jariyah), beneficial knowledge, or a righteous child who prays for him." (Sahih Muslim). This hadith highlights the unique power of Sadaqah Jariyah as a means of continuous spiritual reward even after death.',
						'Unlike one-time charity, Sadaqah Jariyah creates a lasting impact that keeps giving. It is an investment in the hereafter, a way to ensure that your legacy of goodness continues to benefit humanity and earn you rewards long after you have left this world. The beauty of this concept is that the donor continues to receive rewards for every single benefit that stems from their original act of giving.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Why It Is Important',
					'paragraphs' => array(
						'Sadaqah Jariyah represents the highest form of charitable giving in Islam because of its enduring impact. When you contribute to a project that continues to serve people year after year, every meal served, every person helped, and every life touched becomes a source of reward for you. This is the ultimate form of investment — one that pays dividends in the hereafter.',
						'For those who wish to leave a lasting legacy of goodness, Sadaqah Jariyah is the perfect vehicle. It ensures that your name continues to be associated with acts of compassion and service, and that you continue to earn rewards even after you are no longer in a position to perform good deeds yourself.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Sadaqah Jariyah at Daan Foundation',
					'paragraphs' => array(
						'Daan Foundation offers several opportunities for Sadaqah Jariyah, with our Community Kitchen being the most impactful example. Every day, our kitchen serves hundreds of free meals to those in need, and this will continue as long as we have the resources to operate. By contributing to our Community Kitchen or other ongoing programmes, you are establishing a stream of continuous charity that will benefit people for years to come.',
						'Every meal served from your contribution, every person nourished, every life touched — all of these become ongoing acts of charity that earn you rewards. This is the essence of Sadaqah Jariyah, and it is one of the most powerful ways to invest in your eternal future while making a tangible difference in the present.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Community Kitchen',
					'paragraphs' => array(
						'Our Community Kitchen is the ideal vehicle for Sadaqah Jariyah. With over 500,000 meals served since 2020, it is a proven, sustainable programme that continues to grow and serve more people every year. Your contribution to the kitchen ensures that free, nutritious meals are provided to those in need every single day, creating a perpetual stream of rewards for you.',
						'Each meal costs just ₹59, making it accessible for anyone to participate in this ongoing charity. Whether you contribute ₹5,900 for 100 meals or ₹59,000 for 1,000 meals, you are establishing a legacy of compassion that will continue to earn rewards long after you have given.'
					)
				),
				array(
					'type'    => 'grid',
					'heading' => 'Examples of Sadaqah Jariyah',
					'items'   => array(
						array( 'icon' => 'utensils', 'title' => 'Feeding the Hungry', 'desc' => 'Support an ongoing meal programme that feeds the hungry daily' ),
						array( 'icon' => 'book', 'title' => 'Education', 'desc' => 'Sponsor a child\'s education for lasting impact' ),
						array( 'icon' => 'stethoscope', 'title' => 'Medical Support', 'desc' => 'Fund ongoing healthcare services for the needy' ),
						array( 'icon' => 'briefcase', 'title' => 'Self-Reliance', 'desc' => 'Support livelihood training that enables independence' ),
						array( 'icon' => 'lightbulb', 'title' => 'Knowledge', 'desc' => 'Share beneficial knowledge that continues to guide others' ),
						array( 'icon' => 'leaf', 'title' => 'Environment', 'desc' => 'Plant trees or support environmental sustainability' ),
					)
				),
				array(
					'type'    => 'notice',
					'heading' => 'Earn Rewards That Never Stop',
					'content' => 'Your Sadaqah Jariyah through Daan Foundation continues to earn you rewards for every meal served, every person helped, and every life touched.',
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Give Sadaqah Jariyah Today',
					'description' => 'Invest in your eternal future by supporting our ongoing programmes. Every contribution creates a lasting legacy of compassion that continues to earn rewards.',
					'button_text' => 'Give Ongoing Charity',
					'button_url'  => '/donate?cause=community-kitchen',
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
						'Our volunteers personally distribute the gifts, spending time with the children and making them feel special and loved. The smiles we receive in return are the greatest reward, reminding us why this work is so important. Last year, we brought joy to thousands of children across multiple cities, and with your support, we can reach even more this Eid.'
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
					'button_url'  => '/donate?cause=eid-gifts',
				),
			),
		),

		'zakat-al-fitr' => array(
			'title'         => 'Fitrana (Zakat al-Fitr)',
			'subtitle'      => 'A compulsory charitable donation given before Eid prayer, ensuring everyone can celebrate Eid with dignity.',
			'gradient'      => 'from-indigo-600 to-purple-700',
			'image'         => '/images/iftaar-distribution.jpg',
			'default_cause' => 'ramadan-iftar',
			'sections'      => array(
				array(
					'type'    => 'text',
					'heading' => 'What is Zakat al-Fitr?',
					'paragraphs' => array(
						'Zakat al-Fitr, also known as Fitrana, is a compulsory charitable donation that every Muslim who possesses wealth beyond their basic needs must pay before the Eid al-Fitr prayer. It is a purification of the fast and a means of ensuring that even the poorest members of the community can celebrate Eid with dignity and joy. The amount is approximately ₹60 per person, making it accessible for all who are obligated to give.',
						'The primary purpose of Zakat al-Fitr is to enable the less fortunate to partake in the Eid celebrations and to compensate for any shortcomings in one\'s fast during Ramadan. It is a beautiful expression of Islamic solidarity, ensuring that the joy of Eid is shared by everyone, regardless of their financial circumstances.'
					)
				),
				array(
					'type'    => 'quote',
					'quote'   => 'The Prophet Muhammad (peace be upon him) enjoined Zakat al-Fitr as a purification for the fasting person from any idle or obscene speech, and as food for the needy. Whoever pays it before the Eid prayer, it is an accepted Zakat, and whoever pays it after the prayer, it is merely an ordinary charity.',
					'source'  => '— Sunan Abu Dawud & Ibn Majah'
				),
				array(
					'type'    => 'checklist',
					'heading' => 'How We Use Fitrana',
					'items'   => array(
						'Preparing and distributing nutritious Eid meals for needy families',
						'Providing ration kits containing staple food items for Eid celebration',
						'Supporting our Community Kitchen that serves free meals throughout the year',
						'Distributing food packages to orphans, widows, and elderly persons',
						'Ensuring that the joy of Eid reaches every deserving family in our network',
					)
				),
				array(
					'type'    => 'text',
					'heading' => 'Community Kitchen',
					'paragraphs' => array(
						'Your Fitrana contributions support our Community Kitchen, which serves over 500,000 free meals to individuals and families in need. During Eid, we expand our operations to ensure that everyone can celebrate with a proper meal. Each meal costs just ₹59, and your Fitrana can provide multiple meals to those who need them most.',
						'By giving your Fitrana through Daan Foundation, you ensure that your obligation is fulfilled correctly and that your contribution is maximised to help as many people as possible.'
					)
				),
				array(
					'type'    => 'comparison',
					'heading' => 'Who Should Pay vs Zakat vs Fitrana',
					'col1'    => array(
						'heading' => 'Who Should Pay',
						'items'   => array(
							'Every Muslim who possesses food in excess of their basic needs',
							'Must be paid on behalf of every family member, including dependents',
							'Must be given before the Eid prayer to be valid as Zakat al-Fitr',
							'Approximately ₹60 per person, based on staple food grains',
						)
					),
					'col2'    => array(
						'heading' => 'Zakat vs Fitrana',
						'items'   => array(
							'Zakat is 2.5% of annual wealth; Fitrana is a fixed amount per person',
							'Zakat has a Nisab threshold; Fitrana is obligatory for all who can afford it',
							'Zakat can be given anytime; Fitrana must be given before Eid prayer',
							'Zakat purifies wealth; Fitrana purifies the fast and feeds the needy',
						)
					),
				),
				array(
					'type'    => 'notice',
					'heading' => 'Pay Before Eid Prayer',
					'content' => 'Zakat al-Fitr must be paid before the Eid prayer to be accepted as such. Daan Foundation ensures timely distribution to those in need.',
				),
				array(
					'type'        => 'cta',
					'heading'     => 'Pay Your Fitrana Today',
					'description' => 'Fulfil your obligation and ensure that everyone can celebrate Eid with dignity. Your Fitrana provides food and joy to those who need it most.',
					'button_text' => 'Pay Fitrana Now',
					'button_url'  => '/donate?cause=ramadan-iftar',
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
			'button_url'        => '/donate',
			'default_cause'     => 'where-needed',
			'sections'      => array(
				array(
					'type'    => 'grid',
					'heading' => 'Our Impact in Numbers',
					'items'   => array(
						array( 'title' => '500,000+', 'desc' => 'Meals Distributed' ),
						array( 'title' => '100K+', 'desc' => 'Iftar Kits Distributed' ),
						array( 'title' => '6+', 'desc' => 'Years of Service' ),
						array( 'title' => '600K+', 'desc' => 'Beneficiaries Reached' ),
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
						'By 2022, the Community Kitchen had become one of the foundation\'s most important humanitarian initiatives. Hundreds of meals were being prepared and distributed regularly to laborers, elderly individuals, patients, travelers, and poor families.',
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
					'heading' => '2025 — Thousands Benefiting During Ramadan',
					'paragraphs' => array(
						'What once started with helping around 1,000 people during Ramadan had now expanded dramatically. During Ramadan 2025, Daan Foundation was able to provide Iftar support to thousands of fasting individuals through cooked meals, food distribution, and ration assistance programs.',
						'The Community Kitchen continued serving hundreds of meals daily through the support of Zakat, Sadaqah, charity donations, and community contributions — a scale of humanitarian work far beyond what anyone imagined in 2020.'
					)
				),
				array(
					'type'    => 'text',
					'heading' => '2026 — Continuing the Journey of Humanity',
					'paragraphs' => array(
						'By 2026, Daan Foundation had distributed more than 500,000 food plates and meals through its various humanitarian activities. From a small 15-day Ramadan effort to a growing charitable foundation, the journey reflects the power of sincere intentions, community support, and consistent humanitarian work.'
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
					'button_url'  => '/donate',
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
