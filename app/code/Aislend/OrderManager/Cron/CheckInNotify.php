<?php

namespace Aislend\OrderManager\Cron;
use \Mofluid\Mofluidapi2\Helper\Data;

class CheckInNotify
{
    protected $helper;

    public function __construct(Data $helper)
    {
        $this->helper=$helper;
    }


    public function execute()
    {

        // $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/cron.log');
        // $logger = new \Zend\Log\Logger();
        // $logger->addWriter($writer);

        $notify_pickers=$this->helper->getFirstSlotOfPickers();
        // $logger->info("CRON Notifiy before");
        // $logger->info("TOTAL   COUNT =>".count($notify_pickers));       

        return true;

    }
}

