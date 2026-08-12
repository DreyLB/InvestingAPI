<?php
// app/Infrastructure/Persistence/Models/CotacaoModel.php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CotacaoModel extends Model
{
  use SoftDeletes;

  protected $table = 'cotacoes';

  protected $fillable = ['asset_id', 'valor', 'atualizado_em'];

  protected $casts = [
    'valor' => 'float',
    'atualizado_em' => 'datetime',
  ];

  public function asset()
  {
    return $this->belongsTo(AtivoModel::class, 'asset_id');
  }
}
