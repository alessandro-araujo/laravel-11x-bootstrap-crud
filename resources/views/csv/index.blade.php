@extends('layouts.admin')
@section('content')
    <p>Olá, {{ auth()->user()->name }}!</p>
    <h3 class="card-header">Laravel 11 - Importar Excel</h3>
    <div class="card-body">
        <x-alert />

        <form action="{{ route('csv.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('post')
            <div class="input-group my-4">
                <input type="file" name="file" class="form-control" id="file" accept=".csv">
                <button type="submit" class="btn btn-outline-success" id="fileBtn"><i
                        class="fa-solid fa-upload"></i> Importar</button>
            </div>

        </form>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        @if($users)
            {{ $users->links('vendor.pagination.bootstrap-5') }}
        @endif
    </div>
@endsection
