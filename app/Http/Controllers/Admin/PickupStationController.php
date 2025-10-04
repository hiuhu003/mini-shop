<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PickupStation;

class PickupStationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q      = $request->string('q')->toString();
        $status = $request->string('status')->toString(); // "active" | "inactive" | ""

        $stations = PickupStation::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('address', 'like', "%{$q}%")
                        ->orWhere('city', 'like', "%{$q}%")
                        ->orWhere('notes', 'like', "%{$q}%");
                });
            })
            ->when($status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy('name')
            ->paginate(15)
            ->appends($request->query());

        return view('Admin.stations', compact('stations', 'q', 'status'));
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
        $data = $request->validate([
            'name'      => ['required','string','max:255'],
            'address'   => ['nullable','string','max:255'],
            'city'      => ['nullable','string','max:120'],
            'notes'     => ['nullable','string'],
            'is_active' => ['sometimes','boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        PickupStation::create($data);

        return back()->with('success', 'Pickup station created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,PickupStation $station)
    {
         $data = $request->validate([
            'name'      => ['required','string','max:255'],
            'address'   => ['nullable','string','max:255'],
            'city'      => ['nullable','string','max:120'],
            'notes'     => ['nullable','string'],
            'is_active' => ['sometimes','boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $station->update($data);

        return back()->with('success', 'Pickup station updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PickupStation $station)
    {
        $station->delete();

        return back()->with('success', 'Pickup station deleted.');
    }
}
