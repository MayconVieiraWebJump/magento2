<?php

namespace Webjump\LanguageAndCurrency\Setup\Patch\Data;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Sales\Model\Order\StatusFactory;


class OrderStatus implements DataPatchInterface
{
    private $moduleDataSetup;
    private $writer;
    private $storeManager;
    private $statusFactory;

    public function __construct(

        ModuleDataSetupInterface $moduleDataSetup,
        WriterInterface $writer,
        StoreManagerInterface $storeManager,
        StatusFactory $statusFactory
    )

    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->writer = $writer;
        $this->storeManager = $storeManager;
        $this->statusFactory = $statusFactory;
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

    
    private function getStoreLabels(): array
  {
    return [
       'msvEN' => $this->getStatusCodeEN(),
       'msvBR' => $this->getStatusCodeBR(),
       'wsvEN' => $this->getStatusCodeEN(),
       'wsvBR' => $this->getStatusCodeBR()
    ];
  }

  private function getStatusCodeBR(): array
    {
        return [
            'Processando',
            'Suspeita de fraude',
            'Pagamento pendente',
            'Análise de Pagamento',
            'Pendente',
            'Em espera',
            'Aberto',
            'Completo',
            'Fechado',
            'Cancelado',
            'PayPal Cancelado',
            'PayPal Pendente',
            'PayPal Revertido',
            'Entregue ao cliente'
        ];
    } 
    
    private function getStatusCodeEN(): array
    {
        return [
            'Processing',
            'Suspected Fraud',
            'Pending Payment',
            'Payment Review',
            'Pending',
            'On Hold',
            'Open',
            'Complete',
            'Closed',
            'Canceled',
            'PayPal Canceled Reversal',
            'Pending PayPal',
            'PayPal Reversed',
            'Customer Delivered'
        ];
    }
  
  private function getStatusCode(): array
    {
        return [
            'processing',
            'fraud',
            'pending_payment',
            'payment_review',
            'pending',
            'holded',
            'STATE_OPEN',
            'complete',
            'closed',
            'canceled',
            'paypay_canceled_reversal',
            'pending_paypal',
            'paypal_reversed',
            'customer_delivered'
        ];
    }
    
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        foreach ($this->getStatusCode() as $statusCode){
        $code = $statusCode;
        $status = $this->statusFactory->create()->load($code);
        if(!$status->getStatus()) {
        // lançar exceção
        }
        $status->setData('store_labels', $this->getStoreLabels());
        $status->save();
    }


        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
  