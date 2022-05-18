<?php

namespace Webjump\PaymentMethods;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\StoreManagerInterface;


Class PaymentSetAttribute {

    public function __construct(
        WriterInterface $writer,
        StoreManagerInterface $storeManager
    )
    {
        $this->writer = $writer;
        $this->storeManager = $storeManager;
    }
    
    
    public function setPaymentCheckAndMoney(string $StoreViewCode)
    {
        
        $StoreViewGetId = $this->storeManager->getStore($StoreViewCode)->getId();
        
        $this->writer->save(
            "payment/checkmo/active",
            "1",
            "stores",
            $StoreViewGetId
        );

        $this->writer->save(
            "payment/checkmo/title",
            "Check / Money Order",
            "stores",
            $StoreViewGetId
        );

        $this->writer->save(
            "payment/checkmo/order_status",
            "pending",
            "stores",
            $StoreViewGetId
        );

        $this->writer->save(
           "payment/checkmo/allowspecific",
           "1",
           "stores",
           $StoreViewGetId
        );

        $this->writer->save(
            "payment/checkmo/specificcountry",
            "BR,US",
            "stores",
            $StoreViewGetId
        );

        $this->writer->save(
            "payment/checkmo/sort_order",
            "0",
            "stores",
            $StoreViewGetId
        );
    }

    public function setPaymentBankTransfer($StoreViewCode)
    {

        $StoreViewGetId = $this->storeManager
        ->getStore($StoreViewCode)
        ->getId();

        $this->writer->save(
            "payment/banktransfer/specificcountry",
            "BR,US",
            "stores",
            $StoreViewGetId
        );

        $this->writer->save(
            "payment/banktransfer/instructions",
            "Test Classe implementada",
            "stores",
            $StoreViewGetId
        );

        $this->writer->save(
            "payment/banktransfer/active",
            "1",
            "stores",
            $StoreViewGetId
        );

        $this->writer->save(
           "payment/banktransfer/sort_order",
           "1",
           "stores",
           $StoreViewGetId
        );

        $this->writer->save(
            "payment/banktransfer/title",
            "Bank Transfer Payment",
            "stores",
            $StoreViewGetId
        );

        $this->writer->save(
            "payment/banktransfer/order_status",
            "pending",
            "stores",
            $StoreViewGetId
        );
    }


}