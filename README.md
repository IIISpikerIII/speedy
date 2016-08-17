# Speed testing any functions

## install

composer require iiispikeriii/speedy

## use

Speedy::test(Speedy::PHP_INC_PREF_POST)


$params = [
    'name' => 'Speedy ++i vs i++',
    'valueTest' => [100, 1000, 2000, 3000],
    'qntTest' => 5,
    'viewers' => [TestCore::VIEWER_TLIST, TestCore::VIEWER_TGROUP, TestCore::VIEWER_TAVG, TestCore::VIEWER_GBUBLE],
];
Speedy::test(Speedy::PHP_INC_PREF_POST, $params)