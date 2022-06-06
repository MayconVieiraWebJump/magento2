<?php

namespace Webjump\LanguageAndCurrency\Setup\Patch\Data;

use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Eav\Api\Data\AttributeFrontendLabelInterfaceFactory;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Store\Model\StoreManagerInterface;

class TranslateAttributes
{
    private StoreManagerInterface $storeManager;
    private EavSetupFactory $eavSetupFactory;
    private ProductAttributeRepositoryInterface $productAttributeRepository;
    private AttributeFrontendLabelInterfaceFactory $attributeFrontendLabel;
    private ModuleDataSetupInterface $moduleDataSetup;

    public function __construct(
        StoreManagerInterface $storeManager,
        EavSetupFactory $eavSetupFactory,
        ProductAttributeRepositoryInterface $productAttributeRepository,
        AttributeFrontendLabelInterfaceFactory $attributeFrontendLabel,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->productAttributeRepository = $productAttributeRepository;
        $this->attributeFrontendLabel = $attributeFrontendLabel;
    }

    public function getAliases()
    {
        return [
        ];
    }

    public static function getDependencies()
    {
        return [
            \Webjump\BaseConfig\Setup\Patch\Data\SetTamanhoAttribute::class,
            \Webjump\BaseConfig\Setup\Patch\Data\SetSizeSneakersAttributes::class,
            \Webjump\BaseConfig\Setup\Patch\Data\SetWineTypeAttribute::class,
            \Webjump\BaseConfig\Setup\Patch\Data\SetYearAttribute::class,
            \Webjump\BaseConfig\Setup\Patch\Data\SetTypeAttribute::class
        ];
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(
            ['setup' => $this->moduleDataSetup]
        );

        $entityTypeId = $eavSetup->getEntityTypeId(
            \Magento\Catalog\Model\Product::ENTITY
        );

        $colorAttributeId = $eavSetup->getAttributeId(
            $entityTypeId,
            'color'
        );

        $fabricAttributeId = $eavSetup->getAttributeId(
            $entityTypeId,
            'FabricType'
        );

        $wineTypeAttributeId = $eavSetup->getAttributeId(
            $entityTypeId,
            'WyneType'
        );

        $yearAttributeId = $eavSetup->getAttributeId(
            $entityTypeId,
            'Year'
        );

        $sneakerSizeAttributeId = $eavSetup->getAttributeId(
            $entityTypeId,
            'tamanhosnek'
        );

        $clothesSizeAttributeId = $eavSetup->getAttributeId(
            $entityTypeId,
            'tamanhoclo'
        );


        $modaStoreId = $this->storeManager
            ->getStore("msvBR")
            ->getId();

        $wineStoreId = $this->storeManager
            ->getStore("wsvBR")
            ->getId();

        $this->translateAttribute("Cor", $modaStoreId, $wineStoreId, $colorAttributeId);
        $this->translateAttribute("Composição", $modaStoreId, $wineStoreId, $fabricAttributeId);
        $this->translateAttribute("Tipo de Vinho", $modaStoreId, $wineStoreId, $wineTypeAttributeId);
        $this->translateAttribute("Safra", $modaStoreId, $wineStoreId, $yearAttributeId);
        $this->translateAttribute("Tamanho", $modaStoreId, $wineStoreId, $sneakerSizeAttributeId);
        $this->translateAttribute("Tamanho", $modaStoreId, $wineStoreId, $clothesSizeAttributeId);


        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function translateAttribute(
        $newName,
        $modaStoreId,
        $wineStoreId,
        $attributeId
    ) {
        $attribute = $this->productAttributeRepository->get($attributeId);

        $frontendLabels = [
            $this->attributeFrontendLabel->create()
                ->setStoreId($modaStoreId)
                ->setLabel($newName),
            $this->attributeFrontendLabel->create()
                ->setStoreId($wineStoreId)
                ->setLabel($newName),
        ];

        $attribute->setFrontendLabels($frontendLabels);

        $this->productAttributeRepository->save($attribute);
    }
}
