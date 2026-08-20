<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Skema — {{ $scheme->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <script>
        (function() {
            const saved = localStorage.getItem('lpk_theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .dark .glass {
            background: rgba(15,23,42,0.85);
            border-color: rgba(255,255,255,0.07);
        }
        html:not(.dark) .glass {
            background: rgba(248,250,252,0.85);
            border-color: rgba(0,0,0,0.08);
        }
        .glass {
            backdrop-filter: blur(20px);
            transition: all 0.3s ease;
        }
        *, ::before, ::after { border-radius: 0px !important; }
        .text-\[9px\] { font-size: 0.75rem !important; }
        .text-\[10px\] { font-size: 0.75rem !important; }
        .text-\[11px\] { font-size: 0.875rem !important; }

        /* Light mode overrides */
        html:not(.dark) body {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
        }
        html:not(.dark) .text-slate-400 {
            color: #475569 !important;
        }
        html:not(.dark) .border-slate-800 {
            border-color: #cbd5e1 !important;
        }
        html:not(.dark) .bg-slate-900\/80 {
            background-color: rgba(255, 255, 255, 0.9) !important;
            border-color: #cbd5e1 !important;
        }
        html:not(.dark) .bg-slate-900\/60 {
            background-color: #ffffff !important;
        }
        html:not(.dark) .sticky h1 {
            color: #0f172a !important;
        }

        /* Brand Palette Buttons Override */
        .btn-brand,
        button.bg-blue-600,
        a.bg-blue-600,
        button[type="submit"]:not(.bg-rose-600\/10):not(.bg-amber-600\/20) {
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 50%, #4338ca 100%) !important;
            background-size: 200% 200% !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px 0 rgba(29, 78, 216, 0.35) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .btn-brand:hover,
        button.bg-blue-600:hover,
        a.bg-blue-600:hover,
        button[type="submit"]:not(.bg-rose-600\/10):not(.bg-amber-600\/20):hover {
            background-position: right center !important;
            box-shadow: 0 8px 22px 0 rgba(29, 78, 216, 0.45) !important;
            transform: translateY(-1.5px) !important;
        }
        .btn-brand:active,
        button.bg-blue-600:active,
        a.bg-blue-600:active,
        button[type="submit"]:not(.bg-rose-600\/10):not(.bg-amber-600\/20):active {
            transform: translateY(0) scale(0.97) !important;
        }

        /* Custom Global Text Color Sync Override */
        /* Light Mode: Force slate/gray/neutral/indigo text to black */
        .text-slate-950, .text-slate-900, .text-slate-800, .text-slate-700, .text-slate-650, .text-slate-600, .text-slate-500, .text-slate-400, .text-slate-350, .text-slate-300, .text-slate-200,
        .text-indigo-950, .text-indigo-900, .text-indigo-800, .text-indigo-700, .text-indigo-600, .text-indigo-500, .text-indigo-400, .text-indigo-300, .text-indigo-200,
        .text-gray-950, .text-gray-900, .text-gray-800, .text-gray-700, .text-gray-600, .text-gray-500, .text-gray-400, .text-gray-300, .text-gray-200,
        .text-neutral-950, .text-neutral-900, .text-neutral-800, .text-neutral-700, .text-neutral-600, .text-neutral-500, .text-neutral-400, .text-neutral-300, .text-neutral-200 {
            color: #000000 !important;
        }

        /* Dark Mode: Force slate/gray/neutral/indigo text to white */
        .dark .text-slate-950, .dark .text-slate-900, .dark .text-slate-800, .dark .text-slate-700, .dark .text-slate-650, .dark .text-slate-600, .dark .text-slate-500, .dark .text-slate-400, .dark .text-slate-350, .dark .text-slate-300, .dark .text-slate-200,
        .dark .text-indigo-950, .dark .text-indigo-900, .dark .text-indigo-800, .dark .text-indigo-700, .dark .text-indigo-600, .dark .text-indigo-500, .dark .text-indigo-400, .dark .text-indigo-300, .dark .text-indigo-200,
        .dark .text-gray-950, .dark .text-gray-900, .dark .text-gray-800, .dark .text-gray-700, .dark .text-gray-600, .dark .text-gray-500, .dark .text-gray-400, .dark .text-gray-300, .dark .text-gray-200,
        .dark .text-neutral-950, .dark .text-neutral-900, .dark .text-neutral-800, .dark .text-neutral-700, .dark .text-neutral-600, .dark .text-neutral-500, .dark .text-neutral-400, .dark .text-neutral-300, .dark .text-neutral-200 {
            color: #ffffff !important;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 dark:bg-slate-950 text-slate-950 dark:text-white transition-colors duration-300">

    {{-- Topbar --}}
    <div class="sticky top-0 z-30 bg-slate-900/80 backdrop-blur border-b border-slate-800 px-6 py-3 flex items-center gap-4">
        <a href="{{ route('asesor.dashboard') }}" class="text-slate-300 dark:text-slate-300 hover:text-white bg-slate-800/60 hover:bg-slate-800 px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all border border-slate-700/50 flex items-center gap-1">← Kembali</a>
        <div class="flex-1">
            <h1 class="font-black text-white text-sm">{{ $scheme->title }}</h1>
            <p class="text-[10px] text-slate-400 dark:text-slate-400">Editor Skema Penilaian</p>
        </div>
        <form action="{{ route('asesor.scheme.toggle-publish', $scheme->id) }}" method="POST">
            @csrf
            @if($scheme->status === 'draft')
                <button type="submit" class="btn-brand text-white font-extrabold text-xs uppercase tracking-wider px-5 py-2.5 rounded-xl shadow-md shadow-blue-500/25 active:scale-95 transition-all duration-300">
                    🚀 Publikasikan Skema
                </button>
            @else
                <button type="submit" class="bg-gradient-to-r from-amber-500 via-amber-600 to-amber-500 hover:from-amber-600 hover:to-amber-700 text-white font-extrabold text-xs uppercase tracking-wider px-5 py-2.5 rounded-xl shadow-md shadow-amber-500/20 active:scale-95 transition-all duration-300">
                    ↩️ Kembalikan ke Draft
                </button>
            @endif
        </form>
    </div>

    <div class="max-w-5xl mx-auto p-6 space-y-8">
        {{-- Flash --}}
        @if(session('success'))
            <div class="bg-blue-500/10 border border-blue-500/30 text-blue-400 px-4 py-3 rounded-xl text-sm">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3 rounded-xl text-sm">✕ {{ session('error') }}</div>
        @endif

        {{-- Scheme Status Badge --}}
        <div class="flex items-center gap-3">
            @if($scheme->status === 'published')
                <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 px-3 py-1 rounded-full text-xs font-black uppercase">🟢 Published — Asesi dapat mengerjakan skema ini</span>
            @else
                <span class="bg-amber-500/10 text-amber-400 border border-amber-500/20 px-3 py-1 rounded-full text-xs font-black uppercase">🟡 Draft — Belum bisa dikerjakan asesi</span>
            @endif
        </div>

        {{-- Edit Scheme Details --}}
        <div class="glass rounded-2xl p-6">
            <h2 class="font-bold text-white mb-4">Detail Skema</h2>
            <form action="{{ route('asesor.scheme.update', $scheme->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                @csrf @method('PUT')
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Judul Skema</label>
                    <input type="text" name="title" value="{{ $scheme->title }}" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Durasi (menit)</label>
                    <input type="number" name="duration_minutes" value="{{ $scheme->duration_minutes }}" min="5" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Deskripsi (Opsional)</label>
                    <textarea name="description" rows="2" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 resize-none">{{ $scheme->description }}</textarea>
                </div>
                <div><button type="submit" class="btn-brand text-white font-extrabold text-xs uppercase tracking-wider px-5 py-2.5 rounded-xl shadow-md shadow-blue-500/25 active:scale-95 transition-all duration-300">💾 Simpan Detail</button></div>
            </form>
        </div>

        {{-- Add Question Form --}}
        <div class="glass rounded-2xl p-6">
            <h2 class="font-bold text-white mb-4">Tambah Soal Baru</h2>
            <form action="{{ route('asesor.question.store', $scheme->id) }}" method="POST" id="add-question-form" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Pertanyaan</label>
                        <textarea name="question_text" rows="2" required placeholder="Tulis pertanyaan di sini..."
                            class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 resize-none"></textarea>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Tipe Soal</label>
                            <select name="question_type" id="q-type" onchange="toggleOptions()" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                <option value="multiple_choice">Pilihan Ganda</option>
                                <option value="essay">Esai</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nilai Poin</label>
                            <input type="number" name="points" value="10" min="1" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                </div>

                {{-- Options Area --}}
                <div id="options-area" class="space-y-3">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider font-semibold">Pilihan Jawaban <span class="text-slate-600 font-semibold">(Tandai pilihan yang benar)</span></label>
                    @foreach(['A','B','C','D'] as $i => $ltr)
                    <div class="flex items-center gap-3">
                        <input type="radio" name="correct_option" value="{{ $i }}" {{ $i === 0 ? 'required' : '' }} class="text-blue-500 w-4 h-4 shrink-0">
                        <span class="text-xs font-bold text-slate-400 w-4 font-semibold">{{ $ltr }}</span>
                        <input type="text" name="options[]" required placeholder="Pilihan {{ $ltr }}"
                            class="flex-1 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-1.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                    </div>
                    @endforeach
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn-brand text-white font-extrabold text-xs uppercase tracking-wider px-6 py-2.5 rounded-xl shadow-md shadow-blue-500/25 active:scale-95 transition-all duration-300">
                        ➕ Tambah Soal
                    </button>
                </div>
            </form>
        </div>

        {{-- Question List --}}
        <div>
            <h2 class="text-lg font-black mb-4">Daftar Soal <span class="text-slate-500 dark:text-slate-400 text-sm font-normal">({{ $scheme->questions->count() }} soal)</span></h2>
            @if($scheme->questions->isEmpty())
                <div class="glass rounded-2xl p-10 text-center text-slate-500 dark:text-slate-400 text-sm">Belum ada soal. Tambahkan soal di atas.</div>
            @else
                <div class="space-y-4">
                    @foreach($scheme->questions as $idx => $q)
                    <div class="glass rounded-2xl p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase">Soal {{ $idx + 1 }}</span>
                                    <span class="text-[9px] font-bold uppercase px-2 py-0.5 rounded-full {{ $q->question_type === 'multiple_choice' ? 'bg-blue-500/10 text-blue-400 border border-blue-500/20' : 'bg-purple-500/10 text-purple-400 border border-purple-500/20' }}">
                                        {{ $q->question_type === 'multiple_choice' ? 'Pilihan Ganda' : 'Esai' }}
                                    </span>
                                    <span class="text-[9px] font-bold text-slate-500 dark:text-slate-400">{{ $q->points }} poin</span>
                                </div>
                                <p class="text-white text-sm font-medium mb-3">{{ $q->question_text }}</p>

                                @if($q->question_type === 'multiple_choice')
                                    <div class="space-y-1.5">
                                        @foreach($q->options as $oi => $opt)
                                        <div class="flex items-center gap-2 text-xs {{ $opt->is_correct ? 'text-blue-400 font-bold' : 'text-slate-400' }}">
                                            <span class="w-5 h-5 rounded-full border {{ $opt->is_correct ? 'border-blue-500 bg-blue-500/20' : 'border-slate-700' }} flex items-center justify-center text-[9px] font-black shrink-0">
                                                {{ chr(65 + $oi) }}
                                            </span>
                                            {{ $opt->option_text }}
                                            @if($opt->is_correct) <span class="text-[9px]">✓ Benar</span> @endif
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-xs text-slate-500 dark:text-slate-400 italic">[ Jawaban Esai — penilaian manual ]</div>
                                @endif
                            </div>
                            <form action="{{ route('asesor.question.delete', [$scheme->id, $q->id]) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')" class="shrink-0">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-gradient-to-r from-rose-600 to-red-600 hover:from-rose-700 hover:to-red-700 text-white font-extrabold text-[10px] uppercase px-3 py-1.5 rounded-lg shadow-sm active:scale-95 transition-all duration-300">🗑️ Hapus</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

<script>
    function toggleOptions() {
        const type = document.getElementById('q-type').value;
        const area = document.getElementById('options-area');
        area.style.display = type === 'multiple_choice' ? 'block' : 'none';
        area.querySelectorAll('input[required]').forEach(inp => {
            inp.required = type === 'multiple_choice';
        });
    }
</script>
</body>
</html>
