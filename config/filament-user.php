<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Panel access
    |--------------------------------------------------------------------------
    |
    | Rules used by User::canAccessPanel(). For anything more specific, register
    | a callback in a service provider: PanelAccess::using(fn ($user, $panel) => ...).
    |
    */

    'panel_access' => [
        // Panels users of this model can never enter.
        'denied_panels' => ['admin'],

        // Deactivated users (status = false) lose access, even with an open session.
        'require_active_status' => true,
    ],

];
