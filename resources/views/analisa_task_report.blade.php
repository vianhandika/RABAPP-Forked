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
                padding: 8px;
            }
            /* .table-section table tbody tr td {
                border: 0.2px solid black;
            } */
        </style>
    </head>
    <body>
        <img src="{{public_path('images/logo.png')}}" width="120px">
        <div class="title">
            <h3>Daftar Analisa Pekerjaan {{$datas[0]->task}} (Master)</h3>
        </div>

        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>Id. Pek.</th>
                        <th>Uraian Pekerjaan</th>
                        <th>Koef</th>
                        <th>Id. B&T</th>
                        <th>Uraian B&T</th>
                        <th>Sat.</th>
                        <th>Harga B&T</th>
                        <th>Harga Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$datas[0]->kode_task}}</td>
                        <td colspan="2">{{$datas[0]->task}}</td>
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td></td> 
                        <td>satuan : {{$datas[0]->satuan_task}}</td> 
                    </tr>
                    <tr> 
                        <td style="border-bottom: 0.2px solid black"></td>
                        <td style="border-bottom: 0.2px solid black"></td>
                        <td style="border-bottom: 0.2px solid black"></td>
                        <td style="border-bottom: 0.2px solid black"></td>
                        <td style="border-bottom: 0.2px solid black"></td>
                        <td style="border-bottom: 0.2px solid black"></td>
                        <td style="border-bottom: 0.2px solid black"></td>
                        <td style="border-bottom: 0.2px solid black"></td>
                    </tr>

                    @php
                        $i=0
                    @endphp

                    @foreach ($datas as $data)  
                    <tr>
                        <td></td>
                        <td></td>
                        <td>{{$data->coefficient}}</td>
                        <td>{{$data->kode_material}}</td>
                        <td>{{$data->material}}</td>
                        <td>{{$data->satuan_material}}</td>
                        <td>Rp. {{$data->price}}</td>
                        <td>Rp. {{$data->price_satuan}}</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td ></td>
                        
                        @if ($j == $i+1)
                        {
                            <td colspan="2" style="border-bottom: 0.2px solid black">Total Material</td>
                            <td style="border-bottom: 0.2px solid black">Rp. {{ $data->total_material }}</td>
                        }
                        @endif
                        
                        
                        @if($data->status == "labor")
                        {
                            @if($loop->last)
                            {
                                <td colspan="2" style="border-bottom: 0.2px solid black">Total Tenaga</td>
                                <td style="border-bottom: 0.2px solid black">Rp. {{ $data->total_labor }}</td>
                            }
                            @endif
                        }
                        @endif       
                    </tr>
                    @php
                        $i++
                    @endphp 
                    @endforeach    

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="2">Biaya Total</td>
                        <td>Rp. {{$data->total}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>