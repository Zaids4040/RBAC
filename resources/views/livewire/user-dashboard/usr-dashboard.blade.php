<div>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        #map {
            height: 300px;
            width: 100%;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s;
        }
        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background: white;
            padding: 0;
            border-radius: 15px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.3s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-success { background: #d1fae5; color: #065f46; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
    </style>

    <div class="container mx-auto px-4 py-8">
        <!-- Stats Dashboard -->
        <div class="mb-4 flex justify-between items-center gap-4">
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Overview</h2>

            <div class="flex gap-2">
                <input
                    type="date"
                    wire:model="startDate"
                    wire:change="cards"
                    class="border border-gray-300 rounded-lg px-3 py-2 shadow-sm"
                >

                <input
                    type="date"
                    wire:model="endDate"
                    wire:change="cards"
                    class="border border-gray-300 rounded-lg px-3 py-2 shadow-sm"
                >
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Leads <span id="dashboardPeriodText">({{$selectdays}} Days)</span></p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2" id="totalLeads">{{$total_leads}}</h3>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-full">
                        <i class="fas fa-users text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Success Leads</p>
                        <h3 class="text-3xl font-bold text-green-600 mt-2" id="successLeads">{{$success_leads}}</h3>
                    </div>
                    <div class="bg-green-100 p-4 rounded-full">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Pending Leads</p>
                        <h3 class="text-3xl font-bold text-yellow-600 mt-2" id="pendingLeads">{{$pending_leads}}</h3>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-full">
                        <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Rejected Leads</p>
                        <h3 class="text-3xl font-bold text-red-600 mt-2" id="rejectedLeads">{{$rejected_leads}}</h3>
                    </div>
                    <div class="bg-red-100 p-4 rounded-full">
                        <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commission Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl shadow-lg p-6 text-white card-hover">
                <p class="text-purple-200 text-sm">Total MRC <span id="commissionPeriodText">({{$selectdays}} Days)</span></p>
                <h3 class="text-3xl font-bold mt-2">AED <span id="leadCommission">{{$totalcommission}}</span></h3>
            </div>

            <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-xl shadow-lg p-6 text-white card-hover">
                <p class="text-indigo-200 text-sm">Pending MRC</p>
                <h3 class="text-3xl font-bold mt-2">AED <span id="referralCommission">{{$pendingcommission}}</span></h3>
            </div>

            @if(Auth::user()->salary_type != 0)
                <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-xl shadow-lg p-6 text-white card-hover">
                    <p class="text-green-200 text-sm">Close MRC</p>
                    <h3 class="text-3xl font-bold mt-2">AED <span id="totalCommission">{{$successcommission}}</span></h3>
                </div>

                <div class="bg-gradient-to-br from-teal-500 to-teal-700 rounded-xl shadow-lg p-6 text-white card-hover">
                    <p class="text-teal-200 text-sm">Paid Amount</p>
                    <h3 class="text-3xl font-bold mt-2">AED <span id="paidAmount">{{$paidcommission}}</span></h3>
                </div>
            @else
                <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-xl shadow-lg p-6 text-white card-hover">
                    <p class="text-green-200 text-sm">Your Salary</p>
                    <h3 class="text-3xl font-bold mt-2">AED <span id="totalCommission">{{$usersalary}}</span></h3>
                </div>

                <div class="bg-gradient-to-br from-teal-500 to-teal-700 rounded-xl shadow-lg p-6 text-white card-hover">
                    <p class="text-teal-200 text-sm">Your Target</p>
                    <h3 class="text-3xl font-bold mt-2">AED <span id="paidAmount">{{$usertarget}}</span></h3>
                </div>
            @endif
        </div>
        <!-- Attendence Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="  bg-gradient-to-br from-teal-500 to-teal-700 rounded-xl shadow-lg p-6 text-white card-hover">
                <p class="text-purple-200 text-sm">Present <span id="commissionPeriodText">({{$selectdays}} Days)</span></p>
                <h3 class="text-3xl font-bold mt-2"><span id="leadCommission">{{$totalpresent}}</span></h3>
            </div>

            <div class=" bg-gradient-to-br from-green-500 to-green-700 rounded-xl shadow-lg p-6 text-white card-hover">
                <p class="text-indigo-200 text-sm">Absent</p>
                <h3 class="text-3xl font-bold mt-2"><span id="referralCommission">{{$totalabsent}}</span></h3>
            </div>

            <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-xl shadow-lg p-6 text-white card-hover">
                <p class="text-green-200 text-sm">Leavs</p>
                <h3 class="text-3xl font-bold mt-2"><span id="totalCommission">{{$totalleaves}}</span></h3>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl shadow-lg p-6 text-white card-hover">
                <p class="text-teal-200 text-sm">Late</p>
                <h3 class="text-3xl font-bold mt-2"><span id="paidAmount">{{$totallates}}</span></h3>
            </div>
        </div>

        <!-- Action Buttons & Filters -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex flex-wrap gap-4 items-center justify-between">
                <div class="flex gap-3">
                    <button wire:click='openmodal()' class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-3 py-2 teext-sm md:text-md md:px-6 md:py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg">
                        <i class="fas fa-plus mr-2" wire:loading.remove wire:target='openmodal'></i><span wire:loading.remove wire:target='openmodal'>Add Submission</span>
                        <span wire:loading.flex wire:target='openmodal' class='justify-center'>
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
                <div class="flex gap-3">
                    <select id="statusFilter" wire:change='view' wire:model='statusdd' class="border border-gray-300 rounded-lg px-3 py-2 text-sm md:text-md md:px-4 md:py-2">
                        <option value="-1">All Status</option>
                        <option value="0">Pending</option>
                        <option value="1">Success</option>
                        <option value="2">Paid</option>
                        <option value="3">Rejected</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- Leads Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden max-w-[310px] md:max-w-full">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800">My Leads</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commission</th>
                        </tr>
                    </thead>
                    <tbody id="leadsTable" class="bg-white divide-y divide-gray-200">
                        @foreach($leads as $lead)
                            <tr>
                                <td class="px-6 py-4 font-medium text-gray-900">{{$lead->name}}</td>
                                <td class="px-6 py-4 text-gray-900">{{$lead->phone}}</td>
                                <td class="px-6 py-4 text-gray-900">{{$lead->locationlink}}</td>
                                <td class="px-6 py-4 text-gray-900">{{$lead->created_at}}</td>
                                <td class="px-6 py-4 text-gray-900">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        @if($lead->status == 0) Submitted @elseif($lead->status == 1) In-Process @elseif($lead->status == 2) Close @elseif($lead->status == 3) Pending @elseif($lead->status == 4) Paid @else Rejected @endif</td>
                                    </span>
                                <td class="px-6 py-4 text-gray-900">{{$lead->note}}</td>
                                <td class="px-6 py-4 text-gray-900">{{$lead->package->commission}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Lead Modal -->
    <div id="addLeadModal" class="fixed bg-[rgba(0,0,0,0.5)] z-[10000] left-0 top-0 w-full h-[100%] justify-center items-center {{ $leadmodal ? 'flex' : 'hidden' }}">
        <div class="modal-content">
            <div class="gradient-bg text-white p-6 rounded-t-xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">Add New Lead</h2>
                    <button wire:click='closemodal()' class="text-white hover:text-gray-200">
                        <i class="fas fa-times text-2xl" wire:loading.remove wire:target='closemodal'></i>
                        <span wire:loading.flex wire:target='closemodal' class='justify-center'>
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
            <form id="addLeadForm" class="p-6" wire:submit.prevent='save()'>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Company Name</label>
                    <input type="text" id="leadName" wire:model='name' required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('name')<span class='text-red-500'>{{$message}}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Phone Number</label>
                    <input type="tel" id="leadNumber" wire:model='phone' required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('phone')<span class='text-red-500'>{{$message}}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" id="emailtxt" wire:model='emailtxt' required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('emailtxt')<span class='text-red-500'>{{$message}}</span> @enderror
                </div>
                

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Location</label>
                    <div class="flex gap-2 mb-2">
                        <button type="button" onclick="pastelink('manualLocation')" class="flex-1 bg-purple-100 text-purple-700 px-4 py-2 rounded-lg hover:bg-purple-200 transition">
                            <i class="fas fa-link mr-2"></i>Paste Link
                        </button>
                        <button type="button" onclick="showMapSelection()" class="hidden flex-1 bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                            <i class="fas fa-map-marked-alt mr-2"></i>Select on Map
                        </button>
                    </div>
                    <div id="manualLocationDiv" style="display:block;">
                        <input type="text" id="manualLocation" wire:model='locationlink' placeholder="Paste Google Maps link" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('locationlink')<span class='text-red-500'>{{$message}}</span> @enderror
                    </div>
                    <div id="mapSelectionDiv" style="display:none;">
                        <input type="text" id="mapSearch" placeholder="Search location..." class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <div id="map" class="rounded-lg border border-gray-300"></div>
                        <input type="hidden" id="selectedLocation">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Documents</label>
                    <input type="file" id="emiratesId" wire:model='emirateid' accept="image/*,.pdf" multiple required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('emirateid')<span class='text-red-500'>{{$message}}</span> @enderror
                </div>

                <div class='flex gap-2 mt-6'>
                    <div class='w-full'>
                        <label class="block text-gray-700 font-semibold mb-2">Company *</label>
                        <select required wire:model='company' wire:change='packagefilter()'
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="-1">Select Type</option>
                                
                                <option value="Etisalat">Etisalat</option>
                        </select>
                    </div>
                    <div class='w-full'>
                        <label class="block text-gray-700 font-semibold mb-2">Package Type *</label>
                        <select required wire:model='packagetype' wire:change='packagefilter()'
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="-1">Select Type</option>
                                <option value="Wireless">Wireless</option>
                                <option value="GSM">GSM</option>
                                <option value="Fiber">Fiber</option>
                        </select>
                    </div>
                </div>
                <div class="my-6">
                    <label class="block text-gray-700 font-semibold mb-2">Package *</label>
                    <select required wire:model='package'
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="-1">Select Type</option>
                            @foreach($packages as $package)
                                <option value="{{$package->id}}">{{$package->name}}</option>
                            @endforeach
                    </select>
                    @error('package')<span class='text-red-500'>{{$message}}</span> @enderror
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition font-semibold shadow-lg">
                    <i class="fas fa-plus mr-2" wire:loading.remove wire:target='save'></i><span wire:loading.remove wire:target='save'>Add Submission</span>
                    <span wire:loading.flex wire:target='save' class='justify-center'>
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </span>
                </button>
            </form>
        </div>
    </div>

    <!-- Settings Modal -->
    <div id="settingsModal" class="modal">
        <div class="modal-content">
            <div class="gradient-bg text-white p-6 rounded-t-xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">Agent Settings</h2>
                    <button onclick="closeSettings()" class="text-white hover:text-gray-200">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
            </div>
            <form id="settingsForm" class="p-6">
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
                    <input type="text" id="settingsName" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" id="settingsEmail" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Phone Number</label>
                    <input type="tel" id="settingsPhone" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Bank Account</label>
                    <input type="text" id="settingsBank" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition font-semibold shadow-lg">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
            </form>
        </div>
    </div>


    
</div>
