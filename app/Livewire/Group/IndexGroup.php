<?php

namespace App\Livewire\Group;

use App\Models\Group;
use Livewire\Component;

class IndexGroup extends Component
{
    public $groups = [];

    public function mount()
    {
        $this->groups = Group::all();
    }

    public function render()
    {
        return view('livewire.group.index-group');
    }
}
