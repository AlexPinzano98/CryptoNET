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

    public function addCarrito($id_producto,$precio){
        $id_usuario = session()->get('user');
        $one = 1;
        $comprovar = $users=DB::table('carrito')->where([
            ['id_usuario','=',$id_usuario],
            ['id_producto','=',$id_producto]
            ])->count();
        // Comprovamos si ya hay un registro en la tabla carrito
        if ($comprovar == 0){ // Si no existe lo añadimos
            DB::insert('insert into carrito (id_producto,id_usuario,unidades,preciototal) VALUES (?,?,?,?)', [$id_producto,$id_usuario,$one,$precio]);
        } // Si existe no hacemos nada (ya está insertado)

        $productos=DB::select('select * from productos');
        return view('/mostrar_productos',compact('productos'));
    }

    public function verProductos(){
        $productos=DB::select('select * from productos');
        return view('/mostrar_productos',compact('productos'));
    }

    public function deleteCarrito($id_carrito){
        DB::delete('delete from carrito where id_carrito=?', [$id_carrito]);
        return view('carrito');
    }

    public function verCarrito(){
        $id_usuario = session()->get('user');
        $productosCarrito = DB::select('SELECT p.id_producto,p.nombre,p.precio,p.foto,c.id_usuario,c.unidades,c.preciototal FROM productos AS p
        LEFT JOIN carrito AS c ON c.id_producto=p.id_producto
        WHERE c.id_usuario=?',[$id_usuario]);
        $preciototal = 0;
        foreach ($productosCarrito as $producto) {
            $preciototal+=$producto->preciototal;
        }
        return view('carrito',compact('productosCarrito'));
    }

    public function delete($id){
        DB::table('carrito')->where('id_producto','=',$id)->delete();
        return redirect('verCarrito');
    }

    public function updateUnidad(Request $request){
        try {
            $id_user = session()->get('user');
            $id_p = $request->input('id_p');
            $unidades = $request->input('unidades');
            $precio = $request->input('precio');

            // DB::table('carrito')->where([['id_usuario','=',$id_user],
            // ['id_producto','=',$id_p]
            // ])->update([['unidades'=>$unidades],['preciototal'=>$totalprice]]);

            DB::update('UPDATE carrito SET unidades = ? , preciototal = ? WHERE id_usuario = ? AND id_producto = ?',[$unidades,$precio,$id_user,$id_p]);

            // print_r($id_p);
            // print_r($unidades);
            return response()->json(array('resultado'=>'OK'), 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(array('resultado'=>'NOK'.$th->getMessage()), 200);
        }
    }

    public function pagar(){
        echo "hola";
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
