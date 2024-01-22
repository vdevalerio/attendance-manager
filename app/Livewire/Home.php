<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{
    public function startAttendance()
    {
        $PATH =  './../app/Services/face-recognition.py';
        $command = escapeshellcmd('python3 ' . $PATH);
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
        return view('livewire.home');
    }
}
