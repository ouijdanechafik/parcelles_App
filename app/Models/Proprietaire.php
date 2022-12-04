<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Parcelle;
use App\Models\Photos_identite;

class Proprietaire extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Get the parcelles for the Proprietaire.
     */
    public function parcelles()
    {
        return $this->hasMany(Parcelle::class);
    }

    /**
     * Get the photos for the Proprietaire.
     */
    public function photos_identite()
    {
        return $this->hasMany(Photos_identite::class);
    }
}
