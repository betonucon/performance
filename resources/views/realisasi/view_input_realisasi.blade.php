@extends('layouts.app_admin')
<?php error_reporting(0); ?>

@section('content')
<style>
@media only screen and (min-width: 650px) {
        td{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 0.9vw;
            font-family: sans-serif;
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
            
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            
                            <div class="col-md-6">
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item"><b>Kode Unit</b> <a class="pull-right">{{$data['kode_unit']}}</a></li>
                                    <li class="list-group-item"><b>Nama Unit</b> <a class="pull-right">{{cek_unit($data['kode_unit'])['nama']}}</a></li>
                                    <li class="list-group-item"><b>Kode KPI</b> <a class="pull-right">{{$data['kode_kpi']}}</a></li>
                                    <li class="list-group-item"><b>KPI</b> <a class="pull-right">{{cek_kpi($data['kode_kpi'],$data['tahun'])['kpi']}}</a></li>
                                    <li class="list-group-item"><b>Level</b> <a class="pull-right">{{cek_level(cek_unit($data['kode_unit'])['unit_id'])}}</a></li>
                                    
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item"><b>Rumus Akumulasi</b> <a class="pull-right">{{cek_akumulasi($data['rumus_akumulasi'])}}</a></li>
                                    <li class="list-group-item"><b>Capaian</b> <a class="pull-right">{{cek_capaian($data['rumus_capaian'])}}</a></li>
                                    <li class="list-group-item"><b>Target Tahunan</b> <a class="pull-right">{{$data['target_tahunan']}}</a></li>
                                    <li class="list-group-item"><b>Status</b> <a class="pull-right">{{status($data['status_id'])}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>           

                           
                    <div class="box-body">       
                        <div class="row">
                            <div class="col-md-4">
                                <ul class="list-group list-group-unbordered">
                                    @foreach(get_target($data['id']) as $target)
                                        
                                        <li class="list-group-item">{{bulan($target['bulan'])}} <a class="pull-right"><input type="text" value="{{$target['target']}}"  disabled ></a></li>
                                    @endforeach
                                </ul>
                                
                            </div>
                            <div class="col-md-4">
                                <ul class="list-group list-group-unbordered" >
                                     @foreach(get_target($data['id']) as $target)
                                        
                                        <li class="list-group-item">{{bulan($target['bulan'])}} <a class="pull-right"><input type="text" value="{{$target['realisasi']}}"  disabled >
                                            
                                                
                                        </a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-1">
                                <ul class="list-group list-group-unbordered" >
                                    @foreach(get_target($data['id']) as $target)
                                        <li class="list-group-item" style="padding: 9px 0px 5px 7px;"><input type="text" disabled style="width:100%" value="{{hitung_capaian($data['rumus_capaian'],$target['target'],$target['realisasi'])}}%"></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="list-group list-group-unbordered" >
                                    @foreach(get_target($data['id']) as $target)
                                        <li class="list-group-item" style="padding: 5px 0px 5px 7px;">
                                            @if(hitung_capaian($data['rumus_capaian'],$target['target'],$target['realisasi'])>95)
                                                <span class="btn btn-default btn-sm" disabled><i class="fa fa-check"></i></span>
                                                <a class="pull-right"></a>
                                            @elseif(hitung_capaian($data['rumus_capaian'],$target['target'],$target['realisasi'])==0)
                                                <span class="btn btn-default btn-sm" disabled><i class="fa fa-remove"></i></span>
                                                <a class="pull-right"></a>
                                            @else
                                                <a href="{{url('_file_upload/'.$target['file'])}}" target="_blank"><span class="btn btn-primary btn-sm"><i class="fa fa-file"></i></span></a>
                                                <a class="pull-right">
                                                    <span class="btn btn-warning btn-sm" data-keyboard="false" data-backdrop="static" data-toggle="modal" data-target="#modalmasalah{{$target['id']}}"><i class="fa fa-comment"></i> Masalah</span>
                                                </a>
                                            @endif
                                            
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                   
                    
                    @if(Auth::user()['role_id']==1)
                        <div class="mailbox-controls" style="text-align:center;background:#e5e5f5;">
                            @if($data['status_id']==3)
                                <span  id="validasi_admin_target" class="btn btn-primary"   onclick="validasi_admin_target()" style="margin-left:5px;" ><i class="fa fa-check-square-o"></i> Proses Validasi </span>
                            @endif
                            <span class="btn btn-danger"  onclick="kembali()" id="kembali">Kembali</span>
                            <div id="loading"></div>
                         </div>
                    @endif

                    @if(Auth::user()['role_id']==3)
                        <div class="mailbox-controls" style="text-align:center;background:#e5e5f5;">
                            @if($data['status_id']==2)
                                <span  id="validasi_atasan_target" class="btn btn-primary"   onclick="validasi_atasan_target()" style="margin-left:5px;" ><i class="fa fa-check-square-o"></i> Proses Validasi</span>
                            @endif
                            @if($data['status_id']>4 && $data['status_realisasi']==2)
                                <span  id="validasi_atasan_realisasi" class="btn btn-primary"   onclick="validasi_atasan_realisasi()" style="margin-left:5px;" ><i class="fa fa-check-square-o"></i> Proses Validasi</span>
                            @endif
                            <span class="btn btn-danger"  onclick="kembali()" id="kembali">Kembali</span>
                            <div id="loading"></div>
                         </div>
                     @endif



                </div>
            </div>
       </div>
    </div>
</section>

<div class="modal fade" id="modalnotifikasi" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Error </h4>
            </div>
            <div class="modal-body">
                <div id="notifikasi"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('datepicker')
<script>
    @for($x=1;$x<13;$x++)   
        $('#datepicker_target{{$x}}').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        })
    @endfor
</script>
@endpush

@push('simpan')
<script>
    
    function kembali(){
        window.location.assign("{{url('/realisasi')}}?kode={{$kode}}&tahun={{$tahun}}");
    }

    function validasi_atasan_target(){
        
        var a="{{$id}}";
        $.ajax({
            type: 'GET',
            url: "{{url('/target/validasi_atasan_target')}}/"+a,
            data: "id="+a,
            beforeSend: function(){
                $('#validasi_atasan_target').hide();
                $('#kembali').hide();
                $('#loading').html('Proses Validasi ................');
            },
            success: function(msg){
                location.reload();
                
            }
        });
    }

    function validasi_admin_target(){
        
        var a="{{$id}}";
        $.ajax({
            type: 'GET',
            url: "{{url('/target/validasi_admin_target')}}/"+a,
            data: "id="+a,
            beforeSend: function(){
                $('#validasi_admin_target').hide();
                $('#kembali').hide();
                $('#loading').html('Proses Validasi ................');
            },
            success: function(msg){
                location.reload();
                
            }
        });
    }

    
</script>
@endpush
