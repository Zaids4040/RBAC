<div id="dashboardSection" class="section">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Employees</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">24</h3>
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
                    <h3 class="text-3xl font-bold text-purple-600 mt-2">18/24</h3>
                    <p class="text-sm text-gray-600 mt-1">75% Present</p>
                </div>
                <div class="bg-purple-100 p-4 rounded-full">
                    <i class="fas fa-calendar-check text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Pending Approvals</p>
                    <h3 class="text-3xl font-bold text-yellow-600 mt-2">12</h3>
                </div>
                <div class="bg-yellow-100 p-4 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Payouts</p>
                    <h3 class="text-3xl font-bold text-green-600 mt-2">AED 45,600</h3>
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
            <h3 class="text-xl font-bold text-gray-800 mb-4">Recent Activity</h3>
            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">New lead approved</p>
                        <p class="text-sm text-gray-600">Ahmed Ali - Dubai Marina</p>
                    </div>
                    <span class="text-sm text-gray-500">2 mins ago</span>
                </div>
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-user-plus text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">New Employee registered</p>
                        <p class="text-sm text-gray-600">Sara Mohammed</p>
                    </div>
                    <span class="text-sm text-gray-500">15 mins ago</span>
                </div>
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-money-bill text-purple-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">Payment processed</p>
                        <p class="text-sm text-gray-600">AED 2,500 to Omar Hassan</p>
                    </div>
                    <span class="text-sm text-gray-500">1 hour ago</span>
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
                    <span class="font-bold">18 Employees</span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <span class="text-gray-700">Absent</span>
                    </div>
                    <span class="font-bold">4 Employees</span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                        <span class="text-gray-700">Late</span>
                    </div>
                    <span class="font-bold">2 Employees</span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                        <span class="text-gray-700">On Leave</span>
                    </div>
                    <span class="font-bold">2 Employees</span>
                </div>
            </div>
            <div class="mt-6">
                <button onclick="showSection('attendance')" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition">
                    <i class="fas fa-calendar-alt mr-2"></i>View Full Attendance
                </button>
            </div>
        </div>
    </div>
</div>