@extends('layouts.app_admin')
<?php error_reporting(0); ?>

@section('content')
<style>
@media only screen and (min-width: 650px) {
        th{
            padding:3px;
            border:solid 1px #bf9898;
            color: #575282;
            text-align:center;
            font-size: 0.7vw;
            font-family: sans-serif;
            background:#add4d4;
        }
        td{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 0.7vw;
            font-family: sans-serif;
            vertical-align:top;
        }
    }
    @media only screen and (max-width: 649px) {
        td{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 3vw;
            font-family: sans-serif;
        }
    }
</style>
<section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body" style="padding:10px">
                    
                        <div class="mailbox-controls" style="background:#f8f8fb;margin-bottom:10px;margin-top:5px;margin-bottom:20px">
                            <select id="kode" class="form-control" style="width: 30%;display: inline;">
                                <option value="">Pilih Unit</option>
                                @foreach(array_user() as $unit)
                                    <option value="{{$unit}}" @if($unit==$kode) selected @endif>{{cek_unit($unit)['nama']}}</option>
                                @endforeach
                            </select>
                            <select id="tahun" class="form-control" style="width: 10%;display: inline;">
                                @for($x=2019;$x<2030;$x++)
                                    <option value="{{$x}}" @if($x==$tahun) selected @endif>{{$x}}</option>
                                @endfor
                            </select>
                            <span  id="upload" class="btn btn-primary btn-sm"   onclick="cari()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-search"></i> Cari</span>
                            @if($kode!='')
                            <span  id="pdf" class="btn btn-success btn-sm"   onclick="pdf()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-pdf"></i> Download PDF</span>
                            <span  id="excel" class="btn btn-success btn-sm"   onclick="excel()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-excel"></i> Download Excel</span>
                            @endif
                        </div>
                        
                        <div style="width:100%;overflow-x:scroll;min-height:500px;padding:2%">
                            <table  width="130%" >
                                <thead>
                                    <tr>
                                        <th rowspan="2" width="5%">Kode KPI</th>
                                        <th rowspan="2"  >Nama KPI</th>
                                        <th rowspan="2" width="6%">Ket</th>
                                        <th rowspan="2" width="6%">Target</th>
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
                                        <?php if($no%2==0){$color="#fff";}else{$color="#f9f4fb";} ?>
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
                                        <td colspan="6">VALIDASI</td>
                                         @for($x=1;$x<13;$x++)
                                            <td> 
                                            
                                            @if(cek_validasi_atasan($kode,$tahun,$x)==array_deploymen_target_val($kode,$tahun,$x))
                                                {{tgl(tgl_validasi_atasan($kode,$tahun,$x))}}
                                            @else
                                                @if(array_deploymen_realisasi($kode,$tahun,$x)==array_deploymen_target($kode,$tahun,$x))
                                                <span class="btn btn-success btn-xs" id="validasi_bulanan{{$x}}" onclick="proses_validasi_bulanan('{{$kode}}','{{$x}}','{{$tahun}}')">Validasi</span>
                                                <div id="not_validasi_bulanan{{$x}}"></div>
                                                @else
                                                    {{array_deploymen_target($kode,$tahun,$x)}}-
                                                    {{array_deploymen_realisasi($kode,$tahun,$x)}}
                                                @endif
                                            @endif
                                            
                                            </td>
                                        @endfor
                                        <td colspan="2"></td>
                                    </tr>
                                    
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
                                            <td>{{substr(nilai_max((total_capaian($kode,$tahun,$x)/total_bobot($kode,$tahun,$x))*100),0,4)}}%</th>
                                        @endfor
                                        <td colspan="2" align="right">{{substr(nilai_max(($score/$totbot)*100),0,5)}}</td>
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
                                        <td colspan="2" align="right">{{($potongan/12)}}</td>
                                    </tr>
                                    <tr style="background:{{$color}}">
                                        <td colspan="6">CAPAIAN AKHIR </td>
                                         @for($x=1;$x<13;$x++)
                                            <td>{{(substr(nilai_max((total_capaian($kode,$tahun,$x)/total_bobot($kode,$tahun,$x))*100),0,4)-potongan(tgl_validasi_atasan($kode,$tahun,$x),$tahun,$x,total_capaian($kode,$tahun,$x)))}}%</th>
                                         @endfor
                                        <td colspan="2" align="right">{{substr(nilai_max((($score/$totbot)*100)-($potongan/12)),0,5)}}</td>
                                    </tr>
                                    @endif
                                </tbody>
                                
                            </table>
                        </div>
                
                </div>
            </div>
       </div>
    </div>
</section>



@endsection

@push('simpan')
<script>
    $(function () {
        $('#example1').DataTable({
            "scrollY": "90%",
            "scrollX": "100%",
            "scrollCollapse": true,
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
        })
    });  

    function pdf(){
        var kode="{{$kode}}";
        var tahun="{{$tahun}}";
        window.location.assign("{{url('/pdf/capaian')}}?kode="+kode+"&tahun="+tahun);
    }
    function excel(){
        var kode="{{$kode}}";
        var tahun="{{$tahun}}";
        window.location.assign("{{url('/excel/capaian')}}?kode="+kode+"&tahun="+tahun);
    }
    function cari(){
        var kode=$('#kode').val();
        var tahun=$('#tahun').val();
        if(kode==''){
            alert('Pilih Unit Kerja');
        }else{
            window.location.assign("{{url('/realisasi')}}?kode="+kode+"&tahun="+tahun);
        }
        
    }

    function proses_validasi_bulanan(kode,bulan,tahun){
        $.ajax({
            type: 'GET',
            url: "{{url('/realisasi/validasi_bulanan')}}/"+kode+"/"+bulan+"/"+tahun,
            data: "id="+bulan,
            beforeSend: function(){
                $('#validasi_bulanan'+bulan).hide();
                $('#not_validasi_bulanan'+bulan).html('Proses');
            },
            success: function(msg){
                
                location.reload();
                
            }
        });
        // alert(kode+"/"+tahun+"/"+a);
    }
</script>
@endpush
