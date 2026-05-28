<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Kayıt Kontrolcüsü (Register Controller)
    |--------------------------------------------------------------------------
    |
    | Bu kontrolcü yeni kullanıcıların kaydolmasını, doğrulanmasını ve
    | oluşturulmasını yönetir. Varsayılan olarak bu kontrolcü, herhangi bir
    | ek kod gerektirmeden bu işlevi sağlamak için bir trait kullanır.
    |
    */

    use RegistersUsers;

    /**
     * Uygulama için kayıt talebini işler.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(\Illuminate\Http\Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());
        event(new \Illuminate\Auth\Events\Registered($user));

        \App\Models\ActivityLog::log('register', "{$user->name} ({$user->email}) topluluğa katıldı ve yeni hesap oluşturdu.", $user->id);

        // Kullanıcıyı doğrudan kayıttan sonra giriş yaptırmak yerine giriş sayfasına yönlendir
        return redirect()->route('login')->with('success', 'Kayıt işlemi başarılı. Lütfen giriş yapın.');
    }

    /**
     * Kayıttan sonra kullanıcıların yönlendirileceği yer.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Yeni bir kontrolcü örneği oluşturur.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Gelen kayıt talebi için bir doğrulayıcı alır.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $email = $data['email'] ?? '';
        $isGmail = str_ends_with(strtolower($email), '@gmail.com');

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'verification_code' => $isGmail ? ['required', 'string', 'size:6'] : ['nullable'],
        ], [
            'email.email' => 'Lütfen geçerli ve aktif bir e-posta adresi girin.',
            'email.unique' => 'Bu e-posta adresi zaten kullanımda.',
            'email.required' => 'E-posta alanı zorunludur.',
            'name.required' => 'Ad Soyad alanı zorunludur.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az 8 karakter olmalıdır.',
            'password.confirmed' => 'Şifre tekrarları eşleşmiyor.',
            'verification_code.required' => 'E-posta doğrulama kodu zorunludur.',
            'verification_code.size' => 'Doğrulama kodu 6 haneli olmalıdır.',
        ])->after(function ($validator) use ($isGmail, $data, $email) {
            if ($isGmail) {
                $sessionEmail = session('register_email');
                $sessionCode = session('register_code');
                $expiresAt = session('register_code_expires_at');
                $enteredCode = $data['verification_code'] ?? '';

                if (!$sessionCode || !$sessionEmail || $sessionEmail !== $email) {
                    $validator->errors()->add('verification_code', 'Lütfen önce doğrulama kodu isteyin.');
                } elseif (now()->greaterThan($expiresAt)) {
                    $validator->errors()->add('verification_code', 'Doğrulama kodunun süresi dolmuş. Lütfen yeni bir kod isteyin.');
                } elseif ((string)$sessionCode !== (string)$enteredCode) {
                    $validator->errors()->add('verification_code', 'Girdiğiniz doğrulama kodu geçersiz.');
                }
            }
        });
    }

    /**
     * Geçerli bir kayıttan sonra yeni bir kullanıcı örneği oluşturur.
     *
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * E-posta doğrulama kodu gönderir.
     */
    public function sendVerificationCode(\Illuminate\Http\Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
        ], [
            'email.email' => 'Lütfen geçerli ve aktif bir e-posta adresi girin.',
            'email.unique' => 'Bu e-posta adresi zaten kullanımda.',
            'email.required' => 'E-posta alanı zorunludur.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first('email')
            ], 422);
        }

        $email = $request->input('email');
        $code = rand(100000, 999999);

        session([
            'register_email' => $email,
            'register_code' => $code,
            'register_code_expires_at' => now()->addMinutes(10)
        ]);

        try {
            Mail::raw("CineScope kayıt işleminizi tamamlamak için doğrulama kodunuz: {$code}\n\nBu kod 10 dakika boyunca geçerlidir.", function ($message) use ($email) {
                $message->to($email)
                    ->subject("CineScope E-posta Doğrulama Kodu");
            });

            return response()->json([
                'success' => true,
                'message' => 'Doğrulama kodu e-posta adresinize gönderildi.'
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Mail sending failed: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Doğrulama kodu gönderilemedi. Lütfen daha sonra tekrar deneyin.'
            ], 500);
        }
    }
}
