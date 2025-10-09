<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return $this->view('admin.schedules.index', 'Kalendar', [], TRUE);
  }
}
