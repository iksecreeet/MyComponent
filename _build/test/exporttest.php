<?php
/**
 * Generated by PHPUnit_SkeletonGenerator on 2012-08-18 at 18:52:48.
 */
include 'c:\xampp\htdocs\addons\assets\mycomponents\mycomponent\core\components\mycomponent\model\mycomponent\export.class.php';


class ExportTest extends PHPUnit_Framework_TestCase
{
    /**
     * @outputBuffering disabled
     * @var $export Export

     */
    protected $export;
    protected $exportExposed;
    protected $object;
    /* @var $utHelpers utHelpers */
    protected $utHelpers;
    /* @var $bootstrap Bootstrap */
    protected $bootstrap;
    /* @var $modx modX */
    protected $modx;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.

     */
    public static function setUpBeforeClass() {
        require_once dirname(__FILE__) . '/build.config.php';
        require_once dirname(__FILE__) . '/uthelpers.class.php';
        require_once MODX_ASSETS_PATH . 'mycomponents/mycomponent/core/components/mycomponent/model/mycomponent/bootstrap.class.php';
        require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
        $modx = new modX();
        $bootstrap = new Bootstrap($modx);
        $bootstrap->init(dirname(__FILE__) . '/build.config.php');
        if ($bootstrap->props['category'] != 'UnitTest') {
            die('wrong config - NEVER run unit test on a real project!');
        }
        $bootstrap->createCategory();
        $bootstrap->createElements();
        $bootstrap = null;
        $modx = null;


    }

    public static function tearDownAfterClass() {
        require_once dirname(__FILE__) . '/build.config.php';
        require_once dirname(__FILE__) . '/uthelpers.class.php';
        require_once MODX_ASSETS_PATH . 'mycomponents/mycomponent/core/components/mycomponent/model/mycomponent/bootstrap.class.php';
        // require_once dirname(dirname(__FILE__)) . '/utilities/bootstrap.class.php';
        require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
        $modx = new modX();
        $bootstrap = new Bootstrap($modx);
        $bootstrap->init(dirname(__FILE__) . '/build.config.php');
        $utHelpers = new UtHelpers();
        $utHelpers->removeElements($modx, $bootstrap);
        $bootstrap = null;
        $modx = null;

    }
    protected function setUp()
    {
        require_once dirname(__FILE__) . '/build.config.php';

        $modx = new modX();
        $modx->initialize('mgr');
        $this->utHelpers = new UtHelpers();
        $this->bootstrap = new Bootstrap($modx);
        $this->bootstrap->init(dirname(__FILE__) . '/build.config.php');
        $this->bootstrap->createCategory();
        require_once MODX_ASSETS_PATH . 'mycomponents/mycomponent/core/components/mycomponent/model/mycomponent/export.class.php';

        $this->export = new Export($modx);
        $this->modx =& $this->export->modx;
        /* @var $categoryObj modCategory */
        $this->export->init(dirname(__FILE__) . '/build.config.php');
        if ($this->export->props['category'] != 'UnitTest') {
            die('wrong config');
        }

        $this->utHelpers->rrmdir($this->bootstrap->targetBase);

        $modx->setLogLevel(modX::LOG_LEVEL_INFO);
        $modx->setLogTarget('ECHO');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        /* comment out this next line to leave the objects in the
         * directory for inspection */
        $this->utHelpers->rrmdir($this->bootstrap->targetBase);

        $this->export->modx = null;
        $this->modx = null;
        $this->bootstrap = null;
    }

    /**
     * @covers Export::init
     */


    public function testInit()
    {
        $this->modx->log(MODX::LOG_LEVEL_INFO, 'Component: ' . $this->export->props['packageName']);
        $this->modx->log(MODX::LOG_LEVEL_INFO, 'Source: ' . $this->export->props['source']);
        $this->modx->log(MODX::LOG_LEVEL_INFO, 'Target Base: ' . PHPUnit_Framework_Assert::readAttribute($this->export, 'targetBase'));
        $this->modx->log(MODX::LOG_LEVEL_INFO, 'Target Core: ' . PHPUnit_Framework_Assert::readAttribute($this->export, 'targetCore'));
        $this->modx->log(MODX::LOG_LEVEL_INFO, 'Target Assets: ' . PHPUnit_Framework_Assert::readAttribute($this->export, 'transportPath'));
        $this->assertNotEmpty($this->export->props);
        $this->assertNotEmpty($this->export->props['source']);
        $this->assertTrue(method_exists($this->export->helpers, 'replaceTags'));
        $this->assertNotEmpty(PHPUnit_Framework_Assert::readAttribute($this->export, 'packageName'));
        $this->assertNotEmpty(PHPUnit_Framework_Assert::readAttribute($this->export, 'packageNameLower'));
        $this->assertNotEmpty(PHPUnit_Framework_Assert::readAttribute($this->export, 'targetBase'));
        $this->assertNotEmpty(PHPUnit_Framework_Assert::readAttribute($this->export, 'targetCore'));
        $this->assertNotEmpty(PHPUnit_Framework_Assert::readAttribute($this->export, 'dirPermission'));
        $this->assertNotEmpty(PHPUnit_Framework_Assert::readAttribute($this->export, 'category'));
        $this->assertNotEmpty(PHPUnit_Framework_Assert::readAttribute($this->export, 'categoryId'));
        $this->assertNotEmpty(PHPUnit_Framework_Assert::readAttribute($this->export, 'resourcePath'));
        $this->assertNotEmpty(PHPUnit_Framework_Assert::readAttribute($this->export, 'elementPath'));
        $this->assertNotEmpty(PHPUnit_Framework_Assert::readAttribute($this->export, 'transportPath'));

        $this->assertInstanceOf('modCategory', PHPUnit_Framework_Assert::readAttribute($this->export, 'categoryObj'));
        $v = PHPUnit_Framework_Assert::readAttribute($this->export, 'createObjectFiles');
        $this->assertTrue($v === true || $v === false || $v === '1' || $v === '0' || $v === 1 || $v === 0);
        $v = PHPUnit_Framework_Assert::readAttribute($this->export, 'createTransportFiles');
        $this->assertTrue($v === true || $v === false || $v === '1' || $v === '0' || $v === 1 || $v === 0);
    }

    public function testProcessResources() {
        $this->bootstrap->createResources();
        $this->export->process('resources');
        $resources = $this->bootstrap->props['resources'];
        $this->assertNotEmpty($resources);
        $fileName = $this->bootstrap->targetBase . '_build/data/transport.resources.php';
        $this->assertFileExists($fileName);
        $this->assertNotEmpty(file_get_contents($fileName));
        $this->assertNotEmpty($resources);
        $resources = explode(',', $resources);
        foreach($resources as $resource) {
            $this->assertNotEmpty($resource);
            $fileName = $this->bootstrap->targetBase . '_build/data/resources/' . strtolower($resource) . '.content.html';
            $this->assertFileExists($fileName);
            $content = file_get_contents($fileName);
            $this->assertNotEmpty($content);
            $this->assertNotEmpty(strstr($content, 'Content goes here'));
        }
    }
    public function testProcessPropertySets() {
        $this->bootstrap->createPropertySets();
        $this->utHelpers->createPropertysetProperties($this->modx, $this->bootstrap);
        $this->export->process('propertySets');
        $fileName = $this->bootstrap->targetBase . '_build/data/transport.propertysets.php';
        $this->assertFileExists($fileName);
        $this->assertNotEmpty(file_get_contents($fileName));
        $modx =& $this->modx;
        $objects = include $fileName;
        $this->assertEquals(2, count($objects));

        foreach($objects as $object) {
            /* @var $object modPropertySet */
            $properties = $object->getProperties();
            $this->assertEquals(4, count($properties));
        }

        $sets = $this->bootstrap->props['propertySets'];
        $this->assertNotEmpty($sets);
        $sets = explode(',', $sets);
        $this->assertNotEmpty($sets);
        foreach($sets as $setName) {
            $setName = strtolower($setName);
            $fileName = $this->bootstrap->targetBase . '_build/data/properties/properties.' . $setName . '.propertyset.php';
            $this->assertFileExists($fileName);
            $this->assertNotEmpty(file_get_contents($fileName));


        }



    }
    /**
     * @covers Export::process
     * @todo   Implement testProcess()
     * @dataProvider testProcessProvider()
     */
    public function testProcessElements($element)
    {
        /* @var $utHelpers utHelpers */
        $this->utHelpers->createProperties($this->modx, $this->bootstrap);
        $data = explode(':', $element);
        $toProcess = $data[0];

        $name = substr($data[0], 0, -1);
        $name = $name == 'templateVar'? 'tv' : $name;
        $type = $data[1];
        $this->export->process($toProcess);

        $elements = $this->bootstrap->props['elements'][$type];
        $elements = explode(',', $elements);
        foreach ($elements as $elementName) {
            $this->assertNotEmpty($elementName);
            $baseDir = $this->bootstrap->targetBase . '_build/';
            $transportDir = $baseDir . 'data/';
            $propertiesDir = $baseDir . 'properties/';

            /* @var $elementObj modElement */
            $alias = $this->utHelpers->getNameAlias($type);
            $elementObj = $this->modx->getObject($type, array($alias => $elementName));
            $this->assertInstanceOf($type, $elementObj);
            $properties = $elementObj->getProperties();
            $this->assertNotEmpty($properties);
            $fileName = $toProcess == 'templateVars'? 'tvs.php' : strtolower($toProcess) . '.php';
            $transportFileName = $transportDir . 'transport.' . $fileName;
            $this->assertFileExists($transportFileName);
            $content = file_get_contents($transportFileName);
            $this->assertNotEmpty($content);

            $this->assertTrue(strstr($content, 'setProperties') !== false);
            $modx =& $this->modx;
            $objects = include $transportFileName;
            foreach ($objects as $object) {
                /* @var $object modElement */
                $props = $object->getProperties();
                $this->assertEquals(4, count($props));
            }
            $fileName = strtolower($elementName) . '.' . $name . '.php';
            $this->assertFileExists($transportDir . 'properties/properties.' . $fileName);
            $this->assertNotEmpty(file_get_contents($transportDir . 'properties/properties.' . $fileName), 'FILENAME: ' . $fileName);
            $props = include $transportDir . 'properties/properties.' . $fileName;
            $this->assertEquals(4, count($props));
        }
    }

    protected static $myData =
        array(
            array('chunks:modChunk'),
            array('snippets:modSnippet'),
            array('templates:modTemplate'),
            array('plugins:modPlugin'),
            array('templateVars:modTemplateVar'),
        );

    public static function testProcessProvider()
    {
        return self::$myData;

    }

    public function testProcessSystemSettings() {
        // Remove the following lines when you implement this test.
        //$this->utHelpers->createNewSystemSettings($this->modx, $this->bootstrap);
        $this->bootstrap->createNewSystemSettings();
        $configSettings = count($this->bootstrap->props['newSystemSettings']);
        $settings = $this->modx->getCollection('modSystemSetting', array('namespace' => $this->bootstrap->props['category']));
        $this->assertEquals($configSettings, count($settings));
        $this->export->process('systemSettings');
        $fileName = $this->bootstrap->targetBase . '_build/data/transport.settings.php';
        $this->assertFileExists($fileName);
        $content = file_get_contents($fileName);
        $this->assertNotEmpty($content);
        $this->assertEmpty(strstr($content, '{{+'));
        $modx =& $this->modx;
        $objects = include $fileName;
        $this->assertEquals($configSettings, count($objects));
        $this->utHelpers->removeSystemSettings($this->modx, $this->bootstrap);
    }

}