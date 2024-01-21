<?php

namespace App\Livewire\Person;

use App\Models\Person;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class EditPerson extends Component
{
    public $person;
    public $name = '';
    public $image = '';

    public function render()
    {
        return view('livewire.person.edit-person');
    }

    public function mount(Person $person)
    {
        $this->person = $person;
        $this->name = $person->name;
        $this->image = $person->image;
    }

    public function editPerson()
    {
        $validated = $this->validate([
            'name' => 'sometimes',
            'image' => 'sometimes',
        ]);

        if (preg_match('/^data:image\/(\w+);base64,/', $validated['image'], $type)) {
            $image = substr($validated['image'], strpos($validated['image'], ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                throw new \Exception('invalid image type');
            }

            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if ($image === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        $imageName = 'person_' . time() . '.' . $type;
        Storage::disk('public')->put($imageName, $image);

        $validated['image'] = $imageName;

        $this->person->update($validated);

        return $this->redirect('/people/index', navigate:true);
    }

    public function updateImage($imageDataUrl)
    {
        $this->image = $imageDataUrl;
    }
}
