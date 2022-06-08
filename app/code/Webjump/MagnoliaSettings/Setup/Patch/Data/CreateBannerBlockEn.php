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

class CreateBannerBlockEn implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    const IDENTIFIER_BLOCK = 'banner_moda_en';

    private StoreManagerInterface $storeManager;


    /**
     * CreateBannerBlock constructor.
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
     * Patch Method "Apply" method $this->createBannerBlock()
     * @return DataPatchInterface|void
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->createBannerBlockEn("msvEN");

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     *  Method to create cms landing page
     */
    protected function createBannerBlockEn(string $storeCode)
    {
        $storeGetId = $this->storeManager->getStore($storeCode)->getId();

        $cmsBlock = $this->blockFactory->create()->load(self::IDENTIFIER_BLOCK, 'identifier');

        $cmsBlockData = [
            'is_active' => 1,
            'title' => 'Banner Moda en-us',
            'identifier' => self::IDENTIFIER_BLOCK,
            'stores' => [$storeGetId],
            'content' => '<style>#html-body [data-pb-style=A6A1YYF],#html-body [data-pb-style=U91K2IR]{background-size:cover;background-repeat:no-repeat;background-attachment:scroll}#html-body [data-pb-style=U91K2IR]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;min-height:561px}#html-body [data-pb-style=A6A1YYF]{background-position:center center;text-align:center}#html-body [data-pb-style=X11VD1X]{border-radius:0;min-height:651px;background-color:transparent}@media only screen and (max-width: 768px) { #html-body [data-pb-style=U91K2IR]{display:flex;flex-direction:column;min-height:310px}#html-body [data-pb-style=X11VD1X]{border-radius:0;min-height:300px;background-color:transparent} }</style><div data-content-type="row" data-appearance="full-bleed" data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="main" data-pb-style="U91K2IR"><div data-content-type="banner" data-appearance="poster" data-show-button="never" data-show-overlay="never" data-element="main"><div data-element="empty_link"><div class="pagebuilder-banner-wrapper" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/banner-en.png}}\&quot;,\&quot;mobile_image\&quot;:\&quot;{{media url=wysiwyg/banner-mobile-en.png}}\&quot;}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="wrapper" data-pb-style="A6A1YYF"><div class="pagebuilder-overlay pagebuilder-poster-overlay" data-overlay-color="" aria-label="" title="" data-element="overlay" data-pb-style="X11VD1X"><div class="pagebuilder-poster-content"><div data-element="content"></div></div></div></div></div></div></div>'
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