<?php
namespace StripeIntegration\Payments\Setup\Jobs\WebhookPingCleanupCommand;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Setup\Jobs\WebhookPingCleanupCommand
 */
class Interceptor extends \StripeIntegration\Payments\Setup\Jobs\WebhookPingCleanupCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(?string $name = null)
    {
        $this->___init();
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    public function run(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'run');
        if (!$pluginInfo) {
            return parent::run($input, $output);
        } else {
            return $this->___callPlugins('run', func_get_args(), $pluginInfo);
        }
    }
}
