<?php

namespace App\Livewire\Admin\Notes;

use App\Models\Note;
use App\Models\Project;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Index extends Component
{
  public $projects;
  public $notes;
  public $selectedProjectId = '';

  // Form properties
  public $showModal = false;
  public $showDetailModal = false;
  public $noteId;
  public $project_id;
  public $title;
  public $content;
  public $isEdit = false;

  // Edit inline
  public $editingTitle = false;
  public $editingContent = false;
  public $tempTitle;
  public $tempContent;

  protected $rules = [
    'project_id' => 'required|exists:projects,id',
    'title' => 'required|string|max:255',
    'content' => 'required|string',
  ];

  public function mount()
  {
    $this->loadProjects();
    $this->loadNotes();
  }

  public function updatedSelectedProjectId()
  {
    $this->loadNotes();
  }

  private function loadProjects()
  {
    $this->projects = Project::orderBy('project_name')->get();
  }

  private function loadNotes()
  {
    $query = Note::with('project')->orderBy('created_at', 'DESC');

    if ($this->selectedProjectId) {
      $query->where('project_id', $this->selectedProjectId);
    }

    $this->notes = $query->get();
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

  public function save()
  {
    $this->validate();

    if ($this->isEdit) {
      $note = Note::findOrFail($this->noteId);
      $note->update([
        'project_id' => $this->project_id,
        'title' => $this->title,
        'content' => $this->content,
      ]);

      LivewireAlert::title('Catatan berhasil diperbarui!')->success()->show();
    } else {
      Note::create([
        'project_id' => $this->project_id,
        'title' => $this->title,
        'content' => $this->content,
      ]);

      LivewireAlert::title('Catatan berhasil ditambahkan!')->success()->show();
    }

    $this->showModal = false;
    $this->resetForm();
    $this->loadNotes();
  }

  public function viewDetail($id)
  {
    $note = Note::with('project')->findOrFail($id);
    $this->noteId = $note->id;
    $this->project_id = $note->project_id;
    $this->title = $note->title;
    $this->tempTitle = $note->title;
    $this->content = $note->content;
    $this->tempContent = $note->content;
    $this->showDetailModal = true;
    $this->editingTitle = false;
    $this->editingContent = false;
  }

  public function closeDetailModal()
  {
    $this->showDetailModal = false;
    $this->editingTitle = false;
    $this->editingContent = false;
  }

  public function enableTitleEdit()
  {
    $this->editingTitle = true;
  }

  public function updateTitle()
  {
    $this->validate(['title' => 'required|string|max:255']);

    $note = Note::findOrFail($this->noteId);
    $note->update(['title' => $this->title]);

    $this->tempTitle = $this->title;
    $this->editingTitle = false;
    $this->loadNotes();
  }

  public function cancelTitleEdit()
  {
    $this->title = $this->tempTitle;
    $this->editingTitle = false;
  }

  public function enableContentEdit()
  {
    $this->editingContent = true;
  }

  public function updateContent()
  {
    $this->validate(['content' => 'required|string']);

    $note = Note::findOrFail($this->noteId);
    $note->update(['content' => $this->content]);

    $this->editingContent = false;
    $this->tempContent = $this->content;
    $this->loadNotes();
  }

  public function cancelContentEdit()
  {
    $this->content = $this->tempContent;
    $this->editingContent = false;
  }

  public function confirmDelete($id)
  {
    $this->noteId = $id;

    LivewireAlert::title('Yakin ingin menghapus catatan ini?')
      ->asConfirm()
      ->onConfirm('delete')
      ->show();
  }

  public function delete()
  {
    Note::findOrFail($this->noteId)->delete();
    LivewireAlert::title('Catatan berhasil dihapus!')->success()->show();
    $this->noteId = null;
    $this->loadNotes();

    if ($this->showDetailModal) {
      $this->closeDetailModal();
    }
  }

  private function resetForm()
  {
    $this->noteId = null;
    $this->project_id = '';
    $this->title = '';
    $this->content = '';
    $this->resetErrorBag();
  }

  public function render()
  {
    return view('livewire.admin.notes.index');
  }
}
