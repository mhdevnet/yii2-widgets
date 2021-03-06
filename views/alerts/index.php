<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use nitm\widgets\models\Alerts;

/* @var $this yii\web\View */
/* @var $searchModel nitm\models\search\Alerts */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Alerts');
$this->params['breadcrumbs'][] = $this->title;
$alertsModel = new Alerts();
?>
<div class="alerts-index" role="alertsListForm">
<div class="wrapper">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render("_form", [
		"model" => $alertsModel,
		'formOptions' => $formOptions
	]);  ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
		'itemView' => function ($model, $key, $index, $widget) {
			return $this->render('view', ['model' => $model]);
		},
		'summary' => false,
		"layout" => "{summary}\n{items}",
		'itemOptions' => [
			'tag' => false
		],
		'options' => [
			'id' => 'alerts-list-container',
			'tag' => 'ul',
			'class' => 'list-group',
			'role' => 'alertsList'
		],
		/*'pager' => [
			'class' => \kop\y2sp\ScrollPager::className(),
			'container' => '#documentation-ias-container',
			'item' => "tr"
		]*/
		'pager' => [
			'linkOptions' => [
				'data-pjax' => 1
			],
		]
    ]); ?>
</div>
</div>
