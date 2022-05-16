<?php

namespace Webjump\BaseConfig\Setup\Patch\Data;

use Magento\Catalog\Helper\DefaultCategory;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateCategories implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;
    private CategoryRepository $categoryRepository;
    private CategoryFactory $categoryFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        DefaultCategory $defaultCategoryHelper,
        CategoryFactory $categoryFactory,
        CategoryRepository $categoryRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Method for create all categories and subcategories
     * @param array $categories
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */

    public function createCategories(array $categories): void
    {
        foreach ($categories as $item) {
            $category = $this->categoryFactory->create();
            $category
                ->setData($item)
                ->setAttributeSetId($category->getDefaultAttributeSetId());
            $this->categoryRepository->save($category);
        }
    }

    /**
     * Method for create Root category
     * @return array
     */

    public function categoryRoot(string $name, string $urlKey): array
    {
        $categories = [];

        $categories[] = [
            'name' => $name,
            'url_key' => $urlKey,
            'is_active' => true,
            'is_anchor' => true,
            'include_in_menu' => true,
            'display_mode' => 'PRODUCTS_AND_PAGE',
            'parent_id' => '1'
        ];

        return $categories;
    }

    /**
     * Method for create subcategorie for Moda
     * @return array
     */

    public function subCategories(string $name, string $urlKey, string $rootKey): array
    {
        $category = $this->categoryFactory->create();
        $parentCategory = $category->loadByAttribute('url_key', $rootKey);

        $categories = [];

        $categories [] = [
            'name' => $name,
            'url_key' => $urlKey,
            'is_active' => true,
            'is_anchor' => true,
            'include_in_menu' => true,
            'display_mode' => 'PRODUCTS_AND_PAGE',
            'parent_id' => $parentCategory->getId()
        ];
        return $categories;
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

        $this->createCategories($this->categoryRoot('Moda', 'moda'));
        $this->createCategories($this->categoryRoot('Wine', 'wine'));

        $this->createCategories($this->subCategories('Roupas', 'roupas', 'moda'));
        $this->createCategories($this->subCategories('Inverno', 'inverno', 'roupas'));
        $this->createCategories($this->subCategories('Verão', 'verao', 'roupas'));
        $this->createCategories($this->subCategories('Primavera', 'primavera', 'roupas'));
        $this->createCategories($this->subCategories('Outono', 'outono', 'roupas'));

        $this->createCategories($this->subCategories('Lingerie', 'lingerie', 'moda'));
        $this->createCategories($this->subCategories('Pijamas', 'pijamas', 'lingerie'));
        $this->createCategories($this->subCategories('Renda', 'renda', 'lingerie'));

        $this->createCategories($this->subCategories('Calçados', 'calcados', 'moda'));
        $this->createCategories($this->subCategories('Botas', 'botas', 'calcados'));
        $this->createCategories($this->subCategories('Sandálias', 'sandalias', 'calcados'));
        $this->createCategories($this->subCategories('Tênis', 'tenis', 'calcados'));

        $this->createCategories($this->subCategories('Acessórios', 'acessorios-moda', 'moda'));
        $this->createCategories($this->subCategories('Promoções', 'promocoes', 'moda'));

        $this->createCategories($this->subCategories('Vinhos', 'vinhos', 'wine'));
        $this->createCategories($this->subCategories('Espumantes', 'espumantes', 'wine'));
        $this->createCategories($this->subCategories('Premium', 'premium', 'wine'));
        $this->createCategories($this->subCategories('Kits', 'kits', 'wine'));

        $this->createCategories($this->subCategories('Vinhos Brancos', 'vinhos-brancos', 'vinhos'));
        $this->createCategories($this->subCategories('Vinhos Rose', 'vinhos-rose', 'vinhos'));
        $this->createCategories($this->subCategories('Vinhos Tinto', 'vinhos-tinto', 'vinhos'));

        $this->createCategories($this->subCategories('Frisantes', 'frisantes', 'espumantes'));

        $this->createCategories($this->subCategories('Acessórios', 'acessorios-wine', 'kits'));
        $this->createCategories($this->subCategories('sobremesa', 'sobremesa', 'kits'));

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
