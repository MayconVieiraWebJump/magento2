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

class CreateTextBlockEn implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    const IDENTIFIER_BLOCK = 'text-magnolia-enus';

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

        $this->CreateTextBlockEn("msvEN");

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     *  Method to create cms landing page
     */
    protected function CreateTextBlockEn(string $storeCode)
    {
        $storeGetId = $this->storeManager->getStore($storeCode)->getId();

        $cmsBlock = $this->blockFactory->create()->load(self::IDENTIFIER_BLOCK, 'identifier');

        $cmsBlockData = [
            'is_active' => 1,
            'title' => 'Texto descritivo Magnolia EN',
            'identifier' => self::IDENTIFIER_BLOCK,
            'stores' => [$storeGetId],
            'content' => '<style>#html-body [data-pb-style=UYHFFH1]{justify-content:flex-start;display:flex;flex-direction:column;background-position:center center;background-size:contain;background-repeat:no-repeat;background-attachment:scroll;text-align:center;min-height:68px;margin-top:60px;margin-bottom:20px}#html-body [data-pb-style=AMFGQW3],#html-body [data-pb-style=C3UEU2M],#html-body [data-pb-style=OMXXN97],#html-body [data-pb-style=QS80MC8]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div class="magnolia-text" data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/3-layers_1_.png}}\&quot;,\&quot;mobile_image\&quot;:\&quot;{{media url=wysiwyg/2-layers.png}}\&quot;}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="UYHFFH1"></div></div><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="AMFGQW3"><div data-content-type="text" data-appearance="default" data-element="main"><p id="UY0NIYA"><span style="font-size: 16px;"><strong>Magnolia L. is a genus of flowering plants in the order Magnoliales&nbsp;</strong></span></p></div></div></div><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="OMXXN97"><div data-content-type="text" data-appearance="default" data-element="main"><p>It groups the mostly arboreal species known by the common name of magnolias. In its present taxonomic circumscription, the genus was extended to include the species that were dispersed in the genera Magnolia, Manglietia, Michelia, Talauma, Aromadendron, Kmeria, Pachylarnax and Alcimandra (all of the former subfamily Magnolioideae), resulting in a monophyletic genus with about 297 species. The genus is distributed throughout the subtropical and tropical regions of East and Southeast Asia (including Malesia) and the Americas, with centers of diversity in Southeast Asia and northern South America. The genus includes several species widely used as an ornamental tree in the subtropical and temperate regions of both hemispheres.&nbsp;</p></div></div></div><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="C3UEU2M"><div data-content-type="text" data-appearance="default" data-element="main"><p id="SJFMFTS"><span style="font-size: 16px;"><strong>Brand Description</strong></span></p></div></div></div><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="QS80MC8"><div data-content-type="text" data-appearance="default" data-element="main"><p>The genus Magnolia is eponymous after Pierre Magnol, a botanist from Montpellier (France). The first identified species of this genus was Magnolia virginiana, found by missionaries sent to North America in the 1680s. As early as the 18th century, the species Magnolia grandiflora was described, also from North American samples, today the best known species. of the genus as it is widely used as an ornamental tree in subtropical and temperate regions of moderate climate around the world.</p></div></div></div>'
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
