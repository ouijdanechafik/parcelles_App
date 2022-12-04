<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Village;
use App\Models\User;
use App\Models\Proprietaire;


class Parcelle extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function proprietaire()
    {
        return $this->belongsTo(Proprietaire::class);
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
