<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Descrição</th>
            <th scope="col">Preço</th>
            <th scope="col">qtd</th>
            <th scope="col">category</th>
            <th scope="col">creation_date</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($test as $user)
            <tr>
            <th>{{ $user->id }}</th>
            <td>{{ $user->name }}</td> 
            <td>{{ $user->description }}</td> 
            <td>{{ $user->price }}</td> 
            <td>{{ $user->qtd }}</td> 
            <td>{{ $user->category }}</td> 
            <td>{{ $user->creation_date }}</td> 

            </tr>
        @empty
        @endforelse
    </tbody>
</table>