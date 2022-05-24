<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param mixed $user
     * @param array $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'firstname' => ['required', 'string', 'max:255'],
            'middlename' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['required', 'phone:AUTO,RU,KZ', 'max:255', Rule::unique('users', 'phone')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'max:1024'],
            'photo_type' => ['nullable', 'string'],
            'photo_body' => ['nullable', 'base64image', 'base64max:5128'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if (isset($input['photo_body'])) {
            $user->deleteProfilePhoto();
            $image_name = Str::random(64) . '.' . Str::after($input['photo_type'], '/');
            $image_path = "profile-photos/{$image_name}";
            Storage::disk('public')->put(
                $image_path,
                base64_decode($input['photo_body'])
            );
            $user->forceFill([
                'profile_photo_path' => $image_path
            ])->save();
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'firstname' => $input['firstname'],
                'middlename' => $input['middlename'],
                'lastname' => $input['lastname'],
                'email' => $input['email'],
                'phone' => $input['phone'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param mixed $user
     * @param array $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'firstname' => $input['firstname'],
            'middlename' => $input['middlename'],
            'lastname' => $input['lastname'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
