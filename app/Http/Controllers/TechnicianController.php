<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $technicians = User::sorted('created_at', 'desc')->filtered()->paginate(10)->withQueryString();

        return view('dashboard.technicians.index', compact('technicians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.technicians.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,technician',
        ]);


        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('technicians.index')->with('success', 'Technicien supprimé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $technician)
    {
        return view('dashboard.technicians.show', compact('technician'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $technician)
    {
        return redirect()->route('technicians.show', $technician);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $technician)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $technician->id,
            'role' => 'required|in:admin,technician',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update password if provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Remove password_confirmation from data
        unset($data['password_confirmation']);

        $technician->update($data);

        return redirect()->route('technicians.show', $technician)->with('success', 'Technicien mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $technician)
    {
        $technician->delete();

        return redirect()->route('technicians.index');
    }
}
