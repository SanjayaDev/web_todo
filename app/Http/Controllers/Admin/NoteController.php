<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NoteRequest;
use App\Models\Note;
use App\Services\NoteService;
use Illuminate\Http\Request;

class NoteController extends Controller
{
  protected $service;

  public function __construct(NoteService $service)
  {
    $this->service = $service;
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return $this->view('admin.notes.index', 'Catatan', [], TRUE);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(NoteRequest $request)
  {
    $response = $this->service->store($request);
    return response_json($response);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(NoteRequest $request, Note $note)
  {
    $response = $this->service->update($request, $note);
    return response_json($response);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Note $note)
  {
    $response = $this->service->destroy($note);
    return response_json($response);
  }
}
