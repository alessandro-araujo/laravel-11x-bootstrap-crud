<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobsRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class JobsController extends Controller
{
    public function index()
    {
        return view('jobs.index');
    }
    
    public function store(JobsRequest $request){
        $request->validated();

        DB::beginTransaction();
        try {
            //code...
        } catch (Exception $error) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Usuário não enviado');
        }
    }
}
