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
    <div id="leadsSection" class="section ">
        <div class="flex justify-between items-center mb-6 flex-col md:flex-row gap-2">
            <h2 class="text-2xl font-bold text-gray-800">All Submission</h2>
            <div class='flex flex-col md:flex-row gap-4'>
                @if(in_array('create', $currentusrpermissions))
                <button wire:click='openmodal()' class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white min-w-[15%] justify-center items-center cursor-pointer px-3 py-2 text-sm md:text-md md:px-3 md:py-2 text-dm md:text-md md:px-6 md:py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg">
                    <i wire:loading.remove wire:target="openmodal()" class="fas fa-user-plus mr-2 cursor-pointer hidden md:inline-block"></i><span wire:loading.remove wire:target="openmodal()">Add Submission</span>
                    <span wire:loading.flex wire:target="openmodal()" class='justify-center'>
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </span>
                </button>
                @endif
                <div class='grid grid-cols-2 gap-2'>
                    
                        <select id="leadStatusFilter" wire:model='usersdd' wire:click='view()' class="border border-gray-300 rounded-lg px-3 py-2 text-sm md:text-md md:px-4 md:py-2 w-full">
                            <option value="-1">All Users</option>
                             @foreach($users as $usr)
                                    <option value="{{$usr->id}}">{{$usr->name}}</option>
                            @endforeach
                        </select>
                    
                        <select id="leadStatusFilter" wire:model='statusdd' wire:click='view()' class="border border-gray-300 rounded-lg px-3 py-2 text-sm md:text-md md:px-4 md:py-2 w-full">
                            <option value="-1">All Status</option>
                            <option value="0">Submitted</option>
                            <option value="1">In-Process</option>
                            <option value="2">Close</option>
                            <option value="3">Pending</option>
                            <option value="4">Paid</option>
                            <option value="5">Reject</option>
                        </select>
                    
                </div>
                <div class='grid grid-cols-2 gap-2'>
                   
                        <input type='text' wire:model='searchtxt' wire:keyup='view()' placeholder='Search' class='border border-gray-300 rounded-lg px-3 py-2 text-sm md:text-md md:px-4 md:py-2 w-full'/>    
                    
                        <select id="columndd" wire:model='columndd' wire:click='view()' class="border border-gray-300 rounded-lg px-3 py-2 text-sm md:text-md md:px-4 md:py-2 w-full">
                            <option value="id">Order Number</option>
                            <option value="accnumber">Account Number</option>
                            <option value="name">Lead Name</option>
                            <option value="package_id">Package MRC</option>
                            <option value="locationlink">Location</option>
                        </select>
                    
                </div>
            </div>
        </div>
        @if(in_array('view',$currentusrpermissions))
        <div class="bg-white rounded-xl shadow-md overflow-hidden max-w-[320px] md:max-w-full">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Account Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lead Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Package MRC</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employee</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                            
                            @if(in_array('edit',$currentusrpermissions) || in_array('delete',$currentusrpermissions))
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($leads as $lead)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-600">{{$lead->id}}</td>
                                <td>
                                    @if(in_array('edit',$currentusrpermissions))
                                    <div class="flex items-center gap-2">
                                        <textarea
                                            wire:model="accountxt.{{ $lead->id }}"
                                            class="border rounded-md px-2 py-1 w-full text-sm resize-none"
                                            rows="2"
                                        ></textarea>

                        
                                        <button
                                            wire:click="accountupdate({{ $lead->id }})"
                                            class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-md"
                                            title="Save"
                                        >
                                            <!-- Save Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" wire:loading.remove wire:target='accountupdate'
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span wire:loading.flex wire:target='accountupdate' class='justify-center'>
                                            <svg class="animate-spin h-5 w-5 text-purple" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                            </svg>
                                        </span>
                                        </button>
                                    </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{$lead->name}}</div>
                                    <div class="text-sm text-gray-500">{{$lead->phone}}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{$lead->package->name}}</td>
                                <td class="px-6 py-4 text-gray-600">{{$lead->phone}}</td>
                                <td class="px-6 py-4 text-gray-600">{{$lead->user->name}}</td>
                                <td class="px-6 py-4 text-gray-600">{{$lead->locationlink}}</td>
                                <td class="px-6 py-4 text-gray-600">{{$lead->created_at}}</td>
                                <td class="px-6 py-4">
                                    @if(in_array('edit',$currentusrpermissions))
                                        <select wire:change="updateStatus({{ $lead->id }}, $event.target.value)"
                                            class="border border-gray-300 rounded-lg px-2 py-1">
                                            <option value="0" {{ $lead->status == 0 ? 'selected' : '' }}>Submitted</option>
                                            <option value="1" {{ $lead->status == 1 ? 'selected' : '' }}>In-Process</option>
                                            <option value="2" {{ $lead->status == 2 ? 'selected' : '' }}>Close</option>
                                            <option value="3" {{ $lead->status == 3 ? 'selected' : '' }}>Pending</option>
                                            <option value="4" {{ $lead->status == 4 ? 'selected' : '' }}>Paid</option>
                                            <option value="5" {{ $lead->status == 5 ? 'selected' : '' }}>Reject</option>
                                        </select>
                                    @else
                                        @if($lead->status == 0)
                                            Submitted
                                        @elseif($lead->status == 1)
                                            In-Process
                                        @elseif($lead->status == 2)
                                            Close
                                        @elseif($lead->status == 3)
                                            Pending
                                        @elseif($lead->status == 4)
                                            Paid
                                        @elseif($lead->status == 5)
                                            Reject
                                        @endif
                                    @endif

                                </td>
                                <td>
                                    @if(in_array('edit',$currentusrpermissions))
                                    <div class="flex items-center gap-2">
                                        <textarea
                                            wire:model="remarkstxt.{{ $lead->id }}"
                                            class="border rounded-md px-2 py-1 w-full text-sm resize-none"
                                            rows="2"
                                        ></textarea>

                        
                                        <button
                                            wire:click="updateremarks({{ $lead->id }})"
                                            class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-md"
                                            title="Save"
                                        >
                                            <!-- Save Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" wire:loading.remove wire:target='updateremarks'
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span wire:loading.flex wire:target='updateremarks' class='justify-center'>
                                            <svg class="animate-spin h-5 w-5 text-purple" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                            </svg>
                                        </span>
                                        </button>
                                    </div>
                                    @endif
                                </td>
                                @if(in_array('edit',$currentusrpermissions) || in_array('delete',$currentusrpermissions))
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(in_array('edit',$currentusrpermissions))
                                    <button wire:click='edit({{$lead->id}})' class="text-purple-600 hover:text-purple-800 mr-3">
                                        <i class="fas fa-edit" wire:loading.remove wire:target='edit'></i>
                                        <span wire:loading.flex wire:target='edit' class='justify-center'>
                                            <svg class="animate-spin h-5 w-5 text-purple" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    @endif
                                    <button wire:click='downloadZip({{$lead->id}})' class="text-gray-600 hover:text-gray-800 mr-3">
                                        <i class="fas fa-download" wire:loading.remove wire:target='downloadZip'></i>
                                        <span wire:loading.flex wire:target='downloadZip' class='justify-center'>
                                            <svg class="animate-spin h-5 w-5 text-purple" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    @if(in_array('delete',$currentusrpermissions))
                                    <button wire:click='delete({{$lead->id}})' class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash" wire:loading.remove wire:target='delete'></i>
                                        <span wire:loading.flex wire:target='delete' class='justify-center'>
                                            <svg class="animate-spin h-5 w-5 text-purple" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                            </svg>
                                        </span>
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
        @endif
    </div>

    <!--Modal-->
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
            <form id="addLeadForm" wire:submit.prevent='save()' class="p-6">
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Lead Name</label>
                    <input type="text" id="leadName" wire:model='name' required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('name')<span class='text-red-500'>{{$message}}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Phone Number</label>
                    <input type="tel" id="leadNumber" wire:model='phone' required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('phone')<span class='text-red-500'>{{$message}}</span> @enderror
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
                    <label class="block text-gray-700 font-semibold mb-2">Emirates ID</label>
                    <input type="file" id="emiratesId" wire:model='emirateid' accept="image/*,.pdf" multiple @if($editid == 0) required @endif class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('emirateid')<span class='text-red-500'>{{$message}}</span> @enderror
                </div>

                <div class='w-full mt-6'>
                    <label class="block text-gray-700 font-semibold mb-2">User *</label>
                    <select required wire:model='userid'
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="-1">Select Type</option>
                            @foreach($users as $usr)
                                <option value="{{$usr->id}}">{{$usr->name}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="my-6">
                    <label class="block text-gray-700 font-semibold mb-2">Package *</label>
                    <select required wire:model='package'
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm md:text-md md:px-4 md:py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="-1">Select Type</option>
                            @foreach($packages as $package)
                                <option value="{{$package->id}}">{{$package->name}}</option>
                            @endforeach
                    </select>
                    @error('package')<span class='text-red-500'>{{$message}}</span> @enderror
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-3 py-2 text-sm md:text-md md:px-4 md:py-2 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition font-semibold shadow-lg">
                    <i class="fas fa-plus mr-2" wire:loading.remove wire:target='save'></i><span wire:loading.remove wire:target='save'>{{$editid != 0 ? 'Edit' : 'Save'}} Lead</span>
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



</div>
