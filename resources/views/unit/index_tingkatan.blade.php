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
                <div class="box-body" style="padding:10px">
                    
                        <div class="mailbox-controls" style="background:#f8f8fb;margin-bottom:10px;margin-top:5px;margin-bottom:20px">
                            <div class="input-group ">
                                <form method="post" id="mydataini" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="file" style="width: 40%;" class="form-control" >    
                                    <span  id="upload" class="btn btn-primary btn-sm"   onclick="upload_data_unit()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-search"></i> Upload</span>
                                    <span  class="btn btn-default btn-sm" onclick="reload()"  style="margin-left:5px;margin-top:2px" ><i class="fa fa-refresh"></i> Reload</span>
                                </form>
                             </div>
                            <div class="pull-right">
                            
                            </div>
                        </div>
                    
                        
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Unit Kerja</th>
                                    <th>Pimpinan</th>
                                    <th>Atasan Unit</th>
                                    <th>Pimpinan</th>
                                    <th width="7%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(unit_tingkatan() as $no=>$data)
                                    <tr>
                                        <td>{{$no+1}}</td>
                                        <td><b>{{$data->kode}}</b><br>{{$data->nama}}</td>
                                        <td><b>{{$data['nik_atasan']}}</b><br>{{cek_nik($data->nik_atasan)}}</td>
                                        <td><b>{{$data->kode_unit}}</b><br>{{cek_unit($data->kode_unit)['nama']}}</td>
                                        <td>{{cek_unit($data['kode_unit'])['nik_atasan']}}<br>{{cek_nik(cek_unit($data['kode_unit'])['nik_atasan'])}}</td>
                                        
                                        <td><a href="{{url('unit/edit/'.$data['id'])}}"><span class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></span></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                
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

    function upload_data_unit(){
        var form=document.getElementById('mydataini');
        
            $.ajax({
                type: 'POST',
                url: "{{url('/unit/import_data_unit')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#upload').hide();
                    $('#proses_loading').html('Proses Pembayaran ....................');
                },
                success: function(msg){
                    // alert(msg);
                    location.reload();
                    
                    
                }
            });

    }  
</script>
@endpush
