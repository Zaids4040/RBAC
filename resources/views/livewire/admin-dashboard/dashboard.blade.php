<div>
    <div class="mb-4 flex justify-between items-center gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Dashboard Overview</h2>

        <div class="flex gap-2">
            <input
                type="date"
                wire:model="startDate"
                wire:change="filter"
                class="border border-gray-300 rounded-lg px-3 py-2 shadow-sm"
            >

            <input
                type="date"
                wire:model="endDate"
                wire:change="filter"
                class="border border-gray-300 rounded-lg px-3 py-2 shadow-sm"
            >
        </div>
    </div>

    <div id="dashboardSection" class="section">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Employees</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">{{$userscount}}</h3>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-full">
                        <i class="fas fa-users text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Today's Attendance</p>
                        <h3 class="text-3xl font-bold text-purple-600 mt-2">{{$presentusers}}/{{$userscount}}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{$attendencepercentage}}% Present</p>
                    </div>
                    <div class="bg-purple-100 p-4 rounded-full">
                        <i class="fas fa-calendar-check text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Pending Cases</p>
                        <h3 class="text-3xl font-bold text-yellow-600 mt-2">{{$pendingleads}}</h3>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-full">
                        <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Submission</p>
                        <h3 class="text-3xl font-bold text-green-600 mt-2">AED {{$paidamount}}</h3>
                    </div>
                    <div class="bg-green-100 p-4 rounded-full">
                        <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Attendance Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Other Information</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="text-gray-700">Success Leads</span>
                        </div>
                        <span class="font-bold">{{$successleads}}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <span class="text-gray-700">Paid Leads</span>
                        </div>
                        <span class="font-bold">{{$paidleads}}</span>
                    </div>
                     <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-gray-700">Rejected Leads</span>
                        </div>
                        <span class="font-bold">{{$rejectedleads}}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-gray-700">Fiber Leads</span>
                        </div>
                        <span class="font-bold">{{$fiberleads}}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-gray-700">Wireless Leads</span>
                        </div>
                        <span class="font-bold">{{$wirelessleads}}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-gray-700">GSM Leads</span>
                        </div>
                        <span class="font-bold">{{$gsmleads}}</span>
                    </div>
                </div>
                
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Today's Attendance Overview</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="text-gray-700">Present</span>
                        </div>
                        <span class="font-bold">{{$presentusers}} Employees</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-gray-700">Absent</span>
                        </div>
                        <span class="font-bold">{{$absentusers}} Employees</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <span class="text-gray-700">Late</span>
                        </div>
                        <span class="font-bold">{{$lateusers}} Employees</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                            <span class="text-gray-700">On Leave</span>
                        </div>
                        <span class="font-bold">{{$leaveusers}} Employees</span>
                    </div>
                </div>
                <div class="mt-6">
                    <button wire:click="$dispatch('switchattendence')" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition">
                        <i class="fas fa-calendar-alt mr-2"></i>View Full Attendance
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
