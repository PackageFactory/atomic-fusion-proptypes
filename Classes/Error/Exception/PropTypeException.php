<?php
namespace PackageFactory\AtomicFusion\PropTypes\Error\Exception;

use Neos\Fusion\Exception as FusionException;
use Neos\Error\Messages\Result;
use Throwable;

class PropTypeException extends FusionException
{
    /**
     * @var Result $result
     */
    protected $result;

    /**
     * @param Result $result
     */
    public function setResult(Result $result): void
    {
        $this->result = $result;
    }

    /**
     * @return Result
     */
    public function getResult(): Result
    {
        return $this->result;
    }


}
