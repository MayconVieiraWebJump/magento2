<?php

namespace Webjump\PriceRules\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\SalesRule\Model\RuleFactory;
use Magento\Framework\App\State;
use Webjump\PriceRules\NewPriceRule;

class CartDiscount implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;
    private RuleFactory $ruleFactory;
    private State $state;
    private NewPriceRule $priceRuleVar;


    CONST cartRuleTitleBR = "Regra 5 itens ou mais";
    CONST cartRuleDescBR = "Compre 5 itens ou mais e receba 10% de desconto no valor do carrinho!";
    CONST cartRuleTitleEN = "Five items or more rule";
    CONST cartRuleDescEN = "Buy 5 items or more and receive 10% off in cart!";
    CONST cartDiscount = "10.000";

    CONST customerNameModaBR = "Usuarios não logados no site Moda";
    CONST customerDescModaBR = "Usuários não logados recebem 5% de desconto em suas compras";
    CONST customerDiscountModaBR = "5.000";
    CONST groupIdModa = "0";
    CONST websiteIdModa = "moda_br";

    CONST customerNameWineBR = "Usuarios não logados no site Wine";
    CONST customerDescWineBR = "Usuários não logados recebem 10% de desconto em suas compras";
    CONST customerDiscountWineBR = "10.000";
    CONST groupIdWine = "0";
    CONST websiteIdWine = "wine_br";


    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        RuleFactory $ruleFactory,
        NewPriceRule $priceRuleVar,
        State $state
        )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->ruleFactory = $ruleFactory;
        $this->state = $state;
        $this->priceRuleVar = $priceRuleVar;
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

        $this->priceRuleVar->createRuleCart(
            self::cartRuleTitleBR,
            self::cartRuleDescBR,
            self::cartDiscount
        );
        
        $this->priceRuleVar->createRuleCustomerGroup(
            self::customerNameModaBR,
            self::customerDescModaBR,
            self::customerDiscountModaBR,
            self::groupIdModa, 
            self::websiteIdModa
        );

        $this->priceRuleVar->createRuleCustomerGroup(
            self::customerNameWineBR,
            self::customerDescWineBR,
            self::customerDiscountWineBR,
            self::groupIdWine,
            self::websiteIdWine
        );
        
        $this->moduleDataSetup->getConnection()->endSetup();
    }
}