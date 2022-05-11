<?php

namespace Webjump\CarbonoSettings\Setup\Patch\Data;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\View\Design\Theme\ThemeProviderInterface;

class SetCarbono implements DataPatchInterface
{
    # get the theme ID
    CONST PATH_THEME = "design/theme/theme_id";

    private $moduleDataSetup;
    private $writer;
    private $themeProvider;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        WriterInterface $writer,
        ThemeProviderInterface  $themeProvider
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->writer = $writer;
        $this->themeProvider = $themeProvider;
    }

    public function getAliases()
    {
        return [
        ];
    }

    public static function getDependencies()
    {
        return [
        ];
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $themeId = $this->themeProvider
            ->getThemeByFullPath("frontend/Webjump/theme-frontend-carbono")
            ->getId();

        $this->writer->save(self::PATH_THEME,$themeId);

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
