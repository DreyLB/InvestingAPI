<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetaModel extends Model
{
  use SoftDeletes;

  protected $table = 'goals';

  protected $fillable = [
    'wallet_id',
    'nome',
    'descricao',
    'valor',
    'data_limite',
  ];

  public function carteira()
  {
    return $this->belongsTo(CarteiraModel::class, 'wallet_id');
  }
}
