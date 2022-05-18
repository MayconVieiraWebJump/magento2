<?php

namespace Webjump\PaymentMethods\Setup\Patch\Data;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\StoreManagerInterface;

class Payment implements DataPatchInterface
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
            ->getStore("msvBR")
            ->getId();

        $this->writer->save(
            "payment/checkmo/active",
            "1",
            "stores",
            $storeId
        );

        $this->writer->save(
            "payment/checkmo/title",
            "Check / Money Order",
            "stores",
            $storeId
        );

        $this->writer->save(
            "payment/checkmo/order_status",
            "pending",
            "stores",
            $storeId
        );

        $this->writer->save(
           "payment/checkmo/allowspecific",
           "1",
           "stores",
           $storeId
        );

        $this->writer->save(
            "payment/checkmo/specificcountry",
            "BR,US",
            "stores",
            $storeId
        );

        $this->writer->save(
            "payment/checkmo/sort_order",
            "0",
            "stores",
            $storeId
        );
        
       
       
       
       
       
        $this->writer->save(
            "payment/banktransfer/specificcountry",
            "BR,US",
            "stores",
            $storeId
        );

        $this->writer->save(
            "payment/banktransfer/instructions",
            "Test",
            "stores",
            $storeId
        );

        $this->writer->save(
            "payment/banktransfer/active",
            "1",
            "stores",
            $storeId
        );

        $this->writer->save(
           "payment/banktransfer/sort_order",
           "1",
           "stores",
           $storeId
        );

        $this->writer->save(
            "payment/banktransfer/title",
            "Bank Transfer Payment",
            "stores",
            $storeId
        );

        $this->writer->save(
            "payment/banktransfer/order_status",
            "pending",
            "stores",
            $storeId
        );
        
        $this->moduleDataSetup->getConnection()->endSetup();
    }
}