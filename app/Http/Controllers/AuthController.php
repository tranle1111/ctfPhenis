<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\Auth\EmailExists;
use Kreait\Firebase\Exception\Auth\InvalidPassword;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $auth;

    public function __construct()
    {
        $credentials = storage_path('firebase_ctfPhenis.json');
        $databaseUri = config('firebase.projects.app.database.url');
        $projectId = config('firebase.default');

        // Debugging statements
        // Log::info('Firebase Credentials: ' . $credentials);
        // Log::info('Firebase Database URI: ' . $databaseUri);
        // Log::info('Firebase Project ID: ' . $projectId);

        $factory = (new Factory)
            ->withServiceAccount($credentials)
            ->withDatabaseUri($databaseUri)
            ->withProjectId($projectId);

        $this->auth = $factory->createAuth();
    }

    // Hiển thị trang đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        try {
            $signInResult = $this->auth->signInWithEmailAndPassword($request->email, $request->password);
            session(['firebase_user' => $signInResult->data()]);
    
            Log::info('Đăng nhập thành công cho email: ' . $request->email);
    
            // Reset url.intended nếu không cần dùng
            session()->forget('url.intended');
            Log::info('Redirecting to: ' . session('url.intended', route('home')));
    
            return redirect()->intended(route('home'))->with('success', 'Đăng nhập thành công!');
            Log::info('Redirecting to: ' . session('url.intended', 'home'));

        } catch (UserNotFound | InvalidPassword $e) {
            Log::error('Email hoặc mật khẩu không đúng: ' . $request->email);
            return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng!']);
        } catch (\Exception $e) {
            Log::error('Lỗi khi đăng nhập: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Đã xảy ra lỗi, vui lòng thử lại sau!']);
        }
    }    

    // Hiển thị trang đăng ký
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    // Xử lý đăng ký
public function register(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    try {
        // Tạo người dùng mới trong Firebase Authentication
        $user = $this->auth->createUser([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Lấy UID của người dùng vừa tạo
        $uid = $user->uid;

        // Lấy tham chiếu tới Firebase Realtime Database
        $database = (new Factory)->withServiceAccount(storage_path('firebase_ctfPhenis.json'))
                                 ->withDatabaseUri(config('firebase.projects.app.database.url'))
                                 ->createDatabase();

        // Dữ liệu bạn muốn thêm vào Firebase
        $newUserData = [
            'email' => $request->email,
            'created_at' => now(),
            'challenges' => [
                'Reverse Engineering' => [
                    "1" => [
                        "name" => "TRANFORMATION",
                        "points" => 324,
                        "solved" => false,
                        "answer"=> "picoCTF{16_bits_inst34d_of_8_e141a0f7}",
                        "description" => "I wonder what this really is... enc ''.join([chr((ord(flag[i]) << 8) + ord(flag[i + 1])) for i in range(0, len(flag), 2)])",
                        "hints" => "1. The flag is in the format picoCTF{...}",
                        "link" => "https://drive.google.com/file/d/1yvG7dF8h4i3zphWGyqRr1LfCAVczH52l/view?usp=drive_link"
                    ],
                    "2" => [
                        "name" => "PACKER",
                        "points" => 500,  
                        "solved" => false,
                        "answer"=> "picoCTF{U9X_UnP4ck1N6_B1n4Ri3S_1a5a3f39}",
                        "description" =>  "Reverse this linux executable?",
                        "hints" =>  "1. What can we do to reduce the size of a binary after compiling it.",
                        "link" =>  "https://drive.google.com/file/d/1FHWugoGs9y-rEZxg-d3tewzfbRO6n5F9/view?usp=sharing"
                    ],
                    "3" => [
                        "name" => "SAFE OPENER",
                        "points" => 999,  
                        "solved" => false,
                        "answer"=> "picoCTF{pl3as3_l3t_m3_1nt0_th3_saf3}",
                        "description" =>  "Can you open this safe? I forgot the key to my safe but this program is supposed to help me with retrieving the lost key. Can you help me unlock my safe? Put the password you recover into the picoCTF flag format like: picoCTF{password}",
                        "hints" =>  "none",
                        "link" => "https://drive.google.com/file/d/1EVpm0T82pROMuyuALvbIfAGNBb20ILhi/view?usp=drive_link"
                    ],
                    "4" => [
                        "name" => "Picker I",
                        "points" => 999,  
                        "solved" => false,
                        "answer"=> "picoCTF{4_d14m0nd_1n_7h3_r0ugh_ce4b5d5b}",
                        "description" =>  "This service can provide you with a random number, but can it do anything else? Connect to the program with netcat: $ nc saturn.picoctf.net 64886",
                        "hints" =>  "1. Can you point the program to a function that does something useful for you?",
                        "link" => "https://drive.google.com/file/d/1G3LueFtSHU0z1eWncA41Wj8sxj1YaDSw/view?usp=sharing"
                    ],
                    "5" => [
                        "name" => "NO WAY OUT",
                        "points" => 1000,  
                        "solved" => false,
                        "answer"=> "picoCTF{WELCOME_TO_UNITY!!}",
                        "description" =>  "Put this flag in standard picoCTF format before submitting. If the flag was h1_1m_7h3_f14g submit picoCTF{h1_1m_7h3_f14g} to the platform. Windows game, Mac game Use password picoctf to unzip archives.",
                        "hints" =>  "none",
                        "link" => "https://drive.google.com/file/d/1mqYBXmwx9UbB2m6qA9zo3qsK00-2zVey/view?usp=sharing"
                    ],
                ],
                'Digital Forensics' => [
                    "1" => [
                        "name" => "CANYOUSEE",
                        "points" => 1000, 
                        "solved" => false,
                        "answer"=> "picoCTF{ME74D47A_HIDD3N_a6d...}",
                        "description" => "How about some hide and seek?",
                        "hints" => "1.How can you view the information about the picture? 2.If something isn't in the expected form, maybe it deserves attention?",
                        "link" => "https://drive.google.com/file/d/1sCpSqeNchQWCxMgFL4LHvCjDGCqQU1_c/view?usp=drive_link"
                    ],
                    "2" => [
                        "name" => "PCAPPOISONING",
                        "points" => 1000, 
                        "solved" => false,
                        "answer"=> "picoCTF{P64P_4N4L7S1S_SU55355FUL_4d72dfcc}",
                        "description" => "How about some hide and seek heh?",
                        "hints" => "none",
                        "link" => "https://drive.google.com/file/d/10AAvLam49QBpvE_ljPHDLYK65ihJ0dGE/view?usp=sharing"
                    ],
                    "3" => [
                        "name" => "SLEUTHKIT INTRO",
                        "points" => 1000, 
                        "solved" => false,
                        "answer"=> "picoCTF{mm15_f7w!}",
                        "description" => "Download the disk image and use mmls on it to find the size of the Linux partition. Connect to the remote checker service to check your answer and get the flag. Note: if you are using the webshell, download and extract the disk image into /tmp not your home directory. Download disk image Access checker program: nc saturn.picoctf.net 53234",
                        "hints" => "none",
                        "link" => "https://drive.google.com/file/d/1zdJkhkLf9gdSoSgKQrype3xrrDwMCqyr/view?usp=drive_link"
                    ],
                    "4" => [
                        "name" => "PACKETS PRIMER",
                        "points" => 1000, 
                        "solved" => false,
                        "answer"=> "picoCTF{p4ck37_5h4rk_ceccaa7f}",
                        "description" => "Download the packet capture file and use packet analysis software to find the flag.",
                        "hints" => "1. Wireshark, if you can install and use it, is probably the most beginner friendly packet analysis software product.",
                        "link" => "https://drive.google.com/file/d/1zdJkhkLf9gdSoSgKQrype3xrrDwMCqyr/view?usp=drive_link"
                    ],
                    "5" => [
                        "name" => "LOOKEY HERE",
                        "points" => 1000, 
                        "solved" => false,
                        "answer"=> "picoCTF{gr3p_15_@w3s0m3_4c479940}",
                        "description" => "Attackers have hidden information in a very large mass of data in the past, maybe they are still doing it.",
                        "hints" => "1. Download the file and search for the flag based on the known prefix.",
                        "link" => "https://drive.google.com/file/d/1omJUSyczGCUyCwiGqQOPE40SYZkROPb6/view?usp=drive_link"
                    ],
                    "6" => [
                        "name" => "ENHANCE!",
                        "points" => 1000,
                        "solved" => false,
                        "answer"=> "picoCTF{3nh4nc3d_aab729dd}",
                        "description" => "Download this image file and find the flag.",
                        "hints" => "none",
                        "link" => "https://drive.google.com/file/d/11NuV3r2H-UE5J-pDHq1fku4cn9wCpY4R/view?usp=drive_link"
                    ],
                ],
                'Crypto' => [
                    "1" => [
                        "name" => "INTERENCDEC",
                        "points" => 100, 
                        "solved" => false,
                        "answer"=> "picoCTF{caesar_d3cr9pt3d_b20...}",
                        "description" => "Can you get the real meaning from this file. Download the file here.",
                        "hints" => "none",
                        "link" => "https://drive.google.com/file/d/1WAGrUOS7YKExhlbgqVytuNA3_SLyqC0u/view?usp=sharing"
                    ],
                    "2" => [
                        "name" => "THE NUMBERS",
                        "points" => 100,  
                        "solved" => false,
                        "answer"=> "PICOCTF{THENUMBERSMASON}",
                        "description" => "The numbers... what do they mean?",
                        "hints" => "1. The flag is in the format picoCTF{...}",
                        "link" => "https://drive.google.com/file/d/1T9HSLHttMPRpN0OVEtUaLLKrrb62NAg_/view?usp=drive_link"
                    ],
                    "3" => [
                        "name" => "ROTATION",
                        "points" => 100,
                        "solved" => false,
                        "answer"=> "picoCTF{r0tat1on_d3crypt3d_25d7c61b}",
                        "description" => "You will find the flag after decrypting this file. Download the encrypted flag here.",
                        "hints" => "Sometimes rotation is right",
                        "link" => "https://drive.google.com/file/d/1_FBTDewwTIN1jTgYfIkM0e4DvoOOCntu/view?usp=drive_link"
                    ],
                    "4" => [
                        "name" => "VIGENERE",
                        "points" => 100,
                        "solved" => false,
                        "answer"=>"picoCTF{D0NT_US3_V1G3N3R3_C1PH3R_ae82272q}",
                        "description" => "Can you decrypt this message? Decrypt this message using this key \"CYLAB\" .",
                        "hints" => "1. https://en.wikipedia.org/wiki/Vigen%C3%A8re_cipher",
                        "link" => "https://drive.google.com/file/d/1FFLxmw7qA8tHm7KBTjheZjPDaUNGXp_x/view?usp=drive_link"
                    ],
                    "5" => [
                        "name" => "Sum-O-Primes",
                        "points" => 100,
                        "solved" => false,
                        "answer"=> "picoCTF{3921def5}",
                        "description" => "We have so much faith in RSA we give you not just the product of the primes, but their sum as well!",
                        "hints" => "I love squares :)",
                        "link" => "https://drive.google.com/file/d/1_nWZDKj5UiyIuASnGe6tLLK68Vr6MxPV/view?usp=drive_link"
                    ],
                ],
                'Web' => [
                    "1" => [
                        "name" => "LOCAL AUTHORITY",
                        "points" => 1000, 
                        "solved" => false,
                        "answer"=> "picoCTF{j5_15_7r4n5p4r3n7_05df90c8}",
                        "description" => "Can you get the flag? Go to this website and see what you can discover.",
                        "hints" => "1. How is the password checked on this website?",
                        "link" => "http://saturn.picoctf.net:59922/"
                    ],
                    "2" => [
                        "name" => "INSPECT HTML",
                        "points" => 1000, 
                        "solved" => false,
                        "answer"=> "picoCTF{1n5p3t0r_0f_h7ml_1fd8425b}",
                        "description" => "Can you get the flag? Go to this website and see what you can discover.",
                        "hints" => "1. What is the web inspector in web browsers?",
                        "link" => "http://saturn.picoctf.net:55253/"
                    ],
                    "3" => [
                        "name" => "MATCH THE REGEX",
                        "points" => 1000, 
                        "solved" => false,
                        "answer"=> "picoCTF{succ3ssfully_matchtheregex_08c310c6}",
                        "description" => "How about trying to match a regular expression. The website is running here.",
                        "hints" => "1. Access the webpage and try to match the regular expression associated with the text field",
                        "link" => "http://saturn.picoctf.net:57015/"
                    ],
                    "4" => [
                        "name" => "SOAP",
                        "points" => 1000, 
                        "solved" => false,
                        "answer"=> "picoCTF{XML_3xtern@l_3nt1t1ty_e5f02dbf}",
                        "description" => "The web project was rushed and no security assessment was done. Can you read the /etc/passwd file?Web Portal",
                        "hints" => "1. XML external entity Injection",
                        "link" => "http://saturn.picoctf.net:59613/"
                    ],
                    "5" => [
                        "name" => "BITHUG",
                        "points" => 1000,  
                        "solved" => false,
                        "answer"=> "picoCTF{good_job_at_gitting_good}",
                        "description" => "Code management software is way too bloated. Try our new lightweight solution, BitHug. Source: distribution.tgz",
                        "hints" =>  "1. Every user gets their own target repository to attack called _/.git, but no permission to read it",
                        "link" => "https://drive.google.com/file/d/1y3qR8lVVOg0YUEV5pBL36-gNx8LCjORj/view?usp=drive_link"
                    ],
                    "6" => [
                        "name" => "ELEMENTS",
                        "points" => 1000, 
                        "solved" => false,
                        "answer"=> "picoCTF{little_alchemy_was_the_0g_game_does_anyone_rememb3r_9889fd4a}",
                        "description" => "Insert Standard Web Challenge Here. Source code: elements.tar.gz.  Additional details will be available after launching your challenge instance.",
                        "hints" => "none",
                        "link" => "https://drive.google.com/file/d/1kefQrMRdtqb5CCNasHfQxsZxR8_p8FwU/view?usp=sharing"
                    ],
                ],
                'Pwn' => [
                    "1" => [
                        "name" => "HEAP 0",
                        "points" => 750, 
                        "solved" => false,
                        "answer"=> "picoCTF{my_first_heap_overflow_0c47...}",
                        "description" => "Are overflows just a stack concern? Download the binary and code here. Connect with the challenge instance here: nc tethys.picoctf.net 57398",
                        "hints" => "1. What part of the heap do you have control over and how far is it from the safe_var?",
                        "link" => "https://drive.google.com/file/d/1TNW5RcJAAzCeCbFVed-5hFViC13dtdnT/view?usp=drive_link"
                    ],
                    "2" => [
                        "name" => "HEAP 1",
                        "points" => 750, 
                        "solved" => false,
                        "answer"=> "picoCTF{starting_to_get_the_hang_c58...}",
                        "description" => "Can you control your overflow? Download the binary and codehere. Connect with the challenge instance here: nc tethys.picoctf.net 54845",
                        "hints" => "1. How can you tell where safe_var starts?",
                        "link" => "https://drive.google.com/file/d/1QWnQfd-NB6foaBjdwClJExHxalFuDmHJ/view?usp=drive_link"
                    ],
                    "3" => [
                        "name" => "LOCAL TARGET",
                        "points" => 750,
                        "solved" => false,
                        "answer"=> "picoCTF{l0c4l5_1n_5c0p...8441a}",
                        "description" => "Smash the stack Can you  overflow the buffer and modify the other local variable? The program is available here. You can view source here. And connect with it using: nc saturn.picoctf.net 61415",
                        "hints" => "1. Do anything you can to change num. 2.When you change num, view the value as hexadecimal.",
                        "link" => "https://drive.google.com/file/d/1t1u6MzN9cljLRFUUrX1GIrGHXpKYdypr/view?usp=drive_link"
                    ],
                    "4" => [
                        "name" => "TWO-SUM",
                        "points" => 750, 
                        "solved" => false,
                        "answer"=> "picoCTF{Tw0_Sum_Integer_Bu773R_0v3rfl0w_e06700c0}",
                        "description" => "Can you solve this? What two positive numbers can make this possible: n1 > n1 + n2 OR n2 > n1 + n2 Enter them here nc saturn.picoctf.net 59099. Source",
                        "hints" => "1. Integer overflow. 2.Not necessarily a math problem.",
                        "link" => "https://drive.google.com/file/d/1Te2XoD0A6Vr607z7Q68R9V-mmkjn6t6-/view?usp=drive_link"
                    ],
                    "5" => [
                        "name" => "ROPFU",
                        "points" => 750, 
                        "solved" => false,
                        "answer"=> "picoCTF{5n47ch_7h3_5h311_e81af635}",
                        "description" => "What's ROP? Can you exploit the following program to get the flag? Download source. nc saturn.picoctf.net 49850",
                        "hints" => "1. This is a classic ROP to get a shell",
                        "link" => "https://drive.google.com/file/d/1OKJqWEp8fiKLdiYDArBJvmV9cYqIU_7V/view?usp=drive_link"
                    ],
                    "6" => [
                        "name" => "FUNCTION OVERWRITE",
                        "points" => 750, 
                        "solved" => false,
                        "answer"=> "picoCTF{0v3rwrit1ng_P01nt3rs_529bfb38}",
                        "description" => "Story telling class 2/2 You can point to all kinds of things in C. Checkout our function pointers demo program. You can view source here. And connect with it using nc saturn.picoctf.net 54586",
                        "hints" => "1. Don't be so negative",
                        "link" => "https://drive.google.com/file/d/1KHglTqfcDJH0RfunjuU4yvVxz22k7Ao6/view?usp=drive_link"
                    ],
                ],
                'Misc' => [
                    "1" => [
                        "name" => "QR Code",
                        "points" => 600, 
                        "solved" => false,
                        "answer"=> "n0_body_f0rget_qr_code",
                        "description" => "Do you remember something known as QR Code? Simple. Here for you :",
                        "hints" => "none",
                        "link" => "https://drive.google.com/file/d/1CcEUtxZGDIFMsphTa8PhrrEv3UeaTtgL/view?usp=drive_link"
                    ],
                    "2" => [
                        "name" => "What could this be?",
                        "points" => 600,
                        "solved" => false,
                        "answer"=> "flag{5uch_j4v4_5crip7_much_w0w}",
                        "description" => "It seems like someone really likes special characters… Or could it mean something more?",
                        "hints" => "none",
                        "link" => "https://drive.google.com/file/d/1dxybvIH4UO6mNX5Ddm1U0iDQd-EFCU0S/view?usp=drive_link"
                    ],
                    "3" => [
                        "name" => "Rock Paper Scissors",
                        "points" => 600,
                        "solved" => false,
                        "answer"=> "CTFlearn{r0ck_p4per_skiss0rs}",
                        "description" => "Do you think you're lucky enough to win 10 games of Rock Paper Scissors in a row? Connect to the server and find out. nc 138.197.193.132 5001",
                        "hints" => "none",
                        "link" => "none"
                    ],
                    "4" => [
                        "name" => "Get Into Command Mission",
                        "points" => 600,
                        "solved" => false,
                        "answer"=> "Arm0uR_pPTi4",
                        "description" => "Back into the mission. Since we struck one fugitive successfully, we found an ID Card named ALDI and a flashdisk which contain a program. Unfortunately, it was locked. Note: You do NOT need a specific operating system to solve this question.",
                        "hints" => "none",
                        "link" => "https://drive.google.com/file/d/1s76l00MA1vF-931fC36doYEGCTX0E7Xc/view?usp=drive_link"
                    ],
                ]
            ],
        ];

        // Tạo node cho người dùng trong Firebase Realtime Database
        $database->getReference('users/' . $uid)
                 ->set($newUserData);

        // Gửi email xác nhận
        $this->auth->sendEmailVerificationLink($request->email);

        // Thêm thông báo ghi log
        Log::info('Tạo tài khoản thành công cho email: ' . $request->email);

        return redirect()->route('login')->with('success', 'Tạo tài khoản thành công! Hãy kiểm tra email để xác nhận tài khoản.');
    } catch (EmailExists $e) {
        Log::error('Email này đã được đăng ký: ' . $request->email);
        return back()->withErrors(['email' => 'Email này đã được đăng ký!']);
    } catch (\Exception $e) {
        Log::error('Lỗi khi tạo tài khoản: ' . $e->getMessage());
        return back()->withErrors(['email' => 'Đã xảy ra lỗi, vui lòng thử lại sau!']);
    }
}


    // Xử lý đăng xuất
    public function logout()
    {
        session()->forget('firebase_user');
        return redirect()->route('login')->with('success', 'Bạn đã đăng xuất!');
    }

    // Hiển thị trang quên mật khẩu
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Xử lý gửi email đặt lại mật khẩu
    public function sendResetPasswordEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $this->auth->sendPasswordResetLink($request->email);

            // Ghi log
            Log::info('Email đặt lại mật khẩu đã được gửi đến: ' . $request->email);

            return back()->with('success', 'Liên kết đặt lại mật khẩu đã được gửi, vui lòng kiểm tra email của bạn!');
        } catch (UserNotFound $e) {
            Log::error('Không tìm thấy email trong hệ thống: ' . $request->email);
            return back()->withErrors(['email' => 'Không tìm thấy email này trong hệ thống!']);
        } catch (\Exception $e) {
            Log::error('Lỗi khi gửi email đặt lại mật khẩu: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Đã xảy ra lỗi, vui lòng thử lại sau!']);
        }
    }

}
