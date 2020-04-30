<html>
    <head>
        <title>Rencana Anggaran Biaya {{$rab[0]->name}}</title>
        <style>
            .title{
                border-top: 1px solid black;
                border-bottom: 1px solid black;
                font-size: 35px;
                text-align: right;
                font-family: Calibri, sans-serif;
            }
            .table-section table{
                border: 3px solid black;
                text-align: center;
                border-collapse: collapse;
                font-size: 11px;
                font-family: Calibri, sans-serif;
                width: 700px;
                margin-top: 10px;
            }
            .table-section table thead tr th {
                border-bottom: 1px solid black;
                border-right: 1px solid black;
                font-family: Calibri, sans-serif;
                margin: 10px;
                border-top:3px solid black;
            }
            .table-section table tbody tr td {
                border-bottom: 1px solid black;
                border-right: 1px solid black;
                font-family: Calibri, sans-serif;
                margin: 10px;
            }
            .table-section table thead tr td{
                font-family: Calibri, sans-serif;
                margin: 10px;
            }
            .footer{
                text-align: right;
                font-size: 25px;
                font-family: Calibri, sans-serif;
            }
            .footerDate{
                margin-bottom: 10px;
                text-align: right;
                font-size: 20px;
                font-family: Calibri, sans-serif
            }
            .rekapitulasi{
                text-align: right;
                margin-top: 100px;
                font-family: Calibri, sans-serif
            }
            .headerTable{
                margin-top: 20px;
                font-family: Calibri, sans-serif;
                font-size: 13px;
            }
        </style>
    </head>
    <body>
        <img src="{{public_path('images/logo.png')}}" width="400px">
        <div class="title">
            <h3>Rencana Anggaran Biaya</h3>
            <h3>(RAB)</h3>
        </div>
        <div class="footer" style="margin-top:350px">
            <h3>Proyek</h3>
            <h3>{{ strtoupper($rab[0]->name)}}</h3>
            <h3>{{$rab[0]->address}}</h3>
            <br>
        </div>
        <div class="footerDate">
            <p>Yogyakarta, {{$newDate}}
        </div>
    </body>
    @foreach ($structure as $structure_data)
        <body>
            <div class="rekapitulasi">
                <h3 style="font-size: 25px">PEKERJAAN</h3>
                <p style="font-size: 20px">{{strtoupper($structure_data->name)}}
            </div>

            <div class="footer" style="margin-top: 500px;">
                <h3>Proyek</h3>
                <h3>{{ strtoupper($rab[0]->name)}}</h3>
                <h3>{{$rab[0]->address}}</h3>
                <br>
            </div>
            <div class="footerDate">
                <p>Yogyakarta, {{$newDate}}
            </div>
        </body>
        <body>
            <div class="headerTable">
                <h3>RENCANA ANGGARAN BIAYA</h3>
                <h3>PEMBANGUNAN {{strtoupper($structure_data->name)}}</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <td style="font-size:15px">Pemilik</td>
                        <td style="font-size:15px">:</td>
                        <td align="left" colspan="2" style="font-size:15px">{{$rab[0]->owner}}</td>
                        <td style="padding-right:20px"></td>
                        <td style="font-size:15px">Alamat</td>
                        <td style="font-size:15px">:</td>
                        <td colspan="2" style="font-size:15px">{{$rab[0]->address}}</td>
                    </tr>
                    <tr>
                        <td style="font-size:15px">Tipologi</td>
                        <td style="font-size:15px">:</td>
                        <td colspan="2" style="font-size:15px">{{$rab[0]->type}}</td>
                        <td style="padding-right:20px"></td>
                        <td style="font-size:15px">Tanggal</td>
                        <td style="font-size:15px">:</td>
                        <td colspan="2" style="font-size:15px">{{$newDate}}</td>
                    </tr>
                </thead>
            </table>
            <div class="table-section">
                <table>
                    <thead>
                        <tr>
                            <th rowspan="2">No.</th>
                            <th rowspan="2" width="160px">Uraian Pekerjaan</th>
                            <th>Vol.</th>
                            <th>Sat.</th>
                            <th colspan="2">Harga Sat</th>
                            <th colspan="2">Harga Terhitung</th>
                            <th colspan="2">Jumlah</th>
                            <th colspan="2">Proc</th>
                        </tr>
                        <tr>
                            <th>Pek.</th>
                            <th>Pek.</th>
                            <th colspan="2">Pekerjaan</th>
                            <th colspan="2">Upah&Bahan</th>
                            <th colspan="2">Terhitung</th>
                            <th colspan="2">Pek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $k=0;
                            $nominal = 0;
                            $total_proc=0;
                        @endphp
                        @foreach ($group as $group_data)
                            @if ($structure_data->id_structure == $group_data->id_structure)
                                <tr>
                                    <td style="font-style:bold">{{$roman[$k]}}</td>
                                    <td align="left" style="font-style:bold">LANTAI {{strtoupper($group_data->name)}}</td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2"></td>
                                    <td colspan="2"></td>
                                    <td colspan="2"></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @php
                                    $j=0;
                                @endphp
                                @foreach ($tasksub as $tasksub_data)
                                    @if ($structure_data->id_structure == $tasksub_data->id_structure)
                                        @if ($group_data->id_groups == $tasksub_data->id_groups)
                                            <tr>
                                                <td style="font-style:bold">{{$alphabet[$j]}}</td>
                                                <td align="left" style="font-style:bold">PEKERJAAN {{strtoupper($tasksub_data->name)}}</td>
                                                <td></td>
                                                <td></td>
                                                <td colspan="2"></td>
                                                <td colspan="2"></td>
                                                <td colspan="2"></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @php
                                                $i=1;
                                                $j++;
                                                $total=0;
                                                $proc_pek=0
                                            @endphp
                                            @foreach ($rab as $rab_data)
                                                @if ($structure_data->id_structure == $rab_data->id_structure)
                                                    @if ($group_data->id_groups == $rab_data->id_groups)
                                                        @if ($tasksub_data->id_sub == $rab_data->id_sub)
                                                            <tr>
                                                                <td>{{$i}}</td>
                                                                <td align="left">{{$rab_data->job}}</td>
                                                                @if ($rab_data->status == "Volume")
                                                                    <td>{{$rab_data->volume * $rab_data->adjustment}}</td>
                                                                @else
                                                                    <td>{{$rab_data->volume}}</td>
                                                                @endif
                                                                <td>{{$rab_data->satuan}}</td>
                                                                <td align="left" style="border-right: 1px solid none;padding-left:5px">Rp.</td>
                                                                @if ($rab_data->status == 'Price')
                                                                    <td align="right" style="padding-right:5px">{{number_format($rab_data->HSP * $rab_data->adjustment,2,',','.')}}</td>
                                                                @else
                                                                    <td align="right" style="padding-right:5px">{{number_format($rab_data->HSP,2,',','.')}}</td>
                                                                @endif
                                                                <td align="left" style="border-right: 1px solid none;padding-left:5px">Rp.</td>
                                                                <td align="right" style="padding-right:5px">{{number_format($rab_data->HP_Adjust,2,',','.')}}</td>
                                                                <td colspan="2"></td>
                                                                @foreach ($totalSt as $item)
                                                                    @if ($item->id_structure == $structure_data->id_structure)
                                                                        @php
                                                                            $proc = ($rab_data->HP_Adjust/$item->Total)*100;
                                                                        @endphp
                                                                    @endif
                                                                @endforeach
                                                                <td align="right" style="padding-right:2px;font-style:bold">{{number_format($proc,2,',','.')}}%</td>
                                                                <td></td>
                                                                @php
                                                                    $total += $rab_data->HP_Adjust;
                                                                    $proc_pek += $proc;
                                                                @endphp
                                                            </tr>
                                                            @php
                                                                $i++
                                                            @endphp 
                                                        @endif
                                                    @endif 
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td colspan="2"></td>
                                                <td colspan="2"></td>
                                                <td align="left" style="border-right: 1px solid none;padding-left:5px;border-bottom:3px solid black;border-size:1px;font-style:bold">Rp.</td>
                                                <td align="right" style="padding-right:5px;padding-left:5px;border-bottom:3px solid black;font-style:bold">{{number_format($total,2,',','.')}}</td>
                                                <td></td>
                                                <td align="right" style="padding-right:2px;font-style:bold">{{number_format($proc_pek,2,',','.')}}%</td>
                                            </tr>
                                            @php
                                                $nominal += $total;
                                                $total_proc += $proc_pek;
                                            @endphp
                                        @endif
                                    @endif
                                @endforeach
                                @php
                                    $k++;
                                @endphp
                            @endif
                        @endforeach
                        <tr>
                            <td style="border-bottom: 3px solid black">-</td>
                            <td style="border-bottom: 3px solid black"></td>
                            <td style="border-bottom: 3px solid black"></td>
                            <td style="border-bottom: 3px solid black"></td>
                            <td style="border-bottom: 3px solid black" colspan="2"></td>
                            <td style="border-bottom: 3px solid black" colspan="2"></td>
                            <td style="border-bottom: 3px solid black" colspan="2" style="border-bottom: 3px solid black"></td>
                            <td style="border-bottom: 3px solid black"></td>
                            <td style="border-bottom: 3px solid black"></td>
                        </tr>
                        <tr>
                            <td colspan="8" align="left" style="font-style:bold;padding-left:10px">SUB TOTAL</td>
                            <td align="left" style="border-right: 1px solid none;padding-left:5px;font-style:bold">Rp.</td>
                            <td align="right" style="padding-right:5px;font-style:bold">{{number_format($nominal,2,',','.')}}</td>
                            <td rowspan="5" align="center" style="padding-right:2px;font-style:bold">{{number_format($total_proc,0,',','.')}}%</td>
                            <td rowspan="5" align="center" style="padding-right:2px;font-style:bold">{{number_format($total_proc,0,',','.')}}%</td>
                        </tr>
                        @php
                            $Pajak = $nominal * $ppn /100;
                            $Jasa = $nominal * $jasa /100;
                            $Total_Nominal = $nominal + $Pajak + $Jasa;
                        @endphp
                        <tr>
                        <td colspan="8" align="left" style="font-style:bold;padding-left:10px">PAJAK ({{$ppn}}%)</td>
                            <td align="left" style="border-right: 1px solid none;padding-left:5px;font-style:bold">Rp.</td>
                            <td align="right" style="padding-right:5px;font-style:bold">{{number_format($Pajak,2,',','.')}}</td>
                        </tr>
                        <tr>
                            <td colspan="8" align="left" style="font-style:bold;padding-left:10px">JASA ({{$jasa}}%)</td>
                            <td align="left" style="border-right: 1px solid none;padding-left:5px;font-style:bold">Rp.</td>
                            <td align="right" style="padding-right:5px;font-style:bold">{{number_format($Jasa,2,',','.')}}</td>
                        </tr>
                        <tr>
                            <td colspan="8" align="left" style="font-style:bold;padding-left:10px;border-top: 3px solid black">TOTAL</td>
                            <td align="left" style="border-right: 1px solid none;padding-left:5px;font-style:bold;border-top: 3px solid black">Rp.</td>
                            <td align="right" style="padding-right:5px;font-style:bold;border-top: 3px solid black">{{number_format($Total_Nominal,2,',','.')}}</td>
                        </tr>
                        <tr>
                            <td colspan="8" align="left" style="font-style:bold;padding-left:10px">PEMBULATAN</td>
                            <td align="left" style="border-right: 1px solid none;padding-left:5px;font-style:bold">Rp.</td>
                            <td align="right" style="padding-right:5px;font-style:bold">{{number_format($Total_Nominal,0,',','.')}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </body>
    @endforeach
</html>