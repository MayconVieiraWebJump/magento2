<?php

namespace Webjump\BaseConfig\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateWineAttributeSets implements DataPatchInterface
{
 private $attributeSetFactory;
 private $attributeSet;
 private $categorySetupFactory;
 private $moduleDataSetup;

 public function __construct(
     AttributeSetFactory $attributeSetFactory, 
     CategorySetupFactory $categorySetupFactory,
     ModuleDataSetupInterface $moduleDataSetup )
 {
 $this->attributeSetFactory = $attributeSetFactory;
 $this->categorySetupFactory = $categorySetupFactory;
 $this->moduleDataSetup = $moduleDataSetup;
 }

 public static function getDependencies()
    {
        return [
        ];
    }

    public function getAliases()
    {
        return [
        ];
    }
 
 
 public function apply()
 {
    $this->moduleDataSetup->getConnection()->startSetup();

        $categorySetup = $this->categorySetupFactory->create(
            ['setup' => $this->moduleDataSetup]
        );

        $attributeSet = $this->attributeSetFactory->create();

        $entityTypeId = $categorySetup->getEntityTypeId(
            \Magento\Catalog\Model\Product::ENTITY
        );
        
        $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);
        
        $data = [
            'attribute_set_name' => 'Wine_Attribute_Set',
            'entity_type_id' => $entityTypeId,
            'sort_order' => 50,
        ];
        
        $attributeSet->setData($data);
        $attributeSet->validate();
        $attributeSet->save();
        $attributeSet->initFromSkeleton($attributeSetId);
        $attributeSet->save();

        $this->moduleDataSetup->getConnection()->endSetup();

 }
}