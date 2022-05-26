<?php

namespace Webjump\HomePageWine\Setup\Patch\Data;

use Magento\Cms\Model\PageFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class WineHome implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;
    private PageFactory $pageFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PageFactory $pageFactory,
        StoreManagerInterface $storeManager)
{
    $this->moduleDataSetup = $moduleDataSetup;
    $this->pageFactory = $pageFactory;
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

public function createPage()
{
    $StoreViewGetIdBR = $this->storeManager
    ->getStore("wsvBR")
    ->getId();

    $StoreViewGetIdEN = $this->storeManager
    ->getStore("wsvEN")
    ->getId();

    $pageData = [

        'title' => 'Woda', // cms page title
        'page_layout' => 'cms-full-width', // cms page layout
        'meta_keywords' => '', // cms page meta keywords
        'meta_description' => '', // cms page meta description
        'identifier' => 'winebr', // cms page identifier
        'content_heading' => '', // cms page content heading
        'content' => '', // cms page content
        'layout_update_xml' => '', // cms page layout xml
        'url_key' => 'winebr', // cms page url key
        'is_active' => 1, // status enabled or disabled
        'stores' => [$StoreViewGetIdBR, $StoreViewGetIdEN], // You can set store id single or multiple values in array.
        'sort_order' => 0, // cms page sort order
    ];
    $this->moduleDataSetup->startSetup();
    $this->pageFactory->create()->setData($pageData)->save();
    $this->moduleDataSetup->endSetup();
}


public function apply()
{
    $this->moduleDataSetup->getConnection()->startSetup(); 
    
    $this->createPage();

    $this->moduleDataSetup->getConnection()->endSetup();
}

}