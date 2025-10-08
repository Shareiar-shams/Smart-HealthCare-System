<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        
        <p>
            System User
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('admin.permissions.index')}}" class="nav-link">
            
                <i class="far fa-circle nav-icon"></i>
                <p>Permission</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.roles.index')}}" class="nav-link">
            
                <i class="far fa-circle nav-icon"></i>
                <p>Role</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.users.roles')}}" class="nav-link">
            
                <i class="far fa-circle nav-icon"></i>
                <p>System User</p>
            </a>
        </li>
    </ul>
</li>