<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static when($q, \Closure $param)
 */
class NoticeBoard extends Model
{
  use HasFactory;

  protected $fillable = [
    'message', 'author_id',
  ];
}
