# jQuery Fetcher

Specify what version of jQuery you want, and let the bundle handle getting it
and showing either the minified or development version.

You might want to checkout [bower](http://bower.io/search/?q=jquery) to see if
that fits your needs better than this bundle.

## Installation via Composer

Best way to get this bundle using [composer](https://getcomposer.org/).

```javascript
{
    "require": {
        "guzzlehttp/guzzle": "~4.0"
    }
}
```

And then register the bundle in your `app/AppKernel.php`.

```php
public function registerBundles()
{
    $bundles = array(
        // ..,
        new Shane\JqueryBundle\ShaneJqueryBundle(),
    );
}
```

In order for the twig files to work, you will need to allow them to access
assetic. You can do this by adding `ShaneJqueryBundle` to your
`assetic.bundles` configuration, in `app/config/config.yml`.

## Usage

### Change version

By default, you'll get jQuery version 2.1.0 (the latest stable version at time
of writing), but you can change the version you want to get by setting it in
your `app/config/config.yml`.

```yaml
shane_jquery:
    version: 1.9.1
```

This version number needs to look like it will in the jQuery download URL:
"X.Y.Z". There's nothing fancy going on with the version number, so no
wild cards.  It's just a string that gets put into the URL.

### Download jQuery

Downloading the jQuery version you want isn't automatic; you need to run a
command to get it to download.

```bash
app/console jquery:download
```

### Output to twig

Two jQuery files are downloaded: the minimised and the development version. You
can get access to these using the shorthand syntax
"@ShaneJqueryBundle/Resources/public/js/jquery.js" or "jquery.min.js" for the
minified version.

You can put those file paths into a `{% javascripts %}` if you like. This'll
give you flexibility to run filters on the files.

However, it's recommended you just output the included twig file, which will
decide which file to show based on dev or prod environments.

```twig
{% include 'ShaneJqueryBundle::jquery.html.twig' %}
```

## Contributing

If you're using this bundle, then you may want to check out this project's
issues. There's a few since this was just a quick bundle I threw together.
