<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'date' => 'required|date',
        ]);

        Holiday::create($data);

        return back()->with('success','Holiday added.');
    }

    public function update(Request $request, Holiday $holiday)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'date' => 'required|date',
        ]);

        $holiday->update($data);

        return back()->with('success','Holiday updated.');
    }

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();

        return back()->with('success','Holiday deleted.');
    }
}