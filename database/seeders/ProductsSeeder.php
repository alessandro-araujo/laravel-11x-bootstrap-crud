<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Products;
use Carbon\Carbon;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Products::insert(
        //     [
        //         'name' => 'Notebook Gamer',
        //         'description' => 'Notebook com placa de vídeo dedicada',
        //         'price' => 4500.00,
        //         'qtd' => 10,
        //         'category' => 'Eletrônicos',
        //         'creation_date' => Carbon::now(),  // Obtém a data e hora atual
        //     ],
        //     [
        //         'name' => 'Smartphone X',
        //         'description' => 'Celular com câmera de 108MP',
        //         'price' => 2500.00,
        //         'qtd' => 15,
        //         'category' => 'Eletrônicos',
        //         'creation_date' => Carbon::now(),
        //     ],
        //     [
        //         'name' => 'Teclado Mecânico',
        //         'description' => 'Teclado RGB com switches azuis',
        //         'price' => 350.00,
        //         'qtd' => 30,
        //         'category' => 'Acessórios',
        //         'creation_date' => Carbon::now(),
        //     ],
        //     [
        //         'name' => 'Cadeira Gamer',
        //         'description' => 'Cadeira ergonômica com ajustes de altura',
        //         'price' => 1200.00,
        //         'qtd' => 5,
        //         'category' => 'Móveis',
        //         'creation_date' => Carbon::now(),
        //     ],
        //     [
        //         'name' => 'Monitor 27"',
        //         'description' => 'Monitor Full HD com taxa de atualização de 144Hz',
        //         'price' => 1800.00,
        //         'qtd' => 8,
        //         'category' => 'Eletrônicos',
        //         'creation_date' => Carbon::now(),
        //     ]
        // );
    
    
        Products::insert([
            [
                'name' => 'Notebook Gamer',
                'description' => 'Notebook com placa de vídeo dedicada',
                'price' => 4500.00,
                'qtd' => 10,
                'category' => 'Eletrônicos',
                'creation_date' => Carbon::now(),  // Obtém a data e hora atual
            ],
            [
                'name' => 'Smartphone X',
                'description' => 'Celular com câmera de 108MP',
                'price' => 2500.00,
                'qtd' => 15,
                'category' => 'Eletrônicos',
                'creation_date' => Carbon::now(),
            ],
            [
                'name' => 'Teclado Mecânico',
                'description' => 'Teclado RGB com switches azuis',
                'price' => 350.00,
                'qtd' => 30,
                'category' => 'Acessórios',
                'creation_date' => Carbon::now(),
            ],
            [
                'name' => 'Cadeira Gamer',
                'description' => 'Cadeira ergonômica com ajustes de altura',
                'price' => 1200.00,
                'qtd' => 5,
                'category' => 'Móveis',
                'creation_date' => Carbon::now(),
            ],
            [
                'name' => 'Monitor 27"',
                'description' => 'Monitor Full HD com taxa de atualização de 144Hz',
                'price' => 1800.00,
                'qtd' => 8,
                'category' => 'Eletrônicos',
                'creation_date' => Carbon::now(),
            ]
        ]);
        
    
    }
}
