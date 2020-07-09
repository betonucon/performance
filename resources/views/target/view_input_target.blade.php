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
                                    <li class="list-group-item"><b>KPI</b> <a class="pull-right">{{cek_kpi($data['kode_kpi'])['kpi']}}</a></li>
                                    <li class="list-group-item"><b>Level</b> <a class="pull-right">{{cek_level($data['level'])}}</a></li>
                                    
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
                                <form method="post" id="mytarget" enctype="multipart/form-data">
                                    @csrf
                                    <ul class="list-group list-group-unbordered">
                                        @for($b=1;$b<13;$b++)
                                            <?php if($b>9){$bul=$b;}else{$bul='0'.$b;} ?>
                                            <li class="list-group-item">{{bulan($bul)}} <a class="pull-right"><input type="text" name="target[]" value="{{target($id,$b)['target']}}" disabled id="datepicker_target{{$b}}"></a></li>
                                            <input type="hidden" name="id[]" value="{{target($id,$b)['id']}}">
                                            <input type="hidden" name="bulan[]" value="{{$b}}">
                                        @endfor
                                    </ul>
                                </form>
                                
                            </div>
                            <div class="col-md-8">
                                <ul class="list-group list-group-unbordered" >
                                    @for($b=1;$b<13;$b++)
                                        <?php if($b>9){$bul=$b;}else{$bul='0'.$b;} ?>
                                        <li class="list-group-item">&nbsp; <a class="pull-right"></a></li>
                                    @endfor
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                   
                    
                    @if(Auth::user()['role_id']==1)
                        <div class="mailbox-controls" style="text-align:center;background:#e5e5f5;">
                            @if($data['status_id']==3)
                                <span  id="validasi_admin_target" class="btn btn-primary"   onclick="validasi_admin_target()" style="margin-left:5px;" ><i class="fa fa-check-square-o"></i> Proses Validasi </span>
                            @endif
                            @if($data['status_id']==4)
                                <span  id="unvalidasi_admin_target" class="btn btn-success"   onclick="unvalidasi_admin_target()" style="margin-left:5px;" ><i class="fa fa-remove"></i> Unvalidasi </span>
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
        window.location.assign("{{url('/target')}}?kode={{$kode}}&tahun={{$tahun}}");
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

    function unvalidasi_admin_target(){
        
        var a="{{$id}}";
        $.ajax({
            type: 'GET',
            url: "{{url('/target/unvalidasi_admin_target')}}/"+a,
            data: "id="+a,
            beforeSend: function(){
                $('#unvalidasi_admin_target').hide();
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
