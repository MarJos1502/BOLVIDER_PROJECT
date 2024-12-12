<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        // $currentUserId = Auth::id();

        // $users = User::where('id', '!=', $currentUserId) ->where('is_deleted','0')->get();
        $users = User::all();
        return view("users", compact("users"));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user-form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validated Input field, including the Image
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'. User::class],
            'password' => ['required', 'confirmed', Rules\Password::default()],
            'profile' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        //Handle the image upload if present
        if ($request->hasFile('profile')) {
            $filenameWithExtension = $request->file('profile')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('profile')->getClientOriginalExtension();
            $filenameToStore = $filename . '_' . time() . '_' . $extension;
            $request->file('profile')->storeAs('Uploads/users-profile', $filenameToStore);
            $validated['profile'] = $filenameToStore;
        }
          
        // Create the user
        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);

        // Redirect to the users index page
        return redirect()->route('users')->with('success', 'User added successfully.');
        
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
