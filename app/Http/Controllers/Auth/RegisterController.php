<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
//use App\User;
use App\Usuario;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'rut' => ['required', 'string', 'max:12', 'unique:usuarios'],
            'primerNombre' => ['required', 'string', 'max:30'],
            'segundoNombre' => ['string', 'max:30', 'nullable'],
            'primerApellido' => ['required', 'string', 'max:30'],
            'segundoApellido' => ['string', 'max:30', 'nullable'],
            'fechaNacimiento' => ['date'],
            'telefono' => ['string', 'max:12'],
            'urlFoto' => ['required', 'file', 'mimes:jpeg,jpg,png'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return Usuario::create([
            'rut' => $data['rut'],
            'primerNombre' => $data['primerNombre'],
            'segundoNombre' => $data['segundoNombre'],
            'primerApellido' => $data['primerApellido'],
            'segundoApellido' => $data['segundoApellido'],
            'fechaNacimiento' => $data['fechaNacimiento'],
            'telefono' => $data['telefono'],
            'urlFoto' => $data['urlFoto']->store('usuarios'),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
