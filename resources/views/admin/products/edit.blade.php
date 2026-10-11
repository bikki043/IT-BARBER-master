@extends('adminlte::page')

@section('title', 'แก้ไขสินค้า | IT BARBER')

@section('content_header')
    <div class="container-fluid animate__animated animate__fadeIn">
        <div class="row mb-3">
            <div class="col-sm-6">
                <h1 class="m-0 text-bold text-dark" style="font-size: 1.8rem;">
                    <i class="fas fa-edit mr-2 text-warning"></i>แก้ไขข้อมูลสินค้า
                </h1>
                <p class="text-muted small">จัดการรายละเอียดและรูปภาพสินค้าให้เป็นปัจจุบัน</p>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.products.index') }}" class="btn btn-light px-4 shadow-sm" style="border-radius: 10px; border: 1px solid #ddd;">
                    <i class="fas fa-arrow-left mr-1"></i> ย้อนกลับ
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid animate__animated animate__fadeInUp">
        <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row no-gutters">
                    {{-- ฝั่งข้อมูลสินค้า (ซ้าย) --}}
                    <div class="col-lg-8 bg-white p-4 p-md-5">
                        <div class="d-flex align-items-center mb-4">
                            <i class="fas fa-info-circle text-warning mr-2" style="font-size: 1.2rem;"></i>
                            <h5 class="text-bold m-0">รายละเอียดข้อมูลพื้นฐาน</h5>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-4">
                                    <label class="text-muted small text-bold text-uppercase">ชื่อสินค้า <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control custom-input"
                                        value="{{ $product->name }}" placeholder="กรุณาระบุชื่อสินค้า" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label class="text-muted small text-bold text-uppercase">ราคาขาย (THB) <span class="text-danger">*</span></label>
                                    <input type="number" name="price" class="form-control custom-input"
                                        value="{{ $product->price }}" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="text-muted small text-bold text-uppercase">หมวดหมู่สินค้า</label>
                                    <select name="cat" class="form-control custom-input">
                                        <option value="Clippers" {{ $product->cat == 'Clippers' ? 'selected' : '' }}>Clippers</option>
                                        <option value="Scissors" {{ $product->cat == 'Scissors' ? 'selected' : '' }}>Scissors</option>
                                        <option value="Hair Care" {{ $product->cat == 'Hair Care' ? 'selected' : '' }}>Hair Care</option>
                                        <option value="Essentials" {{ $product->cat == 'Essentials' ? 'selected' : '' }}>Essentials</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label class="text-muted small text-bold text-uppercase">รายละเอียดสินค้าอย่างย่อ</label>
                                    <textarea name="description" class="form-control custom-input" rows="5"
                                        placeholder="ระบุข้อมูลเพิ่มเติมเกี่ยวกับสินค้า...">{{ $product->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ฝั่งจัดการรูปภาพ (ขวา) --}}
                    <div class="col-lg-4 p-4 p-md-5" style="background: #fcfcfc; border-left: 1px solid #f0f0f0;">
                        <div class="d-flex align-items-center mb-4">
                            <i class="fas fa-images text-warning mr-2" style="font-size: 1.2rem;"></i>
                            <h5 class="text-bold m-0">จัดการรูปภาพ</h5>
                        </div>

                        {{-- รูปภาพหลัก --}}
                        <div class="text-center mb-4">
                            <label class="d-block text-muted small mb-2 text-left text-bold">รูปภาพหน้าปก (Main)</label>
                            <div class="main-upload-box shadow-sm mx-auto" onclick="document.getElementById('imgInput').click();">
                                <img id="previewImg"
                                    src="{{ str_starts_with($product->img, 'http') ? $product->img : asset('storage/' . $product->img) }}"
                                    class="img-fit-cover">
                                <div class="upload-overlay">
                                    <i class="fas fa-camera fa-2x"></i>
                                    <span class="d-block mt-2">เปลี่ยนรูปหลัก</span>
                                </div>
                            </div>
                            <input type="file" name="image_file" id="imgInput" class="d-none" onchange="previewFile(this, 'previewImg')">
                        </div>

                        <div class="row">
                            {{-- รูปประกอบ 2 --}}
                            <div class="col-6">
                                <label class="x-small text-muted mb-1 text-bold">รูปประกอบ 2</label>
                                <div class="sub-upload-box shadow-sm mb-2" onclick="document.getElementById('imgInput2').click();">
                                    <img id="previewImg2"
                                        src="{{ $product->img2 ? asset('storage/' . $product->img2) : 'https://via.placeholder.com/150?text=Upload' }}"
                                        class="img-fit-cover">
                                    <div class="upload-overlay-small"><i class="fas fa-plus"></i></div>
                                </div>
                                <input type="file" name="image_file2" id="imgInput2" class="d-none" onchange="previewFile(this, 'previewImg2')">
                            </div>
                            {{-- รูปประกอบ 3 --}}
                            <div class="col-6">
                                <label class="x-small text-muted mb-1 text-bold">รูปประกอบ 3</label>
                                <div class="sub-upload-box shadow-sm mb-2" onclick="document.getElementById('imgInput3').click();">
                                    <img id="previewImg3"
                                        src="{{ $product->img3 ? asset('storage/' . $product->img3) : 'https://via.placeholder.com/150?text=Upload' }}"
                                        class="img-fit-cover">
                                    <div class="upload-overlay-small"><i class="fas fa-plus"></i></div>
                                </div>
                                <input type="file" name="image_file3" id="imgInput3" class="d-none" onchange="previewFile(this, 'previewImg3')">
                            </div>
                        </div>

                        <div class="alert alert-light mt-4 border-0 p-3" style="border-radius: 12px; background: #f0f0f0;">
                            <small class="text-muted"><i class="fas fa-lightbulb mr-1 text-warning"></i> <b>Tip:</b> แนะนำรูปทรงสี่เหลี่ยมจัตุรัสเพื่อให้การแสดงผลหน้าเว็บสวยงามที่สุด</small>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top p-4 d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        <i class="fas fa-history mr-1"></i> อัปเดตล่าสุดเมื่อ: {{ $product->updated_at->diffForHumans() }}
                    </div>
                    <button type="submit" class="btn btn-black btn-lg px-5 shadow-lg" style="border-radius: 12px;">
                        <i class="fas fa-save mr-2 text-warning"></i> บันทึกและอัปเดตข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap');

        body { font-family: 'Kanit', sans-serif; background-color: #f4f7f6; }

        /* การปรับแต่ง Input */
        .custom-input {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1.5px solid #ebebeb;
            background-color: #fafafa;
            transition: all 0.3s ease;
        }
        .custom-input:focus {
            border-color: #ffc107;
            background-color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.1);
        }

        /* ปุ่มสีดำแบบเว็บ Modern */
        .btn-black {
            background: #1a1a1a;
            color: #fff;
            border: none;
            transition: all 0.3s;
        }
        .btn-black:hover {
            background: #000;
            color: #ffc107;
            transform: translateY(-2px);
        }

        /* กล่องอัปโหลดรูปภาพ */
        .main-upload-box {
            width: 100%;
            max-width: 280px;
            height: 280px;
            border-radius: 20px;
            border: 2px dashed #ddd;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            transition: 0.3s;
        }
        .sub-upload-box {
            width: 100%;
            height: 120px;
            border-radius: 15px;
            border: 1px dashed #ddd;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            transition: 0.3s;
        }
        .main-upload-box:hover, .sub-upload-box:hover { border-color: #ffc107; }

        .img-fit-cover { width: 100%; height: 100%; object-fit: cover; }

        /* Overlay เวลาเอาเมาส์ชี้รูป */
        .upload-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); color: #fff; display: flex; flex-direction: column;
            align-items: center; justify-content: center; opacity: 0; transition: 0.3s;
        }
        .upload-overlay-small {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(255, 193, 7, 0.7); color: #000; display: flex;
            align-items: center; justify-content: center; opacity: 0; transition: 0.3s;
        }
        .main-upload-box:hover .upload-overlay, .sub-upload-box:hover .upload-overlay-small { opacity: 1; }

        .x-small { font-size: 0.75rem; }
    </style>
@stop

@section('js')
    <script>
        // ฟังก์ชันสำหรับ Preview รูปภาพทันทีที่เลือกไฟล์
        function previewFile(input, previewId) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@stop
