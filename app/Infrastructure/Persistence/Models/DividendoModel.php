<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;


class DividendoModel extends Model
{
  protected $table = 'ativo';

  protected $fillable = [
    'periodoInicial',
    'valor',
  ];
}
