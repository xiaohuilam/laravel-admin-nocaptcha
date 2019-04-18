<?php

namespace LaravelAdminExt\Nocaptcha\Tests;

use LaravelAdminExt\Nocaptcha\Tests\AbstractTestCase;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

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

    /**
     * 空token断言
     */
    public function testEmpty()
    {
        $this->visit('/admin/auth/login')
            ->storeInput('username', 'admin')
            ->storeInput('password', 'admin')
            ->storeInput('g-recaptcha-response', null)
            ->submitForm(trans('Login'));

        $this->see(trans('validation.required', ['attribute' => 'g-recaptcha-response']));
    }

    /**
     * 无效token断言
     */
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
        $this->see(trans('validation.recaptchav3'));
    }

    /**
     * 有效token断言
     */
    public function testValidToken()
    {
        $html = $this->visit('/admin/auth/login')->response->content();
        $html = explode('name="_token" value="', $html)[1];
        $html = explode('"', $html, 2)[0];
        $token = $html;
        $data = [
            'username' => 'admin',
            'password' => 'admin',
            'g-recaptcha-response' => 'valid_token',
            '_token' => $token
        ];

        RecaptchaV3::shouldReceive('verify')
            ->with('valid_token', 'login')
            ->once()
            ->andReturn(0.4);

        $this->post('/admin/auth/login', $data);
        $this->assertEquals(302, $this->response->getStatusCode());

        /**
         * @var \Symfony\Component\HttpFoundation\ResponseHeaderBag $headers
         */
        $headers = $this->response->headers;
        $location = $headers->get('location');

        $this->assertTrue(str_contains($location, '/admin'));
        $this->assertFalse(str_contains($location, '/login'));

        $this->visit($location);
        $this->assertEquals(200, $this->response->getStatusCode());
    }
}
