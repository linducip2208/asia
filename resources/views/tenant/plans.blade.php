<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Paket Harga — ERPAsia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet">
    <style>body{font-family:'Inter',sans-serif}</style>
</head>
<body class="h-full py-16 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900">Pilih Paket</h1>
            <p class="mt-3 text-lg text-gray-500">Mulai gratis, upgrade sesuai kebutuhan bisnis Anda.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($plans as $plan)
            <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col @if($plan->slug === 'professional') ring-2 ring-blue-500 scale-105 @endif">
                <h3 class="text-xl font-bold text-gray-900">{{ $plan->name }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ $plan->description }}</p>
                <div class="mt-6 mb-6">
                    <span class="text-4xl font-extrabold text-gray-900">{{ $plan->formattedPriceMonthly() }}</span>
                    <span class="text-gray-500">/bulan</span>
                </div>
                <ul class="space-y-3 text-sm text-gray-600 flex-1">
                    <li>✅ {{ $plan->max_outlets }} Outlet</li>
                    <li>✅ {{ $plan->max_users }} User</li>
                    <li>✅ {{ number_format($plan->max_products) }} Produk</li>
                    <li>✅ {{ number_format($plan->max_transactions_per_day) }} Transaksi/hari</li>
                    @foreach(array_slice($plan->features ?? [], 0, 5) as $f)
                        <li>✅ {{ $f }}</li>
                    @endforeach
                </ul>
                <a href="/register?plan={{ $plan->slug }}" class="mt-8 block text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow transition">Pilih {{ $plan->name }}</a>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>
