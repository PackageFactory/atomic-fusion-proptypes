<?php
namespace PackageFactory\AtomicFusion\PropTypes\Tests\Functional\Validators;

use Neos\Flow\Tests\FunctionalTestCase;
use Neos\Flow\Validation\Validator\StringValidator;
use PackageFactory\AtomicFusion\PropTypes\Validators\IntegerValidator;
use PackageFactory\AtomicFusion\PropTypes\Validators\PropTypeValidator;
use Neos\Flow\Validation\Validator\ValidatorInterface;
use Neos\Error\Messages\Result;

/**
 * Testcase for the propType validator
 *
 */
class PropTypeValidatorTest extends FunctionalTestCase
{

    public function setUp()
    {
        $this->validator = new PropTypeValidator();
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
     * @return array
     */
    public function isReqiredExamples()
    {
        return [
            [1, true],
            [-1, true],
            [0, true],
            [true, true],
            [false, true],
            ['string', true],
            ['', false],
            [[], false],
            [null, false]
        ];
    }

    /**
     * @test
     * @dataProvider isReqiredExamples
     */
    public function validatorEnforcesIsReqired($value, $expectSucces)
    {
        $this->validator->getIsRequired();
        $validationResult = $this->validator->validate($value);

        if ($expectSucces) {
            $this->assertFalse($validationResult->hasErrors());
        } else {
            $this->assertTrue($validationResult->hasErrors());
        }
    }

    /**
     * @return array
     */
    public function stringExamples()
    {
        return [
            ['fooo', true],
            ['', true],
            [null, true],
            [true, false],
            [false, false],
            [123, false],
            [[], false]
        ];
    }

    /**
     * @test
     * @dataProvider stringExamples
     */
    public function validatorEnforcesString($value, $expectSucces)
    {
        $this->validator->getString();
        $validationResult = $this->validator->validate($value);

        if ($expectSucces) {
            $this->assertFalse($validationResult->hasErrors());
        } else {
            $this->assertTrue($validationResult->hasErrors());
        }
    }

    /**
     * @return array
     */
    public function integerExamples()
    {
        return [
            //valid
            [123, true],
            [0, true],
            [-123, true],
            [null, true],
            //invalid
            ['', false],
            [true, false],
            [false, false],
            [[], false]
        ];
    }

    /**
     * @test
     * @dataProvider integerExamples
     */
    public function validatorEnforcesInteger($value, $expectSucces)
    {
        $this->validator->getInteger();
        $validationResult = $this->validator->validate($value);

        if ($expectSucces) {
            $this->assertFalse($validationResult->hasErrors());
        } else {
            $this->assertTrue($validationResult->hasErrors());
        }
    }

    /**
     * @return array
     */
    public function floatExamples()
    {
        return [
            // valid
            [123, true],
            [0, true],
            [-123, true],
            [123.456, true],
            [0.456, true],
            [-123.4456, true],
            [null, true],
            // invalid
            ['', false],
            [true, false],
            [false, false],
            [[], false]
        ];
    }

    /**
     * @test
     * @dataProvider integerExamples
     */
    public function validatorEnforcesFloat($value, $expectSucces)
    {
        $this->validator->getFloat();
        $validationResult = $this->validator->validate($value);

        if ($expectSucces) {
            $this->assertFalse($validationResult->hasErrors());
        } else {
            $this->assertTrue($validationResult->hasErrors());
        }
    }

    /**
     * @return array
     */
    public function regexExamples()
    {
        return [
            // valid
            ['example', true],
            ['--- example ---', true],
            [null, true],
            ['', true],
            // invalid
            [true, false],
            [false, false],
            [123, false]
        ];
    }

    /**
     * @test
     * @dataProvider regexExamples
     */
    public function validatorEnforcesRegex($value, $expectSucces)
    {
        $this->validator->regex('/.*example.*/');
        $validationResult = $this->validator->validate($value);

        if ($expectSucces) {
            $this->assertFalse($validationResult->hasErrors());
        } else {
            $this->assertTrue($validationResult->hasErrors());
        }
    }

    /**
     * @return array
     */
    public function arrayOfExamples()
    {
        return [
            // valid
            [null, true],
            [[], true],
            [[1,2,3,4], true],
            // invalid arrays
            [[123, 'foo', 234], false],
            [['foo', 'bar'], false],
            // invalid types
            [true, false],
            [false, false],
            [123, false],
            ['', false]

        ];
    }

    /**
     * @test
     * @dataProvider arrayOfExamples
     */
    public function validatorEnforcesArrayOf($value, $expectSucces)
    {
        $this->validator->arrayOf(new IntegerValidator());
        $validationResult = $this->validator->validate($value);

        if ($expectSucces) {
            $this->assertFalse($validationResult->hasErrors());
        } else {
            $this->assertTrue($validationResult->hasErrors());
        }
    }

    /**
     * @return array
     */
    public function anyOfExamples()
    {
        return [
            // valid
            [null, true],
            [123, true],
            [-123, true],
            [0, true],
            ['', true],
            ['foo', true],
            // invalid
            [123.456, false],
            [true, false],
            [false, false],
            [[1,2,3,4], false],
            [[], false]
        ];
    }

    /**
     * @test
     * @dataProvider anyOfExamples
     */
    public function validatorEnforcesAnyOf($value, $expectSucces)
    {
        $this->validator->anyOf(
            new IntegerValidator(),
            new StringValidator()
        );

        $validationResult = $this->validator->validate($value);

        if ($expectSucces) {
            $this->assertFalse($validationResult->hasErrors());
        } else {
            $this->assertTrue($validationResult->hasErrors());
        }
    }

    /**
     * @return array
     */
    public function shapeExamples()
    {
        $arrayObjectShape = new \ArrayObject(['foo' => 123, 'bar' => 'string']);

        $stdClassShape = new \stdClass();
        $stdClassShape->foo = 123;
        $stdClassShape->bar = 'string';

        return [
            // valid
            [null, true],
            [[], true],
            [['foo' => 123, 'bar' => 'string'], true],
            [['foo' => null, 'bar' => null], true],
            [$arrayObjectShape, true],
            [$stdClassShape, true],

            // invalid type
            [true, false],
            [false, false]
        ];
    }

    /**
     * @test
     * @dataProvider shapeExamples
     */
    public function validatorEnforcesShape($value, $expectSucces)
    {
        $this->validator->shape([
            'foo' => new IntegerValidator(),
            'bar' => new StringValidator()
        ]);

        $validationResult = $this->validator->validate($value);

        if ($expectSucces) {
            $this->assertFalse($validationResult->hasErrors());
        } else {
            $this->assertTrue($validationResult->hasErrors());
        }
    }
}
