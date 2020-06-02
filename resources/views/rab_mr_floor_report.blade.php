<html>
    <head>
    <title>Kebutuhan Bahan {{$rab[0]->name}}</title>
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
            <h3>Kebutuhan</h3>
            <h3>Bahan & Tenaga Kerja</h3>
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
    @php
        $a=0;
    @endphp
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
                <p>Yogyakarta, {{$newDate}}</p>
            </div>
        </body>
        <body>
            <div class="headerTable">
                <h3>KEBUTUHAN BAHAN & TENAGA KERJA</h3>
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
                            <th rowspan="2" width="50px">ID. B&T</th>
                            <th rowspan="2" width="90px">Uraian Pekerjaan</th>
                            <th>Vol.</th>
                            <th rowspan="2" width="100px">Item</th>
                            <th>Sat.</th>
                            <th rowspan="2">Koef.</th>
                            <th>Adj.</th>
                            <th colspan="2">Harga</th>
                            <th colspan="2">Harga Terhitung</th>
                            <th colspan="2">Total</th>
                            <th>Kebutuhan</th>
                            <th>Total Vol.</th>
                        </tr>
                        <tr>
                            <th>Pek.</th>
                            <th>B&T</th>
                            <th>B&T</th>
                            <th colspan="2">Bahan</th>
                            <th colspan="2">Bahan</th>
                            <th colspan="2">Harga Terhitung</th>
                            <th>Bahan</th>
                            <th>Bahan</th>
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
                                    <td class="bottomRight" align="left" style="font-style:bold" colspan="15">LANTAI {{strtoupper($group_data->name)}}</td>
                                </tr>
                                @php
                                    $i=1;
                                    $total=0;
                                    $count = count($rab);
                                    $total_rab_mr = 0;
                                    $total_terhitung = 0;
                                @endphp
                                @foreach ($rab as $rab_data)
                                    @if ($structure_data->id_structure == $rab_data->id_structure)
                                        @if ($group_data->id_groups == $rab_data->id_groups)
                                            <tr>
                                                <td class="bottomRight">{{$i}}</td>
                                                <td class="bottomRight">{{$rab_data->kode}}</td>
                                                <td class="bottomRight" align="left">{{$rab_data->job}}</td>
                                                <td class="bottomRight">{{$rab_data->volume}}</td>
                                                <td class="bottomRight" align="left">{{$rab_data->materials}}</td>
                                                <td class="bottomRight">{{$rab_data->sat_mat}}</td>
                                                <td class="bottomRight">{{$rab_data->coefficient}}</td>
                                                <td class="bottomRight" align="center">{{$rab_data->adjustment}}</td>
                                                <td class="bottomRight" align="left" style="border-right: 1px solid none;padding-left:5px">Rp.</td>
                                                <td class="bottomRight" align="right" style="padding-right:5px">{{number_format($rab_data->price,2,',','.')}}</td>
                                                <td class="bottomRight" align="left" style="border-right: 1px solid none;padding-left:5px">Rp.</td>
                                                <td class="bottomRight" align="right" style="padding-right:5px">{{number_format($rab_data->sub_total,2,',','.')}}</td>
                                                @php
                                                    $rab_mr = $rab_data->volume * $rab_data->coefficient * $rab_data->adjustment;
                                                @endphp
                                                <td class="bottomRight" colspan="2"></td>
                                                <td class="bottomRight">{{number_format($rab_mr,2,',','.')}}</td>
                                                <td class="bottomRight"></td>
                                            </tr>
                                            <tr>
                                                @if ($a != $count-1)
                                                    @php
                                                        $total_rab_mr += $rab_mr;  
                                                        $total_terhitung += $rab_data->sub_total; 
                                                    @endphp
                                                    @if ($temp[$a]->materials != $temp[$a+1]->materials)
                                                        <td class="bottomRight"></td>
                                                        <td class="bottomRight"></td>
                                                        <td class="bottomRight"></td>
                                                        <td class="bottomRight"></td>
                                                        <td class="bottomRight"></td>
                                                        <td class="bottomRight"></td>
                                                        <td class="bottomRight" colspan="2"></td>
                                                        <td class="bottomRight" colspan="2"></td>
                                                        <td class="bottomRight" colspan="2"></td>
                                                        <td align="left" style="border-bottom: 3px solid black;border-right: 1px solid none;padding-left:5px">Rp.</td>
                                                        <td align="right" style="border-bottom: 3px solid black;border-right: 1px solid black;padding-right:5px">{{number_format($total_terhitung,2,',','.')}}</td>
                                                        <td class="bottomRight"></td>
                                                        <td style="border-bottom: 3px solid black;border-right: 1px solid black">{{$total_rab_mr}}</td>
                                                        @php
                                                            $total_rab_mr=0;
                                                            $total_terhitung=0;
                                                        @endphp
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
                                                        <td align="left" style="border-bottom: 3px solid black;border-right: 1px solid none;padding-left:5px">Rp.</td>
                                                        <td align="right" style="border-bottom: 3px solid black;border-right: 1px solid black;padding-right:5px">{{number_format($total_terhitung,2,',','.')}}</td>
                                                        <td class="bottomRight"></td>
                                                        <td style="border-bottom: 3px solid black;border-right: 1px solid black">{{$total_rab_mr}}</td>
                                                    @endif
                                                @else
                                                    @if ($a==$count-1)
                                                        @php
                                                            $total_rab_mr += $rab_mr;  
                                                            $total_terhitung += $rab_data->sub_total; 
                                                        @endphp
                                                        @if ($temp[$a-1]->materials == $temp[$a]->materials)
                                                            <td class="bottomRight"></td>
                                                            <td class="bottomRight"></td>
                                                            <td class="bottomRight"></td>
                                                            <td class="bottomRight"></td>
                                                            <td class="bottomRight"></td>
                                                            <td class="bottomRight"></td>
                                                            <td class="bottomRight" colspan="2"></td>
                                                            <td class="bottomRight" colspan="2"></td>
                                                            <td class="bottomRight" colspan="2"></td>
                                                            <td align="left" style="border-bottom: 3px solid black;border-right: 1px solid none;padding-left:5px">Rp.</td>
                                                            <td align="right" style="border-bottom: 3px solid black;border-right: 1px solid black;padding-right:5px">{{number_format($total_terhitung,2,',','.')}}</td>
                                                            <td class="bottomRight"></td>
                                                            <td style="border-bottom: 3px solid black;border-right: 1px solid black">{{$total_rab_mr}}</td>
                                                            @php
                                                                $total_rab_mr=0;
                                                                $total_terhitung=0;
                                                            @endphp
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
                                                            <td align="left" style="border-bottom: 3px solid black;border-right: 1px solid none;padding-left:5px">Rp.</td>
                                                            <td align="right" style="border-bottom: 3px solid black;border-right: 1px solid black;padding-right:5px">{{number_format($total_terhitung,2,',','.')}}</td>
                                                            <td class="bottomRight"></td>
                                                            <td style="border-bottom: 3px solid black;border-right: 1px solid black">{{$total_rab_mr}}</td>
                                                        @endif
                                                    @endif
                                                @endif
                                            </tr>
                                            @php
                                                $i++;
                                                $a++;
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
                            <td class="bottomRight">-</td>
                            <td class="bottomRight" colspan="15"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </body>
    @endforeach
</html>