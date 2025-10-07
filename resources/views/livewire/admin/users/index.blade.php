<div>

  @if (check_authorized("002B"))
    <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm mb-3">Buat User Baru</a>
  @endif

  <div class="card">
    <div class="card-body">

      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Jabatan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($users as $item)
            <tr>
              <td>{{ $item->name }}</td>
              <td>{{ $item->email }}</td>
              <td>{{ $item->role->role_name }}</td>
              <td>
                @if (check_authorized("003D") && ($item->role_id != 1 || auth()->user()->role_id == 1 || ($item->role_id == 1 && auth()->user()->id == $item->id)))
                  <a href="{{ route('admin.users.edit', $item->id) }}" class="btn btn-sm btn-primary m-1">Edit</a>
                @endif
                @if (check_authorized("003C"))
                  <a href="{{ route('admin.users.show', $item->id) }}" class="btn btn-sm btn-info m-1">Detail</a>
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
        {!! $users->links() !!}
      </div>

    </div>
  </div>

</div>
