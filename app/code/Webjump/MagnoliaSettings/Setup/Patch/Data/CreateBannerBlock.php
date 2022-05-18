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

class CreateBannerBlock implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    const IDENTIFIER_BLOCK = 'banner_moda_br';

    /**
     * CreateBannerBlock constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param BlockFactory $blockFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        BlockFactory $blockFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->blockFactory = $blockFactory;
    }

    /**
     * Patch Method "Apply" method $this->createBannerBlock()
     * @return DataPatchInterface|void
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->createBannerBlock();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     *  Method to create cms landing page
     */
    protected function createBannerBlock()
    {
        $cmsBlock = $this->blockFactory->create()->load(self::IDENTIFIER_BLOCK, 'identifier');

        $cmsBlockData = [
            'is_active' => 1,
            'title' => 'Banner Moda pt-br',
            'identifier' => self::IDENTIFIER_BLOCK,
            'stores' => [2],
            'content' => '<style>#html-body [data-pb-style=C7YDJ3U],#html-body [data-pb-style=RK4DN05]{background-size:cover;background-repeat:no-repeat;background-attachment:scroll}#html-body [data-pb-style=C7YDJ3U]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;min-height:561px}#html-body [data-pb-style=RK4DN05]{background-position:center center;text-align:center}#html-body [data-pb-style=P4HMKGV]{border-radius:0;min-height:750px;background-color:transparent}@media only screen and (max-width: 768px) { #html-body [data-pb-style=C7YDJ3U]{display:flex;flex-direction:column;min-height:310px}#html-body [data-pb-style=P4HMKGV]{border-radius:0;min-height:300px;background-color:transparent} }</style><div data-content-type="row" data-appearance="full-bleed" data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="main" data-pb-style="C7YDJ3U"><div data-content-type="banner" data-appearance="poster" data-show-button="never" data-show-overlay="never" data-element="main"><div data-element="empty_link"><div class="pagebuilder-banner-wrapper" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/4-layers.png}}\&quot;,\&quot;mobile_image\&quot;:\&quot;{{media url=wysiwyg/4-layers_2_.png}}\&quot;}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="wrapper" data-pb-style="RK4DN05"><div class="pagebuilder-overlay pagebuilder-poster-overlay" data-overlay-color="" aria-label="" title="" data-element="overlay" data-pb-style="P4HMKGV"><div class="pagebuilder-poster-content"><div data-element="content"></div></div></div></div></div></div></div>'
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