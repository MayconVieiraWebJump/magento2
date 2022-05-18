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
    
    
    public function setGlobalSettings(string $websiteCode)
    {
        $websiteGetId = $this->storeManager
        ->getWebsite($websiteCode)
        ->getId();

        $this->writer->save(
            "payment/checkmo/active",
            "1",
            "websites",
            $websiteGetId
        );

        $this->writer->save(
            "payment/checkmo/order_status",
            "pending",
            "websites",
            $websiteGetId
        );

        $this->writer->save(
            "payment/checkmo/allowspecific",
            "1",
            "websites",
            $websiteGetId
         );
 
         $this->writer->save(
             "payment/checkmo/specificcountry",
             "BR,US",
             "websites",
             $websiteGetId
         );

         $this->writer->save(
            "payment/checkmo/sort_order",
            "0",
            "websites",
            $websiteGetId
        );
        
        $this->writer->save(
            "payment/banktransfer/specificcountry",
            "BR,US",
            "websites",
            $websiteGetId
        );

        $this->writer->save(
            "payment/banktransfer/active",
            "1",
            "websites",
            $websiteGetId
        );

        $this->writer->save(
           "payment/banktransfer/sort_order",
           "1",
           "websites",
           $websiteGetId
        );

        $this->writer->save(
            "payment/banktransfer/order_status",
            "pending",
            "websites",
            $websiteGetId
        );

    }
    
    public function setPaymentCheckAndMoney(string $storeViewCode, string $language)
    {
        
        $StoreViewGetId = $this->storeManager
        ->getStore($storeViewCode)
        ->getId();
        
        if ($language == 'br'){

            $this->writer->save(
                "payment/checkmo/title",
                "Pagamento em cheque ou dinheiro",
                "stores",
                $StoreViewGetId
            ); 

        } else if ($language == "en") {

            $this->writer->save(
                "payment/checkmo/title",
                "Check / money order",
                "stores",
                $StoreViewGetId
            ); 
        }
        
        
        $this->writer->save(
            "payment/checkmo/active",
            "1",
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

    public function setPaymentBankTransfer(string $storeViewCode, string $language)
    {

        $StoreViewGetId = $this->storeManager
        ->getStore($storeViewCode)
        ->getId();

        if ($language == "br")
        {
            $this->writer->save(
                "payment/banktransfer/instructions",
                "Proprietário: Grupo 1 \nConta 000-01 \nBanco Webjump \nEndereço: Rua A \nnúmero 123",
                "stores",
                $StoreViewGetId
            );

            $this->writer->save(
                "payment/banktransfer/title",
                "Pagamento por transferência bancária",
                "stores",
                $StoreViewGetId
            );

        } else if ($language == "en") 
        {
            $this->writer->save(
                "payment/banktransfer/instructions",
                "Owner: Group 1 \nAccount: 000-01 \nWebjump Bank \nAddress: A street, number 123",
                "stores",
                $StoreViewGetId
            );

            $this->writer->save(
                "payment/banktransfer/title",
                "Bank Transfer Payment",
                "stores",
                $StoreViewGetId
            );
        }
        
        $this->writer->save(
            "payment/banktransfer/specificcountry",
            "BR,US",
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
            "payment/banktransfer/order_status",
            "pending",
            "stores",
            $StoreViewGetId
        );
    }


}