<?php
  
namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlertaModel extends Model
{
  use SoftDeletes;

  protected $table = 'alerts';

  protected $fillable = [
    'wallet_id',
    'tipo',
    'mensagem',
    'data',
    'lido',
  ];

  protected $casts = [
    'lido' => 'boolean',
  ];

  public function carteira()
  {
    return $this->belongsTo(CarteiraModel::class, 'wallet_id');
  }
}