<?php

namespace Siropu\AdsManager\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\FormAction;
use XF\Util\File;

class Package extends AbstractController
{
     public function actionIndex()
     {
          $type = $this->filter('type', 'str');

          $finder = $this->getPackageRepo()
               ->findPackagesForList()
               ->order('title', 'ASC');

          $filters = [];

          if ($type)
          {
               $finder->ofType($type);
               $filters['type'] = $type;
          }

          $packages = $finder->fetch();

          $viewParams = [
               'packages' => $packages->groupBy('type'),
               'total'    => $packages->count(),
               'filters'  => $filters,
               'type'     => $type
          ];

          return $this->view('Siropu\AdsManager:Package\List', 'siropu_ads_manager_package_list', $viewParams);
     }
     public function actionCreate()
     {
          return $this->view('Siropu\AdsManager:Package\Create', 'siropu_ads_manager_package_create');
     }
     public function actionAdd(ParameterBag $params)
     {
          $package = $this->em()->create('Siropu\AdsManager:Package');
          $package->type = $this->getType();

          return $this->packageAddEdit($package);
     }
     public function actionEdit(ParameterBag $params)
     {
          $package = $this->assertPackageExists($params->package_id);
          return $this->packageAddEdit($package);
     }
     public function actionSave(ParameterBag $params)
     {
          $this->assertPostOnly();

		if ($params->package_id)
		{
			$package = $this->assertPackageExists($params->package_id);
		}
		else
		{
			$package = $this->em()->create('Siropu\AdsManager:Package');
		}

		$this->packageSaveProcess($package)->run();

          $redirect = $this->filter('redirect', 'str');

          if ($redirect)
          {
               return $this->redirect($this->buildLink('ads-manager/ads'));
          }
          else
          {
               return $this->redirect($this->buildLink('ads-manager/packages'));
          }
     }
     public function actionDelete(ParameterBag $params)
     {
          $package = $this->assertPackageExists($params->package_id);

          if ($this->isPost())
          {
               $package->delete();

               if ($this->filter('delete_ads', 'bool'))
               {
                    if ($package->Ads)
                    {
                         foreach ($package->Ads as $ad)
                         {
                              $ad->delete();
                         }
                    }
               }
               else
               {
                    $this->getAdRepo()->unsetPackage($package->package_id);
               }

               return $this->redirect($this->buildLink('ads-manager/packages'));
          }

          $viewParams = [
               'package'  => $package,
               'redirect' => $this->filter('redirect', 'str')
          ];

          return $this->view('Siropu\AdsManager:Package\Delete', 'siropu_ads_manager_package_delete', $viewParams);
     }
     public function actionClone(ParameterBag $params)
     {
          $package = $this->assertPackageExists($params->package_id);

          if ($this->isPost())
          {
               $data = $package->toArray();

               unset(
                    $data['package_id'],
                    $data['ad_count'],
                    $data['placeholder_id']
               );

               $input = $this->filter([
                    'title'                     => 'str',
                    'description'               => 'str',
                    'guidelines'                => 'str',
                    'position'                  => 'array',
                    'cost_amount'               => 'float',
                    'cost_custom'               => 'array',
                    'cost_currency'             => 'str',
                    'cost_per'                  => 'str',
                    'cost_exclusive'            => 'float',
                    'min_purchase'              => 'uint',
                    'max_purchase'              => 'uint',
                    'discount'                  => 'array',
                    'ad_allowed_limit'          => 'uint',
                    'settings'                  => 'array',
                    'advertiser_user_groups'    => 'array',
                    'advertiser_criteria'       => 'array',
                    'advertiser_purchase_limit' => 'uint',
                    'advertise_here'            => 'bool',
                    'display_order'             => 'uint'
               ]);

               if (empty($input['title']))
               {
                    $input['title'] = \XF::phrase('siropu_ads_manager_clone_of', ['name' => $package->title]);
               }

               $clone = $this->em()->create('Siropu\AdsManager:Package');

               $upload = $this->app()->request->getFile('upload', false, false);

               if ($upload)
               {
                    $upload->requireImage();

                    if (!$upload->isValid($errors))
                    {
                         return $this->error($errors);
                    }
                    else
                    {
                         $fileName = sprintf('%s.%s', uniqid(), $upload->getExtension());
                         File::copyFileToAbstractedPath($upload->getTempFile(), "data://siropu/am/package/$fileName");

                         $clone->preview = $fileName;
                    }
               }

               $data = array_replace_recursive($data, $input);

               $clone->bulkSet($data);
               $clone->save();

               return $this->redirect($this->buildLink('ads-manager/packages'));
          }

          $clone = $this->em()->create('Siropu\AdsManager:Package');
          $clone->bulkSet($package->toArray(), ['forceSet' => true]);
          $clone->title = '';
          $clone->preview = '';
          $clone->placeholder_id = 0;

          $viewParams = [
               'package'            => $package,
               'clone'              => $clone,
               'advertiserCriteria' => $this->app->criteria('Siropu\AdsManager:Advertiser', $package->advertiser_criteria),
          ];

          return $this->view('Siropu\AdsManager:Package\Clone', 'siropu_ads_manager_package_clone', $viewParams);
     }
     public function actionManagePlaceholder(ParameterBag $params)
     {
          $package = $this->assertPackageExists($params->package_id);

          if ($this->isPost())
          {
               if ($package->hasPlaceholder())
               {
                    $package->disablePlaceholder();
               }
               else
               {
                    $package->enablePlaceholder($this->filter('use_as_backup', 'bool'));
               }

               return $this->redirect($this->getDynamicRedirect());
          }

          $viewParams = [
               'package' => $package
          ];

          return $this->view('Siropu\AdsManager:Package\ManagePlaceholder', 'siropu_ads_manager_package_manage_placeholder', $viewParams);
     }
     public function actionEmbed(ParameterBag $params)
     {
          $package = $this->assertPackageExists($params->package_id);
          $plugin = $this->plugin('Siropu\AdsManager:Embed');

          return $plugin->embedUnit($package);
     }
     public function actionExport(ParameterBag $params)
     {
          if ($this->isPost())
          {
               $finder = $this->finder('Siropu\AdsManager:Package')->where('package_id', $params->package_id);
               return $this->initExport($finder, 'Siropu\AdsManager:Package\Export');
          }

          $viewParams = [
               'package' => $this->assertPackageExists($params->package_id)
          ];

          return $this->view('Siropu\AdsManager:Package\Export', 'siropu_ads_manager_package_export', $viewParams);
     }
     public function actionMassExport(ParameterBag $params)
     {
          if ($this->isPost())
          {
               $finder = $this->finder('Siropu\AdsManager:Package')->where('package_id', $this->filter('export', 'array-uint'));
               return $this->initExport($finder, 'Siropu\AdsManager:Package\Export');
          }

          $finder = $this->getPackageRepo()
               ->findPackagesForList()
               ->order('type', 'ASC')
               ->order('title', 'ASC');

          $viewParams = [
               'packages' => $finder->fetch()->groupBy('type'),
               'total'    => $finder->total()
          ];

          return $this->view('Siropu\AdsManager:Package\Export', 'siropu_ads_manager_package_mass_export', $viewParams);
     }
     public function actionImport()
     {
          if ($this->isPost())
          {
               $upload = $this->app()->request->getFile('upload', false, false);

               if ($upload && $upload->getExtension() == 'zip')
               {
                    return $this->importFromZip($upload);
               }
               else
               {
                    return $this->plugin('XF:Xml')->actionImport(
                         'ads-manager/packages',
                         'ads_manager',
                         'Siropu\AdsManager:Package\Import'
                    );
               }
          }

          return $this->view('Siropu\AdsManager:Package\Import', 'siropu_ads_manager_import', ['route' => 'packages']);
     }
     public function actionStatistics(ParameterBag $params)
     {
          $package = $this->assertPackageExists($params->package_id);

          $page     = $this->filterPage();
          $perPage  = 20;

          $adFinder = $this->getAdRepo()
               ->findAdsForList()
               ->forPackage($package->package_id)
               ->order('ctr', 'DESC')
               ->limitByPage($page, $perPage);

          $viewParams = [
               'package' => $package,
               'stats'   => $this->getPackageRepo()->getPakageAdStats($package->package_id),
               'ads'     => $adFinder->fetch(),
               'total'   => $adFinder->total(),
               'page'    => $page,
               'perPage' => $perPage
          ];

          return $this->view('Siropu\AdsManager:Packcage\Stats', 'siropu_ads_manager_package_stats', $viewParams);
     }
     public function actionManagePlaceholders()
     {
          if ($this->isPost())
          {
               $packages = $this->filter('packages', 'array-uint');
               $entities = $this->em()->findByIds('Siropu\AdsManager:Package', $packages);

               foreach ($entities as $entity)
               {
                    if ($this->filter('action', 'str') == 'enable')
                    {
                         $entity->enablePlaceholder($this->filter('use_as_backup', 'bool'));
                    }
                    else
                    {
                         $entity->disablePlaceholder();
                    }
               }

               return $this->redirect($this->buildLink('ads-manager/packages'));
          }

          $packages = $this->getPackageRepo()
               ->findPackagesForList()
               ->ofType(['code', 'banner', 'text', 'link'])
               ->order('title', 'ASC')
               ->where('cost_amount', '>', 0)
               ->fetch();

          $viewParams = [
               'packages' => $packages
          ];

          return $this->view('Siropu\AdsManager:Packcage\ManagePlaceholders', 'siropu_ads_manager_package_manage_placeholders', $viewParams);
     }
     public function actionTopPerforming()
     {
          $orderField = $this->filter('order_field', 'str');
          $orderDir   = $this->filter('order_direction', 'str');

          $viewParams = [
               'packages' => $this->getPackageRepo()->getTopPerformingPackages($orderField, $orderDir),
               'order'    => [
                    'field'     => $orderField,
                    'direction' => $orderDir
               ]
          ];

          return $this->view('Siropu\AdsManager:Package\Top', 'siropu_ads_manager_package_top_performing', $viewParams);
     }
     public function actionGetItemList()
     {
          $type    = $this->filter('type', 'str');
          $options = \XF::options();
          $items   = [];

          switch ($type)
          {
               case 'thread':
               case 'sticky':
                    $forums = $this->em()->findByIds('XF:Forum', $type == 'thread' ? $options->siropuAdsManagerPromoThreadForums : $options->siropuAdsManagerAllowedStickyForums);
                    foreach ($forums as $forum)
                    {
                         $items[] = $forum->title . " (ID: {$forum->node_id})";
                    }
                    break;
               case 'resource':
                    $categories = $this->em()->findByIds('XFRM:Category', $options->siropuAdsManagerAllowedFeaturedResourceCategories);

                    foreach ($categories as $category)
                    {
                         $items[] = $category->title . " (ID: {$category->resource_category_id})";
                    }
                    break;
          }

          $reply = $this->view('Siropu\AdsManager:ItemList');
          $reply->setJsonParams([
               'items' => $items
          ]);

          return $reply;
     }
     public function actionDisableAds(ParameterBag $params)
     {
          $package = $this->assertPackageExists($params->package_id);

          if ($this->isPost())
          {
               foreach ($package->Ads as $ad)
               {
                    if ($ad->isActive())
                    {
                         $ad->status = 'inactive';
                         $ad->save();
                    }
               }

               return $this->redirect($this->buildLink('ads-manager/ads', '', ['package_id' => $package->package_id]));
          }

          $viewParams = [
               'package' => $package
          ];

          return $this->view('Siropu\AdsManager:Package\DisableAds', 'siropu_ads_manager_package_disable_ads', $viewParams);
     }
     public function actionEnableAds(ParameterBag $params)
     {
          $package = $this->assertPackageExists($params->package_id);

          if ($this->isPost())
          {
               foreach ($package->Ads as $ad)
               {
                    if (!$ad->isActive())
                    {
                         $ad->status = 'active';
                         $ad->save();
                    }
               }

               return $this->redirect($this->buildLink('ads-manager/ads', '', ['package_id' => $package->package_id]));
          }

          $viewParams = [
               'package' => $package
          ];

          return $this->view('Siropu\AdsManager:Package\EnableAds', 'siropu_ads_manager_package_enable_ads', $viewParams);
     }
     protected function packageAddEdit(\Siropu\AdsManager\Entity\Package $package)
	{
          $advertiserUserGroups = $this->repository('XF:UserGroup')
			->findUserGroupsForList()
			->where('user_group_id', '<>', [1, 2, 3, 4])
			->fetch()
			->pluckNamed('title', 'user_group_id');

          $viewParams = [
               'package'              => $package,
               'positionCriteria'     => $this->app->criteria('Siropu\AdsManager:Position', $package->position_criteria),
               'userCriteria'         => $this->app->criteria('XF:User', $package->user_criteria),
               'pageCriteria'         => $this->app->criteria('XF:Page', $package->page_criteria),
               'deviceCriteria'       => $this->app->criteria('Siropu\AdsManager:Device', $package->device_criteria),
               'geoCriteria'          => $this->app->criteria('Siropu\AdsManager:Geo', $package->geo_criteria),
               'advertiserCriteria'   => $this->app->criteria('Siropu\AdsManager:Advertiser', $package->advertiser_criteria),
               'advertiserUserGroups' => $advertiserUserGroups,
               'redirect'             => $this->filter('redirect', 'str')
          ];

          return $this->view('Siropu\AdsManager:Package\Edit', 'siropu_ads_manager_package_edit', $viewParams);
     }
     protected function packageSaveProcess(\Siropu\AdsManager\Entity\Package $package)
	{
          $input = $this->filter([
               'title'                     => 'str',
               'description'               => 'str',
               'guidelines'                => 'str',
               'position'                  => 'array',
               'cost_amount'               => 'float',
               'cost_custom'               => 'array',
               'cost_currency'             => 'str',
               'cost_per'                  => 'str',
               'cost_exclusive'            => 'float',
               'cost_sticky'               => 'float',
               'min_purchase'              => 'uint',
               'max_purchase'              => 'uint',
               'discount'                  => 'array',
               'ad_allowed_limit'          => 'uint',
               'ad_display_limit'          => 'uint',
               'ad_display_order'          => 'str',
               'content'                   => 'str',
               'settings'                  => 'array',
               'position_criteria'         => 'array',
               'user_criteria'             => 'array',
               'page_criteria'             => 'array',
               'device_criteria'           => 'array',
               'geo_criteria'              => 'array',
               'advertiser_criteria'       => 'array',
               'advertiser_user_groups'    => 'array',
               'advertise_here'            => 'bool',
               'advertiser_purchase_limit' => 'uint',
               'display_order'             => 'uint'
          ]);

          if ($package->isInsert())
          {
               $package->type = $this->getType();
          }

          $form = $this->formAction();
          $form->basicEntitySave($package, $input);

          $form->validate(function(FormAction $form) use ($package, $input)
          {
               if ($package->isOfType(['code', 'banner', 'text', 'link']) && empty($input['position']))
               {
                    $form->logError(\XF::phrase('siropu_ads_manager_please_select_position'));
               }
          });

          $form->setup(function() use ($package)
          {
               $upload = $this->app()->request->getFile('upload', false, false);

               if ($upload)
               {
                    $upload->requireImage();

                    if (!$upload->isValid($errors))
                    {
                         $form->logErrors($errors);
                    }
                    else
                    {
                         $fileName = sprintf('%s.%s', uniqid(), $upload->getExtension());
                         File::copyFileToAbstractedPath($upload->getTempFile(), "data://siropu/am/package/$fileName");

                         $package->preview = $fileName;
                    }
               }
               else if ($this->filter('delete_preview', 'bool'))
               {
                    $package->preview = '';
               }
          });

          $form->complete(function() use ($package)
		{
               $this->getPackageRepo()->inheritPackage($package->package_id, $this->filter('bypass_inheritance', 'bool'));

               $enablePlaceholder = $this->filter('enable_placeholder', 'bool');

               if ($package->hasPlaceholder() && !$enablePlaceholder)
               {
                    $package->disablePlaceholder();
               }
               else if ($enablePlaceholder)
               {
                    $package->enablePlaceholder();
               }
          });

		return $form;
     }
}
