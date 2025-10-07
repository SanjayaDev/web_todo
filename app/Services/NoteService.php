<?php namespace App\Services;

use App\Http\Requests\Admin\NoteRequest;
use App\Models\Note;
use Illuminate\Support\Facades\DB;

class NoteService
{
  /**
   * Store a newly note
   *
   * @param \App\Http\Requests\Admin\NoteRequest $request
   * @return \stdClass
   */
  public function store(NoteRequest $request)
  {
    $response = create_response();
    $error = FALSE;

    // Start Database Transaction
    DB::beginTransaction();

    // Let's start!
    try  {
      $values = $request->validated();
      $note = Note::create($values);
    } catch (\Exception $e) {
      $error = TRUE;
      if ($e->getCode() == 403) {
        $response->message = $e->getMessage();
        $response->status_code = 403;
      } else {
        $response = response_errors_default();
        insert_log($e, "NoteService::store");
      }
    }

    // Final check
    if ($error) {
      // If have error, Rollback database
      DB::rollback();
    } else {
      // Success, commit database and return response success
      DB::commit();
      $response = response_success_default("Berhasil menambahkan catatan baru!", $note->id, route('admin.notes.index'));
    }

    return $response;
  }

  /**
   * Update the specified note
   *
   * @param \App\Http\Requests\Admin\NoteRequest $request
   * @param \App\Models\Note $note
   * @return \stdClass
   */
  public function update(NoteRequest $request, Note $note)
  {
    $response = create_response();
    $error = FALSE;

    // Start Database Transaction
    DB::beginTransaction();

    // Let's start!
    try  {
      $values = $request->validated();
      $note->update($values);
    } catch (\Exception $e) {
      $error = TRUE;
      if ($e->getCode() == 403) {
        $response->message = $e->getMessage();
        $response->status_code = 403;
      } else {
        $response = response_errors_default();
        insert_log($e, "NoteService::update");
      }
    }

    // Final check
    if ($error) {
      // If have error, Rollback database
      DB::rollback();
    } else {
      // Success, commit database and return response success
      DB::commit();
      $response = response_success_default("Berhasil memperbarui catatan!", $note->id, route('admin.notes.index'));
    }

    return $response;
  }

  /**
   * Remove the specified note
   *
   * @param \App\Models\Note $note
   * @return \stdClass
   */
  public function destroy(Note $note)
  {
    $response = create_response();
    $error = FALSE;

    // Start Database Transaction
    DB::beginTransaction();

    // Let's start!
    try  {
      $note->delete();
    } catch (\Exception $e) {
      $error = TRUE;
      if ($e->getCode() == 403) {
        $response->message = $e->getMessage();
        $response->status_code = 403;
      } else {
        $response = response_errors_default();
        insert_log($e, "NoteService::destroy");
      }
    }

    // Final check
    if ($error) {
      // If have error, Rollback database
      DB::rollback();
    } else {
      // Success, commit database and return response success
      DB::commit();
      $response = response_success_default("Berhasil menghapus catatan!", null, route('admin.notes.index'));
    }

    return $response;
  }
}
