@extends('adminlte::page')

@section('title', 'Revenue Analytics | IT BARBER')

@section('content_header')
    <div class="container-fluid animate__animated animate__fadeIn">
        <div class="row mb-4 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 text-bold text-dark" style="font-size: 2.2rem;">
                    <i class="fas fa-chart-line mr-2 text-warning"></i>วิเคราะห์รายได้
                </h1>
                <p class="text-muted">ข้อมูลสรุปยอดขายและสถิติแยกตามหมวดหมู่</p>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.appointments.analytics.pdf') }}" target="_blank"
                    class="btn btn-danger shadow-sm px-4 rounded-pill mr-2">
                    <i class="fas fa-file-pdf mr-2"></i> ส่งออก PDF
                </a>
                <button onclick="window.location.reload()"
                    class="btn btn-white shadow-sm border px-4 rounded-pill transition-hover">
                    <i class="fas fa-sync-alt mr-2 text-primary"></i> อัปเดตข้อมูลล่าสุด
                </button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid pb-5">

        {{-- 1. Stat Cards (Gradient Style เหมือนหน้า Order) --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm"
                    style="border-radius: 20px; background: linear-gradient(135deg, #fff 0%, #fff9e6 100%);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-bold text-muted uppercase small">รายได้ค่าบริการ (ตัดผม)</h6>
                                <h2 class="text-bold text-warning mb-0">{{ number_format(array_sum($serviceData)) }} ฿</h2>
                            </div>
                            <div class="icon-shape bg-warning text-white rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <i class="fas fa-cut"></i>
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
                                <h6 class="text-bold text-muted uppercase small">รายได้ขายสินค้า</h6>
                                <h2 class="text-bold text-success mb-0">{{ number_format(array_sum($productData)) }} ฿</h2>
                            </div>
                            <div class="icon-shape bg-success text-white rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm"
                    style="border-radius: 20px; background: linear-gradient(135deg, #fff 0%, #f0f2f5 100%);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-bold text-muted uppercase small">รายได้รวมทั้งหมด</h6>
                                <h2 class="text-bold text-dark mb-0">
                                    {{ number_format(array_sum($serviceData) + array_sum($productData)) }} ฿</h2>
                            </div>
                            <div class="icon-shape bg-dark text-white rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <i class="fas fa-wallet"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Chart Section --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="text-bold text-dark"><i
                                class="fas fa-chart-bar mr-2 text-primary"></i>สัดส่วนรายได้เปรียบเทียบรายเดือน</h5>
                    </div>
                    <div class="card-body p-4">
                        <div style="height: 400px; position: relative;">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');

            // สร้าง Gradient สำหรับกราฟเพื่อให้ดูแพงขึ้น
            const serviceGradient = ctx.createLinearGradient(0, 0, 0, 400);
            serviceGradient.addColorStop(0, '#ffc107'); // สีเหลืองทอง
            serviceGradient.addColorStop(1, '#ffeb3b');

            const productGradient = ctx.createLinearGradient(0, 0, 0, 400);
            productGradient.addColorStop(0, '#28a745'); // สีเขียว
            productGradient.addColorStop(1, '#81c784');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.',
                        'ต.ค.', 'พ.ย.', 'ธ.ค.'
                    ],
                    datasets: [{
                            label: 'บริการตัดผม',
                            data: @json($serviceData),
                            backgroundColor: serviceGradient,
                            borderRadius: 8,
                            borderSkipped: false,
                        },
                        {
                            label: 'ขายสินค้า',
                            data: @json($productData),
                            backgroundColor: productGradient,
                            borderRadius: 8,
                            borderSkipped: false,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        x: {
                            stacked: true,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            grid: {
                                color: '#f0f0f0'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '฿' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                font: {
                                    family: 'Kanit',
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            padding: 12,
                            titleFont: {
                                family: 'Kanit',
                                size: 16
                            },
                            bodyFont: {
                                family: 'Kanit',
                                size: 14
                            },
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('th-TH', {
                                            style: 'currency',
                                            currency: 'THB'
                                        }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap');

        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f4f7f6;
        }

        .uppercase {
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .transition-hover:hover {
            transform: translateY(-2px);
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .icon-shape {
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, .14), 0 7px 10px -5px rgba(0, 0, 0, .4);
        }

        /* ตกแต่ง Card ให้ดูทันสมัย */
        .card {
            transition: all 0.3s ease;
        }

        canvas {
            filter: drop-shadow(0px 10px 10px rgba(0, 0, 0, 0.05));
        }
    </style>
@stop
