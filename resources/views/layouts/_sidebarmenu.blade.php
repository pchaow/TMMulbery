<ul class="sidebar-menu">
    <li class="header">HEADER</li>
    <!-- Optionally, you can add icons to the links -->
    <li class="{{ Request::is('home') ? 'active' : '' }}"><a href="/home"><i class="fa fa-link"></i> <span>Dashboard</span></a>
    </li>


    <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
    <li class="treeview">
        <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <li><a href="#">Link in level 2</a></li>
            <li><a href="#">Link in level 2</a></li>
        </ul>
    </li>

    <li class="treeview {{ Request::is('admin/*') ? 'active' : '' }}">
        <a href="#"><i class="fa fa-link"></i> <span>Administrator</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu ">
            <li class="{{ Request::is('admin/users') ? 'active' : '' }}">
                <a href="/admin/users">
                    <i class="fa fa-user"></i>
                    User Management
                </a>
            </li>
            <li class="{{ Request::is('admin/roles') ? 'active' : '' }}">
                <a href="/admin/roles">
                    <i class="fa fa-sign-in"></i>Role Management
                </a>
            </li>

            <li class="{{ Request::is('admin/plants') ? 'active' : '' }}">
                <a href="/admin/plants">
                    <i class="fa fa-pencil"></i>Plant Management
                </a>
            </li>
        </ul>
    </li>
</ul>