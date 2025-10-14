<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // General search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereRaw("CONCAT(first_name, ' ', last_name, ' ', email, ' ', COALESCE(phone, ''), ' ', COALESCE(address, ''), ' ', COALESCE(notes, '')) LIKE ?", ["%{$search}%"]);
        }

        // Advanced filters - only apply if advanced search button was pressed
        if ($request->has('advanced_search')) {
            if ($request->filled('name')) {
                $name = $request->name;
                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$name}%"]);
            }

            if ($request->filled('email')) {
                $query->where('email', 'like', "%{$request->email}%");
            }

            if ($request->filled('phone')) {
                $query->where('phone', 'like', "%{$request->phone}%");
            }

            if ($request->filled('address')) {
                $query->where('address', 'like', "%{$request->address}%");
            }
        }

        // Order by
        $orderBy = $request->get('order_by', 'created_at_desc');
        switch ($orderBy) {
            case 'created_at_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'created_at_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'full_name_asc':
                $query->orderBy('first_name')->orderBy('last_name');
                break;
            case 'full_name_desc':
                $query->orderBy('first_name', 'desc')->orderBy('last_name', 'desc');
                break;
            case 'email_asc':
                $query->orderBy('email');
                break;
            case 'email_desc':
                $query->orderBy('email', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $customers = $query->paginate(10)->withQueryString();

        return view('dashboard.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Customer::create($data);

        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('dashboard.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('dashboard.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $customer->update($data);

        return redirect()->route('customers.show', $customer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index');
    }
}
