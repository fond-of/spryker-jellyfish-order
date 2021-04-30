<?php

namespace FondOfSpryker\Zed\JellyfishSalesOrder\Business\Api\Adapter;

use Exception;
use FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AbstractAdapter as FondOfSprykerJellyfishAbstractAdapter;
use Psr\Http\Message\ResponseInterface;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Symfony\Component\HttpFoundation\Response;

class SalesOrderAdapter extends FondOfSprykerJellyfishAbstractAdapter implements SalesOrderAdapterInterface
{
    protected const ORDERS_URI = 'standard/orders';

    protected const VALID_CODES = [
        Response::HTTP_OK,
        Response::HTTP_CREATED,
        Response::HTTP_ACCEPTED
    ];

    /**
     * @return string
     */
    protected function getUri(): string
    {
        return sprintf('%s/%s', rtrim($this->config->getBaseUri(), '/'), static::ORDERS_URI);
    }

    /**
     * @param  \Psr\Http\Message\ResponseInterface  $response
     * @param  \Spryker\Shared\Kernel\Transfer\AbstractTransfer|\Generated\Shared\Transfer\JellyfishOrderTransfer  $transfer
     *
     * @return void
     */
    protected function handleResponse(ResponseInterface $response, AbstractTransfer $transfer): void
    {
        if (in_array($response->getStatusCode(), self::VALID_CODES, true) === false) {
            throw new Exception(sprintf('Order export in store %s for order with id %s and reference %s failed!',
                $transfer->getStore(), $transfer->getId(), $transfer->getReference()));
        }
    }
}
