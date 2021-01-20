<?php
namespace App\Database;
use CodeIgniter\Test\CIUnitTestCase;

class RapperTest extends CIUnitTestCase
{
    protected $refresh  = true;
    protected $seed     = 'RapperSeeder';
    protected $basePath = '../app/Database';
    protected $namespace = '../app/Database';
    protected $benchmark;

    public function setUp(): void
    {
        $this->benchmark = \Config\Services::timer();
        $this->benchmark->start('test rappers');
        parent::setUp();
    }
    /** @test */
    public function testRappers(){
        $seeder = \Config\Database::seeder();
        $seeder->call('RappersSeeder');
    }
    public function tearDown(): void
    {
        $this->benchmark->stop('test rappers');
        $file = './writable/uploads/benchmark.text';
        $person = $this->benchmark->getElapsedTime('test rappers')." ".date('m/d/Y h:i:s a', time());
        ;
        file_put_contents($file, $person, FILE_APPEND | LOCK_EX);
//        echo $this->benchmark->getElapsedTime('test rappers');
        parent::tearDown();
    }

}