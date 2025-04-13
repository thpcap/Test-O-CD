<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Afficher la liste des personnes avec le nom de l'utilisateur qui les a créées
    public function index()
    {
        $people = Person::with('creator')->get();
        return view('people.index', compact('people'));
    }

    // Afficher une personne spécifique avec ses enfants et parents
    public function show($id)
    {
        $person = Person::with(['children', 'parents'])->findOrFail($id);
        return view('people.show', compact('person'));
    }

    // Afficher le formulaire de création d'une nouvelle personne
    public function create()
    {
        return view('people.create');
    }

    // Valider les données et insérer une nouvelle personne
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_name' => 'nullable|string|max:255',
            'middle_names' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        $validated['created_by'] = auth()->id(); // Associer l'utilisateur connecté

        Person::create($validated);

        return redirect()->route('people.index')->with('success', 'Personne créée avec succès.');
    }
}
