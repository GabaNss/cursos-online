<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    protected $table = 'inscricoes';

    protected $fillable = [
        'curso_id',
        'aluno',
        'email',
        'data_inscricao',
        'status',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
