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

class CreateFooterLinksBlockEN implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    const IDENTIFIER_BLOCK = 'magnolia-footer-links-en';

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

        $this->CreateFooterLinksBlockEN("msvEN");

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     *  Method to create cms landing page
     */
    protected function CreateFooterLinksBlockEN(string $storeCode)
    {
        $storeGetId = $this->storeManager->getStore($storeCode)->getId();

        $cmsBlock = $this->blockFactory->create()->load(self::IDENTIFIER_BLOCK, 'identifier');

        $cmsBlockData = [
            'is_active' => 1,
            'title' => 'Footer Links EN',
            'identifier' => self::IDENTIFIER_BLOCK,
            'stores' => [$storeGetId],
            'content' => '<style>#html-body [data-pb-style=OAR7PUY]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="OAR7PUY"><div data-content-type="html" data-appearance="default" data-element="main">&lt;div class="footer-moda"&gt;
            &lt;div class="footer-links-container links-left"&gt;        
            &lt;h2&gt;INSTITUCIONAL&lt;/h2&gt;
                        &lt;ul&gt;
                          &lt;li&gt;&lt;a href="#"&gt;The Brand&lt;/a&gt;&lt;/li&gt;
                          &lt;li&gt;&lt;a href="#"&gt;Our storess&lt;/a&gt;&lt;/li&gt;
                          &lt;li&gt;&lt;a href="#"&gt;Work with us&lt;/a&gt;&lt;/li&gt;
                          &lt;li&gt;&lt;a href="#"&gt;Privacy Policy&lt;/a&gt;&lt;/li&gt;
                        &lt;/ul&gt;
             &lt;/div&gt;
                        &lt;div class="footer__links-container links-middle"&gt;
                        &lt;h2&gt;HELP&lt;/h2&gt;
                        &lt;ul&gt;
                          &lt;li&gt;&lt;a href="#"&gt;Shipping and Delivery&lt;/a&gt;&lt;/li&gt;
                          &lt;li&gt;&lt;a href="#"&gt;Exchanges and Returns&lt;/a&gt;&lt;/li&gt;
                          &lt;li&gt;&lt;a href="#"&gt;Safety&lt;/a&gt;&lt;/li&gt;
                          &lt;li&gt;&lt;a href="#"&gt;Call Center&lt;/a&gt;&lt;/li&gt;
                          &lt;li&gt;&lt;a href="#"&gt;FAQ&lt;/a&gt;&lt;/li&gt;
                        &lt;/ul&gt;
                        &lt;/div&gt;
            &lt;/div&gt;</div></div></div>'
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