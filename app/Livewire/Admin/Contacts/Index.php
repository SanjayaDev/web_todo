<?php

namespace App\Livewire\Admin\Contacts;

use App\Models\Contact;
use App\Models\ContactType;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Index extends Component
{

  public $contactTypes;
  public $contacts;

  // Form properties
  public $showModal = false;
  public $contactId;
  public $contact_type_id;
  public $name;
  public $phone;
  public $isEdit = false;

  protected $rules = [
    'contact_type_id' => 'required|exists:contact_types,id',
    'name' => 'required|string|max:255',
    'phone' => 'nullable|string|max:20',
  ];

  public function mount()
  {
    $this->loadContactTypes();
    $this->loadContacts();
  }

  private function loadContactTypes()
  {
    $this->contactTypes = ContactType::orderBy('name')->get();
  }

  private function loadContacts()
  {
    $this->contacts = Contact::with('contactType')->orderBy('created_at', 'DESC')->get();
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
      $contact = Contact::findOrFail($this->contactId);
      $contact->update([
        'contact_type_id' => $this->contact_type_id,
        'name' => $this->name,
        'phone' => $this->phone,
      ]);

      LivewireAlert::title('Kontak berhasil diperbarui!')->success()->show();
    } else {
      Contact::create([
        'contact_type_id' => $this->contact_type_id,
        'name' => $this->name,
        'phone' => $this->phone,
      ]);

      LivewireAlert::title('Kontak berhasil ditambahkan!')->success()->show();
    }

    $this->showModal = false;
    $this->resetForm();
    $this->loadContacts();
  }

  public function edit($id)
  {
    $contact = Contact::findOrFail($id);
    $this->contactId = $contact->id;
    $this->contact_type_id = $contact->contact_type_id;
    $this->name = $contact->name;
    $this->phone = $contact->phone;
    $this->isEdit = true;
    $this->showModal = true;
  }

  public function confirmDelete($id)
  {
    $this->contactId = $id;

    LivewireAlert::title('Yakin ingin menghapus kontak ini?')
      ->asConfirm()
      ->onConfirm('delete')
      ->show();
  }

  public function delete()
  {
    Contact::findOrFail($this->contactId)->delete();
    LivewireAlert::title('Kontak berhasil dihapus!')->success()->show();
    $this->contactId = null;
    $this->loadContacts();
  }

  private function resetForm()
  {
    $this->contactId = null;
    $this->contact_type_id = '';
    $this->name = '';
    $this->phone = '';
    $this->resetErrorBag();
  }

  public function render()
  {
    return view('livewire.admin.contacts.index');
  }
}
