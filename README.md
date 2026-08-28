# CineIF

Catálogo de filmes desenvolvido em Laravel para a disciplina de Programação Web. O sistema tem uma área pública (galeria de filmes) e uma área administrativa (cadastro, edição e exclusão de filmes). Como funcionalidade extra, possui um sistema de avaliações no estilo IMDb.

## Tecnologias

- PHP 8.2 ou superior
- Laravel 12 (gerenciado com Composer)
- Banco de dados SQLite (Migrations e Seeders)
- Blade para as views
- Tailwind CSS 4 com Vite
- Autenticação nativa do Laravel
- Localização em português com o pacote lucascudo/laravel-pt-br-localization

## Funcionalidades

### Seção de administração (requer login)

- Inserção de filmes: nome, sinopse, ano, categoria, imagem da capa e link do trailer no YouTube
- Edição de filmes
- Listagem de filmes com opções de editar e excluir
- Cada filme guarda a chave estrangeira do usuário que fez a inserção (coluna usuario_id)
- Painel com estatísticas e o último filme cadastrado pelo usuário (relação hasOne)
- Lixeira com exclusão reversível (soft delete): restaurar ou apagar definitivamente

### Seção de usuário (pública)

- Galeria de filmes em formato de grade
- Filtragem por ano e por categoria, além de busca por título
- Página de detalhes com sinopse e trailer incorporado (embed) do YouTube
- Quando o vídeo não permite embed, é exibido um link para assistir no YouTube

### Extra: avaliações estilo IMDb

- Usuários logados podem dar uma nota de 1 a 5 estrelas e escrever um comentário
- A nota média e a quantidade de avaliações aparecem na galeria e na página do filme
- Cada usuário avalia um filme uma única vez (a nota pode ser atualizada)

## Banco de dados

### Migrations

- create_categorias_table
- create_filmes_table (chaves estrangeiras usuario_id e categoria_id)
- create_avaliacoes_table

### Seeders

- CategoriaSeeder, FilmeSeeder e AvaliacaoSeeder, além dos usuários de demonstração no DatabaseSeeder

### Relacionamentos das Models (hasOne, hasMany, belongsTo)

- Categoria hasMany Filme
- User hasMany Filme e hasOne Filme (ultimoFilme, usando latestOfMany)
- Filme belongsTo User (usuario) e belongsTo Categoria
- Filme hasMany Avaliacao
- User hasMany Avaliacao
- Avaliacao belongsTo Filme e belongsTo User

As junções (joins) são feitas automaticamente com eager loading, por exemplo `Filme::with(['categoria', 'usuario'])`.

## Como executar

Pré-requisitos: PHP 8.2 ou superior, Composer e Node.js.

```bash
# 1. Instalar as dependências PHP
composer install

# 2. Criar o arquivo de ambiente
cp .env.example .env

# 3. Gerar a chave da aplicação
php artisan key:generate

# 4. Criar o arquivo do banco SQLite
touch database/database.sqlite

# 5. Rodar as migrations e os seeders
php artisan migrate:fresh --seed

# 6. Criar o link do storage (para as imagens de capa enviadas)
php artisan storage:link

# 7. Instalar dependências de front-end e compilar os assets
npm install
npm run build

# 8. Iniciar o servidor
php artisan serve
```

Depois acesse http://127.0.0.1:8000

## Conta de demonstração

- E-mail: admin@cineif.test
- Senha: password

Também é possível criar uma conta nova pela tela de cadastro.

## Estrutura principal

- `app/Models`: Filme, Categoria, Avaliacao e User
- `app/Http/Controllers`: GaleriaController, FilmeController, AvaliacaoController, AuthController e PainelController
- `database/migrations` e `database/seeders`
- `resources/views`: galeria, admin, auth, layouts e partials
- `routes/web.php`
