# Asset Manager
Manage and build simple your assets

## Installation
```bash
composer requrie pschur/assets
```

## Usage

I recomend you to look also at my [example directory](./example).

At first import the autoloader from composer:
```php
<?php
use Pschur\Assets\Asset;

require __DIR__.'/vendor/autoload.php';
```

Then configure some importaint things:
````php
// REQUIRED
Asset::setAssetCache(__DIR__.'/cache'); // Define a cache where the package can store some data
Asset::setAssetUrl('/assets.php'); // Define the url, where the Asset Manager can get its data.

// OPTIONAL
Asset::setAutoOptimize(true); // If you want to create automatic optimized data set this to true. I don't recommend this while developing!
````

### Why need the Asset Manager an own endpoint?
The Asset Manager organizes all styles and scripts by its self. If you haven't optimized your data, 
the Asset Manager will build the styles and script on every load new. When you optimized the whole thing. 
It will return static files.
