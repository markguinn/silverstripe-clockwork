<?php
SS_Log::add_writer(new Clockwork\Support\Silverstripe\ClockworkLogWriter(), SS_Log::INFO, '<=');