import Breadcrumbs from "@/components/layout/Breadcrumbs";
import ZakatCalculator from "@/components/donation/ZakatCalculator";
import SEO from "@/components/SEO";

export function ZakatCalculatorPage() {
  return (
    <div>
      <SEO title="Zakat Calculator - Calculate Your Zakat Online" description="Calculate your Zakat accurately with Daan Foundation's free online Zakat calculator. Based on current Nisab values in INR for gold and silver." canonical="/zakat-calculator" keywords="zakat calculator, calculate zakat online, zakat amount, nisab value India, zakat on gold silver" />
      <Breadcrumbs
        items={[
          { label: "Zakat", href: "/zakat" },
          { label: "Calculator" },
        ]}
      />

      <section className="py-12 md:py-16">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <ZakatCalculator />
        </div>
      </section>
    </div>
  );
}

export default ZakatCalculatorPage;
