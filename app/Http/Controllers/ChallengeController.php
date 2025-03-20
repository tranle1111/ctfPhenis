<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChallengeController extends Controller
{
    protected $database;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('firebase_ctfPhenis.json'))
            ->withDatabaseUri(config('firebase.projects.app.database.url'));

        $this->database = $factory->createDatabase();
    }

    public function index()
    {
        $firebaseUser = session('firebase_user');
        if (!$firebaseUser) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập!');
        }

        $userUid = $firebaseUser['localId'];
        $challengesRef = $this->database->getReference("users/{$userUid}/challenges");
        $challengesData = $challengesRef->getValue() ?? [];

        $userChallenges = [];

        foreach ($challengesData as $category => $challenges) {
            if (!is_array($challenges)) continue;

            foreach ($challenges as $challengeKey => $challenge) {
                if (!is_array($challenge) || !isset($challenge['name'], $challenge['points'], $challenge['solved'])) {
                    continue;
                }

                $challengeStatus = $challenge['solved'] ? '✅ ' . $challenge['name'] : $challenge['name'];

                $userChallenges[] = [
                    'category'    => $category,
                    'name'        => $challengeStatus,
                    'points'      => $challenge['points'],
                    'solved'      => $challenge['solved'],
                    'description' => $challenge['description'] ?? 'Không có mô tả',
                    'hints'       => $challenge['hints'] ?? 'Không có gợi ý',
                    'link'        => $challenge['link'] ?? '#',
                    'answer'      => $challenge['answer'] ?? 'Không có đáp án',
                ];
            }
        }

        return view('challenges.index', compact('userChallenges'));
    }

    public function checkAnswer(Request $request)
    {
        $firebaseUser = session('firebase_user');
        if (!$firebaseUser) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
        }

        $userUid = $firebaseUser['localId'];
        $challengeName = $request->input('name');
        $userAnswer = trim($request->input('answer'));

        // Lấy danh sách thử thách của người dùng
        $challengesRef = $this->database->getReference("users/{$userUid}/challenges");
        $challengesData = $challengesRef->getValue() ?? [];

        foreach ($challengesData as $category => &$challenges) {
            if (!is_array($challenges)) continue;

            foreach ($challenges as $challengeKey => &$challenge) {
                if (!is_array($challenge) || !isset($challenge['name'], $challenge['answer'])) {
                    continue;
                }

                if ($challenge['name'] === $challengeName) {
                    if (strcasecmp($challenge['answer'], $userAnswer) === 0) {
                        $challenge['solved'] = true;

                        // Cập nhật trạng thái trên Firebase
                        $this->database->getReference("users/{$userUid}/challenges/{$category}/{$challengeKey}/solved")
                            ->set(true);

                        return response()->json(['success' => true, 'message' => 'Chúc mừng! Bạn đã giải đúng thử thách.']);
                    } else {
                        return response()->json(['success' => false, 'message' => 'Câu trả lời chưa chính xác! Hãy thử lại.']);
                    }
                }
            }
        }

        return response()->json(['success' => false, 'message' => 'Không tìm thấy thử thách.']);
    }

}
