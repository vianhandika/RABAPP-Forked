<html>
    <head>
        <title>Analisa Pekerjaan {{$datas[0]->task}}</title>
        <style>
            .border{
                border: 0.2px solid black;
                /* height: 1000px; */
            }
            .title{
                border-top: 1px solid black;
                /* border-bottom: 1px solid black; */
                font-size: 15px;
                text-align: center;
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            }
            .table-section table{
                border: 2px solid black;
                text-align: center;
                border-collapse: collapse;
                font-size: 15px;
            }
            .table-section table thead tr th {
                border-bottom: 0.2px solid black;
                border-right: 0.2px solid black;
            }
            /* .table-section table tbody tr td {
                border-right: 0.2px solid black;
            } */
            .top{
                border-top: 0.2px solid black;
                padding-top: -2px;
                /* border-collapse: collapse; */
            }
            .bottom{
                border-bottom: 0.2px solid black;
            }
            .left{
                border-left: 0.2px solid black;
            }
            .right{
                border-right: 0.2px solid black;
            }
            .bottomLeft{
                border-bottom: 0.2px solid black;
                border-left: 0.2px solid black
            }
        </style>
    </head>
    <body>
        <img src="{{public_path('images/logo.png')}}" width="400px">
        <div class="title">
            <h3>Daftar Analisa Pekerjaan {{$datas[0]->task}} (Master)</h3>
        </div>

        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th style="padding: 5px" width="50px">Id. Pek.</th>
                        <th width="150px" align="left" >Uraian Pekerjaan</th>
                        <th>Koef.</th>
                        <th style="padding: 5px" width="50px">Id. B&T</th>
                        <th width="120px" align="left">Uraian B&T</th>
                        <th style="padding: 5px" width="40px">Sat.</th>
                        <th style="padding: 5px" colspan="2">Harga B&T</th>
                        <th style="padding: 5px" colspan="2">Harga Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="right">{{$datas[0]->kode_task}}</td>
                        <td class="right" align="left" >{{$datas[0]->task}}</td>
                        <td class="right"></td> 
                        <td class="right"></td> 
                        <td class="right"></td> 
                        <td class="right"></td> 
                        <td></td> 
                        <td class="right"></td> 
                        <td colspan="2">satuan : {{$datas[0]->satuan_task}}</td> 
                    </tr>
                    <tr> 
                        <td colspan="10" class="top"></td>
                    </tr>

                    @php
                        $i=0
                    @endphp

                    @foreach ($datas as $data)  
                    <tr>
                        <td></td>
                        <td class="right"></td>
                        <td class="right">{{$data->coefficient}}</td>
                        <td class="right">{{$data->kode_material}}</td>
                        <td class="right" align="left">{{$data->material}}</td>
                        <td class="right">{{$data->satuan_material}}</td>
                        <td class="left" align="right" style="padding-left:5px;padding-right:5px">Rp.</td>
                        <td class="right" align="right" style="padding-right: 5px">{{number_format($data->price,2,',','.')}}</td>
                        <td class="left" align="right" style="padding-left:5px;padding-right:5px">Rp.</td>
                        <td class="right" align="right" style="padding-right: 5px">{{number_format($data->price_satuan,2,',','.')}}</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td class="top" colspan="8"></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        @if ($j == $i+1)
                        {
                            <td colspan="5" class="bottomLeft" class="left" style="padding-right:10px" align="left">Subtotal Material</td>
                            <td class="bottom" align="right">:</td>
                            <td class="bottom" align="right" style="padding-right:5px;padding-left:5px">Rp. </td>
                            <td class="bottom" align="right" style="padding-right: 5px">{{ number_format($data->total_material,2,',','.') }}</td>
                        }
                        @else
                        @endif
                    </tr>
                    @php
                        $i++
                    @endphp 
                    @endforeach   
                    
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="5" class="bottomLeft" style="padding-right:10px" align="left">Subtotal Tenaga</td>
                        <td class="bottom" align="right">:</td>
                        <td class="bottom" align="right" style="padding-right:5px;padding-left:5px">Rp.</td>
                        <td class="bottom" align="right" style="padding-right: 5px">{{ number_format($data->total_labor,2,',','.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="5" class="bottomLeft" style="padding-right:10px" align="left">Subtotal Peralatan</td>
                        <td class="bottom" align="right">:</td>
                        <td class="bottom" align="right" style="padding-right:5px;padding-left:5px">Rp.</td>
                        <td class="bottom" align="right" style="padding-right: 5px">{{ number_format($data->total_equipment,2,',','.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="5" class="bottomLeft" style="padding-right:10px" align="left">Biaya Total</td>
                        <td class="bottom" align="right">:</td>
                        <td class="bottom" align="right" style="padding-right:5px;padding-left:5px">Rp.</td>
                        <td class="bottom" align="right" style="padding-right: 5px">{{number_format($data->total_before_overhead,2,',','.')}}</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="5" class="bottomLeft" style="padding-right:10px" align="left">Overhead</td>
                        <td class="bottom" align="right">:</td>
                        <td class="bottom"></td>
                        <td class="bottom" align="right" style="padding-right:5px">{{$data->overhead}}%</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="5" class="left" style="padding-right:10px" align="left">Biaya Total (Overhead)</td>
                        <td class="bottom" align="right">:</td>
                        <td align="right" style="padding-right:5px;padding-left:5px">Rp.</td>
                        <td align="right" style="padding-right: 5px">{{number_format($data->total,2,',','.')}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>