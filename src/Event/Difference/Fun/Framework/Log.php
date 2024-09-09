<?php

namespace Event\Raxon\Org\Framework;

use Raxon\Org\App;
use Raxon\Org\Config;

use Raxon\Org\Module\File;
use Raxon\Org\Module\Parse;

use Exception;

class Log {

    /**
     * @throws Exception
     */
    public static function archive(App $object, $event, $options=[]): void
    {
        if($object->config(Config::POSIX_ID) !== 0){
            return;
        }
        $action = $event->get('action');
        if(array_key_exists('destination', $options)){
            $destination = $options['destination'];
            $destination = str_replace(
                [
                    '"{',
                    '}"'
                ],
                [
                    '{',
                    '}'
                ],
                $destination
            );
            $parse = new Parse($object);
            $parse->limit([
                'function' => [
                    'date'
                ]
            ]);
            $parse->limit([
                'function' => [
                    'date'
                ]
            ]);
            $destination = $parse->compile($destination, [], $object);
            $options['destination'] = $destination;
            if(File::Exist($destination)){
                \Event\Raxon\Org\Framework\Email::queue(
                    $object,
                    $action,
                    $options
                );
            }
        }
    }
}