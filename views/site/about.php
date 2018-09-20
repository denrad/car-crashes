<?php
 use yii\helpers\Html;
 $email = \Yii::$app->params['adminEmail'];
?>

<div>
    <strong>Информация по дорожно—транспортным происшествиям</strong>
    <p>
        Основано на <?= Html::a(
            'откртых данных МВД России',
            'https://xn--80abhddbmm5bieahtk5n.xn--p1ai/opendata/crashes/2017'
        ) ?> <br>
        Связь с автором - <?= Html::mailto($email, $email) ?> <br>
        <?= Html::a('Доска разработки проекта на Trello', 'https://trello.com/b/VJBv9eSL/-'); ?>
    </p>
</div>