<x-website-layout>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(-6deg); }
            50% { transform: translateY(-20px) rotate(-8deg); }
        }
        @keyframes float-delayed {
            0%, 100% { transform: translateY(0) rotate(12deg); }
            50% { transform: translateY(20px) rotate(14deg); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed { animation: float-delayed 7s ease-in-out infinite; }
        .reveal { opacity: 0; transform: translateY(20px); animation: reveal 0.8s ease-out forwards; }
        @keyframes reveal {
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <section class="relative max-w-7xl mx-auto px-8 pt-16 pb-32 flex flex-col md:flex-row items-center overflow-hidden">
        <div class="absolute top-0 left-0 w-72 h-72 bg-[#d4af37] opacity-10 blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#d4af37] opacity-5 blur-[150px] animate-pulse" style="animation-delay: 2s;"></div>

        <div class="w-full md:w-1/2 relative z-10 flex flex-col items-start h-[500px] justify-center">
            <div class="animate-float absolute left-10 md:left-20 top-0 w-64 h-96 bg-gradient-to-br from-[#f3d360] to-[#d4af37] rounded-3xl p-8 shadow-2xl flex flex-col justify-between z-20 transition-all duration-500 hover:scale-105">
                <div class="w-12 h-8 bg-black/20 rounded-md"></div>
                <div class="space-y-4">
                    <div class="w-8 h-8 bg-black/10 rounded"></div>
                    <div class="text-black/60 font-mono text-xs flex justify-between">
                        <span>****</span><span>****</span><span>****</span><span>****</span>
                    </div>
                </div>
            </div>
            <div class="animate-float-delayed absolute left-32 md:left-48 top-40 w-72 h-44 bg-[#1a1a1a] border border-white/10 rounded-2xl p-6 shadow-2xl z-10">
                 <div class="flex gap-1">
                    <div class="w-6 h-6 rounded-full bg-white/10"></div>
                    <div class="w-6 h-6 rounded-full bg-white/10 -ml-3"></div>
                 </div>
            </div>
            <p class="absolute top-[-20px] left-0 text-[10px] uppercase tracking-widest text-gray-600 rotate-[-90deg] origin-left reveal">Secure Your Account</p>
        </div>

        <div class="w-full md:w-1/2 text-right relative z-10 mt-20 md:mt-0 reveal" style="animation-delay: 0.3s;">
            <div class="inline-block p-2 border border-white/10 rounded-lg mb-6 text-[#d4af37] animate-bounce">⬡</div>
            <h1 class="text-5xl md:text-7xl font-light text-white leading-[1.1] mb-8">
                Detect & Trap <br>Card Fraud in <br><span class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#f3d360] to-[#d4af37]">Real Time</span>
            </h1>
            <button class="ml-auto flex items-center gap-3 bg-gradient-to-r from-[#d4af37] to-[#b8860b] text-black px-8 py-4 rounded-full font-bold hover:scale-110 transition-all duration-300 shadow-[0_0_20px_rgba(212,175,55,0.3)]">
                Get Started <span class="text-xl group-hover:translate-x-2 transition-transform">→</span>
            </button>
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-8 py-24 reveal" style="animation-delay: 0.6s;">
        <div class="text-center mb-16">
            <h2 class="text-3xl text-white mb-4">Card <span class="font-bold">Fraud</span> Scenario in <span class="font-bold text-[#d4af37]">Nepal</span></h2>
            <p class="text-gray-500 max-w-2xl mx-auto text-sm leading-relaxed">
                As digital payments surge in Nepal, fraud via phishing and social engineering is on the rise. We provide localized intelligence to safeguard Nepali fintech users.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-[#111] border border-white/5 p-8 rounded-2xl hover:border-[#d4af37]/50 hover:bg-[#161616] transition-all duration-300 group cursor-default">
                <h3 class="text-white font-semibold mb-3 flex items-center gap-2">
                    OTP & Wallet Scams <span class="text-[#d4af37] transform translate-x-[-10px] opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all">→</span>
                </h3>
                <p class="text-xs text-gray-500 leading-relaxed">Fraudsters often impersonate bank staff to steal eSewa or Khalti credentials through fake support calls.</p>
            </div>
            <div class="bg-[#111] border border-white/5 p-8 rounded-2xl hover:border-[#d4af37]/50 hover:bg-[#161616] transition-all duration-300 group cursor-default">
                <h3 class="text-white font-semibold mb-3 flex items-center gap-2">
                    NRB Guidelines <span class="text-[#d4af37] transform translate-x-[-10px] opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all">→</span>
                </h3>
                <p class="text-xs text-gray-500 leading-relaxed">Stay compliant with Nepal Rastra Bank's security mandates regarding 2nd-factor authentication.</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-8 py-32 relative text-center">
        <span class="text-[10px] tracking-[0.2em] text-gray-500 uppercase border border-white/10 px-4 py-1 rounded-full animate-pulse">Financial Solutions</span>
        <h2 class="text-4xl text-white mt-8 mb-20 font-light reveal">How It Works</h2>

        <div class="relative h-[600px] flex justify-center items-center">
            <div class="absolute w-[400px] h-[400px] bg-[#d4af37]/10 blur-[150px] rounded-full animate-pulse"></div>

            <div class="w-80 h-[480px] bg-[#F5F5F0] rounded-[40px] shadow-2xl z-10 flex flex-col justify-between p-10 border-[6px] border-white overflow-hidden relative hover:rotate-2 transition-transform duration-500">
                <div class="text-black/20 font-mono text-xl absolute top-32 -right-16 rotate-90 tracking-widest">**** **** **** 4234</div>
                <div class="w-12 h-12 bg-black/5 rounded-full self-end animate-pulse"></div>
                <div class="flex justify-between items-end">
                    <div class="text-4xl text-black/20 font-bold italic">C</div>
                    <div class="flex gap-1">
                        <div class="w-8 h-8 rounded-full bg-black/10"></div>
                        <div class="w-8 h-8 rounded-full bg-black/10 -ml-4"></div>
                    </div>
                </div>
            </div>

            <div class="reveal absolute top-20 left-[15%] md:left-[25%] bg-white/5 backdrop-blur-xl border border-white/10 p-5 rounded-2xl shadow-2xl w-44 text-left group hover:bg-white/10 transition-all hover:-translate-y-2" style="animation-delay: 0.8s;">
                <div class="w-8 h-8 bg-[#d4af37]/20 rounded-lg mb-3 flex items-center justify-center text-[#d4af37] group-hover:scale-110 transition">💳</div>
                <h4 class="text-white text-xs font-semibold leading-tight">Transaction <br>Monitoring</h4>
            </div>
            
            <div class="reveal absolute bottom-20 left-[10%] md:left-[20%] bg-white/5 backdrop-blur-xl border border-white/10 p-5 rounded-2xl shadow-2xl w-44 text-left group hover:bg-white/10 transition-all hover:-translate-y-2" style="animation-delay: 1s;">
                <div class="w-8 h-8 bg-[#d4af37]/20 rounded-lg mb-3 flex items-center justify-center text-[#d4af37] group-hover:scale-110 transition">⚙️</div>
                <h4 class="text-white text-xs font-semibold leading-tight">Behavior & <br>Risk Analysis</h4>
            </div>

            <div class="reveal absolute top-40 right-[15%] md:right-[25%] bg-white/5 backdrop-blur-xl border border-white/10 p-5 rounded-2xl shadow-2xl w-44 text-left group hover:bg-white/10 transition-all hover:-translate-y-2" style="animation-delay: 1.2s;">
                <div class="w-8 h-8 bg-[#d4af37]/20 rounded-lg mb-3 flex items-center justify-center text-[#d4af37] group-hover:scale-110 transition">⚡</div>
                <h4 class="text-white text-xs font-semibold leading-tight">Automated <br>Response</h4>
            </div>
        </div>
    </section>
</x-website-layout>