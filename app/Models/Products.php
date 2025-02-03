<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    // Desabilitar o uso de timestamps
    public $timestamps = false;

    // Ou definir explicitamente quais colunas você deseja preencher
    protected $fillable = [
        'name', 'description', 'price', 'qtd', 'category', 'creation_date'
    ];
}
