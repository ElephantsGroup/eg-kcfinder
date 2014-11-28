<?php

namespace iutbay\yii2kcfinder;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

/**
 * KCFinder
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
class KCFinder extends \yii\widgets\InputWidget
{

	/**
	 * Multiple selection
	 * @var boolean
	 */
	public $multiple = false;

	/**
	 * KCFinder dynamic settings (using session)
	 * @link http://kcfinder.sunhater.com/install#dynamic
	 * @var array
	 */
	public $kcfOptions = [];

	/**
	 * KCFinder input parameters
	 * @link http://kcfinder.sunhater.com/integrate#input
	 * @var array
	 */
	public $kcfBrowseOptions = [];

	/**
	 * KCFinder client options
	 * @var array
	 */
	public $clientOptions = [];

	/**
	 * KCFinder default dynamic settings
	 * @link http://kcfinder.sunhater.com/install#dynamic
	 * @var array
	 */
	public static $kcfDefaultOptions = [
		'disabled' => false,
		'denyZipDownload' => true,
		'denyUpdateCheck' => true,
		'denyExtensionRename' => true,
		'theme' => 'default',
		'access' => [ // @link http://kcfinder.sunhater.com/install#_access
			'files' => [
				'upload' => false,
				'delete' => false,
				'copy' => false,
				'move' => false,
				'rename' => false,
			],
			'dirs' => [
				'create' => false,
				'delete' => false,
				'rename' => false,
			],
		],
		'types' => [  // @link http://kcfinder.sunhater.com/install#_types
			'files' => [
				'type' => '',
			],
		],
		'thumbsDir' => '.thumbs',
		'thumbWidth' => 100,
		'thumbHeight' => 100,
	];

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();

		if (!isset($this->kcfOptions['uploadURL']))
		{
			$this->kcfOptions['uploadURL'] = Yii::getAlias('@web/upload');
			//$this->kcfOptions['uploadDir'] = Yii::getAlias('@app/web/upload');
		}

		$this->kcfOptions = array_merge(self::$kcfDefaultOptions, $this->kcfOptions);
		Yii::$app->session['KCFINDER'] = $this->kcfOptions;

		$this->clientOptions['browseOptions'] = $this->kcfBrowseOptions;
		$this->clientOptions['uploadURL'] = $this->kcfOptions['uploadURL'];
		$this->clientOptions['multiple'] = $this->multiple;
		$this->clientOptions['inputName'] = $this->getInputName();
	}

	/**
	 * @return string input name
	 */
	public function getInputName()
	{
		if ($this->hasModel())
		{
			return Html::getInputName($this->model, $this->attribute);
		}
		else
		{
			return $this->name;
		}
	}

}