@extends('adminlte::page')

@section('title', 'โปรไฟล์ของฉัน')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-bold" style="font-family: 'Kanit', sans-serif;"><i
                        class="fas fa-id-card-alt mr-2 text-warning"></i>การตั้งค่าโปรไฟล์</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f4f6f9;
        }

        .card {
            border-radius: 15px !important;
            border: none !important;
        }

        .profile-user-img {
            border: 4px solid #fff !important;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .profile-user-img:hover {
            transform: scale(1.05);
        }

        .btn-warning {
            background-color: #c5a059 !important;
            border-color: #c5a059 !important;
            color: #fff !important;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-warning:hover {
            background-color: #a68549 !important;
            filter: brightness(90%);
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
        }

        .nav-pills .nav-link.active {
            background-color: #c5a059 !important;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            {{-- ส่วนที่ 1: การ์ดโปรไฟล์ (Responsive: มือถือเต็มจอ, คอม 1/3) --}}
            <div class="col-lg-4 col-md-5">
                <div class="card card-outline card-warning shadow-sm mb-4">
                    <div class="card-body box-profile py-4">
                        <div class="text-center position-relative">
                            @php
                                $profileImg = $user->image_path
                                    ? asset('storage/' . $user->image_path) . '?v=' . time()
                                    : 'https://ui-avatars.com/api/?name=' .
                                        urlencode($user->name) .
                                        '&background=c5a059&color=fff&size=150';
                            @endphp
                            <img id="profile-preview" class="profile-user-img img-fluid img-circle"
                                src="{{ $profileImg }}" style="width: 140px; height: 140px; object-fit: cover;"
                                alt="User profile picture">
                            <div class="mt-3">
                                <h3 class="profile-username text-center font-weight-bold mb-0">{{ $user->name }}</h3>
                                <p class="text-muted text-center small"><i class="fas fa-shield-alt text-warning mr-1"></i>
                                    ผู้ดูแลระบบสูงสุด</p>
                            </div>
                        </div>

                        <ul class="list-group list-group-unbordered my-3">
                            <li class="list-group-item border-top-0 px-2">
                                <small class="text-muted font-weight-bold">อีเมลติดต่อ</small>
                                <p class="mb-0 text-dark">{{ $user->email }}</p>
                            </li>
                            <li class="list-group-item px-2 border-bottom-0">
                                <small class="text-muted font-weight-bold">ลงทะเบียนเมื่อ</small>
                                <p class="mb-0 text-dark">{{ $user->created_at->translatedFormat('d F Y') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- ส่วนที่ 2: ฟอร์มแก้ไข (Responsive: มือถือเต็มจอ, คอม 2/3) --}}
            <div class="col-lg-8 col-md-7">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white p-3">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="#"><i
                                        class="fas fa-user-edit mr-2"></i>ข้อมูลพื้นฐาน</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data"
                            id="profileForm">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ชื่อ-นามสกุล <span class="text-danger">*</span></label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $user->name) }}" placeholder="เช่น สมชาย ใจดี" required>
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ที่อยู่อีเมล <span class="text-danger">*</span></label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $user->email) }}" placeholder="admin@example.com"
                                            required>
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-2">
                                <label>เปลี่ยนรูปโปรไฟล์</label>
                                <div class="custom-file">
                                    <input type="file" name="image_file" class="custom-file-input" id="image_file"
                                        accept="image/*">
                                    <label class="custom-file-label" for="image_file">เลือกไฟล์รูปภาพใหม่...</label>
                                </div>
                            </div>

                            <hr class="my-4">
                            <h5 class="text-bold mb-3"><i class="fas fa-key mr-2 text-muted"></i>ความปลอดภัย (รหัสผ่าน)</h5>

                            <div class="row">
                                {{-- ช่องรหัสผ่านใหม่ --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>รหัสผ่านใหม่</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="ปล่อยว่างไว้ถ้าไม่ต้องการเปลี่ยน" autocomplete="new-password">
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="togglePassword('password')"
                                                    style="cursor: pointer;">
                                                    <i class="fas fa-eye" id="eye-password"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @error('password')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- ช่องยืนยันรหัสผ่าน --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ยืนยันรหัสผ่านใหม่</label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" id="password_confirmation"
                                                class="form-control" placeholder="กรอกรหัสผ่านอีกครั้ง"
                                                autocomplete="new-password">
                                            <div class="input-group-append">
                                                <span class="input-group-text"
                                                    onclick="togglePassword('password_confirmation')"
                                                    style="cursor: pointer;">
                                                    <i class="fas fa-eye" id="eye-password_confirmation"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="alert alert-info bg-light border-0 small mt-2">
                                        <i class="fas fa-info-circle mr-1 text-info"></i>
                                        หากพี่ไม่ต้องการเปลี่ยนรหัสผ่าน ให้ **"เว้นว่าง"** ทั้งสองช่องนี้ไว้ครับ
                                        ระบบจะใช้รหัสเดิมโดยอัตโนมัติ
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-warning btn-block btn-lg shadow">
                                    <i class="fas fa-save mr-2"></i> บันทึกการเปลี่ยนแปลง
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            // อัปเดตชื่อไฟล์และพรีวิวรูป
            $("#image_file").change(function() {
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $("#profile-preview").attr("src", e.target.result);
                    };
                    reader.readAsDataURL(file);
                    $(this).next('.custom-file-label').html(file.name);
                }
            });

            // ป๊อปอัพยืนยันก่อนส่งข้อมูล
            $('#profileForm').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'ยืนยันการบันทึก?',
                    text: "ข้อมูลโปรไฟล์ของคุณจะถูกอัปเดตทันที",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#c5a059',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'ตกลง, บันทึกเลย',
                    cancelButtonText: 'ยกเลิก',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'กำลังประมวลผล...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        this.submit();
                    }
                });
            });

            // ป๊อปอัพแจ้งเตือนสำเร็จ
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#c5a059',
                    timer: 2000
                });
            @endif
        });
    </script>
@stop

