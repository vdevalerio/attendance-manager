<div class="container">
    <div class="row">
        <div class="col d-flex justify-content-between align-items-center">
            <h1>Attendance of {{ $attendance->created_at }}</h1>
            <button class="btn btn-primary btn-sm" wire:click="startAttendance">Start Attendance</button>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Attended at</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendance->people as $person)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $person->name }}</td>
                <td>{{ $person->pivot->created_at }}</td>
                <td>
                    <button class="btn btn-primary btn-sm" wire:navigate href="/attendances/{{$attendance->group_id}}/{{$attendance->id}}/show">View</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
