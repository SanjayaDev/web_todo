<?php

namespace App\Livewire\Admin\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Index extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';

  public $search = '';
  public $projectId;
  public $project_name;
  public $description;
  public $start_date = NULL;
  public $end_date = NULL;
  public $isEdit = false;
  public $showModal = false;

  protected $rules = [
    'project_name' => 'required|string|max:255',
    'description' => 'nullable|string',
    'start_date' => 'nullable|date',
    'end_date' => 'nullable|date',
  ];

  public function updatingSearch()
  {
    $this->resetPage();
  }

  private function get_projects()
  {
    return Project::query()
      ->when($this->search, function($query) {
        $query->where('project_name', 'like', '%' . $this->search . '%');
      })
      ->orderBy('created_at', 'DESC')
      ->paginate(10);
  }

  public function openModal()
  {
    $this->resetForm();
    $this->isEdit = false;
    $this->showModal = true;
  }

  public function closeModal()
  {
    $this->showModal = false;
    $this->resetForm();
  }

  public function edit($id)
  {
    $project = Project::findOrFail($id);
    $this->projectId = $project->id;
    $this->project_name = $project->project_name;
    $this->description = $project->description;
    $this->start_date = $project->start_date;
    $this->end_date = $project->end_date;
    $this->isEdit = true;
    $this->showModal = true;
  }

  public function save()
  {
    $this->validate();

    if ($this->isEdit) {
      $project = Project::findOrFail($this->projectId);
      $project->update([
        'project_name' => $this->project_name,
        'description' => $this->description ?? NULL,
        'start_date' => $this->start_date ?? NULL,
        'end_date' => $this->end_date ?? NULL,
      ]);

      LivewireAlert::title('Project berhasil diperbarui!')->success()->show();
    } else {
      Project::create([
        'project_name' => $this->project_name,
        'description' => $this->description ?? NULL,
        'start_date' => $this->start_date ?? NULL,
        'end_date' => $this->end_date ?? NULL,
      ]);

      LivewireAlert::title('Project berhasil ditambahkan!')->success()->show();
    }

    $this->showModal = false;
    $this->resetForm();
  }

  public function confirmDelete($id)
  {
    $this->projectId = $id;

    LivewireAlert::title('Yakin ingin menghapus project ini?')
      ->asConfirm()
      ->onConfirm('delete')
      ->show();
  }

  public function delete()
  {
    Project::findOrFail($this->projectId)->delete();
    LivewireAlert::title('Project berhasil dihapus!')->success()->show();
    $this->projectId = null;
  }

  private function resetForm()
  {
    $this->projectId = null;
    $this->project_name = '';
    $this->description = NULL;
    $this->start_date = NULL;
    $this->end_date = NULL;
    $this->resetErrorBag();
  }

  public function render()
  {
    $data = [
      'projects' => $this->get_projects(),
    ];

    return view('livewire.admin.projects.index', $data);
  }
}
