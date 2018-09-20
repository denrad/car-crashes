<?php

namespace app\commands;

use app\models\AccidentSitemap;
use yii\console\Controller;
use zhelyabuzhsky\sitemap\components\Sitemap;

class SitemapController extends Controller
{
    /**
     * Генерация карты сайта
     */
    public function actionIndex()
    {
        /** @var Sitemap $sitemap */
        $sitemap = \Yii::$app->sitemap;
        $sitemap->sitemapDirectory = \Yii::getAlias('@app/web');
        \Yii::$app->sitemap->addModel(AccidentSitemap::class)
            ->create();
    }
}