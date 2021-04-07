<?php
namespace PackageFactory\AtomicFusion\PropTypes\Tests\Unit\Validators;

use Neos\Flow\Tests\Unit\Validation\Validator\AbstractValidatorTestcase;
use PackageFactory\AtomicFusion\PropTypes\Validators\BooleanValidator;
use PackageFactory\AtomicFusion\PropTypes\Validators\StringValidator;

/**
 * Testcase for the boolean validator
 *
 */
class StringValidatorTest extends AbstractValidatorTestcase
{
    protected $validatorClassName = StringValidator::class;

    /**
     * Data provider with valid examples
     *
     * @return array
     */
    public function validExamples()
    {

        return [
            [null],
            [""],
            ["hello world"],
            [new class() {
                public function __toString()
                {
                    return "hello world";
                }
            }]
        ];
    }

    /**
     * @test
     * @dataProvider validExamples
     */
    public function validatorReturnsNoErrorsForValidExamples($value)
    {
        $this->assertFalse($this->validator->validate($value)->hasErrors());
    }

    /**
     * Data provider with invalid examples
     *
     * @return array
     */
    public function invalidExamples()
    {
        return [
            [123],
            [false],
            [true],
            [[]],
            [[1,2,3]],
            [new class() {}]
        ];
    }

    /**
     * @test
     * @dataProvider invalidExamples
     */
    public function validatorReturnsErrorsForInValidExamples($value)
    {
        $this->assertTrue($this->validator->validate($value)->hasErrors());
    }
}
