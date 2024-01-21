<?php

namespace App\Livewire\Group;

use App\Models\Group;
use Livewire\Component;

class EditGroup extends Component
{
    public $group;
    public $name = '';

    public function render()
    {
        return view('livewire.group.edit-group');
    }

    public function mount(Group $group)
    {
        $this->group = $group;
        $this->name = $group->name;
    }

    public function editGroup()
    {
        $validated = $this->validate([
            'name' => 'required',
        ]);

        $this->group->update($validated);

        return $this->redirect('/groups/index', navigate:true);
    }
}
