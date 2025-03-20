<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService
{
    protected $database;

    public function __construct()
    {
        // Đảm bảo đường dẫn tới tệp JSON đúng
        $credentials = storage_path('firebase_ctfPhenis.json'); // Đường dẫn tới tệp JSON của Firebase

        // Khởi tạo Firebase SDK với service account
        $firebase = (new Factory)
            ->withServiceAccount($credentials)
            ->withDatabaseUri('https://ctfapp-9e0fd-default-rtdb.asia-southeast1.firebasedatabase.app'); // Đặt URL của Realtime Database
        
        // Lấy đối tượng Database của Firebase
        $this->database = $firebase->createDatabase();
    }

    public function getChallenges()
    {
        try {
            $challengesRef = $this->database->getReference('challenges');
            $challenges = $challengesRef->getValue();
            
            // In kết quả ra console
            print_r($challenges);
     
            return $challenges;
        } catch (\Exception $e) {
            // Nếu có lỗi xảy ra, in ra lỗi để kiểm tra
            print_r($e->getMessage());
        }
    }
    
}
