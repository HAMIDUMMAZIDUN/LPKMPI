<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian — {{ $scheme->title }}</title>
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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .dark .glass {
            background: rgba(15,23,42,0.90);
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
        .option-label { cursor: pointer; transition: all .15s; }
        .option-label:hover { border-color: rgba(139,92,246,0.5); background: rgba(139,92,246,0.08); }
        input[type="radio"]:checked + .option-inner { border-color: #7c3aed; background: rgba(124,58,237,0.15); }
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
        html:not(.dark) .bg-slate-900\/90 {
            background-color: rgba(255, 255, 255, 0.9) !important;
            border-color: #cbd5e1 !important;
        }
        html:not(.dark) .bg-slate-900\/60 {
            background-color: #ffffff !important;
        }
        html:not(.dark) .sticky h1 {
            color: #0f172a !important;
        }
        html:not(.dark) .option-inner {
            background-color: #ffffff !important;
            color: #0f172a !important;
            border-color: #cbd5e1 !important;
        }
        html:not(.dark) .option-label:hover .option-inner {
            border-color: rgba(139,92,246,0.5) !important;
            background: rgba(139,92,246,0.08) !important;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 dark:bg-slate-950 text-slate-950 dark:text-white transition-colors duration-300">

    {{-- Topbar Ujian --}}
    <div class="sticky top-0 z-30 bg-slate-900/90 backdrop-blur border-b border-slate-800 px-6 py-3 flex items-center justify-between">
        <div>
            <div class="text-[10px] font-black uppercase tracking-widest text-violet-400">Ujian Berlangsung</div>
            <h1 class="font-black text-white text-sm">{{ $scheme->title }}</h1>
        </div>
        <div class="flex items-center gap-4">
            <div class="glass rounded-xl px-4 py-1.5 text-center">
                <div class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase">Waktu</div>
                <div id="timer" class="text-lg font-black text-white">{{ sprintf('%02d:%02d', intdiv($scheme->duration_minutes, 60), $scheme->duration_minutes % 60) }}:00</div>
            </div>
            <div class="glass rounded-xl px-4 py-1.5 text-center">
                <div class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase">Soal</div>
                <div class="text-lg font-black text-white">{{ $scheme->questions->count() }}</div>
            </div>
        </div>
    </div>

    <form id="exam-form" action="{{ route('asesi.exam.finish', $attempt->id) }}" method="POST">
        @csrf
        <div class="max-w-3xl mx-auto p-6 space-y-6 pb-32">

            @forelse($scheme->questions as $idx => $q)
            <div class="glass rounded-2xl p-6" id="question-{{ $q->id }}">
                <div class="flex items-start gap-3 mb-4">
                    <span class="shrink-0 w-8 h-8 rounded-xl bg-violet-600/20 border border-violet-500/30 text-violet-400 text-xs font-black flex items-center justify-center">
                        {{ $idx + 1 }}
                    </span>
                    <div class="flex-1">
                        <p class="font-medium text-white text-sm leading-relaxed">{{ $q->question_text }}</p>
                        <span class="text-[9px] text-slate-500 dark:text-slate-400 font-bold uppercase mt-1 block">
                            {{ $q->question_type === 'multiple_choice' ? 'Pilihan Ganda' : 'Esai' }} · {{ $q->points }} poin
                        </span>
                    </div>
                </div>

                @if($q->question_type === 'multiple_choice')
                    <div class="space-y-2">
                        @foreach($q->options as $oi => $opt)
                        <label class="option-label block">
                            <input type="radio" name="answers[{{ $q->id }}][selected_option_id]" value="{{ $opt->id }}"
                                {{ isset($savedAnswers[$q->id]) && $savedAnswers[$q->id]->selected_option_id == $opt->id ? 'checked' : '' }}
                                class="hidden"
                                onchange="autoSave({{ $attempt->id }}, {{ $q->id }}, {{ $opt->id }}, null)">
                            <div class="option-inner flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-700 {{ isset($savedAnswers[$q->id]) && $savedAnswers[$q->id]->selected_option_id == $opt->id ? 'border-violet-500 bg-violet-500/15' : '' }}">
                                <span class="shrink-0 w-6 h-6 rounded-full border border-slate-600 flex items-center justify-center text-[10px] font-black text-slate-400">
                                    {{ chr(65 + $oi) }}
                                </span>
                                <span class="text-sm text-slate-200">{{ $opt->option_text }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                @else
                    <textarea name="answers[{{ $q->id }}][essay_answer]" rows="4"
                        placeholder="Tulis jawaban Anda di sini..."
                        class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-violet-500 resize-none transition-all"
                        >{{ $savedAnswers[$q->id]->essay_answer ?? '' }}</textarea>
                @endif
            </div>
            @empty
                <div class="glass rounded-2xl p-10 text-center text-slate-500 dark:text-slate-400">Skema ini belum memiliki soal.</div>
            @endforelse
        </div>

        {{-- Fixed Submit Button --}}
        <div class="fixed bottom-0 left-0 right-0 bg-slate-900/95 backdrop-blur border-t border-slate-800 p-4 flex items-center justify-between z-30">
            <div class="text-xs text-slate-400">
                <span id="answered-count">0</span> dari {{ $scheme->questions->count() }} soal dijawab
            </div>
            <button type="button" onclick="confirmSubmit()"
                class="bg-violet-600 hover:bg-violet-700 text-white font-black text-sm uppercase tracking-wider px-8 py-3 rounded-xl transition-all shadow-xl shadow-violet-500/30">
                Selesai & Kumpulkan Jawaban
            </button>
        </div>
    </form>

    {{-- Confirm Modal --}}
    <div id="confirm-modal" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
        <div class="glass rounded-2xl p-8 max-w-md w-full text-center space-y-4">
            <div class="text-4xl">⚠️</div>
            <h3 class="text-white font-black text-lg">Kumpulkan Jawaban?</h3>
            <p class="text-slate-400 text-sm">Setelah dikumpulkan, jawaban tidak dapat diubah lagi. Pastikan Anda telah menjawab semua soal.</p>
            <div class="flex gap-3 mt-4">
                <button onclick="document.getElementById('confirm-modal').classList.add('hidden')" class="flex-1 bg-slate-800 hover:bg-slate-700 text-white font-bold text-sm py-2.5 rounded-xl transition-all">Batal</button>
                <button onclick="document.getElementById('exam-form').submit()" class="flex-1 bg-violet-600 hover:bg-violet-700 text-white font-black text-sm py-2.5 rounded-xl transition-all">Ya, Kumpulkan</button>
            </div>
        </div>
    </div>

<script>
    // Auto-save answer via AJAX
    function autoSave(attemptId, questionId, optionId, essayText) {
        fetch(`/asesi/exam/${attemptId}/answer`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                question_id: questionId,
                selected_option_id: optionId,
                essay_answer: essayText
            })
        });
        updateAnsweredCount();
    }

    function updateAnsweredCount() {
        const radios = document.querySelectorAll('input[type="radio"]:checked');
        const essays = Array.from(document.querySelectorAll('textarea')).filter(t => t.value.trim() !== '');
        document.getElementById('answered-count').textContent = radios.length + essays.length;
    }

    function confirmSubmit() {
        document.getElementById('confirm-modal').classList.remove('hidden');
    }

    // Countdown Timer
    const totalSeconds = {{ $scheme->duration_minutes }} * 60;
    let remaining = totalSeconds;
    const timerEl = document.getElementById('timer');

    function updateTimer() {
        const h = Math.floor(remaining / 3600);
        const m = Math.floor((remaining % 3600) / 60);
        const s = remaining % 60;
        timerEl.textContent = (h > 0 ? String(h).padStart(2,'0')+':' : '') + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
        if (remaining <= 300) timerEl.classList.add('text-rose-400');
        if (remaining <= 0) {
            timerEl.textContent = '00:00';
            document.getElementById('exam-form').submit();
        }
        remaining--;
    }

    setInterval(updateTimer, 1000);
    updateAnsweredCount();

    // Style selected radio visually
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const group = document.querySelectorAll(`input[name="${this.name}"]`);
            group.forEach(r => {
                const inner = r.nextElementSibling;
                inner.classList.remove('border-violet-500', 'bg-violet-500/15');
            });
            this.nextElementSibling.classList.add('border-violet-500', 'bg-violet-500/15');
        });
    });
</script>
</body>
</html>
