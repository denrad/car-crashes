<?php

namespace app\controllers;

use app\models\Accident;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $actualDate = Accident::find()->select(['em_moment_date'])->orderBy(['datetime' => SORT_DESC])->limit(1)->scalar();
        $regions = ['all' => 'Все регионы'] +  ArrayHelper::map(\Yii::$app->params['isoCodes'], 'iso', 0);
        return $this->render('index', compact('regions', 'actualDate'));
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
