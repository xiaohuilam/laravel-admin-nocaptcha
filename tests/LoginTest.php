<?php

namespace LaravelAdminExt\Nocaptcha\Tests;
use LaravelAdminExt\Nocaptcha\Tests\AbstractTestCase;

class LoginTest extends AbstractTestCase
{
    /**
     * 断言登录页是否加载了recaptcha js
     */
    public function testForm()
    {
        $this->get('/admin/auth/login');
        $this->see('/recaptcha/api.js');
        $this->see(config('recaptchav3.sitekey'));
        $this->dontSee(trans('validation.recaptchav3'));
    }

    public function testEmpty()
    {
        $this->visit('/admin/auth/login')
            ->storeInput('username', 'admin')
            ->storeInput('password', 'admin')
            ->storeInput('g-recaptcha-response', null)
            ->submitForm(trans('Login'));
        $this->see('The g-recaptcha-response field is required.');
    }

    public function testBadToken()
    {
        $html = $this->visit('/admin/auth/login')->response->content();
        $html = explode('name="_token" value="', $html)[1];
        $html = explode('"', $html, 2)[0];
        $token = $html;
        $data = [
            'username' => 'admin',
            'password' => 'admin',
            'g-recaptcha-response' => 'invalid_token',
            '_token' => $token
        ];
        $this->post('/admin/auth/login', $data);

        $this->assertEquals(302, $this->response->getStatusCode());

        $this->get('/admin/auth/login');
        $this->see(trans( 'validation.recaptchav3'));
    }
}
