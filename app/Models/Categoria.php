<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nome',
    ];

    /**
     * Uma categoria possui muitos filmes (hasMany).
     * Permite o join automático: $categoria->filmes.
     */
    public function filmes(): HasMany
    {
        return $this->hasMany(Filme::class, 'categoria_id');
    }
}
