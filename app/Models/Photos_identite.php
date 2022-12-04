<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Proprietaire;

class Photos_identite extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function proprietaire()
    {
        return $this->belongsTo(Proprietaire::class);
    }
}
