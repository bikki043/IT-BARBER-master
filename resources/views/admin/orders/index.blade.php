@extends('adminlte::page')

@section('title', 'Order Management | IT BARBER')

@section('content_header')
    <div class="container-fluid animate__animated animate__fadeIn">
        <div class="row mb-4 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 text-bold text-dark" style="font-size: 2.2rem;">
                    <i class="fas fa-shipping-fast mr-2 text-warning"></i>การจัดการคำสั่งซื้อ
                </h1>
                <p class="text-muted">ตรวจสอบสินค้า ยืนยันการจัดส่ง หรือจัดการออเดอร์ในระบบ</p>
            </div>
            <div class="col-sm-6 text-right">
                <button onclick="window.location.reload()"
                    class="btn btn-white shadow-sm border px-4 rounded-pill transition-hover">
                    <i class="fas fa-sync-alt mr-2 text-primary"></i> อัปเดตรายการใหม่
                </button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid pb-5">
        {{-- Stat Dashboard --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm"
                    style="border-radius: 20px; background: linear-gradient(135deg, #fff 0%, #fff9e6 100%);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-bold text-muted uppercase small">รอการจัดส่ง</h6>
                                <h2 class="text-bold text-warning mb-0">{{ $orders->where('status', 'pending')->count() }}
                                    ออเดอร์</h2>
                            </div>
                            <div class="icon-shape bg-warning text-white rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm"
                    style="border-radius: 20px; background: linear-gradient(135deg, #fff 0%, #e6f9ed 100%);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-bold text-muted uppercase small">จัดส่งแล้ว</h6>
                                <h2 class="text-bold text-success mb-0">
                                    {{ $orders->whereIn('status', ['shipped', 'completed'])->count() }} ออเดอร์</h2>
                            </div>
                            <div class="icon-shape bg-success text-white rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <i class="fas fa-check-double"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="card border-0 shadow-sm bg-transparent" style="border-radius: 20px;">
            <div class="card-header p-0 border-0 bg-transparent mb-3">
                <ul class="nav nav-pills p-2 bg-white d-inline-flex shadow-sm" style="border-radius: 15px;">
                    <li class="nav-item">
                        <a class="nav-link active px-4 py-2 font-weight-bold" data-toggle="pill" href="#pending-tab">
                            <i class="fas fa-box mr-2"></i>ออเดอร์รอจัดการ
                        </a>
                    </li>
                    <li class="nav-item ml-2">
                        <a class="nav-link px-4 py-2 font-weight-bold text-dark" data-toggle="pill" href="#shipped-tab">
                            <i class="fas fa-history mr-2 text-info"></i>ประวัติการส่งแล้ว
                        </a>
                    </li>
                </ul>
            </div>

            <div class="tab-content pt-2">
                <div class="tab-pane fade show active" id="pending-tab">
                    {!! renderOrderList($orders->where('status', 'pending'), true) !!}
                </div>
                <div class="tab-pane fade" id="shipped-tab">
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('admin.orders.exportPDF') }}" target="_blank"
                            class="btn btn-danger rounded-pill px-4 shadow-sm">
                            <i class="fas fa-file-pdf mr-2"></i> พิมพ์รายงาน PDF
                        </a>
                    </div>
                    {!! renderOrderList($orders->whereIn('status', ['shipped', 'completed']), false) !!}
                </div>
            </div>
        </div>
    </div>

    {{-- SYSTEM FORMS --}}
    <form id="main-update-form" action="" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" value="shipped">
        <input type="hidden" name="courier" id="input-courier-val">
    </form>

    <form id="delete-order-form" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    {{-- MODAL --}}
    <div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 30px; overflow: hidden;">
                <div id="modal-body-content"></div>
            </div>
        </div>
    </div>
@stop

@php
   function renderOrderList($orders, $canProcess)
{
    if ($orders->isEmpty()) {
        return '
        <div class="text-center bg-white py-5 rounded-xl border shadow-xs">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076402.png" style="width: 120px; opacity: 0.3;">
            <p class="mt-4 text-muted font-weight-bold h5">ยังไม่มีรายการสั่งซื้อในหมวดนี้</p>
        </div>';
    }

    $html = '<div class="table-responsive bg-white rounded-xl shadow-sm border"><table class="table table-hover mb-0">';
    $html .= '<thead class="bg-light">
                <tr>
                    <th class="border-0 pl-4 py-3">เลขออเดอร์</th>
                    <th class="border-0 py-3">ลูกค้า</th>
                    <th class="border-0 py-3 text-center">สินค้า</th>
                    <th class="border-0 py-3 text-right">ยอดชำระ</th>
                    <th class="border-0 py-3 text-center">สถานะ</th>
                    <th class="border-0 py-3 text-right pr-4">จัดการ</th>
                </tr>
              </thead><tbody>';

    foreach ($orders as $o) {
        // --- ส่วนที่เพิ่ม: ดึงรูปโปรไฟล์ลูกค้า ---
        $customerImg = ($o->customer && $o->customer->image_path) 
            ? asset('storage/' . $o->customer->image_path) 
            : 'https://ui-avatars.com/api/?name=' . urlencode($o->customer_name) . '&background=E8F0FE&color=2C3E50&bold=true';
        // ------------------------------------

        $itemsData = $o->items->map(function ($i) {
            $p = \App\Models\Product::where('name', $i->product_name)->first();
            return [
                'name' => $i->product_name,
                'qty' => $i->quantity,
                'price' => number_format($i->price, 2),
                'img' => $p
                    ? (str_starts_with($p->img, 'http')
                        ? $p->img
                        : asset('storage/' . $p->img))
                    : 'https://via.placeholder.com/150',
            ];
        });

        $data = [
            'id' => $o->id,
            'name' => $o->customer_name,
            'phone' => $o->phone,
            'address' => $o->address,
            'total' => number_format($o->total_amount, 2),
            'date' => $o->created_at->format('d/m/Y H:i'),
            'status' => $o->status,
            'items' => $itemsData,
        ];

        $thumbs = '';
        foreach ($itemsData->take(3) as $item) {
            $thumbs .= '<img src="' . $item['img'] . '" class="table-thumb shadow-xs">';
        }

        $html .= '
        <tr class="align-middle">
            <td class="pl-4 py-4 text-bold text-dark">#' . $o->id . '</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <img src="' . $customerImg . '" class="rounded-circle shadow-sm border" 
                             style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #fff;">
                    </div>
                    <div>
                        <div class="text-bold text-dark mb-0">' . $o->customer_name . '</div>
                        <small class="text-muted">' . $o->phone . '</small>
                    </div>
                </div>
            </td>
            <td class="text-center">' . $thumbs . '</td>
            <td class="text-right text-bold text-dark h6">฿' . number_format($o->total_amount) . '</td>
            <td class="text-center">
                <span class="badge ' . ($canProcess ? 'badge-warning' : 'badge-info') . ' px-3 py-2 rounded-pill shadow-xs">
                    ' . ($canProcess ? 'รอการจัดการ' : 'จัดส่งแล้ว') . '
                </span>
            </td>
            <td class="text-right pr-4">
                <div class="btn-group">
                    <button class="btn btn-dark btn-sm rounded-pill px-3 mr-2" onclick=\'viewOrderDetails(' . json_encode($data) . ')\'>
                        <i class="fas fa-search mr-1"></i> ตรวจสอบ
                    </button>
                    <button class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" onclick="deleteOrder(' . $o->id . ')">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        </tr>';
    }
    $html .= '</tbody></table></div>';
    return $html;
}
@endphp

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentCourier = '';

        function viewOrderDetails(data) {
            currentCourier = '';
            let productHtml = '';
            data.items.forEach(item => {
                productHtml += `
                <div class="col-md-12 mb-3">
                    <div class="d-flex align-items-center p-3 rounded-xl border bg-white shadow-xs">
                        <img src="${item.img}" class="rounded-lg shadow-sm border mr-3" style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="text-bold text-dark mb-1">${item.name}</h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">จำนวน: ${item.qty}</span>
                                <span class="text-bold text-dark">฿${item.price}</span>
                            </div>
                        </div>
                    </div>
                </div>`;
            });

            let content = `
            <div class="row no-gutters">
                <div class="col-lg-7 p-4 p-md-5 bg-white overflow-auto" style="max-height: 85vh;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-bold mb-0"><i class="fas fa-file-invoice text-warning mr-2"></i>ออเดอร์ #${data.id}</h3>
                        <span class="badge badge-light border px-3">${data.date}</span>
                    </div>
                    <div class="card border-0 bg-light rounded-xl mb-4">
                        <div class="card-body">
                            <h6 class="text-bold text-muted small uppercase mb-3"><i class="fas fa-map-marker-alt mr-2"></i>ที่อยู่จัดส่ง</h6>
                            <h5 class="text-bold text-dark mb-1">${data.name}</h5>
                            <p class="text-muted mb-2">${data.phone}</p>
                            <p class="mb-0 text-dark" style="font-size: 1rem; line-height: 1.6;">${data.address}</p>
                        </div>
                    </div>
                    <h5 class="text-bold text-dark mb-3">รายการสินค้า</h5>
                    <div class="row">${productHtml}</div>
                </div>
                <div class="col-lg-5 p-4 p-md-5 bg-dark d-flex flex-column justify-content-between" style="border-radius: 0 30px 30px 0;">
                    <div class="text-white">
                        <h4 class="text-bold text-warning mb-4"><i class="fas fa-truck-loading mr-2"></i> จัดการส่งสินค้า</h4>
                        <p class="text-muted font-weight-bold small uppercase mb-2">1. เลือกผู้ขนส่ง</p>
                        <div class="courier-grid mb-4">
                            <div class="courier-box" onclick="setCourier('Kerry Express', this)">Kerry</div>
                            <div class="courier-box" onclick="setCourier('Flash Express', this)">Flash</div>
                            <div class="courier-box" onclick="setCourier('J&T Express', this)">J&T</div>
                            <div class="courier-box" onclick="setCourier('ไปรษณีย์ไทย', this)">EMS</div>
                        </div>
                        <div class="bg-secondary-dark p-4 rounded-xl mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-bold mb-0">ยอดรวมทั้งสิ้น</span>
                                <span class="h4 text-bold text-warning mb-0">฿${data.total}</span>
                            </div>
                        </div>
                        ${data.status === 'pending' ? `
                                <button onclick="finalSubmit(${data.id})" class="btn btn-warning btn-lg btn-block text-bold mb-3 py-3 shadow" style="border-radius: 15px;">
                                    <i class="fas fa-check-circle mr-2"></i> ยืนยันการจัดส่ง
                                </button>
                            ` : `
                                <div class="alert alert-success border-0 text-center py-3 mb-3" style="border-radius: 15px;">
                                    <i class="fas fa-check-double mr-2"></i> จัดส่งเรียบร้อยแล้ว
                                </div>
                            `}
                        <button onclick="window.print()" class="btn btn-outline-light btn-block py-2" style="border-radius: 15px; border-style: dashed; opacity: 0.7;">
                            <i class="fas fa-print mr-2"></i> พิมพ์ใบปะหน้า
                        </button>
                    </div>
                    <div class="text-center mt-4">
                        <button class="btn btn-link text-muted" data-dismiss="modal">ปิดหน้าต่าง</button>
                    </div>
                </div>
            </div>`;

            $('#modal-body-content').html(content);
            $('#orderDetailModal').modal('show');
        }

        function setCourier(name, el) {
            currentCourier = name;
            $('.courier-box').removeClass('active');
            $(el).addClass('active');
        }

        function finalSubmit(id) {
            if (!currentCourier) {
                Swal.fire({
                    icon: 'warning',
                    title: 'กรุณาเลือกขนส่ง',
                    text: 'โปรดคลิกเลือกผู้ขนส่งก่อนยืนยัน',
                    confirmButtonColor: '#ffc107'
                });
                return;
            }
            Swal.fire({
                title: 'ยืนยันการจัดส่ง?',
                html: `ออเดอร์ #${id} ส่งโดย <b>${currentCourier}</b>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'ยืนยัน, ส่งแล้ว',
                cancelButtonText: 'ย้อนกลับ',
                borderRadius: '20px'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#input-courier-val').val(currentCourier);

                    // --- แก้ไขจุดนี้ ---
                    // ใช้คำสั่งแทนที่ :id ด้วยค่า id จริงๆ เพื่อป้องกัน URL เพี้ยน
                    let url = "{{ route('admin.orders.updateStatus', ':id') }}";
                    url = url.replace(':id', id);

                    $('#main-update-form').attr('action', url);
                    $('#main-update-form').submit();
                }
            });
        }

        function deleteOrder(id) {
            Swal.fire({
                title: 'ลบออเดอร์นี้?',
                text: "ข้อมูลออเดอร์ #" + id + " จะถูกลบออกจากระบบถาวร!",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเลย',
                cancelButtonText: 'ยกเลิก',
                borderRadius: '20px'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-order-form').attr('action', "{{ url('admin/orders') }}/" + id);
                    $('#delete-order-form').submit();
                }
            });
        }
    </script>
@stop

@section('css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap');

        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f4f7f6;
        }

        .rounded-xl {
            border-radius: 20px !important;
        }

        .shadow-xs {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .transition-hover:hover {
            transform: translateY(-2px);
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .table-thumb {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: -10px;
            border: 2px solid #fff;
            transition: 0.3s;
        }

        .table-thumb:hover {
            z-index: 10;
            transform: scale(1.3);
            margin-right: 5px;
        }

        .align-middle td {
            vertical-align: middle !important;
        }

        .courier-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .courier-box {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            padding: 12px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
            color: #fff;
        }

        .courier-box:hover {
            border-color: #ffc107;
            background: rgba(255, 255, 255, 0.1);
        }

        .courier-box.active {
            background: #ffc107;
            border-color: #ffc107;
            color: #000;
            font-weight: bold;
            transform: scale(1.05);
        }

        .bg-secondary-dark {
            background: rgba(255, 255, 255, 0.08);
        }

        .uppercase {
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .col-lg-7,
            .col-lg-7 * {
                visibility: visible;
            }

            .col-lg-7 {
                position: absolute;
                left: 0;
                top: 0;
                width: 100% !important;
            }

            .btn,
            .badge-light {
                display: none !important;
            }
        }
    </style>
@stop

