<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Infrastructure\Persistence\Models\CarteiraModel;


class UserModel extends Authenticatable implements JWTSubject
{
    //HasFactory: permite usar UserModel::factory() para gerar dados fake em testes ou seeders.
    //Notifiable: permite que o usuário receba notificações via e-mail, SMS, etc. ($user->notify(...)).
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'balance',
        'age',
        'investorProfile'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function carteiras(): HasMany
    {
        return $this->hasMany(CarteiraModel::class, 'user_id');
    }
}
