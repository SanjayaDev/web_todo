<div>

  <button class="btn btn-success btn-sm mb-3" onclick="CORE.showModal('modalCreateRole')">Buat Jabatan Baru</button>

  <div class="card">
    <div class="card-body">

      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Jabatan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($roles as $item)
            <tr>
              <td>{{ $item->role_name }}</td>
              <td>
                @if ($item->id > 1)
                  <a href="{{ route('admin.roles.show', $item->id) }}" class="btn btn-sm btn-info m-1">Detail</a>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center">Data tidak ditemukan</td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-3">
        {!! $roles->links() !!}
      </div>

    </div>
  </div>

  <div class="modal fade" id="modalCreateRole">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Jabatan Baru</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          
          <form action="{{ route('admin.roles.store') }}" method="POST" with-submit-crud>
            @csrf

            <div class="form-group">
              <label>Jabatan</label>
              <input type="text" name="role_name" class="form-control" placeholder="Masukkan nama jabatan">
            </div>

            <button class="btn btn-success btn-sm mt-3">Tambah Jabatan</button>
          </form>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

</div>
