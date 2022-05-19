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

class CreateBannerInfoBlock implements DataPatchInterface, PatchRevertableInterface
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
     * CreateBannerInfoBlock constructor.
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
     * Patch Method "Apply" method $this->createBannerInfoBlock()
     * @return DataPatchInterface|void
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->createBannerInfoBlock();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     *  Method to create cms landing page
     */
    protected function createBannerInfoBlock()
    {
        $cmsBlock = $this->blockFactory->create()->load(self::IDENTIFIER_BLOCK, 'identifier');

        $cmsBlockData = [
            'is_active' => 1,
            'title' => 'Banner Info Moda pt-br',
            'identifier' => self::IDENTIFIER_BLOCK,
            'stores' => [2],
            'content' => '<style>#html-body [data-pb-style=JDD6SKM]{justify-content:center;display:flex;flex-direction:column;background-position:center center;background-size:contain;background-repeat:no-repeat;background-attachment:scroll;text-align:center;min-height:65px;margin:20px 25px 9px}@media only screen and (max-width: 768px) { #html-body [data-pb-style=JDD6SKM]{display:flex;flex-direction:column;min-height:225px} }</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/BannerInfo.png}}\&quot;,\&quot;mobile_image\&quot;:\&quot;{{media url=wysiwyg/mobile.png}}\&quot;}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="JDD6SKM"></div></div>'
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