<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrganizationVolunteer extends Pivot
{
    protected $table = 'organization_volunteer';
}
