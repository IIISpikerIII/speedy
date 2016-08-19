# Speed testing any functions

## Install

```
composer require iiispikeriii/speedy
```

## Use

```php
print Speedy::test(Speedy::PHP_INC_PREF_POST);
```

if you want to get only result speed testing - use onlyData param its true

```php
print Speedy::test(Speedy::PHP_INC_PREF_POST, [], true);
```

OR

```php
$params = [ 
    'name' => 'Speedy ++i vs i++',  
    'valueTest' => [100, 1000, 2000, 3000], 
    'qntTest' => 5, 
    'viewers' => [TestCore::VIEWER_TGROUP, TestCore::VIEWER_TAVG, TestCore::VIEWER_GBUBLE], 
];  
print Speedy::test(Speedy::PHP_INC_PREF_POST, $params);
```

## Viewers

* `TestCore::VIEWER_TLIST` - table list result
* `TestCore::VIEWER_TGROUP` - table group result
* `TestCore::VIEWER_TAVG` - table average result
* `TestCore::VIEWER_GBUBLE` - graph with buble result

## Tests

* `Speedy::PHP_INC_PREF_POST` - comparison with pre-increment postincrement (++i and i++)

## Compare custom functions

```php
$myFunc1 =  function($size) 
{
    ... custom code ... 
};  
    
$myFunc2 = function($size)  
{
    ... custom code ... 
};  
```
    
```php
print Speedy::compare(['nameFunc1' => $myFunc1, 'nameFunc2' => $myFunc2]);  
```

OR

```php
$params = [ 
    'name' => 'Compare functions',   
    'valueTest' => [100, 1000, 2000, 3000], 
    'qntTest' => 5, 
    'viewers' => [TestCore::VIEWER_TLIST, TestCore::VIEWER_TGROUP, TestCore::VIEWER_TAVG, TestCore::VIEWER_GBUBLE], 
];  
print Speedy::compare(['nameFunc1' => $myFunc1, 'nameFunc2' => $myFunc2], $params);
```