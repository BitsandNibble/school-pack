<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static get()
 * @method static where(string $string, int|string $i)
 */
class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'description'
    ];
}
