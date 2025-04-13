<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Person extends Model
{
    use HasFactory;

    /**
     * Les attributs assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_name',
        'middle_names',
        'date_of_birth',
        'created_by',
    ];

    /**
     * Les relations Eloquent.
     */

    // Une personne peut avoir plusieurs enfants
    public function children()
    {
        return $this->belongsToMany(Person::class, 'relationships', 'parent_id', 'child_id');
    }

    // Une personne peut avoir plusieurs parents
    public function parents()
    {
        return $this->belongsToMany(Person::class, 'relationships', 'child_id', 'parent_id');
    }

    // Une personne a un utilisateur-créateur
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getDegreeWith($target_person_id)
    {
        // Charger toutes les relations en une seule requête
        $relations = DB::table('relationships')
            ->select('parent_id', 'child_id')
            ->get()
            ->flatMap(function ($relation) {
                return [
                    [$relation->parent_id, $relation->child_id],
                    [$relation->child_id, $relation->parent_id],
                ];
            })
            ->groupBy(0)
            ->map(function ($items) {
                return collect($items)->pluck(1)->toArray();
            })
            ->toArray();

        // Initialisation
        $visited = [];
        $queue = [];
        $queue[] = ['person_id' => $this->id, 'degree' => 0, 'path' => [$this->id]];
        $visited[$this->id] = true;

        while (!empty($queue)) {
            $current = array_shift($queue);

            $current_person_id = $current['person_id'];
            $current_degree = $current['degree'];
            $current_path = $current['path'];

            // Si le degré dépasse 25, arrêter la recherche
            if ($current_degree > 25) {
                return false;
            }

            // Si la personne cible est trouvée, retourner le degré et le chemin
            if ($current_person_id == $target_person_id) {
                return [
                    'degree' => $current_degree,
                    'path' => $current_path,
                ];
            }

            // Récupérer les relations depuis le tableau chargé
            $related_person_ids = $relations[$current_person_id] ?? [];

            foreach ($related_person_ids as $related_person_id) {
                if (!isset($visited[$related_person_id])) {
                    $visited[$related_person_id] = true;
                    $queue[] = [
                        'person_id' => $related_person_id,
                        'degree' => $current_degree + 1,
                        'path' => array_merge($current_path, [$related_person_id]),
                    ];
                }
            }
        }

        // Si aucune connexion n'est trouvée
        return false;
    }

    public function fetchRelations($person_id)
    {
        $query = "
            SELECT DISTINCT related_id
            FROM (
                SELECT parent_id AS related_id FROM relationships WHERE child_id = ?
                UNION
                SELECT child_id AS related_id FROM relationships WHERE parent_id = ?
            ) AS relations
        ";

        return collect(DB::select($query, [$person_id, $person_id]))->pluck('related_id')->toArray();
    }
}
