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
class AcceptanceJsTester extends \Codeception\Actor
{
    use _generated\AcceptanceJsTesterActions;
    use Helper\BaseTester;

    /**
     * @Then I should be able to add an article
     */
    public function iShouldBeAbleToAddAnArticle()
    {
        $this->amOnPage('/en/admin/post/');

        $this->seeLink('Create a new post');
        $this->click('Create a new post');
        $this->amOnPage('/en/admin/post/new');
        $this->waitForElement('#post_title');
//        $this->canSeeInCurrentUrl('/new');
        $this->fillField('#post_title', 'test title');
        $this->fillField('#post_summary', 'test summary');
        $this->fillField('#post_content', 'Test my content');
        // javascript adds tags which is looking for a keypress
        $this->fillField('.tt-input', 'test');
        $this->pressKey('.tt-input',WebDriverKeys::ENTER);
        $this->click('Create post');

        $this->amOnPage('/en/blog/');
        $this->see('test title', 'article');
        $this->see('test', '.post-tags');
    }

    /**
     * @Then I should be able to delete an article
     */
    public function iShouldBeAbleToDeleteAnArticle()
    {
        $id = $this->haveInDatabase('symfony_demo_post', [
            'author_id' => 1,
            'title' => 'test delete',
            'slug' => 'test-delete',
            'summary' => 'test delete summary',
            'content' => 'test delete content',
            'published_at' => date('Y-m-d H:i:s'),
        ]);
        $this->waitForElementNotVisible("a[contains(@href, '/en/admin/post/$id')]");
        $this->amOnPage('/en/admin/post/' . $id);
        $this->see('test delete', 'h1');
        $this->click('button[type=submit]', '#delete-form');

        $this->amOnPage('/en/admin/post/');
        $this->waitForElementNotVisible("a[contains(@href, '/en/admin/post/$id')]");
    }
}
