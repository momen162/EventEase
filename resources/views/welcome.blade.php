<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EventEase - Home</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <style>
        /* Simple CSS for a clean, modern look */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0; padding: 0;
            background: #f4f7f8;
            color: #333;
        }
        header {
            background: #007bff;
            padding: 20px;
            color: white;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        header h1 {
            margin: 0;
            font-weight: 700;
            font-size: 2.5rem;
        }
        main {
            padding: 40px 20px;
            max-width: 900px;
            margin: 0 auto;
        }
        .intro {
            font-size: 1.25rem;
            margin-bottom: 30px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px 25px;
            color: white;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        footer {
            text-align: center;
            padding: 20px;
            font-size: 0.9rem;
            color: #666;
            background: #e9ecef;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to EventEase</h1>
    </header>

    <main>
        <p class="intro">
            Manage your events effortlessly with EventEase. Create, update, and track all your events in one place.
        </p>
        <a href="{{ url('/events') }}" class="btn-primary">View Events</a>
    </main>

    <footer>
        &copy; {{ date('Y') }} EventEase. All rights reserved.
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
      // You can add any simple JS here if needed
      console.log('Welcome to EventEase!');
    </script>
</body>
</html>
