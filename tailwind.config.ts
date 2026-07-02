import type { Config } from "tailwindcss";

const config: Config = {
  content: [
    "./wp-content/themes/daan-custom/**/*.php",
    "./wp-content/themes/daan-custom/**/*.html",
    "./wp-content/themes/daan-custom/**/*.js",
    // Pehle wale paths bhi rakh sakte ho agar Next.js ke bhi hain:
    // "./pages/**/*.{js,ts,jsx,tsx,mdx}",
    // "./components/**/*.{js,ts,jsx,tsx,mdx}",
    // "./app/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};

export default config;
