<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Inscricao;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@educursos.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $cursos = [
            ['nome' => 'Desenvolvimento Web Completo', 'nivel' => 'Iniciante',     'preco' => 197.00, 'carga_horaria' => 80,  'status' => 'Ativo'],
            ['nome' => 'Laravel Avançado',             'nivel' => 'Avançado',      'preco' => 297.00, 'carga_horaria' => 60,  'status' => 'Ativo'],
            ['nome' => 'Vue.js do Zero',               'nivel' => 'Intermediário', 'preco' => 147.00, 'carga_horaria' => 40,  'status' => 'Ativo'],
            ['nome' => 'Banco de Dados MySQL',         'nivel' => 'Iniciante',     'preco' => 0.00,   'carga_horaria' => 20,  'status' => 'Em breve'],
        ];

        foreach ($cursos as $dados) {
            Curso::create(array_merge($dados, [
                'descricao' => 'Descrição detalhada do curso. Aprenda tudo sobre o tema de forma prática e objetiva.',
            ]));
        }

        Inscricao::create(['curso_id' => 1, 'aluno' => 'Maria Silva',    'email' => 'maria@email.com',  'data_inscricao' => '2024-01-15', 'status' => 'Confirmada']);
        Inscricao::create(['curso_id' => 1, 'aluno' => 'João Souza',     'email' => 'joao@email.com',   'data_inscricao' => '2024-01-18', 'status' => 'Pendente']);
        Inscricao::create(['curso_id' => 2, 'aluno' => 'Ana Oliveira',   'email' => 'ana@email.com',    'data_inscricao' => '2024-02-01', 'status' => 'Confirmada']);
    }
}
