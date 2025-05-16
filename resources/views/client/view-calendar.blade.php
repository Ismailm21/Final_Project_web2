<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Calendar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Tailwind + Bootstrap CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #43cea2, #185a9d);
            color: #fff;
            padding: 40px 20px;
            animation: fadeIn 1s ease-in-out;
        }

        .title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 30px;
            animation: slideDown 1s ease-in-out;
        }

        .calendar-cell {
            background: #fff;
            color: #333;
            border-radius: 12px;
            padding: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            animation: fadeInUp 0.8s ease-in-out;
        }

        .btn-custom {
            padding: 12px 18px;
            font-size: 1.1rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s ease-in-out;
        }

        .btn-custom:hover {
            transform: scale(1.05);
        }

        @keyframes slideDown {
            from { transform: translateY(-30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeInUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>

<h1 class="title">View Orders Calendar</h1>

<div class="container">
    <div class="mb-4 text-start">
        <a href="{{ route('clientOrders') }}" class="btn btn-light btn-custom">← Return</a>
    </div>

    <!-- Day Names -->
    <div id="calendar-headers" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3 mb-2 text-center text-white fw-bold"></div>

    <!-- Calendar Days -->
    <div id="calendar-days" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3"></div>
</div>

<script>
    const orders = @json($orders);
    const calendarDaysEl = document.getElementById('calendar-days');
    const headersEl = document.getElementById('calendar-headers');

    const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    dayNames.forEach(day => {
        const header = document.createElement('div');
        header.innerText = day;
        header.className = 'text-white text-center fw-bold';
        headersEl.appendChild(header);
    });

    const now = new Date();
    const year = now.getFullYear();
    const month = now.getMonth();

    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const totalDays = lastDay.getDate();
    const startWeekDay = firstDay.getDay(); // Sunday = 0

    // Empty cells before the first day
    for (let i = 0; i < startWeekDay; i++) {
        const emptyCell = document.createElement('div');
        emptyCell.className = 'calendar-cell bg-transparent border-0 shadow-none';
        calendarDaysEl.appendChild(emptyCell);
    }

    // Fill the calendar with days
    for (let day = 1; day <= totalDays; day++) {
        const cell = document.createElement('div');
        cell.className = 'calendar-cell';

        const dayLabel = document.createElement('div');
        dayLabel.className = 'fw-bold mb-2';
        dayLabel.innerText = day;
        cell.appendChild(dayLabel);

        const dayStr = new Date(year, month, day).toISOString().split('T')[0];
        const todaysOrders = orders.filter(o => o.delivery_date === dayStr);

        todaysOrders.forEach(order => {
            const orderDiv = document.createElement('div');
            orderDiv.className = 'mb-2 p-2 rounded';

            let bgColor = 'bg-light text-dark';
            if (order.status === 'processing') bgColor = 'bg-warning text-dark';
            else if (order.status === 'completed') bgColor = 'bg-success text-white';

            orderDiv.classList.add(...bgColor.split(' '));
            orderDiv.innerHTML = `
                <div><strong>Order:</strong> #${order.tracking_code || order.id}</div>
                <div><strong>Status:</strong> ${order.status}</div>
                <div><strong>Driver:</strong> ${order.driver?.user?.name || 'N/A'}</div>
            `;
            cell.appendChild(orderDiv);
        });

        calendarDaysEl.appendChild(cell);
    }
</script>

</body>
</html>
