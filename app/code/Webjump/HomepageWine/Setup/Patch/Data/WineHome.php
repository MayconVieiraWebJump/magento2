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

public function createPageBR()
{
    $StoreViewGetIdBR = $this->storeManager
    ->getStore("wsvBR")
    ->getId();


    $pageData = [

        'title' => 'Wine Club BR', // cms page title
        'page_layout' => 'cms-full-width', // cms page layout
        'meta_keywords' => '', // cms page meta keywords
        'meta_description' => '', // cms page meta description
        'identifier' => 'wineclubbr', // cms page identifier
        'content_heading' => '', // cms page content heading
        'content' => '<div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="6" type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="7" type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="11" type_name="CMS Static Block"}}</div>', // cms page content
        'layout_update_xml' => '', // cms page layout xml
        'url_key' => 'winebr', // cms page url key
        'is_active' => 1, // status enabled or disabled
        'stores' => [$StoreViewGetIdBR], // You can set store id single or multiple values in array.
        'sort_order' => 0, // cms page sort order
    ];
    $this->moduleDataSetup->startSetup();
    $this->pageFactory->create()->setData($pageData)->save();
    $this->moduleDataSetup->endSetup();
}

public function createPageEN()
{
    
    $StoreViewGetIdEN = $this->storeManager
    ->getStore("wsvEN")
    ->getId();

    $pageData = [

        'title' => 'Wine Club EN', // cms page title
        'page_layout' => 'cms-full-width', // cms page layout
        'meta_keywords' => '', // cms page meta keywords
        'meta_description' => '', // cms page meta description
        'identifier' => 'winecluben', // cms page identifier
        'content_heading' => '', // cms page content heading
        'content' => '<div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="6" type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="7" type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="11" type_name="CMS Static Block"}}</div>', // cms page content
        'layout_update_xml' => '', // cms page layout xml
        'url_key' => 'wineen', // cms page url key
        'is_active' => 1, // status enabled or disabled
        'stores' => [$StoreViewGetIdEN], // You can set store id single or multiple values in array.
        'sort_order' => 0, // cms page sort order
    ];
    $this->moduleDataSetup->startSetup();
    $this->pageFactory->create()->setData($pageData)->save();
    $this->moduleDataSetup->endSetup();
}


public function apply()
{
    $this->moduleDataSetup->getConnection()->startSetup(); 
    
    $this->createPageBR();
    $this->createPageEN();

    $this->moduleDataSetup->getConnection()->endSetup();
}

}