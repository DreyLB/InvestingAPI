<?php
// app/Infrastructure/Persistence/Models/IndicadorMercadoModel.php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndicadorMercadoModel extends Model
{
  use SoftDeletes;

  protected $table = 'indicadores_mercado';

  protected $fillable = ['chave', 'nome', 'valor', 'variacao_percentual', 'atualizado_em'];

  protected $casts = [
    'valor' => 'float',
    'variacao_percentual' => 'float',
    'atualizado_em' => 'datetime',
  ];
}
