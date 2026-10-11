@extends('adminlte::page')

@section('title', 'เพิ่มช่างใหม่ - IT BARBER')

@section('css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap');

        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f4f6f9;
        }

        .card-custom {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
            margin-top: 30px;
        }

        .card-header-gold {
            background: linear-gradient(135deg, #c5a059 0%, #a68549 100%);
            color: white;
            border-radius: 20px 20px 0 0 !important;
            padding: 25px;
        }

        .form-label {
            font-size: 1.1rem;
            font-weight: 600;
            color: #444;
            margin-bottom: 10px;
        }

        .form-control-lg, .form-select-lg {
            border-radius: 12px;
            font-size: 1.1rem;
            padding: 12px 20px;
            border: 2px solid #eee;
            background-color: #fcfcfc;
        }

        .form-control-lg:focus, .form-select-lg:focus {
            border-color: #c5a059;
            box-shadow: 0 0 0 0.25rem rgba(197, 160, 89, 0.1);
            background-color: #fff;
        }

        .btn-save {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 15px;
            font-size: 1.2rem;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-save:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(40, 167, 69, 0.3);
            color: white;
        }

        /* ส่วนแสดงรูปตัวอย่าง */
        #image-preview-container {
            width: 180px;
            height: 180px;
            border: 3px dashed #ddd;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0 auto 20px;
            background-color: #f9f9f9;
        }

        #image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .upload-placeholder {
            text-align: center;
            color: #aaa;
        }
    </style>
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card card-custom">
                <div class="card-header card-header-gold">
                    <h3 class="mb-0 font-weight-bold"><i class="fas fa-user-plus mr-2"></i> เพิ่มช่างตัดผมใหม่</h3>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.barbers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <label class="form-label d-block">รูปโปรไฟล์ช่าง</label>
                                <div id="image-preview-container">
                                    <img id="image-preview" src="#" alt="Preview">
                                    <div class="upload-placeholder">
                                        <i class="fas fa-camera fa-3x mb-2"></i>
                                        <p class="small mb-0">คลิกเลือกรูป</p>
                                    </div>
                                </div>
                                <input type="file" name="image" id="image-input" class="form-control mb-4" accept="image/*" style="display: none;">
                                <button type="button" class="btn btn-outline-secondary btn-sm mb-4" onclick="document.getElementById('image-input').click();">
                                    <i class="fas fa-folder-open mr-1"></i> เลือกไฟล์รูปภาพ
                                </button>
                            </div>

                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label class="form-label"><i class="fas fa-user text-muted mr-2"></i>ชื่อ-นามสกุล</label>
                                    <input type="text" name="name" class="form-control form-control-lg" placeholder="เช่น ช่างบิ๊กกี้" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label"><i class="fas fa-award text-muted mr-2"></i>ตำแหน่ง</label>
                                    <select name="position" class="form-select form-select-lg" required style="width: 100%; height: 60px;">
                                        <option value="FOUNDER">FOUNDER</option>
                                        <option value="MASTER BARBER" selected>MASTER BARBER</option>
                                        <option value="SENIOR BARBER">SENIOR BARBER</option>
                                        <option value="BARBER">BARBER</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label"><i class="fas fa-star text-muted mr-2"></i>ความถนัด (Specialty)</label>
                                    <input type="text" name="specialty" class="form-control form-control-lg" placeholder="เช่น Skin Fade, Hair Tattoo">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label"><i class="fas fa-store text-muted mr-2"></i>สาขาที่ประจำ</label>
                                    <input type="text" name="branch" class="form-control form-control-lg" placeholder="เช่น สาขาหลัก (สยาม)" required>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('admin.barbers.index') }}" class="btn btn-outline-secondary btn-block py-3" style="border-radius: 15px; font-weight: 600;">
                                    <i class="fas fa-arrow-left mr-2"></i> ยกเลิกและย้อนกลับ
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <button type="submit" class="btn btn-save btn-block shadow-lg">
                                    <i class="fas fa-save mr-2"></i> บันทึกข้อมูลช่าง
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
    <script>
        // ระบบ Preview รูปภาพก่อนอัปโหลด
        document.getElementById('image-input').onchange = evt => {
            const [file] = document.getElementById('image-input').files
            if (file) {
                document.getElementById('image-preview').src = URL.createObjectURL(file);
                document.getElementById('image-preview').style.display = 'block';
                document.querySelector('.upload-placeholder').style.display = 'none';
            }
        }
    </script>
@stop
