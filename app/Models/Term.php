<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find($id)
 * @method static where(string $string, $id)
 * @method static create(array $array)
 * @method static get()
 */
class Term extends Model
{
  use HasFactory;

  protected $fillable = [
    'name', 'session', 'locked'
  ];
}