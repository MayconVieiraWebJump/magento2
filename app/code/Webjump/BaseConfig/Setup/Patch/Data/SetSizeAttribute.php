<?php


namespace Webjump\BaseConfig\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;


class SetSizeAttribute implements DataPatchInterface
{
    private $moduleDataSetup;
    private $eavSetupFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        ModuleDataSetupInterface $moduleDataSetup
    )
    {
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

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'Size',
            [
                'attribute_set' => 'Moda_Attribute_Set',
                'type' => 'varchar',
                'comparable' => '1',
                'filterable_in_search' => '1',
                'filterable' => '1',
                'label' => 'Size',
                'input' => 'text',
                'is_filterable_in_grid' => '1',
                'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_WEBSITE,
                'visible' => '1',
                'required' => '0',
                'user_defined' => '1',
                'unique' => '0',
                'visible_on_front' => '1',
                'searchable' => '1',
                'visible_in_advanced_search' => '1'
            ]
        );

        $entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        
        $attributeSetId = $eavSetup->getAttributeSet(
            $entityTypeId, 
            'Moda_Attribute_Set', 
            'attribute_set_id'
        );


        $attributeId = $eavSetup->getAttributeId(
            $entityTypeId,
            'Size'
        );

        $eavSetup->addAttributeToSet(
            $entityTypeId,
            $attributeSetId,
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