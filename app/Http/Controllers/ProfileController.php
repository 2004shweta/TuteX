<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $education = $user->education()->orderBy('start_date', 'desc')->get();
        return view('profile.show', compact('user', 'education'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
        ]);

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully');
    }

    public function addEducation(Request $request)
    {
        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = Auth::id();
        
        Education::create($validated);

        return redirect()->route('profile.show')->with('success', 'Education added successfully');
    }

    public function deleteEducation(Education $education)
    {
        if ($education->user_id !== Auth::id()) {
            abort(403);
        }

        $education->delete();

        return redirect()->route('profile.show')->with('success', 'Education deleted successfully');
    }
} 