<x-website-layout>
    <style>
        /* Base Reveal */
        .reveal { opacity: 0; transform: translateY(30px); animation: reveal 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        @keyframes reveal { to { opacity: 1; transform: translateY(0); } }

        /* Scanning Animation for Service Cards */
        .service-card { position: relative; overflow: hidden; border: 1px solid rgba(255,255,255,0.05); transition: all 0.4s ease; }
        .service-card:hover { border-color: #d4af37; background: rgba(212, 175, 55, 0.03); }
        
        .service-card::after {
            content: "";
            position: absolute;
            top: -100%;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent, rgba(212, 175, 55, 0.05), transparent);
            transition: none;
        }
        .service-card:hover::after {
            animation: scan 2s linear infinite;
        }
        @keyframes scan {
            0% { top: -100%; }
            100% { top: 100%; }
        }
    </style>

    <section class="max-w-7xl mx-auto px-8 pt-32 pb-20 text-center">
        <div class="inline-block px-4 py-1 border border-[#d4af37]/30 rounded-full text-[#d4af37] text-[10px] font-bold tracking-[0.3em] uppercase mb-8 reveal">
            Defense Capabilities
        </div>
        <h1 class="text-5xl md:text-7xl text-white font-light mb-8 reveal" style="animation-delay: 0.1s;">
            Tailored <span class="font-bold">Fraud Defense</span>
        </h1>
        <p class="text-gray-500 max-w-2xl mx-auto text-lg reveal" style="animation-delay: 0.2s;">
            Advanced security modules designed to integrate seamlessly with Nepali financial infrastructure.
        </p>
    </section>

    <section class="max-w-7xl mx-auto px-8 pb-32">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="service-card p-10 rounded-[2.5rem] bg-[#0c0c0c] reveal" style="animation-delay: 0.3s;">
                <div class="w-12 h-12 bg-[#d4af37]/10 rounded-2xl flex items-center justify-center text-[#d4af37] mb-8 text-2xl">📡</div>
                <h3 class="text-2xl text-white font-bold mb-4">Transaction Monitoring</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-8">
                    Instant analysis of card and wallet transactions. We flag anomalies in milliseconds using behavior-based algorithms specific to the Nepali market.
                </p>
                <ul class="space-y-3 text-xs text-gray-400 font-medium">
                    <li class="flex items-center gap-2"><span class="text-[#d4af37]">✓</span> Velocity Tracking</li>
                    <li class="flex items-center gap-2"><span class="text-[#d4af37]">✓</span> Geo-fencing Alerts</li>
                    <li class="flex items-center gap-2"><span class="text-[#d4af37]">✓</span> Merchant Risk Scoring</li>
                </ul>
            </div>

            <div class="service-card p-10 rounded-[2.5rem] bg-[#0c0c0c] reveal" style="animation-delay: 0.4s;">
                <div class="w-12 h-12 bg-[#d4af37]/10 rounded-2xl flex items-center justify-center text-[#d4af37] mb-8 text-2xl">🍯</div>
                <h3 class="text-2xl text-white font-bold mb-4">HoneyPot Traps</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-8">
                    We deploy decoy endpoints to "sting" fraudsters before they reach your real users. Study their methods and block them at the source.
                </p>
                <ul class="space-y-3 text-xs text-gray-400 font-medium">
                    <li class="flex items-center gap-2"><span class="text-[#d4af37]">✓</span> Decoy Wallet Integrations</li>
                    <li class="flex items-center gap-2"><span class="text-[#d4af37]">✓</span> Phishing Link Interception</li>
                    <li class="flex items-center gap-2"><span class="text-[#d4af37]">✓</span> Attacker Fingerprinting</li>
                </ul>
            </div>

            <div class="service-card p-10 rounded-[2.5rem] bg-[#0c0c0c] reveal" style="animation-delay: 0.5s;">
                <div class="w-12 h-12 bg-[#d4af37]/10 rounded-2xl flex items-center justify-center text-[#d4af37] mb-8 text-2xl">🛡️</div>
                <h3 class="text-2xl text-white font-bold mb-4">Social Defense</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-8">
                    Localized protection against OTP scams and impersonation calls. We identify fraudulent patterns in Nepali dialect and messaging.
                </p>
                <ul class="space-y-3 text-xs text-gray-400 font-medium">
                    <li class="flex items-center gap-2"><span class="text-[#d4af37]">✓</span> OTP Leak Detection</li>
                    <li class="flex items-center gap-2"><span class="text-[#d4af37]">✓</span> SMS Header Verification</li>
                    <li class="flex items-center gap-2"><span class="text-[#d4af37]">✓</span> User Education Modules</li>
                </ul>
            </div>

        </div>

        <div class="mt-24 p-12 rounded-[3rem] border border-white/5 bg-gradient-to-b from-[#0c0c0c] to-black flex flex-col md:flex-row items-center justify-between gap-12 reveal" style="animation-delay: 0.6s;">
            <div class="max-w-xl">
                <h4 class="text-white text-3xl font-light mb-4">Ready to <span class="font-bold">Integrate</span>?</h4>
                <p class="text-gray-500 text-sm">
                    Our API is built for speed. Get HoneySting protection running in your environment with minimal latency and maximum security.
                </p>
            </div>
            <div class="flex gap-4">
                <button class="bg-white/5 text-white px-8 py-4 rounded-full font-bold hover:bg-white/10 transition text-sm uppercase tracking-widest">Documentation</button>
                <button class="bg-[#d4af37] text-black px-8 py-4 rounded-full font-bold hover:scale-105 transition text-sm uppercase tracking-widest">Get API Key</button>
            </div>
        </div>
    </section>
</x-website-layout>