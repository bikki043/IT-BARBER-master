@extends('layouts.app')

@section('content')
    <style>
        :root {
            --gold: #ffcc00;
            --dark-bg: #050505;
            --card-bg: #111;
            --border-color: #222;
        }

        body {
            background-color: var(--dark-bg);
            color: #fff;
            font-family: 'Chakra Petch', sans-serif;
        }

        .history-header {
            font-family: 'Oswald', sans-serif;
            letter-spacing: 3px;
            border-left: 4px solid var(--gold);
            padding-left: 15px;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        .premium-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            transition: 0.3s;
            margin-bottom: 25px;
        }

        .premium-card:hover {
            border-color: var(--gold);
            box-shadow: 0 5px 20px rgba(255, 204, 0, 0.1);
        }

        .card-header-custom {
            background: rgba(255, 255, 255, 0.03);
            padding: 15px 25px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status-badge {
            font-family: 'Oswald', sans-serif;
            font-size: 0.75rem;
            padding: 4px 12px;
            border-radius: 4px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .status-completed {
            background: #28a745;
            color: #fff;
        }

        .status-shipped {
            background: var(--gold);
            color: #000;
        }

        .status-pending {
            background: #666;
            color: #fff;
        }

        .img-container {
            width: 100px;
            height: 100px;
            flex-shrink: 0;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            overflow: hidden;
            background: #000;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }

        .premium-card:hover .img-container img {
            transform: scale(1.1);
        }

        .price-text {
            font-family: 'Oswald', sans-serif;
            font-size: 1.4rem;
            color: var(--gold);
        }

        .text-gold {
            color: var(--gold);
        }

        .text-muted-custom {
            color: #888;
            font-size: 0.85rem;
        }
    </style>

    <div class="container py-5">

        {{-- Section 1: Service Appointments --}}
        <div class="mb-5">
            <h2 class="history-header">Service <span class="text-gold">Appointments</span></h2>

            <div class="row">
                @forelse ($appointments as $item)
                    <div class="col-12">
                        <div class="premium-card">
                            <div class="card-header-custom">
                                <div>
                                    <span class="font-weight-bold mr-3">BOOKING ID: #{{ $item->id }}</span>
                                    {{-- เพิ่มเวลาที่สั่งซื้อ (Booking Date) --}}
                                    <span class="text-muted-custom">ทำรายการเมื่อ:
                                        {{ $item->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <span
                                    class="status-badge {{ $item->status == 'completed' ? 'status-completed' : 'status-pending' }}">
                                    {{ strtoupper($item->status ?? 'PENDING') }}
                                </span>
                            </div>
                            <div class="p-4 d-flex align-items-center justify-content-between flex-wrap">
                                <div class="d-flex align-items-center">
                                    <div class="img-container mr-4">
                                        @php
                                            $serviceImg = $item->service->image_url ?? ($item->service->img ?? null);
                                        @endphp
                                        <img src="{{ $serviceImg ? (str_starts_with($serviceImg, 'http') ? $serviceImg : asset('storage/' . $serviceImg)) : asset('images/default-service.png') }}"
                                            alt="Service">
                                    </div>
                                    <div>
                                        <h4 class="mb-1 font-weight-bold">{{ $item->service->name ?? 'Service Name' }}</h4>
                                        <p class="mb-0 text-muted-custom">
                                            {{-- วันที่และเวลาที่จะเข้ารับบริการ --}}
                                            <i class="fas fa-calendar-check mr-2 text-gold"></i>
                                            วันนัดหมาย:
                                            {{ \Carbon\Carbon::parse($item->appointment_date)->format('d M Y') }}
                                            <i class="fas fa-clock ml-3 mr-2 text-gold"></i> {{ $item->appointment_time }}
                                            น.
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right mt-3 mt-md-0">
                                    <p class="small text-muted-custom mb-0 uppercase">Service Price</p>
                                    <span class="price-text">฿{{ number_format($item->service->price ?? 0, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5" style="border: 1px dashed #333; border-radius: 8px;">
                        <p class="text-muted">ไม่พบประวัติการจองบริการ</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Section 2: Product Orders --}}
        <div>
            <h2 class="history-header">Product <span class="text-gold">Orders</span></h2>

            @forelse ($orders as $order)
                <div class="premium-card">
                    <div class="card-header-custom">
                        <div>
                            <span class="font-weight-bold mr-3">ORDER #{{ $order->id }}</span>
                            <span class="text-muted-custom">ทำรายการเมื่อ:
                                {{ $order->created_at->format('d/m/Y H:i') }}</span>
                            {{-- เพิ่มเวลาที่สั่งซื้อ (Order Date) --}}

                        </div>
                        <span class="status-badge status-shipped">{{ strtoupper($order->status ?? 'SHIPPED') }}</span>
                    </div>

                    <div class="order-items-list">
                        {{-- จุดที่แก้ไข: เพิ่ม @foreach กลับเข้าไปเพื่อวนลูปสินค้าใน Order --}}
                        @foreach ($order->items as $productItem)
                            <div class="p-4 d-flex align-items-center justify-content-between border-bottom"
                                style="border-color: #222 !important;">
                                <div class="d-flex align-items-center">
                                    <div class="img-container mr-4" style="width: 70px; height: 70px;">
                                        @if ($productItem->product && $productItem->product->img)
                                            @php
                                                // 1. ลองดึงจาก Relation ปกติก่อน
                                                $product = $productItem->product;

                                                // 2. ถ้า Relation เป็น NULL (เพราะ product_id ใน DB เป็น null)
                                                // ให้ลองไป Query หา Product ตรงๆ จากชื่อสินค้า
                                                if (!$product && $productItem->product_name) {
                                                    $product = \App\Models\Product::where(
                                                        'name',
                                                        $productItem->product_name,
                                                    )->first();
                                                }

                                                $finalUrl = asset('images/default-product.png');

                                                if ($product && $product->img) {
                                                    $imgValue = trim($product->img);
                                                    $fileName = basename($imgValue);
                                                    $finalUrl = asset('storage/products/' . $fileName);
                                                }
                                            @endphp

                                            <img src="{{ $finalUrl }}"
                                                onerror="this.src='{{ asset('images/default-product.png') }}'"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                            <img src="{{ $finalUrl }}"
                                                onerror="this.src='{{ asset('images/default-product.png') }}'">
                                        @else
                                            <div
                                                class="w-100 h-100 d-flex align-items-center justify-content-center bg-dark">
                                                <i class="fas fa-image text-secondary"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="mb-1 font-weight-bold">
                                            {{ $productItem->product->name ?? $productItem->product_name }}</p>
                                        <p class="mb-0 text-muted-custom">จำนวน: {{ $productItem->quantity }} ชิ้น</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="font-weight-bold text-gold">฿{{ number_format($productItem->price * $productItem->quantity, 2) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-3 px-4 d-flex justify-content-between align-items-center"
                        style="background: rgba(255,255,255,0.02);">
                        <span class="text-muted-custom">ขอบคุณที่ใช้บริการ IT BARBER</span>
                        <div>
                            <span class="mr-3 text-muted-custom">ยอดรวมทั้งสิ้น:</span>
                            <span class="price-text"
                                style="font-size: 1.6rem;">฿{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5" style="border: 1px dashed #333; border-radius: 8px;">
                    <p class="text-muted">ยังไม่มีประวัติการสั่งซื้อสินค้า</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

