# Speed testing any functions

It`s util for easy performance testing some functions. 

## Install

```
composer require iiispikeriii/speedy
```

## Use

```php
$speedy = new Speedy();
print $speedy->runTestByName(TestList::PHP_ARR_SORT);
```

OR

```php
print Speedy::test(TestList::PHP_INC_PREF_POST);
```

if you want to get only result speed testing - use onlyData param its true

```php
print Speedy::test(TestList::PHP_INC_PREF_POST, [], true);
```

OR

```php
$params = [ 
    'name' => 'Speedy ++i vs i++',  
    'volumesTest' => [100, 1000, 2000, 3000], 
    'repeatTest' => 5, 
    'viewers' => [ViewerList::VIEWER_TGROUP, ViewerList::VIEWER_TAVG, ViewerList::VIEWER_GBUBLE], 
    'tester' => 'tester' => TesterList::TESTER_PHP
];  
print Speedy::test(TestList::PHP_INC_PREF_POST, $params);
```

## Viewers

* `ViewerList::VIEWER_TLIST` - table list result
* `ViewerList::VIEWER_TGROUP` - table group result
* `ViewerList::VIEWER_TAVG` - table average result
* `ViewerList::VIEWER_GBUBLE` - graph with buble result

## Tests

* `TestList::PHP_INC_PREF_POST` - comparison with pre-increment postincrement (++i and i++)
* `TestList::PHP_ARR_READ` - comparison with reading array "while" "for" "foreach"
* `TestList::PHP_ARR_SORT` - comparison with sorting arrays Heap, Bubble, Select, Insertion, Quick
* `TestList::PHP_SOF_VS_COUNT` - comparison with sizeof() versus count()

## Testers

* `TesterList::TESTER_PHP` - testing with PHP functions microtime and memory_get_usage
* `TesterList::TESTER_XHPROF` - testing with extention XHProf, required XHProf. 
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
every custome functions should take int parameter - workload from volumesTest
```php
print Speedy::compare(['nameFunc1' => $myFunc1, 'nameFunc2' => $myFunc2]);  
```

OR

```php
$params = [ 
    'name' => 'Compare functions',   
    'volumesTest' => [100, 1000, 2000, 3000], 
    'repeatTest' => 5, 
    'viewers' => [ViewerList::VIEWER_TLIST, ViewerList::VIEWER_TGROUP, ViewerList::VIEWER_TAVG, ViewerList::VIEWER_GBUBLE], 
    'tester' => TesterList::TESTER_XHPROF,
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

