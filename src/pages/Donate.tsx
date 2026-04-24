import { useState } from "react";
import { Heart, Lock, Gift, CreditCard, Landmark, ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";

const presetAmounts = [25, 50, 100, 250, 500, 1000];
const causes = [
  { id: "where-needed", label: "Where Most Needed" },
  { id: "palestine", label: "Palestine Emergency" },
  { id: "orphans", label: "Orphan Sponsorship" },
  { id: "zakat", label: "Zakat" },
  { id: "sadaqah", label: "Sadaqah" },
  { id: "water", label: "Water Projects" },
];

export function Donate() {
  const [amount, setAmount] = useState<number | null>(50);
  const [customAmount, setCustomAmount] = useState("");
  const [frequency, setFrequency] = useState("single");
  const [cause, setCause] = useState("where-needed");
  const [step, setStep] = useState(1);

  const finalAmount = customAmount ? parseFloat(customAmount) : amount || 0;

  const handleNext = () => {
    if (step < 3) setStep(step + 1);
  };

  return (
    <div>
      <Breadcrumbs items={[{ label: "Donate" }]} />

      {/* Hero */}
      <section className="py-12 md:py-16 bg-gradient-to-br from-orange-600 to-orange-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-4">
            Make a Donation
          </h1>
          <p className="text-xl text-white/90 max-w-2xl mx-auto">
            Your generosity transforms lives. 100% of your donation goes directly to those in need.
          </p>
        </div>
      </section>

      {/* Donation form */}
      <section className="py-12 md:py-20">
        <div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
          {/* Progress */}
          <div className="mb-8">
            <div className="flex items-center justify-between mb-2">
              {["Amount", "Details", "Payment"].map((label, idx) => (
                <div 
                  key={label}
                  className={`flex items-center gap-2 ${idx + 1 <= step ? "text-orange-600" : "text-slate-400"}`}
                >
                  <div className={`h-8 w-8 rounded-full flex items-center justify-center text-sm font-bold ${
                    idx + 1 <= step ? "bg-orange-600 text-white" : "bg-slate-200 text-slate-500"
                  }`}>
                    {idx + 1}
                  </div>
                  <span className="hidden sm:inline font-medium">{label}</span>
                </div>
              ))}
            </div>
            <div className="h-2 bg-slate-200 rounded-full overflow-hidden">
              <div 
                className="h-full bg-orange-600 transition-all duration-300" 
                style={{ width: `${(step / 3) * 100}%` }}
              />
            </div>
          </div>

          <div className="bg-white rounded-2xl shadow-lg p-6 md:p-8">
            {step === 1 && (
              <div className="space-y-6">
                {/* Frequency */}
                <div>
                  <h2 className="text-lg font-bold text-slate-900 mb-3">Giving Type</h2>
                  <div className="grid grid-cols-2 gap-3">
                    {[
                      { id: "single", label: "One-Time" },
                      { id: "monthly", label: "Monthly" },
                    ].map(({ id, label }) => (
                      <button
                        key={id}
                        onClick={() => setFrequency(id)}
                        className={`py-3 px-4 rounded-xl border-2 font-semibold transition-colors ${
                          frequency === id
                            ? "border-orange-600 bg-orange-50 text-orange-700"
                            : "border-slate-200 hover:border-slate-300"
                        }`}
                      >
                        {label}
                      </button>
                    ))}
                  </div>
                </div>

                {/* Amount */}
                <div>
                  <h2 className="text-lg font-bold text-slate-900 mb-3">Select Amount</h2>
                  <div className="grid grid-cols-3 gap-3 mb-4">
                    {presetAmounts.map((value) => (
                      <button
                        key={value}
                        onClick={() => { setAmount(value); setCustomAmount(""); }}
                        className={`py-3 px-4 rounded-xl border-2 font-bold text-lg transition-colors ${
                          amount === value && !customAmount
                            ? "border-orange-600 bg-orange-50 text-orange-700"
                            : "border-slate-200 hover:border-slate-300"
                        }`}
                      >
                        £{value}
                      </button>
                    ))}
                  </div>
                  <div>
                    <Label htmlFor="custom">Custom Amount</Label>
                    <div className="relative mt-1">
                      <span className="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500">£</span>
                      <Input
                        id="custom"
                        type="number"
                        min="1"
                        placeholder="Enter amount"
                        value={customAmount}
                        onChange={(e) => { setCustomAmount(e.target.value); setAmount(null); }}
                        className="pl-8"
                      />
                    </div>
                  </div>
                </div>

                {/* Cause */}
                <div>
                  <h2 className="text-lg font-bold text-slate-900 mb-3">Choose a Cause</h2>
                  <RadioGroup value={cause} onValueChange={setCause} className="grid sm:grid-cols-2 gap-3">
                    {causes.map(({ id, label }) => (
                      <Label
                        key={id}
                        htmlFor={id}
                        className={`flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-colors ${
                          cause === id ? "border-orange-600 bg-orange-50" : "border-slate-200 hover:border-slate-300"
                        }`}
                      >
                        <RadioGroupItem value={id} id={id} />
                        <span className="font-medium">{label}</span>
                      </Label>
                    ))}
                  </RadioGroup>
                </div>

                <Button onClick={handleNext} className="w-full bg-orange-600 hover:bg-orange-700" disabled={finalAmount <= 0}>
                  Continue — £{finalAmount || 0} {frequency === "monthly" ? "/month" : ""}
                  <ArrowRight className="ml-2 h-4 w-4" />
                </Button>
              </div>
            )}

            {step === 2 && (
              <div className="space-y-6">
                <h2 className="text-lg font-bold text-slate-900">Your Details</h2>
                <div className="grid sm:grid-cols-2 gap-4">
                  <div>
                    <Label htmlFor="firstName">First Name</Label>
                    <Input id="firstName" placeholder="John" className="mt-1" />
                  </div>
                  <div>
                    <Label htmlFor="lastName">Last Name</Label>
                    <Input id="lastName" placeholder="Doe" className="mt-1" />
                  </div>
                </div>
                <div>
                  <Label htmlFor="email">Email</Label>
                  <Input id="email" type="email" placeholder="john@example.com" className="mt-1" />
                </div>
                <div>
                  <Label htmlFor="phone">Phone (Optional)</Label>
                  <Input id="phone" type="tel" placeholder="+44..." className="mt-1" />
                </div>

                <div className="flex items-start gap-3 p-4 bg-amber-50 rounded-xl">
                  <Gift className="h-5 w-5 text-amber-600 flex-shrink-0 mt-0.5" />
                  <div>
                    <h3 className="font-semibold text-slate-900">Gift Aid</h3>
                    <p className="text-sm text-slate-600">
                      UK taxpayer? We can claim 25% extra from HMRC at no cost to you.
                    </p>
                  </div>
                </div>

                <div className="flex gap-3">
                  <Button variant="outline" onClick={() => setStep(1)} className="flex-1">
                    Back
                  </Button>
                  <Button onClick={handleNext} className="flex-1 bg-orange-600 hover:bg-orange-700">
                    Continue to Payment
                    <ArrowRight className="ml-2 h-4 w-4" />
                  </Button>
                </div>
              </div>
            )}

            {step === 3 && (
              <div className="space-y-6">
                <h2 className="text-lg font-bold text-slate-900">Payment Method</h2>

                {/* Summary */}
                <div className="p-4 bg-slate-50 rounded-xl">
                  <div className="flex justify-between mb-2">
                    <span className="text-slate-600">Donation</span>
                    <span className="font-semibold">£{finalAmount}</span>
                  </div>
                  <div className="flex justify-between mb-2">
                    <span className="text-slate-600">Cause</span>
                    <span className="font-semibold">{causes.find(c => c.id === cause)?.label}</span>
                  </div>
                  <div className="flex justify-between border-t pt-2 mt-2">
                    <span className="font-bold">Total</span>
                    <span className="font-bold text-orange-600">£{finalAmount}</span>
                  </div>
                </div>

                <div className="grid sm:grid-cols-2 gap-3">
                  <button className="flex items-center justify-center gap-2 p-4 rounded-xl border-2 border-slate-200 hover:border-orange-600 transition-colors">
                    <CreditCard className="h-5 w-5" />
                    <span className="font-medium">Card</span>
                  </button>
                  <button className="flex items-center justify-center gap-2 p-4 rounded-xl border-2 border-slate-200 hover:border-orange-600 transition-colors">
                    <Landmark className="h-5 w-5" />
                    <span className="font-medium">Bank Transfer</span>
                  </button>
                </div>

                <div className="flex items-center gap-2 text-sm text-slate-500">
                  <Lock className="h-4 w-4" />
                  <span>Your payment is secured with 256-bit encryption</span>
                </div>

                <div className="flex gap-3">
                  <Button variant="outline" onClick={() => setStep(2)} className="flex-1">
                    Back
                  </Button>
                  <Button className="flex-1 bg-orange-600 hover:bg-orange-700">
                    <Heart className="mr-2 h-4 w-4" />
                    Complete Donation
                  </Button>
                </div>
              </div>
            )}
          </div>
        </div>
      </section>
    </div>
  );
}

export default Donate;
