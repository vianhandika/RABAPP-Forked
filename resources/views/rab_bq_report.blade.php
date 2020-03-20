<html>
    <head>
        <title>Rencana Anggaran Biaya</title>
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
                width: 700px
            }
            .table-section table thead tr th {
                border-bottom: 1px solid black;
                border-right: 1px solid black;
                font-family: Calibri, sans-serif;
                margin: 10px;
                border-top:3px solid black;
                /* padding: 10px; */
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
            <h3>(RAB-OE)</h3>
        </div>
        <div class="footer" style="margin-top:400px">
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
            <div class="footer" style="margin-top:580px">
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
                        <td>Pemilik : {{$rab[0]->owner}}</td>
                        <td style="padding-left: 200px">Alamat : {{$rab[0]->address}}</td>
                    </tr>
                    <tr>
                        <td>No. HP : {{$rab[0]->phone}}</th>
                        <td style="padding-left: 200px">Tanggal : {{date('d M Y'),strtotime($rab[0]->date)}}</th>
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
                        @endphp
                        @foreach ($group as $group_data)
                            @if ($structure_data->id_structure == $group_data->id_structure)
                                <tr>
                                    <td style="font-style:bold">{{$roman[$k]}}</td>
                                    <td align="left" style="font-style:bold">{{strtoupper($group_data->name)}}</td>
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
                                    @if ($group_data->id_groups == $tasksub_data->id_groups)
                                        <tr>
                                            <td style="font-style:bold">{{$alphabet[$j]}}</td>
                                            <td align="left" style="font-style:bold">{{strtoupper($tasksub_data->name)}}</td>
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
                                        @endphp
                                        @foreach ($rab as $rab_data)
                                            @if ($group_data->id_groups == $rab_data->id_groups)
                                                @if ($tasksub_data->id_sub == $rab_data->id_sub)
                                                    <tr>
                                                        <td>{{$i}}</td>
                                                        <td align="left">{{$rab_data->job}}</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td align="left" style="border-right: 1px solid none">Rp.</td>
                                                        <td align="right" ></td>
                                                        <td align="left" style="border-right: 1px solid none">Rp.</td>
                                                        <td align="right"></td>
                                                        <td colspan="2"></td>
                                                        
                                                        <td align="right" style="padding-right:2px;font-style:bold"></td>
                                                        <td></td>
                                                    </tr>
                                                    @php
                                                        $i++
                                                    @endphp 
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
                                            <td align="right" style="padding-right:5px;padding-left:5px;border-bottom:3px solid black;font-style:bold"></td>
                                            <td></td>
                                            <td align="right" style="padding-right:2px;font-style:bold"></td>
                                        </tr>
                                    @endif
                                @endforeach
                                @php
                                    $k++;
                                @endphp
                            @endif
                        @endforeach
                        <tr>
                            <td>-</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td colspan="2"></td>
                            <td colspan="2" style="border-bottom: 3px solid black"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="8" align="left" style="font-style:bold;padding-left:10px">TOTAL</td>
                            <td align="left" style="border-right: 1px solid none;padding-left:5px;font-style:bold">Rp.</td>
                            <td align="right" style="padding-right:5px;font-style:bold"></td>
                            <td rowspan="2" align="right" style="border-top: 3px solid black;padding-right:2px;font-style:bold"></td>}}
                            <td rowspan="2" align="right" style="border-top: 3px solid black;padding-right:2px;font-style:bold"></td>}}
                        </tr>
                        <tr>
                            <td colspan="8" align="left" style="font-style:bold;padding-left:10px">PEMBULATAN</td>
                            <td align="left" style="border-right: 1px solid none;padding-left:5px;font-style:bold">Rp.</td>
                            <td align="right" style="padding-right:5px;font-style:bold"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </body>
    @endforeach
</html>