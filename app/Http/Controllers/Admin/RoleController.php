<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return $this->view('admin.roles.index', 'Roles Management', [], TRUE);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(RoleRequest $request)
  {
    $values = $request->validated();
    $role = Role::create($values);

    $response = response_success_default("Berhasil menambahkan role baru!", $role->id, route('admin.roles.show', $role->id));
    return response_json($response);
  }

  /**
   * Display the specified resource.
   */
  public function show(Role $role)
  {
    $data = [
      'role' => $role,
    ];

    return $this->view('admin.roles.show', 'Detail Role', $data);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(RoleRequest $request, Role $role)
  {
    $values = $request->validated();
    $role->update($values);

    $response = response_success_default("Berhasil memperbarui data role!", $role->id, route('admin.roles.show', $role->id));
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
