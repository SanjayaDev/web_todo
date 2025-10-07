<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';

  private function get_roles()
  {
    return Role::query()
    ->where("id", ">", 1)
    ->orderBy('created_at', 'DESC')
    ->paginate(10);
  }

  public function render()
  {
    $data = [
      'roles' => $this->get_roles(),
    ];

    return view('livewire.admin.roles.index', $data);
  }
}
