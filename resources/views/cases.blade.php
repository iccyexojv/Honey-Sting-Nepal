<x-website-layout>
    <style>
        /* Modern Reveal Animation */
        .reveal { opacity: 0; transform: translateY(40px); animation: reveal 1s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
        @keyframes reveal { to { opacity: 1; transform: translateY(0); } }

        /* Smooth Card Hover */
        .case-card { transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .case-card:hover { transform: scale(1.02); border-color: rgba(212, 175, 55, 0.4); }
        
        /* Scrolling Ticker */
        .ticker-wrap { overflow: hidden; white-space: nowrap; }
        .ticker { display: inline-block; animation: ticker 30s linear infinite; }
        @keyframes ticker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
    </style>

    <div class="w-full bg-[#d4af37]/10 border-y border-white/5 py-3 overflow-hidden">
        <div class="ticker-wrap flex items-center">
            <div class="ticker text-[#d4af37] text-[10px] font-bold uppercase tracking-[0.3em] flex gap-10">
                <span>⚠️ New Phishing Campaign Detected in Kathmandu</span>
                <span>🛑 423 Cards Blocked in Last 24 Hours</span>
                <span>⚡ NRB Update: New 2FA Mandate Effective Soon</span>
                <span>🛡️ HoneySting AI Model v4.2 Deployed</span>
                <span>⚠️ New Phishing Campaign Detected in Kathmandu</span>
                <span>🛑 423 Cards Blocked in Last 24 Hours</span>
                <span>⚡ NRB Update: New 2FA Mandate Effective Soon</span>
                <span>🛡️ HoneySting AI Model v4.2 Deployed</span>
            </div>
        </div>
    </div>

    <section class="max-w-7xl mx-auto px-8 py-20">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="max-w-2xl reveal">
                <span class="text-[#d4af37] text-xs font-bold tracking-widest uppercase mb-4 block">Case Studies & News</span>
                <h1 class="text-5xl md:text-7xl text-white font-light">The <span class="font-bold">Intelligence</span> Feed</h1>
            </div>
            <div class="reveal" style="animation-delay: 0.2s;">
                <p class="text-gray-500 text-sm max-w-[300px] text-right">Insight into the latest fraud trends and successful interceptions in the Nepal region.</p>
            </div>
        </div>

        <a href="/cases/nepal-telecom-phishing" class="group block relative w-full h-[500px] rounded-[3rem] overflow-hidden mb-8 reveal" style="animation-delay: 0.3s;">
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent z-10"></div>
            <div class="absolute inset-0 bg-[#111] flex items-center justify-center group-hover:scale-105 transition-transform duration-1000">
                <div class="w-full h-full opacity-30 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-[#d4af37]/20 via-transparent to-transparent"></div>
            </div>
            
            <div class="absolute bottom-0 left-0 p-12 z-20">
                <span class="bg-[#d4af37] text-black text-[10px] font-bold px-3 py-1 rounded-full mb-4 inline-block">CRITICAL CASE</span>
                <h2 class="text-4xl md:text-5xl text-white font-bold mb-4 max-w-2xl">The "Holiday Scam" Interception: Saving 1200+ eSewa Wallets</h2>
                <p class="text-gray-300 max-w-lg line-clamp-2">How our HoneyPot sensors identified a sophisticated phishing ring operating from outside Nepal targeting local wallet users during Dashain.</p>
                <div class="mt-6 flex items-center gap-2 text-white font-bold group-hover:gap-4 transition-all">
                    Read Analysis <span>→</span>
                </div>
            </div>
        </a>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="/news/nrb-guidelines" class="case-card bg-[#111]/50 backdrop-blur-sm border border-white/5 p-8 rounded-[2rem] flex flex-col justify-between h-80 reveal" style="animation-delay: 0.4s;">
                <div>
                    <span class="text-gray-500 text-[10px] font-bold tracking-widest uppercase">Regulation • Oct 2023</span>
                    <h3 class="text-white text-xl font-bold mt-4 leading-snug group-hover:text-[#d4af37] transition">New NRB Mandates for Multi-Factor Authentication</h3>
                </div>
                <div class="flex justify-between items-center mt-auto">
                    <span class="text-gray-500 text-xs">5 min read</span>
                    <div class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white">→</div>
                </div>
            </a>

            <a href="/news/tech-update" class="case-card bg-[#111]/50 backdrop-blur-sm border border-white/5 p-8 rounded-[2rem] flex flex-col justify-between h-80 reveal" style="animation-delay: 0.5s;">
                <div>
                    <span class="text-gray-500 text-[10px] font-bold tracking-widest uppercase">Tech • AI Deep Dive</span>
                    <h3 class="text-white text-xl font-bold mt-4 leading-snug">Using Machine Learning to Predict Nepali Dialect Social Engineering</h3>
                </div>
                <div class="flex justify-between items-center mt-auto">
                    <span class="text-gray-500 text-xs">8 min read</span>
                    <div class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white">→</div>
                </div>
            </a>

            <a href="/news/report-2023" class="case-card bg-gradient-to-br from-[#d4af37] to-[#b8860b] p-8 rounded-[2rem] flex flex-col justify-between h-80 reveal" style="animation-delay: 0.6s;">
                <div>
                    <span class="text-black/60 text-[10px] font-bold tracking-widest uppercase">Annual Report</span>
                    <h3 class="text-black text-2xl font-black mt-4 leading-tight">The 2023 Nepal Fraud Landscape Report</h3>
                </div>
                <div class="flex justify-between items-center mt-auto">
                    <span class="text-black font-bold text-xs underline">Download PDF</span>
                    <div class="w-10 h-10 rounded-full bg-black flex items-center justify-center text-white">↓</div>
                </div>
            </a>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-8 py-32 border-t border-white/5 reveal" style="animation-delay: 0.7s;">
        <div class="flex flex-col md:flex-row items-center justify-between gap-12 bg-[#050505] p-12 rounded-[3rem]">
            <div class="max-w-md">
                <h2 class="text-3xl text-white font-bold mb-4">Stay Ahead of Threats</h2>
                <p class="text-gray-500">Get a weekly briefing on fraud patterns specifically targeting the Nepal region. No fluff, just intelligence.</p>
            </div>
            <form class="flex w-full md:w-auto gap-2">
                <input type="email" placeholder="email@example.com" class="bg-white/5 border border-white/10 text-white px-6 py-4 rounded-full focus:outline-none focus:border-[#d4af37] transition w-full md:w-80">
                <button class="bg-[#d4af37] text-black px-8 py-4 rounded-full font-bold hover:scale-105 transition">Subscribe</button>
            </form>
        </div>
    </section>
</x-website-layout>