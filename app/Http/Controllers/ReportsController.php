<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\AHS;
use PDF;


class ReportsController extends Controller
{
    public function analisa_task($id)
    {
        $ahs = AHS::find($id);
        $datas = DB::select("SELECT j.kode as kode_task, j.name as task, j.satuan as satuan_task, 
        d.coefficient as coefficient, d.sub_total as price_satuan, m.kode as kode_material, m.name as material, 
        m.satuan as satuan_material, m.price, m.status as status, a.total_labor, a.total_material, a.total
        FROM a_h_s_s a
        INNER JOIN jobs j ON j.id_job = a.id_job
        INNER JOIN ahs_details d ON a.id_ahs = d.id_ahs
        INNER JOIN materials m ON m.id_material = d.id_material
        WHERE a.id_ahs = $id AND d.deleted_at is null
        ORDER BY m.status DESC");

        $index = count($datas);
        for($i=0;$i<$index;$i++)
        {
            if($datas[$i]->status == "labor")
            {
                $j = $i;
                break;
            }
        }
        $pdf = PDF::loadView('analisa_task_report',['datas' => $datas, 'j'=>$j]);
        $pdf->setPaper([0,0,550,900]);
        return $pdf->stream();
    }

    public function analisa_task_all($id)
    {
        $ahs = AHS::find($id);
        $datas = DB::select("SELECT j.kode as kode_task, j.name as task, j.satuan as satuan_task, 
        d.coefficient as coefficient, d.sub_total as price_satuan, m.kode as kode_material, m.name as material, 
        m.satuan as satuan_material, m.price, m.status as status, a.total_labor, a.total_material, a.total
        FROM a_h_s_s a
        INNER JOIN jobs j ON j.id_job = a.id_job
        INNER JOIN ahs_details d ON a.id_ahs = d.id_ahs
        INNER JOIN materials m ON m.id_material = d.id_material
        WHERE d.deleted_at is null
        ORDER BY j.name, m.status DESC");

        $index = count($datas);
        for($i=0;$i<$index;$i++)
        {
            if($datas[$i]->status == "labor")
            {
                $j = $i;
                break;
            }
        }
        $pdf = PDF::loadView('analisa_task_all_report',['datas' => $datas, 'j'=>$j]);
        $pdf->setPaper([0,0,550,900]);
        return $pdf->stream();
    }
}
