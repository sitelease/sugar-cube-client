# Gitea <small>for PHP</small>

## Yet another implementation of enumerated types
This implementation, based on [traits](https://secure.php.net/manual/en/language.oop5.traits.php), does not try to reproduce the semantics of traditional enumerations, like the ones found in C# or Java languages.

Unlike other [PHP](https://secure.php.net) implementations, like the [SplEnum](https://secure.php.net/manual/en/class.splgitea.php) class, it does not rely on object instances. Instead, it just gives a set of static methods to ease working with the `public` constants of a class representing an enumerated type.

## Quick start
Install the latest version of **Enums for PHP** with [Composer](https://getcomposer.org):

```shell
composer require sab-international/gitea
```

For detailed instructions, see the [installation guide](installation.md).
