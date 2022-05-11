<?php
namespace Webjump\MagnoliaSettings\Setup\Patch\Data;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\View\Design\Theme\ThemeProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Setup\Module\Setup;
use Magento\Store\Api\WebsiteRepositoryInterface;

class SetThemeMagnolia implements DataPatchInterface
{
    const THEME_PATH = "design/theme/theme_id";
    private $moduleDataSetup;
    private $writer;
    private $themeProvider;
    private $websiteRepository;
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        WriterInterface $writer,
        ThemeProviderInterface $themeProvider,
        WebsiteRepositoryInterface $websiteRepository
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->writer = $writer;
        $this->themeProvider = $themeProvider;
        $this->websiteRepository = $websiteRepository;
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
            ->getThemeByFullPath("frontend/Webjump/Magnolia")
            ->getId();
        $website = $this->websiteRepository->get('moda_br');
        $this->writer->save(
            self::THEME_PATH,
            $themeId,
            $scopeConfig = "websites",
            $scopeId = $website->getId()
        );
        $this->moduleDataSetup->getConnection()->endSetup();
    }
    public function getAliases()
    {
        return [
        ];
    }
}
