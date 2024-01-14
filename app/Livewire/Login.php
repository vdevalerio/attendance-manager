<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;

    public function render()
    {
        return view('livewire.login');
    }

    public function loginUser(Request $request)
    {
        $validated = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt($validated))
        {
            $request->session()->regenerate();

            return $this->redirect('/home', navigate:true);
        }

        $this->addError('email', 'The credentials provided doesn\'t match the records.');
    }
}
