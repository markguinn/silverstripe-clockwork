<?php
/**
 * Initializes Clockwork at the beginning of a request and
 * finalizes it at the end, adding the correct headers to
 * the response.
 *
 * @author Mark Guinn <mark@adaircreative.com>
 * @date 11.07.2014
 * @package clockwork
 */
namespace Clockwork\Support\Silverstripe;

use Clockwork\Clockwork;
use Clockwork\DataSource\PhpDataSource;
use Clockwork\Storage\FileStorage;
use DataModel;
use Session;
use SS_HTTPRequest;
use SS_HTTPResponse;
use Director;
use DB;

class RequestFilter implements \RequestFilter
{
    protected $clockwork;

    /**
     * Filter executed before a request processes
     *
     * @param SS_HTTPRequest $request Request container object
     * @param Session $session        Request session
     * @param DataModel $model        Current DataModel
     * @return boolean Whether to continue processing other filters. Null or true will continue processing (optional)
     */
    public function preRequest(SS_HTTPRequest $request, Session $session, DataModel $model) {
        if (Director::isDev()) {
            $this->clockwork = new Clockwork();

            // Wrap the current database adapter in a proxy object so we can log queries
            DB::setConn(new DatabaseProxy(DB::getConn()));
            $this->clockwork->addDataSource(new SilverstripeDataSource());

            // Attach a default datasource that comes with
            // the Clockwork library (grabs session info, etc)
            $this->clockwork->addDataSource(new PhpDataSource());

            // Give it a place to store data
            $this->clockwork->setStorage(new FileStorage(TEMP_FOLDER . '/clockwork'));
        }
    }


    /**
     * Filter executed AFTER a request
     *
     * @param SS_HTTPRequest $request   Request container object
     * @param SS_HTTPResponse $response Response output object
     * @param DataModel $model          Current DataModel
     * @return boolean Whether to continue processing other filters. Null or true will continue processing (optional)
     */
    public function postRequest(SS_HTTPRequest $request, SS_HTTPResponse $response, DataModel $model) {
        if (Director::isDev()) {
            $response->addHeader("X-Clockwork-Id", $this->clockwork->getRequest()->id);
            $response->addHeader("X-Clockwork-Version", Clockwork::VERSION);
            $this->clockwork->resolveRequest();
            $this->clockwork->storeRequest();
        }
    }
}
