<?php

namespace Webjump\Shipping\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Webjump\Shipping\SetTableRate;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\StoreManagerInterface;


class SetShipping implements DataPatchInterface
{
    private $moduleDataSetup;
    private $tableRate;
    

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        SetTableRate $tableRate,
        WriterInterface $writer,
        StoreManagerInterface $storeManager
    )
    
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->tableRate = $tableRate;
        $this->writer = $writer;
        $this->storeManager = $storeManager;
        
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

    public function deactivateFlatRate($websiteCode)
    {
        $websiteGetId = $this->storeManager
        ->getWebsite($websiteCode)
        ->getId();
        
        $this->writer->save(
            "carriers/flatrate/active",
            "0",
            "websites",
            $websiteGetId
        );

    }
    
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        
       $this->deactivateFlatRate("moda_br");
       $this->deactivateFlatRate("wine_br"); 
        
        $this->tableRate->setAllowedCountries("moda_br");
        $this->tableRate->setAllowedCountries("wine_br");

        
        $this->tableRate->setTableRateGlobal("moda_br");
        $this->tableRate->setTableRateGlobal("wine_br");

        
        $this->tableRate->setTableRateDefault("msvBR", "br");
        $this->tableRate->setTableRateDefault("msvEN", "en");
        $this->tableRate->setTableRateDefault("wsvBR", "br");
        $this->tableRate->setTableRateDefault("wsvEN", "en");

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}