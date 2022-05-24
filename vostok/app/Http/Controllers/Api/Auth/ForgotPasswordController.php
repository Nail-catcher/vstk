<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\NotificationChannels\SmsRu\SmsRuChannel;
use App\Notifications\Api\SendCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */


    /**
     * Send a reset link to the given user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetCodeEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentialsEmail($request)
        );


        $code = random_int(1000, 9999);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $code,
            'created_at' => now()
        ]);
        Notification::route('mail', $request->email)
            ->notify(new SendCode($code));
        return $this->sendResetCodeResponse($request, 'passwords.sent_code', $code);
    }

    /**
     * Validate the email for the given request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * Get the needed authentication credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentialsEmail(Request $request): array
    {
        return $request->only('email');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $response
     * @param int $code
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetCodeResponse(Request $request, string $response, int $code)
    {
        return new JsonResponse(['message' => trans($response), 'code' => $code], 200);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetCodePhone(Request $request)
    {
        $this->validatePhone($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
//        $response = $this->broker()->sendResetLink(
//            $this->credentialsEmail($request)
//        );

        $code = random_int(1000, 9999);
        DB::table('password_resets')->insert([
            'email' => $request->phone,
            'token' => $code,
            'created_at' => now()
        ]);
        Notification::route(SmsRuChannel::class, preg_replace('/\D/', '', $request->phone))
            ->notify(new SendCode($code));
        return $this->sendResetCodeResponse($request, 'passwords.sent_code', $code);
    }

    /**
     * Validate the phone for the given request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function validatePhone(Request $request)
    {
        $request->validate(['phone' => 'required|phone:AUTO']);
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $response
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }
}
