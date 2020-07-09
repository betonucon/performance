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
                
                    <div class="box-body">
                        <span  class="btn btn-default btn-sm" data-toggle="modal" style="margin-bottom:2%" data-target="#modaltambah"   ><i class="fa fa-add"></i> Tambah</span>
                        <table  class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Tahun</th>
                                    <th>Tanggal</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach(validasi_tanggal() as $no=>$data)
                                <tr>
                                    <td>{{$no+1}}</td>
                                    <td>{{$data->tahun}}</td>
                                    <td>{{$data->tanggal}}</td>
                                    <td><span class="btn btn-success btn-sm" data-toggle="modal" data-target="#modaledit{{$data->id}}"><i class="fa fa-pencil"></i></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                     </div>
                   
                    
                
            </div>
       </div>
    </div>
</section>
@foreach(validasi_tanggal() as $no=>$data)
<div class="modal fade" id="modaledit{{$data->id}}" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Form Tanggal Validasi </h4>
            </div>
            <div class="modal-body">
                <div id="notifikasi_edit_simpan_tanggal_validasi{{$data->id}}"></div>
                <form method="post" id="myedit_simpan_tanggal_validasi{{$data->id}}" enctype="multipart/form-data">
                    @csrf
                    
                        <div class="form-group">
                            <label>Tanggal</label>
                            <select  name="tanggal" value="{{$data['tanggal']}}" class="form-control">
                                <option value="">Pilih Tanggal------</option>
                                @for($x=1;$x<32;$x++)
                                    <option value="{{bulan_db($x)}}" @if($data['tanggal']==$x) selected @endif>{{bulan_db($x)}}</option>
                                @endfor
                            </select>
                        </div>
                        
                    
                </form>
                <div style="width:100%;display:flex;">
                     <span id="edit_simpan_tanggal_validasi{{$data->id}}" style="margin-right:2%" onclick="edit_simpan_tanggal_validasi({{$data->id}})" class="btn btn-primary pull-left">Simpan</span>
                    <span id="tutup_edit_simpan_tanggal_validasi{{$data->id}}" data-dismiss="modal" class="btn btn-default pull-right">Tutup</span>
                    <div style="width:100%;text-align:center" id="proses_loading_edit_simpan_tanggal_validasi{{$data->id}}">
                    
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endforeach
<div class="modal fade" id="modaltambah" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Form Tanggal Validasi </h4>
            </div>
            <div class="modal-body">
                <div id="notifikasi_simpan_tanggal_validasi"></div>
                <form method="post" id="mysimpan_tanggal_validasi" enctype="multipart/form-data">
                    @csrf
                    
                        <div class="form-group">
                            <label>Tanggal</label>
                            <select  name="tanggal" value="{{$data['tanggal']}}" class="form-control">
                                <option value="">Pilih Tanggal------</option>
                                @for($x=1;$x<32;$x++)
                                    <option value="{{bulan_db($x)}}">{{bulan_db($x)}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tahun</label>
                            <select  name="tahun" value="{{$data['tahun']}}" class="form-control">
                                <option value="">Pilih Tahun------</option>
                                @for($x=2019;$x<2040;$x++)
                                    <option value="{{$x}}">{{$x}}</option>
                                @endfor
                            </select>
                        </div>
                        
                    
                </form>
                <div style="width:100%;display:flex;">
                     <span id="simpan_tanggal_validasi" style="margin-right:2%" onclick="simpan_tanggal_validasi()" class="btn btn-primary pull-left">Simpan</span>
                    <span id="tutup_simpan_tanggal_validasi" data-dismiss="modal" class="btn btn-default pull-right">Tutup</span>
                    <div style="width:100%;text-align:center" id="proses_loading_simpan_tanggal_validasi">
                    
                    </div>
                </div>
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

    function simpan_tanggal_validasi(){
        var form=document.getElementById('mysimpan_tanggal_validasi');
        var a="{{$id}}";
            $.ajax({
                type: 'POST',
                url: "{{url('/pengaturan/simpan_tanggal_validasi')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#simpan_tanggal_validasi').hide();
                    $('#tutup_simpan_tanggal_validasi').hide();
                    $('#proses_loading_simpan_tanggal_validasi').html('Proses Pembayaran ....................');
                },
                success: function(msg){
                    
                    if(msg=='ok'){
                        location.reload();
                    }else{
                        $('#simpan_tanggal_validasi').show();
                        $('#tutup_simpan_tanggal_validasi').show();
                        $('#proses_loading_simpan_tanggal_validasi').html('');
                        $('#notifikasi_simpan_tanggal_validasi').html(msg);
                    }
                    
                    
                }
            });

    } 

    function edit_simpan_tanggal_validasi(a){
        var form=document.getElementById('myedit_simpan_tanggal_validasi'+a);
        
            $.ajax({
                type: 'POST',
                url: "{{url('/pengaturan/edit_simpan_tanggal_validasi')}}/"+a,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#edit_simpan_tanggal_validasi'+a).hide();
                    $('#tutup_edit_simpan_tanggal_validasi'+a).hide();
                    $('#proses_loading_edit_simpan_tanggal_validasi'+a).html('Proses Pembayaran ....................');
                },
                success: function(msg){
                    
                    if(msg=='ok'){
                        location.reload();
                    }else{
                        $('#edit_simpan_tanggal_validasi'+a).show();
                        $('#tutup_edit_simpan_tanggal_validasi'+a).show();
                        $('#proses_loading_edit_simpan_tanggal_validasi'+a).html('');
                        $('#notifikasi_edit_simpan_tanggal_validasi'+a).html(msg);
                    }
                    
                    
                }
            });

    } 
</script>
@endpush
