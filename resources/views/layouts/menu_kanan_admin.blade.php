<ul class="nav navbar-nav">
   
    
    <li class="messages-menu" title="Panduan Performance Management System">
        <a href="{{url('icon/Panduan Performance Management System Reborn 22.07.2020 PDF.pdf')}}" target="_blank">
        <i class="fa fa-book"></i>
        </a>
    </li>
    <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{url('/icon/akun.png')}}" class="user-image" alt="User Image">
            <span class="hidden-xs">{{cek_role(Auth::user()['role_id'])}}@ {{Auth::user()['name']}}</span>
        </a>
        <ul class="dropdown-menu">
            <li class="user-header">
            <img src="{{url('/icon/akun.png')}}" class="img-circle" alt="User Image">

            <p>
                {{Auth::user()['nik']}} @ {{cek_role(Auth::user()['role_id'])}}
                <small>{{Auth::user()['name']}}</small>
            </p>
            </li>
            <!-- Menu Body -->
            <li class="user-body">
           
            <!-- /.row -->
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
            <div class="pull-left">
                
            </div>
            <div class="pull-left">
                @if(Auth::user()['role_id']==1)
                  <input type="submit" onclick="pengaturan()" class="btn btn-default btn-flat" value="Pengaturan">
                @endif
            </div>
            <div class="pull-right">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <input type="submit" class="btn btn-default btn-flat" value="Sign out">
                    </form>
            </div>
            </li>
        </ul>
    </li>
    <!-- Control Sidebar Toggle Button -->
    <li>
    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
    </li>
</ul>