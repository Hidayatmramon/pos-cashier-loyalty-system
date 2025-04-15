@extends('dashboard.main')
@section('dashboard')
    <div class="container-fluid">
        <div class="page-titles mb-7 mb-md-5">
          <div class="row">
            <div class="col-lg-8 col-md-6 col-12 align-self-center">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center">
                  <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" >
                      <i class="ti ti-home fs-5"></i>
                    </a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">User</li>
                </ol>
              </nav>
              <h2 class="mb-0 fw-bolder fs-8">User</h2>
            </div>

          </div>
        </div>
        <div class="widget-content searchable-container list">
          <div class="card card-body">
            <div class="row">
              <div class="col-md-4 col-xl-3">
                
              </div>
              <div
                class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                <a href="{{ route('user.create') }}" id="btn-add-contact" class="btn btn-primary d-flex align-items-center">
                  <i class="ti ti-users text-white me-1 fs-5"></i> Add User
                </a>
              </div>
            </div>
          </div>

          <div class="card card-body">
            <div class="table-responsive">

              <table class="table search-table align-middle text-nowrap">
                <thead class="header-item">

                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Action</th>
                </thead>
                <tbody>
                    @php
                    $i = 1;
                @endphp
                @foreach ($users as $data)
                <tr>
                    <th>{{ $i++ }}</th>
                    <td>
                      <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/dashboard/images/user-2.jpg') }}" alt="avatar" class="rounded-circle"
                          width="35" />
                        <div class="ms-3">
                          <div class="user-meta-info">
                            <h6 class="user-name mb-0">{{ $data->name }}</h6>
                            <span class="user-work fs-3">{{ $data->role }}</span>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="usr-email-addr">{{ $data->email }}</span>
                    </td>

                    <td>
                        <div class="action-btn">
                            <form action="{{ route('user.edit', $data->id) }}" method="get" class="d-inline">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-eye fs-5"></i>
                                </button>
                            </form>

                            <form action="{{ route('user.destroy', $data->id) }}" method="post" class="d-inline">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="ti ti-trash fs-5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                  </tr>
                  @endforeach
                  <!-- end row -->''
                  @if (count($users) == 0)
                  <tr><td colspan="6" class="text-center">Tidak ada user ditemukan</td></tr>
                 @endif


                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
@endsection
