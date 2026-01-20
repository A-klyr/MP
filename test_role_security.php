<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

function testAccess($email, $roleName) {
    echo "Testing access for {$roleName} ({$email})...\n";
    $user = App\Models\User::where('email', $email)->first();
    
    if (!$user) {
        echo "User {$email} not found.\n";
        return;
    }

    // Authenticate as the user
    auth()->login($user);

    // Create an internal request
    $request = Illuminate\Http\Request::create('/user', 'GET');
    
    // Dispatch request through Kernel
    try {
        $response = app()->handle($request);
        $status = $response->getStatusCode();
    } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
        $status = $e->getStatusCode();
    } catch (\Exception $e) {
        // If abort(403) throws exception in this context
        if ($e->getMessage() == 'Anda tidak memiliki akses ke halaman ini.') {
             $status = 403;
        } else {
             echo "Exception: " . $e->getMessage() . "\n";
             $status = 500;
        }
    }

    echo "Status Code: {$status}\n";

    if ($roleName == 'Admin' && $status == 200) {
        echo "PASS: Admin allowed.\n";
    } elseif ($roleName != 'Admin' && ($status == 403)) {
        echo "PASS: Non-admin denied.\n";
    } else {
        echo "FAIL: Unexpected status for {$roleName}.\n";
    }
    
    // Logout
    auth()->logout();
    echo "---------------------------------\n";
}

testAccess('admin@gmail.com', 'Admin');
testAccess('user@gmail.com', 'Regular User');
