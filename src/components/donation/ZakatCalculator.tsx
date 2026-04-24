import { useState, useMemo } from "react";
import { Calculator, Info, ChevronDown, ChevronUp, RefreshCw } from "lucide-react";

/* ─── Nisab Values (placeholder - would fetch from API) ─────────────────── */
const NISAB = {
  gold: 5950, // £ value of 87.48g gold
  silver: 450, // £ value of 612.36g silver
};

/* ─── Asset Categories ──────────────────────────────────────────────────── */
interface AssetCategory {
  id: string;
  label: string;
  description: string;
  fields: {
    id: string;
    label: string;
    placeholder: string;
    helpText?: string;
  }[];
}

const assetCategories: AssetCategory[] = [
  {
    id: "cash",
    label: "Cash & Bank Balances",
    description: "All liquid assets you have access to",
    fields: [
      { id: "cash_hand", label: "Cash at home", placeholder: "0" },
      { id: "cash_bank", label: "Bank accounts", placeholder: "0" },
      { id: "cash_savings", label: "Savings accounts", placeholder: "0" },
    ],
  },
  {
    id: "gold_silver",
    label: "Gold & Silver",
    description: "Jewellery and precious metals you own",
    fields: [
      { id: "gold_value", label: "Gold (current value)", placeholder: "0", helpText: "Include jewellery worn regularly" },
      { id: "silver_value", label: "Silver (current value)", placeholder: "0" },
    ],
  },
  {
    id: "investments",
    label: "Investments & Shares",
    description: "Stocks, shares, funds, and other investments",
    fields: [
      { id: "stocks", label: "Stocks & shares", placeholder: "0" },
      { id: "funds", label: "Investment funds", placeholder: "0" },
      { id: "crypto", label: "Cryptocurrency", placeholder: "0" },
    ],
  },
  {
    id: "business",
    label: "Business Assets",
    description: "Stock and cash from business activities",
    fields: [
      { id: "stock", label: "Stock/inventory value", placeholder: "0" },
      { id: "receivables", label: "Money owed to you", placeholder: "0" },
    ],
  },
  {
    id: "other",
    label: "Other Assets",
    description: "Any other zakatable wealth",
    fields: [
      { id: "property_investment", label: "Investment property value", placeholder: "0", helpText: "Not your primary residence" },
      { id: "pension", label: "Accessible pension funds", placeholder: "0" },
    ],
  },
];

const liabilityFields = [
  { id: "debts", label: "Debts to be paid", placeholder: "0" },
  { id: "bills", label: "Immediate bills due", placeholder: "0" },
];

/* ─── Zakat Calculator Component ───────────────────────────────────────── */
export function ZakatCalculator() {
  const [values, setValues] = useState<Record<string, string>>({});
  const [expandedSections, setExpandedSections] = useState<string[]>(["cash"]);
  const [nisabType, setNisabType] = useState<"gold" | "silver">("silver");

  const handleInputChange = (fieldId: string, value: string) => {
    // Only allow numbers and decimals
    if (value === "" || /^\d*\.?\d*$/.test(value)) {
      setValues((prev) => ({ ...prev, [fieldId]: value }));
    }
  };

  const toggleSection = (sectionId: string) => {
    setExpandedSections((prev) =>
      prev.includes(sectionId)
        ? prev.filter((id) => id !== sectionId)
        : [...prev, sectionId]
    );
  };

  const resetCalculator = () => {
    setValues({});
  };

  // Calculate totals
  const calculations = useMemo(() => {
    const getNum = (id: string) => parseFloat(values[id] || "0") || 0;

    const totalAssets = assetCategories.reduce((sum, cat) => {
      return sum + cat.fields.reduce((catSum, field) => catSum + getNum(field.id), 0);
    }, 0);

    const totalLiabilities = liabilityFields.reduce(
      (sum, field) => sum + getNum(field.id),
      0
    );

    const netAssets = totalAssets - totalLiabilities;
    const nisabThreshold = NISAB[nisabType];
    const isZakatDue = netAssets >= nisabThreshold;
    const zakatPayable = isZakatDue ? netAssets * 0.025 : 0;

    return {
      totalAssets,
      totalLiabilities,
      netAssets,
      nisabThreshold,
      isZakatDue,
      zakatPayable,
    };
  }, [values, nisabType]);

  return (
    <div className="w-full max-w-3xl mx-auto">
      {/* Header */}
      <div className="text-center mb-8">
        <div className="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-orange-600 to-orange-700 mb-4">
          <Calculator className="h-8 w-8 text-white" />
        </div>
        <h2 className="text-3xl font-bold text-slate-900 mb-2">
          Zakat Calculator
        </h2>
        <p className="text-slate-600 max-w-lg mx-auto">
          Calculate your Zakat obligation accurately. Enter your assets and liabilities 
          to see how much Zakat you owe this year.
        </p>
      </div>

      {/* Nisab selector */}
      <div className="bg-slate-50 rounded-2xl p-6 mb-6">
        <div className="flex items-start gap-3 mb-4">
          <Info className="h-5 w-5 text-orange-600 mt-0.5 shrink-0" />
          <div>
            <h3 className="font-semibold text-slate-900 mb-1">Nisab Threshold</h3>
            <p className="text-sm text-slate-600">
              Zakat is due if your net assets exceed the Nisab. Choose which calculation to use:
            </p>
          </div>
        </div>
        <div className="grid grid-cols-2 gap-3">
          <button
            onClick={() => setNisabType("silver")}
            className={`p-4 rounded-xl border-2 transition-all text-left ${
              nisabType === "silver"
                ? "border-orange-500 bg-orange-50"
                : "border-slate-200 hover:border-slate-300"
            }`}
          >
            <div className="text-sm font-medium text-slate-600 mb-1">Silver Nisab</div>
            <div className="text-xl font-bold text-slate-900">£{NISAB.silver.toLocaleString()}</div>
            <div className="text-xs text-slate-500 mt-1">Based on 612.36g silver</div>
          </button>
          <button
            onClick={() => setNisabType("gold")}
            className={`p-4 rounded-xl border-2 transition-all text-left ${
              nisabType === "gold"
                ? "border-orange-500 bg-orange-50"
                : "border-slate-200 hover:border-slate-300"
            }`}
          >
            <div className="text-sm font-medium text-slate-600 mb-1">Gold Nisab</div>
            <div className="text-xl font-bold text-slate-900">£{NISAB.gold.toLocaleString()}</div>
            <div className="text-xs text-slate-500 mt-1">Based on 87.48g gold</div>
          </button>
        </div>
      </div>

      {/* Asset sections */}
      <div className="space-y-4 mb-6">
        {assetCategories.map((category) => {
          const isExpanded = expandedSections.includes(category.id);
          const sectionTotal = category.fields.reduce(
            (sum, field) => sum + (parseFloat(values[field.id] || "0") || 0),
            0
          );

          return (
            <div
              key={category.id}
              className="bg-white rounded-2xl border border-slate-200 overflow-hidden"
            >
              <button
                onClick={() => toggleSection(category.id)}
                className="w-full flex items-center justify-between p-5 text-left hover:bg-slate-50 transition-colors"
              >
                <div>
                  <h3 className="font-semibold text-slate-900">{category.label}</h3>
                  <p className="text-sm text-slate-500">{category.description}</p>
                </div>
                <div className="flex items-center gap-4">
                  {sectionTotal > 0 && (
                    <span className="text-lg font-bold text-orange-600">
                      £{sectionTotal.toLocaleString()}
                    </span>
                  )}
                  {isExpanded ? (
                    <ChevronUp className="h-5 w-5 text-slate-400" />
                  ) : (
                    <ChevronDown className="h-5 w-5 text-slate-400" />
                  )}
                </div>
              </button>

              {isExpanded && (
                <div className="px-5 pb-5 pt-2 border-t border-slate-100 space-y-4">
                  {category.fields.map((field) => (
                    <div key={field.id}>
                      <label
                        htmlFor={field.id}
                        className="block text-sm font-medium text-slate-700 mb-1"
                      >
                        {field.label}
                      </label>
                      <div className="relative">
                        <span className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                          £
                        </span>
                        <input
                          id={field.id}
                          type="text"
                          inputMode="decimal"
                          value={values[field.id] || ""}
                          onChange={(e) => handleInputChange(field.id, e.target.value)}
                          placeholder={field.placeholder}
                          className="w-full rounded-xl border-2 border-slate-200 py-3 pl-8 pr-4 text-slate-900 placeholder:text-slate-300 focus:border-orange-500 focus:outline-none focus:ring-4 focus:ring-orange-500/10 transition-all"
                        />
                      </div>
                      {field.helpText && (
                        <p className="mt-1 text-xs text-slate-500">{field.helpText}</p>
                      )}
                    </div>
                  ))}
                </div>
              )}
            </div>
          );
        })}

        {/* Liabilities section */}
        <div className="bg-white rounded-2xl border border-slate-200 overflow-hidden">
          <div className="p-5">
            <h3 className="font-semibold text-slate-900 mb-1">Liabilities</h3>
            <p className="text-sm text-slate-500 mb-4">Deductible debts and bills</p>
            <div className="space-y-4">
              {liabilityFields.map((field) => (
                <div key={field.id}>
                  <label
                    htmlFor={field.id}
                    className="block text-sm font-medium text-slate-700 mb-1"
                  >
                    {field.label}
                  </label>
                  <div className="relative">
                    <span className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                      £
                    </span>
                    <input
                      id={field.id}
                      type="text"
                      inputMode="decimal"
                      value={values[field.id] || ""}
                      onChange={(e) => handleInputChange(field.id, e.target.value)}
                      placeholder={field.placeholder}
                      className="w-full rounded-xl border-2 border-slate-200 py-3 pl-8 pr-4 text-slate-900 placeholder:text-slate-300 focus:border-orange-500 focus:outline-none focus:ring-4 focus:ring-orange-500/10 transition-all"
                    />
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>

      {/* Results panel */}
      <div className={`rounded-2xl p-6 ${
        calculations.isZakatDue 
          ? "bg-gradient-to-br from-orange-600 to-orange-700" 
          : "bg-slate-100"
      }`}>
        <div className="flex items-center justify-between mb-6">
          <h3 className={`text-lg font-semibold ${calculations.isZakatDue ? "text-white" : "text-slate-900"}`}>
            Zakat Summary
          </h3>
          <button
            onClick={resetCalculator}
            className={`flex items-center gap-1.5 text-sm font-medium transition-colors ${
              calculations.isZakatDue 
                ? "text-white/80 hover:text-white" 
                : "text-slate-500 hover:text-slate-700"
            }`}
          >
            <RefreshCw className="h-4 w-4" />
            Reset
          </button>
        </div>

        <div className="space-y-3 mb-6">
          <div className="flex justify-between">
            <span className={calculations.isZakatDue ? "text-white/80" : "text-slate-600"}>Total Assets</span>
            <span className={`font-semibold ${calculations.isZakatDue ? "text-white" : "text-slate-900"}`}>
              £{calculations.totalAssets.toLocaleString()}
            </span>
          </div>
          <div className="flex justify-between">
            <span className={calculations.isZakatDue ? "text-white/80" : "text-slate-600"}>Less Liabilities</span>
            <span className={`font-semibold ${calculations.isZakatDue ? "text-white" : "text-slate-900"}`}>
              -£{calculations.totalLiabilities.toLocaleString()}
            </span>
          </div>
          <div className={`border-t pt-3 ${calculations.isZakatDue ? "border-white/20" : "border-slate-200"}`}>
            <div className="flex justify-between">
              <span className={calculations.isZakatDue ? "text-white/80" : "text-slate-600"}>Net Zakatable Assets</span>
              <span className={`font-semibold ${calculations.isZakatDue ? "text-white" : "text-slate-900"}`}>
                £{calculations.netAssets.toLocaleString()}
              </span>
            </div>
          </div>
          <div className="flex justify-between">
            <span className={calculations.isZakatDue ? "text-white/80" : "text-slate-600"}>Nisab Threshold</span>
            <span className={`font-semibold ${calculations.isZakatDue ? "text-white" : "text-slate-900"}`}>
              £{calculations.nisabThreshold.toLocaleString()}
            </span>
          </div>
        </div>

        {/* Zakat result */}
        <div className={`rounded-xl p-4 ${calculations.isZakatDue ? "bg-white/10" : "bg-white"}`}>
          {calculations.isZakatDue ? (
            <>
              <div className="text-sm text-white/80 mb-1">Your Zakat Due (2.5%)</div>
              <div className="text-4xl font-bold text-white mb-3">
                £{calculations.zakatPayable.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
              </div>
              <button className="w-full rounded-xl bg-white py-3 text-base font-bold text-orange-600 hover:bg-orange-50 transition-colors">
                Pay Your Zakat Now
              </button>
            </>
          ) : (
            <div className="text-center py-2">
              <div className="text-lg font-semibold text-slate-900 mb-1">
                Zakat is not due
              </div>
              <div className="text-sm text-slate-600">
                Your net assets are below the Nisab threshold
              </div>
            </div>
          )}
        </div>
      </div>

      {/* Disclaimer */}
      <p className="text-xs text-slate-500 text-center mt-6">
        This calculator provides an estimate. For complex situations, please consult a qualified scholar.
        Nisab values are updated periodically based on market prices.
      </p>
    </div>
  );
}

export default ZakatCalculator;
