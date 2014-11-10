<?php
/**
 * This is the endpoint that serves json to the extension
 *
 * @author Mark Guinn <mark@adaircreative.com>
 * @date 11.07.2014
 * @package clockwork
 */

namespace Clockwork\Support\Silverstripe;
use Clockwork\Storage\FileStorage;
use Controller;
use SS_HTTPRequest;

class ClockworkController extends Controller
{
    private static $allowed_actions = array('retrieve');
    private static $url_handlers = array('$ID!' => 'retrieve');

    public function retrieve(SS_HTTPRequest $request) {
        $storage = new FileStorage(TEMP_FOLDER . '/clockwork');
        $data = $storage->retrieve($request->param('ID'));
        $response = $this->getResponse();
        $response->addHeader('Content-type', 'application/json');
        $response->setBody($data->toJson());
        return $response;
    }
}
