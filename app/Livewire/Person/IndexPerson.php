<?php

namespace App\Livewire\Person;

use App\Models\Person;
use Livewire\Component;

class IndexPerson extends Component
{
    public $people = [];

    public function render()
    {
        return view('livewire.person.index-person');
    }

    public function mount()
    {
        $this->people = Person::all();
    }

    public function deletePerson(Person $person)
    {
        $person->delete();

        return $this->redirect('/people/index', navigate:true);
    }
}
