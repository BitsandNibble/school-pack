<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
