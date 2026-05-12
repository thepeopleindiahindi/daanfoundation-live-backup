import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import { HelmetProvider } from "react-helmet-async";
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
import Fidya from "./pages/Fidya";
import ZakatAlFitr from "./pages/ZakatAlFitr";
import News from "./pages/News";
import NewsDetail from "./pages/NewsDetail";
import WhereMostNeeded from "./pages/WhereMostNeeded";
import Contact from "./pages/Contact";
import Donate from "./pages/Donate";
import About from "./pages/About";
import NotFound from "./pages/NotFound";

// New pages
import BankDetails from "./pages/BankDetails";
import Kaffarah from "./pages/Kaffarah";
import SadaqahJariyah from "./pages/SadaqahJariyah";
import CommunityKitchen from "./pages/CommunityKitchen";
import RamadanIftar from "./pages/RamadanIftar";
import WinterAppeal from "./pages/WinterAppeal";
import EidGifts from "./pages/EidGifts";

// Our Work pages
import OurImpact from "./pages/ourwork/OurImpact";
import CharityInAction from "./pages/ourwork/CharityInAction";
import CommunityTrust from "./pages/ourwork/CommunityTrust";
import History from "./pages/ourwork/History";
import ServingWithDignity from "./pages/ourwork/ServingWithDignity";
import SupportingWomen from "./pages/ourwork/SupportingWomen";
import DonationIsTrust from "./pages/ourwork/DonationIsTrust";
import EmpoweringLivelihoods from "./pages/ourwork/EmpoweringLivelihoods";
import WhyTransparency from "./pages/ourwork/WhyTransparency";
import AnnualReport from "./pages/ourwork/AnnualReport";
import ClothingDistribution from "./pages/ourwork/ClothingDistribution";
import MedicalAssistance from "./pages/ourwork/MedicalAssistance";
import EducationalSupport from "./pages/ourwork/EducationalSupport";
import MarriageAssistance from "./pages/ourwork/MarriageAssistance";
import RationKitDistribution from "./pages/ourwork/RationKitDistribution";

const queryClient = new QueryClient();

const App = () => (
  <HelmetProvider>
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
            <Route path="/sadaqah-jariyah" element={<SadaqahJariyah />} />
            <Route path="/fidya" element={<Fidya />} />
            <Route path="/kaffarah" element={<Kaffarah />} />
            <Route path="/zakat-al-fitr" element={<ZakatAlFitr />} />
            
            {/* Programs */}
            <Route path="/community-kitchen" element={<CommunityKitchen />} />
            <Route path="/ramadan" element={<RamadanIftar />} />
            <Route path="/winter" element={<WinterAppeal />} />
            <Route path="/eid-gifts" element={<EidGifts />} />
            <Route path="/where-most-needed" element={<WhereMostNeeded />} />
            
            {/* Our Work */}
            <Route path="/our-work/impact" element={<OurImpact />} />
            <Route path="/our-work/charity-in-action" element={<CharityInAction />} />
            <Route path="/our-work/community-trust" element={<CommunityTrust />} />
            <Route path="/our-work/history" element={<History />} />
            <Route path="/our-work/serving-with-dignity" element={<ServingWithDignity />} />
            <Route path="/our-work/supporting-women" element={<SupportingWomen />} />
            <Route path="/our-work/donation-is-trust" element={<DonationIsTrust />} />
            <Route path="/our-work/empowering-livelihoods" element={<EmpoweringLivelihoods />} />
            <Route path="/our-work/why-transparency" element={<WhyTransparency />} />
            <Route path="/our-work/annual-report" element={<AnnualReport />} />
            <Route path="/our-work/clothing-distribution" element={<ClothingDistribution />} />
            <Route path="/our-work/medical-assistance" element={<MedicalAssistance />} />
            <Route path="/our-work/educational-support" element={<EducationalSupport />} />
            <Route path="/our-work/marriage-assistance" element={<MarriageAssistance />} />
            <Route path="/our-work/ration-kit-distribution" element={<RationKitDistribution />} />
            
            {/* Information */}
            <Route path="/about" element={<About />} />
            <Route path="/news" element={<News />} />
            <Route path="/news/:slug" element={<NewsDetail />} />
            <Route path="/contact" element={<Contact />} />
            <Route path="/bank-details" element={<BankDetails />} />
            
            {/* Donation */}
            <Route path="/donate" element={<Donate />} />
          </Route>
          
          <Route path="*" element={<NotFound />} />
        </Routes>
      </BrowserRouter>
    </TooltipProvider>
  </QueryClientProvider>
  </HelmetProvider>
);

export default App;
