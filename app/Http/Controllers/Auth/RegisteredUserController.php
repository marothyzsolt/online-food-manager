<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'type' => 'required|string',
                'password' => 'required|string|confirmed|min:8',
                'zip' => 'required|min:4|max:4',
                'city' => 'required',
                'address' => 'required',
                'phone' => 'required',
            ]);
        } catch (ValidationException $e){
            return redirect()->route('register')->withErrors($e->errors())->withInput($request->input());

        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'zip' => $request->zip,
            'city' => $request->city,
            'address' => $request->address,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
