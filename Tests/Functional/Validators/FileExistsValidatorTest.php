<?php
namespace PackageFactory\AtomicFusion\PropTypes\Tests\Functional\Validators;

use Neos\Flow\Tests\FunctionalTestCase;
use PackageFactory\AtomicFusion\PropTypes\Validators\FileExistsValidator;

/**
 * Testcase for the flowQuery validator
 *
 */
class FileExistsValidatorTest extends \Neos\Flow\Tests\FunctionalTestCase
{
    /**
     * @test
     */
    public function validatorAcceptsNull()
    {
        $validator = new FileExistsValidator();
        $this->assertFalse($validator->validate(null)->hasErrors());
    }

    /**
     * @return array
     */
    public function fileExamples()
    {
        return [
            [__DIR__ . '/Fixtures/example.file', true],
            [__DIR__ . '/Fixtures/example.fileThatDoesNotExist', false],
            [__DIR__ . '/Fixtures', false]
        ];
    }

    /**
     * @test
     * @dataProvider fileExamples
     */
    public function validatorDetectsFile($value, $expectSucces)
    {
        $validator = new FileExistsValidator();

        $validationResult = $validator->validate($value);

        if ($expectSucces) {
            $this->assertFalse($validationResult->hasErrors());
        } else {
            $this->assertTrue($validationResult->hasErrors());
        }
    }
}
