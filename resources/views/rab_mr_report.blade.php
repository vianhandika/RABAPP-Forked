<html>
    <head>
    <title>Kebutuhan Bahan {{$rab[0]->name}}</title>
        <style>
            /* .border{
                border: 1px solid black;
            } */
            .title{
                border-top: 1px solid black;
                border-bottom: 1px solid black;
                font-size: 35px;
                text-align: right;
                /* margin-top: 100px */
                font-family: Calibri, sans-serif;
            }
            .table-section table{
                border: 3px solid black;
                text-align: center;
                border-collapse: collapse;
                font-size: 10px;
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
            .bottomRight {
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
                /* border-top: 1px solid black */
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
                font-size: 11px;
            }
        </style>
    </head>
    <body>
        <img src="{{public_path('images/logo.png')}}" width="400px">
        <div class="title">
            <h3>Rencana Anggaran Biaya</h3>
            <h3>(RAB-Kebutuhan-Bahan)</h3>
        </div>
        <div class="footer" style="margin-top:350px">
            <h3>Proyek</h3>
            <h3>{{ strtoupper($rab[0]->name)}}</h3>
            <h3>{{$rab[0]->address}}</h3>
            <br>
        </div>
        <div class="footerDate">
            <p>Yogyakarta, {{date('d M Y'),strtotime($rab[0]->date)}}
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
                <p>Yogyakarta, {{date('d M Y'),strtotime($rab[0]->date)}}
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
                        <td colspan="2" style="font-size:15px">{{date('d M Y'),strtotime($rab[0]->date)}}</td>
                    </tr>
                    <tr>
                        <td style="font-size:15px">Adjustment</td>
                        <td style="font-size:15px">:</td>
                        <td colspan="2" style="font-size:15px">{{$adjust}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
            </table>
            <div class="table-section">
                <table>
                    <thead>
                        <tr>
                            <th rowspan="2">No.</th>
                            <th rowspan="2" width="50px">ID. B&T</th>
                            <th rowspan="2" width="100px">Item</th>
                            <th rowspan="2">Status</th>
                            <th rowspan="2" width="160px">Uraian Pekerjaan</th>
                            <th rowspan="2">Koef.</th>
                            <th>Vol.</th>
                            <th>Sat.</th>
                            <th colspan="2">Harga</th>
                            <th colspan="2">Harga Terhitung</th>
                            <th>Kebutuhan</th>
                            <th>Total</th>
                        </tr>
                        <tr>
                            <th>Pek.</th>
                            <th>Pek.</th>
                            <th colspan="2">Bahan</th>
                            <th colspan="2">Bahan</th>
                            <th>Bahan</th>
                            <th>Volume</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $k=0;
                            $nominal = 0;
                        @endphp
                        @foreach ($group as $group_data)
                            @if ($structure_data->id_structure == $group_data->id_structure)
                                <tr>
                                    <td class="bottomRight" style="font-style:bold">{{$roman[$k]}}</td>
                                    <td class="bottomRight" align="left" style="font-style:bold" colspan="13">LANTAI {{strtoupper($group_data->name)}}</td>
                                </tr>
                                @php
                                    $j=0;
                                @endphp
                                @foreach ($tasksub as $tasksub_data)
                                    @if ($structure_data->id_structure == $tasksub_data->id_structure)
                                        @if ($group_data->id_groups == $tasksub_data->id_groups)
                                            <tr>
                                                <td class="bottomRight" style="font-style:bold">{{$alphabet[$j]}}</td>
                                                <td class="bottomRight" align="left" style="font-style:bold" colspan="13">PEKERJAAN {{strtoupper($tasksub_data->name)}}</td>
                                            </tr>
                                            @php
                                                $i=1;
                                                $j++;
                                                $total=0;
                                                $a=0;
                                                $count = count($rab);
                                                $total_rab_mr = 0;
                                            @endphp
                                            @foreach ($rab as $rab_data)
                                                @if ($structure_data->id_structure == $rab_data->id_structure)
                                                    @if ($group_data->id_groups == $rab_data->id_groups)
                                                        @if ($tasksub_data->id_sub == $rab_data->id_sub)
                                                            <tr>
                                                                <td class="bottomRight">{{$i}}</td>
                                                                <td class="bottomRight">{{$rab_data->kode}}</td>
                                                                <td class="bottomRight" align="left">{{$rab_data->materials}}</td>
                                                                <td class="bottomRight" align="left">{{$rab_data->status}}</td>
                                                                <td class="bottomRight" align="left">{{$rab_data->job}}</td>
                                                                <td class="bottomRight">{{$rab_data->coefficient}}</td>
                                                                <td class="bottomRight">{{$rab_data->volume}}</td>
                                                                <td class="bottomRight">{{$rab_data->satuan}}</td>
                                                                <td class="bottomRight" align="left" style="border-right: 1px solid none;padding-left:5px">Rp.</td>
                                                                <td class="bottomRight" align="right" style="padding-right:5px">{{number_format($rab_data->price,2,',','.')}}</td>
                                                                <td class="bottomRight" align="left" style="border-right: 1px solid none;padding-left:5px">Rp.</td>
                                                                <td class="bottomRight" align="right" style="padding-right:5px">{{number_format($rab_data->HSP,2,',','.')}}</td>
                                                                @php
                                                                    $rab_mr = $rab_data->volume * $rab_data->coefficient * $rab_data->adjustment;
                                                                @endphp
                                                                <td class="bottomRight">{{number_format($rab_mr,2,',','.')}}</td>
                                                                <td class="bottomRight"></td>
                                                            </tr>
                                                            <tr>
                                                                @if ($a != $count-1)
                                                                    @php
                                                                        $total_rab_mr += $rab_mr;        
                                                                    @endphp
                                                                    @if ($rab[$a]->materials != $rab[$a+1]->materials)
                                                                        <td class="bottomRight"></td>
                                                                        <td class="bottomRight"></td>
                                                                        <td class="bottomRight"></td>
                                                                        <td class="bottomRight"></td>
                                                                        <td class="bottomRight"></td>
                                                                        <td class="bottomRight"></td>
                                                                        <td class="bottomRight" colspan="2"></td>
                                                                        <td class="bottomRight" colspan="2"></td>
                                                                        <td class="bottomRight" colspan="2"></td>
                                                                        <td class="bottomRight"></td>
                                                                        <td style="border-bottom: 3px solid black;border-right: 1px solid black">{{$total_rab_mr}}</td>
                                                                        @php
                                                                            $total_rab_mr=0;
                                                                        @endphp
                                                                    @else
                                                                        <td colspan="14"></td>
                                                                    @endif
                                                                @else
                                                                    <td class="bottomRight"></td>
                                                                    <td class="bottomRight"></td>
                                                                    <td class="bottomRight"></td>
                                                                    <td class="bottomRight"></td>
                                                                    <td class="bottomRight"></td>
                                                                    <td class="bottomRight"></td>
                                                                    <td class="bottomRight" colspan="2"></td>
                                                                    <td class="bottomRight" colspan="2"></td>
                                                                    <td class="bottomRight" colspan="2"></td>
                                                                    <td class="bottomRight"></td>
                                                                    <td style="border-bottom: 3px solid black;border-right: 1px solid black">{{$total_rab_mr + $rab_mr}}</td>
                                                                @endif
                                                            </tr>
                                                            @php
                                                                $i++;
                                                                $a++;
                                                            @endphp 
                                                        @endif
                                                    @endif 
                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                                @php
                                    $k++;
                                @endphp
                            @endif
                        @endforeach
                        <tr>
                            <td class="bottomRight">-</td>
                            <td class="bottomRight" colspan="13"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </body>
    @endforeach
</html>