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
                                    <li class="list-group-item"><b>Level</b> <a class="pull-right">{{cek_level($data['level'])}}</a></li>
                                    <li class="list-group-item"><b>Status</b> <a class="pull-right">{{status($data['status_id'])}}</a></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item"><b>Rumus Akumulasi</b> <a class="pull-right">{{cek_akumulasi($data['rumus_akumulasi'])}}</a></li>
                                    <li class="list-group-item"><b>Capaian</b> <a class="pull-right">{{cek_capaian($data['rumus_capaian'])}}</a></li>
                                    <li class="list-group-item"><b>Bobot Tahunan</b> <a class="pull-right">{{$data['bobot_tahunan']}}</a></li>
                                    <li class="list-group-item"><b>Target Tahunan</b> <a class="pull-right">{{$data['target_tahunan']}}</a></li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>           
                    <div style="width:100%;padding:10px;background:#e8e8f5">Daftar Target dan Realisasi {{$tahun}}</div>       
                    
                    @if($data['rumus_capaian']==3)           
                        <div class="box-body">       
                            <div class="row">
                                <div class="col-md-4">
                                    <form method="post" id="mytarget" enctype="multipart/form-data">
                                        @csrf
                                        <ul class="list-group list-group-unbordered">
                                            @for($b=1;$b<13;$b++)
                                                <?php if($b>9){$bul=$b;}else{$bul='0'.$b;} ?>
                                                <li class="list-group-item">{{bulan($bul)}} <a class="pull-right"><input type="text" name="target[]" value="{{target($id,$b)['target']}}" @if($data->status_realisasi==1 || $data->status_realisasi==2) disabled @else  @endif readonly id="datepicker_target{{$b}}"></a></li>
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
                    @endif

                    @if($data['rumus_capaian']==2 || $data['rumus_capaian']==1 || $data['rumus_capaian']==4)           
                        <div class="box-body">       
                            <div class="row">
                                <div class="col-md-4">
                                    <form method="post" id="mytarget" enctype="multipart/form-data">
                                        @csrf
                                        <ul class="list-group list-group-unbordered">
                                            @for($b=1;$b<13;$b++)
                                                <?php if($b>9){$bul=$b;}else{$bul='0'.$b;} ?>
                                                <li class="list-group-item">{{bulan($bul)}} <a class="pull-right"><input type="text" name="target[]" onkeypress="return hanyaAngka(event)" @if($data->status_realisasi==1 || $data->status_realisasi==2) disabled @else  @endif value="{{target($id,$b)['target']}}"  ></a></li>
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
                    @endif
                    
                    @if(Auth::user()['role_id']==2)
                        <div class="mailbox-controls" style="text-align:center;background:#e5e5f5;">
                            @if($data['status_id']==1 || $data['status_id']==2)
                                <span class="btn btn-success btn-sm" id="simpan_target" onclick="simpan_target()">Proses</span>
                                <span class="btn btn-danger btn-sm" id="kembali" onclick="kembali()">Kembali</span>
                                <div id="proses_loading"></div>
                            @else
                                <span class="btn btn-danger btn-sm"  onclick="kembali()">Kembali</span>
                            @endif
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
    function cari_nik(a){
        $.ajax({
            type: 'GET',
            url: "{{url('/unit/cek_nik/pic')}}/"+a,
            data: "id="+a,
            beforeSend: function(){
                $('#nama_pic').val('');
            },
            success: function(msg){
                if(msg=='terdaftar'){
                    alert('Sudah Terdaftar sebagai Atasan');
                }else{
                    $('#nama_pic').val(msg);
                }
                
            }
        });
    }

    function cari_atasan(a){
        $.ajax({
            type: 'GET',
            url: "{{url('/unit/cek_nik/atasan')}}/"+a,
            data: "id="+a,
            beforeSend: function(){
                $('#nama_atasan').val('');
            },
            success: function(msg){
                if(msg=='terdaftar'){
                    alert('Sudah Terdaftar sebagai PIC');
                }else{
                    $('#nama_atasan').val(msg);
                }
                
                
            }
        });
    }

    function simpan_target(){
        var form=document.getElementById('mytarget');
        var a="{{$id}}";
            $.ajax({
                type: 'POST',
                url: "{{url('/target/simpan_target')}}/"+a,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#simpan_target').hide();
                    $('#kembali').hide();
                    $('#proses_loading').html('<font color="red">Proses data ....................</font>');
                },
                success: function(msg){
                    
                    if(msg=='ok'){
                        location.reload();
                    }else{
                        $('#simpan_target').show();
                        $('#kembali').show();
                        $('#proses_loading').html('');
                    }
                    
                    
                }
            });

    } 
</script>
@endpush
