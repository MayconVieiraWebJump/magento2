<?php

namespace Webjump\PaymentMethods\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Webjump\PaymentMethods\PaymentSetAttribute;

class Payment implements DataPatchInterface
{
    private $moduleDataSetup;
    private $websitePaymentSetup;
    

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PaymentSetAttribute $websitePaymentSetup
    )
    
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->websitePaymentSetup = $websitePaymentSetup;
        
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

        $this->websitePaymentSetup->setPaymentCheckAndMoney("moda_br");
        $this->websitePaymentSetup->setPaymentBankTransfer("moda_br");


        $this->websitePaymentSetup->setPaymentCheckAndMoney("wine_br");
        $this->websitePaymentSetup->setPaymentBankTransfer("wine_br");

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}