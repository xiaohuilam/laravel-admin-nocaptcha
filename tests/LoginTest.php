<?php

namespace LaravelAdminExt\Nocaptcha\Tests;

use LaravelAdminExt\Nocaptcha\Tests\AbstractTestCase;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use Illuminate\Support\Str;

class LoginTest extends AbstractTestCase
{
    protected $token = null;

    public function setUp()
    {
        parent::setUp();
        $this->token = Str::random();
        $this->withSession(['_token', $this->token]);
    }

    /**
     * 断言登录页是否加载了recaptcha js
     */
    public function testForm()
    {
        $this->get('/admin/auth/login')
            ->see('/recaptcha/api.js')
            ->see(config('recaptchav3.sitekey'))
            ->dontSee(trans('validation.recaptchav3'));
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
     * 禁用断言
     */
    public function testDisable()
    {
        if (file_exists($routes = admin_path('routes.php'))) {
            require $routes;
        }
        $this->visit('/admin/auth/login')
            ->storeInput('username', 'admin')
            ->storeInput('password', 'admin')
            ->dontSee('g-recaptcha-response')
            ->submitForm(trans('Login'));

        $this->dontSee(trans('validation.required', ['attribute' => 'g-recaptcha-response']));
    }

    /**
     * 无效token断言
     */
    public function testBadToken()
    {
        $this->visit('/admin/auth/login');

        $challenge = Str::random();
        $data = [
            'username' => 'admin',
            'password' => 'admin',
            'g-recaptcha-response' => $challenge,
            '_token' => $this->token,
        ];

        RecaptchaV3::shouldReceive('verify')
            ->with($challenge, 'login')
            ->once()
            ->andReturn(false);

        $this->post('/admin/auth/login', $data)
            ->assertEquals(302, $this->response->getStatusCode());

        /**
         * @var \Symfony\Component\HttpFoundation\ResponseHeaderBag $headers
         */
        $headers = $this->response->headers;
        $location = $headers->get('location');

        $this->assertTrue(Str::endsWith($location, '/admin/auth/login'));
    }

    /**
     * 有效token断言
     */
    public function testValidToken()
    {
        $this->visit('/admin/auth/login');

        $challenge = Str::random();
        $data = [
            'username' => 'admin',
            'password' => 'admin',
            'g-recaptcha-response' => $challenge,
            '_token' => $this->token,
        ];

        RecaptchaV3::shouldReceive('verify')
            ->with($challenge, 'login')
            ->once()
            ->andReturn(0.4);

        $this->post('/admin/auth/login', $data)
            ->assertEquals(302, $this->response->getStatusCode());

        /**
         * @var \Symfony\Component\HttpFoundation\ResponseHeaderBag $headers
         */
        $headers = $this->response->headers;
        $location = $headers->get('location');

        $this->assertTrue(Str::endsWith($location, '/admin'));
    }
}
