<div>
    <style>
        .commission-tier {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 20px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .commission-tier::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        }
    </style>
    <div id="commissionSection" class="section">
        <div class="flex justify-between items-center mb-6 flex-col md:flex-row gap-2 md:gap-0">
            <h2 class="text-2xl font-bold text-gray-800">Package Management</h2>
            @if(in_array('create',$currectuserpermission))
                <button wire:click='openmodal()' class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-3 py-2 text-sm md:text-md md:px-6 md:py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg">
                    <i class="fas fa-plus mr-2" wire:loading.remove wire:target='openmodal'></i><span wire:loading.remove wire:target='openmodal'>Add Package</span>
                    <span wire:loading.flex wire:target='openmodal' class='justify-center'>
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </span>
                </button>
            @endif
        </div>

        <!-- Weekly Commission View -->
        @if(in_array('view',$currectuserpermission))
        <div id="weeklyCommissionView" class='z-[-1]'>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Tier 1 -->
                 @foreach($data as $d)
                    <div class="commission-tier" >
                        <div class="relative">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-purple-100 text-sm">Package Type</p>
                                    <h4 class="text-2xl font-bold">{{ $d->package_type ?? 'Normal' }}</h4>
                                </div>
                                <div class='flex gap-2'>
                                    @if(in_array('edit',$currectuserpermission))
                                    <button wire:click='editopenmodal({{$d->id}})' class="text-white hover:text-purple-200">
                                        <i class="fas fa-edit" wire:loading.remove wire:target='editopenmodal'></i>
                                        <span wire:loading.flex wire:target='editopenmodal' class='justify-center'>
                                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    @endif
                                    @if(in_array('delete',$currectuserpermission))
                                    <button class="text-red-600 hover:text-red-800" wire:click='deletepackage({{$d->id}})'>
                                        <i class="fas fa-trash" wire:loading.remove wire:target='deletepackage'></i>
                                        <span wire:loading.flex wire:target="deletepackage" class='justify-center'>
                                            <svg class="animate-spin h-5 w-5 text-purple" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    @endif
                                </div>
                                
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-purple-100">Package Name:</span>
                                    <span class="font-bold">{{ $d->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-purple-100">Price:</span>
                                    <span class="font-bold text-2xl">AED {{ $d->amount }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-purple-100">Duration:</span>
                                    <span class="font-bold">{{ $d->contact_month }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-purple-100">Company:</span>
                                    <span class="font-bold">{{ $d->package_company }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-purple-100">Discount:</span>
                                    <span class="font-bold">{{ $d->dis_amount ?? '0' }} AED ({{ $d->dis_month ?? 0 }} months)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-purple-100">Description:</span>
                                    <span class="font-bold">{{ $d->description ?? 'No description available.' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-purple-100">Status:</span>
                                    <span class="font-bold">{{ $d->status ? 'Active' : 'Inactive' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                 @endforeach
            </div>

        
        </div>
        @endif
    </div>
    @if(in_array('create',$currectuserpermission) || in_array('edit',$currectuserpermission))
    <!--modal-->
    <div id="addPackageModal" class="fixed bg-[rgba(0,0,0,0.5)] left-0 top-0 w-full h-[100%] justify-center items-center {{ $packagemodal ? 'flex' : 'hidden' }}">
        <div class="bg-white p-0 rounded-[15px] max-w-[900px] w-[90%] max-h-[90vh] overflow-y-auto animate-slide-up">
            <div class="gradient-bg text-white p-6 rounded-t-xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">{{$editid == 0 ? 'Add' : 'Edit' }} Package</h2>
                    <button wire:click='closemodal()'  class="text-white hover:text-gray-200">
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
            <form class="p-6" wire:submit.prevent='savedata'>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Package Name -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Name *</label>
                        <input type="text" required wire:model='name'
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                            placeholder="e.g., Premium Internet, Business Plan">
                            @error('name') <span class='text-red-500'>{{$message}}</span> @enderror
                    </div>
                    
                    <!-- Amount -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Amount (AED) *</label>
                        <div class="relative">
                            <div class="absolute left-3 top-2.5 text-gray-500">AED</div>
                            <input type="number" required wire:model='amount'
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 pl-12 focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                                placeholder="Package price">
                        </div>
                        @error('amount') <span class='text-red-500'>{{$message}}</span> @enderror
                    </div>
                    
                    
                    <!-- Minimum Contract -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Minimum Contract (Months) *</label>
                        <input type="text" required wire:model='contract'
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                            placeholder="e.g., 12, 24" min="1">
                            @error('contract') <span class='text-red-500'>{{$message}}</span> @enderror
                    </div>
                    
                    <!-- Discount Price -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Discount Price (AED)</label>
                        <div class="relative">
                            <div class="absolute left-3 top-2.5 text-gray-500">AED</div>
                            <input type="number" wire:model='dis_price'
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 pl-12 focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                                placeholder="Discounted price">
                        </div>
                        @error('dis_price') <span class='text-red-500'>{{$message}}</span> @enderror
                    </div>
                    
                    <!-- Discount No. of Months -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Discount No. of Months</label>
                        <input type="number" wire:model='dis_month'
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                            placeholder="Discount duration in months">
                            @error('dis_month') <span class='text-red-500'>{{$message}}</span> @enderror
                    </div>
                    
                    <!-- Package Type Dropdown -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Package Type *</label>
                        <select required wire:model='packagetype'
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="-1">Select Type</option>
                            <option value="Wireless">Wireless</option>
                            <option value="GSM">GSM</option>
                            <option value="Fiber">Fiber</option>
                        </select>
                        @error('packagetype') <span class='text-red-500'>{{$message}}</span> @enderror
                    </div>
                    
                    <!-- Company Dropdown -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Company *</label>
                        <select required wire:model='companyname'
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="-1">Select Company</option>
                            
                            <option value="Etisalat">Etisalat</option>
                        </select>
                        @error('companyname') <span class='text-red-500'>{{$message}}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Commission</label>
                        <input type="number" wire:model='commission'
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                            placeholder="Comission of the agent">
                            @error('commission') <span class='text-red-500'>{{$message}}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Credit Commission</label>
                        <input type="number" wire:model='creditcommission'
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                            placeholder="Comission of the agent">
                            @error('creditcommission') <span class='text-red-500'>{{$message}}</span> @enderror
                    </div>
                </div>
                
                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Description</label>
                    <textarea wire:model='description' class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                            rows="3" 
                            placeholder="Describe this package..."></textarea>
                            @error('description') <span class='text-red-500'>{{$message}}</span> @enderror
                </div>
                <!-- Active Checkbox -->
                <div class="flex items-center gap-3 mb-6">
                    <input type="checkbox" wire:model='active_ch' id="isPackageActive" class="w-5 h-5">
                    <label for="isPackageActive" class="text-gray-700 font-semibold">Active Package</label>
                </div>

                <!-- Info Note -->
                <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-info-circle text-blue-600"></i>
                        <p class="text-blue-700 text-sm">
                            <span class="font-semibold">Note:</span> 
                            Discount price and months are optional. Minimum contract period is required for all packages.
                        </p>
                    </div>
                    
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                    <button type="button" wire:click='closemodal()'
                            class="px-3 py-2 text-sm md:text-md md:px-6 md:py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        <span wire:loading.remove wire:target='closemodal'>Cancel</span>
                        <span wire:loading.flex wire:target='closemodal' class='justify-center'>
                            <svg class="animate-spin h-5 w-5 text-purple" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                        </span>
                    </button>
                    <button type="submit" 
                            class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-3 py-2 text-sm md:text-md md:px-8 md:py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg">
                        <i class="fas fa-plus mr-2" wire:loading.remove wire:target='savedata'></i><span wire:loading.remove wire:target='savedata'>{{$editid == 0 ? 'Add' : 'Edit' }} Package</span>
                        <span wire:loading.flex wire:target='savedata' class='justify-center'>
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
    @endif
</div>
