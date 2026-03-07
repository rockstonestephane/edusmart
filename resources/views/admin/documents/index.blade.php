@extends('admin.layouts.admin')
@section('title', 'Documents téléchargeables')
@section('breadcrumb', 'Documents')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Documents téléchargeables</h1>
        <p class="text-sm text-gray-500 mt-1">Gérez les documents disponibles au téléchargement sur le site.</p>
    </div>
    <button onclick="document.getElementById('modal-add').classList.remove('hidden')"
            class="btn-primary flex items-center gap-2">
        ➕ Ajouter un document
    </button>
</div>

{{-- Liste --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-6 py-3 text-gray-500 font-semibold">Document</th>
                <th class="text-left px-6 py-3 text-gray-500 font-semibold">Catégorie</th>
                <th class="text-left px-6 py-3 text-gray-500 font-semibold">Type / Taille</th>
                <th class="text-left px-6 py-3 text-gray-500 font-semibold">Statut</th>
                <th class="text-left px-6 py-3 text-gray-500 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($documents as $doc)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">{{ $doc->icone }}</span>
                        <div>
                            <div class="font-semibold text-gray-800">{{ $doc->nom }}</div>
                            @if($doc->description)
                            <div class="text-xs text-gray-400">{{ $doc->description }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-600">
                        {{ ucfirst($doc->categorie) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-500">
                    {{ strtoupper($doc->type_fichier) }} · {{ $doc->taille_formattee }}
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded-lg text-xs font-semibold {{ $doc->actif ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                        {{ $doc->actif ? 'Visible' : 'Masqué' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ $doc->url }}" target="_blank"
                           class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200">
                            👁 Voir
                        </a>
                        <form method="POST" action="{{ route('admin.documents.destroy', $doc) }}"
                              onsubmit="return confirm('Supprimer ce document ?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-50 text-red-500 hover:bg-red-100">
                                🗑 Supprimer
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                    Aucun document pour l'instant. Ajoutez-en un !
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal Ajout --}}
<div id="modal-add" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-lg mx-4 shadow-2xl">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-bold text-gray-800 text-lg">Ajouter un document</h3>
            <button onclick="document.getElementById('modal-add').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 text-xl">✕</button>
        </div>
        <form method="POST" action="{{ route('admin.documents.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="form-label">Nom du document <span class="text-red-500">*</span></label>
                    <input type="text" name="nom" class="form-input" placeholder="Ex: Grille tarifaire 2025-2026" required>
                </div>
                <div>
                    <label class="form-label">Description</label>
                    <input type="text" name="description" class="form-input" placeholder="Courte description...">
                </div>
                <div>
                    <label class="form-label">Catégorie <span class="text-red-500">*</span></label>
                    <select name="categorie" class="form-input" required>
                        <option value="tarifs">💰 Tarifs & Scolarité</option>
                        <option value="inscription">✏️ Inscription & Préinscription</option>
                        <option value="formulaires">📋 Formulaires</option>
                        <option value="general">📁 Général</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Fichier <span class="text-red-500">*</span></label>
                    <input type="file" name="fichier" class="form-input" accept=".pdf,.doc,.docx,.xlsx,.xls" required>
                    <p class="text-xs text-gray-400 mt-1">PDF, Word, Excel — max 10 Mo</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Ordre d'affichage</label>
                        <input type="number" name="ordre" class="form-input" value="0" min="0">
                    </div>
                    <div class="flex items-center gap-2 mt-6">
                        <input type="checkbox" name="actif" value="1" checked id="actif-check" class="w-4 h-4">
                        <label for="actif-check" class="text-sm text-gray-600">Visible sur le site</label>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary flex-1 justify-center">💾 Enregistrer</button>
                <button type="button"
                        onclick="document.getElementById('modal-add').classList.add('hidden')"
                        class="flex-1 px-4 py-2 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>

@endsection