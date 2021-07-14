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
                            @if(Auth::user()['role_id']==2)
                            <select id="kode" class="form-control" style="width: 30%;display: inline;">
                                <option value="">Pilih Unit</option>
                                {!!array_unit_user()!!}
                            </select>
                                
                            @endif
                            @if(Auth::user()['role_id']==3)
                            <select id="kode" class="form-control" style="width: 30%;display: inline;">
                                <option value="">Pilih Unit</option>
                                {!!array_unit_atasan()!!}
                            </select>
                                
                            @endif
                            @if(Auth::user()['role_id']==1)
                            <select id="kode" class="form-control" style="width: 30%;display: inline;">
                                <option value="">Pilih Unit</option>
                                @foreach(array_user() as $unit)
                                    <option value="{{$unit}}" @if($unit==$kode) selected @endif>{{cek_unit($unit)['nama']}}</option>
                                @endforeach
                            </select>
                            @endif
                            <select id="tahun" class="form-control" style="width: 10%;display: inline;">
                                @for($x=2019;$x<2030;$x++)
                                    <option value="{{$x}}" @if($x==$tahun) selected @endif>{{$x}}</option>
                                @endfor
                            </select>
                            <span  id="upload" class="btn btn-primary btn-sm"   onclick="cari()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-search"></i> Cari</span>
                            @if($kode!='')
                                @if(cek_deployment_realisasi_atasan($kode,$tahun)>0)
                                    <span  id="pdf" class="btn btn-success btn-sm"   onclick="pdf()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-pdf"></i> Download PDF</span>
                                    @if(Auth::user()['role_id']==1)
                                    <span  id="excel" class="btn btn-success btn-sm"   onclick="excel()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-excel"></i> Download Excel</span>
                                    @endif
                                @endif
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
                                @if(cek_deployment_realisasi_atasan($kode,$tahun)>0)
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
                                            <td rowspan="4">{{cek_kpi($data->kode_kpi,$data['tahun'])['kpi']}}</td>
                                            <td rowspan="4" style="padding:0px;">{{cek_capaian($data['rumus_capaian'])}}<hr style="margin: 0px;border-color:#b7b7bd">{{cek_akumulasi($data['rumus_akumulasi'])}}</td>
                                            <td rowspan="4">{{$data->target_tahunan}}</td>
                                            <td rowspan="4">{{cek_kpi($data->kode_kpi,$data['tahun'])['satuan']}}</td>
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
                                                <td>{{hitung_capaian($data['rumus_capaian'],$detail['target'],$detail['realisasi'],$tahun)}}%</th>
                                            @endforeach
                                            <td>{{nilai_max(akumulasi_capaian($data['id'],akumulasi_target($data['id']),akumulasi_realisasi($data['id'])),$tahun)}}</td>
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
                                         @foreach(get_target($data['id']) as $detail)
                                            <td> 
                                            @if(cek_validasi_atasan($kode,$tahun,$detail['bulan'])==array_deploymen_target_val($kode,$tahun,$detail['bulan']))
                                                {{tgl(tgl_validasi_atasan($kode,$tahun,$detail['bulan']))}}
                                            @else
                                                @if(array_deploymen_realisasi($kode,$tahun,$detail['bulan'])==array_deploymen_target($kode,$tahun,$detail['bulan']))
                                                    Proses
                                                @else
                                                    {{array_deploymen_target($kode,$tahun,$detail['bulan'])}}-
                                                    {{array_deploymen_realisasi($kode,$tahun,$detail['bulan'])}}
                                                @endif
                                            @endif
                                            
                                            </td>
                                        @endforeach
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
                                            <td>{{nilai_max((total_capaian($kode,$tahun,$x)/total_bobot($kode,$tahun,$x))*100,$tahun)}}%</th>
                                        @endfor
                                        <td colspan="2" align="right">{{nilai_max(($score*100)/100,$tahun)}}</td>
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
                                        <td colspan="2" align="right">{{nilai_max((($score*100)/100)-($potongan/12),$tahun)}}</td>
                                    </tr>
                                    @endif
                                </tbody>
                                @endif
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
            window.location.assign("{{url('/laporan')}}?kode="+kode+"&tahun="+tahun);
        }
        
    }
    function upload(){
        var form=document.getElementById('mydata');
        
            $.ajax({
                type: 'POST',
                url: "{{url('/deployment/import_data')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#upload').hide();
                    $('#proses_loading').html('Proses Pembayaran ....................');
                },
                success: function(msg){
                    
                    // if(msg=='ok'){
                    //     window.location.assign("{{url('/unit/')}}");
                    // }else{
                    //     $('#upload').show();
                    //     $('#proses_loading').html('');
                    //     $('#modalnotifikasi').modal('show');
                    //     $('#notifikasi').html(msg);
                    // }
                    alert(msg);
                    
                    
                }
            });

    }  
</script>
@endpush
