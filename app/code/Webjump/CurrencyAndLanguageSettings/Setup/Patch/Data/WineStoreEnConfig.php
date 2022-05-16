<?php

namespace Webjump\CurrencyAndLanguageSettings\Setup\Patch\Data;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\StoreManagerInterface;


class WineStoreEnConfig implements DataPatchInterface
{
    
    private $moduleDataSetup;
    private $writer;
    private $storeManager;
    
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        WriterInterface $writer,
        StoreManagerInterface $storeManager
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
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
    
    public function apply()
    {
   
        $this->moduleDataSetup->getConnection()->startSetup();
        
        
        $storeId = $this->storeManager
            ->getStore("msvEN")
            ->getId();

        $this->writer->save(
            "general/locale/code",
            "en_US",
            "stores",
            $storeId
        );

        $this->writer->save(
            "general/locale/weight_unit",
            "lbs",
            "stores",
            $storeId
        );

        $this->writer->save(
            "general/locale/timezone",
            "America/Los_Angeles",
            "stores",
            $storeId
        );

        $this->writer->save(
           "currency/options/allow",
           "USD",
           "stores",
           $storeId 
        );

        $this->writer->save(
            "currency/options/default",
            "USD",
            "stores",
            $storeId
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
