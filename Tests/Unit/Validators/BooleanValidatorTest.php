<?php
namespace PackageFactory\AtomicFusion\PropTypes\Tests\Validators;

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
     * Data provider with valid floats
     *
     * @return array
     */
    public function exampleValues()
    {
        return [
            [TRUE, TRUE],
            [FALSE, TRUE],
            [null, TRUE],
            ['', FALSE],
            [123, FALSE],
            ['foobar', FALSE],
            [[], FALSE],
            [[1,2,3], FALSE],
            [['foo' => 'foo', 'bar' => 1], FALSE]
        ];
    }

    /**
     * @test
     * @dataProvider exampleValues
     */
    public function floatValidatorReturnsNoErrorsForValidValues($value, $expectToBeValid)
    {
        if ($expectToBeValid) {
            $this->assertFalse($this->validator->validate($value)->hasErrors());
        } else {
            $this->assertTrue($this->validator->validate($value)->hasErrors());
        }
    }
}
