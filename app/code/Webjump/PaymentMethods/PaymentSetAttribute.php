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
    
    
    public function setPaymentCheckAndMoney(string $WebsiteCode)
    {
        
        $WebsiteGetId = $this->storeManager->getWebsite($WebsiteCode)->getId();
        
        $this->writer->save(
            "payment/checkmo/active",
            "1",
            "websites",
            $WebsiteGetId
        );

        $this->writer->save(
            "payment/checkmo/title",
            "Check / Money Order",
            "websites",
            $WebsiteGetId
        );

        $this->writer->save(
            "payment/checkmo/order_status",
            "pending",
            "websites",
            $WebsiteGetId
        );

        $this->writer->save(
           "payment/checkmo/allowspecific",
           "1",
           "websites",
           $WebsiteGetId
        );

        $this->writer->save(
            "payment/checkmo/specificcountry",
            "BR,US",
            "websites",
            $WebsiteGetId
        );

        $this->writer->save(
            "payment/checkmo/sort_order",
            "0",
            "websites",
            $WebsiteGetId
        );
    }

    public function setPaymentBankTransfer($WebsiteCode)
    {

        $WebsiteGetId = $this->storeManager->getWebsite($WebsiteCode)->getId();


        $this->writer->save(
            "payment/banktransfer/specificcountry",
            "BR,US",
            "websites",
            $WebsiteGetId
        );

        $this->writer->save(
            "payment/banktransfer/instructions",
            "Test Classe implementada",
            "websites",
            $WebsiteGetId
        );

        $this->writer->save(
            "payment/banktransfer/active",
            "1",
            "websites",
            $WebsiteGetId
        );

        $this->writer->save(
           "payment/banktransfer/sort_order",
           "1",
           "websites",
           $WebsiteGetId
        );

        $this->writer->save(
            "payment/banktransfer/title",
            "Bank Transfer Payment",
            "websites",
            $WebsiteGetId
        );

        $this->writer->save(
            "payment/banktransfer/order_status",
            "pending",
            "websites",
            $WebsiteGetId
        );
    }


}