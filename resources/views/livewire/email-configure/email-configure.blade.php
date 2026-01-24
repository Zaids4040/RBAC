<div>
    {{$error}}
    <div id="emailConfigSection" class="section">
        <div class="flex justify-between items-center mb-6 flex-col gap-2 md:flex-row md:gap-0">
            <h2 class="text-2xl font-bold text-gray-800">Email Configuration</h2>
            @if(in_array('create', $currentusrpermissions))
            <button wire:click='openEmailModal()' class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm md:text-md min-w-[15%] justify-center items-center cursor-pointer px-6 py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg">
                <i wire:loading.remove wire:target="openEmailModal()" class="fas fa-envelope mr-2 cursor-pointer"></i><span wire:loading.remove wire:target="openEmailModal()">Add Email Configuration</span>
                <span wire:loading.flex wire:target="openEmailModal()" class='justify-center'>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email Configuration ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Configuration Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">SMTP Host</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">SMTP Port</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Username/Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Encryption</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            @if(in_array('edit', $currentusrpermissions) || in_array('delete', $currentusrpermissions))
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($emailConfigs as $config)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{$config->id}}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">{{$config->config_name}}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{$config->smtp_host}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{$config->smtp_port}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{$config->username}}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                       {{$config->encryption}}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($config->is_active)
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                @if(in_array('edit', $currentusrpermissions) || in_array('delete', $currentusrpermissions))
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(in_array('edit', $currentusrpermissions))
                                    <button wire:click='editEmailConfig({{$config->id}})' class="text-purple-600 hover:text-purple-800 mr-3">
                                        <i class="fas fa-edit" wire:loading.remove wire:target='editEmailConfig'></i>
                                        <span wire:loading.flex wire:target="editEmailConfig()" class='justify-center'>
                                            <svg class="animate-spin h-5 w-5 text-purple" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    @endif
                                    @if(in_array('delete', $currentusrpermissions))
                                    <button class="text-red-600 hover:text-red-800" wire:click='deleteEmailConfig({{$config->id}})'>
                                        <i class="fas fa-trash" wire:loading.remove wire:target='deleteEmailConfig'></i>
                                        <span wire:loading.flex wire:target="deleteEmailConfig" class='justify-center'>
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


    <!-- Add Email Configuration Modal -->
    @if(in_array('create', $currentusrpermissions) || in_array('edit', $currentusrpermissions))
    <div id="addEmailConfigModal" class="fixed bg-[rgba(0,0,0,0.5)] z-1000 left-0 top-0 w-full h-[100%] justify-center items-center {{ $emailmodal ? 'flex' : 'hidden' }}">
        <div class="bg-white p-0 rounded-[15px] max-w-[900px] w-[90%] max-h-[90vh] overflow-y-auto animate-slide-up">
            <div class="gradient-bg text-white p-6 rounded-t-xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">{{$emailConfigId == 0 ? 'Add New Email Configuration' : 'Edit Email Configuration' }}</h2>
                    <button wire:click='closeEmailModal' class="text-white hover:text-gray-200">
                        <i wire:loading.remove wire:target='closeEmailModal()' class="fas fa-times text-2xl"></i>
                        <span wire:loading.flex wire:target="closeEmailModal()" class='justify-center'>
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
            <form class="p-6" wire:submit.prevent='saveEmailConfig'>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Configuration Name *</label>
                        <input type="text" wire:model='config_name' required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="e.g., Primary Email Server">
                        @error('config_name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">SMTP Host *</label>
                        <input type="text" wire:model='smtp_host' required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="smtp.gmail.com">
                        @error('smtp_host') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">SMTP Port *</label>
                        <input type="number" wire:model='smtp_port' required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="587">
                        @error('smtp_port') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Encryption *</label>
                        <select required wire:model='encryption' class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Select Encryption</option>
                            <option value="tls">TLS</option>
                            <option value="ssl">SSL</option>
                            <option value="none">None</option>
                        </select>
                        @error('encryption') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Username/Email *</label>
                        <input type="text" wire:model='username' required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="your-email@domain.com">
                        @error('username') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Password *</label>
                        <div class="relative">
                            <input type="password" wire:model='smtp_password' class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="SMTP password">
                            <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('smtp_password') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">From Name</label>
                        <input type="text" wire:model='from_name' class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Company Name">
                        @error('from_name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">From Email</label>
                        <input type="email" wire:model='from_email' class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="noreply@domain.com">
                        @error('from_email') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
                @if($emailConfigId == 0)
                <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mr-3"></i>
                        <div>
                            <h3 class="font-semibold text-yellow-800">Test Before Use</h3>
                            <p class="text-yellow-700 text-sm">We recommend testing this configuration before setting it as active.</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                    <button type="button" wire:click='closeEmailModal' class="px-3 py-2 text-sm md:text-md md:px-6 md:py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        <span wire:loading.remove wire:target='closeEmailModal'>Cancel</span>
                        <span wire:loading.flex wire:target="closeEmailModal" class='justify-center'>
                            <svg class="animate-spin h-5 w-5 text-purple" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                        </span>
                    </button>
                    @if($emailConfigId == 0)
                    <button type="button" wire:click='testEmailConfig' class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-3 py-2 text-sm md:text-md md:px-8 md:py-3 rounded-lg hover:from-green-700 hover:to-emerald-700 transition shadow-lg">
                        <i class="fas fa-vial mr-2" wire:loading.remove wire:target='testEmailConfig'></i><span wire:loading.remove wire:target='testEmailConfig'>Test Configuration</span>
                        <span wire:loading.flex wire:target="testEmailConfig" class='justify-center'>
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                        </span>
                    </button>
                    @endif
                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-3 py-2 text-sm md:text-md md:px-8 md:py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg">
                        <i class="fas fa-save mr-2" wire:loading.remove wire:target='saveEmailConfig'></i><span wire:loading.remove wire:target='saveEmailConfig'>{{$emailConfigId == 0 ? 'Save Configuration' : 'Update Configuration' }}</span>
                        <span wire:loading.flex wire:target="saveEmailConfig" class='justify-center'>
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

<script>
    function togglePassword(button) {
        const input = button.parentElement.querySelector('input');
        const icon = button.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>