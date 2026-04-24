import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { Toaster } from "@/components/ui/toaster";
import { TooltipProvider } from "@/components/ui/tooltip";

// Layout
import MainLayout from "./components/layout/MainLayout";

// Pages
import HomePage from "./pages/HomePage";
import Appeals from "./pages/Appeals";
import AppealDetail from "./pages/AppealDetail";
import Zakat from "./pages/Zakat";
import ZakatCalculatorPage from "./pages/ZakatCalculatorPage";
import Sadaqah from "./pages/Sadaqah";
import Qurbani from "./pages/Qurbani";
import Fidya from "./pages/Fidya";
import News from "./pages/News";
import NewsDetail from "./pages/NewsDetail";
import OrphanSponsorship from "./pages/OrphanSponsorship";
import Water from "./pages/Water";
import WhereMostNeeded from "./pages/WhereMostNeeded";
import WhereWeWork from "./pages/WhereWeWork";
import Contact from "./pages/Contact";
import Donate from "./pages/Donate";
import NotFound from "./pages/NotFound";

const queryClient = new QueryClient();

const App = () => (
  <QueryClientProvider client={queryClient}>
    <TooltipProvider>
      <Toaster />
      <Sonner />
      <BrowserRouter>
        <Routes>
          <Route element={<MainLayout />}>
            <Route path="/" element={<HomePage />} />
            
            {/* Appeals */}
            <Route path="/appeals" element={<Appeals />} />
            <Route path="/appeals/:slug" element={<AppealDetail />} />
            
            {/* Islamic Giving */}
            <Route path="/zakat" element={<Zakat />} />
            <Route path="/zakat-calculator" element={<ZakatCalculatorPage />} />
            <Route path="/sadaqah" element={<Sadaqah />} />
            <Route path="/qurbani" element={<Qurbani />} />
            <Route path="/fidya" element={<Fidya />} />
            
            {/* Programs */}
            <Route path="/orphan-sponsorship" element={<OrphanSponsorship />} />
            <Route path="/water" element={<Water />} />
            <Route path="/where-most-needed" element={<WhereMostNeeded />} />
            
            {/* Information */}
            <Route path="/where-we-work" element={<WhereWeWork />} />
            <Route path="/news" element={<News />} />
            <Route path="/news/:slug" element={<NewsDetail />} />
            <Route path="/contact" element={<Contact />} />
            
            {/* Donation */}
            <Route path="/donate" element={<Donate />} />
          </Route>
          
          <Route path="*" element={<NotFound />} />
        </Routes>
      </BrowserRouter>
    </TooltipProvider>
  </QueryClientProvider>
);

export default App;
