@extends('adminlte::page')

@section('title', 'จัดการข้อมูลเกี่ยวกับเรา | IT BARBER')

@section('content_header')
    <div class="container-fluid animate__animated animate__fadeIn">
        <div class="row mb-2 align-items-end">
            <div class="col-sm-6">
                <h1 class="m-0 text-bold"><i class="fas fa-info-circle mr-2 text-warning"></i>จัดการข้อมูลร้าน</h1>
                <p class="text-muted mb-0">แก้ไขเนื้อหาประวัติความเป็นมาและสถิติของ IT BARBER</p>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-dark shadow-sm px-4 py-2" style="border-radius: 12px;">
                    <i class="fas fa-external-link-alt mr-2 text-warning"></i> ดูหน้าเว็บจริง
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid animate__animated animate__fadeInUp">
    
    {{-- ส่วนแสดง Error --}}
    @if ($errors->any())
        <div class="alert alert-danger shadow-lg border-0 animate__animated animate__shakeX" style="border-radius: 15px;">
            <div class="d-flex">
                <i class="fas fa-exclamation-circle mr-3 mt-1"></i>
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- ส่วนแสดง Success --}}
    @if (session('success'))
        <div class="alert bg-black text-warning border-warning alert-dismissible fade show shadow-lg" role="alert" style="border-radius: 15px;">
            <i class="icon fas fa-check-circle mr-2"></i> <strong>สำเร็จ!</strong> {{ session('success') }}
            <button type="button" class="close text-warning" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- หากมีรูปใน gallery ให้แสดงแถว thumbnail พร้อมปุ่มลบ (อยู่ข้างนอกฟอร์มหลัก) --}}
    @if(isset($about) && $about->images && $about->images->count())
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 20px;">
            <div class="card-header bg-white">
                <h6 class="mb-0 text-bold">รูป Gallery ที่มีอยู่</h6>
            </div>
            <div class="card-body p-3">
                <div class="row">
                    @foreach($about->images as $img)
                        <div class="col-4 text-center mb-3">
                            <img src="{{ asset('storage/' . $img->image_path) }}" class="img-fluid" style="max-height:80px; object-fit:cover; border-radius:6px;">
                            <form action="{{ route('admin.about.image.destroy', $img->id) }}" method="POST" class="mt-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger px-2 py-1">ลบ</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            {{-- ฝั่งซ้าย: เนื้อหาหลัก --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 20px;">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="text-bold mb-0"><i class="fas fa-pen-nib mr-2 text-warning"></i>เนื้อหาหลัก (Main Content)</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group mb-4">
                            <label class="text-sm text-bold uppercase">หัวข้อหลัก (Hero Title) <span class="text-warning">*</span></label>
                            <input type="text" name="hero_title" class="form-control custom-input @error('hero_title') is-invalid @enderror" 
                                   value="{{ old('hero_title', $about->hero_title) }}" placeholder="เช่น THE LEGACY" required>
                        </div>

                        <div class="form-group mb-0">
                            <label class="text-sm text-bold uppercase">รายละเอียดประวัติร้าน (Story Description) <span class="text-warning">*</span></label>
                            <textarea name="story_description" class="form-control custom-input @error('story_description') is-invalid @enderror" 
                                      rows="12" style="resize: none;" required placeholder="เล่าเรื่องราวร้านของคุณที่นี่...">{{ old('story_description', $about->story_description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ฝั่งขวา: รูปภาพและสถิติ --}}
            <div class="col-lg-4">

                {{-- Card อัปโหลดรูป --}}
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 20px;">
                    <div class="card-body p-4 text-center">
                        <label class="text-sm text-bold uppercase d-block text-left mb-3">รูปภาพหลัก (Hero) + แกลเลอรี</label>

                        {{-- แสดงภาพหลักเดิมพร้อมฟอร์มอัพเดทเดียว --}}
                        <div class="position-relative overflow-hidden mb-3 shadow-sm preview-box" style="border-radius: 15px; height: 220px;">
                            <img src="{{ $about->image_path ? asset('storage/' . $about->image_path) : 'https://via.placeholder.com/600x400?text=No+Image' }}" 
                                 id="preview" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="custom-file mt-2">
                            <input type="file" name="image" class="custom-file-input" id="imgInput" accept="image/*">
                            <label class="custom-file-label text-left text-truncate" for="imgInput" style="border-radius: 10px;">เลือกรูป hero ใหม่...</label>
                        </div>
                        <p class="small text-muted mt-2 mb-0"><i class="fas fa-image mr-1"></i> ขนาดแนะนำ 600x400px (ไม่เกิน 2MB)</p>

                        {{-- ฟอร์มอัพโหลดหลายภาพสำหรับ gallery --}}
                        <hr>
                        <label class="text-sm text-bold uppercase d-block text-left mb-2">เพิ่มภาพ Gallery</label>
                        <div class="custom-file">
                            <input type="file" name="images[]" class="custom-file-input" id="galleryInput" accept="image/*" multiple>
                            <label class="custom-file-label text-left text-truncate" for="galleryInput" style="border-radius: 10px;">เลือกภาพหลายภาพ...</label>
                        </div>
                        <p class="small text-muted mt-2 mb-0"><i class="fas fa-images mr-1"></i> สามารถเลือกได้หลายรูป (แต่ละรูปไม่เกิน 2MB)</p>
                    </div>
                </div>

                {{-- Card สถิติ --}}
                <div class="card shadow-sm border-0" style="border-radius: 20px; background: #1a1a1a;">
                    <div class="card-header border-0 pt-4 px-4 bg-transparent">
                        <h5 class="text-bold text-white mb-0"><i class="fas fa-chart-line mr-2 text-warning"></i>ค่าสถิติโชว์หน้าเว็บ</h5>
                    </div>
                    <div class="card-body p-4 text-white">
                        <div class="form-group mb-3">
                            <label class="small text-bold uppercase text-warning">ประสบการณ์ (ปี)</label>
                            <input type="number" name="stat_years" class="form-control bg-dark border-secondary text-white custom-input" 
                                   value="{{ old('stat_years', $about->stat_years ?? 0) }}" style="border-radius: 10px;">
                        </div>
                        <div class="form-group mb-3">
                            <label class="small text-bold uppercase text-warning">จำนวนลูกค้า (คน)</label>
                            <input type="number" name="stat_cuts" class="form-control bg-dark border-secondary text-white custom-input" 
                                   value="{{ old('stat_cuts', $about->stat_cuts ?? 0) }}" style="border-radius: 10px;">
                        </div>
                        <div class="form-group mb-0">
                            <label class="small text-bold uppercase text-warning">ความพึงพอใจ (%)</label>
                            <input type="number" name="stat_satisfaction" class="form-control bg-dark border-secondary text-white custom-input" 
                                   value="{{ old('stat_satisfaction', $about->stat_satisfaction ?? 0) }}" max="100" style="border-radius: 10px;">
                        </div>
                    </div>
                </div>

                {{-- ปุ่มบันทึก --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-black btn-block shadow-lg py-3 text-bold" style="border-radius: 15px; font-size: 1.1rem;">
                        <i class="fas fa-save mr-2 text-warning"></i> บันทึกข้อมูลทั้งหมด
                    </button>
                    <button type="reset" class="btn btn-link btn-block text-muted mt-2 text-decoration-none">คืนค่าเริ่มต้น</button>
                </div>
            </div>
        </div>
    </form>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap');
        body { font-family: 'Kanit', sans-serif; background-color: #f4f6f9; }
        
        /* สไตล์ปุ่มดำ-ทอง */
        .btn-black { background: #1a1a1a; color: white; border: none; transition: 0.3s; }
        .btn-black:hover { background: #000; color: #ffc107; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important; }
        
        /* ฟอร์ม Input */
        .custom-input { border-radius: 12px; padding: 12px 15px; border: 1px solid #e0e0e0; transition: 0.3s; }
        .custom-input:focus { border-color: #ffc107; box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.1); }
        
        /* การ์ดและ Preview */
        .preview-box { border: 2px dashed #ddd; background: #fdfdfd; }
        .card { transition: 0.3s; }
        
        /* ซ่อนลูกศร input number */
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    </style>
@stop

@section('js')
<script>
    $(document).ready(function () {
        // Preview รูปภาพ
        $('#imgInput').on('change', function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result).hide().fadeIn(600);
                }
                reader.readAsDataURL(file);
                
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            }
        });

        $('#galleryInput').on('change', function() {
            let count = this.files.length;
            let label = count ? count + ' รูปที่เลือก' : 'เลือกภาพหลายภาพ...';
            $(this).next('.custom-file-label').addClass("selected").html(label);
        });

        // Effect เมื่อกดบันทึก
        $('form').on('submit', function() {
            $('.btn-black').html('<i class="fas fa-spinner fa-spin mr-2"></i> กำลังบันทึก...');
        });
    });
</script>
@stop
