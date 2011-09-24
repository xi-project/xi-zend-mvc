<?php

namespace Xi\Zend\Mvc\View;

use PHPUnit_Framework_TestCase,
    Zend_View;

/**
 * @category   Xi
 * @package    Zend
 * @subpackage View
 * @author     Mikko Hirvonen <mikko.petteri.hirvonen@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */
class ElemenHelpertTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ElementHelper
     */
    private $element;

    public function setUp()
    {
        parent::setUp();

        $this->element = new ElementHelper();
        $this->element->setView(new Zend_View());
    }

    /**
     * @test
     */
    public function emptyContentCreatesASelfClosingTag()
    {
        $this->assertEquals('<br />', sprintf($this->element->element('br')));
    }

    /**
     * @test
     */
    public function falseContentCreatesASelfClosingTag()
    {
        $this->assertEquals(
            '<br />',
            sprintf($this->element->element('br', false))
        );
    }

    /**
     * @test
     */
    public function nullContentCreatesASelfClosingTag()
    {
        $this->assertEquals(
            '<br />',
            sprintf($this->element->element('br', null))
        );
    }

    /**
     * @test
     */
    public function emptyStringContentCreatesAContainerTag()
    {
        $this->assertEquals(
            '<p></p>',
            sprintf($this->element->element('p', ''))
        );
    }

    /**
     * @test
     */
    public function numericContentCreatesAContainerTag()
    {
        $this->assertEquals(
            '<p>0</p>',
            sprintf($this->element->element('p', 0))
        );

        $this->assertEquals(
            '<p>1.2</p>',
            sprintf($this->element->element('p', 1.2))
        );
    }

    /**
     * @test
     */
    public function stringContentCreatesAContainerTag()
    {
        $this->assertEquals(
            '<span>foo bar</span>',
            sprintf($this->element->element('span', 'foo bar'))
        );
    }

    /**
     * @test
     */
    public function emptyAttributesDoesNotCreateElementAttributes()
    {
        $this->assertEquals(
            '<span></span>',
            sprintf($this->element->element(
                'span',
                '',
                array(
                    'class' => '',
                    'id' => null,
                    'title' => false
                )
            ))
        );
    }

    /**
     * @test
     */
    public function attributesWithContentCreatesElementAttributes()
    {
        $this->assertEquals(
            '<span class="bar" title="luss"></span>',
            sprintf($this->element->element(
                'span',
                '',
                array(
                    'class' => 'bar',
                    'title' => 'luss'
                )
            ))
        );
    }

    /**
     * @test
     */
    public function anArrayOfAttributeIsConcatenated()
    {
        $this->assertEquals(
            '<p class="foo bar loso"></p>',
            sprintf($this->element->element(
                'p',
                '',
                array('class' => array('foo', 'bar', 'loso'))
            ))
        );
    }

    /**
     * @test
     */
    public function elementReturnsItself()
    {
        $this->assertSame($this->element, $this->element->element('p'));
    }

    /**
     * @test
     */
    public function contentCanBeSetAfterCreation()
    {
        $this->assertEquals(
            '<p></p>',
            (string) $this->element->element('p', '')
        );

        $this->element->setContent('xoo');

        $this->assertEquals(
            '<p>xoo</p>',
            (string) $this->element
        );
    }

    /**
     * @test
     */
    public function attributesCanBeSetAfterCreation()
    {
        $this->assertEquals(
            '<p class="foo"></p>',
            (string) $this->element->element('p', '', array('class' => 'foo'))
        );

        $this->element->setAttributes(array('class' => 'bar'));

        $this->assertEquals(
            '<p class="bar"></p>',
            (string) $this->element
        );
    }

    /**
     * @test
     */
    public function settersReturnSameObject()
    {
        $this->assertSame(
            $this->element,
            $this->element->element('p')->setContent('content')
        );

        $this->assertSame(
            $this->element,
            $this->element->setAttributes(array('rel' => 'nofollow'))
        );
    }
}
