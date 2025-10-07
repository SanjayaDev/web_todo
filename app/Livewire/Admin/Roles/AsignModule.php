<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Module;
use App\Models\ModuleRole;
use App\Models\Role;
use Livewire\Component;

class AsignModule extends Component
{
  public $role;
  public $modules;
  public $modules_header = [];
  public $module_parent;
  public $checked_all = FALSE;

  public function updatedModuleParent()
  {
    $this->checked_all = FALSE;
  }

  public function updatedCheckedAll()
  {
    $role = $this->role;

    if ($this->checked_all) {
      foreach ($this->modules as $module) {
        foreach ($module->childs as $item) {
          $values = [
            "role_id" => $role->id,
            "module_id" => $item->id,
          ];

          ModuleRole::create($values);
        }
      }
    } else {
      foreach ($this->modules as $module) {
        foreach ($module->childs as $item) {
          ModuleRole::query()->where("role_id", $role->id)->where("module_id", $item->id)->delete();
        }
      }
    }
  }

  public function mount()
  {
    $this->modules_header = Module::query()
    ->whereNull("parent_id")
    ->get();
  }

  private function get_modules()
  {
    $role = $this->role;
    $module_parent = $this->module_parent;

    $this->modules = Module::query()
    ->whereNull("parent_id")
    ->with([
      "childs" => function($query) use ($role) {
        return $query->with([
          "roles" => function ($q) use ($role) {
            return $q->where("role_id", $role->id);
          }
        ]);
      }
    ])
    ->get();
  }

  public function check_module(Role $role, Module $module, $checked = FALSE)
  {
    if ($checked) {
      $values = [
        "role_id" => $role->id,
        "module_id" => $module->id,
      ];

      ModuleRole::create($values);
    } else {
      ModuleRole::query()->where("role_id", $role->id)->where("module_id", $module->id)->delete();
    }
  }

  public function render()
  {
    $this->get_modules();
    return view('livewire.admin.roles.asign-module');
  }
}
