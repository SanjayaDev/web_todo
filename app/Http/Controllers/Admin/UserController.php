<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
  private UserService $service;

  public function __construct()
  {
    $this->service = new UserService();
  }

  /**
   * Display a listing of the resource.
   * 
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
   */
  public function index()
  {
    return $this->view("admin.users.index", "List User", [], TRUE);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $data = [
      "roles" => Role::query()->where("id", ">", 1)->get(),
    ];

    return $this->view("admin.users.create", "Buat User Baru", $data);
  }

  /**
   * Store a newly created resource in storage.
   * 
   * @param \App\Http\Requests\Admin\UserRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(UserRequest $request)
  {
    $response = $this->service->store($request);
    return response_json($response);
  }

  /**
   * Display the specified resource.
   * 
   * @param \App\Models\User $user
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
   */
  public function show(User $user)
  {
    $data = [
      "user" => $user->load("role"),
    ];

    return $this->view("admin.users.show", "Detail User", $data);
  }

  /**
   * Show the form for editing the specified resource.
   * 
   * @param \App\Models\User $user
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
   */
  public function edit(User $user)
  {
    $data = [
      "user" => $user->load("role"),
      "roles" => Role::query()->where("id", ">", 1)->get(),
    ];

    return $this->view("admin.users.edit", "Edit User", $data);
  }

  /**
   * Update the specified resource in storage.
   * 
   * @param \App\Http\Requests\Admin\UserRequest $request
   * @param \App\Models\User $user
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UserRequest $request, User $user)
  {
      $response = $this->service->update($request, $user);
      return response_json($response);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
      //
  }
}
