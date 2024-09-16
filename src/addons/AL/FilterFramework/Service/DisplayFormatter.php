<?php
/** 
* @package [AL] Filter Framework
* @author AddonsLab
* @license https://addonslab.com/
* @link https://addonslab.com/
* @version 1.0.0
This software is furnished under a license and may be used and copied
only  in  accordance  with  the  terms  of such  license and with the
inclusion of the above copyright notice.  This software  or any other
copies thereof may not be provided or otherwise made available to any
other person.  No title to and  ownership of the  software is  hereby
transferred.                                                         
                                                                     
You may not reverse  engineer, decompile, defeat  license  encryption
mechanisms, or  disassemble this software product or software product
license.  AddonsLab may terminate this license if you don't comply with
any of these terms and conditions.  In such event,  licensee  agrees 
to return licensor  or destroy  all copies of software  upon termination 
of the license.
*/


namespace AL\FilterFramework\Service;

use AddonsLab\Core\LazyLoadList;
use AL\FilterFramework\ActiveFilterInfo;
use AL\FilterFramework\ContentTypeProviderInterface;
use AL\FilterFramework\FilterApp;
use AL\LocationField\Constants;
use AL\LocationField\Service\Configuration;
use XF\CustomField\Definition;
use XF\Service\AbstractService;

class DisplayFormatter extends AbstractService
{
    protected $contentTypeProvider;

    public function __construct(
        \XF\App $app,
        ContentTypeProviderInterface $contentTypeProvider
    )
    {
        parent::__construct($app);
        $this->contentTypeProvider = $contentTypeProvider;
    }

    /**
     * @param array $filterData
     * Based on input data provided prepares data required for rending active filters
     */
    public function prepareActiveFilters(array $filterData)
    {
        if (empty($filterData))
        {
            return [];
        }

        $activeFilterData = FilterApp::getExtendedAttributeHandler($this->contentTypeProvider)->getActiveFilters($filterData);

        $fieldDefinitions = $this->contentTypeProvider->getFieldDefinitions();

        /** @var TypeProvider $typeProvider */
        $typeProvider = FilterApp::getTypeProvider();
        $inputTransformer = FilterApp::getInputTransformer($this->contentTypeProvider);
        $contentTypeProvider = $this->contentTypeProvider;

        /** @var Definition $fieldDefinition */
        foreach ($fieldDefinitions as $fieldId => $fieldDefinition)
        {
            // will handle the case of numeric fields, including dates and ratings
            if ($inputTransformer->normalizeFieldInputValue($filterData, $fieldId) === false)
            {
                continue;
            }

            $template = '';
            $phrase = '';
            $phraseParams = [];
            $templateParams = [];
            $showLabel = true; // if false the name of the field itself will not be shown

            if ($typeProvider->isColor($fieldDefinition) && ($labColor = $typeProvider->getColor($fieldDefinition, $filterData)))
            {
                $showLabel = false;
                $template = 'color';
                /** @var ColorConverter $colorConverter */
                $colorConverter = \XF::service('AL\FilterFramework:ColorConverter');
                $templateParams = [
                    'backgroundColor' => $filterData[$fieldId],
                    'color' => $colorConverter->getContrastColor($filterData[$fieldId]),
                ];
            }
            else if ($typeProvider->isLocationField($fieldDefinition))
            {
                /** @var Configuration $configuration */
                $configuration = $fieldDefinition->getLocationConfiguration();
                if (
                    $configuration->getSearchFormatOption() === Constants::SEARCH_FORMAT_RANGE
                    && !$this->contentTypeProvider->getGoogleApiKeySetting()
                )
                {
                    // No filter is possible without Google API key
                    continue;
                }

                $template = 'location';
                $templateParams = $filterData[$fieldId];
                $templateParams['config'] = $configuration;
                $templateParams['data'] = $fieldDefinition->getLocationData($filterData[$fieldId], false);
            }
            else if ($typeProvider->isInteger($fieldDefinition) || $typeProvider->isFloat($fieldDefinition))
            {
                $filterValue = $typeProvider->getIndexTableValue($fieldDefinition, $filterData);
                if ($filterValue === false)
                {
                    // the data was not set in filters at all
                    continue;
                }

                list($operator, $value) = $filterValue;

                if ($typeProvider->isStarField($fieldDefinition))
                {
                    $template = 'stars'; // no need for any phrase, will use a template to render
                    $templateParams = ['stars' => $value];
                }
                else
                {
                    $postfix = $typeProvider->isDateField($fieldDefinition) ? '_date' : '';
                    switch ($operator)
                    {
                        case 'BETWEEN':
                            $phrase = $contentTypeProvider->getOptionPrefix() . '_value_between_x_y';
                            $phraseParams =
                                [
                                    'x' => $this->formatFieldForDisplay($fieldDefinition, $value[0]),
                                    'y' => $this->formatFieldForDisplay($fieldDefinition, $value[1])
                                ];
                            break;
                        case '<=':
                            $phrase = $contentTypeProvider->getOptionPrefix() . '_less_than_x';
                            $phraseParams = ['x' => $this->formatFieldForDisplay($fieldDefinition, $value)];
                            break;
                        case '>=':
                            $phrase = $contentTypeProvider->getOptionPrefix() . '_more_than_x';
                            $phraseParams = ['x' => $this->formatFieldForDisplay($fieldDefinition, $value)];
                            break;
                        case '=':
                            $phrase = $contentTypeProvider->getOptionPrefix() . '_equal_to_x';
                            $phraseParams = ['x' => $this->formatFieldForDisplay($fieldDefinition, $value)];
                            break;
                        default:
                            throw new Exception($this->error(\XF::phrase($contentTypeProvider->getOptionPrefix() . '_field_operator_is_undefined')));
                            break;

                    }
                    $phrase .= $postfix;
                }
            }
            else if ($typeProvider->isFreeText($fieldDefinition))
            {
                if (empty($filterData[$fieldId]))
                {
                    continue;
                }

                $string = $this->formatFieldForDisplay($fieldDefinition, $filterData[$fieldId]);

                $phrase = $contentTypeProvider->getOptionPrefix() . '_match_text';
                $phraseParams = [
                    'string' => htmlspecialchars($string)
                ];
            }
            else if ($typeProvider->isSingleOption($fieldDefinition) || $typeProvider->isMultipleOption($fieldDefinition))
            {
                if (empty($filterData[$fieldId]))
                {
                    continue;
                }

                $formattedValue = $this->formatFieldForDisplay($fieldDefinition, $filterData[$fieldId]);

                if (!$formattedValue)
                {
                    continue;
                }

                $phrase = $contentTypeProvider->getOptionPrefix() . '_match_text';
                $phraseParams = [
                    'string' => $formattedValue
                ];

                // remove the lines below if we don't need them anymore
                /*$selectedValues = $this->formatFieldForDisplay($fieldDefinition, $filterData[$fieldId]);

                if (empty($selectedValues))
                {
                    continue;
                }

                $template = 'selection';
                $templateParams['options'] = $selectedValues;*/
            }

            if ($template || $phrase)
            {
                if ($phrase)
                {
                    $phrase = \XF::phrase($phrase, $phraseParams);
                }

                $activeFilterData[$fieldId] = new ActiveFilterInfo([
                    'showLabel' => $showLabel,
                    'title' => $fieldDefinition['title'],
                    'template' => $template,
                    'templateParams' => $templateParams,
                    'phrase' => $phrase,
                    'match_type' => $fieldDefinition['match_type'],
                    'field_type' => $fieldDefinition['field_type'],
                ]);
            }
        }

        return $activeFilterData;
    }

    /**
     * @param Definition $field
     * @param $value
     * @return array|mixed|null|string|string[]
     */
    public function formatFieldForDisplay($field, $value)
    {
        $typeProvider = FilterApp::getTypeProvider();

        if($field->display_template)
        {
            $field->display_template = strip_tags($field->display_template);
        }

        if ($typeProvider->isDateField($field))
        {
            $value = \XF::language()->date($value);
        }
        else if ($typeProvider->isInteger($field) || $typeProvider->isFloat($field))
        {
            $exclusionList = $this->contentTypeProvider->getNumberFormattingExclusionListSetting();
            $exclusionList = $exclusionList ? array_map('trim', explode(',', $exclusionList)) : [];
            if (!in_array($field->field_id, $exclusionList, true))
            {
                $value = \XF::language()->numberFormat($value, $typeProvider->isInteger($field) ? 0 : 1);
            }

            // format according to display template setting
            $value = $field->getFormattedValue($value);

        }
        else if ($typeProvider->isFreeText($field))
        {
            $formatter = new \XF\Str\Formatter();
            $value = $formatter->wholeWordTrim($value, 20);
            $value = $field->getFormattedValue($value);
        }
        else if (
            $typeProvider->isSingleOption($field)
            || $typeProvider->isMultipleOption($field)
        )
        {
            $value = (array)$value;
            $list = new LazyLoadList(', ');

            if ($typeProvider->isSingleOption($field))
            {
                $value = array_map(function ($v) use ($field, $list)
                {
                    $list->addItem($field->getFormattedValue($v));
                }, $value);

            }
            elseif ($typeProvider->isMultipleOption($field))
            {

                $value = array_map(function ($v) use ($field, $list)
                {
                    $list->addItem($field->getFormattedValue(array_flip(array($v))));
                }, $value);
            }

            $value = (string)$list;

            /*$selectedValues = [];
            foreach ($value AS $selectedOption)
            {
                $phrase = $this->contentTypeProvider->getPhraseForOption($field, $selectedOption);
                $selectedValues[] = \XF::phrase($phrase);
            }
            $value = $selectedValues;*/
        }

        return $value;
    }
}
