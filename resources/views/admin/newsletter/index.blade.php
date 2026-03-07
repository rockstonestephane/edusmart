@extends('admin.layouts.admin')

@section('title', 'Newsletter — Abonnés')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">📬 Abonnés Newsletter</h1>
    <span class="badge bg-primary fs-6">{{ $subscribers->total() }} abonnés</span>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Statut</th>
                    <th>Date d'inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $subscriber)
                <tr>
                    <td>{{ $subscriber->id }}</td>
                    <td>{{ $subscriber->email }}</td>
                    <td>
                        @if($subscriber->actif)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-secondary">Inactif</span>
                        @endif
                    </td>
                    <td>{{ $subscriber->created_at->format('d/m/Y H:i') }}</td>
                    <td class="d-flex gap-2">
                        {{-- Toggle actif --}}
                        <form action="{{ route('admin.newsletter.toggle', $subscriber) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm {{ $subscriber->actif ? 'btn-warning' : 'btn-success' }}">
                                {{ $subscriber->actif ? 'Désactiver' : 'Activer' }}
                            </button>
                        </form>

                        {{-- Supprimer --}}
                        <form action="{{ route('admin.newsletter.destroy', $subscriber) }}" method="POST"
                            onsubmit="return confirm('Supprimer cet abonné ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Aucun abonné pour le moment.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $subscribers->links() }}
</div>
@endsection