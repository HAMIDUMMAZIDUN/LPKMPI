<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Ujian — {{ $attempt->scheme->title }}</title>
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
        html:not(.dark) .text-white {
            color: #0f172a !important;
        }
        html:not(.dark) .text-slate-400 {
            color: #475569 !important;
        }
        html:not(.dark) .border-slate-800 {
            border-color: #cbd5e1 !important;
        }
        html:not(.dark) .bg-slate-900\/60 {
            background-color: #ffffff !important;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 dark:bg-slate-950 text-slate-950 dark:text-white transition-colors duration-300">

    <div class="max-w-3xl mx-auto p-6 space-y-8">
        {{-- Header Result --}}
        @php
            $score = $attempt->score;
            $isPass = $score >= 70;
            $answerMap = $attempt->answers->keyBy('question_id');
        @endphp

        <div class="text-center pt-8 pb-2">
            <div class="text-6xl mb-4">{{ $isPass ? '🏆' : '📝' }}</div>
            <h1 class="text-3xl font-black text-white mb-2">{{ $isPass ? 'Selamat! Anda Lulus' : 'Belum Lulus' }}</h1>
            <p class="text-slate-400 text-sm">{{ $attempt->scheme->title }}</p>
        </div>

        {{-- Score Card --}}
        <div class="glass rounded-3xl p-8 text-center">
            <div class="text-7xl font-black mb-2 {{ $isPass ? 'text-emerald-400' : 'text-rose-400' }}">{{ $score }}%</div>
            <div class="text-slate-400 text-sm mb-6">Nilai Akhir</div>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-slate-900/60 rounded-xl p-3">
                    <div class="text-lg font-black text-white">{{ $attempt->scheme->questions->count() }}</div>
                    <div class="text-[10px] text-slate-500 font-bold uppercase">Total Soal</div>
                </div>
                <div class="bg-slate-900/60 rounded-xl p-3">
                    <div class="text-lg font-black {{ $isPass ? 'text-emerald-400' : 'text-rose-400' }}">{{ $isPass ? 'Lulus' : 'Belum Lulus' }}</div>
                    <div class="text-[10px] text-slate-500 font-bold uppercase">Status</div>
                </div>
                <div class="bg-slate-900/60 rounded-xl p-3">
                    <div class="text-lg font-black text-white">{{ $attempt->completed_at?->format('d/m/Y') }}</div>
                    <div class="text-[10px] text-slate-500 font-bold uppercase">Tanggal</div>
                </div>
            </div>

            <div class="mt-6 flex justify-center">
                <a href="{{ route('asesi.dashboard') }}" class="bg-violet-600 hover:bg-violet-700 text-white font-bold text-sm uppercase tracking-wider px-8 py-3 rounded-xl transition-all shadow-lg shadow-violet-500/20">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        {{-- Answer Review --}}
        <div>
            <h2 class="text-lg font-black text-white mb-4">Pembahasan Jawaban</h2>
            <div class="space-y-4">
                @foreach($attempt->scheme->questions as $idx => $q)
                    @php
                        $answer = $answerMap[$q->id] ?? null;
                        $isCorrect = false;
                        if($q->question_type === 'multiple_choice' && $answer?->selectedOption?->is_correct) {
                            $isCorrect = true;
                        }
                    @endphp
                    <div class="glass rounded-2xl p-5 border {{ $q->question_type === 'multiple_choice' ? ($isCorrect ? 'border-emerald-500/30' : 'border-rose-500/30') : 'border-slate-800' }}">
                        <div class="flex items-start gap-3 mb-3">
                            <span class="shrink-0 w-7 h-7 rounded-lg {{ $q->question_type === 'multiple_choice' ? ($isCorrect ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400') : 'bg-slate-800 text-slate-400' }} text-xs font-black flex items-center justify-center">
                                {{ $idx + 1 }}
                            </span>
                            <div class="flex-1">
                                <p class="text-white text-sm font-medium">{{ $q->question_text }}</p>
                            </div>
                            @if($q->question_type === 'multiple_choice')
                                <span class="shrink-0 text-[10px] font-black uppercase {{ $isCorrect ? 'text-emerald-400' : 'text-rose-400' }}">
                                    {{ $isCorrect ? '✓ Benar' : '✕ Salah' }}
                                </span>
                            @endif
                        </div>

                        @if($q->question_type === 'multiple_choice')
                            <div class="space-y-1.5 mt-2">
                                @foreach($q->options as $oi => $opt)
                                    @php
                                        $isSelected = $answer?->selected_option_id == $opt->id;
                                        $isCorrOpt = $opt->is_correct;
                                    @endphp
                                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs
                                        {{ $isCorrOpt ? 'bg-emerald-500/10 border border-emerald-500/20' : ($isSelected && !$isCorrOpt ? 'bg-rose-500/10 border border-rose-500/20' : 'bg-slate-900/40 border border-slate-800') }}">
                                        <span class="w-5 h-5 rounded-full border {{ $isCorrOpt ? 'border-emerald-500 bg-emerald-500/20 text-emerald-400' : ($isSelected ? 'border-rose-500 bg-rose-500/20 text-rose-400' : 'border-slate-700 text-slate-500') }} flex items-center justify-center text-[9px] font-black shrink-0">
                                            {{ chr(65 + $oi) }}
                                        </span>
                                        <span class="{{ $isCorrOpt ? 'text-emerald-300' : ($isSelected && !$isCorrOpt ? 'text-rose-300' : 'text-slate-400') }}">
                                            {{ $opt->option_text }}
                                        </span>
                                        @if($isCorrOpt) <span class="ml-auto text-emerald-400 font-bold">✓ Benar</span> @endif
                                        @if($isSelected && !$isCorrOpt) <span class="ml-auto text-rose-400 font-bold">Jawaban Anda</span> @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-slate-900/60 rounded-xl p-3 mt-2">
                                <div class="text-[10px] text-slate-500 font-bold uppercase mb-1">Jawaban Esai Anda</div>
                                <p class="text-slate-300 text-sm">{{ $answer?->essay_answer ?: '(Tidak dijawab)' }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
