import { ReactNode } from "react";
import { DonationSidebar } from "./DonationSidebar";

interface ProjectPageLayoutProps {
  children: ReactNode;
  defaultCause?: string;
  sidebarClassName?: string;
}

export function ProjectPageLayout({ children, defaultCause = "where-needed", sidebarClassName = "" }: ProjectPageLayoutProps) {
  return (
    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-12">
      <div className="lg:grid lg:grid-cols-3 lg:gap-10">
        <div className="lg:col-span-2 space-y-10">
          {children}
        </div>
        <aside className="lg:col-span-1 mt-8 lg:mt-0">
          <div className={`lg:sticky lg:top-24 ${sidebarClassName}`}>
            <DonationSidebar defaultCause={defaultCause} />
          </div>
        </aside>
      </div>
    </div>
  );
}

export default ProjectPageLayout;
