<?php

namespace Webjump\BaseConfig\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class SetSizeSneakersAttributes implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;
    private EavSetupFactory $eavSetupFactory;

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
            \Webjump\BaseConfig\Setup\Patch\Data\CreateModaAttributeSets::class
        ];
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(
            ['setup' => $this->moduleDataSetup]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'tamanhosnek',
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Tamanho',
                'input' => 'select',
                'class' => '',
                'source' => '',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => '',
                'visible_in_advanced_search' => '1',
                'option' => [
                    'values' => [
                        '30',
                        '31',
                        '32',
                        '33',
                        '34',
                        '35',
                        '36',
                        '37',
                        '38',
                        '39',
                        '40',
                        '41',
                        '42',
                        '43',
                        '44',
                        '45'
                    ]
                ]
            ]
        );

        $entityTypeId = $eavSetup->getEntityTypeId(
            \Magento\Catalog\Model\Product::ENTITY
        );

        $modaAttributeSetId = $eavSetup->getAttributeSet(
            $entityTypeId,
            'Moda_Attribute_Set',
            'attribute_set_id'
        );

        $attributeId = $eavSetup->getAttributeId(
            $entityTypeId,
            'tamanhosnek'
        );

        $eavSetup->addAttributeToSet(
            $entityTypeId,
            $modaAttributeSetId,
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
