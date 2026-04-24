import { Link } from "react-router-dom";
import { Play, ArrowRight } from "lucide-react";

const stories = [
  {
    id: 1,
    title: "From hunger to hope: A family's journey",
    category: "Impact Story",
    image: "/images/food-distribution-ramadan.jpg",
    href: "/news/family-journey",
    hasVideo: true,
  },
  {
    id: 2,
    title: "Clean water transforms a village",
    category: "Project Update",
    image: "/images/community-queue.jpg",
    href: "/news/water-village",
    hasVideo: false,
  },
  {
    id: 3,
    title: "Elderly care in action",
    category: "Impact Story",
    image: "/images/aid-distribution-elderly.jpg",
    href: "/news/elderly-care-program",
    hasVideo: false,
  },
];

export function ImpactStories() {
  return (
    <section className="py-16 md:py-24 bg-slate-50">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
          <div>
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-2">
              How Your Donations Are Changing Lives
            </h2>
            <p className="text-lg text-slate-600">
              Real stories from the communities we serve
            </p>
          </div>
          <Link
            to="/news"
            className="inline-flex items-center gap-2 text-orange-600 font-semibold hover:text-orange-700 transition-colors"
          >
            View all stories
            <ArrowRight className="h-4 w-4" />
          </Link>
        </div>

        {/* Stories grid */}
        <div className="grid md:grid-cols-3 gap-6">
          {stories.map((story) => (
            <Link
              key={story.id}
              to={story.href}
              className="group relative aspect-[4/5] rounded-2xl overflow-hidden"
            >
              {/* Image */}
              <img
                src={story.image}
                alt={story.title}
                className="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
              />

              {/* Overlay */}
              <div className="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent" />

              {/* Play button for videos */}
              {story.hasVideo && (
                <div className="absolute inset-0 flex items-center justify-center">
                  <div className="h-16 w-16 rounded-full bg-white/90 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <Play className="h-6 w-6 text-orange-600 ml-1" fill="currentColor" />
                  </div>
                </div>
              )}

              {/* Content */}
              <div className="absolute bottom-0 left-0 right-0 p-6">
                <span className="inline-block rounded-full bg-white/20 backdrop-blur-sm px-3 py-1 text-xs font-semibold text-white mb-3">
                  {story.category}
                </span>
                <h3 className="text-xl font-bold text-white group-hover:text-orange-300 transition-colors">
                  {story.title}
                </h3>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
}

export default ImpactStories;
