<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;


class TransacaoModel extends Model
{
  protected $table = 'transacao';

  protected $fillable = [
    'tipo',
    'quantidade',
    'valor',
    'data'
  ];
}
