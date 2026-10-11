<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contact = \App\Models\Contact::first();
        return view('contact', compact('contact')); // เรียกไฟล์ที่เราเพิ่งสร้าง
    }
}
