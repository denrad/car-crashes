<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\mongodb\ActiveRecord;

/**
 * Class Accident
 * @package app\models
 *
 * @property                $_id
 * @property                $tr_area_state_name
 * @property                $suffer_amount
 * @property string         $region_code
 * @property array          $motion_influences
 * @property array          $place_id
 * @property string         $em_moment_time
 * @property                $hidden_by_okato
 * @property                $type
 * @property                $em_type_code
 * @property bool           $is_hidden
 * @property int            $loss_amount
 * @property string         $light_type_name
 * @property int            $light_type_code
 * @property string         $road_name
 * @property                $from_mia
 * @property array          $road_drawbacks
 * @property int            $loss_child_amount
 * @property                $author
 * @property array          $participants
 * @property                $mark
 * @property array          $infractions
 * @property int            $num_of_victim
 * @property int            $mt_rate_code
 * @property                $em_place_latitude
 * @property                $road_type_code
 * @property                $there_road_constructions
 * @property array          $geo_code
 * @property array          $here_road_constructions
 * @property                $road_significance_code
 * @property                $region_name
 * @property                $em_moment_date DD.MM.YYYY
 * @property                $road_loc_m
 * @property                $place_path
 * @property int            $suffer_child_amount
 * @property array          $vehicles
 * @property                $em_place_longitude
 * @property                $road_type_name
 * @property                $address
 * @property                $road_loc
 * @property                $tr_area_state_code
 * @property                $transp_amount
 * @property                $num_of_fatalities
 * @property                $okato_code
 * @property                $mt_rate_name
 * @property                $num_of_party
 * @property array          $created_at
 * @property                $road_code
 * @property                $num_of_vehicle
 * @property                $em_type_name
 * @property                $road_significance_name
 * @property                $formatted_address
 *
 * @property-read \DateTime $accidentDatetime
 * @property-read \DateTime $created
 */
class Accident extends ActiveRecord
{
    static private $types = [
        "Столкновение",
        "Наезд на препятствие",
        "Наезд на пешехода",
        "Наезд на стоящее ТС",
        "Съезд с дороги",
        "Опрокидывание",
        "Отбрасывание предмета(отсоединение колеса)",
        "Наезд на велосипедиста",
        "Падение пассажира",
        "Наезд на гужевой транспорт",
        "Наезд на животное",
        "Наезд на лицо, не являющееся участником дорожного движения(иного участника ДТП), осуществляющее производство работ",
        "Иной вид ДТП",
        "Наезд на внезапно возникшее препятствие",
        "Наезд на лицо, не являющееся участником дорожного движения(иного участника ДТП), осуществляющее какую-либо другую деятельность",
        "Наезд на лицо, не являющееся участником дорожного движения(иного участника ДТП), осуществляющее несение службы",
        "Падение груза",
        "Отбрасывание предмета",
    ];

    static public function getTypes()
    {
        return array_combine(self::$types, array_map(function ($type) {
            return \Yii::$app->formatter->format($type, 'text');
        }, self::$types));
    }

    static public function getSex($sex)
    {
        return $sex == 2 ? 'женщина' : 'мужчина';
    }

    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'accident';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'accidentDatetime'       => 'Дата и время',
            'datetime'               => 'Дата и время',
            'tr_area_state_name'     => 'Покрытие',
            'suffer_amount'          => 'Пострадавшие',
            'loss_amount'            => 'Погибшие',
            'suffer_child_amount'    => 'Пострадавшие дети',
            'loss_child_amount'      => 'Погибшие дети',
            'em_moment_date'         => 'Дата',
            'em_moment_time'         => 'Время',
            'type'                   => 'Тип',
            'light_type_name'        => 'Светлое/темное время',
            'road_name'              => 'Имя дороги',
            'num_of_victim'          => 'Количество транспортных средств',
            'address'                => 'Адрес',
            'formatted_address'      => 'Адрес',
            'participants'           => 'Участники',
            'okato_code'             => 'Код ОКАТО',
            'vehicles'               => 'Транспортные средства',
            'road_significance_name' => 'Принадлежность',
            'road_type_name'         => 'Тип дороги',
            'mt_rate_name'           => 'Перекрывалось движение',
            'road_drawbacks'         => 'Недостатки дороги',
            'infractions'            => 'Нарушение ПДД',
        ];
    }

    /**
     * @return string
     */
    public function getFormattedAddress()
    {
        return str_replace('Unnamed Road,', '', $this->formatted_address);
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'tr_area_state_name',
            'suffer_amount',
            'region_code',
            'motion_influences',
            'place_id',
            'datetime',
            'em_moment_time',
            'hidden_by_okato',
            'mchs_actions',
            'type',
            'em_type_code',
            'is_hidden',
            'loss_amount',
            'light_type_name',
            'light_type_code',
            'road_name',
            'from_mia',
            'road_drawbacks',
            'loss_child_amount',
            'author',
            'participants',
            'mark',
            'infractions',
            'num_of_victim',
            'mt_rate_code',
            'em_place_latitude',
            'road_type_code',
            'there_road_constructions',
            'geo_code',
            'here_road_constructions',
            'road_significance_code',
            'region_name',
            'em_moment_date',
            'road_loc_m',
            'meteo_clouds',
            'place_path',
            'vehicles',
            'em_place_longitude',
            'road_type_name',
            'suffer_child_amount',
            'technical_equipments',
            'address',
            'road_loc',
            'tr_area_state_code',
            'transp_amount',
            'gai_actions',
            'num_of_fatalities',
            'okato_code',
            'mt_rate_name',
            'num_of_party',
            'created_at',
            'road_code',
            'num_of_vehicle',
            'em_type_name',
            'road_significance_name',
            'formatted_address',
        ];
    }

    /**
     * @return \DateTime|null
     */
    public function getAccidentDatetime()
    {
        $datetime = $this->datetime['$numberLong'] / 100000;
        return $datetime ? new \DateTime('@' . $datetime) : null;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreated()
    {
        $created = $this->created_at['$numberLong'] / 100000;
        return $created ? new \DateTime('@' . $created) : null;
    }

    /**
     * @param array|\stdClass $data
     * @return static
     */
    public static function createFromArray($data)
    {
        $accident = new static();
        $accident->setAttributes($data, false);
        return $accident;
    }
}
