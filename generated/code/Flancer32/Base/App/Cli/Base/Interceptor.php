<?php
namespace Flancer32\Base\App\Cli\Base;

/**
 * Interceptor class for @see \Flancer32\Base\App\Cli\Base
 */
class Interceptor extends \Flancer32\Base\App\Cli\Base implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct($name, $desc)
    {
        $this->___init();
        parent::__construct($name, $desc);
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
