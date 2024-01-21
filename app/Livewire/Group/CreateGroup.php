<?php

namespace App\Livewire\Group;

use App\Models\Group;
use Livewire\Component;

class CreateGroup extends Component
{
    public $name = '';
    public $code = '';

    public function render()
    {
        return view('livewire.group.create-group');
    }

    public function createGroup()
    {
        $validated = $this->validate([
            'name' => 'required',
        ]);

        Group::create($validated);

        return $this->redirect('/home', navigate:true);
    }
}
