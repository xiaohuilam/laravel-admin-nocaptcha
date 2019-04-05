<?php

namespace LaravelAdminExt\Nocaptcha\Controllers;

use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseAuthController
{
    /**
     * {@inheritDoc}
     */
    public function getLogin()
    {
        if ($this->guard()->check()) {
            return redirect($this->redirectPath());
        }

        return view('laravel-admin-nocaptcha::login');
    }

    /**
     * {@inheritDoc}
     */
    public function postLogin(Request $request)
    {
        $remember = $request->get('remember', false);

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($request->all(),[
            $this->username()   => 'required',
            'password'          => 'required',
            'g-recaptcha-response' => 'required|recaptchav3:login,0.3'
        ]);

        $credentials = $request->only([$this->username(), 'password']);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        if ($this->guard()->attempt($credentials, $remember)) {
            return $this->sendLoginResponse($request);
        }

        return back()->withInput()->withErrors([
            $this->username() => $this->getFailedLoginMessage(),
        ]);
    }
}
