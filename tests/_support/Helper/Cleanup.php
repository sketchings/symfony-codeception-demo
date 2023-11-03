<?php

namespace App\Tests\Helper;

use Codeception\Exception\ModuleException;
use Codeception\TestInterface;

trait Cleanup
{
    public function _after(TestInterface $test): void
    {
        $this->runSqlQuery("DELETE FROM symfony_demo_post WHERE LOWER(title) like '%test%'");
    }

    /**
     * @param string $query
     * @return array|false
     * @throws ModuleException
     */
    public function runSqlQuery(string $query): array|false
    {
        $dbh = $this->getModule("Db")->_getDbh();
        $result = $dbh->query($query);
        return $result->fetchAll();
    }

}