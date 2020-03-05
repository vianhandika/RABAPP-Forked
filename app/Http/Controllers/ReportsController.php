<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\AHS;
use PDF;
use App\RAB;
use App\StructureDetails;
use App\GroupDetails;
use App\TaskSubDetails;
use App\RABDetails;
use App\Structure;
use App\Groups;
use App\TaskSub;

class ReportsController extends Controller
{
    public function analisa_task($id)
    {
        $ahs = AHS::find($id);
        $datas = DB::table('a_h_s_s')
                ->select('a_h_s_s.kode as kode_ahs','jobs.kode as kode_task','jobs.name as task','jobs.satuan as satuan_task',
                        'ahs_details.coefficient as coefficient','ahs_details.sub_total as price_satuan',
                        'materials.kode as kode_material','materials.name as material',
                        'materials.satuan as satuan_material','materials.price','materials.status',
                        'a_h_s_s.total_labor','a_h_s_s.total_material','a_h_s_s.total')
                ->join('jobs','jobs.id_job','=','a_h_s_s.id_job')
                ->join('ahs_details','ahs_details.id_ahs','=','a_h_s_s.id_ahs')
                ->join('materials','materials.id_material','=','ahs_details.id_material')
                ->where('a_h_s_s.id_ahs','=',$id)
                ->whereNull('ahs_details.deleted_at')
                ->orderBy('materials.status','DESC')
                ->get();
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
                $j +=1;
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
        $pdf->setPaper('A4','potrait');
        return $pdf->stream();
    }

    function integerToRoman($integer)
    {
        $integer = intval($integer);
        $result = '';
     
        $lookup = array('M' => 1000,'CM' => 900,'D' => 500,'CD' => 400,'C' => 100,'XC' => 90,'L' => 50,
                        'XL' => 40,'X' => 10,'IX' => 9,'V' => 5,'IV' => 4,'I' => 1);
        
        foreach($lookup as $roman => $value)
        {
            $matches = intval($integer/$value);
            $result .= str_repeat($roman,$matches);
            $integer = $integer % $value;
        }
        return $result;
    }

    public function rab($id)
    {
        $rab = DB::table('rabs')
            ->select('projects.name','projects.owner','projects.date','projects.address', 'projects.phone',
                        'task_subs.id_sub','groups.id_groups','ahs_lokals.adjustment','ahs_lokals.volume','ahs_lokals.HSP',
                        'ahs_lokals.HP_Adjust','jobs.name as job', 'jobs.satuan','jobs.status')
            ->join('projects','projects.id_project','=','rabs.id_project')
            ->join('structure_details','rabs.id_rab','=','structure_details.id_rab')
            ->join('group_details','group_details.id_structure_details','=','structure_details.id_structure_details')
            ->join('task_sub_details','task_sub_details.id_group_details','=','group_details.id_group_details')
            ->join('ahs_lokals','ahs_lokals.id_sub_details','=','task_sub_details.id_sub_details')
            ->join('jobs','jobs.id_job','=','ahs_lokals.id_job')
            ->join('task_subs','task_subs.id_sub','=','task_sub_details.id_sub')
            ->join('groups','groups.id_groups','=','group_details.id_groups')
            ->where('rabs.id_rab','=',$id)
            ->whereNull('rabs.deleted_at')
            ->get();
        // dd($rab);
        $totalSt = DB::table('rabs')
            ->select(DB::raw('SUM(ahs_lokals.HP_Adjust) as Total,structure_details.id_structure'))
            ->join('projects','projects.id_project','=','rabs.id_project')
            ->join('structure_details','rabs.id_rab','=','structure_details.id_rab')
            ->join('group_details','group_details.id_structure_details','=','structure_details.id_structure_details')
            ->join('task_sub_details','task_sub_details.id_group_details','=','group_details.id_group_details')
            ->join('ahs_lokals','ahs_lokals.id_sub_details','=','task_sub_details.id_sub_details')
            ->join('jobs','jobs.id_job','=','ahs_lokals.id_job')
            ->join('task_subs','task_subs.id_sub','=','task_sub_details.id_sub')
            ->join('groups','groups.id_groups','=','group_details.id_groups')
            ->where('rabs.id_rab','=',$id) 
            ->whereNull('ahs_lokals.deleted_at')
            ->groupBy('structure_details.id_structure')
            ->get();
        // dd($totalSt);
        $structure = DB::table('rabs')
            ->select('structures.id_structure','structures.name')
            ->join('structure_details','rabs.id_rab','=','structure_details.id_rab')
            ->join('structures','structure_details.id_structure','=','structures.id_structure')
            ->where('rabs.id_rab','=',$id)
            ->whereNull('structure_details.deleted_at')
            ->get();
        // dd($structure);
        $group = DB::table('rabs')
            ->select('structure_details.id_structure','groups.id_groups','groups.name')
            ->join('structure_details','rabs.id_rab','=','structure_details.id_rab')
            ->join('group_details','group_details.id_structure_details','=','structure_details.id_structure_details')
            ->join('groups','groups.id_groups','=','group_details.id_groups')
            ->where('rabs.id_rab','=',$id)
            ->whereNull('group_details.deleted_at')
            ->get();
        // dd($group);

        $tasksub = DB::table('rabs')
            ->select('structure_details.id_structure','group_details.id_groups','task_subs.id_sub','task_subs.name')
            ->join('structure_details','rabs.id_rab','=','structure_details.id_rab')
            ->join('group_details','group_details.id_structure_details','=','structure_details.id_structure_details')
            ->join('task_sub_details','task_sub_details.id_group_details','=','group_details.id_group_details')
            ->join('task_subs','task_subs.id_sub','=','task_sub_details.id_sub')
            ->where('rabs.id_rab','=',$id)
            ->whereNull('task_sub_details.deleted_at')
            ->get();
        // dd($tasksub);
        $alphabet=[];
        foreach(range('A','Z') as $alphabet_data)
        {
            array_push($alphabet,$alphabet_data);
        }

        $index = count($group);
        $roman=[];
        for($i=1;$i<=$index;$i++)
        {
            $data = $this->integerToRoman($i);
            array_push($roman,$data);
        }
        // dd($roman);
        $pdf = PDF::loadView('rab_report',['rab' => $rab,'structure'=>$structure,'group'=>$group,
                            'tasksub'=>$tasksub, 'alphabet'=>$alphabet,'roman'=>$roman,'totalSt'=>$totalSt]);
        $pdf->setPaper('A4','potrait');
        return $pdf->stream();
    }
}
