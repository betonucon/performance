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
        <div style="padding:10px">
            <center><h3>LAPORAN CAPAIAN PERIODE {{$tahun}}<br>{{cek_unit($kode)['nama']}}</h3></center>
            <table  width="100%" border="1" >
                <thead>
                    <tr>
                        <th rowspan="2" width="5%">Kode KPI</th>
                        <th rowspan="2" width="14%" >Nama KPI</th>
                        <th rowspan="2" width="4%">Ket</th>
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
                    @foreach(deployment_realisasi_atasan($kode,$tahun) as $no=>$data)
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
                            <td rowspan="4">{{$data->kode_kpi}}</td>
                            <td rowspan="4">{{cek_kpi($data->kode_kpi)['kpi']}}</td>
                            <td rowspan="4" style="padding:0px;">{{cek_capaian($data['rumus_capaian'])}}<hr style="margin: 0px;border-color:#b7b7bd">{{cek_akumulasi($data['rumus_akumulasi'])}}</td>
                            <td rowspan="4">{{$data->target_tahunan}}</td>
                            <td rowspan="4">{{cek_kpi($data->kode_kpi)['satuan']}}</td>
                            <td>T</td>
                                @foreach(get_target($data['id']) as $detail)
                                    @if($data['rumus_capaian']==3)
                                    <td>{{tgl($detail['target'])}}</th>
                                    @else
                                    <td>{{$detail['target']}}</th>
                                    @endif
                                @endforeach
                            <td>{{akumulasi_target($data['id'])}}</td>
                            <td rowspan="4">{{score($data['id'],akumulasi_capaian($data['id'],akumulasi_target($data['id']),akumulasi_realisasi($data['id'])))}}</td>
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
                        <tr style="background:yellow">
                            <td>B</td>
                            @foreach(get_target($data['id']) as $detail)
                                <td>{{bobot_bulanan($data['kode_unit'],$data['kode_kpi'],$data['tahun'],$detail['bulan'])}}</th>
                            @endforeach
                            <td></td>
                        </tr>
                    @endforeach
                    @if($kode!='')
                    
                    
                    <tr style="background:{{$color}}">
                        <td colspan="6">TOTAL CAPAIAN</td>
                            @for($x=1;$x<13;$x++)
                            <td>{{total_capaian($kode,$tahun,$x)}}%</th>
                        @endfor
                        <td colspan="2" align="right">{{$score}}</td>
                    </tr>

                    <tr style="background:{{$color}}">
                        <td colspan="6">TOTAL BOBOT</td>
                            @for($x=1;$x<13;$x++)
                            <td>{{total_bobot($kode,$tahun,$x)}}%</th>
                        @endfor
                        <td colspan="2" align="right">{{total_bobot($kode,$tahun,$x)}}</td>
                    </tr>

                    <tr style="background:{{$color}}">
                        <td colspan="6">TOTAL CAPAIAN/TOTAL BOBOT</td>
                        <?php
                            $totbot=0;
                        ?>
                        @for($x=1;$x<13;$x++)
                            <?php $totbot+=total_bobot($kode,$tahun,$x); ?>
                            <td>{{nilai_max((total_capaian($kode,$tahun,$x)/total_bobot($kode,$tahun,$x))*100)}}%</th>
                        @endfor
                        <td colspan="2" align="right">{{nilai_max(($score*100)/100)}}</td>
                    </tr>

                    <tr style="background:{{$color}}">
                        <td colspan="6">POTONGAN KETERLAMBATAN</td>
                        <?php 
                            $potongan=0; 
                            
                        ?>
                        @for($x=1;$x<13;$x++)
                            <?php 
                                $potongan+=potongan(tgl_validasi_atasan($kode,$tahun,$x),$tahun,$x,total_capaian($kode,$tahun,$x)); 
                                
                            ?>
                            
                            <td>{{potongan(tgl_validasi_atasan($kode,$tahun,$x),$tahun,$x,total_capaian($kode,$tahun,$x))}}%</td>
                        @endfor
                        <td colspan="2" align="right">{{nilai_max($potongan/12)}}</td>
                    </tr>
                    <tr style="background:{{$color}}">
                        <td colspan="6">CAPAIAN AKHIR </td>
                            @for($x=1;$x<13;$x++)
                            <td>{{(nilai_max((total_capaian($kode,$tahun,$x)/total_bobot($kode,$tahun,$x))*100)-potongan(tgl_validasi_atasan($kode,$tahun,$x),$tahun,$x,total_capaian($kode,$tahun,$x)))}}%</th>
                            @endfor
                        <td colspan="2" align="right">{{nilai_max((($score*100)-($potongan/12))/100)}}</td>
                    </tr>
                    @endif
                </tbody>
                
            </table><br><br>
            <?php
                $bar=cek_unit($kode)['nama'].' '.$tahun;
            ?>
            <table width="100%" border="0">
                <tr>
                    <td width="10%" align="center"></td>
                    <td width="20%" align="center">{!!barcoderider($bar,4,4)!!}</td>
                    <td width="40%"></td>
                    <td width="30%" align="center" style="font-size:12px">Cilegon, {{ttd()}}<br><br><br><br><br><u>{{cek_nik(cek_unit($kode)['nik_atasan'])}}</u><br>{{cek_unit($kode)['nama']}}</td>
                </tr>
            </table>
            
        </div>
    </body>
</html>