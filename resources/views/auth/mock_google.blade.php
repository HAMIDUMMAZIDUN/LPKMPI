<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pilih Akun - LPK-MI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        *, ::before, ::after { border-radius: 0px !important; }
    </style>
</head>
<body class="h-full min-h-screen bg-slate-950 flex items-center justify-center p-4">
    <div class="w-full max-w-[420px] bg-slate-900 rounded-3xl p-8 border border-slate-800 shadow-2xl flex flex-col">

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center">
                    <span class="text-white font-black text-sm">L</span>
                </div>
                <span class="font-black text-white text-lg tracking-tight">LPK-MI</span>
            </div>
        </div>

        <h1 class="text-center font-black text-white text-lg mb-1">Pilih Akun</h1>
        <p class="text-center text-xs text-slate-400 mb-6">untuk melanjutkan ke <strong class="text-blue-400">lpk-mi.com</strong></p>

        <!-- Errors -->
        @if ($errors->any())
            <div class="mb-4 p-3 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-xl text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <p>⚠ {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Accounts List -->
        <div class="space-y-2 max-h-72 overflow-y-auto pr-1">
            @forelse($admins as $admin)
                @php
                    $roleConfig = [
                        'superadmin' => ['bg' => 'bg-indigo-500/10', 'text' => 'text-indigo-400', 'border' => 'border-indigo-500/20', 'dot' => 'bg-indigo-500'],
                        'admin'      => ['bg' => 'bg-blue-500/10',   'text' => 'text-blue-400',   'border' => 'border-blue-500/20',   'dot' => 'bg-blue-500'],
                        'asesor'     => ['bg' => 'bg-emerald-500/10','text' => 'text-emerald-400','border' => 'border-emerald-500/20','dot' => 'bg-emerald-500'],
                        'asesi'      => ['bg' => 'bg-violet-500/10', 'text' => 'text-violet-400', 'border' => 'border-violet-500/20', 'dot' => 'bg-violet-500'],
                    ];
                    $rc = $roleConfig[$admin->role] ?? ['bg'=>'bg-slate-500/10','text'=>'text-slate-400','border'=>'border-slate-500/20','dot'=>'bg-slate-500'];
                @endphp
                <form action="{{ route('auth.mock-google-callback') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ $admin->email }}">
                    <button type="submit" class="w-full text-left p-3 rounded-xl hover:bg-slate-800 border border-slate-800 flex items-center gap-3 transition-all group">
                        <!-- Avatar -->
                        <div class="w-9 h-9 rounded-full {{ $rc['bg'] }} border {{ $rc['border'] }} flex items-center justify-center {{ $rc['text'] }} font-black text-sm shrink-0 group-hover:scale-105 transition-transform">
                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-0.5">
                                <span class="text-xs font-bold text-white truncate">{{ $admin->name }}</span>
                                <span class="shrink-0 text-[9px] font-black uppercase px-1.5 py-0.5 rounded {{ $rc['bg'] }} {{ $rc['text'] }} border {{ $rc['border'] }}">
                                    {{ $admin->role }}
                                </span>
                            </div>
                            <span class="block text-[10px] text-slate-500 truncate">{{ $admin->email }}</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-600 group-hover:text-slate-400 transition-colors shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </form>
            @empty
                <div class="text-center py-8 text-slate-500 text-xs">
                    Tidak ada akun terdaftar di database.
                </div>
            @endforelse
        </div>

        <div class="mt-6 pt-5 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-500">
            <span>Mock SSO — Development Only</span>
            <a href="{{ route('home') }}" class="text-blue-400 font-semibold hover:underline">Kembali</a>
        </div>
    </div>
</body>
</html>
