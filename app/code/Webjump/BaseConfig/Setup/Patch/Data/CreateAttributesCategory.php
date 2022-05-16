<?php

declare(strict_types = 1);
namespace Webjump\BaseConfig\Setup\Patch\Data;

use Magento\Catalog\Model\Category;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateAttributesCategory implements DataPatchInterface
{
    const ATTRIBUTE_WINE = 'Wine';
    const ATTRIBUTE_MODA = 'Moda';

    private ModuleDataSetupInterface $moduleDataSetup;
    private EavSetupFactory $eavSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
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

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(Category::ENTITY, self::ATTRIBUTE_WINE, [
            'type' => 'text',
            'label' => 'Wine',
            'input' => 'boolean',
            'source' => '',
            'user_defined' => true,
            'visible' => true,
            'default' => '',
            'required' => false,
            'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
            'group' => 'General',
            'visible_on_front' => true
        ]);

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(Category::ENTITY, self::ATTRIBUTE_MODA, [
            'type' => 'text',
            'label' => 'Moda',
            'input' => 'boolean',
            'source' => '',
            'user_defined' => true,
            'visible' => true,
            'default' => '',
            'required' => false,
            'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
            'group' => 'General',
            'visible_on_front' => true
        ]);

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
