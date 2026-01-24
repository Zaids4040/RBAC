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
            <button wire:click='opencreditmodal()' class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-3 py-2 text-sm md:text-md md:px-6 md:py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg">
                <span wire:loading.remove wire:target='opencreditmodal'>Credits</span>
                <span wire:loading.flex wire:target='opencreditmodal' class='justify-center'>
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </span>
            </button>
        </div>
        
    </div>

    <div id="dashboardSection" class="section">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Close Leads</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">AED {{$creditcommission}}</h3>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-full">
                        <i class="fas fa-users text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">PanUnited Commission Payout</p>
                        <h3 class="text-3xl font-bold text-purple-600 mt-2">AED {{$debitcommission}}</h3>
                    </div>
                    <div class="bg-purple-100 p-4 rounded-full">
                        <i class="fas fa-calendar-check text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>


            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Expences</p>
                        <h3 class="text-3xl font-bold text-yellow-600 mt-2">AED {{$expences}}</h3>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-full">
                        <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Salaries Debit</p>
                        <h3 class="text-3xl font-bold text-green-600 mt-2">AED {{$totalsalariespaid}}</h3>
                    </div>
                    <div class="bg-green-100 p-4 rounded-full">
                        <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Gross Profit</p>
                        <h3 class="text-3xl font-bold text-yellow-600 mt-2">AED {{$grossprofit}}</h3>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-full">
                        <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Net Profit</p>
                        <h3 class="text-3xl font-bold text-green-600 mt-2">AED {{$netprofit}}</h3>
                    </div>
                    <div class="bg-green-100 p-4 rounded-full">
                        <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Etisalat Need To Be Pay</p>
                        <h3 class="text-3xl font-bold text-green-600 mt-2">AED {{$due}}</h3>
                    </div>
                    <div class="bg-green-100 p-4 rounded-full">
                        <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="addPackageModal" class="fixed bg-[rgba(0,0,0,0.5)] left-0 top-0 w-full h-[100%] justify-center items-center {{ $passwordmodal ? 'flex' : 'hidden' }}">
        <div class="bg-white p-0 rounded-[15px] max-w-[400px] w-[90%] max-h-[90vh] overflow-y-auto animate-slide-up">
            <div class="gradient-bg text-white p-6 rounded-t-xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">Security Password</h2>
                </div>
            </div>
            <form class="p-6" wire:submit.prevent='checkpass'>
                <div class="mb-2">
                    <!-- Package Name -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Password *</label>
                        <input type="password" required wire:model='password'
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                            placeholder="e.g., Premium Internet, Business Plan">
                            @error('password') <span class='text-red-500'>{{$message}}</span> @enderror
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                    <button type="submit" 
                            class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-3 py-2 text-sm md:text-md md:px-8 md:py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg">
                        <span wire:loading.remove wire:target='checkpass'>Login</span>
                        <span wire:loading.flex wire:target='checkpass' class='justify-center'>
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


<!--Table-->
    <div class='flex gap-2 justify-end mb-2 w-full'>
        <div class="flex gap-3 float-right">
            <select id="accountsfilter" wire:model='paytypesel' wire:click='view()' class="border border-gray-300 rounded-lg px-3 py-2 text-sm md:text-md md:px-4 md:py-2">
                <option value="-1">All Types</option>
                <option value="0">Etisalat Credit</option>
                <option value="1">Expence</option>
                <option value="2">User Salary</option>
            </select>
        </div>
        <div class="flex gap-3 float-right">
            <select id="accountsfilterusr" wire:model='usersel' wire:click='view()' class="border border-gray-300 rounded-lg px-3 py-2 text-sm md:text-md md:px-4 md:py-2">
                <option value="-1">All Users</option>
                @foreach($users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
        </div>
        
    </div>
    <div class="bg-white rounded-xl shadow-md overflow-hidden max-w-[320px] md:max-w-full">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pay Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">To User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Note</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Delete</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($records as $rec)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-600">@if($rec->type == 0) Etisalat Credit @elseif($rec->type == 1) Expence @else User Salary Pay @endif</td>
                            <td class="px-6 py-4 text-gray-600">{{$rec->amount}}</td>
                            <td class="px-6 py-4 text-gray-600">{{$rec->user_id_salary_pay != 0 ? $rec->user_id_salary_pay : 'No User' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{$rec->note ? $rec->note : 'No Note' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{$rec->created_at}}</td>
                            <td>
                                <button class="text-red-600 hover:text-red-800" wire:click='deleteaccounts({{$rec->id}})'>
                                    <i class="fas fa-trash" wire:loading.remove wire:target='deleteaccounts'></i>
                                    <span wire:loading.flex wire:target="deleteaccounts" class='justify-center'>
                                        <svg class="animate-spin h-5 w-5 text-purple" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                        </svg>
                                    </span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
    <!--credit modal-->
    <div id="creditmodal" class="fixed bg-[rgba(0,0,0,0.5)] left-0 top-0 w-full h-[100%] justify-center items-center {{ $creditmodal ? 'flex' : 'hidden' }}">
        <div class="bg-white p-0 rounded-[15px] max-w-[400px] w-[90%] max-h-[90vh] overflow-y-auto animate-slide-up">
            <div class="gradient-bg text-white p-6 rounded-t-xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">Credit/Debit Management</h2>
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
            <form class="p-6" wire:submit.prevent='save'>
                <div class="mb-2">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Payment Type *</label>
                        <select required wire:model='paytype' wire:change='showuser'
                                class="w-full border border-gray-300 mb-2 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="-1">Select Type</option>
                            <option value="0">Etisalat Credit</option>
                            <option value="1">Debit</option>
                            <option value="2">User Salary</option>
                        </select>
                        @error('paytype') <span class='text-red-500'>{{$message}}</span> @enderror
                    </div>
                    @if($userddshow)
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Users *</label>
                            <select required wire:model='userdd' wire:change='usrsalaryupdate'
                                    class="w-full border mb-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="-1">Select Type</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                            @error('userdd') <span class='text-red-500'>{{$message}}</span> @enderror
                        </div>
                        <div class='flex gap-2 w-full'>
                            <div class='w-full'>
                                <label class="block text-gray-700 font-semibold mb-2">Year *</label>
                                <select required wire:model='yeardd' wire:change='usrsalaryupdate'
                                        class="w-full border mb-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="-1">Select Type</option>
                                    @foreach($years as $year)
                                    <option value="{{$year}}">{{$year}}</option>
                                    @endforeach
                                </select>
                                @error('userdd') <span class='text-red-500'>{{$message}}</span> @enderror
                            </div>
                            <div class='w-full'>
                                <label class="block text-gray-700 font-semibold mb-2">Month *</label>
                                <select required wire:model='monthdd' wire:change='usrsalaryupdate'
                                        class="w-full border mb-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="-1">Select Type</option>
                                    @foreach($months as $key => $month)
                                    <option value="{{$key + 1}}">{{$month}}</option>
                                    @endforeach
                                </select>
                                @error('userdd') <span class='text-red-500'>{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class='flex gap-2 w-full'>
                            <div class='w-full'>
                                <label class="block text-gray-700 font-semibold mb-2">No of Late *</label>
                                <select required wire:model='latedd' wire:change='usrsalaryupdate'
                                        class="w-full border mb-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    @for($i=0; $i<=30; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                                @error('latedd') <span class='text-red-500'>{{$message}}</span> @enderror
                            </div>
                            <div class='w-full'>
                                <label class="block text-gray-700 font-semibold mb-2">Salary Deduct *</label>
                                <select required wire:model='deductdd' wire:change='usrsalaryupdate'
                                        class="w-full border mb-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    @for($i=0; $i<=30; $i += 0.5)
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                                @error('deductdd') <span class='text-red-500'>{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class='flex gap-2 w-full'>
                            <div class='w-full'>
                                <label class="block text-gray-700 font-semibold mb-2">Late Remaining *</label>
                                <select required wire:model='lateredd' disabled
                                        class="w-full border mb-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    @for($i=0; $i<=30; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                                @error('lateredd') <span class='text-red-500'>{{$message}}</span> @enderror
                            </div>
                            <div class='w-full'>
                                <label class="block text-gray-700 font-semibold mb-2">Salary Deduct *</label>
                                <select required wire:model='deductredd' wire:change='remainingded'
                                        class="w-full border mb-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    @for($i=0; $i<=30; $i += 0.5)
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                                @error('deductredd') <span class='text-red-500'>{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div>
                        Total Lates : <b>{{$totlate}}</b></br>
                        Total Late Deduct: <b>{{$lateded}}</b></br>
                        Remaining Late: <b>{{$lateredd}}</b></br>
                        Remaining Late Deduct: <b>{{$deductremaininglate}}</b></br>
                        Total Absent: <b>{{$totabsent}}</b></br>
                        Total Absent Deduct: <b>{{$absentded}}</b></br>
                        Total Deduction: <b>{{$absentded + $lateded + $deductremaininglate}}</b></br>
                        Total Salary: <b>{{$total_salary}}</b></br>
                        <div>
                    @endif
                    <!-- Package Name -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Amount *</label>
                        <input type="amount" required wire:model='amount'
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                            placeholder="e.g., Premium Internet, Business Plan">
                            @error('amount') <span class='text-red-500'>{{$message}}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mt-2">Note *</label>
                        <input type="text" required wire:model='note'
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                            placeholder="e.g., Premium Internet, Business Plan">
                            @error('note') <span class='text-red-500'>{{$message}}</span> @enderror
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                    <button type="submit" 
                            class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-3 py-2 text-sm md:text-md md:px-8 md:py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg">
                        <span wire:loading.remove wire:target='save'>Save</span>
                        <span wire:loading.flex wire:target='save' class='justify-center'>
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
