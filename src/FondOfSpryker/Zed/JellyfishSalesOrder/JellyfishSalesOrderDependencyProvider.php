<?php

namespace FondOfSpryker\Zed\JellyfishSalesOrder;

use FondOfSpryker\Zed\Jellyfish\Dependency\Service\JellyfishToUtilEncodingServiceBridge;
use FondOfSpryker\Zed\JellyfishSalesOrder\Dependency\Service\JellyfishSalesOrderToUtilEncodingServiceBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class JellyfishSalesOrderDependencyProvider extends AbstractBundleDependencyProvider
{
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';
    public const PLUGINS_JELLYFISH_ORDER_EXPANDER_POST_MAP = 'PLUGINS_JELLYFISH_ORDER_EXPANDER_POST_MAP';
    public const PLUGINS_JELLYFISH_ORDER_ITEM_EXPANDER_POST_MAP = 'PLUGINS_JELLYFISH_ORDER_ITEM_EXPANDER_POST_MAP';
    public const PLUGINS_JELLYFISH_ORDER_ADDRESS_EXPANDER_POST_MAP = 'PLUGINS_JELLYFISH_ORDER_ADDRESS_EXPANDER_POST_MAP';


    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->addUtilEncodingService($container);
        $container = $this->addJellyfishOrderExpanderPostMapPlugins($container);
        $container = $this->addJellyfishOrderItemExpanderPostMapPlugins($container);
        $container = $this->addJellyfishOrderAddressExpanderPostMapPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilEncodingService(Container $container): Container
    {
        $container[static::SERVICE_UTIL_ENCODING] = function (Container $container) {
            return new JellyfishSalesOrderToUtilEncodingServiceBridge(
                $container->getLocator()->utilEncoding()->service()
            );
        };

        return $container;
    }
    
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addJellyfishOrderExpanderPostMapPlugins(Container $container): Container
    {
        $container[static::PLUGINS_JELLYFISH_ORDER_EXPANDER_POST_MAP] = function (Container $container) {
            return $this->getJellyfishOrderExpanderPostMapPlugins();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addJellyfishOrderItemExpanderPostMapPlugins(Container $container): Container
    {
        $container[static::PLUGINS_JELLYFISH_ORDER_ITEM_EXPANDER_POST_MAP] = function (Container $container) {
            return $this->getJellyfishOrderItemExpanderPostMapPlugins();
        };

        return $container;
    }

    protected function addJellyfishOrderAddressExpanderPostMapPlugins(Container $container): Container
    {
        $container[static::PLUGINS_JELLYFISH_ORDER_ADDRESS_EXPANDER_POST_MAP] = function (Container $container) {
            return $this->getJellyfishOrderAddressExpanderPostMapPlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishSalesOrderExtension\Dependency\Plugin\JellyfishOrderItemExpanderPostMapPluginInterface[]
     */
    protected function getJellyfishOrderItemExpanderPostMapPlugins(): array
    {
        return [];
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishSalesOrderExtension\Dependency\Plugin\JellyfishOrderExpanderPostMapPluginInterface[]
     */
    protected function getJellyfishOrderExpanderPostMapPlugins(): array
    {
        return [];
    }

    /**
     * @return \FondOfSpryker\Zed\JellyfishExtension\Dependency\Plugin\JellyfishOrderAddressExpanderPostMapPluginInterface[]
     */
    protected function getJellyfishOrderAddressExpanderPostMapPlugins(): array
    {
        return [];
    }

}
