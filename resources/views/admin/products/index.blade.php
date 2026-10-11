@extends('adminlte::page')

@section('title', 'จัดการสินค้า | IT BARBER')

@section('content_header')
    <div class="container-fluid animate__animated animate__fadeIn">
        <div class="row mb-4 align-items-end">
            <div class="col-sm-6">
                <h1 class="m-0 text-bold text-dark" style="font-size: 1.8rem;">
                    <i class="fas fa-shopping-bag mr-2 text-warning"></i>จัดการสินค้า
                </h1>
                <p class="text-muted mb-0">คลังสินค้าและอุปกรณ์ตัดผมระดับมืออาชีพ</p>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-black shadow px-4 py-2" style="border-radius: 12px;"
                    data-toggle="modal" data-target="#modal-add-product">
                    <i class="fas fa-plus-circle mr-2 text-warning"></i> เพิ่มสินค้าใหม่
                </button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid animate__animated animate__fadeInUp">
        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert bg-black text-warning border-warning alert-dismissible fade show shadow-lg mb-4" role="alert"
                style="border-radius: 15px;">
                <i class="icon fas fa-check-circle mr-2"></i> <strong>สำเร็จ!</strong> {{ session('success') }}
                <button type="button" class="close text-warning" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        {{-- Product Grid --}}
        <div class="row">
            @forelse($products as $product)
                <div class="col-12 col-md-6 col-lg-3 mb-4">
                    <div class="product-card shadow-sm border-0 h-100 bg-white">
                        <div class="position-relative overflow-hidden group">
                            @php
                                $displayImage = str_starts_with($product->img, 'http')
                                    ? $product->img
                                    : asset('storage/' . $product->img);
                            @endphp

                            <img src="{{ $displayImage }}" class="w-100 product-img"
                                style="height: 240px; object-fit: cover;"
                                onerror="this.onerror=null;this.src='https://via.placeholder.com/400x400?text=No+Image'">

                            {{-- แถบจัดการ (Hover Overlay) --}}
                            <div class="card-action-overlay">
                                <div class="btn-group-vertical shadow-lg">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                       class="btn btn-white text-primary mb-1" title="แก้ไข">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                          onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบสินค้านี้?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-white text-danger" title="ลบ">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge badge-light text-muted px-2 py-1" style="border-radius: 6px; font-size: 0.65rem; border: 1px solid #eee;">
                                    {{ strtoupper($product->cat) }}
                                </span>
                                <h6 class="text-bold text-dark mb-0 price-tag">฿{{ number_format($product->price) }}</h6>
                            </div>
                            <h6 class="text-bold text-dark mb-1 text-truncate">{{ $product->name }}</h6>
                            <p class="text-muted x-small mb-0 text-truncate-2">{{ $product->description ?: 'ไม่มีรายละเอียดสินค้า' }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-white shadow-sm d-inline-block p-5" style="border-radius: 30px; border: 1px dashed #ddd;">
                        <i class="fas fa-box-open fa-4x mb-3 text-warning opacity-50"></i>
                        <h5 class="text-bold">ยังไม่มีข้อมูลสินค้าในระบบ</h5>
                        <p class="text-muted">คลิกปุ่มด้านบนเพื่อเพิ่มสินค้าชิ้นแรกของคุณ</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modal เพิ่มสินค้า --}}
    <div class="modal fade" id="modal-add-product" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-2xl" style="border-radius: 25px; overflow: hidden;">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row no-gutters">
                        {{-- ซ้าย: ข้อมูล --}}
                        <div class="col-lg-7 p-4 p-md-5 bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="text-bold m-0"><i class="fas fa-plus-circle mr-2 text-warning"></i>รายละเอียดสินค้า</h4>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="small text-bold">ชื่อสินค้า <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control custom-input" placeholder="ระบุชื่อสินค้า..." required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="small text-bold">ราคาขาย (บาท) <span class="text-danger">*</span></label>
                                        <input type="number" name="price" class="form-control custom-input" placeholder="0" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="small text-bold">หมวดหมู่</label>
                                        <select name="cat" class="form-control custom-input">
                                            <option value="Clippers">Clippers</option>
                                            <option value="Scissors">Scissors</option>
                                            <option value="Hair Care">Hair Care</option>
                                            <option value="Essentials">Essentials</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="small text-bold">รายละเอียดโดยย่อ</label>
                                        <textarea name="description" class="form-control custom-input" rows="4" placeholder="ระบุรายละเอียด..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ขวา: รูปภาพ --}}
                        <div class="col-lg-5 p-4 p-md-5 bg-light" style="border-left: 1px solid #eee;">
                            <h6 class="text-bold mb-4"><i class="fas fa-images mr-2 text-warning"></i>อัปโหลดรูปภาพ</h6>
                            
                            {{-- Preview รูปหลัก --}}
                            <div class="text-center mb-4">
                                <div class="main-preview-box shadow-sm mx-auto mb-2" onclick="document.getElementById('addImg1').click();">
                                    <img id="addPreview1" src="https://via.placeholder.com/400x400?text=Click+to+Upload" class="img-fit">
                                </div>
                                <label class="x-small text-bold text-muted">รูปภาพหน้าปก (จำเป็น)</label>
                                <input type="file" name="image_file" id="addImg1" class="d-none" required onchange="previewFile(this, 'addPreview1')">
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="sub-preview-box shadow-sm mb-2" onclick="document.getElementById('addImg2').click();">
                                        <img id="addPreview2" src="https://via.placeholder.com/150?text=Sub+2" class="img-fit">
                                    </div>
                                    <input type="file" name="image_file2" id="addImg2" class="d-none" onchange="previewFile(this, 'addPreview2')">
                                </div>
                                <div class="col-6">
                                    <div class="sub-preview-box shadow-sm mb-2" onclick="document.getElementById('addImg3').click();">
                                        <img id="addPreview3" src="https://via.placeholder.com/150?text=Sub+3" class="img-fit">
                                    </div>
                                    <input type="file" name="image_file3" id="addImg3" class="d-none" onchange="previewFile(this, 'addPreview3')">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-black btn-block mt-5 py-3 shadow-lg" style="border-radius: 15px;">
                                <i class="fas fa-save mr-2 text-warning"></i> ยืนยันเพิ่มสินค้า
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap');

        body { font-family: 'Kanit', sans-serif; background-color: #f4f7f6; }

        /* Card ดีไซน์ใหม่ */
        .product-card {
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid #f0f0f0 !important;
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }

        /* Overlay สำหรับปุ่มจัดการ */
        .card-action-overlay {
            position: absolute;
            top: 15px;
            right: -50px; /* ซ่อนไว้ทางขวา */
            transition: 0.3s ease;
            z-index: 10;
        }
        .product-card:hover .card-action-overlay {
            right: 15px; /* เลื่อนเข้ามาเมื่อ Hover */
        }
        .btn-white {
            background: #fff;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 10px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }
        .btn-white:hover { transform: scale(1.1); background: #eee; }

        /* Inputs & Modal */
        .custom-input {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #eee;
            background: #fcfcfc;
        }
        .custom-input:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.1);
            background: #fff;
        }

        .btn-black {
            background: #111;
            color: #fff;
            border: none;
            transition: 0.3s;
            font-weight: 500;
        }
        .btn-black:hover { background: #000; color: #ffc107; }

        /* Image Containers */
        .main-preview-box { width: 100%; max-width: 200px; height: 200px; border-radius: 20px; border: 2px dashed #ccc; overflow: hidden; cursor: pointer; }
        .sub-preview-box { width: 100%; height: 100px; border-radius: 15px; border: 1px dashed #ccc; overflow: hidden; cursor: pointer; }
        .img-fit { width: 100%; height: 100%; object-fit: cover; }

        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 32px;
        }
        .x-small { font-size: 0.7rem; }
        .price-tag { color: #2d3436; font-size: 1.1rem; }
    </style>
@stop

@section('js')
    <script>
        // ฟังก์ชัน Preview รูปภาพ
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

        // ทำให้ Alert หายไปเอง
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);
    </script>
@stop
