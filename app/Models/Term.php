<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static find($id)
 * @method static where(string $string, $id)
 * @method static create(array $array)
 * @method static get()
 * @method static firstOrCreate(array $array)
 */
class Term extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'session', 'locked'
    ];
}