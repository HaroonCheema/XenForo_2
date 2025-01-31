<?php

namespace FS\UserCarDetails\Job;

use XF\Job\AbstractJob;

class CarDetails extends AbstractJob
{
    protected $defaultData = [
        'limit' => 1000,
    ];

    public function run($maxRunTime)
    {
        $startTime = microtime(true);

        $limit = $this->data['limit'];

        $conditions = [
            ['model_id', '!=', 0],
            ['location_id', '!=', 0],
            ['car_colour', '!=', ''],
            ['car_trim', '!=', ''],
            ['car_plaque_number', '!=', ''],
            ['car_reg_number', '!=', ''],
            ['car_reg_date', '!=', 0],
            ['car_forum_name', '!=', ''],
            ['car_unique_information', '!=', '']
        ];

        $carDetails = \XF::finder('XF:User')->whereOr($conditions)->limitByPage(1, $limit)->fetch();

        if (!$carDetails->count()) {

            return $this->complete();
        }

        foreach ($carDetails as $key => $user) {

            $addCarExist = \XF::finder('FS\UserCarDetails:UserCarDetail')->where('username', $user['username'])->fetchOne();

            if (!$addCarExist) {
                $addCarExist = \xf::app()->em()->create('FS\UserCarDetails:UserCarDetail');
            }

            $addCarExist->username = $user['username'];
            $addCarExist->model_id = $user['model_id'];
            $addCarExist->car_colour = $user['car_colour'];
            $addCarExist->car_trim = $user['car_trim'];
            $addCarExist->location_id = $user['location_id'];
            $addCarExist->car_plaque_number = $user['car_plaque_number'];
            $addCarExist->car_reg_number = $user['car_reg_number'];
            $addCarExist->car_forum_name = $user['car_forum_name'];
            $addCarExist->car_unique_information = $user['car_unique_information'];
            $addCarExist->car_reg_date = $user['car_reg_date'];

            $addCarExist->save();

            $input = [
                'model_id' => 0,
                'car_colour' => '',
                'car_trim' => '',
                'location_id' => 0,
                'car_plaque_number' => '',
                'car_reg_number' => '',
                'car_forum_name' => '',
                'car_unique_information' => '',
                'car_reg_date' => 0,
            ];

            $user->bulkSet($input);
            $user->save();

            if (microtime(true) - $startTime >= $maxRunTime) {
                break;
            }
        }

        return $this->resume();
    }

    public function writelevel() {}

    public function getStatusMessage()
    {
        return \XF::phrase('processing_successfully...');
    }

    public function canCancel()
    {
        return false;
    }

    public function canTriggerByChoice()
    {
        return false;
    }
}
