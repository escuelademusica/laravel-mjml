# Laravel MJML

### Installation

`composer require escuelademusica/laravel-mjml`

You neeed install [MJML](https://mjml.io/) via npm.

`npm install --save mjml`

You can customize the location of the MJML files by adding the following to your `.env` file:
`MJML_BINARY_PATH=/path/to/mjml/bin/mjml`

### Usage

There are two ways to use this package.

#### 1. Extends our Custom Mailable

```php
<?php

namespace App\Mail;

use EscuelaDeMusica\MJML\Mail\Mailable;

class CustomMailable extends Mailable
{

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->mjml('view.name',);
    }
}
```

#### 2. Use the InteractsWithMjml Trait with laravel mailable

This works the same way as the CustomMailable, but you don't need to extend the mailable. You can use the trait with any laravel mailable, but remember to edit the render function to look like this:

```php

<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use EscuelaDeMusica\MJML\Support\InteractsWithMjml;

class SomeEmail extends Mailable
{
    use InteractsWithMjml;

    public function build ()
    {
        return $this->mjml('view.name');
    }

    public function render()
    {
        return $this->renderMjml();
    }
}
```

For laravel notifications in your `toMail` method, you will normally return an instance of a MailMessage. The package extends that class and adds the mjml functions to it. To use mjml mails for notifications, you will need to extend the MjmlMessage provided by the package.

```php
<?php

namespace App\Notifications;

use EscuelaDeMusica\MJML\Mail\Messages\MjmlMessage;

class SomeNotification extends Notification
{


    public function toMail($notifiable)
    {
        return (new MjmlMessage)
            ->subject('Notification Subject')
            ->mjml('notification.name');
    }
}
```

## How it works.

This is inspired by (https://github.com/asahasrabuddhe/laravel-mjml), but more optimized.
Compiles the mjml of view compiled file.

Also there's a helper function to render the mjml directly.

```php
<?php

class DummyClass {
    public function something(){
        return mjml('view.name', $data);
    }
}
```
