# CRUD-LARAVEL-ANTI-CSRF

## Requisitos
- **PHP** 8.2 ou superior
- **Composer**
- **Node.js** 20 ou superior

## Como criar o projeto
No terminal, execute:
```bash
composer create-project laravel/laravel .
```

## Iniciar o servidor
Execute o comando:
```bash
php artisan serve
```

## Configuração de rotas
### Rota para exibir uma view
```php
Route::get('/', [UserController::class, 'index'])->name('user.index');
```
### Rota para criar um recurso
```php
Route::post('/store-user', [UserController::class, 'store'])->name('user-store');
```

## Criando uma Controller
Para criar uma nova controller, utilize:
```bash
php artisan make:controller [nome]
```
### Namespace para controllers
Certifique-se de importar a controller:
```php
use App\Http\Controllers\UserController;
```

## Trabalhando com Models
### Criar um Model
```bash
php artisan make:model [nome]
```

## Trabalhando com Views
### Criar uma View
```bash
php artisan make:view users/index
```
### Renderizar uma View
```php
return view('users.index');
```

## Configurações do Banco de Dados
Atualize o arquivo `.env` conforme necessário:
```env
APP_TIMEZONE=America/Sao_Paulo
APP_URL=http://127.0.0.1:8000/
APP_LOCALE=pt_BR

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
Certifique-se de que `APP_KEY` no `.env` não esteja vazio.

### Executar as migrations
Após configurar o banco, execute:
```bash
php artisan migrate
```

## Links e formulários
### Criar um link para uma rota
```html
<a href="{{ route('user.create') }}">Create</a>
```
### Formulário para envio de dados
```html
<form action="{{ route('user-store') }}" method="POST">
```

## Validações
### Criar uma Request para validação
```bash
php artisan make:request UserRequest
```
### Exemplo de validações
```php
public function rules(): array
{
    return [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6'
    ];
}

public function messages(): array
{
    return [
        'name.required' => 'Campo nome é obrigatório',
        'email.required' => 'Campo e-mail é obrigatório',
        'email.email' => 'O campo deve ser um e-mail válido!',
        'password.required' => 'Campo senha é obrigatório',
        'password.min' => 'Senha deve ter no mínimo :min caracteres!'
    ];
}
```
### Exibir mensagens de erro na View
```html
@if($errors->any())
    @foreach ($errors->all() as $error)
        <p style="color: red">{{ $error }}</p>
    @endforeach
@endif
```

## Trabalhando com dados do banco
### Listar dados do banco
Controller:
```php
$users = User::orderByDesc('id')->get();
return view('users.index', ['users' => $users]);
```
View:
```html
@forelse ($users as $user)
    ID: {{ $user->id }}<br>
    Nome: {{ $user->name }}<br>
    E-mail: {{ $user->email }}<br>
@empty
    <p>Sem registros encontrados.</p>
@endforelse
```
### Obter um registro específico
Rota:
```php
Route::get('/show-user/{user}', [UserController::class, 'show'])->name('user.show');
```

## Exemplo de criação, validação e redirecionamento
Controller:
```php
public function store(UserRequest $request)
{
    $request->validated();

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
    ]);

    return redirect()->route('user.index')->with('success', 'Usuário cadastrado com sucesso!');
}
```
View para exibir mensagem de sucesso:
```html
@if (session('success'))
    <p>{{ session('success') }}</p>
@endif
```

## Formatação de datas
Para formatar datas, use a biblioteca `Carbon`:
```php
{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}
```

## Trabalhando com rotas PUT e DELETE
### Exemplo de rotas
```php
Route::put('/update-user/{user}', [UserController::class, 'update'])->name('user-update');
Route::delete('/destroy-user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
```
### Formulário para deletar um registro
```html
<form method="POST" action="{{ route('user.destroy', ['user' => $user->id]) }}" class="d-inline">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>
</form>
```

## Integrando Bootstrap
### Instalar dependências
```bash
npm install
npm i --save bootstrap @popperjs/core
npm i --save-dev sass
```
### Importar Bootstrap
No arquivo `resources/js/bootstrap.js`:
```js
import 'bootstrap';
```
### Criar arquivo de estilo
No diretório `resources/sass`, crie o arquivo `app.scss`:
```scss
@import 'bootstrap/scss/bootstrap';
```
### Configurar o Vite
No arquivo `vite.config.js`:
```js
input: ['resources/sass/app.scss', 'resources/js/app.js'],
```
### Executar as bibliotecas
```bash
npm run dev
```

## Trabalhando com Layouts e Componentes
### Criar um layout
No diretório `resources/view/layouts`, crie `admin.blade.php`:
```html
<div class="container">
    @yield('content')
</div>
```
### Usar o layout
Na View:
```html
@extends('layouts.admin')
@section('content')
    <!-- Conteúdo -->
@endsection
```
### Criar um componente
```bash
php artisan make:component alert --view
```
Usar o componente na View:
```html
<x-alert />
```

