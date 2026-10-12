<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with('user')
            ->latest()
            ->take(50)
            ->get();

        return view('appointments', ['appointments' => $appointments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'reason' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
        ]);

        Appointment::create($validated);

        return redirect('appointments')->with('succes', 'Cita agendada!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        return view('appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'reason' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'date'],
        ]);

        if (empty($validated['reason'])) {
            unset($validated['reason']);
        }

        if (empty($validated['date'])) {
            unset($validated['date']);
        }

        $appointment->update($validated);

        return redirect('appointments')->with('succes', 'Cita medica editada!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect('appointments')->with('succes', 'Cita medica eliminada!');
    }
}
