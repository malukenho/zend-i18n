<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\I18n\View\Helper;

use PHPUnit\Framework\TestCase;
use Zend\I18n\View\Helper\Plural as PluralHelper;

/**
 * @group      Zend_View
 * @group      Zend_View_Helper
 */
class PluralTest extends TestCase
{
    /**
     * @var PluralHelper
     */
    public $helper;

    /**
     * Sets up the fixture
     *
     * @return void
     */
    public function setUp()
    {
        if (! extension_loaded('intl')) {
            $this->markTestSkipped('ext/intl not enabled');
        }

        $this->helper = new PluralHelper();
    }

    /**
     * @return array
     */
    public function pluralsTestProvider()
    {
        return [
            ['nplurals=1; plural=0', 'かさ', 0, 'かさ'],
            ['nplurals=1; plural=0', 'かさ', 10, 'かさ'],

            ['nplurals=2; plural=(n==1 ? 0 : 1)', ['umbrella', 'umbrellas'], 0, 'umbrellas'],
            ['nplurals=2; plural=(n==1 ? 0 : 1)', ['umbrella', 'umbrellas'], 1, 'umbrella'],
            ['nplurals=2; plural=(n==1 ? 0 : 1)', ['umbrella', 'umbrellas'], 2, 'umbrellas'],

            ['nplurals=2; plural=(n==0 || n==1 ? 0 : 1)', ['parapluie', 'parapluies'], 0, 'parapluie'],
            ['nplurals=2; plural=(n==0 || n==1 ? 0 : 1)', ['parapluie', 'parapluies'], 1, 'parapluie'],
            ['nplurals=2; plural=(n==0 || n==1 ? 0 : 1)', ['parapluie', 'parapluies'], 2, 'parapluies'],
        ];
    }

    /**
     * @dataProvider pluralsTestProvider
     */
    public function testGetCorrectPlurals($pluralRule, $strings, $number, $expected)
    {
        $this->helper->setPluralRule($pluralRule);
        $result = $this->helper->__invoke($strings, $number);
        $this->assertEquals($expected, $result);
    }
}
