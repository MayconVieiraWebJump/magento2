<?php

declare(strict_types=1);

namespace Webjump\LanguageAndCurrency\Test\Unit;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;
use PHPUnit\Framework\TestCase;
use Webjump\LanguageAndCurrency\Setup\Patch\Data\ModaStoreBRConfig;

class ModaStoreBRConfigTest extends TestCase
{
    public function setUp(): void
    {
        $this->writerInterfaceMock = $this
            ->createMock(WriterInterface::class);

        $this->moduleDataSetupMock = $this
            ->createMock(ModuleDataSetupInterface::class);

        $this->adapterInterfaceMock = $this
            ->createMock(AdapterInterface::class);

        $this->storeManagerMock = $this
            ->createMock(StoreManagerInterface::class);

        $this->storeInterfaceMock = $this
            ->createMock(StoreInterface::class);

        $this->localeWriter = new ModaStoreBRConfig(
            $this->moduleDataSetupMock,
            $this->writerInterfaceMock,
            $this->storeManagerMock
        );
    }

    public function testApply()
    {
        $storeId = 1;

        $this->moduleDataSetupMock
            ->expects($this->exactly(2))
            ->method("getConnection")
            ->willReturn($this->adapterInterfaceMock);

        $this->adapterInterfaceMock->expects($this->once())
            ->method("startSetup")
            ->willReturnSelf();

        $this->storeManagerMock->expects($this->once())
            ->method('getStore')
            ->willReturn($this->storeInterfaceMock);

        $this->storeInterfaceMock->expects($this->once())
            ->method('getId')
            ->willReturn($storeId);

        $this->writerInterfaceMock
            ->expects($this->exactly(5))
            ->method("save")
            ->withConsecutive(
                [
                    'general/locale/code',
                    'pt_BR',
                    'stores',
                    $storeId
                ],
                [
                    'general/locale/weight_unit',
                    'kgs',
                    'stores',
                    $storeId
                ],
                [
                    'general/locale/timezone',
                    'America/Sao_Paulo',
                    'stores',
                    $storeId
                ],
                [
                    'currency/options/allow',
                    'BRL',
                    'stores',
                    $storeId
                ],
                [
                    'currency/options/default',
                    'BRL',
                    'stores',
                    $storeId
                ],
            );

        $this->adapterInterfaceMock->expects($this->once())
            ->method("endSetup")
            ->willReturnSelf();

        $this->localeWriter->apply($storeId);
    }
}
