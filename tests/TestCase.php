<?php

namespace Yizen\Chat\Tests;

require __DIR__ . '/../database/migrations/create_chat_tables.php';

use CreateChatTables;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Yizen\Chat\User;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected $conversation;
    protected $prefix = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'testbench']);
        $this->withFactories(__DIR__ . '/../database/factories');
        $this->migrate();
        $this->users = $this->createUsers(6);
    }

    protected function migrateTestTables()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    protected function migrate()
    {
        (new CreateChatTables)->up();
        $this->migrateTestTables();
    }
    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        // $app['config']->set('database.default', 'testbench');
        // $app['config']->set('database.connections.testbench', [
        //     'driver' => 'mysql',
        //     'database' => 'chat',
        //     'username' => 'root',
        //     'host' => '127.0.0.1',
        //     'password' => 'my-secret-pw',
        //     'prefix' => '',
        // ]);
        $app['config']->set('chat.user_model', 'Yizen\Chat\User');
        $app['config']->set('chat.sent_message_event', 'Yizen\Chat\Eventing\MessageWasSent');
        $app['config']->set('chat.broadcasts', false);
    }

    protected function getPackageProviders($app)
    {
        return [
            \Orchestra\Database\ConsoleServiceProvider::class,
            \Yizen\Chat\ChatServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Chat' => \Yizen\Chat\Facades\ChatFacade::class,
        ];
    }

    public function createUsers($count = 1)
    {
        return factory(User::class, $count)->create();
    }

    public function tearDown()
    {
        $this->rollbackTestTables();
        (new CreateChatTables)->down();
        parent::tearDown();
    }

    protected function rollbackTestTables()
    {
        Schema::drop('users');
    }
}