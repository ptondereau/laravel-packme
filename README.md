Laravel Packer
=================

Laravel Packer is a project starter pack which combine all basic stuff (src, tests) in order to develop a package for Laravel 5.*.

Most of this repository's common practices comes from [Graham Campbell](https://github.com/GrahamCampbell). You should follow him!


Laravel Packer was created by, and is maintained by [Pierre Tondereau](https://github.com/ptondereau). It utilises my [Laravel TestBench](https://github.com/GrahamCampbell/Laravel-TestBench) package. Feel free to check out the [change log](CHANGELOG.md), [releases](https://github.com/ptondereau/laravel-packer/releases), [license](LICENSE), and [contribution guidelines](CONTRIBUTING.md).

## Installation

Either [PHP](https://php.net) 5.5+ or [HHVM](http://hhvm.com) 3.6+ are required.

To get the latest version of Laravel Bitbucket, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer create-project ptondereau/laravel-packer
```

## Configuration

Laravel Packer provides a configuration example.

So you can test publishing assets with:

```bash
$ php artisan vendor:publish --provider="YourVendor\YourPackage\YourPackageServiceProvider"
```

This will create a `config/your-packagephp` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

## Usage

Replace all 'YourVendor' by your vendor/company name and 'YourPackage' by the name of your package. Also, some comments are dummies and you should replace it too!

 Rewrite the REAMDE.md, CHANGELOG.md, CONTRIBUTING.md according to your need. Finally, delete .gitattributes.example

##### Further Information

There are other classes in this package that are not documented here. This is because they are not intended for public use and are used internally by this package.

## License

Laravel Packer is licensed under [The MIT License (MIT)](LICENSE).