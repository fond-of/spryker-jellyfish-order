<?php

namespace FondOfSpryker\Zed\JellyfishSalesOrder\Communication\Plugin;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Exporter\SalesOrderExporter;

class SalesOrderExporterTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Exporter\SalesOrderExporterInterface
     */
    protected $salesOrderExporter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->salesOrderExporter = new SalesOrderExporter();

    }
}
