<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\FirebaseException;
use Illuminate\Http\Request;

class FirebaseController extends Controller
{
    protected $database;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('firebase_ctfPhenis.json'))
            ->withDatabaseUri('https://ctfapp-9e0fd-default-rtdb.asia-southeast1.firebasedatabase.app/');

        $this->database = $factory->createDatabase();
    }

    public function uploadChallengesJson(Request $request)
    {
        // Kiểm tra xem file có hợp lệ không
        if (!$request->hasFile('challenge_file') || !$request->file('challenge_file')->isValid()) {
            return response()->json(['error' => 'No valid file uploaded'], 400);
        }

        // Lấy file
        $file = $request->file('challenge_file');
        
        // Kiểm tra nếu file là JSON
        if ($file->getClientOriginalExtension() !== 'json') {
            return response()->json(['error' => 'File must be a JSON file'], 400);
        }

        // Đọc dữ liệu từ file JSON
        $jsonData = json_decode(file_get_contents($file->getRealPath()), true);

        if (!$jsonData) {
            return response()->json(['error' => 'Invalid JSON format'], 400);
        }

        try {
            // Đẩy dữ liệu vào Firebase Realtime Database tại node 'challenges'
            $this->database->getReference('challenges')->set($jsonData);

            return response()->json(['message' => 'Challenges uploaded successfully to Realtime Database'], 200);
        } catch (FirebaseException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
