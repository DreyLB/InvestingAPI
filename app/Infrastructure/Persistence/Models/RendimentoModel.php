<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;


class RendimentoModel extends Model
{
  protected $table = 'performance';

  protected $fillable = [
    'tipo',
    'periodoInicial',
    'periodoFinal'
  ];
}
