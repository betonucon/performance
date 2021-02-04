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
                    
                        <div class="input-group ">
                            <!-- <form method="post" action="{{url('/deployment/import_data_mandatori')}}" enctype="multipart/form-data"> -->
                            <form method="post" id="mydataini" enctype="multipart/form-data">
                                @csrf
                                <div id="proses_upload_loading"></div>
                                <input type="file" name="file"  style="width: 40%;" class="form-control" >    
                                <span  id="upload" class="btn btn-primary btn-sm"   onclick="upload_data_unit()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-search"></i> Upload</span>
                                <span  class="btn btn-default btn-sm" onclick="reload()"  style="margin-left:5px;margin-top:2px" ><i class="fa fa-refresh"></i> Reload</span>
                            </form>
                        </div>
                        
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Level</th>
                                    <th>Unit Kerja</th>
                                    <th>KPI</th>
                                    <th>T Tahunan</th>
                                    <th>Tahun</th>
                                    <th>R Capaian</th>
                                    <th>R Akumulasi</th>
                                    <th>Update</th>
                                    <th width="7%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(deployment_mandatori($kode,$tahun) as $no=>$data)
                                    <tr>
                                        <td>{{$no+1}}</td>
                                        <td>{{cek_level($data->level)}}</td>
                                        <td><b>{{$data->kode_unit}}</b><br>{{cek_unit($data->kode_unit)['nama']}}</td>
                                        <td><b>{{$data->kode_kpi}}</b><br>{{cek_kpi($data['kode_kpi'],$data['tahun'])['kpi']}}</td>
                                        <td>{{$data->target_tahunan}}</td>
                                        <td>{{$data->tahun}}</td>
                                        <td>{{capaian($data->kode_kpi)}}</td>
                                        <td>{{akumulasi($data->kode_kpi)}}</td>
                                        <td>{{$data->updated_at}}</td>
                                        <td><a href="{{url('deployment/edit_mandatori/'.$data['id'])}}"><span class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></span></a></td>
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
                url: "{{url('/deployment/import_data_mandatori')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#file_upload').hide();
                    $('#upload').hide();
                    $('#proses_upload_loading').html('Proses Import Data ....................');
                },
                success: function(msg){
                    
                    if(msg=='ok'){
                        location.reload();
                    }else{
                        location.reload();
                    }
                   
                    
                    
                    
                }
            });

    }  
</script>
@endpush
