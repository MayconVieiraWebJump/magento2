<?php

namespace Webjump\LanguageAndCurrency\Setup\Patch\Data;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\StoreManagerInterface;

class ModaStoreBRConfig implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;
    private WriterInterface $writer;
    private StoreManagerInterface $storeManager;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        WriterInterface $writer,
        StoreManagerInterface $storeManager
    ) {
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
            ->getStore("msvBR")
            ->getId();

        $this->writer->save(
            "general/locale/code",
            "pt_BR",
            "stores",
            $storeId
        );

        $this->writer->save(
            "general/locale/weight_unit",
            "kgs",
            "stores",
            $storeId
        );

        $this->writer->save(
            "general/locale/timezone",
            "America/Sao_Paulo",
            "stores",
            $storeId
        );

        $this->writer->save(
            "currency/options/allow",
            "BRL",
            "stores",
            $storeId
        );

        $this->writer->save(
            "currency/options/default",
            "BRL",
            "stores",
            $storeId
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
