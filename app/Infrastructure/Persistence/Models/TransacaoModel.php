<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransacaoModel extends Model
{
  use SoftDeletes;

  protected $table = 'transactions';

  protected $fillable = [
    'asset_id',
    'tipo',
    'quantidade',
    'valor',
    'data',
  ];

  public function ativo()
  {
    return $this->belongsTo(AtivoModel::class, 'asset_id');
  }
}
