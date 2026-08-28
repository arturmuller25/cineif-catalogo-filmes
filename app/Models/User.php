<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Um usuário pode cadastrar muitos filmes (hasMany).
     */
    public function filmes(): HasMany
    {
        return $this->hasMany(Filme::class, 'usuario_id');
    }

    /**
     * O último filme cadastrado pelo usuário (hasOne + latestOfMany).
     */
    public function ultimoFilme(): HasOne
    {
        return $this->hasOne(Filme::class, 'usuario_id')->latestOfMany();
    }

    /**
     * Um usuario pode fazer muitas avaliacoes (hasMany).
     */
    public function avaliacoes(): HasMany
    {
        return $this->hasMany(Avaliacao::class, 'usuario_id');
    }
}
