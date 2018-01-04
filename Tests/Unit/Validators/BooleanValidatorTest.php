<?php
namespace PackageFactory\AtomicFusion\PropTypes\Tests\Unit\Validators;

use Neos\Flow\Tests\Unit\Validation\Validator\AbstractValidatorTestcase;
use PackageFactory\AtomicFusion\PropTypes\Validators\BooleanValidator;

/**
 * Testcase for the boolean validator
 *
 */
class BooleanValidatorTest extends AbstractValidatorTestcase
{
    protected $validatorClassName = BooleanValidator::class;

    /**
     * Data provider with valid examples
     *
     * @return array
     */
    public function validExamples()
    {
        return [
            [true],
            [false],
            [null]
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
            [''],
            [123],
            ['foobar'],
            [[]],
            [[1,2,3]],
            [['foo' => 'foo', 'bar' => 1]]
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
