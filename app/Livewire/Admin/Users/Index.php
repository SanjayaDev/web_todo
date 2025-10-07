<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';

  private function get_users()
  {
    return User::query()
    ->with(["role"])
    ->orderBy('created_at', 'DESC')
    ->paginate(10);
  }

  public function render()
  {
    $data = [
      "users" => $this->get_users()
    ];

    return view('livewire.admin.users.index', $data);
  }
}
