<?php

declare(strict_types=1);

namespace Webjump\BaseConfig\Setup\Patch\Data;

use Magento\Catalog\Api\ProductAttributeOptionManagementInterface;
use Magento\Eav\Api\Data\AttributeOptionInterfaceFactory;
use Magento\Eav\Api\Data\AttributeOptionLabelInterface;
use Magento\Eav\Api\Data\AttributeOptionLabelInterfaceFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\StoreManagerInterface;

class TranslateColorAttributes implements DataPatchInterface
{
    private StoreManagerInterface $storeManager;
    private ModuleDataSetupInterface $moduleDataSetup;
    private AttributeOptionInterfaceFactory $attributeOptionInterfaceFactory;
    private AttributeOptionLabelInterfaceFactory $attributeOptionLabelInterfaceFactory;
    private ProductAttributeOptionManagementInterface $attributeOptionManagement;

    public function __construct(
        StoreManagerInterface $storeManager,
        ModuleDataSetupInterface $moduleDataSetup,
        AttributeOptionInterfaceFactory $attributeOptionInterfaceFactory,
        AttributeOptionLabelInterfaceFactory $attributeOptionLabelInterfaceFactory,
        ProductAttributeOptionManagementInterface $attributeOptionManagement
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->storeManager = $storeManager;
        $this->attributeOptionInterfaceFactory = $attributeOptionInterfaceFactory;
        $this->attributeOptionLabelInterfaceFactory = $attributeOptionLabelInterfaceFactory;
        $this->attributeOptionManagement = $attributeOptionManagement;
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

        $modaPtStoreId = $this->storeManager
            ->getStore("msvBR")
            ->getId();

        $winePtStoreId = $this->storeManager
            ->getStore("wsvBR")
            ->getId();

        $options = $this->attributeOptionManagement->getItems("color");

        foreach ($options as $option) {
            if ($option->getValue()) {
                $this->attributeOptionManagement->delete('color', $option->getValue());
            }
        }

        foreach ($this->getData() as $labelUs => $labelPt) {
            $modaLabel = $this->createAttributeOptionLabel($labelPt, (int)$modaPtStoreId);
            $wineLabel = $this->createAttributeOptionLabel($labelPt, (int)$winePtStoreId);

            $option = $this->attributeOptionInterfaceFactory->create();
            $option
                ->setLabel($labelUs)
                ->setStoreLabels([$modaLabel,$wineLabel]);

            $this->attributeOptionManagement->add(
                'color',
                $option
            );
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    private function getData(): array
    {
        return [
            "White" => "Branco",
            "Black" => "Preto",
            "Red" => "Vermelho",
            "Blue" => "Azul",
            "Yellow" => "Amarelo",
            "Green" => "Verde",
            "Orange" => "Laranja",
            "Pink" => "Rosa",
            "Beige" => "Bege"
        ];
    }

    private function createAttributeOptionLabel(string $labelPt, int $storeId)
    {
        /** @var AttributeOptionLabelInterface $attributeOptionLabel */
        $attributeOptionLabel = $this->attributeOptionLabelInterfaceFactory->create();

        $attributeOptionLabel
            ->setLabel($labelPt)
            ->setStoreId($storeId);

        return $attributeOptionLabel;
    }
}
