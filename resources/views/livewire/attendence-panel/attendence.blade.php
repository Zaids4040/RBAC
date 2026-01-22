<div>
    <!-- Attendance Section -->
    <div id="attendanceSection" class="section">
        <div class="flex justify-between items-center mb-6 flex-col md:flex-row gap-2 md:gap-0">
            <h2 class="text-2xl font-bold text-gray-800">Attendance Management</h2>
            <div class="flex gap-3 md:gap-1">
                <input type="date" id="attendanceDatePicker" wire:model='datepicker' wire:change='dateselect()' placeholder="Select Date" class="border border-gray-300 rounded-lg px-3 text-sm md:text-md md:px-4 py-2">
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800">Today's Attendance</h3>
                
            </div>
            @if(in_array('view',$currentusrpermissions))
            <div id="dailyAttendanceView" class='max-w-[300px] md:max-w-full'>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employee</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check-in</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check-out</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($rows as $row)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4">{{$row->user->name}}</td>
                                    <td class="px-4 py-4">
                                        @if(in_array('edit',$currentusrpermissions))
                                            <input type="time" 
                                                value="{{ $row->enter_time }}"
                                                class="border border-gray-300 rounded px-2 py-1 text-sm w-full"
                                                wire:model='enter_time.{{$row->id}}'
                                                wire:change="update({{ $row->id }})" wire:loadin.remove wire:target='update'>
                                        @else
                                            {{ $row->enter_time }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        @if(in_array('edit',$currentusrpermissions))
                                        <input type="time" 
                                            value="{{ $row->exit_time }}"
                                            class="border border-gray-300 rounded px-2 py-1 text-sm w-full"
                                            wire:model='exit_time.{{$row->id}}'
                                            wire:change="update({{ $row->id }})" wire:loadin.remove wire:target='update'>
                                        @else
                                            {{ $row->exit_time }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        @if(in_array('edit',$currentusrpermissions))
                                        <select 
                                            wire:model="statusdd.{{$row->id}}" 
                                            wire:change="update({{$row->id}})"
                                            class="border rounded-lg px-3 py-1 text-sm font-semibold
                                                bg-green-100 text-green-800
                                                focus:outline-none focus:ring-2 focus:ring-purple-500" wire:loadin.remove wire:target='update'
                                        >
                                            <option value="Present">PRESENT</option>
                                            <option value="Late">LATE</option>
                                            <option value="Absent">ABSENT</option>
                                            <option value="Leave">LEAVE</option>
                                        </select>
                                        @else
                                            {{ $row->attendence_status }}
                                        @endif
                                    </td>

                                    <td class="px-4 py-4">
                                        {{$row->created_at}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
