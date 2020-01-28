<html>
    <head>
        <title>Analisa Pekerjaan Master</title>
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
        <img src="{{public_path('images/logo.png')}}" width="350px">
        <div class="title">
            <h3>Daftar Analisa Pekerjaan (Master)</h3>
        </div>

        @php
            $a = 0;
            $b = 0;
            $c = 0;
            $d = 0;
            $k = 0;
            $v = 0;
        @endphp

        @foreach ($datas as $data)
        @if ($a<$count)
            <div class="table-section">
                <table>
                    <thead>
                        <tr>
                            <th>Id. Pek.</th>
                            <th>Uraian Pekerjaan</th>
                            <th>Koef</th>
                            <th>Id. Bahan/Pek.</th>
                            <th>Uraian Bahan/Pek</th>
                            <th>Sat.</th>
                            <th>Harga Bahanup.</th>
                            <th>Harga Satuan</th>
                        </tr>
                    </thead>
                        @php
                            for($k=$v;$k<$index-1;$k++)
                            {
                                if($datas[$k]->task == $datas[$k+1]->task)
                                {
                                    if($k != $index)
                                    {
                                        $v++;
                                    }
                                    else {
                                        break;
                                    }
                                }
                                else{
                                    $v=$k;
                                    break;
                                }
                            }
                            // dd($v);
                        @endphp
                        <tbody>
                            <tr>
                                <td>{{$datas[$v]->kode_task}}</td>
                                <td>{{$datas[$v]->task}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td> 
                                <td>satuan : {{$datas[$v]->satuan_task}}</td> 
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
                                $i=0;
                            @endphp

                            @foreach ($datas as $data)  
                            @if($datas[$v]->task == $data->task)
                            {
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

                                @php
                                    for($d=0;$d<$index-1;$d++)
                                    {
                                        if($datas[$v]->task == $datas[$d]->task)
                                        {
                                            // dd($datas[$v]->task);
                                            if($d != $index)
                                            {
                                                if($datas[$d]->status != "labor")
                                                    $b=$d;
                                                // else {
                                                //     $b++;
                                                // }
                                                if($datas[$d]->status != "material")
                                                    $c=$d;
                                            }
                                            else {
                                                break;
                                            }
                                        }
                                        // else {
                                        //     break;
                                        // }
                                    }
                                    // dd($b);
                                @endphp
                            }
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td ></td>
                        
                                @if ($b == $i && $b!=0)
                                {
                                    <td style="border-bottom: 0.2px solid black">Total Material</td>
                                    <td style="border-bottom: 0.2px solid black">Rp. {{ $datas[$v]->total_material }}</td>
                                }
                                @endif

                                @if ($a == $count-1)
                                    @if($loop->last && $datas[$v]->total_labor != 0)
                                        <td style="border-bottom: 0.2px solid black">Total Tenaga</td>
                                        <td style="border-bottom: 0.2px solid black">Rp. {{ $datas[$v]->total_labor }}</td>
                                    @endif   
                                @else
                                    @if ($c == $i && $c!=0)
                                    {
                                        <td style="border-bottom: 0.2px solid black">Total Tenaga</td>
                                        <td style="border-bottom: 0.2px solid black">Rp. {{ $datas[$v]->total_labor }}</td>
                                    }
                                    @endif
                                @endif
                            </tr>
                            @endif

                            @php
                                $i++;
                            @endphp 
                            @endforeach    

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Biaya Total</td>
                                <td>Rp. {{$datas[$v]->total}}</td>
                            </tr>
                        </tbody>
                
                </table>
            </div>
            <br>
            @php
                $a++;
                $v++;
            @endphp
        @else
        @endif
        @endforeach
    </body>
</html>