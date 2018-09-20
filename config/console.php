<?php

return [
    'id'                  => 'basic-console',
    'controllerNamespace' => 'app\commands',
    'components'          => [
        'sitemap' => [
            'class'              => \zhelyabuzhsky\sitemap\components\Sitemap::class,
            'maxUrlsCountInFile' => 10000,
            'optionalAttributes' => ['changefreq', 'lastmod', 'priority'],
            'maxFileSize'        => '10M',
        ],
    ],
];
