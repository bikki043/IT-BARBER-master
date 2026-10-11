@extends('adminlte::page')

@section('title', 'Contact Management | IT BARBER')

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

        /* Database Card Design */
        .card-db {
            background: #ffffff;
            border: 1px solid var(--db-border);
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            overflow: hidden;
        }

        .card-db-header {
            background: #fdfdfd;
            border-bottom: 1px solid var(--db-border);
            padding: 15px 25px;
            font-weight: 600;
            color: #8898aa;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.8rem;
        }

        /* Form Styling */
        .form-label-db {
            font-weight: 500;
            color: var(--db-dark);
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .form-control-db {
            border: 1px solid var(--db-border);
            border-radius: 8px;
            padding: 12px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control-db:focus {
            border-color: var(--db-primary);
            box-shadow: 0 0 0 3px rgba(197, 160, 89, 0.1);
            outline: none;
        }

        /* Buttons */
        .btn-save-db {
            background: var(--db-primary);
            color: #fff !important;
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(197, 160, 89, 0.2);
            transition: 0.3s;
        }

        .btn-save-db:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 14px rgba(197, 160, 89, 0.3);
            opacity: 0.9;
        }

        /* Map Preview */
        .map-preview-box {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--db-border);
            margin-top: 15px;
        }

        .map-preview-box iframe {
            width: 100%;
            height: 250px;
            border: none;
        }
    </style>
@stop

@section('content_header')
    <div class="page-header-db animate__animated animate__fadeIn">
        <div class="container-fluid">
            <h1 class="main-title-db">
                <i class="fas fa-address-card"></i> 
                จัดการข้อมูลการติดต่อร้าน
            </h1>
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

        <div class="row">
            <div class="col-lg-8">
                <div class="card card-db animate__animated animate__fadeInLeft">
                    <div class="card-db-header">
                        <i class="fas fa-edit mr-1"></i> รายละเอียดข้อมูลการติดต่อ
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.contact.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label-db">เบอร์โทรศัพท์ติดต่อ</label>
                                    <input type="text" name="phone" class="form-control form-control-db" value="{{ $contact->phone }}" placeholder="0xx-xxx-xxxx">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label-db">Line ID / OA</label>
                                    <input type="text" name="line_id" class="form-control form-control-db" value="{{ $contact->line_id }}" placeholder="@itbarber">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label-db"><i class="fab fa-facebook text-primary mr-1"></i> Facebook URL</label>
                                    <input type="url" name="facebook" class="form-control form-control-db" value="{{ $contact->facebook }}" placeholder="https://facebook.com/yourpage">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label-db"><i class="fab fa-instagram text-danger mr-1"></i> Instagram URL</label>
                                    <input type="url" name="instagram" class="form-control form-control-db" value="{{ $contact->instagram }}" placeholder="https://instagram.com/yourprofile">
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label-db">ที่อยู่ร้าน (แสดงผลหน้าเว็บ)</label>
                                    <textarea name="address" class="form-control form-control-db" rows="3" placeholder="ระบุเลขที่ตั้ง อาคาร ถนน สาขา...">{{ $contact->address }}</textarea>
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label-db">Google Map Iframe Code</label>
                                    <textarea name="google_map_iframe" class="form-control form-control-db text-monospace" style="font-size: 11px;" rows="4" placeholder="วางโค้ด <iframe ...> ที่นี่">{{ $contact->google_map_iframe }}</textarea>
                                    <small class="text-muted mt-2 d-block">
                                        <i class="fas fa-info-circle mr-1"></i> ไปที่ Google Maps เลือก "แบ่งปัน" > "ฝังแผนที่" แล้วคัดลอก HTML มาวาง
                                    </small>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="text-right">
                                <button type="submit" class="btn btn-save-db">
                                    <i class="fas fa-save mr-2"></i> อัปเดตข้อมูลทั้งหมด
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-db animate__animated animate__fadeInRight">
                    <div class="card-db-header">
                        <i class="fas fa-map-marked-alt mr-1"></i> พรีวิวแผนที่ปัจจุบัน
                    </div>
                    <div class="card-body p-3">
                        @if($contact->google_map_iframe)
                            <div class="map-preview-box shadow-sm">
                                {!! $contact->google_map_iframe !!}
                            </div>
                            <div class="mt-3 text-center">
                                <span class="badge badge-success px-3 py-2" style="font-weight: 400; border-radius: 50px;">
                                    <i class="fas fa-check-circle mr-1"></i> ติดตั้งแผนที่เรียบร้อยแล้ว
                                </span>
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-map-marker-alt fa-3x mb-3 opacity-25"></i>
                                <p>ยังไม่ได้ระบุโค้ดแผนที่</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card card-db mt-4 animate__animated animate__fadeInUp">
                    <div class="card-body p-4 bg-light">
                        <h6 class="font-weight-bold mb-3"><i class="fas fa-lightbulb text-warning mr-2"></i>ข้อแนะนำ</h6>
                        <ul class="text-muted small pl-3 mb-0" style="line-height: 1.8;">
                            <li>ตรวจสอบเบอร์โทรศัพท์ให้ถูกต้องเพื่อให้ลูกค้าโทรติดทันที</li>
                            <li>URL โซเชียลมีเดียควรขึ้นต้นด้วย <strong>https://</strong></li>
                            <li>ที่อยู่ควรระบุจุดสังเกตใกล้เคียงเพื่อให้หาได้ง่ายขึ้น</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
