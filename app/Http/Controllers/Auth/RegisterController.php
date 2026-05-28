<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.email' => 'Lütfen geçerli ve aktif bir e-posta adresi girin.',
            'email.unique' => 'Bu e-posta adresi zaten kullanımda.',
            'email.required' => 'E-posta alanı zorunludur.',
            'name.required' => 'Ad Soyad alanı zorunludur.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az 8 karakter olmalıdır.',
            'password.confirmed' => 'Şifre tekrarları eşleşmiyor.',
        ]);
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
}
