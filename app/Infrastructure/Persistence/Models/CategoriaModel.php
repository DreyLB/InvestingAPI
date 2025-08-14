<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;


class CategoriaModel extends Model
{
  protected $table = 'ativo';

  protected $fillable = [
    'nome',
    'descricao',
  ];
}
