<?php
/**
 * Created by PhpStorm.
 * User: Servidor Symi
 * Date: 24/06/2015
 * Time: 04:06 PM
 */

namespace Symi\Repositories;
use Symi\Entities\Contrato;

class ContratoRep {


	public function all()
	{
		# code...
		$contratos = Contrato::all();
		return $contratos;
	}

	


}