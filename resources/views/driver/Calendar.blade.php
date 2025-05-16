@extends('driver.fixedLayout')

@section('title', 'Calendar')

@section('page_title', 'Calendar')

@section('page-content')
    <div class="space-y-8">
        @if(session('success'))
            <div class="bg-green-50 text-green-600 p-4 rounded-lg border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if(isset($unscheduledOrders) && $unscheduledOrders->count() > 0)
            <div class="bg-yellow-50 text-yellow-700 p-4 rounded-lg border border-yellow-200 mb-4 cursor-pointer hover:bg-yellow-100 transition-colors" onclick="document.getElementById('unscheduled_orders').scrollIntoView({behavior: 'smooth'});">
            You have {{ $unscheduledOrders->count() }} unscheduled order(s). <span class="text-blue-600 underline ml-1">Click to view</span>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-900">Your Calendar</h2>
                <p class="text-sm text-gray-500">View your availabilities and scheduled deliveries</p>
            </div>
            
            <div id="calendar-container" class="border rounded-lg">
                <!-- Calendar header -->
                <div class="flex justify-between items-center p-4 bg-gray-50 border-b">
                    <button id="prev-month" class="px-3 py-1 rounded hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <h3 id="current-month" class="text-lg font-medium"></h3>
                    <button id="next-month" class="px-3 py-1 rounded hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
                
                <!-- Days of week header -->
                <div class="grid grid-cols-7 text-center py-2 bg-gray-50 border-b">
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                        <div class="font-medium text-sm">{{ $day }}</div>
                    @endforeach
                </div>
                
                <!-- Calendar grid -->
                <div id="calendar-days" class="grid grid-cols-7">
                    <!-- Calendar days will be populated by JavaScript -->
                </div>
            </div>
            
            <!-- Legend -->
            <div class="mt-4 flex flex-wrap gap-4">
                <div class="flex items-center">
                    <span class="inline-block w-4 h-4 bg-blue-200 rounded mr-2"></span>
                    <span class="text-sm">Available</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-4 h-4 bg-yellow-200 rounded mr-2"></span>
                    <span class="text-sm">Processing Order</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-4 h-4 bg-green-200 rounded mr-2"></span>
                    <span class="text-sm">Completed Order</span>
                </div>
            </div>
        </div>

        @if(isset($unscheduledOrders) && $unscheduledOrders->count() > 0)
            <div class="bg-white rounded-lg shadow p-4 mb-6">
            <h3 id="unscheduled_orders" class="text-lg font-medium mb-4">Unscheduled Orders</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($unscheduledOrders as $order)
                <div class="bg-white rounded border shadow-sm hover:shadow transition-shadow p-4">
                    <div class="flex justify-between items-start mb-2">
                    <h3 class="text-base font-semibold">#{{ $order->tracking_code }}</h3>
                    <span class="px-2 py-0.5 rounded-full text-xs
                        @if($order->status === 'pending')
                           bg-blue-100 text-blue-900 animate-pulse border-2 border-blue-400 border-dotted
                        @elseif($order->status === 'processing')
                        bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'completed')
                        bg-green-100 text-green-800
                        @else
                        bg-red-100 text-red-800
                        @endif
                    ">
                        {{ ucfirst($order->status) }}
                    </span>
                    </div>
                
                    <div class="space-y-2 text-xs">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-gray-500 mr-1 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l1-2a2 2 0 012-1h12a2 2 0 012 1l1 2m-1 4v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0H4m5 0v6m6-6v6"/>
                        </svg>
                        <div>
                        <p class="font-medium">Order Details</p>
                        <p class="text-gray-500">Weight: {{ $order->package_weight }} kg | 
                            Size: {{ $order->package_size_l }}x{{ $order->package_size_w }}x{{ $order->package_size_h }} cm</p>
                        </div>
                    </div>
                
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mr-1 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                        <div>
                        <p class="font-medium">Pickup</p>
                        <p class="text-gray-500 truncate">{{ $order->pickupAddress->city }}, {{ $order->pickupAddress->street }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-red-500 mr-1 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"/>
                        </svg>
                        <div>
                        <p class="font-medium">Dropoff</p>
                        <p class="text-gray-500 truncate">{{ $order->dropoffAddress->city }}, {{ $order->dropoffAddress->street }}</p>
                        </div>
                    </div>
                    </div>
                
                    <form action="{{ route('driver.updateOrderDeliveryDate') }}" method="POST" class="mt-3 flex flex-col space-y-2">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="datetime-local" name="delivery_date" class="border rounded px-2 py-1 text-xs w-full" 
                           required min="{{ date('Y-m-d\TH:i') }}">
                    <button type="submit" class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700 text-xs w-full">Set Delivery Date</button>
                    </form>
                </div>
                @endforeach
            </div>
            </div>
        @endif
    </div>

    <style>
        /* Custom styles for calendar cells */
        .calendar-day {
            min-height: 120px;
            height: auto;
            max-height: 160px;
            overflow-y: auto;
            position: relative;
        }
        
        /* Styling for the scrollbar */
        .calendar-day::-webkit-scrollbar {
            width: 4px;
        }
        
        .calendar-day::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .calendar-day::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        /* Event container inside calendar day */
        .events-container {
            max-height: 130px;
            overflow-y: auto;
        }
        
        /* When too many events, show indicator */
        .more-events {
            font-size: 10px;
            text-align: center;
            color: #6b7280;
            padding: 2px;
            cursor: pointer;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Calendar data from PHP
            const availabilities = @json($availabilities ?? []);
            const orders = @json($orders ?? []);
            
            // Generate routes for each order
            const orderRoutes = {};
            @foreach($orders ?? [] as $order)
                orderRoutes[{{ $order->id }}] = "{{ route('driver.viewOrderDetails', ['id' => $order->id]) }}";
            @endforeach
            
            // Map day names to day numbers (0-6, where 0 is Sunday)
            const dayNameToNumber = {
                'Sunday': 0,
                'Monday': 1,
                'Tuesday': 2,
                'Wednesday': 3,
                'Thursday': 4,
                'Friday': 5,
                'Saturday': 6
            };
            
            // Current date and displayed month/year
            let currentDate = new Date();
            let currentMonth = currentDate.getMonth();
            let currentYear = currentDate.getFullYear();
            
            // Elements
            const calendarDaysEl = document.getElementById('calendar-days');
            const currentMonthEl = document.getElementById('current-month');
            const prevMonthBtn = document.getElementById('prev-month');
            const nextMonthBtn = document.getElementById('next-month');
            
            // Initialize calendar
            renderCalendar(currentMonth, currentYear);
            
            // Event listeners for navigation
            prevMonthBtn.addEventListener('click', () => {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                renderCalendar(currentMonth, currentYear);
            });
            
            nextMonthBtn.addEventListener('click', () => {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                renderCalendar(currentMonth, currentYear);
            });
            
            function renderCalendar(month, year) {
                // Clear previous calendar
                calendarDaysEl.innerHTML = '';
                
                // Update header
                const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 
                                    'July', 'August', 'September', 'October', 'November', 'December'];
                currentMonthEl.textContent = `${monthNames[month]} ${year}`;
                
                // Get first day of month and number of days in month
                const firstDay = new Date(year, month, 1).getDay(); // 0 = Sunday, 1 = Monday, etc.
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                
                // Create calendar grid
                let dayCount = 1;
                
                // Add empty cells for days before the first of the month
                for (let i = 0; i < firstDay; i++) {
                    const emptyDay = document.createElement('div');
                    emptyDay.className = 'border p-1 bg-gray-50 calendar-day';
                    calendarDaysEl.appendChild(emptyDay);
                }
                
                // Add days of the month
                for (let day = 1; day <= daysInMonth; day++) {
                    const dateObj = new Date(year, month, day);
                    const dayCell = document.createElement('div');
                    dayCell.className = 'border p-1 calendar-day';
                    
                    // Check if it's today
                    if (dateObj.toDateString() === new Date().toDateString()) {
                        dayCell.className += ' bg-blue-50';
                    }
                    
                    // Add day number
                    const dayNumber = document.createElement('div');
                    dayNumber.className = 'font-semibold text-sm mb-1 sticky top-0 bg-inherit z-10';
                    dayNumber.textContent = day;
                    dayCell.appendChild(dayNumber);
                    
                    // Create events container
                    const eventsContainer = document.createElement('div');
                    eventsContainer.className = 'events-container';
                    
                    // Check for availabilities
                    const dayOfWeek = dateObj.getDay(); // 0-6
                    const matchingAvailabilities = availabilities.filter(a => {
                        return dayNameToNumber[a.day] === dayOfWeek;
                    });
                    
                    if (matchingAvailabilities.length > 0) {
                        // Format the times in AM/PM format with blue background
                        const formattedAvailabilities = matchingAvailabilities.map(a => {
                            const startTime = formatTimeToAMPM(a.start_time);
                            const endTime = formatTimeToAMPM(a.end_time);
                            return `<span class="bg-blue-200 text-xs px-1 py-0.5 rounded ml-1">${startTime}-${endTime}</span>`;
                        }).join(' ');
                        
                        // Update day number to include availability next to it
                        dayNumber.className = 'font-semibold text-sm mb-1 sticky top-0 bg-inherit z-10 flex items-center flex-wrap';
                        dayNumber.innerHTML = `<span>${day}</span>${formattedAvailabilities}`;
                    }

                    // Helper function to format time to AM/PM
                    function formatTimeToAMPM(time) {
                        if (!time) return '';
                        const timeStr = time.substr(0, 5);
                        const [hours, minutes] = timeStr.split(':');
                        const hour = parseInt(hours, 10);
                        const ampm = hour >= 12 ? 'PM' : 'AM';
                        const formattedHour = hour % 12 || 12;
                        return `${formattedHour}${minutes !== '00' ? ':' + minutes : ''} ${ampm}`;
                    }
                    
                    // Check for orders with delivery dates on this day
                    const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const ordersForThisDay = orders.filter(order => {
                        const orderDate = new Date(order.delivery_date);
                        return orderDate.getFullYear() === year &&
                               orderDate.getMonth() === month &&
                               orderDate.getDate() === day;
                    });
                    
                    // Show orders with a limit if there are too many
                    const maxVisibleOrders = 3;
                    const orderCount = ordersForThisDay.length;
                    
                    ordersForThisDay.slice(0, maxVisibleOrders).forEach(order => {
                        const orderDiv = document.createElement('div');
                        const deliveryTime = new Date(order.delivery_date).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                        
                        if (order.status === 'processing') {
                            orderDiv.className = 'bg-yellow-200 text-xs p-1 mb-1 rounded cursor-pointer hover:bg-yellow-300';
                            orderDiv.textContent = `Order #${order.tracking_code} - ${deliveryTime}`;
                        } else if (order.status === 'completed') {
                            orderDiv.className = 'bg-green-200 text-xs p-1 mb-1 rounded cursor-pointer hover:bg-green-300';
                            orderDiv.textContent = `Order #${order.tracking_code} - Delivered ${deliveryTime}`;
                        }
                        
                        // Make the order div clickable with the route from Laravel
                        orderDiv.addEventListener('click', function() {
                            window.location.href = orderRoutes[order.id];
                        });
                        
                        eventsContainer.appendChild(orderDiv);
                    });
                    
                    
                    // If there are more events than can be shown, add a "more" indicator
                    if (orderCount > maxVisibleOrders) {
                        const moreDiv = document.createElement('div');
                        moreDiv.className = 'more-events';
                        moreDiv.textContent = `+ ${orderCount - maxVisibleOrders} more`;
                        
                        // When clicking on "more", reveal all orders in the cell
                        moreDiv.addEventListener('click', function(e) {
                            e.stopPropagation();
                            
                            // Remove the "more" text
                            moreDiv.remove();
                            
                            // Add all remaining orders
                            ordersForThisDay.slice(maxVisibleOrders).forEach(order => {
                                const orderDiv = document.createElement('div');
                                const deliveryTime = new Date(order.delivery_date).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                                
                                if (order.status === 'processing') {
                                    orderDiv.className = 'bg-yellow-200 text-xs p-1 mb-1 rounded cursor-pointer hover:bg-yellow-300';
                                    orderDiv.textContent = `Order #${order.tracking_code} - ${deliveryTime}`;
                                } else if (order.status === 'completed') {
                                    orderDiv.className = 'bg-green-200 text-xs p-1 mb-1 rounded cursor-pointer hover:bg-green-300';
                                    orderDiv.textContent = `Order #${order.tracking_code} - Delivered ${deliveryTime}`;
                                }
                                
                                // Make the order div clickable with the route from Laravel
                                orderDiv.addEventListener('click', function() {
                                    window.location.href = orderRoutes[order.id];
                                });
                                
                                eventsContainer.appendChild(orderDiv);
                            });
                        });
                        
                        eventsContainer.appendChild(moreDiv);
                    }
                    
                    dayCell.appendChild(eventsContainer);
                    calendarDaysEl.appendChild(dayCell);
                    dayCount++;
                }
                
                // Fill remaining cells
                const totalCells = Math.ceil((daysInMonth + firstDay) / 7) * 7;
                for (let i = daysInMonth + firstDay; i < totalCells; i++) {
                    const emptyDay = document.createElement('div');
                    emptyDay.className = 'border p-1 bg-gray-50 calendar-day';
                    calendarDaysEl.appendChild(emptyDay);
                }
            }
        });
    </script>
@endsection