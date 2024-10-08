<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'colonia',
        'calle',
        'numero',
        'responsable',
        'telefono',
        'latitude',
        'longitude',
    ];
}
