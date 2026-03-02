<body class="bg-[#080808] text-gray-400 antialiased selection:bg-yellow-500/30"></body>

<nav id="navbar" class="fixed top-0 left-0 right-0 z-[100] px-4 py-6 transition-all duration-500 ease-in-out">
    <div class="max-w-7xl mx-auto flex justify-between items-center py-3 px-6 rounded-full border border-white/0 bg-transparent transition-all duration-300">
        
        <div class="flex items-center gap-3 group cursor-pointer">
            <div class="w-9 h-9 bg-[#d4af37] rounded-xl flex items-center justify-center text-black font-black text-xs transition-transform duration-500 group-hover:rotate-[360deg]">
                HS
            </div>
            <div class="text-[#d4af37] font-bold text-xl tracking-tighter">
                HoneySting <span class="text-white font-light opacity-80">Nepal</span>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-2">
            <a href="{{ route('home') }}" class="px-5 py-2 text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400 hover:text-[#d4af37] transition-colors relative group">
                Home
                <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-[#d4af37] transition-all group-hover:w-4"></span>
            </a>
            <a href="{{ route('about-us') }}" class="px-5 py-2 text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400 hover:text-[#d4af37] transition-colors relative group">About</a>
            <a href="{{ route('cases') }}" class="px-5 py-2 text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400 hover:text-[#d4af37] transition-colors relative group">Cases</a>
            <a href="{{ route('services') }}" class="px-5 py-2 text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400 hover:text-[#d4af37] transition-colors relative group">Services</a>
        </div>

        <div class="flex items-center gap-4">
            
            <button class="bg-[#d4af37] text-black text-[11px] font-black uppercase tracking-widest px-7 py-3 rounded-full hover:scale-105 active:scale-95 transition-all shadow-[0_10px_20px_rgba(212,175,55,0.1)]">
                Get Started
            </button>
            
            <button class="md:hidden flex flex-col gap-1.5 p-2" id="mobile-menu-btn">
                <div class="w-6 h-0.5 bg-[#d4af37] rounded-full"></div>
                <div class="w-6 h-0.5 bg-white rounded-full"></div>
            </button>
        </div>
    </div>
</nav>

<script>
    const navbar = document.getElementById('navbar');
    const navInner = navbar.querySelector('div');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            // "Premium Scroll" State
            navbar.classList.add('py-3');
            navInner.classList.add('bg-black/60', 'backdrop-blur-md', 'border-white/5', 'shadow-2xl');
            navInner.classList.remove('border-white/0');
        } else {
            // "Initial" State
            navbar.classList.remove('py-3');
            navInner.classList.remove('bg-black/60', 'backdrop-blur-md', 'border-white/5', 'shadow-2xl');
            navInner.classList.add('border-white/0');
        }
    });
</script>