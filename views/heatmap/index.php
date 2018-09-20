<?php

use Ivory\GoogleMap\Layer\HeatmapLayer;
use app\models\Accident;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Helper\Builder\MapHelperBuilder;
use Ivory\GoogleMap\Helper\Builder\ApiHelperBuilder;
use voime\GoogleMaps\Map;

/**
 * @var Accident[] $accidents
 * @var \yii\web\View $this
 * @var string $region
 */

$this->title = 'Тепловая карта ';

$markers = array_filter(array_map(function (Accident $model) {
 return $model->em_place_longitude && $model->em_place_latitude ?
     [
         'title' => $model->type,
         'position' => [$model->em_place_latitude, $model->em_place_longitude],
     ] : null;
}, $accidents));

echo Map::widget(
    [
        'zoom'    => 7,
        'center'  => [$accidents[0]->em_place_latitude, $accidents[0]->em_place_longitude],
        'height'  => '500px',
        'mapType' => Map::MAP_TYPE_ROADMAP,
        'markers' => $markers,
    ]
);


/*
$coordinates = array_filter(
    array_map(
        function (Accident $model) {
            return $model->em_place_latitude && $model->em_place_longitude ?
                new Coordinate($model->em_place_latitude, $model->em_place_longitude)
                : null;
        },
        $accidents
    )
);

$map = new \Ivory\GoogleMap\Map();
$mapHelper = MapHelperBuilder::create()->build();
$apiHelper = ApiHelperBuilder::create()
                             ->setKey(\Yii::$app->params['GOOGLE_API_KEY'])
                             ->build();
$map->setAutoZoom(true);
$heatmapLayer = new HeatmapLayer($coordinates);
$map->getLayerManager()->addHeatmapLayer($heatmapLayer);
echo $mapHelper->render($map);
echo $apiHelper->render([$map]);
*/