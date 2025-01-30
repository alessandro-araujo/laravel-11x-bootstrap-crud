<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Database\QueryException;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }
    
    public function create()
    {
        return view('login.create');
    }
    
    public function store(UserRequest $request)
    {
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
            return redirect()->back()->with('error', $e);
        }
    }

    public function loginProcess(LoginRequest $request)
    {
        // Validar o formulário
        $request->validated();

        // Validar usuário e senha no banco de dados    
        $authenticated = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        if(!$authenticated){
            // Erro ao conseguir logar no sistema
            return back()->withInput()->with('error', 'E-mail ou Senha inválida');
        }

        // Obter usuário autenticado
        $user = Auth::user();
        $user = User::find($user->id);

        // Direcionar para o dashboard
        return redirect()->route('user.index');
    }
    public function destroy()
    {
        // Destruindo a SESSION 
        Auth::logout();
        return redirect()->route('login')->with('success', 'Deslogado com sucesso!');
    }
}
