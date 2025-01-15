<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function countTables()
    {
        $dataCounts = [
            'analysis' => DB::table('analysis')->count(),
            'detailgeneration' => DB::table('detailgeneration')->count(),
            'doc_read' => DB::table('doc_read')->count(),
            'events' => DB::table('events')->count(),
            'finan_state' => DB::table('finan_state')->count(),
            'holder_stuc' => DB::table('holder_stuc')->count(),
            'manualsgovernan' => DB::table('manualsgovernan')->count(),
            'news' => DB::table('news')->count(),
            'newsprint' => DB::table('newsprint')->count(),
            'pay_lists' => DB::table('pay_lists')->count(),
            'petty_cashes' => DB::table('petty_cashes')->count(),
            'stock_prices' => DB::table('stock_prices')->count(),
            'users' => DB::table('users')->count(),
        ];

        return response()->json($dataCounts);
    }
}
