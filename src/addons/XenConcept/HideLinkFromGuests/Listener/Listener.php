<?php

/*************************************************************************
 * Hide Link From Guests - XenConcept (c) 2017
 * All Rights Reserved.
 **************************************************************************
 * This file is subject to the terms and conditions defined in the Licence
 * Agreement available at Try it like it buy it :)
 *************************************************************************/

namespace XenConcept\HideLinkFromGuests\Listener;

class Listener
{
    public static function optionTabbed(\XF\Template\Templater $templater, &$type, &$template, &$name, array &$arguments, array &$globalVars)
    {
        if ($arguments['group']->group_id == 'xc_hide_links_from_guests')
        {
            // Override template name
            $template = 'xc_hide_links_medias_to_guests_option_tabbed_macros';
        }
    }

    public static function templaterPreRender(\XF\Template\Templater $templater, &$type, &$template, array &$params)
    {

        if (isset($params['groups']['xc_hide_links_from_guests']))
        {
            $template = 'xc_hide_links_medias_to_guests_addon_option_tabbed_macros';
        }
    }


}