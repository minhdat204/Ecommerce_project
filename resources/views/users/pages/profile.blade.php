@extends('users.layouts.layout')

@section('content')
<div class="container mt-5">
    <!-- Tabs -->
    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="information-tab" data-bs-toggle="tab" data-bs-target="#information" type="button" role="tab" aria-controls="information" aria-selected="true">
                Information
            </button>
        </li>
    </ul>

    <div class="tab-content mt-4" id="profileTabsContent">
        <form method="POST" action="{{ route('profile.update', $user->id_nguoidung) }}">
            @csrf
            <!-- Information Tab -->
            <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="information-tab">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="profile-picture">
                                    <img src="{{ asset($user->avatar ?? 'images/anh1.png') }}" alt="Profile Picture" class="img-fluid rounded-circle" width="150">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="hoten" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="hoten" name="hoten" value="{{ $user->hoten }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="userId" class="form-label">ID</label>
                                        <input type="text" class="form-control" id="id_nguoidung" name="id_nguoidung" value="{{ $user->id_nguoidung }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-select" id="gioitinh" name="gioitinh">
                                            <option value="male" {{ $user->gioitinh == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ $user->gioitinh == 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="language" class="form-label">Language</label>
                                        <select class="form-select" id="language">
                                            <option selected>Select Language</option>
                                            <option value="english">English</option>
                                            <option value="vietnamese">Vietnamese</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="diachi" name="diachi" value="{{ $user->diachi }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="sodienthoai" name="sodienthoai" value="{{ $user->sodienthoai }}">
                                    </div>
                                </div>
                                <div class="my-email-address border p-3 rounded">
                                    <h5>My Email Address</h5>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-envelope me-2 text-primary" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <p class="mb-0">{{ $user->email }}</p>
                                            <small class="text-muted">Updated 1 month ago</small>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-secondary btn-sm mt-2">+ Add Email Address</button>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="text-end mt-4">
                            <button class="btn btn-primary">Edit</button>
                        </div> -->
                    </div>
                </div>

                <!-- Dòng kẻ ngang ở trên các nút -->
                <hr class="my-4">

                <div class="d-flex justify-content-center mt-4">
                    <button class="btn btn-lg me-3 btn-hover-shadow rounded-pill px-5 btn-order">Your Order</button>
                    <button class="btn btn-danger btn-lg me-3 btn-hover-shadow rounded-pill px-5">Favorite List</button>
                    <button class="btn btn-success btn-lg btn-hover-shadow rounded-pill px-5">Score List</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
