import Breadcrumbs from "@/components/layout/Breadcrumbs";
import ZakatCalculator from "@/components/donation/ZakatCalculator";

export function ZakatCalculatorPage() {
  return (
    <div>
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
