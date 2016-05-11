Redbeard's Thoughts
===================

Or is it thought experiments? I'm not really sure...

This is a collection of thoughts, ideas, and experiments. Anything that is worthy will be put on my
blog. But code samples and demos will live here. And I'll keep the documentation here as well so
it's convenient.

Specifying class names
----------------------

Determine if

```php
$di->set(My\Namespaced\Object::class, My\NamespacedObject::class);
```

is faster or slower than

```php
$di->set('My\Namespaced\Object', 'My\NamespacedObject');
```

The reason I ask this is I was configuring my dependency injection container using strings as in the
latter example. but all the cool kids were recommending the former. The former also works well with
this:

```php
use My\Namepsaced\Object;

$di->set(Object::class, Object::class);
```

But I was concerned that this will actually autoload the class. That's not a problem if you only
have one or two or even a few classes. But the project I'm working on has dozens, working it's way
to hundreds. If defining dependency injection loaded *all* of those, even if only one or two are
needed, it would seriously hurt the performance of the project.

So I did a little _ad hoc_ test and determined that the classes were *not* autoloaded. The value of
`Object::class` was determined strictly from the name. But I got curious. It looks nicer, should be
easier to maintain, and IDEs should be able to autocomplete it. But is it faster? Not that it really
matters, I'm going to use it. But I was curious.

See `tests/classname.php`.

Results for 10,000,000 iterations on PHP 5 (5.6.21) and PHP 7 (7.0.6) on my laptop, run with 5
iterations, throwing out the highest and lowest times.

| Test            | PHP 5  | PHP 7  |
|-----------------|-------:|-------:|
| Strings         | 3.1123 | 0.8149 |
| Full Namespace  | 3.1302 | 0.8173 |
| Short Namespace | 6.2273 | 1.6559 |

PHP 7 is an order of magnitude faster than PHP 5 (which is to be expected). Strings are slightly
faster than using a full namespace (0.29% and 0.58% faster for PHP 7 and PHP 5 respectively). Short
namespaces take about twice as long.

My conclusion is it's best to use full namespaces. They are easier than strings and twice as fast as
short namespaces. And the difference between strings and full namespaces is small enough to probably
be an error margine. Of course, using something shorter than a ten component namespace might affect
this. I also didn't test what happens if you use a relative namespace.

And as with all microbenchmarks, your results may vary and probably will. So only use these number
as broad strokes.

Licensing
=========

See [LICENSE.md](LICENSE.md) for licensing details. It contains licensing info for the entire
repository.

This document is licensed as [CC-BY-SA-4.0](LICENSE.md#cc-by-sa-40). Briefly, this means you're free
to use and change these documents, but you must give me credit and if you make changes, you must
license the changes under the same license. As an exception, any code embedded in this document
should be considered as public domain using [the Unlicense](LICENSE.md#the-unlicense). This allows
the use of said code via copy/paste without having to worry about the licensing.
