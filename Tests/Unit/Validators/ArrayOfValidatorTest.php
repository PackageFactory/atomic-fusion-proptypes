<?php
namespace PackageFactory\AtomicFusion\PropTypes\Tests\Unit\Validators;

use Neos\Flow\Tests\Unit\Validation\Validator\AbstractValidatorTestcase;
use PackageFactory\AtomicFusion\PropTypes\Validators\ArrayOfValidator;
use Neos\Flow\Validation\Validator\ValidatorInterface;
use Neos\Error\Messages\Result;
use Neos\Error\Messages\Error;

/**
 * Testcase for the boolean validator
 *
 */
class ArrayOfValidatorTest extends AbstractValidatorTestcase
{

    /**
     * @var ValidatorInterface
     */
    protected $mockItemValidator;

    public function setUp()
    {
        $mockSuccessResult = $this->createMock(Result::class);
        $mockSuccessResult->expects($this->any())->method('hasErrors')->will($this->returnValue(false));

        $this->mockItemValidator = $this->createMock(ValidatorInterface::class);
        $this->mockItemValidator
            ->expects($this->any())
            ->method('validate')
            ->will($this->returnValue($mockSuccessResult));
    }

    /**
     * @test
     */
    public function validatorAcceptsNull()
    {
        $validator = new ArrayOfValidator(['itemValidator' => $this->mockItemValidator]);
        $this->assertFalse($validator->validate(null)->hasErrors());
    }

    /**
     * @test
     */
    public function validatorAcceptsEmptyArray()
    {
        $validator = new ArrayOfValidator(['itemValidator' => $this->mockItemValidator]);
        $this->assertFalse($validator->validate([])->hasErrors());
    }

    /**
     * @test
     */
    public function validatorAcceptsEmptyArrayObject()
    {
        $arrayObject = new \ArrayObject();
        $validator = new ArrayOfValidator(['itemValidator' => $this->mockItemValidator]);
        $this->assertFalse($validator->validate($arrayObject)->hasErrors());
    }

    /**
     * @test
     */
    public function validatorCallsItemValidatorForeEachItemInArray()
    {
        $items = [1,2,3,'foo','bar'];
        $this->mockItemValidator->expects($this->exactly(count($items)))->method('validate');
        foreach ($items as $index => $value) {
            $this->mockItemValidator->expects($this->at($index))->method('validate')->with($this->equalTo($value));
        }

        $validator = new ArrayOfValidator(['itemValidator' => $this->mockItemValidator]);
        $validator->validate($items);
    }

    /**
     * @test
     */
    public function validatorCallsItemValidatorForeEachItemInArrayObject()
    {
        $items = new \ArrayObject([1,2,3,'foo','bar']);

        $this->mockItemValidator->expects($this->exactly(count($items)))->method('validate');
        foreach ($items as $index => $value) {
            $this->mockItemValidator->expects($this->at($index))->method('validate')->with($value);
        }

        $validator = new ArrayOfValidator(['itemValidator' => $this->mockItemValidator]);
        $validator->validate($items);
    }

    /**
     * @test
     */
    public function validatorAcceptsItemsIfAllItemsValidateSuccessfully()
    {
        $items = [1,2,3];
        $validator = new ArrayOfValidator(['itemValidator' => $this->mockItemValidator]);
        $this->assertFalse($validator->validate($items)->hasErrors());
    }

    /**
     * @test
     */
    public function validatorReturnsErrorIfItemsDoNotValidate()
    {
        $items = [1,2,3];

        $mockErrorResult = new Result();
        $mockErrorResult->addError(new Error('Error stub'));

        $mockItemValidator = $this->createMock(ValidatorInterface::class);
        $mockItemValidator->expects($this->any())->method('validate')->will($this->returnValue($mockErrorResult));

        $validator = new ArrayOfValidator(['itemValidator' => $mockItemValidator]);
        $this->assertTrue($validator->validate($items)->hasErrors());
    }
}
