<?php
/**
 * @var \yii\web\View                $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \app\models\AccidentSearch   $searchModel
 * @var string                       $region
 * @var string                       $regionName
 */

use app\models\Accident;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerMetaTag(['name' => 'description', 'content' => $regionName]);
$this->title = 'Список ДТП ' . $regionName;
if ($regionName) {
    $this->params['breadcrumbs'][] = [
        'label' => $regionName,
        'url'   => ['index', 'region' => $region],
    ];
}
$this->params['breadcrumbs'][] = 'Список ДТП';

print GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'datetime',
                'value'     => function (Accident $accident) {
                    return $accident->getAccidentDatetime();
                },
                'format'    => ['date', 'dd.MM.YYYY HH:mm'],
                'filter'    => false,
            ],
            [
                'attribute' => 'address',
                'value'     => function (Accident $model) {
                    return Html::a(
                        Html::encode($model->getFormattedAddress()),
                        Url::to(['view', 'id' => (string)$model->_id])
                    );
                },
                'format'    => 'html',
            ],
            [
                'attribute' => 'type',
                'filter'    => Accident::getTypes(),
            ],
            'suffer_amount',
            'loss_amount',
        ],
    ]
);