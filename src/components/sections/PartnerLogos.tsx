const partners = [
  { name: "Support Society", id: 1 },
  { name: "Friends of Amroha", id: 2 },
  { name: "Angel Welfare Society", id: 3 },
  { name: "Sootista", id: 4 },
  { name: "Qurbani Easy\nqurbanieasy.com", id: 5 },
];

export function PartnerLogos() {
  return (
    <section className="py-16 md:py-20 border-t border-slate-100">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-10">
          <h2 className="text-2xl font-bold text-slate-900 mb-2">
            Our Partners
          </h2>
          <p className="text-slate-600">
            Working together to make a greater impact
          </p>
        </div>

        <div className="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-8 items-center">
          {partners.map((partner) => (
            <div
              key={partner.id}
              className="flex items-center justify-center h-16 grayscale hover:grayscale-0 opacity-60 hover:opacity-100 transition-all"
            >
              <div className="h-12 w-24 rounded-lg bg-slate-200 flex items-center justify-center">
                <span className="text-[10px] font-medium text-slate-500 text-center px-2 leading-tight whitespace-pre-line">
                  {partner.name}
                </span>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

export default PartnerLogos;
