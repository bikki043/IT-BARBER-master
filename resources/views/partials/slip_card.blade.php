@php
    $slipAppointments = \App\Models\Appointment::with(['service', 'barber'])
        ->whereNotNull('payment_slip')
        ->orderByRaw("CASE payment_status WHEN 'pending' THEN 0 ELSE 1 END")
        ->latest('slip_uploaded_at')
        ->take(20)
        ->get();

    $badges = ['unpaid' => 'secondary', 'pending' => 'warning', 'paid' => 'success', 'rejected' => 'danger'];
    $labels = ['unpaid' => 'ยังไม่ชำระ', 'pending' => 'รอตรวจสอบ', 'paid' => 'ชำระแล้ว', 'rejected' => 'ไม่ผ่าน'];
@endphp

<div class="card">
    <div class="card-header">
        <h3 class="card-title">สลิปการโอนเงิน (แดชบอร์ดการจอง)</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ลูกค้า</th>
                    <th>บริการ</th>
                    <th>วัน-เวลานัด</th>
                    <th>สลิป</th>
                    <th>สถานะ</th>
                    <th>อัปโหลดเมื่อ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($slipAppointments as $a)
                    <tr>
                        <td>{{ $a->customer_name }}<br><small class="text-muted">{{ $a->customer_phone }}</small></td>
                        <td>{{ $a->service->name ?? '-' }}</td>
                        <td>{{ optional($a->appointment_date)->format('d/m/Y') }} {{ $a->appointment_time }}</td>
                        <td>
                            <a href="{{ asset('storage/'.$a->payment_slip) }}" target="_blank">
                                <img src="{{ asset('storage/'.$a->payment_slip) }}" style="height:60px" alt="สลิป">
                            </a>
                        </td>
                        <td>
                            <span class="badge badge-{{ $badges[$a->payment_status] ?? 'secondary' }}">
                                {{ $labels[$a->payment_status] ?? $a->payment_status }}
                            </span>
                        </td>
                        <td>{{ optional($a->slip_uploaded_at)->format('d/m/Y H:i') }}</td>
                        <td>
                            @if ($a->payment_status === 'pending')
                                <form method="POST" action="{{ route('admin.appointments.payment', $a->id) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button name="status" value="paid" class="btn btn-sm btn-success">ยืนยัน</button>
                                    <button name="status" value="rejected" class="btn btn-sm btn-danger">ไม่ผ่าน</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">ยังไม่มีสลิป</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>