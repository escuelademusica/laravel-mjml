# Laravel MJML

### Installation

`composer require escuelademusica/laravel-mjml`

`npm install --save mjml`

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
