<?php
namespace App\Tests;

use Facebook\WebDriver\WebDriverKeys;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

   /**
    * Define custom actions here
    */

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
        $this->amOnPage('/en/blog/');
        $this->seeElementInDOM('#user');
    }

    /**
     * @Given I am not logged in
     */
    public function iAmNotLoggedIn(): void
    {
        $this->amOnPage('/en/login');
        $this->amOnPage('/en/blog/');
        $this->cantSeeElementInDOM('#user');
    }

    /**
     * @Then I should be able to add an article
     */
    public function iShouldBeAbleToAddAnArticle()
    {
        $this->amOnPage('/en/blog/');
        $this->see('lorem', '.post-tags');

        $this->amOnPage('/en/admin/post/');

        $this->click('Create a new post');
        $this->canSeeInCurrentUrl('/new');
        $this->fillField('#post_title', 'title test');
        $this->fillField('#post_summary', 'summary test');
        $this->fillField('#post_content', 'Test my content');
        // javascript adds tags which is looking for a keypress
        $this->fillField('.tt-input', 'test');
        $this->pressKey('.tt-input',WebDriverKeys::ENTER);
        $this->click('Create post');

        $this->amOnPage('/en/blog/');
        $this->see('title test', 'article');
        $this->see('test', '.post-tags');
    }

    /**
     * @Then I should be able to delete an article
     */
    public function iShouldBeAbleToDeleteAnArticle()
    {
        $id = $this->haveInDatabase('symfony_demo_post', [
            'author_id' => 1,
            'title' => 'delete test',
            'slug' => 'delete-test',
            'summary' => 'delete test summary',
            'content' => 'delete test content',
            'published_at' => date('Y-m-d H:i:s'),
        ]);
        $this->waitForElementNotVisible("a[contains(@href, '/en/admin/post/$id')]");
        $this->amOnPage('/en/admin/post/' . $id);
        $this->see('delete test', 'h1');
        $this->click('button[type=submit]', '#delete-form');

        $this->amOnPage('/en/admin/post/');
        $this->waitForElementNotVisible("a[contains(@href, '/en/admin/post/$id')]");
    }
}
