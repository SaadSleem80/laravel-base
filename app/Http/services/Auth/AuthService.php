<?php 

namespace App\Http\Services\Auth;

use App\Http\Resources\User\UserResource;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    private $model;
    
    public function __construct(User $model) 
    {
        $this->model = $model;
    }

    public function login(array $data): array
    {
        // Check if the user exists
        if(!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) { 
            throw new \Exception('Invalid credentials');
        }

        // Get the user
        $user = Auth::user();

        // Create a token
        $token = $user->createToken('authToken')->plainTextToken;

        return [ 
            'user' => new UserResource($user),
            'token' => $token
        ];
    }

    public function register(array $data)
    { 
        return $this->model->create($data);
    }

    public function forgetPassword(array $data): void
    {
        $user = $this->model->where('email', $data['email'])->first();

        if (!$user) 
            throw new \Exception(__('response.not_found'));

        // Logout the user if they are logged in
        $user->tokens()->delete();

        // Generate a password reset code
        $resetCode = rand(100000, 999999);

        // Send the reset code to the user's email
        Mail::to($user->email)->send( new ResetPassword($user->name, $resetCode));

        // Store the reset code in the user's record
        $user->update([
            'password_reset_code' => $resetCode,
            'password_reset_expires_at' => now()->addMinutes(30),
        ]);
    }

    public function resetPassword(array $data): void
    { 
        $user = $this->model->where('email', $data['email'])->first();

        if (!$user) 
            throw new \Exception(__('response.not_found'));
        

        // Check if the reset code is valid
        if ($user->password_reset_code !== $data['code'] || now()->greaterThan($user->password_reset_expires_at))
            throw new \Exception(__('response.invalid_reset_code'));

        // Update the user's password
        $user->update([
            'password' => bcrypt($data['password']),
            'password_reset_code' => null,
            'password_reset_expires_at' => null,
        ]);
    }

    public function logout(): void
    {
        Auth::user()->tokens()->delete();
    }
}