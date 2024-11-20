@extends('users.layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.profile-navigation a');
    const tabPanes = document.querySelectorAll('.profile-tab-pane');
        tabs.forEach((tab, index) => {
            tab.addEventListener('click', function (e) {
                e.preventDefault();

                // Loại bỏ lớp active khỏi tất cả tab và ẩn các pane
                tabs.forEach((t) => t.classList.remove('active'));
                tabPanes.forEach((pane) => pane.style.display = 'none');

                // Thêm lớp active vào tab được nhấn và hiển thị nội dung pane
                tab.classList.add('active');
                tabPanes[index].style.display = 'block';
            });
        });

        // Đảm bảo tab Favorites hiển thị nếu có lỗi khi reload lại
        if (window.location.hash === '#favorites') {
            tabs[1].click();
    }
});
    </script>
@endpush

@section('content')
<div class="container mt-5">
    <!-- Navigation Tabs -->
    <ul class="profile-navigation">
        <li><a href="#" class="active">Personal Info</a></li>
        <li><a href="#">Favorites List</a></li>
    </ul>

    <!-- Tab Content -->
    <div class="profile-content mt-4">
        <!-- Personal Info Tab -->
        <div class="profile-tab-pane" style="display: block;">
            <form method="POST" action="{{ route('profile.update', $user->id_nguoidung) }}">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="profile-avatar">
                                    <img src="{{  asset('img/avatar.jpg') }}" alt="User Avatar" class="img-fluid rounded-circle" width="150">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="user-fullname" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="user-fullname" name="hoten" value="{{ $user->hoten }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="user-id" class="form-label">User ID</label>
                                        <input type="text" class="form-control" id="user-id" name="id_nguoidung" value="{{ $user->id_nguoidung }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="user-gender" class="form-label">Gender</label>
                                        <select class="form-select" id="user-gender" name="gioitinh">
                                            <option value="male" {{ $user->gioitinh == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ $user->gioitinh == 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="user-language" class="form-label">Language</label>
                                        <select class="form-select" id="user-language">
                                            <option selected>Select Language</option>
                                            <option value="english">English</option>
                                            <option value="vietnamese">Vietnamese</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="user-address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="user-address" name="diachi" value="{{ $user->diachi }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="user-phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="user-phone" name="sodienthoai" value="{{ $user->sodienthoai }}">
                                    </div>
                                </div>
                                <div class="email-address-section border p-3 rounded">
                                    <h5>Email Address</h5>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-envelope me-2 text-primary" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <p class="mb-0">{{ $user->email }}</p>
                                            <small class="text-muted">Updated 1 month ago</small>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-secondary btn-sm mt-2">+ Add Email</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

       <!-- Favorites List Tab -->
       <div class="profile-tab-pane" style="display: none;">
    <div class="favorite-page-container">
        <div class="row">
            @forelse ($favorites as $favorite)
                <div class="col-md-4 mb-4">
                    <div class="card">
                    <img src="{{ asset('img/product/'.$favorite->image) }}" class="card-img-top" alt="{{ $favorite->tensanpham }}" style="height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $favorite->tensanpham }}</h5>
                            <p class="card-text text-muted">{{ number_format($favorite->gia, 0, ',', '.') }}đ</p>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-primary">Redeem Again</button>
                                <button class="btn btn-sm btn-secondary">Contact Seller</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">No favorites found ! Thanks </p>
                </div>
            @endforelse
        </div>
    </div>
    <!-- Pagination -->
    <div class="pagination-container mt-4">
        {{ $favorites->links() }}
    </div>
</div>


@endsection
