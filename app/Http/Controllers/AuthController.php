<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index(){
        return view('modules/auth/login');
    }
    public function logear(Request $request){
        $credenciales = $request->only("name", "password");
        if (Auth::attempt($credenciales)) {
            if ( auth()->user()->rol == 'admin') {
                return redirect()->route('admin_index');
            } else if(auth()->user()->rol == 'cliente') {
                return redirect()->route('cliente_index');
            } else {
                return $this->logout();
            }
        } else {
            return back()->withInput($credenciales);
        }
    } 
    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect()->route('login');     
    }
    public function agregarUsuario(){
        $item = new User();
        $item->name = 'cliente';
        $item->password = Hash::make('1234');
        $item->rol = 'cliente';
        $item->save();
        return $item;
    }
}
