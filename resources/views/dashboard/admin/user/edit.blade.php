@extends('dashboard.main')
@section('dashboard')
<div class="container-fluid">
  <div class="page-titles mb-7 mb-md-5">
    <div class="row">
      <div class="col-lg-8 col-md-6 col-12 align-self-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb align-items-center">
            <li class="breadcrumb-item">
              <a class="text-muted text-decoration-none">
                <i class="ti ti-home fs-5"></i>
              </a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}" class="text-muted">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
          </ol>
        </nav>
        <h2 class="mb-0 fw-bolder fs-8">Edit User</h2>
      </div>
    </div>
  </div>

  <div class="card card-body">
    <form action="{{ route('user.update', $user->id) }}" method="POST">
      @csrf
      @method('PATCH')

      <div class="mb-3">
        <label for="name" class="form-label">Nama *</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email *</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
      </div>

      <div class="mb-3">
        <label for="role" class="form-label">Role *</label>
        <select name="role" id="role" class="form-control" required>
          <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="cashier" {{ $user->role == 'cashier' ? 'selected' : '' }}>Cashier</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengubah">
      </div>

      <div class="d-flex justify-content-end">
        <a href="{{ route('user.index') }}" class="btn btn-secondary me-2">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
@endsection
