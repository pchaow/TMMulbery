<ul class="sidebar-menu">
    <!-- Optionally, you can add icons to the links -->

    @if(\Laratrust::hasRole('administrator'))
        <li class="{{ Request::is('home') ? 'active' : '' }}"><a href="/home"><i class="fa fa-tachometer "></i>
                <span>หน้าหลัก</span></a></li>

        <li class="treeview active">
            <a href="#"><i class="fa fa-link"></i> <span>ผู้ดูแลระบบ</span>
                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
            </a>
            <ul class="treeview-menu ">
                <li class="{{ Request::is('admin/users') ? 'active' : '' }}">
                    <a href="/admin/users">
                        <i class="fa fa-user"></i>
                        จัดการผู้ใช้งาน
                    </a>
                </li>

            <!--    <li class="{{ Request::is('admin/plant_transaction_status') ? 'active' : '' }}">
                    <a href="/admin/plant_transaction_status">
                        <i class="fa fa-check-square-o "></i>
                        จัดการสถานะการปลูก
                    </a>
                </li> -->

                <li class="{{ Request::is('admin/roles') ? 'active' : '' }}">
                    <a href="/admin/roles">
                        <i class="fa fa-sign-in"></i>จัดการสิทธิการใช้งาน
                    </a>
                </li>

            <!--     <li class="{{ Request::is('admin/farmers') ? 'active' : '' }}"><a href="/admin/farmers"><i
                                class="fa fa-users"></i><span>จัดการเกษตรกร</span></a></li>

                <li class="{{ Request::is('admin/buyers') ? 'active' : '' }}"><a href="/admin/buyers"><i
                                class="fa fa-user-circle-o "></i><span>จัดการผู้รับซื้อ</span></a></li> -->


                <li class="{{ Request::is('admin/plants') ? 'active' : '' }}">
                    <a href="/admin/plants">
                        <i class="fa fa-tree"></i>จัดการแปลงหม่อน
                    </a>
                </li>
            </ul>
        </li>
    @endif

    @if(\Laratrust::hasRole('buyer'))
        <li class="{{ Request::is('buyer') ? 'active' : '' }}"><a href="{{url("buyer")}}"><i class="fa fa-money "></i>
                <span>สถานะคำสั่งซื้อ</span></a></li>
        <li class="{{ Request::is('buyer/plan') ? 'active' : '' }}"><a href="{{url("buyer/plan")}}"><i class="fa fa-calendar "></i>
                <span>แผนการปลูก</span></a></li>
        <li class="{{ Request::is('buyer/plant') || Request::is('buyer/plant/*') ? 'active' : '' }}"><a href="{{url("buyer/plant")}}"><i class="fa fa-tree "></i>
                <span>แปลง</span></a></li>
        <li class="{{ Request::is('buyer/farmer') || Request::is('buyer/farmer/*') ? 'active' : '' }}"><a href="{{url("buyer/farmer")}}"><i class="fa fa-users "></i>
                <span>เกษตรกร</span></a></li>
    @endif

    @if(\Laratrust::hasRole('farmer'))
    @endif
</ul>