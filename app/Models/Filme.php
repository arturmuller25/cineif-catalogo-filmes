<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filme extends Model
{
    use SoftDeletes;

    protected $table = 'filmes';

    protected $fillable = [
        'usuario_id',
        'categoria_id',
        'titulo',
        'sinopse',
        'ano',
        'imagem_capa',
        'trailer_url',
    ];

    protected $casts = [
        'ano' => 'integer',
    ];

    /**
     * O filme pertence ao usuário que o cadastrou (belongsTo).
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * O filme pertence a uma categoria (belongsTo).
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Um filme possui muitas avaliacoes (hasMany).
     */
    public function avaliacoes(): HasMany
    {
        return $this->hasMany(Avaliacao::class, 'filme_id');
    }

    /**
     * Usuarios que favoritaram este filme (belongsToMany).
     */
    public function favoritadoPor(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favoritos', 'filme_id', 'user_id')->withTimestamps();
    }

    /**
     * URL da capa. Aceita tanto upload local (storage) quanto URL externa.
     * Retorna null quando não há imagem cadastrada.
     */
    public function capaUrl(): ?string
    {
        if (! $this->imagem_capa) {
            return null;
        }

        if (str_starts_with($this->imagem_capa, 'http')) {
            return $this->imagem_capa;
        }

        // Posteres inclusos no projeto ficam em public/posters.
        if (str_starts_with($this->imagem_capa, 'posters/')) {
            return asset($this->imagem_capa);
        }

        return asset('storage/' . $this->imagem_capa);
    }

    /**
     * Extrai o ID do vídeo a partir de qualquer formato de URL do YouTube
     * (watch?v=, youtu.be/, embed/, shorts/).
     */
    public function youtubeId(): ?string
    {
        if (! $this->trailer_url) {
            return null;
        }

        $padrao = '~(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|v/)|youtu\.be/)([A-Za-z0-9_-]{11})~';

        return preg_match($padrao, $this->trailer_url, $m) ? $m[1] : null;
    }

    /**
     * URL pronta para embed do trailer no player do YouTube
     * (ou null quando o embed não é possível).
     */
    public function embedUrl(): ?string
    {
        $id = $this->youtubeId();

        return $id ? "https://www.youtube.com/embed/{$id}" : null;
    }

    /**
     * Cor determinística usada na capa "placeholder" quando não há imagem,
     * garantindo um visual coerente sem depender de recursos externos.
     */
    public function corPlaceholder(): string
    {
        $cores = ['#7c3aed', '#db2777', '#2563eb', '#059669', '#d97706', '#dc2626', '#0891b2', '#4f46e5'];

        return $cores[abs(crc32($this->titulo)) % count($cores)];
    }
}
