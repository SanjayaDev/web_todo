@extends('layouts.admin.app')

@section('content')
    
  <div class="card">
    <div class="card-body">

      <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info btn-sm">Edit</a>

      <table class="table mt-2">
        <tr>
          <th>Nama</th>
          <td>: {{ $user->name }}</td>
        </tr>
        <tr>
          <th>Email</th>
          <td>: {{ $user->email }}</td>
        </tr>
        <tr>
          <th>Jabatan</th>
          <td>: {{ $user->role->role_name }}</td>
        </tr>
      </table>

    </div>
  </div>

@endsection