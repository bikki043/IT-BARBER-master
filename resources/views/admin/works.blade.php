@extends('adminlte::page')

@section('title', 'จัดการผลงาน | IT BARBER')

@section('content_header')
    <div class="container-fluid animate__animated animate__fadeIn">
        <div class="row mb-2 align-items-end">
            <div class="col-sm-6">
                <h1 class="m-0 text-bold"><i class="fas fa-camera-retro mr-2 text-warning"></i>จัดการผลงาน</h1>
                <p class="text-muted mb-0">แกลเลอรี่ภาพทรงผมและผลงานระดับพรีเมียม</p>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-black shadow-sm px-4 py-2" style="border-radius: 12px;"
                    data-toggle="modal" data-target="#modal-add-work">
                    <i class="fas fa-plus-circle mr-2 text-warning"></i> เพิ่มผลงานใหม่
                </button>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid animate__animated animate__fadeInUp">
    {{-- Error Display --}}
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm" style="border-radius: 15px;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Alert Section --}}
    @if (session('success'))
        <div class="alert bg-black text-warning border-warning alert-dismissible fade show shadow-lg" role="alert"
            style="border-radius: 15px;">
            <i class="icon fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close text-warning" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="row">
        @forelse($works as $work)
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="work-card shadow-sm border-0 h-100 bg-white">
                    <div class="position-relative overflow-hidden">
                        @php
                            // ตรวจสอบว่ารูปมาจาก URL หรือ Storage
                            $displayImage = (str_starts_with($work->image_url, 'http')) 
                                ? $work->image_url 
                                : asset('storage/' . $work->image_url);
                        @endphp
                        
                        <img src="{{ $displayImage }}" 
                             class="w-100 work-img" 
                             style="height: 250px; object-fit: cover;"
                             onerror="this.onerror=null;this.src='https://via.placeholder.com/400x300?text=Image+Not+Found'">
                        
                        <div class="overlay-actions">
                            <form action="{{ route('admin.works.destroy', $work->id) }}" method="POST" onsubmit="return confirm('ยืนยันการลบรูปผลงานนี้?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-warning btn-sm shadow-lg text-bold px-3" style="border-radius: 10px;">
                                    <i class="fas fa-trash-alt mr-1"></i> ลบรูปภาพ
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body p-3 text-center">
                        <h6 class="text-bold text-dark mb-1">{{ $work->title }}</h6>
                        <p class="text-muted small mb-0">
                            <i class="far fa-calendar-alt text-warning mr-1"></i> {{ $work->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="bg-white shadow-sm d-inline-block p-5" style="border-radius: 30px;">
                    <i class="fas fa-images fa-4x mb-3 text-light"></i>
                    <h5 class="text-bold">ยังไม่มีรูปผลงาน</h5>
                    <p class="text-muted">คลิกที่ปุ่มด้านบนเพื่อเริ่มสร้างแกลเลอรี่ของคุณ</p>
                </div>
            </div>
        @endforelse
    </div>

    @if(method_exists($works, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $works->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>

{{-- Modal เพิ่มผลงาน --}}
<div class="modal fade" id="modal-add-work" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-2xl" style="border-radius: 25px;">
            <form action="{{ route('admin.works.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0 p-4">
                    <h5 class="modal-title text-bold"><i class="fas fa-upload mr-2 text-warning"></i>อัปโหลดผลงานใหม่</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body px-4 pb-4">
                    <div class="form-group mb-4">
                        <label class="text-sm text-bold uppercase">ชื่อทรงผม / คำอธิบาย</label>
                        <input type="text" name="title" class="form-control custom-input" placeholder="เช่น Vintage Side Part" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="text-sm text-bold uppercase mb-2 d-block">เลือกช่องทางอัปโหลด</label>
                        <ul class="nav nav-pills nav-fill mb-3 bg-light rounded-lg p-1" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active rounded-lg py-2" data-toggle="pill" href="#work-url">ลิงก์ URL</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link rounded-lg py-2" data-toggle="pill" href="#work-upload">อัปโหลดไฟล์</a>
                            </li>
                        </ul>
                        
                        <div class="tab-content border-0 p-3 bg-light" style="border-radius: 15px;">
                            <div id="work-url" class="tab-pane fade show active">
                                <input type="url" name="image_url" class="form-control custom-input bg-white" placeholder="https://example.com/image.jpg">
                            </div>
                            <div id="work-upload" class="tab-pane fade text-center">
                                <input type="file" name="image_file" class="form-control-file d-inline-block" accept="image/*">
                                <p class="small text-muted mt-2 mb-0">รองรับไฟล์ JPG, PNG (ขนาดไม่เกิน 2MB)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 bg-light" style="border-radius: 0 0 25px 25px;">
                    <button type="button" class="btn btn-link text-muted" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-black px-5 py-2 text-bold shadow-lg" style="border-radius: 12px;">บันทึกผลงาน</button>
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
        .btn-black { background: #1a1a1a; color: white; border: none; transition: 0.3s; }
        .btn-black:hover { background: #000; color: #ffc107; transform: translateY(-2px); }
        .work-card { border-radius: 20px; overflow: hidden; transition: 0.3s; background: #fff; }
        .work-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important; }
        .work-img { transition: 0.5s ease; }
        .overlay-actions {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center;
            opacity: 0; transition: 0.3s;
        }
        .work-card:hover .overlay-actions { opacity: 1; }
        .custom-input { border-radius: 12px; padding: 12px 15px; border: 1px solid #eee; }
        .nav-pills .nav-link.active { background-color: #1a1a1a !important; color: #ffc107 !important; }
    </style>
@stop
