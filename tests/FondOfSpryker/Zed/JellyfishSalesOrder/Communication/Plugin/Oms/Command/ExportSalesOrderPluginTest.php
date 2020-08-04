<?php

namespace FondOfSpryker\Zed\JellyfishSalesOrder\Communication\Plugin;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\JellyfishSalesOrderFacadeInterface;
use FondOfSpryker\Zed\JellyfishSalesOrder\Communication\Plugin\Oms\Command\ExportSalesOrderPlugin;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;

class ExportSalesOrderPluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\JellyfishSalesOrder\Communication\Plugin\ExportSalesOrderPlugin
     */
    protected $exportSalesOrderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\JellyfishSalesOrder\Business\JellyfishSalesOrderFacadeInterface
     */
    protected $jellyfishSalesOrderFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Sales\Persistence\SpySalesOrder
     */
    protected $spySalesOrderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject
     */
    protected $readOnlyArrayObjectMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->jellyfishSalesOrderFacadeMock = $this->getMockBuilder(JellyfishSalesOrderFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spySalesOrderMock = $this->getMockBuilder(SpySalesOrder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->readOnlyArrayObjectMock = $this->getMockBuilder(ReadOnlyArrayObject::class)
            ->disableOriginalConstructor()
            ->getMock();


        $this->exportSalesOrderPlugin = new class (
            $this->jellyfishSalesOrderFacadeMock
        ) extends ExportSalesOrderPlugin {
            /**
             * @var \FondOfSpryker\Zed\JellyfishSalesOrder\Business\JellyfishSalesOrderFacadeInterface
             */
            protected $jellyfishSalesOrderFacade;

            /**
             *  constructor.
             * @param \FondOfSpryker\Zed\JellyfishSalesOrder\Business\JellyfishSalesOrderFacadeInterface $jellyfishSalesOrderFacade
             */
            public function __construct(JellyfishSalesOrderFacadeInterface $jellyfishSalesOrderFacade)
            {
                $this->jellyfishSalesOrderFacade = $jellyfishSalesOrderFacade;
            }

            /**
             * @return \FondOfSpryker\Zed\JellyfishSalesOrder\Business\JellyfishSalesOrderFacadeInterface
             */
            public function getFacade(): JellyfishSalesOrderFacadeInterface
            {
                return $this->jellyfishSalesOrderFacade;
            }
        };

    }

    /**
     * @return void
     */
    public function testRun(): void
    {
        $this->assertIsArray(
            $this->exportSalesOrderPlugin->run(
                [],
                $this->spySalesOrderMock,
                $this->readOnlyArrayObjectMock
            )
        );
    }
}
