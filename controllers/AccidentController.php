<?php

namespace app\controllers;

use app\models\Accident;
use app\models\AccidentSearch;
use kartik\export\ExportMenu;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AccidentController extends Controller
{
    const REGION_ALL = 'all';

    /**
     * @param string $region
     * @return string
     */
    public function actionIndex($region)
    {
        $searchModel = new AccidentSearch();

        $code = $this->getCode($region);
        if ($region !== self::REGION_ALL && $code) {
            $searchModel->region_code = $code['code'];
            $regionName               = $code[0];
        } else {
            $regionName = null;
        }

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', compact('dataProvider', 'searchModel', 'region', 'regionName'));
    }

    /**
     * @param string $id
     * @return string
     */
    public function actionView($id)
    {
        $model      = $this->findModel($id);
        // @todo переписать
        $region     = array_filter(
            \Yii::$app->params['isoCodes'],
            function (array $code) use ($model) {
                return $code['code'] == $model->region_code;
            }
        );
        $region     = reset($region);
        $regionName = $region[0];
        $region     = $region['iso'];
        return $this->render('view', compact('model', 'region', 'regionName'));
    }

    /**
     * @param string $id
     * @return Accident
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Accident::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param string $region
     * @return null|array
     */
    protected function getCode($region)
    {
        $codes = \Yii::$app->params['isoCodes'];
        return isset($codes[$region]['code']) ?
            $codes[$region] : null;
    }
}