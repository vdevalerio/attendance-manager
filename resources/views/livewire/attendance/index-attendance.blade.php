<div class="container">
    <div class="row">
        <div class="col d-flex justify-content-between align-items-center">
            <h1>Attendances</h1>
            <button class="btn btn-primary btn-sm" wire:click="startAttendance">Start Attendance</button>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $attendance->created_at }}</td>
                <td>
                    <button class="btn btn-primary btn-sm" wire:navigate href="/attendances/{{$attendance->group_id}}/{{$attendance->id}}/show">View</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
