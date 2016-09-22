<?php

namespace PayumTW\Esunbank\Action\Api;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Reply\HttpPostRedirect;
use PayumTW\Esunbank\Request\Api\CreateTransaction;

class CreateTransactionAction extends BaseApiAwareAction
{
    /**
     * {@inheritdoc}
     *
     * @param $request CreateTransaction
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $details = ArrayObject::ensureArrayObject($request->getModel());

        throw new HttpPostRedirect(
            $this->api->getApiEndpoint(),
            $this->api->createTransaction((array) $details)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request)
    {
        return
            $request instanceof CreateTransaction &&
            $request->getModel() instanceof \ArrayAccess;
    }
}
