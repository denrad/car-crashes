<?php

namespace app\controllers;

use app\models\Accident;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class HeatmapController extends Controller
{
    public function actionIndex($region)
    {
        if (!$region) {
            throw new NotFoundHttpException();
        }

        $code = \Yii::$app->params['isoCodes'][$region]['code'];

        $accidents = Accident::find()->select([
            'type',
            'em_place_latitude',
            'em_place_longitude'
        ])->where(['region_code' => (string)$code])->all();

        return $this->render('index', compact('accidents', 'region'));
    }
}