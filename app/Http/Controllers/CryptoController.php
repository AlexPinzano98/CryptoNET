<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CryptoController extends Controller
{
    public function login(){
        return view('login');
    }

    public function validarLogin(Request $request){
        $datos = $request->except('_token','enviar'); // Datos del formulario
        $users=DB::table('usuarios')->where([
            ['email','=',$datos['email']],
            ['password','=',md5($datos['pswd'])]])->count();

        if ($users == 1){
            /* $all_usuario=DB::table('usuarios')->where([
                ['email','=',$datos['email']],
                ['password','=',md5($datos['pswd'])]])->get(); */
            
                $conseguir_id=DB::select('SELECT * FROM usuarios where email=? and password=?', [$datos['email'],md5($datos['pswd'])]);
            foreach ($conseguir_id as $id) {
                $id_user=$id->id_usuario;

            }

            $productos=DB::select('select * from productos');
            $request->session()->put('user',$id_user);
            return view('/mostrar_productos',compact('productos'));
        } else {
            $error="Correo o contraseña incorrectos";
            return view('login', compact('error'));
        }
    }

    public function addCarrito($id_producto){
        $id_usuario = session()->get('user');
        DB::insert('insert into carrito (id_producto,id_usuario) VALUES (?,?)', [$id_producto,$id_usuario]);
        $productos=DB::select('select * from productos');
        return view('/mostrar_productos',compact('productos'));
    }

    public function deleteCarrito($id_carrito){
        DB::delete('delete from carrito where id_carrito=?', [$id_carrito]);
        return view('carrito');
    }

    public function verCarrito(){
        $id_usuario = session()->get('user');
        $carrito=DB::select('SELECT * FROM carrito where id_usuario=?', [$id_usuario]);
        return view('carrito', compact('carrito'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Crypto  $crypto
     * @return \Illuminate\Http\Response
     */
    public function show(Crypto $crypto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Crypto  $crypto
     * @return \Illuminate\Http\Response
     */
    public function edit(Crypto $crypto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Crypto  $crypto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Crypto $crypto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Crypto  $crypto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Crypto $crypto)
    {
        //
    }
}
