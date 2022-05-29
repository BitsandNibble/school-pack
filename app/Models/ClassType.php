<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static get()
 * @method static find($get_class_id)
 * @method static pluck(string $string)
 */
class ClassType extends Model
{
    use HasFactory;

    public $timestamps = false;
}
