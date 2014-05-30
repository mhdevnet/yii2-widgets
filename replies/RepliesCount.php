<?php
/**
* @link http://www.yiiframework.com/
* @copyright Copyright (c) 2008 Yii Software LLC
* @license http://www.yiiframework.com/license/
*/

namespace nitm\widgets\replies;

use Yii;
use yii\helpers\Html;
use nitm\widgets\models\BaseWidget;
use nitm\models\Replies as RepliesModel;
use nitm\models\User;
use kartik\icons\Icon;

class RepliesCount extends BaseWidget
{
	/*
	 * HTML options for generating the widget
	 */
	public $options = [
		'class' => 'badge',
		'role' => 'replyCount',
		'id' => 'reply-count'
	];
	
	public $widgetOptions = [
		'class' => 'list-group'
	];
	
	public $itemOptions = [
		'class' => 'list-group-item'
	];
	
	public function init()
	{
		switch(1)
		{
			case !($this->model instanceof RepliesModel) && (($this->parentType == null) || ($this->parentId == null) || ($this->parentKey == null)):
			$this->model = null;
			break;
			
			default:
			$this->model = ($this->model instanceof RepliesModel) ? $this->model : RepliesModel::findModel([$this->parentId, $this->parentType, $this->parentKey]);
			break;
		}
		parent::init();
	}
	
	public function run()
	{
		switch(is_null($this->model) || ($this->model->count == 0))
		{
			case true:
			$info = $this->showEmptyCount ? Html::tag('li', 'Replies: '.Html::tag('span', 0, $this->options), $this->itemOptions) : '';
			break;
			
			default:
			$this->options['id'] .= $this->parentId;
			$info = 'Replies: '.Html::a(
				Html::tag('span', (int)$this->model->count.' '.Icon::show('eye'), $this->options),
				'/reply/index/'.$this->parentType."/".$this->parentId."/".urlencode($this->parentKey)."?__format=modal",
				[
					'data-toggle' => 'modal',
					'data-target' => '#replies-modal',
					'title' => 'View issue',
					'class' => 'btn btn-xs btn-primary'
				]
			);
			$new = $this->model->hasNew();
			switch($new)
			{
				case true:
				$info .= " New: ".Html::a(
					Html::tag('span', $new, $this->options),
					"#",
					[
						'class' => 'btn btn-xs btn-primary'
					]
				);
				break;
			}
			switch(((int)$this->model->count >= 1) && ($this->model->last->authorUser instanceof User))
			{
				case true:
				$info .= Html::tag('span', " on ".$this->model->last->created_at, $this->options);
				$info .= Html::tag('span', " Last by ".$this->model->last->authorUser->getFullName(true, $this->model->last->authorUser), $this->options);
				break;
			}
			$info = Html::tag('li', $info, $this->itemOptions);
			break;
		}
		echo $info = Html::tag('ul', $info, $this->widgetOptions);
	}
}
?>