@extends('Template')

@section('title', 'Degré de parenté')

@section('content')
    <div class="container">
        <h1>Degré de parenté</h1>

        @if ($degree !== false)
            <p><strong>Degré de parenté :</strong> {{ $degree }}</p>
            <p><strong>Chemin :</strong> {{ $path_people->pluck('id')->implode(' -> ') }}</p>

            <h2>Détails des personnes dans le chemin</h2>
            <ul>
                @foreach ($path_people as $person)
                    <li>
                        <strong>ID :</strong> {{ $person->id }},
                        <strong>Nom :</strong> {{ $person->first_name }} {{ $person->last_name }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucune connexion trouvée ou degré supérieur à 25.</p>
        @endif

        <p><strong>Temps d'exécution :</strong> {{ $execution_time }} secondes</p>
        <p><strong>Nombre de requêtes SQL :</strong> {{ $query_count }}</p>

        <a href="{{ route('people.index') }}" class="btn btn-secondary">Retour à la liste</a>
    </div>
@endsection
