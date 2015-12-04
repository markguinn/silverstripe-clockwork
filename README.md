SilverStripe Clockwork Integration
==================================

Integrates the wonderful Clockwork Chrome extension into Silverstripe. Out of
the box queries and controller events will be logged. You can also log your
own events on the timeline. 

* Clockwork: https://github.com/itsgoingd/clockwork
* Chrome Extension: https://github.com/itsgoingd/clockwork-chrome

NOTE: This extension is only active when your site is in dev mode. There should
be no slowdown in live mode because the database proxy adapter is not installed
and clockwork is never activated.

**NOTE:** This version requires SilverStripe 3.2. For 3.1 compatibility use v0.1.0


Usage
-----
Install the chrome extension. Install via composer. Basic timing and query 
logging work out of the box. To add your own events to the timeline use:

```
Injector::inst()->get('ClockworkTimeline')->startEvent('myevent1', 'Description of the event');

// ... do the things ... ///

// this will happen automatically when the request ends
Injector::inst()->get('ClockworkTimeline')->endEvent('myevent1');
```

You can also use SilverStripe's logging to output to Clockwork:

```php
SS_Log::log('Some error', Zend_Log::ERR);
```

Todo List
---------
- Integrate the embeddable web version for non-chrome-users: https://github.com/itsgoingd/clockwork-web


Developer(s)
------------
- Mark Guinn <mark@adaircreative.com>

Contributions welcome by pull request and/or bug report.
Please follow Silverstripe code standards.


License (MIT)
-------------
Copyright (c) 2014 Mark Guinn

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the
Software, and to permit persons to whom the Software is furnished to do so, subject
to the following conditions:

The above copyright notice and this permission notice shall be included in all copies
or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE
FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
DEALINGS IN THE SOFTWARE.
