<?php
// app/Infrastructure/Persistence/Models/CotacaoModel.php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class CotacaoModel extends Model
{
  protected $table = 'cotacoes';

  protected $fillable = ['ticker', 'tipo', 'valor', 'atualizado_em'];

  protected $casts = [
    'valor' => 'float',
    'atualizado_em' => 'datetime',
  ];
}
