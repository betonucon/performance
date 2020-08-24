<?php
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=".str_replace(',','_',cek_unit($kode)['nama'])."-".$tahun.".xls");
        ?>
<html>
    <head>  
        <title>Laporan Proses </title>  
        <style>
            html { 
                margin: 50px 5px 50px 5px;
              
            }
            table{
                border-collapse:collapse;
            }
            th{
                padding:3px;
                color: #575282;
                text-align:center;
                font-size: 9px;
                font-family: sans-serif;
                background:#add4d4;
            }
            td{
                padding:5px;
                color: #575282;
                font-size: 9px;
                font-family: sans-serif;
                vertical-align:top;
            }
            
        </style>
    </head> 
    <body>   
        @foreach(array_unit_atasan_subdit($kode) as $kodediv)
       
            <div style="padding:10px">
                
                <table  width="100%" border="0" >
                    <thead>
                        <tr>
                            <td colspan="21"><center><h3>LAPORAN CAPAIAN PERIODE {{$tahun}}<br>{{cek_unit($kodediv)['nama']}}</h3></center></td>
                        </tr>
                    </thead>
                </table>
                <table  width="100%" border="1" >
                    <thead>
                        <tr>
                            <th rowspan="2" width="5%">Kode KPI</th>
                            <th rowspan="2" width="10%" >Nama KPI</th>
                            <th rowspan="2" width="4%">Ket</th>
                            <th rowspan="2" width="4%">Bobot</th>
                            <th rowspan="2" width="4%">Target</th>
                            <th rowspan="2" width="6%">Satuan</th>
                            <th rowspan="2" width="1%"></th>
                            <th colspan="12">bulan</th>
                            <th rowspan="2" width="5%">KOM</th>
                            <th rowspan="2" width="4%">SCORE</th>
                        </tr>
                        <tr>
                            @for($x=1;$x<13;$x++)
                            <th width="4%">{{$x}}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        <?php $score=0; ?>
                        @foreach(deployment_realisasi_atasan($kodediv,$tahun) as $no=>$data)
                            <?php $score+=score($data['id'],akumulasi_capaian($data['id'],akumulasi_target($data['id']),akumulasi_realisasi($data['id'])));?>
                            <?php 
                                if($data['sts']==1){
                                    $color=color(1);
                                }else{
                                    if($no%2==0){$color=color(2);}
                                    else{$color=color(3);} 
                                }
                            ?>
                            <tr style="background:{{$color}}">
                                <td rowspan="3">{{$data->kode_kpi}}</td>
                                <td rowspan="3">{{cek_kpi($data->kode_kpi)['kpi']}}</td>
                                <td rowspan="3" style="padding:0px;">{{cek_capaian($data['rumus_capaian'])}}<hr style="margin: 0px;border-color:#b7b7bd">{{cek_akumulasi($data['rumus_akumulasi'])}}</td>
                                <td rowspan="3">{{$data->bobot_tahunan}}</td>
                                <td rowspan="3">{{$data->target_tahunan}}</td>
                                <td rowspan="3">{{cek_kpi($data->kode_kpi)['satuan']}}</td>
                                <td>T</td>
                                    @foreach(get_target($data['id']) as $detail)
                                        @if($data['rumus_capaian']==3)
                                        <td>{{tgl($detail['target'])}}</th>
                                        @else
                                        <td>{{$detail['target']}}</th>
                                        @endif
                                    @endforeach
                                <td>{{akumulasi_target($data['id'])}}</td>
                                <td rowspan="3">{{score($data['id'],akumulasi_capaian($data['id'],akumulasi_target($data['id']),akumulasi_realisasi($data['id'])))}}</td>
                            </tr>
                            <tr style="background:{{$color}}">
                                <td>R</td>
                                @foreach(get_target($data['id']) as $detail)
                                    @if($data['rumus_capaian']==3)
                                        <td>{{tgl($detail['realisasi'])}}</th>
                                    @else
                                        <td>{{$detail['realisasi']}}</th>
                                    @endif
                                @endforeach
                                <td>{{akumulasi_realisasi($data['id'])}}</td>
                            </tr>
                            <tr style="background:{{$color}}">
                                <td>C</td>
                                @foreach(get_target($data['id']) as $detail)
                                    <td>{{hitung_capaian($data['rumus_capaian'],$detail['target'],$detail['realisasi'])}}%</th>
                                @endforeach
                                <td>{{akumulasi_capaian($data['id'],akumulasi_target($data['id']),akumulasi_realisasi($data['id']))}}</td>
                            </tr>
                        @endforeach
                        @if($kodediv!='')
                        
                        
                        <tr style="background:{{$color}}">
                            <td colspan="7">TOTAL CAPAIAN</td>
                                @foreach(get_target($data['id']) as $detail)
                                <td>{{total_capaian($kodediv,$tahun,$detail['bulan'])}}%</th>
                            @endforeach
                            <td colspan="2" align="right">{{$score}}</td>
                        </tr>

                        <tr style="background:{{$color}}">
                            <td colspan="7">TOTAL BOBOT</td>
                                @foreach(get_target($data['id']) as $detail)
                                <td>{{total_bobot($kodediv,$tahun)}}%</th>
                            @endforeach
                            <td colspan="2" align="right">{{total_bobot($kodediv,$tahun)}}</td>
                        </tr>

                        <tr style="background:{{$color}}">
                            <td colspan="7">TOTAL CAPAIAN/TOTAL BOBOT</td>
                                @foreach(get_target($data['id']) as $detail)
                                <td>{{substr((total_capaian($kodediv,$tahun,$detail['bulan'])/total_bobot($kodediv,$tahun))*100,0,4)}}%</th>
                            @endforeach
                            <td colspan="2" align="right">{{($score/total_bobot($kodediv,$tahun))*100}}</td>
                        </tr>

                        <tr style="background:{{$color}}">
                            <td colspan="7">POTONGAN KETERLAMBATAN</td>
                            <?php 
                                $potongan=0; 
                                
                            ?>
                            @for($x=1;$x<13;$x++)
                                <?php 
                                    $potongan+=potongan(tgl_validasi_atasan($kodediv,$tahun,$x),$tahun,$x); 
                                    
                                ?>
                                
                                <td>{{potongan(tgl_validasi_atasan($kodediv,$tahun,$x),$tahun,$x)}}%</td>
                            @endfor
                            <td colspan="2" align="right">{{($potongan/12)}}</td>
                        </tr>
                        <tr style="background:{{$color}}">
                            <td colspan="7">CAPAIAN AKHIR </td>
                                @for($x=1;$x<13;$x++)
                                <td>{{(substr((total_capaian($kodediv,$tahun,$x)/total_bobot($kodediv,$tahun))*100,0,4)-potongan(tgl_validasi_atasan($kodediv,$tahun,$x),$tahun,$x))}}%</th>
                                @endfor
                            <td colspan="2" align="right">{{((($score/total_bobot($kodediv,$tahun))*100)-($potongan/12))}}</td>
                        </tr>
                        @endif
                    </tbody>
                    
                </table>
                <table  width="100%" border="0" >
                    <thead>
                        <tr>
                            <td colspan="21"><center><h3><br><br></h3></center></td>
                        </tr>
                    </thead>
                </table>
                
            </div>
        @endforeach
    </body>
</html>