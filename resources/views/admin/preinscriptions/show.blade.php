@extends('admin.layouts.admin')
@section('title', 'Détail préinscription')
@section('breadcrumb', 'Préinscriptions → Détail')

@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.preinscriptions.index') }}" class="btn-outline">← Retour</a>
    <h1 class="text-2xl font-bold text-gray-800">
        Préinscription — {{ $preinscription->prenom }} {{ $preinscription->nom }}
    </h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Infos principales --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Élève --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
                🎓 Informations de l'élève
            </h3>
            <div class="grid grid-cols-2 gap-4">
                @foreach([
                    ['Nom',               $preinscription->nom],
                    ['Prénom',            $preinscription->prenom],
                    ['Date de naissance', $preinscription->date_naissance?->format('d/m/Y')],
                    ['Sexe',              ucfirst($preinscription->sexe ?? '—')],
                    ['Classe demandée',   $preinscription->classe_demandee],
                    ['Année scolaire',    $preinscription->annee_scolaire],
                ] as [$label, $value])
                <div class="p-3 bg-gray-50 rounded-xl">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">
                        {{ $label }}
                    </div>
                    <div class="text-sm font-medium text-gray-800">{{ $value ?? '—' }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Parent --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
                👨‍👩‍👧 Informations du parent / tuteur
            </h3>
            <div class="grid grid-cols-2 gap-4">
                @foreach([
                    ['Nom du parent', $preinscription->nom_parent],
                    ['Téléphone',     $preinscription->telephone_parent],
                    ['Email',         $preinscription->email_parent],
                    ['Adresse',       $preinscription->adresse],
                ] as [$label, $value])
                <div class="p-3 bg-gray-50 rounded-xl">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">
                        {{ $label }}
                    </div>
                    <div class="text-sm font-medium text-gray-800">{{ $value ?? '—' }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Message --}}
        @if($preinscription->message)
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 class="font-bold text-gray-700 mb-3">💬 Message</h3>
            <p class="text-sm text-gray-600 leading-relaxed bg-gray-50 p-4 rounded-xl">
                {{ $preinscription->message }}
            </p>
        </div>
        @endif

        {{-- Documents --}}
        @if($preinscription->acte_naissance || $preinscription->bulletin)
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 class="font-bold text-gray-700 mb-4">📎 Documents fournis</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- Acte de naissance --}}
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">
                        Acte de naissance
                    </div>
                    @if($preinscription->acte_naissance)
                        @php $ext = pathinfo($preinscription->acte_naissance, PATHINFO_EXTENSION); @endphp
                        @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                        <img src="{{ asset('storage/' . $preinscription->acte_naissance) }}"
                             alt="Acte de naissance"
                             class="w-full h-32 object-cover rounded-lg mb-3">
                        @else
                        <div class="flex items-center justify-center h-16 bg-red-50 rounded-lg mb-3">
                            <span class="text-3xl">📄</span>
                        </div>
                        @endif
                        <a href="{{ asset('storage/' . $preinscription->acte_naissance) }}"
                           target="_blank"
                           class="btn-edit w-full justify-center text-center block">
                            👁️ Voir / Télécharger
                        </a>
                    @else
                        <div class="flex items-center justify-center h-16 bg-gray-100 rounded-lg">
                            <span class="text-sm text-gray-400">Non fourni</span>
                        </div>
                    @endif
                </div>

                {{-- Bulletin --}}
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">
                        Bulletin / Relevé de notes
                    </div>
                    @if($preinscription->bulletin)
                        @php $ext = pathinfo($preinscription->bulletin, PATHINFO_EXTENSION); @endphp
                        @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                        <img src="{{ asset('storage/' . $preinscription->bulletin) }}"
                             alt="Bulletin"
                             class="w-full h-32 object-cover rounded-lg mb-3">
                        @else
                        <div class="flex items-center justify-center h-16 bg-blue-50 rounded-lg mb-3">
                            <span class="text-3xl">📋</span>
                        </div>
                        @endif
                        <a href="{{ asset('storage/' . $preinscription->bulletin) }}"
                           target="_blank"
                           class="btn-edit w-full justify-center text-center block">
                            👁️ Voir / Télécharger
                        </a>
                    @else
                        <div class="flex items-center justify-center h-16 bg-gray-100 rounded-lg">
                            <span class="text-sm text-gray-400">Non fourni</span>
                        </div>
                    @endif
                </div>

            </div>
        </div>
        @endif

    </div>

    {{-- Sidebar statut --}}
    <div class="space-y-5">

        {{-- Statut actuel --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 class="font-bold text-gray-700 mb-4">Statut de la demande</h3>

            @php
                $statutClass = match($preinscription->statut) {
                    'validee'  => 'badge-green',
                    'refusee'  => 'badge-red',
                    'en_cours' => 'badge-blue',
                    default    => 'badge-yellow',
                };
            @endphp
            <div class="text-center mb-4 p-4 bg-gray-50 rounded-xl">
                <span class="badge {{ $statutClass }} text-sm px-4 py-1.5">
                    {{ \App\Models\Preinscription::STATUTS[$preinscription->statut] ?? $preinscription->statut }}
                </span>
            </div>

            {{-- Changer le statut --}}
            <form method="POST"
                  action="{{ route('admin.preinscriptions.statut', $preinscription->id) }}">
                @csrf
                <label class="form-label">Changer le statut</label>
                <select name="statut" class="form-select mb-3">
                    @foreach(\App\Models\Preinscription::STATUTS as $val => $label)
                    <option value="{{ $val }}"
                            {{ $preinscription->statut == $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary w-full justify-center">
                    ✅ Mettre à jour
                </button>
            </form>
        </div>

        {{-- Méta --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 class="font-bold text-gray-700 mb-3">Informations</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-400">Reçue le</span>
                    <span class="font-medium">{{ $preinscription->created_at->format('d/m/Y à H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Modifiée le</span>
                    <span class="font-medium">{{ $preinscription->updated_at->format('d/m/Y à H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- Supprimer --}}
        <form method="POST"
              action="{{ route('admin.preinscriptions.destroy', $preinscription->id) }}"
              onsubmit="return confirm('Supprimer définitivement cette préinscription ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger w-full justify-center py-3">
                🗑️ Supprimer cette préinscription
            </button>
        </form>

    </div>
</div>

@endsection