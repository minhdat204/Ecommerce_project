@extends('Admin.Layout.Layout')

@section('namepage', 'Chi tiết sản phẩm')

@section('content')
    <div class="container">
        <h2>Chi Tiết Sản Phẩm</h2>
        <table class="table table-bordered table-responsive">
            <tr>
                <th style="width: 20%;">ID</th>
                <td>{{ $product->id_sanpham }}</td>
            </tr>
            <tr>
                <th>Tên Sản Phẩm</th>
                <td>{{ $product->tensanpham }}</td>
            </tr>
            <tr>
                <th>Mô Tả</th>
                <td>{{ $product->mota }}</td>
            </tr>
            <tr>
                <th>Thông Tin Kỹ Thuật</th>
                <td>{{ $product->thongtin_kythuat }}</td>
            </tr>
            <tr>
                <th>Giá</th>
                <td>{{ number_format($product->gia, 0, ',', '.') }} VNĐ</td>
            </tr>
            <tr>
                <th>Giá Khuyến Mãi</th>
                <td>{{ number_format($product->gia_khuyen_mai, 0, ',', '.') }} VNĐ</td>
            </tr>
            <tr>
                <th>Đơn Vị Tính</th>
                <td>{{ $product->donvitinh }}</td>
            </tr>
            <tr>
                <th>Xuất Xứ</th>
                <td>{{ $product->xuatxu }}</td>
            </tr>
            <tr>
                <th>Trạng Thái</th>
                <td>
                    @if ($product->trangthai == 'active')
                        <span class="label label-success">Hoạt Động</span>
                    @else
                        <span class="label label-danger">Không Hoạt Động</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Lượt Xem</th>
                <td>{{ $product->luotxem }}</td>
            </tr>
            <tr>
                <th>Danh Mục</th>
                <td>{{ $product->category ? $product->category->tendanhmuc : 'Chưa có danh mục' }}</td>
            </tr>
            <tr>
                <th>Hình Ảnh</th>
                <td>
                    @foreach ($product->images as $productImage)
                        <img src="{{ asset('storage/' . $productImage->duongdan) }}" alt="{{ $productImage->alt }}"
                            width="100">
                    @endforeach
                </td>
            </tr>
        </table>
        <a href="{{ route('admin.product.index') }}" class="btn btn-primary">Quay Lại</a>
    </div>
@endsection
