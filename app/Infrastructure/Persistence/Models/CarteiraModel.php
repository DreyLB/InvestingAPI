<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;


class CarteiraModel extends Model
{
  protected $table = 'wallets';

  protected $fillable = [
    'user_id',
    'nome',
    'descricao',
  ];
}
