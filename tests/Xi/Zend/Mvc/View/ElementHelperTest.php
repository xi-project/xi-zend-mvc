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
        $this->assertEquals('<br />', $this->element->element('br'));
    }

    /**
     * @test
     */
    public function falseContentCreatesASelfClosingTag()
    {
        $this->assertEquals('<br />', $this->element->element('br', false));
    }

    /**
     * @test
     */
    public function nullContentCreatesASelfClosingTag()
    {
        $this->assertEquals('<br />', $this->element->element('br', null));
    }

    /**
     * @test
     */
    public function emptyStringContentCreatesAContainerTag()
    {
        $this->assertEquals('<p></p>', $this->element->element('p', ''));
    }

    /**
     * @test
     */
    public function numericContentCreatesAContainerTag()
    {
        $this->assertEquals('<p>0</p>', $this->element->element('p', 0));
        $this->assertEquals('<p>1.2</p>', $this->element->element('p', 1.2));
    }

    /**
     * @test
     */
    public function stringContentCreatesAContainerTag()
    {
        $this->assertEquals(
            '<span>foo bar</span>',
            $this->element->element('span', 'foo bar')
        );
    }

    /**
     * @test
     */
    public function emptyAttributesDoesNotCreateElementAttributes()
    {
        $this->assertEquals(
            '<span></span>',
            $this->element->element(
                'span',
                '',
                array(
                    'class' => '',
                    'id' => null,
                    'title' => false
                )
            )
        );
    }

    /**
     * @test
     */
    public function attributesWithContentCreatesElementAttributes()
    {
        $this->assertEquals(
            '<span class="bar" title="luss"></span>',
            $this->element->element(
                'span',
                '',
                array(
                    'class' => 'bar',
                    'title' => 'luss'
                )
            )
        );
    }

    /**
     * @test
     */
    public function anArrayOfAttributeIsConcatenated()
    {
        $this->assertEquals(
            '<p class="foo bar loso"></p>',
            $this->element->element(
                'p',
                '',
                array('class' => array('foo', 'bar', 'loso'))
            )
        );
    }
}
