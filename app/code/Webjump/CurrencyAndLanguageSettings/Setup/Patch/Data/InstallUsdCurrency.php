<?php

namespace Webjump\CurrencyAndLanguageSettings\Setup\Patch\Data;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class InstallUsdCurrency implements DataPatchInterface
{
    
    private $moduleDataSetup;
    private $writer;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        WriterInterface $writer
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
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
    
    public function apply()
    {

        $this->moduleDataSetup->getConnection()->startSetup();        
        
        $this->writer->save(
            "system/currency/installed",
            "BRL,USD"
        );
        
        $this->moduleDataSetup->getConnection()->endSetup();
    }
}