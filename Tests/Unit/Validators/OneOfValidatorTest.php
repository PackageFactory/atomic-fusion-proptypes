<?php
namespace PackageFactory\AtomicFusion\PropTypes\Tests\Unit\Validators;

use Neos\Flow\Tests\Unit\Validation\Validator\AbstractValidatorTestcase;
use PackageFactory\AtomicFusion\PropTypes\Validators\OneOfValidator;

/**
 * Testcase for the boolean validator
 *
 */
class OneOfValidatorTest extends AbstractValidatorTestcase
{
    protected $validatorClassName = OneOfValidator::class;

    /**
     * Data provider with valid floats
     *
     * @return array
     */
    public function validExamples()
    {
        return [
            [1, [1,2,3]],
            ['foo', ['foo','bar']],
            ['foo', ['foo',1,true]],
            [1, ['foo',1,true]],
            [true, ['foo',1,true]],
        ];
    }

    /**
     * @test
     * @dataProvider validExamples
     */
    public function validatorReturnsNoErrorsForValidExamples($value, $list)
    {
        $validator = new OneOfValidator(['values' => $list]);
        $this->assertFalse($validator->validate($value)->hasErrors());
    }

    /**
     * Data provider with invalid examples
     *
     * @return array
     */
    public function invalidExamples()
    {
        return [
            [4, [1,2,3]],
            ['baz', ['foo','bar']],
            ['bar', ['foo',1,true]],
            [5, ['foo',1,true]],
            [false, ['foo',1,true]]
        ];
    }

    /**
     * @test
     * @dataProvider invalidExamples
     */
    public function validatorReturnsErrorsForInvalidExamples($value, $list)
    {
        $validator = new OneOfValidator(['values' => $list]);
        $this->assertTrue($validator->validate($value)->hasErrors());
    }
}
