<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DividendoModel extends Model
{
  use SoftDeletes;

  protected $table = 'dividends';

  protected $fillable = ['asset_id', 'valor', 'data'];

  public function ativo()
  {
    return $this->belongsTo(AtivoModel::class, 'asset_id');
  }
}