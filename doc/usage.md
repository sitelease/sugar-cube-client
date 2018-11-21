path: src/branch/master
source: lib/EnumTrait.php
# Usage

## Create the enumeration
Just use the `Enum\EnumTrait` trait on a class:

```php
<?php
use Enum\{EnumTrait};

/**
 * Specifies the day of the week.
 */
final class DayOfWeek {
  use EnumTrait;

  const SUNDAY = 0;
  const MONDAY = 1;
  const TUESDAY = 2;
  const WEDNESDAY = 3;
  const THURSDAY = 4;
  const FRIDAY = 5;
  const SATURDAY = 6;
}
```

This trait adds a private constructor to the enumerated type: it prohibits its instantiation.

Thus, the obtained enumeration can only contain static members.
You should only use [scalar constants](https://secure.php.net/manual/en/function.is-scalar.php), and possibly methods.

## Work with the enumeration
Check whether a value is defined among the enumerated type:

```php
<?php
DayOfWeek::isDefined(DayOfWeek::SUNDAY); // true
DayOfWeek::isDefined('foo'); // false
```

Ensure that a value is defined among the enumerated type:

```php
<?php
DayOfWeek::assert(DayOfWeek::MONDAY); // DayOfWeek::MONDAY
DayOfWeek::assert('foo'); // (throws \UnexpectedValueException)

DayOfWeek::coerce(DayOfWeek::MONDAY); // DayOfWeek::MONDAY
DayOfWeek::coerce('bar'); // null
DayOfWeek::coerce('baz', DayOfWeek::TUESDAY); // DayOfWeek::TUESDAY
```

Get the zero-based position of a value in the enumerated type declaration:

```php
<?php
DayOfWeek::getIndex(DayOfWeek::WEDNESDAY); // 3
DayOfWeek::getIndex('foo'); // -1
```

Get the name associated to an enumerated value:

```php
<?php
DayOfWeek::getName(DayOfWeek::THURSDAY); // "THURSDAY"
DayOfWeek::getName('foo'); // "" (empty)
```

Get information about the enumerated type:

```php
<?php
DayOfWeek::getEntries();
// ["SUNDAY" => 0, "MONDAY" => 1, "TUESDAY" => 2, "WEDNESDAY" => 3, "THURSDAY" => 4, "FRIDAY" => 5, "SATURDAY" => 6]

DayOfWeek::getNames();
// ["SUNDAY", "MONDAY", "TUESDAY", "WEDNESDAY", "THURSDAY", "FRIDAY", "SATURDAY"]

DayOfWeek::getValues();
// [0, 1, 2, 3, 4, 5, 6]
```
