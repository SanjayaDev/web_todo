<div>

  <div class="mb-3 d-flex justify-content-between align-items-center">
    <button class="btn btn-success btn-sm" wire:click="openModal">Tambah Project</button>
    <input type="text" wire:model.live="search" class="form-control" style="max-width: 300px;" placeholder="Cari project...">
  </div>

  <div class="card">
    <div class="card-body">

      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>Project</th>
            <th>Keterangan</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($projects as $index => $item)
            <tr>
              <td>{{ $projects->firstItem() + $index }}</td>
              <td>{{ $item->project_name }}</td>
              <td>{{ $item->description ?? '-' }}</td>
              <td>{{ $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('j F Y') : '-' }}</td>
              <td>{{ $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('j F Y') : '-' }}</td>
              <td>
                <button wire:click="edit({{ $item->id }})" class="btn btn-sm btn-warning">
                  <i class="fa-solid fa-edit"></i>
                </button>
                <button wire:click="confirmDelete({{ $item->id }})" class="btn btn-sm btn-danger">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center">Data tidak ditemukan</td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-3">
        {!! $projects->links() !!}
      </div>

    </div>
  </div>

  <!-- Modal Form -->
  @if($showModal)
  <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">{{ $isEdit ? 'Edit Project' : 'Tambah Project Baru' }}</h4>
          <button type="button" class="btn-close" wire:click="closeModal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

          <form wire:submit.prevent="save">

            <div class="form-group mb-3">
              <label>Nama Project <span class="text-danger">*</span></label>
              <input type="text" wire:model="project_name" class="form-control @error('project_name') is-invalid @enderror" placeholder="Masukkan nama project">
              @error('project_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
              <label>Deskripsi</label>
              <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Masukkan deskripsi project"></textarea>
              @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
              <label>Tanggal Mulai</label>
              <input type="date" wire:model="start_date" class="form-control @error('start_date') is-invalid @enderror">
              @error('start_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
              <label>Tanggal Selesai</label>
              <input type="date" wire:model="end_date" class="form-control @error('end_date') is-invalid @enderror">
              @error('end_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-success btn-sm">{{ $isEdit ? 'Update' : 'Tambah' }} Project</button>
          </form>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" wire:click="closeModal">Close</button>
        </div>

      </div>
    </div>
  </div>
  @endif

</div>
