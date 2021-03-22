<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class EnviarMensage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $datos = DB::select('SELECT MAX(id_factura),descripcion,preciototal FROM facturas');
        // $maxValue = facturas::max('id_factura');
        $id_f = DB::table('facturas')->max('id_factura');


        $result = DB::select('SELECT * FROM facturas WHERE id_factura = ?',[$id_f]);


        // $result = json_decode($pepe, true);

        // print_r($result);


        return $this->from("danirueda.estudios@gmail.com")->subject('Pedido en CryptoNET')->view('descEmail',compact('result'));
    }
}
