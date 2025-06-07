<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function index(){
        $title = 'Admin payments';
        return view('admin.payment.index',compact('title'));
    }
}
