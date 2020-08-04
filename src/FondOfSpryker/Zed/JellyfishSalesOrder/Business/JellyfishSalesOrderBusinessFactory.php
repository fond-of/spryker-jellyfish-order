<?php

namespace FondOfSpryker\Zed\JellyfishSalesOrder\Business;

use FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AdapterInterface;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Api\Adapter\SalesOrderAdapter;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Api\Adapter\SalesOrderAdapterInterface;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Exporter\OrderExporterInterface;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishAddressMapper;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishAddressMapperInterface;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderAddressMapper;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderAddressMapperInterface;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderDiscountMapper;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderDiscountMapperInterface;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderExpenseMapper;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderExpenseMapperInterface;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderItemMapper;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderItemMapperInterface;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderMapper;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderMapperInterface;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderPaymentMapper;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderPaymentMapperInterface;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderTotalsMapper;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderTotalsMapperInterface;
use FondOfSpryker\Zed\JellyfishSalesOrder\Dependency\Service\JellyfishSalesOrderToUtilEncodingServiceInterface;
use FondOfSpryker\Zed\JellyfishSalesOrder\Dependency\Service\JellyfishToUtilEncodingServiceInterface;
use FondOfSpryker\Zed\JellyfishSalesOrder\JellyfishDependencyProvider;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Exporter\SalesOrderExporter;
use FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Exporter\SalesOrderExporterInterface;
use FondOfSpryker\Zed\JellyfishSalesOrder\JellyfishSalesOrderDependencyProvider;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface as HttpClientInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\JellyfishSalesOrder\JellyfishSalesOrderConfig getConfig()
 */
class JellyfishSalesOrderBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Exporter\SalesOrderExporterInterface
     */
    public function createSalesOrderExporter(): SalesOrderExporterInterface
    {
        return new SalesOrderExporter(
            $this->createJellyfishOrderMapper(),
            $this->createJellyfishOrderItemMapper(),
            $this->createSalesOrderAdapter()
        );
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    protected function createHttpClient(): HttpClientInterface
    {
        return new HttpClient([
            'base_uri' => $this->getConfig()->getBaseUri(),
            'timeout' => $this->getConfig()->getTimeout(),
        ]);
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderMapperInterface
     */
    protected function createJellyfishOrderMapper(): JellyfishOrderMapperInterface
    {
        return new JellyfishOrderMapper(
            $this->createJellyfishOrderAddressMapper(),
            $this->createJellyfishOrderExpenseMapper(),
            $this->createJellyfishOrderDiscountMapper(),
            $this->createJellyfishOrderPaymentMapper(),
            $this->createJellyfishOrderTotalsMapper(),
            $this->getOrderExpanderPostMapPlugins(),
            $this->getConfig()->getSystemCode()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderAddressMapperInterface
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    protected function createJellyfishOrderAddressMapper(): JellyfishOrderAddressMapperInterface
    {
        return new JellyfishOrderAddressMapper(
            $this->getOrderAddressExpanderPostMapPlugins()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderExpenseMapperInterface
     */
    protected function createJellyfishOrderExpenseMapper(): JellyfishOrderExpenseMapperInterface
    {
        return new JellyfishOrderExpenseMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderDiscountMapperInterface
     */
    protected function createJellyfishOrderDiscountMapper(): JellyfishOrderDiscountMapperInterface
    {
        return new JellyfishOrderDiscountMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderPaymentMapperInterface
     */
    protected function createJellyfishOrderPaymentMapper(): JellyfishOrderPaymentMapperInterface
    {
        return new JellyfishOrderPaymentMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderTotalsMapperInterface
     */
    protected function createJellyfishOrderTotalsMapper(): JellyfishOrderTotalsMapperInterface
    {
        return new JellyfishOrderTotalsMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishSalesOrder\Business\Model\Mapper\JellyfishOrderItemMapperInterface
     */
    protected function createJellyfishOrderItemMapper(): JellyfishOrderItemMapperInterface
    {
        return new JellyfishOrderItemMapper(
            $this->getOrderItemExpanderPostMapPlugins()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishSalesOrder\Business\Api\Adapter\SalesOrderAdapterInterface
     * 
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    protected function createSalesOrderAdapter(): SalesOrderAdapterInterface
    {
        return new SalesOrderAdapter(
            $this->getUtilEncodingService(),
            $this->createHttpClient(),
            $this->getConfig()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishSalesOrder\Dependency\Service\JellyfishSalesOrderToUtilEncodingServiceInterface
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    protected function getUtilEncodingService(): JellyfishSalesOrderToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(JellyfishSalesOrderDependencyProvider::SERVICE_UTIL_ENCODING);
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishSalesOrderExtension\Dependency\Plugin\JellyfishOrderAddressExpanderPostMapPluginInterface[]
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    protected function getOrderExpanderPostMapPlugins(): array
    {
        return $this->getProvidedDependency(JellyfishSalesOrderDependencyProvider::PLUGINS_JELLYFISH_ORDER_EXPANDER_POST_MAP);
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishSalesOrderExtension\Dependency\Plugin\JellyfishOrderAddressExpanderPostMapPluginInterface[]
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    protected function getOrderItemExpanderPostMapPlugins(): array
    {
        return $this->getProvidedDependency(JellyfishSalesOrderDependencyProvider::PLUGINS_JELLYFISH_ORDER_ITEM_EXPANDER_POST_MAP);
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishSalesOrderExtension\Dependency\Plugin\JellyfishOrderAddressExpanderPostMapPluginInterface[]
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    protected function getOrderAddressExpanderPostMapPlugins(): array
    {
        return $this->getProvidedDependency(JellyfishSalesOrderDependencyProvider::PLUGINS_JELLYFISH_ORDER_ADDRESS_EXPANDER_POST_MAP);
    }
}
