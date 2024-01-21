<div class="container">
    <div class="row">
        <div class="col d-flex justify-content-between align-items-center" wire:navigate href="/people/create">
            <h1>Person Index</h1>
            <button class="btn btn-primary btn-sm">Create Person</button>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($people as $person)
            <tr>
                <th scope="row">{{ $person->id }}</th>
                <td>{{ $person->name }}</td>
                <td>
                    <button class="btn btn-primary btn-sm">View</button>
                    <button class="btn btn-secondary btn-sm" wire:navigate href="/people/{{$person->id}}/edit">Edit</button>
                    <button class="btn btn-danger btn-sm" wire:click="deletePerson({{$person->id}})">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
