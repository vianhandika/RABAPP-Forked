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
        
        $j=0;
        $index = count($datas);
        for($i=0;$i<$index;$i++)
        {
            if($datas[$i]->status == "labor")
            {
                $j = $i;
                break;
            }
            if($datas[$i]->status == "material")
            {
                $j +=1;
            }
        }
        $pdf = PDF::loadView('analisa_task_report',['datas' => $datas, 'j'=>$j]);
        $pdf->setPaper([0,0,550,900]);
        return $pdf->stream();
    }

    public function analisa_task_all()
    {
        $datas = DB::select("SELECT j.kode as kode_task, j.name as task, j.satuan as satuan_task, 
        d.coefficient as coefficient, d.sub_total as price_satuan, m.kode as kode_material, m.name as material, 
        m.satuan as satuan_material, m.price, m.status as status, a.total_labor, a.total_material, a.total
        FROM a_h_s_s a
        INNER JOIN jobs j ON j.id_job = a.id_job
        INNER JOIN ahs_details d ON a.id_ahs = d.id_ahs
        INNER JOIN materials m ON m.id_material = d.id_material
        WHERE d.deleted_at is null
        ORDER BY j.kode, m.status DESC");

        $index = count($datas);
        for($i=0;$i<$index-1;$i++)
        {
            if($datas[$i]->status == "labor")
            {
                $j = $i;
                break;
            }
            else{

            }
        }
        $count=1;
        for($i=0;$i<$index-1;$i++)
        {
            if($datas[$i]->task != $datas[$i+1]->task)
            {
                $count +=1;
            }
        }
        $pdf = PDF::loadView('analisa_task_all_report',['datas' => $datas,'count'=>$count,'index'=>$index]);
        $pdf->setPaper([0,0,550,900]);
        return $pdf->stream();
    }

    public function rab($id)
    {
        $rab = DB::select("SELECT p.kode, p.name, p.address, p.owner, p.date, p.no_telp, p.phone, p.type, 
                        p.nominal, st.name as structure, gr.name as floor, ts.name as taskgroup, 
                        j.name as task, a.volume, j.satuan, a.HSP, a.HP
        FROM rabs r
        INNER JOIN projects p ON p.id_project = r.id_project
        INNER JOIN structure_details s ON s.id_rab = r.id_rab
        INNER JOIN group_details g ON g.id_structure_details = s.id_structure_details
        INNER JOIN task_sub_details t ON t.id_group_details = g.id_group_details
        INNER JOIN ahs_lokals a ON a.id_sub_details = t.id_sub_details
        INNER JOIN structures st ON st.id_structure = s.id_structure
        INNER JOIN groups gr ON gr.id_groups = g.id_groups
        INNER JOIN task_subs ts ON ts.id_sub = t.id_sub
        INNER JOIN jobs j ON j.id_job = a.id_job
        WHERE r.id_rab = $id");

        return response()->json([
            'data' => $rab,
            'message' => $rab ? 'Success' : 'Error'
        ]);

        // $pdf = PDF::loadView('rab_report',['rab'=>$rab]);
        // $pdf->setPaper([0,0,50,900]);
        // return $pdf->stream();
    }
}
