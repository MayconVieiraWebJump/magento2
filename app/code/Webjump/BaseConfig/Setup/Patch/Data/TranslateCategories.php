<?php 

namespace Webjump\BaseConfig\Setup\Patch\Data;

use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Catalog\Api\CategoryListInterface;
use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\CreateCategory;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Store\Model\StoreManagerInterface;


class TranslateCategories implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;
    private CategoryRepository $categoryRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private CategoryListInterface $categoryList;
    private CategoryFactory $categoryFactory;


    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategoryRepository $categoryRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CategoryListInterface $categoryList,
        CategoryFactory $categoryFactory,
        StoreManagerInterface $storeManager

    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categoryRepository = $categoryRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->categoryList = $categoryList;
        $this->categoryFactory = $categoryFactory;
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
            CreateCategories::class
        ];
    }


    public function translate(string $categoryName, string $newName, int $storeId)
    {

    $category = $this->categoryFactory->create()->getCollection()
                ->addAttributeToFilter('name',$categoryName)->setPageSize(1)->getFirstItem();
                $category->setName($newName);
                $category->setStoreId($storeId);
                $category->save();  
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        
        $modaStoreId = $this->storeManager
        ->getStore("msvEN")
        ->getId();

        $wineStoreId = $this->storeManager
        ->getStore("wsvEN")
        ->getId();

        // Moda
        $this->translate("Roupas", "Clothes", $modaStoreId);

        $this->translate("Inverno", "Winter", $modaStoreId);
        $this->translate("Ver??o", "Summer", $modaStoreId);
        $this->translate("Primavera", "Spring", $modaStoreId);
        $this->translate("Outono", "Autumn", $modaStoreId);

        $this->translate("Pijamas", "Pajamas", $modaStoreId);
        $this->translate("Renda", "Laces", $modaStoreId);

        $this->translate("Cal??ados", "Shoes", $modaStoreId);
        $this->translate("Botas", "Boots", $modaStoreId);
        $this->translate("Sand??lias", "Sandals", $modaStoreId);
        $this->translate("T??nis", "Sneakers", $modaStoreId);

        $this->translate("Acess??rios", "Accessories", $modaStoreId);

        $this->translate("Promo????es", "Sales", $modaStoreId);


        // Wine
        $this->translate("Vinhos", "Wines", $wineStoreId);
        $this->translate("Vinhos Brancos", "White Wines", $wineStoreId);
        $this->translate("Vinhos Rose", "Rose Wines", $wineStoreId);
        $this->translate("Vinhos Tinto", "Red Wines", $wineStoreId);
        $this->translate("Espumantes", "Sparkling Wines", $wineStoreId);
        $this->translate("Frisantes", "Frisants", $wineStoreId);
        $this->translate("Cole????o NFT", "NFT Collection", $wineStoreId);
        $this->translate("Utens??lios", "Utensils", $wineStoreId);

        

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}