<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var array         $regions
 * @var \yii\web\View $this
 * @var string        $actualDate
 */
$this->title = 'Список регионов';
?>

<p> Информация актуальна на: <b><?= $actualDate ?></b> </p>
<p>Регионы:</p>
<?= Html::ul(
    $regions,
    [
        'item' => function ($item, $index) {
            return Html::tag(
                'li',
                Html::a($item, Url::to(['accident/index', 'region' => $index]))
            );
        },
    ]
);

?>
<p>
    В список попадают ДТП с пострадавшими.
</p>