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
    'tester' => ['name' => TestCore::TESTER_PHP], or 'tester' => TestCore::TESTER_PHP
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
* `Speedy::PHP_ARR_READ` - comparison with reading array "while" "for" "foreach"
* `Speedy::PHP_ARR_SORT` - comparison with sorting arrays Heap, Bubble, Select, Insertion, Quick

## Testers

* `TestCore::TESTER_PHP` - testing with PHP functions microtime and memory_get_usage
* `TestCore::TESTER_XHPROF` - testing with extention XHProf, required XHProf. 
    * xhprof_lib - path to xhprof_lib.php (not required)
    * xhprof_runs - path to xhprof_runs.php (not required)
    

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
    'tester' => TestCore::TESTER_XHPROF,
];  
print Speedy::compare(['nameFunc1' => $myFunc1, 'nameFunc2' => $myFunc2], $params);
```
## Example viwers

VIEWER_TLIST

!["table data list viewer"](https://github.com/IIISpikerIII/speedy/blob/master/docs/VIEWER_TLIST.png?raw=true)

VIEWER_TGROUP

!["table data group viewer"](https://github.com/IIISpikerIII/speedy/blob/master/docs/VIEWER_TGROUP.png?raw=true)

VIEWER_TAVG

!["table data group viewer"](https://github.com/IIISpikerIII/speedy/blob/master/docs/VIEWER_TAVG.png?raw=true)

VIEWER_GBUBLE

!["graph data buble viewer"](https://github.com/IIISpikerIII/speedy/blob/master/docs/chartTest.png?raw=true)

