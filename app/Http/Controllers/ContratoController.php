<?php
/**
 * Created by PhpStorm.
 * User: Servidor Symi
 * Date: 24/06/2015
 * Time: 04:32 PM
 */

namespace symi\Http\Controllers;
use Symi\Repositories\ContratoRep;

class ContratoController extends Controller{

    protected $contratoRep;

    public function __construct(ContratoRep $contratoRep){

        $this->contratoRep = $contratoRep;

    }

    public function index(){

    	$contratos = $this->contratoRep->all();

    	return view('RH/Contratos/viewAllContratos',compact('contratos'));


    }


}