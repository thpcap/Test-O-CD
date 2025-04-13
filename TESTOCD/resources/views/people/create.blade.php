@extends('Template')

@section('title', 'Créer une nouvelle personne')

@section('content')
    <div class="container">
        <h1>Créer une nouvelle personne</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('people.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="first_name" class="form-label">Prénom</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" required>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Nom</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" required>
            </div>

            <div class="mb-3">
                <label for="birth_name" class="form-label">Nom de naissance</label>
                <input type="text" name="birth_name" id="birth_name" class="form-control" value="{{ old('birth_name') }}">
            </div>

            <div class="mb-3">
                <label for="middle_names" class="form-label">Noms intermédiaires</label>
                <input type="text" name="middle_names" id="middle_names" class="form-control" value="{{ old('middle_names') }}">
            </div>

            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Date de naissance</label>
                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
            </div>

            <button type="submit" class="btn btn-primary">Créer</button>
            <a href="{{ route('people.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection
