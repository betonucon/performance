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
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                    </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <form method="post" id="mydata" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kode Unit</label>
                                        <input type="text" readonly name="kode" value="{{$data['kode']}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>PIC</label>
                                        <input type="text" name="nik" onkeyup="cari_nik(this.value)" value="{{$data['nik']}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama PIC</label>
                                        <input type="text" readonly name="nama_pic" id="nama_pic" value="{{$data['nama_pic']}}" class="form-control">
                                    </div>
                                    
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    
                                    <div class="form-group">
                                        <label>Nama Unit</label>
                                        <input type="text"  name="name" value="{{$data['nama']}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Nik Atasan</label>
                                        <input type="text" name="nik_atasan" onkeyup="cari_atasan(this.value)" value="{{$data['nik_atasan']}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Atasan</label>
                                        <input type="text" readonly name="nama_atasan" id="nama_atasan" value="{{$data->user['name']}}" class="form-control">
                                    </div>
                                </div>
                            </form>
                            <div style="width:100%;display:flex;padding: 1.5%;">
                                <span id="simpan_data" onclick="simpan_data()" class="btn btn-primary">Simpan</span>
                                <div style="width:100%;text-align:center" id="proses_loading">
                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    
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

@push('simpan')
<script>
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

    function simpan_data(){
        var form=document.getElementById('mydata');
        var a="{{$id}}";
            $.ajax({
                type: 'POST',
                url: "{{url('/unit/simpan')}}/"+a,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#simpan_data').hide();
                    $('#proses_loading').html('Proses Pembayaran ....................');
                },
                success: function(msg){
                    
                    if(msg=='ok'){
                        window.location.assign("{{url('/unit/')}}");
                    }else{
                        $('#simpan_data').show();
                        $('#proses_loading').html('');
                        $('#modalnotifikasi').modal('show');
                        $('#notifikasi').html(msg);
                    }
                    
                    
                }
            });

    } 
</script>
@endpush
