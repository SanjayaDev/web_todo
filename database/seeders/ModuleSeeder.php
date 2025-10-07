<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $module_parent = Module::create([
        "module_name" => "Dashboard",
        "module_code" => "001",
      ]);
      Module::create([
        "parent_id" => $module_parent->id,
        "module_name" => "Dapat mengakses dashboard",
        "module_code" => "001A"
      ]);

      $module_parent = Module::create([
        "module_name" => "User Management",
        "module_code" => "002",
      ]);
      Module::create([
        "parent_id" => $module_parent->id,
        "module_name" => "Dapat mengakses halaman list user",
        "module_code" => "002A"
      ]);
      Module::create([
        "parent_id" => $module_parent->id,
        "module_name" => "Dapat membuat user baru",
        "module_code" => "002B"
      ]);
      Module::create([
        "parent_id" => $module_parent->id,
        "module_name" => "Dapat melihat detail user",
        "module_code" => "002C"
      ]);
      Module::create([
        "parent_id" => $module_parent->id,
        "module_name" => "Dapat mengedit user",
        "module_code" => "002D"
      ]);
      
      $module_parent = Module::create([
        "module_name" => "Role Management",
        "module_code" => "003",
      ]);
      Module::create([
        "parent_id" => $module_parent->id,
        "module_name" => "Dapat mengakses halaman list role",
        "module_code" => "003A"
      ]);
      Module::create([
        "parent_id" => $module_parent->id,
        "module_name" => "Dapat membuat role baru",
        "module_code" => "003B"
      ]);
      Module::create([
        "parent_id" => $module_parent->id,
        "module_name" => "Dapat melihat detail role",
        "module_code" => "003C"
      ]);
      Module::create([
        "parent_id" => $module_parent->id,
        "module_name" => "Dapat mengedit role",
        "module_code" => "003D"
      ]);
      Module::create([
        "parent_id" => $module_parent->id,
        "module_name" => "Dapat asign module suatu role",
        "module_code" => "003E"
      ]);
    }
}
