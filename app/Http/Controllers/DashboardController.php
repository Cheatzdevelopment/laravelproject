<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Dashboard សម្រាប់ Owner (បង្ហាញទិន្នន័យលម្អិត និងក្រាប)
     */
    public function owner()
    {
        // ១. ទិន្នន័យសង្ខេប (Summary Cards)
        $totalSales = Order::where('status', 'paid')->sum('total_price'); // លុយសរុប
        $todaySales = Order::where('status', 'paid')->whereDate('created_at', Carbon::today())->sum('total_price'); // លុយថ្ងៃនេះ
        $totalOrders = Order::count(); // ចំនួន Order សរុប
        $totalUsers = User::count(); // ចំនួនអ្នកប្រើប្រាស់សរុប (បុគ្គលិក + អតិថិជន)
        $totalStaff = User::where('role', '!=', 'user')->count(); // ចំនួនបុគ្គលិក

        // ២. ទិន្នន័យសម្រាប់ Chart (ការលក់ប្រចាំថ្ងៃ ក្នុងរយៈពេល ៣០ ថ្ងៃចុងក្រោយ)
        $salesQuery = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_price) as total')
        )
        ->where('status', 'paid')
        ->where('created_at', '>=', Carbon::now()->subDays(30)) // យកតែ 30 ថ្ងៃចុងក្រោយ
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

        // រៀបចំទិន្នន័យសម្រាប់ Chart.js (បំបែកជា Array)
        $chartLabels = $salesQuery->pluck('date');
        $chartData = $salesQuery->pluck('total');

        // ៣. ការកម្មង់ថ្មីៗ (Recent Orders - សម្រាប់តារាងខាងស្តាំ)
        $recentOrders = Order::latest()->take(5)->get();

        return view('owner.dashboard', compact(
            'totalSales',
            'todaySales',
            'totalOrders',
            'totalUsers',
            'totalStaff',
            'chartLabels',
            'chartData',
            'recentOrders'
        ));
    }

    /**
     * Dashboard សម្រាប់ Cashier (បង្ហាញការកម្មង់ និងស្តុក)
     */
    public function cashier()
    {
        // ១. ស្ថិតិប្រចាំថ្ងៃ
        $totalProducts = Product::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $todayOrdersCount = Order::whereDate('created_at', Carbon::today())->count();

        // ២. ផលិតផលជិតអស់ (Low Stock)
        $lowStockProducts = Product::where('stock', '<=', 5)->count();

        // ៣. ការកម្មង់ថ្មីៗ (Recent Orders - 10 ជួរចុងក្រោយ)
        $recentOrders = Order::with('user')->latest()->take(10)->get();

        return view('cashier.dashboard', compact(
            'totalProducts',
            'pendingOrders',
            'todayOrdersCount',
            'lowStockProducts',
            'recentOrders'
        ));
    }

    /**
     * Dashboard សម្រាប់ Admin (បង្ហាញការគ្រប់គ្រង User)
     */
    public function admin()
    {
        // ១. ស្ថិតិអ្នកប្រើប្រាស់
        $totalCustomers = User::where('role', 'user')->count();
        $totalCashiers = User::where('role', 'cashier')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        // ២. ប្រតិបត្តិការសរុប (All Orders) - សម្រាប់កាតពណ៌បៃតង
        $totalOrders = Order::count();

        // ៣. អ្នកប្រើប្រាស់ថ្មីៗ (Recent Users)
        // មិនបង្ហាញ Owner ក្នុងតារាងទេ ដើម្បីកុំឱ្យច្រឡំលុប
        $recentUsers = User::where('role', '!=', 'owner')->latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalCashiers',
            'totalAdmins',
            'totalOrders',
            'recentUsers'
        ));
    }
}
