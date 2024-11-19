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
        <!-- <li class="nav-item" role="presentation">
            <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="orders" aria-selected="false">
                Orders
            </button>
        </li> -->
    </ul>

    <div class="tab-content mt-4" id="profileTabsContent">
        <!-- Information Tab -->
        <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="information-tab">
            <div class="row">
                <div class="col-md-4 text-center">
                <div class="profile-picture">
                <img src="{{ asset('avatar.jpg') }}" alt="Profile Picture">
                <button>
                    <i class="bi bi-camera"></i>
                </button>
            </div>

                </div>
                <div class="col-md-8">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullName" placeholder="Your First Name">
                            </div>
                            <div class="col-md-6">
                                <label for="userId" class="form-label">ID</label>
                                <input type="text" class="form-control" id="userId" placeholder="Your ID">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender">
                                    <option selected>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
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
                                <input type="text" class="form-control" id="address" placeholder="Your Address">
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" placeholder="Your Phone Number">
                            </div>
                        </div>
                    </form>
                    <div class="my-email-address">
                        <h5>My email Address</h5>
                        <p>
                            <i class="bi bi-envelope"></i> mygmail@gmail.com <br>
                            <small>1 month ago</small>
                        </p>
                        <button class="btn btn-outline-secondary btn-sm">+ Add Email Address</button>
                    </div>
                </div>
            </div>
            <div class="text-end mt-4">
                <button class="btn btn-primary">Edit</button>
            </div>

    <!-- Dòng kẻ ngang ở trên các nút -->
    <hr class="my-4">

    <div class="d-flex justify-content-center mt-4">
        <button class="btn btn-lg me-3 btn-hover-shadow rounded-pill px-5 btn-order">Your Order</button>
        <button class="btn btn-danger btn-lg me-3 btn-hover-shadow rounded-pill px-5">Favorite List</button>
        <button class="btn btn-success btn-lg btn-hover-shadow rounded-pill px-5">Score List</button>
    </div>

        <!-- Orders Tab
        <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
            <p>Orders content goes here...</p>
        </div> -->
    </div>
</div>
@endsection
