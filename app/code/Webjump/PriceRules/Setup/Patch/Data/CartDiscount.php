<?php

namespace Webjump\PriceRules\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\SalesRule\Model\RuleFactory;
use Magento\Framework\App\State;

class CartDiscount implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;
    private RuleFactory $ruleFactory;
    private State $state;

    CONST cartRuleTitleBR = "Regra 5 itens ou mais";
    CONST cartRuleDescBR = "Compre 5 itens ou mais e receba 10% de desconto no valor do carrinho!";
    CONST cartDiscount = "10.000";

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        RuleFactory $ruleFactory,
        State $state
        )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->ruleFactory = $ruleFactory;
        $this->state = $state;
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

    public function apply() {
        $this->moduleDataSetup->getConnection()->startSetup();
        
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_FRONTEND);


        $this->moduleDataSetup->getConnection()->endSetup();
    }
}