<?php
namespace PackageFactory\AtomicFusion\PropTypes\Tests\Functional\Validators;

use Neos\ContentRepository\Domain\Model\NodeType;
use Neos\Flow\Tests\FunctionalTestCase;
use PackageFactory\AtomicFusion\PropTypes\Validators\InstanceOfValidator;
use Neos\ContentRepository\Domain\Model\Node;

/**
 * Testcase for the flowQuery validator
 *
 */
class InstanceOfValidatorTest extends \Neos\Flow\Tests\FunctionalTestCase
{
    /**
     * @test
     */
    public function validatorAcceptsNull()
    {
        $validator = new InstanceOfValidator();
        $this->assertFalse($validator->validate(null)->hasErrors());
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
        $validator = new InstanceOfValidator([
            'type' => '\\ArrayAccess'
        ]);

        $validationResult = $validator->validate($value);

        if ($expectSucces) {
            $this->assertFalse($validationResult->hasErrors());
        } else {
            $this->assertTrue($validationResult->hasErrors());
        }
    }


    /**
     * @test
     */
    public function validatorAcceptsNodesIfTypeMatches()
    {
        /**
         * @var NodeType $mockNodeType
         */
        $mockNodeType = $this->createMock(NodeType::class);
        $mockNodeType->expects($this->once())->method('isOfType')->with('Vendor.Site:Node')->will($this->returnValue(true));

        /**
         * @var Node $mockNode
         */
        $mockNode = $this->createMock(Node::class);
        $mockNode->expects($this->any())->method('getNodeType')->will($this->returnValue($mockNodeType));

        $validator = new InstanceOfValidator(['type' => 'Vendor.Site:Node']);

        $validationResult = $validator->validate($mockNode);
        $this->assertFalse($validationResult->hasErrors());
    }

    /**
     * @test
     */
    public function validatorRejectsNodesIfTypeDoesNotMatch()
    {
        /**
         * @var NodeType $mockNodeType
         */
        $mockNodeType = $this->createMock(NodeType::class);
        $mockNodeType->expects($this->once())->method('isOfType')->with('Vendor.Site:Node')->will($this->returnValue(false));

        /**
         * @var Node $mockNode
         */
        $mockNode = $this->createMock(Node::class);
        $mockNode->expects($this->any())->method('getNodeType')->will($this->returnValue($mockNodeType));

        $validator = new InstanceOfValidator(['type' => 'Vendor.Site:Node']);

        $validationResult = $validator->validate($mockNode);
        $this->assertTrue($validationResult->hasErrors());
    }
}
