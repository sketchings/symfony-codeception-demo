<?php
namespace App\Tests;

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
    use Helper\BaseTester;

    /**
     * @Then I should be able to add an article
     */
    public function iShouldBeAbleToAddAnArticle()
    {
        $this->amOnPage('/en/admin/post/');

        $this->click('Create a new post');
        $this->fillField('#post_title', 'test title');
        $this->fillField('#post_summary', 'test summary');
        $this->fillField('#post_content', 'Test my content');
        $this->click('Create post');

        $this->amOnPage('/en/blog/');
        $this->see('test title', 'article');
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
        $this->seeInDatabase('symfony_demo_post', ['id' => $id]);
        $this->amOnPage('/en/admin/post/' . $id);
        $this->see('test delete', 'h1');
        $this->submitForm('#delete-form', []);

        $this->amOnPage('/en/admin/post/');
        $this->cantSee('test delete', 'td');
    }

    /**
     * @When I try to view :page
     */
    public function iTryToView(string $page): void
    {
        $this->amOnPage($page);
    }

    /**
     * @Then I should be redirected to :page
     */
    public function iShouldBeRedirected(string $page): void
    {
        $this->seeInCurrentUrl($page);
    }

    /**
     * @Then I should receive error :error
     */
    public function iShouldReceiveErrorAccessDenied(string $error): void
    {
        $this->see($error);
    }
}
