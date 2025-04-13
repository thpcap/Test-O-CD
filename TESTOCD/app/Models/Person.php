<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
