<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Conversion Booster - Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #008060 0%, #004c3f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-card {
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 600px;
        }

        .logo {
            font-size: 60px;
            color: #008060;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .btn-install {
            background: #008060;
            color: white;
            padding: 15px 40px;
            font-size: 18px;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-install:hover {
            background: #006e52;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 128, 96, 0.4);
        }
    </style>
</head>

<body>
    <div class="welcome-card">
        <div class="logo">
            <i class="fas fa-rocket"></i> 🚀
        </div>
        <h1>Smart Conversion Booster</h1>
        <p class="lead text-muted mb-4">
            Increase your Shopify store's conversion rate with sales notifications,
            product reviews, social proof widgets, and more!
        </p>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="mt-4">
            <p class="text-muted">App install karne ke liye:</p>
            <form action="/auth" method="GET" class="d-flex gap-2 justify-content-center">
                <input type="text" name="shop" class="form-control" placeholder="your-store.myshopify.com"
                    style="max-width: 300px;" required>
                <button type="submit" class="btn btn-install">
                    Install App
                </button>
            </form>
        </div>

        <div class="mt-4 text-muted small">
            <p>Built with Laravel & PHP - No React/Node.js required!</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
