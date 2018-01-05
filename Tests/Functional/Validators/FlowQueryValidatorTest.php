<?php
namespace PackageFactory\AtomicFusion\PropTypes\Tests\Functional\Validators;

use Neos\Flow\Tests\FunctionalTestCase;
use PackageFactory\AtomicFusion\PropTypes\Validators\FlowQueryValidator;

/**
 * Testcase for the flowQuery validator
 *
 */
class FlowQueryValidatorTest extends \Neos\Flow\Tests\FunctionalTestCase
{
    /**
     * @test
     */
    public function validatorAcceptsNull()
    {
        $validator = new FlowQueryValidator();
        $this->assertFalse($validator->validate(null)->hasErrors());
    }

    /**
     * @return array
     */
    public function simpleExamples()
    {
        return [
            [1, true],
            [-1, true],
            [true, true],
            ['string', true],
            [null, true],

            ['', false],
            [[], false],
            [0, false],
            [false, false]
        ];
    }

    /**
     * @test
     * @dataProvider simpleExamples
     */
    public function validatorRequiredNonEmptyContextOfNoConditionIsGiven($value, $expectSucces)
    {
        $validator = new FlowQueryValidator([
            'condition' => null
        ]);

        $validationResult = $validator->validate($value);

        if ($expectSucces) {
            $this->assertFalse($validationResult->hasErrors());
        } else {
            $this->assertTrue($validationResult->hasErrors());
        }
    }

    /**
     * @return array
     */
    public function phpObjectExamples()
    {
        return [
            [$this->createMock(\ArrayObject::class), true],
            [$this->createMock(\ArrayAccess::class), true],
            [new \stdClass(), false],
            [null, true],
            [1223, false],
            ['foo', false]
        ];
    }

    /**
     * @test
     * @dataProvider phpObjectExamples
     */
    public function validatorDetectsPhpClasses($value, $expectSucces)
    {
        $validator = new FlowQueryValidator([
            'condition' => '[instanceof \\ArrayAccess]'
        ]);

        $validationResult = $validator->validate($value);

        if ($expectSucces) {
            $this->assertFalse($validationResult->hasErrors());
        } else {
            $this->assertTrue($validationResult->hasErrors());
        }
    }
}
