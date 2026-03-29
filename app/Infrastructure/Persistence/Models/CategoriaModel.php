<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaModel extends Model
{
  use SoftDeletes;

  protected $table = 'categories';

  protected $fillable = ['nome', 'descricao'];

  public function ativos()
  {
    return $this->hasMany(AtivoModel::class, 'category_id');
  }
}
