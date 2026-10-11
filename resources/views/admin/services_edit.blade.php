@extends('adminlte::page')

@section('title', 'แก้ไขบริการ')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark font-weight-bold" style="font-family: 'Kanit', sans-serif;">
                    <i class="fas fa-edit mr-2 text-warning"></i>แก้ไขบริการ
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">บริการ</a></li>
                    <li class="breadcrumb-item active">แก้ไข</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-lighten p-2 rounded-circle mr-3">
                            <i class="fas fa-scissors text-warning"></i>
                        </div>
                        <h3 class="card-title font-weight-bold m-0">ข้อมูลบริการ: {{ $service->name }}</h3>
                    </div>
                </div>

                <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group mb-4">
                                    <label class="text-muted small text-uppercase font-weight-bold">ชื่อบริการ</label>
                                    <input type="text" name="name" class="form-control form-control-lg custom-input" value="{{ $service->name }}" placeholder="ระบุชื่อบริการ" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label class="text-muted small text-uppercase font-weight-bold">ราคา (บาท)</label>
                                            <div class="input-group">
                                                <input type="number" name="price" class="form-control form-control-lg custom-input" value="{{ $service->price }}" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text border-0 bg-light">฿</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label class="text-muted small text-uppercase font-weight-bold">ระยะเวลา (นาที)</label>
                                            <div class="input-group">
                                                <input type="number" name="duration" class="form-control form-control-lg custom-input" value="{{ $service->duration }}" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text border-0 bg-light"><i class="far fa-clock"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="text-muted small text-uppercase font-weight-bold">รายละเอียด</label>
                                    <textarea name="description" class="form-control custom-input" rows="4" placeholder="อธิบายเกี่ยวกับบริการนี้...">{{ $service->description }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-5 pl-md-5 border-left-lg">
                                <label class="text-muted small text-uppercase font-weight-bold mb-3 d-block">รูปภาพบริการ</label>
                                
                                <div class="current-image-preview text-center p-3 mb-4 rounded-lg bg-light border-dashed">
                                    @php
                                        $imageSource = str_starts_with($service->image, 'http') 
                                            ? $service->image 
                                            : asset('storage/' . $service->image);
                                    @endphp
                                    <img src="{{ $imageSource }}" id="preview" class="img-fluid rounded shadow-sm" style="max-height: 200px; object-fit: cover;">
                                    <p class="mt-2 text-muted small">รูปภาพปัจจุบัน</p>
                                </div>

                                <div class="upload-section">
                                    <ul class="nav nav-pills nav-fill mb-3 bg-light rounded p-1" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active rounded shadow-sm py-1" data-toggle="pill" href="#pills-upload" style="font-size: 0.8rem;">อัปโหลดไฟล์</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link rounded py-1" data-toggle="pill" href="#pills-url" style="font-size: 0.8rem;">ใส่ลิงก์ URL</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="pills-upload">
                                            <div class="custom-file shadow-none">
                                                <input type="file" name="image_file" class="custom-file-input" id="uploadFile">
                                                <label class="custom-file-label border-light text-muted" for="uploadFile">เลือกรูปใหม่...</label>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-url">
                                            <input type="text" name="image" class="form-control custom-input" placeholder="วางลิงก์รูปภาพ https://..." value="{{ str_starts_with($service->image, 'http') ? $service->image : '' }}">
                                        </div>
                                    </div>
                                    <small class="text-info mt-3 d-block italic"><i class="fas fa-info-circle mr-1"></i> เว้นว่างไว้หากไม่ต้องการเปลี่ยนรูปภาพ</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white py-4 border-top">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.services.index') }}" class="btn btn-link text-muted mr-3">ยกเลิก</a>
                            <button type="submit" class="btn btn-warning px-5 shadow font-weight-bold" style="border-radius: 10px; color: #000;">
                                <i class="fas fa-check-circle mr-2"></i> บันทึกข้อมูล
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    /* ปรับแต่งตาม Dashboard Style */
    body { background-color: #f4f6f9 !important; }
    
    .bg-warning-lighten { background-color: rgba(255, 193, 7, 0.15); }
    
    .custom-input {
        border: 1px solid #e9ecef !important;
        border-radius: 10px !important;
        background-color: #fbfbfb !important;
        transition: all 0.2s;
    }
    
    .custom-input:focus {
        background-color: #fff !important;
        border-color: #ffc107 !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.1) !important;
    }

    .nav-pills .nav-link.active {
        background-color: #fff !important;
        color: #ffc107 !important;
        font-weight: bold;
    }

    .nav-pills .nav-link { color: #6c757d; }

    .border-dashed {
        border: 2px dashed #dee2e6 !important;
    }

    .custom-file-label::after {
        content: "ค้นหา";
        background-color: #ffc107;
        color: black;
    }

    @media (min-width: 768px) {
        .border-left-lg {
            border-left: 1px solid #f2f2f2 !important;
        }
    }
</style>
@stop

@section('js')
<script>
    $(document).ready(function () {
        // อัปเดตชื่อไฟล์และตัวอย่างรูป
        $('#uploadFile').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
            
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@stop
