<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller
{
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
            'date_of_birth' => 'nullable|date|date_format:Y-m-d',
        ]);

        // Formatage des données
        $validated['created_by'] = auth()->id(); // Associer l'utilisateur connecté
        $validated['first_name'] = ucfirst(strtolower($validated['first_name'])); // Première lettre en majuscule
        $validated['last_name'] = strtoupper($validated['last_name']); // Tout en majuscules
        $validated['birth_name'] = strtoupper($validated['birth_name'] ?? $validated['last_name']); // Tout en majuscules ou copie de last_name
        $validated['middle_names'] = $validated['middle_names']
            ? implode(', ', array_map('ucfirst', array_map('strtolower', explode(',', $validated['middle_names']))))
            : null; // Formatage des noms intermédiaires ou NULL
        $validated['date_of_birth'] = $validated['date_of_birth'] ?? null; // NULL si non renseigné

        // Créer la personne
        Person::create($validated);

        return redirect()->route('people.index')->with('success', 'Personne créée avec succès.');
    }

    public function degree($person1_id, $person2_id)
    {
        $person = Person::findOrFail($person1_id);

        DB::enableQueryLog();
        $timestart = microtime(true);
        $result = $person->getDegreeWith($person2_id);
        $time = microtime(true) - $timestart;
        $nbQueries = count(DB::getQueryLog());
        DB::disableQueryLog();

        if ($result !== false) {
            $degree = $result['degree'];
            $path_ids = $result['path'];
            // Récupérer les informations des personnes dans le chemin
            $path_people = Person::whereIn('id', $path_ids)
                ->orderByRaw('FIELD(id, ' . implode(',', $path_ids) . ')')
                ->get();

            // Passer les données à la vue
            return view('people.degree', [
                'degree' => $degree,
                'path_people' => $path_people,
                'execution_time' => $time,
                'query_count' => $nbQueries,
            ]);
        } else {
            return view('people.degree', [
                'degree' => false,
                'execution_time' => $time,
                'query_count' => $nbQueries,
            ]);
        }
    }
}
