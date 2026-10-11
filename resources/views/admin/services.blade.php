@extends('adminlte::page')

@section('title', 'Manage Services | IT BARBER')

@section('content_header')
    <div class="container-fluid animate__animated animate__fadeIn">
        <div class="row mb-2 align-items-end">
            <div class="col-sm-6">
                <h1 class="m-0 text-bold"><i class="fas fa-cut mr-2 text-warning"></i>จัดการบริการ</h1>
                <p class="text-muted mb-0">เพิ่ม แก้ไข หรือระงับบริการที่แสดงบนหน้าเว็บ</p>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-black shadow-sm px-4 py-2" style="border-radius: 12px;"
                    data-toggle="modal" data-target="#modal-add-service">
                    <i class="fas fa-plus-circle mr-2 text-warning"></i> เพิ่มบริการใหม่
                </button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid animate__animated animate__fadeInUp">
        {{-- Alert Section --}}
        @if (session('success'))
            <div class="alert bg-black text-warning border-warning alert-dismissible fade show shadow-lg" role="alert"
                style="border-radius: 15px;">
                <i class="icon fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close text-warning" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        <div class="row">
            @forelse($services as $service)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="service-card shadow-sm border-0 h-100 bg-white"
                        style="border-radius: 20px; overflow: hidden; transition: 0.3s;">
                        <div class="position-relative">
                            @php
                                $img = $service->image_url;
                                if (!$img) {
                                    $imageSource = 'https://via.placeholder.com/400x200?text=No+Image';
                                } elseif (filter_var($img, FILTER_VALIDATE_URL)) {
                                    $imageSource = $img;
                                } else {
                                    $imageSource = Storage::url($img);
                                }
                            @endphp
                            <img src="{{ $imageSource }}" class="w-100" style="height: 180px; object-fit: cover;"
                                onerror="this.onerror=null;this.src='https://via.placeholder.com/400x200?text=Image+Not+Found';">
                            <div class="price-tag">฿{{ number_format($service->price) }}</div>
                        </div>

                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="text-bold mb-0 text-dark">{{ $service->name }}</h5>
                                <span class="badge badge-light px-3 py-2" style="border-radius: 10px;">
                                    <i class="far fa-clock mr-1 text-warning"></i> {{ $service->duration }} นาที
                                </span>
                            </div>
                            <p class="text-muted small text-truncate">ID: #SER-{{ $service->id }}</p>

                            <hr class="my-3 opacity-50">

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                                    <a href="{{ route('admin.services.edit', $service->id) }}"
                                        class="btn btn-warning btn-sm px-3">
                                        <i class="fas fa-edit mr-1"></i> แก้ไข
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-dark btn-sm px-3"
                                            onclick="return confirm('ยืนยันการลบบริการนี้?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="switch{{ $service->id }}"
                                        checked>
                                    <label class="custom-control-label small text-muted"
                                        for="switch{{ $service->id }}">เปิดใช้งาน</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-white shadow-sm d-inline-block p-5" style="border-radius: 30px;">
                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076402.png" width="120"
                            class="mb-4 opacity-50">
                        <h4 class="text-bold">ยังไม่มีข้อมูลบริการ</h4>
                        <p class="text-muted">เริ่มต้นด้วยการเพิ่มบริการแรกสำหรับร้านของคุณ</p>
                        <button class="btn btn-warning px-4 text-bold" data-toggle="modal"
                            data-target="#modal-add-service">เพิ่มบริการเลย</button>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modal เพิ่มบริการ --}}
    <div class="modal fade" id="modal-add-service" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0 shadow-2xl" style="border-radius: 25px;">
                <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-0 p-4">
                        <h5 class="modal-title text-bold"><i
                                class="fas fa-plus-circle mr-2 text-warning"></i>สร้างรายการบริการใหม่</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body px-4 pb-4">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group mb-4">
                                    <label class="text-sm uppercase letter-spacing-1">ชื่อบริการ <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control custom-input"
                                        placeholder="เช่น ตัดผมชายระดับพรีเมียม" required>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mb-4">
                                            <label class="text-sm">ราคา (บาท)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span
                                                        class="input-group-text bg-white border-right-0">฿</span></div>
                                                <input type="number" name="price"
                                                    class="form-control custom-input border-left-0" placeholder="0"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-4">
                                            <label class="text-sm">ระยะเวลา (นาที)</label>
                                            <div class="input-group">
                                                <input type="number" name="duration"
                                                    class="form-control custom-input border-right-0" placeholder="30"
                                                    required>
                                                <div class="input-group-append"><span
                                                        class="input-group-text bg-white border-left-0"><i
                                                            class="far fa-clock"></i></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="text-sm uppercase letter-spacing-1">คำอธิบายบริการ</label>
                                    <textarea name="description" class="form-control custom-input" rows="3" placeholder="อธิบายรายละเอียดบริการของคุณ..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label class="text-sm">ภาพหน้าปกบริการ</label>
                                <div class="image-preview-zone" id="imagePreviewZone" onclick="document.getElementById('fileInput').click()">
                                    {{-- ส่วนแสดงผล Default --}}
                                    <div id="previewDefault">
                                        <i class="fas fa-cloud-upload-alt fa-3x mb-2 text-muted"></i>
                                        <p class="small text-muted mb-0">คลิกเพื่ออัปโหลดรูปภาพ</p>
                                    </div>
                                    {{-- ส่วนแสดงรูปที่เลือก --}}
                                    <img src="" id="imgPreviewRender" class="preview-img d-none">
                                    
                                    {{-- Input ตัวจริงที่ห้ามถูกลบหรือสร้างใหม่ --}}
                                    <input type="file" name="image_file" id="fileInput" class="file-input" accept="image/*"
                                        onchange="previewImage(this)">
                                </div>
                                <div class="mt-2 text-center">
                                    <span class="text-muted small">หรือระบุ URL</span>
                                    <input type="text" name="image_url_input"
                                        class="form-control form-control-sm mt-1"
                                        placeholder="https://example.com/image.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 bg-light" style="border-radius: 0 0 25px 25px;">
                        <button type="button" class="btn btn-link text-muted" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-black px-5 py-2 text-bold shadow-lg"
                            style="border-radius: 12px;">บันทึกบริการ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap');
        body { font-family: 'Kanit', sans-serif; background-color: #f8f9fa; }
        .btn-black { background: #1a1a1a; color: white; border: none; }
        .btn-black:hover { background: #000; color: #ffc107; }
        .service-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important; }
        .price-tag { position: absolute; bottom: 15px; right: 15px; background: rgba(0, 0, 0, 0.8); color: #ffc107; padding: 5px 15px; border-radius: 12px; font-weight: bold; backdrop-filter: blur(5px); }
        .custom-input { border-radius: 12px; padding: 12px 15px; border: 1px solid #eee; transition: 0.3s; }
        .image-preview-zone { width: 100%; height: 250px; border: 2px dashed #ddd; border-radius: 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; cursor: pointer; overflow: hidden; background: #fdfdfd; }
        .preview-img { width: 100%; height: 100%; object-fit: cover; }
        .file-input { position: absolute; width: 1px; height: 1px; opacity: 0; }
        .d-none { display: none !important; }
    </style>
@stop

@section('js')
    <script>
        function previewImage(input) {
            const preview = document.getElementById('imgPreviewRender');
            const defaultUI = document.getElementById('previewDefault');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    defaultUI.classList.add('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@stop
