<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Webjump\WineClubSettings\Setup\Patch\Data;

use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class CreateGridBlock implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    const IDENTIFIER_BLOCK = 'grid_wine_br';

    /**
     * CreateGridBlock constructor.
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
     * Patch Method "Apply" method $this->createGridBlock()
     * @return DataPatchInterface|void
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->createGridBlock();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     *  Method to create cms landing page
     */
    protected function createGridBlock()
    {
        $cmsBlock = $this->blockFactory->create()->load(self::IDENTIFIER_BLOCK, 'identifier');

        $cmsBlockData = [
            'is_active' => 1,
            'title' => 'Grid Wine pt-br',
            'identifier' => self::IDENTIFIER_BLOCK,
            'stores' => [3],
            'content' => '<style>#html-body [data-pb-style=F9KFVSM],#html-body [data-pb-style=H1GJ0EL],#html-body [data-pb-style=VLP822O]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:auto;background-repeat:no-repeat;background-attachment:scroll}#html-body [data-pb-style=H1GJ0EL],#html-body [data-pb-style=VLP822O]{justify-content:center;background-position:center center;background-size:contain;width:50%;align-self:stretch}#html-body [data-pb-style=H1GJ0EL]{justify-content:flex-end;background-position:left top;background-size:auto;margin-top:10px}#html-body [data-pb-style=YG3IRNB]{text-align:center;border-style:none}#html-body [data-pb-style=E2Q7KR6],#html-body [data-pb-style=N4O0I1Q]{max-width:100%;height:auto}#html-body [data-pb-style=XQLLKI4]{text-align:center;border-style:none}#html-body [data-pb-style=B6S0K6P],#html-body [data-pb-style=V3D36T8]{max-width:100%;height:auto}#html-body [data-pb-style=NOM83SI]{justify-content:flex-start;display:flex;flex-direction:column;background-position:center center;background-size:auto;background-repeat:no-repeat;background-attachment:scroll;min-height:150px;width:100%;align-self:center}@media only screen and (max-width: 768px) { #html-body [data-pb-style=H1GJ0EL],#html-body [data-pb-style=VLP822O]{display:flex;flex-direction:column;align-self:stretch;min-height:258px}#html-body [data-pb-style=XQLLKI4],#html-body [data-pb-style=YG3IRNB]{border-style:none} }</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="F9KFVSM"><div class="pagebuilder-column-group" style="display: flex;" data-content-type="column-group" data-grid-size="12" data-element="main"><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/Grupo_9.png}}\&quot;,\&quot;mobile_image\&quot;:\&quot;{{media url=wysiwyg/Grupo_13_2.png}}\&quot;}" data-element="main" data-pb-style="VLP822O"></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="H1GJ0EL"><figure data-content-type="image" data-appearance="full-width" data-element="main" data-pb-style="YG3IRNB"><img class="pagebuilder-mobile-hidden" src="{{media url=wysiwyg/Grupo_10.png}}" alt="" title="" data-element="desktop_image" data-pb-style="N4O0I1Q"><img class="pagebuilder-mobile-only" src="{{media url=wysiwyg/Grupo_14_1.png}}" alt="" title="" data-element="mobile_image" data-pb-style="E2Q7KR6"></figure><figure data-content-type="image" data-appearance="full-width" data-element="main" data-pb-style="XQLLKI4"><img class="pagebuilder-mobile-hidden" src="{{media url=wysiwyg/Grupo_11.png}}" alt="" title="" data-element="desktop_image" data-pb-style="V3D36T8"><img class="pagebuilder-mobile-only" src="{{media url=wysiwyg/Grupo_15_1.png}}" alt="" title="" data-element="mobile_image" data-pb-style="B6S0K6P"></figure></div></div><div class="pagebuilder-column-group" style="display: flex;" data-content-type="column-group" data-grid-size="12" data-element="main"><div class="pagebuilder-column" data-content-type="column" data-appearance="align-center" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/wine-not_2.png}}\&quot;,\&quot;mobile_image\&quot;:\&quot;{{media url=wysiwyg/6_2.png}}\&quot;}" data-element="main" data-pb-style="NOM83SI"></div></div></div></div>'
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