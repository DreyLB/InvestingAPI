<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class CarteiraModel extends Model
{
  use SoftDeletes;
  use HasFactory;

  protected $table = 'wallets';

  protected $fillable = [
    'user_id',
    'nome',
    'descricao',
  ];

  /**
   * Obtenha o usuário que é dono desta carteira.
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(UserModel::class);
  }

  public function carteiras(): HasMany
  {
    // Certifique-se de que a classe CarteiraModel está sendo importada
    return $this->hasMany(CarteiraModel::class);
  }
}
