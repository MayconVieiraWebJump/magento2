<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Webjump\MagnoliaSettings\Setup\Patch\Data;

use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Store\Model\StoreManagerInterface;


class CreateCarouselBlock implements DataPatchInterface, PatchRevertableInterface
{
  private StoreManagerInterface $storeManager;

  private 
    /**
     * @var ModuleDataSetupInterface
     */

    const IDENTIFIER_BLOCK = 'carrossel_moda_br';

     /**
     * @var BlockFactory
     */
    private $blockFactory;

    /**
     * CreateCarouselBlock constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param BlockFactory $blockFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        BlockFactory $blockFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->blockFactory = $blockFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * Patch Method "Apply" method $this->createCarouselBlock()
     * @return DataPatchInterface|void
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->createCarouselBlock("moda_br");

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     *  Method to create cms landing page
     */
    protected function createCarouselBlock(string $websiteCode)
    {
      $websiteGetId = $this->storeManager->getWebsite($websiteCode)->getId();

      $cmsBlock = $this->blockFactory->create()->load(self::IDENTIFIER_BLOCK, 'identifier');

        $cmsBlockData = [
            'is_active' => 1,
            'title' => 'Carrossel Moda pt-br',
            'identifier' => self::IDENTIFIER_BLOCK,
            'stores' => [$websiteGetId],
            'content' => '<style>#html-body [data-pb-style=FORS53K],#html-body [data-pb-style=NMQX3L7]{justify-content:flex-start;display:flex;flex-direction:column;background-repeat:no-repeat;background-attachment:scroll;text-align:center}#html-body [data-pb-style=FORS53K]{background-position:center center;background-size:contain;min-height:58px}#html-body [data-pb-style=NMQX3L7]{background-position:left top;background-size:cover}#html-body [data-pb-style=G8VTL12]{text-align:center}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/3-layers.png}}\&quot;,\&quot;mobile_image\&quot;:\&quot;{{media url=wysiwyg/novidades_para_voc_1_.png}}\&quot;}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="FORS53K"></div></div><div data-content-type="row" data-appearance="full-width" data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="main" data-pb-style="NMQX3L7"><div class="row-full-width-inner" data-element="inner"><div data-content-type="products" data-appearance="carousel" data-autoplay="false" data-autoplay-speed="4000" data-infinite-loop="false" data-show-arrows="true" data-show-dots="false" data-carousel-mode="default" data-center-padding="90px" data-element="main" data-pb-style="G8VTL12">{{widget type="Magento\CatalogWidget\Block\Product\ProductsList" template="Magento_PageBuilder::catalog/product/widget/content/carousel.phtml" anchor_text="" id_path="" show_pager="0" products_count="6" condition_option="category_ids" condition_option_value="6" type_name="Catalog Products Carousel" conditions_encoded="^[`1`:^[`aggregator`:`all`,`new_child`:``,`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`value`:`1`^],`1--1`:^[`operator`:`==`,`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`value`:`6`^]^]" sort_order="position"}}</div></div></div>'
        ];

        if (!$cmsBlock->getId()) {
            $this->blockFactory->create()->setData($cmsBlockData)->save();
        } else {
            $cmsBlock->setTitle($cmsBlockData['title']);
            $cmsBlock->setContent($cmsBlockData['content']);
            $cmsBlock->save();
        }
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
}