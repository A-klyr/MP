<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Setup User & Token
$user = App\Models\User::where('email', 'admin@gmail.com')->first();
if (!$user) {
    die("Admin user not found.\n");
}
$token = $user->createToken('test-token')->plainTextToken;

// Setup Product
$product = App\Models\Product::first();
if (!$product) {
    die("No products found.\n");
}
$initialStock = $product->stock;
echo "Product: {$product->name} (ID: {$product->id})\n";
echo "Initial Stock: {$initialStock}\n";

// Prepare Request Data
$qtyToBuy = 5;
$data = [
    'transaction_time' => now()->toDateTimeString(),
    'kasir_id' => $user->id,
    'total_price' => 10000,
    'total_item' => 1,
    'payment_method' => 'cash',
    'order_items' => [
        [
            'product_id' => $product->id,
            'quantity' => $qtyToBuy,
            'total_price' => 10000
        ]
    ]
];

// Execute Request
echo "Sending POST request to /api/orders...\n";
$response = Illuminate\Support\Facades\Http::withToken($token)
    ->post('http://127.0.0.1:8000/api/orders', $data);

echo "Response Status: " . $response->status() . "\n";
echo "Response Body: " . $response->body() . "\n";

// Verify Stock
$product->refresh();
$finalStock = $product->stock;
echo "Final Stock: {$finalStock}\n";

if ($finalStock == ($initialStock - $qtyToBuy)) {
    echo "SUCCESS: Stock deducted correctly.\n";
} else {
    echo "FAILURE: Stock not deducted correctly.\n";
}
