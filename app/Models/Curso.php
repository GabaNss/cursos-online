<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'carga_horaria',
        'nivel',
        'preco',
        'imagem',
        'status',
    ];

    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class);
    }
}
