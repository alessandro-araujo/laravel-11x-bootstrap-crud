@extends('layouts.admin')
@section('content')
<p>Olá, {{ auth()->user()->name }}!</p>

    <div class="card mt-4 mb-4 border-light shadow">

        <div class="card-header hstack gap-2">
            <span>Comandos da API</span>

        </div>
        
        <div class="card-body">

            <x-alert />

            <div class="position-relative">
                <code id="code-content" class="bg-light text-dark p-2 rounded">
                    <?php echo e('<p>Este é um exemplo de código</p>'); ?>
                </code>
                <button class="btn btn-sm btn-primary position-absolute top-0 end-0" id="copy-btn">
                    Copiar
                </button>
            </div>


        </div>
    </div>
@endsection