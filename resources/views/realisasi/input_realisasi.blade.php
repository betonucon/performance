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
                                    <li class="list-group-item"><b>Bobot Tahunan</b> <a class="pull-right">{{$data['bobot_tahunan']}}</a></li>
                                    <li class="list-group-item"><b>Target Tahunan</b> <a class="pull-right">{{$data['target_tahunan']}}</a></li>
                                    <li class="list-group-item"><b>Status</b> <a class="pull-right">{{status($data['status_id'])}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>           

                    <div style="width:100%;padding:10px;background:#e8e8f5">Daftar Target dan Realisasi {{$tahun}}</div>       
                    
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
                                            @if($target['target']==0)
                                            <span class="btn btn-default btn-sm"><i class="fa fa-pencil"></i></span>
                                            @else
                                                @if($target['tgl_validasi_atasan']!=null)
                                                <span class="btn btn-default btn-sm"><i class="fa fa-pencil"></i></span>
                                                @else
                                                <span class="btn btn-success btn-sm" data-keyboard="false" data-backdrop="static" data-toggle="modal" data-target="#inputrealisasi{{$target['id']}}"><i class="fa fa-pencil"></i></span>
                                                @endif
                                            @endif
                                                
                                        </a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-1">
                                <ul class="list-group list-group-unbordered" >
                                    @foreach(get_target($data['id']) as $target)
                                        <li class="list-group-item" style="padding: 9px 0px 5px 7px;"><input type="text" disabled style="width:100%" value="{{hitung_capaian($data['rumus_capaian'],$target['target'],$target['realisasi'],$data['tahun'])}}%"></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="list-group list-group-unbordered" >
                                    @foreach(get_target($data['id']) as $target)
                                        <li class="list-group-item" style="padding: 5px 0px 5px 7px;">
                                            @if(hitung_capaian($data['id'],$target['target'],$target['realisasi'],$data['tahun'])>95)
                                                <a href="{{url('_file_upload/'.$target['file'])}}" target="_blank"><span class="btn btn-primary btn-sm"><i class="fa fa-file"></i></span></a>
                                                <a class="pull-right"></a>
                                            @elseif(hitung_capaian($data['id'],$target['target'],$target['realisasi'],$data['tahun'])==0)
                                                @if($target['target']!=0 && $target['realisasi']!=0)
                                                <a href="{{url('_file_upload/'.$target['file'])}}" target="_blank"><span class="btn btn-primary btn-sm"><i class="fa fa-file"></i></span></a>
                                                <a class="pull-right">
                                                    <span class="btn btn-warning btn-sm" data-keyboard="false" data-backdrop="static" data-toggle="modal" data-target="#modalmasalah{{$target['id']}}"><i class="fa fa-comment"></i> Masalah</span>
                                                </a>
                                                
                                                @else
                                                <span class="btn btn-default btn-sm" disabled><i class="fa fa-remove"></i></span>
                                                <a class="pull-right"></a>
                                                @endif
                                                
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
                   

                    @if(Auth::user()['role_id']==2)
                        <div class="mailbox-controls" style="text-align:center;background:#e5e5f5;">
                            @if($data['status_id']==1 || $data['status_id']==2)
                                <span class="btn btn-success btn-sm" id="simpan_target" onclick="simpan_target()">Proses</span>
                                <span class="btn btn-danger btn-sm"  onclick="kembali()">Kembali</span>
                                <div id="proses_loading_target"></div>
                            @endif
                            <!-- @if($data['status_id']==4 && $data['status_realisasi']==1 || $data['status_realisasi']==2 )
                                <span class="btn btn-success btn-sm" id="simpan_realisasi" onclick="simpan_realisasi()">Proses</span>
                                <span class="btn btn-danger btn-sm"  onclick="kembali()">Kembali</span>
                                <div id="proses_loading_target"></div>
                            @endif -->
                         </div>
                    @endif

                    



                </div>
            </div>
       </div>
    </div>
</section>

    @foreach(get_target($data['id']) as $target)
        <div class="modal fade" id="inputrealisasi{{$target['id']}}" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Input Realisasi </h4>
                    </div>
                    <div class="modal-body">
                        <div id="notifikasi_realisasi{{$target['id']}}"></div>
                            <form method="get" id="myrealisasi{{$target['id']}}" enctype="multipart/form-data">
                                @csrf
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item" style="background: none;"><b>Rumus Akumulasi</b> <a class="pull-right">{{cek_akumulasi($data['rumus_akumulasi'])}}</a></li>
                                    <li class="list-group-item" style="background: none;"><b>Rumus Capaian</b> <a class="pull-right">{{cek_capaian($data['rumus_capaian'])}}</a></li>
                                </ul>
                                <div class="form-group">
                                    <label>Target</label>
                                    <input type="text" readonly id="target" value="{{$target['target']}}" class="form-control">
                                </div>
                                
                                
                                @if($data['rumus_capaian']==3)  
                                    <div class="form-group">
                                        <label>Realisasi {{$target['target']}}</label>
                                        <input type="text"  name="realisasi" value="{{$target['realisasi']}}" class="form-control" readonly onchange="cek_realisasi({{$data['tahun']}},this.value,'{{$target['target']}}',{{$target['id']}})" id="datepicker_realisasi{{$target['id']}}">
                                    </div>
                                @endif
                                
                                @if($data['rumus_capaian']==2 || $data['rumus_capaian']==1 || $data['rumus_capaian']==4)
                                    <div class="form-group">
                                        <label>Realisasi</label>
                                        <input type="text" name="realisasi" value="{{$target['realisasi']}}" onkeyup="cek_realisasi({{$data['tahun']}},this.value,{{$target['target']}},{{$target['id']}})" onkeypress="return hanyaAngka(event)" class="form-control">
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>Capaian</label>
                                    <input type="text" readonly name="capaian" id="capaian{{$target['id']}}"  value="{{hitung_capaian($data['rumus_capaian'],$target['target'],$target['realisasi'],$data['tahun'])}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>file</label>
                                    <input type="file" name="file"  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Masalah</label><br>
                                    <textarea disabled name="masalah" id="masalah{{$target['id']}}" style="width:100%" rows="3" >{{$target['masalah']}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Rencana</label><br>
                                    <textarea disabled name="rencana" id="rencana{{$target['id']}}" style="width:100%" rows="3" >{{$target['rencana']}}</textarea>
                                </div>
                            </form>
                    </div>
                    <div class="modal-footer">
                        
                        <div id="proses_loading_realisasi{{$target['id']}}"></div>
                        <span  id="tutup_realisasi{{$target['id']}}" class="btn btn-default pull-left" data-dismiss="modal">Tutup</span>
                        <span  id="simpan_realisasi{{$target['id']}}" class="btn btn-primary pull-right" onclick="simpan_realisasi({{$target['id']}})">Simpan</span>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modalmasalah{{$target['id']}}" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title"> </h4>
                    </div>
                    <div class="modal-body">
                        <div id="notifikasi_realisasi{{$target['id']}}"></div>
                            <form method="get" id="mymasalah{{$target['id']}}" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="form-group">
                                    <label>Masalah</label>
                                    <textarea disabled name="masalah"  style="width:100%" rows="3" >{{$target['masalah']}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Rencana</label>
                                    <textarea disabled name="rencana"  style="width:100%" rows="3" >{{$target['rencana']}}</textarea>
                                </div>
                            </form>
                    </div>
                    <div class="modal-footer">
                        
                        <div id="proses_loading_masalah{{$target['id']}}"></div>
                        <span  id="tutup_masalah{{$target['id']}}" class="btn btn-default pull-left" data-dismiss="modal">Tutup</span>
                        <span  id="simpan_masalah{{$target['id']}}" class="btn btn-primary pull-right" onclick="simpan_realisasi({{$target['id']}})">Simpan</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('datepicker')
<script>
    @foreach(get_target($data['id']) as $target) 
        $('#datepicker_realisasi{{$target['id']}}').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        })

        $( document ).ready(function() {
            var cap= $('#capaian{{$target['id']}}').val();
            if(cap=='' || cap==0){
                if(cap==0){
                    $("#masalah{{$target['id']}}").prop( "disabled", true );
                    $("#rencana{{$target['id']}}").prop( "disabled", true );
                }else{
                    $("#masalah{{$target['id']}}").prop( "disabled", true );
                    $("#rencana{{$target['id']}}").prop( "disabled", true );
                }
                
            }else{
                if(cap>95){
                
                    $("#masalah{{$target['id']}}").prop( "disabled", true );
                    $("#rencana{{$target['id']}}").prop( "disabled", true );
                }else{
                    $("#masalah{{$target['id']}}").prop( "disabled", true );
                    $("#rencana{{$target['id']}}").prop( "disabled", true );
                }
            }
            

        });
    @endforeach
</script>
@endpush

@push('simpan')
<script>
   
    function kembali(){
        window.location.assign("{{url('/target')}}?kode={{$kode}}&tahun={{$tahun}}");
    }

    function cek_realisasi(tahun,realisasi,target,id){
        
        var akumulasi="{{$data['rumus_akumulasi']}}";
        var capaian="{{$data['rumus_capaian']}}";
        $.ajax({
            type: 'GET',
            url: "{{url('/realisasi/perhitungan')}}",
            data: "id="+id+"&akumulasi="+akumulasi+"&capaian="+capaian+"&target="+target+"&realisasi="+realisasi+"&tahun="+tahun,
            success: function(msg){
                if(msg>95){
                    $("#masalah"+id).prop( "disabled", true );
                    $("#rencana"+id).prop( "disabled", true );
                    $('#capaian'+id).val(msg);
                }else{
                    $("#masalah"+id).prop( "disabled", false );
                    $("#rencana"+id).prop( "disabled", false );
                    $('#capaian'+id).val(msg);
                }
               
                
            }
        });
    }

    

    function simpan_realisasi(a){
        var form=document.getElementById('myrealisasi'+a);
      
            $.ajax({
                type: 'POST',
                url: "{{url('/realisasi/simpan_realisasi')}}/"+a,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#simpan_realisasi'+a).hide();
                    $('#tutup_realisasi'+a).hide();
                    $('#proses_loading_realisasi'+a).html('<font color="red">Proses data ....................</font>');
                },
                success: function(msg){
                    
                    if(msg=='ok'){
                        location.reload();
                    }else{
                        $('#simpan_realisasi'+a).show();
                        $('#tutup_realisasi'+a).show();
                        $('#proses_loading_realisasi'+a).html('');
                        $('#notifikasi_realisasi'+a).html(msg);
                    }
                    
                    
                }
            });

    } 
</script>
@endpush
