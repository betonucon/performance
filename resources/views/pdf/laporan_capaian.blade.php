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
                padding:5px;
                color: #fff;
                border:solid 1px #000;
                text-align:center;
                font-size: 9px;
                font-family: sans-serif;
                background:#0d0d4a;
                text-transform:uppercase;
            }
            .tdh{
                border:solid 1px #000;
                font-size:20px;
                text-align:center;
                vertical-align:middle;
            }
            td{
                padding:3px;
                color: #000;
                font-size: 9px;
                font-family: sans-serif;
                vertical-align:top;
                border:solid 1px #000;
            }
            .cont{
                margin-top: 30px;
                width: 100%;
                padding:10px;
            }
        </style>
    </head> 
    <body>     
        <div class="cont">
            <table width="100%" border="0">
                <tr>
                    <td class="tdh" width="15%"><img src="{{public_path('img/logoks.png')}}" style="width:100%;"></td>
                    <td class="tdh">LAPORAN CAPAIAN PERIODE {{$tahun}}<br>{{cek_unit($kode)['nama']}}</td>
                </tr>
            </table>
            <br>
            <table  width="99%" border="1" >
                
                    <tr>
                        <th rowspan="2" width="4%">Kode KPI</th>
                        <th rowspan="2" >Nama KPI</th>
                        <th rowspan="2" width="4%">Ket</th>
                        <th rowspan="2" width="4%">Target</th>
                        <th rowspan="2" width="5%">Satuan</th>
                        <th rowspan="2" width="1%"></th>
                        <th colspan="12">bulan</th>
                        <th rowspan="2" width="5%">KOM</th>
                        <th rowspan="2" width="5%">SCORE</th>
                    </tr>
                    <tr>
                        @for($x=1;$x<13;$x++)
                        <th width="4%">{{$x}}</th>
                        @endfor
                    </tr>
                
                @foreach(pilar($kode,$tahun) as $nx=>$pil)
                
                    
                
                <tbody>
                    <tr>
                        <th style="background: #aaaacb; text-align: center; color: #000; text-transform: uppercase;">{{$pil->pilar}}</th>
                        <th colspan="19" style="background: #aaaacb; text-align: left; color: #000; text-transform: uppercase;">{{$pil->pilarnya['name']}}</th>
                    </tr>
                    <?php $score=0; ?>
                    @foreach(deployment_realisasi_atasan($kode,$tahun,$pil->pilar) as $no=>$data)
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
                            <td style="border-bottom:solid 0px #fff;">{{cek_kpi($data->kode_kpi,$data->tahun)['kpi']}}</td>
                            <td style="border-bottom:solid 0px #fff;" style="padding:0px;">{{cek_capaian($data['rumus_capaian'])}}<hr style="margin: 0px;border-color:#b7b7bd">{{cek_akumulasi($data['rumus_akumulasi'])}}</td>
                            <td style="border-bottom:solid 0px #fff;">{{$data->target_tahunan}}</td>
                            <td style="border-bottom:solid 0px #fff;">{{cek_kpi($data->kode_kpi,$data->tahun)['satuan']}}</td>
                            <td style="border-bottom:solid 0px #fff;">T</td>
                                @foreach(get_target($data['id']) as $detail)
                                    @if($data['rumus_capaian']==3)
                                    <td>{{tgl($detail['target'])}}</td>
                                    @else
                                    <td>{{$detail['target']}}</td>
                                    @endif
                                @endforeach
                            <td>{{number_format(akumulasi_target($data['id']),2)}}</td>
                            <td style="border-bottom:solid 0px #fff;">{{score($data['id'],akumulasi_capaian($data['id'],akumulasi_target($data['id']),akumulasi_realisasi($data['id'])))}}</td>
                        </tr>
                        <tr style="background:{{$color}}">
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
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                        </tr>
                        <tr style="background:{{$color}}">
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td>C</td>
                            @foreach(get_target($data['id']) as $detail)
                                <td>{{hitung_capaian($data['id'],$detail['target'],$detail['realisasi'],$tahun)}}%</td>
                            @endforeach
                            <td>{{nilai_max(akumulasi_capaian($data['id'],akumulasi_target($data['id']),akumulasi_realisasi($data['id'])),$tahun)}}</td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                        </tr>
                        <tr style="background:{{$color}}">
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td style="border-top:solid 0px #fff;border-bottom:solid 0px #fff;"></td>
                            <td>B</td>
                            @foreach(get_target($data['id']) as $detail)
                                <td>{{bobot_bulanan($data['kode_unit'],$data['kode_kpi'],$data['tahun'],$detail['bulan'])}}</td>
                            @endforeach
                            <td></td>
                            <td style="border-top:solid 0px #fff;"></td>
                        </tr>
                    @endforeach
                    @endforeach
                    @if($kode!='')
                    
                    
                    <tr style="background:{{$color}}">
                        <td colspan="6">TOTAL CAPAIAN</td>
                            @for($x=1;$x<13;$x++)
                            <td>{{total_capaian($kode,$tahun,$x)}}%</td>
                        @endfor
                        <td colspan="2" align="right">{{total_score($kode,$tahun)}}</td>
                    </tr>

                    <tr style="background:{{$color}}">
                        <td colspan="6">TOTAL BOBOT</td>
                            @for($x=1;$x<13;$x++)
                            <td>{{total_bobot($kode,$tahun,$x)}}%</td>
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
                            <td>{{nilai_max((total_capaian($kode,$tahun,$x)/total_bobot($kode,$tahun,$x))*100,$tahun)}}%</th>
                        @endfor
                        <td colspan="2" align="right">{{nilai_max((total_score($kode,$tahun)*100)/100,$tahun)}}</td>
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
                        <td colspan="2" align="right">{{nilai_max($potongan/12,$tahun)}}</td>
                    </tr>
                    <tr style="background:{{$color}}">
                        <td colspan="6">CAPAIAN AKHIR </td>
                            @for($x=1;$x<13;$x++)
                            <td>{{(nilai_max((total_capaian($kode,$tahun,$x)/total_bobot($kode,$tahun,$x))*100,$tahun)-potongan(tgl_validasi_atasan($kode,$tahun,$x),$tahun,$x,total_capaian($kode,$tahun,$x)))}}%</th>
                            @endfor
                        <td colspan="2" align="right">{{nilai_max(((total_score($kode,$tahun)*100)-($potongan/12))/100,$tahun)}}</td>
                    </tr>
                    @endif
                </tbody>
                
            </table><br><br>
            <?php
                $bar=cek_unit($kode)['nama'].' '.cek_unit($kode)['nama_atasan'];
            ?>
            <?php
                $bar=cek_unit($kode)['nama'].' '.cek_unit($kode)['nama_atasan'];
            ?>
            <table width="100%" border="0">
                <tr>
                    <td style="border:solid 1px #fff;font-size:14px" width="10%" align="center"></td>
                    <td style="border:solid 1px #fff;font-size:14px" width="20%" align="center"></td>
                    <td style="border:solid 1px #fff;font-size:14px" width="40%"></td>
                    <td style="border:solid 1px #fff;font-size:14px" width="30%" align="center" style="font-size:12px">Cilegon, {{ttd()}}</td>
                </tr>
            </table>
            <table width="100%" border="0">
                <tr>
                    <td style="border:solid 1px #fff;font-size:14px" width="10%" align="center"></td>
                    <td style="border:solid 1px #fff;font-size:14px" width="20%" align="center"></td>
                    <td style="border:solid 1px #fff;font-size:14px"></td>
                    <td style="border:solid 1px #fff;font-size:14px" width="20%" align="center" style="font-size:12px"><center>{!!barcoderider($bar,4,4)!!}</center></td>
                </tr>
            </table>
            <table width="100%" border="0">
                <tr>
                    <td style="border:solid 1px #fff;font-size:14px" width="10%" align="center"></td>
                    <td style="border:solid 1px #fff;font-size:14px" width="20%" align="center"></td>
                    <td style="border:solid 1px #fff;font-size:14px" width="40%"></td>
                    <td style="border:solid 1px #fff;font-size:14px" width="30%" align="center" style="font-size:12px"><u>{{cek_nik(cek_unit($kode)['nik_atasan'])}}</u><br>{{cek_unit($kode)['nama']}}</td>
                </tr>
            </table>
            
        </div>
    </body>
</html>