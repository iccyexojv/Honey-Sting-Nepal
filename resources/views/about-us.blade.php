<x-website-layout>
    <style>
        /* Base Reveal Animation */
        .reveal { opacity: 0; transform: translateY(30px); animation: reveal 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        @keyframes reveal { to { opacity: 1; transform: translateY(0); } }

        /* Floating Particles Animation */
        .particle { animation: drift 20s linear infinite; }
        @keyframes drift {
            from { transform: translateY(0) translateX(0) rotate(0deg); }
            to { transform: translateY(-100vh) translateX(50px) rotate(360deg); }
        }

        /* Value Card Hover */
        .value-card { transition: all 0.4s ease; border: 1px solid rgba(255,255,255,0.05); }
        .value-card:hover { 
            border-color: #d4af37; 
            background: rgba(212, 175, 55, 0.05); 
            transform: translateY(-5px); 
        }

        /* Enhanced Spinner */
        .animate-spin-slow { animation: spin 12s linear infinite; }
        .animate-reverse-spin { animation: spin-reverse 10s linear infinite; }
        @keyframes spin-reverse { from { transform: rotate(360deg); } to { transform: rotate(0deg); } }
    </style>

    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="particle absolute bottom-[-10%] left-[10%] w-2 h-2 bg-[#d4af37] rounded-full blur-sm opacity-20"></div>
        <div class="particle absolute bottom-[-20%] left-[40%] w-3 h-3 bg-[#d4af37] rounded-full blur-sm opacity-10" style="animation-delay: 5s;"></div>
        <div class="particle absolute bottom-[-15%] left-[80%] w-2 h-2 bg-[#d4af37] rounded-full blur-sm opacity-15" style="animation-delay: 10s;"></div>
    </div>

    <section class="relative max-w-7xl mx-auto px-8 pt-32 pb-20 z-10">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#d4af37] opacity-[0.07] blur-[150px] animate-pulse"></div>
        
        <div class="max-w-4xl">
            <span class="inline-flex items-center gap-2 text-[#d4af37] text-xs font-bold tracking-[0.3em] uppercase mb-6 reveal">
                <span class="w-2 h-2 rounded-full bg-[#d4af37] animate-ping"></span> Our Identity
            </span>
            <h1 class="text-6xl md:text-8xl text-white font-light leading-[1.1] mb-10 reveal" style="animation-delay: 0.2s;">
                Engineering <span class="font-bold italic text-transparent bg-clip-text bg-gradient-to-r from-[#f3d360] via-[#d4af37] to-[#b8860b]">Digital Resilience.</span>
            </h1>
            <p class="text-gray-400 text-xl leading-relaxed max-w-2xl reveal" style="animation-delay: 0.4s;">
                We aren't just a security firm; we are the architects of trust in Nepal's digital age. By merging global standards with local context, we neutralize threats before they reach your doorstep.
            </p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-8 py-16 z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-12 border-y border-white/5 py-16 reveal" style="animation-delay: 0.6s;">
            <div class="group cursor-default">
                <div class="text-4xl text-[#d4af37] font-bold mb-2 group-hover:scale-110 transition-transform">24/7</div>
                <div class="text-gray-500 text-xs uppercase tracking-widest font-medium">Real-time Watch</div>
            </div>
            <div class="group cursor-default">
                <div class="text-4xl text-[#d4af37] font-bold mb-2 group-hover:scale-110 transition-transform">12ms</div>
                <div class="text-gray-500 text-xs uppercase tracking-widest font-medium">Latent Response</div>
            </div>
            <div class="group cursor-default">
                <div class="text-4xl text-[#d4af37] font-bold mb-2 group-hover:scale-110 transition-transform">100%</div>
                <div class="text-gray-500 text-xs uppercase tracking-widest font-medium">Data Sovereignty</div>
            </div>
            <div class="group cursor-default">
                <div class="text-4xl text-[#d4af37] font-bold mb-2 group-hover:scale-110 transition-transform">NRB</div>
                <div class="text-gray-500 text-xs uppercase tracking-widest font-medium">Compliant Tech</div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-8 py-24 z-10">
        <div class="mb-16 reveal">
            <h2 class="text-3xl text-white font-light">The <span class="font-bold">Pillars</span> of HoneySting</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="value-card p-10 rounded-3xl bg-[#0a0a0a] reveal" style="animation-delay: 0.7s;">
                <div class="text-[#d4af37] text-3xl mb-6">🛡️</div>
                <h4 class="text-white text-xl font-bold mb-4">Proactive Defense</h4>
                <p class="text-gray-500 text-sm leading-relaxed">We don't wait for attacks. Our honey-pot systems actively lure and identify malicious actors to study their patterns first.</p>
            </div>
            <div class="value-card p-10 rounded-3xl bg-[#0a0a0a] reveal" style="animation-delay: 0.8s;">
                <div class="text-[#d4af37] text-3xl mb-6">🇳🇵</div>
                <h4 class="text-white text-xl font-bold mb-4">Localized Intel</h4>
                <p class="text-gray-500 text-sm leading-relaxed">Global tools often miss local nuances. We specialize in detecting fraud unique to the Nepali SMS and wallet ecosystem.</p>
            </div>
            <div class="value-card p-10 rounded-3xl bg-[#0a0a0a] reveal" style="animation-delay: 0.9s;">
                <div class="text-[#d4af37] text-3xl mb-6">👁️</div>
                <h4 class="text-white text-xl font-bold mb-4">Total Transparency</h4>
                <p class="text-gray-500 text-sm leading-relaxed">Trust is earned through visibility. Our clients get real-time dashboards showing exactly what we block and why.</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-8 py-24 z-10 border-t border-white/5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-20 items-center">
            <div class="relative flex justify-center order-2 md:order-1 reveal" style="animation-delay: 1s;">
                <div class="w-80 h-80 border border-white/5 rounded-full flex items-center justify-center relative">
                    <div class="absolute inset-0 border-t-2 border-[#d4af37] rounded-full animate-spin-slow opacity-40"></div>
                    <div class="w-64 h-64 border border-[#d4af37]/20 rounded-full flex items-center justify-center animate-reverse-spin">
                        <div class="w-48 h-48 bg-gradient-to-br from-[#111] to-black border border-[#d4af37]/40 rounded-full flex items-center justify-center shadow-[0_0_50px_rgba(212,175,55,0.1)]">
                             <div class="text-[#d4af37] text-5xl font-black tracking-tighter">HS</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-12 order-1 md:order-2">
                <div class="reveal" style="animation-delay: 1.1s;">
                    <h3 class="text-4xl text-white font-light mb-6 leading-snug">Our <span class="font-bold italic">Mission</span></h3>
                    <p class="text-gray-400 leading-relaxed text-lg">
                        To build a impenetrable shield around Nepal's financial future. We empower banks, PSPs, and individual users with the tools they need to stay ahead of cyber-criminals, ensuring that innovation is never hampered by fear.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-8 py-32 text-center z-10 reveal">
        <div class="bg-gradient-to-tr from-[#0a0a0a] via-[#111] to-[#0a0a0a] border border-white/10 p-20 rounded-[4rem] relative overflow-hidden group">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#d4af37] opacity-10 blur-[100px] group-hover:opacity-20 transition-opacity"></div>
            <h2 class="text-5xl text-white mb-8 font-light">Ready to <span class="font-bold">Sting</span> Back?</h2>
            <p class="text-gray-500 mb-12 max-w-xl mx-auto text-lg leading-relaxed">
                Join the network of secure financial institutions in Nepal. Let's discuss how HoneySting can protect your specific infrastructure.
            </p>
            <div class="flex flex-col md:flex-row gap-4 justify-center items-center">
                <button class="bg-[#d4af37] text-black px-12 py-5 rounded-full font-bold hover:scale-105 transition-all shadow-[0_10px_30px_rgba(212,175,55,0.2)]">
                    Schedule a Demo
                </button>
                <button class="border border-white/20 text-white px-12 py-5 rounded-full font-bold hover:bg-white/5 transition-all">
                    View Case Studies
                </button>
            </div>
        </div>
    </section>
</x-website-layout>