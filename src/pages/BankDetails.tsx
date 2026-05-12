import { Landmark, Copy, CheckCircle } from "lucide-react";
import { useState } from "react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";

const bankInfo = [
  { label: "Bank Name", value: "State Bank of India" },
  { label: "Account Name", value: "Daan Foundation" },
  { label: "Account Number", value: "42818355421" },
  { label: "IFSC Code", value: "SBIN0003448" },
  { label: "Branch", value: "Amroha, UP" },
  { label: "UPI ID", value: "42818355421@sbi" },
];

export function BankDetails() {
  const [copied, setCopied] = useState<string | null>(null);

  const copyToClipboard = (value: string, label: string) => {
    navigator.clipboard.writeText(value);
    setCopied(label);
    setTimeout(() => setCopied(null), 2000);
  };

  return (
    <div>
      <SEO title="Bank Details - Donation Account Information" description="Daan Foundation bank account details for direct donations. Transfer your Zakat, Sadaqah, and charity donations securely via bank transfer or UPI." canonical="/bank-details" keywords="Daan Foundation bank details, charity bank account, donate via bank transfer, UPI donation" />
      <Breadcrumbs items={[{ label: "Bank Details" }]} />

      {/* Hero */}
      <section className="py-16 md:py-20 bg-gradient-to-br from-orange-600 to-orange-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-4">
            Bank Details
          </h1>
          <p className="text-xl text-white/90 max-w-2xl mx-auto">
            Donate directly to Daan Foundation via bank transfer or UPI.
          </p>
        </div>
      </section>

      {/* Bank Details */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
          <div className="bg-white rounded-2xl shadow-lg p-8 md:p-12">
            <div className="flex items-center gap-3 mb-8">
              <div className="h-12 w-12 rounded-xl bg-orange-100 flex items-center justify-center">
                <Landmark className="h-6 w-6 text-orange-600" />
              </div>
              <div>
                <h2 className="text-2xl font-bold text-slate-900">Bank Transfer Details</h2>
                <p className="text-sm text-slate-500">Click any value to copy</p>
              </div>
            </div>

            <div className="divide-y divide-slate-100">
              {bankInfo.map(({ label, value }) => (
                <div key={label} className="flex items-center justify-between py-4">
                  <div>
                    <div className="text-sm text-slate-500">{label}</div>
                    <div className="text-lg font-semibold text-slate-900">{value}</div>
                  </div>
                  <button
                    onClick={() => copyToClipboard(value, label)}
                    className="flex items-center gap-1.5 rounded-lg bg-slate-100 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition-colors"
                  >
                    {copied === label ? (
                      <>
                        <CheckCircle className="h-4 w-4 text-green-500" />
                        Copied
                      </>
                    ) : (
                      <>
                        <Copy className="h-4 w-4" />
                        Copy
                      </>
                    )}
                  </button>
                </div>
              ))}
            </div>
          </div>

          {/* UPI Section */}
          <div className="mt-8 bg-white rounded-2xl shadow-lg p-8 md:p-12 text-center">
            <h3 className="text-xl font-bold text-slate-900 mb-2">Pay via UPI</h3>
            <p className="text-slate-500 mb-6">Scan the QR code below to donate via UPI</p>
            <img
              src="/images/upi-qr-code.jpg"
              alt="UPI QR Code - Daan Foundation"
              className="mx-auto h-56 w-56 rounded-2xl object-contain bg-white shadow-md p-2"
            />
            <p className="mt-4 text-sm text-slate-500">
              UPI ID: <span className="font-semibold text-slate-900">42818355421@sbi</span>
            </p>
          </div>

          {/* Trust note */}
          <div className="mt-8 rounded-2xl bg-amber-50 border border-amber-200 p-6 text-center">
            <p className="text-amber-800 font-medium">
              Daan Foundation treats every donation as an amanah (trust). All contributions are used
              responsibly for humanitarian work within India only.
            </p>
            <p className="text-sm text-amber-600 mt-2">
              Registered Charity No. 124456
            </p>
          </div>
        </div>
      </section>
    </div>
  );
}

export default BankDetails;
