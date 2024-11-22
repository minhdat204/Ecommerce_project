<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nguoi_dung', function (Blueprint $table) {
            $table->id('id_nguoidung');
            $table->string('tendangnhap', 50)->unique();
            $table->string('matkhau');
            $table->string('email', 100)->unique();
            $table->string('sodienthoai', 20)->nullable();
            $table->text('diachi')->nullable();
            $table->string('hoten', 100);
            $table->enum('gioitinh', ['male', 'female'])->nullable();
            $table->date('ngaysinh')->nullable();
            $table->string('avatar', 255)->nullable();
            $table->enum('loai_nguoidung', ['user', 'admin'])->default('user');
            $table->enum('trangthai', ['active', 'inactive'])->default('active');
            $table->datetime('email_verified_at')->nullable();
            $table->timestamps();
        });

        Schema::create('danh_muc', function (Blueprint $table) {
            $table->id('id_danhmuc');
            $table->foreignId('id_danhmuc_cha')->nullable()->constrained('danh_muc', 'id_danhmuc')->onDelete('set null');
            $table->string('tendanhmuc', 100);
            $table->string('slug', 120)->unique();
            $table->text('mota')->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->enum('trangthai', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('san_pham', function (Blueprint $table) {
            $table->id('id_sanpham');
            $table->foreignId('id_danhmuc')->constrained('danh_muc', 'id_danhmuc');
            $table->string('tensanpham');
            $table->string('slug')->unique();
            $table->text('mota')->nullable();
            $table->text('thongtin_kythuat')->nullable();
            $table->decimal('gia', 15, 2);
            $table->decimal('gia_khuyen_mai', 15, 2)->nullable();
            $table->string('donvitinh', 50);
            $table->string('xuatxu')->nullable();
            $table->integer('soluong')->default(0);
            $table->enum('trangthai', ['active', 'inactive'])->default('active');
            $table->integer('luotxem')->default(0);
            $table->timestamps();
        });

        Schema::create('hinh_anh_san_pham', function (Blueprint $table) {
            $table->id('id_hinhanh');
            $table->foreignId('id_sanpham')->constrained('san_pham', 'id_sanpham')->onDelete('cascade');
            $table->string('duongdan');
            $table->string('alt')->nullable();
            $table->integer('vitri')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('gio_hang', function (Blueprint $table) {
            $table->id('id_giohang');
            $table->foreignId('id_nguoidung')->constrained('nguoi_dung', 'id_nguoidung')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('san_pham_gio_hang', function (Blueprint $table) {
            $table->id('id_sp_giohang');
            $table->foreignId('id_giohang')->constrained('gio_hang', 'id_giohang')->onDelete('cascade');
            $table->foreignId('id_sanpham')->constrained('san_pham', 'id_sanpham')->onDelete('cascade');
            $table->integer('soluong')->default(1);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('don_hang', function (Blueprint $table) {
            $table->id('id_donhang');
            $table->foreignId('id_nguoidung')->constrained('nguoi_dung', 'id_nguoidung');
            $table->string('ma_don_hang', 50)->unique();
            $table->decimal('tong_tien_hang', 15, 2);
            $table->decimal('tong_giam_gia', 15, 2)->default(0);
            $table->decimal('phi_van_chuyen', 15, 2)->default(0);
            $table->decimal('tong_thanh_toan', 15, 2);
            $table->enum('pt_thanhtoan', ['cod', 'momo']);
            $table->enum('trangthai_thanhtoan', ['pending', 'paid', 'failed'])->default('pending');
            $table->text('dia_chi_giao');
            $table->string('ten_nguoi_nhan', 100);
            $table->string('sdt_nhan', 20);
            $table->text('ghi_chu')->nullable();
            $table->enum('trangthai', ['pending', 'confirmed', 'processing', 'shipping', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });

        Schema::create('chi_tiet_don_hang', function (Blueprint $table) {
            $table->id('id_chitiet_donhang');
            $table->foreignId('id_donhang')->constrained('don_hang', 'id_donhang')->onDelete('cascade');
            $table->foreignId('id_sanpham')->constrained('san_pham', 'id_sanpham');
            $table->integer('soluong');
            $table->decimal('gia', 15, 2);
            $table->decimal('giam_gia', 15, 2)->default(0);
            $table->decimal('thanh_tien', 15, 2);
        });

        Schema::create('binh_luan', function (Blueprint $table) {
            $table->id('id_binhluan');
            $table->foreignId('id_sanpham')->constrained('san_pham', 'id_sanpham')->onDelete('cascade');
            $table->foreignId('id_nguoidung')->constrained('nguoi_dung', 'id_nguoidung');
            $table->integer('danhgia')->nullable()->check('danhgia between 1 and 5');
            $table->text('noidung')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('binh_luan', 'id_binhluan')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('bai_viet', function (Blueprint $table) {
            $table->id('id_baiviet');
            $table->string('tieude');
            $table->string('slug')->unique();
            $table->text('noidung');
            $table->foreignId('id_tacgia')->constrained('nguoi_dung', 'id_nguoidung');
            $table->string('thumbnail')->nullable();
            $table->integer('luotxem')->default(0);
            $table->timestamps();
        });

        Schema::create('san_pham_yeu_thich', function (Blueprint $table) {
            $table->id('id_yeuthich');
            $table->foreignId('id_nguoidung')->constrained('nguoi_dung', 'id_nguoidung')->onDelete('cascade');
            $table->foreignId('id_sanpham')->constrained('san_pham', 'id_sanpham')->onDelete('cascade');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('lien_he', function (Blueprint $table) {
            $table->id('id_lienhe');
            $table->foreignId('id_nguoidung')->nullable()->constrained('nguoi_dung', 'id_nguoidung')->onDelete('set null');
            $table->string('ten', 100);
            $table->string('email', 100);
            $table->string('sodienthoai', 20)->nullable();
            $table->text('noidung');
            $table->enum('trangthai', ['new', 'processing', 'resolved'])->default('new');
            $table->timestamps();
        });

        Schema::create('phien_chat', function (Blueprint $table) {
            $table->id('id_phienchat');
            $table->foreignId('id_nguoidung')->constrained('nguoi_dung', 'id_nguoidung');
            $table->foreignId('id_admin')->nullable()->constrained('nguoi_dung', 'id_nguoidung')->onDelete('set null');
            $table->string('tieu_de')->nullable();
            $table->datetime('batdau')->useCurrent();
            $table->datetime('ketthuc')->nullable();
            $table->enum('trangthai', ['active', 'closed'])->default('active');
        });

        Schema::create('tin_nhan', function (Blueprint $table) {
            $table->id('id_tinnhan');
            $table->foreignId('id_phienchat')->constrained('phien_chat', 'id_phienchat')->onDelete('cascade');
            $table->foreignId('id_nguoigui')->constrained('nguoi_dung', 'id_nguoidung');
            $table->text('noidung');
            $table->string('file_dinh_kem')->nullable();
            $table->datetime('thoigian')->useCurrent();
            $table->enum('trangthai', ['sent', 'seen'])->default('sent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tin_nhan');
        Schema::dropIfExists('phien_chat');
        Schema::dropIfExists('lien_he');
        Schema::dropIfExists('san_pham_yeu_thich');
        Schema::dropIfExists('bai_viet');
        Schema::dropIfExists('binh_luan');
        Schema::dropIfExists('chi_tiet_don_hang');
        Schema::dropIfExists('don_hang');
        Schema::dropIfExists('san_pham_gio_hang');
        Schema::dropIfExists('gio_hang');
        Schema::dropIfExists('hinh_anh_san_pham');
        Schema::dropIfExists('san_pham');
        Schema::dropIfExists('danh_muc');
        Schema::dropIfExists('nguoi_dung');
    }
};
