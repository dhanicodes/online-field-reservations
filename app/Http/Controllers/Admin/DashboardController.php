<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FieldSchedule;
use App\Models\RequestCancelled;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index() {
        $now = Carbon::now();

        $user = User::where('is_admin', false)->get();
        // $jadwalTersedia = FieldSchedule::where('is_booked', 'available')->whereDate('date', '>=', $now->toDateString())->get();
        $jadwalTersedia = FieldSchedule::where('is_booked', 'available')->whereYear('date', now()->year)->whereMonth('date', now()->month)->get();
        $jadwalTerjual = FieldSchedule::where('is_booked', 'booked')->whereYear('date', now()->year)->whereMonth('date', now()->month)->get();
        $permintaanPembatalan = RequestCancelled::where('status', 'pending')->get();

        return view('admin.home', compact('user', 'jadwalTersedia', 'jadwalTerjual', 'permintaanPembatalan'));
    }
}
