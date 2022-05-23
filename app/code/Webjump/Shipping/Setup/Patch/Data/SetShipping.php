<?php

namespace Webjump\Shipping\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Webjump\Shipping\SetTableRate;

class SetShipping implements DataPatchInterface
{
    private $moduleDataSetup;
    private $tableRate;
    

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        SetTableRate $tableRate
    )
    
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->tableRate = $tableRate;
        
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
        
        $this->tableRate->setTableRateGlobal("moda_br");
        $this->tableRate->setTableRateGlobal("wine_br");

        
        $this->tableRate->setTableRateDefault("msvBR", "br");
        $this->tableRate->setTableRateDefault("msvEN", "en");
        $this->tableRate->setTableRateDefault("wsvBR", "br");
        $this->tableRate->setTableRateDefault("wsvEN", "en");

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}