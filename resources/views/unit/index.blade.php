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
                                <!-- <input type="text" style="width: 40%;" class="form-control" id="datepicker">    
                                <span  class="btn btn-primary btn-sm"   onclick="cari()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-search"></i> Cari</span>
                                <span  class="btn btn-success btn-sm"   onclick="pdf()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-file-pdf-o"></i> PDF</span>
                                <span  class="btn btn-success btn-sm"   onclick="excel()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-file-excel-o"></i> Excel</span> -->
                                <span  class="btn btn-primary btn-sm" onclick="location.assign(`{{url('unit/edit/0')}}`)"  style="margin-left:5px;margin-top:2px" ><i class="fa fa-plus"></i> Tambah</span>
                                <span  class="btn btn-default btn-sm" onclick="reload()"  style="margin-left:5px;margin-top:2px" ><i class="fa fa-refresh"></i> Reload</span>
                             </div>
                            <div class="pull-right">
                            
                            </div>
                        </div>
                    
                        
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Pejabat</th>
                                    <th>Pimpinan</th>
                                    <th>PIC</th>
                                    <th width="7%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(unit() as $no=>$data)
                                    <tr>
                                        <td>{{$no+1}}</td>
                                        <td>{{$data->kode}}</td>
                                        <td>{{$data->nama}}</td>
                                        <td>{{pimpinan_unit($data->unit_id)}}</td>
                                        <td>{{$data->nik_atasan}}<br>{{cek_nik($data->nik_atasan)}}</td>
                                        <td>{{$data->nik}}<br>{{$data->nama_pic}}</td>
                                        
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
</script>
@endpush
