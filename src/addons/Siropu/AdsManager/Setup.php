<?php

namespace Siropu\AdsManager;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;
use XF\Util\File;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

     public function checkRequirements(&$errors = [], &$warnings = [])
	{
          if (\XF::em()->find('XF:AddOn', 'Siropu/AdsManagerLite'))
          {
               $errors[] = 'You have to uninstall Ads Manager 2 Lite in order to install Ads Manager 2.';
          }
	}
	public function installStep1()
	{
		$this->createAdTable();
		$this->createPackageTable();
		$this->createPositionTable();
		$this->createInvoiceTable();
		$this->createPromoCodeTable();
		$this->createDailyStatsTable();
		$this->createClickStatsTable();
		$this->createClickFraudTable();
          $this->createStatsAccessTable();
	}
	public function installStep2()
	{
		$this->addDefaultPositionData();
	}
	public function installStep3()
	{
		$this->addPurchasableType();
          $this->addPaymentProvider();
	}
	public function installStep4()
	{
		$this->applyDefaultPermissions();
	}
     public function installStep5()
     {
          $this->createWidgets();
     }
     public function installStep6()
     {
          $this->addUserOptionFields();
     }
	public function upgrade2000035Step1()
	{
		$sm = $this->schemaManager();

		if ($sm->tableExists('xf_siropu_ads_manager_ad'))
		{
			$sm->alterTable('xf_siropu_ads_manager_ad', function(Alter $table)
			{
				$table->renameColumn('content', 'content_1');
				$table->renameColumn('banner_code', 'content_2');
				$table->renameColumn('backup', 'content_3');
			});
		}
	}
	public function upgrade2000035Step2()
	{
		$sm = $this->schemaManager();

		if ($sm->tableExists('xf_siropu_ads_manager_packages') && !$sm->tableExists('xf_siropu_ads_manager_package'))
		{
			$this->createPackageTable();

			$results = $this->db()->fetchAll('
				SELECT *
				FROM xf_siropu_ads_manager_packages
			');

			foreach ($results as $result)
			{
				$type = $result['type'];

				$settings = [
					'unit_alignment'   => isset($result['style']['align']) ? $result['style']['align'] : '',
					'unit_size'        => isset($result['style']['size']) ? $result['style']['size'] : '',
					'count_views'      => $result['count_ad_views'],
					'count_clicks'     => $result['count_ad_clicks'],
					'daily_stats'      => $result['daily_stats'],
					'click_stats'      => $result['click_stats'],
					'nofollow'         => $result['nofollow'],
					'target_blank'     => $result['target_blank'],
					'hide_from_robots' => $result['hide_from_robots'],
					'keyword_limit'    => $result['keyword_limit']
				];

				if ($result['js_rotator'])
				{
					$settings['carousel'] = 1;
					$settings['slick']['slidesToShow'] = 1;
					$settings['slick']['autoplaySpeed'] = $result['js_interval'] * 1000;
				}

				$advertiserCriteria = [];
				$advCriteria = @unserialize($result['advertiser_criteria']);

				if ($result['enabled'])
				{
					$advertiserCriteria[] = [
						'rule' => 'user_groups',
						'data' => !empty($advCriteria['user_groups']) ? ['user_group_ids' => $advCriteria['user_groups']] : []
					];
				}

				$package = \XF::em()->create('Siropu\AdsManager:Package');
				$package->bulkSet([
					'package_id'          => $result['package_id'],
					'type'                => $type,
					'position'            => $this->getNewPositions($result['positions']),
					'title'               => $result['name'],
					'description'         => $result['description'],
					'guidelines'          => $result['guidelines'],
					'cost_amount'         => $result['cost_amount'],
					'cost_custom'         => $this->getArrayPairFromStr($result['cost_list'], 'item', 'cost'),
					'cost_currency'       => $result['cost_currency'],
					'cost_per'            => strtolower($result['cost_per']),
					'min_purchase'        => $result['min_purchase'],
					'max_purchase'        => $result['max_purchase'],
					'discount'            => $this->getArrayPairFromStr($result['discount'], 'purchase', 'discount'),
					'settings'            => $settings,
					'ad_allowed_limit'    => $result['max_items_allowed'],
					'ad_display_limit'    => $result['max_items_display'],
					'ad_display_order'    => $result['ads_order'],
					'advertise_here'      => $result['advertise_here'],
					'page_criteria'       => $this->getNewCriteria($result['page_criteria']),
					'user_criteria'       => $this->getNewCriteria($result['user_criteria']),
					'position_criteria'   => $this->getNewPositionCriteria($result['position_criteria'], $result['item_id']),
					'device_criteria'     => $this->getNewDeviceCriteria($result['device_criteria']),
					'geo_criteria'        => $this->getNewGeoCriteria($result['geoip_criteria']),
					'advertiser_criteria' => $advertiserCriteria,
					'preview'             => isset($result['preview']) ? $result['preview'] : '',
					'display_order'       => isset($result['display_order']) ? $result['display_order'] : 0

				], ['forceSet' => true]);
				$package->save(false);

				if (!empty($result['preview']))
				{
					$existingPath = 'data://Siropu/images/preview/' . $result['preview'];
					$newPath      = 'data://siropu/am/package/' . $result['preview'];

					if ($this->app->fs()->has($existingPath))
					{
						try
						{
							$temp = File::copyAbstractedPathToTempFile($existingPath);

							File::copyFileToAbstractedPath($temp, $newPath);
							File::deleteFromAbstractedPath($existingPath);
						}
						catch (\Exception $e) {}
					}
				}
			}

			$sm->dropTable('xf_siropu_ads_manager_packages');
		}
	}
	public function upgrade2000035Step3()
	{
		$sm = $this->schemaManager();

		if ($sm->tableExists('xf_siropu_ads_manager_ads') && !$sm->tableExists('xf_siropu_ads_manager_ad'))
		{
			$this->createAdTable();

			$results = $this->db()->fetchAll('
				SELECT *
				FROM xf_siropu_ads_manager_ads
				WHERE status NOT IN ("Rejected")
				AND is_placeholder = 0
			');

			foreach ($results as $result)
			{
				$type = $result['type'];

				$settings = [
					'count_views'      => $result['count_views'],
					'count_clicks'     => $result['count_clicks'],
					'daily_stats'      => $result['daily_stats'],
					'click_stats'      => $result['click_stats'],
					'ga_stats'         => $result['ga_stats'],
					'nofollow'         => $result['nofollow'],
					'target_blank'     => $result['target_blank'],
					'hide_from_robots' => $result['hide_from_robots'],
					'keyword_limit'    => $result['keyword_limit'],
					'display_after'    => $result['display_after'],
					'hide_after'       => $result['hide_after']
				];

				$ad = \XF::em()->create('Siropu\AdsManager:Ad');
				$ad->bulkSet([
					'ad_id'             => $result['ad_id'],
					'package_id'        => $result['package_id'],
					'inherit_package'   => $result['inherit_settings'],
					'type'              => $type,
					'user_id'           => $result['user_id'],
					'username'          => $result['username'],
					'name'              => $result['name'],
					'position'          => $this->getNewPositions($result['positions']),
                         'title'             => $result['title'],
					'target_url'        => $result['url'],
					'item_id'           => in_array($type, ['sticky', 'featured']) ? intval($result['code']) : 0,
					'create_date'       => $result['date_created'],
					'start_date'        => $result['date_start'],
					'end_date'          => $result['date_end'],
					'view_limit'        => $result['view_limit'],
					'click_limit'       => $result['click_limit'],
					'settings'          => $settings,
					'display_order'     => $result['ad_order'],
					'display_priority'  => $result['priority'],
					'page_criteria'     => $this->getNewCriteria($result['page_criteria']),
					'user_criteria'     => $this->getNewCriteria($result['user_criteria']),
					'position_criteria' => $this->getNewPositionCriteria($result['position_criteria'], $result['item_id']),
					'device_criteria'   => $this->getNewDeviceCriteria($result['device_criteria']),
					'geo_criteria'      => $this->getNewGeoCriteria($result['geoip_criteria']),
					'view_count'        => $result['view_count'],
					'click_count'       => $result['click_count'],
					'ctr'               => $result['ctr'],
					'status'            => strtolower($result['status'])
				], ['forceSet' => true]);

				switch ($type)
				{
					case 'code':
						$ad->content_1 = $result['code'];
						$ad->content_3 = $result['backup'];
						break;
					case 'banner':
						$bannerFile = [];

						if ($result['banner'])
						{
							$bannerFile[] = $result['banner'];
						}

						if (!empty($result['banner_extra']))
						{
							$bannerExtra = @unserialize($result['banner_extra']);

							foreach ($bannerExtra as $banner)
							{
								$bannerFile[] = $banner;
							}
						}

						$ad->banner_file = $bannerFile;

						if ($result['banner_url'])
						{
							$ad->banner_url = [$result['banner_url']];
						}

                              if ($result['code'])
                              {
                                   $ad->content_2 = $result['code'];
                              }

						$ad->content_3 = $result['backup'];
						break;
					case 'text':
						$ad->content_1 = $result['description'];
						break;
                         case 'keyword':
                              $ad->content_1 = $result['items'];
                              $ad->title = $result['description'];
                              break;
                         case 'sticky':
                         case 'featured':
                              $ad->item_id = intval($result['items']);
                              break;
				}

                    $extraData = [
					'email_notification' => $result['email_notifications'],
					'alert_notification' => $result['alert_notifications'],
					'count_exclude'      => $result['count_exclude'],
					'active_since'       => $result['date_active'],
					'last_change'        => $result['date_last_change'],
					'last_active'        => $result['date_last_active'],
					'notes'              => $result['notes'],
					'reject_reason'      => $result['reject_reason'],
					'prev_status'        => strtolower($result['status_old'])
				];

                    if (!empty($result['purchase']))
                    {
                         $extraData['purchase'] = $result['purchase'];
                    }

                    $ad->updateExtraData($extraData);

				$ad->save(false);

				if ($type == 'banner')
				{
					foreach ($ad->banner_file as $banner)
					{
						$existingPath = 'data://Siropu/images/' . $banner;
						$newPath      = 'data://siropu/am/user/' . $banner;

						if ($this->app->fs()->has($existingPath))
						{
							try
							{
								$temp = File::copyAbstractedPathToTempFile($existingPath);

								File::copyFileToAbstractedPath($temp, $newPath);
								File::deleteFromAbstractedPath($existingPath);
							}
							catch (\Exception $e) {}
						}
					}
				}
			}

			$sm->dropTable('xf_siropu_ads_manager_ads');
		}
	}
	public function upgrade2000035Step4()
	{
		$sm = $this->schemaManager();

		if ($sm->tableExists('xf_siropu_ads_manager_transactions') && !$sm->tableExists('xf_siropu_ads_manager_invoice'))
		{
			$this->createInvoiceTable();

			$results = $this->db()->fetchAll('
				SELECT *
				FROM xf_siropu_ads_manager_transactions
				WHERE status NOT IN ("Cancelled")
			');

			foreach ($results as $result)
			{
				$invoice = \XF::em()->create('Siropu\AdsManager:Invoice');
				$invoice->bulkSet([
					'invoice_id'    => $result['transaction_id'],
					'ad_id'         => $result['ad_id'],
					'user_id'       => $result['user_id'],
					'username'      => $result['username'],
					'cost_amount'   => $result['cost_amount'],
					'cost_currency' => $result['cost_currency'],
					'promo_code'    => $result['promo_code'],
					'create_date'   => $result['date_generated'],
					'complete_date' => $result['date_completed'],
					'invoice_file'  => $result['download'] ?: '',
					'status'        => strtolower($result['status'])
				], ['forceSet' => true]);
				$invoice->save(false);

				if ($result['download'])
				{
					$existingPath = "data://Siropu/invoices/{$result['transaction_id']}/{$result['download']}";
					$newPath      = "data://siropu/am/invoice/{$result['transaction_id']}/{$result['download']}";

					if ($this->app->fs()->has($existingPath))
					{
						$temp = File::copyAbstractedPathToTempFile($existingPath);

						File::copyFileToAbstractedPath($temp, $newPath);
						File::deleteFromAbstractedPath($existingPath);
					}
				}
			}

			$sm->dropTable('xf_siropu_ads_manager_transactions');
		}
	}
	public function upgrade2000035Step5()
	{
		$sm = $this->schemaManager();

		if ($sm->tableExists('xf_siropu_ads_manager_promo_codes') && !$sm->tableExists('xf_siropu_ads_manager_promo_code'))
		{
			$this->createPromoCodeTable();

			$results = $this->db()->fetchAll('
				SELECT *
				FROM xf_siropu_ads_manager_promo_codes
			');

			foreach ($results as $result)
			{
				$promoCode = \XF::em()->create('Siropu\AdsManager:PromoCode');
				$promoCode->bulkSet([
					'promo_code'        => $result['code'],
					'value'             => $result['value'],
					'type'              => $result['type'],
					'package'           => array_filter(explode(',', $result['packages'])),
					'invoice_amount'    => $result['min_transaction_value'],
					'expire_date'       => $result['date_expire'],
					'user_usage_limit'  => $result['usage_limit_user'],
					'total_usage_limit' => $result['usage_limit_total'],
					'user_criteria'     => $this->getNewCriteria($result['user_criteria']),
					'create_date'       => $result['date_created'],
					'usage_count'       => $result['usage_count'],
					'enabled'           => $result['enabled']
				], ['forceSet' => true]);
				$promoCode->save(false);
			}

			$sm->dropTable('xf_siropu_ads_manager_promo_codes');
		}
	}
	public function upgrade2000035Step6()
	{
		if (!$this->schemaManager()->tableExists('xf_siropu_ads_manager_position'))
		{
			$this->createPositionTable();
			$this->addDefaultPositionData();
		}
	}
	public function upgrade2000035Step7()
	{
		$sm = $this->schemaManager();

		if ($sm->tableExists('xf_siropu_ads_manager_positions_categories'))
		{
			$sm->dropTable('xf_siropu_ads_manager_positions_categories');
		}

		if ($sm->tableExists('xf_siropu_ads_manager_positions'))
		{
			$sm->dropTable('xf_siropu_ads_manager_positions');
		}

		if ($sm->tableExists('xf_siropu_ads_manager_stats_clicks'))
		{
			$sm->dropTable('xf_siropu_ads_manager_stats_clicks');
		}

		if ($sm->tableExists('xf_siropu_ads_manager_subscriptions'))
		{
			$sm->dropTable('xf_siropu_ads_manager_subscriptions');
		}
	}
	public function upgrade2000035Step8()
	{
		$sm = $this->schemaManager();

		if ($sm->columnExists('xf_siropu_ads_manager_stats_daily', 'id'))
		{
			$sm->dropTable('xf_siropu_ads_manager_stats_daily');

			$this->createDailyStatsTable();
		}

		if (!$sm->tableExists('xf_siropu_ads_manager_stats_click'))
		{
			$this->createClickStatsTable();
		}
	}
	public function upgrade2000035Step9()
	{
		$db = $this->db();

		$db->delete('xf_content_type_field', "content_type = 'siropu_ads_manager'");
		$db->delete('xf_option', "addon_id = 'siropu_ads_manager'");
		$db->delete('xf_option_group', "addon_id = 'siropu_ads_manager'");
		$db->delete('xf_option_group_relation', "group_id = 'siropu_ads_manager'");
	}
	public function upgrade2000035Step10()
	{
		$this->addPurchasableType();
	}
	public function upgrade2000170Step1()
	{
		$this->rebuildPositionCache();
	}
	public function upgrade2000270Step1()
	{
		$this->schemaManager()->alterTable('xf_siropu_ads_manager_stats_click', function(Alter $table)
		{
			$table->addColumn('image_url', 'varchar', 255);
		});
	}
	public function upgrade2000370Step1()
	{
		$this->createClickFraudTable();
	}
     public function upgrade2000570Step1()
	{
		$this->schemaManager()->alterTable('xf_siropu_ads_manager_ad_extra', function(Alter $table)
		{
			$table->addColumn('prev_prefix', 'int')->setDefault(0);
		});
	}
     public function upgrade2010070Step1()
	{
		$this->schemaManager()->alterTable('xf_siropu_ads_manager_package', function(Alter $table)
		{
			$table->addColumn('content', 'text');
		});

          $positions = [
               [
                    'position_id'   => 'javascript',
                    'category_id'   => 0,
                    'title'         => 'JavaScript',
                    'description'   => 'Position used for popup and background ads.',
                    'display_order' => 4
               ]
          ];

          $this->insertPositions($positions);
	}
     public function upgrade2011070Step1()
	{
          $this->createWidgets();

          $positions = [
               [
				'position_id'   => 'header_above',
				'category_id'   => 2,
				'title'         => 'Above header',
				'description'   => '',
				'display_order' => 1
			],
               [
				'position_id'   => 'footer',
				'category_id'   => 2,
				'title'         => 'Footer',
				'description'   => '',
				'display_order' => 9
			],
               [
				'position_id'   => 'footer_below',
				'category_id'   => 2,
				'title'         => 'Below footer',
				'description'   => '',
				'display_order' => 10
			],
          ];

          $this->insertPositions($positions);

          \XF::repository('Siropu\AdsManager:Ad')->rebuildWidgetsCache();
     }
     public function upgrade2013070Step1()
	{
          $sm = $this->schemaManager();

		$sm->alterTable('xf_siropu_ads_manager_ad_extra', function(Alter $table)
		{
			$table->addColumn('advertiser_list', 'tinyint', 1)->setDefault(0);
		});

          $sm->alterTable('xf_siropu_ads_manager_package', function(Alter $table)
		{
			$table->addColumn('advertiser_purchase_limit', 'tinyint', 3)->setDefault(0);
		});

          $this->addPaymentProvider();
	}
     public function upgrade2020070Step1()
	{
          $this->createStatsAccessTable();

		$this->schemaManager()->alterTable('xf_siropu_ads_manager_ad', function(Alter $table)
		{
			$table->addColumn('daily_view_limit', 'int')->setDefault(0);
		});

          $this->schemaManager()->alterTable('xf_siropu_ads_manager_invoice', function(Alter $table)
		{
			$table->changeColumn('length_amount', 'int');
		});
     }
     public function upgrade2020070Step2()
	{
          $positions = [
               [
				'position_id'   => 'post_above_signature_',
				'category_id'   => 4,
				'title'         => 'Above thread post x signature',
				'description'   => '',
				'display_order' => 5
			],
			[
				'position_id'   => 'post_below_signature_',
				'category_id'   => 4,
				'title'         => 'Below thread post x signature',
				'description'   => '',
				'display_order' => 6
			]
          ];

          $this->insertPositions($positions);
     }
     public function upgrade2020070Step3()
	{
          $queuedAds = \XF::finder('Siropu\AdsManager:Ad')
               ->queued()
               ->fetch();

          foreach ($queuedAds as $ad)
          {
               if (!$ad->isFree())
               {
                    $ad->queueAndInvoice();
               }
          }
     }
     public function upgrade2020270Step1()
	{
          try
          {
               @File::deleteFromAbstractedPath('data://siropu/am/invoice/9/id-client-25316-nr-26734-an-2018.pdf');
          }
          catch (\Exception $e) {}
     }
     public function upgrade2030070Step1()
	{
          $sm = $this->schemaManager();

          $sm->alterTable('xf_siropu_ads_manager_ad', function(Alter $table)
		{
			$table->addColumn('content_4', 'text');
		});

          $sm->alterTable('xf_siropu_ads_manager_ad_extra', function(Alter $table)
		{
			$table->addColumn('is_sticky', 'tinyint', 1)->setDefault(0);
               $table->addColumn('prefix_id', 'int')->setDefault(0);
               $table->addColumn('pending_changes', 'blob');
		});

		$sm->alterTable('xf_siropu_ads_manager_package', function(Alter $table)
		{
			$table->addColumn('cost_sticky', 'decimal', '10,2')->setDefault(0.00);
		});

          \XF::repository('Siropu\AdsManager:Package')->updateAdvertiseHereThreadCache();
     }
     public function upgrade2030270Step1()
	{
          $this->schemaManager()->alterTable('xf_siropu_ads_manager_ad_extra', function(Alter $table)
		{
			$table->addColumn('prev_status', 'varchar', 25);
               $table->addKey('prev_status');
		});
     }
     public function upgrade2030370Step1()
     {
          $this->schemaManager()->alterTable('xf_siropu_ads_manager_invoice', function(Alter $table)
		{
               $table->addColumn('marked_as_paid', 'int')->setDefault(0);
          });
     }
     public function upgrade2030470Step1(array $stepParams)
     {
          $position = empty($stepParams[0]) ? 0 : $stepParams[0];

          $columns = [
               'position',
               'banner_file',
               'banner_url',
               'settings',
               'position_criteria',
               'user_criteria',
               'page_criteria',
               'device_criteria',
               'geo_criteria'
          ];

          return $this->entityColumnsToJson('Siropu\AdsManager:Ad', $columns, $position, $stepParams);
     }
     public function upgrade2030470Step2(array $stepParams)
     {
          $serializedFields = [
               'Siropu\AdsManager:Package'   => ['position', 'cost_custom', 'discount', 'settings', 'position_criteria', 'user_criteria', 'page_criteria', 'device_criteria', 'geo_criteria', 'advertiser_criteria'],
               'Siropu\AdsManager:PromoCode' => ['package', 'user_criteria']
          ];

          foreach ($serializedFields as $entityName => $columns)
          {
               $this->entityColumnsToJson($entityName, $columns, 0, [], true);
          }
     }
     public function upgrade2030470Step3(array $stepParams)
     {
          try
          {
               $position = empty($stepParams[0]) ? 0 : $stepParams[0];
               return $this->entityColumnsToJson('Siropu\AdsManager:ClickStats', ['visitor'], $position, $stepParams);
          }
          catch (\Exception $e) {}
     }
     public function upgrade2030670Step1()
     {
          $this->schemaManager()->alterTable('xf_siropu_ads_manager_position', function(Alter $table)
		{
			$table->changeColumn('title', 'varchar', 100);
		});

          $this->addDefaultPositionData();
     }
     public function upgrade2030870Step1()
     {
          $this->schemaManager()->alterTable('xf_siropu_ads_manager_ad_extra', function(Alter $table)
		{
			$table->addColumn('custom_fields', 'blob');
		});

          $this->addDefaultPositionData();
     }
     public function upgrade2031170Step1()
     {
          $this->addDefaultPositionData();
     }
     public function upgrade2031270Step1()
     {
          $this->schemaManager()->alterTable('xf_siropu_ads_manager_ad', function(Alter $table)
		{
			$table->addColumn('item_array', 'mediumblob');
		});

          $this->schemaManager()->alterTable('xf_siropu_ads_manager_ad_extra', function(Alter $table)
		{
			$table->dropColumns(['blocked_ips']);
		});
     }
     public function upgrade2031270Step2()
     {
          $this->addDefaultPositionData();
     }
     public function upgrade2031370Step1()
     {
          $customPositionCount = $this->db()->fetchOne('SELECT COUNT(*) FROM xf_siropu_ads_manager_position WHERE is_default = 0');

          if ($customPositionCount == 0)
          {
               $this->getPositionCategoryRepo()->resetPostionCategories();
               $this->getPositionRepo()->resetPositions();
          }
          else
          {
               $this->addDefaultPositionData();
          }
     }
     public function upgrade2031370Step2()
     {
          $packages = \XF::finder('Siropu\AdsManager:Package')
               ->ofType(['code', 'banner', 'text', 'link'])
               ->fetch();

          foreach ($packages as $package)
          {
               $default = [
                    'arrows'         => 0,
                    'dots'           => 0,
                    'slidesToShow'   => 1,
                    'slidesPerRow'   => 1,
                    'slidesToScroll' => 1,
                    'autoplaySpeed'  => 3
               ];

               $settings = $package->settings;

               if (isset($settings['slick']))
               {
                    $slick = array_merge($default, $settings['slick']);
               }
               else
               {
                    $slick = $default;
               }

               $newSettings = [
                    'carousel' => [
                         'enabled'         => $settings['carousel'],
                         'arrows'          => $slick['arrows'],
                         'bullets'         => $slick['dots'],
                         'itemsPerView'    => $slick['slidesToShow'],
                         'itemsPerColumn'  => $slick['slidesPerRow'],
                         'itemsPerGroup'   => $slick['slidesToScroll'],
                         'autoplaySpeed'   => substr($slick['autoplaySpeed'], 0, 1),
                         'transitionSpeed' => 300,
                         'effect'          => 'slide',
                         'direction'       => 'horizontal',
                         'device'          => [
                              'desktop' => 1,
                              'tablet'  => 1,
                              'mobile'  => 1
                         ]
                    ]
               ];

               unset($settings['slick']);

               $package->settings = array_replace_recursive($settings, $newSettings);
               $package->save(false);
          }
     }
     public function upgrade2031470Step1()
     {
          $this->schemaManager()->alterTable('xf_siropu_ads_manager_package', function(Alter $table)
		{
			$table->addColumn('advertiser_user_groups', 'blob');
		});

          $this->addDefaultPositionData();
     }
     public function upgrade2031670Step1()
     {
          $this->addDefaultPositionData();
     }
     public function upgrade2031870Step1()
     {
          $this->schemaManager()->alterTable('xf_siropu_ads_manager_click_fraud', function(Alter $table)
		{
			$table->addColumn('page_url', 'text');
		});
     }
     public function upgrade2032070Step1()
     {
          $this->addDefaultPositionData();
     }
     public function upgrade2032270Step1()
     {
          $this->addDefaultPositionData();
     }
     public function upgrade2040070Step1()
     {
          $this->schemaManager()->alterTable('xf_siropu_ads_manager_click_fraud', function(Alter $table)
		{
			$table->addColumn('ip_blocked', 'int')->setDefault(0);
               $table->addKey(['ip', 'ip_blocked']);
		});
     }
     public function upgrade2040070Step2()
     {
          $this->addDefaultPositionData();
     }
     public function upgrade2040370Step1()
	{
		$this->schemaManager()->alterTable('xf_siropu_ads_manager_stats_click', function(Alter $table)
		{
			$table->addColumn('click_id', 'int')->autoIncrement();
		});
	}
     public function upgrade2040370Step2()
     {
          $this->addDefaultPositionData();
     }
     public function upgrade2040570Step1()
     {
          $this->addDefaultPositionData();
     }
     public function upgrade2040670Step1()
     {
          $this->addUserOptionFields();
     }
     public function upgrade2041470Step1()
     {
          $this->addDefaultPositionData();
     }
     public function upgrade2041570Step1()
     {
          $this->addDefaultPositionData();
     }
     public function uninstallStep1()
	{
          $ads = \XF::finder('Siropu\AdsManager:Ad')->ofType(['code', 'banner', 'text', 'popup'])->fetch();

          foreach ($ads as $ad)
          {
               if ($ad->MasterTemplate)
               {
                    $ad->MasterTemplate->delete();
               }
          }
     }
	public function uninstallStep2()
	{
		$sm = $this->schemaManager();

		$sm->dropTable('xf_siropu_ads_manager_ad');
		$sm->dropTable('xf_siropu_ads_manager_ad_extra');
		$sm->dropTable('xf_siropu_ads_manager_package');
		$sm->dropTable('xf_siropu_ads_manager_position');
		$sm->dropTable('xf_siropu_ads_manager_position_category');
		$sm->dropTable('xf_siropu_ads_manager_stats_daily');
		$sm->dropTable('xf_siropu_ads_manager_stats_click');
		$sm->dropTable('xf_siropu_ads_manager_promo_code');
		$sm->dropTable('xf_siropu_ads_manager_invoice');
		$sm->dropTable('xf_siropu_ads_manager_click_fraud');
          $sm->dropTable('xf_siropu_ads_manager_stats_access');
	}
     public function uninstallStep3()
     {
          $this->deleteWidget('siropu_ads_manager_adv');
          $this->deleteWidget('siropu_ads_manager_sticky');
          $this->deleteWidget('siropu_ads_manager_feat');
     }
	public function uninstallStep4()
	{
		$this->db()->delete('xf_purchasable', 'purchasable_type_id = ?', 'advertising');
	}
     public function uninstallStep5()
	{
		$this->db()->delete('xf_payment_provider', 'provider_id = ?', 'banktransfer');
	}
     public function uninstallStep6()
     {
          $this->schemaManager()->alterTable('xf_user_option', function(Alter $table)
          {
               $table->dropColumns(['siropu_ads_manager_view_ads']);
          });
     }
	public function postUpgrade($previousVersion, array &$stateChanges)
	{
		if ($this->applyDefaultPermissions($previousVersion))
		{
			$this->app->jobManager()->enqueueUnique(
				'permissionRebuild',
				'XF:PermissionRebuild',
				[],
				false
			);
		}

          $coreJsFilePath = \XF::options()->siropuAdsManagerJsFilePath ?? false;

          if ($coreJsFilePath && strpos($coreJsFilePath, 'http') === false)
          {
               try
               {
                    File::copyFile('js/siropu/am/core.min.js', "js/{$coreJsFilePath}");
               }
               catch (\Exception $e)
               {
                    \XF::logException($e, false, 'Could not copy js/siropu/am/core.min.js file to custom path.');
               }
          }
	}
	protected function applyDefaultPermissions($previousVersion = null)
	{
		$applied = false;

		if (!$previousVersion)
		{
			$this->applyGlobalPermission('siropuAdsManager', 'viewAds');

			$applied = true;
		}

		return $applied;
	}
	protected function createAdTable()
	{
		$this->schemaManager()->createTable('xf_siropu_ads_manager_ad', function(Create $table)
		{
			$table->addColumn('ad_id', 'int')->autoIncrement();
			$table->addColumn('package_id', 'int')->setDefault(0);
			$table->addColumn('inherit_package', 'tinyint', 1)->setDefault(0);
			$table->addColumn('type', 'varchar', 25);
			$table->addColumn('user_id', 'int');
			$table->addColumn('username', 'varchar', 50);
			$table->addColumn('name', 'varchar', 255);
			$table->addColumn('position', 'blob');
			$table->addColumn('content_1', 'text');
			$table->addColumn('content_2', 'text');
			$table->addColumn('content_3', 'text');
               $table->addColumn('content_4', 'text');
               $table->addColumn('item_array', 'mediumblob');
			$table->addColumn('banner_file', 'blob');
			$table->addColumn('banner_url', 'blob');
			$table->addColumn('title', 'varchar', 255);
			$table->addColumn('target_url', 'varchar', 255);
			$table->addColumn('item_id', 'int')->setDefault(0);
			$table->addColumn('create_date', 'int')->setDefault(0);
			$table->addColumn('start_date', 'int')->setDefault(0);
			$table->addColumn('end_date', 'int')->setDefault(0);
			$table->addColumn('view_limit', 'int')->setDefault(0);
               $table->addColumn('daily_view_limit', 'int')->setDefault(0);
			$table->addColumn('click_limit', 'int')->setDefault(0);
			$table->addColumn('display_order', 'int')->setDefault(0);
			$table->addColumn('display_priority', 'int')->setDefault(0);
			$table->addColumn('settings', 'mediumblob');
			$table->addColumn('position_criteria', 'mediumblob');
			$table->addColumn('user_criteria', 'mediumblob');
			$table->addColumn('page_criteria', 'mediumblob');
			$table->addColumn('device_criteria', 'mediumblob');
			$table->addColumn('geo_criteria', 'mediumblob');
			$table->addColumn('view_count', 'int')->setDefault(0);
			$table->addColumn('click_count', 'int')->setDefault(0);
			$table->addColumn('ctr', 'decimal', '5,2')->setDefault(0.00);
			$table->addColumn('status', 'varchar', 25);
			$table->addKey('package_id');
			$table->addKey('type');
			$table->addKey('user_id');
			$table->addKey('item_id');
			$table->addKey('start_date');
			$table->addKey('end_date');
			$table->addKey('display_order');
			$table->addKey('ctr');
			$table->addKey('status');
			$table->addKey(['status', 'display_order'], 'status_display_order');
		});

		$this->schemaManager()->createTable('xf_siropu_ads_manager_ad_extra', function(Create $table)
		{
			$table->addColumn('ad_id', 'int');
			$table->addColumn('active_since', 'int')->setDefault(0);
			$table->addColumn('last_change', 'int')->setDefault(0);
			$table->addColumn('last_active', 'int')->setDefault(0);
			$table->addColumn('is_placeholder', 'tinyint', 1)->setDefault(0);
			$table->addColumn('count_exclude', 'tinyint', 1)->setDefault(0);
			$table->addColumn('exclusive_use', 'tinyint', 1)->setDefault(0);
               $table->addColumn('is_sticky', 'tinyint', 1)->setDefault(0);
			$table->addColumn('purchase', 'int')->setDefault(0);
               $table->addColumn('prefix_id', 'int')->setDefault(0);
               $table->addColumn('custom_fields', 'blob');
               $table->addColumn('promo_code', 'varchar', 50);
			$table->addColumn('email_notification', 'tinyint', 1)->setDefault(0);
			$table->addColumn('alert_notification', 'tinyint', 1)->setDefault(0);
			$table->addColumn('notes', 'text');
               $table->addColumn('pending_changes', 'blob');
			$table->addColumn('notice_sent', 'tinyint', 1)->setDefault(0);
			$table->addColumn('reject_reason', 'text');
			$table->addColumn('prev_status', 'varchar', 25);
               $table->addColumn('prev_prefix', 'int')->setDefault(0);
               $table->addColumn('advertiser_list', 'tinyint', 1)->setDefault(0);
			$table->addPrimaryKey('ad_id');
			$table->addKey('active_since');
			$table->addKey('is_placeholder');
			$table->addKey('count_exclude');
			$table->addKey('exclusive_use');
			$table->addKey('promo_code');
			$table->addKey('prev_status');
		});
	}
	protected function createPackageTable()
	{
		$this->schemaManager()->createTable('xf_siropu_ads_manager_package', function(Create $table)
		{
			$table->addColumn('package_id', 'int')->autoIncrement();
			$table->addColumn('type', 'varchar', 25);
			$table->addColumn('title', 'varchar', 255);
			$table->addColumn('description', 'text');
			$table->addColumn('guidelines', 'text');
			$table->addColumn('position', 'blob');
			$table->addColumn('cost_amount', 'decimal', '10,2')->setDefault(0.00);
			$table->addColumn('cost_custom', 'blob');
			$table->addColumn('cost_currency', 'varchar', 3);
			$table->addColumn('cost_per', 'enum')->values(['','day','week','month','year','cpm','cpc']);
			$table->addColumn('cost_sticky', 'decimal', '10,2')->setDefault(0.00);
               $table->addColumn('cost_exclusive', 'decimal', '10,2')->setDefault(0.00);
			$table->addColumn('min_purchase', 'int')->setDefault(1);
			$table->addColumn('max_purchase', 'int')->setDefault(1);
			$table->addColumn('discount', 'blob');
			$table->addColumn('ad_allowed_limit', 'int')->setDefault(1);
			$table->addColumn('ad_display_limit', 'int')->setDefault(1);
			$table->addColumn('ad_display_order', 'enum')->values(['', 'random', 'dateAsc', 'dateDesc', 'orderAsc', 'orderDesc',  'viewAsc', 'viewDesc', 'clickAsc', 'clickDesc', 'ctrAsc', 'ctrDesc']);
			$table->addColumn('preview', 'varchar', 50);
               $table->addColumn('content', 'text');
			$table->addColumn('settings', 'blob');
			$table->addColumn('position_criteria', 'mediumblob');
			$table->addColumn('user_criteria', 'mediumblob');
			$table->addColumn('page_criteria', 'mediumblob');
			$table->addColumn('device_criteria', 'mediumblob');
			$table->addColumn('geo_criteria', 'mediumblob');
               $table->addColumn('advertiser_user_groups', 'blob');
			$table->addColumn('advertiser_criteria', 'blob');
			$table->addColumn('advertise_here', 'tinyint', 1)->setDefault(0);
			$table->addColumn('display_order', 'int')->setDefault(0);
			$table->addColumn('placeholder_id', 'int')->setDefault(0);
			$table->addColumn('ad_count', 'int')->setDefault(0);
			$table->addColumn('empty_slot_count', 'int')->setDefault(0);
               $table->addColumn('advertiser_purchase_limit', 'tinyint', 3)->setDefault(0);
			$table->addKey('type');
			$table->addKey('placeholder_id');
			$table->addKey('display_order');
		});
	}
	protected function createPositionTable()
	{
		$this->schemaManager()->createTable('xf_siropu_ads_manager_position', function(Create $table)
		{
			$table->addColumn('position_id', 'varchar', 50);
			$table->addColumn('title', 'varchar', 100);
			$table->addColumn('description', 'varchar', 255);
			$table->addColumn('category_id', 'int')->setDefault(0);
			$table->addColumn('is_default', 'tinyint', 1)->setDefault(0);
			$table->addColumn('display_order', 'int');
			$table->addPrimaryKey('position_id');
		});

		$this->schemaManager()->createTable('xf_siropu_ads_manager_position_category', function(Create $table)
		{
			$table->addColumn('category_id', 'int')->autoIncrement();
			$table->addColumn('title', 'varchar', 255);
			$table->addColumn('description', 'varchar', 255);
			$table->addColumn('display_order', 'int');
		});
	}
	protected function createInvoiceTable()
	{
		$this->schemaManager()->createTable('xf_siropu_ads_manager_invoice', function(Create $table)
		{
			$table->addColumn('invoice_id', 'int')->autoIncrement();
			$table->addColumn('child_ids', 'varbinary', 255)->setDefault('');
			$table->addColumn('ad_id', 'int')->setDefault(0);
			$table->addColumn('user_id', 'int');
			$table->addColumn('username', 'varchar', 50);
			$table->addColumn('cost_amount', 'decimal', '10,2')->setDefault(0.00);
			$table->addColumn('cost_currency', 'varchar', 3);
			$table->addColumn('length_amount', 'int');
			$table->addColumn('length_unit', 'enum')->values(['day','week','month','year','cpm','cpc',''])->setDefault('');
			$table->addColumn('promo_code', 'varchar', 50);
			$table->addColumn('create_date', 'int');
			$table->addColumn('complete_date', 'int')->setDefault(0);
			$table->addColumn('payment_profile_id', 'int');
			$table->addColumn('recurring', 'tinyint', 1)->setDefault(0);
               $table->addColumn('marked_as_paid', 'int')->setDefault(0);
			$table->addColumn('invoice_file', 'varchar', 255);
			$table->addColumn('status', 'enum')->values(['pending', 'completed', 'cancelled'])->setDefault('pending');
			$table->addKey('ad_id');
			$table->addKey('child_ids');
			$table->addKey('user_id');
			$table->addKey('payment_profile_id');
			$table->addKey('promo_code');
			$table->addKey(['cost_amount', 'cost_currency'], 'cost');
			$table->addKey('status');
		});
	}
	protected function createPromoCodeTable()
	{
		$this->schemaManager()->createTable('xf_siropu_ads_manager_promo_code', function(Create $table)
		{
			$table->addColumn('promo_code', 'varchar', 50);
			$table->addColumn('value', 'float');
			$table->addColumn('type', 'enum')->values(['percent', 'amount'])->setDefault('percent');
			$table->addColumn('package', 'blob');
			$table->addColumn('invoice_amount', 'decimal', '5,2')->setDefault(0.00);
			$table->addColumn('active_date', 'int')->setDefault(0);
			$table->addColumn('expire_date', 'int')->setDefault(0);
			$table->addColumn('user_usage_limit', 'int')->setDefault(0);
			$table->addColumn('total_usage_limit', 'int')->setDefault(0);
			$table->addColumn('user_criteria', 'mediumblob');
			$table->addColumn('create_date', 'int');
			$table->addColumn('usage_count', 'int')->setDefault(0);
			$table->addColumn('enabled', 'tinyint', 1)->setDefault(1);
			$table->addPrimaryKey('promo_code');
			$table->addKey('enabled');
		});
	}
	protected function createDailyStatsTable()
	{
		$this->schemaManager()->createTable('xf_siropu_ads_manager_stats_daily', function(Create $table)
		{
			$table->addColumn('stats_date', 'int');
			$table->addColumn('ad_id', 'int');
			$table->addColumn('position_id', 'varchar', 50);
			$table->addColumn('view_count', 'int');
			$table->addColumn('click_count', 'int');
			$table->addUniqueKey(['ad_id', 'position_id', 'stats_date'], 'ad_id_position_id_stats_date');
		});
	}
	protected function createClickStatsTable()
	{
		$this->schemaManager()->createTable('xf_siropu_ads_manager_stats_click', function(Create $table)
		{
               $table->addColumn('click_id', 'int')->autoIncrement();
			$table->addColumn('stats_date', 'int');
			$table->addColumn('ad_id', 'int');
			$table->addColumn('position_id', 'varchar', 50);
			$table->addColumn('image_url', 'varchar', 255);
			$table->addColumn('page_url', 'text');
			$table->addColumn('visitor', 'blob');
			$table->addKey(['ad_id', 'position_id', 'stats_date'], 'ad_id_position_id_stats_date');
		});
	}
	protected function createClickFraudTable()
	{
		$this->schemaManager()->createTable('xf_siropu_ads_manager_click_fraud', function(Create $table)
		{
			$table->addColumn('ad_id', 'int');
			$table->addColumn('ip', 'varbinary', 16);
               $table->addColumn('ip_blocked', 'int')->setDefault(0);
               $table->addColumn('page_url', 'text');
			$table->addColumn('log_date', 'int');
			$table->addColumn('click_count', 'int')->setDefault(0);
			$table->addUniqueKey(['ad_id', 'ip'], 'ad_id_ip');
               $table->addKey(['ip', 'ip_blocked']);
		});
	}
     protected function createStatsAccessTable()
     {
          $this->schemaManager()->createTable('xf_siropu_ads_manager_stats_access', function(Create $table)
		{
			$table->addColumn('access_key', 'varchar', 40);
               $table->addColumn('ad_list', 'varbinary', 255);
               $table->addColumn('title', 'varchar', 255);
			$table->addColumn('access_date', 'int')->setDefault(0);
			$table->addPrimaryKey('access_key');
		});
     }
     protected function addUserOptionFields()
     {
          $this->schemaManager()->alterTable('xf_user_option', function(Alter $table)
          {
               $table->addColumn('siropu_ads_manager_view_ads', 'tinyint', 1)->setDefault(1);
          });
     }
     protected function createWidgets()
     {
          $this->createWidget('siropu_ads_manager_adv', 'siropu_ads_manager_adv', [
			'positions' => [
                    'forum_list_sidebar' => 100
               ],
               'options'   => [
                    'limit' => 10,
                    'order' => 'registerDate'
               ]
		]);

          $this->createWidget('siropu_ads_manager_sticky', 'siropu_ads_manager_sticky', [
               'positions' => [
                    'forum_list_sidebar' => 100
               ],
               'options'   => [
                    'limit' => 10,
                    'order' => 'lastPostDate'
               ]
		]);

          $this->createWidget('siropu_ads_manager_feat', 'siropu_ads_manager_feat', [
               'positions' => [
                    'forum_list_sidebar' => 100
               ],
               'options'   => [
                    'limit' => 10,
                    'order' => 'lastUpdate'
               ]
		]);
     }
	protected function addDefaultPositionData()
	{
		$this->getPositionCategoryRepo()->addDefaultPositionCategories();
		$this->getPositionRepo()->addDefaultPositions();
	}
	protected function addPurchasableType()
	{
		if (!\XF::em()->find('XF:Purchasable', 'advertising'))
		{
			$purchasable = \XF::em()->create('XF:Purchasable');
			$purchasable->bulkSet([
				'purchasable_type_id' => 'advertising',
				'purchasable_class'   => 'Siropu\AdsManager:Advertising',
				'addon_id'            => 'Siropu/AdsManager'
			]);
			$purchasable->save();
		}
	}
     protected function addPaymentProvider()
     {
          if (!\XF::em()->find('XF:PaymentProvider', 'banktransfer'))
          {
               $paymentProvider = \XF::em()->create('XF:PaymentProvider');
               $paymentProvider->bulkSet([
                    'provider_id'    => 'banktransfer',
                    'provider_class' => 'Siropu\AdsManager:BankTransfer',
                    'addon_id'       => 'Siropu/AdsManager'
               ]);
               $paymentProvider->save();
          }
     }
	protected function getNewPositions($positions)
	{
		$position = [];

		if (!empty($positions))
		{
			foreach (array_filter(explode("\n", $positions)) as $pos)
			{
				switch ($pos)
				{
					case 'ad_above_top_breadcrumb':
						$position[] = 'container_breadcrumb_top_above';
						break;
					case 'ad_below_top_breadcrumb':
						$position[] = 'container_breadcrumb_top_below';
						break;
					case 'ad_above_content':
						$position[] = 'container_content_above';
						break;
					case 'ad_below_content':
						$position[] = 'container_content_below';
						break;
					case 'ad_header':
						$position[] = 'container_header';
						break;
					case 'ad_sidebar_top':
					case 'ad_sidebar_below_visitor_panel':
						$position[] = 'container_sidebar_above';
						break;
					case 'ad_sidebar_bottom':
						$position[] = 'container_sidebar_below';
						break;
					case 'ad_thread_view_above_messages':
						$position[] = 'thread_view_above_messages';
						break;
					case 'ad_thread_view_below_messages':
						$position[] = 'thread_view_below_messages';
						break;
					case 'ad_thread_list_below_stickies':
						$position[] = 'forum_view_below_stickies';
						break;
					case 'ad_forum_view_above_node_list':
						$position[] = 'forum_view_above_node_list';
						break;
					case 'ad_forum_view_above_thread_list':
						$position[] = 'forum_view_above_thread_list';
						break;
					case 'sam_search_results_after_result_x':
						$position[] = 'search_results_below_item_container_';
						break;
					case 'sam_tag_view_after_result_x':
						$position[] = 'tag_view_below_item_container_';
						break;
					case 'sam_thread_list_after_item_x':
						$position[] = 'thread_list_below_item_container_';
						break;
					case 'sam_thread_post_container_after_x':
						$position[] = 'post_below_container_';
						break;
					case 'sam_thread_post_message_below_x':
					case 'sam_thread_post_message_inside_x':
						$position[] = 'post_below_content_';
						break;
					case 'sam_conversation_post_message_inside_x':
					case 'sam_conversation_post_message_below_x':
					case 'sam_conversation_post_container_after_x':
						$position[] = 'message_below_container_';
						break;
					case 'sam_profile_post_container_after_x':
						$position[] = 'profile_post_below_container_';
						break;
					case 'sam_forum_category_after_x':
						$position[] = 'node_list_below_category_container_';
						break;
					case 'sam_node_page_description_x':
						$position[] = 'node_title_container_';
						break;
					case 'sam_media_after_item_x':
					case 'sam_media_album_after_item_x':
						$position[] = 'media_list_item_';
						break;
					case 'sam_media_view_below_media':
						$position[] = 'media_view_below_media_preview';
						break;
					case 'sam_media_view_image':
						$position[] = 'media_view_image_container';
						break;
					case 'sam_media_view_video':
						$position[] = 'media_view_video_container';
						break;
					case 'sam_media_view_sidebar_top':
						$position[] = 'sidebar_above_media_info_block';
						break;
					case 'sam_media_view_sidebar_end':
						$position[] = 'sidebar_below_media_share_block';
						break;
					case 'sam_resource_list_after_item_x':
						$position[] = 'resource_list_below_item_container_';
						break;
				}
			}
		}

		return $position;
	}
	protected function getNewPositionCriteria($criteria, $itemId)
	{
		$oldCriteria = @unserialize($criteria);
		$newCriteria = [];

		if ($itemId)
		{
			$newCriteria[] = [
				'rule' => 'item_id',
				'data' => [
					'id' => $itemId
				]
			];
		}

		if ($oldCriteria)
		{
			if (isset($oldCriteria['thread_tag']))
			{
				$newCriteria[] = [
					'rule' => 'thread_tag',
					'data' => [
						'tag' => $oldCriteria['thread_tag']
					]
				];
			}

			if (isset($oldCriteria['thread_tag_not']))
			{
				$newCriteria[] = [
					'rule' => 'thread_tag_not',
					'data' => [
						'tag' => $oldCriteria['thread_tag_not']
					]
				];
			}

			if (isset($oldCriteria['thread_title_contains']))
			{
				$newCriteria[] = [
					'rule' => 'thread_title',
					'data' => [
						'title' => $oldCriteria['thread_title_contains']
					]
				];
			}

			if (isset($oldCriteria['thread_title_not_contains']))
			{
				$newCriteria[] = [
					'rule' => 'thread_title_not',
					'data' => [
						'title' => $oldCriteria['thread_title_not_contains']
					]
				];
			}

			if (isset($oldCriteria['thread_id']))
			{
				$newCriteria[] = [
					'rule' => 'thread_id',
					'data' => [
						'id' => $oldCriteria['thread_id']
					]
				];
			}

			if (isset($oldCriteria['thread_id_not']))
			{
				$newCriteria[] = [
					'rule' => 'thread_id_not',
					'data' => [
						'id' => $oldCriteria['thread_id_not']
					]
				];
			}

			if (isset($oldCriteria['first_post_contains']))
			{
				$newCriteria[] = [
					'rule' => 'first_post',
					'data' => [
						'message' => $oldCriteria['first_post_contains']
					]
				];
			}

			if (isset($oldCriteria['first_post_not_contains']))
			{
				$newCriteria[] = [
					'rule' => 'first_post_not',
					'data' => [
						'message' => $oldCriteria['first_post_not_contains']
					]
				];
			}

			if (isset($oldCriteria['post_contains']))
			{
				$newCriteria[] = [
					'rule' => 'post',
					'data' => [
						'message' => $oldCriteria['post_contains']
					]
				];
			}

			if (isset($oldCriteria['post_not_contains']))
			{
				$newCriteria[] = [
					'rule' => 'post_not',
					'data' => [
						'message' => $oldCriteria['post_not_contains']
					]
				];
			}

			if (isset($oldCriteria['search_keyword']))
			{
				$newCriteria[] = [
					'rule' => 'keyword',
					'data' => [
						'keyword' => $oldCriteria['search_keyword']
					]
				];
			}

			if (isset($oldCriteria['search_keyword_not']))
			{
				$newCriteria[] = [
					'rule' => 'keyword_not',
					'data' => [
						'keyword' => $oldCriteria['search_keyword_not']
					]
				];
			}

			if (isset($oldCriteria['min_results']))
			{
				$newCriteria[] = [
					'rule' => 'minimum_results',
					'data' => [
						'minimum' => $oldCriteria['min_results']
					]
				];
			}
		}

		return $newCriteria;
	}
	protected function getNewDeviceCriteria($criteria)
	{
		$oldCriteria = @unserialize($criteria);
		$newCriteria = [];

		if ($oldCriteria)
		{
			if (isset($oldCriteria['desktop']))
			{
				$newCriteria[] = [
					'rule' => 'desktop',
					'data' => []
				];
			}

			if (isset($oldCriteria['tablet']))
			{
				$newCriteria[] = [
					'rule' => 'tablet',
					'data' => [
						'brand' => $oldCriteria['tablet']
					]
				];
			}

			if (isset($oldCriteria['mobile']))
			{
				$newCriteria[] = [
					'rule' => 'mobile',
					'data' => [
						'brand' => $oldCriteria['mobile']
					]
				];
			}
		}

		return $newCriteria;
	}
	protected function getNewGeoCriteria($criteria)
	{
		$oldCriteria = @unserialize($criteria);
		$newCriteria = [];

		if ($oldCriteria)
		{
			if (isset($oldCriteria['is_country']))
			{
				$newCriteria[] = [
					'rule' => 'country',
					'data' => [
						'country' => $oldCriteria['is_country']
					]
				];
			}

			if (isset($oldCriteria['is_not_country']))
			{
				$newCriteria[] = [
					'rule' => 'country_not',
					'data' => [
						'country' => $oldCriteria['is_not_country']
					]
				];
			}
		}

		return $newCriteria;
	}
	protected function getNewCriteria($criteria)
	{
		$oldCriteria = @unserialize($criteria);
		$newCriteria = [];

		if ($oldCriteria)
		{
			$newCriteria = $oldCriteria;
		}

		return $newCriteria;
	}
	protected function getArrayPairFromStr($costList, $key, $val)
	{
		$customCost = [];

		if (!empty($costList))
		{
			foreach (explode("\n", $costList) as $group)
			{
				if ($items = array_filter(explode('=', $group)))
				{
					$customCost[$key][] = $items[0];
					$customCost[$val][] = $items[1];
				}
			}
		}

		return $customCost;
	}
     protected function insertPositions(array $positions)
     {
          foreach ($positions as $position)
          {
               $em = \XF::em()->create('Siropu\AdsManager:Position');
               $em->is_default = 1;
               $em->bulkSet($position, ['forceSet' => true]);
               $em->save(false);
          }

          $this->rebuildPositionCache();
     }
     protected function rebuildPositionCache()
     {
          $this->getPositionRepo()->rebuildPositionCache();
     }
     protected function getPositionCategoryRepo()
     {
          return \XF::repository('Siropu\AdsManager:PositionCategory');
     }
     protected function getPositionRepo()
     {
          return \XF::repository('Siropu\AdsManager:Position');
     }
}
