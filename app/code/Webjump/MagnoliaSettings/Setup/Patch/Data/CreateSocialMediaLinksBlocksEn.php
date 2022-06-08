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

class CreateSocialMediaLinksBlocksEn implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    const IDENTIFIER_BLOCK = 'MediaLinksMagnoliaEn';

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

        $this->CreateSocialMediaLinksBlocksEn("msvEN");

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     *  Method to create cms landing page
     */
    protected function CreateSocialMediaLinksBlocksEn(string $storeCode)
    {
        $storeGetId = $this->storeManager->getStore($storeCode)->getId();

        $cmsBlock = $this->blockFactory->create()->load(self::IDENTIFIER_BLOCK, 'identifier');

        $cmsBlockData = [
            'is_active' => 1,
            'title' => 'Social Media Blocks En',
            'identifier' => self::IDENTIFIER_BLOCK,
            'stores' => [$storeGetId],
            'content' => '<div data-content-type="html" data-appearance="default" data-element="main">&lt;div class="social-media-footer"&gt;        
            &lt;ul&gt;
              &lt;li&gt;&lt;a href="#"&gt;&lt;img src="{{media url=wysiwyg/pinterest.png}}" alt="" /&gt;&lt;/a&gt;&lt;/li&gt;
              &lt;li&gt;&lt;a href="#"&gt;&lt;img src="{{media url=wysiwyg/youtube.png}}" alt="" /&gt;&lt;/a&gt;&lt;/li&gt;
              &lt;li&gt;&lt;a href="#"&gt;&lt;img src="{{media url=wysiwyg/Rectangle_8.png}}" alt="" /&gt;&lt;/a&gt;&lt;/li&gt;
              &lt;li&gt;&lt;a href="#"&gt;&lt;img src="{{media url=wysiwyg/instagram.png}}" alt="" /&gt;&lt;/a&gt;&lt;/li&gt;
            &lt;/ul&gt;
 &lt;/div&gt;</div>'
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