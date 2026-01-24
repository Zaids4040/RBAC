<div class="flex">
@if(count($currentusrpermissions) > 1)
<aside id="sidebar" class="sidebar bg-white min-w-64 min-h-screen shadow-lg hidden fixed md:static md:flex z-[50]">
    <nav class="p-4">
        <ul class="space-y-2">
            @foreach($currentusrpermissions as $panel)
            <li>
                <a wire:click="switchpanel('{{$panelnames[$panel][0]}}')" class="flex cursor-pointer items-center gap-3 px-4 py-3 rounded-lg @if($currentpanel == '{{$panelnames[$panel][0]}}') bg-purple-50 text-purple-700 @else hover:bg-gray-100 text-gray-700 @endif  font-semibold">
                    <i class='{{$panelnames[$panel][2]}}'></i>
                    <span>{{$panelnames[$panel][1]}}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </nav>
</aside>
@endif

<div wire:loading.flex class="w-full py-6 flex justify-center items-center z-[100]">
    <div class="animate-spin rounded-full h-12 w-12 border-4 border-purple-600 border-t-transparent"></div>
</div>

<!-- Main Content -->
<main class='flex-1 p-6' wire:loading.remove>
    @if($currentpanel == 'dashboard')
        @livewire('admin-dashboard.dashboard')
    @elseif($currentpanel == 'users')
        @livewire('users.user-panel')
    @elseif($currentpanel == 'roles')
        @livewire('roles.role-panel')
    @elseif($currentpanel == 'packagepanel')
        @livewire('packagepanel.package-panel')
    @elseif($currentpanel == 'usrdashboard')
       @livewire('user-dashboard.usr-dashboard')
    @elseif($currentpanel == 'leadspanel')
       @livewire('leads-panel.leads-panel')
    @elseif($currentpanel == 'attendence')
       @livewire('attendence-panel.attendence')
    @elseif($currentpanel == 'accounts')
       @livewire('accounts.accounts')
    @elseif($currentpanel == 'emailconfig')
        @livewire('emain-configure.email-configure')
    @endif
</main>
</div>

