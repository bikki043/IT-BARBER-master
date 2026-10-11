@extends('adminlte::page')

@section('title', 'แก้ไขข้อมูลช่าง | IT BARBER')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap');
        body { font-family: 'Kanit', sans-serif; background: #f4f6f9; }

        /* Card Design */
        .card-edit { 
            border-radius: 30px; 
            border: none; 
            box-shadow: 0 15px 40px rgba(0,0,0,0.1) !important;
            overflow: hidden;
        }
        
        /* Header Section */
        .edit-header {
            background: #1a1a1a;
            color: #c5a059;
            padding: 30px;
            border-bottom: 4px solid #c5a059;
        }

        /* Form Styling */
        .form-label { font-weight: 600; color: #1a1a1a; font-size: 1rem; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; }
        .form-control-custom { 
            border-radius: 15px; 
            height: 55px; 
            font-size: 1.1rem; 
            border: 2px solid #eee;
            background: #fff;
            transition: 0.3s;
        }
        .form-control-custom:focus {
            border-color: #c5a059;
            box-shadow: 0 0 0 0.2rem rgba(197, 160, 89, 0.25);
        }

        /* Buttons */
        .btn-black {
            background: #1a1a1a;
            color: #fff !important;
            border-radius: 15px;
            padding: 12px 35px;
            font-weight: 600;
            border: none;
            transition: 0.3s;
        }
        .btn-black:hover {
            background: #000;
            color: #c5a059 !important;
            transform: translateY(-2px);
        }

        .btn-gold {
            background: linear-gradient(45deg, #a68549, #c5a059);
            color: white !important;
            border-radius: 15px;
            padding: 12px 35px;
            font-size: 1.1rem;
            font-weight: 600;
            border: none;
            box-shadow: 0 10px 20px rgba(166, 133, 73, 0.3);
            transition: 0.3s;
        }
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(166, 133, 73, 0.4);
        }

        /* Image Preview */
        .img-wrapper {
            position: relative;
            display: inline-block;
        }
        .img-holder {
            width: 220px;
            height: 220px;
            object-fit: cover;
            border-radius: 30px;
            border: 5px solid white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transition: 0.3s;
        }
        .upload-badge {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: #c5a059;
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid white;
            font-size: 1.2rem;
        }
    </style>
@stop

@section('content_header')
    <div class="container-fluid pt-4 animate__animated animate__fadeIn">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.barbers.index') }}" class="btn btn-black mr-3 shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="font-weight-bold m-0" style="color: #1a1a1a;">แก้ไขข้อมูลบุคลากร</h1>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid pb-5">
    <div class="card card-edit animate__animated animate__fadeInUp">
        <div class="edit-header">
            <h3 class="m-0 font-weight-bold"><i class="fas fa-user-edit mr-2"></i> โปรไฟล์: {{ $barber->name }}</h3>
        </div>
        
        <div class="card-body p-4 p-md-5">
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 20px;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-triangle mr-2"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.barbers.update', $barber->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- ฝั่งซ้าย: รูปภาพ --}}
                    <div class="col-lg-4 text-center mb-5">
                        <div class="img-wrapper mb-4">
                            <img id="preview" src="{{ $barber->image_path ? asset('storage/' . $barber->image_path) : 'https://via.placeholder.com/220' }}" class="img-holder">
                            <div class="upload-badge"><i class="fas fa-camera"></i></div>
                        </div>
                        
                        <div class="form-group px-md-4">
                            <label class="form-label d-block text-muted">อัปโหลดรูปภาพใหม่</label>
                            <div class="custom-file" style="height: 50px;">
                                <input type="file" name="image" class="custom-file-input h-100" id="imageInput" accept="image/*">
                                <label class="custom-file-label d-flex align-items-center h-100" for="imageInput" style="border-radius: 15px;">เลือกไฟล์...</label>
                            </div>
                            <small class="text-muted mt-3 d-block"><i class="fas fa-info-circle mr-1"></i> รองรับเฉพาะไฟล์ JPG, PNG ขนาดไม่เกิน 2MB</small>
                        </div>
                    </div>

                    {{-- ฝั่งขวา: ข้อมูล --}}
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">ชื่อ-นามสกุล <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0" style="border-radius: 15px 0 0 15px;"><i class="fas fa-user text-warning"></i></span>
                                    </div>
                                    <input type="text" name="name" class="form-control form-control-custom border-left-0" style="border-radius: 0 15px 15px 0;" value="{{ old('name', $barber->name) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">ตำแหน่ง <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0" style="border-radius: 15px 0 0 15px;"><i class="fas fa-id-badge text-warning"></i></span>
                                    </div>
                                    <input type="text" name="position" class="form-control form-control-custom border-left-0" style="border-radius: 0 15px 15px 0;" value="{{ old('position', $barber->position) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">สาขาที่ประจำ</label>
                                <select name="branch" class="form-control form-control-custom">
                                    <option value="สาขาบ้านโป่ง" {{ $barber->branch == 'สาขาบ้านโป่ง' ? 'selected' : '' }}>📍 สาขาบ้านโป่ง</option>
                                    <option value="สาขาในเมือง" {{ $barber->branch == 'สาขาในเมือง' ? 'selected' : '' }}>📍 สาขาในเมือง</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">ความเชี่ยวชาญ</label>
                                <input type="text" name="specialty" class="form-control form-control-custom" placeholder="เช่น ตัดวินเทจ, แกะลาย" value="{{ old('specialty', $barber->specialty) }}">
                            </div>
                        </div>

                        <div class="mt-5 pt-3 d-flex justify-content-end align-items-center">
                            <a href="{{ route('admin.barbers.index') }}" class="text-muted mr-4 font-weight-bold">ยกเลิกการแก้ไข</a>
                            <button type="submit" class="btn btn-gold px-5 shadow-lg">
                                <i class="fas fa-save mr-2"></i> อัปเดตข้อมูลช่าง
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // ระบบ Live Preview รูปภาพ
            $('#imageInput').on('change', function() {
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $('#preview').attr('src', event.target.result);
                    }
                    reader.readAsDataURL(file);
                    
                    // แสดงชื่อไฟล์
                    let fileName = file.name;
                    $(this).next('.custom-file-label').addClass("selected").html(fileName);
                }
            });
        });
    </script>
@stop
