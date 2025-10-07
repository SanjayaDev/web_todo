<div class="row">
  <div class="col-md-6 my-3">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" class="form-control" id="name" name="name" value="{{ $user->name ?? '' }}" placeholder="Masukan nama" autocomplete="off" required>
    </div>
  </div>
  <div class="col-md-6 my-3">
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control" id="email" name="email" value="{{ $user->email ?? '' }}" placeholder="Masukan email" autocomplete="off" required>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6 my-3">
    <div class="form-group">
      <label for="name">Jabatan</label>
      <select name="role_id" id="role_id" class="form-control" required>
        <option value="">Pilih Jabatan</option>
        @foreach($roles as $role)
          <option value="{{ $role->id }}" {{ (isset($user) && $user->role_id == $role->id) ? 'selected' : '' }}>{{ $role->role_name }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="col-md-6 my-3">
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Masukan password">
    </div>
  </div>
</div>