<?php

namespace Siropu\AdsManager\Criteria;

class Geo extends \XF\Criteria\AbstractCriteria
{
     protected $countryIsoCode;

     public function __construct(\XF\App $app, array $criteria)
     {
          parent::__construct($app, $criteria);

          $path = \XF::getAddOnDirectory() . '/Siropu/AdsManager/Vendor/MaxMind/';

          $geoLite2CityDb = $path . 'GeoLite2-City.mmdb';

          $this->countryIsoCode = $this->app->session()->get('samCountryIsoCode') ?? null;

          if (file_exists($geoLite2CityDb) && !$this->countryIsoCode)
          {
               require_once $path . 'autoload.php';

               try
               {
                    $reader = new \GeoIp2\Database\Reader($geoLite2CityDb);
                    $record = $reader->city($this->app->request()->getIp());

                    if ($isoCode = $record->country->isoCode)
                    {
                         $this->countryIsoCode = $isoCode;

                         $this->app->session()->set('samCountryIsoCode', $isoCode);
                    }
               }
               catch (\Exception $e)
               {
                    \XF::logException($e, false, 'MaxMind GeoLite2: ');
               }
          }
     }
     public function _matchCountry(array $data, \XF\Entity\User $user)
     {
          if ($this->countryIsoCode && !in_array($this->countryIsoCode, $data['country']))
          {
               return false;
          }

          return true;
     }
     public function _matchCountryNot(array $data, \XF\Entity\User $user)
     {
          if ($this->countryIsoCode && in_array($this->countryIsoCode, $data['country']))
          {
               return false;
          }

          return true;
     }
     public function _matchCity(array $data, \XF\Entity\User $user)
     {

     }
     public function _matchCityNot(array $data, \XF\Entity\User $user)
     {

     }
     public function getExtraTemplateData()
     {
          $templateData = [
			'countryList' => $this->getCountryList()
		];

          return $templateData;
     }
     public static function getCountryList()
     {
          return [
               'Africa' => [
                    'continent' => \XF::phrase('siropu_ads_manager_continent.africa'),
                    'countries' => [
                         'DZ' => 'Algeria',
                         'AO' => 'Angola',
                         'BJ' => 'Benin',
                         'BW' => 'Botswana',
                         'BF' => 'Burkina Faso',
                         'BI' => 'Burundi',
                         'CM' => 'Cameroon',
                         'CV' => 'Cape Verde',
                         'CF' => 'Central African Republic',
                         'TD' => 'Chad',
                         'KM' => 'Comoros',
                         'CG' => 'Congo - Brazzaville',
                         'CD' => 'Congo - Kinshasa',
                         'CI' => 'Côte d’Ivoire',
                         'DJ' => 'Djibouti',
                         'EG' => 'Egypt',
                         'GQ' => 'Equatorial Guinea',
                         'ER' => 'Eritrea',
                         'ET' => 'Ethiopia',
                         'GA' => 'Gabon',
                         'GM' => 'Gambia',
                         'GH' => 'Ghana',
                         'GN' => 'Guinea',
                         'GW' => 'Guinea-Bissau',
                         'KE' => 'Kenya',
                         'LS' => 'Lesotho',
                         'LR' => 'Liberia',
                         'LY' => 'Libya',
                         'MG' => 'Madagascar',
                         'MW' => 'Malawi',
                         'ML' => 'Mali',
                         'MR' => 'Mauritania',
                         'MU' => 'Mauritius',
                         'YT' => 'Mayotte',
                         'MA' => 'Morocco',
                         'MZ' => 'Mozambique',
                         'NA' => 'Namibia',
                         'NE' => 'Niger',
                         'NG' => 'Nigeria',
                         'RW' => 'Rwanda',
                         'RE' => 'Réunion',
                         'SH' => 'Saint Helena',
                         'SN' => 'Senegal',
                         'SC' => 'Seychelles',
                         'SL' => 'Sierra Leone',
                         'SO' => 'Somalia',
                         'ZA' => 'South Africa',
                         'SD' => 'Sudan',
                         'SZ' => 'Swaziland',
                         'ST' => 'São Tomé and Príncipe',
                         'TZ' => 'Tanzania',
                         'TG' => 'Togo',
                         'TN' => 'Tunisia',
                         'UG' => 'Uganda',
                         'EH' => 'Western Sahara',
                         'ZM' => 'Zambia',
                         'ZW' => 'Zimbabwe',
                    ]
               ],
               'Asia' => [
                    'continent' => \XF::phrase('siropu_ads_manager_continent.asia'),
                    'countries' => [
                         'AF' => 'Afghanistan',
                         'AM' => 'Armenia',
                         'AZ' => 'Azerbaijan',
                         'BH' => 'Bahrain',
                         'BD' => 'Bangladesh',
                         'BT' => 'Bhutan',
                         'BN' => 'Brunei',
                         'KH' => 'Cambodia',
                         'CN' => 'China',
                         'CY' => 'Cyprus',
                         'GE' => 'Georgia',
                         'HK' => 'Hong Kong SAR China',
                         'IN' => 'India',
                         'ID' => 'Indonesia',
                         'IR' => 'Iran',
                         'IQ' => 'Iraq',
                         'IL' => 'Israel',
                         'JP' => 'Japan',
                         'JO' => 'Jordan',
                         'KZ' => 'Kazakhstan',
                         'KW' => 'Kuwait',
                         'KG' => 'Kyrgyzstan',
                         'LA' => 'Laos',
                         'LB' => 'Lebanon',
                         'MO' => 'Macau SAR China',
                         'MY' => 'Malaysia',
                         'MV' => 'Maldives',
                         'MN' => 'Mongolia',
                         'MM' => 'Myanmar [Burma]',
                         'NP' => 'Nepal',
                         'NT' => 'Neutral Zone',
                         'KP' => 'North Korea',
                         'OM' => 'Oman',
                         'PK' => 'Pakistan',
                         'PS' => 'Palestinian Territories',
                         'YD' => 'People\'s Democratic Republic of Yemen',
                         'PH' => 'Philippines',
                         'QA' => 'Qatar',
                         'SA' => 'Saudi Arabia',
                         'SG' => 'Singapore',
                         'KR' => 'South Korea',
                         'LK' => 'Sri Lanka',
                         'SY' => 'Syria',
                         'TW' => 'Taiwan',
                         'TJ' => 'Tajikistan',
                         'TH' => 'Thailand',
                         'TL' => 'Timor-Leste',
                         'TR' => 'Turkey',
                         'TM' => 'Turkmenistan',
                         'AE' => 'United Arab Emirates',
                         'UZ' => 'Uzbekistan',
                         'VN' => 'Vietnam',
                         'YE' => 'Yemen',
                    ]
               ],
               'Europe' => [
                    'continent' => \XF::phrase('siropu_ads_manager_continent.europe'),
                    'countries' => [
                         'AL' => 'Albania',
                         'AD' => 'Andorra',
                         'AT' => 'Austria',
                         'BY' => 'Belarus',
                         'BE' => 'Belgium',
                         'BA' => 'Bosnia and Herzegovina',
                         'BG' => 'Bulgaria',
                         'HR' => 'Croatia',
                         'CY' => 'Cyprus',
                         'CZ' => 'Czech Republic',
                         'DK' => 'Denmark',
                         'DD' => 'East Germany',
                         'EE' => 'Estonia',
                         'FO' => 'Faroe Islands',
                         'FI' => 'Finland',
                         'FR' => 'France',
                         'DE' => 'Germany',
                         'GI' => 'Gibraltar',
                         'GR' => 'Greece',
                         'GG' => 'Guernsey',
                         'HU' => 'Hungary',
                         'IS' => 'Iceland',
                         'IE' => 'Ireland',
                         'IM' => 'Isle of Man',
                         'IT' => 'Italy',
                         'JE' => 'Jersey',
                         'LV' => 'Latvia',
                         'LI' => 'Liechtenstein',
                         'LT' => 'Lithuania',
                         'LU' => 'Luxembourg',
                         'MK' => 'Macedonia',
                         'MT' => 'Malta',
                         'FX' => 'Metropolitan France',
                         'MD' => 'Moldova',
                         'MC' => 'Monaco',
                         'ME' => 'Montenegro',
                         'NL' => 'Netherlands',
                         'NO' => 'Norway',
                         'PL' => 'Poland',
                         'PT' => 'Portugal',
                         'RO' => 'Romania',
                         'RU' => 'Russia',
                         'SM' => 'San Marino',
                         'RS' => 'Serbia',
                         'CS' => 'Serbia and Montenegro',
                         'SK' => 'Slovakia',
                         'SI' => 'Slovenia',
                         'ES' => 'Spain',
                         'SJ' => 'Svalbard and Jan Mayen',
                         'SE' => 'Sweden',
                         'CH' => 'Switzerland',
                         'UA' => 'Ukraine',
                         'SU' => 'Union of Soviet Socialist Republics',
                         'GB' => 'United Kingdom',
                         'VA' => 'Vatican City',
                         'AX' => 'Åland Islands'
                    ]
               ],
               'North America' => [
                    'continent' => \XF::phrase('siropu_ads_manager_continent.north_america'),
                    'countries' => [
                         'AG' => 'Antigua and Barbuda',
                         'BS' => 'Bahamas',
                         'BB' => 'Barbados',
                         'BZ' => 'Belize',
                         'CA' => 'Canada',
                         'CR' => 'Costa Rica',
                         'CU' => 'Cuba',
                         'DM' => 'Dominica',
                         'DO' => 'Dominican Republic',
                         'SV' => 'El Salvador',
                         'GD' => 'Grenada',
                         'GT' => 'Guatemala',
                         'HT' => 'Haiti',
                         'HN' => 'Honduras',
                         'JM' => 'Jamaica',
                         'MX' => 'Mexico',
                         'NI' => 'Nicaragua',
                         'PA' => 'Panama',
                         'KN' => 'Saint Kitts and Nevis',
                         'LC' => 'Saint Lucia',
                         'VC' => 'Saint Vincent and the Grenadines',
                         'TT' => 'Trinidad and Tobago',
                         'US' => 'United States'
                    ]
               ],
               'South America' => [
                    'continent' => \XF::phrase('siropu_ads_manager_continent.south_america'),
                    'countries' => [
                         'AR' => 'Argentina',
                         'BO' => 'Bolivia',
                         'BR' => 'Brazil',
                         'CL' => 'Chile',
                         'CO' => 'Colombia',
                         'EC' => 'Ecuador',
                         'GY' => 'Guyana',
                         'PY' => 'Paraguay',
                         'PE' => 'Peru',
                         'SR' => 'Suriname',
                         'UY' => 'Uruguay',
                         'VE' => 'Venezuela'
                    ]
               ],
               'Oceania' => [
                    'continent' => \XF::phrase('siropu_ads_manager_continent.oceania'),
                    'countries' => [
                         'AS' => 'American Samoa',
                         'AQ' => 'Antarctica',
                         'AU' => 'Australia',
                         'BV' => 'Bouvet Island',
                         'IO' => 'British Indian Ocean Territory',
                         'CX' => 'Christmas Island',
                         'CC' => 'Cocos [Keeling] Islands',
                         'CK' => 'Cook Islands',
                         'FJ' => 'Fiji',
                         'PF' => 'French Polynesia',
                         'TF' => 'French Southern Territories',
                         'GU' => 'Guam',
                         'HM' => 'Heard Island and McDonald Islands',
                         'KI' => 'Kiribati',
                         'MH' => 'Marshall Islands',
                         'FM' => 'Micronesia',
                         'NR' => 'Nauru',
                         'NC' => 'New Caledonia',
                         'NZ' => 'New Zealand',
                         'NU' => 'Niue',
                         'NF' => 'Norfolk Island',
                         'MP' => 'Northern Mariana Islands',
                         'PW' => 'Palau',
                         'PG' => 'Papua New Guinea',
                         'PN' => 'Pitcairn Islands',
                         'WS' => 'Samoa',
                         'SB' => 'Solomon Islands',
                         'GS' => 'South Georgia and the South Sandwich Islands',
                         'TK' => 'Tokelau',
                         'TO' => 'Tonga',
                         'TV' => 'Tuvalu',
                         'UM' => 'U.S. Minor Outlying Islands',
                         'VU' => 'Vanuatu',
                         'WF' => 'Wallis and Futuna'
                    ]
               ]
          ];
     }
     private function getItemArray($items)
     {
          return \Siropu\AdsManager\Util\Arr::getItemArray($items);
     }
}
