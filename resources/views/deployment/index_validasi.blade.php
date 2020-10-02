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
            font-size: 0.8vw;
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
                            <div class="input-group " style="width: 30%;">
                                
                                    <select id="tahun" style="width: 70%;display:inline" class="form-control" >  
                                        @for($th=2019;$th<2040;$th++) 
                                            <option value="{{$th}}" @if($th==$tahun) selected @endif>{{$th}}</option>
                                        @endfor 
                                    </select>
                                    <span   class="btn btn-primary btn-sm"   onclick="cari()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-search"></i> Cari</span>
                                   
                                
                            </div>
                            <div class="pull-right">
                            
                            </div>
                        </div>
                    
                        
                        <table id="tabeldata" class="table table-bordered table-striped">
                            
                            
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
                    $('#upload').hide();
                    $('#proses_loading').html('Proses Pembayaran ....................');
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
                
                   


                var table = $('#tabeldata').DataTable({
                    responsive: true,
                    scrollY: "450px",
                    scrollCollapse: true,
                    ordering   : false,
                    paging   : false,
                    info   : false,
                    oLanguage: {"sSearch": "<span class='btn btn-default btn sm'><i class='fa fa-search'></i></span>" },
                    "ajax": {
                        "type": "GET",
                        "url": "{{url('/validasi/api/'.$tahun)}}",
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
                    "order": [[ 4, "asc" ]],
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
                            "title": "Unit Kerja",
                            "render": function (data, row, type, meta) {
                                return '['+data.kode_unit+']'+data.name_unit;
                            }
                        },
                        {
                            "mData": null,
                            "title": "Tahun",
                            "render": function (data, row, type, meta) {
                                return data.tahun;
                            }
                        },
                        {
                            "mData": null,
                            "title": "Jan",
                            "width":"4%",
                            "render": function (data, row, type, meta) {
                                return data.Jan;
                            }
                        },
                        {
                            "mData": null,
                            "title": "Feb",
                            "width":"4%",
                            "render": function (data, row, type, meta) {
                                return data.Feb;
                            }
                        },
                        {
                            "mData": null,
                            "title": "Mar",
                            "width":"4%",
                            "render": function (data, row, type, meta) {
                                return data.Mar;
                            }
                        },
                        {
                            "mData": null,
                            "title": "Apr",
                            "width":"4%",
                            "render": function (data, row, type, meta) {
                                return data.Apr;
                            }
                        },
                        {
                            "mData": null,
                            "title": "Mei",
                            "width":"4%",
                            "render": function (data, row, type, meta) {
                                return data.Mei;
                            }
                        },
                        {
                            "mData": null,
                            "title": "Jun",
                            "width":"4%",
                            "render": function (data, row, type, meta) {
                                return data.Jun;
                            }
                        },
                        {
                            "mData": null,
                            "title": "Jul",
                            "width":"4%",
                            "render": function (data, row, type, meta) {
                                return data.Jul;
                            }
                        },
                        {
                            "mData": null,
                            "title": "Ags",
                            "width":"4%",
                            "render": function (data, row, type, meta) {
                                return data.Ags;
                            }
                        },
                        {
                            "mData": null,
                            "title": "Sep",
                            "width":"4%",
                            "render": function (data, row, type, meta) {
                                return data.Sep;
                            }
                        },
                        {
                            "mData": null,
                            "title": "Okt",
                            "width":"4%",
                            "render": function (data, row, type, meta) {
                                return data.Okt;
                            }
                        },
                        {
                            "mData": null,
                            "title": "Nov",
                            "width":"4%",
                            "render": function (data, row, type, meta) {
                                return data.Nov;
                            }
                        },
                        {
                            "mData": null,
                            "title": "Des",
                            "width":"4%",
                            "render": function (data, row, type, meta) {
                                return data.Des;
                            }
                        },
                        {
                            "mData": null,
                            "title": "",
                            "width":"3%",
                            "sortable": false,
                            "render": function (data, row, type, meta) {
                                let btn = '';

                                
                                        btn += '<span class="btn btn-success btn-xs" onclick="ubah('+data.kode_unit+','+data.tahun+')"><i class="fa fa-pencil"></i></span>';
                                    

                                return btn;
                            }
                        }
                    ]
                });
    });

    function cari(){
        var tahun=$('#tahun').val();
        window.location.assign("{{url('validasi')}}?tahun="+tahun);
    }
    function ubah(kode,tahun){
        window.location.assign("{{url('validasi/ubah')}}?kode="+kode+"&tahun="+tahun);
    }
</script>
@endpush
