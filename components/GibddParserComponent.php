<?php

namespace app\components;

use app\models\Stat;
use simplehtmldom_1_5\simple_html_dom_node;
use Sunra\PhpSimple\HtmlDomParser;
use yii\base\Component;
use \DateTime;

/**
 * Парсер сайта ГИБДД, получаем информацию о количестве аварий, смертей и ранений
 * Class GibddParserComponent
 * @package app\components
 */
class GibddParserComponent extends Component
{
    const SITE_URL = 'http://www.gibdd.ru/';

    private $pluralMonth = [
        'января'   => 1,
        'февраля'  => 2,
        'марта'    => 3,
        'апреля'   => 4,
        'мая'      => 5,
        'июня'     => 6,
        'июля'     => 7,
        'августа'  => 8,
        'сентября' => 9,
        'октября'  => 10,
        'ноября'   => 11,
        'декабря'  => 12,
    ];

    private $fieldsMap = [
        'ДТП'           => 'accidents_count',
        'Погибли'       => 'loss_count',
        'Погибло детей' => 'loss_child_count',
        'Ранены'        => 'suffer_count',
        'Ранено детей'  => 'suffer_child_count',
    ];

    /**
     * @return Stat
     * @throws \Exception
     */
    public function parse()
    {
        $statistics = $this->parseHtml();
        $stat = new Stat();
        foreach ($this->fieldsMap as $statField => $field) {
            $stat->setAttribute($field, $statistics[$statField]);
        }
        $stat->date = $statistics['date']->format('Y-m-d');
        if (!$stat->validate()) {
            throw new \Exception('Неправильные данные' . var_export($stat->errors, true));
        }

        return $stat;
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function parseHtml()
    {
        // Делаем локальную копию
        if (defined('YII_DEBUG') && YII_DEBUG) {
            $localFile = sprintf('%s/%s.html', \Yii::getAlias('@app/runtime/html'), date('Y-m-d'));
            if (!is_readable($localFile)) {
                copy(self::SITE_URL, $localFile);
            }
        }

        $dom     = HtmlDomParser::file_get_html($localFile);
        $getText = function (simple_html_dom_node $node) {
            return trim(html_entity_decode($node->text()));
        };

        // Получаем дату
        $header = $dom->find('div.block_count h3')[0]->text();
        $date   = $this->parseDate(explode("\n", $header)[1]);

        $columns  = array_map(
            function ($str) {
                list($str) = explode(':', trim($str));
                return $str;
            },
            array_map($getText, $dom->find('div.block_count .count_title'))
        );
        $elements = array_map($getText, $dom->find('div.block_count .count_right'));

        $elementsPerColumn = intval(count($elements) / count($columns));
        $statistics        = array_column(
            array_map(
                function ($col, array $elements) {
                    return [trim($col), intval(implode('', $elements))];
                },
                $columns,
                array_chunk($elements, $elementsPerColumn)
            ),
            1,
            0
        );

        \Yii::trace($statistics);

        if (count($statistics) !== 5) {
            throw new \Exception('Неправильное количество показателей' . var_export($statistics, true));
        }

        return ['date' => $date] + $statistics;
    }

    /**
     * `2 сентября 2018`
     * @param string $stringDate Строка, содержащая дату
     * @return \DateTime
     * @throws \Exception
     */
    protected function parseDate($stringDate)
    {
        $stringDate = strtr(mb_strtolower($stringDate), $this->pluralMonth);
        $date = DateTime::createFromFormat('d m Y', $stringDate);

        if ($date === false) {
            throw new \Exception("Неправильная дата $stringDate");
        }
        return $date;
    }

}