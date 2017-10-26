#Defining Aliases
You can define an alias for a file path or URL by calling $alias->setAlias():

```php
// an alias of a file path
$alias->setAlias('@foo', '/path/to/foo');

// an alias of a URL
$alias->setAlias('@bar', 'http://www.example.com');
```

> Note: The file path or URL being aliased may not necessarily refer to an existing file or resource.
Given a defined alias, you may derive a new alias (without the need of calling $alias->setAlias()) by appending a slash / followed with one or more path segments. The aliases defined via $alias->setAlias() becomes the root alias, while aliases derived from it are derived aliases. For example, @foo is a root alias, while @foo/bar/file.php is a derived alias.

You can define an alias using another alias (either root or derived):

```php
$alias->setAlias('@foobar', '@foo/bar');
```


#Resolving Aliases
You can call $alias->getAlias() to resolve a root alias into the file path or URL it represents. The same method can also resolve a derived alias into the corresponding file path or URL:

```php
echo $alias->getAlias('@foo');               // displays: /path/to/foo
echo $alias->getAlias('@bar');               // displays: http://www.example.com
echo $alias->getAlias('@foo/bar/file.php');  // displays: /path/to/foo/bar/file.php
```

The path/URL represented by a derived alias is determined by replacing the root alias part with its corresponding path/URL in the derived alias.

> Note: The $alias->getAlias() method does not check whether the resulting path/URL refers to an existing file or resource.
A root alias may also contain slash / characters. The $alias->getAlias() method is intelligent enough to tell which part of an alias is a root alias and thus correctly determines the corresponding file path or URL:

```php
$alias->setAlias('@foo', '/path/to/foo');
$alias->setAlias('@foo/bar', '/path2/bar');
$alias->getAlias('@foo/test/file.php');  // displays: /path/to/foo/test/file.php
$alias->getAlias('@foo/bar/file.php');   // displays: /path2/bar/file.php
```

If @foo/bar is not defined as a root alias, the last statement would display /path/to/foo/bar/file.php.