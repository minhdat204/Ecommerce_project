@extends('Admin.Layout.Layout')
@section('namepage', 'Dashboard')
@section('css_custom')
<link href="{{ asset('Admin/css/website-info.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="dashboard-container">
        {{-- Statistics Cards --}}
        <div class="stats-container">
            <div class="stat-card products">
                <div class="stat-header">
                    <span class="stat-title">Sản phẩm</span>
                </div>
                <div class="stat-value">{{ $stats['products']['total'] }}</div>
                <div class="stat-details">
                    <span>Đang bán: {{ $stats['products']['active'] }}</span>
                    <span>Ngừng bán: {{ $stats['products']['inactive'] }}</span>
                </div>
            </div>

            <div class="stat-card users">
                <div class="stat-header">
                    <span class="stat-title">Người dùng</span>
                </div>
                <div class="stat-value">{{ $stats['users']['total'] }}</div>
                <div class="stat-details">
                    <span>Mới hôm nay: {{ $stats['users']['new_today'] }}</span>
                    <span>Hoạt động: {{ $stats['users']['active'] }}</span>
                </div>
            </div>

            <div class="stat-card orders">
                <div class="stat-header">
                    <span class="stat-title">Đơn hàng</span>
                </div>
                <div class="stat-value">{{ $stats['orders']['total'] }}</div>
                <div class="stat-details">
                    <span>Chờ xử lý: {{ $stats['orders']['pending'] }}</span>
                    <span>Hoàn thành: {{ $stats['orders']['completed'] }}</span>
                </div>
            </div>
        </div>

        {{-- Website Information --}}
<div class="website-info">
    <div class="info-header d-flex justify-content-between align-items-center">
        <h5>Thông tin Website</h5>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editWebsiteInfoModal">
            <i class="fa fa-edit"></i> Cập nhật
        </button>
    </div>
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Địa chỉ</div>
            <div class="info-value">{{ $websiteInfo->address ?? 'Chưa cập nhật' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Số điện thoại</div>
            <div class="info-value">{{ $websiteInfo->phone ?? 'Chưa cập nhật' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Email liên hệ</div>
            <div class="info-value">{{ $websiteInfo->email ?? 'Chưa cập nhật' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Nội dung</div>
            <div class="info-value">{{ Str::limit($websiteInfo->content ?? 'Chưa cập nhật', 100) }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Link Facebook</div>
            <div class="info-value">
                @if (!empty($websiteInfo->facebook_link))
                    <a href="{{ $websiteInfo->facebook_link }}" target="_blank">{{ $websiteInfo->facebook_link }}</a>
                @else
                    Chưa cập nhật
                @endif
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">Logo</div>
            <div class="info-value">
                @if (!empty($websiteInfo->logo_image))
                    <img src="{{ asset('storage/' . $websiteInfo->logo_image) }}" alt="Logo" style="max-height: 100px;">
                @else
                    Chưa cập nhật
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editWebsiteInfoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.dashboard.update-website-info') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Cập nhật thông tin website</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" class="form-control" name="address"
                               value="{{ $websiteInfo->address ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" class="form-control" name="phone"
                               value="{{ $websiteInfo->phone ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email liên hệ</label>
                        <input type="email" class="form-control" name="email"
                               value="{{ $websiteInfo->email ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Nội dung</label>
                        <textarea class="form-control" name="content" rows="4" required>{{ $websiteInfo->content ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Link Facebook</label>
                        <input type="url" class="form-control" name="facebook_link"
                               value="{{ $websiteInfo->facebook_link ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>Logo</label>
                        @if (!empty($websiteInfo->logo_image))
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $websiteInfo->logo_image) }}" alt="Logo" style="max-height: 100px;">
                            </div>
                        @endif
                        <input type="file" class="form-control-file" name="logo_image" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
