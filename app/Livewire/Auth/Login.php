<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

#[\Livewire\Attributes\Layout('layouts.auth.app')]
class Login extends Component
{
  public $error_login = NULL;
  public $email;
  public $password;

  public function login()
  {
    $this->validate([
      'email'=> 'required|email',
      'password'=> 'required|min:6',
    ]);

    $user = User::where('email', $this->email)->first();
    if (!$user) {
      $this->error_login = 'Email not registered';
      return;
    }

    if (!Hash::check($this->password, $user->password)) {
      $this->error_login = 'Incorrect password';
      return;
    }

    Auth::login($user);
    $this->error_login = FALSE;
    return redirect()->route('admin.dashboard.index');
  }

  public function render()
  {
    return view('livewire.auth.login');
  }
}
