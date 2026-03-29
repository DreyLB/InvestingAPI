<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RendimentoModel extends Model
{
  use SoftDeletes;

  protected $table = 'incomes';

  protected $fillable = [
    'wallet_id',
    'rendimento',
    'valor',
    'periodo_ini',
    'periodo_fim',
  ];

  public function carteira()
  {
    return $this->belongsTo(CarteiraModel::class, 'wallet_id');
  }
}
