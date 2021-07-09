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
            <center><h3>LAPORAN CAPAIAN PERIODE {{$tahun}}<br>KPI MANDATORI</h3></center>
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
                    @foreach(deployment_mandatori_capaian($tahun) as $no=>$data)
                        <?php $score+=score($data['id'],akumulasi_capaian($data['id'],akumulasi_target($data['id']),akumulasi_realisasi($data['id'])));?>
                    <?php if($no%2==0){$color="#fff";}else{$color="#f9f4fb";} ?>
                        <tr style="background:{{$color}}">
                            <td rowspan="3">{{$data->kode_kpi}}</td>
                            <td rowspan="3">{{cek_kpi($data->kode_kpi,$data->tahun)['kpi']}}</td>
                            <td rowspan="3" style="padding:0px;">{{cek_capaian($data['rumus_capaian'])}}<hr style="margin: 0px;border-color:#b7b7bd">{{cek_akumulasi($data['rumus_akumulasi'])}}</td>
                            <td rowspan="3">{{$data->bobot_tahunan}}</td>
                            <td rowspan="3">{{$data->target_tahunan}}</td>
                            <td rowspan="3">{{cek_kpi($data->kode_kpi,$data->tahun)['satuan']}}</td>
                            <td>T</td>
                                @foreach(get_target($data['id']) as $detail)
                                    @if($data['rumus_capaian']==3)
                                    <td>{{tgl($detail['target'])}}</th>
                                    @else
                                    <td>{{$detail['target']}}</th>
                                    @endif
                                @endforeach
                            <td>{{round(akumulasi_target($data['id']),1)}}</td>
                            <td rowspan="3">{{round(score($data['id'],akumulasi_capaian($data['id'],akumulasi_target($data['id']),akumulasi_realisasi($data['id']))),1)}}</td>
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
                            <td>{{round(akumulasi_realisasi($data['id']),1)}}</td>
                        </tr>
                        <tr style="background:{{$color}}">
                            <td>C</td>
                            @foreach(get_target($data['id']) as $detail)
                                <td>{{hitung_capaian($data['rumus_capaian'],$detail['target'],$detail['realisasi'],$tahun)}}%</th>
                            @endforeach
                            <td>{{round(akumulasi_capaian($data['id'],akumulasi_target($data['id']),akumulasi_realisasi($data['id'])),1)}}</td>
                        </tr>
                    @endforeach
                        <tr style="background:{{$color}}">
                            <td colspan="7">TOTAL CAPAIAN</td>
                            @for($x=1;$x<13;$x++)
                                <td>{{total_capaian_mandatori($tahun,$x)}}%</th>
                            @endfor
                            <td colspan="2" align="right">{{round($score,2)}}</td>
                        </tr>

                        <tr style="background:{{$color}}">
                            <td colspan="7">TOTAL BOBOT</td>
                            @for($x=1;$x<13;$x++)
                                <td>{{total_bobot_mandatori($tahun)}}%</th>
                                @endfor
                            <td colspan="2" align="right">{{total_bobot_mandatori($tahun)}}</td>
                        </tr>

                        <tr style="background:{{$color}}">
                            <td colspan="7">TOTAL CAPAIAN/TOTAL BOBOT</td>
                            @for($x=1;$x<13;$x++)
                                <td>{{substr((total_capaian_mandatori($tahun,$x)/total_bobot_mandatori($tahun))*100,0,4)}}%</th>
                            @endfor
                            <td colspan="2" align="right">{{($score/total_bobot_mandatori($tahun))*100}}</td>
                        </tr>
                        <tr style="background:{{$color}}">
                            <td colspan="7">POTONGAN KETERLAMBATAN</td>
                            <?php 
                                $potongan=0; 
                                
                            ?>
                            @for($x=1;$x<13;$x++)
                                <?php 
                                    $potongan+=potongan(tgl_validasi_atasan_mandatori($tahun,$x),$tahun,$x); 
                                    
                                ?>
                                
                                <td>{{potongan(tgl_validasi_atasan_mandatori($tahun,$x),$tahun,$x)}}%</td>
                            @endfor
                            <td colspan="2" align="right">{{($potongan/12)}}</td>
                        </tr>
                        <tr style="background:{{$color}}">
                            <td colspan="7">CAPAIAN AKHIR </td>
                                @for($x=1;$x<13;$x++)
                                <td>{{(substr((total_capaian_mandatori($tahun,$x)/total_bobot_mandatori($tahun))*100,0,4)-potongan(tgl_validasi_atasan_mandatori($tahun,$x),$tahun,$x))}}%</th>
                                @endfor
                            <td colspan="2" align="right">{{((($score/total_bobot_mandatori($tahun))*100)-($potongan/12))}}</td>
                        </tr>
                </tbody>
                
            </table><br><br>
            <?php
                $bar='KPI Mandatori '.$tahun;
            ?>
            <table width="100%" border="0">
                <tr>
                    <td width="10%" align="center"></td>
                    <td width="20%" align="center">{!!barcoderider($bar,4,4)!!}</td>
                    <td width="40%"></td>
                    <td width="30%" align="center" style="font-size:12px">Cilegon, {{ttd()}}<br><br><br><br><br><u>{{cek_nik(cek_unit($kode)['nik_atasan'])}}</u><br>(.......................)</td>
                </tr>
            </table>
            
        </div>
    </body>
</html>