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

        $this->storeViewPaymentSetup->setGlobalSettings("moda_br");
        $this->storeViewPaymentSetup->setGlobalSettings("wine_br");


        $this->storeViewPaymentSetup->setPaymentCheckAndMoney("msvBR", "br");
        $this->storeViewPaymentSetup->setPaymentBankTransfer("msvBR", "br");

        $this->storeViewPaymentSetup->setPaymentCheckAndMoney("msvEN", "en");
        $this->storeViewPaymentSetup->setPaymentBankTransfer("msvEN", "en");

        $this->storeViewPaymentSetup->setPaymentCheckAndMoney("wsvBR", "br");
        $this->storeViewPaymentSetup->setPaymentBankTransfer("wsvBR", "br");

        $this->storeViewPaymentSetup->setPaymentCheckAndMoney("wsvEN", "en");
        $this->storeViewPaymentSetup->setPaymentBankTransfer("wsvEN", "en");



        $this->moduleDataSetup->getConnection()->endSetup();
    }
}