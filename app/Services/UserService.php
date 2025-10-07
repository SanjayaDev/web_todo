<?php namespace App\Services;

use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService 
{
  /**
   * Store a newly user
   * 
   * @param \App\Http\Requests\Admin\UserRequest $request
   * @return \stdClass
   */
  public function store(UserRequest $request)
  {
    $response = create_response();
    $error = FALSE;

    // Start Database Transaction
    DB::beginTransaction();

    // Let's start!
    try  {
      $values = $request->validated();
      $user = \App\Models\User::create($values);
    } catch (\Exception $e) {
      $error = TRUE;
      if ($e->getCode() == 403) {
        $response->message = $e->getMessage();
        $response->status_code = 403;
      } else {
        $response = response_errors_default();
        insert_log($e, "UserService::store");
      }
    }

    // Final check
    if ($error) {
      // If have error, Rollback database
      DB::rollback();
    } else {
      // Success, commit database and return response success
      DB::commit();
      $response = response_success_default("Berhasil menambahkan user baru!", $user->id, route('admin.users.show', $user->id));
    }

    return $response;
  }

  /**
   * Update the specified user
   * 
   * @param \App\Http\Requests\Admin\UserRequest $request
   * @param \App\Models\User $user
   * @return \stdClass
   */
  public function update(UserRequest $request, User $user)
  {
    $response = create_response();
    $error = FALSE;

    // Start Database Transaction
    DB::beginTransaction();

    // Let's start!
    try  {
      $values = $request->validated();
      if (empty($values['password'])) {
        unset($values['password']);
      }

      User::query()
      ->where('id', $user->id)
      ->update($values);

    } catch (\Exception $e) {
      $error = TRUE;
      if ($e->getCode() == 403) {
        $response->message = $e->getMessage();
        $response->status_code = 403;
      } else {
        $response = response_errors_default();
        insert_log($e, "UserService::update");
      }
    }

    // Final check
    if ($error) {
      // If have error, Rollback database
      DB::rollback();
    } else {
      // Success, commit database and return response success
      DB::commit();
      $response = response_success_default("Berhasil memperbarui user!", $user->id, route('admin.users.show', $user->id));
    }

    return $response;
  }
}