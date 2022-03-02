@extends('layouts.app_admin')
<?php error_reporting(0); ?>

@section('content')
<style>
@media only screen and (min-width: 650px) {
        th{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 0.86vw;
            font-family: sans-serif;
        }
        td{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 0.86vw;
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
                <div class="box-body" style="padding:10px">
                        <div class="mailbox-controls" style="background:#f8f8fb;margin-bottom:10px;margin-top:5px;margin-bottom:20px">
                            <div class="input-group ">
                                <form method="post" id="mydata" action="{{url('/bobot/import_data_bobot')}}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="file" style="width: 40%;" class="form-control" >    
                                    <span  id="upload" class="btn btn-primary btn-sm"   onclick="upload()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-search"></i> Upload</span>
                                    <span  class="btn btn-default btn-sm" onclick="reload()"  style="margin-left:5px;margin-top:2px" ><i class="fa fa-refresh"></i> Reload</span>
                                    <!-- <input type="submit"> -->

                                </form>
                            </div>
                            <div class="pull-right">
                            
                            </div>
                        </div>
                        <select id="tahun" onchange="cari_tahun(this.value)" class="form-control" style="width: 10%;display: inline;">
                            @for($thn=2020;$thn<2030;$thn++)
                                <option value="{{$thn}}" @if($thn==$tahun) selected @endif>{{$thn}}</option>
                            @endfor
                        </select>
                        <select id="kode" onchange="cari_unit(this.value)" class="form-control" style="width: 30%;display: inline;">
                            <option value="">Pilih Unit</option>
                            @foreach(array_user() as $unit)
                                <option value="{{$unit}}" @if($unit==$kode) selected @endif>{{cek_unit($unit)['nama']}}</option>
                            @endforeach
                        </select>
                        <hr>
                        <div id="tabeldata" >
                            
                            
                        </div>
                
                </div>
            </div>
       </div>
    </div>
</section>

<div class="modal fade" id="modalloadinggg" >
    <div class="modal-dialog">
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <button type="button" class="close" >
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Loading ........ </h4>
            </div>
            <div class="modal-body" style="text-align:center">
                <img src="{{url('icon/loading.gif')}}" width="50%">
            </div>
            <div class="modal-footer">
               
            </div>
        </div>
    </div>
</div>

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

    function upload(){
        var form=document.getElementById('mydata');
        
            $.ajax({
                type: 'POST',
                url: "{{url('/bobot/import_data_bobot')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#modalloadinggg').modal({backdrop: 'static', keyboard: false});
                },
                success: function(msg){
                    
                    // if(msg=='ok'){
                        location.reload();
                    // }else{
                    //     $('#upload').show();
                    //     $('#proses_loading').html('');
                    //     $('#modalnotifikasi').modal('show');
                    //     $('#notifikasi').html(msg);
                    // }
                    
                    
                }
            });

    }  

    $(document).ready(function() {
       var tahun=$('#tahun').val();   
        $.ajax({
               type: 'GET',
               url: "{{url('bobot/view_api_bobot')}}",
               data: "tahun="+tahun,
               beforeSend: function(){
                    $("#tabeldata").html('<center>Proses Data.............</center>');
               },
               success: function(msg){
                    $("#tabeldata").html(msg);
                  
               }
           });
    });

    function hapus_bobot(kpi,kode,tahun){
        $.ajax({
               type: 'GET',
               url: "{{url('bobot/hapus_bobot')}}",
               data: "tahun="+tahun+"&kode="+kode+"&kpi="+kpi,
               success: function(msg){
                   
                   var det=msg.split('@');
                    $.ajax({
                        type: 'GET',
                        url: "{{url('bobot/view_api_bobot')}}",
                        data: "tahun="+det[0]+"&kode="+det[1],
                        success: function(msg){
                                $("#tabeldata").html(msg);
                            
                        }
                    });
                  
               }
        });
    }
    function cari_unit(a){
        var tahun=$('#tahun').val();   
        $.ajax({
               type: 'GET',
               url: "{{url('bobot/view_api_bobot')}}",
               data: "tahun="+tahun+"&kode="+a,
               beforeSend: function(){
                    $("#tabeldata").html('<center>Proses Data.............</center>');
               },
               success: function(msg){
                    $("#tabeldata").html(msg);
                  
               }
        });
    }
</script>
@endpush
