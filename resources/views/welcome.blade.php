<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Library Management</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        header {
            background-color: #6200ea;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        header h1 {
            margin: 0;
            font-size: 2.5em;
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 100px);
            padding: 20px;
        }

        .welcome-text {
            font-size: 1.5em;
            text-align: center;
            margin-bottom: 20px;
        }

        .button-container {
            display: flex;
            gap: 15px;
        }

        .button {
            padding: 10px 20px;
            background-color: #6200ea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #3700b3;
        }

        footer {
            background-color: #6200ea;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome to Library Management</h1>
</header>

<main>
    <p class="welcome-text">Effortlessly manage your library with our simple and efficient tools.</p>
</main>

<footer>
    <p>&copy; 2024 Library Management. All rights reserved.</p>
</footer>

</body>
</html>
