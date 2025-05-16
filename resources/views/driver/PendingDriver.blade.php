<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Pending</title>
    <style>
        /* Base styles */
        :root {
            --primary-color: #f8b400;
            --secondary-color: #2d3748;
            --accent-color: #4299e1;
            --light-color: #f7fafc;
            --dark-color: #1a202c;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Container styles */
        .container {
            width: 100%;
            padding: 2rem 15px;
            max-width: 1140px;
            margin: 0 auto;
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .col-md-8 {
            width: 100%;
            max-width: 800px;
        }
        
        /* Card styles */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
            background-color: white;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background: var(--primary-color);
            padding: 1.2rem;
            border-bottom: none;
        }
        
        .card-header h4 {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0;
        }
        
        .card-body {
            padding: 2rem;
            background-color: white;
        }
        
        /* Text styles */
        .text-center {
            text-align: center;
        }
        
        .text-warning {
            color: var(--primary-color) !important;
        }
        
        .mb-0 {
            margin-bottom: 0;
        }
        
        .mb-3 {
            margin-bottom: 1rem;
        }
        
        .mb-4 {
            margin-bottom: 1.5rem;
        }
        
        .mt-4 {
            margin-top: 1.5rem;
        }
        
        h2 {
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }
        
        .lead {
            font-size: 1.25rem;
            font-weight: 300;
            color: #4a5568;
        }
        
        /* Alert styles */
        .alert-info {
            background-color: rgba(66, 153, 225, 0.1);
            border-left: 4px solid var(--accent-color);
            border-radius: 8px;
            color: #2c5282;
            padding: 1.2rem;
        }
        
        h5 {
            color: var(--secondary-color);
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        /* List styles */
        ul {
            padding-left: 1.2rem;
        }
        
        ul li {
            margin-bottom: 0.5rem;
            position: relative;
            list-style-type: none;
            padding-left: 1.5rem;
        }
        
        ul li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: var(--primary-color);
            font-weight: bold;
        }
        
        /* Button styles */
        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: all 0.15s ease-in-out;
            text-decoration: none;
            cursor: pointer;
        }
        
        .btn-danger {
            background-color: #e53e3e;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #c53030;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(229, 62, 62, 0.3);
        }
        
        /* Icon styles */
        .fas {
            -moz-osx-font-smoothing: grayscale;
            -webkit-font-smoothing: antialiased;
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 1;
        }
        
        .fa-4x {
            font-size: 4em;
        }
        
        .fa-clock:before {
            content: "⏱";
            font-size: 1.2em;
        }
        
        .fa-sign-out-alt:before {
            content: "↪";
            margin-right: 8px;
        }
        
        .fa-clock {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
        
        strong {
            color: var(--accent-color);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .col-md-8 {
                width: 90%;
            }
            
            .card-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Application Pending</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <i class="fas fa-clock fa-4x text-warning mb-3"></i>
                            <h2>Your driver application is pending approval</h2>
                            <p class="lead">Thank you for applying to be a driver with our service.</p>
                        </div>

                        <div class="alert alert-info">
                            <p>Our team is currently reviewing your driver application. This process typically takes 1-3 business days.</p>
                            <p>Once your application is approved, you will receive an email and you'll be able to start accepting delivery orders.</p>
                        </div>

                        <div class="mt-4">
                            <h5>What happens next?</h5>
                            <ul>
                                <li>We verify your information</li>
                                <li>We perform a background check</li>
                                <li>Upon approval, your account will be activated</li>
                            </ul>
                        </div>

                        <div class="mt-4">
                            <p>If you have any questions, please contact our support team at <strong>support@quickdeliver.com</strong></p>
                        </div>

                        <div class="text-center mt-4">
                            <form method="GET" action="{{ route('driver.logout') }}">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>