<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'base_experience',
        'height',
        'weight',
        'abilities',
        'cries',
        'forms',
        'game_indices',
        'held_items',
        'moves',
        'sprites',
        'stats',
        'types',
    ];

    protected $casts = [
        'abilities' => 'array',
        'cries' => 'array',
        'forms' => 'array',
        'game_indices' => 'array',
        'held_items' => 'array',
        'moves' => 'array',
        'sprites' => 'array',
        'stats' => 'array',
        'types' => 'array',
    ];
}