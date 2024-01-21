<div class="container">
    <div class="row">
        <div class="col d-flex justify-content-between align-items-center" wire:navigate href="/groups/create">
            <h1>Group Index</h1>
            <button class="btn btn-primary btn-sm">Create Group</button>
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
            @foreach($groups as $group)
            <tr>
                <th scope="row">{{ $group->id }}</th>
                <td>{{ $group->name }}</td>
                <td>
                    <button class="btn btn-primary btn-sm">View</button>
                    <button class="btn btn-secondary btn-sm" wire:navigate href="/groups/{{$group->id}}/edit">Edit</button>
                    <button class="btn btn-danger btn-sm" wire:click="deleteGroup({{$group->id}})">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
