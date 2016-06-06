<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since 6/4/16
 */

namespace Src\V2\Email;

use Src\BaseResponse;
use Src\Response;

class SendResponse extends BaseResponse implements Response
{
    public function getTransactionId()
    {
        return 'test';
    }
}