<?php

namespace App\Jobs;

use App\Models\UserCsv;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use League\Csv\Reader;
use League\Csv\Statement;
use Illuminate\Support\Facades\Log;


class ImportCsvJob implements ShouldQueue
{
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
}
