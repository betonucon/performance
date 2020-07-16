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
                            <h4>Traffic E-performance {{bul($bulan)}} {{$tahun}}</h4>
                        </div>
                        <div id="donut-chart" style="height: 300px;background:#f3f3e0;margin: 2%;"></div>
                        

                        
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Unit Kerja {{persen($tahun,$bulan)}}</th>
                                    @for($x=1;$x<13;$x++)
                                        <?php
                                            if($x>9){$bul=$x;}else{$bul='0'.$x;}
                                        ?>
                                        <th width="5%">{{substr(bulan($bul),0,3)}}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @for($x=1;$x<13;$x++) 
                                    <?php
                                        $total[$x]=0;
                                    ?>
                                @endfor
                                @foreach(unit() as $no=>$data)
                                    @for($x=1;$x<13;$x++)   
                                        <?php
                                        $total[$x]+=array_kode($data['kode'],$tahun,$x);
                                        ?>
                                    @endfor
                                    <tr>
                                        <td>{{$no+1}}</td>
                                        <td>{{$data['nama']}}</td>
                                        @for($x=1;$x<13;$x++)
                                        <td>@if(array_kode($data['kode'],$tahun,$x)==1)<i class="fa fa-check"></i> @endif</td>
                                        @endfor
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2">Total {{round($total[$bulan]*(100/jumlah_unit()))}}</td>
                                    @for($x=1;$x<13;$x++)
                                    <td>{{round($total[$x]*(100/jumlah_unit()))}}%</td>
                                    @endfor
                                </tr>
                            </tbody>
                            
                        </table>
                
                </div>
            </div>
       </div>
    </div>
</section>



@endsection


<script>
    function cari(){
        var bulan=$('#bulan').val();
        var tahun=$('#tahun').val();
        
         window.location.assign("{{url('/home')}}?bulan="+bulan+"&tahun="+tahun);
        
    }


</script>


