<?php

namespace Webjump\PriceRules;

use Magento\Framework\App\State;
use Magento\SalesRule\Model\RuleFactory;
use Magento\Store\Model\StoreManagerInterface;

class NewPriceRule
{
    private StoreManagerInterface $storeManager;

    public function __construct(
        RuleFactory $ruleFactory,
        State $state,
        StoreManagerInterface $storeManager
    ) {
        $this->ruleFactory = $ruleFactory;
        $this->state = $state;
        $this->storeManager = $storeManager;
    }

    public function createRuleCustomerGroup(string $name, string $description, string $discount, int $customerGroupId, string $websiteCode)
    {
        $websiteGetId = $this->storeManager
        ->getWebsite($websiteCode)
        ->getId();

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
            "sort_order" => "2",
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
            "website_ids" => [$websiteGetId],
            "coupon_code" => null,
            "store_labels" => [],
            "conditions_serialized" => '',
            "actions_serialized" => ''
        ];

        $ruleModel = $this->ruleFactory->create();
        $ruleModel->setData($ruleData);
        $ruleModel->save();
    }

    public function createRuleCart(string $name, string $description, string $discount)
    {
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
            "sort_order" => "1",
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
            "website_ids" => [0, 1, 2, 3, 4, 5],
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

    public function createCouponRule(){
        
        $ruleData = [
            "name" => "Cupom 50% de desconto - EFETIVAESTAGIARIO",
            "description" => null,
            "from_date" => null,
            "to_date" => null,
            "uses_per_customer" => "0",
            "is_active" => "1",
            "stop_rules_processing" => "1",
            "is_advanced" => "1",
            "product_ids" => null,
            "sort_order" => "0",
            "simple_action" => "by_percent",
            "discount_amount" => "50",
            "discount_qty" => null,
            "discount_step" => "0",
            "apply_to_shipping" => "0",
            "times_used" => "0",
            "is_rss" => "1",
            "coupon_type" => "2",
            "use_auto_generation" => "0",
            "uses_per_coupon" => "0",
            "simple_free_shipping" => "0",
            "customer_group_ids" => [0, 1, 2, 3], // 0 = Not Logged, 1 = General, 2 = Wholesale, 3 = Retailer
            "website_ids" => [0, 1, 2, 3, 4, 5],
            "coupon_code" => 'EFETIVAESTAGIARIO',
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
                        'type' => \Magento\SalesRule\Model\Rule\Condition\Combine\Address::class,
                        'attribute' => null,
                        'operator' => null,
                        'value' => '1',
                        'is_value_processed' => null,
                        'aggregator' => 'all'
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
