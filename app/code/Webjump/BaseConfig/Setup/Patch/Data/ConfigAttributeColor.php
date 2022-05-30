<?php

namespace Webjump\BaseConfig\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class ConfigAttributeColor implements DataPatchInterface
{
    private $moduleDataSetup;
    private $eavSetupFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public static function getDependencies()
    {
        return [
            \Webjump\BaseConfig\Setup\Patch\Data\CreateModaAttributeSets::class,
            \Webjump\BaseConfig\Setup\Patch\Data\CreateWineAttributeSets::class
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

        $modaAttributeSetId = $eavSetup->getAttributeSet(
            $entityTypeId,
            'Moda_Attribute_Set',
            'attribute_set_id'
        );

        $wineAttributeSetId = $eavSetup->getAttributeSet(
            $entityTypeId,
            'Wine_Attribute_Set',
            'attribute_set_id'
        );

        $attributeId = $eavSetup->getAttributeId(
            $entityTypeId,
            'color'
        );

        $options = [
            'attribute_id' => $attributeId,
            'values' => [
                'White',
                'Black',
                'Red',
                'Blue',
                'Yellow',
                'Green',
                'Pink',
                'Beige'
            ]
        ];

        $eavSetup->addAttributeOption($options);

        $eavSetup->addAttributeToSet(
            $entityTypeId,
            $modaAttributeSetId,
            'General',
            $attributeId,
            null
        );

        $eavSetup->addAttributeToSet(
            $entityTypeId,
            $wineAttributeSetId,
            'General',
            $attributeId,
            null
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getAliases()
    {
        return [
        ];
    }
}
