<?php

namespace app\models;

use yii\helpers\Url;
use zhelyabuzhsky\sitemap\models\SitemapEntityInterface;

class AccidentSitemap extends Accident implements SitemapEntityInterface
{
    public function getSitemapLastmod()
    {
        return date('c');
    }

    public function getSitemapChangefreq()
    {
        return 'daily';
    }

    public function getSitemapPriority()
    {
        return 0.8;
    }

    public static function getSitemapDataSource()
    {
        return self::find();
    }

    public function getSitemapLoc()
    {
        return Url::to(['/accident/view', 'id' => (string) $this->_id]);
    }
}