<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetTypeModel extends Model
{
    use SoftDeletes;

    protected $table = 'asset_types';

    protected $fillable = [
        'nome',
        'descricao',
    ];
}
