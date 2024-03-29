<?php

namespace App\Livewire\Person;

use App\Models\Person;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePerson extends Component
{
    use WithFileUploads;

    public $name = '';
    public $image = '';

    protected $listeners = [
        'setImageData' => 'updateImage',
    ];

    public function render()
    {
        return view('livewire.person.create-person');
    }

    public function createPerson()
    {
        $validated = $this->validate([
            'name' => 'required',
            'image' => 'required',
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

        Person::create($validated);

        return $this->redirect('/people/index', navigate:true);
    }

    public function updateImage($imageDataUrl)
    {
        $this->image = $imageDataUrl;
    }
}
