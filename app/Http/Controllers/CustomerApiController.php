<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerApiController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q', '');

        if (empty($q)) {
            return response()->json([]);
        }

        $customers = \App\Models\Customer::whereRaw("CONCAT(first_name, ' ', last_name, ' ', email) LIKE ?", ["%{$q}%"])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->limit(10)
            ->get();

        return response()->json($customers);
    }
}
