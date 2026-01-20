<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// 1. Create a dummy product
$product = \App\Models\Product::factory()->create([
    'name' => 'Test Update ' . time(),
    'price' => 5000,
    'stock' => 10,
    'category' => 'snack',
    'image' => 'dummy.jpg' // Pretend we have an image
]);

echo "Created Product ID: {$product->id}\n";
echo "Initial Name: {$product->name}\n";

// 2. Simulate Update Request (Change Name only)
echo "Testing update without image...\n";
$user = \App\Models\User::where('roles', 'admin')->first();
auth()->login($user);

$req1 = Illuminate\Http\Request::create("/product/{$product->id}", 'PUT', [
    'name' => $product->name . ' Updated',
    'price' => 6000,
    'stock' => 10,
    'category' => 'snack',
    '_token' => csrf_token()
]);

try {
    $resp = app()->handle($req1);
    if ($resp->getStatusCode() == 302) {
        $product->refresh();
        if ($product->name == $req1->name && $product->price == 6000) {
            echo "PASS: Update without image success.\n";
        } else {
             echo "FAIL: Data not updated.\n";
        }
    } else {
        echo "FAIL: Status " . $resp->getStatusCode() . "\n";
    }
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}

// 3. Cleanup
$product->delete();
echo "Cleanup done.\n";
