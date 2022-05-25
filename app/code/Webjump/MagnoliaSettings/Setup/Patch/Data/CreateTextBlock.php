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

class CreateTextBlock implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    const IDENTIFIER_BLOCK = 'text-magnolia-ptbr';

    /**
     * CreateTextBlock constructor.
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
     * Patch Method "Apply" method $this->createTextBlock()
     * @return DataPatchInterface|void
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->createTextBlock();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     *  Method to create cms landing page
     */
    protected function createTextBlock()
    {
        $cmsBlock = $this->blockFactory->create()->load(self::IDENTIFIER_BLOCK, 'identifier');

        $cmsBlockData = [
            'is_active' => 1,
            'title' => 'Texto descritivo Magnolia',
            'identifier' => self::IDENTIFIER_BLOCK,
            'stores' => [2],
            '<style>#html-body [data-pb-style=UYHFFH1]{justify-content:flex-start;display:flex;flex-direction:column;background-position:center center;background-size:contain;background-repeat:no-repeat;background-attachment:scroll;text-align:center;min-height:68px;margin-top:60px;margin-bottom:20px}#html-body [data-pb-style=AMFGQW3],#html-body [data-pb-style=C3UEU2M],#html-body [data-pb-style=OMXXN97],#html-body [data-pb-style=QS80MC8]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div class="magnolia-text" data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/3-layers_1_.png}}\&quot;,\&quot;mobile_image\&quot;:\&quot;{{media url=wysiwyg/2-layers.png}}\&quot;}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="UYHFFH1"></div></div><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="AMFGQW3"><div data-content-type="text" data-appearance="default" data-element="main"><p id="UY0NIYA"><span style="font-size: 16px;"><strong>Magnolia L. é um género de plantas com flor, da ordem Magnoliales&nbsp;</strong></span></p></div></div></div><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="OMXXN97"><div data-content-type="text" data-appearance="default" data-element="main"><p>Agrupa as espécies maioritariamente arbóreas conhecidas pelo nome comum de magnólias. Na sua presente circunscrição taxonómica o género foi alargado para incluir as espécies que se encontravam dispersas pelos géneros Magnolia, Manglietia, Michelia, Talauma, Aromadendron, Kmeria, Pachylarnax e Alcimandra (todos da antiga subfamília Magnolioideae), resultando num género monofilético com cerca de 297 espécies. O género distribui-se pelas regiões subtropicais e tropicais do leste e sueste da Ásia (incluindo a Malésia) e pelas Américas, com centros de diversidade no Sueste Asiático e no norte da América do Sul. O género inclui diversas espécies amplamente utilizadas como árvore ornamental nas regiões subtropicais e temperadas de ambos os hemisférios.&nbsp;</p></div></div></div><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="C3UEU2M"><div data-content-type="text" data-appearance="default" data-element="main"><p id="SJFMFTS"><span style="font-size: 16px;"><strong>Descrição da Marca</strong></span></p></div></div></div><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="QS80MC8"><div data-content-type="text" data-appearance="default" data-element="main"><p>O género Magnolia tem como epónimo o nome de Pierre Magnol, um botânico de Montpellier (França). A primeira espécie identificada deste género foi Magnolia virginiana, encontrada por missionários enviados à América do Norte na década de 1680. Já em pleno século XVIII foi descrita, também a partir de amostras norte-americanas, a espécie Magnolia grandiflora, hoje a espéci mais conhecida do género dado ser amplamente utilizada como árvore ornamental nas regiões subtropicais e temperadas de clima moderado de todo o mundo.</p></div></div></div>'
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