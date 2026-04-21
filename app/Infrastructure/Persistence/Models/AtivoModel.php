<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AtivoModel extends Model
{
  use SoftDeletes;

  protected $table = 'assets';
  protected $fillable = ['ticker', 'name', 'asset_type_id', 'category_id'];

  public function assetType()
  {
    return $this->belongsTo(AssetTypeModel::class, 'asset_type_id');
  }

  public function category()
  {
    return $this->belongsTo(CategoriaModel::class, 'category_id');
  }

  public function positions()
  {
    return $this->hasMany(PositionModel::class, 'asset_id');
  }

  public function transactions()
  {
    return $this->hasMany(TransacaoModel::class, 'asset_id');
  }
}
