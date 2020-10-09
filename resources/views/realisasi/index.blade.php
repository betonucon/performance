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
                            <select id="kode" class="form-control" style="width: 30%;display: inline;">
                                <option value="">Pilih Unit</option>
                                @foreach(array_user() as $unit)
                                    <option value="{{$unit}}" @if($unit==$kode) selected @endif>{{cek_unit($unit)['nama']}}</option>
                                @endforeach
                            </select>
                            <select id="tahun" class="form-control" style="width: 10%;display: inline;">
                                @for($x=2019;$x<2030;$x++)
                                    <option value="{{$x}}" @if($x==$tahun) selected @endif>{{$x}}</option>
                                @endfor
                            </select>
                            <span  id="upload" class="btn btn-primary btn-sm"   onclick="cari()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-search"></i> Cari</span>
                            
                            <span  class="btn btn-default btn-sm" onclick="reload()"  style="margin-left:5px;margin-top:2px" ><i class="fa fa-refresh"></i> Reload</span>
                        </div>
                    
                        
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Unit Kerja</th>
                                    <th>KPI</th>
                                    <th>Target</th>
                                    <th>Akumulasi</th>
                                    <th>Tahun</th>
                                    <th>Status</th>
                                    <th width="7%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(deployment_realisasi($kode,$tahun) as $no=>$data)
                                    <tr>
                                        <td>{{$no+1}}</td>
                                        <td><b>{{$data->kode_unit}}</b><br>{{cek_unit($data->kode_unit)['nama']}}</td>
                                        <td><b>{{$data->kode_kpi}}</b><br>{{cek_kpi($data['kode_kpi'])['kpi']}}</td>
                                        <td>{{$data->target_tahunan}}</td>
                                        <td>{{akumulasi($data->kode_kpi)}}</td>
                                        <td>{{$data->tahun}}</td>
                                        <td>{!!icon_status_realisasi($data['status_realisasi'])!!}</td>
                                        <td><a href="{{url('realisasi/input/'.$data['id'])}}"><span class="btn btn-primary btn-sm"><i class="fa fa-gear"></i></span></a></td>
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

    function cari(){
        var kode=$('#kode').val();
        var tahun=$('#tahun').val();
        if(kode==''){
            alert('Pilih Unit Kerja');
        }else{
            window.location.assign("{{url('/realisasi')}}?kode="+kode+"&tahun="+tahun);
        }
        
    }
    function upload(){
        var form=document.getElementById('mydata');
        
            $.ajax({
                type: 'POST',
                url: "{{url('/deployment/import_data')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#upload').hide();
                    $('#proses_loading').html('Proses Pembayaran ....................');
                },
                success: function(msg){
                    
                    // if(msg=='ok'){
                    //     window.location.assign("{{url('/unit/')}}");
                    // }else{
                    //     $('#upload').show();
                    //     $('#proses_loading').html('');
                    //     $('#modalnotifikasi').modal('show');
                    //     $('#notifikasi').html(msg);
                    // }
                    alert(msg);
                    
                    
                }
            });

    }  
</script>
@endpush
