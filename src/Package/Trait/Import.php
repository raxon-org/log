<?php
namespace Package\Raxon\Org\Log\Trait;

use Raxon\Org\App;

use Raxon\Org\Exception\FileWriteException;
use Raxon\Org\Exception\ObjectException;
use Raxon\Org\Module\Core;
use Raxon\Org\Module\File;

use Raxon\Org\Node\Model\Node;

use Exception;
trait Import {

    public function role_system(): void
    {
        $object = $this->object();
        $package = $object->request('package');
        if($package){
            $node = new Node($object);
            $node->role_system_create($package);
        }
    }

    /**
     * @throws ObjectException
     * @throws FileWriteException
     */
    public function log_handler(): void
    {
        $object = $this->object();
        $package = $object->request('package');
        if($package){
            $options = App::options($object);
            $class = 'System.Log.Handler';
            $options->url = $object->config('project.dir.vendor') .
                $package . '/Data/' .
                $class .
                $object->config('extension.json')
            ;
            $options->uuid = true;
            $node = new Node($object);
            $response = $node->import($class, $node->role_system(), $options);
            $node->stats($class, $response);
        }
    }

    /**
     * @throws ObjectException
     * @throws FileWriteException
     */
    public function log_processor(): void
    {
        $object = $this->object();
        $package = $object->request('package');
        if($package){
            $options = App::options($object);
            $class = 'System.Log.Processor';
            $options->url = $object->config('project.dir.vendor') .
                $package . '/Data/' .
                $class .
                $object->config('extension.json')
            ;
            $options->uuid = true;
            $node = new Node($object);
            $response = $node->import($class, $node->role_system(), $options);
            $node->stats($class, $response);
        }
    }

    public function log(): void
    {
        $object = $this->object();
        $package = $object->request('package');
        if($package){
            $options = App::options($object);
            $class = 'System.Log';
            $options->url = $object->config('project.dir.vendor') .
                $package . '/Data/' .
                $class .
                $object->config('extension.json')
            ;
            $node = new Node($object);
            $response = $node->import($class, $node->role_system(), $options);
            $node->stats($class, $response);
            $class = 'System.Config';
            $response = $node->record($class, $node->role_system(), []);
            if(
                $response &&
                is_array($response) &&
                array_key_exists('node', $response) &&
                property_exists($response['node'], 'uuid')
            ){
                $patch = (object) [
                    'uuid' => $response['node']->uuid,
                    'log' => '*',
                ];
                $response = $node->patch($class, $node->role_system(), $patch, []);
                if(
                    $response &&
                    is_array($response) &&
                    array_key_exists('node', $response) &&
                    property_exists($response['node'], 'uuid') &&
                    !empty($response['node']->uuid)
                ){
                    echo 'Config patched with log...' . PHP_EOL;
                }
            }
        }
    }
}