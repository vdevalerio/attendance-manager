<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Livewire\Component;

class IndexAttendance extends Component
{
    public $attendances = [];
    public $groupId;

    public function mount($group)
    {
        $this->attendances = Attendance::where('group_id', $group)->get();
        $this->groupId = $group;
    }

    public function startAttendance()
    {
        $PATH =  './../app/Services/face-recognition.py';
        $command = escapeshellcmd('python3 ' . $PATH . ' ' . $this->groupId);
        $output = [];
        $returnVar = null;

        exec($command, $output, $returnVar);

        if ($returnVar == 0) {
            // Success
            // ... handle success
        } else {
            // Error
            // ... handle error
        }
    }

    public function render()
    {
        return view('livewire.attendance.index-attendance');
    }
}
