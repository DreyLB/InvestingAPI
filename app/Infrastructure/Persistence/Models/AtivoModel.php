<?php

namespace App\Infrastructure\Persistence\Models;
use Illuminate\Database\Eloquent\Model;


class AtivoModel extends Model
{
     protected $table = 'ativo';

    protected $fillable = [
      'nome', 
      'tipo',
      'valor',
      'precoMedio',
      'quantidade',
    ];

}
