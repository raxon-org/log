<?php

namespace Event\Raxon\Framework;

use Raxon\App;
use Raxon\Config;

use Raxon\Module\File;
use Raxon\Module\Parse;

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
                \Event\Raxon\Framework\Email::queue(
                    $object,
                    $action,
                    $options
                );
            }
        }
    }
}