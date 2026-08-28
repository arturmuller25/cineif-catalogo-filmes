<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avaliacao extends Model
{
    protected $table = 'avaliacoes';

    protected $fillable = [
        'filme_id',
        'usuario_id',
        'nota',
        'comentario',
    ];

    protected $casts = [
        'nota' => 'integer',
    ];

    /**
     * A avaliacao pertence a um filme (belongsTo).
     */
    public function filme(): BelongsTo
    {
        return $this->belongsTo(Filme::class, 'filme_id');
    }

    /**
     * A avaliacao pertence ao usuario que a fez (belongsTo).
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
