<?php

use Core\Database\Generator;
use App\Models\User;
use Core\Valid\Hash;

return new class implements Generator
{
    /**
     * Generate nilai database
     *
     * @return void
     */
    public function run()
    {
        $email = env('ADMIN_EMAIL', 'admin@studio.com');
        $name = env('ADMIN_NAME', 'Studio Undangan');
        $password = env('ADMIN_PASSWORD', 'ChangeMe123!');

        $user = User::find($email, 'email');

        if (!$user->exist()) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password)
            ]);
        }

        $user->fill([
            'name' => $name,
            'is_filter' => true,
            'is_active' => true,
            'is_confetti_animation' => true,
            'tz' => 'Asia/Jakarta',
            'access_key' => Hash::rand(25),
        ])->save();
    }
};
