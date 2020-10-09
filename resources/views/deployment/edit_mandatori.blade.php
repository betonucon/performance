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
                                        <input type="text"  name="kode_unit" value="{{$data['kode_unit']}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Unit</label>
                                        <input type="text" name="nik" readonly value="{{cek_unit($data['kode_unit'])['nama']}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Kode KPI</label>
                                        <input type="text" readonly name="kode_kpi" id="kode_kpi" value="{{$data['kode_kpi']}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Level</label>
                                        <input type="text" readonly name="level" id="level" value="{{cek_level($data['level'])}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select name="sts" class="form-control">
                                            @foreach(kategori() as $kategori)
                                                <option value="{{$kategori->id}}" @if($kategori->id==$data->sts) selected @endif>{{$kategori->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    
                                    <div class="form-group">
                                        <label>Akumulasi</label>
                                        <select name="rumus_akumulasi" class="form-control">
                                            @foreach(akumulasi_all() as $akumulasi)
                                                <option value="{{$akumulasi->id}}" @if($akumulasi->id==$data->rumus_akumulasi) selected @endif>{{$akumulasi->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Capaian</label>
                                        <select name="rumus_capaian" class="form-control">
                                            @foreach(capaian_all() as $capaian)
                                                <option value="{{$capaian->id}}" @if($capaian->id==$data->rumus_capaian) selected @endif>{{$capaian->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Target Tahunan</label>
                                        <input type="text"  name="target_tahunan" id="target_tahunan" value="{{$data['target_tahunan']}}" class="form-control">
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
                url: "{{url('/deployment/simpan')}}/"+a,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#simpan_data').hide();
                    $('#proses_loading').html('Proses simpan data....................');
                },
                success: function(msg){
                    
                    if(msg=='ok'){
                        window.location.assign("{{url('/deployment/mandatori')}}");
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
