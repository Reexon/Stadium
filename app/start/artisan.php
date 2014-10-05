<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/

/**
 * Cron Job che aggiorna localmente gli stati delle spedizioni
 */
Artisan::add(new ShipmentsUpdateCommand);
