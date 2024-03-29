<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarMensage;
use Illuminate\Support\Facades\Storage;

class CryptoController extends Controller
{
    public function login(){
        return view('login');
    }
    public function cerrar_sesion(){
        session()->forget(['user']);
        return redirect('/');
    }
    public function validarLogin(Request $request){
        $datos = $request->except('_token','enviar'); // Datos del formulario
        $users=DB::table('usuarios')
        ->where('email','=',$datos['email'])
        ->where('password','=',$datos['pswd'])
        ->count();
        
    
        if ($users == 1){
            /* $all_usuario=DB::table('usuarios')->where([
                ['email','=',$datos['email']],
                ['password','=',md5($datos['pswd'])]])->get(); */

                $conseguir_id=DB::select('SELECT * FROM usuarios where email=? and password=?', [$datos['email'],$datos['pswd']]);
            foreach ($conseguir_id as $id) {
                $id_user=$id->id_usuario;
                $email=$id->email;
            }

            $productos=DB::select('select * from productos');
            $request->session()->put('user',$id_user);
            $request->session()->put('email',$email);
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
        if ((session()->has('user'))) { // Así comprovamos que exista la session usuarios
            $productos=DB::select('select * from productos');
            return view('/mostrar_productos',compact('productos'));
        } else {
            return view('login');
        }

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

    public function calcularTotal(){
        $datos=DB::select('SELECT productos.nombre, carrito.unidades, carrito.id_producto, carrito.preciototal FROM carrito
        LEFT JOIN productos ON productos.id_producto = carrito.id_producto
        where id_usuario=?', [session()->get('user')]);
        $preuTotal = 0;
        $desc = '';
        foreach ($datos as $dato) {
            $preuTotal = $preuTotal + $dato->preciototal;
            $desc = $desc . ($dato->unidades . ' unidad/es de ' . $dato->nombre . '. ' );
        }
        // print_r($preuTotal);
        return response()->json(array('total'=>$preuTotal, 'desc'=>$desc), 200);
    }

    public function pagar(){
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('services.paypal.clientid'),     // ClientID
                config('services.paypal.secret')      // ClientSecret
            )
        );
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new \PayPal\Api\Amount();
        //CALCULAMOS EL PRECIO TOTAL
        $datos=DB::select('SELECT * FROM carrito where id_usuario=?', [session()->get('user')]);
        $preuTotal = 0;
        foreach ($datos as $dato) {
            $preuTotal = $preuTotal + $dato->preciototal;
        }
        $amount->setTotal($preuTotal);
        $amount->setCurrency('EUR');

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);
        //le envioa la pagina informacion del id
        //si se cancela lo llevo a la pagina que quiero
        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(url("comprado/"))->setCancelUrl(url("/"));

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($apiContext);
            //me redirige a la pagina de paypal
            return redirect()->away( $payment->getApprovalLink());

        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            echo $ex->getData();
        }
    }

    public function comprado(){
        // return 'PAGO REALIZADO CON ÉXITO';
        $id_user = session()->get('user');
        // Anter de borrar los datos del carrito hemos de crear un registro en la tabla factura
        // Datos de la factura: ID_factura, ID_usuario, Importe total y descripción de la facutras
        $datos=DB::select('SELECT productos.nombre, carrito.unidades, carrito.id_producto, carrito.preciototal FROM carrito
        LEFT JOIN productos ON productos.id_producto = carrito.id_producto
        where id_usuario=?', [$id_user]);
        $preuTotal = 0;
        $desc = '';
        foreach ($datos as $dato) {
            $preuTotal = $preuTotal + $dato->preciototal;
            $desc = $desc . ($dato->unidades . ' unidad/es de ' . $dato->nombre . '. ' );
        }
        // Ahora hacer un insert into de los valores
        DB::insert('insert into facturas (id_usuario,descripcion,preciototal) VALUES (?,?,?)', [$id_user,$desc,$preuTotal]);

        DB::table('carrito')->where('id_usuario','=',$id_user)->delete();

        // AHORA ENVIAMOS EL EMAIL
        $email_user = session()->get('email');
        $this->sendEmail($email_user);


        $productos=DB::select('select * from productos');
        return view('/mostrar_productos',compact('productos'));
    }

    public function sendEmail($email)
    {
        Mail::to($email)->send(new EnviarMensage);
    }
}