import { useState } from "react";
import { Link } from "react-router-dom";
import { Lock, ShieldCheck, Eye } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";

const presetAmounts = [500, 1000, 2500, 5000];
const causes = [
  { id: "where-needed", label: "Where Most Needed" },
  { id: "community-kitchen", label: "Community Kitchen" },
  { id: "ramadan-iftar", label: "Ramadan Iftar" },
  { id: "zakat", label: "Zakat" },
  { id: "sadaqah", label: "Sadaqah" },
  { id: "fidya-kaffarah", label: "Fidyah & Kaffarah" },
];

interface DonationSidebarProps {
  defaultCause?: string;
  hideTitle?: boolean;
  className?: string;
}

export function DonationSidebar({ defaultCause = "where-needed", hideTitle = false, className = "" }: DonationSidebarProps) {
  const [amount, setAmount] = useState<number | null>(1000);
  const [customAmount, setCustomAmount] = useState("");
  const [frequency, setFrequency] = useState("single");
  const [cause, setCause] = useState(defaultCause);

  const finalAmount = customAmount ? parseFloat(customAmount) : amount || 0;

  return (
    <div className={`bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden ${className}`}>
      {!hideTitle && (
        <div className="bg-gradient-to-r from-orange-600 to-orange-700 p-4 text-center">
          <h3 className="text-lg font-bold text-white">Quick Donate</h3>
        </div>
      )}

      <div className="p-5 space-y-5">

        <div>
          <Label className="text-sm font-semibold text-slate-700 mb-2 block">Frequency</Label>
          <div className="grid grid-cols-2 gap-2">
            {[{ id: "single", label: "One-Time" }, { id: "monthly", label: "Monthly" }].map(({ id, label }) => (
              <button
                key={id}
                onClick={() => setFrequency(id)}
                className={`py-2.5 px-3 rounded-lg border-2 font-semibold text-sm transition-colors ${
                  frequency === id
                    ? "border-orange-600 bg-orange-50 text-orange-700"
                    : "border-slate-200 hover:border-slate-300 text-slate-600"
                }`}
              >
                {label}
              </button>
            ))}
          </div>
        </div>

        <div>
          <Label className="text-sm font-semibold text-slate-700 mb-2 block">Amount</Label>
          <div className="grid grid-cols-2 gap-2 mb-3">
            {presetAmounts.map((value) => (
              <button
                key={value}
                onClick={() => { setAmount(value); setCustomAmount(""); }}
                className={`py-2.5 px-3 rounded-lg border-2 font-bold text-sm transition-colors ${
                  amount === value && !customAmount
                    ? "border-orange-600 bg-orange-50 text-orange-700"
                    : "border-slate-200 hover:border-slate-300 text-slate-700"
                }`}
              >
                ₹{value}
              </button>
            ))}
          </div>
          <div className="relative">
            <span className="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm">₹</span>
            <Input
              placeholder="Custom amount"
              type="number"
              min="1"
              value={customAmount}
              onChange={(e) => { setCustomAmount(e.target.value); setAmount(null); }}
              className="pl-7 text-sm h-10"
            />
          </div>
        </div>

        <div>
          <Label className="text-sm font-semibold text-slate-700 mb-2 block">Cause</Label>
          <select
            value={cause}
            onChange={(e) => setCause(e.target.value)}
            className="w-full h-10 rounded-lg border-2 border-slate-200 px-3 text-sm font-medium text-slate-700 bg-white focus:border-orange-600 focus:outline-none"
          >
            {causes.map(({ id, label }) => (
              <option key={id} value={id}>{label}</option>
            ))}
          </select>
        </div>

        <Button
          asChild
          className="w-full bg-orange-600 hover:bg-orange-700 h-11 text-sm font-bold"
          disabled={finalAmount <= 0}
        >
          <Link to="/donate">
            Donate {finalAmount > 0 ? `₹${finalAmount}` : ""} {frequency === "monthly" ? "/month" : ""}
          </Link>
        </Button>

        <div className="flex items-center justify-center gap-4 text-xs text-slate-400 pt-1">
          <span className="flex items-center gap-1"><Lock className="h-3 w-3" /> Secure</span>
          <span className="flex items-center gap-1"><ShieldCheck className="h-3 w-3" /> Registered Charity</span>
          <span className="flex items-center gap-1"><Eye className="h-3 w-3" /> 100% Transparent</span>
        </div>
      </div>
    </div>
  );
}

export default DonationSidebar;
