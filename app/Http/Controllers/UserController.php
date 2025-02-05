<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use App\Models\Products;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function index()
    {
        // Recuperar os registros do banco de dados
        $users = User::orderByDesc('id')->get();
        // Carregar a VIEW
        return view('users.index', ['users' => $users]);
    }

    public function indexApi()
    {
        return view('api.index');
    }

    /**
     * Vamos retornar um Json
     * @return \Illuminate\Http\JsonResponse
     */
    public function getForApiUserAll(): JsonResponse
    {
        // Pegando todos os dados
        #$users = User::all();
        // Usando paginação PARAM=2 é a quantidade de itens por pagina
        $users = User::orderBy('id', 'DESC')->paginate(1);
        // http://localhost:8000/api/user?page=2
        
        return response()->json([
            'status' => true,
            'users' => $users
        ]);
    }

    /**
     * Vamos retornar um Json
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getForApiUser(int $userId): JsonResponse
    {   
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Usuário não encontrado'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'user' => $user
        ], 200);
    }

    
    /**
     * Vamos retornar um Json
     * @param  \App\Http\Requests\UserRequest  $request O objeto de requisição contendo os dados do usuário a ser criado.
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeForApiUser(UserRequest $request): JsonResponse
    {   
        try {
            // Cadastrar o usuário no BD
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            // Retorna os dados do usuário criado e uma mensagem de sucesso com status 201
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuário cadastrado com sucesso!",
            ], 201);

        } catch (QueryException $e) {
            // Retorna uma mensagem de erro com status 400
            return response()->json([
                'status' => false,
                'message' => "Usuário não cadastrado!",
            ], 400);
        }
    }

    /**
     * Atualizar os dados de um usuário existente com base nos dados fornecidos na requisição.
     * 
     * @param  \App\Http\Requests\UserRequest  $request O objeto de requisição contendo os dados do usuário a ser atualizado.
     * @param  \App\Models\User  $user O usuário a ser atualizado.
     * @return \Illuminate\Http\JsonResponse
     */
    public function putForApiUser(UserRequest $request, User $user): JsonResponse
    {   
        try {
            // Editar as informações do registro no banco de dados
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            // Retorna os dados do usuário editado e uma mensagem de sucesso com status 200
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuário editado com sucesso!",
            ], 200);
        }catch (Exception $e) {
            // Retorna uma mensagem de erro com status 400
            return response()->json([
                'status' => false,
                'message' => "Usuário não editado!",
            ], 400);
        }
    }
    
    /**
     * Vamos retornar um Json
     * @param \App\Models\User
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteForApiUser(User $user): JsonResponse
    {   
        try {
            // Apagar o registro no banco de dados
            $user->delete();
            // Retorna os dados do usuário apagado e uma mensagem de sucesso com status 200
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuário apagado com sucesso!",
            ], 200);
        } catch (Exception $e) {
            // Retorna uma mensagem de erro com status 400
            return response()->json([
                'status' => false,
                'message' => "Usuário não apagado!",
            ], 400);
        }
    }
    

    public function test()
    {
        // Select ALL
        # $test = Products::get();

        // Select com condições
        $test = Products::select(
            'id', 
            'name', 
            'price', 
            'qtd', 
            'category',
            DB::raw('ROUND(price * 1.1, 2) AS preco_com_imposto'),
            DB::raw('LENGTH(description) AS tamanho_descricao')
        )
        ->where('price', '>', 1000)
        ->whereBetween('qtd', [5, 20])
        ->whereIn('category', ['Eletrônicos', 'Móveis']) 
        ->orderBy('preco_com_imposto', 'DESC')  
        ->limit(3)
        ->get();
        return view('users.test', ['test' => $test]);
    }

    public function show(User $user)
    {       
         return view('users.show', ['user' => $user]);
    }
    
    public function create()
    {
        return view('users.create');
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }
    
    public function update(UserRequest $request, User $user)
    {
        // Validar o formulário
        $request->validated();

        // Editar as informações do registro no banco de dados
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Redirecionar o usuário, enviar a mensagem de sucesso
        return redirect()->route('user.show', ['user' => $user->id ])->with('success', 'Usuário editado com sucesso!');
    }

    public function destroy(User $user)
    {
        // Apagar o registro no BD
        $user->delete();

        // Redirecionar o usuário, enviar a mensagem de sucesso
        return redirect()->route('user.index')->with('success', 'Usuário deletado com sucesso!');
    }

    public function store(UserRequest $request)
    {
        // Validar o formulário
        $request->validated();
        try {
            // Cadastrar o usuário no BD
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('user.index')->with('success', 'Usuário cadastrado com sucesso!');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar usuário. Tente novamente.');
        }
    }
    
}
