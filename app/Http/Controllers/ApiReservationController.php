<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiReservationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json($request->user()->reservations()
            ->with(['pack', 'products.product'])
            ->latest()
            ->paginate(10));
    }
}
