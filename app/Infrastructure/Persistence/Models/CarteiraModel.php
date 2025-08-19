<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CarteiraModel extends Model
{
  use SoftDeletes;
  protected $table = 'wallets';

  protected $fillable = [
    'user_id',
    'nome',
    'descricao',
  ];
}
