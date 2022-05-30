<?php

namespace Webjump\Shipping;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\StoreManagerInterface;


Class SetTableRate {

    public function __construct(
        WriterInterface $writer,
        StoreManagerInterface $storeManager
    )
    {
        $this->writer = $writer;
        $this->storeManager = $storeManager;
    }
    
    
    public function setAllowedCountries (string $websiteCode)
    {
        $websiteGetId = $this->storeManager
        ->getWebsite($websiteCode)
        ->getId();

        $this->writer->save(
            "general/country/allow",
            "BR,US",
            "websites",
            $websiteGetId
        ); 
    }
    
    public function setTableRateGlobal (string $websiteCode)
    {

        $websiteGetId = $this->storeManager
        ->getWebsite($websiteCode)
        ->getId();
        
        $this->writer->save(
            "carriers/tablerate/active",
            "1",
            "websites",
            $websiteGetId
        );

        $this->writer->save(
            "carriers/tablerate/condition_name",
            "package_weight",
            "websites",
            $websiteGetId
        );

        $this->writer->save(
            "carriers/tablerate/include_virtual_price",
            "0",
            "websites",
            $websiteGetId
        );

        $this->writer->save(
            "carriers/tablerate/sallowspecific",
            "1",
            "websites",
            $websiteGetId
        );

        $this->writer->save(
            "carriers/tablerate/specificcountry",
            "BR,US",
            "websites",
            $websiteGetId
        );

        $this->writer->save(
            "carriers/tablerate/showmethod",
            "0",
            "websites",
            $websiteGetId
        );

        $this->writer->save(
            "carriers/tablerate/sort_order",
            "0",
            "websites",
            $websiteGetId
        ); 
    }
    
    
    public function setTableRateDefault (string $storeViewCode, string $language)
    {
        
        $websiteGetId = $this->storeManager
        ->getStore($storeViewCode)
        ->getId();
        
        if ($language == 'br'){

            $this->writer->save(
                "carriers/tablerate/specificerrmsg",
                "Esse método de envio não está disponível. Para saber mais, por favor entre em contato conosco.",
                "stores",
                $websiteGetId
            );
            
            $this->writer->save(
                "carriers/tablerate/title",
                "WJ Expresso",
                "stores",
                $websiteGetId
            );

            $this->writer->save(
                "carriers/tablerate/name",
                "Taxa de tabela",
                "stores",
                $websiteGetId
            );

        } else if ($language == "en") {

            $this->writer->save(
                "carriers/tablerate/specificerrmsg",
                "This shipping method is not available. To find out more, please contact us.",
                "stores",
                $websiteGetId
            );
            
            $this->writer->save(
                "carriers/tablerate/title",
                "WJ Express",
                "stores",
                $websiteGetId
            );

            $this->writer->save(
                "carriers/tablerate/name",
                "Table Rate",
                "stores",
                $websiteGetId
            );
        }
    }
}