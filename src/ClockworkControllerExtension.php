<?php
/**
 * Hooks into any controller to provide some amount of timeline data.
 *
 * @author Mark Guinn <mark@adaircreative.com>
 * @date 11.07.2014
 * @package salveo
 * @subpackage clockwork
 */

namespace Clockwork\Support\Silverstripe;

use Extension;
use Injector;
use Director;

class ClockworkControllerExtension extends Extension
{
    public function onBeforeInit() {
        if (Director::isDev()) {
            Injector::inst()->get('ClockworkTimeline')->startEvent(
                get_class($this->owner) . '_init',
                get_class($this->owner) . ' initialization'
            );
        }
    }

    public function onAfterInit() {
        if (Director::isDev()) {
            $injector = Injector::inst();
            $injector->get('ClockworkTimeline')->endEvent(get_class($this->owner) . '_init');
            $injector->get('ClockworkTimeline')->startEvent(
                get_class($this->owner) . '_action',
                get_class($this->owner) . ' action ' . $this->owner->getRequest()->param('Action')
            );
        }
    }
}
