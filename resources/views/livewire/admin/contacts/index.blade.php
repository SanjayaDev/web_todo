<div>

  <div class="mb-4">
    <button class="btn btn-success btn-sm" wire:click="openModal">
      <i class="fa-solid fa-plus me-1"></i> Tambah Kontak
    </button>
  </div>

  <!-- Table -->
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th width="50">#</th>
              <th>Nama</th>
              <th>Tipe Kontak</th>
              <th>Telepon</th>
              <th width="150">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($contacts as $index => $contact)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $contact->name }}</td>
                <td>
                  <span class="badge bg-info">{{ $contact->contactType->name }}</span>
                </td>
                <td>{{ $contact->phone ?? '-' }}</td>
                <td>
                  <button wire:click="edit({{ $contact->id }})" class="btn btn-warning btn-sm">
                    <i class="fa-solid fa-edit"></i>
                  </button>
                  <button wire:click="confirmDelete({{ $contact->id }})" class="btn btn-danger btn-sm">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">
                  <i class="fa-solid fa-address-book fa-3x mb-3 d-block"></i>
                  <p>Belum ada kontak</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal Create/Edit -->
  @if($showModal)
  <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $isEdit ? 'Edit Kontak' : 'Tambah Kontak Baru' }}</h5>
          <button type="button" class="btn-close" wire:click="closeModal"></button>
        </div>

        <div class="modal-body">
          <form wire:submit.prevent="save">

            <div class="form-group mb-3">
              <label>Tipe Kontak <span class="text-danger">*</span></label>
              <select wire:model="contact_type_id" class="form-select @error('contact_type_id') is-invalid @enderror">
                <option value="">Pilih Tipe Kontak</option>
                @foreach($contactTypes as $type)
                  <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
              </select>
              @error('contact_type_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
              <label>Nama <span class="text-danger">*</span></label>
              <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama kontak">
              @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
              <label>Telepon</label>
              <input type="text" wire:model="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Masukkan nomor telepon">
              @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-success btn-sm">{{ $isEdit ? 'Update' : 'Tambah' }} Kontak</button>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" wire:click="closeModal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  @endif

</div>
