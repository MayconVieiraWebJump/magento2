<?php

namespace Webjump\LanguageAndCurrency\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Sales\Model\Order\StatusFactory;


class OrderStatus implements DataPatchInterface
{
    private $moduleDataSetup;
    private $statusFactory;
    function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        StatusFactory $statusFactory,
        StoreManagerInterface $storeManager
        )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->statusFactory = $statusFactory;
        $this->storeManager = $storeManager;
    }
    
    public static function getDependencies()
    {
        return [
        ];
    }

    public function getAliases()
    {
        return [
        ];
    }
    
    private function getStoreLabels($label): array
    {
    $storeViewModaId = $this->storeManager
        ->getStore("msvEN")
        ->getId();

    $storeViewWineId = $this->storeManager
        ->getStore("wsvEN")
        ->getId();

      return [
         $storeViewModaId => $label, // Here we define Status Label
         $storeViewWineId => $label // Here we define Status Label
      ];
    }

    public function translate($code, $label)
    {
        $status = $this->statusFactory->create()->load($code);
        if(!$status->getStatus()) {
           // lançar exceção
        }
        $status->setData('store_labels', $this->getStoreLabels($label));
        $status->save();
    }


    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        
        $this->translate("processing", "Processing");
        $this->translate("fraud", "Suspected Fraud");
        $this->translate("pending_payment", "Pending Payment");
        $this->translate("pending", "Pending");
        $this->translate("holded", "On Hold");
        $this->translate("STATE_OPEN", "Open");
        $this->translate("complete", "Complete");
        $this->translate("closed", "Closed");
        $this->translate("canceled", "Canceled");
        $this->translate("paypal_canceled_reversal", "PayPal Canceled Reversal");
        $this->translate("pending_paypal", "Pending PayPal");
        $this->translate("paypal_reversed", "PayPal Reversed");


        

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}

