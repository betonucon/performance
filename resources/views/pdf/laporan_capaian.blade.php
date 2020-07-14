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
            .cont{
                margin-top: 30px;
                height: 100%;
                width: 100%;
                padding:10px;
            }
        </style>
    </head> 
    <body>     
        <div class="cont">
            <center><h3>LAPORAN CAPAIAN PERIODE {{$tahun}}<br>{{cek_unit($kode)['nama']}}</h3></center>
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
                            <td style="border-bottom:solid 0px #fff;">{{$data->kode_kpi}}</td>
                            <td style="border-bottom:solid 0px #fff;">{{cek_kpi($data->kode_kpi)['kpi']}}</td>
                            <td style="border-bottom:solid 0px #fff;" style="padding:0px;">{{cek_capaian($data['rumus_capaian'])}}<hr style="margin: 0px;border-color:#b7b7bd">{{cek_akumulasi($data['rumus_akumulasi'])}}</td>
                            <td style="border-bottom:solid 0px #fff;">{{$data->bobot_tahunan}}</td>
                            <td style="border-bottom:solid 0px #fff;">{{$data->target_tahunan}}</td>
                            <td style="border-bottom:solid 0px #fff;">{{cek_kpi($data->kode_kpi)['satuan']}}</td>
                            <td style="border-bottom:solid 0px #fff;">T</td>
                                @foreach(get_target($data['id']) as $detail)
                                    @if($data['rumus_capaian']==3)
                                    <td>{{tgl($detail['target'])}}</td>
                                    @else
                                    <td>{{$detail['target']}}</td>
                                    @endif
                                @endforeach
                            <td>{{number_format(akumulasi_target($data['id']),2)}}</td>
                            <td rowspan="3">{{score($data['id'],akumulasi_capaian($data['id'],akumulasi_target($data['id']),akumulasi_realisasi($data['id'])))}}</td>
                        </tr>
                        <tr style="background:{{$color}}">
                        <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td>R</td>
                            @foreach(get_target($data['id']) as $detail)
                                @if($data['rumus_capaian']==3)
                                    <td>{{tgl($detail['realisasi'])}}</td>
                                @else
                                    <td>{{$detail['realisasi']}}</td>
                                @endif
                            @endforeach
                            <td>{{number_format(akumulasi_realisasi($data['id']),2)}}</td>
                        </tr>
                        <tr style="background:{{$color}}">
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td>C</td>
                            @foreach(get_target($data['id']) as $detail)
                                <td>{{hitung_capaian($data['rumus_capaian'],$detail['target'],$detail['realisasi'])}}%</td>
                            @endforeach
                            <td>{{akumulasi_capaian($data['id'],akumulasi_target($data['id']),akumulasi_realisasi($data['id']))}}</td>
                        </tr>
                    @endforeach
                    @if($kode!='')
                    
                    
                    <tr style="background:{{$color}}">
                        <td colspan="7">TOTAL CAPAIAN</td>
                            @foreach(get_target($data['id']) as $detail)
                            <td>{{total_capaian($kode,$tahun,$detail['bulan'])}}%</td>
                        @endforeach
                        <td colspan="2" align="right">{{$score}}</td>
                    </tr>

                    <tr style="background:{{$color}}">
                        <td colspan="7">TOTAL BOBOT</td>
                            @foreach(get_target($data['id']) as $detail)
                            <td>{{total_bobot($kode,$tahun)}}%</td>
                        @endforeach
                        <td colspan="2" align="right">{{total_bobot($kode,$tahun)}}</td>
                    </tr>

                    <tr style="background:{{$color}}">
                        <td colspan="7">TOTAL CAPAIAN/TOTAL BOBOT</td>
                            @foreach(get_target($data['id']) as $detail)
                            <td>{{substr((total_capaian($kode,$tahun,$detail['bulan'])/total_bobot($kode,$tahun))*100,0,4)}}%</td>
                        @endforeach
                        <td colspan="2" align="right">{{($score/total_bobot($kode,$tahun))*100}}</td>
                    </tr>

                    <tr style="background:{{$color}}">
                        <td colspan="7">POTONGAN KETERLAMBATAN</td>
                        <?php 
                            $potongan=0; 
                            
                        ?>
                        @for($x=1;$x<13;$x++)
                            <?php 
                                $potongan+=potongan(tgl_validasi_atasan($kode,$tahun,$x),$tahun,$x); 
                                
                            ?>
                            
                            <td>{{potongan(tgl_validasi_atasan($kode,$tahun,$x),$tahun,$x)}}%</td>
                        @endfor
                        <td colspan="2" align="right">{{($potongan/12)}}</td>
                    </tr>
                    <tr style="background:{{$color}}">
                        <td colspan="7">CAPAIAN AKHIR </td>
                            @for($x=1;$x<13;$x++)
                            <td>{{(substr((total_capaian($kode,$tahun,$x)/total_bobot($kode,$tahun))*100,0,4)-potongan(tgl_validasi_atasan($kode,$tahun,$x),$tahun,$x))}}%</td>
                            @endfor
                        <td colspan="2" align="right">{{((($score/total_bobot($kode,$tahun))*100)-($potongan/12))}}</td>
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