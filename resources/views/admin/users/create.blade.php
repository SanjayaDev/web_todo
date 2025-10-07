@extends('layouts.admin.app')

@section('content')
    
  <div class="card">
    <div class="card-body">

      <form action="{{ route('admin.users.store') }}" method="POST" with-submit-crud>
        @csrf

        @include('admin.users.form')

        <button class="btn btn-success btn-sm">Buat User Baru</button>

      </form>

    </div>
  </div>

@endsection