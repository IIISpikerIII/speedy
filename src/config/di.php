<?php

use speedy\config\Database;
use speedy\tests\phpFunc\CompareTest;
use speedy\viewers\GraphBubleViewer;
use speedy\viewers\TableAvgViewer;
use speedy\viewers\TableGroupViewer;
use speedy\viewers\TableListViewer;
use speedy\lists\TesterList;
use speedy\lists\TestList;
use speedy\lists\ViewerList;
use speedy\tests\phpFunc\ArrayReadTest;
use speedy\tests\phpFunc\ArraySortTest;
use speedy\tests\phpFunc\IncPrefVsPosTest;
use speedy\tests\phpFunc\SizeofVsCountTest;
use speedy\repositories\DataRepository;
use speedy\testers\PhpTester;
use speedy\testers\XHprofTester;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;
use function DI\autowire;
use function DI\create;
use function DI\get;

return [
	Database::class => create(Database::class)->constructor(get('db')),
	DataRepository::class => autowire(),
	// Twig
	LoaderInterface::class => create(FilesystemLoader::class)->constructor(get('twig.templates')),
	Environment::class => create()->constructor(get(LoaderInterface::class)),
	// Included Tests
	TestList::PHP_INC_PREF_POST => autowire(IncPrefVsPosTest::class),
	TestList::PHP_ARR_READ => autowire(ArrayReadTest::class),
	TestList::PHP_ARR_SORT => autowire(ArraySortTest::class),
	TestList::PHP_SOF_VS_COUNT => autowire(SizeofVsCountTest::class),
	CompareTest::class => autowire(),
	// Testers
	TesterList::TESTER_PHP => autowire(PhpTester::class),
	TesterList::TESTER_XHPROF => autowire(XHprofTester::class),
	// Viewers
	ViewerList::VIEWER_GBUBLE => autowire(GraphBubleViewer::class),
	ViewerList::VIEWER_TAVG => autowire(TableAvgViewer::class),
	ViewerList::VIEWER_TGROUP => autowire(TableGroupViewer::class),
	ViewerList::VIEWER_TLIST => autowire(TableListViewer::class),
];