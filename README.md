Postgres Broadcasting Events Driver for Laravel
===============================================

Installation
--------------

Using Composer:

```sh
composer require adaojunior/laravel-postgresql-broadcast-driver
```

In your config/app.php file add the following provider to your service providers array:

```php
'providers' => [
    ...
    Adaojunior\PostgreSqlBroadcastDriver\BroadcastServiceProvider::class,
    ...
]
```

In your config/broadcasting.php file set the default driver to 'postgresql' and add the connection configuration like so:

```php
'default' => 'postgresql',

'connections' => [
    ...
    'postgresql' => [
            'driver' => 'postgresql',
            'connection' => env('BROADCAST_PG_DB','pgsql')
        ]
    ...
]
```

Usage
-------

Add a custom broadcast event to your application like so:

```php
namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Message extends Event implements ShouldBroadcast
{
    protected $message;

    public function __construct($message)
    {
        $this->message= $message;
    }

    public function broadcastOn()
    {
        return ['MessageChannel'];
    }

    public function broadcastWith()
    {
        return ['message' => $this->message];
    }
}

```

Now to publish in your application simply fire the event:

```php
event(new App\Events\Message('Test publish!!!'));
```

NodeJS Client (optional)
-------------------------------
``` sh
npm install pg-pubsub --save
```
```js
// server.js

var PGPubsub = require('pg-pubsub');

var instance = new PGPubsub('postgres://homestead:secret@localhost/homestead';

instance.addChannel('MessageChannel', function (payload) {
    console.log(payload);
});

```
