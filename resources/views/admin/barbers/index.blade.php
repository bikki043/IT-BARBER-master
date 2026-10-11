@extends('adminlte::page')

@section('title', 'Database Management | IT BARBER')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap');

        :root {
            --db-primary: #c5a059;
            --db-dark: #2c3e50;
            --db-light-bg: #f8f9fa;
            --db-border: #e9ecef;
        }

        body {
            font-family: 'Kanit', sans-serif;
            background-color: var(--db-light-bg);
            color: var(--db-dark);
        }

        /* Header Style */
        .page-header-db {
            padding: 1.5rem 0;
            border-bottom: 1px solid var(--db-border);
            margin-bottom: 2rem;
            background: #fff;
            margin-top: -20px;
            margin-left: -20px;
            margin-right: -20px;
            padding-left: 2rem;
            padding-right: 2rem;
        }

        .main-title-db {
            font-weight: 600;
            font-size: 1.5rem;
            color: var(--db-dark);
            margin: 0;
            display: flex;
            align-items: center;
        }

        .main-title-db i {
            color: var(--db-primary);
            margin-right: 12px;
        }

        /* Database Card */
        .card-db {
            background: #ffffff;
            border: 1px solid var(--db-border);
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            overflow: hidden;
        }

        /* Table Design */
        .table-db {
            margin-bottom: 0;
        }

        .table-db thead th {
            background: #fdfdfd;
            border-top: none;
            border-bottom: 2px solid var(--db-border);
            color: #8898aa;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px 25px;
            font-weight: 600;
        }

        .table-db tbody tr {
            transition: all 0.2s;
        }

        .table-db tbody tr:hover {
            background-color: #fcfaf5 !important;
        }

        .table-db td {
            padding: 15px 25px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid var(--db-border);
        }

        /* Data Styling */
        .emp-name {
            display: block;
            font-weight: 600;
            color: #32325d;
            font-size: 1.05rem;
        }

        .emp-id {
            display: block;
            font-size: 0.8rem;
            color: #8898aa;
        }

        .img-db {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid var(--db-border);
        }

        /* Badges */
        .badge-db-position {
            background: #e8f0fe;
            color: #1a73e8;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .badge-db-branch {
            background: #fef1e8;
            color: #e67e22;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Buttons */
        .btn-add-db {
            background: var(--db-primary);
            color: #fff !important;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(197, 160, 89, 0.2);
            transition: 0.3s;
        }

        .btn-add-db:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 14px rgba(197, 160, 89, 0.3);
        }

        .action-icon {
            padding: 8px;
            border-radius: 6px;
            transition: 0.2s;
            margin: 0 2px;
        }

        .action-edit { color: #5e72e4; background: #f0f2ff; }
        .action-delete { color: #f5365c; background: #fef1f4; }
        .action-icon:hover { opacity: 0.8; transform: scale(1.1); }

    </style>
@stop

@section('content_header')
    <div class="page-header-db animate__animated animate__fadeIn">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1 class="main-title-db">
                <i class="fas fa-database"></i> 
                ฐานข้อมูลช่างตัดผม
            </h1>
            <a href="{{ route('admin.barbers.create') }}" class="btn btn-add-db">
                <i class="fas fa-plus mr-2"></i> เพิ่มข้อมูลใหม่
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid px-4">
        
        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm animate__animated animate__fadeInDown" style="border-radius: 12px;">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card card-db animate__animated animate__fadeInUp">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-db table-hover">
                        <thead>
                            <tr>
                                <th style="width: 80px;">รูปภาพ</th>
                                <th>รายละเอียดช่างตัดผม</th>
                                <th>ตำแหน่ง / บทบาท</th>
                                <th>สาขาหลัก</th>
                                <th class="text-right">เเก้ไข</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barbers as $barber)
                                <tr>
                                    <td>
                                        <img src="{{ $barber->image_path ? asset('storage/' . $barber->image_path) : 'https://ui-avatars.com/api/?name='.urlencode($barber->name).'&background=random' }}" 
                                             class="img-db shadow-sm">
                                    </td>
                                    <td>
                                        <span class="emp-name">{{ $barber->name }}</span>
                                        <span class="emp-id">UID: #ITB-{{ str_pad($barber->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge-db-position">
                                            <i class="fas fa-cut mr-1" style="font-size: 10px;"></i> {{ $barber->position }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-db-branch">
                                            <i class="fas fa-store mr-1" style="font-size: 10px;"></i> {{ $barber->branch }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.barbers.edit', $barber->id) }}" 
                                           class="action-icon action-edit" title="Edit Record">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.barbers.destroy', $barber->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-icon action-delete border-0" 
                                                    onclick="return confirm('Confirm data deletion?')" title="Delete Record">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Footer สำหรับแสดงจำนวนข้อมูลทั้งหมด (ถ้ามี pagination) --}}
            <div class="card-footer bg-white border-top py-3 text-muted" style="font-size: 0.9rem;">
                เเสดง <strong>{{ $barbers->count() }}</strong> ช่างตัดผมในระบบ
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        // สามารถเพิ่ม DataTables.js ตรงนี้ได้ถ้าต้องการให้ค้นหาหรือเรียงลำดับได้
        $(document).ready(function() {
            // Logic ค้นหาเบื้องต้น
        });
    </script>
@stop
