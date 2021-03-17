<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_TimeSlotDelivery
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\TimeSlotDelivery\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('webkul_timeslotdelivery_timeslots'))
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Entity ID'
                )
                ->addColumn(
                    'delivery_day',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    ['nullable' => true, 'default' => null],
                    'Order Delivery Day'
                )
                ->addColumn(
                    'start_time',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    ['nullable' => true, 'default' => null],
                    'Order Delivery Start Time'
                )
                ->addColumn(
                    'end_time',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    ['nullable' => true, 'default' => null],
                    'Order Delivery End Time'
                )
                ->addColumn(
                    'order_count',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                    'Order Count'
                )
                ->addColumn(
                    'status',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                    'Slot Status'
                )
                ->setComment('Delivery Time Slots');
        $installer->getConnection()->createTable($table);

         $table = $installer->getConnection()
            ->newTable($installer->getTable('webkul_timeslotdelivery_order'))
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Entity ID'
                )
                ->addColumn(
                    'slot_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                    'Slot ID'
                )
                ->addColumn(
                    'order_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                    'Order ID'
                )
                ->addColumn(
                    'selected_date',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    [],
                    'Selected Slot Date'
                )
                ->setComment('Order Time Slot');
        $installer->getConnection()->createTable($table);

        $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'order_delivery_date',
            [
                'type' => 'text',
                'nullable' => false,
                'comment' => 'Delivery Date',
            ]
        );
        $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'order_delivery_time',
            [
                'type' => 'text',
                'nullable' => false,
                'comment' => 'Delivery Time',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'order_delivery_date',
            [
                'type' => 'text',
                'nullable' => false,
                'comment' => 'Delivery Date',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'order_delivery_time',
            [
                'type' => 'text',
                'nullable' => false,
                'comment' => 'Delivery Time',
            ]
        );

        $setup->endSetup();
    }
}
