<?php
// app/Infrastructure/Persistence/Models/IndicadorMercadoModel.php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndicadorMercadoModel extends Model
{
  use SoftDeletes;

  protected $table = 'indicadores_mercado';

  protected $fillable = ['chave', 'nome', 'valor', 'atualizado_em'];

  protected $casts = [
    'valor' => 'float',
    'atualizado_em' => 'datetime',
  ];
}
