# Laravel (Create, Read, Update, Delete, Middleware Login, API Route) <img src="https://github.com/user-attachments/assets/e4b7a64d-8302-495b-b44d-93d9d0f4b2a4" width="55" height="35" />  <img src="https://github.com/user-attachments/assets/958dab41-1a1f-4f53-afef-43e2d5a6740c" width="40" height="40" />

## ➡️ Requisitos.
- **PHP** 8.2 ou superior
- **Composer** 2.8.5 ou superior
- **Node.js** 20 ou superior
- **phpMyAdmin** 5.2.1 ou superior


## ➡️ Usando o projeto pela **primeira vez**.
- **[Configurando .env](#%EF%B8%8F-configura%C3%A7%C3%B5es-do-banco-de-dados-regras-migrate) Crie o arquivo .env de .env-example**
- **Execute o comando:**
```shell
php artisan migrate
```
- **Execute o php:**
```shell
php artisan serve
```

## ➡️ Instalando Bootstrap (**Faça na Ordem!**).
* Usando o comando **npm** vamos instalar as dependências.
```shell
npm install
npm i --save bootstrap @popperjs/core
npm i --save-dev sass
```

* Vamos importar o **Bootstrap** no projeto.

**No arquivo** `resources/js/bootstrap.js`:
```js
import 'bootstrap';
```

* Configurando arquivo de estilo **app.scss**
**No diretório** `resources/sass/`, crie o arquivo `app.scss`:
```scss
@import 'bootstrap/scss/bootstrap';
```

* Configurando o **Bootstrap Vite**
**No arquivo** `vite.config.js`:
```js
input: ['resources/sass/app.scss', 'resources/js/app.js'],
```

**Executando a interface do Bootstrap**
```shell
npm run dev
```

- **Acesse: [http://127.0.0.1:8000/](http://127.0.0.1:8000/)**


## ➡️ Criando o Projeto do **zero**.
Crie o projeto usando o composer:
```shell
composer create-project laravel/laravel .
```

## ➡️ Trabalhando com **Rotas**.
- Vamos começar com rotas **web**
* Rota para exibir uma **view**
```php
Route::get('/', [UserController::class, 'index'])->name('user.index');
```

# Explicação do **Namespace das rotas** (**name()**).
* O método **route('user.index') na view** vai acessar a rota com o método **name()**
```php
->name('user.index');
```

* Rota para criar um recurso **(post)**
```php
Route::post('/store-user', [UserController::class, 'store'])->name('user-store');
```

* Obter um registro específico usando **Parâmetros**
```php
Route::get('/show-user/{user}', [UserController::class, 'show'])->name('user.show');
```

* Rotas **PUT** e **DELETE**
```php
Route::put('/update-user/{user}', [UserController::class, 'update'])->name('user-update');
Route::delete('/destroy-user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
```

## ➡️ Criando **arquivos** para o projeto.
* Criando uma **Controller**
```shell
php artisan make:controller [NomeController]
```
* Criando uma **Model**
```shell
php artisan make:model [NomeModel]
```
* Criando uma **Migration**
```shell
php artisan make:migration [nome_da_migration]
```
* Criando um **Seeder**
```shell
php artisan make:seeder [NomeSeeder]
```
* Criando uma **Factory**
```shell
php artisan make:factory [NomeFactory]
```
* Criando um **Middleware**
```shell
php artisan make:middleware [NomeMiddleware]
```
* Criando uma **Request**
```shell
php artisan make:request [NomeRequest]
```
* Criando um **Event**
```shell
php artisan make:event [NomeEvent]
```
* Criando um **Listener**
```shell
php artisan make:listener [NomeListener]
```
* Criando um **Job**
```shell
php artisan make:job [NomeJob]
```
* Criando um **Command**
```shell
php artisan make:command [NomeCommand]
```
* Criando um **Observer**
```shell
php artisan make:observer [NomeObserver] --model=[NomeModel]
```
* Criando um **Policy**
```shell
php artisan make:policy [NomePolicy]
```
* Criando um **Resource**
```shell
php artisan make:resource [NomeResource]
```
* Criando um **Rule**
```shell
php artisan make:rule [NomeRule]
```
* Criando um **Test (Unitário)**
```shell
php artisan make:test [NomeTest]
```
* Criando um **Test (Feature)**
```shell
php artisan make:test [NomeTest] --unit
```

### **Namespace** para Controllers.
* Certifique-se de importar a **Controller**:
```php
use App\Http\Controllers\UserController;
```

## ➡️ Trabalhando com **Views**.
* Criar uma **View** com diretório (**diretorio/view**):
```shell
php artisan make:view [pasta/nome]
```
### Retornar uma **view personalizada** (**pasta.arquivo**).
```php
return view('users.index');
```

## Utilizando **Links** e **Formulários**.
* Criar um **link** para uma **rota** use o **namespace** de rotas
```html
<a href="{{ route('user.create') }}">Create</a>
```
### Formulário para **envio de dados**.
```html
<form action="{{ route('user-store') }}" method="POST">
```
### Manter dados do formulario apos o **F5**.
* O valor do **old** é o **name do input**.
```html
value="{{ old('name') }}"
```  
### Exibir **mensagens de erro na View**.
* Use o valor que vc predefiniu na function **with()**
```php
@if (session('success'))
    <p>
        {{ session('success') }}
    </p>
@endif
```  
```php
@if($errors->any())
    @foreach ($errors->all() as $error)
        <p style="color: red">{{ $error }}</p>
    @endforeach
@endif
```

### Formulário para **deletar um registro** usando parametros dentro da rota.
* Importante usar (**@csrf**) e (**@method('delete')**)
```html
<form method="POST" action="{{ route('user.destroy', ['user' => $user->id]) }}" class="d-inline">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>
</form>
```


# Capturar um **dado de um laço e passar** para um href utilizando **rotas com parâmetros**.
* Esse exemplo é uma rota passando com **parâmetros**
```html
<a href="{{ route('user.show', ['user' => $user->id]) }}"> Visualizar</a><br><hr>
```

## ➡️ Configurações do Banco de Dados (Regras Migrate!)
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
Certifique-se de que `APP_KEY` no `.env.example` esteja vazio!.
(**Fora o APP_KEY, o arquivo .env deve estar totalmente igual ao .env.example**)
Para hospedagens reais, alterar: **APP_ENV=local**


### Executar as migrations
* Após configurar o banco, execute (**CASO QUEIRA USAR O BD JÀ INTEGRADO NO LARAVEL**) - (**NÂO RECOMENDADO EM PROJETOS REAIS**):
```bash
php artisan migrate
```
## ➡️ Trabalhando com dados do banco
### Listar dados do banco
* Como no exemplo vamos importar a **model (User)** e **orderByDesc get()**, assim recuperando todos os dados
**Controller:**
```php
$users = User::orderByDesc('id')->get();
return view('users.index', ['users' => $users]);
```
**View:**
```php
@forelse ($users as $user)
    ID: {{ $user->id }}<br>
    Nome: {{ $user->name }}<br>
    E-mail: {{ $user->email }}<br>
@empty
    <p>Sem registros encontrados.</p>
@endforelse
```

## ➡️ Trabalhando com **Request** e **Validações de dados**.
### Criar uma Request para validação
* Criando arquivo de validação: **UserRequest**
```shell
php artisan make:request UserRequest
```

* Exemplo de **validações**:
```php
public function authorize(): bool
{
    return true;
}

/**
 * Get the validation rules that apply to the request.
 *
 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
 */
public function rules(): array
{
    // pegar dados da URL
    $userId = $this->route('user');

    return [
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . ($userId ? $userId->id : null),
        'password' => 'required|min:6',
    ];
}

public function messages(): array
{
    return [
        'name.required' => 'Campo nome é obrigatorio',
        'email.required' => 'Campo e-mail é obrigatorio',
        'email.email' => 'Campo deve ser um email valido!',
        'email.unique' => 'O e-mail já está cadastrado!',
        'password.required' => 'Campo senha é obrigatorio',
        'password.min' => 'Senha com no minimo :min caracteres!',
    ];
}
```

## Exemplo de criação, validação e redirecionamento.
**Controller:**
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

## Formatação de datas.
* Para formatar datas, use a biblioteca `Carbon`:
```php
{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}
```

# Uso do **var_drump()**.
```php
{{ dd($array) }}
```

## ➡️ Trabalhando com **Layouts** e **Componentes**.
### Criar um layout
No diretório `resources/view/layouts`, crie `admin.blade.php`:
No arquivo `admin.blade.php` crie seu corpo e importe o Bootstrap:
```html
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
```
`admin.blade.php` Na admn o local onde o content sera adicionado:
```html
<div class="container">
    @yield('content')
</div>
```

### Usar o layout
Na View criando o content (para usar no `@yield` da página `admin.blade.php`):
```html
@extends('layouts.admin')
@section('content')
    <!-- Conteúdo -->
@endsection
```
### Criar um componente
```bash
php artisan make:component nome-componente --view
```
Usar o componente na View (<x-nome-componente />):
```html
<x-alert />
```


#laravel #api #php #mvc #crud #poo