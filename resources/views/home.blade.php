@extends('layouts.app_admin2')
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
                            <div class="input-group " style="width: 40%;">
                                <select id="tahun" class="form-control" style="width: 40%;display: inline;">
                                    @for($x=2019;$x<2030;$x++)
                                        <option value="{{$x}}" @if($x==$tahun) selected @endif>{{$x}}</option>
                                    @endfor
                                </select>
                                <select id="bulan" class="form-control" style="width: 40%;display: inline;">
                                    @for($x=1;$x<13;$x++)
                                        <?php
                                            if($x>9){$bul=$x;}else{$bul='0'.$x;}
                                        ?>
                                        <option value="{{$x}}" @if($x==$bulan) selected @endif>{{bulan($bul)}}</option>
                                    @endfor
                                </select>
                                <span   class="btn btn-primary btn-sm"   onclick="cari()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-search"></i> Cari</span>
                             </div>
                            
                        </div>
                        
                        <div class="callout callout-info">
                            <h4>Traffic E-performance {{bul($bulan)}} {{$tahun}} </h4>
                        </div>
                        <div id="donut-chart" style="height: 300px;background:#f3f3e0;margin: 2%;"></div>
                        

                        
                        <table id="example1" style="width:100%" class="table table-bordered table-striped">
                            
                        </table>
                        <table id="datatotal" style="width:100%" class="table table-bordered table-striped">
                            
                        </table>
                
                </div>
            </div>
       </div>
    </div>
</section>
<div class="modal modal-dfeault fade" id="modalpengumuman">
    <div class="modal-dialog " style="width:90%">
        <div class="modal-content" style="margin-top:-10px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Tutup</button>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="{{url('icon/edaran2022.pdf')}}" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
                
            
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


@endsection

@push('simpan')
<script>
    function cari(){
        var bulan=$('#bulan').val();
        var tahun=$('#tahun').val();
        
         window.location.assign("{{url('/home')}}?bulan="+bulan+"&tahun="+tahun);
        
    }

    $(document).ready(function() {
        $('#modalpengumuman').modal('show');
           
            var table = $('#example1').DataTable({
                responsive: true,
                scrollX: true,
                searching   : false,
                ordering   : false,
                paging   : false,
                info   : false,
                 "ajax": {
                    "type": "GET",
                    "url": "{{url('unit/api/'.$tahun)}}",
                    "timeout": 120000,
                    "dataSrc": function (json) {
                        if(json != null){
                            return json
                        } else {
                            return "No Data";
                        }
                    }
                },
                "sAjaxDataProp": "",
                "width": "100%",
                "order": [[ 0, "asc" ]],
                "aoColumns": [
                    {
                        "mData": null,
                        "width":"5%",
                        "title": "No",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        "mData": null,
                        "width":"30%",
                        "title": "Nama Unit",
                        "render": function (data, row, type, meta) {
                            return data.name;
                        }
                    },
                    {
                        "mData": null,
                        "title": "Jan",
                        "render": function (data, row, type, meta) {
                            var act='';
                                if(data.jan>0){
                                    act+='<i class="fa fa-check"></i>';
                                }else{
                                    act+='';
                                }
                            return act;
                        }
                    },
                    {
                        "mData": null,
                        "title": "Feb",
                        "render": function (data, row, type, meta) {
                            var act='';
                                if(data.feb>0){
                                    act+='<i class="fa fa-check"></i>';
                                }else{
                                    act+='';
                                }
                            return act;
                        }
                    },
                    {
                        "mData": null,
                        "title": "Mar",
                        "render": function (data, row, type, meta) {
                            var act='';
                                if(data.mar>0){
                                    act+='<i class="fa fa-check"></i>';
                                }else{
                                    act+='';
                                }
                            return act;
                        }
                    },
                    {
                        "mData": null,
                        "title": "Apr",
                        "render": function (data, row, type, meta) {
                            var act='';
                                if(data.apr>0){
                                    act+='<i class="fa fa-check"></i>';
                                }else{
                                    act+='';
                                }
                            return act;
                        }
                    },
                    {
                        "mData": null,
                        "title": "Mei",
                        "render": function (data, row, type, meta) {
                            var act='';
                                if(data.mei>0){
                                    act+='<i class="fa fa-check"></i>';
                                }else{
                                    act+='';
                                }
                            return act;
                        }
                    },
                    {
                        "mData": null,
                        "title": "Jun",
                        "render": function (data, row, type, meta) {
                            var act='';
                                if(data.jun>0){
                                    act+='<i class="fa fa-check"></i>';
                                }else{
                                    act+='';
                                }
                            return act;
                        }
                    },
                    {
                        "mData": null,
                        "title": "Jul",
                        "render": function (data, row, type, meta) {
                            var act='';
                                if(data.jul>0){
                                    act+='<i class="fa fa-check"></i>';
                                }else{
                                    act+='';
                                }
                            return act;
                        }
                    },
                    {
                        "mData": null,
                        "title": "Ags",
                        "render": function (data, row, type, meta) {
                            var act='';
                                if(data.agus>0){
                                    act+='<i class="fa fa-check"></i>';
                                }else{
                                    act+='';
                                }
                            return act;
                        }
                    },
                    {
                        "mData": null,
                        "title": "Sep",
                        "render": function (data, row, type, meta) {
                            var act='';
                                if(data.sept>0){
                                    act+='<i class="fa fa-check"></i>';
                                }else{
                                    act+='';
                                }
                            return act;
                        }
                    },
                    {
                        "mData": null,
                        "title": "Okt",
                        "render": function (data, row, type, meta) {
                            var act='';
                                if(data.okt>0){
                                    act+='<i class="fa fa-check"></i>';
                                }else{
                                    act+='';
                                }
                            return act;
                        }
                    },
                    {
                        "mData": null,
                        "title": "Nov",
                        "render": function (data, row, type, meta) {
                            var act='';
                                if(data.nov>0){
                                    act+='<i class="fa fa-check"></i>';
                                }else{
                                    act+='';
                                }
                            return act;
                        }
                    },
                    {
                        "mData": null,
                        "title": "Des",
                        "render": function (data, row, type, meta) {
                            var act='';
                                if(data.des>0){
                                    act+='<i class="fa fa-check"></i>';
                                }else{
                                    act+='';
                                }
                            return act;
                        }
                    }
                    
                ]
            });

            var table = $('#datatotal').DataTable({
                responsive: true,
                scrollX: true,
                searching   : false,
                ordering   : false,
                paging   : false,
                info   : false,
                 "ajax": {
                    "type": "GET",
                    "url": "{{url('unit/api/foot/'.$tahun)}}",
                    "timeout": 120000,
                    "dataSrc": function (json) {
                        if(json != null){
                            return json
                        } else {
                            return "No Data";
                        }
                    }
                },
                "sAjaxDataProp": "",
                "width": "100%",
                "order": [[ 0, "asc" ]],
                "aoColumns": [
                   {
                        "mData": null,
                        "width":"35.1%",
                        "title": "Total",
                        "render": function (data, row, type, meta) {
                            return data.total;
                        }
                    },
                    {
                        "mData": null,
                        "title": "Jan",
                        "render": function (data, row, type, meta) {
                            
                            return data.jan;
                        }
                    },
                    {
                        "mData": null,
                        "title": "feb",
                        "render": function (data, row, type, meta) {
                            
                            return data.feb;
                        }
                    },
                    {
                        "mData": null,
                        "title": "mar",
                        "render": function (data, row, type, meta) {
                            
                            return data.mar;
                        }
                    },
                    {
                        "mData": null,
                        "title": "apr",
                        "render": function (data, row, type, meta) {
                            
                            return data.apr;
                        }
                    },
                    {
                        "mData": null,
                        "title": "mei",
                        "render": function (data, row, type, meta) {
                            
                            return data.mei;
                        }
                    },
                    {
                        "mData": null,
                        "title": "jun",
                        "render": function (data, row, type, meta) {
                            
                            return data.jun;
                        }
                    },
                    {
                        "mData": null,
                        "title": "jul",
                        "render": function (data, row, type, meta) {
                            
                            return data.jul;
                        }
                    },
                    {
                        "mData": null,
                        "title": "ags",
                        "render": function (data, row, type, meta) {
                            
                            return data.ags;
                        }
                    },
                    {
                        "mData": null,
                        "title": "sep",
                        "render": function (data, row, type, meta) {
                            
                            return data.sep;
                        }
                    },
                    {
                        "mData": null,
                        "title": "okt",
                        "render": function (data, row, type, meta) {
                            
                            return data.okt;
                        }
                    },
                    {
                        "mData": null,
                        "title": "nov",
                        "render": function (data, row, type, meta) {
                            
                            return data.nov;
                        }
                    },
                    {
                        "mData": null,
                        "title": "des",
                        "render": function (data, row, type, meta) {
                            
                            return data.des;
                        }
                    },
                    
                    
                ]
            });

    });
    
    $(window).load(function()
    {
        // $('#modalpengumuman').modal('show');
    })
</script>
@endpush


