<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \App\Models\LandingSetting::getValue('site_title', 'LPK-MI') }} | Lembaga Pelatihan Kerja Manajemen Industri</title>
    <!-- CSRF Token for JavaScript AJAX submissions -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Vite Assets (Tailwind & JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Inline script to apply theme instantly before rendering to prevent flashing -->
    <script>
        const savedTheme = localStorage.getItem('lpk_theme');
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (savedTheme === 'dark' || (!savedTheme && systemDark)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @auth
    @if(auth()->user()->role === 'superadmin')
    <style>
        body.initial-superadmin .tab-content:not(#sec-admin-panel) {
            display: none !important;
        }
        body.initial-superadmin #sec-admin-panel {
            display: block !important;
        }
    </style>
    @endif
    @endauth
</head>
<body class="bg-[#f0f4f8] dark:bg-slate-950 text-slate-950 dark:text-white font-sans min-h-screen relative overflow-x-hidden selection:bg-blue-600 selection:text-white transition-colors duration-300 @auth @if(auth()->user()->role === 'superadmin') initial-superadmin @endif @endauth">

    <!-- Background Gradient Glows -->
    <div class="glow-bg glow-1"></div>
    <div class="glow-bg glow-2"></div>

    <!-- Header Navigation -->
    <header class="sticky top-0 w-full z-50 bg-white/90 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800/60 py-4 @auth @if(auth()->user()->role === 'superadmin') hidden @endif @endauth">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6">
            @php
                $siteLogo = \App\Models\LandingSetting::getValue('site_logo');
                $siteTitle = \App\Models\LandingSetting::getValue('site_title', 'LPK-MI');
            @endphp
            <a href="#" class="flex items-center gap-2.5 text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight" id="nav-logo-btn">
                @if($siteLogo)
                    <img src="{{ asset('storage/' . $siteLogo) }}" class="h-9 w-auto object-contain rounded" alt="{{ $siteTitle }}">
                @else
                    <div class="bg-gradient-to-br from-blue-700 to-sky-500 w-9 h-9 rounded-lg flex items-center justify-center text-white text-xs font-black">
                        MI
                    </div>
                @endif
                <span>{{ $siteTitle }}</span>
            </a>
            
            <nav class="hidden lg:flex items-center gap-1">
                <a href="#beranda" class="nav-link text-xs font-bold uppercase tracking-wider px-3.5 py-2.5 rounded-lg transition-all duration-300 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 border border-blue-100 dark:border-blue-800/40 active-tab-nav" data-tab="beranda">
                    {{ app()->getLocale() === 'id' ? 'Beranda' : 'Home' }}
                </a>
                <a href="#profil" class="nav-link text-xs font-bold uppercase tracking-wider px-3.5 py-2.5 rounded-lg transition-all duration-300 text-slate-600 dark:text-slate-400 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-slate-800" data-tab="profil">
                    {{ app()->getLocale() === 'id' ? 'Profil' : 'Profile' }}
                </a>
                <a href="#program" class="nav-link text-xs font-bold uppercase tracking-wider px-3.5 py-2.5 rounded-lg transition-all duration-300 text-slate-600 dark:text-slate-400 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-slate-800" data-tab="program">
                    {{ app()->getLocale() === 'id' ? 'Program' : 'Programs' }}
                </a>
                <a href="#fasilitas" class="nav-link text-xs font-bold uppercase tracking-wider px-3.5 py-2.5 rounded-lg transition-all duration-300 text-slate-600 dark:text-slate-400 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-slate-800" data-tab="fasilitas">
                    {{ app()->getLocale() === 'id' ? 'Fasilitas' : 'Facilities' }}
                </a>
                <a href="#galeri" class="nav-link text-xs font-bold uppercase tracking-wider px-3.5 py-2.5 rounded-lg transition-all duration-300 text-slate-600 dark:text-slate-400 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-slate-800" data-tab="galeri">
                    {{ app()->getLocale() === 'id' ? 'Galeri' : 'Gallery' }}
                </a>
                <a href="#karir" class="nav-link text-xs font-bold uppercase tracking-wider px-3.5 py-2.5 rounded-lg transition-all duration-300 text-slate-600 dark:text-slate-400 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-slate-800" data-tab="karir">
                    {{ app()->getLocale() === 'id' ? 'Karir & Alumni' : 'Careers & Alumni' }}
                </a>
                <a href="#kontak" class="nav-link text-xs font-bold uppercase tracking-wider px-3.5 py-2.5 rounded-lg transition-all duration-300 text-slate-600 dark:text-slate-400 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-slate-800" data-tab="kontak">
                    {{ app()->getLocale() === 'id' ? 'Kontak' : 'Contact' }}
                </a>
                @auth
                <a href="#admin-panel" class="nav-link text-xs font-bold uppercase tracking-wider px-3.5 py-2.5 rounded-lg transition-all duration-300 text-slate-600 dark:text-slate-400 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-slate-800" data-tab="admin-panel">
                    {{ app()->getLocale() === 'id' ? 'Panel Admin' : 'Admin Panel' }}
                </a>
                @endauth
            </nav>
            
            <div class="flex items-center gap-3">
                <!-- Theme Toggle Button -->
                <button id="theme-toggle" class="bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 p-2.5 rounded-lg border border-slate-300 dark:border-slate-700 shadow-sm transition flex items-center justify-center" aria-label="Ubah Tema">
                    <!-- Sun Icon (visible in dark mode) -->
                    <svg class="w-4.5 h-4.5 hidden dark:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path>
                    </svg>
                    <!-- Moon Icon (visible in light mode) -->
                    <svg class="w-4.5 h-4.5 block dark:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>

                <!-- Hamburger Button (visible on mobile/tablet) -->
                <button id="mobile-menu-toggle" class="lg:hidden bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 p-2.5 rounded-lg border border-slate-300 dark:border-slate-700 shadow-sm transition flex items-center justify-center" aria-label="Menu Mobile">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                @auth
                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-rose-50 dark:bg-rose-950/20 hover:bg-rose-100 dark:hover:bg-rose-950/40 border border-rose-200 dark:border-rose-800/30 text-rose-700 dark:text-rose-455 font-bold text-xs uppercase tracking-wider px-4 py-2.5 rounded-lg shadow-sm transition">
                        {{ app()->getLocale() === 'id' ? 'Keluar' : 'Logout' }}
                    </button>
                </form>
                @else
                <!-- Admin Login Button -->
                <a href="{{ route('login') }}" class="bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs uppercase tracking-wider px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 shadow-sm transition">
                    {{ app()->getLocale() === 'id' ? 'Masuk' : 'Login' }}
                </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Mobile Menu Drawer/Dropdown -->
    <div id="mobile-menu" class="hidden lg:hidden bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800/60 transition-all duration-300 absolute w-full z-40 shadow-lg">
        <div class="px-6 py-4 flex flex-col gap-2">
            <a href="#beranda" class="mobile-nav-link text-xs font-bold uppercase tracking-wider py-3 px-4 rounded-lg transition text-slate-600 dark:text-slate-400" data-tab="beranda">{{ app()->getLocale() === 'id' ? 'Beranda' : 'Home' }}</a>
            <a href="#profil" class="mobile-nav-link text-xs font-bold uppercase tracking-wider py-3 px-4 rounded-lg transition text-slate-600 dark:text-slate-400" data-tab="profil">{{ app()->getLocale() === 'id' ? 'Profil' : 'Profile' }}</a>
            <a href="#program" class="mobile-nav-link text-xs font-bold uppercase tracking-wider py-3 px-4 rounded-lg transition text-slate-600 dark:text-slate-400" data-tab="program">{{ app()->getLocale() === 'id' ? 'Program' : 'Programs' }}</a>
            <a href="#fasilitas" class="mobile-nav-link text-xs font-bold uppercase tracking-wider py-3 px-4 rounded-lg transition text-slate-600 dark:text-slate-400" data-tab="fasilitas">{{ app()->getLocale() === 'id' ? 'Fasilitas' : 'Facilities' }}</a>
            <a href="#galeri" class="mobile-nav-link text-xs font-bold uppercase tracking-wider py-3 px-4 rounded-lg transition text-slate-600 dark:text-slate-400" data-tab="galeri">{{ app()->getLocale() === 'id' ? 'Galeri' : 'Gallery' }}</a>
            <a href="#karir" class="mobile-nav-link text-xs font-bold uppercase tracking-wider py-3 px-4 rounded-lg transition text-slate-600 dark:text-slate-400" data-tab="karir">{{ app()->getLocale() === 'id' ? 'Karir & Alumni' : 'Careers & Alumni' }}</a>
            <a href="#kontak" class="mobile-nav-link text-xs font-bold uppercase tracking-wider py-3 px-4 rounded-lg transition text-slate-600 dark:text-slate-400" data-tab="kontak">{{ app()->getLocale() === 'id' ? 'Kontak' : 'Contact' }}</a>
            @auth
            <a href="#admin-panel" class="mobile-nav-link text-xs font-bold uppercase tracking-wider py-3 px-4 rounded-lg transition text-slate-600 dark:text-slate-400" data-tab="admin-panel">{{ app()->getLocale() === 'id' ? 'Panel Admin' : 'Admin Panel' }}</a>
            @endauth
        </div>
    </div>

    <main id="main-content-container" class="max-w-7xl mx-auto my-10 px-6 min-h-[70vh] @auth @if(auth()->user()->role === 'superadmin') !max-w-full !w-full !m-0 !p-0 !min-h-screen @endif @endauth">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="w-full bg-white dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800/80 py-12 mt-20 text-xs text-slate-500 dark:text-slate-400 transition-colors duration-300 @auth @if(auth()->user()->role === 'superadmin') hidden @endif @endauth">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 mb-8 text-left">
            <div>
                <h4 class="font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-3">{{ $siteTitle }} Jakarta</h4>
                <p class="leading-relaxed mb-2 text-slate-600 dark:text-slate-400">Lembaga Pelatihan Kerja Manajemen Industri & Kompetensi.</p>
                <p class="leading-relaxed">Kawasan Industri Manajemen, Kebayoran Baru, Jakarta Selatan.</p>
            </div>
            <div>
                <h4 class="font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-3">Legalitas Resmi</h4>
                <ul class="space-y-1.5 font-mono text-[10px] text-slate-600 dark:text-slate-400">
                    <li>NIB: 9120300481234</li>
                    <li>Izin Disnaker: 560/124-LPK/Disnaker/2026</li>
                    <li>Status: Terakreditasi Kemnaker RI</li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-3">Kebijakan & Syarat</h4>
                <ul class="space-y-1.5">
                    <li><a href="#kontak" onclick="switchTab('kontak')" class="hover:text-blue-700 dark:hover:text-blue-400 transition">Hubungi CS</a></li>
                    <li><span class="cursor-pointer hover:text-blue-700 dark:hover:text-blue-400 transition" onclick="alert('Kebijakan Privasi: Semua data registrasi, NIK, dan dokumen kelulusan dienkripsi secara aman dan hanya digunakan untuk keperluan sertifikasi kompetensi LPK-MI.')">Kebijakan Privasi</span></li>
                    <li><span class="cursor-pointer hover:text-blue-700 dark:hover:text-blue-400 transition" onclick="alert('Syarat & Ketentuan: Calon peserta pelatihan wajib mematuhi seluruh kurikulum, hadir minimal 80% jam pelajaran, dan bersedia mengikuti uji sertifikasi nasional.')">Syarat & Ketentuan</span></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 border-t border-slate-200 dark:border-slate-800/80 pt-6 flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left">
            <p>&copy; 2026 LPK-MI. Lembaga Pelatihan Kerja Manajemen Industri. All Rights Reserved.</p>
            <div class="flex gap-4">
                <span class="font-medium text-slate-400">Verifikasi Resmi LA-LPK & Kemnaker</span>
            </div>
        </div>
    </footer>

    <!-- App Scripts -->
    <script>
        // SPA state
        const STATE = {
            currentTab: @auth @if(auth()->user()->role === 'superadmin') 'admin-panel' @else 'beranda' @endif @else 'beranda' @endauth,
            apiHits: 0
        };

        document.addEventListener('DOMContentLoaded', () => {
            initApp();
        });

        async function initApp() {
            setupTheme();
            setupNavigation();
            setupScrollHighlight();
            
            // Only fetch stats if authenticated (admin elements are present in the DOM)
            if (document.getElementById('admin-stat-total')) {
                await refreshStats();
            }

            // Explore program CTA
            document.getElementById('explore-programs-btn').addEventListener('click', () => switchTab('program'));
            // Logo CTA
            document.getElementById('nav-logo-btn').addEventListener('click', (e) => {
                e.preventDefault();
                switchTab('beranda');
            });

            // If superadmin is authenticated, trigger switchTab on load
            @auth
            @if(auth()->user()->role === 'superadmin')
            switchTab('admin-panel');
            @endif
            @endauth
        }

        // Fetch metrics from backend dynamically
        async function refreshStats() {
            try {
                const response = await fetch('/admin/dashboard', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                if (data.success) {
                    document.getElementById('admin-stat-total').textContent = data.stats.total;
                    document.getElementById('admin-stat-cert').textContent = data.stats.cert;
                    document.getElementById('admin-stat-api').textContent = data.stats.api;
                    STATE.apiHits = data.stats.api;
                }
            } catch (err) {
                console.error('Error refreshing stats:', err);
            }
        }

        // Toggle Light & Dark Mode
        function setupTheme() {
            const toggleBtn = document.getElementById('theme-toggle');
            if (!toggleBtn) return;

            toggleBtn.addEventListener('click', () => {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('lpk_theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('lpk_theme', 'dark');
                }
            });
        }

        // SPA Navigation tabs
        function setupNavigation() {
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetTab = link.getAttribute('data-tab');
                    switchTab(targetTab);
                });
            });

            // Mobile menu toggle
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            const mobileLinks = document.querySelectorAll('.mobile-nav-link');
            mobileLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (mobileMenu) mobileMenu.classList.add('hidden');
                    const targetTab = link.getAttribute('data-tab');
                    switchTab(targetTab);
                });
            });

            // Handle back/forward buttons or hash routing
            if (window.location.hash) {
                const hashTab = window.location.hash.substring(1);
                const validTabs = ['beranda', 'profil', 'program', 'fasilitas', 'galeri', 'karir', 'kontak', 'admin-panel'];
                if (validTabs.includes(hashTab)) {
                    switchTab(hashTab);
                }
            }
        }

        let isManualScrolling = false;
        let manualScrollTimer = null;

        function setActiveNavbarLink(tabId) {
            document.querySelectorAll('.nav-link, .mobile-nav-link').forEach(link => {
                link.classList.remove('active-tab-nav', 'bg-blue-50', 'dark:bg-blue-900/20', 'text-blue-700', 'dark:text-blue-400', 'border', 'border-blue-100', 'dark:border-blue-800/40');
                link.classList.add('text-slate-600', 'dark:text-slate-400');
                if (link.getAttribute('data-tab') === tabId) {
                    link.classList.remove('text-slate-600', 'dark:text-slate-400');
                    link.classList.add('active-tab-nav', 'bg-blue-50', 'dark:bg-blue-900/20', 'text-blue-700', 'dark:text-blue-400', 'border', 'border-blue-100', 'dark:border-blue-800/40');
                }
            });
        }

        function setupScrollHighlight() {
            window.addEventListener('scroll', () => {
                if (isManualScrolling || STATE.currentTab === 'admin-panel') return;
                
                const sections = ['beranda', 'profil', 'program', 'fasilitas', 'galeri', 'karir', 'kontak'];
                const scrollPosition = window.scrollY + 180; // offset for sticky navbar

                for (const secId of sections) {
                    const el = document.getElementById(`sec-${secId}`);
                    if (el) {
                        const top = el.offsetTop;
                        const height = el.offsetHeight;
                        if (scrollPosition >= top && scrollPosition < top + height) {
                            setActiveNavbarLink(secId);
                            STATE.currentTab = secId;
                            break;
                        }
                    }
                }
            });
        }

        function switchTab(tabId) {
            // Remove initial superadmin body class if present to allow public page rendering
            document.body.classList.remove('initial-superadmin');

            const header = document.querySelector('header');
            const footer = document.querySelector('footer');
            const mainContainer = document.getElementById('main-content-container');

            // Check if it's the admin panel
            if (tabId === 'admin-panel') {
                const adminSec = document.getElementById('sec-admin-panel');
                if (!adminSec) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }
                
                // Hide all public sections
                const publicTabs = ['beranda', 'profil', 'program', 'fasilitas', 'galeri', 'karir', 'kontak'];
                publicTabs.forEach(pTab => {
                    const sec = document.getElementById(`sec-${pTab}`);
                    if (sec) {
                        sec.classList.remove('block');
                        sec.classList.add('hidden');
                    }
                });
                
                // Show admin panel
                adminSec.classList.remove('hidden');
                adminSec.classList.add('block');

                // Hide header and footer, expand container (for superadmin/sidebar view)
                @auth
                @if(auth()->user()->role === 'superadmin')
                if (header) header.classList.add('hidden');
                if (footer) footer.classList.add('hidden');
                if (mainContainer) {
                    mainContainer.classList.add('!max-w-full', '!w-full', '!m-0', '!p-0', '!min-h-screen');
                }
                @endif
                @endauth
            } else {
                // If it's a public tab, make sure all public sections are visible
                const publicTabs = ['beranda', 'profil', 'program', 'fasilitas', 'galeri', 'karir', 'kontak'];
                publicTabs.forEach(pTab => {
                    const sec = document.getElementById(`sec-${pTab}`);
                    if (sec) {
                        sec.classList.remove('hidden');
                        sec.classList.add('block');
                    }
                });
                
                // Hide admin panel if present
                const adminSec = document.getElementById('sec-admin-panel');
                if (adminSec) {
                    adminSec.classList.remove('block');
                    adminSec.classList.add('hidden');
                }

                // Show header and footer, normalize container
                if (header) header.classList.remove('hidden');
                if (footer) footer.classList.remove('hidden');
                if (mainContainer) {
                    mainContainer.classList.remove('!max-w-full', '!w-full', '!m-0', '!p-0', '!min-h-screen');
                }
                
                isManualScrolling = true;
                clearTimeout(manualScrollTimer);

                // Scroll to the targeted section with a layout reflow delay
                setTimeout(() => {
                    const targetSec = document.getElementById(`sec-${tabId}`);
                    if (targetSec) {
                        const headerHeight = document.querySelector('header').offsetHeight || 70;
                        const targetPosition = targetSec.getBoundingClientRect().top + window.pageYOffset - headerHeight - 15;
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                    
                    // Release manual scrolling after smooth scroll finishes
                    manualScrollTimer = setTimeout(() => {
                        isManualScrolling = false;
                    }, 1000);
                }, 50);
            }

            STATE.currentTab = tabId;
            window.location.hash = tabId;
            
            // Update active nav styling
            setActiveNavbarLink(tabId);
        }

        // Called from Program Cards
        function selectProgramAndRegister(programId) {
            window.location.href = "{{ route('login') }}?program=" + programId;
        }


    </script>
</body>
</html>
