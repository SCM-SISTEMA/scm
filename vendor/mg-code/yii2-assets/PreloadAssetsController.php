<?php

namespace mgcode\assets;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\Console;

/**
 * @link https://github.com/mg-code/yii2-assets
 * @author Maris Graudins <maris@mg-interactive.lv>
 */
class PreloadAssetsController extends Controller
{
    /**
     * @var string controller default action ID.
     */
    public $defaultAction = 'preload';

    /**
     * Asset bundles that should be preloaded
     * @var array
     */
    public $bundles = [];

    /**
     * @var array|\yii\web\AssetManager [[\yii\web\AssetManager]] instance or its array configuration, which will be used
     * for assets processing.
     */
    private $_assetManager = [];

    /**
     * Preload asset bundles according to the given configuration.
     * @param string $configFile configuration file name.
     */
    public function actionPreload($configFile)
    {
        $configFile = \Yii::getAlias($configFile);

        $this->loadConfiguration($configFile);
        $this->loadBundles($this->bundles);
    }

    /**
     * Returns the asset manager instance.
     * @throws \yii\console\Exception on invalid configuration.
     * @return \yii\web\AssetManager asset manager instance.
     */
    public function getAssetManager()
    {
        if (!is_object($this->_assetManager)) {
            $options = $this->_assetManager;
            if (!isset($options['class'])) {
                $options['class'] = 'yii\\web\\AssetManager';
            }
            if (!isset($options['basePath'])) {
                throw new Exception("Please specify 'basePath' for the 'assetManager' option.");
            }
            if (!isset($options['baseUrl'])) {
                throw new Exception("Please specify 'baseUrl' for the 'assetManager' option.");
            }

            if (!isset($options['forceCopy'])) {
                $options['forceCopy'] = true;
            }

            $this->_assetManager = Yii::createObject($options);
        }

        return $this->_assetManager;
    }

    /**
     * Sets asset manager instance or configuration.
     * @param \yii\web\AssetManager|array $assetManager asset manager instance or its array configuration.
     * @throws \yii\console\Exception on invalid argument type.
     */
    public function setAssetManager($assetManager)
    {
        if (is_scalar($assetManager)) {
            throw new Exception('"'.get_class($this).'::assetManager" should be either object or array - "'.gettype($assetManager).'" given.');
        }
        $this->_assetManager = $assetManager;
    }

    /**
     * Creates template of configuration file for [[actionPreload]].
     * @param string $configFile output file name.
     * @return int CLI exit code
     * @throws \yii\console\Exception on failure.
     */
    public function actionTemplate($configFile)
    {
        $configFile = \Yii::getAlias($configFile);

        $template = <<<EOD
<?php
/**
 * Configuration file for the "yii asset" console command.
 */

// In the console environment, some path aliases may not exist. Please define these:
// Yii::setAlias('@webroot', __DIR__ . '/../web');
// Yii::setAlias('@web', '/');

return [
    // The list of asset bundles to compress:
    'bundles' => [
        // 'app\assets\AppAsset',
        // 'yii\web\YiiAsset',
        // 'yii\web\JqueryAsset',
    ],
    // Asset manager configuration:
    'assetManager' => [
        //'basePath' => '@webroot/assets',
        //'baseUrl' => '@web/assets',
    ],
];
EOD;
        if (file_exists($configFile)) {
            if (!$this->confirm("File '{$configFile}' already exists. Do you wish to overwrite it?")) {
                return self::EXIT_CODE_NORMAL;
            }
        }
        if (!file_put_contents($configFile, $template)) {
            throw new Exception ("Unable to write template file '{$configFile}'.");
        } else {
            $this->stdout("Configuration file template created at '{$configFile}'.\n\n", Console::FG_GREEN);
            return self::EXIT_CODE_NORMAL;
        }
    }

    /**
     * Creates full list of source asset bundles.
     * @param string[] $bundles list of asset bundle names
     * @return \yii\web\AssetBundle[] list of source asset bundles.
     */
    protected function loadBundles($bundles)
    {
        $am = $this->getAssetManager();
        $result = [];
        foreach ($bundles as $name) {
            $this->stdout("Loading bundle '{$name}' with dependencies...\n");
            $result[$name] = $am->getBundle($name);
        }
        foreach ($result as $bundle) {
            $this->loadDependency($bundle, $result);
        }

        return $result;
    }

    /**
     * Loads asset bundle dependencies recursively.
     * @param \yii\web\AssetBundle $bundle bundle instance
     * @param array $result already loaded bundles list.
     * @throws Exception on failure.
     */
    protected function loadDependency($bundle, &$result)
    {
        $am = $this->getAssetManager();
        foreach ($bundle->depends as $name) {
            if (!isset($result[$name])) {
                $dependencyBundle = $am->getBundle($name);
                $result[$name] = false;
                $this->loadDependency($dependencyBundle, $result);
                $result[$name] = $dependencyBundle;
            } elseif ($result[$name] === false) {
                throw new Exception("A circular dependency is detected for bundle '{$name}': ".$this->composeCircularDependencyTrace($name, $result).'.');
            }
        }
    }

    /**
     * Applies configuration from the given file to self instance.
     * @param string $configFile configuration file name.
     * @throws \yii\console\Exception on failure.
     */
    protected function loadConfiguration($configFile)
    {
        $this->stdout("Loading configuration from '{$configFile}'...\n");
        foreach (require($configFile) as $name => $value) {
            if (property_exists($this, $name) || $this->canSetProperty($name)) {
                $this->$name = $value;
            } else {
                throw new Exception("Unknown configuration option: $name");
            }
        }

        $this->getAssetManager(); // check if asset manager configuration is correct
    }

    /**
     * Composes trace info for bundle circular dependency.
     * @param string $circularDependencyName name of the bundle, which have circular dependency
     * @param array $registered list of bundles registered while detecting circular dependency.
     * @return string bundle circular dependency trace string.
     */
    private function composeCircularDependencyTrace($circularDependencyName, array $registered)
    {
        $dependencyTrace = [];
        $startFound = false;
        foreach ($registered as $name => $value) {
            if ($name === $circularDependencyName) {
                $startFound = true;
            }
            if ($startFound && $value === false) {
                $dependencyTrace[] = $name;
            }
        }
        $dependencyTrace[] = $circularDependencyName;
        return implode(' -> ', $dependencyTrace);
    }
}