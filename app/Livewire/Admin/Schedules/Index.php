<?php

namespace App\Livewire\Admin\Schedules;

use App\Models\Project;
use App\Models\Schedule;
use Carbon\Carbon;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Index extends Component
{
  public $currentMonth;
  public $currentYear;
  public $calendarDays = [];

  // Modal daily info
  public $showDailyModal = false;
  public $selectedDate;
  public $dailySchedules = [];

  // Modal form
  public $showFormModal = false;
  public $scheduleId;
  public $project_id;
  public $title;
  public $description;
  public $scheduled_at;
  public $time_start;
  public $time_end;
  public $isEdit = false;

  protected function rules()
  {
    return [
      'project_id' => 'nullable|integer',
      'title' => 'required|string|max:255',
      'description' => 'nullable|string',
      'scheduled_at' => 'required|date',
      'time_start' => 'nullable',
      'time_end' => 'nullable',
    ];
  }

  public function mount()
  {
    $this->currentMonth = now()->month;
    $this->currentYear = now()->year;
    $this->generateCalendar();
  }

  public function previousMonth()
  {
    $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
    $this->currentMonth = $date->month;
    $this->currentYear = $date->year;
    $this->generateCalendar();
  }

  public function nextMonth()
  {
    $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
    $this->currentMonth = $date->month;
    $this->currentYear = $date->year;
    $this->generateCalendar();
  }

  private function getProjects()
  {
    return Project::orderBy('project_name')->get();
  }

  private function getSchedules()
  {
    $startDate = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfMonth();
    $endDate = Carbon::create($this->currentYear, $this->currentMonth, 1)->endOfMonth();

    return Schedule::with('project')
      ->whereBetween('scheduled_at', [$startDate, $endDate])
      ->orderBy('scheduled_at')
      ->orderBy('time_start')
      ->get()
      ->groupBy('scheduled_at');
  }

  private function generateCalendar()
  {
    $firstDay = Carbon::create($this->currentYear, $this->currentMonth, 1);
    $daysInMonth = $firstDay->daysInMonth;
    $startDayOfWeek = $firstDay->dayOfWeek; // 0 = Sunday, 6 = Saturday

    $this->calendarDays = [];

    // Empty cells before first day
    for ($i = 0; $i < $startDayOfWeek; $i++) {
      $this->calendarDays[] = ['day' => null, 'date' => null];
    }

    // Days in month
    for ($day = 1; $day <= $daysInMonth; $day++) {
      $date = Carbon::create($this->currentYear, $this->currentMonth, $day)->format('Y-m-d');
      $this->calendarDays[] = ['day' => $day, 'date' => $date];
    }
  }

  public function openDailyModal($date)
  {
    $this->selectedDate = $date;
    $this->dailySchedules = Schedule::with('project')
      ->where('scheduled_at', $date)
      ->orderBy('time_start')
      ->get();
    $this->showDailyModal = true;
  }

  public function closeDailyModal()
  {
    $this->showDailyModal = false;
    $this->selectedDate = null;
    $this->dailySchedules = [];
  }

  public function openFormModal($date = null)
  {
    $this->resetForm();
    if ($date) {
      $this->scheduled_at = $date;
    }
    $this->isEdit = false;
    $this->showFormModal = true;
  }

  public function edit($id)
  {
    $schedule = Schedule::findOrFail($id);
    $this->scheduleId = $schedule->id;
    $this->project_id = $schedule->project_id;
    $this->title = $schedule->title;
    $this->description = $schedule->description;
    $this->scheduled_at = $schedule->scheduled_at;
    $this->time_start = $schedule->time_start;
    $this->time_end = $schedule->time_end;
    $this->isEdit = true;
    $this->showFormModal = true;
  }

  public function closeFormModal()
  {
    $this->showFormModal = false;
    $this->resetForm();
  }

  public function save()
  {
    $this->validate();

    $data = [
      'project_id' => $this->project_id ?: null,
      'title' => $this->title,
      'description' => $this->description,
      'scheduled_at' => $this->scheduled_at,
      'time_start' => $this->time_start ?: null,
      'time_end' => $this->time_end ?: null,
    ];

    if ($this->isEdit) {
      $schedule = Schedule::findOrFail($this->scheduleId);
      $schedule->update($data);

      LivewireAlert::title('Jadwal berhasil diperbarui!')->success()->show();
    } else {
      Schedule::create($data);

      LivewireAlert::title('Jadwal berhasil ditambahkan!')->success()->show();
    }

    $this->showFormModal = false;
    $this->resetForm();

    // Reopen daily modal if it was open
    if ($this->selectedDate) {
      $this->openDailyModal($this->selectedDate);
    }
  }

  public function confirmDelete($id)
  {
    $this->scheduleId = $id;

    LivewireAlert::title('Yakin ingin menghapus jadwal ini?')
      ->asConfirm()
      ->onConfirm('delete')
      ->show();
  }

  public function delete()
  {
    Schedule::findOrFail($this->scheduleId)->delete();
    LivewireAlert::title('Jadwal berhasil dihapus!')->success()->show();
    $this->scheduleId = null;

    // Refresh daily modal if it's open
    if ($this->selectedDate) {
      $this->dailySchedules = Schedule::with('project')
        ->where('scheduled_at', $this->selectedDate)
        ->orderBy('time_start')
        ->get();
    }
  }

  private function resetForm()
  {
    $this->scheduleId = null;
    $this->project_id = null;
    $this->title = '';
    $this->description = '';
    $this->scheduled_at = '';
    $this->time_start = '';
    $this->time_end = '';
    $this->resetErrorBag();
  }

  public function render()
  {
    return view('livewire.admin.schedules.index', [
      'projects' => $this->getProjects(),
      'schedules' => $this->getSchedules(),
    ]);
  }
}
