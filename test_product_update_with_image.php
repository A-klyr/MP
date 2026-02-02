<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// 0. Setup: Pick a real image
$sourceImage = __DIR__.'/public/library/selectric/public/img/icon.png'; // Small valid PNG from file list
$testImage = __DIR__.'/test_image.png';
copy($sourceImage, $testImage);

// 1. Create a dummy product
$product = \App\Models\Product::factory()->create([
    'name' => 'Original Name ' . time(),
    'price' => 5000,
    'stock' => 10,
    'category' => 'snack',
    'image' => 'initial.jpg'
]);

echo "Created Product ID: {$product->id}\n";
echo "Initial Image: {$product->image}\n";

// 2. Simulate Update Request (Change Name AND Image)
// Note: Handing file uploads in CLI script like this is tricky with Request::create, 
// so we will manually verify the controller logic unit-test style or create UploadedFile

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

Storage::fake('public'); // Mock storage to avoid actual filesystem mess

$file = new UploadedFile(
    $testImage,
    'test_image.png',
    'image/png',
    null,
    true
);

$user = \App\Models\User::where('roles', 'admin')->first();
auth()->login($user);

// Create request with file
$req = Illuminate\Http\Request::create(
    "/api/products/{$product->id}", 
    'POST', // Method spoofing for file upload in Laravel usually needs POST
    [
        'name' => 'Updated Name',
        'price' => 10000,
        'stock' => 5,
        'category' => 'drink',
        '_method' => 'PUT', // Spoof PUT
        'is_favorite' => 1
    ], 
    [], // cookies
    ['image' => $file] // files
);

// Resolve controller
$controller = new \App\Http\Controllers\Api\ProductController();

try {
    // Call update directly to bypass routing issues in CLI wrapper if any, 
    // but better to go through app handle if possible. 
    // Let's try direct controller call for simplicity in unit testing behavior.
    
    // We need to bind the route parameter manually if calling directly? 
    // No, let's use app()->handle() but we need to ensure route exists
    // The route is defined in api.php as apiResource 'products' -> which maps PUT/PATCH to update
    
    // To properly simulate file upload via Request::create in CLI, we need to handle content-type
    
    // Simpler approach: Call the method directly with the request object
    $response = $controller->update($req, $product->id);
    
    // Check response
    if ($response->getStatusCode() == 200) {
        $product->refresh();
        echo "Update Status: " . $response->getStatusCode() . "\n";
        echo "New Name: " . $product->name . "\n";
        echo "New Image: " . $product->image . "\n";
        
        if ($product->name == 'Updated Name' && $product->image != 'initial.jpg') {
            echo "PASS: Product updated with image.\n";
        } else {
            echo "FAIL: Data mismatch.\n";
        }
    } else {
        echo "FAIL: Status " . $response->getStatusCode() . "\n";
        echo "Response: " . json_encode($response->getData()) . "\n";
    }

} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}

// Cleanup
if(file_exists($testImage)) unlink($testImage);
//$product->delete();
