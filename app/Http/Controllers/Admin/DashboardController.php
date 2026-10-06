<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pack;
use App\Models\Product;
use App\Models\Reservation;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'productsCount' => Product::query()->count(),
            'packsCount' => Pack::query()->count(),
            'pendingReservations' => Reservation::query()->where('status', 'pending')->count(),
            'confirmedReservations' => Reservation::query()->where('status', 'confirmed')->count(),
            'latestReservations' => Reservation::query()->with('pack')->latest()->limit(8)->get(),
        ]);
    }
}
