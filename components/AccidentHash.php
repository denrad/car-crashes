<?php

namespace app\components;

use app\models\Accident;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class AccidentHash extends Component
{
    const HASH_ALGO = 'sha1';

    /**
     * Получаем шех инциндента, сформированный по основным полям
     * @param Accident|array $accident
     * @return string
     */
    public function getHash($accident)
    {
        return $this->hash(
            ArrayHelper::getValue(
                $accident,
                [
                    'mt_rate_code',
                    'road_name',
                    'road_significance_code',
                    'em_type_code',
                    'region_code',
                    'em_moment_date',
                    'road_type_code',
                    'loss_amount',
                    'loss_child_amount',
                    'suffer_amount',
                    'suffer_child_amount',
                    'em_moment_time',
                ]
            )
        );
    }

    /**
     * @param array $vehicle
     * @return string
     */
    public function getVehicleHash(array $vehicle)
    {
        return $this->hash(
            ArrayHelper::getValue(
                $vehicle,
                [
                    'rudder_type_code',
                    'vl_year',
                    'prod_type_code',
                    'okfs_code',
                ]
            )
        );
    }

    /**
     * @param mixed $element
     * @return string
     */
    protected function hash($element)
    {
        $text = is_scalar($element) ? $element : json_encode($element);
        return hash(self::HASH_ALGO, $text);
    }
}
