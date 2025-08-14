<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;


class AlertaModel extends Model
{
  protected $table = 'ativo';

  protected $fillable = [
    'tipo',
    'mensagem',
    'data',
  ];
}
