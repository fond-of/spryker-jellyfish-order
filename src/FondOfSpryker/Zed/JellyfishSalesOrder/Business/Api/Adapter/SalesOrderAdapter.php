<?php

namespace FondOfSpryker\Zed\JellyfishSalesOrder\Business\Api\Adapter;

use FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AbstractAdapter as FondOfSprykerJellyfishAbstractAdapter;
use Psr\Http\Message\ResponseInterface;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class SalesOrderAdapter extends FondOfSprykerJellyfishAbstractAdapter implements SalesOrderAdapterInterface
{
    protected const ORDERS_URI = 'standard/orders';

    /**
     * @return string
     */
    protected function getUri(): string
    {
        return sprintf('%s/%s', rtrim($this->config->getBaseUri(), '/'), static::ORDERS_URI);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $transfer
     *
     * @return void
     */
    protected function handleResponse(ResponseInterface $response, AbstractTransfer $transfer): void
    {
    }
}
