<?php
namespace App\Tests\Helper;

trait BaseTester
{
    /**
     * @Given I am logged in as :user
     * @Given /^I am logged in as (\w+)$/
     */
    public function iAmLoggedIn(string $user): void
    {
        if ($user == 'admin') {
            $username = 'jane_admin';
        } elseif ($user == 'user') {
            $username = 'john_user';
        }
        $this->amOnPage('/en/login');
        $this->see('Secure Sign in', 'legend');
        $this->fillField('#username', $username);
        $this->fillField('#password', 'kitten');
        $this->click('Sign in');
        $this->seeElement('#user');
    }

    /**
     * @Given I am not logged in
     */
    public function iAmNotLoggedIn(): void
    {
        $this->amOnPage('/logout');
        $this->amOnPage('/en/blog/');
        $this->cantSeeElement('#user');
    }
}
