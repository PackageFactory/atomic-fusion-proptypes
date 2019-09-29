<?php
namespace PackageFactory\AtomicFusion\PropTypes\Tests\Unit\Validators;

use Neos\Flow\Tests\Unit\Validation\Validator\AbstractValidatorTestcase;
use PackageFactory\AtomicFusion\PropTypes\Validators\ShapeValidator;
use Neos\Flow\Validation\Validator\ValidatorInterface;
use Neos\Error\Messages\Result;
use Neos\Error\Messages\Error;

/**
 * Testcase for the shape validator
 *
 */
class ShapeValidatorTest extends AbstractValidatorTestcase
{

    /**
     * @var ValidatorInterface
     */
    protected $mockItemValidator;


    protected function setUp(): void
    {
        $mockSuccessResult = $this->createMock(Result::class);
        $mockSuccessResult->expects($this->any())->method('hasErrors')->will($this->returnValue(false));

        $this->mockItemValidator = $this->createMock(ValidatorInterface::class);
        $this->mockItemValidator
            ->expects($this->any())
            ->method('validate')
            ->will($this->returnValue($mockSuccessResult));

        $this->validator = new ShapeValidator(['shape' => [
            'foo' => $this->mockItemValidator,
            'bar' => $this->mockItemValidator
        ]]);
    }

    /**
     * @test
     */
    public function validatorAcceptsNull()
    {
        $this->assertFalse($this->validator->validate(null)->hasErrors());
    }

    /**
     * @test
     */
    public function validatorAcceptsEmptyArray()
    {
        $this->assertFalse($this->validator->validate([])->hasErrors());
    }

    /**
     * @test
     */
    public function validatorAcceptsEmptyArrayObject()
    {
        $arrayObject = new \ArrayObject();
        $this->assertFalse($this->validator->validate($arrayObject)->hasErrors());
    }

    /**
     * @test
     */
    public function validatorCallsItemValidatorForEachKeyOfShape()
    {
        $shape = ['foo' => 123, 'bar' => 'string'];

        $this->mockItemValidator->expects($this->exactly(2))->method('validate');
        $this->mockItemValidator->expects($this->at(0))->method('validate')->with(123);
        $this->mockItemValidator->expects($this->at(1))->method('validate')->with('string');

        $this->validator->validate($shape);
    }

    /**
     * @test
     */
    public function validatorCallsItemValidatorForEachKeyOfShapeOnArrayObjects()
    {
        $shape = new \ArrayObject(['foo' => 123, 'bar' => 'string']);

        $this->mockItemValidator->expects($this->exactly(2))->method('validate');
        $this->mockItemValidator->expects($this->at(0))->method('validate')->with(123);
        $this->mockItemValidator->expects($this->at(1))->method('validate')->with('string');

        $this->validator->validate($shape);
    }


    /**
     * @test
     */
    public function validatorCallsItemValidatorForEachKeyOfShapeOnStdClassObjects()
    {
        $shape = new \stdClass();
        $shape->foo = 123;
        $shape->bar = 'string';

        $this->mockItemValidator->expects($this->exactly(2))->method('validate');
        $this->mockItemValidator->expects($this->at(0))->method('validate')->with(123);
        $this->mockItemValidator->expects($this->at(1))->method('validate')->with('string');

        $this->validator->validate($shape);
    }

    /**
     * @test
     */
    public function validatorCallsItemValidatorForEachKeyOfShapeOfClassObjects()
    {
        $shape = new class() {
            public function getFoo()
            {
                return 123;
            }
            public function getBar()
            {
                return 'string';
            }
        };

        $this->mockItemValidator->expects($this->exactly(2))->method('validate');
        $this->mockItemValidator->expects($this->at(0))->method('validate')->with(123);
        $this->mockItemValidator->expects($this->at(1))->method('validate')->with('string');

        $this->validator->validate($shape);
    }

    /**
     * @test
     */
    public function validatorReturnsErrorIfItemsDoNotValidate()
    {
        $shape = ['foo' => 123, 'bar' => 'string'];

        $mockErrorResult = new Result();
        $mockErrorResult->addError(new Error('Error stub'));

        $mockItemValidator = $this->createMock(ValidatorInterface::class);
        $mockItemValidator->expects($this->any())->method('validate')->will($this->returnValue($mockErrorResult));

        $validator = new ShapeValidator(['shape' => [
            'foo' => $mockItemValidator,
            'bar' => $mockItemValidator
        ]]);

        $this->assertTrue($validator->validate($shape)->hasErrors());
    }
}
