
@extends('adminlte::page')

@section('title', 'จัดการบริการทรงผม')

@section('content_header')
    <h1 class="m-0 text-dark">จัดการบริการทรงผม</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-info shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white py-3">
                    <h3 class="card-title font-weight-bold">
                        <i class="fas fa-cut mr-2 text-info"></i> รายการบริการทั้งหมด
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-info btn-sm px-3" data-toggle="modal" data-target="#modal-add-service">
                            <i class="fas fa-plus-circle mr-1"></i> เพิ่มบริการใหม่
                        </button>
                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 80px" class="text-center">รูปภาพ</th>
                                <th>ชื่อบริการ</th>
                                <th class="text-center">ราคา (บาท)</th>
                                <th class="text-center">เวลา (นาที)</th>
                                <th style="width: 150px" class="text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                                <tr>
                                    <td class="text-center">
                                        <img src="{{ $service->image_url }}" alt="img" 
                                             class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;"
                                             onerror="this.src='https://via.placeholder.com/50x50?text=No+Img'">
                                    </td>
                                    <td class="align-middle font-weight-bold">{{ $service->name }}</td>
                                    <td class="text-center align-middle">{{ number_format($service->price) }} ฿</td>
                                    <td class="text-center align-middle">{{ $service->duration }} นาที</td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-warning" title="แก้ไข">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('ยืนยันการลบบริการนี้?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="ลบ">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">ไม่พบข้อมูลบริการในระบบ</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal เพิ่มบริการ (ให้ตรงกับตาราง services) --}}
<div class="modal fade" id="modal-add-service" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 15px;">
            <form action="{{ route('admin.services.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title font-weight-bold">เพิ่มบริการทรงผมใหม่</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group">
                        <label>ชื่อบริการ (เช่น ตัดผมชาย)</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>ราคา (บาท)</label>
                                <input type="number" name="price" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>เวลาที่ใช้ (นาที)</label>
                                <input type="number" name="duration" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>ลิงก์รูปภาพตัวอย่าง</label>
                        <input type="url" name="image_url" class="form-control" placeholder="https://...">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-info px-4">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            @if(session('success'))
                Swal.fire({ icon: 'success', title: 'สำเร็จ!', text: '{{ session('success') }}', timer: 2000, showConfirmButton: false });
            @endif
        });
    </script>
@stop
