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

    const IDENTIFIER_BLOCK = 'grid_moda_br';

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
            'title' => 'Grid Moda pt-br',
            'identifier' => self::IDENTIFIER_BLOCK,
            'stores' => [2],
            'content' => '<style>#html-body [data-pb-style=F62JGXN],#html-body [data-pb-style=OXHMFUI],#html-body [data-pb-style=R9K294C],#html-body [data-pb-style=RP02UGY],#html-body [data-pb-style=X1MX3XF]{justify-content:center;display:flex;flex-direction:column;background-position:center center;background-size:auto;background-repeat:no-repeat;background-attachment:scroll;text-align:center}#html-body [data-pb-style=F62JGXN],#html-body [data-pb-style=R9K294C],#html-body [data-pb-style=RP02UGY],#html-body [data-pb-style=X1MX3XF]{min-height:610px;width:calc(50% - 20px);margin:10px;align-self:stretch}@media only screen and (max-width: 768px) { #html-body [data-pb-style=F62JGXN],#html-body [data-pb-style=R9K294C],#html-body [data-pb-style=RP02UGY],#html-body [data-pb-style=X1MX3XF]{display:flex;flex-direction:column;min-height:320px;align-self:stretch} }</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="OXHMFUI"><div class="pagebuilder-column-group" style="display: flex;" data-content-type="column-group" data-grid-size="12" data-element="main"><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/Banner_1_1.jpg}}\&quot;,\&quot;mobile_image\&quot;:\&quot;{{media url=wysiwyg/Grupo_74.png}}\&quot;}" data-element="main" data-pb-style="X1MX3XF"></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/Banner_2_1.jpg}}\&quot;,\&quot;mobile_image\&quot;:\&quot;{{media url=wysiwyg/Grupo_144.png}}\&quot;}" data-element="main" data-pb-style="F62JGXN"></div></div><div class="pagebuilder-column-group" style="display: flex;" data-content-type="column-group" data-grid-size="12" data-element="main"><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/Banner_3_1.png}}\&quot;,\&quot;mobile_image\&quot;:\&quot;{{media url=wysiwyg/Grupo_145.png}}\&quot;}" data-element="main" data-pb-style="R9K294C"></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/Banner_4_1.png}}\&quot;,\&quot;mobile_image\&quot;:\&quot;{{media url=wysiwyg/Grupo_146.png}}\&quot;}" data-element="main" data-pb-style="RP02UGY"></div></div></div></div>'
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