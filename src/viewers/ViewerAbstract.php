<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 10.08.16
 * Time: 20:04
 */

namespace speedy\viewers;

use speedy\DTO\TestDataDTO;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class ViewerAbstract implements ViewerInterface
{
	protected $view = '/viewer/tableList.php';

	/** @var \Twig_Environment */
	protected $twig;

	abstract function prepareData(array $data): array;

	/**
	 * ViewerAbstract constructor.
	 *
	 * @param Environment
	 */
	public function __construct(Environment $twig)
	{
		$this->twig = $twig;
	}

	/**
	 * @param TestDataDTO[] $data
	 *
	 * @return string
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	public function run(array $data): string
	{
		$data = $this->prepareData($data);

		return $this->twig->render($this->view, compact('data'));
	}
}