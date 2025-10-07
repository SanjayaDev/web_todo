<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Livewire\Admin\Index as IndexDashboard;

use \App\Livewire\Admin\Users\Index as IndexUsers;

use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', Login::class)->name('login');

Route::middleware("auth")->group(function() {
  Route::get("/app/dashboard", DashboardController::class)->name('admin.dashboard.index');

  // Start User Management
  Route::get("/app/users", [UserController::class, "index"])->name('admin.users.index')->middleware("check_auth:002A");
  Route::get("/app/users/create", [UserController::class, "create"])->name('admin.users.create')->middleware("check_auth:002B");
  Route::post("/app/users", [UserController::class, "store"])->name('admin.users.store')->middleware("check_auth:002B");
  Route::get("/app/users/{user}", [UserController::class, "show"])->name('admin.users.show')->middleware("check_auth:002C");
  Route::get("/app/users/{user}/edit", [UserController::class, "edit"])->name('admin.users.edit')->middleware("check_auth:002D");
  Route::put("/app/users/{user}", [UserController::class, "update"])->name('admin.users.update')->middleware("check_auth:002D");
  // End User Management

  // Start role Management
  Route::get("/app/roles", [RoleController::class, "index"])->name('admin.roles.index')->middleware("check_auth:003A");
  Route::post("/app/roles", [RoleController::class, "store"])->name('admin.roles.store')->middleware("check_auth:003B");
  Route::get("/app/roles/{role}", [RoleController::class, "show"])->name('admin.roles.show')->middleware("check_auth:003C");
  Route::put("/app/roles/{role}", [RoleController::class, "update"])->name('admin.roles.update')->middleware("check_auth:003D");
  // End role Management

  // Start Project Management
  Route::get("/app/projects", [ProjectController::class, "index"])->name('admin.projects.index');
  // End Project Management

  // Start Note Management
  Route::get("/app/notes", [NoteController::class, "index"])->name('admin.notes.index');
  Route::post("/app/notes", [NoteController::class, "store"])->name('admin.notes.store');
  Route::put("/app/notes/{note}", [NoteController::class, "update"])->name('admin.notes.update');
  Route::delete("/app/notes/{note}", [NoteController::class, "destroy"])->name('admin.notes.destroy');
  // End Note Management
});