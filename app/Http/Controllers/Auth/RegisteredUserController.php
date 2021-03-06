<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller {

//    public function create()
//    {
//        return view('auth.register');
//    }


    public function store( Request $request ) {
        $request->validate( [
            'name'      => [ 'required', 'string', 'max:255' ],
            'email'     => [ 'required', 'string', 'email', 'max:255', 'unique:users' ],
            'password'  => [ 'required', 'confirmed', Rules\Password::defaults() ],
            'user_type' => [ 'required', 'integer', 'max:1' ],
        ] );

        $user = User::create( [
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make( $request->password ),
            'user_type' => $request->user_type,
        ] );

        event( new Registered( $user ) );

        Auth::login( $user );

        return json_encode( [ 'success' => 'ok', 'message' => 'Регистрация успешно выполнена!' ] );
    }
}
