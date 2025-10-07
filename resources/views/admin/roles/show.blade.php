@extends('layouts.admin.app')

@section('content')
    
  <div class="card">
    <div class="card-body">

      <button class="btn btn-info btn-sm mb-3" onclick="CORE.showModal('modalEditRole')">Edit</button>

      <table class="table">
        <tr>
          <th>Jabatan</th>
          <td>: {{ $role->role_name }}</td>
        </tr>
      </table>

    </div>
  </div>

  @if (check_authorized("003E"))
    <div class="card">
      <div class="card-body">

        @livewire('admin.roles.asign-module', ['role' => $role])

      </div>
    </div>
  @endif

  <div class="modal fade" id="modalEditRole">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Jabatan</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

          <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" with-submit-crud>
            @csrf
            @method('PUT')

            <div class="form-group">
              <label>Jabatan</label>
              <input type="text" name="role_name" class="form-control" placeholder="Masukkan nama jabatan" value="{{ $role->role_name }}">
            </div>

            <button class="btn btn-success btn-sm mt-3">Update Jabatan</button>
          </form>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

@endsection