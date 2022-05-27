<?php

namespace Webjump\HomePageWine\Setup\Patch\Data;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class SetDefaultPageWine implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;
    private StoreManagerInterface $storeManager;
    private WriterInterface $writer;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        StoreManagerInterface $storeManager,
        WriterInterface $writer)
{
    $this->moduleDataSetup = $moduleDataSetup;
    $this->storeManager = $storeManager;
    $this->writer = $writer;
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

public function setDefaultCmsPage (string $storeViewCode, string $defaultUrl) {

    $StoreViewGetId = $this->storeManager
    ->getStore($storeViewCode)
    ->getId();

    $this->writer->save (
        "web/default/cms_home_page",
        $defaultUrl, 
        "stores",
        $StoreViewGetId
    );

}

public function apply()
{
    $this->moduleDataSetup->startSetup();


    $this->setDefaultCmsPage("wsvBR", "wineclubbr");
    $this->setDefaultCmsPage("wsvEN", "winecluben");

    $this->moduleDataSetup->endSetup();
}
}