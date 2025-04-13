@extends('Template')

@section('title', 'Liste des personnes')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="container">
        <h1>Liste des personnes</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div>
            <a href="{{ route('people.create') }}" class="btn btn-primary mb-3">Créer une nouvelle personne</a>
        </div>
        <table id="peopleTable" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Créé par</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($people as $person)
                    <tr>
                        <td>{{ $person->id }}</td>
                        <td>{{ $person->first_name }}</td>
                        <td>{{ $person->last_name }}</td>
                        <td>{{ $person->creator->name ?? 'Inconnu' }}</td>
                        <td>
                            <a href="{{ route('people.show', $person->id) }}" class="btn btn-info">Voir</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#peopleTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
                }
            });
        });
    </script>
@endsection
