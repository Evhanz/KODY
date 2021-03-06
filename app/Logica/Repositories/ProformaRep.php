<?php
/**
 * Created by PhpStorm.
 * User: Servidor Symi
 * Date: 15/07/2015
 * Time: 09:43 AM
 */

namespace Symi\Repositories;
use Symi\Entities\Proforma;
use Symi\Entities\EstadoProforma;


class ProformaRep {

    public function all(){
        return Proforma::all();
    }

    public function find($id)
    {
        return Proforma::find($id);
    }

    /*get Proformaspor coincidencia*/
    public function GetProformaByNumero($numero){

        try{
            $proforma = Proforma::where('numero','like',$numero)->orWhere('numero','like','%'.$numero.'%')->get();
        }catch (\Exception $e){

            $proforma = 0;
        }

        return $proforma;

    }


    /*get proformas por num numero unico*/
    public function GetProformaFindByNumero($numero){

        try{
            $proforma = Proforma::where('numero','like',$numero)->firstOrFail();
        }catch (\Exception $e){

            $proforma = 0;
        }

        return $proforma;

    }

    public function getProformaByArea($area)
    {
        $proformas = Proforma::select('proformas.id','proformas.numero','proformas.descripcion','areas.descripcion as area')
                             ->join('areas', 'areas.id', '=', 'proformas.area_id')
                             ->where('area_id','like',$area)
                             ->get();
        return $proformas;
    }


    public function regProforma($data){

        $area = $data['area'];


        $rules=[

            'numero' => 'required|min:4|unique:proformas',
            'descripcion' => 'required|min:4',
            'monto_MO' => 'required',
            'f_inicio' => 'required',
            'n_dias' => 'required',
            'maquinaria_equipo' => 'required',
            'materiales' =>'required'

        ];

        $data = array_only($data,array_keys($rules));
        $validation = \Validator::make($data,$rules);

        $isValid = $validation->passes();
        
        if ($isValid) {

            $estado = $this->newEstado('creada');

            $proforma = new Proforma($data);
            $proforma->f_fin = date('Y-m-d');
            $proforma->area_id = $area;
            $proforma->estado_id = $estado->id;
            $proforma->save();
            return 1;

        }else{
            return $validation->messages();
        }

    }

    public function updateProforma($data){

        $area = $data['area'];
        $id = $data['id'];


        $rules=[

            'numero' => 'required|min:4|unique:proformas,numero,'.$data['id'],
            'descripcion' => 'required|min:4',
            'monto_MO' => 'required|min:4',
            'f_inicio' => 'required|date',
            'n_dias' => 'required',
            'maquinaria_equipo' => 'required',
            'materiales' =>'required'

        ];

        $data = array_only($data,array_keys($rules));
        $validation = \Validator::make($data,$rules);

        $isValid = $validation->passes();
        
        if ($isValid) {

            $proforma = Proforma::find($id);
            $proforma->numero = $data['numero'];
            $proforma->descripcion = $data['descripcion'];
            $proforma->monto_MO = $data['monto_MO'];
            $proforma->maquinaria_equipo = $data['maquinaria_equipo'];
            $proforma->materiales = $data['materiales'];
            $proforma->f_inicio = $data['f_inicio'];
            $proforma->n_dias = $data['n_dias'];
            $proforma->area_id = $area;
            $proforma->save();
            return 1;

        }else{
            return $validation->messages();
        }

    }



    public function newEstado($tipo)
    {
        $estado = new EstadoProforma();
        $estado->tipo = 'creada';
        $estado->fecha = date('Y-m-d');
        $estado->save();

        return $estado;
    }


    public function getInitAlldata()
    {
        $proformas = Proforma::orderBy('id','desc')->take(20)->get();

        return $proformas;
    }

}