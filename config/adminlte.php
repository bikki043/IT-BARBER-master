    <?php

    return [

        /*
        |--------------------------------------------------------------------------
        | User Menu
        |--------------------------------------------------------------------------
        */
        'usermenu_enabled' => true,
        'usermenu_header' => true,
        'usermenu_header_class' => 'bg-dark',
        'usermenu_image' => true,
        'usermenu_desc' => true,
        'usermenu_profile_url' => false,

        /*
        |--------------------------------------------------------------------------
        | Menu Items
        |--------------------------------------------------------------------------
        */
        'menu' => [
            // เมนูหลัก
            ['header' => 'MAIN NAVIGATION'],
            [
                'text' => 'แดชบอร์ดการจอง',
                'url'  => 'admin/dashboard',
                'icon' => 'fas fa-fw fa-calendar-check',
                'active' => ['admin/dashboard*'],
            ],
            [
                'text' => 'จัดการช่างตัดผม',
                'url'  => 'admin/barbers',
                'icon' => 'fas fa-fw fa-cut',
                'active' => ['admin/barbers*'],
            ],
            [
                'text' => 'จัดการบริการ/ทรงผม',
                'url'  => 'admin/services',
                'icon' => 'fas fa-fw fa-list',
                'active' => ['admin/services*'],
            ],

            [
                'text' => 'จัดการเกี่ยวกับเรา',
                'url'  => 'admin/about',
                'icon' => 'fas fa-fw fa-info-circle',
                'active' => ['admin/about*'],
            ],

            [
                'text' => 'จัดการผลงาน (รูปภาพ)',
                'url'  => 'admin/works',
                'icon' => 'fas fa-fw fa-images',
                'active' => ['admin/works*'],
            ],

            [
                'text' => 'จัดการการติดต่อ',
                'url'  => 'admin/contact', // ต้องตรงกับ route ที่เราตั้ง
                'icon' => 'fas fa-fw fa-envelope',
            ],

            [
                'text' => 'จัดการสินค้า (Store)',
                'url'  => 'admin/products',
                'icon' => 'fas fa-fw fa-shopping-bag',
                'active' => ['admin/products*'],
                'label' => 'HOT', // ใส่ป้ายไฟสีแดงๆ ให้ดูเด่น
                'label_color' => 'danger',
            ],

            [
                'text' => 'รายการสั่งซื้อสินค้า',
                'url'  => 'admin/orders', // ต้องตรงกับ route ที่เราตั้ง
                'icon' => 'fas fa-fw fa-file-invoice-dollar',
            ],

            [
                'text' => 'สรุปยอดขาย',
                'url'  => 'admin/analytics', // ต้องตรงกับ route ที่เราตั้ง
                'icon' => 'fas fa-fw fa-chart-bar',
            ],




            // เมนูบัญชี
            ['header' => 'ACCOUNT SETTINGS'],
            [
                'text' => 'โปรไฟล์',
                'url'  => 'admin/profile',
                'icon' => 'fas fa-fw fa-user',
            ],
            [

                'icon' => 'fas fa-fw fa-sign-out-alt',
                'url'  => '#', // เปลี่ยนเป็น # เพื่อไม่ให้มัน Redirect แบบ GET
                'onclick' => "event.preventDefault(); document.getElementById('logout-form').submit();",
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Admin Panel Classes
        |--------------------------------------------------------------------------
        */
        'layout_fixed_navbar' => false,
        'classes_topnav' => 'navbar-dark bg-dark',
        'classes_sidebar' => 'sidebar-dark-warning elevation-4',
        'classes_sidebar_nav' => 'nav-flat',
        'classes_topnav_nav' => 'navbar-expand',
        'classes_topnav_container' => 'container',

        /*
        |--------------------------------------------------------------------------
        | Stylesheets
        |--------------------------------------------------------------------------
        */
        'stylesheets' => [
            'css/custom_admin.css',
        ],

        /*
        |--------------------------------------------------------------------------
        | Logout Method
        |--------------------------------------------------------------------------
        */
        'logout_method' => 'POST',
        'logout_url' => 'logout',


        /*
        |--------------------------------------------------------------------------
        | Auth URLs
        |--------------------------------------------------------------------------
        */
        'login_url' => 'login',
        'register_url' => 'register',
        'password_reset_url' => 'forgot-password',

        'logout_method' => 'POST',
        'logout_url' => 'logout',

        'login_url' => 'login',
        'register_url' => 'register',
        'password_reset_url' => 'forgot-password',

    ];
