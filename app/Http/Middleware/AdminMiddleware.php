<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class AdminMiddleware
{
    protected $database;

    public function __construct()
    {
        // Khởi tạo Firebase
        $factory = (new Factory)
            ->withServiceAccount(storage_path('firebase_ctfPhenis.json'))
            ->withDatabaseUri('https://ctfapp-9e0fd-default-rtdb.asia-southeast1.firebasedatabase.app/');

        $this->database = $factory->createDatabase();
    }

    public function handle(Request $request, Closure $next)
    {
        // Lấy UID người dùng từ session
        $user = session('firebase_user');
        if ($user) {
            $userId = $user['uid'];

            // Kiểm tra xem người dùng có phải là admin không
            $isAdmin = $this->database->getReference('admins/' . $userId)->getValue();

            if ($isAdmin) {
                return $next($request); // Cho phép truy cập
            }
        }

        // Nếu không phải admin, chuyển hướng về trang chủ với thông báo lỗi
        return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
    }
}
