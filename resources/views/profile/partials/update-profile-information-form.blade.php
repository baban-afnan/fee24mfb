<!-- Container-fluid starts -->
<div class="container-fluid">
  <div class="edit-profile">
    <div class="row">

     <!-- Left Column: Password Update -->
<div class="col-xl-4">
  <div class="card">
    <div class="card-header card-no-border pb-0">
      <h3 class="card-title mb-0">My Profile</h3>
      <div class="card-options">
        <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
        <a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
      </div>
    </div>

    <div class="card-body">
 {{-- Display user info --}}
<div class="row mb-4">
  <div class="profile-title">
    <div class="d-flex align-items-center gap-3 p-3 bg-white rounded shadow-sm">
      <img class="img-70 rounded-circle border border-2 shadow-sm"
           src="{{ Auth::user()->photo }}"
           alt="User Photo"
           style="object-fit: cover; width: 70px; height: 70px;" />

      <div class="flex-grow-1">
        <h4 class="mb-0 fw-bold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h4>
        <p class="text-muted mb-0">Account Role, {{ Auth::user()->role }}!</p>
      </div>
    </div>
  </div>
</div>


      {{-- Password Update Form --}}
      <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        @if (session('status') === 'password-updated')
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ Password updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if ($errors->updatePassword->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
              @foreach ($errors->updatePassword->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="mb-3">
          <label for="current_password" class="form-label">Current Password</label>
          <input type="password"
                 class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                 id="current_password" name="current_password" required>
          @error('current_password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">New Password</label>
          <input type="password"
                 class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                 id="password" name="password" required>
          @error('password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Confirm New Password</label>
          <input type="password"
                 class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                 id="password_confirmation" name="password_confirmation" required>
          @error('password_confirmation', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </div>
      </form>
    </div>
  </div>
</div>


   <!-- Right Column: Edit Profile -->
<div class="col-xl-8">
    <form method="POST" action="{{ route('profile.update') }}" class="card" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <!-- Card Header -->
        <div class="card-header card-no-border pb-0">
            <h3 class="card-title mb-0">Edit Profile</h3>
            <div class="card-options">
                <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse">
                    <i class="fe fe-chevron-up"></i>
                </a>
                <a class="card-options-remove" href="#" data-bs-toggle="card-remove">
                    <i class="fe fe-x"></i>
                </a>
            </div>
        </div>

        <!-- Show success message -->
        @if (session('status') === 'profile-updated')
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                ✅ Profile updated successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Show error message -->
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ❌ {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Show validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Card Body -->
        <div class="card-body">
            <div class="row">
                <!-- Phone Number -->
                <div class="col-md-5">
                    <div class="mb-3">
                        <label class="form-label">Phone No:</label>
                        <input class="form-control" type="text" name="phone_no" id="phone_no"
                               placeholder="08012345678" minlength="11" maxlength="11"
                               value="{{ old('phone_no', Auth::user()->phone_no ?? '') }}" required>
                    </div>
                </div>

                <!-- BVN -->
                <div class="col-sm-6 col-md-3">
                    <div class="mb-3">
                        <label class="form-label">BVN ID</label>
                        <input class="form-control" type="text" name="bvn" id="bvn"
                               placeholder="22123456789" minlength="11" maxlength="11"
                               value="{{ old('bvn', Auth::user()->bvn ?? '') }}" required>
                    </div>
                </div>

                <!-- NIN -->
                <div class="col-sm-6 col-md-4">
                    <div class="mb-3">
                        <label class="form-label">NIN ID</label>
                        <input class="form-control" type="text" name="nin" id="nin"
                               placeholder="10123456789" minlength="11" maxlength="11"
                               value="{{ old('nin', Auth::user()->nin ?? '') }}" required>
                    </div>
                </div>

                <!-- Address -->
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input class="form-control" type="text" name="address"
                               placeholder="Home Address"
                               value="{{ old('address', Auth::user()->address ?? '') }}" required>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email" name="email"
                               value="{{ old('email', Auth::user()->email) }}"
                               @if (old('email', Auth::user()->email)) readonly @endif>
                    </div>
                </div>

                <!-- Profile Photo Upload -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Profile Photo</label>
                        <input type="file" name="photo" class="form-control" onchange="this.nextElementSibling.innerText = this.files[0]?.name">
                        <small class="form-text text-muted"></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        @php
            $user = Auth::user();
            $isUpdated = $user->name && $user->email && $user->phone_no && $user->bvn && $user->nin && $user->address;
        @endphp

        @if (!$isUpdated)
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary w-100">Update Account</button>
            </div>
        @else
            <div class="card-footer text-center">
                <span class="text-success fw-bold">✅ Profile already updated.</span>
            </div>
        @endif
    </form>
</div>
