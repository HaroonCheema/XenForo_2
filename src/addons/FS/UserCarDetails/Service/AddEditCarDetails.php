<?php

namespace FS\UserCarDetails\Service;

class AddEditCarDetails extends \XF\Service\AbstractService
{

    public function filterInputs(\XF\Entity\User $user)
    {
        $input = \xf::app()->request()->filter([
            'model_id' => 'int',
            'car_colour' => 'str',
            'car_trim' => 'str',
            'car_location' => 'str',
            'car_plaque_number' => 'str',
            'car_reg_number' => 'str',
            'car_forum_name' => 'str',
            'car_unique_information' => 'str'
        ]);

        $request = \XF::app()->request();

        $currentUrl = $request->getRequestUri();

        if (!preg_match('/\badmin\.php\b/', $currentUrl)) {

            if (!$input['model_id'] || $input['car_colour'] == '' || $input['car_trim'] == '' || $input['car_plaque_number'] == '' || $input['car_reg_number'] == '') {

                throw new \XF\PrintableException(\XF::phrase('please_complete_required_fields'));
            }
        }

        if (\xf::app()->request()->filter('car_reg_date', 'str')) {
            $input['car_reg_date'] = strtotime(\xf::app()->request()->filter('car_reg_date', 'str'));
        } else {
            $input['car_reg_date'] = 0;
        }

        $user->bulkSet($input);

        $user->save();

        return true;
    }
}
