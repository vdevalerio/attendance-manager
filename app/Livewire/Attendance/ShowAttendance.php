<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Livewire\Component;

class ShowAttendance extends Component
{
    public $attendance;

    public function mount(Attendance $attendance)
    {
        $this->attendance = $attendance;
    }

    public function render()
    {
        return view('livewire.attendance.show-attendance');
    }
}
