<?php

use yii\widgets\DetailView;
use voime\GoogleMaps\Map;
use app\models\Accident;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * @var \yii\web\View $this
 * @var Accident      $model
 * @var string        $region
 * @var string        $regionName
 */

$this->registerMetaTag(
    ['name'    => 'description',
     'content' => $model->em_moment_date . ' ' . $model->em_moment_time . ' ' . $model->type . ' ' . $model->address,
    ]
);
$this->title                 = $model->type . ' ' . $model->formatted_address;
$this->params['breadcrumbs'] = [
    [
        'label' => $regionName,
        'url'   => ['index', 'region' => $region],
    ],
    $this->title,
];

echo Map::widget(
    [
        'zoom'    => 15,
        'center'  => [$model->em_place_latitude, $model->em_place_longitude],
        'height'  => '300px',
        'mapType' => Map::MAP_TYPE_ROADMAP,
        'markers' => [
            [
                'position' => [$model->em_place_latitude, $model->em_place_longitude],
                'title'    => $model->type,
            ],
        ],
    ]
);

print DetailView::widget(
    [
        'model'      => $model,
        'attributes' => [
            [
                'attribute' => 'accidentDatetime',
                'format'    => ['date', 'dd.MM.YYYY HH:mm'],
            ],
            'type',
            'suffer_amount',
            'loss_amount',
            'suffer_child_amount',
            'loss_child_amount',

            [
                'attribute' => 'infractions',
                'value'     => implode(', ', $model->infractions),
            ],

            // Участники
            [
                'attribute' => 'participants',
                'format'    => 'html',
                'value'     => Html::ul(
                    $model->participants,
                    [
                        'item' => function ($item) {
                            return DetailView::widget(
                                [
                                    'model'      => $item,
                                    'attributes' => [
                                        [
                                            'attribute' => 'part_type_name',
                                            'label'     => 'Статус',
                                        ],
                                        [
                                            'attribute' => 'person_sex_name',
                                            'label'     => 'Пол',
                                            'value'     => !empty($item['person_sex_name']) ? $item['person_sex_name'] : null,
                                        ],
                                        [
                                            'attribute' => 'person_birthday',
                                            'label'     => 'Дата рождения',
                                        ],
                                        [
                                            'attribute' => 'main_pdd_derangements',
                                            'label'     => 'Нарушение ПДД',
                                            'value'     =>
                                                function (array $item) {
                                                    return !empty($item['main_pdd_derangements']) ?
                                                        Html::ul(
                                                            ArrayHelper::getColumn(
                                                                $item['main_pdd_derangements'],
                                                                'derang_name'
                                                            )
                                                        )
                                                        : null;
                                                },
                                            'format'    => 'html',
                                        ],
                                        [
                                            'attribute' => 'hv_type_name',
                                            'label'     => 'Пострадал',
                                        ],
                                    ],

                                ]
                            );
                        },
                    ]
                ),
            ],

            // автомобили
            [
                'attribute' => 'vehicles',
                'format'    => 'html',
                'value'     => Html::ul(
                    $model->vehicles ? $model->vehicles : [],
                    [
                        'item' => function (array $vehicle) {
                            return DetailView::widget(
                                [
                                    'model'      => $vehicle,
                                    'attributes' => [
                                        [
                                            'attribute' => 'prod_type_name',
                                            'label'     => 'Тип транспортного средства',
                                        ],
                                        [
                                            'attribute' => 'okfs_name',
                                            'label'     => 'Собственность',
                                        ],
                                        [
                                            'attribute' => 'vl_year',
                                            'label'     => 'Год выпуска',
                                        ],
                                        [
                                            'attribute' => 'rudder_type_name',
                                            'label'     => 'Руль',
                                        ],
                                        [
                                            'attribute' => 'damage_dispositions',
                                            'label'     => 'Повреждения',
                                            'value'     =>

                                                $vehicle['damage_dispositions'] ?
                                                implode(
                                                ', ',
                                                ArrayHelper::getColumn(
                                                    $vehicle['damage_dispositions'],
                                                    'disp_name'
                                                )
                                            ) : null,
                                        ],
                                    ],
                                ]
                            );
                        },
                    ]
                ),
            ],

            // дорога

            [
                'attribute' => 'formatted_address',
                'value'     => $model->getFormattedAddress(),
            ],
            'road_name',
            'road_type_name',
            'okato_code',
            'mt_rate_name',
            'tr_area_state_name',
            'road_significance_name',
            [
                'attribute' => 'road_drawbacks',
                'value'     => Html::ul(ArrayHelper::getColumn($model->road_drawbacks, 'drawback_name')),
                'format'    => 'html',
            ],
            'light_type_name',
        ],
    ]
);