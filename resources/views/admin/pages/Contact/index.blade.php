@extends('Admin.Layout.Layout')
@section('namepage', 'Quản lý Liên Hệ')
@section('content')
    <div >
        <div class="table-wrapper">
            @if (session('success'))
                <div class="alert alert
            -success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Quản lý <b>Liên Hệ</b></h2>
                    </div>
                </div>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Liên Hệ </th>
                        <th>Email</th>
                        <th>Số Điện Thoại</th>
                        <th>Nội Dung</th>
                        <th>Trạng Thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $index => $contact)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $contact->ten ?? 'Không xác định' }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->sodienthoai }}</td>
                            <td>{{ $contact->noidung }}</td>
                            <td>
                                @if ($contact->trangthai == 'new')
                                    <div style="color:Tomato;">Chưa phản hồi</div>
                                @elseif($contact->trangthai == 'processing')
                                    <div style="color:Tomato;">Chưa phản hồi</div>
                                @elseif($contact->trangthai == 'resolved')
                                    <div style="color:green;">Đã phản hồi</div>
                                @endif

                            </td>
                            <td>
                                <!-- Nút Xóa -->
                                <a href="#" class="delete" data-toggle="modal"
                                    data-target="#deleteContactModal{{ $contact->id_lienhe }}">
                                    <i class="material-icons" data-toggle="tooltip" title="Xóa">&#xE872;</i>
                                </a>
                                <a href="" class="edit" data-toggle="modal"
                                    data-target="#editContactModal{{ $contact->id_lienhe }}">
                                    <i class="material-icons" data-toggle="tooltip" title="Chỉnh sửa">&#xE254;</i>
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Xóa Liên Hệ -->
                        <div id="deleteContactModal{{ $contact->id_lienhe }}" class="modal fade" tabindex="-1"
                            role="dialog" aria-labelledby="deleteContactModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form id="deleteContactForm{{ $contact->id_lienhe }}"
                                        action="{{ route('admin.contact.destroy', $contact->id_lienhe) }}" method="POST">
                                        @csrf
                                        @method('DELETE') <!-- Phương thức DELETE -->
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteContactModalLabel">Xóa liên hệ</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có chắc chắn muốn xóa liên hệ này?</p>
                                            <p class="text-warning"><small>Hành động này không thể hoàn tác.</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Hủy</button>
                                            <button type="submit" class="btn btn-danger">Xóa</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Chỉnh Sửa Trạng Thái -->
                        <div id="editContactModal{{ $contact->id_lienhe }}" class="modal fade" tabindex="-1"
                            role="dialog" aria-labelledby="editContactModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form id="editContactForm{{ $contact->id_lienhe }}"
                                        action="{{ route('admin.contact.update', $contact->id_lienhe) }}" method="POST">
                                        @csrf
                                        @method('PUT') <!-- Phương thức PUT -->
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editContactModalLabel">Chỉnh sửa trạng thái</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Chọn trạng thái mới cho liên hệ này:</p>
                                            <div class="form-group">
                                                <label for="trangthai">Trạng thái:</label>
                                                <select name="trangthai" id="trangthai" class="form-control">
                                                    <option value="processing"
                                                        {{ $contact->trangthai == 'processing' ? 'selected' : '' }}>Chưa
                                                        phản hồi</option>
                                                    <option value="resolved"
                                                        {{ $contact->trangthai == 'resolved' ? 'selected' : '' }}>Đã phản
                                                        hồi</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Hủy</button>
                                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>

            <!-- Phân trang -->
            <div class="clearfix">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
@endsection
