<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        return view('cart');
    }
}