<div>
    {{$error}}
    <div id="employeesSection" class="section">
        <div class="flex justify-between items-center mb-6 flex-col gap-2 md:flex-row md:gap-0">
            <h2 class="text-2xl font-bold text-gray-800">Manage Users</h2>
            @if(in_array('create', $currentusrpermissions))
            <button wire:click='openusrmodal()' class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm md:text-md min-w-[15%] justify-center items-center cursor-pointer px-6 py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg">
                <i wire:loading.remove wire:target="openusrmodal()" class="fas fa-user-plus mr-2 cursor-pointer"></i><span wire:loading.remove wire:target="openusrmodal()">Add New Employee</span>
                <span wire:loading.flex wire:target="openusrmodal()" class='justify-center'>
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </span>
            </button>
            @endif
        </div>
        @if(in_array('view', $currentusrpermissions))
        <div class="bg-white rounded-xl shadow-md overflow-hidden max-w-[320px] md:max-w-[100%]">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employee Finger ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employee Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Salary Type</th>
                            @if(in_array('edit', $currentusrpermissions) || in_array('delete', $currentusrpermissions))
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $usr)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{$usr->id}}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">{{$usr->name}}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{$usr->email}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{$usr->phone}}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                       {{$usr->role->name}}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                    @if($usr->salarytype == 0)
                                        Fixed
                                    @elseif($usr->salarytype == 1)
                                        Basic + Commission
                                    @else
                                        Commission
                                    @endif
                                </td>
                                @if(in_array('edit', $currentusrpermissions) || in_array('delete', $currentusrpermissions))
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(in_array('edit', $currentusrpermissions))
                                        @if(in_array('edit_high', $currentusrpermissions) || $currentuserlevel <= $usr->role->level)
                                        <button wire:click='edituser({{$usr->id}})' class="text-purple-600 hover:text-purple-800 mr-3">
                                            <i class="fas fa-edit" wire:loading.remove wire:target='edituser'></i>
                                            <span wire:loading.flex wire:target="edituser()" class='justify-center'>
                                                <svg class="animate-spin h-5 w-5 text-purple" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                                </svg>
                                            </span>
                                        </button>
                                        @endif
                                    @endif
                                    @if(in_array('delete', $currentusrpermissions))
                                        @if(in_array('delete_high', $currentusrpermissions) || $currentuserlevel <= $usr->role->level)
                                        <button class="text-red-600 hover:text-red-800" wire:click='deleteusr({{$usr->id}})'>
                                            <i class="fas fa-trash" wire:loading.remove wire:target='deleteusr'></i>
                                            <span wire:loading.flex wire:target="deleteusr" class='justify-center'>
                                                <svg class="animate-spin h-5 w-5 text-purple" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                                </svg>
                                            </span>
                                        </button>
                                        @endif
                                    @endif
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>


    <!-- Add Employee Modal -->
    @if(in_array('create', $currentusrpermissions) || in_array('edit', $currentusrpermissions))
    <div id="addEmployeeModal" class="fixed bg-[rgba(0,0,0,0.5)] z-1000 left-0 top-0 w-full h-[100%] justify-center items-center {{ $usermodal ? 'flex' : 'hidden' }}">
        <div class="bg-white p-0 rounded-[15px] max-w-[900px] w-[90%] max-h-[90vh] overflow-y-auto animate-slide-up">
            <div class="gradient-bg text-white p-6 rounded-t-xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">Add New Employee</h2>
                    <button wire:click='closemodal' class="text-white hover:text-gray-200">
                        <i wire:loading.remove wire:target='closemodal()' class="fas fa-times text-2xl"></i>
                        <span wire:loading.flex wire:target="closemodal()" class='justify-center'>
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
            <form class="p-6" wire:submit.prevent='savemodal'>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Full Name *</label>
                        <input type="text" wire:model='name' required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Enter full name">
                        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Email Address *</label>
                        <input type="email" wire:model='email' required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="employee@company.com">
                        @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Phone Number *</label>
                        <input type="tel" wire:model='phone' required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="+971 50 123 4567">
                        @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Role *</label>
                        <select required wire:model='role' class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Select Role</option>
                            @foreach($roles as $roledata)
                                <option value="{{(int)$roledata->id}}" {{$roledata->id == $role ? 'selected' : ''}}>{{$roledata->name}}</option>
                            @endforeach
                        </select>
                        @error('role') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Salary Type</label>
                        <select wire:model='salarytype' onchange='salarytype(this.value)' class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="-1">Select Salary Type</option>
                            <option value="0">Fixed</option>
                            <option value="1">Basic + Commission</option>
                            <option value="2">Commission</option>
                        </select>
                        @error('salarytype') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div id='salarytxtdiv' class="{{ $salarytype != 0 && $salarytype != 1  ? 'hidden' : '' }}">
                        <label class="block text-gray-700 font-semibold mb-2">Salary</label>
                        <div class="relative">
                            <input type="text" wire:model='salary' class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Add Employee Monthly Salary Here">
                        </div>
                        @error('salary') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Monthly Paid Leaves</label>
                        <div class="relative">
                            <input type="number" wire:model='leave' class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Add Employee Monthly Salary Here">
                        </div>
                        @error('leave') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Password *</label>
                        <div class="relative">
                            <input type="password" wire:model='password' name='password'  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Create password">
                            <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Confirm Password *</label>
                        <div class="relative">
                            <input type="password" wire:model='password_confirmation' name='password_confirmation' class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Confirm password">
                            <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                
                <input type="hidden" wire:model='fingerdata' id="fingerprintData" name="fingerprint">

                <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                    <button type="button" wire:click='closemodal' class="px-3 py-2 text-sm md:text-md md:px-6 md:py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        <span wire:loading.remove wire:target='closemodal'>Cancel</span>
                        <span wire:loading.flex wire:target="closemodal" class='justify-center'>
                            <svg class="animate-spin h-5 w-5 text-purple" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                        </span>
                    </button>
                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-3 py-2 text-sm md:text-md md:px-8 md:py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg">
                        <i class="fas fa-user-plus mr-2" wire:loading.remove wire:target='savemodal'></i><span wire:loading.remove wire:target='savemodal'>{{$userid == 0 ? 'Add Employee' : 'Edit Employee' }}</span>
                        <span wire:loading.flex wire:target="savemodal" class='justify-center'>
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
    <div id="fingerprintloadingModal" class="fixed inset-0 bg-black bg-opacity-50 flex hidden items-center justify-center  z-50">
        <div class="bg-white rounded-xl p-8 w-96 text-center relative">
            <h2 class="text-xl font-semibold mb-4">Scanning Fingerprint</h2>
            <p class="mb-6 text-gray-600">Please place your thumb on the scanner...</p>
            <div class="flex justify-center mb-6">
                <!-- Loading Spinner -->
                <div id='spinnerfinger' class="w-16 h-16 border-4 border-purple-300 border-t-purple-600 rounded-full animate-spin"></div>
                <p id='errormsg_fingerscan' class='hidden'>Not Captured Please Try Again</p>
            </div>
            <button id="rescanbtn" onclick='getfinderprint(1)' class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white min-w-[15%] justify-center items-center cursor-pointer px-6 py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg hidden">Rescan</button>
            <button id="cancelScan" onclick='cancelscan()' class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">&times;</button>
        </div>
    </div>
    @endif
</div>