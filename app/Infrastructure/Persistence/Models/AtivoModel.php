<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AtivoModel extends Model
{
  use SoftDeletes;

  protected $table = 'assets';

  protected $fillable = [
    'wallet_id',
    'category_id',
    'asset_type_id',
    'name',
    'quantity',
    'price',
    'average_price',
  ];

  protected $dates = ['deleted_at'];

  public function carteira(): BelongsTo
  {
    // ajuste o namespace/model abaixo conforme seu projeto
    return $this->belongsTo(CarteiraModel::class, 'wallet_id');
  }

  public function categoria(): BelongsTo
  {
    return $this->belongsTo(CategoriaModel::class, 'category_id');
  }

  /* public function tipo(): BelongsTo
  {
    return $this->belongsTo(AssetTypeModel::class, 'asset_type_id');
  } */
}
