<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PositionModel extends Model
{
  use SoftDeletes;

  protected $table = 'positions';
  protected $fillable = ['wallet_id', 'asset_id', 'quantidade', 'preco_medio', 'valor_total'];

  public function carteira()
  {
    return $this->belongsTo(CarteiraModel::class, 'wallet_id');
  }

  public function asset()
  {
    return $this->belongsTo(AtivoModel::class, 'asset_id');
  }
}
