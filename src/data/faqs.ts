// FAQ data for different topics
export interface FAQ {
  question: string;
  answer: string;
}

export interface FAQCategory {
  topic: string;
  faqs: FAQ[];
}

export const zakatFAQs: FAQ[] = [
  {
    question: "What is Zakat?",
    answer: "Zakat is one of the five pillars of Islam. It is a mandatory charitable contribution, typically 2.5% of a Muslim's total savings and wealth above a minimum amount known as the Nisab.",
  },
  {
    question: "Who must pay Zakat?",
    answer: "Zakat is obligatory for every adult Muslim who owns wealth above the Nisab threshold for one lunar year. The wealth must be in excess of basic needs and debts.",
  },
  {
    question: "What is the Nisab?",
    answer: "The Nisab is the minimum amount of wealth a Muslim must possess before Zakat becomes obligatory. It is calculated based on the value of gold (87.48 grams) or silver (612.36 grams).",
  },
  {
    question: "How is Zakat calculated?",
    answer: "Zakat is calculated as 2.5% of your total zakatable assets minus any debts. Zakatable assets include cash, savings, investments, gold, silver, and business inventory.",
  },
  {
    question: "When should I pay Zakat?",
    answer: "Zakat is due once a full lunar year has passed since your wealth exceeded the Nisab. Many Muslims choose to pay during Ramadan for increased blessings.",
  },
  {
    question: "Who can receive Zakat?",
    answer: "There are eight categories of Zakat recipients mentioned in the Quran: the poor, the needy, Zakat administrators, those whose hearts are to be reconciled, freeing captives, those in debt, in the cause of Allah, and travelers in need.",
  },
];

export const sadaqahFAQs: FAQ[] = [
  {
    question: "What is Sadaqah?",
    answer: "Sadaqah is a voluntary act of charity given out of compassion, love, or generosity. Unlike Zakat, there is no minimum amount and it can be given at any time.",
  },
  {
    question: "What is the difference between Sadaqah and Zakat?",
    answer: "Zakat is obligatory and has specific rules about amounts and recipients. Sadaqah is voluntary, can be any amount, and can be given to anyone in need.",
  },
  {
    question: "What is Sadaqah Jariyah?",
    answer: "Sadaqah Jariyah means 'ongoing charity.' It refers to charitable acts that continue to benefit others long after the initial gift, such as building a well or school.",
  },
  {
    question: "Can I give Sadaqah to non-Muslims?",
    answer: "Yes, Sadaqah can be given to anyone in need regardless of their faith. The key is the intention to help those who are struggling.",
  },
];

export const qurbaniFAQs: FAQ[] = [
  {
    question: "What is Qurbani?",
    answer: "Qurbani is the ritual sacrifice of an animal during Eid ul-Adha, commemorating Prophet Ibrahim's willingness to sacrifice his son in obedience to Allah.",
  },
  {
    question: "Who must give Qurbani?",
    answer: "Qurbani is obligatory (Wajib) for every sane Muslim who has reached puberty and possesses the Nisab amount of wealth.",
  },
  {
    question: "When is Qurbani performed?",
    answer: "Qurbani is performed during the days of Eid ul-Adha, specifically from after the Eid prayer on the 10th of Dhul Hijjah until sunset on the 13th of Dhul Hijjah.",
  },
  {
    question: "What animals can be sacrificed?",
    answer: "Acceptable animals include goats, sheep (1 share each), cows, and camels (7 shares each). The animal must meet minimum age requirements and be free from defects.",
  },
  {
    question: "How is the meat distributed?",
    answer: "The meat is traditionally divided into three parts: one-third for the family, one-third for friends and relatives, and one-third for those in need.",
  },
];

export const fidyaFAQs: FAQ[] = [
  {
    question: "What is Fidya?",
    answer: "Fidya is a donation made when someone cannot fast during Ramadan due to illness or old age and cannot make up the fasts later. It involves feeding one person for each missed fast.",
  },
  {
    question: "What is Kaffarah?",
    answer: "Kaffarah is a penalty paid for deliberately breaking a fast without valid reason. It requires fasting for 60 consecutive days or feeding 60 poor people for each fast broken.",
  },
  {
    question: "When should I pay Fidya vs Kaffarah?",
    answer: "Pay Fidya if you cannot fast due to long-term illness or old age. Pay Kaffarah if you deliberately broke a fast without valid excuse.",
  },
  {
    question: "How much is Fidya?",
    answer: "Fidya is the cost of one meal per missed fast. The amount varies by region but is typically around £5-£7 per day.",
  },
];

export const allFAQs: FAQCategory[] = [
  { topic: "Zakat", faqs: zakatFAQs },
  { topic: "Sadaqah", faqs: sadaqahFAQs },
  { topic: "Qurbani", faqs: qurbaniFAQs },
  { topic: "Fidya & Kaffarah", faqs: fidyaFAQs },
];
