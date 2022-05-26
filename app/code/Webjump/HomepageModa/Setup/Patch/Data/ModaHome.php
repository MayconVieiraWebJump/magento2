<?php

namespace Webjump\HomePageModa\Setup\Patch\Data;

use Magento\Cms\Model\PageFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class ModaHome implements DataPatchInterface
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
    ->getStore("msvBR")
    ->getId();

    $pageData = [

        'title' => 'Magnolia', // cms page title
        'page_layout' => 'cms-full-width', // cms page layout
        'meta_keywords' => '', // cms page meta keywords
        'meta_description' => '', // cms page meta description
        'identifier' => 'modabr', // cms page identifier
        'content_heading' => '', // cms page content heading
        'content' => '<div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="banner_moda_br" type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="banner_info_moda_br" type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="grid_moda_br" type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="carrossel_moda_br" type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="text-magnolia-ptbr" type_name="CMS Static Block"}}</div>', // cms page content
        'layout_update_xml' => '', // cms page layout xml
        'url_key' => 'modabr', // cms page url key
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
    ->getStore("msvEN")
    ->getId();

    $pageData = [

        'title' => 'Magnolia', // cms page title
        'page_layout' => 'cms-full-width', // cms page layout
        'meta_keywords' => '', // cms page meta keywords
        'meta_description' => '', // cms page meta description
        'identifier' => 'modaen', // cms page identifier
        'content_heading' => '', // cms page content heading
        'content' => '<div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="banner_moda_en" type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="banner_info_moda_en" type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="grid_moda_en" type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="carrossel_moda_en" type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="text-magnolia-ptbr" type_name="CMS Static Block"}}</div>', // cms page content
        'layout_update_xml' => '', // cms page layout xml
        'url_key' => 'modaen', // cms page url key
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