<?php


namespace App\Tests\functional;

use App\Tests\FunctionalTester;
use Codeception\Util\Locator;

class readBlogCest
{
    // tests
    public function viewListAndLink(FunctionalTester $I)
    {
        $I->amOnPage('/en/blog/');
        $I->seeElement('article');
        $I->seeLink('Blog Posts RSS');
        $I->seeElement("a[href^='/en/blog/posts/']");
        $I->click(Locator::elementAt("a[href^='/en/blog/posts/']", 1));
        $I->canSeeInCurrentUrl('/en/blog/posts/');
    }

    public function notFound(FunctionalTester $I)
    {
        $I->amOnPage('/en/blog/posts/404-not-found');
        $I->canSeeResponseCodeIs(404);
        $I->see("object not found");
    }
}
