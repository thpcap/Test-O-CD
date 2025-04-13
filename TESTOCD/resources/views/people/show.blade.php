@extends('Template')

@section('title', 'Détails de la personne')

@section('content')
    <div class="container">
        <h1>Détails de la personne</h1>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">{{ $person->first_name }} {{ $person->last_name }}</h5>
                <p><strong>Nom de naissance :</strong> {{ $person->birth_name ?? 'N/A' }}</p>
                <p><strong>Noms intermédiaires :</strong> {{ $person->middle_names ?? 'N/A' }}</p>
                <p><strong>Date de naissance :</strong> {{ $person->date_of_birth ?? 'N/A' }}</p>
                <p><strong>Créé par :</strong> {{ $person->creator->name ?? 'Inconnu' }}</p>
            </div>
        </div>

        <h2>Parents</h2>
        @if ($person->parents->isEmpty())
            <p>Aucun parent trouvé.</p>
        @else
            <ul>
                @foreach ($person->parents as $parent)
                    <li>{{ $parent->first_name }} {{ $parent->last_name }}</li>
                @endforeach
            </ul>
        @endif

        <h2>Enfants</h2>
        @if ($person->children->isEmpty())
            <p>Aucun enfant trouvé.</p>
        @else
            <ul>
                @foreach ($person->children as $child)
                    <li>{{ $child->first_name }} {{ $child->last_name }}</li>
                @endforeach
            </ul>
        @endif

        <a href="{{ route('people.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
    </div>
@endsection
