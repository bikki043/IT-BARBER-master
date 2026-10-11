@extends('admin.admin')
@section('title', 'Services Menu')

@section('content')
<div class="row mb-4">
    <div class="col-sm-6">
        <h2 class="font-weight-bold">จัดการบริการ</h2>
        <p class="text-muted italic">กำหนดรายการบริการและราคาของร้าน ITBARBER</p>
    </div>
    <div class="col-sm-6 text-right">
        <button type="button" class="btn btn-dark shadow-sm rounded-pill px-4 hover-scale" data-toggle="modal" data-target="#serviceFormModal">
            <i class="fas fa-plus-circle mr-2 text-warning"></i> เพิ่มเมนูบริการ
        </button>
    </div>
</div>

<div class="row">
    @foreach ($services as $service)
    <div class="col-12 col-md-6 col-lg-3 mb-4">
        <div class="card shadow-sm border-0 h-100 transition-all hover-lift" style="border-radius: 20px;">
            <div class="card-body p-4 text-center">
                <div class="bg-light d-inline-block p-3 rounded-circle mb-3">
                    <i class="fas fa-cut fa-2x text-warning"></i>
                </div>
                <h5 class="font-weight-bold mb-1">{{ $service->name }}</h5>
                <div class="badge badge-warning px-3 py-2 rounded-pill mb-3">
                    {{ number_format($service->price) }} ฿
                </div>
                <p class="text-muted small"><i class="far fa-clock mr-1"></i> {{ $service->duration }} นาที</p>
                
                <div class="d-flex justify-content-center flex-wrap gap-2">
                    <button class="btn btn-sm btn-outline-dark rounded-pill px-3 m-1" onclick="viewDetail('{{ $service->name }}', '{{ $service->price }}', '{{ $service->duration }}')">ดู</button>
                    
                    {{-- 🛠 แก้ที่ 1: เติม admin. นำหน้า --}}
                    <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 m-1">แก้</a>

                    {{-- 🛠 แก้ที่ 2: เติม admin. นำหน้า --}}
                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" id="del-{{ $service->id }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $service->id }})" class="btn btn-sm btn-outline-danger rounded-pill px-3 m-1">ลบ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="modal fade" id="serviceFormModal" tabindex="-1" role="dialog" aria-labelledby="serviceFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="modal-title font-weight-bold" id="serviceFormModalLabel">เพิ่มบริการใหม่</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- 🛠 แก้ที่ 3: เติม admin. นำหน้า --}}
            <form action="{{ route('admin.services.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold">ชื่อบริการ</label>
                        <input type="text" name="name" class="form-control rounded-pill border-light bg-light" placeholder="เช่น ตัดผมชาย" required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-0">
                                <label class="small font-weight-bold">ราคา (฿)</label>
                                <input type="number" name="price" class="form-control rounded-pill border-light bg-light" placeholder="0" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-0">
                                <label class="small font-weight-bold">เวลา (นาที)</label>
                                <input type="number" name="duration" class="form-control rounded-pill border-light bg-light" placeholder="30" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-dark rounded-pill px-4 shadow">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .transition-all { transition: all 0.3s ease; }
    .gap-2 { gap: 0.25rem; }
    .modal-backdrop { opacity: 0.5 !important; }
</style>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function viewDetail(name, price, duration) {
        Swal.fire({
            title: '<strong>' + name + '</strong>',
            icon: 'info',
            html: 'ราคา: <b>' + price + ' ฿</b><br>เวลา: <b>' + duration + ' นาที</b>',
            confirmButtonText: 'ตกลง',
            confirmButtonColor: '#343a40',
            customClass: { popup: 'rounded-xl' }
        });
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "คุณจะไม่สามารถกู้คืนข้อมูลนี้ได้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก',
            customClass: { popup: 'rounded-xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('del-' + id).submit();
            }
        });
    }

    $(document).ready(function() {
        console.log("Bootstrap Modal Ready and Routes Adjusted");
    });
</script>
@endpush
