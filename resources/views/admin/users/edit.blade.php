@extends('layouts.admin.app')

@section('content')
    
  <div class="card">
    <div class="card-body">

      <form action="{{ route('admin.users.update', $user->id) }}" method="POST" with-submit-crud>
        @csrf
        @method("PUT")

        @include('admin.users.form')

        <button class="btn btn-success btn-sm">Update User</button>

      </form>

    </div>
  </div>

@endsection