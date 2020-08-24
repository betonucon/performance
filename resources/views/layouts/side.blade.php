<ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU</li>
        <li>
          <a href="{{url('/home')}}" style="font-weight: 500;">
            <i class="fa fa-home"></i> <span>Dashboard</span>
          </a>
        </li>
        
        @if(Auth::user()['role_id']==1)
        
          <li class="treeview">
              <a href="#" style="background:#f9fafc;font-weight: 500;">
                <i class="fa fa-folder"></i>
                <span>Unit Kerja</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="background:#f3f6fb">
                <li><a href="{{url('/unit/')}}"><i class="fa fa-check"></i> Unit Kerja</a></li>
             
                <li><a href="{{url('/unit/index_tingkatan')}}"><i class="fa fa-check"></i>Tingkatan Unit Kerja</a></li>
              </ul>
          </li>
          <li class="treeview">
              <a href="#" style="background:#f9fafc;font-weight: 500;">
                <i class="fa fa-folder"></i>
                <span>KPI</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="background:#f3f6fb">
                <li><a href="{{url('/kpi')}}"><i class="fa fa-check"></i> Kpi</a></li>
              </ul>
          </li>
          <li class="treeview">
              <a href="#" style="background:#f9fafc;font-weight: 500;">
                <i class="fa fa-folder"></i>
                <span>Deployment</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="background:#f3f6fb">
                
                <li><a href="{{url('/deployment')}}"><i class="fa fa-check"></i> Deployment All</a></li>
                <li><a href="{{url('/deployment/mandatori')}}"><i class="fa fa-check"></i> Deployment Mandatori</a></li>
                <li><a href="{{url('/deployment/non')}}"><i class="fa fa-check"></i> Deployment Non Mandatori</a></li>
              </ul>
          </li>

          <li class="treeview">
            <a href="#" style="background:#f9fafc;font-weight: 500;">
              <i class="fa fa-folder"></i>
              <span>Target</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="background:#f3f6fb">
              <li><a href="{{url('/target/')}}"><i class="fa fa-check"></i> Target</a></li>
              <li><a href="{{url('/target/mandatori')}}"><i class="fa fa-check"></i> Target Mandatori</a></li>
            </ul>
          </li>

          <li class="treeview">
              <a href="#" style="background:#f9fafc;font-weight: 500;">
                <i class="fa fa-folder"></i>
                <span>Realisasi</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="background:#f3f6fb;color:#000;font-size:1vw">
                <li><a href="{{url('/realisasi/')}}"><i class="fa fa-check"></i> Realisasi</a></li>
                <li><a href="{{url('/realisasi/mandatori')}}"><i class="fa fa-check"></i> Realisasi Mandatori</a></li>
              </ul>
          </li>
          <li class="treeview">
              <a href="#" style="background:#f9fafc;font-weight: 500;">
                <i class="fa fa-folder"></i>
                <span>Capaian</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="background:#f3f6fb;color:#000;font-size:1vw">
                <li><a href="{{url('/laporan/')}}"><i class="fa fa-check"></i> Capaian</a></li>
                <li><a href="{{url('/laporan/subdit')}}"><i class="fa fa-check"></i> Capaian Persubdit</a></li>
                
              </ul>
          </li>
        @endif   

        @if(Auth::user()['role_id']==3)
          

          <li class="treeview">
            <a href="#" style="background:#f9fafc;font-weight: 500;">
              <i class="fa fa-folder"></i>
              <span>Validasi Target</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="background:#f3f6fb">
              <li><a href="{{url('/target/')}}"><i class="fa fa-check"></i> Target</a></li>
            </ul>
          </li>

          <li class="treeview">
              <a href="#" style="background:#f9fafc;font-weight: 500;">
                <i class="fa fa-folder"></i>
                <span>Validasi Realisasi</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="background:#f3f6fb;color:#000;font-size:1vw">
                <li><a href="{{url('/realisasi/')}}"><i class="fa fa-check"></i> Realisasi</a></li>
              </ul>
          </li>
          <li class="treeview">
              <a href="#" style="background:#f9fafc;font-weight: 500;">
                <i class="fa fa-folder"></i>
                <span>Capaian</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="background:#f3f6fb;color:#000;font-size:1vw">
                <li><a href="{{url('/laporan/')}}"><i class="fa fa-check"></i> Capaian</a></li>
                
              </ul>
          </li>
          @if(cek_direktorat()>0)
              <li class="treeview">
                  <a href="#" style="background:#f9fafc;font-weight: 500;">
                    <i class="fa fa-folder"></i>
                    <span>Capaian Direktorat</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="background:#f3f6fb;color:#000;font-size:1vw">
                    @foreach(unit_direktorat() as $direk)
                      <li><a href="{{url('/laporan/bertingkat/'.$direk['kode'])}}"><i class="fa fa-check"></i> {{substr(cek_unit($direk['kode'])['nama'],0,23)}}</a></li>
                    @endforeach
                    
                    
                  </ul>
              </li>
              <li class="treeview">
                  <a href="#" style="background:#f9fafc;font-weight: 500;">
                    <i class="fa fa-folder"></i>
                    <span>Capaian Subdit</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="background:#f3f6fb;color:#000;font-size:1vw">
                    @foreach(array_subdit() as $sub)
                      <li><a href="{{url('/laporan/bertingkat/'.$sub['kode'])}}"><i class="fa fa-check"></i> {{substr(cek_unit($sub['kode'])['nama'],0,23)}}</a></li>
                    @endforeach
                    
                    
                  </ul>
              </li>
          @endif

          @if(cek_subdit()>0 && cek_direktorat()==0)
              
              <li class="treeview">
                  <a href="#" style="background:#f9fafc;font-weight: 500;">
                    <i class="fa fa-folder"></i>
                    <span>Capaian Subdit</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="background:#f3f6fb;color:#000;font-size:1vw">
                    @foreach(array_subdit() as $sub)
                      <li><a href="{{url('/laporan/bertingkat/'.$sub['kode'])}}"><i class="fa fa-check"></i> {{substr(cek_unit($sub['kode'])['nama'],0,23)}}</a></li>
                    @endforeach
                    
                    
                  </ul>
              </li>
          @endif
        @endif   

        @if(Auth::user()['role_id']==2)
          

          <li class="treeview">
            <a href="#" style="background:#f9fafc;font-weight: 500;">
              <i class="fa fa-folder"></i>
              <span>Target</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="background:#f3f6fb">
              <li><a href="{{url('/target/')}}"><i class="fa fa-check"></i> Target</a></li>
            </ul>
          </li>

          <li class="treeview">
              <a href="#" style="background:#f9fafc;font-weight: 500;">
                <i class="fa fa-folder"></i>
                <span>Realisasi</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="background:#f3f6fb;color:#000;font-size:1vw">
                <li><a href="{{url('/realisasi/')}}"><i class="fa fa-check"></i> Realisasi</a></li>
              </ul>
          </li>
          <li class="treeview">
              <a href="#" style="background:#f9fafc;font-weight: 500;">
                <i class="fa fa-folder"></i>
                <span>Capaian</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="background:#f3f6fb;color:#000;font-size:1vw">
                <li><a href="{{url('/laporan/')}}"><i class="fa fa-check"></i>Capaian</a></li>
                
                
                
               
              </ul>
          </li>
        @endif    
       

       
        <!-- <li>
          <a href="{{url('/admin/news/')}}">
            <i class="fa fa-th"></i> <span>Rekapitulasi</span>
          </a>
        </li> -->
        <?php
          $kodebar=Auth::user()['nik'].'-'.Auth::user()['name'];
        ?>
        <li class="header" style="background: #ffffff;padding: 10%;"><center>{!!barcoderider($kodebar,4,4)!!} <br>{{Auth::user()['nik']}}<br>{{Auth::user()['name']}}</center></li>
      </ul>