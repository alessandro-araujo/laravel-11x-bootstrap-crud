<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobsRequest;
use App\Jobs\JobSendWelcomeEmail;
use Exception;
// Somente se for enviar o email sem o JOB
# use App\Mail\SendWelcomeEmail; 
# use Illuminate\Support\Facades\Mail;

class JobsController extends Controller
{
    public function index()
    {
        return view('jobs.index');
    }
    
    public function store(JobsRequest $request){
        $request->validated();

        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ];

        try {
            // Metódo para enviar o email diretamente
            # Mail::to($user['email'])->send(new SendWelcomeEmail($user));

            // Agendar um email com Job
            JobSendWelcomeEmail::dispatch($user)->onQueue('default');

            return redirect()->route('jobs.index')->with('success', 'E-mail enviado com sucesso!');
        } catch (Exception $error) {
            return back()->withInput()->with('error', $error);
        }
    }
}
