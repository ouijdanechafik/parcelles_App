<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Parcelle;

class Village extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Get the parcelles for the village.
     */
    public function parcelles()
    {
        return $this->hasMany(Parcelle::class);
    }
}
