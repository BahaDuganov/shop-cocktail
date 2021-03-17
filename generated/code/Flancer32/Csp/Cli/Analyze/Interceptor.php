<?php
namespace Flancer32\Csp\Cli\Analyze;

/**
 * Interceptor class for @see \Flancer32\Csp\Cli\Analyze
 */
class Interceptor extends \Flancer32\Csp\Cli\Analyze implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\ResourceConnection $resource, \Flancer32\Csp\Helper\Config $hlpCfg, \Flancer32\Csp\Service\Report\Analyze $srvAnalyze)
    {
        $this->___init();
        parent::__construct($resource, $hlpCfg, $srvAnalyze);
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
