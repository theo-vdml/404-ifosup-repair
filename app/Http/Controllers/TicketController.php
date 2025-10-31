<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderBy = request()->get('sort', 'created_at');
        $orderDirection = request()->get('direction', 'desc');
        $allowedSorts = ['id', 'title', 'status', 'created_at', 'customer_full_name'];
        $allowedDirections = ['asc', 'desc'];
        $orderBy = in_array($orderBy, $allowedSorts) ? $orderBy : 'created_at';
        $orderDirection = in_array($orderDirection, $allowedDirections) ? $orderDirection : 'desc';

        $tickets = Ticket::query()
            ->select('tickets.*')
            ->join('customers', 'tickets.customer_id', '=', 'customers.id')
            ->addSelect(DB::raw("CONCAT(customers.first_name, ' ', customers.last_name) as customer_full_name"));

        if ($orderBy === 'customer_full_name') {
            $tickets->orderBy(DB::raw("customer_full_name"), $orderDirection);
        } else {
            $tickets->orderBy($orderBy, $orderDirection);
        }

        $tickets = $tickets->paginate(10)->withQueryString();

        return view('dashboard.tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('dashboard.tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Ticket::create($data);

        return redirect()->route('tickets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('dashboard.tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        return view('dashboard.tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
