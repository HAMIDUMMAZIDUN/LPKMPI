{{-- ============================================================ --}}
{{-- PARTIAL: Landing Page Footer                                  --}}
{{-- Included at the bottom of landing.blade.php                  --}}
{{-- Uses <section> (not <footer>) so it sits inside #pub-main-   --}}
{{-- wrap exactly like every other section and is never covered    --}}
{{-- by the fixed sidebar.                                         --}}
{{-- ============================================================ --}}
@php
    $footerLogo = \App\Models\LandingSetting::getValue('site_logo');
@endphp

<section id="sec-footer" class="w-full bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800/60 py-16 text-xs text-slate-600 dark:text-slate-400 text-left transition-colors duration-300">

    {{-- ── Main grid ─────────────────────────────────────────────── --}}
    <div class="max-w-7xl mx-auto px-6 sm:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

        {{-- Col 1 – Branding & Kantor Pusat --}}
        <div class="sm:col-span-2 lg:col-span-1 space-y-4">
            <div class="flex items-center gap-3">
                @if($footerLogo)
                    <img src="{{ asset('storage/'.$footerLogo) }}?v={{ file_exists(public_path('storage/'.$footerLogo)) ? filemtime(public_path('storage/'.$footerLogo)) : time() }}"
                         class="w-9 h-9 object-contain shrink-0" alt="LPK MPI">
                @else
                    <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center text-white font-black text-xs shrink-0">MPI</div>
                @endif
                <div>
                    <div class="font-extrabold text-sm text-slate-900 dark:text-white tracking-tight uppercase leading-tight">LPK Manajemen Pendidikan Indonesia</div>
                    <div class="text-[10px] text-slate-500 dark:text-slate-400 font-medium">Lembaga Pelatihan Kerja Resmi</div>
                </div>
            </div>

            <div>
                <p class="font-bold text-slate-800 dark:text-slate-200 mb-1">Kantor Pusat:</p>
                <p class="leading-relaxed">Jl. Gedebage Selatan No.137, Kota Bandung, Jawa Barat 40294</p>
            </div>

            <div class="space-y-1 font-mono text-[10px] text-slate-500 dark:text-slate-500">
                <p>📞 +62 811-2009-989</p>
                <p>✉️ lpkmpi@gmail.com / info@lpk-mpi.org</p>
            </div>
        </div>

        {{-- Col 2 – Pusdiklat Bandung --}}
        <div class="space-y-4">
            <h4 class="font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading text-[10px]">Pusdiklat Bandung</h4>
            <p class="leading-relaxed">
                Jl. Arcamanik Sindanglaya, KP. Sekesalam RT/RW 001/008,<br>
                DS. Sindanglaya, Kec. Cimenyan, Kab. Bandung, Jawa Barat 40195
            </p>
        </div>

        {{-- Col 3 – Follow Us --}}
        <div class="space-y-4">
            <h4 class="font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading text-[10px]">Follow Us</h4>
            <ul class="space-y-2 font-medium">
                <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Facebook</a></li>
                <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Twitter / X</a></li>
                <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Youtube</a></li>
                <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Instagram</a></li>
            </ul>
        </div>

        {{-- Col 4 – Partnership --}}
        <div class="space-y-4">
            <h4 class="font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading text-[10px]">Partnership</h4>
            <div class="flex flex-wrap gap-3 opacity-75">
                <div class="w-9 h-9 rounded bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/40 flex items-center justify-center text-[10px] font-black text-blue-600 dark:text-blue-400">C</div>
                <div class="w-9 h-9 rounded bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/40 flex items-center justify-center text-[10px] font-black text-slate-700 dark:text-slate-300">IGS</div>
                <div class="w-9 h-9 rounded bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/40 flex items-center justify-center text-[10px] font-black text-slate-700 dark:text-slate-300">F</div>
            </div>
        </div>
    </div>

    {{-- ── Bottom bar ──────────────────────────────────────────────── --}}
    <div class="max-w-7xl mx-auto px-6 sm:px-8 border-t border-slate-100 dark:border-slate-800/60 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-center sm:text-left">
        <p class="text-slate-500 dark:text-slate-500 font-semibold">
            &copy; 2026 LPK Manajemen Pendidikan Indonesia. All Rights Reserved.
        </p>
        <div class="flex gap-4 text-slate-400 dark:text-slate-500 font-semibold">
            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Terms</a>
            <span>•</span>
            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Privacy</a>
            <span>•</span>
            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Cookies</a>
        </div>
    </div>

</section>
