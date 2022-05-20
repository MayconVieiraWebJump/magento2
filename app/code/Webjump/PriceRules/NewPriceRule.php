<?php

namespace Webjump\PriceRules;

use Magento\SalesRule\Model\RuleFactory;
use Magento\Framework\App\State;


Class NewPriceRule {

    public function __construct(
        RuleFactory $ruleFactory,
        State $state
    )
    {
        $this->ruleFactory = $ruleFactory;
        $this->state = $state;
    }
    
    public function createRuleCustomerGroup(string $name, string $description, string $discount, int $customerGroupId, int $websiteId){
        
        $ruleData = [
            "name" => $name,
            "description" => $description,
            "from_date" => null,
            "to_date" => null,
            "uses_per_customer" => "0",
            "is_active" => "1",
            "stop_rules_processing" => "1",
            "is_advanced" => "1",
            "product_ids" => null,
            "sort_order" => "0",
            "simple_action" => "by_percent",
            "discount_amount" => $discount,
            "discount_qty" => null,
            "discount_step" => "0",
            "apply_to_shipping" => "0",
            "times_used" => "0",
            "is_rss" => "1",
            "coupon_type" => "1",
            "use_auto_generation" => "0",
            "uses_per_coupon" => "0",
            "simple_free_shipping" => "0",
            "customer_group_ids" => [$customerGroupId], // 0 = Not Logged, 1 = General, 2 = Wholesale, 3 = Retailer
            "website_ids" => [$websiteId],
            "coupon_code" => null,
            "store_labels" => [],
            "conditions_serialized" => '',
            "actions_serialized" => ''
        ];

         $ruleModel = $this->ruleFactory->create();
         $ruleModel->setData($ruleData);
         $ruleModel->save();
    }

    public function createRuleCart(string $name, string $description, string $discount){
        
        $ruleData = [
            "name" => $name,
            "description" => $description,
            "from_date" => null,
            "to_date" => null,
            "uses_per_customer" => "0",
            "is_active" => "1",
            "stop_rules_processing" => "1",
            "is_advanced" => "1",
            "product_ids" => null,
            "sort_order" => "0",
            "simple_action" => "by_percent",
            "discount_amount" => $discount,
            "discount_qty" => null,
            "discount_step" => "0",
            "apply_to_shipping" => "0",
            "times_used" => "0",
            "is_rss" => "1",
            "coupon_type" => "1",
            "use_auto_generation" => "0",
            "uses_per_coupon" => "0",
            "simple_free_shipping" => "0",
            "customer_group_ids" => [0, 1, 2, 3], // 0 = Not Logged, 1 = General, 2 = Wholesale, 3 = Retailer
            "website_ids" => [1, 2, 3],
            "coupon_code" => null,
            "store_labels" => [],
            'conditions_serialized' => json_encode([
                'type' => \Magento\SalesRule\Model\Rule\Condition\Combine::class,
                'attribute' => null,
                'operator' => null,
                'value' => '1',
                'is_value_processed' => null,
                'aggregator' => 'all',
                'conditions' => [
                    [
                        'type' => \Magento\SalesRule\Model\Rule\Condition\Address::class,
                        'attribute' => 'total_qty',
                        'operator' => '>=',
                        'value' => '5',
                        'is_value_processed' => false,
                    ],
                ],
            ]),
            "actions_serialized" => ''
        ];

         $ruleModel = $this->ruleFactory->create();
         $ruleModel->setData($ruleData);
         $ruleModel->save();
    }

    
    
    

    


}