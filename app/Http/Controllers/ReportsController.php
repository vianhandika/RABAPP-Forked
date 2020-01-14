<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\AHS;

class ReportsController extends Controller
{
    public function analisa_task($id)
    {
        $ahs = AHS::find($id);
        $data = DB::select("SELECT j.kode, j.name, j.satuan, d.coefficient, m.name, m.price, m.satuan, a.total
        FROM a_h_s_s a
        INNER JOIN jobs j ON j.id_job = a.id_job
        INNER JOIN ahs_details d ON a.id_ahs = d.id_ahs
        INNER JOIN materials m ON m.id_material = d.id_material
        WHERE a.id_ahs = $id");

        $pdf = PDF::loadView('report_analisa_task',['data' => $data]);
        $pdf->setPaper([0,0,550,900]);
        return $pdf->stream();
    }
}
