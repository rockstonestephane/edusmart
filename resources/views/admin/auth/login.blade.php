<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration — {{ config('school.name', 'EduSmart') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h1, h2 { font-family: 'Playfair Display', serif; }
        .login-bg {
            background: linear-gradient(135deg, #0d1224 0%, #192686 60%, #0d1224 100%);
            min-height: 100vh;
        }
        .card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(20px);
        }
        .input-field {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            color: #fff;
            transition: border-color 0.2s, background 0.2s;
        }
        .input-field:focus {
            outline: none;
            border-color: rgba(41,82,245,0.6);
            background: rgba(255,255,255,0.1);
        }
        .input-field::placeholder { color: rgba(255,255,255,0.3); }
        .btn-login {
            background: linear-gradient(135deg, #f5c842, #e8b014);
            color: #0d1224;
            font-weight: 800;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(245,200,66,0.4);
        }
        .blob {
            position: absolute;
            border-radius: 60% 40% 70% 30%/50% 60% 40% 50%;
            filter: blur(80px);
            opacity: 0.12;
            pointer-events: none;
        }
    </style>
</head>
<body>
<div class="login-bg flex items-center justify-center px-4 relative overflow-hidden">

    {{-- Blobs décoratifs --}}
    <div class="blob w-96 h-96 bg-blue-600 top-0 right-0 absolute"></div>
    <div class="blob w-64 h-64 bg-yellow-400 bottom-0 left-0 absolute"></div>

    <div class="w-full max-w-md relative z-10 py-12">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4"
                 style="background:linear-gradient(135deg,#f5c842,#e8b014);box-shadow:0 8px 32px rgba(245,200,66,0.3)">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                     stroke="#0d1224" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">{{ config('school.name', 'EduSmart') }}</h1>
            <p class="text-sm mt-1" style="color:#f5c842;letter-spacing:0.15em;text-transform:uppercase;font-size:0.7rem;font-weight:600;">
                Espace Administration
            </p>
        </div>

        {{-- Card login --}}
        <div class="card rounded-2xl p-8">

            <h2 class="text-xl text-white font-bold mb-1">Connexion</h2>
            <p class="text-sm text-white/40 mb-6">Accès réservé aux administrateurs</p>

            {{-- Message succès --}}
            @if(session('success'))
            <div class="mb-4 p-3 rounded-xl text-sm font-medium"
                 style="background:rgba(34,197,94,0.15);border:1px solid rgba(34,197,94,0.3);color:#86efac">
                ✅ {{ session('success') }}
            </div>
            @endif

            {{-- Erreur globale --}}
            @if($errors->any())
            <div class="mb-4 p-3 rounded-xl text-sm font-medium"
                 style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);color:#fca5a5">
                ❌ {{ $errors->first() }}
            </div>
            @endif

            {{-- Formulaire --}}
            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-semibold text-white/60 uppercase tracking-wider mb-1.5">
                        Adresse email
                    </label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="admin@edusmart.cm"
                           required
                           autocomplete="email"
                           class="input-field w-full px-4 py-3 rounded-xl text-sm">
                </div>

                {{-- Mot de passe --}}
                <div>
                    <label class="block text-xs font-semibold text-white/60 uppercase tracking-wider mb-1.5">
                        Mot de passe
                    </label>
                    <input type="password"
                           name="password"
                           placeholder="••••••••"
                           required
                           autocomplete="current-password"
                           class="input-field w-full px-4 py-3 rounded-xl text-sm">
                </div>

                {{-- Se souvenir --}}
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                           class="w-4 h-4 rounded accent-yellow-400">
                    <label for="remember" class="text-sm text-white/50 cursor-pointer">
                        Se souvenir de moi
                    </label>
                </div>

                {{-- Bouton --}}
                <button type="submit" class="btn-login w-full py-3 rounded-xl text-sm mt-2">
                    Se connecter →
                </button>

            </form>
        </div>

        {{-- Lien retour site --}}
        <div class="text-center mt-6">
            <a href="{{ route('home', ['locale' => 'fr']) }}"
               class="text-xs text-white/30 hover:text-white/60 transition-colors">
                ← Retour au site public
            </a>
        </div>

    </div>
</div>
</body>
</html>