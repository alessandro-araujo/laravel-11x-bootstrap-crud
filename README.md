# Laravel (Create, Read, Update, Delete, Middleware Login, API Route, ORM Eloquent, Jobs and Queues) <img src="https://github.com/user-attachments/assets/e4b7a64d-8302-495b-b44d-93d9d0f4b2a4" width="55" height="35" />  <img src="https://github.com/user-attachments/assets/958dab41-1a1f-4f53-afef-43e2d5a6740c" width="40" height="40" />

## ➡️ Requisitos.
- **PHP** 8.2 ou superior
- **Composer** 2.8.5 ou superior
- **Node.js** 20 ou superior
- **phpMyAdmin** 5.2.1 ou superior
- **Git** 2.47.1.windows.1 ou superior

## ➡️ Usando o projeto pela **primeira vez**.
* Clone o repositório com o **git**
```shell
git clone https://github.com/alessandro-araujo/laravel-11x-bootstrap-crud.git .
```

- **[Configurando .env](#%EF%B8%8F-configura%C3%A7%C3%B5es-do-banco-de-dados-regras-migrate) Crie o arquivo .env de .env-example**
* Crie a **chave** (comando que define o valor **APP_KEY** no seu arquivo **.env**).
```env
php artisan key:generate
```
- **Instale as depêndencias:**
```shell
composer install
```
- **Executar as migrations**
* Após configurar o banco, execute (**CASO QUEIRA USAR O BD JÀ INTEGRADO NO LARAVEL**) - (**NÂO RECOMENDADO EM PROJETOS REAIS**):
```shell
php artisan migrate
```
- Cadastre os **Seeders**
```shell
php artisan db:seed
```
- **[Configurando o Bootstrap](#%EF%B8%8F-instalando-bootstrap-fa%C3%A7a-na-ordem) Execute todos os comandos na ordem**
Se não **Configurar o Bootstrap** o projeto **não vai funcionar**.
- Instalando Bootstrap (**Faça na Ordem!**).
* Usando o comando **npm** vamos instalar as dependências.
```shell
npm install
```
```shell
npm i --save bootstrap @popperjs/core
```
```shell
npm i --save-dev sass
```
**Executando a interface do Bootstrap**
```shell
npm run dev
```
- **Execute o php:**
```shell
php artisan serve
```
- **Acesse: [http://127.0.0.1:8000/](http://127.0.0.1:8000/)**



## ➡️ Aprendendo a importar o **Bootstrap** no projeto.

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

## ➡️ Criando o Projeto do **zero**.
Crie o projeto usando o composer:
```shell
composer create-project laravel/laravel .
```

## ➡️ Trabalhando com **Authentication** e **Middleware**.
- Travando rotas só para **authenticated**
```php
Route::group(['middleware' => 'auth'], function(){
    // Routes
}); 
```
- Configurando a **Controller**
```php
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

public function loginProcess(LoginRequest $request)
{
    // Validar o formulário
    $request->validated();

    // Proteção contra tentativas excessivas
    $key = 'login-attempts:' . $request->ip();
    if (RateLimiter::tooManyAttempts($key, 5)) {
        return back()->with('error', 'Muitas tentativas de login. Tente novamente mais tarde.');
    }

    // Validar usuário e senha no banco de dados    
    $authenticated = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

    if(!$authenticated){
        // Erro ao conseguir logar no sistema
        return back()->withInput()->with('error', 'E-mail ou Senha inválida');
    }

    // Obter usuário autenticado
    // $user = Auth::user();
    // $user = User::find($user->id);
    
    // Regeneração da sessão para segurança
    $request->session()->regenerate();
    // Direcionar para o dashboard
    return redirect()->route('user.index');
}
public function destroy()
{
    // Destruindo a SESSION 
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login')->with('success', 'Deslogado com sucesso!');
}
```

## ➡️ Recuperando dados da  **Session** da **View**.
```php
<p>Olá, {{ auth()->user()->name }}!</p>
```

## ➡️ Criando proteção contra **Brute Force**.
- Proteção contra tentativas de login excessivas, usando o **throttle**.
```php
use Illuminate\Support\Facades\RateLimiter;
$key = 'login-attempts:' . $request->ip();

if (RateLimiter::tooManyAttempts($key, 5)) {
    return back()->with('error', 'Muitas tentativas de login. Tente novamente mais tarde.');
}
RateLimiter::hit($key, 60); // Permite 5 tentativas por minuto

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

## ➡️ Trabalhando com **API Route**.
* Instalando os modulos da **API**
run all pending database migrations? yes
```shell
php artisan install:api
```
* **Rotas**
```php
// Acesso com auth
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Retornando informações direto no get
Route::get('/user', function (Request $request) {
    return response()->json([
        'status' => true,
        'message' => 'Listar Usuários'
    ], 200);
});

Route::get('/user', [UserController::class, 'getForApi']);
```
* **Controller** 
```php
use Illuminate\Http\JsonResponse;

public function getForApi(): JsonResponse
{
    // Pegando todos os dados
    $users = User::all();    
    return response()->json([
        'status' => true,
        'users' => $users
    ]);
}
```
* Para usar com **Paginação**
```php
    // Usando paginação PARAM=2 é a quantidade de itens por pagina
    $users = User::orderBy('id', 'DESC')->paginate(1);
```
* o parâmetro **page=** recebe a quantidade de intes que vai ser enviado ao fronts
- **GET** =  *http://localhost:8000/api/user?page=2*


* Pegando apenas **1 parametro** na **API**
- LEMBRANDO **getForApiUser(User $user)** AQUI O **LARAVEL JÁ FAZ O SELECT WHERE = ID**
```php
/**
    * Vamos retornar um Json
    * @return \Illuminate\Http\JsonResponse
    */
public function getForApiUser(User $user): JsonResponse
{   
    return response()->json([
        'status' => true,
        'user' => $user
    ]);
}
```




## ➡️ Trabalhando com **Models** - (**ORM Eloquent**).
* Criando uma **Model**
```shell
php artisan make:model Flight 
```

* Vamos definir o nome da tabela, e sua chave primaria:

```php
/**
 * A tabela associada ao modelo.
 *
 * @var string
 */
protected $table = 'my_flights';    
protected $primaryKey = 'flight_id';

    /**
 * Indica se o ID do modelo é de incremento automático.
 *
 * @var bool
 */
public $incrementing = true;

/**
 * O tipo de dados do ID da chave primária.
 *
 * @var string
 */
protected $keyType = 'string';

/**
 * Indica se o modelo deve ter registro de data e hora..
 *
 * @var bool
 */
public $timestamps = false;

    /**
     * Conexão de banco de dados que deve ser usada pelo modelo.
     *
     * @var string
     */
    protected $connection = 'mysql';

```


* Exemplos de **SELECT**

```php
$flights = Flight::where('active', 1)
               ->orderBy('name')
               ->take(10)
               ->get();
            

```
- Se você já tiver uma instância de um modelo Eloquent que foi recuperado do banco de dados, você pode "atualizar" o modelo usando o fresh E a refresh de métodos. O que é fresh O método irá re-recuperar o modelo a partir do banco de dados. A instância do modelo existente não será afetada:
```php
$flight = Flight::where('number', 'FR 900')->first();
$freshFlight = $flight->fresh();
```
* O que é refresh O método irá reidratar o modelo existente usando novos dados do banco de dados. Além disso, todas as suas relações carregadas serão atualizadas também:
```php
$flight = Flight::where('number', 'FR 900')->first();
$flight->number = 'FR 456';
$flight->refresh();
$flight->number; // "FR 900"
```
```php
// Select com condições
$test = Produtos::select(
    'id', 
    'nome', 
    'preco', 
    'quantidade', 
    'categoria',
    DB::raw('ROUND(preco * 1.1, 2) AS preco_com_imposto'),
    DB::raw('LENGTH(descricao) AS tamanho_descricao')
)
->where('preco', '>', 1000)
->whereBetween('quantidade', [5, 20])
->whereIn('categoria', ['Eletrônicos', 'Móveis'])
->orderBy('preco', 'DESC')
->limit(3)
->get();
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

## ➡️ Trabalhando com **E-mails** (**Jobs** e **Queues**).
- Vamos enviar um e-mail de boas vindas ao sistema:
* Criando **Mail**.
```shell
php artisan make:mail SendWelcomeEmail
```
* Crie a **Controller**: 
```shell
php artisan make:controller JobsController
```
* **JobsController**
```php
public function store(JobsRequest $request){
    $request->validated();

    $user = [
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
    ];

    try {
        Mail::to($user['email'])->send(new SendWelcomeEmail($user));
        return redirect()->route('jobs.index')->with('success', 'E-mail enviado com sucesso!');
    } catch (Exception $error) {
        return back()->withInput()->with('error', $error);
    }
}
```
* **SendWelcomeEmail**
- Crie duas view, no seu estilo, para enviarmos.
```php
/**
 * Create a new message instance.
 * @param mixed
 */
public function __construct(public $user)
{
    //
}
public function content(): Content
{
    return new Content(
        view: 'emails.SendWelcomeHtml',
        text: 'emails.SendWelcomeText'
    );
}
```

- Usaremos o **https://mailtrap.io** como servidor de e-mail.
- Depois do login escolha o Laravel 9+ e substitua:
* Configurando arquivo .env
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
```
- Usando **Jobs e Queues**
* Vamos criar um job
```shell
php artisan make:job JobSendWelcomeEmail
```
* Vamos agendar o **Job** em vez de mandar direto com o **Mail::to()->send()**
```php
JobSendWelcomeEmail::dispatch($user['email'])->onQueue('default');
```
No Laravel já existe a **Queue default**

* **JobSendWelcomeEmail**
```php
/**
 * Create a new job instance.
 * @param array
 */
public function __construct(private $userArray)
{
    //
}

/**
 * Execute the job.
 * @return void 
 */
public function handle(): void
{   
    // Recuperamos o array com os dados necessarios: 
    $requestUser = $this->userArray;
    // Agendamos nosso pedido na tabela job
    Mail::to($requestUser['email'])->later(now()->addMinute(), new SendWelcomeEmail($requestUser));
    }
```
* Agora vamos executar uma **Queue**
```shel
php artisan queue:work --queue=default
```
### Em Projetos **REAIS**, não use o **queue:work**
* Use o **Supersisor**
**https://laravel.com/docs/11.x/queues#supervisor-configuration**
* Enviar e-mail gratuito via SMTP: **login.iagente.com.br**

## ➡️ Importando **CSV** com **Jobs e Queues**.
* Vamos criar os **arquivos** e instalar a **lib do csv**
```shell
composer require league/csv:^9.21.0
```
* Definir que, se um job falhar, o Laravel deve esperar 90 segundos antes de tentar executá-lo novamente.
```env
QUEUE_RETRY_AFTER=90 
```
- **Controller**
```shell
php artisan make:controller ImportCsvController
```
* Codigo:
```php
// Importar os dados do Excel
public function import(CsvRequest $request)
{
    // Validar o arquivo
    $request->validated();

    // Gerar um nome de arquivo baseado na data e hora atual
    $timestamp = now()->format('Y-m-d-H-i-s');
    $filename = "import-{$timestamp}.csv";

    // Receber o arquivo e movê-lo para um local temporário
    $path = $request->file('file')->storeAs('uploads', $filename);

    // Despachar o Job para processar o CSV
    ImportCsvJob::dispatch($path)->onQueue('import_csv');
    // Redirecionar o usuário para a página anterior e enviar a mensagem de sucesso
    return back()->with('success', 'Dados estão sendo importados.');
}
```
- **Request** (Validações)
```shell
php artisan make:request CsvRequest
```
* Codigo:
```php
/**
 * Determine if the user is authorized to make this request.
 */
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
    return [
        'file' => 'required|mimes:csv,txt|max:8192', // 8 MB
    ];
}
public function messages(): array
{
    return [
        'file.required' => 'O campo arquivo é obrigatório.',
        'file.mimes' => 'Arquivo inválido, necessário enviar arquivo CSV.',
        'file.max' => 'Tamanho do arquivo execede :max Mb.'
    ];
}
```
- **Job e Queue**
```shell
php artisan make:job ImportCsvjob
```
* Codigo:
```php
use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

protected $filePath;

/**
 * Create a new job instance.
 */
public function __construct($filePath)
{
    $this->filePath = $filePath;
}

/**
 * Execute the job.
 */
public function handle(): void
{
    // Ler o conteúdo do arquivo com o método createFromPath sem abrir o arquivo 
    $fullPath = $this->filePath;
    $csv = Reader::createFromPath(storage_path('app/private/' . $fullPath), 'r');
    
    // Definir o delimitador como ponto e vírgula
    $csv->setDelimiter(';');
    // Definir a primeira linha como cabeçalho.
    $csv->setHeaderOffset(0);
    // Inicializar o offset para começar do início do arquivo
    $offset = 0;
    $limit = 100;

    // Continuar processando até que todos os registros sejam lidos
    while (true) {
        // Definir o inicio e o fim das linhas que devem ser lidas
        $stmt = (new Statement())->offset($offset)->limit($limit);
        // Retorna uma coleção de arrays associativos, cada array representa uma linha do arquivo CSV com base no offset e limit definidos.
        $records = $stmt->process($csv);
        // Se não houver mais registros, sair do loop
        if (count($records) === 0) {
            break;
        }

        // Percorrer as linhas do arquivo
        foreach ($records as $record) {
            // Criar o array de informções do novo registro
            $userData = [
                'name' => $record['name'],
                'email' => $record['email'],
                'password' => Hash::make(Str::random(7), ['rounds' => 12])
            ];

            // Verifica se o e-mail já está cadastrado
            if (UserCsv::where('email', $userData['email'])->exists()) {
                // Salvar o log indicando que o e-mail já está cadastrado
                continue;
            }
            // Inserir os dados no banco de dados
            try {
                UserCsv::create($userData);
            } catch (Exception $error) {
                // Log personalizado
                Log::error('Erro ao criar usuário a partir do CSV', [
                    'exception' => get_class($error),
                    'message'   => $error->getMessage(),
                    'file'      => $error->getFile(),
                    'line'      => $error->getLine(),
                    'data'      => $userData,
                ]);
            
                // Opcional: relançar a exceção
                throw $error;
            }
            

            // Salvar o log indicando e-mail cadastrado com sucesso
        }
        // Atualizar o offset para a próxima iteração
        $offset += $limit;
    }
}
```

* Vamos ler a **Queue**
```shell
php artisan queue:work --queue=import_csv
```

## ➡️ Criando **Paginação** e **Estilizando**.
* Vamos criar itens com uma paginação
```php
// Recuperar os registros do banco de dados
$users = UserCsv::orderBy('id', 'DESC')->paginate(40);
// Carregar a VIEW
return view('csv.index', ['users' => $users]);
```
* Vamos **estilizar**
```shell
php artisan vendor:publish --tag=laravel-pagination
```
* Carregar na **View**
```php
@if($users)
    {{ $users->links('vendor.pagination.bootstrap-5') }}
@endif
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
### Usando uma **imagem** <img>:
```html
<img class="mb-4" src="{{ asset('images/nome.png')}}" alt="" width="72" height="72" >
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

- **[Usando o projeto pela primeira vez](#%EF%B8%8F-usando-o-projeto-pela-primeira-vez)**.
  
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

### 1. Instalar o Bootstrap Icons via NPM
Primeiro, instale o pacote `bootstrap-icons` no seu projeto. Abra o terminal no diretório do seu projeto e execute:

```bash
npm install bootstrap-icons
```

### 2. Importar o Bootstrap Icons no seu arquivo `app.scss` ou `app.js`
Após a instalação, você precisa importar o CSS do Bootstrap Icons no seu arquivo `app.scss` ou `app.js`.

#### No `app.scss`:
Abra `resources/sass/app.scss` e adicione a seguinte linha para importar o Bootstrap Icons:

```scss
@import 'bootstrap-icons/font/bootstrap-icons.css';
```

#### Ou no `app.js`:
Se preferir importar no `app.js`, adicione a seguinte linha no início do arquivo `resources/js/app.js`:

```javascript
import 'bootstrap-icons/font/bootstrap-icons.css';
```



#laravel #api #php #mvc #crud #poo
