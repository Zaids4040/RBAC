<div>
    <div id="rolesSection" class="section">
        <div class="flex justify-between items-center mb-6 flex-col md:flex-row gap-2 md:gap-0">
            <h2 class="text-2xl font-bold text-gray-800">Roles Management</h2>
            @if(in_array('create', $currentusrpermissions))
            <button wire:click='openrolemodal()' class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm md:text-md min-w-[15%] px-6 py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg">
                <i wire:loading.remove wire:target="openrolemodal()" class="fas fa-user-tag mr-2"></i><span wire:loading.remove wire:target="openrolemodal()">Add New Role</span>
                <span wire:loading.flex wire:target="openrolemodal()" class='justify-center'>
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </span>
            </button>
            @endif
        </div>
        @if(in_array('view',$currentusrpermissions))
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Users</th>
                                    @if(in_array('edit',$currentusrpermissions) || in_array('delete',$currentusrpermissions))
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($roles_rows as $row)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-medium text-gray-900">{{$row->name}}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{$row->description}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="font-semibold">{{$row->users_count}}</span>
                                        </td>
                                        @if(in_array('edit',$currentusrpermissions) || in_array('delete',$currentusrpermissions))
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(in_array('edit',$currentusrpermissions))
                                            <button wire:click='editrole({{$row->id}})' wire:loading.attr='disabled' wire:target='editrole' class="text-purple-600 hover:text-purple-800 mr-3">
                                                <i class="fas fa-edit" wire:loading.remove wire:target='editrole'></i>
                                                <span wire:loading.flex wire:target="editrole" class='justify-center'>
                                                    <svg class="animate-spin h-5 w-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                                    </svg>
                                                </span>
                                            </button>
                                            @endif
                                            @if(in_array('delete',$currentusrpermissions))
                                            <button  wire:click='deleterole({{$row->id}})' class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div>
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Role Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-gray-700">Total Roles</span>
                            <span class="font-bold">{{$roles_count}}</span>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>


    <!--Role Modal-->
    <div id="addRoleModal" class="fixed bg-[rgba(0,0,0,0.5)] z-1000 left-0 top-0 w-full h-[100%] @if(!$rolemodal) hidden  @else flex justify-center items-center   @endif">
        <div class="bg-white p-0 rounded-[15px] max-w-[900px] w-[90%] max-h-[90vh] animate-slide-up overflow-y-auto">
            <div class="gradient-bg text-white p-6 rounded-t-xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">Add New Role</h2>
                    <button wire:click='closerolemodal' class="text-white hover:text-gray-200">
                        <i wire:loading.remove wire:target='closerolemodal()' class="fas fa-times text-2xl"></i>
                        <span wire:loading.flex wire:target="closerolemodal()" class='justify-center'>
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
            <form wire:submit.prevent="saverole" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Role Name *</label>
                        <input type="text" wire:model="name" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="e.g., Sales Manager">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Description</label>
                        <input type="text" wire:model="description"
 class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Brief description of the role">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Level</label>
                        <input type="number" wire:model="level"
 class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Enter the level of this role">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-4">Role Permissions</label>
                    <div class="role-permission-section">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($permissions as $module => $actions)
                                <div class="permission-group">
                                    <h4 class="font-semibold mb-3 text-gray-800">{{ $module }}</h4>
                                    @foreach($actions as $action)
                                        <div class="permission-checkbox">
                                            <input type="checkbox" wire:model="selectedPermissions" id="perm_{{ $module }}_{{ $action[0] }}" value="{{ $action[1] }}">
                                            <label for="perm_{{ $module }}_{{ $action[0] }}" class="text-sm">{{ ucfirst($action[0]) }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                    <button type="button" wire:click='closerolemodal' class="px-3 py-2 text-sm md:text-md md:px-6 md:py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        <span wire:loading.remove wire:target='closerolemodal'>Cancel</span>
                        <span wire:loading.flex wire:target="closerolemodal" class='justify-center'>
                            <svg class="animate-spin h-5 w-5 text-purple" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                        </span>
                    </button>
                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-3 py-2 text-sm md:text-md md:px-6 md:py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg">
                        <i class="fas fa-user-tag mr-2" wire:loading.remove wire:target='saverole'></i><span wire:loading.remove wire:target='saverole()'>{{$modal_Save_btn_txt}}</span>
                        <span wire:loading.flex wire:target="saverole()" class='justify-center'>
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
