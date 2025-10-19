<div class="w-full flex flex-wrap gap-1.5 rounded-lg bg-primary/10">
    <a href="/admin/user-manager/user"
        class="w-20 md:w-24 {{ request()->routeIs('admin.user-manager.user') ? 'bg-gradient-to-tr from-secondary to-light' : 'bg-primary/10' }} rounded-lg py-1 flex items-center justify-center">User</a>
    <a href="/admin/user-manager/roles/page"
        class="w-20 md:w-24 {{ request()->routeIs('admin.user-manager.roles.page') ? 'bg-gradient-to-tr from-secondary to-light' : 'bg-primary/10' }} rounded-lg py-1 flex items-center justify-center">Roles</a>
    <a href="/admin/user-manager/permissions/page"
        class="w-20 md:w-24 {{ request()->routeIs('admin.user-manager.permissions.page') ? 'bg-gradient-to-tr from-secondary to-light' : 'bg-primary/10' }} rounded-lg py-1 flex items-center justify-center">Permission</a>
    <a href="/admin/user-manager"
        class="w-20 md:w-24 {{ request()->routeIs('admin.user-manager.index') ? 'bg-gradient-to-tr from-secondary to-light' : 'bg-primary/10' }} rounded-lg py-1 flex items-center justify-center">Manage</a>
</div>
