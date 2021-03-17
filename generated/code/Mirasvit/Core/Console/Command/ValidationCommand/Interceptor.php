<?php
namespace Mirasvit\Core\Console\Command\ValidationCommand;

/**
 * Interceptor class for @see \Mirasvit\Core\Console\Command\ValidationCommand
 */
class Interceptor extends \Mirasvit\Core\Console\Command\ValidationCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\State $appState, \Mirasvit\Core\Service\ValidationService $validationService)
    {
        $this->___init();
        parent::__construct($appState, $validationService);
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
