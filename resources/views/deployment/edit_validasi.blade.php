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
                            <form method="post" id="mydata" action="{{url('validasi/simpan')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="tahun" value="{{$tahun}}">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kode Unit</label>
                                        <input type="text" readonly name="kode_unit" value="{{$kode}}" class="form-control">
                                    </div>
                                    
                                    
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    
                                    <div class="form-group">
                                        <label>Nama Unit</label>
                                        <input type="text"  readonly value="{{cek_unit($kode)['nama']}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    @for($x=1;$x<13;$x++)
                                        <div class="form-group">
                                            <input type="hidden" name="bulan[]" value="{{$x}}">
                                            <label style="width:10%">{{bulan($x)}}</label>
                                            <input type="text" style="width:30%;display:inline" name="tanggal[]" value="{{tgl_validasi_atasan($kode,$tahun,$x)}}" id="datepickernya{{$x}}" >
                                        </div>
                                    @endfor
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
<div class="modal fade" id="modalloadinggg" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" >
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Loading ........ </h4>
            </div>
            <div class="modal-body">
                <img src="{{url('img/loading.gif')}}" width="100%">
            </div>
            <div class="modal-footer">
               
            </div>
        </div>
    </div>
</div>

@endsection

@push('simpan')
<script>
    @for($x=1;$x<13;$x++)   
        $('#datepickernya{{$x}}').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        })
    @endfor
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
        
            $.ajax({
                type: 'POST',
                url: "{{url('/validasi/simpan')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#modalloadinggg').modal({backdrop: 'static', keyboard: false});
                },
                success: function(msg){
                    
                    if(msg=='ok'){
                        location.reload();
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
