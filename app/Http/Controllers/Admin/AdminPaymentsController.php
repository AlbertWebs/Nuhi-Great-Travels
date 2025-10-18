<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesapalTransaction;

class AdminPaymentsController extends Controller
{
    public function index()
    {
        $payments = PesapalTransaction::latest()->paginate(15);
        return view('admin.payments.index', compact('payments'));
    }
}
