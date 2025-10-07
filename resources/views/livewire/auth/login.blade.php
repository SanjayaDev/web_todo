<div>

  <div class="card-group d-block d-md-flex row">
    <div class="card col-md-7 p-4 mb-0">
      <div class="card-body">
        <h1>Login</h1>
        <p class="text-body-secondary">Sign In to your account</p>

        @if ($error_login)
          <div class="alert alert-danger">
            <svg class="icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-warning"></use>
            </svg>
            <span class="ms-1">{{ $error_login }}</span>
          </div>
        @endif

        <div class="input-group mt-3 mb-3"><span class="input-group-text">
            <svg class="icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
            </svg></span>
          <input class="form-control" type="text" placeholder="Email" wire:model="email">
          @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror
        </div>
        <div class="input-group mb-4"><span class="input-group-text">
            <svg class="icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
            </svg></span>
          <input class="form-control" type="password" placeholder="Password" wire:model="password">
          @error('password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror
        </div>
        <div class="row">
          <div class="col-6">
            <button class="btn btn-primary px-4" type="button" wire:click="login">Login</button>
          </div>
          <div class="col-6 text-end">
            <button class="btn btn-link px-0" type="button">Forgot password?</button>
          </div>
        </div>
      </div>
    </div>
    <div class="card col-md-5 text-white bg-primary py-5">
      <div class="card-body text-center">
        <div>
          <h2>Sign up</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          <button class="btn btn-lg btn-outline-light mt-3" type="button">Register Now!</button>
        </div>
      </div>
    </div>
  </div>

</div>
