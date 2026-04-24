// Partner logos - using placeholder boxes since we don't have actual logos
const partners = [
  { name: "United Nations", id: 1 },
  { name: "UNICEF", id: 2 },
  { name: "World Food Programme", id: 3 },
  { name: "Red Cross", id: 4 },
  { name: "UNHCR", id: 5 },
  { name: "WHO", id: 6 },
  { name: "Islamic Development Bank", id: 7 },
  { name: "DEC", id: 8 },
];

export function PartnerLogos() {
  return (
    <section className="py-16 md:py-20 border-t border-slate-100">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="text-center mb-10">
          <h2 className="text-2xl font-bold text-slate-900 mb-2">
            Our Partners
          </h2>
          <p className="text-slate-600">
            Working together to make a greater impact
          </p>
        </div>

        {/* Logo grid */}
        <div className="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-8 items-center">
          {partners.map((partner) => (
            <div
              key={partner.id}
              className="flex items-center justify-center h-16 grayscale hover:grayscale-0 opacity-60 hover:opacity-100 transition-all"
            >
              {/* Placeholder logo box */}
              <div className="h-12 w-24 rounded-lg bg-slate-200 flex items-center justify-center">
                <span className="text-[10px] font-medium text-slate-500 text-center px-2">
                  {partner.name}
                </span>
              </div>
            </div>
          ))}
        </div>

        {/* Trust badges */}
        <div className="mt-12 pt-8 border-t border-slate-100">
          <div className="flex flex-wrap items-center justify-center gap-8">
            <div className="flex items-center gap-2 text-sm text-slate-500">
              <div className="h-10 w-20 rounded bg-slate-100 flex items-center justify-center text-[8px] font-medium">
                Fundraising Regulator
              </div>
            </div>
            <div className="flex items-center gap-2 text-sm text-slate-500">
              <div className="h-10 w-20 rounded bg-slate-100 flex items-center justify-center text-[8px] font-medium">
                CHS Certified
              </div>
            </div>
            <div className="flex items-center gap-2 text-sm text-slate-500">
              <div className="h-10 w-20 rounded bg-slate-100 flex items-center justify-center text-[8px] font-medium">
                DEC Member
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

export default PartnerLogos;
