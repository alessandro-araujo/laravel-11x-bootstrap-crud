<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvRequest;
use App\Jobs\ImportCsvJob;
use App\Models\UserCsv;

class ImportCsvController extends Controller
{
    public function index()
    {
        // Recuperar os registros do banco de dados
        $users = UserCsv::orderBy('id', 'DESC')->paginate(40);
        
        // Carregar a VIEW
        return view('csv.index', ['users' => $users]);
    }

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
}
