<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerApiController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->get('id');

        if ($id) {
            $customer = Customer::find($id);
            return response()->json($customer);
        }

        $q = $request->get('q', '');

        if (empty($q)) {
            return response()->json([]);
        }

        $customers = Customer::whereRaw("CONCAT(first_name, ' ', last_name, ' ', email) LIKE ?", ["%{$q}%"])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->limit(10)
            ->get();

        return response()->json($customers);
    }
}
