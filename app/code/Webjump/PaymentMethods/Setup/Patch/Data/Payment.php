<?php

namespace Webjump\PaymentMethods\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Webjump\PaymentMethods\PaymentSetAttribute;

class Payment implements DataPatchInterface
{
    private $moduleDataSetup;
    private $storeViewPaymentSetup;
    

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PaymentSetAttribute $storeViewPaymentSetup
    )
    
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->storeViewPaymentSetup = $storeViewPaymentSetup;
        
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

        $this->storeViewPaymentSetup->setPaymentCheckAndMoney("msvBR");
        $this->storeViewPaymentSetup->setPaymentBankTransfer("msvBR");

        $this->storeViewPaymentSetup->setPaymentCheckAndMoney("msvEN");
        $this->storeViewPaymentSetup->setPaymentBankTransfer("msvEN");

        $this->storeViewPaymentSetup->setPaymentCheckAndMoney("wsvBR");
        $this->storeViewPaymentSetup->setPaymentBankTransfer("wsvBR");

        $this->storeViewPaymentSetup->setPaymentCheckAndMoney("wsvEN");
        $this->storeViewPaymentSetup->setPaymentBankTransfer("wsvEN");



        $this->moduleDataSetup->getConnection()->endSetup();
    }
}