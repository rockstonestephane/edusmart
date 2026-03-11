@extends('admin.layouts.admin')
@section('title', 'Images Hero des pages')
@section('breadcrumb', 'Images Hero')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Images Hero des pages</h1>
    <p class="text-sm text-gray-500 mt-1">
        Gérez les images de fond des sections hero pour chaque page du site
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    @foreach($heroes as $page => $data)
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">

        {{-- Aperçu image --}}
        <div class="relative h-48 overflow-hidden">
            @if($data['hero']->image)
                <img src="{{ $data['hero']->image }}"
                     alt="Hero {{ $page }}"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0"
                     style="background:rgba(13,18,36,0.5)"></div>
            @else
                <div class="w-full h-full flex items-center justify-center"
                     style="background:linear-gradient(135deg,#0d1224 0%,#192686 60%,#0d1224 100%)">
                </div>
            @endif

            {{-- Label page --}}
            <div class="absolute top-4 left-4">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-bold
                             text-white" style="background:rgba(41,82,245,0.8);backdrop-filter:blur(8px)">
                    {{ $data['label'] }}
                </span>
            </div>

            {{-- Badge image présente --}}
            <div class="absolute top-4 right-4">
                @if($data['hero']->image)
                    <span class="badge badge-green">✅ Image définie</span>
                @else
                    <span class="badge badge-gray">🎨 Dégradé par défaut</span>
                @endif
            </div>
        </div>

        {{-- Formulaire upload --}}
        <div class="p-5">
            <form method="POST"
                  action="{{ route('admin.page-heroes.update', $page) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $data['hero']->image ? 'Changer l\'image' : 'Ajouter une image' }}
                    </label>
                    <input type="file" name="image" accept="image/*" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — max 4Mo</p>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="btn-primary flex-1 justify-center">
                        🖼️ {{ $data['hero']->image ? 'Remplacer' : 'Uploader' }}
                    </button>

                    @if($data['hero']->image)
                    <form method="POST"
                          action="{{ route('admin.page-heroes.destroy', $page) }}"
                          onsubmit="return confirm('Supprimer cette image hero ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">🗑️</button>
                    </form>
                    @endif
                </div>
            </form>
        </div>

    </div>
    @endforeach

</div>

@endsection