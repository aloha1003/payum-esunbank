<?php

namespace PayumTW\Esunbank;

use Payum\Core\GatewayFactory;
use Payum\Core\Bridge\Spl\ArrayObject;
use PayumTW\Esunbank\Action\SyncAction;
use PayumTW\Esunbank\Action\CancelAction;
use PayumTW\Esunbank\Action\RefundAction;
use PayumTW\Esunbank\Action\StatusAction;
use PayumTW\Esunbank\Action\CaptureAction;
use PayumTW\Esunbank\Action\ConvertPaymentAction;
use PayumTW\Esunbank\Action\Api\CancelTransactionAction;
use PayumTW\Esunbank\Action\Api\CreateTransactionAction;
use PayumTW\Esunbank\Action\Api\RefundTransactionAction;
use PayumTW\Esunbank\Action\Api\GetTransactionDataAction;

class EsunbankGatewayFactory extends GatewayFactory
{
    /**
     * {@inheritdoc}
     */
    protected function populateConfig(ArrayObject $config)
    {
        $config->defaults([
            'payum.factory_name' => 'esunbank',
            'payum.factory_title' => 'Esunbank',
            'payum.action.capture' => new CaptureAction(),
            'payum.action.refund' => new RefundAction(),
            'payum.action.cancel' => new CancelAction(),
            'payum.action.sync' => new SyncAction(),
            'payum.action.status' => new StatusAction(),
            'payum.action.convert_payment' => new ConvertPaymentAction(),

            'payum.action.api.create_transaction' => new CreateTransactionAction(),
            'payum.action.api.refund_transaction' => new RefundTransactionAction(),
            'payum.action.api.cancel_transaction' => new CancelTransactionAction(),
            'payum.action.api.get_transaction_data' => new GetTransactionDataAction(),
        ]);

        if (false == $config['payum.api']) {
            $config['payum.default_options'] = [
                'MID' => '8089000016',
                'M' => 'WEGSC0Q7BAJGTQYL8BV8KRQRZXH6VK0B',
                'mobile' => null,
                'sandbox' => true,
            ];

            $config->defaults($config['payum.default_options']);
            $config['payum.required_options'] = ['MID', 'M'];

            $config['payum.api'] = function (ArrayObject $config) {
                $config->validateNotEmpty($config['payum.required_options']);

                return new Api((array) $config, $config['payum.http_client'], $config['httplug.message_factory']);
            };
        }
    }
}
